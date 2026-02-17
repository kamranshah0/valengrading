@extends('layouts.admin')

@section('title', 'Comparison Table')

@section('content')
<div class="w-full space-y-6">
    <div class="bg-[#232528]/80 backdrop-blur-xl border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-4 md:p-6 border-b border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2 flex-shrink-0">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7-9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                Comparison Features
            </h3>

            <div class="flex items-center gap-3">
                 <a href="{{ route('admin.features.create') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold uppercase tracking-wider rounded-lg transition-colors flex items-center justify-center gap-2 flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Feature
                </a>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4 px-4 pb-4 pt-4">
            @forelse($features as $feature)
                <div class="bg-[#15171A] border border-white/5 rounded-xl p-4 space-y-3 shadow-lg">
                    <div class="flex items-start justify-between">
                        <div>
                             <div class="font-bold text-white text-base max-w-[200px]">{{ $feature->name }}</div>
                              <div class="flex items-center gap-2 mt-1">
                                <span class="text-[10px] text-gray-500 font-mono">Order: {{ $feature->order }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 text-center border-t border-white/5 pt-3">
                        <div class="flex flex-col items-center">
                            <span class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">Standard</span>
                             @if($feature->is_standard)
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            @endif
                        </div>
                         <div class="flex flex-col items-center">
                            <span class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">Express</span>
                             @if($feature->is_express)
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            @endif
                        </div>
                         <div class="flex flex-col items-center">
                            <span class="text-[10px] text-gray-500 uppercase tracking-widest mb-1">Elite</span>
                             @if($feature->is_elite)
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2 border-t border-white/5 pt-3">
                         <a href="{{ route('admin.features.edit', $feature->id) }}" class="p-2 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 transition-all" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.features.destroy', $feature->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 italic">No features found.</div>
            @endforelse
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-gray-400 uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-8 py-5 text-center w-24">Order</th>
                        <th class="px-8 py-5">Feature Name</th>
                        <th class="px-8 py-5 text-center">Standard</th>
                        <th class="px-8 py-5 text-center">Express</th>
                        <th class="px-8 py-5 text-center">Elite</th>
                        <th class="px-8 py-5 text-right w-32">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($features as $feature)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-5 text-center text-gray-400 font-mono text-xs">
                                {{ $feature->order }}
                            </td>
                            <td class="px-8 py-5">
                                <div class="text-white font-medium text-base">{{ $feature->name }}</div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                @if($feature->is_standard)
                                    <span class="inline-flex items-center justify-center size-6 rounded-full bg-emerald-500/10 text-emerald-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center size-6 rounded-full bg-white/5 text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-center">
                                @if($feature->is_express)
                                   <span class="inline-flex items-center justify-center size-6 rounded-full bg-emerald-500/10 text-emerald-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center size-6 rounded-full bg-white/5 text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-center">
                                @if($feature->is_elite)
                                    <span class="inline-flex items-center justify-center size-6 rounded-full bg-emerald-500/10 text-emerald-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </span>
                                @else
                                    <span class="inline-flex items-center justify-center size-6 rounded-full bg-white/5 text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.features.edit', $feature->id) }}" class="p-2 rounded-lg bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.features.destroy', $feature->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 italic">No features found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
