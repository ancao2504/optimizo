@extends('layouts.app')

@section('title', __tool('average-calculator', 'meta.title'))
@section('meta_description', __tool('average-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="average-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div class="mb-6">
                <label for="numbers-input"
                    class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('average-calculator', 'editor.label_numbers') }}</label>
                <textarea id="numbers-input" rows="4"
                    placeholder="{{ __tool('average-calculator', 'editor.placeholder_numbers') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all font-mono">10, 20, 30, 40, 50</textarea>
            </div>

            <div class="flex flex-wrap gap-3 mb-6">
                <button onclick="calculateAverage()"
                    class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    {{ __tool('average-calculator', 'editor.btn_calculate') }}
                </button>
                <button
                    onclick="document.getElementById('numbers-input').value='';document.getElementById('avg-result').classList.add('hidden')"
                    class="px-6 py-3 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    {{ __tool('average-calculator', 'editor.btn_clear') }}
                </button>
            </div>

            <!-- Result -->
            <div id="avg-result" class="hidden">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-purple-50 rounded-xl p-5 text-center border border-purple-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_mean') }}
                        </div>
                        <div class="text-2xl font-black text-purple-700" id="result-mean">0</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-5 text-center border border-blue-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_median') }}
                        </div>
                        <div class="text-2xl font-black text-blue-700" id="result-median">0</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-5 text-center border border-green-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_mode') }}
                        </div>
                        <div class="text-2xl font-black text-green-700" id="result-mode">0</div>
                    </div>
                    <div class="bg-orange-50 rounded-xl p-5 text-center border border-orange-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_range') }}
                        </div>
                        <div class="text-2xl font-black text-orange-700" id="result-range">0</div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_count') }}
                        </div>
                        <div class="text-xl font-bold text-gray-700" id="result-count">0</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_sum') }}</div>
                        <div class="text-xl font-bold text-gray-700" id="result-sum">0</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_min') }}</div>
                        <div class="text-xl font-bold text-gray-700" id="result-min">0</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_max') }}</div>
                        <div class="text-xl font-bold text-gray-700" id="result-max">0</div>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="text-sm font-semibold text-gray-600 mb-2">
                        {{ __tool('average-calculator', 'editor.label_sorted') }}</div>
                    <div class="font-mono text-gray-700 text-sm" id="result-sorted"></div>
                </div>
            </div>
        </div>

        @php $content = __tool('average-calculator', 'content'); @endphp
        @if(is_array($content))
            <div
                class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                <h2 class="text-3xl font-black text-gray-900 mb-3 text-center">{{ $content['what_title'] ?? '' }}</h2>
                <p class="text-gray-600 text-center mx-auto max-w-xl mb-8">{{ $content['what_text'] ?? '' }}</p>

                @if(!empty($content['types']))
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $content['types_title'] ?? '' }}</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($content['types'] as $type)
                            <div class="bg-white rounded-xl p-4 shadow-md">
                                <div class="font-semibold text-purple-700 mb-1">{{ $type['name'] }}</div>
                                <div class="text-gray-600 text-sm">{{ $type['desc'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function calculateAverage() {
                const input = document.getElementById('numbers-input').value;
                const numbers = input.split(/[\s,;\n]+/).map(s => s.trim()).filter(s => s !== '').map(Number).filter(n => !isNaN(n));

                if (numbers.length === 0) return;

                numbers.sort((a, b) => a - b);

                const sum = numbers.reduce((a, b) => a + b, 0);
                const mean = sum / numbers.length;
                const min = numbers[0];
                const max = numbers[numbers.length - 1];
                const range = max - min;

                // Median
                const mid = Math.floor(numbers.length / 2);
                const median = numbers.length % 2 !== 0 ? numbers[mid] : (numbers[mid - 1] + numbers[mid]) / 2;

                // Mode
                const freq = {};
                let maxFreq = 0;
                numbers.forEach(n => { freq[n] = (freq[n] || 0) + 1; if (freq[n] > maxFreq) maxFreq = freq[n]; });
                const modes = Object.keys(freq).filter(k => freq[k] === maxFreq);
                const modeStr = maxFreq === 1 ? "{{ __tool('average-calculator', 'js.no_mode') }}" : modes.join(', ');

                const fmt = n => parseFloat(n.toPrecision(10));

                document.getElementById('result-mean').innerText = fmt(mean);
                document.getElementById('result-median').innerText = fmt(median);
                document.getElementById('result-mode').innerText = modeStr;
                document.getElementById('result-range').innerText = fmt(range);
                document.getElementById('result-count').innerText = numbers.length;
                document.getElementById('result-sum').innerText = fmt(sum);
                document.getElementById('result-min').innerText = fmt(min);
                document.getElementById('result-max').innerText = fmt(max);
                document.getElementById('result-sorted').innerText = numbers.join(', ');
                document.getElementById('avg-result').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection