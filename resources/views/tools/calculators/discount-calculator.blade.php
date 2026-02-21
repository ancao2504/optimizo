@extends('layouts.app')

@section('title', __tool('discount-calculator', 'meta.title'))
@section('meta_description', __tool('discount-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="discount-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div class="grid md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="d-original"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('discount-calculator', 'editor.label_original') }}</label>
                    <input type="number" id="d-original" value="199.99" min="0" step="0.01"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="d-discount"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('discount-calculator', 'editor.label_discount') }}</label>
                    <input type="number" id="d-discount" value="25" min="0" max="100" step="0.1"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="d-tax"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('discount-calculator', 'editor.label_tax') }}</label>
                    <input type="number" id="d-tax" value="0" min="0" max="100" step="0.1"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
            </div>

            <button onclick="calcDiscount()"
                class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2 mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                {{ __tool('discount-calculator', 'editor.btn_calculate') }}
            </button>

            <div id="d-result" class="hidden">
                <div class="grid md:grid-cols-2 gap-4">
                    <div class="bg-green-50 rounded-xl p-6 text-center border border-green-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('discount-calculator', 'editor.label_savings') }}
                        </div>
                        <div class="text-4xl font-black text-green-700" id="d-savings">$0</div>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-6 text-center border border-purple-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('discount-calculator', 'editor.label_final_price') }}</div>
                        <div class="text-4xl font-black text-purple-700" id="d-final">$0</div>
                    </div>
                </div>
                <div id="d-tax-details" class="hidden mt-4 grid md:grid-cols-2 gap-4">
                    <div class="bg-orange-50 rounded-xl p-4 text-center border border-orange-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('discount-calculator', 'editor.label_tax_amount') }}</div>
                        <div class="text-2xl font-bold text-orange-700" id="d-tax-amount">$0</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-4 text-center border border-blue-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('discount-calculator', 'editor.label_total_with_tax') }}</div>
                        <div class="text-2xl font-bold text-blue-700" id="d-total-tax">$0</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Long-Form SEO Content --}}
        @php $content = __tool('discount-calculator', 'content'); @endphp
        @if(is_array($content))
            <div class="space-y-8">
                <div
                    class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 text-center">{{ $content['what_title'] ?? '' }}</h2>
                    <p class="text-gray-600 text-lg leading-relaxed text-center mx-auto max-w-3xl">
                        {{ $content['what_text'] ?? '' }}</p>
                </div>

                @if(!empty($content['section1_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section1_title'] }}</h2>
                        @if(!empty($content['section1_items']))
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($content['section1_items'] as $item)
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

                @if(!empty($content['section2_title']))
                    <div
                        class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl p-8 md:p-12 shadow-xl border border-green-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['section2_title'] }}</h2>
                        @if(!empty($content['section2_items']))
                            <div class="space-y-3">
                                @foreach($content['section2_items'] as $tip)
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

                @if(!empty($content['section3_title']))
                    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $content['section3_title'] }}</h2>
                        <p class="text-gray-600 leading-relaxed">{{ $content['section3_text'] ?? '' }}</p>
                    </div>
                @endif

                @if(!empty($content['examples_title']))
                    <div
                        class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-3xl p-8 md:p-12 shadow-xl border border-indigo-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ $content['examples_title'] }}</h2>
                        @if(!empty($content['examples']))
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($content['examples'] as $ex)
                                    <div class="bg-white rounded-xl p-5 border border-indigo-100 shadow-sm">
                                        <div class="font-bold text-indigo-700 mb-1">{{ $ex['label'] }}</div>
                                        <div class="text-gray-600 text-sm">{{ $ex['result'] }}</div>
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
            function fmt(n) { return '$' + n.toFixed(2); }

            function calcDiscount() {
                const orig = parseFloat(document.getElementById('d-original').value);
                const disc = parseFloat(document.getElementById('d-discount').value);
                const tax = parseFloat(document.getElementById('d-tax').value) || 0;

                if (isNaN(orig) || isNaN(disc) || orig < 0 || disc < 0 || disc > 100) return;

                const savings = orig * (disc / 100);
                const afterDiscount = orig - savings;

                document.getElementById('d-savings').innerText = fmt(savings);
                document.getElementById('d-final').innerText = fmt(afterDiscount);

                if (tax > 0) {
                    const taxAmt = afterDiscount * (tax / 100);
                    const totalWithTax = afterDiscount + taxAmt;
                    document.getElementById('d-tax-amount').innerText = fmt(taxAmt);
                    document.getElementById('d-total-tax').innerText = fmt(totalWithTax);
                    document.getElementById('d-tax-details').classList.remove('hidden');
                } else {
                    document.getElementById('d-tax-details').classList.add('hidden');
                }

                document.getElementById('d-result').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection