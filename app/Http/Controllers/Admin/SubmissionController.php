<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $submissions = Submission::with(['user', 'serviceLevel', 'submissionType', 'cards', 'labelType'])
            ->where('status', '!=', 'draft')
            ->latest()
            ->get();

        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(Submission $submission)
    {
        $submission->load(['user', 'serviceLevel', 'submissionType', 'labelType', 'cards.labelType', 'shippingAddress']);
        
        $statuses = [
            'Submission Complete', 
            'Cards Logged', 
            'Awaiting Label Selection',
            'Label Selection Received',
            'Grading Complete', 
            'Label Created', 
            'Encapsulation Complete', 
            'Quality Control Complete', 
            'Cancelled'
        ];

        return view('admin.submissions.show', compact('submission', 'statuses'));
    }

    public function updateStatus(Request $request, Submission $submission)
    {
        $request->validate([
            'status' => 'required|in:Submission Complete,Cards Logged,Awaiting Label Selection,Label Selection Received,Grading Complete,Label Created,Encapsulation Complete,Quality Control Complete,Cancelled',
        ]);

        $sendEmailRequested = $request->input('send_email', '0') === '1';

        $oldStatus = $submission->status;
        $submission->update(['status' => $request->status]);

        if ($request->status === 'Awaiting Label Selection') {
            // Also update all cards
            $submission->cards()->update(['status' => 'Awaiting Label Selection']);
            
            // Notify User ONLY if they chose "Yes, Send Email" via the Modal OR if it's not present (default bypass behavior)
            // Wait, since we added the hidden input, sendEmailRequested will be false if they said No.
            // If they are on a different page that doesn't have the modal but forces an update, it defaults to '0'.
            if ($sendEmailRequested) {
                try {
                    $user = $submission->user;
                    $userEmail = $user->email ?? $submission->shippingAddress->email ?? null;
                    
                    if ($userEmail) {
                        \Illuminate\Support\Facades\Mail::to($userEmail)->send(new \App\Mail\LabelSelectionRequiredEmail($submission));
                    }
                    
                    if ($user) {
                        $user->notify(new \App\Notifications\LabelSelectionRequired($submission));
                    }

                    // Mark as sent
                    $submission->update(['label_selection_email_sent' => true]);

                } catch (\Exception $e) {
                    \Log::error('Failed to send label selection required email: ' . $e->getMessage());
                }
            }
        }

        return back()->with('success', 'Submission status updated successfully.');
    }

    public function editCard(\App\Models\SubmissionCard $card)
    {
        $card->load('submission');
        $statuses = [
            'Submission Complete', 
            'Cards Logged', 
            'Awaiting Label Selection',
            'Label Selection Received',
            'Grading Complete', 
            'Label Created', 
            'Encapsulation Complete', 
            'Quality Control Complete', 
            'Cancelled'
        ];
        return view('admin.submissions.cards.edit', compact('card', 'statuses'));
    }

    public function updateCard(Request $request, \App\Models\SubmissionCard $card)
    {
        // Make all fields nullable since this method handles both the full edit page and the quick status dropdown on the show page
        $request->validate([
            'status' => 'nullable|string',
            'grade' => 'nullable|string',
            'centering' => 'nullable|numeric|min:1|max:10',
            'corners' => 'nullable|numeric|min:1|max:10',
            'edges' => 'nullable|numeric|min:1|max:10',
            'surface' => 'nullable|numeric|min:1|max:10',
            'grading_insights' => 'nullable|string',
            'is_revealed' => 'nullable|boolean',
            'grading_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'back_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'admin_notes' => 'nullable|string',
        ]);

        $data = $request->only([
            'status', 'grade', 'centering', 'corners', 'edges', 'surface', 
            'grading_insights', 'admin_notes'
        ]);

        $data['is_revealed'] = $request->has('is_revealed');

        if ($request->hasFile('grading_image')) {
            $path = $request->file('grading_image')->store('grading_images', 'public');
            $data['grading_image'] = $path;
        }

        if ($request->hasFile('back_image')) {
            $path = $request->file('back_image')->store('grading_images', 'public');
            $data['back_image'] = $path;
        }

        // Ensure cert_number and qr_code_token exist
        if (!$card->cert_number) {
            do {
                $cert = rand(100000, 999999);
            } while (\App\Models\SubmissionCard::where('cert_number', $cert)->exists());
            $data['cert_number'] = $cert;
        }

        if (!$card->qr_code_token) {
            $data['qr_code_token'] = \Illuminate\Support\Str::random(32);
        }

        $card->update($data);

        // Check if all cards are awaiting label selection
        $submission = $card->submission;
        if ($submission) {
            $totalCards = $submission->cards()->count();
            $awaitingCards = $submission->cards()->where('status', 'Awaiting Label Selection')->count();

            if ($totalCards > 0 && $totalCards === $awaitingCards && $submission->status !== 'Awaiting Label Selection') {
                $submission->update(['status' => 'Awaiting Label Selection']);
                
                // Notify User
                try {
                    $user = $submission->user;
                    $userEmail = $user->email ?? $submission->shippingAddress->email ?? null;
                    
                    if ($userEmail) {
                        \Illuminate\Support\Facades\Mail::to($userEmail)->send(new \App\Mail\LabelSelectionRequiredEmail($submission));
                    }
                    
                    if ($user) {
                        $user->notify(new \App\Notifications\LabelSelectionRequired($submission));
                    }

                    // Mark as sent
                    $submission->update(['label_selection_email_sent' => true]);

                } catch (\Exception $e) {
                    \Log::error('Failed to send label selection required email: ' . $e->getMessage());
                }
            }
        }

        // If the request only had 'status' and maybe '_token'/'_method', it likely came from the dropdown on the show page.
        if (count($request->except(['_token', '_method', 'status'])) === 0 && $request->has('status')) {
            return back()->with('success', 'Card status updated to ' . $request->status);
        }

        return redirect()->route('admin.submissions.show', $card->submission_id)
            ->with('success', 'Card details updated successfully.');
    }

    public function storeCard(Request $request, Submission $submission)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'set_name' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:4',
            'card_number' => 'nullable|string|max:50',
            'lang' => 'nullable|string|max:50',
            'label_type_id' => 'nullable|exists:label_types,id',
        ]);

        // Enforcement for Easy Mode limit
        if ($submission->card_entry_mode === 'easy') {
            $currentCount = $submission->cards()->sum('qty');
            $remaining = $submission->total_cards - $currentCount;
            
            if ($request->qty > $remaining) {
                return back()->withErrors(['qty' => "Cannot add {$request->qty} cards. Only {$remaining} cards remaining for this submission."])->withInput();
            }
        }

        for ($i = 0; $i < $request->qty; $i++) {
            do {
                $cert = rand(100000, 999999);
            } while (\App\Models\SubmissionCard::where('cert_number', $cert)->exists());

            $submission->cards()->create([
                'qty' => 1,
                'title' => $request->title,
                'set_name' => $request->set_name,
                'year' => $request->year,
                'card_number' => $request->card_number,
                'lang' => $request->lang,
                'label_type_id' => $request->label_type_id ?? $submission->label_type_id,
                'status' => 'Cards Received',
                'cert_number' => $cert,
                'qr_code_token' => \Illuminate\Support\Str::random(32),
            ]);
        }

        return back()->with('success', 'Card(s) added successfully.');
    }

    public function destroy(Submission $submission)
    {
        $submission->delete();
        return redirect()->route('admin.submissions.index')->with('success', 'Submission deleted successfully.');
    }
}
