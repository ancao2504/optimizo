@extends('layouts.app')

@section('title', __tool('redirect-checker', 'meta.title'))
@section('meta_description', __tool('redirect-checker', 'meta.description'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <!-- Hero Section -->
        <x-tool-hero :tool="$tool" icon="redirect-checker" />

        <!-- Tool Interface -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    {{ __tool('redirect-checker', 'form.url_label') }}
                </label>
                <textarea id="urlInput" rows="6"
                    class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent font-mono text-sm"
                    placeholder="{{ __tool('redirect-checker', 'form.url_placeholder') }}"></textarea>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-xs text-gray-500" id="urlCount">0 / 10 URLs</span>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="checkCanonical"
                            class="w-4 h-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                        <span class="ml-2 text-sm text-gray-700">{{ __tool('redirect-checker', 'form.canonical_check') }}</span>
                    </label>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ __tool('redirect-checker', 'form.user_agent_label') }}
                    </div>
                </label>
                <div class="relative">
                    <select id="userAgent"
                        class="appearance-none w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm bg-white pr-10 cursor-pointer hover:border-purple-300 transition-colors">
                        <option value="">{{ __tool('redirect-checker', 'form.user_agent_default') }}</option>
                        <option value="Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)">{{ __tool('redirect-checker', 'form.user_agent_googlebot') }}</option>
                        <option value="Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)">{{ __tool('redirect-checker', 'form.user_agent_bingbot') }}</option>
                        <option value="facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)">{{ __tool('redirect-checker', 'form.user_agent_facebook') }}</option>
                        <option
                            value="Mozilla/5.0 (iPhone; CPU iPhone OS 14_0 like Mac OS X)">
                            {{ __tool('redirect-checker', 'form.user_agent_iphone') }}</option>
                        <option
                            value="Mozilla/5.0 (Linux; Android 10)">
                            {{ __tool('redirect-checker', 'form.user_agent_android') }}</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <button onclick="checkURLs()" class="btn-primary w-full px-8 py-3 mb-8 flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>{{ __tool('redirect-checker', 'form.button') }}</span>
            </button>

            <!-- Loading State -->
            <div id="loading" class="hidden text-center py-8">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600"></div>
                <p class="mt-4 text-gray-600" id="loadingText">{{ __tool('redirect-checker', 'loading.analyzing') }}</p>
                <div id="bulkProgress" class="hidden mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progressBar" class="bg-purple-600 h-2 rounded-full transition-all" style="width: 0%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2" id="progressText">0 / 0 URLs checked</p>
                </div>
            </div>

            <!-- Results Container -->
            <div id="resultsContainer" class="hidden space-y-4 mt-8">
                <!-- Results will be injected here -->
            </div>

            <!-- Bulk Results (Hidden by default, used for export logic mostly, but we render directly to resultsContainer now) -->
            <div id="bulkResults" class="hidden"></div>

            @include('components.hero-actions')
        </div>

        <!-- SEO Content -->
        <div
            class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl mt-8">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-xl mb-4">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-gray-900 mb-3">{{ __tool('redirect-checker', 'content.main_title') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ __tool('redirect-checker', 'content.main_subtitle') }}</p>
            </div>

            <p class="text-gray-700 leading-relaxed text-lg mb-8">
                {{ __tool('redirect-checker', 'content.intro') }}
            </p>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('redirect-checker', 'content.features_title') }}</h3>
            <div class="grid md:grid-cols-2 gap-5 mb-10">
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-purple-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">🔄</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('redirect-checker', 'content.feature1_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('redirect-checker', 'content.feature1_desc') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-pink-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">🌐</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('redirect-checker', 'content.feature2_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('redirect-checker', 'content.feature2_desc') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-red-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">🔍</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('redirect-checker', 'content.feature3_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('redirect-checker', 'content.feature3_desc') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-indigo-300 transition-all shadow-lg hover:shadow-xl">
                    <div class="text-3xl mb-3">📊</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('redirect-checker', 'content.feature4_title') }}</h4>
                    <p class="text-gray-600 text-sm">{{ __tool('redirect-checker', 'content.feature4_desc') }}</p>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __tool('redirect-checker', 'content.what_are_redirects_title') }}</h3>
            <p class="text-gray-700 leading-relaxed mb-4">
                {{ __tool('redirect-checker', 'content.what_are_redirects_desc') }}
            </p>

            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __tool('redirect-checker', 'content.status_codes_title') }}</h3>
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-lg p-4 border-2 border-green-200">
                    <h4 class="font-bold text-green-900 mb-2">{{ __tool('redirect-checker', 'content.status_2xx_title') }}</h4>
                    <p class="text-gray-700 text-sm">{{ __tool('redirect-checker', 'content.status_2xx_desc') }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-blue-200">
                    <h4 class="font-bold text-blue-900 mb-2">{{ __tool('redirect-checker', 'content.status_3xx_title') }}</h4>
                    <p class="text-gray-700 text-sm">{{ __tool('redirect-checker', 'content.status_3xx_desc') }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-yellow-200">
                    <h4 class="font-bold text-yellow-900 mb-2">{{ __tool('redirect-checker', 'content.status_4xx_title') }}</h4>
                    <p class="text-gray-700 text-sm">{{ __tool('redirect-checker', 'content.status_4xx_desc') }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-red-200">
                    <h4 class="font-bold text-red-900 mb-2">{{ __tool('redirect-checker', 'content.status_5xx_title') }}</h4>
                    <p class="text-gray-700 text-sm">{{ __tool('redirect-checker', 'content.status_5xx_desc') }}</p>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mb-3">301 vs 302 Redirects: Which to Use?</h3>
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-lg p-4 border-2 border-purple-200">
                    <h4 class="font-bold text-purple-900 mb-3">{{ __tool('redirect-checker', 'content.redirect_301_title') }}</h4>
                    <ul class="text-gray-700 text-sm space-y-2">
                        <li>{!! __tool('redirect-checker', 'content.redirect_301_when') !!}</li>
                        <li>{!! __tool('redirect-checker', 'content.redirect_301_seo') !!}</li>
                        <li>{!! __tool('redirect-checker', 'content.redirect_301_cache') !!}</li>
                    </ul>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-pink-200">
                    <h4 class="font-bold text-pink-900 mb-3">{{ __tool('redirect-checker', 'content.redirect_302_title') }}</h4>
                    <ul class="text-gray-700 text-sm space-y-2">
                        <li>{!! __tool('redirect-checker', 'content.redirect_302_when') !!}</li>
                        <li>{!! __tool('redirect-checker', 'content.redirect_302_seo') !!}</li>
                        <li>{!! __tool('redirect-checker', 'content.redirect_302_cache') !!}</li>
                    </ul>
                </div>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __tool('redirect-checker', 'content.why_check_title') }}</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6 leading-relaxed">
                <li>{!! __tool('redirect-checker', 'content.why_check_1') !!}</li>
                <li>{!! __tool('redirect-checker', 'content.why_check_2') !!}</li>
                <li>{!! __tool('redirect-checker', 'content.why_check_3') !!}</li>
                <li>{!! __tool('redirect-checker', 'content.why_check_4') !!}</li>
                <li>{!! __tool('redirect-checker', 'content.why_check_5') !!}</li>
                <li>{!! __tool('redirect-checker', 'content.why_check_6') !!}</li>
                <li>{!! __tool('redirect-checker', 'content.why_check_7') !!}</li>
            </ul>

            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __tool('redirect-checker', 'content.redirect_chains_title') }}</h3>
            <p class="text-gray-700 leading-relaxed mb-4">
                {{ __tool('redirect-checker', 'content.redirect_chains_desc') }}
            </p>
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-5 border-2 border-yellow-200 mb-6">
                <h4 class="font-bold text-yellow-900 mb-3">🚦 Redirect Chain Impact</h4>
                <ul class="text-yellow-800 text-sm space-y-2">
                    <li>{!! __tool('redirect-checker', 'content.chain_recommended') !!}</li>
                    <li>{!! __tool('redirect-checker', 'content.chain_acceptable') !!}</li>
                    <li>{!! __tool('redirect-checker', 'content.chain_problematic') !!}</li>
                </ul>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __tool('redirect-checker', 'content.redirect_loops_title') }}</h3>
            <p class="text-gray-700 leading-relaxed mb-6">
                {{ __tool('redirect-checker', 'content.redirect_loops_desc') }}
            </p>

            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __tool('redirect-checker', 'content.common_issues_title') }}</h3>
            <div class="space-y-3 mb-6">
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('redirect-checker', 'content.issue1_title') }}</h4>
                    <p class="text-gray-700 text-sm mb-2">{!! __tool('redirect-checker', 'content.issue1_problem') !!}</p>
                    <p class="text-gray-700 text-sm">{!! __tool('redirect-checker', 'content.issue1_solution') !!}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('redirect-checker', 'content.issue2_title') }}</h4>
                    <p class="text-gray-700 text-sm mb-2">{!! __tool('redirect-checker', 'content.issue2_problem') !!}</p>
                    <p class="text-gray-700 text-sm">{!! __tool('redirect-checker', 'content.issue2_solution') !!}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('redirect-checker', 'content.issue3_title') }}</h4>
                    <p class="text-gray-700 text-sm mb-2">{!! __tool('redirect-checker', 'content.issue3_problem') !!}</p>
                    <p class="text-gray-700 text-sm">{!! __tool('redirect-checker', 'content.issue3_solution') !!}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool('redirect-checker', 'content.issue4_title') }}</h4>
                    <p class="text-gray-700 text-sm mb-2">{!! __tool('redirect-checker', 'content.issue4_problem') !!}</p>
                    <p class="text-gray-700 text-sm">{!! __tool('redirect-checker', 'content.issue4_solution') !!}</p>
                </div>
            </div>

            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6 mb-6">
                <h4 class="font-bold text-yellow-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __tool('redirect-checker', 'content.best_practices_title') }}
                </h4>
                <ul class="text-yellow-800 text-sm leading-relaxed space-y-2">
                    <li>{{ __tool('redirect-checker', 'content.best_practice1') }}</li>
                    <li>{{ __tool('redirect-checker', 'content.best_practice2') }}</li>
                    <li>{{ __tool('redirect-checker', 'content.best_practice3') }}</li>
                    <li>{{ __tool('redirect-checker', 'content.best_practice4') }}</li>
                    <li>{{ __tool('redirect-checker', 'content.best_practice5') }}</li>
                    <li>{{ __tool('redirect-checker', 'content.best_practice6') }}</li>
                    <li>{{ __tool('redirect-checker', 'content.best_practice7') }}</li>
                </ul>
            </div>

            <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __tool('redirect-checker', 'faq.title') }}</h3>
            <div class="space-y-4">
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('redirect-checker', 'faq.q1') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('redirect-checker', 'faq.a1') }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('redirect-checker', 'faq.q2') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('redirect-checker', 'faq.a2') }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('redirect-checker', 'faq.q3') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('redirect-checker', 'faq.a3') }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('redirect-checker', 'faq.q4') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('redirect-checker', 'faq.a4') }}</p>
                </div>
                <div class="bg-white rounded-lg p-4 border-2 border-gray-200">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('redirect-checker', 'faq.q5') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('redirect-checker', 'faq.a5') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .tab-btn {
            border-bottom-color: transparent;
            color: #6b7280;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: #9333ea;
            border-bottom-color: #e9d5ff;
        }

        .tab-btn.active {
            color: #9333ea;
            border-bottom-color: #9333ea;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Global data storage
        let resultsStore = [];

        // Updated helper to get status badge class
        function getStatusBadgeClass(hop) {
            const status = hop.status;
            if (status === 'Loop' || status === 'LOOP') return 'bg-red-500 text-white';
            if (status >= 200 && status < 300) return 'bg-green-600 text-white';
            if (status >= 300 && status < 400) return 'bg-yellow-500 text-white';
            if (status >= 400 && status < 600) return 'bg-red-500 text-white';
            return 'bg-gray-500 text-white';
        }

        // Updated helper for icon
        function getStatusIconSVG(hop) {
            if (hop.isRedirect) return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>`; // Shuffle/Redirect icon
            if (hop.isSuccess) return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`; // Check icon
            if (hop.isBroken || hop.isLoop) return `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`; // X icon
            return '';
        }

        async function checkURLs() {
            const input = document.getElementById('urlInput').value.trim();
            let urls = input.split('\n').filter(url => url.trim());
            const canonicalCheck = document.getElementById('checkCanonical').checked;

            if (urls.length === 0) {
                showError('Please enter at least one URL');
                return;
            }

            // Limit to 10
            urls = urls.slice(0, 10);

            // Show loading
            document.getElementById('loading').classList.remove('hidden');
            document.getElementById('resultsContainer').classList.add('hidden');
            document.getElementById('resultsContainer').innerHTML = ''; // Clear previous
            resultsStore = [];

            // Determine check mode
            if (canonicalCheck) {
                // Canonical Check Mode - check all 4 versions for each URL
                document.getElementById('bulkProgress').classList.remove('hidden');
                let totalChecks = 0;
                const totalUrls = urls.length;

                for (const url of urls) {
                    await runCanonicalCheck(url);
                    totalChecks++;
                    const progress = (totalChecks / totalUrls) * 100;
                    document.getElementById('progressBar').style.width = progress + '%';
                    document.getElementById('progressText').textContent = `${totalChecks} / ${totalUrls} domains checked`;
                }

                document.getElementById('loading').classList.add('hidden');
                renderResults();
            } else {
                // Normal Check Mode (Single or Bulk)
                await runBulkCheck(urls);
            }
        }

        async function runCanonicalCheck(url) {
            try {
                const response = await fetch('{{ route('seo.redirect-checker.canonical') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        url: url,
                        user_agent: document.getElementById('userAgent').value
                    })
                });

                if (!response.ok) throw new Error('Investigation failed');
                const data = await response.json();

                // data.versions is array of check results (now with full chains)
                // Append to resultsStore instead of replacing

                // Extract base domain for grouping
                const parsedUrl = new URL(url.startsWith('http') ? url : 'https://' + url);
                const baseDomain = parsedUrl.hostname.replace(/^www\./, '');

                const newResults = data.versions.map(v => ({
                    originalUrl: v.url,
                    chain: v.chain,
                    error: v.error,
                    isCanonical: true,
                    baseDomain: baseDomain
                }));


                resultsStore.push(...newResults);

            } catch (e) {
                console.error(e);
                showError('Error checking canonical versions for: ' + url);
            }
        }

        async function runBulkCheck(urls) {
            let completed = 0;
            // Show progress bar
            document.getElementById('bulkProgress').classList.remove('hidden');

            for (const url of urls) {
                try {
                    // Normalize URL
                    let checkUrl = url.trim();
                    if (!checkUrl.match(/^https?:\/\//i)) checkUrl = 'https://' + checkUrl;

                    // Call standard check API
                    const response = await fetch('{{ route('seo.redirect-checker.check') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            url: checkUrl,
                            user_agent: document.getElementById('userAgent').value
                        })
                    });

                    if (!response.ok) throw new Error('Failed');
                    const data = await response.json();

                    resultsStore.push({
                        originalUrl: url,
                        chain: data.chain,
                        // ... stats
                    });

                } catch (e) {
                    resultsStore.push({
                        originalUrl: url,
                        error: e.message
                    });
                }

                completed++;
                const progress = (completed / urls.length) * 100;
                document.getElementById('progressBar').style.width = progress + '%';
                document.getElementById('progressText').textContent = `${completed} / ${urls.length} URLs checked`;
            }

            document.getElementById('loading').classList.add('hidden');
            renderResults();
        }

        function renderResults() {
            const container = document.getElementById('resultsContainer');
            container.innerHTML = '';
            container.classList.remove('hidden');

            let lastBaseDomain = null;

            resultsStore.forEach((result, index) => {
                // Check if we need a domain header (for canonical checks)
                if (result.isCanonical && result.baseDomain !== lastBaseDomain) {
                    const headerEl = document.createElement('div');
                    headerEl.className = 'mt-6 mb-3 flex items-center gap-2 px-1';
                    headerEl.innerHTML = `
                                    <div class="h-px bg-gray-200 flex-grow"></div>
                                    <span class="text-sm font-bold text-gray-500 uppercase tracking-wider bg-gray-50 px-3 rounded-full border border-gray-200">
                                        ${result.baseDomain}
                                    </span>
                                    <div class="h-px bg-gray-200 flex-grow"></div>
                                `;
                    container.appendChild(headerEl);
                    lastBaseDomain = result.baseDomain;
                }

                // Determine display data
                let finalStatus = 'Unknown';
                let finalStatusClass = 'bg-gray-500';
                let chain = [];

                if (result.error) {
                    finalStatus = 'Error';
                    finalStatusClass = 'bg-red-500 text-white';
                } else if (result.chain) {
                    chain = result.chain;
                    const finalHop = chain[chain.length - 1];
                    finalStatus = finalHop.status;
                    finalStatusClass = getStatusBadgeClass(finalHop);
                }

                const resultEl = document.createElement('div');
                resultEl.className = 'bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden';

                // Header Row
                const displayUrl = result.originalUrl || (chain[0] ? chain[0].url : 'Unknown URL');
                const hasChain = chain.length > 1;

                resultEl.innerHTML = `
                                                    <div class="p-4 flex items-center justify-between cursor-pointer hover:bg-gray-50 transition-colors" onclick="toggleChain(${index})">
                                                        <div class="flex items-center gap-3 overflow-hidden">
                                                            <div class="text-gray-400">
                                                                ${hasChain ? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>' : ''}
                                                            </div>
                                                            <div class="font-mono text-sm text-gray-700 truncate pr-4">${displayUrl}</div>
                                                        </div>
                                                        <div class="flex items-center gap-3 shrink-0">
                                                            ${hasChain ? `<button class="text-gray-400 hover:text-purple-600 transition-transform duration-200" id="chevron-${index}">
                                                                <svg class="w-5 h-5 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                                            </button>` : ''}
                                                            <span class="px-2.5 py-1 rounded text-xs font-bold ${finalStatusClass}">${finalStatus}</span>
                                                            <button onclick="copyToClipboard('${displayUrl}', event)" class="text-gray-400 hover:text-gray-600" title="Copy URL">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/></svg>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    ${hasChain ? `
                                                    <div id="chain-${index}" class="hidden bg-gray-50 border-t border-gray-100">
                                                        ${renderChainSteps(chain)}
                                                    </div>
                                                    ` : ''}
                                                `;

                container.appendChild(resultEl);
            });
        }

        function renderChainSteps(chain) {
            return chain.map((hop, i) => `
                                                <div class="p-3 pl-8 border-b border-gray-100 last:border-0 flex items-center justify-between hover:bg-gray-100 transition-colors">
                                                    <div class="flex items-center gap-3 overflow-hidden">
                                                        <div class="${hop.isRedirect ? 'text-blue-500' : (hop.isSuccess ? 'text-green-500' : 'text-gray-400')}">
                                                             ${getStatusIconSVG(hop)}
                                                        </div>
                                                        <div class="font-mono text-xs text-gray-600 truncate">${hop.url}</div>
                                                    </div>
                                                    ${hop.status !== '???' ? `<span class="px-2 py-0.5 rounded text-[10px] font-bold ${getStatusBadgeClass(hop)}">${hop.status}</span>` : ''}
                                                </div>
                                            `).join('');
        }

        function toggleChain(index) {
            const chainEl = document.getElementById(`chain-${index}`);
            const chevron = document.getElementById(`chevron-${index}`);
            if (chainEl) {
                chainEl.classList.toggle('hidden');
                if (chevron) {
                    chevron.classList.toggle('rotate-180');
                }
            }
        }

        function copyToClipboard(text, e) {
            e.stopPropagation();
            navigator.clipboard.writeText(text);
            // Could show a toast
        }

        // Allow Enter key to trigger check (Ctrl+Enter for multi-line input)
        document.getElementById('urlInput').addEventListener('keypress', function (e) {
            if (e.key === 'Enter' && e.ctrlKey) {
                e.preventDefault();
                checkURLs();
            }
        });

        // Restore URL Counter
        const urlInput = document.getElementById('urlInput');
        if (urlInput) {
            urlInput.addEventListener('input', function () {
                const urls = this.value.trim().split('\n').filter(url => url.trim());
                const count = Math.min(urls.length, 10);
                document.getElementById('urlCount').textContent = `${count} / 10 URLs`;
            });
        }
    </script>
@endpush