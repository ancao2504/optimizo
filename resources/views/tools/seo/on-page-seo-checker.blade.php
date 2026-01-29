@extends('layouts.app')

@section('title', __tool('on-page-seo-checker', 'meta.title'))
@section('meta_description', __tool('on-page-seo-checker', 'meta.description'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <x-tool-hero :tool="$tool" />

        <!-- Tool Interface -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border border-gray-100 mb-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __tool('on-page-seo-checker', 'interface.title') }}
                </h2>
                <div class="h-1 w-16 bg-gradient-to-r from-indigo-600 to-pink-600 mx-auto rounded-full"></div>
            </div>

            <form id="seoForm" class="max-w-3xl mx-auto"
                onsubmit="event.preventDefault(); window.runSeoScan(); return false;">
                @csrf
                <div class="space-y-6">
                    <!-- URL Input -->
                    <div class="group">
                        <label for="url" class="block text-sm font-bold text-gray-600 uppercase tracking-wider mb-2 ml-1">
                            {{ __tool('on-page-seo-checker', 'interface.url_label') }}
                        </label>
                        <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <input type="url" id="url" name="url" required placeholder="https://example.com"
                                class="w-full bg-gray-50 text-gray-900 placeholder-gray-400 border-2 border-gray-100 rounded-xl px-6 py-4 pl-14 outline-none focus:bg-white focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all font-semibold text-lg shadow-inner">
                        </div>
                    </div>

                    <!-- Keywords Input -->
                    <div class="group">
                        <div class="flex justify-between items-center mb-2 ml-1">
                            <label for="keywords" class="block text-sm font-bold text-gray-600 uppercase tracking-wider">
                                {{ __tool('on-page-seo-checker', 'interface.keywords_label') }}
                            </label>
                            <span
                                class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md uppercase tracking-wider">{{ __tool('on-page-seo-checker', 'interface.recommended') }}</span>
                        </div>
                        <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-6 h-6 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                </svg>
                            </div>
                            <input type="text" id="keywords" name="keywords" placeholder="e.g. coffee shop, best espresso"
                                class="w-full bg-gray-50 text-gray-900 placeholder-gray-400 border-2 border-gray-100 rounded-xl px-6 py-4 pl-14 outline-none focus:bg-white focus:border-pink-500 focus:ring-4 focus:ring-pink-500/10 transition-all font-semibold text-lg shadow-inner">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xl rounded-xl px-8 py-5 shadow-xl shadow-indigo-500/30 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-300 flex items-center justify-center gap-3">
                            <span>{{ __tool('on-page-seo-checker', 'interface.button') }}</span>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Progress Section (Hidden Initialy) -->
        <div id="progressSection" class="hidden mb-10 scroll-mt-24">
            <div class="bg-white rounded-2xl p-6 shadow-xl border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex justify-between">
                    <span id="progressStatus">{{ __tool('on-page-seo-checker', 'labels.initializing') }}</span>
                    <span id="progressPercent" class="text-indigo-600">0%</span>
                </h3>
                <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
                    <div id="progressBar" class="bg-indigo-600 h-full w-0 transition-all duration-300 ease-out">
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Grid -->
        <div id="resultsGrid" class="hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content (Left) -->
            <div class="lg:col-span-2 space-y-6" id="modulesContainer">
                <!-- Dynamic Modules will be injected here -->
            </div>

            <!-- Scorecard Sidebar (Right) -->
            <div class="lg:col-span-1">
                <div class="sticky top-24 space-y-6">
                    <!-- Score Card -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl border-t-4 border-indigo-600">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">
                            {{ __tool('on-page-seo-checker', 'interface.page_analysis') }}
                        </h2>

                        <!-- Thumbnail Preview -->


                        <div class="relative w-40 h-40 mx-auto mb-6">
                            <!-- Circle -->
                            <div
                                class="w-full h-full rounded-full border-4 border-gray-100 flex items-center justify-center bg-gray-50">
                                <span id="finalScore" class="text-5xl font-black text-indigo-600">--</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div class="p-3 bg-blue-50 rounded-xl">
                                <div class="text-xs text-uppercase text-blue-600 font-bold tracking-wider">
                                    {{ __tool('on-page-seo-checker', 'labels.desktop') }}
                                </div>
                                <div class="text-2xl font-bold text-blue-900" id="desktopScore">--</div>
                            </div>
                            <div class="p-3 bg-pink-50 rounded-xl">
                                <div class="text-xs text-uppercase text-pink-600 font-bold tracking-wider">
                                    {{ __tool('on-page-seo-checker', 'labels.mobile') }}
                                </div>
                                <div class="text-2xl font-bold text-pink-900" id="mobileScore">--</div>
                            </div>
                        </div>
                    </div>

                    <!-- Export Button -->
                    <button disabled id="exportBtn"
                        class="w-full bg-gray-800 hover:bg-gray-700 text-white font-bold py-4 rounded-xl shadow-lg transition-all flex items-center justify-center gap-2 opacity-50 cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download PDF Report
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- SEO Content Section -->
    <div class="max-w-5xl mx-auto mt-8 mb-8">
        <div
            class="bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 rounded-2xl p-8 md:p-12 shadow-lg border border-indigo-100">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('on-page-seo-checker', 'content.main_content_title') }}
            </h2>
            <p class="text-lg text-gray-700 leading-relaxed mb-8 text-center max-w-4xl mx-auto">
                {!! __tool('on-page-seo-checker', 'content.main_content_desc') !!}
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <!-- Feature 1 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-indigo-50">
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4 text-2xl">🚀</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                        {{ __tool('on-page-seo-checker', 'features.f1_title') }}
                    </h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'features.f1_desc') !!}</p>
                </div>

                <!-- Feature 2 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-purple-50">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4 text-2xl">📊</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                        {{ __tool('on-page-seo-checker', 'features.f2_title') }}
                    </h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'features.f2_desc') !!}</p>
                </div>

                <!-- Feature 3 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-pink-50">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-4 text-2xl">🔍</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                        {{ __tool('on-page-seo-checker', 'features.f3_title') }}
                    </h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'features.f3_desc') !!}</p>
                </div>

                <!-- Feature 4 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-blue-50">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4 text-2xl">📱</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                        {{ __tool('on-page-seo-checker', 'features.f4_title') }}
                    </h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'features.f4_desc') !!}</p>
                </div>

                <!-- Feature 5 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-green-50">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4 text-2xl">🆓</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                        {{ __tool('on-page-seo-checker', 'features.f5_title') }}
                    </h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'features.f5_desc') !!}</p>
                </div>

                <!-- Feature 6 -->
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-shadow duration-300 border border-orange-50">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4 text-2xl">🔗</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">
                        {{ __tool('on-page-seo-checker', 'features.f6_title') }}
                    </h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'features.f6_desc') !!}</p>
                </div>
            </div>

            <!-- Steps Section -->
            <div class="bg-white rounded-2xl p-8 shadow-md border border-gray-100 mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                    {{ __tool('on-page-seo-checker', 'content.how_to_title') }}
                </h2>
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                            1</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                {{ __tool('on-page-seo-checker', 'how_to.step1_title') }}
                            </h3>
                            <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'how_to.step1_desc') !!}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                            2</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                {{ __tool('on-page-seo-checker', 'how_to.step2_title') }}
                            </h3>
                            <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'how_to.step2_desc') !!}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold mr-4">
                            3</div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                {{ __tool('on-page-seo-checker', 'how_to.step3_title') }}
                            </h3>
                            <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'how_to.step3_desc') !!}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                    {{ __tool('on-page-seo-checker', 'faq.title') }}
                </h2>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class=" font-bold text-lg text-gray-800 mb-2">{{ __tool('on-page-seo-checker', 'faq.q1') }}</h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'faq.a1') !!}</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class=" font-bold text-lg text-gray-800 mb-2">{{ __tool('on-page-seo-checker', 'faq.q2') }}</h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'faq.a2') !!}</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class=" font-bold text-lg text-gray-800 mb-2">{{ __tool('on-page-seo-checker', 'faq.q3') }}</h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'faq.a3') !!}</p>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class=" font-bold text-lg text-gray-800 mb-2">{{ __tool('on-page-seo-checker', 'faq.q4') }}</h3>
                    <p class="text-gray-600">{!! __tool('on-page-seo-checker', 'faq.a4') !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Global Variables and Function Definitions (Outside DOMContentLoaded)
        const steps = [
            'topic_intent', 'keywords', 'title', 'meta_description', 'url_structure',
            'headings', 'content_quality', 'gpt_optimization', 'mobile_ux', 'core_web_vitals',
            'images', 'internal_links', 'external_links', 'schema', 'trust_signals',
            'ai_citation', 'zero_click', 'canonical', 'indexing'
        ];
        let currentStepIndex = 0;
        let token = '';
        let totalScore = 0;
        let completedModules = 0;

        // Global scan function callable from onsubmit
        window.runSeoScan = function () {
            console.log('Starting SEO Scan...');

            const urlVal = document.getElementById('url').value;
            const keywordsVal = document.getElementById('keywords').value;

            if (!urlVal) {
                showError('Please enter a website URL');
                return;
            }

            // Reset UI
            currentStepIndex = 0;
            totalScore = 0;
            completedModules = 0;
            document.getElementById('modulesContainer').innerHTML = '';
            document.getElementById('progressSection').classList.remove('hidden');
            document.getElementById('resultsGrid').classList.remove('hidden');

            // Auto-scroll to results
            document.getElementById('progressSection').scrollIntoView({ behavior: 'smooth', block: 'center' });

            const btn = document.querySelector('#seoForm button');
            btn.disabled = true;
            btn.classList.add('opacity-75');

            // Init Scan
            fetch('{{ route("seo.on-page-seo-checker.init") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    url: urlVal,
                    keywords: keywordsVal
                })
            })
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        token = res.token;
                        processNextStep();
                    } else {
                        throw new Error(res.message);
                    }
                })
                .catch(error => {
                    showError('Failed to initialize scan: ' + error.message);
                    btn.disabled = false;
                    btn.classList.remove('opacity-75');
                });
        };

        function processNextStep() {
            if (currentStepIndex >= steps.length) {
                finishScan();
                return;
            }

            const step = steps[currentStepIndex];
            const percent = Math.round(((currentStepIndex) / steps.length) * 100);
            updateProgress(percent, `Analyzing ${step.replace('_', ' ')}...`);

            const urlVal = document.getElementById('url').value;
            const keywordsVal = document.getElementById('keywords').value;

            fetch('{{ route("seo.on-page-seo-checker.analyze-step") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    token: token,
                    step: step,
                    url: urlVal,
                    keywords: keywordsVal
                })
            })
                .then(response => response.json())
                .then(res => {
                    if (res.success) {
                        renderModuleResult(res.result);
                        totalScore += res.result.score;
                        completedModules++;
                        updateScoreDisplay();
                    }
                    currentStepIndex++;
                    processNextStep();
                })
                .catch(() => {
                    currentStepIndex++;
                    processNextStep();
                });
        }

        function updateProgress(percent, status) {
            document.getElementById('progressBar').style.width = percent + '%';
            document.getElementById('progressPercent').innerText = percent + '%';
            document.getElementById('progressStatus').innerText = status;
        }

        function updateScoreDisplay() {
            const avg = Math.round(totalScore / Math.max(1, completedModules));
            document.getElementById('finalScore').innerText = avg;
            document.getElementById('desktopScore').innerText = avg;
            document.getElementById('mobileScore').innerText = Math.max(0, avg - 5);
        }

        function renderModuleResult(data) {
            const colorClass = data.status === 'pass' ? 'border-green-200 bg-green-50' : (data.status === 'warning' ?
                'border-yellow-200 bg-yellow-50' : 'border-red-200 bg-red-50');
            const icon = data.status === 'pass' ? '✅' : (data.status === 'warning' ? '⚠️' : '❌');

            let detailsHtml = '';
            if (data.details && typeof data.details === 'object') {
                detailsHtml = '<div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-4 bg-white/50 p-3 rounded-lg text-sm">';
                for (const [key, value] of Object.entries(data.details)) {
                    detailsHtml += `
                                            <div class="flex flex-col">
                                                <span class="text-xs text-uppercase text-gray-500 font-bold">${key.replace(/_/g, ' ')}</span>
                                                <span class="font-bold text-gray-800">${value}</span>
                                            </div>
                                            `;
                }
                detailsHtml += '</div>';
            }

            const html = `
                                        <div class="bg-white rounded-2xl p-6 shadow-sm border-2 ${colorClass} transition-all duration-500 animate-fade-in-up">
                                            <div class="flex justify-between items-start mb-4">
                                                <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                                    <span>${icon}</span> ${data.title}
                                                </h3>
                                                <span
                                                    class="font-black text-2xl ${data.status === 'pass' ? 'text-green-600' : 'text-gray-600'}">${data.score}</span>
                                            </div>
                                            <p class="text-gray-700 font-medium mb-3">${data.explanation}</p>
                                            ${data.fix ? `<div class="bg-white/50 p-3 rounded-lg text-sm text-gray-600 mb-3"><span
                                                    class="font-bold">Recommendation:</span> ${data.fix}</div>` : ''}
                                            ${detailsHtml}
                                        </div>
                                        `;
            const container = document.getElementById('modulesContainer');
            const div = document.createElement('div');
            div.innerHTML = html;
            container.appendChild(div.firstElementChild);
        }

        function finishScan() {
            updateProgress(100, 'Scan Complete!');
            const btn = document.querySelector('#seoForm button');
            btn.disabled = false;
            btn.classList.remove('opacity-75');

            const exportBtn = document.getElementById('exportBtn');
            exportBtn.disabled = false;
            exportBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            exportBtn.classList.add('hover:scale-105');

            // Set download action
            exportBtn.onclick = function () {
                window.location.href = '{{ route("seo.on-page-seo-checker.export") }}?token=' + token;
            };

            document.getElementById('progressBar').classList.remove('from-indigo-500');
            document.getElementById('progressBar').classList.add('bg-green-500');
        }

        // Bind fallback on load just in case
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('seoForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    window.runSeoScan();
                });
            }
        });
    </script>
@endpush