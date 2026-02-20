<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Submission;
use App\Models\SubmissionCard;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // fetch Logic
        $submissions = Submission::where('user_id', $user->id)
            ->where('status', '!=', 'draft') // Filter out drafts
            ->with(['serviceLevel', 'submissionType', 'labelType'])
            ->latest()
            ->get();

        // My Cards Query with Search, Filter, Sort
        $query = SubmissionCard::whereHas('submission', function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('status', '!=', 'draft');
        })
        ->where(function($q) {
            $q->whereNotNull('grade')
              ->orWhere('grade', '!=', '')
              ->orWhereIn('status', ['Label Creation', 'Slabbed', 'Quality Control', 'Completed', 'Shipped', 'Delivered']);
        });

        // 1. Search (Title, Set, Year)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('set_name', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%")
                  ->orWhere('cert_number', 'like', "%{$search}%");
            });
        }

        // 2. Filter by Grade
        if ($request->filled('grade_filter')) {
            $grade = $request->grade_filter;
            if ($grade === 'authentic') {
                $query->where('grade', 'Authentic');
            } elseif ($grade === '6_and_below') {
                // Assuming grades are numeric strings, we might need casting or regex if mixed.
                // Best effort numeric comparison if grade stores numbers.
                $query->where(function ($q) {
                    $q->where('grade', '<=', 6)
                      ->where('grade', '!=', 'Authentic')
                      ->where('grade', '!=', '');
                });
            } else {
                // 10, 9, 8, 7
                $query->where('grade', $grade);
            }
        }

        // 3. Sort
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'alphabetical':
                $query->orderBy('title', 'asc');
                break;
            case 'highest_grade':
                 // Cast to decimal for numeric sorting if possible, or string sort
                 // Ideally DB field should be sortable. '10' comes before '9' in string so desc works for 10 vs 9 generally
                 // But '10' comes before '2'. So we need natural sort or cast.
                 // For simplicity, raw orderBy cast? Or strict column type?
                 // Let's try simple string desc first, usually '10' > '9' works in string if length same? No. '10' < '9' string-wise? 
                 // '10' vs '9': 1 < 9, so 10 comes first in ASC. 
                 // In DESC: 9 > 1, so 9 comes first. Wait, '10' vs '9'. Character 1 vs 9. 9 is bigger.
                 // So '9' comes before '10' in DESC string sort? Yes. 
                 // FIX: use LENGTH desc, then value desc to handle 10 vs 9.
                $query->orderByRaw('LENGTH(grade) DESC, grade DESC'); 
                break;
            case 'lowest_grade':
                // For lowest: LENGTH asc, grade asc
                // '1' vs '10'. Length 1 vs 2. '1' first. Correct.
                // '9' vs '10'. Length 1 vs 2. '9' first. Correct.
                $query->orderByRaw('LENGTH(grade) ASC, grade ASC');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }

        // 4. Pagination (10 per page)
        // Append query params to pagination links
        $myCards = $query->paginate(10)->withQueryString();

        // Calculate Stats
        $totalSubmissions = $submissions->count();
        $cardsGraded = $myCards->count();
        $inProgress = $submissions->where('status', '!=', 'completed')->count(); // Assuming 'completed' is the final status
        
        // precise total spent calculation could be complex, for now sum shipping + service level cost manually or use a helper if available
        // The Submission model has getTotalCostAttribute but it might be heavy to loop all.
        // Let's use the attribute since we have the collection.
        $totalSpent = $submissions->sum(function ($submission) {
             return $submission->total_cost;
        });

        // Overview specific counts
        $cardsCompletedToday = $myCards->whereNotNull('grade')->where('updated_at', '>=', now()->subDay())->count(); // Example metric
        
        $latestAddress = \App\Models\ShippingAddress::where('user_id', $user->id)->latest()->first();

        return view('user.dashboard', compact(
            'user',
            'submissions',
            'myCards',
            'totalSubmissions',
            'cardsGraded',
            'inProgress',
            'totalSpent',
            'latestAddress'
        ));
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update phone in latest address or create new if not exists (simplified logic for now)
        // Ideally User model should have phone, but instructions say map to ShippingAddress number
        $address = \App\Models\ShippingAddress::where('user_id', $user->id)->latest()->first();
        if ($address) {
            $address->update(['number' => $request->phone]);
        }

        return back()->with('success', 'Personal information updated successfully.');
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'county' => 'nullable|string|max:255',
            'post_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        // Find the user's latest address or create a new one
        $address = \App\Models\ShippingAddress::where('user_id', auth()->id())->latest()->first();

        if ($address) {
            $address->update([
                'full_name' => $request->full_name,
                'number' => $request->phone,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'county' => $request->county,
                'post_code' => $request->post_code,
                'country' => $request->country,
                'email' => auth()->user()->email, // Keep email synced with user
            ]);
        } else {
             \App\Models\ShippingAddress::create([
                'user_id' => auth()->id(),
                'full_name' => $request->full_name,
                'number' => $request->phone,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'county' => $request->county,
                'post_code' => $request->post_code,
                'country' => $request->country,
                'email' => auth()->user()->email,
            ]);
        }

        return back()->with('success', 'Delivery address updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function revealGrade($cardId)
    {
        $card = \App\Models\SubmissionCard::findOrFail($cardId);
        
        // Explicitly load submission to ensure it's available
        $card->load('submission');

        if (!$card->submission) {
            return response()->json([
                'status' => 'error',
                'message' => 'Submission data missing for this card.'
            ], 500);
        }
        
        // Security check
        $submissionUserId = (int)$card->submission->user_id;
        $authUserId = (int)auth()->id();
        
        if ($submissionUserId !== $authUserId) {
             // Allow Admin to reveal for testing purposes (Optional, remove if strict)
             // if (auth()->user()->is_admin) return ...

            return response()->json([
                'status' => 'error',
                'message' => "Access Denied. Card Owner: $submissionUserId, You: $authUserId."
            ], 403);
        }

        // User requested NOT to persist the reveal state ("permanent show mat kro")
        // So we will just return the grade to be shown temporarily.
        // If you DO want to track it, uncomment the update line.
        // $card->update(['is_revealed' => true]);

        // Check if admin has allowed reveal
        if (!$card->is_revealed) {
            return response()->json([
                'status' => 'error',
                'message' => 'Grading results have not been released by the admin yet.'
            ]);
        }

        return response()->json([
            'grade' => $card->grade,
            'status' => 'success'
        ]);
    }
}
