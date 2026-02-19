@extends('layouts.admin')

@section('title', 'Contact Queries')

@section('content')
<div class="w-full space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Contact Queries</h1>
            <p class="text-gray-400 text-sm mt-1">Manage incoming contact form messages</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4 text-emerald-500">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mobile Card View -->
    <div class="md:hidden space-y-4 px-4 pb-4 md:pt-4 pt-1">
        @forelse($queries as $query)
            <div class="bg-[#232528] border border-white/5 rounded-xl p-4 space-y-3 shadow-lg {{ $query->is_read ? '' : 'border-l-4 border-l-red-500' }}">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="font-bold text-white text-base">{{ $query->name ?: 'Guest' }}</div>
                        <div class="text-xs text-gray-500 mt-0.5">{{ $query->email }}</div>
                    </div>
                    <span class="text-[10px] text-gray-500 font-mono">{{ $query->created_at->format('M d') }}</span>
                </div>

                <div class="text-sm text-gray-300 border-t border-white/5 pt-3">
                    <span class="block text-[10px] text-gray-500 uppercase tracking-wider mb-1">Subject</span>
                    {{ Str::limit($query->subject, 50) ?: 'No Subject' }}
                </div>
                
                <div class="flex items-center justify-end gap-2 border-t border-white/5 pt-3">
                     <a href="{{ route('admin.contact-queries.show', $query) }}" class="flex-1 text-center p-2 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 transition-all font-bold text-xs uppercase tracking-wider">
                        View Message
                    </a>
                    <form action="{{ route('admin.contact-queries.destroy', $query) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')" class="flex-shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 italic">No contact queries found.</div>
        @endforelse
    </div>

    <!-- Table -->
    <div class="hidden md:block bg-[#232528] border border-white/5 rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-black/40 text-gray-400 uppercase text-xs font-bold tracking-wider border-b border-white/5">
                    <tr>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Name</th>
                        <th class="px-6 py-4 text-left">Email</th>
                        <th class="px-6 py-4 text-left">Subject</th>
                        <th class="px-6 py-4 text-left">Date</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($queries as $query)
                        <tr class="hover:bg-white/[0.02] transition-colors {{ $query->is_read ? '' : 'bg-white/[0.03]' }}">
                            <td class="px-6 py-4 text-sm">
                                @switch($query->status)
                                    @case(\App\Models\ContactQuery::STATUS_NEW)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-md bg-red-500/20 text-red-500 border border-red-500/30 anim-pulse">New</span>
                                        @break
                                    @case(\App\Models\ContactQuery::STATUS_READ)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-md bg-gray-500/20 text-gray-400 border border-gray-500/30">Read</span>
                                        @break
                                    @case(\App\Models\ContactQuery::STATUS_IN_PROGRESS)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-md bg-yellow-500/20 text-yellow-500 border border-yellow-500/30">In Progress</span>
                                        @break
                                    @case(\App\Models\ContactQuery::STATUS_COMPLETE)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-md bg-emerald-500/20 text-emerald-500 border border-emerald-500/30">Complete</span>
                                        @break
                                    @default
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-md bg-gray-500/20 text-gray-400 border border-gray-500/30">Read</span>
                                @endswitch
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-white">{{ $query->name ?: '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $query->email }}</td>
                            <td class="px-6 py-4 text-sm text-white">{{Str::limit($query->subject, 30) ?: '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $query->created_at->format('M d, Y') }}</td>
                            
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.contact-queries.show', $query) }}" class="text-blue-400 hover:text-blue-300 transition-colors" title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.contact-queries.destroy', $query) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-gray-500">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-12 h-12 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <p class="font-medium">No contact queries found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $queries->links() }}
    </div>
</div>
@endsection
