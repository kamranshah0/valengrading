@extends('layouts.admin')

@section('title', 'View Query')

@section('content')
<div class="w-full space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-3xl font-bold text-white">Message Details</h1>
        <a href="{{ route('admin.contact-queries.index') }}" class="w-full md:w-auto text-center bg-white/10 text-white px-4 py-2 rounded-lg hover:bg-white/20 transition-colors flex items-center justify-center gap-2 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
    </div>

    <!-- Content Card -->
    <div class="bg-[#232528] border border-white/5 rounded-2xl overflow-hidden p-4 md:p-8 space-y-8">
        
        <!-- Meta Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-b border-white/5 pb-8">
            <div>
                <h3 class="text-xs uppercase text-gray-500 font-bold tracking-wider mb-1">Sender</h3>
                <p class="text-lg text-white font-medium">{{ $contactQuery->name ?: 'Guest' }}</p>
                <a href="mailto:{{ $contactQuery->email }}" class="text-red-400 hover:text-red-300 text-sm flex items-center gap-2 mt-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    {{ $contactQuery->email }}
                </a>
            </div>
            
            <div class="md:text-right">
                <h3 class="text-xs uppercase text-gray-500 font-bold tracking-wider mb-1">Received At</h3>
                <p class="text-white">{{ $contactQuery->created_at->format('F d, Y') }}</p>
                <p class="text-sm text-gray-400">{{ $contactQuery->created_at->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Subject & Message -->
        <div class="space-y-4">
            <div>
                <h3 class="text-xs uppercase text-gray-500 font-bold tracking-wider mb-2">Subject</h3>
                <p class="text-xl text-white font-medium">{{ $contactQuery->subject ?: 'No Subject' }}</p>
            </div>
            
            <div>
                <h3 class="text-xs uppercase text-gray-500 font-bold tracking-wider mb-3">Message</h3>
                <div class="bg-black/20 rounded-xl p-6 text-gray-300 text-lg leading-relaxed whitespace-pre-wrap border border-white/5">
{{ $contactQuery->message }}
                </div>
            </div>
        </div>


        <!-- Actions & Reply -->
        <div class="pt-8 border-t border-white/5 space-y-8">
            <div class="flex items-center justify-between">
                <h3 class="text-sm uppercase text-gray-500 font-bold tracking-wider">Status</h3>
                @switch($contactQuery->status)
                    @case(\App\Models\ContactQuery::STATUS_NEW)
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-md bg-red-500/20 text-red-500 border border-red-500/30">New</span>
                        @break
                    @case(\App\Models\ContactQuery::STATUS_READ)
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-md bg-gray-500/20 text-gray-400 border border-gray-500/30">Read</span>
                        @break
                    @case(\App\Models\ContactQuery::STATUS_IN_PROGRESS)
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-md bg-yellow-500/20 text-yellow-500 border border-yellow-500/30">In Progress</span>
                        @break
                    @case(\App\Models\ContactQuery::STATUS_COMPLETE)
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-md bg-emerald-500/20 text-emerald-500 border border-emerald-500/30">Complete</span>
                        @break
                @endswitch
            </div>

            <!-- Reply Form -->
            <div class="bg-black/20 rounded-xl p-6 border border-white/5">
                <h3 class="text-white font-bold text-lg mb-4">Reply to {{ $contactQuery->name }}</h3>
                <form action="{{ route('admin.contact-queries.update', $contactQuery) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <textarea name="reply_message" rows="6" class="w-full bg-[#15171A] text-white border border-white/10 rounded-lg p-4 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all placeholder-gray-600" placeholder="Type your reply here..." required></textarea>
                    </div>

                    <div class="flex items-center justify-between">
                        <input type="hidden" name="action" value="reply">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-6 py-2 rounded-lg font-bold transition-colors shadow-lg shadow-blue-900/40 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                            Send Reply
                        </button>
                    </div>
                </form>
            </div>

            <!-- Management Actions -->
            <div class="flex flex-col md:flex-row items-stretch md:items-center justify-end gap-3 pt-4 border-t border-white/5">
                @if($contactQuery->status !== \App\Models\ContactQuery::STATUS_COMPLETE)
                <form action="{{ route('admin.contact-queries.update', $contactQuery) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="action" value="complete">
                    <button type="submit" class="w-full md:w-auto bg-emerald-600/10 hover:bg-emerald-600/20 text-emerald-500 border border-emerald-600/20 px-6 py-2 rounded-lg font-bold transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Mark as Complete
                    </button>
                </form>
                @endif
                
                <form action="{{ route('admin.contact-queries.destroy', $contactQuery) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full md:w-auto bg-red-600/10 hover:bg-red-600/20 text-red-500 border border-red-600/20 px-6 py-2 rounded-lg font-bold transition-colors">
                        Delete Message
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
