@extends('layouts.app')

@section('title', __tool('scientific-calculator', 'meta.title'))
@section('meta_description', __tool('scientific-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="scientific-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            {{-- Display --}}
            <div class="bg-gray-900 rounded-xl p-4 mb-4">
                <div class="text-right text-gray-400 text-sm h-6" id="sci-history"></div>
                <div class="text-right text-white text-4xl font-mono font-bold overflow-x-auto" id="sci-display">0</div>
                <div class="text-right text-purple-400 text-xs mt-1" id="sci-mode">DEG</div>
            </div>

            {{-- Memory & Mode --}}
            <div class="flex flex-wrap gap-2 mb-3">
                <button onclick="sciMC()"
                    class="px-3 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-semibold hover:bg-red-100 transition-all">MC</button>
                <button onclick="sciMR()"
                    class="px-3 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm font-semibold hover:bg-blue-100 transition-all">MR</button>
                <button onclick="sciMAdd()"
                    class="px-3 py-2 bg-green-50 text-green-600 rounded-lg text-sm font-semibold hover:bg-green-100 transition-all">M+</button>
                <button onclick="sciMSub()"
                    class="px-3 py-2 bg-yellow-50 text-yellow-600 rounded-lg text-sm font-semibold hover:bg-yellow-100 transition-all">M-</button>
                <button onclick="toggleDegRad()"
                    class="px-3 py-2 bg-purple-50 text-purple-600 rounded-lg text-sm font-semibold hover:bg-purple-100 transition-all"
                    id="btn-deg-rad">DEG</button>
            </div>

            {{-- Scientific Functions --}}
            <div class="grid grid-cols-5 gap-2 mb-3">
                <button onclick="sciFunc('sin')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">sin</button>
                <button onclick="sciFunc('cos')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">cos</button>
                <button onclick="sciFunc('tan')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">tan</button>
                <button onclick="sciFunc('log')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">log</button>
                <button onclick="sciFunc('ln')" class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">ln</button>
                <button onclick="sciFunc('asin')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">sin⁻¹</button>
                <button onclick="sciFunc('acos')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">cos⁻¹</button>
                <button onclick="sciFunc('atan')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">tan⁻¹</button>
                <button onclick="sciFunc('sqrt')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">√</button>
                <button onclick="sciFunc('fact')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">n!</button>
                <button onclick="sciAppend('Math.PI')"
                    class="sci-btn bg-orange-50 text-orange-700 hover:bg-orange-100">π</button>
                <button onclick="sciAppend('Math.E')"
                    class="sci-btn bg-orange-50 text-orange-700 hover:bg-orange-100">e</button>
                <button onclick="sciPow(2)" class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">x²</button>
                <button onclick="sciPow(3)" class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">x³</button>
                <button onclick="sciAppend('**')"
                    class="sci-btn bg-indigo-50 text-indigo-700 hover:bg-indigo-100">xⁿ</button>
            </div>

            {{-- Number Pad --}}
            <div class="grid grid-cols-4 gap-2">
                <button onclick="sciClear()" class="sci-btn bg-red-100 text-red-700 hover:bg-red-200">C</button>
                <button onclick="sciAppend('(')" class="sci-btn bg-gray-100 text-gray-700 hover:bg-gray-200">(</button>
                <button onclick="sciAppend(')')" class="sci-btn bg-gray-100 text-gray-700 hover:bg-gray-200">)</button>
                <button onclick="sciAppend('/')"
                    class="sci-btn bg-purple-100 text-purple-700 hover:bg-purple-200">÷</button>
                @foreach([7, 8, 9] as $n)<button onclick="sciAppend('{{ $n }}')"
                class="sci-btn bg-white text-gray-800 hover:bg-gray-50 border border-gray-200">{{ $n }}</button>@endforeach
                <button onclick="sciAppend('*')"
                    class="sci-btn bg-purple-100 text-purple-700 hover:bg-purple-200">×</button>
                @foreach([4, 5, 6] as $n)<button onclick="sciAppend('{{ $n }}')"
                class="sci-btn bg-white text-gray-800 hover:bg-gray-50 border border-gray-200">{{ $n }}</button>@endforeach
                <button onclick="sciAppend('-')"
                    class="sci-btn bg-purple-100 text-purple-700 hover:bg-purple-200">−</button>
                @foreach([1, 2, 3] as $n)<button onclick="sciAppend('{{ $n }}')"
                class="sci-btn bg-white text-gray-800 hover:bg-gray-50 border border-gray-200">{{ $n }}</button>@endforeach
                <button onclick="sciAppend('+')"
                    class="sci-btn bg-purple-100 text-purple-700 hover:bg-purple-200">+</button>
                <button onclick="sciBackspace()" class="sci-btn bg-gray-100 text-gray-700 hover:bg-gray-200">⌫</button>
                <button onclick="sciAppend('0')"
                    class="sci-btn bg-white text-gray-800 hover:bg-gray-50 border border-gray-200">0</button>
                <button onclick="sciAppend('.')"
                    class="sci-btn bg-white text-gray-800 hover:bg-gray-50 border border-gray-200">.</button>
                <button onclick="sciEval()" class="sci-btn bg-purple-600 text-white hover:bg-purple-700">=</button>
            </div>
        </div>

        {{-- Long-Form SEO Content --}}
        @php $content = __tool('scientific-calculator', 'content'); @endphp
        @if(is_array($content))
            <div class="space-y-8">
                <div
                    class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 text-center">{{ $content['what_title'] ?? '' }}</h2>
                    <p class="text-gray-600 text-lg leading-relaxed text-center mx-auto max-w-3xl">
                        {{ $content['what_text'] ?? '' }}</p>
                </div>

                @if(!empty($content['features_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['features_title'] }}</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($content['features'] ?? [] as $feat)
                                <div class="flex items-start gap-3 bg-indigo-50 rounded-xl p-4">
                                    <svg class="w-5 h-5 text-indigo-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-gray-700 text-sm">{{ $feat }}</span>
                                </div>
                            @endforeach
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
                    <div
                        class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl p-8 md:p-12 shadow-xl border border-indigo-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section2_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $content['section2_text'] ?? '' }}</p>
                    </div>
                @endif

                @if(!empty($content['section3_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section3_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed mb-6">{{ $content['section3_text'] ?? '' }}</p>
                    </div>
                @endif

                @if(!empty($content['section4_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section4_title'] }}</h2>
                        @if(!empty($content['section4_items']))
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($content['section4_items'] as $item)
                                    <div
                                        class="bg-gradient-to-br from-gray-50 to-indigo-50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-shadow">
                                        <h3 class="font-bold text-indigo-700 text-lg mb-2">{{ $item['title'] }}</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $item['text'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($content['section5_title']))
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 md:p-12 shadow-xl border border-green-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section5_title'] }}</h2>
                        @if(!empty($content['section5_items']))
                            <div class="space-y-3">
                                @foreach($content['section5_items'] as $tip)
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

    <style>
        .sci-btn {
            padding: .75rem;
            border-radius: .75rem;
            font-weight: 600;
            font-size: .95rem;
            transition: all .15s;
            text-align: center
        }
    </style>

    @push('scripts')
        <script>
            let expr = '', memory = 0, degMode = true;
            const disp = () => document.getElementById('sci-display');
            const hist = () => document.getElementById('sci-history');

            function sciAppend(v) { if (expr === '0' && v !== '.') expr = ''; expr += v; disp().innerText = expr || '0'; }
            function sciClear() { expr = ''; disp().innerText = '0'; hist().innerText = ''; }
            function sciBackspace() { expr = expr.slice(0, -1); disp().innerText = expr || '0'; }

            function sciEval() {
                try {
                    let e = expr.replace(/π/g, 'Math.PI').replace(/e(?![x])/g, 'Math.E');
                    const result = Function('"use strict";return (' + e + ')')();
                    hist().innerText = expr + ' =';
                    expr = String(result);
                    disp().innerText = expr;
                } catch { disp().innerText = "{{ __tool('scientific-calculator', 'js.error_invalid') }}"; expr = ''; }
            }

            function sciFunc(fn) {
                const v = parseFloat(expr) || 0;
                let r;
                const toRad = (d) => degMode ? d * Math.PI / 180 : d;
                const fromRad = (d) => degMode ? d * 180 / Math.PI : d;
                switch (fn) {
                    case 'sin': r = Math.sin(toRad(v)); break;
                    case 'cos': r = Math.cos(toRad(v)); break;
                    case 'tan': r = Math.tan(toRad(v)); break;
                    case 'asin': r = fromRad(Math.asin(v)); break;
                    case 'acos': r = fromRad(Math.acos(v)); break;
                    case 'atan': r = fromRad(Math.atan(v)); break;
                    case 'log': r = Math.log10(v); break;
                    case 'ln': r = Math.log(v); break;
                    case 'sqrt': r = Math.sqrt(v); break;
                    case 'fact': r = factorial(v); break;
                }
                hist().innerText = fn + '(' + v + ') =';
                expr = String(r);
                disp().innerText = expr;
            }

            function factorial(n) { if (n < 0 || n > 170) return NaN; if (n <= 1) return 1; let r = 1; for (let i = 2; i <= n; i++) r *= i; return r; }
            function sciPow(p) { const v = parseFloat(expr) || 0; hist().innerText = v + '^' + p + ' ='; expr = String(Math.pow(v, p)); disp().innerText = expr; }
            function sciMC() { memory = 0; }
            function sciMR() { expr = String(memory); disp().innerText = expr; }
            function sciMAdd() { memory += parseFloat(expr) || 0; }
            function sciMSub() { memory -= parseFloat(expr) || 0; }
            function toggleDegRad() { degMode = !degMode; document.getElementById('sci-mode').innerText = degMode ? 'DEG' : 'RAD'; document.getElementById('btn-deg-rad').innerText = degMode ? 'DEG' : 'RAD'; }

            document.addEventListener('keydown', (e) => {
                if (e.key >= '0' && e.key <= '9' || '+-*/.()'.includes(e.key)) sciAppend(e.key);
                else if (e.key === 'Enter') sciEval();
                else if (e.key === 'Backspace') sciBackspace();
                else if (e.key === 'Escape') sciClear();
            });
        </script>
    @endpush
@endsection