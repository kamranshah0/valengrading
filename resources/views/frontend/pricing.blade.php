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
                    <!-- Classic -->
                    <div
                        class="group relative bg-[#1C1E21] border border-[var(--color-valen-border)] rounded-2xl p-10 text-center transition-all duration-300 hover:border-[var(--color-primary)] hover:shadow-[0_0_30px_rgba(163,5,10,0.15)] hover:-translate-y-2">
                        <h3 class="text-xl font-bold text-white mb-2">Classic Label</h3>
                        <div class="text-4xl font-black text-[var(--color-primary)] mb-2">£0 <span
                                class="text-sm font-medium text-gray-400">/ per card</span></div>
                        <p class="text-xs text-gray-500 mb-8 uppercase tracking-widest">Included with submission price</p>
                        <ul class="text-sm text-gray-400 text-left space-y-4 mb-8 pl-4">
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Clean, timeless design</li>
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Clear Information</li>
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> QR Code Authentication</li>
                        </ul>
                    </div>

                    <!-- Premium -->
                    <div
                        class="group relative bg-[#1C1E21] border border-[var(--color-valen-border)] rounded-2xl p-10 text-center transition-all duration-300 hover:border-[var(--color-primary)] hover:shadow-[0_0_30px_rgba(163,5,10,0.15)] hover:-translate-y-2">
                        <h3 class="text-xl font-bold text-white mb-2">Premium Label</h3>
                        <div class="text-4xl font-black text-[var(--color-primary)] mb-2">£5 <span
                                class="text-sm font-medium text-gray-400">/ per card</span></div>
                        <p class="text-xs text-gray-500 mb-8 uppercase tracking-widest">Enhanced features & security</p>
                        <ul class="text-sm text-gray-400 text-left space-y-4 mb-8 pl-4">
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Holographic elements</li>
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Premium foil text</li>
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Superior security</li>
                        </ul>
                    </div>

                    <!-- Custom -->
                    <div
                        class="group relative bg-[#1C1E21] border border-[var(--color-valen-border)] rounded-2xl p-10 text-center transition-all duration-300 hover:border-[var(--color-primary)] hover:shadow-[0_0_30px_rgba(163,5,10,0.15)] hover:-translate-y-2">
                        <h3 class="text-xl font-bold text-white mb-2">Custom Label</h3>
                        <div class="text-4xl font-black text-[var(--color-primary)] mb-2">£15 <span
                                class="text-sm font-medium text-gray-400">/ per card</span></div>
                        <p class="text-xs text-gray-500 mb-8 uppercase tracking-widest">Fully customizable design</p>
                        <ul class="text-sm text-gray-400 text-left space-y-4 mb-8 pl-4">
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Submit your own art</li>
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> Exclusive designs</li>
                            <li class="flex items-center"><svg class="w-4 h-4 text-[var(--color-primary)] mr-3" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg> All premium features</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Service Levels & Pricing -->
            <div class="mb-24" x-data="{ activeTab: 'grading' }">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-extrabold text-white mb-4">Service Levels & Pricing</h2>
                    <p class="text-gray-400 max-w-2xl mx-auto">Choose the service level that best fits your needs and
                        budget. All options include our industry-leading quality standards.</p>
                </div>

                 <!-- Tabs -->
                <div class="flex justify-center mb-12">
                    <div class="bg-white/10 backdrop-blur-md rounded-full p-1 flex border border-white/10 overflow-x-auto max-w-full hide-scrollbar">
                        <button @click="activeTab = 'grading'"
                            :class="{ 'bg-[var(--color-primary)] text-white shadow-lg': activeTab === 'grading', 'text-gray-300 hover:text-white hover:bg-white/5': activeTab !== 'grading' }"
                            class="px-6 sm:px-8 py-2.5 rounded-full font-bold text-sm transition-all duration-300 whitespace-nowrap">Grading</button>
                        <button @click="activeTab = 'crossover'"
                            :class="{ 'bg-[var(--color-primary)] text-white shadow-lg': activeTab === 'crossover', 'text-gray-300 hover:text-white hover:bg-white/5': activeTab !== 'crossover' }"
                            class="px-6 sm:px-8 py-2.5 rounded-full font-bold text-sm transition-all duration-300 whitespace-nowrap">Crossover</button>
                        <button @click="activeTab = 'reholder'"
                            :class="{ 'bg-[var(--color-primary)] text-white shadow-lg': activeTab === 'reholder', 'text-gray-300 hover:text-white hover:bg-white/5': activeTab !== 'reholder' }"
                            class="px-6 sm:px-8 py-2.5 rounded-full font-bold text-sm transition-all duration-300 whitespace-nowrap">Re-Holder</button>
                        <button @click="activeTab = 'authentication'"
                            :class="{ 'bg-[var(--color-primary)] text-white shadow-lg': activeTab === 'authentication', 'text-gray-300 hover:text-white hover:bg-white/5': activeTab !== 'authentication' }"
                            class="px-6 sm:px-8 py-2.5 rounded-full font-bold text-sm transition-all duration-300 whitespace-nowrap">Authentication</button>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="relative min-h-[500px]">
                    
                    @php
                        $tiers = [
                            'Basic' => ['price' => '15', 'time' => '45 Business Days', 'subtitle' => 'Perfect for casual collectors', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'],
                            'Express' => ['price' => '25', 'time' => '20 Business Days', 'subtitle' => 'Faster service for urgent needs', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>'],
                            'Premium' => ['price' => '45', 'time' => '5 Business Days', 'subtitle' => 'Our highest tier service', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>'],
                        ];
                        
                        $services = [
                            'grading' => [
                                'Basic' => ['Authentication', 'Expert Grading', 'Encapsulation', 'Basic insurance'],
                                'Express' => ['All Basic features', 'Priority handling', 'Enhanced insurance', 'Front of line access'],
                                'Premium' => ['All Express features', 'Same day processing', 'Dedicated support', 'Max insurance cover', 'White glove service'],
                            ],
                            'crossover' => [
                                'Basic' => ['Evaluation', 'New encapsulation if grade meets/exceeds', 'Database entry', 'Basic insurance'],
                                'Express' => ['Priority Evaluation', 'New encapsulation if grade meets/exceeds', 'Enhanced insurance', 'Front of line access'],
                                'Premium' => ['Expert Panel Evaluation', 'Same day processing', 'Dedicated support', 'Max insurance cover'],
                            ],
                            'reholder' => [
                                'Basic' => ['New Generation Slab', 'Label refresh', 'Sonic sealing'],
                                'Express' => ['Priority queue', 'New Generation Slab', 'Enhanced protection'],
                                'Premium' => ['Max Speed', 'UV Protection', 'Custom label option'],
                            ],
                            'authentication' => [
                                'Basic' => ['Visual inspection', 'Digital Proof', 'Database addition'],
                                'Express' => ['Priority review', 'Physical Letter', 'Fast tracking'],
                                'Premium' => ['Multi-expert panel', 'Detailed Report', 'High value items'],
                            ]
                        ];
                    @endphp

                    @foreach($services as $serviceKey => $serviceTiers)
                        <div x-show="activeTab === '{{ $serviceKey }}'" {{ $serviceKey !== 'grading' ? 'style="display: none;"' : '' }}
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="opacity-0 translate-y-8"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-300 absolute top-0 w-full"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-8"
                             class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
                             
                             @foreach($tiers as $tierName => $tierDetails)
                                <div class="bg-[#1C1E21] border border-[var(--color-valen-border)] rounded-2xl p-8 flex flex-col items-center text-center transition-all duration-300 hover:border-[var(--color-primary)] hover:shadow-[0_0_30px_rgba(163,5,10,0.15)] {{ $tierName === 'Express' ? 'scale-105 z-10 shadow-2xl relative' : '' }} group relative overflow-hidden">
                                     @if($tierName === 'Express')
                                        <div class="absolute top-0 right-0 bg-[var(--color-primary)] text-white text-[10px] font-bold px-3 py-1 rounded-bl uppercase">Most Popular</div>
                                     @endif
                                     
                                     <div class="w-12 h-12 rounded-lg bg-[#2A1215] flex items-center justify-center text-[var(--color-primary)] mb-6">
                                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                             {!! $tierDetails['icon'] !!}
                                         </svg>
                                     </div>
                                     <h3 class="text-xl font-bold text-white mb-2">{{ $tierName }}</h3>
                                     <p class="text-xs text-gray-500 mb-6">{{ $tierDetails['subtitle'] }}</p>
                                     <div class="text-4xl font-black text-[var(--color-primary)] mb-6">£{{ $tierDetails['price'] }} <span class="text-sm font-medium text-gray-400">/ item</span></div>
                                     <div class="text-sm text-white font-bold mb-8">Turnaround: <span class="text-gray-400 font-normal">{{ $tierDetails['time'] }}</span></div>
        
                                     <ul class="text-sm text-gray-400 text-left space-y-3 mb-8 w-full">
                                        @foreach($serviceTiers[$tierName] as $featureDescription)
                                            <li class="flex items-center">
                                                <svg class="w-3 h-3 text-[var(--color-primary)] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg> 
                                                {{ $featureDescription }}
                                            </li>
                                        @endforeach
                                     </ul>
                                     <button class="mt-auto w-full py-3 rounded-lg border border-[var(--color-valen-border)] text-white hover:bg-[var(--color-primary)] hover:border-[var(--color-primary)] transition-colors font-bold text-sm">Select</button>
                                </div>
                             @endforeach
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
