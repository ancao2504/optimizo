@extends('layouts.app')

@section('title', __tool('bmi-calculator', 'meta.title'))
@section('meta_description', __tool('bmi-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="bmi-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <!-- Unit Toggle -->
            <div class="flex gap-3 mb-6">
                <button onclick="setUnit('metric')" id="btn-metric"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-purple-600 text-white shadow-lg">
                    {{ __tool('bmi-calculator', 'editor.unit_metric') }}
                </button>
                <button onclick="setUnit('imperial')" id="btn-imperial"
                    class="px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
                    {{ __tool('bmi-calculator', 'editor.unit_imperial') }}
                </button>
            </div>

            <!-- Metric Inputs -->
            <div id="metric-inputs">
                <div class="grid md:grid-cols-2 gap-6 mb-6">
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
            </div>

            <!-- Imperial Inputs -->
            <div id="imperial-inputs" class="hidden">
                <div class="grid md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="height-ft"
                            class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('bmi-calculator', 'editor.label_height_ft') }}</label>
                        <input type="number" id="height-ft" value="5" min="1" max="10"
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
            </div>

            <button onclick="calculateBMI()"
                class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2 mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                {{ __tool('bmi-calculator', 'editor.btn_calculate') }}
            </button>

            <!-- Result -->
            <div id="bmi-result" class="hidden">
                <div class="text-center p-6 rounded-xl border-2 border-gray-200 bg-gray-50">
                    <div class="text-6xl font-black mb-2" id="bmi-value">0</div>
                    <div class="text-xl font-bold mb-4" id="bmi-category">-</div>
                    <!-- BMI Scale Bar -->
                    <div class="relative h-8 rounded-full overflow-hidden mb-2 mx-auto max-w-md">
                        <div class="absolute inset-0 flex">
                            <div class="flex-1 bg-blue-400"></div>
                            <div class="flex-1 bg-green-400"></div>
                            <div class="flex-1 bg-yellow-400"></div>
                            <div class="flex-1 bg-red-400"></div>
                        </div>
                        <div id="bmi-pointer" class="absolute top-0 w-1 h-full bg-gray-900 transition-all"
                            style="left: 50%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 max-w-md mx-auto">
                        <span>15</span><span>18.5</span><span>25</span><span>30</span><span>40</span>
                    </div>
                </div>
            </div>
        </div>

        @php $content = __tool('bmi-calculator', 'content'); @endphp
        @if(is_array($content))
            <div
                class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                <h2 class="text-3xl font-black text-gray-900 mb-3 text-center">{{ $content['what_title'] ?? '' }}</h2>
                <p class="text-gray-600 text-center mx-auto max-w-xl mb-8">{{ $content['what_text'] ?? '' }}</p>

                @if(!empty($content['categories']))
                    <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">{{ $content['categories_title'] ?? '' }}</h3>
                    <div class="grid md:grid-cols-4 gap-4 mb-8">
                        @foreach($content['categories'] as $cat)
                            <div class="bg-white rounded-xl p-4 shadow-md border-l-4"
                                style="border-color: {{ $cat['color'] ?? '#6B7280' }}">
                                <div class="font-bold text-gray-800">{{ $cat['label'] }}</div>
                                <div class="text-sm text-gray-500">BMI: {{ $cat['range'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="text-center bg-white rounded-xl p-4 shadow-md">
                    <div class="font-bold text-gray-700">{{ $content['formula_title'] ?? '' }}</div>
                    <div class="text-gray-600 font-mono mt-1">{{ $content['formula_text'] ?? '' }}</div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            let unitMode = 'metric';

            function setUnit(mode) {
                unitMode = mode;
                document.getElementById('metric-inputs').classList.toggle('hidden', mode !== 'metric');
                document.getElementById('imperial-inputs').classList.toggle('hidden', mode !== 'imperial');
                document.getElementById('btn-metric').className = mode === 'metric'
                    ? 'px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-purple-600 text-white shadow-lg'
                    : 'px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-gray-100 text-gray-600 hover:bg-gray-200';
                document.getElementById('btn-imperial').className = mode === 'imperial'
                    ? 'px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-purple-600 text-white shadow-lg'
                    : 'px-5 py-2.5 rounded-xl font-semibold text-sm transition-all bg-gray-100 text-gray-600 hover:bg-gray-200';
            }

            function calculateBMI() {
                let heightM, weightKg;
                if (unitMode === 'metric') {
                    heightM = parseFloat(document.getElementById('height-cm').value) / 100;
                    weightKg = parseFloat(document.getElementById('weight-kg').value);
                } else {
                    const ft = parseFloat(document.getElementById('height-ft').value) || 0;
                    const inches = parseFloat(document.getElementById('height-in').value) || 0;
                    heightM = (ft * 12 + inches) * 0.0254;
                    weightKg = parseFloat(document.getElementById('weight-lbs').value) * 0.453592;
                }

                if (!heightM || !weightKg || heightM <= 0 || weightKg <= 0) return;

                const bmi = weightKg / (heightM * heightM);
                let category, color;
                if (bmi < 18.5) { category = "{{ __tool('bmi-calculator', 'js.cat_underweight') }}"; color = '#3B82F6'; }
                else if (bmi < 25) { category = "{{ __tool('bmi-calculator', 'js.cat_normal') }}"; color = '#10B981'; }
                else if (bmi < 30) { category = "{{ __tool('bmi-calculator', 'js.cat_overweight') }}"; color = '#F59E0B'; }
                else { category = "{{ __tool('bmi-calculator', 'js.cat_obese') }}"; color = '#EF4444'; }

                document.getElementById('bmi-value').innerText = bmi.toFixed(1);
                document.getElementById('bmi-value').style.color = color;
                document.getElementById('bmi-category').innerText = category;
                document.getElementById('bmi-category').style.color = color;

                // Position pointer (BMI 15-40 range mapped to 0-100%)
                const pct = Math.min(100, Math.max(0, (bmi - 15) / 25 * 100));
                document.getElementById('bmi-pointer').style.left = pct + '%';
                document.getElementById('bmi-result').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection