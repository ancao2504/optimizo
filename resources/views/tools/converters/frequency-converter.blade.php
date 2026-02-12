@extends('layouts.app')

@section('title', __tool('frequency-converter', 'meta.title'))
@section('meta_description', __tool('frequency-converter', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Hero Section --}}
        {{-- Hero Section --}}
        <x-tool-hero :tool="$tool" />

        {{-- Converter Card --}}
        <div class="bg-white rounded-3xl p-6 md:p-10 shadow-2xl border border-gray-100 mb-12 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-cyan-400 to-blue-500"></div>

            <div class="grid md:grid-cols-7 gap-6 items-center">
                {{-- From Section --}}
                <div class="md:col-span-3 space-y-2">
                    <label for="fromValue"
                        class="block text-sm font-bold text-gray-700 uppercase tracking-wide">{{ __tool('frequency-converter', 'form.from_label') }}</label>
                    <div class="relative">
                        <input type="number" id="fromValue" value="1" step="any"
                            class="block w-full text-3xl font-bold p-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-cyan-100 focus:border-cyan-500 transition-all text-gray-800 placeholder-gray-300"
                            placeholder="0" oninput="convert('from')">
                    </div>
                    <select id="fromUnit" onchange="convert('from')"
                        class="block w-full p-3 bg-gray-50 border border-gray-200 rounded-xl font-medium text-gray-700 focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all cursor-pointer hover:bg-gray-100">
                        <option value="Hz">{{ __tool('frequency-converter', 'form.unit_Hz') }}</option>
                        <option value="kHz">{{ __tool('frequency-converter', 'form.unit_kHz') }}</option>
                        <option value="MHz" selected>{{ __tool('frequency-converter', 'form.unit_MHz') }}</option>
                        <option value="GHz">{{ __tool('frequency-converter', 'form.unit_GHz') }}</option>
                        <option value="THz">{{ __tool('frequency-converter', 'form.unit_THz') }}</option>
                        <option value="rpm">{{ __tool('frequency-converter', 'form.unit_rpm') }}</option>
                    </select>
                </div>

                {{-- Swap Button --}}
                <div class="md:col-span-1 flex justify-center py-4 md:py-0">
                    <button onclick="swapUnits()"
                        class="p-4 bg-cyan-50 text-cyan-600 rounded-full hover:bg-cyan-100 hover:scale-110 active:scale-95 transition-all shadow-md focus:outline-none focus:ring-4 focus:ring-cyan-100"
                        title="Swap Units">
                        <svg class="w-8 h-8 rotate-90 md:rotate-0 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </button>
                </div>

                {{-- To Section --}}
                <div class="md:col-span-3 space-y-2">
                    <label for="toValue" class="block text-sm font-bold text-gray-700 uppercase tracking-wide">{{ __tool('frequency-converter', 'form.to_label') }}</label>
                    <div class="relative">
                        <input type="number" id="toValue" step="any"
                            class="block w-full text-3xl font-bold p-4 border-2 border-gray-200 rounded-2xl focus:ring-4 focus:ring-cyan-100 focus:border-cyan-500 transition-all text-gray-800 placeholder-gray-300 bg-gray-50"
                            placeholder="0" oninput="convert('to')">
                    </div>
                    <select id="toUnit" onchange="convert('from')"
                        class="block w-full p-3 bg-gray-50 border border-gray-200 rounded-xl font-medium text-gray-700 focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition-all cursor-pointer hover:bg-gray-100">
                        <option value="Hz" selected>{{ __tool('frequency-converter', 'form.unit_Hz') }}</option>
                        <option value="kHz">{{ __tool('frequency-converter', 'form.unit_kHz') }}</option>
                        <option value="MHz">{{ __tool('frequency-converter', 'form.unit_MHz') }}</option>
                        <option value="GHz">{{ __tool('frequency-converter', 'form.unit_GHz') }}</option>
                        <option value="THz">{{ __tool('frequency-converter', 'form.unit_THz') }}</option>
                        <option value="rpm">{{ __tool('frequency-converter', 'form.unit_rpm') }}</option>
                    </select>
                </div>
            </div>

            {{-- Formula Display --}}
            <div class="mt-8 p-4 bg-gray-50 rounded-xl border border-gray-100 text-center">
                <p id="formulaDisplay" class="text-cyan-600 font-medium font-mono text-sm sm:text-base"></p>
            </div>
        </div>

        {{-- SEO Content Section --}}
        <div class="space-y-12">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-cyan-100 rounded-xl flex items-center justify-center text-cyan-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __tool('frequency-converter', 'content.card1_title') ?: 'Frequency Units' }}</h3>
                    <p class="text-gray-600">{{ __tool('frequency-converter', 'content.card1_desc') ?: 'Convert between Hz, kHz, MHz, GHz, RPM, and more frequency units.' }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __tool('frequency-converter', 'content.card2_title') ?: 'Electronics & Computing' }}</h3>
                    <p class="text-gray-600">{{ __tool('frequency-converter', 'content.card2_desc') ?: 'Perfect for CPU speeds, radio frequencies, and wave calculations.' }}</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-teal-100 rounded-xl flex items-center justify-center text-teal-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __tool('frequency-converter', 'content.card3_title') ?: 'Cycles Per Second' }}</h3>
                    <p class="text-gray-600">{{ __tool('frequency-converter', 'content.card3_desc') ?: 'Accurate conversions for oscillations, rotations, and wave frequencies.' }}</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ __tool('frequency-converter', 'content.main_title') }}</h2>
                <div class="prose prose-cyan max-w-none text-gray-600">
                    <p>{{ __tool('frequency-converter', 'content.description_p1') }}</p>
                    <p class="mt-4">{{ __tool('frequency-converter', 'content.description_p2') }}</p>

                    <h3 class="text-xl font-bold text-gray-900 mt-8 mb-4">{{ __tool('frequency-converter', 'content.usage_examples_title') }}</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <ul class="list-disc list-inside space-y-2">
                            <li>{!! __tool('frequency-converter', 'content.usage_1') !!}</li>
                            <li>{!! __tool('frequency-converter', 'content.usage_2') !!}</li>
                            <li>{!! __tool('frequency-converter', 'content.usage_3') !!}</li>
                        </ul>
                        <ul class="list-disc list-inside space-y-2">
                            <li>{!! __tool('frequency-converter', 'content.usage_4') !!}</li>
                            <li>{!! __tool('frequency-converter', 'content.usage_5') !!}</li>
                            <li>{!! __tool('frequency-converter', 'content.usage_6') !!}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-cyan-50 to-white rounded-3xl p-8 border border-cyan-100 shadow-lg">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    {{ __tool('frequency-converter', 'content.faq_title') }}
                </h2>
                <div class="space-y-6">
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">{{ __tool('frequency-converter', 'content.faq_q1') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ __tool('frequency-converter', 'content.faq_a1') }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">{{ __tool('frequency-converter', 'content.faq_q2') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ __tool('frequency-converter', 'content.faq_a2') }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">{{ __tool('frequency-converter', 'content.faq_q3') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ __tool('frequency-converter', 'content.faq_a3') }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-2">{{ __tool('frequency-converter', 'content.faq_q4') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ __tool('frequency-converter', 'content.faq_a4') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // Conversion rates relative to Hertz (Hz)
    const rates = {
        'Hz': 1,
        'kHz': 1000,
        'MHz': 1000000,
        'GHz': 1000000000,
        'THz': 1000000000000,
        'rpm': 0.016666667
    };

    const names = {
        'Hz': 'Hz', 'kHz': 'kHz', 'MHz': 'MHz',
        'GHz': 'GHz', 'THz': 'THz', 'rpm': 'RPM'
    };

    function convert(source) {
        const fromUnit = document.getElementById('fromUnit').value;
        const toUnit = document.getElementById('toUnit').value;
        const fromInput = document.getElementById('fromValue');
        const toInput = document.getElementById('toValue');

        let value;
        if (source === 'from') {
            value = parseFloat(fromInput.value);
            if (isNaN(value)) {
                toInput.value = '';
                updateFormula(null);
                return;
            }

            const baseValue = value * rates[fromUnit];
            const result = baseValue / rates[toUnit];
            toInput.value = parseFloat(result.toPrecision(12)) / 1;
        } else {
            value = parseFloat(toInput.value);
            if (isNaN(value)) {
                fromInput.value = '';
                updateFormula(null);
                return;
            }

            const baseValue = value * rates[toUnit];
            const result = baseValue / rates[fromUnit];
            fromInput.value = parseFloat(result.toPrecision(12)) / 1;
        }

        updateFormula(fromUnit, toUnit);
    }

    function swapUnits() {
        const fromSelect = document.getElementById('fromUnit');
        const toSelect = document.getElementById('toUnit');
        const temp = fromSelect.value;

        fromSelect.value = toSelect.value;
        toSelect.value = temp;
        convert('from');
    }

    function updateFormula(from, to) {
        const display = document.getElementById('formulaDisplay');
        if (!from) {
            display.innerText = '';
            return;
        }
        const factor = rates[from] / rates[to];
        const cleanFactor = parseFloat(factor.toPrecision(8)) / 1;
        display.innerHTML = `1 ${names[from]} = ${cleanFactor} ${names[to]}`;
    }

    // Initialize
    window.addEventListener('load', () => convert('from'));
</script>
@endpush