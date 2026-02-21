@extends('layouts.app')

@section('title', __tool('mortgage-calculator', 'meta.title'))
@section('meta_description', __tool('mortgage-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="mortgage-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="principal"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('mortgage-calculator', 'editor.label_principal') }}</label>
                    <input type="number" id="principal" value="300000" min="0" step="1000"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="down-payment"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('mortgage-calculator', 'editor.label_down_payment') }}</label>
                    <input type="number" id="down-payment" value="60000" min="0" step="1000"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="rate"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('mortgage-calculator', 'editor.label_rate') }}</label>
                    <input type="number" id="rate" value="6.5" min="0" max="30" step="0.1"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="term"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('mortgage-calculator', 'editor.label_term') }}</label>
                    <input type="number" id="term" value="30" min="1" max="50"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
            </div>

            <button onclick="calculateMortgage()"
                class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2 mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                {{ __tool('mortgage-calculator', 'editor.btn_calculate') }}
            </button>

            <!-- Results -->
            <div id="mortgage-result" class="hidden">
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-purple-50 rounded-xl p-5 text-center border border-purple-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('mortgage-calculator', 'editor.label_monthly') }}
                        </div>
                        <div class="text-3xl font-black text-purple-700" id="monthly-payment">$0</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-5 text-center border border-blue-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('mortgage-calculator', 'editor.label_total_payment') }}</div>
                        <div class="text-3xl font-black text-blue-700" id="total-payment">$0</div>
                    </div>
                    <div class="bg-pink-50 rounded-xl p-5 text-center border border-pink-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('mortgage-calculator', 'editor.label_total_interest') }}</div>
                        <div class="text-3xl font-black text-pink-700" id="total-interest">$0</div>
                    </div>
                </div>

                <!-- Amortization Table -->
                <h3 class="text-lg font-bold text-gray-800 mb-3">
                    {{ __tool('mortgage-calculator', 'editor.label_schedule') }}</h3>
                <div class="overflow-x-auto max-h-96 overflow-y-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-600 font-semibold">
                                    {{ __tool('mortgage-calculator', 'editor.col_month') }}</th>
                                <th class="px-4 py-3 text-right text-gray-600 font-semibold">
                                    {{ __tool('mortgage-calculator', 'editor.col_payment') }}</th>
                                <th class="px-4 py-3 text-right text-gray-600 font-semibold">
                                    {{ __tool('mortgage-calculator', 'editor.col_principal') }}</th>
                                <th class="px-4 py-3 text-right text-gray-600 font-semibold">
                                    {{ __tool('mortgage-calculator', 'editor.col_interest') }}</th>
                                <th class="px-4 py-3 text-right text-gray-600 font-semibold">
                                    {{ __tool('mortgage-calculator', 'editor.col_balance') }}</th>
                            </tr>
                        </thead>
                        <tbody id="amort-table"></tbody>
                    </table>
                </div>
            </div>
        </div>

        @php $content = __tool('mortgage-calculator', 'content'); @endphp
        @if(is_array($content))
            <div
                class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                <h2 class="text-3xl font-black text-gray-900 mb-3 text-center">{{ $content['what_title'] ?? '' }}</h2>
                <p class="text-gray-600 text-center mx-auto max-w-xl mb-8">{{ $content['what_text'] ?? '' }}</p>

                @if(!empty($content['tips']))
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $content['tips_title'] ?? '' }}</h3>
                    <ul class="space-y-3">
                        @foreach($content['tips'] as $tip)
                            <li class="flex items-start gap-2 text-gray-600">
                                <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $tip }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function fmt(n) { return '$' + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }

            function calculateMortgage() {
                const totalLoan = parseFloat(document.getElementById('principal').value) - parseFloat(document.getElementById('down-payment').value);
                const annualRate = parseFloat(document.getElementById('rate').value) / 100;
                const years = parseInt(document.getElementById('term').value);

                if (totalLoan <= 0 || annualRate < 0 || years <= 0) return;

                const monthlyRate = annualRate / 12;
                const n = years * 12;
                const monthly = monthlyRate > 0
                    ? totalLoan * (monthlyRate * Math.pow(1 + monthlyRate, n)) / (Math.pow(1 + monthlyRate, n) - 1)
                    : totalLoan / n;
                const totalPayment = monthly * n;
                const totalInterest = totalPayment - totalLoan;

                document.getElementById('monthly-payment').innerText = fmt(monthly);
                document.getElementById('total-payment').innerText = fmt(totalPayment);
                document.getElementById('total-interest').innerText = fmt(totalInterest);

                // Amortization (show yearly summary)
                let balance = totalLoan;
                let html = '';
                for (let year = 1; year <= years; year++) {
                    let yearPrincipal = 0, yearInterest = 0;
                    for (let m = 0; m < 12; m++) {
                        const intPmt = balance * monthlyRate;
                        const prinPmt = monthly - intPmt;
                        yearInterest += intPmt;
                        yearPrincipal += prinPmt;
                        balance -= prinPmt;
                    }
                    if (balance < 0) balance = 0;
                    html += `<tr class="border-t border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-700">Year ${year}</td>
                            <td class="px-4 py-2 text-right font-mono">${fmt(monthly * 12)}</td>
                            <td class="px-4 py-2 text-right font-mono text-green-600">${fmt(yearPrincipal)}</td>
                            <td class="px-4 py-2 text-right font-mono text-red-500">${fmt(yearInterest)}</td>
                            <td class="px-4 py-2 text-right font-mono">${fmt(balance)}</td>
                        </tr>`;
                }
                document.getElementById('amort-table').innerHTML = html;
                document.getElementById('mortgage-result').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection