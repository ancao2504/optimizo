@extends('layouts.app')

@section('title', __tool('hreflang-checker', 'meta.title'))
@section('meta_description', __tool('hreflang-checker', 'meta.description'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <x-tool-hero :tool="$tool" icon="hreflang-checker" />

        <!-- Tool Interface -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <form id="hreflang-form" action="{{ route('seo.hreflang-checker.check') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        {{ __tool('hreflang-checker', 'form.url_label') }}
                    </label>
                    <input type="url" name="url" required value="{{ old('url', $url ?? '') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent font-mono text-sm"
                        placeholder="{{ __tool('hreflang-checker', 'form.url_placeholder') }}">
                    @error('url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">
                        {{ __tool('hreflang-checker', 'form.user_agent_label') }}
                    </label>
                    <div class="relative">
                        <select name="user_agent"
                            class="appearance-none w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent text-sm bg-white pr-10 cursor-pointer hover:border-purple-300 transition-colors">
                            <option value="Mozilla/5.0 (compatible; HreflangChecker/1.0)">
                                {{ __tool('hreflang-checker', 'form.user_agent_default') }}</option>
                            <option value="Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)">
                                {{ __tool('hreflang-checker', 'form.user_agent_googlebot') }}</option>
                            <option value="Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)">
                                {{ __tool('hreflang-checker', 'form.user_agent_bingbot') }}</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-purple-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <button type="submit" id="submit-btn"
                    class="btn-primary w-full px-8 py-3 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>{{ __tool('hreflang-checker', 'form.button') }}</span>
                </button>
            </form>

            <div id="results-container">
                @if(isset($results))
                    @include('tools.seo.partials.hreflang-results')
                @endif
            </div>


        </div>

        <!-- SEO Content -->
        <div class="space-y-12 mt-8 font-sans">
            <!-- Intro Card -->
            <div
                class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border border-purple-100 shadow-xl relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gradient-to-br from-purple-200 to-pink-200 rounded-full opacity-20 blur-3xl">
                </div>
                <div class="relative z-10 text-center">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">
                        {{ __tool('hreflang-checker', 'content.main_title') }}
                    </h2>
                    <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                        {{ __tool('hreflang-checker', 'content.main_subtitle') }}
                    </p>
                    <div class="mt-8 text-gray-700 leading-relaxed text-lg">
                        {{ __tool('hreflang-checker', 'content.intro') }}
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div>
                <h3 class="text-3xl font-bold text-gray-900 mb-10 text-center">
                    {{ __tool('hreflang-checker', 'content.features_title') }}</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    @if(__tool('hreflang-checker', 'content.feature1_title') !== 'tools/seo.hreflang-checker.content.feature1_title')
                        <div
                            class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-purple-100 transition-all duration-300 group">
                            <div
                                class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-600 transition-colors duration-300">
                                <svg class="h-8 w-8 text-purple-600 group-hover:text-white transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">
                                {{ __tool('hreflang-checker', 'content.feature1_title') }}</h4>
                            <p class="text-gray-600">{{ __tool('hreflang-checker', 'content.feature1_desc') }}</p>
                        </div>
                    @endif
                    <!-- Feature 2 -->
                    @if(__tool('hreflang-checker', 'content.feature2_title') !== 'tools/seo.hreflang-checker.content.feature2_title')
                        <div
                            class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-pink-100 transition-all duration-300 group">
                            <div
                                class="w-14 h-14 bg-pink-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-pink-600 transition-colors duration-300">
                                <svg class="h-8 w-8 text-pink-600 group-hover:text-white transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">
                                {{ __tool('hreflang-checker', 'content.feature2_title') }}</h4>
                            <p class="text-gray-600">{{ __tool('hreflang-checker', 'content.feature2_desc') }}</p>
                        </div>
                    @endif
                    <!-- Feature 3 -->
                    @if(__tool('hreflang-checker', 'content.feature3_title') !== 'tools/seo.hreflang-checker.content.feature3_title')
                        <div
                            class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-blue-100 transition-all duration-300 group">
                            <div
                                class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors duration-300">
                                <svg class="h-8 w-8 text-blue-600 group-hover:text-white transition-colors" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">
                                {{ __tool('hreflang-checker', 'content.feature3_title') }}</h4>
                            <p class="text-gray-600">{{ __tool('hreflang-checker', 'content.feature3_desc') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- How to Guide -->
            @if(__tool('hreflang-checker', 'content.how_title') !== 'tools/seo.hreflang-checker.content.how_title')
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12">
                    <h3 class="text-3xl font-bold text-gray-900 mb-8">{{ __tool('hreflang-checker', 'content.how_title') }}</h3>
                    <div class="space-y-8">
                        @foreach(range(1, 4) as $step)
                            @if(__tool('hreflang-checker', "content.step{$step}_title") !== "tools/seo.hreflang-checker.content.step{$step}_title")
                                <div class="flex flex-col md:flex-row gap-6 items-start">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg shadow-purple-200">
                                        {{ $step }}</div>
                                    <div>
                                        <h4 class="text-xl font-bold text-gray-900 mb-2">
                                            {{ __tool('hreflang-checker', "content.step{$step}_title") }}</h4>
                                        <p class="text-gray-600">{{ __tool('hreflang-checker', "content.step{$step}_desc") }}</p>
                                    </div>
                                </div>
                                @if(!$loop->last && __tool('hreflang-checker', "content.step" . ($step + 1) . "_title") !== "tools/seo.hreflang-checker.content.step" . ($step + 1) . "_title")
                                    <div class="relative pl-5 md:pl-0">
                                        <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-100 hidden md:block"></div>
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- FAQ Section -->
            @if(__tool('hreflang-checker', 'content.faq_title') !== 'tools/seo.hreflang-checker.content.faq_title')
                <div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-8 text-center">
                        {{ __tool('hreflang-checker', 'content.faq_title') }}</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach(range(1, 6) as $i)
                            @if(__tool('hreflang-checker', "content.faq{$i}_q") !== "tools/seo.hreflang-checker.content.faq{$i}_q")
                                <div
                                    class="bg-gray-50 rounded-xl p-6 hover:bg-white hover:shadow-lg transition-all border border-gray-100 h-full">
                                    <h4 class="font-bold text-gray-900 mb-3">{{ __tool('hreflang-checker', "content.faq{$i}_q") }}</h4>
                                    <p class="text-gray-600 text-sm">{{ __tool('hreflang-checker', "content.faq{$i}_a") }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('hreflang-form');
            const resultsContainer = document.getElementById('results-container');
            const submitBtn = document.getElementById('submit-btn');
            const originalBtnContent = submitBtn.innerHTML;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Clear previous errors/results
                resultsContainer.innerHTML = '';
                const existingErrors = form.querySelectorAll('.text-red-500');
                existingErrors.forEach(el => el.remove());

                // Loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Processing...
                `;

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => Promise.reject(data));
                        }
                        return response.text();
                    })
                    .then(html => {
                        resultsContainer.innerHTML = html;
                        // Scroll to results
                        resultsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        let errorMessage = 'An error occurred. Please try again.';
                        if (error.errors && error.errors.url) {
                            errorMessage = error.errors.url[0];
                            const inputContainer = form.querySelector('input[name="url"]').closest('.mb-6');
                            const errorEl = document.createElement('p');
                            errorEl.className = 'text-red-500 text-sm mt-1';
                            errorEl.textContent = errorMessage;
                            inputContainer.appendChild(errorEl);
                        } else if (error.error) {
                            errorMessage = error.error;
                            // Show general error in results container
                            resultsContainer.innerHTML = `
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700">${errorMessage}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        }
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnContent;
                    });
            });
        });
    </script>
@endpush