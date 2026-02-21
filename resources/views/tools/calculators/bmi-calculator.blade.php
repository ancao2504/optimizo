@extends('layouts.app')

@section('title', __tool('bmi-calculator', 'meta.title'))
@section('meta_description', __tool('bmi-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="bmi-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            {{-- Unit Toggle --}}
            <div class="flex gap-2 mb-6">
                <button onclick="setUnit('metric')" id="btn-metric"
                    class="px-5 py-2.5 rounded-xl font-semibold transition-all bg-purple-600 text-white">
                    {{ __tool('bmi-calculator', 'editor.unit_metric') }}
                </button>
                <button onclick="setUnit('imperial')" id="btn-imperial"
                    class="px-5 py-2.5 rounded-xl font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                    {{ __tool('bmi-calculator', 'editor.unit_imperial') }}
                </button>
            </div>

            {{-- Metric Inputs --}}
            <div id="inputs-metric" class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="height-cm"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('bmi-calculator', 'editor.label_height_cm') }}</label>
                    <input type="number" id="height-cm" value="170" min="50" max="300"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="weight-kg"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('bmi-calculator', 'editor.label_weight_kg') }}</label>
                    <input type="number" id="weight-kg" value="70" min="10" max="500"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
            </div>

            {{-- Imperial Inputs --}}
            <div id="inputs-imperial" class="hidden grid md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="height-ft"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('bmi-calculator', 'editor.label_height_ft') }}</label>
                    <input type="number" id="height-ft" value="5" min="1" max="8"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="height-in"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('bmi-calculator', 'editor.label_height_in') }}</label>
                    <input type="number" id="height-in" value="7" min="0" max="11"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="weight-lbs"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('bmi-calculator', 'editor.label_weight_lbs') }}</label>
                    <input type="number" id="weight-lbs" value="154" min="20" max="1000"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
            </div>

            <button onclick="calcBMI()"
                class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl mb-6">
                {{ __tool('bmi-calculator', 'editor.btn_calculate') }}
            </button>

            {{-- Result --}}
            <div id="bmi-result" class="hidden">
                <div class="grid md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-purple-50 rounded-xl p-6 text-center border border-purple-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('bmi-calculator', 'editor.label_result') }}</div>
                        <div class="text-5xl font-black text-purple-700" id="bmi-value">0</div>
                    </div>
                    <div class="rounded-xl p-6 text-center border-2" id="bmi-category-card">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('bmi-calculator', 'editor.label_category') }}
                        </div>
                        <div class="text-3xl font-black" id="bmi-category">-</div>
                    </div>
                </div>
                {{-- BMI Scale Bar --}}
                <div class="relative h-8 rounded-full overflow-hidden mb-2">
                    <div class="absolute inset-0 flex">
                        <div class="h-full bg-blue-400" style="width:18.5%"></div>
                        <div class="h-full bg-green-400" style="width:25%"></div>
                        <div class="h-full bg-yellow-400" style="width:20%"></div>
                        <div class="h-full bg-red-400" style="width:36.5%"></div>
                    </div>
                    <div id="bmi-pointer" class="absolute top-0 w-1 h-full bg-gray-900 transition-all duration-500"
                        style="left:50%"></div>
                </div>
                <div class="flex text-xs text-gray-500 mb-1">
                    <span style="width:18.5%" class="text-center">
                        < 18.5</span>
                            <span style="width:25%" class="text-center">18.5-24.9</span>
                            <span style="width:20%" class="text-center">25-29.9</span>
                            <span style="width:36.5%" class="text-center">30+</span>
                </div>
            </div>
        </div>

        {{-- Long-Form SEO Content --}}
        @php $content = __tool('bmi-calculator', 'content'); @endphp
        @if(is_array($content))
            <div class="space-y-8">
                <div
                    class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 text-center">{{ $content['what_title'] ?? '' }}</h2>
                    <p class="text-gray-600 text-lg leading-relaxed text-center mx-auto max-w-3xl">
                        {{ $content['what_text'] ?? '' }}</p>
                </div>

                {{-- BMI Formulas --}}
                @if(!empty($content['formula_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['formula_title'] }}</h2>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="bg-blue-50 rounded-xl p-5 text-center border border-blue-200">
                                <div class="font-mono text-blue-700 font-bold">{{ $content['formula_metric'] ?? '' }}</div>
                            </div>
                            <div class="bg-orange-50 rounded-xl p-5 text-center border border-orange-200">
                                <div class="font-mono text-orange-700 font-bold">{{ $content['formula_imperial'] ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- BMI Categories Detail --}}
                @if(!empty($content['section1_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section1_title'] }}</h2>
                        @if(!empty($content['section1_items']))
                            <div class="space-y-6">
                                @foreach($content['section1_items'] as $item)
                                    <div class="bg-gradient-to-r from-gray-50 to-purple-50 rounded-2xl p-6 border border-gray-100">
                                        <h3 class="font-bold text-purple-700 text-lg mb-2">{{ $item['title'] }}</h3>
                                        <p class="text-gray-600 leading-relaxed">{{ $item['text'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Limitations --}}
                @if(!empty($content['section2_title']))
                    <div
                        class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-3xl p-8 md:p-12 shadow-xl border border-amber-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section2_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $content['section2_text'] ?? '' }}</p>
                    </div>
                @endif

                {{-- Factors --}}
                @if(!empty($content['section3_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section3_title'] }}</h2>
                        @if(!empty($content['section3_items']))
                            <div class="grid md:grid-cols-2 gap-3">
                                @foreach($content['section3_items'] as $factor)
                                    <div class="flex items-start gap-3 bg-purple-50 rounded-xl p-4">
                                        <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700 text-sm">{{ $factor }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                {{-- Tips --}}
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
            let unitMode = 'metric';
            function setUnit(mode) {
                unitMode = mode;
                document.getElementById('inputs-metric').classList.toggle('hidden', mode !== 'metric');
                document.getElementById('inputs-imperial').classList.toggle('hidden', mode !== 'imperial');
                document.getElementById('btn-metric').className = mode === 'metric' ? 'px-5 py-2.5 rounded-xl font-semibold transition-all bg-purple-600 text-white' : 'px-5 py-2.5 rounded-xl font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200';
                document.getElementById('btn-imperial').className = mode === 'imperial' ? 'px-5 py-2.5 rounded-xl font-semibold transition-all bg-purple-600 text-white' : 'px-5 py-2.5 rounded-xl font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200';
            }
            function calcBMI() {
                let bmi;
                if (unitMode === 'metric') {
                    const h = parseFloat(document.getElementById('height-cm').value) / 100;
                    const w = parseFloat(document.getElementById('weight-kg').value);
                    if (!h || !w) return;
                    bmi = w / (h * h);
                } else {
                    const ft = parseFloat(document.getElementById('height-ft').value) || 0;
                    const inches = parseFloat(document.getElementById('height-in').value) || 0;
                    const totalIn = ft * 12 + inches;
                    const lbs = parseFloat(document.getElementById('weight-lbs').value);
                    if (!totalIn || !lbs) return;
                    bmi = (lbs * 703) / (totalIn * totalIn);
                }

                document.getElementById('bmi-value').innerText = bmi.toFixed(1);
                let cat, color, bgClass;
                if (bmi < 18.5) { cat = "{{ __tool('bmi-calculator', 'js.cat_underweight') }}"; color = '#3B82F6'; bgClass = 'bg-blue-50 border-blue-200 text-blue-700'; }
                else if (bmi < 25) { cat = "{{ __tool('bmi-calculator', 'js.cat_normal') }}"; color = '#10B981'; bgClass = 'bg-green-50 border-green-200 text-green-700'; }
                else if (bmi < 30) { cat = "{{ __tool('bmi-calculator', 'js.cat_overweight') }}"; color = '#F59E0B'; bgClass = 'bg-yellow-50 border-yellow-200 text-yellow-700'; }
                else { cat = "{{ __tool('bmi-calculator', 'js.cat_obese') }}"; color = '#EF4444'; bgClass = 'bg-red-50 border-red-200 text-red-700'; }

                document.getElementById('bmi-category').innerText = cat;
                document.getElementById('bmi-category-card').className = 'rounded-xl p-6 text-center border-2 ' + bgClass;
                const pct = Math.min(bmi / 40 * 100, 100);
                document.getElementById('bmi-pointer').style.left = pct + '%';
                document.getElementById('bmi-result').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection