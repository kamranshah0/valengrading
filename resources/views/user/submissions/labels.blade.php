@extends('layouts.frontend')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
<div class="min-h-screen bg-[#15171A] text-white font-['Outfit'] py-12 px-4 sm:px-6 lg:px-8" x-data="labelSelection()">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-red-400 to-[#A3050A] mb-2">Select Your Labels</h1>
            <p class="text-gray-400">Your cards for submission #{{ $submission->submission_no }} have been graded! Please select the label style for each card before we encapsulate them.</p>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-xl font-medium">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('user.submissions.process_labels', $submission->id) }}" method="POST">
            @csrf
            
            <div class="bg-[#232528]/80 backdrop-blur-xl rounded-2xl border border-white/5 shadow-2xl overflow-hidden mb-8">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-400">
                        <thead class="text-xs text-gray-300 uppercase bg-[#15171A] border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4">Card Details</th>
                                <th class="px-6 py-4">Grade</th>
                                <th class="px-6 py-4 w-[280px]">Select Label Type</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($submission->cards as $card)
                                <tr class="bg-[#15171A]/30 hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white mb-1">{{ $card->title }}</div>
                                        <div class="text-xs text-gray-500">
                                            @if($card->set_name) Set: {{ $card->set_name }} &bull; @endif
                                            @if($card->year) Year: {{ $card->year }} &bull; @endif
                                            @if($card->card_number) #: {{ $card->card_number }} @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-white">
                                        {{ $card->grade ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <select name="cards[{{ $card->id }}][label_type_id]" 
                                                class="w-full bg-[#15171A] border border-white/10 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:ring-1 focus:ring-red-500 appearance-none cursor-pointer label-select" 
                                                required
                                                @change="calculateTotal">
                                            <option value="" disabled selected>Select a Label...</option>
                                            @foreach($labelTypes as $type)
                                                <option value="{{ $type->id }}" data-price="{{ max(0, $type->price_adjustment) }}">
                                                    {{ $type->name }} ({{ $type->price_adjustment == 0 ? 'Free' : '+£' . number_format(max(0, $type->price_adjustment), 2) }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sticky Bottom Bar -->
            <div class="sticky bottom-6 bg-[#232528] rounded-2xl border border-white/10 p-6 flex flex-col sm:flex-row justify-between items-center gap-4 shadow-2xl shadow-black/50 z-50">
                <div>
                    <div class="text-gray-400 text-sm mb-1">Total Label Upgrade Cost</div>
                    <div class="text-2xl font-bold text-white" x-text="'£' + totalCost.toFixed(2)">£0.00</div>
                </div>
                
                <button type="submit" 
                        class="px-8 py-3 rounded-xl bg-gradient-to-r from-red-600 to-[#A3050A] text-white font-bold shadow-[0_0_20px_rgba(163,5,10,0.3)] hover:shadow-[0_0_30px_rgba(163,5,10,0.5)] hover:scale-[1.02] transition-all duration-300 w-full sm:w-auto text-center"
                        :class="{'opacity-50 cursor-not-allowed': !allSelected}"
                        :disabled="!allSelected">
                    <span x-text="totalCost > 0 ? 'Pay & Confirm Labels' : 'Confirm Labels (Free)'">Confirm Labels</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('labelSelection', () => ({
            totalCost: 0,
            allSelected: false,
            
            init() {
                this.calculateTotal();
            },
            
            calculateTotal() {
                let sum = 0;
                let selects = document.querySelectorAll('.label-select');
                let allFilled = true;
                
                selects.forEach(select => {
                    if (!select.value) {
                        allFilled = false;
                    } else {
                        let price = parseFloat(select.options[select.selectedIndex].getAttribute('data-price')) || 0;
                        sum += price;
                    }
                });
                
                this.totalCost = sum;
                this.allSelected = allFilled;
            }
        }));
    });
</script>
@endsection
