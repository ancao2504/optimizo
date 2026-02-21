@extends('layouts.app')

@section('title', __tool('percentage-calculator', 'meta.title'))
@section('meta_description', __tool('percentage-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="percentage-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <!-- Tabs -->
            <div class="flex flex-wrap gap-2 mb-6">
                <button onclick="switchTab('basic')" id="tab-basic"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-purple-600 text-white shadow-lg">
                    {{ __tool('percentage-calculator', 'editor.tab_basic') }}
                </button>
                <button onclick="switchTab('increase')" id="tab-increase"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                    {{ __tool('percentage-calculator', 'editor.tab_increase') }}
                </button>
                <button onclick="switchTab('whatpercent')" id="tab-whatpercent"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                    {{ __tool('percentage-calculator', 'editor.tab_what_percent') }}
                </button>
            </div>

            <!-- Basic Percentage -->
            <div id="panel-basic">
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="basic-percentage"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_percentage') }}</label>
                        <input type="number" id="basic-percentage" value="25" step="any"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="basic-value"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_value') }}</label>
                        <input type="number" id="basic-value" value="200" step="any"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                </div>
                <button onclick="calcBasic()"
                    class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    {{ __tool('percentage-calculator', 'editor.btn_calculate') }}
                </button>
                <div id="result-basic"
                    class="w-full px-4 py-6 border-2 border-gray-200 rounded-xl bg-gray-50 text-3xl font-mono text-center min-h-[80px] flex items-center justify-center">
                    50</div>
            </div>

            <!-- Percentage Increase/Decrease -->
            <div id="panel-increase" class="hidden">
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="inc-from"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_from') }}</label>
                        <input type="number" id="inc-from" value="100" step="any"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="inc-to"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_to') }}</label>
                        <input type="number" id="inc-to" value="150" step="any"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                </div>
                <button onclick="calcIncrease()"
                    class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    {{ __tool('percentage-calculator', 'editor.btn_calculate') }}
                </button>
                <div id="result-increase"
                    class="w-full px-4 py-6 border-2 border-gray-200 rounded-xl bg-gray-50 text-3xl font-mono text-center min-h-[80px] flex items-center justify-center">
                    50%</div>
            </div>

            <!-- What % is X of Y -->
            <div id="panel-whatpercent" class="hidden">
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="wp-x"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_x') }}</label>
                        <input type="number" id="wp-x" value="30" step="any"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="wp-y"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_y') }}</label>
                        <input type="number" id="wp-y" value="200" step="any"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                </div>
                <button onclick="calcWhatPercent()"
                    class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2 mb-6">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    {{ __tool('percentage-calculator', 'editor.btn_calculate') }}
                </button>
                <div id="result-whatpercent"
                    class="w-full px-4 py-6 border-2 border-gray-200 rounded-xl bg-gray-50 text-3xl font-mono text-center min-h-[80px] flex items-center justify-center">
                    15%</div>
            </div>
        </div>

        @php $content = __tool('percentage-calculator', 'content'); @endphp
        @if(is_array($content))
            <div
                class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                <h2 class="text-3xl font-black text-gray-900 mb-3 text-center">{{ $content['what_title'] ?? '' }}</h2>
                <p class="text-gray-600 text-center mx-auto max-w-xl mb-8">{{ $content['what_text'] ?? '' }}</p>

                @if(!empty($content['how_steps']))
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $content['how_title'] ?? '' }}</h3>
                    <ol class="list-decimal list-inside space-y-2 mb-8 text-gray-600">
                        @foreach($content['how_steps'] as $step)
                            <li>{{ $step }}</li>
                        @endforeach
                    </ol>
                @endif

                @if(!empty($content['examples']))
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $content['examples_title'] ?? '' }}</h3>
                    <div class="grid md:grid-cols-3 gap-4">
                        @foreach($content['examples'] as $ex)
                            <div class="bg-white rounded-xl p-4 shadow-md">
                                <div class="font-semibold text-purple-700 mb-1">{{ $ex['label'] }}</div>
                                <div class="text-gray-600 text-sm">{{ $ex['desc'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function switchTab(tab) {
                document.querySelectorAll('[id^="panel-"]').forEach(p => p.classList.add('hidden'));
                document.querySelectorAll('[id^="tab-"]').forEach(t => {
                    t.className = 'px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-gray-100 text-gray-600 hover:bg-gray-200';
                });
                document.getElementById('panel-' + tab).classList.remove('hidden');
                document.getElementById('tab-' + tab).className = 'px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-purple-600 text-white shadow-lg';
            }

            function calcBasic() {
                const pct = parseFloat(document.getElementById('basic-percentage').value);
                const val = parseFloat(document.getElementById('basic-value').value);
                if (isNaN(pct) || isNaN(val)) { document.getElementById('result-basic').innerText = "{{ __tool('percentage-calculator', 'js.error_invalid') }}"; return; }
                document.getElementById('result-basic').innerHTML = `<span class="text-purple-600">${(pct / 100 * val).toFixed(4).replace(/\.?0+$/, '')}</span>`;
            }

            function calcIncrease() {
                const from = parseFloat(document.getElementById('inc-from').value);
                const to = parseFloat(document.getElementById('inc-to').value);
                if (isNaN(from) || isNaN(to) || from === 0) { document.getElementById('result-increase').innerText = "{{ __tool('percentage-calculator', 'js.error_zero') }}"; return; }
                const change = ((to - from) / Math.abs(from) * 100).toFixed(2);
                const sign = change >= 0 ? '+' : '';
                document.getElementById('result-increase').innerHTML = `<span class="${change >= 0 ? 'text-green-600' : 'text-red-600'}">${sign}${change}%</span>`;
            }

            function calcWhatPercent() {
                const x = parseFloat(document.getElementById('wp-x').value);
                const y = parseFloat(document.getElementById('wp-y').value);
                if (isNaN(x) || isNaN(y) || y === 0) { document.getElementById('result-whatpercent').innerText = "{{ __tool('percentage-calculator', 'js.error_zero') }}"; return; }
                document.getElementById('result-whatpercent').innerHTML = `<span class="text-purple-600">${(x / y * 100).toFixed(4).replace(/\.?0+$/, '')}%</span>`;
            }
        </script>
    @endpush
@endsection