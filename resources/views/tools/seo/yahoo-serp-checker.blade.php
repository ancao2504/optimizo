@extends('layouts.app')

@section('title', __tool('yahoo-serp-checker', 'meta.title'))
@section('meta_description', __tool('yahoo-serp-checker', 'meta.description'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <x-tool-hero :tool="$tool" />

        <!-- Tool Interface -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ __tool('yahoo-serp-checker', 'interface.simulation_title') }}
                </h2>
                <div class="h-1 w-16 bg-gradient-to-r from-purple-600 to-indigo-600 mx-auto rounded-full"></div>
            </div>

            <form id="serpForm" onsubmit="handleSearch(event)" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Keyword Input -->
                    <div>
                        <label for="keyword" class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __tool('yahoo-serp-checker', 'interface.keyword_label') }}
                        </label>
                        <input type="text" id="keyword" name="keyword" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-medium text-gray-900 placeholder-gray-400 text-base transition-colors hover:border-indigo-300"
                            placeholder="{{ __tool('yahoo-serp-checker', 'form.keyword_placeholder') }}">
                    </div>

                    <!-- Location Input -->
                    <div class="relative">
                        <label for="locationInput" class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __tool('yahoo-serp-checker', 'interface.location_label') }}
                        </label>
                        <input type="text" id="locationInput" autocomplete="off"
                            class="no-paste w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-medium text-gray-900 placeholder-gray-400 text-base transition-colors hover:border-indigo-300"
                            placeholder="{{ __tool('yahoo-serp-checker', 'form.location_placeholder') }}">
                        <!-- Yahoo location is less precise with parameters, but adding it to query helps -->
                        <div id="locationDropdown"
                            class="hidden absolute z-50 w-full mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 max-h-60 overflow-y-auto custom-scrollbar ring-1 ring-black/5">
                        </div>
                    </div>

                    <!-- Yahoo Domain/Market -->
                    <div>
                        <label for="yahooDomain" class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __tool('yahoo-serp-checker', 'interface.yahoo_domain_label') }}
                        </label>
                        <div class="relative">
                            <select id="yahooDomain"
                                class="appearance-none w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-medium text-gray-700 bg-white pr-10 cursor-pointer hover:border-indigo-300 transition-colors">
                                <option value="search.yahoo.com" data-vc="us">
                                    {{ __tool('yahoo-serp-checker', 'domains.us') }}
                                </option>
                                <option value="uk.search.yahoo.com" data-vc="uk">
                                    {{ __tool('yahoo-serp-checker', 'domains.uk') }}
                                </option>
                                <option value="ca.search.yahoo.com" data-vc="ca">
                                    {{ __tool('yahoo-serp-checker', 'domains.ca') }}
                                </option>
                                <option value="au.search.yahoo.com" data-vc="au">
                                    {{ __tool('yahoo-serp-checker', 'domains.au') }}
                                </option>
                                <option value="de.search.yahoo.com" data-vc="de">
                                    {{ __tool('yahoo-serp-checker', 'domains.de') }}
                                </option>
                                <option value="fr.search.yahoo.com" data-vc="fr">
                                    {{ __tool('yahoo-serp-checker', 'domains.fr') }}
                                </option>
                                <option value="it.search.yahoo.com" data-vc="it">
                                    {{ __tool('yahoo-serp-checker', 'domains.it') }}
                                </option>
                                <option value="es.search.yahoo.com" data-vc="es">
                                    {{ __tool('yahoo-serp-checker', 'domains.es') }}
                                </option>
                                <option value="br.search.yahoo.com" data-vc="br">
                                    {{ __tool('yahoo-serp-checker', 'domains.br') }}
                                </option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Device Type -->
                    <div>
                        <label for="deviceType" class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __tool('yahoo-serp-checker', 'interface.device_label') }}
                        </label>
                        <div class="relative">
                            <select id="deviceType"
                                class="appearance-none w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-medium text-gray-700 bg-white pr-10 cursor-pointer hover:border-indigo-300 transition-colors">
                                <option value="desktop">{{ __tool('yahoo-serp-checker', 'interface.device_desktop') }}
                                </option>
                                <option value="mobile">{{ __tool('yahoo-serp-checker', 'interface.device_mobile') }}
                                </option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-indigo-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="btn-primary w-full px-8 py-4 rounded-xl flex items-center justify-center gap-3 transform hover:-translate-y-0.5 transition-all shadow-lg hover:shadow-xl text-lg font-bold bg-indigo-600 hover:bg-indigo-700 text-white border-none">
                        <span>{{ __tool('yahoo-serp-checker', 'form.button') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                    <p class="text-center text-xs font-bold text-gray-400 mt-4 uppercase tracking-wider">
                        <span class="text-indigo-600">✔</span> {{ __tool('yahoo-serp-checker', 'interface.no_login') }}
                        &nbsp;•&nbsp; <span class="text-indigo-600">✔</span>
                        {{ __tool('yahoo-serp-checker', 'interface.realtime_results') }}
                    </p>
                </div>
            </form>
        </div>

        <!-- content blocks -->
        <div
            class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl mt-8">
            <div class="text-center mb-16">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl shadow-xl mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">
                    {{ __tool('yahoo-serp-checker', 'content.main_title') }}
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    {{ __tool('yahoo-serp-checker', 'content.main_subtitle') }}
                </p>
            </div>

            <!-- Feature Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border-2 border-transparent hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-3">
                        {{ __tool('yahoo-serp-checker', 'content.feature1_title') }}
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ __tool('yahoo-serp-checker', 'content.feature1_desc') }}
                    </p>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border-2 border-transparent hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-600 mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-3">
                        {{ __tool('yahoo-serp-checker', 'content.feature2_title') }}
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ __tool('yahoo-serp-checker', 'content.feature2_desc') }}
                    </p>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-lg border-2 border-transparent hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-xl text-gray-900 mb-3">
                        {{ __tool('yahoo-serp-checker', 'content.feature3_title') }}
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ __tool('yahoo-serp-checker', 'content.feature3_desc') }}
                    </p>
                </div>
            </div>

            <!-- Deep Dive Content -->
            <div class="bg-white rounded-2xl p-8 mb-12 border-l-4 border-indigo-500 shadow-sm">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">
                    {{ __tool('yahoo-serp-checker', 'content.why_matters_title') }}
                </h3>
                <p class="mb-6 text-gray-700 leading-relaxed">
                    {{ __tool('yahoo-serp-checker', 'content.why_matters_desc') }}
                </p>
                <h4 class="text-lg font-bold text-gray-900 mb-3">
                    {{ __tool('yahoo-serp-checker', 'content.same_as_bing_title') }}
                </h4>
                <p class="mb-4 text-gray-700">
                    {!! __tool('yahoo-serp-checker', 'content.same_as_bing_desc') !!}
                </p>
            </div>

            <!-- FAQ Section -->
            <div class="mb-8">
                <h3 class="text-3xl font-black text-center text-gray-900 mb-10">
                    {{ __tool('yahoo-serp-checker', 'faq.title') }}
                </h3>
                <div class="space-y-4 max-w-3xl mx-auto">
                    <!-- FAQ Item 1 -->
                    <details class="group bg-white rounded-2xl shadow-sm border border-indigo-100 overflow-hidden">
                        <summary
                            class="flex justify-between items-center font-bold text-gray-800 cursor-pointer list-none p-6 hover:bg-gray-50 transition-colors">
                            <span>{{ __tool('yahoo-serp-checker', 'faq.q1') }}</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-indigo-600">
                                <svg fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <div class="text-gray-600 p-6 pt-0 leading-relaxed">
                            {{ __tool('yahoo-serp-checker', 'faq.a1') }}
                        </div>
                    </details>

                    <!-- FAQ Item 2 -->
                    <details class="group bg-white rounded-2xl shadow-sm border border-indigo-100 overflow-hidden">
                        <summary
                            class="flex justify-between items-center font-bold text-gray-800 cursor-pointer list-none p-6 hover:bg-gray-50 transition-colors">
                            <span>{{ __tool('yahoo-serp-checker', 'faq.q2') }}</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-indigo-600">
                                <svg fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <div class="text-gray-600 p-6 pt-0 leading-relaxed">
                            {{ __tool('yahoo-serp-checker', 'faq.a2') }}
                        </div>
                    </details>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize elements
        const locationInput = document.getElementById('locationInput');
        const locationDropdown = document.getElementById('locationDropdown');
        const yahooDomainSelect = document.getElementById('yahooDomain');
        let searchTimeout;

        // Input handler with Debounce
        locationInput.addEventListener('input', function () {
            const query = this.value;
            locationDropdown.innerHTML = '';

            clearTimeout(searchTimeout);

            if (query.length < 2) {
                locationDropdown.classList.add('hidden');
                return;
            }

            searchTimeout = setTimeout(() => {
                fetch(`{{ route('seo.locations.search') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(locations => {
                        locationDropdown.innerHTML = '';
                        if (locations.length > 0) {
                            locationDropdown.classList.remove('hidden');
                            locations.forEach(loc => {
                                const div = document.createElement('div');
                                div.className = 'px-4 py-3 hover:bg-indigo-50 cursor-pointer text-sm font-medium text-gray-700 border-b border-gray-50 last:border-0 transition-colors pointer-events-auto';
                                div.textContent = loc.name;
                                div.onclick = () => {
                                    locationInput.value = loc.name;
                                    locationDropdown.classList.add('hidden');
                                };
                                locationDropdown.appendChild(div);
                            });
                        } else {
                            locationDropdown.classList.add('hidden');
                        }
                    })
                    .catch(e => console.error(e));
            }, 300); // 300ms debounce
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (e.target !== locationInput && e.target !== locationDropdown) {
                locationDropdown.classList.add('hidden');
            }
        });

        function handleSearch(e) {
            e.preventDefault();
            const keyword = document.getElementById('keyword').value;
            const domain = yahooDomainSelect.value;
            const selectedOption = yahooDomainSelect.options[yahooDomainSelect.selectedIndex];
            const vc = selectedOption.getAttribute('data-vc');
            const device = document.getElementById('deviceType').value;
            const location = locationInput.value;

            let finalQuery = keyword;
            if (location && location.trim() !== '') {
                finalQuery += ` ${location}`; // Append location to query for Yahoo
            }

            let url = `https://${domain}/search?p=${encodeURIComponent(finalQuery)}`;
            if (vc) {
                url += `&vc=${vc}`;
            }

            if (device === 'mobile') {
                window.open(url, 'yahoo_serp_mobile', 'width=414,height=896,menubar=no,toolbar=no,location=yes,status=yes,scrollbars=yes,resizable=yes,left=100,top=100');
            } else {
                window.open(url, '_blank');
            }
        }
    </script>
@endpush

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #a5b4fc;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #818cf8;
        }
    </style>
@endpush