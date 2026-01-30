@extends('layouts.app')

@section('title', __tool('url-opener', 'meta.title'))
@section('meta_description', __tool('url-opener', 'meta.description'))

@section('content')
    <!-- Animated Background Mesh -->
    <div class="fixed inset-0 min-h-screen overflow-hidden -z-10 pointer-events-none">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-8 left-1/3 w-96 h-96 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000">
        </div>
    </div>

    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="url-opener" />

        <!-- Main Tool Card -->
        <div class="w-full">
            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
                
                <div class="mb-6">
                    <label for="urls" class="form-label text-base flex justify-between items-center mb-2">
                        <span>{{ __tool('url-opener', 'editor.label', 'Paste your links') }}</span>
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                Limit: {{ $limit }}
                            </span>
                            <span id="urlCountInfo" class="text-sm font-medium text-gray-500 transition-colors">
                                <span id="urlCount" class="font-bold text-gray-900">0</span> URLs ready
                            </span>
                             <button onclick="clearUrls()" class="text-gray-400 hover:text-red-500 transition-colors" title="{{ __tool('url-opener', 'editor.clear', 'Clear') }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </div>
                    </label>

                    <div class="relative">
                        <textarea id="urls" rows="6" 
                            class="form-input block w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm leading-relaxed"
                            placeholder="example.com&#10;https://google.com&#10;optimizo.io/blog"></textarea>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                     <!-- Warnings Container -->
                    <div id="limitWarning" class="hidden w-full animate-fade-in-up">
                        <div class="rounded-xl bg-red-50 border border-red-100 p-4 flex gap-4 items-center shadow-sm">
                            <div class="bg-red-100 p-2 rounded-full">
                                <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-red-900">Limit Exceeded</h3>
                                <p class="text-sm text-red-700">Please provide {{ $limit }} URLs or fewer.</p>
                            </div>
                        </div>
                    </div>


                    <button onclick="openUrls()" id="openBtn" class="btn-primary w-full justify-center text-lg py-4 shadow-2xl">
                        <span class="relative flex items-center gap-3">
                            {{ __tool('url-opener', 'editor.btn_open', 'Open All URLs') }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </span>
                    </button>
                </div>

            </div>
        </div>

        <!-- How it Works Section -->
        <div class="mt-24 mb-20 max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <span
                    class="text-indigo-600 font-bold tracking-wider uppercase text-sm bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-100">Simple
                    Workflow</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mt-4 mb-4">
                    {{ __tool('url-opener', 'content.how_to.title', 'How it Works') }}</h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8 relative">
                <!-- Connector Line (Desktop) -->
                <div
                    class="hidden md:block absolute top-12 left-1/6 right-1/6 h-0.5 bg-gradient-to-r from-transparent via-gray-200 to-transparent -z-10">
                </div>

                <div
                    class="group relative bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl text-white flex items-center justify-center text-2xl font-bold shadow-lg mb-6 group-hover:scale-110 transition-transform">
                        1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">
                        {{ __tool('url-opener', 'content.how_to.steps.0.title') }}</h3>
                    <p class="text-gray-500 text-center leading-relaxed">
                        {{ __tool('url-opener', 'content.how_to.steps.0.desc') }}</p>
                </div>

                <div
                    class="group relative bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl text-white flex items-center justify-center text-2xl font-bold shadow-lg mb-6 group-hover:scale-110 transition-transform">
                        2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">
                        {{ __tool('url-opener', 'content.how_to.steps.1.title') }}</h3>
                    <p class="text-gray-500 text-center leading-relaxed">
                        {{ __tool('url-opener', 'content.how_to.steps.1.desc') }}</p>
                </div>

                <div
                    class="group relative bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-indigo-500/10 hover:-translate-y-2 transition-all duration-300">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-pink-500 to-orange-500 rounded-2xl text-white flex items-center justify-center text-2xl font-bold shadow-lg mb-6 group-hover:scale-110 transition-transform">
                        3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">
                        {{ __tool('url-opener', 'content.how_to.steps.2.title') }}</h3>
                    <p class="text-gray-500 text-center leading-relaxed">
                        {{ __tool('url-opener', 'content.how_to.steps.2.desc') }}</p>
                </div>
            </div>
        </div>

        <!-- Popup Guide Section -->
        <div class="max-w-6xl mx-auto mb-16">
             <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row gap-8 items-center shadow-lg relative overflow-hidden">
                
                <div class="flex-1 relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="bg-amber-100 p-2 rounded-lg">
                            <svg class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-900 text-xl">{{ __tool('url-opener', 'guide.popup_title', 'Enable Pop-ups for Best Results') }}</h3>
                    </div>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ __tool('url-opener', 'guide.popup_desc', 'Browsers often block multiple tabs from opening at once. To use the Bulk URL Opener effectively, you need to allow pop-ups for this site. Look for the icon in your address bar!') }}
                    </p>
                    <div class="inline-flex items-center gap-2 text-sm font-bold text-amber-700 bg-amber-100/50 px-4 py-2 rounded-lg border border-amber-200">
                        <i class="fa-solid fa-check-circle"></i> 
                        <span>{{ __tool('url-opener', 'guide.popup_action', 'Select "Always allow pop-ups..."') }}</span>
                    </div>
                </div>
                <div class="flex-shrink-0 relative z-10">
                        <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-amber-400 to-orange-400 rounded-lg blur opacity-25 group-hover:opacity-50 transition duration-200"></div>
                        <img src="/assets/img/tools/allow_popups_guide.png" alt="How to allow popups in browser" class="relative w-full max-w-xs md:max-w-sm rounded-lg shadow-xl border border-white/50 transform group-hover:scale-[1.02] transition duration-300">
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid lg:grid-cols-2 gap-12 items-start mb-16">
            <!-- Problem/Solution Stack -->
            <div class="space-y-8">
                <div class="bg-red-50/50 rounded-3xl p-8 border border-red-100">
                    <h3 class="text-xl font-bold text-red-900 mb-4 flex items-center gap-2">
                        <span class="bg-red-100 p-1.5 rounded-lg">🚫</span>
                        {{ __tool('url-opener', 'content.problem_section.title') }}
                    </h3>
                    <p class="text-red-900/70 leading-relaxed">{{ __tool('url-opener', 'content.problem_section.p1') }}</p>
                </div>
                <div class="bg-green-50/50 rounded-3xl p-8 border border-green-100 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-green-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20">
                    </div>
                    <h3 class="text-xl font-bold text-green-900 mb-4 flex items-center gap-2">
                        <span class="bg-green-100 p-1.5 rounded-lg">✅</span>
                        {{ __tool('url-opener', 'content.solution_section.title') }}
                    </h3>
                    <p class="text-green-900/70 leading-relaxed">{{ __tool('url-opener', 'content.solution_section.p1') }}
                    </p>
                </div>
            </div>

            <!-- Use Cases -->
            <div class="bg-gray-900 rounded-3xl p-8 md:p-10 text-white shadow-2xl relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-indigo-500 rounded-full mix-blend-overlay filter blur-3xl opacity-20">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-64 h-64 bg-purple-500 rounded-full mix-blend-overlay filter blur-3xl opacity-20">
                </div>

                <h2 class="text-2xl font-bold mb-8 relative z-10">{{ __tool('url-opener', 'content.use_cases.title') }}</h2>
                <div class="grid sm:grid-cols-2 gap-6 relative z-10">
                    @foreach([0, 1, 2, 3] as $i)
                        <div
                            class="bg-white/10 backdrop-blur-sm p-4 rounded-xl hover:bg-white/20 transition-colors border border-white/5">
                            <h4 class="font-bold text-indigo-200 mb-1">
                                {{ __tool('url-opener', 'content.use_cases.cases.' . $i . '.title') }}</h4>
                            <p class="text-sm text-gray-300 leading-snug">
                                {{ __tool('url-opener', 'content.use_cases.cases.' . $i . '.desc') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mt-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900">{{ __tool('url-opener', 'content.faq_hero_title') }}</h2>
            </div>
            <div class="space-y-4">
                @foreach(['q1', 'q2', 'q3', 'q4'] as $q)
                    <div
                        class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-indigo-100 transition-colors">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ __tool('url-opener', 'content.faq.' . $q) }}</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ __tool('url-opener', 'content.faq.' . str_replace('q', 'a', $q)) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .animate-blob {
                animation: blob 7s infinite;
            }

            .animation-delay-2000 {
                animation-delay: 2s;
            }

            .animation-delay-4000 {
                animation-delay: 4s;
            }

            @keyframes blob {
                0% {
                    transform: translate(0px, 0px) scale(1);
                }

                33% {
                    transform: translate(30px, -50px) scale(1.1);
                }

                66% {
                    transform: translate(-20px, 20px) scale(0.9);
                }

                100% {
                    transform: translate(0px, 0px) scale(1);
                }
            }

            .animate-gradient-x {
                background-size: 200% 200%;
                animation: gradient-x 3s ease infinite;
            }

            @keyframes gradient-x {
                0% {
                    background-position: 0% 50%;
                }

                50% {
                    background-position: 100% 50%;
                }

                100% {
                    background-position: 0% 50%;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const textarea = document.getElementById('urls');
            const countDisplay = document.getElementById('urlCount');
            const countInfo = document.getElementById('urlCountInfo');
            const warningDiv = document.getElementById('limitWarning');
            const openBtn = document.getElementById('openBtn');
            const maxLimit = {{ $limit }};

            textarea.addEventListener('input', updateCount);

            function clearUrls() {
                textarea.value = '';
                textarea.style.height = 'auto'; // Reset height
                updateCount();
                textarea.focus();
            }

            function updateCount() {
                const urls = textarea.value.split(/\r\n|\r|\n/).filter(url => url.trim() !== '');
                const count = urls.length;

                // Animation for counter
                countDisplay.innerText = count;

                if (count > maxLimit) {
                    countInfo.classList.add('text-red-500');
                    countInfo.classList.remove('text-gray-500');

                    textarea.classList.add('border-red-300', 'bg-red-50');
                    textarea.classList.remove('border-gray-200', 'bg-gray-50/50');

                    warningDiv.classList.remove('hidden');
                    openBtn.disabled = true;
                    openBtn.classList.add('opacity-50', 'cursor-not-allowed', 'filter', 'grayscale');
                } else {
                    countInfo.classList.remove('text-red-500');
                    countInfo.classList.add('text-gray-500');

                    textarea.classList.remove('border-red-300', 'bg-red-50');
                    textarea.classList.add('border-gray-200', 'bg-gray-50/50');

                    warningDiv.classList.add('hidden');
                    openBtn.disabled = false;
                    openBtn.classList.remove('opacity-50', 'cursor-not-allowed', 'filter', 'grayscale');
                }
            }

            function openUrls() {
                const lines = textarea.value.split(/\r\n|\r|\n/).filter(line => line.trim() !== '');

                if (lines.length === 0) {
                    textarea.focus();
                    textarea.classList.add('ring-4', 'ring-red-100');
                    setTimeout(() => textarea.classList.remove('ring-4', 'ring-red-100'), 500);
                    return;
                }

                if (lines.length > maxLimit) return;

                let opened = 0;
                lines.forEach((line) => {
                    let url = line.trim();
                    // Smart protocol addition
                    if (!url.match(/^[a-zA-Z]+:\/\//)) {
                        url = 'https://' + url;
                    }
                    const win = window.open(url, '_blank');
                    if (win) opened++;
                });

                if (opened === 0) {
                    alert('No links were opened. Please check your pop-up blocker settings.');
                }
            }
        </script>
    @endpush
@endsection