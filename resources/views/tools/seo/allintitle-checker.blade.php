@extends('layouts.app')

@section('title', __tool('google-allintitle-checker', 'meta.title'))
@section('meta_description', __tool('google-allintitle-checker', 'meta.description'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <x-tool-hero :tool="$tool" />

        <!-- Tool Interface -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ __tool('google-allintitle-checker', 'interface.title') }}
                </h2>
                <div class="h-1 w-16 bg-gradient-to-r from-indigo-600 to-purple-600 mx-auto rounded-full"></div>
            </div>

            <form id="allintitleForm" onsubmit="handleSearch(event)" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Keyword Input -->
                    <div>
                        <label for="keyword" class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __tool('google-allintitle-checker', 'interface.keyword_label') }}
                        </label>
                        <input type="text" id="keyword" name="keyword" required
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-medium text-gray-900 placeholder-gray-400 text-base transition-colors hover:border-indigo-300"
                            placeholder="{{ __tool('google-allintitle-checker', 'interface.keyword_placeholder') }}">
                    </div>

                    <!-- Location Input -->
                    <div class="relative">
                        <label for="locationInput" class="block text-sm font-bold text-gray-700 mb-2">
                            {{ __tool('google-allintitle-checker', 'interface.location_label') }}
                        </label>
                        <input type="text" id="locationInput" autocomplete="off"
                            class="no-paste w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-medium text-gray-900 placeholder-gray-400 text-base transition-colors hover:border-indigo-300"
                            placeholder="{{ __tool('google-allintitle-checker', 'interface.location_placeholder') }}">
                        <input type="hidden" id="selectedUULE">
                        <div id="locationDropdown"
                            class="hidden absolute z-50 w-full mt-2 bg-white rounded-xl shadow-2xl border border-gray-100 max-h-60 overflow-y-auto custom-scrollbar ring-1 ring-black/5">
                        </div>
                    </div>
                </div>

                <div class="pt-4 text-center">
                    <button type="submit"
                        class="btn-primary w-full md:w-auto px-12 py-4 rounded-xl flex items-center justify-center gap-3 transform hover:-translate-y-0.5 transition-all shadow-lg hover:shadow-xl text-lg font-bold mx-auto">
                        <span>{{ __tool('google-allintitle-checker', 'interface.button') }}</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                    <p class="text-center text-xs font-bold text-gray-400 mt-4 uppercase tracking-wider">
                        <span class="text-indigo-600">✔</span> {{ __tool('google-allintitle-checker', 'interface.no_login') }}
                        &nbsp;•&nbsp; <span class="text-indigo-600">✔</span>
                        {{ __tool('google-allintitle-checker', 'interface.realtime') }}
                    </p>
                </div>
            </form>
        </div>

        <!-- SEO Content Section -->
        <div class="bg-gradient-to-br from-indigo-50 via-white to-purple-50 rounded-3xl p-8 md:p-12 border-2 border-indigo-100 shadow-xl mt-8">
            
            <!-- Introduction -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                <div>
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6 leading-tight">
                        {{ __tool('google-allintitle-checker', 'content.main_title') }}
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed mb-6">
                        {{ __tool('google-allintitle-checker', 'content.main_subtitle') }}
                    </p>
                    <div class="bg-white p-6 rounded-2xl border-l-4 border-indigo-500 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-2">{{ __tool('google-allintitle-checker', 'content.what_is_title') }}</h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {!! __tool('google-allintitle-checker', 'content.what_is_desc') !!}
                        </p>
                    </div>
                </div>
                <div class="relative group">
                    <div class="absolute -inset-4 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-3xl blur opacity-20 group-hover:opacity-30 transition duration-1000"></div>
                    <img src="{{ asset('assets/img/tools/google-allintitle-checker/allintitle-mockup.png') }}" 
                         alt="Google Allintitle Search Simulation" 
                         class="relative rounded-2xl shadow-2xl border border-white transform transition duration-500 hover:scale-[1.02]">
                    <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur px-4 py-2 rounded-lg text-xs font-bold text-indigo-600 shadow-lg">
                        Real-time Data Fetching
                    </div>
                </div>
            </div>

            <!-- How it Works section -->
            <div class="mb-20">
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-black text-gray-900 mb-4">{{ __tool('google-allintitle-checker', 'content.how_works_title') }}</h3>
                    <div class="h-1.5 w-24 bg-indigo-600 mx-auto rounded-full"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach(['step1', 'step2', 'step3', 'step4'] as $step)
                        <div class="bg-white p-6 rounded-2xl shadow-md border border-indigo-50 hover:border-indigo-200 transition-colors">
                            <div class="text-indigo-600 mb-4">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($step == 'step1') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    @elseif($step == 'step2') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    @elseif($step == 'step3') <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2" />
                                    @else <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @endif
                                </svg>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {!! __tool('google-allintitle-checker', 'content.how_works_' . $step) !!}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Benefits section -->
            <div class="bg-white rounded-3xl p-8 md:p-12 shadow-inner border border-indigo-50 mb-20">
                <h3 class="text-2xl font-black text-gray-900 mb-8 flex items-center gap-3">
                    <span class="p-2 bg-indigo-100 rounded-lg">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </span>
                    {{ __tool('google-allintitle-checker', 'content.benefits_title') }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(['benefit1', 'benefit2', 'benefit3'] as $ben)
                        <div>
                            <h4 class="font-bold text-gray-900 mb-3">{{ __tool('google-allintitle-checker', 'content.' . $ben . '_title') }}</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ __tool('google-allintitle-checker', 'content.' . $ben . '_desc') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Interpretation Guide -->
            <div class="mb-20">
                <h3 class="text-2xl font-black text-center text-gray-900 mb-10">{{ __tool('google-allintitle-checker', 'content.interpretation_title') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="p-6 rounded-2xl bg-green-50 border-2 border-green-100 text-center transition-transform hover:-translate-y-1">
                        <div class="text-2xl mb-2">🌱</div>
                        <p class="text-xs font-bold text-green-700 uppercase mb-2">Level 1</p>
                        <p class="text-sm text-green-800 leading-snug">{!! __tool('google-allintitle-checker', 'content.interp_low') !!}</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-blue-50 border-2 border-blue-100 text-center transition-transform hover:-translate-y-1">
                        <div class="text-2xl mb-2">📈</div>
                        <p class="text-xs font-bold text-blue-700 uppercase mb-2">Level 2</p>
                        <p class="text-sm text-blue-800 leading-snug">{!! __tool('google-allintitle-checker', 'content.interp_med') !!}</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-orange-50 border-2 border-orange-100 text-center transition-transform hover:-translate-y-1">
                        <div class="text-2xl mb-2">🔥</div>
                        <p class="text-xs font-bold text-orange-700 uppercase mb-2">Level 3</p>
                        <p class="text-sm text-orange-800 leading-snug">{!! __tool('google-allintitle-checker', 'content.interp_high') !!}</p>
                    </div>
                    <div class="p-6 rounded-2xl bg-red-50 border-2 border-red-100 text-center transition-transform hover:-translate-y-1">
                        <div class="text-2xl mb-2">💀</div>
                        <p class="text-xs font-bold text-red-700 uppercase mb-2">Level 4</p>
                        <p class="text-sm text-red-800 leading-snug">{!! __tool('google-allintitle-checker', 'content.interp_extreme') !!}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="max-w-3xl mx-auto">
                <h3 class="text-3xl font-black text-center text-gray-900 mb-10">{{ __tool('google-allintitle-checker', 'faq.title') }}</h3>
                <div class="space-y-4">
                    @foreach(['q1', 'q2', 'q3'] as $idx)
                        <details class="group bg-white rounded-2xl shadow-sm border border-indigo-100 overflow-hidden">
                            <summary class="flex justify-between items-center font-bold text-gray-800 cursor-pointer list-none p-6 hover:bg-indigo-50/30 transition-colors">
                                <span>{{ __tool('google-allintitle-checker', 'faq.' . $idx) }}</span>
                                <span class="transition-transform duration-300 group-open:rotate-180 text-indigo-600">
                                    <svg fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                </span>
                            </summary>
                            <div class="text-gray-600 p-6 pt-0 leading-relaxed text-sm">
                                {!! __tool('google-allintitle-checker', 'faq.a' . substr($idx, 1)) !!}
                            </div>
                        </details>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const locationInput = document.getElementById('locationInput');
        const locationDropdown = document.getElementById('locationDropdown');
        const selectedUULEInput = document.getElementById('selectedUULE');
        let searchTimeout;

        function generateUULE(canonicalName) {
            const secretKey = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_";
            const key = secretKey[canonicalName.length % 65];
            const encodedName = btoa(canonicalName).replace(/\+/g, '-').replace(/\//g, '_').replace(/=+$/, '');
            return `w+CAIQICI${key}${encodedName}`;
        }

        locationInput.addEventListener('input', function () {
            const query = this.value;
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
                                    selectedUULEInput.value = generateUULE(loc.name);
                                    locationDropdown.classList.add('hidden');
                                };
                                locationDropdown.appendChild(div);
                            });
                        } else {
                            locationDropdown.classList.add('hidden');
                        }
                    });
            }, 300);
        });

        document.addEventListener('click', function (e) {
            if (e.target !== locationInput && e.target !== locationDropdown) {
                locationDropdown.classList.add('hidden');
            }
        });

        function handleSearch(e) {
            e.preventDefault();
            const keyword = document.getElementById('keyword').value;
            const uule = document.getElementById('selectedUULE').value;
            
            let url = `https://www.google.com/search?q=allintitle:${encodeURIComponent(keyword)}`;
            if (uule) url += `&uule=${uule}`;
            
            window.open(url, '_blank');
        }
    </script>
@endpush

@push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #c7d2fe; border-radius: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #818cf8; }
    </style>
@endpush
