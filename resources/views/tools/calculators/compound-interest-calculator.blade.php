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
                    <input type="number" id="ci-time" value="10" min="1" max="100"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="ci-freq"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('compound-interest-calculator', 'editor.label_frequency') }}</label>
                    <select id="ci-freq"
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
                <label for="ci-contrib"
                    class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('compound-interest-calculator', 'editor.label_contribution') }}</label>
                <input type="number" id="ci-contrib" value="200" min="0" step="50"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
            </div>

            <button onclick="calcCI()"
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

        {{-- Long-Form SEO Content --}}
        @php $content = __tool('compound-interest-calculator', 'content'); @endphp
        @if(is_array($content))
            <div class="space-y-8">
                <div
                    class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 text-center">{{ $content['what_title'] ?? '' }}</h2>
                    <p class="text-gray-600 text-lg leading-relaxed text-center mx-auto max-w-3xl">
                        {{ $content['what_text'] ?? '' }}</p>
                </div>

                @if(!empty($content['formula_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['formula_title'] }}</h2>
                        <div class="bg-indigo-50 rounded-xl p-5 text-center border border-indigo-200">
                            <div class="font-mono text-indigo-700 font-bold">{{ $content['formula_text'] ?? '' }}</div>
                        </div>
                    </div>
                @endif

                @if(!empty($content['section1_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section1_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $content['section1_text'] ?? '' }}</p>
                    </div>
                @endif

                @if(!empty($content['section2_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section2_title'] }}</h2>
                        @if(!empty($content['section2_items']))
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($content['section2_items'] as $item)
                                    <div
                                        class="bg-gradient-to-br from-gray-50 to-purple-50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-shadow">
                                        <h3 class="font-bold text-purple-700 text-lg mb-2">{{ $item['title'] }}</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $item['text'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($content['section3_title']))
                    <div
                        class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl p-8 md:p-12 shadow-xl border border-indigo-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section3_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $content['section3_text'] ?? '' }}</p>
                    </div>
                @endif

                @if(!empty($content['section4_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section4_title'] }}</h2>
                        @if(!empty($content['section4_items']))
                            <div class="grid md:grid-cols-2 gap-6">
                                @foreach($content['section4_items'] as $item)
                                    <div
                                        class="bg-gradient-to-br from-gray-50 to-green-50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-shadow">
                                        <h3 class="font-bold text-green-700 text-lg mb-2">{{ $item['title'] }}</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $item['text'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($content['tips_title']))
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 md:p-12 shadow-xl border border-green-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['tips_title'] }}</h2>
                        @if(!empty($content['tips']))
                            <div class="space-y-3">
                                @foreach($content['tips'] as $tip)
                                    <div class="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm">
                                        <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700 text-sm">{{ $tip }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($content['faq_title']))
                    <div
                        class="bg-gradient-to-br from-gray-50 to-purple-50 rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ $content['faq_title'] }}</h2>
                        @if(!empty($content['faqs']))
                            <div class="space-y-4 max-w-3xl mx-auto">
                                @foreach($content['faqs'] as $faq)
                                    <details class="bg-white rounded-xl shadow-sm border border-gray-200 group">
                                        <summary
                                            class="cursor-pointer px-6 py-4 font-semibold text-gray-800 flex justify-between items-center">
                                            {{ $faq['q'] }}
                                            <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition-transform flex-shrink-0"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </summary>
                                        <div class="px-6 pb-4 text-gray-600 text-sm leading-relaxed">{{ $faq['a'] }}</div>
                                    </details>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function fmt(n) { return '$' + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }); }

            function calcCI() {
                const P = parseFloat(document.getElementById('ci-principal').value) || 0;
                const r = parseFloat(document.getElementById('ci-rate').value) / 100;
                const t = parseInt(document.getElementById('ci-time').value) || 0;
                const n = parseInt(document.getElementById('ci-freq').value);
                const monthly = parseFloat(document.getElementById('ci-contrib').value) || 0;

                if (r <= 0 || t <= 0) return;

                let balance = P, totalDeposits = P, html = '';

                for (let y = 1; y <= t; y++) {
                    const yearContrib = monthly * 12;
                    for (let period = 0; period < n; period++) {
                        balance += balance * (r / n);
                        balance += (yearContrib / n);
                    }
                    totalDeposits += yearContrib;
                    const interest = balance - totalDeposits;
                    html += `<tr class="border-t border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-2 text-gray-700">${y}</td>
                            <td class="px-4 py-2 text-right font-mono text-blue-600">${fmt(totalDeposits)}</td>
                            <td class="px-4 py-2 text-right font-mono text-green-600">${fmt(interest)}</td>
                            <td class="px-4 py-2 text-right font-mono font-bold">${fmt(balance)}</td>
                        </tr>`;
                }

                document.getElementById('ci-future').innerText = fmt(balance);
                document.getElementById('ci-interest').innerText = fmt(balance - totalDeposits);
                document.getElementById('ci-deposits').innerText = fmt(totalDeposits);
                document.getElementById('ci-table').innerHTML = html;
                document.getElementById('ci-result').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection