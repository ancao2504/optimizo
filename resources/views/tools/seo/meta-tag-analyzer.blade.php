@extends('layouts.app')

@section('title', __tool('meta-tag-analyzer', 'meta.title'))
@section('meta_description', __tool('meta-tag-analyzer', 'meta.description'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <x-tool-hero :tool="$tool" />

        <!-- Tool Section -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-green-200 mb-8">
            <div class="mb-6">
                <label for="urlInput" class="form-label text-base">{{ __tool('meta-tag-analyzer', 'form.label') }}</label>
                <input type="url" id="urlInput" class="form-input"
                    placeholder="{{ __tool('meta-tag-analyzer', 'form.placeholder') }}" />
            </div>

            <button onclick="analyzeMeta()" id="analyzeBtn" class="btn-primary w-full justify-center text-lg py-4 mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span id="btnText">{{ __tool('meta-tag-analyzer', 'form.button') }}</span>
            </button>

            <!-- Status Message -->
            <div id="statusMessage" class="hidden mt-6 p-4 rounded-xl"></div>

            <!-- Results -->
            <div id="results" class="hidden">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ __tool('meta-tag-analyzer', 'results.title') }}</h3>

                <!-- Title Tag -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-lg text-gray-900">{{ __tool('meta-tag-analyzer', 'results.title_tag') }}</h4>
                        <span id="titleStatus" class="px-3 py-1 rounded-full text-sm font-bold"></span>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <p id="titleContent" class="text-gray-700 mb-2"></p>
                        <div class="text-sm text-gray-600">
                            {{ __tool('meta-tag-analyzer', 'results.length') }}: <span id="titleLength"
                                class="font-bold"></span> {{ __tool('meta-tag-analyzer', 'results.characters') }}
                            <span id="titleAdvice" class="ml-2"></span>
                        </div>
                    </div>
                </div>

                <!-- Meta Description -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-bold text-lg text-gray-900">
                            {{ __tool('meta-tag-analyzer', 'results.meta_description') }}
                        </h4>
                        <span id="descStatus" class="px-3 py-1 rounded-full text-sm font-bold"></span>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <p id="descContent" class="text-gray-700 mb-2"></p>
                        <div class="text-sm text-gray-600">
                            {{ __tool('meta-tag-analyzer', 'results.length') }}: <span id="descLength" class="font-bold"></span>
                            {{ __tool('meta-tag-analyzer', 'results.characters') }}
                            <span id="descAdvice" class="ml-2"></span>
                        </div>
                    </div>
                </div>

                <!-- Other Meta Tags -->
                <div class="mb-6">
                    <h4 class="font-bold text-lg text-gray-900 mb-3">
                        {{ __tool('meta-tag-analyzer', 'results_labels.other_tags') }}</h4>
                    <div id="otherMeta" class="space-y-3"></div>
                </div>

                <!-- SEO Score -->
                <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-xl p-6 border-2 border-green-200">
                    <h4 class="font-bold text-lg text-gray-900 mb-3">
                        {{ __tool('meta-tag-analyzer', 'results_labels.seo_score') }}</h4>
                    <div class="flex items-center gap-4">
                        <div class="text-5xl font-black" id="seoScore">0</div>
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div id="scoreBar" class="h-4 rounded-full transition-all" style="width: 0%"></div>
                            </div>
                            <p id="scoreText" class="text-sm text-gray-600 mt-2"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO Content -->
        <div
            class="bg-gradient-to-br from-green-50 to-teal-50 rounded-3xl p-8 md:p-12 border-2 border-green-100 shadow-2xl mt-8">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl shadow-xl mb-4">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-gray-900 mb-3">{{ __tool('meta-tag-analyzer', 'content.main_title') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ __tool('meta-tag-analyzer', 'content.main_subtitle') }}
                </p>
            </div>

            <p class="text-gray-700 leading-relaxed text-lg mb-8">
                {{ __tool('meta-tag-analyzer', 'content.intro') }}
            </p>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('meta-tag-analyzer', 'content.what_are_title') }}</h3>
            <p class="text-gray-700 leading-relaxed mb-6">
                {{ __tool('meta-tag-analyzer', 'content.what_are_desc') }}
            </p>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('meta-tag-analyzer', 'content.essential_title') }}</h3>
            <div class="grid md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">
                        {{ __tool('meta-tag-analyzer', 'meta_tags.title_tag_title') }}</h4>
                    <p class="text-gray-700 mb-3">{{ __tool('meta-tag-analyzer', 'meta_tags.title_tag_desc') }}</p>
                    <div class="bg-blue-50 p-3 rounded-lg border border-blue-200">
                        <p class="text-sm text-blue-900">
                            <strong>{{ __tool('meta-tag-analyzer', 'meta_tags.title_optimal_length') }}</strong>
                            {{ __tool('meta-tag-analyzer', 'meta_tags.title_optimal_value') }}</p>
                        <p class="text-sm text-blue-900">
                            <strong>{{ __tool('meta-tag-analyzer', 'meta_tags.title_best_practice') }}</strong>
                            {{ __tool('meta-tag-analyzer', 'meta_tags.title_best_value') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">
                        {{ __tool('meta-tag-analyzer', 'meta_tags.meta_desc_title') }}</h4>
                    <p class="text-gray-700 mb-3">{{ __tool('meta-tag-analyzer', 'meta_tags.meta_desc_desc') }}</p>
                    <div class="bg-green-50 p-3 rounded-lg border border-green-200">
                        <p class="text-sm text-green-900">
                            <strong>{{ __tool('meta-tag-analyzer', 'meta_tags.meta_desc_optimal_length') }}</strong>
                            {{ __tool('meta-tag-analyzer', 'meta_tags.meta_desc_optimal_value') }}</p>
                        <p class="text-sm text-green-900">
                            <strong>{{ __tool('meta-tag-analyzer', 'meta_tags.meta_desc_best_practice') }}</strong>
                            {{ __tool('meta-tag-analyzer', 'meta_tags.meta_desc_best_value') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('meta-tag-analyzer', 'meta_tags.og_title') }}
                    </h4>
                    <p class="text-gray-700 mb-3">{{ __tool('meta-tag-analyzer', 'meta_tags.og_desc') }}</p>
                    <div class="bg-purple-50 p-3 rounded-lg border border-purple-200">
                        <p class="text-sm text-purple-900">
                            <strong>{{ __tool('meta-tag-analyzer', 'meta_tags.og_key_tags') }}</strong>
                            {{ __tool('meta-tag-analyzer', 'meta_tags.og_key_value') }}</p>
                        <p class="text-sm text-purple-900">
                            <strong>{{ __tool('meta-tag-analyzer', 'meta_tags.og_platform') }}</strong>
                            {{ __tool('meta-tag-analyzer', 'meta_tags.og_platform_value') }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">
                        {{ __tool('meta-tag-analyzer', 'meta_tags.twitter_title') }}</h4>
                    <p class="text-gray-700 mb-3">{{ __tool('meta-tag-analyzer', 'meta_tags.twitter_desc') }}</p>
                    <div class="bg-cyan-50 p-3 rounded-lg border border-cyan-200">
                        <p class="text-sm text-cyan-900">
                            <strong>{{ __tool('meta-tag-analyzer', 'meta_tags.twitter_key_tags') }}</strong>
                            {{ __tool('meta-tag-analyzer', 'meta_tags.twitter_key_value') }}</p>
                        <p class="text-sm text-cyan-900">
                            <strong>{{ __tool('meta-tag-analyzer', 'meta_tags.twitter_types') }}</strong>
                            {{ __tool('meta-tag-analyzer', 'meta_tags.twitter_types_value') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-2xl p-8 mb-10">
                <h4 class="font-bold text-yellow-900 mb-3 flex items-center gap-3 text-xl">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __tool('meta-tag-analyzer', 'content.common_mistakes_title') }}
                </h4>
                <ul class="text-yellow-800 leading-relaxed space-y-2">
                    <li>{{ __tool('meta-tag-analyzer', 'content.mistake_1') }}</li>
                    <li>{{ __tool('meta-tag-analyzer', 'content.mistake_2') }}</li>
                    <li>{{ __tool('meta-tag-analyzer', 'content.mistake_3') }}</li>
                    <li>{{ __tool('meta-tag-analyzer', 'content.mistake_4') }}</li>
                    <li>{{ __tool('meta-tag-analyzer', 'content.mistake_5') }}</li>
                    <li>{{ __tool('meta-tag-analyzer', 'content.mistake_6') }}</li>
                </ul>
            </div>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('meta-tag-analyzer', 'content.why_analyze_title') }}
            </h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-green-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">📈</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('meta-tag-analyzer', 'benefits.b1_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('meta-tag-analyzer', 'benefits.b1_desc') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-teal-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">👆</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('meta-tag-analyzer', 'benefits.b2_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('meta-tag-analyzer', 'benefits.b2_desc') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-blue-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">📱</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('meta-tag-analyzer', 'benefits.b3_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('meta-tag-analyzer', 'benefits.b3_desc') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-purple-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">🔍</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('meta-tag-analyzer', 'benefits.b4_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('meta-tag-analyzer', 'benefits.b4_desc') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-pink-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">⚡</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('meta-tag-analyzer', 'features.f2_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('meta-tag-analyzer', 'features.f2_desc') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-indigo-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">🏆</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('meta-tag-analyzer', 'features.f3_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('meta-tag-analyzer', 'features.f3_desc') }}</p>
                </div>
            </div>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('meta-tag-analyzer', 'faq.title') }}</h3>
            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('meta-tag-analyzer', 'faq.q1') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('meta-tag-analyzer', 'faq.a1') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('meta-tag-analyzer', 'faq.q2') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('meta-tag-analyzer', 'faq.a2') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('meta-tag-analyzer', 'faq.q3') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('meta-tag-analyzer', 'faq.a3') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('meta-tag-analyzer', 'faq.q4') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('meta-tag-analyzer', 'faq.a4') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('meta-tag-analyzer', 'faq.q5') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('meta-tag-analyzer', 'faq.a5') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        async function analyzeMeta() {
            const url = document.getElementById('urlInput').value.trim();
            const btn = document.getElementById('analyzeBtn');
            const btnText = document.getElementById('btnText');
            const statusMessage = document.getElementById('statusMessage');

            if (!url) {
                showError('{{ __tool('meta-tag-analyzer', 'js.alert_enter_url') }}');
                return;
            }

            // Show loading state
            btn.disabled = true;
            btn.classList.add('opacity-75');
            btnText.textContent = '{{ __tool('meta-tag-analyzer', 'js.analyzing') }}';
            statusMessage.classList.add('hidden');
            document.getElementById('results').classList.add('hidden');

            try {
                // Fetch the page (Note: This will be blocked by CORS in production)
                // In production, you'd need a backend proxy
                statusMessage.className = 'mt-6 p-4 rounded-xl bg-yellow-100 text-yellow-800 border-2 border-yellow-300';
                statusMessage.innerHTML = '{!! __tool('meta-tag-analyzer', 'js.error_cors') !!}';
                statusMessage.classList.remove('hidden');

                // Simulated analysis for demo
                setTimeout(() => {
                    showDemoResults();
                }, 1000);

            } catch (error) {
                statusMessage.className = 'mt-6 p-4 rounded-xl bg-red-100 text-red-800 border-2 border-red-300';
                statusMessage.textContent = '{{ __tool('meta-tag-analyzer', 'js.error_general') }}';
                statusMessage.classList.remove('hidden');
            } finally {
                btn.disabled = false;
                btn.classList.remove('opacity-75');
                btnText.textContent = '{{ __tool('meta-tag-analyzer', 'js.analyze_btn') }}';
            }
        }

        function showDemoResults() {
            // Demo data - in production, parse actual HTML
            const title = "{{ __tool('meta-tag-analyzer', 'js.demo_title') }}";
            const description = "{{ __tool('meta-tag-analyzer', 'js.demo_description') }}";

            // Title analysis
            document.getElementById('titleContent').textContent = title;
            document.getElementById('titleLength').textContent = title.length;

            if (title.length >= 50 && title.length <= 60) {
                document.getElementById('titleStatus').className = 'px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800';
                document.getElementById('titleStatus').textContent = '{{ __tool('meta-tag-analyzer', 'js.status_optimal') }}';
                document.getElementById('titleAdvice').textContent = '{{ __tool('meta-tag-analyzer', 'js.advice_perfect_length') }}';
                document.getElementById('titleAdvice').className = 'ml-2 text-green-600';
            } else if (title.length > 60) {
                document.getElementById('titleStatus').className = 'px-3 py-1 rounded-full text-sm font-bold bg-orange-100 text-orange-800';
                document.getElementById('titleStatus').textContent = '{{ __tool('meta-tag-analyzer', 'js.status_too_long') }}';
                document.getElementById('titleAdvice').textContent = '{{ __tool('meta-tag-analyzer', 'js.advice_truncated') }}';
                document.getElementById('titleAdvice').className = 'ml-2 text-orange-600';
            } else {
                document.getElementById('titleStatus').className = 'px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800';
                document.getElementById('titleStatus').textContent = '{{ __tool('meta-tag-analyzer', 'js.status_too_short') }}';
                document.getElementById('titleAdvice').textContent = '{{ __tool('meta-tag-analyzer', 'js.advice_add_detail') }}';
                document.getElementById('titleAdvice').className = 'ml-2 text-yellow-600';
            }

            // Description analysis
            document.getElementById('descContent').textContent = description;
            document.getElementById('descLength').textContent = description.length;

            if (description.length >= 150 && description.length <= 160) {
                document.getElementById('descStatus').className = 'px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800';
                document.getElementById('descStatus').textContent = '{{ __tool('meta-tag-analyzer', 'js.status_optimal') }}';
                document.getElementById('descAdvice').textContent = '{{ __tool('meta-tag-analyzer', 'js.advice_perfect_length') }}';
                document.getElementById('descAdvice').className = 'ml-2 text-green-600';
            } else if (description.length > 160) {
                document.getElementById('descStatus').className = 'px-3 py-1 rounded-full text-sm font-bold bg-orange-100 text-orange-800';
                document.getElementById('descStatus').textContent = '{{ __tool('meta-tag-analyzer', 'js.status_too_long') }}';
                document.getElementById('descAdvice').textContent = '{{ __tool('meta-tag-analyzer', 'js.advice_truncated_short') }}';
                document.getElementById('descAdvice').className = 'ml-2 text-orange-600';
            } else {
                document.getElementById('descStatus').className = 'px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800';
                document.getElementById('descStatus').textContent = '{{ __tool('meta-tag-analyzer', 'js.status_too_short') }}';
                document.getElementById('descAdvice').textContent = '{{ __tool('meta-tag-analyzer', 'js.advice_add_detail_short') }}';
                document.getElementById('descAdvice').className = 'ml-2 text-yellow-600';
            }

            // Other meta tags
            const otherMeta = document.getElementById('otherMeta');
            otherMeta.innerHTML = `
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="font-bold text-gray-900 mb-1">{{ __tool('meta-tag-analyzer', 'results_labels.viewport') }}</div>
                                        <code class="text-sm text-gray-600">width=device-width, initial-scale=1</code>
                                        <span class="ml-2 text-green-600">✓</span>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="font-bold text-gray-900 mb-1">{{ __tool('meta-tag-analyzer', 'results_labels.charset') }}</div>
                                        <code class="text-sm text-gray-600">UTF-8</code>
                                        <span class="ml-2 text-green-600">✓</span>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                        <div class="font-bold text-gray-900 mb-1">{{ __tool('meta-tag-analyzer', 'results_labels.robots') }}</div>
                                        <code class="text-sm text-gray-600">index, follow</code>
                                        <span class="ml-2 text-green-600">✓</span>
                                    </div>
                                `;

            // SEO Score
            const score = 85;
            document.getElementById('seoScore').textContent = score;
            document.getElementById('scoreBar').style.width = score + '%';
            document.getElementById('scoreBar').className = 'h-4 rounded-full transition-all bg-gradient-to-r from-green-500 to-teal-600';
            document.getElementById('scoreText').textContent = '{{ __tool('meta-tag-analyzer', 'js.score_text') }}';

            document.getElementById('results').classList.remove('hidden');
        }
    </script>
@endpush