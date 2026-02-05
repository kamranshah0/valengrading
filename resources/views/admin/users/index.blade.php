@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="w-full space-y-6">
    <div class="bg-[#232528]/80 backdrop-blur-xl border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-4 md:p-6 border-b border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                Registered Users
            </h3>
            <div class="text-sm text-gray-400">
                Total Users: <span class="text-white font-bold">{{ $users->total() }}</span>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4 px-4 pb-4 pt-4">
            @forelse($users as $user)
                <div class="bg-[#232528] border border-white/5 rounded-xl p-4 space-y-3 shadow-lg">
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-500 to-[#A3050A] flex flex-shrink-0 items-center justify-center text-sm font-bold text-white shadow-lg shadow-red-900/20">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-white font-bold text-base">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 border-t border-white/5 pt-3">
                        <div>
                             <div class="text-[10px] text-gray-500 uppercase tracking-wider">Submissions</div>
                             <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-500/10 text-blue-400 mt-1">
                                {{ $user->submissions_count }}
                             </span>
                        </div>
                        <div class="text-right">
                             <div class="text-[10px] text-gray-500 uppercase tracking-wider">Joined</div>
                             <div class="text-gray-400 text-xs mt-0.5">{{ $user->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-2 border-t border-white/5 pt-3">
                        @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone and will delete all their submissions.');" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all flex items-center gap-2 w-full justify-center" title="Delete User">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    <span class="text-xs font-bold uppercase tracking-wider">Delete User</span>
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-600 italic">Current User</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 italic">No users found.</div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-gray-400 uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="px-4 py-3 md:px-6 md:py-4">User Details</th>
                        <th class="px-4 py-3 md:px-6 md:py-4 text-center">Submissions</th>
                        <th class="hidden md:table-cell px-6 py-4">Joined Date</th>
                        <th class="px-4 py-3 md:px-6 md:py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($users as $user)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-4 py-3 md:px-6 md:py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-500 to-[#A3050A] flex flex-shrink-0 items-center justify-center text-xs font-bold text-white">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-white font-medium text-xs md:text-sm">{{ $user->name }}</div>
                                    <div class="text-[10px] md:text-xs text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 md:px-6 md:py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400">
                                {{ $user->submissions_count }}
                            </span>
                        </td>
                        <td class="hidden md:table-cell px-6 py-4">
                            <div class="text-sm text-gray-400">{{ $user->created_at->format('M d, Y') }}</div>
                            <div class="text-[10px] text-gray-600">{{ $user->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-4 py-3 md:px-6 md:py-4 text-right">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone and will delete all their submissions.');" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all" title="Delete User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-600 italic">Current User</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 italic">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-white/5">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
