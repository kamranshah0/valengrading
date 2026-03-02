@extends('layouts.frontend')

@section('content')
    <div class="bg-[var(--color-valen-dark)] min-h-screen py-16 sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Label Options -->
            <div class="mb-24">
                <div class="text-center mb-16">
                    <h1 class="text-4xl font-extrabold text-white sm:text-5xl mb-4">Label Options</h1>
                    <p class="text-gray-400 text-lg">Choose your preferred label design and service level</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @php
                        $labelTypes = \App\Models\LabelType::where('is_active', true)->orderBy('order')->get();
                    @endphp
                    @foreach($labelTypes as $label)
                    <div
                        class="group relative bg-[#1C1E21] border border-[var(--color-valen-border)] rounded-2xl p-10 text-center transition-all duration-300 hover:border-[var(--color-primary)] hover:shadow-[0_0_30px_rgba(163,5,10,0.15)] hover:-translate-y-2 flex flex-col items-center">
                        <h3 class="text-xl font-bold text-white mb-2">{{ $label->name }} Label</h3>
                        
                        <div class="text-4xl font-black text-[var(--color-primary)] mb-2 mt-4">{{ $label->price_adjustment == 0 ? '£0' : '£' . number_format($label->price_adjustment, 0) }} <span
                                class="text-sm font-medium text-gray-400">/ per card</span></div>
                        <p class="text-xs text-gray-500 mb-8 uppercase tracking-widest">{{ $label->subtitle ?? 'Label Option' }}</p>
                        
                        @if($label->features && is_array($label->features) && count($label->features) > 0)
                        <ul class="text-sm text-gray-400 text-left space-y-4 mb-8 pl-4 w-full flex-grow">
                            @foreach($label->features as $feature)
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> {{ $feature }}</li>
                            @endforeach
                        </ul>
                        @endif

                        <!-- Image -->
                        <div class="w-full mt-auto flex justify-center">
                            @if($label->image_path)
                                <img src="{{ asset('storage/' . $label->image_path) }}" alt="{{ $label->name }} Label" class="max-w-full h-auto rounded-lg shadow-lg border border-white/10 group-hover:border-[var(--color-primary)]/50 transition-colors">
                            @else
                                <div class="w-full h-32 bg-[#2A1215] rounded-lg border border-white/10 flex items-center justify-center text-gray-500">No Image</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Service Levels & Pricing -->
            @php
                $firstTabSlug = $submissionTypes->first() ? Str::slug($submissionTypes->first()->name) : 'grading';
            @endphp
            <div class="mb-24" x-data="{ activeTab: '{{ $firstTabSlug }}' }">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-white mb-4">Service Levels & Pricing</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">Choose the service level that best fits your needs and
                        budget. All options include our industry-leading quality standards.</p>
                </div>

                 <!-- Tabs -->
                <div class="flex justify-center mb-12 w-full px-4">
                    <div class="bg-white/10 backdrop-blur-md rounded-2xl md:rounded-full p-1.5 flex flex-wrap justify-center gap-1 border border-white/10 w-full max-w-2xl mx-auto">
                        @foreach($submissionTypes as $type)
                            @php $slug = Str::slug($type->name); @endphp
                            <button @click="activeTab = '{{ $slug }}'"
                                :class="{ 'bg-[var(--color-primary)] text-white shadow-lg': activeTab === '{{ $slug }}', 'text-gray-300 hover:text-white hover:bg-white/5': activeTab !== '{{ $slug }}' }"
                                class="flex-1 md:flex-none px-3 sm:px-8 py-2 md:py-2.5 rounded-xl md:rounded-full font-bold text-[11px] sm:text-sm transition-all duration-300 whitespace-nowrap">{{ $type->display_title }}</button>
                        @endforeach
                    </div>
                </div>

                <!-- Content Area -->
                <div class="relative min-h-[500px]">
                    @foreach($submissionTypes as $index => $type)
                        @php $slug = Str::slug($type->name); @endphp
                        <div x-show="activeTab === '{{ $slug }}'" {!! $index !== 0 ? 'style="display: none;"' : '' !!}
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 translate-y-8"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-300 absolute top-0 w-full"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-8"
                             class="grid grid-cols-1 lg:grid-cols-3 md:grid-cols-2 gap-8 w-full">
                             
                             @forelse($type->serviceLevels as $level)
                                <div class="bg-[#1C1E21] border border-[var(--color-valen-border)] rounded-2xl p-8 flex flex-col items-center text-center transition-all duration-300 hover:border-[var(--color-primary)] hover:shadow-[0_0_30px_rgba(163,5,10,0.15)] {{ strtolower($level->name) === 'express' ? 'scale-105 z-10 shadow-2xl relative' : '' }} group relative overflow-hidden">
                                     @if(strtolower($level->name) === 'express')
                                        <div class="absolute top-0 right-0 bg-[var(--color-primary)] text-white text-[10px] font-bold px-3 py-1 rounded-bl uppercase">Most Popular</div>
                                     @endif
                                     
                                     <div class="w-12 h-12 rounded-lg bg-[#2A1215] flex items-center justify-center text-[var(--color-primary)] mb-6">
                                         @if($level->icon)
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                {!! $level->icon !!}
                                            </svg>
                                         @else
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                         @endif
                                     </div>
                                     <h3 class="text-xl font-bold text-white mb-2">{{ $level->name }}</h3>
                                     <p class="text-xs text-gray-500 mb-6">{{ $level->subtitle ?? 'Quality grading service' }}</p>
                                     <div class="text-4xl font-black text-[var(--color-primary)] mb-6">£{{ rtrim(rtrim(number_format($level->price_per_card, 2), '0'), '.') }} <span class="text-sm font-medium text-gray-400">/ item</span></div>
                                     <div class="text-sm text-white font-bold mb-8">Turnaround: <span class="text-gray-400 font-normal">{{ $level->turnaround_time ?? ($level->delivery_time . ' Days') }}</span></div>
        
                                     <ul class="text-sm text-gray-400 text-left space-y-3 mb-8 w-full">
                                        @if($level->features && is_array($level->features))
                                            @foreach($level->features as $featureDescription)
                                                <li class="flex items-center">
                                                    <svg class="w-3 h-3 text-[var(--color-primary)] mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> 
                                                    {{ $featureDescription }}
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="flex items-center text-gray-600 italic">No features listed.</li>
                                        @endif
                                     </ul>
                                     <a href="{{ route('submission.step1') }}" class="mt-auto block w-full py-3 rounded-lg border border-[var(--color-valen-border)] text-white hover:bg-[var(--color-primary)] hover:border-[var(--color-primary)] transition-colors font-bold text-sm text-center">Select</a>
                                </div>
                             @empty
                                <div class="col-span-1 lg:col-span-3 text-center py-12 text-gray-500 border border-dashed border-white/10 rounded-xl">
                                    No services available for this type yet.
                                </div>
                             @endforelse
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Feature Comparison -->
            <div class="mb-12">
                <div class="text-center mb-16">
                    <h2 class="text-2xl font-bold text-white mb-4">Feature Comparison</h2>
                    <p class="text-gray-400">See what's included with each service tier</p>
                </div>

                <div class="overflow-x-auto border border-[var(--color-valen-border)] rounded-2xl">
                    <table class="w-full text-sm text-left text-gray-400">
                        <thead class="text-xs text-white uppercase bg-black/40">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-bold">Feature</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Basic</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Express</th>
                                <th scope="col" class="px-6 py-4 font-bold text-center">Premium</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[var(--color-valen-border)] bg-[#1C1E21]">
                            @foreach($comparisonFeatures as $feature)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4 font-medium text-white">{{ $feature->name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($feature->is_standard) <svg class="w-4 h-4 text-[var(--color-primary)] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        @else <svg class="w-4 h-4 text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> @endif
                                     </td>
                                     <td class="px-6 py-4 text-center">
                                         @if($feature->is_express) <svg class="w-4 h-4 text-[var(--color-primary)] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                         @else <svg class="w-4 h-4 text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> @endif
                                     </td>
                                     <td class="px-6 py-4 text-center">
                                             @if($feature->is_elite) <svg class="w-4 h-4 text-[var(--color-primary)] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                             @else <svg class="w-4 h-4 text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> @endif
                                         </td>
                                     </tr>
                             @endforeach
                             </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
@endsection
