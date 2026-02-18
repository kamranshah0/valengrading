@extends('layouts.admin')

@section('title', 'Service Levels')

@section('content')
<div class="space-y-6" x-data="{ search: '' }">
    <div class="bg-[#232528]/80 backdrop-blur-xl border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="p-4 md:p-6 border-b border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                Service Levels
            </h3>
            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <!-- Search Bar -->
                <div class="relative group">
                    <input type="text" x-model="search" placeholder="Search service..." 
                        class="w-full md:w-64 bg-[#15171A] border border-white/10 rounded-xl px-4 py-2 text-xs text-white focus:outline-none focus:border-red-500 transition-all pl-10">
                    <svg class="w-4 h-4 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <a href="{{ route('admin.service-levels.create') }}" class="px-6 py-2 rounded-xl bg-gradient-to-r from-red-600 to-[#A3050A] text-white font-bold shadow-lg shadow-red-900/20 hover:scale-[1.02] transition-all duration-300 text-xs uppercase tracking-widest text-center">
                    Add New
                </a>
            </div>
        </div>

        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4 px-4 pb-4 pt-4">
            @foreach($serviceLevels as $level)
                <div class="bg-[#232528] border border-white/5 rounded-xl p-4 space-y-3 shadow-lg"
                     x-show="search === '' || '{{ strtolower($level->name) }}'.includes(search.toLowerCase())">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="font-bold text-white text-base">{{ $level->name }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                @if($level->submissionType)
                                    <span class="text-[10px] text-blue-400 font-bold uppercase">{{ $level->submissionType->name }}</span>
                                @else
                                    <span class="text-[10px] text-gray-500 italic">Global</span>
                                @endif
                                <span class="text-[10px] text-gray-500">•</span>
                                <span class="text-[10px] text-gray-500">{{ $level->turnaround_time }} Days</span>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $level->is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400' }}">
                            {{ $level->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 border-t border-white/5 pt-3">
                        <div>
                            <div class="text-[10px] text-gray-500 uppercase tracking-wider">Price/Card</div>
                            <div class="text-emerald-400 font-bold mt-0.5">£{{ number_format($level->price_per_card, 2) }}</div>
                        </div>
                        <div class="text-right">
                             <div class="text-[10px] text-gray-500 uppercase tracking-wider">Min Cards</div>
                             <div class="text-white font-bold mt-0.5">{{ $level->min_submission ?: 'None' }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-end gap-2 border-t border-white/5 pt-3">
                        <a href="{{ route('admin.service-levels.edit', $level) }}" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('admin.service-levels.destroy', $level) }}" method="POST" onsubmit="return confirm('Delete this service level?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
            
            <div x-show="Object.keys($refs).length > 0 && $arr(serviceLevels).filter(l => l.name.toLowerCase().includes(search.toLowerCase())).length === 0" class="text-center py-8 text-gray-500 italic" style="display: none;">
               <!-- Alpine handling empty state in loop is tricky without a list array. ignoring specific empty msg for card view simple impl -->
            </div>
        </div>

        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-white/5 text-gray-400 uppercase text-[10px] font-bold tracking-wider">
                    <tr>
                        <th class="hidden md:table-cell px-6 py-4">Order</th>
                        <th class="px-4 py-3 md:px-6 md:py-4">Parent Service</th>
                        <th class="px-4 py-3 md:px-6 md:py-4">Name</th>
                        <th class="hidden md:table-cell px-6 py-4 text-center">Delivery</th>
                        <th class="hidden md:table-cell px-6 py-4 text-center">Min Cards</th>
                        <th class="px-4 py-3 md:px-6 md:py-4 text-center">Price/Card</th>
                        <th class="px-4 py-3 md:px-6 md:py-4 text-center">Status</th>
                        <th class="px-4 py-3 md:px-6 md:py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($serviceLevels as $level)
                        <tr class="hover:bg-white/[0.02] transition-colors group" 
                            x-show="search === '' || '{{ strtolower($level->name) }}'.includes(search.toLowerCase())">
                            <td class="hidden md:table-cell px-6 py-4 text-gray-500 font-mono">{{ $level->order }}</td>
                            <td class="px-4 py-3 md:px-6 md:py-4">
                                @if($level->submissionType)
                                    <span class="px-2 py-1 rounded bg-blue-500/10 text-blue-400 text-[10px] md:text-xs font-bold border border-blue-500/20 whitespace-nowrap">
                                        {{ $level->submissionType->name }}
                                    </span>
                                @else
                                    <span class="text-gray-600 text-[10px] md:text-xs italic">Global</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 md:px-6 md:py-4 font-bold text-white text-xs md:text-sm whitespace-nowrap">{{ $level->name }}</td>
                            <td class="hidden md:table-cell px-6 py-4 text-center text-gray-300">{{ $level->delivery_time }}</td>
                            <td class="hidden md:table-cell px-6 py-4 text-center text-gray-300">
                                @if($level->min_submission)
                                    <span class="bg-white/5 px-2 py-1 rounded text-xs">{{ $level->min_submission }} cards</span>
                                @else
                                    <span class="text-gray-600 italic">None</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 md:px-6 md:py-4 text-center">
                                <span class="text-emerald-400 font-bold tabular-nums text-xs md:text-base">£{{ number_format($level->price_per_card, 2) }}</span>
                            </td>
                            <td class="px-4 py-3 md:px-6 md:py-4 text-center">
                                <span class="px-2 py-1 md:px-3 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $level->is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $level->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 md:px-6 md:py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.service-levels.edit', $level) }}" class="p-2 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500/20 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.service-levels.destroy', $level) }}" method="POST" onsubmit="return confirm('Delete this service level?')">
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