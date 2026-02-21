@extends('layouts.app')

@section('title', __tool('average-calculator', 'meta.title'))
@section('meta_description', __tool('average-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="average-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div class="mb-6">
                <label for="avg-numbers"
                    class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('average-calculator', 'editor.label_numbers') }}</label>
                <textarea id="avg-numbers" rows="4"
                    placeholder="{{ __tool('average-calculator', 'editor.placeholder_numbers') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all font-mono">10, 20, 30, 40, 50</textarea>
            </div>

            <div class="flex flex-wrap gap-3 mb-6">
                <button onclick="calcAvg()"
                    class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    {{ __tool('average-calculator', 'editor.btn_calculate') }}
                </button>
                <button
                    onclick="document.getElementById('avg-numbers').value=''; document.getElementById('avg-result').classList.add('hidden')"
                    class="px-5 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all font-semibold">
                    {{ __tool('average-calculator', 'editor.btn_clear') }}
                </button>
            </div>

            <div id="avg-result" class="hidden">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-purple-50 rounded-xl p-5 text-center border border-purple-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_mean') }}
                        </div>
                        <div class="text-2xl font-black text-purple-700" id="avg-mean">0</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-5 text-center border border-blue-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_median') }}
                        </div>
                        <div class="text-2xl font-black text-blue-700" id="avg-median">0</div>
                    </div>
                    <div class="bg-green-50 rounded-xl p-5 text-center border border-green-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_mode') }}
                        </div>
                        <div class="text-2xl font-black text-green-700" id="avg-mode">-</div>
                    </div>
                    <div class="bg-orange-50 rounded-xl p-5 text-center border border-orange-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_range') }}
                        </div>
                        <div class="text-2xl font-black text-orange-700" id="avg-range">0</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_count') }}
                        </div>
                        <div class="text-xl font-bold text-gray-700" id="avg-count">0</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_sum') }}</div>
                        <div class="text-xl font-bold text-gray-700" id="avg-sum">0</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_min') }}</div>
                        <div class="text-xl font-bold text-gray-700" id="avg-min">0</div>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-200">
                        <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_max') }}</div>
                        <div class="text-xl font-bold text-gray-700" id="avg-max">0</div>
                    </div>
                </div>
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="text-xs text-gray-500 mb-1">{{ __tool('average-calculator', 'editor.label_sorted') }}</div>
                    <div class="font-mono text-sm text-gray-700" id="avg-sorted">-</div>
                </div>
            </div>
        </div>

        {{-- Long-Form SEO Content --}}
        @php $content = __tool('average-calculator', 'content'); @endphp
        @if(is_array($content))
            <div class="space-y-8">
                <div
                    class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 text-center">{{ $content['what_title'] ?? '' }}</h2>
                    <p class="text-gray-600 text-lg leading-relaxed text-center mx-auto max-w-3xl">
                        {{ $content['what_text'] ?? '' }}</p>
                </div>

                @if(!empty($content['types_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['types_title'] }}</h2>
                        @if(!empty($content['types']))
                            <div class="grid md:grid-cols-2 gap-6">
                                @foreach($content['types'] as $type)
                                    <div
                                        class="bg-gradient-to-br from-gray-50 to-purple-50 rounded-2xl p-6 border border-gray-100 hover:shadow-lg transition-shadow">
                                        <h3 class="font-bold text-purple-700 text-lg mb-2">{{ $type['name'] }}</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $type['desc'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($content['section1_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section1_title'] }}</h2>
                        @if(!empty($content['section1_items']))
                            <div class="grid md:grid-cols-2 gap-6">
                                @foreach($content['section1_items'] as $item)
                                    <div class="bg-gradient-to-br from-gray-50 to-indigo-50 rounded-2xl p-6 border border-gray-100">
                                        <h3 class="font-bold text-indigo-700 text-lg mb-2">{{ $item['title'] }}</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $item['text'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($content['section2_title']))
                    <div
                        class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl p-8 md:p-12 shadow-xl border border-indigo-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section2_title'] }}</h2>
                        @if(!empty($content['section2_items']))
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($content['section2_items'] as $item)
                                    <div class="bg-white rounded-2xl p-6 border border-indigo-100 hover:shadow-lg transition-shadow">
                                        <h3 class="font-bold text-indigo-700 text-lg mb-2">{{ $item['title'] }}</h3>
                                        <p class="text-gray-600 text-sm leading-relaxed">{{ $item['text'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($content['section3_title']))
                    <div
                        class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-3xl p-8 md:p-12 shadow-xl border border-amber-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section3_title'] }}</h2>
                        @if(!empty($content['section3_items']))
                            <div class="space-y-3">
                                @foreach($content['section3_items'] as $mistake)
                                    <div class="flex items-start gap-3 bg-white rounded-xl p-4 shadow-sm">
                                        <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="text-gray-700 text-sm">{{ $mistake }}</span>
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
            function calcAvg() {
                const text = document.getElementById('avg-numbers').value;
                const nums = text.split(/[\s,;\n]+/).map(Number).filter(n => !isNaN(n));

                if (nums.length === 0) return;

                const sorted = [...nums].sort((a, b) => a - b);
                const sum = nums.reduce((a, b) => a + b, 0);
                const mean = sum / nums.length;
                const median = nums.length % 2 === 1 ? sorted[Math.floor(nums.length / 2)] : (sorted[nums.length / 2 - 1] + sorted[nums.length / 2]) / 2;
                const range = sorted[sorted.length - 1] - sorted[0];

                // Mode
                const freq = {};
                nums.forEach(n => freq[n] = (freq[n] || 0) + 1);
                const maxFreq = Math.max(...Object.values(freq));
                let mode;
                if (maxFreq === 1) {
                    mode = "{{ __tool('average-calculator', 'js.no_mode') }}";
                } else {
                    mode = Object.entries(freq).filter(([k, v]) => v === maxFreq).map(([k]) => k).join(', ');
                }

                const p = (n) => parseFloat(n.toPrecision(10));
                document.getElementById('avg-mean').innerText = p(mean);
                document.getElementById('avg-median').innerText = p(median);
                document.getElementById('avg-mode').innerText = mode;
                document.getElementById('avg-range').innerText = p(range);
                document.getElementById('avg-count').innerText = nums.length;
                document.getElementById('avg-sum').innerText = p(sum);
                document.getElementById('avg-min').innerText = sorted[0];
                document.getElementById('avg-max').innerText = sorted[sorted.length - 1];
                document.getElementById('avg-sorted').innerText = sorted.join(', ');
                document.getElementById('avg-result').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection