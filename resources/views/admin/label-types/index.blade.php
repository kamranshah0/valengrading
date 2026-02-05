@extends('layouts.admin')

@section('title', 'Label Types Management')

@section('content')
<div class="space-y-6" x-data="{ search: '' }">
    <div class="bg-[#232528]/80 backdrop-blur-xl border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-4 md:p-6 border-b border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M13 7h.01M13 11h.01M13 15h.01M17 7h.01M17 11h.01M17 15h.01"></path></svg>
                Label Types
            </h3>
            
            <a href="{{ route('admin.label-types.create') }}" class="px-6 py-2 rounded-lg bg-gradient-to-r from-red-600 to-[#A3050A] text-white font-bold hover:shadow-lg hover:shadow-red-900/30 transition-all text-sm w-full md:w-auto text-center flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New
            </a>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4 px-4 pb-4 pt-4">
            @forelse($labelTypes as $labelType)
                <div class="bg-[#232528] border border-white/5 rounded-xl p-4 space-y-3 shadow-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="font-bold text-white text-base">{{ $labelType->name }}</div>
                            <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $labelType->description }}</div>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $labelType->is_active ? 'bg-emerald-500/10 text-emerald-400' : 'bg-gray-500/10 text-gray-400' }}">
                                {{ $labelType->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    <div class="flex items-start justify-between border-t border-white/5 pt-3">
                        <div>
                            <div class="text-[10px] text-gray-500 uppercase tracking-wider">Display Price</div>
                            <div class="text-white font-bold mt-0.5">{{ $labelType->display_price }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-2 border-t border-white/5 pt-3">
                        <a href="{{ route('admin.label-types.edit', $labelType) }}" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <form action="{{ route('admin.label-types.destroy', $labelType) }}" method="POST" onsubmit="return confirm('Delete this label type?')" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 italic">No label types found.</div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-gray-400 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-8 py-5">Name</th>
                        <th class="px-8 py-5">Description</th>
                        <th class="px-8 py-5">Display Price</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        <th class="px-8 py-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($labelTypes as $type)
                        <tr class="hover:bg-white/[0.02] transition-colors group"
                            x-show="search === '' || '{{ strtolower($type->name . ' ' . $type->description) }}'.includes(search.toLowerCase())">
                            <td class="px-4 py-3 md:px-6 md:py-4 text-gray-500 font-mono text-xs">{{ $type->order }}</td>
                            <td class="px-4 py-3 md:px-6 md:py-4 font-bold text-white text-xs md:text-sm whitespace-nowrap">{{ $type->name }}</td>
                            <td class="hidden md:table-cell px-6 py-4 text-sm text-gray-400 max-w-xs truncate">{{ $type->description }}</td>
                            <td class="px-4 py-3 md:px-6 md:py-4 text-center">
                                <span class="bg-red-500/10 text-red-400 px-2 py-1 md:px-3 rounded-lg font-bold tabular-nums text-xs">
                                    {{ $type->display_price }}
                                </span>
                            </td>
                            <td class="px-4 py-3 md:px-6 md:py-4 text-center">
                                <span class="px-2 py-1 md:px-3 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $type->is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $type->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 md:px-6 md:py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.label-types.edit', $type) }}" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.label-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Delete this label type?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection