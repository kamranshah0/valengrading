<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactQueryController extends Controller
{
    public function index()
    {
        $queries = \App\Models\ContactQuery::latest()->paginate(10);
        return view('admin.contact-queries.index', compact('queries'));
    }

    public function show(\App\Models\ContactQuery $contactQuery)
    {
        $contactQuery->load('replies.user');
        
        if ($contactQuery->status === \App\Models\ContactQuery::STATUS_NEW) {
            $contactQuery->update(['status' => \App\Models\ContactQuery::STATUS_READ]);
        }
        return view('admin.contact-queries.show', compact('contactQuery'));
    }

    public function update(Request $request, \App\Models\ContactQuery $contactQuery)
    {
        $request->validate([
            'reply_message' => 'nullable|required_if:action,reply|string',
            'action' => 'required|in:reply,complete',
        ]);

        if ($request->action === 'reply') {
            // Save Reply to Database
            $contactQuery->replies()->create([
                'user_id' => auth()->id(),
                'message' => $request->reply_message,
            ]);

            // Send Reply Email
            try {
                \Mail::raw($request->reply_message, function ($message) use ($contactQuery) {
                    $message->to($contactQuery->email)
                        ->subject('[Ticket #' . $contactQuery->id . '] Re: ' . $contactQuery->subject);
                });
                
                $contactQuery->update(['status' => \App\Models\ContactQuery::STATUS_IN_PROGRESS]);
                return back()->with('success', 'Reply sent successfully and status updated to In Progress.');
            
            } catch (\Exception $e) {
                return back()->with('error', 'Reply saved, but failed to send email: ' . $e->getMessage());
            }
        }

        if ($request->action === 'complete') {
            $contactQuery->update(['status' => \App\Models\ContactQuery::STATUS_COMPLETE]);
            return back()->with('success', 'Query marked as complete.');
        }

        return back();
    }

    public function destroy(\App\Models\ContactQuery $contactQuery)
    {
        $contactQuery->delete();
        return redirect()->route('admin.contact-queries.index')->with('success', 'Contact query deleted successfully.');
    }
}
