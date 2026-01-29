@extends('layouts.app')

@section('title', __tool('google-index-checker', 'meta.title'))
@section('meta_description', __tool('google-index-checker', 'meta.description'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <x-tool-hero :tool="$tool" />

        <!-- Tool Interface -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    {{ __tool('google-index-checker', 'meta.h1') }}
                </h2>
                <div class="h-1 w-16 bg-gradient-to-r from-purple-600 to-red-600 mx-auto rounded-full"></div>
            </div>

            <form id="checkerForm" onsubmit="handleCheck(event)" class="space-y-6">
                @csrf
                <div>
                    <label for="url" class="block text-sm font-bold text-gray-700 mb-2">
                        {{ __tool('google-index-checker', 'interface.url_label') }}
                    </label>
                    <div class="relative">
                        <input type="url" id="url" name="url" required
                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent font-medium text-gray-900 placeholder-gray-400 text-base transition-colors hover:border-purple-300 shadow-sm"
                            placeholder="{{ __tool('google-index-checker', 'interface.url_placeholder') }}">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.826a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" id="submitBtn"
                        class="btn-primary w-full px-8 py-4 rounded-xl flex items-center justify-center gap-3 transform hover:-translate-y-0.5 transition-all shadow-lg hover:shadow-xl text-lg font-bold">
                        <span id="btnText">{{ __tool('google-index-checker', 'interface.button') }}</span>
                        <svg id="loadingIcon" class="hidden animate-spin h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <svg id="checkIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Results Section -->
            <div id="resultContainer" class="hidden mt-10 animate-fade-in">
                <div class="p-6 rounded-2xl border-2 flex flex-col md:flex-row items-center gap-6" id="resultCard">
                    <div id="resultIcon"
                        class="w-20 h-20 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg">
                        <!-- Icon will be injected here -->
                    </div>
                    <div class="flex-grow text-center md:text-left">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-1">
                            {{ __tool('google-index-checker', 'interface.status_label') }}
                        </h3>
                        <div id="statusBadge" class="inline-block text-3xl font-black mb-2"></div>
                        <p id="resultUrl" class="text-gray-600 font-medium break-all"></p>
                    </div>
                    <div class="flex-shrink-0">
                        <button onclick="document.getElementById('url').scrollIntoView({behavior: 'smooth'})"
                            class="text-purple-600 font-bold hover:underline">
                            {{ __tool('google-index-checker', 'interface.button') }}
                        </button>
                    </div>
                </div>
            </div>

            <div id="errorAlert"
                class="hidden mt-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg flex items-start gap-4 text-red-700 font-medium">
                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div id="errorMessage"></div>
            </div>
        </div>

        <!-- SEO Content Section -->
        <div
            class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl overflow-hidden relative mt-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-purple-200/50 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-indigo-200/50 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">
                        {{ __tool('google-index-checker', 'content.main_title') }}
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                        {{ __tool('google-index-checker', 'content.main_subtitle') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <span
                                class="w-10 h-10 bg-purple-600 text-white rounded-lg flex items-center justify-center text-xl font-black">?</span>
                            {{ __tool('google-index-checker', 'content.what_is_title') }}
                        </h3>
                        <p class="text-gray-700 leading-relaxed lg:text-lg">
                            {{ __tool('google-index-checker', 'content.what_is_desc') }}
                        </p>
                    </div>
                    <div
                        class="bg-white p-8 rounded-2xl shadow-xl border border-purple-100 transform hover:rotate-1 transition-transform">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <span
                                class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center text-xl font-black">⚙</span>
                            {{ __tool('google-index-checker', 'content.how_it_works_title') }}
                        </h3>
                        <p class="text-gray-700 leading-relaxed">
                            {{ __tool('google-index-checker', 'content.how_it_works_desc') }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-8 md:p-10 shadow-lg border border-purple-100 mb-16">
                    <h3 class="text-2xl font-black text-gray-900 mb-8 flex items-center gap-3">
                        <span class="text-red-500">⚠</span>
                        {{ __tool('google-index-checker', 'content.reasons_title') }}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @for($i = 1; $i <= 5; $i++)
                            <div class="p-6 bg-gray-50 rounded-xl hover:bg-purple-50 transition-colors">
                                <p class="text-gray-700 leading-relaxed text-sm">
                                    {!! __tool('google-index-checker', "content.reason_$i") !!}
                                </p>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Visual Examples Section -->
                <div class="mb-16">
                    <div class="text-center mb-10">
                        <h3 class="text-3xl font-black text-gray-900 mb-4">
                            {{ __tool('google-index-checker', 'content.visual_examples_title') }}
                        </h3>
                        <p class="text-gray-600 max-w-2xl mx-auto leading-relaxed">
                            {{ __tool('google-index-checker', 'content.visual_examples_subtitle') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                        <!-- Indexed Example -->
                        <div
                            class="bg-white rounded-3xl p-6 shadow-xl border border-green-50 overflow-hidden group hover:border-green-100 transition-all duration-300">
                            <h4 class="text-xl font-black text-green-700 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ __tool('google-index-checker', 'content.indexed_visual_title') }}
                            </h4>
                            <div class="mb-6 rounded-2xl overflow-hidden border border-gray-100 shadow-inner">
                                <img src="{{ asset('assets/img/tools/google-index-checker/indexed.png') }}"
                                    alt="Indexed Example"
                                    class="w-full h-auto transform group-hover:scale-105 transition-transform duration-700">
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ __tool('google-index-checker', 'content.indexed_visual_desc') }}
                            </p>
                        </div>

                        <!-- Not Indexed Example -->
                        <div
                            class="bg-white rounded-3xl p-6 shadow-xl border border-red-50 overflow-hidden group hover:border-red-100 transition-all duration-300">
                            <h4 class="text-xl font-black text-red-700 mb-4 flex items-center gap-2">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                {{ __tool('google-index-checker', 'content.not_indexed_visual_title') }}
                            </h4>
                            <div class="mb-6 rounded-2xl overflow-hidden border border-gray-100 shadow-inner">
                                <img src="{{ asset('assets/img/tools/google-index-checker/not_indexed.png') }}"
                                    alt="Not Indexed Example"
                                    class="w-full h-auto transform group-hover:scale-105 transition-transform duration-700">
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed">
                                {{ __tool('google-index-checker', 'content.not_indexed_visual_desc') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ Area -->
                <div class="max-w-3xl mx-auto">
                    <h3 class="text-3xl font-black text-center text-gray-900 mb-10">
                        {{ __tool('google-index-checker', 'faq.title') }}
                    </h3>
                    <div class="space-y-4">
                        @for($i = 1; $i <= 4; $i++)
                            <details class="group bg-white rounded-2xl shadow-sm border border-purple-100 overflow-hidden">
                                <summary
                                    class="flex justify-between items-center font-bold text-gray-800 cursor-pointer list-none p-6 hover:bg-gray-50 transition-colors">
                                    <span>{{ __tool('google-index-checker', "faq.q$i") }}</span>
                                    <span
                                        class="transition-transform duration-300 group-open:rotate-180 text-purple-600 border-2 border-purple-100 rounded-full p-1">
                                        <svg fill="none" height="20" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"
                                            width="20">
                                            <path d="M6 9l6 6 6-6"></path>
                                        </svg>
                                    </span>
                                </summary>
                                <div class="text-gray-600 p-6 pt-0 leading-relaxed border-t border-gray-50">
                                    {{ __tool('google-index-checker', "faq.a$i") }}
                                </div>
                            </details>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        async function handleCheck(e) {
            e.preventDefault();

            const form = e.target;
            const urlInput = document.getElementById('url');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const loadingIcon = document.getElementById('loadingIcon');
            const checkIcon = document.getElementById('checkIcon');
            const resultContainer = document.getElementById('resultContainer');
            const errorAlert = document.getElementById('errorAlert');

            // Reset state
            errorAlert.classList.add('hidden');
            submitBtn.disabled = true;
            btnText.textContent = "{{ __tool('google-index-checker', 'interface.button_checking') }}";
            loadingIcon.classList.remove('hidden');
            checkIcon.classList.add('hidden');

            try {
                const response = await fetch("{{ route('seo.google-index-checker.check') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        url: urlInput.value
                    })
                });

                const data = await response.json();

                if (data.success) {
                    renderResult(data);
                    resultContainer.classList.remove('hidden');

                    // Open Google in a new tab
                    window.open(data.redirect_url, '_blank');
                } else {
                    throw new Error(data.message || 'Something went wrong');
                }

            } catch (error) {
                document.getElementById('errorMessage').textContent = error.message;
                errorAlert.classList.remove('hidden');
                resultContainer.classList.add('hidden');
            } finally {
                submitBtn.disabled = false;
                btnText.textContent = "{{ __tool('google-index-checker', 'interface.button') }}";
                loadingIcon.classList.add('hidden');
                checkIcon.classList.remove('hidden');
            }
        }

        function renderResult(data) {
            const card = document.getElementById('resultCard');
            const iconContainer = document.getElementById('resultIcon');
            const badge = document.getElementById('statusBadge');
            const urlText = document.getElementById('resultUrl');

            urlText.innerHTML = `Searching for: <span class="text-purple-600 font-bold">${document.getElementById('url').value}</span>`;

            card.className = "p-6 rounded-2xl border-2 flex flex-col md:flex-row items-center gap-6 bg-blue-50 border-blue-200 shadow-lg shadow-blue-100 animate-bounce-slow";
            iconContainer.className = "w-20 h-20 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg bg-blue-100 text-blue-600";
            iconContainer.innerHTML = `<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>`;
            badge.className = "inline-block text-2xl font-black mb-2 text-blue-700";
            badge.textContent = "Opening Google Search...";
        }
    </script>
@endpush

@push('styles')
    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-bounce-slow {
            animation: bounceSlow 3s infinite;
        }

        @keyframes bounceSlow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .font-shake {
            animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
        }

        @keyframes shake {

            10%,
            90% {
                transform: translate3d(-1px, 0, 0);
            }

            20%,
            80% {
                transform: translate3d(2px, 0, 0);
            }

            30%,
            50%,
            70% {
                transform: translate3d(-4px, 0, 0);
            }

            40%,
            60% {
                transform: translate3d(4px, 0, 0);
            }
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
@endpush