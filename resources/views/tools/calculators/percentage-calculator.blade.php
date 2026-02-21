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
                    class="tab-btn px-5 py-2.5 rounded-xl font-semibold transition-all bg-purple-600 text-white">
                    {{ __tool('percentage-calculator', 'editor.tab_basic') }}
                </button>
                <button onclick="switchTab('change')" id="tab-change"
                    class="tab-btn px-5 py-2.5 rounded-xl font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                    {{ __tool('percentage-calculator', 'editor.tab_increase') }}
                </button>
                <button onclick="switchTab('whatpct')" id="tab-whatpct"
                    class="tab-btn px-5 py-2.5 rounded-xl font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                    {{ __tool('percentage-calculator', 'editor.tab_what_percent') }}
                </button>
            </div>

            <!-- Basic Percentage -->
            <div id="panel-basic" class="tab-panel">
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="pct-value"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_value') }}</label>
                        <input type="number" id="pct-value" value="200"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="pct-percent"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_percentage') }}</label>
                        <input type="number" id="pct-percent" value="25"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                </div>
                <button onclick="calcBasic()"
                    class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl mb-4">
                    {{ __tool('percentage-calculator', 'editor.btn_calculate') }}
                </button>
                <div id="result-basic" class="bg-purple-50 rounded-xl p-5 text-center border border-purple-200 hidden">
                    <span class="text-sm text-gray-500" id="result-basic-label"></span>
                    <div class="text-4xl font-black text-purple-700" id="result-basic-val">0</div>
                </div>
            </div>

            <!-- Percentage Change -->
            <div id="panel-change" class="tab-panel hidden">
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="pct-from"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_from') }}</label>
                        <input type="number" id="pct-from" value="50"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="pct-to"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_to') }}</label>
                        <input type="number" id="pct-to" value="65"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                </div>
                <button onclick="calcChange()"
                    class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl mb-4">
                    {{ __tool('percentage-calculator', 'editor.btn_calculate') }}
                </button>
                <div id="result-change" class="bg-green-50 rounded-xl p-5 text-center border border-green-200 hidden">
                    <span
                        class="text-sm text-gray-500">{{ __tool('percentage-calculator', 'editor.result_increase') }}</span>
                    <div class="text-4xl font-black text-green-700" id="result-change-val">0%</div>
                </div>
            </div>

            <!-- What Percent -->
            <div id="panel-whatpct" class="tab-panel hidden">
                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="pct-x"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_x') }}</label>
                        <input type="number" id="pct-x" value="15"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                    <div>
                        <label for="pct-y"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('percentage-calculator', 'editor.label_y') }}</label>
                        <input type="number" id="pct-y" value="75"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>
                </div>
                <button onclick="calcWhatPct()"
                    class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl mb-4">
                    {{ __tool('percentage-calculator', 'editor.btn_calculate') }}
                </button>
                <div id="result-whatpct" class="bg-blue-50 rounded-xl p-5 text-center border border-blue-200 hidden">
                    <span class="text-sm text-gray-500" id="result-whatpct-label"></span>
                    <div class="text-4xl font-black text-blue-700" id="result-whatpct-val">0%</div>
                </div>
            </div>
        </div>

        {{-- Long-Form SEO Content --}}
        @php $content = __tool('percentage-calculator', 'content'); @endphp
        @if(is_array($content))
            <div class="space-y-8">
                {{-- Section: What is a Percentage --}}
                <div
                    class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 text-center">{{ $content['what_title'] ?? '' }}</h2>
                    <p class="text-gray-600 text-lg leading-relaxed text-center mx-auto max-w-3xl">
                        {{ $content['what_text'] ?? '' }}</p>
                </div>

                {{-- Section: How to Use --}}
                @if(!empty($content['how_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">{{ $content['how_title'] }}</h2>
                        @if(!empty($content['how_text']))
                            <p class="text-gray-600 mb-6">{{ $content['how_text'] }}</p>
                        @endif
                        @if(!empty($content['how_steps']))
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($content['how_steps'] as $i => $step)
                                    <div class="flex items-start gap-3 bg-purple-50 rounded-xl p-4">
                                        <span
                                            class="flex-shrink-0 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold">{{ $i + 1 }}</span>
                                        <span class="text-gray-700">{{ $step }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Section 1: Understanding Percentage Calculations --}}
                @if(!empty($content['section1_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section1_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $content['section1_text'] ?? '' }}</p>
                    </div>
                @endif

                {{-- Section 2: Formula --}}
                @if(!empty($content['section2_title']))
                    <div
                        class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl p-8 md:p-12 shadow-xl border border-indigo-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section2_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $content['section2_text'] ?? '' }}</p>
                    </div>
                @endif

                {{-- Section 3: Common Uses --}}
                @if(!empty($content['section3_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section3_title'] }}</h2>
                        @if(!empty($content['section3_items']))
                            <div class="grid md:grid-cols-2 gap-6">
                                @foreach($content['section3_items'] as $item)
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

                {{-- Section 4: Tips --}}
                @if(!empty($content['section4_title']))
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 md:p-12 shadow-xl border border-green-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section4_title'] }}</h2>
                        @if(!empty($content['section4_items']))
                            <div class="space-y-3">
                                @foreach($content['section4_items'] as $tip)
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

                {{-- Examples --}}
                @if(!empty($content['examples_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['examples_title'] }}</h2>
                        @if(!empty($content['examples']))
                            <div class="grid md:grid-cols-2 gap-4">
                                @foreach($content['examples'] as $ex)
                                    <div class="bg-purple-50 rounded-xl p-5 border border-purple-100">
                                        <div class="font-bold text-purple-700 mb-1">{{ $ex['label'] }}</div>
                                        <div class="text-gray-600 text-sm">{{ $ex['desc'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                {{-- FAQ --}}
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
            function switchTab(tab) {
                document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
                document.querySelectorAll('.tab-btn').forEach(b => { b.classList.remove('bg-purple-600', 'text-white'); b.classList.add('bg-gray-100', 'text-gray-600'); });
                document.getElementById('panel-' + tab).classList.remove('hidden');
                const btn = document.getElementById('tab-' + tab);
                btn.classList.remove('bg-gray-100', 'text-gray-600');
                btn.classList.add('bg-purple-600', 'text-white');
            }
            function calcBasic() {
                const v = parseFloat(document.getElementById('pct-value').value);
                const p = parseFloat(document.getElementById('pct-percent').value);
                if (isNaN(v) || isNaN(p)) return;
                const result = v * (p / 100);
                document.getElementById('result-basic-val').innerText = parseFloat(result.toPrecision(10));
                document.getElementById('result-basic-label').innerText = p + '% ' + "{{ __tool('percentage-calculator', 'editor.result_percent_of') }}" + ' ' + v + ' ' + "{{ __tool('percentage-calculator', 'editor.result_is') }}";
                document.getElementById('result-basic').classList.remove('hidden');
            }
            function calcChange() {
                const from = parseFloat(document.getElementById('pct-from').value);
                const to = parseFloat(document.getElementById('pct-to').value);
                if (isNaN(from) || isNaN(to) || from === 0) return;
                const change = ((to - from) / Math.abs(from)) * 100;
                document.getElementById('result-change-val').innerText = parseFloat(change.toPrecision(10)) + '%';
                document.getElementById('result-change').classList.remove('hidden');
            }
            function calcWhatPct() {
                const x = parseFloat(document.getElementById('pct-x').value);
                const y = parseFloat(document.getElementById('pct-y').value);
                if (isNaN(x) || isNaN(y) || y === 0) return;
                const pct = (x / y) * 100;
                document.getElementById('result-whatpct-val').innerText = parseFloat(pct.toPrecision(10)) + '%';
                document.getElementById('result-whatpct-label').innerText = x + ' ' + "{{ __tool('percentage-calculator', 'editor.result_what_percent') }}" + ' ' + y;
                document.getElementById('result-whatpct').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection