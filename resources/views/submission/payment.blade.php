@extends('layouts.frontend')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
<div class="min-h-screen bg-[#15171A] text-white font-['Outfit'] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Progress Steps -->
        <!-- Progress Steps Desktop -->
        <div class="mb-12 hidden md:block">
            <div class="flex items-center justify-between relative">
                <div class="absolute left-0 top-1/2 w-full h-1 bg-white/5 -z-10 rounded-full"></div>
                
                @foreach(['Submission Type', 'Service Level', 'Card Details', 'Shipping', 'Review', 'Payment'] as $index => $step)
                    <div class="flex flex-col items-center w-24">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm mb-2 transition-all duration-300 relative z-10
                            {{ $index + 1 <= 6 ? 'bg-gradient-to-r from-red-500 to-[#A3050A] shadow-[0_0_15px_rgba(163,5,10,0.4)] scale-110' : 'bg-[#232528] text-gray-500' }}">
                            @if($index + 1 < 6)
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                {{ $index + 1 }}
                            @endif
                        </div>
                        <span class="text-xs font-medium text-center leading-tight mt-1 {{ $index + 1 <= 6 ? 'text-white' : 'text-gray-500' }}">{{ $step }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Mobile Progress Steps (Image Style) -->
        <div class="mb-8 block md:hidden">
            <div class="flex items-start justify-between relative">
                <!-- Background Line -->
                <div class="absolute left-[8.33%] right-[8.33%] top-3 h-[2px] bg-[#232528] -z-10"></div>
                <!-- Active Line -->
                <div class="absolute left-[8.33%] top-3 h-[2px] bg-[#A3050A] -z-10 transition-all duration-300" style="width: {{ (6 - 1) * 20 }}%;"></div>
                
                @foreach(['Type', 'Level', 'Cards', 'Ship', 'Review', 'Pay'] as $index => $step)
                    @php $isCompleted = ($index + 1) < 6; $isActive = ($index + 1) == 6; @endphp
                    <div class="flex flex-col items-center z-10 w-1/6">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center mb-1 transition-all duration-300 bg-[#15171A] 
                            {{ $isCompleted ? 'bg-[#A3050A] text-white shadow-[0_0_10px_rgba(163,5,10,0.5)]' : ($isActive ? 'border-2 border-[#A3050A] text-[#A3050A] p-[2px]' : 'border border-gray-600 text-gray-500') }}">
                            @if($isCompleted)
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @elseif($isActive)
                                <div class="bg-gradient-to-r from-red-500 to-[#A3050A] w-full h-full rounded-full flex items-center justify-center shadow-[0_0_8px_rgba(163,5,10,0.4)] text-[11px] font-bold text-white">
                                    {{ $index + 1 }}
                                </div>
                            @else
                                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                            @endif
                        </div>
                        <span class="text-[7px] uppercase tracking-wider text-gray-500 font-bold mb-0.5">Step {{ $index + 1 }}</span>
                        <span class="text-[8.5px] font-bold text-center leading-tight mb-1 {{ $isActive ? 'text-white' : 'text-gray-400' }}">{{ $step }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-[#232528]/80 backdrop-blur-xl rounded-2xl border border-white/5 p-8 shadow-2xl relative overflow-hidden group">
            <!-- Glassmorphism Background -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-500/10 rounded-full blur-3xl -z-10 transition-all duration-700 group-hover:bg-red-500/15"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-red-900/10 rounded-full blur-3xl -z-10 transition-all duration-700 group-hover:bg-red-900/15"></div>

                            </svg>
                        </span>
                        <div class="absolute inset-0 rounded-xl bg-white/10 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('payment-form').addEventListener('submit', function(e) {
        var submitButton = document.getElementById('submit-button');
        submitButton.disabled = true;
        document.getElementById('button-text').innerText = 'Redirecting...';
    });
</script>
</body>
</html>
