@extends('layouts.admin')

@section('title', 'Edit Comparison Feature')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.features.index') }}" class="p-2 rounded-xl bg-white/5 text-gray-400 hover:text-white hover:bg-white/10 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-2xl font-bold text-white">Edit Feature</h1>
    </div>

    <!-- Form Card -->
    <div class="bg-[#232528] border border-white/5 rounded-2xl shadow-xl overflow-hidden">
        <form method="POST" action="{{ route('admin.features.update', $feature->id) }}" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Feature Name -->
            <div class="space-y-2">
                <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">
                    Feature Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $feature->name) }}" required autofocus
                    class="w-full bg-[#15171A] border @error('name') border-red-500/50 @else border-white/10 @enderror rounded-xl px-5 py-4 text-white focus:outline-none focus:border-red-500 transition-all placeholder-gray-600">
                @error('name') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
            </div>

             <!-- Order -->
            <div class="space-y-2">
                <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-widest">
                    Display Order <span class="text-red-500">*</span>
                </label>
                <input type="number" name="order" id="order" value="{{ old('order', $feature->order) }}" required
                    class="w-full bg-[#15171A] border @error('order') border-red-500/50 @else border-white/10 @enderror rounded-xl px-5 py-4 text-white focus:outline-none focus:border-red-500 transition-all placeholder-gray-600">
                <p class="text-[10px] text-gray-500">Lower numbers appear first in the table.</p>
                @error('order') <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Availability Toggles -->
            <div class="space-y-4 pt-4 border-t border-white/5">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">
                    Availability by Service Level
                </label>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                     <!-- Standard -->
                    <label class="flex items-center gap-3 p-4 rounded-xl bg-[#15171A] border border-white/5 cursor-pointer hover:border-white/10 transition-all group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_standard" class="peer sr-only" {{ old('is_standard', $feature->is_standard) ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-600"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Standard</span>
                    </label>

                     <!-- Express -->
                    <label class="flex items-center gap-3 p-4 rounded-xl bg-[#15171A] border border-white/5 cursor-pointer hover:border-white/10 transition-all group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_express" class="peer sr-only" {{ old('is_express', $feature->is_express) ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-600"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Express</span>
                    </label>

                     <!-- Elite -->
                    <label class="flex items-center gap-3 p-4 rounded-xl bg-[#15171A] border border-white/5 cursor-pointer hover:border-white/10 transition-all group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="is_elite" class="peer sr-only" {{ old('is_elite', $feature->is_elite) ? 'checked' : '' }}>
                            <div class="w-9 h-5 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-red-600"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-300 group-hover:text-white transition-colors">Elite</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-white/5 flex items-center justify-end gap-4">
                <a href="{{ route('admin.features.index') }}" class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Cancel</a>
                <button type="submit" class="bg-gradient-to-r from-red-600 to-[#A3050A] text-white font-bold px-8 py-3 rounded-xl shadow-lg shadow-red-900/20 hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-xs">
                    Update Feature
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
