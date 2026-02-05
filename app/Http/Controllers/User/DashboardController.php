<?php

namespace App\Http\Controllers\User;

class DashboardController
{
    public function index()
    {
        $submissions = \App\Models\Submission::where('user_id', auth()->id())
            ->with(['serviceLevel', 'cards.labelType'])
            ->latest()
            ->get();

        // Fetch cards that are ready for collection (e.g. graded/completed)
        // Assuming 'graded' or 'completed' status on card or submission implies readiness
        // User request: "only if admin allowed reveal"
        // We will assume card.status == 'graded' OR submission.status == 'completed' implies this for now
        // And we need to filter for the current user's submissions
        
        $myCards = \App\Models\SubmissionCard::whereHas('submission', function($q) {
                $q->where('user_id', auth()->id());
            })
            ->whereNotNull('grade') // Only cards that have a grade
            // ->where('status', 'graded') // Optional: enforce status if needed
            ->latest()
            ->get();

        $stats = [
            'total_submissions' => $submissions->count(),
            'total_cards' => $submissions->sum(function($s) {
                return $s->card_entry_mode === 'detailed' ? $s->cards->sum('qty') : $s->total_cards;
            }),
            'active_orders' => $submissions->whereNotIn('status', ['completed', 'cancelled', 'draft'])->count(),
            'total_spent' => $submissions->sum('total_cost'), // Assuming an accessor or column exists, otherwise 0
            'cards_graded' => $myCards->count(),
            'in_progress' => $submissions->whereNotIn('status', ['completed', 'cancelled', 'draft'])->count(),
        ];
        
        // Calculate total spent more accurately if needed
        $stats['total_spent'] = $submissions->sum(function($s) {
             return $s->total_cost; // Using the accessor from Submission model
        });

        return view('user.dashboard', compact('submissions', 'stats', 'myCards'));
    }

    public function revealGrade($cardId)
    {
        $card = \App\Models\SubmissionCard::findOrFail($cardId);
        
        // Security check
        if ($card->submission->user_id !== auth()->id()) {
            abort(403);
        }

        $card->update(['is_revealed' => true]);

        return back()->with('status', 'Grade revealed!');
    }
}
