@extends('layouts.frontend')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
<div class="min-h-screen bg-[#15171A] text-white font-['Outfit'] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <!-- Progress Steps -->
        <div class="mb-12">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 w-full h-1 bg-white/5 -z-10 rounded-full"></div>
                
                @foreach(['Submission Type', 'Service Level', 'Card Details', 'Shipping', 'Review', 'Payment'] as $index => $step)
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm mb-2 transition-all duration-300 relative
                            {{ $index + 1 <= 1 ? 'bg-gradient-to-r from-red-500 to-[#A3050A] shadow-[0_0_15px_rgba(163,5,10,0.4)] scale-110' : 'bg-[#232528] text-gray-500' }}">
                            @if($index + 1 < 1)
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <span class="text-xs font-medium {{ $index + 1 <= 1 ? 'text-white' : 'text-gray-500' }}">{{ $step }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-[#232528]/80 backdrop-blur-xl rounded-2xl border border-white/5 p-8 shadow-2xl relative overflow-hidden">
            <!-- Glassmorphism Background -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-500/10 rounded-full blur-3xl -z-10 transition-all duration-700"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-red-900/10 rounded-full blur-3xl -z-10 transition-all duration-700"></div>

            <div class="mb-8 text-center">
                <h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-400 to-[#A3050A] mb-2">Start Your Submission</h2>
                <p class="text-gray-400">Let's get started with your submission details.</p>
            </div>

            <!-- Resume Draft Section -->
            @if(isset($drafts) && $drafts->count() > 0)
                <div class="mb-10 animate-fade-in-up">
                    <label class="block mb-4 text-sm font-semibold text-gray-300 uppercase tracking-wider">Resume a Submission</label>
                    
                    <div class="space-y-3 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($drafts as $draft)
                            <div class="bg-[#15171A] border border-white/10 rounded-2xl p-6 transition-all duration-300 hover:border-red-500/50 hover:bg-white/[0.02] flex flex-col md:flex-row md:items-center justify-between gap-4 group">
                                <div>
                                    <h4 class="font-bold text-white text-lg group-hover:text-red-400 transition-colors">{{ $draft->guest_name ?? 'Untitled Submission' }} 
                                        <span class="text-gray-500 font-normal text-sm ml-2">({{ $draft->submissionType->title ?? 'Unknown' }} - {{ $draft->serviceLevel->name ?? 'Unknown' }})</span>
                                    </h4>
                                    <div class="text-xs text-gray-500 mt-2 flex gap-4 uppercase tracking-wider font-medium">
                                        <span>Created: {{ $draft->created_at->format('jS F Y') }}</span>
                                        <span>Cards: {{ $draft->total_cards ?? 0 }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('submission.resume', $draft->id) }}" class="flex items-center gap-2 bg-white/5 hover:bg-white/10 text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all border border-white/5 hover:border-white/20">
                                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                                        Resume
                                    </a>
                                    <form action="{{ route('submission.draft.delete', $draft->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this draft?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex items-center gap-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all border border-red-500/20 hover:border-red-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('submission.storeStep1') }}" method="POST">
                @csrf
                
                <div class="mb-8">
                    <label for="submission_name" class="block mb-2 text-sm font-semibold text-gray-300">Submission Name</label>
                    <input type="text" id="submission_name" name="submission_name" 
                        value="{{ old('submission_name', session('submission_data.submission_name')) }}"
                        class="w-full bg-[#15171A] border border-white/10 text-white text-lg rounded-xl focus:ring-2 focus:ring-red-500/50 focus:border-red-500 block p-4 transition-all placeholder-gray-600" 
                        placeholder="e.g. My Pokemon Collection #1" required>
                    @error('submission_name')
                        <p class="mt-2 text-sm text-red-500 flex items-center"><span class="mr-1">⚠</span> {{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-10">
                    <label class="block mb-4 text-sm font-semibold text-gray-300 uppercase tracking-wider">Select Submission Type</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($types as $type)
                            <div class="relative submission-card-wrapper">
                                <input type="radio" id="type_{{ $type->id }}" name="submission_type_id" value="{{ $type->id }}" class="peer hidden" 
                                    {{ (old('submission_type_id', session('submission_data.submission_type_id')) == $type->id) ? 'checked' : '' }} required>
                                <label for="type_{{ $type->id }}" class="block text-left p-6 bg-[#15171A] border border-white/10 rounded-2xl cursor-pointer transition-all duration-300 h-full
                                    hover:border-red-500/50 hover:bg-white/[0.02] 
                                    peer-checked:border-red-500 peer-checked:bg-red-500/5 peer-checked:shadow-[0_0_20px_rgba(163,5,10,0.1)]">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="font-bold text-xl text-white transition-colors uppercase tracking-tight title-text">{{ $type->title }}</span>
                                        <div class="w-6 h-6 rounded-full border-2 border-white/10 flex items-center justify-center transition-all duration-300 radio-circle">
                                            <div class="w-2.5 h-2.5 rounded-full bg-white opacity-0 transition-opacity duration-300 check-dot"></div>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-400 leading-relaxed">{{ $type->description ?? 'Standard service option.' }}</p>
                                </label>
                                <style>
                                    #type_{{ $type->id }}:checked + label .title-text { color: #ef4444; }
                                    #type_{{ $type->id }}:checked + label .radio-circle { background-color: #A3050A; border-color: #A3050A; }
                                    #type_{{ $type->id }}:checked + label .check-dot { opacity: 1; transform: scale(1); }
                                </style>
                            </div>
                        @endforeach
                    </div>
                    @error('submission_type_id')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-6 border-t border-white/10">
                    <a href="{{ route('home') }}" class="text-gray-500 hover:text-white transition-colors text-sm font-semibold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Exit to Home
                    </a>
                    <button type="submit" class="w-full md:w-auto text-white bg-gradient-to-r from-red-600 to-[#A3050A] font-bold rounded-xl text-lg px-8 py-4 shadow-[0_0_20px_rgba(163,5,10,0.3)] hover:shadow-[0_0_30px_rgba(163,5,10,0.5)] transform transition hover:scale-[1.02]">
                        Continue to Service Level →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
