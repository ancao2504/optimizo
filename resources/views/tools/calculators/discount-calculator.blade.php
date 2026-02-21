@extends('layouts.app')

@section('title', __tool('discount-calculator', 'meta.title'))
@section('meta_description', __tool('discount-calculator', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="discount-calculator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div class="grid md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="original-price"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('discount-calculator', 'editor.label_original') }}</label>
                    <input type="number" id="original-price" value="100" min="0" step="0.01"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="discount-pct"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('discount-calculator', 'editor.label_discount') }}</label>
                    <input type="number" id="discount-pct" value="25" min="0" max="100" step="0.1"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
                <div>
                    <label for="tax-rate"
                        class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('discount-calculator', 'editor.label_tax') }}</label>
                    <input type="number" id="tax-rate" value="0" min="0" max="100" step="0.1"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                </div>
            </div>

            <!-- Quick Discount Buttons -->
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach([5, 10, 15, 20, 25, 30, 40, 50, 60, 75] as $d)
                    <button onclick="document.getElementById('discount-pct').value={{ $d }};calculateDiscount()"
                        class="px-4 py-2 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-all text-sm font-semibold border border-purple-200">
                        {{ $d }}%
                    </button>
                @endforeach
            </div>

            <button onclick="calculateDiscount()"
                class="px-8 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all font-semibold shadow-lg hover:shadow-xl flex items-center gap-2 mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                {{ __tool('discount-calculator', 'editor.btn_calculate') }}
            </button>

            <!-- Result -->
            <div id="discount-result" class="hidden">
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    <div class="bg-green-50 rounded-xl p-5 text-center border border-green-200">
                        <div class="text-sm text-gray-500 mb-1">{{ __tool('discount-calculator', 'editor.label_savings') }}
                        </div>
                        <div class="text-4xl font-black text-green-700" id="savings-amount">$0</div>
                    </div>
                    <div class="bg-purple-50 rounded-xl p-5 text-center border border-purple-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('discount-calculator', 'editor.label_final_price') }}</div>
                        <div class="text-4xl font-black text-purple-700" id="final-price">$0</div>
                    </div>
                </div>
                <div id="tax-details" class="hidden grid md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4 text-center border border-gray-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('discount-calculator', 'editor.label_tax_amount') }}</div>
                        <div class="text-2xl font-bold text-gray-700" id="tax-amount">$0</div>
                    </div>
                    <div class="bg-blue-50 rounded-xl p-4 text-center border border-blue-200">
                        <div class="text-sm text-gray-500 mb-1">
                            {{ __tool('discount-calculator', 'editor.label_total_with_tax') }}</div>
                        <div class="text-2xl font-bold text-blue-700" id="total-with-tax">$0</div>
                    </div>
                </div>
            </div>
        </div>

        @php $content = __tool('discount-calculator', 'content'); @endphp
        @if(is_array($content))
            <div
                class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl">
                <h2 class="text-3xl font-black text-gray-900 mb-3 text-center">{{ $content['what_title'] ?? '' }}</h2>
                <p class="text-gray-600 text-center mx-auto max-w-xl mb-8">{{ $content['what_text'] ?? '' }}</p>

                @if(!empty($content['examples']))
                    <h3 class="text-xl font-bold text-gray-800 mb-4">{{ $content['examples_title'] ?? '' }}</h3>
                    <div class="grid md:grid-cols-3 gap-4">
                        @foreach($content['examples'] as $ex)
                            <div class="bg-white rounded-xl p-4 shadow-md">
                                <div class="font-semibold text-purple-700 mb-1">{{ $ex['label'] }}</div>
                                <div class="text-gray-600 text-sm">{{ $ex['result'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            function fmt(n) { return '$' + n.toFixed(2); }

            function calculateDiscount() {
                const price = parseFloat(document.getElementById('original-price').value);
                const discount = parseFloat(document.getElementById('discount-pct').value);
                const taxRate = parseFloat(document.getElementById('tax-rate').value) || 0;

                if (isNaN(price) || isNaN(discount) || price < 0 || discount < 0 || discount > 100) return;

                const savings = price * (discount / 100);
                const afterDiscount = price - savings;

                document.getElementById('savings-amount').innerText = fmt(savings);
                document.getElementById('final-price').innerText = fmt(afterDiscount);

                if (taxRate > 0) {
                    const tax = afterDiscount * (taxRate / 100);
                    const totalWithTax = afterDiscount + tax;
                    document.getElementById('tax-amount').innerText = fmt(tax);
                    document.getElementById('total-with-tax').innerText = fmt(totalWithTax);
                    document.getElementById('tax-details').classList.remove('hidden');
                } else {
                    document.getElementById('tax-details').classList.add('hidden');
                }

                document.getElementById('discount-result').classList.remove('hidden');
            }
        </script>
    @endpush
@endsection