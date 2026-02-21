@extends('layouts.app')

@section('title', __tool('compound-interest-calculator', 'meta.title'))
@section('meta_description', __tool('compound-interest-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="compound-interest-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="ci-principal"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('compound-interest-calculator', 'editor.label_principal') }}</label>
                    <input type="number" id="ci-principal" value="10000" min="0" step="100"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="ci-rate"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('compound-interest-calculator', 'editor.label_rate') }}</label>
                    <input type="number" id="ci-rate" value="7" min="0" max="100" step="0.1"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="ci-time"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('compound-interest-calculator', 'editor.label_time') }}</label>
                    <input type="number" id="ci-time" value="10" min="1" max="50"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="ci-frequency"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('compound-interest-calculator', 'editor.label_frequency') }}</label>
                    <select id="ci-frequency"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                        <option value="1">{{ __tool('compound-interest-calculator', 'editor.freq_annually') }}</option>
                        <option value="2">{{ __tool('compound-interest-calculator', 'editor.freq_semiannually') }}</option>
                        <option value="4">{{ __tool('compound-interest-calculator', 'editor.freq_quarterly') }}</option>
                        <option value="12" selected>{{ __tool('compound-interest-calculator', 'editor.freq_monthly') }}
                        </option>
                        <option value="365">{{ __tool('compound-interest-calculator', 'editor.freq_daily') }}</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label for="ci-contribution"
                    class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('compound-interest-calculator', 'editor.label_contribution') }}</label>
                <input type="number" id="ci-contribution" value="200" min="0" step="50"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
            </div>

            <button onclick="calculateCI()"
                class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2 mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                {{ __tool('compound-interest-calculator', 'editor.btn_calculate') }}
            </button>

            <div id="ci-result" class="hidden">
                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-purple-50 rounded-xl p-5 text-center border border-purple-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('compound-interest-calculator', 'editor.label_future_value') }}</div>
                        <div class="text-3xl font-black text-purple-700" id="ci-future">$0</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-5 text-center border border-green-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('compound-interest-calculator', 'editor.label_total_interest') }}</div>
                        <div class="text-3xl font-black text-green-700" id="ci-interest">$0</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-5 text-center border border-blue-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('compound-interest-calculator', 'editor.label_total_deposits') }}</div>
                        <div class="text-3xl font-black text-blue-700" id="ci-deposits">$0</div>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-gray-800 mb-3">
                    {{ __tool('compound-interest-calculator', 'editor.label_breakdown') }}</h3>
                <div class="overflow-x-auto max-h-96 overflow-y-auto rounded-xl border border-gray-200">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-600 font-semibold">
                                    {{ __tool('compound-interest-calculator', 'editor.col_year') }}</th>
                                <th class="px-4 py-3 text-right text-gray-600 font-semibold">
                                    {{ __tool('compound-interest-calculator', 'editor.col_deposits') }}</th>
                                <th class="px-4 py-3 text-right text-gray-600 font-semibold">
                                    {{ __tool('compound-interest-calculator', 'editor.col_interest') }}</th>
                                <th class="px-4 py-3 text-right text-gray-600 font-semibold">
                                    {{ __tool('compound-interest-calculator', 'editor.col_balance') }}</th>
                            </tr>
                        </thead>
                        <tbody id="ci-table"></tbody>
                    </table>
                </div>
            </div>
        </div>

        @php $content = __tool('compound-interest-calculator', 'content'); @endphp
        @if(is_array($content))
            <div
                class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                <h2 class="text-3xl font-black text-gray-900 mb-3 text-center">{{ $content['what_title'] ?? '' }}</h2>
                <p class="text-gray-600 text-center mx-auto max-w-xl mb-8">{{ $content['what_text'] ?? '' }}</p>

                <div class="text-center bg-white rounded-xl p-4 shadow-md mb-6">
                    <div class="font-bold text-gray-700">{{ $content['formula_title'] ?? '' }}</div>
                    <div class="text-gray-600 font-mono mt-1">{{ $content['formula_text'] ?? '' }}</div>
                </div>

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

            function calculateCI() {
                const P = parseFloat(document.getElementById('ci-principal').value);
                const r = parseFloat(document.getElementById('ci-rate').value) / 100;
                const t = parseInt(document.getElementById('ci-time').value);
                const n = parseInt(document.getElementById('ci-frequency').value);
                const monthly = parseFloat(document.getElementById('ci-contribution').value) || 0;

                if (P < 0 || r < 0 || t <= 0) return;

                let balance = P;
                let totalDeposits = P;
                let html = '';

                for (let year = 1; year <= t; year++) {
                    let yearDeposit = 0;
                    for (let period = 0; period < n; period++) {
                        balance *= (1 + r / n);
                        const monthsInPeriod = 12 / n;
                        const contribution = monthly * monthsInPeriod;
                        balance += contribution;
                        yearDeposit += contribution;
                    }
                    totalDeposits += yearDeposit;
                    const totalInterest = balance - totalDeposits;

                    html += `<tr class="border-t border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-700">${year}</td>
                            <td class="px-4 py-2 text-right font-mono text-blue-600">${fmt(totalDeposits)}</td>
                            <td class="px-4 py-2 text-right font-mono text-green-600">${fmt(totalInterest)}</td>
                            <td class="px-4 py-2 text-right font-mono font-bold">${fmt(balance)}</td>
                        </tr>`;
                }

                const totalInterest = balance - totalDeposits;
                document.getElementById('ci-future').innerText = fmt(balance);
                document.getElementById('ci-interest').innerText = fmt(totalInterest);
                document.getElementById('ci-deposits').innerText = fmt(totalDeposits);
                document.getElementById('ci-table').innerHTML = html;
                document.getElementById('ci-result').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection