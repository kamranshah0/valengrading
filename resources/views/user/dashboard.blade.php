@extends('layouts.frontend')

@section('content')
    <div x-data="{ activeTab: '{{ request('tab', 'overview') }}' }" class="pb-32 pt-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Dashboard Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-white mb-2">My Dashboard</h1>
            <p class="text-gray-400">Track your card grading submissions and manage your account</p>
        </div>

        <!-- 4 Stats Cards Row -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <!-- Total Submissions -->
            <div
                class="bg-[var(--color-valen-light)] rounded-lg p-6 border border-[var(--color-valen-border)] relative overflow-hidden group">
                <div class="flex flex-col justify-between h-full min-h-[90px]">
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total Submissions</span>
                    <div class="flex justify-between items-end">
                        <span class="text-4xl font-bold text-white">{{ $totalSubmissions }}</span>
                        <div class="text-[var(--color-primary)] opacity-80">
                            <svg class="size-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards Graded -->
            <div
                class="bg-[var(--color-valen-light)] rounded-lg p-6 border border-[var(--color-valen-border)] relative overflow-hidden group">
                <div class="flex flex-col justify-between h-full min-h-[90px]">
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Cards Graded</span>
                    <div class="flex justify-between items-end">
                        <span class="text-4xl font-bold text-white">{{ $cardsGraded }}</span>
                        <div class="text-green-500 opacity-80">
                            <svg class="size-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submission In Progress -->
            <div
                class="bg-[var(--color-valen-light)] rounded-lg p-6 border border-[var(--color-valen-border)] relative overflow-hidden group">
                <div class="flex flex-col justify-between h-full min-h-[90px]">
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Submission In Progress</span>
                    <div class="flex justify-between items-end">
                        <span class="text-4xl font-bold text-white">{{ $inProgress }}</span>
                        <div class="text-blue-500 opacity-80">
                            <svg class="size-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grading Reports -->
            <div
                class="bg-[var(--color-valen-light)] rounded-lg p-6 border border-[var(--color-valen-border)] relative overflow-hidden group">
                <div class="flex flex-col justify-between h-full min-h-[90px]">
                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wide">Grading Reports</span>
                    <div class="flex justify-between items-end">
                        <span class="text-4xl font-bold text-white">{{ $gradingReportsCount }}</span>
                        <div class="text-purple-500 opacity-80">
                            <svg class="size-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Segmented Tab Navigation -->
        <div
            class="bg-[var(--color-valen-light)] rounded-lg border border-[var(--color-valen-border)] p-1 grid grid-cols-4 gap-1 mb-8">
            <button @click="activeTab = 'overview'"
                class="flex items-center justify-center py-3 rounded text-sm font-medium transition-all duration-300"
                :class="activeTab === 'overview' ? 'bg-[var(--color-primary)] text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
            </button>
            <button @click="activeTab = 'cards'"
                class="flex items-center justify-center py-3 rounded text-sm font-medium transition-all duration-300"
                :class="activeTab === 'cards' ? 'bg-[var(--color-primary)] text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </button>
            <button @click="activeTab = 'status'"
                class="flex items-center justify-center py-3 rounded text-sm font-medium transition-all duration-300"
                :class="activeTab === 'status' ? 'bg-[var(--color-primary)] text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </button>
            <button @click="activeTab = 'profile'"
                class="flex items-center justify-center py-3 rounded text-sm font-medium transition-all duration-300"
                :class="activeTab === 'profile' ? 'bg-[var(--color-primary)] text-white shadow-lg' : 'text-gray-400 hover:text-white hover:bg-white/5'">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </button>
        </div>

        <!-- Content Area with Glass Effect -->
        <div class="glass-effect rounded-lg p-1 min-h-[500px] animate-slide-up">

            <!-- OVERVIEW TAB -->
            <div x-show="activeTab === 'overview'"
                class="p-8 flex flex-col items-center justify-center h-full min-h-[400px]">
                <h2 class="text-2xl font-bold text-white mb-2">Welcome Back!</h2>
                <p class="text-gray-400 mb-12">Here's a summary of your recent grading activity</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-4xl mb-12">
                    <!-- Cards Completed Block -->
                    <div
                        class="bg-[var(--color-valen-light)]/50 border border-[var(--color-valen-border)] rounded-xl p-8 flex flex-col items-center justify-center hover:border-green-500/50 transition-colors cursor-pointer group">
                        <div
                            class="w-12 h-12 rounded-full border border-green-500/30 flex items-center justify-center mb-4 text-green-500 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">{{ $cardsGraded }} Cards Completed</h3>
                        <p class="text-sm text-gray-500">Your total graded collection</p>
                    </div>

                    <!-- Cards In Progress Block -->
                    <div
                        class="bg-[var(--color-valen-light)]/50 border border-[var(--color-valen-border)] rounded-xl p-8 flex flex-col items-center justify-center hover:border-blue-500/50 transition-colors cursor-pointer group">
                        <div
                            class="w-12 h-12 rounded-full border border-blue-500/30 flex items-center justify-center mb-4 text-blue-500 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-1">{{ $inProgress }} Submissions Active</h3>
                        <p class="text-sm text-gray-500">Currently in the grading process</p>
                    </div>
                </div>

                <a href="{{ route('submission.step1') }}"
                    class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-hover)] text-white px-8 py-3 rounded text-sm font-semibold transition-all shadow-[0_0_20px_rgba(163,5,10,0.4)] hover:shadow-[0_0_30px_rgba(163,5,10,0.6)]">
                    Submit New Cards
                </a>
            </div>

            <!-- MY CARDS TAB -->
            <div x-show="activeTab === 'cards'" class="p-8" style="display: none;">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
                    <h2 class="text-xl font-bold text-white whitespace-nowrap">My Card Collection</h2>
                    
                    <form action="{{ route('user.dashboard') }}" method="GET" class="w-full lg:w-auto flex flex-col sm:flex-row gap-3">
                        <input type="hidden" name="tab" value="cards">
                        
                        <!-- Search Group -->
                        <div class="flex w-full sm:w-auto items-stretch">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." 
                                class="w-full sm:w-64 bg-[var(--color-valen-dark)] border border-r-0 border-[var(--color-valen-border)] rounded-l-lg py-3 pl-4 pr-3 text-sm text-white focus:outline-none focus:border-[var(--color-primary)] placeholder-gray-500 transition-colors">
                            <button type="submit" class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-hover)] text-white px-5 rounded-r-lg border border-[var(--color-primary)] transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </div>

                        <!-- Filters Group -->
                        <div class="grid grid-cols-2 gap-3 w-full sm:w-auto">
                            <!-- Grade Filter -->
                            <select name="grade_filter" onchange="this.form.submit()" 
                                class="w-full sm:w-40 bg-[var(--color-valen-dark)] border border-[var(--color-valen-border)] rounded-lg py-2.5 px-3 text-sm text-white focus:outline-none focus:border-[var(--color-primary)] cursor-pointer appearance-none">
                                <option value="">All Grades</option>
                                <option value="10" {{ request('grade_filter') == '10' ? 'selected' : '' }}>Grade 10</option>
                                <option value="9" {{ request('grade_filter') == '9' ? 'selected' : '' }}>Grade 9</option>
                                <option value="8" {{ request('grade_filter') == '8' ? 'selected' : '' }}>Grade 8</option>
                                <option value="7" {{ request('grade_filter') == '7' ? 'selected' : '' }}>Grade 7</option>
                                <option value="6_and_below" {{ request('grade_filter') == '6_and_below' ? 'selected' : '' }}>6 & Below</option>
                                <option value="authentic" {{ request('grade_filter') == 'authentic' ? 'selected' : '' }}>Authentic</option>
                            </select>

                            <!-- Sort -->
                            <select name="sort" onchange="this.form.submit()" 
                                class="w-full sm:w-40 bg-[var(--color-valen-dark)] border border-[var(--color-valen-border)] rounded-lg py-2.5 px-3 text-sm text-white focus:outline-none focus:border-[var(--color-primary)] cursor-pointer appearance-none">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                <option value="alphabetical" {{ request('sort') == 'alphabetical' ? 'selected' : '' }}>Alphabetical</option>
                                <option value="highest_grade" {{ request('sort') == 'highest_grade' ? 'selected' : '' }}>Highest Grade</option>
                                <option value="lowest_grade" {{ request('sort') == 'lowest_grade' ? 'selected' : '' }}>Lowest Grade</option>
                            </select>
                        </div>
                    </form>
                </div>

                <div class="space-y-4">
                    @forelse($myCards as $card)
                    <!-- Card Item -->
                    <div
                        class="bg-[var(--color-valen-dark)] border border-[var(--color-valen-border)] rounded-lg p-6 flex flex-col md:flex-row items-center justify-between gap-6 hover:border-[var(--color-valen-border)]/80 transition-colors group">
                        <div class="flex items-center gap-6 w-full">
                            <!-- Image Placeholder -->
                            <div
                                class="w-24 h-32 bg-[var(--color-valen-light)] rounded border border-[var(--color-valen-border)] flex-shrink-0 overflow-hidden relative">
                                @if($card->grading_image)
                                    <img src="{{ asset('storage/' . $card->grading_image) }}" alt="{{ $card->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-600">
                                            <svg class="w-8 h-8 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                    </div>
                                @endif
                                @if($card->grade)
                                    <!-- Optional: Show grade here if revealed, but user wants specific reveal behavior below -->
                                    {{-- <div class="absolute top-0 right-0 bg-[var(--color-primary)] text-white text-xs font-bold px-1.5 py-0.5 rounded-bl">
                                        {{ $card->grade ?? 'N/A' }}
                                    </div> --}}
                                @endif
                            </div>

                            <div x-data="{ revealed: false, grade: '{{ $card->grade }}', loading: false }">
                                <h3 class="text-white font-bold text-lg">{{ $card->title }}</h3>
                                <p class="text-gray-400 text-sm mb-4">{{ $card->set_name ?? 'N/A' }} • {{ $card->year ?? 'N/A' }}</p>

                                <template x-if="revealed">
                                    <button 
                                        @click="revealed = false" 
                                        class="bg-white text-black text-xs font-bold px-4 py-2 rounded flex items-center gap-2 hover:bg-gray-200 transition-colors cursor-pointer">
                                         <svg class="w-4 h-4 text-[var(--color-primary)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span x-text="grade"></span>
                                    </button>
                                </template>

                                <template x-if="!revealed">
                                    <button 
                                        @click="loading = true; 
                                                // If we already have the grade, just toggle. Otherwise fetch.
                                                if (grade && grade !== 'Pending' && grade !== '') {
                                                    revealed = true;
                                                    loading = false;
                                                } else {
                                                    fetch('{{ route('user.card.reveal', $card->id) }}', {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                        }
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.status === 'error') {
                                                            alert(data.message);
                                                            loading = false;
                                                            return;
                                                        }
                                                        grade = data.grade;
                                                        revealed = true;
                                                        loading = false;
                                                    })
                                                    .catch(() => {
                                                        loading = false;
                                                        alert('Something went wrong');
                                                    });
                                                }"
                                        class="bg-white text-black text-xs font-bold px-4 py-2 rounded flex items-center gap-2 hover:bg-gray-200 transition-colors"
                                        :class="{ 'opacity-75 cursor-wait': loading }"    
                                    >
                                        <svg x-show="!loading" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span x-text="loading ? 'Revealing...' : 'Reveal Grade'"></span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="flex gap-8 pr-4">
                            <a href="{{ route('cert.index', ['cert' => $card->cert_number]) }}" target="_blank"
                                class="flex flex-col items-center gap-1 text-gray-500 hover:text-[var(--color-primary)] transition-colors group/btn">
                                <svg class="w-5 h-5 text-[var(--color-primary)] opacity-70 group-hover/btn:opacity-100 transition-opacity"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="text-[10px] uppercase font-bold tracking-wider">View<br>Report</span>
                            </a>
                            <a href="{{ route('pop-report') }}" target="_blank"
                                class="flex flex-col items-center gap-1 text-gray-500 hover:text-[var(--color-primary)] transition-colors group/btn">
                                <svg class="w-5 h-5 text-[var(--color-primary)] opacity-70 group-hover/btn:opacity-100 transition-opacity"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                <span class="text-[10px] uppercase font-bold tracking-wider">Pop<br>Report</span>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 text-gray-400">
                        No cards found.
                    </div>
                    @endforelse
                </div>
                
                <div class="mt-8">
                    {{ $myCards->appends(request()->query())->links() }}
                </div>
            </div>

            <!-- ORDER STATUS TAB -->
            <div x-show="activeTab === 'status'" class="p-8" style="display: none;">
                <h2 class="text-xl font-bold text-white mb-8 text-center">My Order Status</h2>

                <div class="space-y-8">
                    @forelse($submissions as $submission)
                        @php 
                            $backendStatus = $submission->status;
                            $progressLevel = 0;

                            $states = [
                                'Submission Complete' => 1,
                                'Cards Logged' => 2,
                                'Grading Complete' => 3,
                                'Label Created' => 4,
                                'Encapsulation Complete' => 5,
                                'Quality Control Complete' => 6,
                            ];

                            // Determine level based on Exact match, but handle legacy mappings generically or fallback to 1
                            if (array_key_exists($backendStatus, $states)) {
                                $progressLevel = $states[$backendStatus];
                            } elseif (in_array(strtolower($backendStatus), ['submitted', 'pending_payment', 'order_received', 'awaiting_arrival'])) {
                                $progressLevel = 1;
                            } elseif (in_array(strtolower($backendStatus), ['processing', 'in_production'])) {
                                $progressLevel = 3;
                            } elseif (in_array(strtolower($backendStatus), ['shipped', 'completed', 'delivered'])) {
                                $progressLevel = 6;
                            }

                            $stepsConfig = [
                                1 => [ 'completed' => 'Submission Complete', 'pending' => 'Submission Complete' ],
                                2 => [ 'completed' => 'Cards Logged', 'pending' => 'Awaiting Card Logging' ],
                                3 => [ 'completed' => 'Grading Complete', 'pending' => 'Awaiting Grading' ],
                                4 => [ 'completed' => 'Label Created', 'pending' => 'Label Selection Received' ],
                                5 => [ 'completed' => 'Encapsulation Complete', 'pending' => 'Awaiting Encapsulation' ],
                                6 => [ 'completed' => 'Quality Control Confirmed', 'pending' => 'Awaiting Quality Control' ],
                            ];
                        @endphp
                        
                        <!-- Order Container with Border -->
                        <div class="animate-fade-in-up bg-[var(--color-valen-dark)]/30 border border-[var(--color-valen-border)] rounded-xl p-6 relative overflow-hidden group hover:border-[var(--color-primary)]/30 transition-colors">
                            
                            <!-- Status Grid or Resume Call to Action -->
                            @if($submission->status === 'draft')
                                <div class="mb-8 bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-6 flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-yellow-500/20 text-yellow-500 flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-white font-bold text-lg mb-1">Application Incomplete</h4>
                                    <p class="text-gray-400 text-sm mb-4">You have a saved draft. Resume your submission to complete the process.</p>
                                    <a href="{{ route('submission.resume', $submission->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-black font-bold py-2 px-6 rounded-lg transition-colors shadow-lg shadow-yellow-500/20">
                                        Resume Application
                                    </a>
                                </div>
                            @elseif(strtolower($submission->status) === 'cancelled')
                                <div class="mb-8 bg-red-500/10 border border-red-500/20 rounded-lg p-6 flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-red-500/20 text-red-500 flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-white font-bold text-lg mb-1">Submission Cancelled</h4>
                                    <p class="text-gray-400 text-sm">This submission order has been cancelled.</p>
                                </div>
                            @elseif($submission->status === 'Awaiting Label Selection')
                                <div class="mb-8 bg-blue-500/10 border border-blue-500/20 rounded-lg p-6 flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-full bg-blue-500/20 text-blue-500 flex items-center justify-center mb-3">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <h4 class="text-white font-bold text-lg mb-1">Action Required: Select Labels</h4>
                                    <p class="text-gray-400 text-sm mb-4">Your cards have been graded! Because you submitted via Easy Mode, please select a label style for each card so we can encapsulate them.</p>
                                    <a href="{{ route('user.submissions.labels', $submission->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors shadow-lg shadow-blue-500/20">
                                        Select Labels Now
                                    </a>
                                </div>
                            @else
                                <!-- Status Grid (Horizontal/Wrap) -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                                    @for($i = 1; $i <= 6; $i++)
                                        @php
                                            $isCompleted = $progressLevel >= $i;
                                            $isActivePending = ($progressLevel + 1) == $i; // The immediately next step
                                            $isFuture = $progressLevel < ($i - 1);
                                            
                                            $text = $isCompleted ? $stepsConfig[$i]['completed'] : $stepsConfig[$i]['pending'];
                                            
                                            // Box border styling
                                            $boxBorder = 'border-gray-800 bg-[var(--color-valen-light)]/40';
                                            if ($isCompleted) $boxBorder = 'border-green-900/50 bg-[var(--color-valen-light)]/40';
                                            if ($isActivePending) $boxBorder = 'border-amber-700/50 bg-amber-500/5';
                                            
                                            // Icon circle border & text
                                            $iconBorder = 'border-gray-600 text-gray-600';
                                            if ($isCompleted) $iconBorder = 'border-green-500 text-green-500';
                                            if ($isActivePending) $iconBorder = 'border-amber-500 text-amber-500';

                                            // Text color
                                            $textColor = 'text-gray-500';
                                            if ($isCompleted) $textColor = 'text-green-500';
                                            if ($isActivePending) $textColor = 'text-amber-500 font-bold';
                                        @endphp
                                        
                                        <div class="border {{ $boxBorder }} rounded flex items-center p-3 gap-3 transition-colors">
                                            <div class="w-5 h-5 flex-shrink-0 rounded-full border {{ $iconBorder }} flex items-center justify-center">
                                                @if($isCompleted)
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                @elseif($isActivePending)
                                                    <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                                                @endif
                                            </div>
                                            <span class="{{ $textColor }} text-sm {{ $isCompleted ? 'font-medium' : '' }}">{{ $text }}</span>
                                        </div>
                                    @endfor
                                </div>
                            @endif

                            <!-- Order Details Footer/Block -->
                            <div class="bg-[var(--color-valen-dark)]/50 border border-[var(--color-valen-border)] rounded-lg p-6">
                                <h3 class="text-white font-bold text-lg mb-1">Order #{{ $submission->submission_no }}</h3>
                                <p class="text-gray-400 text-sm mb-6">Submitted on {{ $submission->created_at->format('F j, Y') }}</p>

                                <div class="flex items-center gap-2 text-sm text-gray-300">
                                    Current Status: <span class="text-[var(--color-primary)] font-bold uppercase">{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-400 border border-dashed border-gray-700 rounded-xl">
                            <p class="mb-4">No active orders found.</p>
                            <a href="{{ route('submission.step1') }}" class="text-[var(--color-primary)] hover:underline">Start a new submission</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- MY PROFILE TAB -->
            <div x-show="activeTab === 'profile'" class="p-8" style="display: none;">
                <div class="grid grid-cols-1 gap-12 max-w-5xl mx-auto">
                    
                    <!-- Personal Information Form -->
                    <form action="{{ route('user.profile.update-info') }}" method="POST" class="bg-transparent">
                        @csrf
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[var(--color-primary)] rounded-sm"></span>
                            Personal Information
                        </h3>
                        <!-- Merging First/Last name for display as User model usually has 'name' -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-ui.valen-input label="Full Name" name="name" placeholder="Full Name" :value="$user->name" />
                            <x-ui.valen-input label="Email Address" name="email" placeholder="email@example.com" :value="$user->email" />
                            <x-ui.valen-input label="Phone Number" name="phone" placeholder="+1 (555) 000-0000" :value="$latestAddress->number ?? ''" />
                        </div>
                        <div class="mt-6 text-right">
                            <button type="submit" class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-hover)] text-white px-6 py-2 rounded text-sm font-bold transition-colors">
                                Save Personal Information
                            </button>
                        </div>
                    </form>

                    <!-- Delivery Address Form -->
                    <form action="{{ route('user.profile.update-address') }}" method="POST" class="bg-transparent">
                        @csrf
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[var(--color-primary)] rounded-sm"></span>
                            Delivery Address
                        </h3>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-ui.valen-input label="Recipient Name" name="full_name" placeholder="Full Name" :value="$latestAddress->full_name ?? auth()->user()->name" />
                                <x-ui.valen-input label="Phone Number" name="phone" placeholder="+1 (555) 000-0000" :value="$latestAddress->number ?? ''" />
                            </div>
                            <x-ui.valen-input label="Address Line 1" name="address_line_1" placeholder="Street Address" :value="$latestAddress->address_line_1 ?? ''" />
                            <x-ui.valen-input label="Address Line 2 (Optional)" name="address_line_2" placeholder="Start typing address..." :value="$latestAddress->address_line_2 ?? ''" />
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-ui.valen-input label="City" name="city" placeholder="City" :value="$latestAddress->city ?? ''" />
                                <x-ui.valen-input label="County (Optional)" name="county" placeholder="County" :value="$latestAddress->county ?? ''" />
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-ui.valen-input label="Post Code" name="post_code" placeholder="Zip/Post Code" :value="$latestAddress->post_code ?? ''" />
                                <x-ui.valen-input label="Country" name="country" placeholder="Country" :value="$latestAddress->country ?? ''" />
                            </div>
                        </div>
                        <div class="mt-6 text-right">
                            <button type="submit" class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-hover)] text-white px-6 py-2 rounded text-sm font-bold transition-colors">
                                Save Delivery Address
                            </button>
                        </div>
                    </form>

                    <!-- Change Password Form -->
                    <form action="{{ route('user.profile.update-password') }}" method="POST" class="bg-transparent">
                        @csrf
                        <h3 class="text-xl font-bold text-white mb-6 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-[var(--color-primary)] rounded-sm"></span>
                            Change Password
                        </h3>
                        <div class="space-y-6">
                             <x-ui.valen-input label="Current Password" type="password" name="current_password" placeholder="••••••••" />
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-ui.valen-input label="New Password" type="password" name="new_password" placeholder="••••••••" />
                                <x-ui.valen-input label="Confirm New Password" type="password" name="new_password_confirmation" placeholder="••••••••" />
                            </div>
                        </div>
                        <div class="mt-6 text-right">
                            <button type="submit" class="bg-[var(--color-primary)] hover:bg-[var(--color-primary-hover)] text-white px-6 py-2 rounded text-sm font-bold transition-colors">
                                Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection