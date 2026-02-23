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
        $cardsGraded = $myCards->total(); // total() gets the total count for pagination, count() only gets the current page's count
        $inProgress = $submissions->where('status', '!=', 'completed')->count(); // Assuming 'completed' is the final status
        
        $gradingReportsCount = \App\Models\SubmissionCard::whereHas('submission', function ($q) use ($user) {
            $q->where('user_id', $user->id)->where('status', '!=', 'draft');
        })
        ->whereNotNull('grade')
        ->where('grade', '!=', '')
        ->where('is_revealed', true)
        ->count();

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
            'gradingReportsCount',
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
    public function labelSelection(Submission $submission)
    {
        if ($submission->user_id !== auth()->id() || $submission->status !== 'Awaiting Label Selection') {
            return redirect()->route('user.dashboard')->with('error', 'Label selection is not available for this submission.');
        }

        $submission->load(['cards.labelType', 'serviceLevel']);
        $labelTypes = \App\Models\LabelType::where('is_active', true)->orderBy('order')->get();

        return view('user.submissions.labels', compact('submission', 'labelTypes'));
    }

    public function processLabelSelection(Request $request, Submission $submission)
    {
        if ($submission->user_id !== auth()->id() || $submission->status !== 'Awaiting Label Selection') {
            return redirect()->route('user.dashboard')->with('error', 'Label selection is not available for this submission.');
        }

        $request->validate([
            'cards' => 'required|array',
            'cards.*.label_type_id' => 'required|exists:label_types,id',
        ]);

        $totalExtraCost = 0;
        $lineItems = [];

        foreach ($submission->cards as $card) {
            $selectedLabelId = $request->cards[$card->id]['label_type_id'] ?? null;
            if ($selectedLabelId) {
                $labelType = \App\Models\LabelType::find($selectedLabelId);
                $extraCost = max(0, $labelType->price_adjustment); // Only charge positive adjustments

                if ($extraCost > 0) {
                    $totalExtraCost += $extraCost;
                    $lineItems[] = [
                        'price_data' => [
                            'currency' => 'gbp',
                            'product_data' => [
                                'name' => 'Premium Label Upgrade',
                                'description' => ($card->title ?? 'Card') . ' - Select Label: ' . $labelType->name,
                            ],
                            'unit_amount' => round($extraCost * 100),
                        ],
                        'quantity' => 1,
                    ];
                }
            }
        }

        // Store selections in session
        session(['label_selections_'.$submission->id => $request->cards]);

        if ($totalExtraCost > 0) {
            try {
                \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => route('user.submissions.labels_success') . '?session_id={CHECKOUT_SESSION_ID}&submission_id='.$submission->id,
                    'cancel_url' => route('user.submissions.labels', $submission->id),
                    'metadata' => [
                        'label_payment_submission_id' => $submission->id,
                    ],
                ]);

                return redirect($session->url);
            } catch (\Exception $e) {
                return back()->with('error', 'Error starting payment: ' . $e->getMessage());
            }
        }

        // Applied for free
        return $this->applyLabels($submission, $request->cards);
    }

    public function labelPaymentSuccess(Request $request)
    {
        $submissionId = $request->submission_id;
        if (!$submissionId) {
            return redirect()->route('user.dashboard');
        }

        $submission = Submission::findOrFail($submissionId);
        $selections = session('label_selections_'.$submission->id);

        if ($selections) {
            return $this->applyLabels($submission, $selections);
        }

        return redirect()->route('user.dashboard')->with('success', 'Labels processed.');
    }

    protected function applyLabels(Submission $submission, $selections)
    {
        foreach ($submission->cards as $card) {
            $selectedLabelId = $selections[$card->id]['label_type_id'] ?? null;
            if ($selectedLabelId) {
                $card->update([
                    'label_type_id' => $selectedLabelId,
                    'status' => 'Label Selection Received'
                ]);
            }
        }

        // Update submission status to proceed out of "Awaiting Label Selection"
        $submission->update(['status' => 'Label Selection Received']);
        session()->forget('label_selections_'.$submission->id);

        return redirect()->route('user.dashboard')->with('success', 'Your label selections have been saved! We will now proceed with encapsulating your cards.');
    }
}
