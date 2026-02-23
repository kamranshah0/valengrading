@extends('layouts.admin')

@section('title', 'Edit Label Type')

@section('content')
<div class="w-full">
    <div class="bg-[#232528]/80 backdrop-blur-xl border border-white/5 rounded-2xl p-4 md:p-8 shadow-2xl">
        <form method="POST" action="{{ route('admin.label-types.update', $labelType) }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-2">
                <label for="name" class="text-sm font-medium text-gray-400">Label Type Name*</label>
                <input type="text" id="name" name="name" value="{{ old('name', $labelType->name) }}" 
                    class="w-full bg-[#15171A] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors"
                    placeholder="e.g., Classic, Premium, Custom" required>
                @error('name')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="space-y-2">
                <label for="subtitle" class="text-sm font-medium text-gray-400">Subtitle</label>
                <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle', $labelType->subtitle) }}" 
                    class="w-full bg-[#15171A] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors"
                    placeholder="e.g., Included with submission price">
                @error('subtitle')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="space-y-2">
                <label for="description" class="text-sm font-medium text-gray-400">Description</label>
                <input type="text" id="description" name="description" value="{{ old('description', $labelType->description) }}" 
                    class="w-full bg-[#15171A] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors"
                    placeholder="e.g., Clean, timeless look for any collection.">
                @error('description')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="space-y-2">
                <label for="image" class="text-sm font-medium text-gray-400">Label Image (leave blank to keep current)</label>
                <input type="file" id="image" name="image" 
                    class="w-full bg-[#15171A] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors"
                    accept="image/*">
                @if($labelType->image_path)
                    <div class="mt-2 pl-1">
                        <img src="{{ asset('storage/' . $labelType->image_path) }}" alt="Current Image" class="h-20 w-auto rounded border border-white/10">
                    </div>
                @endif
                @error('image')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="space-y-2">
                <label for="features" class="text-sm font-medium text-gray-400">Features (one per line)</label>
                <textarea id="features" name="features" rows="4"
                    class="w-full bg-[#15171A] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors"
                    placeholder="Clean, timeless design&#10;Clear Information&#10;QR Code Authentication">{{ old('features', is_array($labelType->features) ? implode("\n", $labelType->features) : '') }}</textarea>
                @error('features')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="price_adjustment" class="text-sm font-medium text-gray-400">Price Adjustment (£)*</label>
                    <input type="number" step="0.01" id="price_adjustment" name="price_adjustment" value="{{ old('price_adjustment', $labelType->price_adjustment) }}" 
                        class="w-full bg-[#15171A] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors"
                        required>
                    <p class="text-[10px] text-gray-500 uppercase tracking-wider">Additional price (0 for free)</p>
                    @error('price_adjustment')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div class="space-y-2">
                    <label for="order" class="text-sm font-medium text-gray-400">Display Order*</label>
                    <input type="number" id="order" name="order" value="{{ old('order', $labelType->order) }}" 
                        class="w-full bg-[#15171A] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-red-500 transition-colors"
                        required>
                    @error('order')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            
            <div class="space-y-2">
                <label for="is_active" class="text-sm font-medium text-gray-400">Status*</label>
                <div class="relative">
                    <select id="is_active" name="is_active" 
                        class="w-full bg-[#15171A] border border-white/10 rounded-xl pl-4 pr-10 py-3 text-white focus:outline-none focus:border-red-500 transition-colors appearance-none cursor-pointer"
                        required>
                        <option value="1" {{ old('is_active', $labelType->is_active) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $labelType->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <svg class="w-4 h-4 text-gray-500 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                @error('is_active')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div class="pt-4 flex flex-col-reverse md:flex-row items-center justify-end gap-4">
                <a href="{{ route('admin.label-types.index') }}" class="w-full md:w-auto text-center px-6 py-3 rounded-xl bg-white/5 text-gray-300 hover:text-white hover:bg-white/10 transition-all font-medium">Cancel</a>
                <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-red-600 to-[#A3050A] text-white font-bold shadow-lg shadow-red-900/20 hover:scale-[1.02] transition-all duration-300">
                    Update Label Type
                </button>
            </div>
        </form>
    </div>
</div>
@endsection