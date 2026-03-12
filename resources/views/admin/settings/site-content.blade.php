@extends('layouts.admin')

@section('title', 'Site Content Management')

@section('content')
<div class="w-full space-y-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white">Site Content Management</h2>
        <p class="text-gray-400">Update landing page text and company contact details.</p>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 px-6 py-4 rounded-xl font-medium mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-[#232528]/80 backdrop-blur-xl border border-white/5 rounded-2xl shadow-2xl overflow-hidden p-4 md:p-8">
        <form action="{{ route('admin.settings.update-content') }}" method="POST" class="space-y-8">
            @csrf
            @method('PATCH')
            
            <!-- Hero Section -->
            <div class="space-y-6">
                <h4 class="text-sm font-bold text-red-500 uppercase tracking-widest border-b border-white/5 pb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Hero Section
                </h4>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Main Header Title</label>
                        <input type="text" name="home_hero_title" value="{{ old('home_hero_title', $home_hero_title) }}"
                            class="w-full bg-[#15171A] border border-white/10 rounded-xl px-5 py-4 text-white focus:outline-none focus:border-red-500 transition-all font-medium">
                        @error('home_hero_title') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Subtext / Description</label>
                        <textarea name="home_hero_subtitle" rows="3" class="w-full bg-[#15171A] border border-white/10 rounded-xl px-5 py-4 text-white focus:outline-none focus:border-red-500 transition-all font-medium resize-none">{{ old('home_hero_subtitle', $home_hero_subtitle) }}</textarea>
                        <p class="text-[10px] text-gray-500 italic">You can use &lt;br&gt; for line breaks.</p>
                        @error('home_hero_subtitle') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="space-y-6">
                <h4 class="text-sm font-bold text-red-500 uppercase tracking-widest border-b border-white/5 pb-2 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Contact Information
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Display Address</label>
                        <input type="text" name="contact_address" value="{{ old('contact_address', $contact_address) }}"
                            class="w-full bg-[#15171A] border border-white/10 rounded-xl px-5 py-4 text-white focus:outline-none focus:border-red-500 transition-all font-medium">
                        @error('contact_address') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Phone Number</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone', $contact_phone) }}"
                            class="w-full bg-[#15171A] border border-white/10 rounded-xl px-5 py-4 text-white focus:outline-none focus:border-red-500 transition-all font-medium">
                        @error('contact_phone') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Support Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email', $contact_email) }}"
                            class="w-full bg-[#15171A] border border-white/10 rounded-xl px-5 py-4 text-white focus:outline-none focus:border-red-500 transition-all font-medium">
                        @error('contact_email') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">Business Hours</label>
                        <input type="text" name="contact_hours" value="{{ old('contact_hours', $contact_hours) }}"
                            class="w-full bg-[#15171A] border border-white/10 rounded-xl px-5 py-4 text-white focus:outline-none focus:border-red-500 transition-all font-medium">
                        @error('contact_hours') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-white/5">
                <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-red-600 to-[#A3050A] text-white font-bold px-10 py-4 rounded-xl shadow-2xl shadow-red-900/20 transition-all hover:scale-[1.02] active:scale-[0.98] uppercase tracking-widest text-xs">
                    Update Site Content & Contact Info
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
