@extends('layouts.app')

@section('title', __tool('sitemap-validator', 'meta.title'))
@section('meta_description', __tool('sitemap-validator', 'meta.description'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <x-tool-hero :tool="$tool" icon="sitemap-validator" />

        <!-- Tool -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __tool('sitemap-validator', 'editor.title', 'Validate Sitemap') }}</h2>
            <form id="sitemapValidatorForm" method="POST" action="{{ route('seo.sitemap-validator.validate') }}">
                @csrf

                <div class="mb-6">
                    <div class="flex gap-4 mb-6">
                        <button type="button" id="urlInputBtn"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md active-tab">
                            <i class="fas fa-link mr-2"></i>{{ __tool('sitemap-validator', 'editor.btn_url_input', 'URL Input') }}
                        </button>
                        <button type="button" id="xmlInputBtn"
                            class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-all duration-200">
                            <i class="fas fa-code mr-2"></i>{{ __tool('sitemap-validator', 'editor.btn_xml_input', 'XML Input') }}
                        </button>
                    </div>

                    <!-- URL Input Tab -->
                    <div id="urlInputSection">
                        <label for="sitemapUrl" class="form-label text-base font-semibold text-gray-700 mb-2 block">
                            {{ __tool('sitemap-validator', 'editor.label_url', 'Sitemap URL') }}
                        </label>
                        <input type="url" id="sitemapUrl" name="url"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            placeholder="{{ __tool('sitemap-validator', 'editor.ph_url', 'https://example.com/sitemap.xml') }}"
                            value="{{ old('url', request('url')) }}">
                         <p class="text-sm text-gray-500 mt-2">{{ __tool('sitemap-validator', 'editor.help_url', 'Enter the full URL of your sitemap.xml file') }}</p>
                    </div>

                    <!-- XML Input Tab -->
                    <div id="xmlInputSection" class="hidden">
                        <label for="sitemapXml" class="form-label text-base font-semibold text-gray-700 mb-2 block">
                            {{ __tool('sitemap-validator', 'editor.label_xml', 'Paste Sitemap XML') }}
                        </label>
                        <textarea id="sitemapXml" name="xml" rows="12"
                            class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-mono text-sm"
                            placeholder="{{ __tool('sitemap-validator', 'editor.ph_xml', 'Paste your sitemap XML here...') }}">{{ old('xml', request('xml')) }}</textarea>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button type="submit" id="validateBtn"
                        class="flex-1 px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-bold hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-lg">
                        <i class="fas fa-check-circle mr-2"></i>{{ __tool('sitemap-validator', 'editor.btn_validate', 'Validate Sitemap') }}
                    </button>
                    <button type="button" id="clearBtn"
                        class="px-8 py-4 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition-all duration-200 hover:shadow-md">
                        <i class="fas fa-eraser mr-2"></i>{{ __tool('sitemap-validator', 'editor.btn_clear', 'Clear') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Container -->
        <div id="resultsContainer">
            @if(isset($result))
                @include('tools.seo.sitemap-validator-results', ['result' => $result])
            @endif
        </div>

        <!-- SEO Content Section -->
        <div class="space-y-12 mt-8 font-sans">
            <!-- Intro Card -->
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-3xl p-8 md:p-12 border border-indigo-100 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gradient-to-br from-indigo-200 to-blue-200 rounded-full opacity-20 blur-3xl"></div>
                <div class="relative z-10 text-center">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-indigo-600 to-blue-600 rounded-3xl shadow-lg mb-8 transform -rotate-3 hover:rotate-3 transition-transform duration-300">
                         <!-- Heroicons 'map' -->
                        <svg class="h-10 w-10 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.159.69.159 1.006 0Z" />
                        </svg>
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">
                        {{ __tool('sitemap-validator', 'content.main_heading', 'Master Your Site Structure with Our XML Sitemap Validator') }}
                    </h2>
                    <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                        {{ __tool('sitemap-validator', 'content.main_intro', 'Ensure your website is perfectly crawlable by search engines. Detect errors, validate structure, and optimize your path to higher rankings immediately.') }}
                    </p>
                </div>
            </div>

            <!-- What is Section -->
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="order-2 md:order-1">
                    <h3 class="text-3xl font-bold text-gray-900 mb-6 flex items-center">
                        <span class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mr-3 text-xl">
                            <!-- Heroicons 'question-mark-circle' -->
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                            </svg>
                        </span>
                        {{ __tool('sitemap-validator', 'content.what_is_title', 'What is an XML Sitemap Validator?') }}
                    </h3>
                    <div class="prose prose-lg text-gray-600">
                        <p class="mb-4">
                            {!! __tool('sitemap-validator', 'content.what_is_desc_1', 'An description...') !!}
                        </p>
                        <p>
                             {{ __tool('sitemap-validator', 'content.what_is_desc_2', 'Think of your sitemap...') }}
                        </p>
                    </div>
                </div>
                <div class="order-1 md:order-2">
                    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100 transform hover:scale-[1.02] transition-transform duration-300">
                        <img src="https://cdn-icons-png.flaticon.com/512/3050/3050525.png" alt="Sitemap Illustration" class="w-full h-64 object-contain opacity-90 mx-auto">
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div>
                <h3 class="text-3xl font-bold text-gray-900 mb-10 text-center">{{ __tool('sitemap-validator', 'content.features_title', 'Why Choose Our Validator?') }}</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-indigo-100 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors duration-300">
                            <!-- Heroicons 'bolt' -->
                            <svg class="h-8 w-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">{{ __tool('sitemap-validator', 'content.feature_instant_title', 'Instant Analysis') }}</h4>
                        <p class="text-gray-600">{{ __tool('sitemap-validator', 'content.feature_instant_desc', 'Get immediate feedback...') }}</p>
                    </div>
                    <!-- Feature 2 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-purple-100 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-600 transition-colors duration-300">
                             <!-- Heroicons 'shield-check' -->
                            <svg class="h-8 w-8 text-purple-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">{{ __tool('sitemap-validator', 'content.feature_strict_title', 'Strict Validation') }}</h4>
                        <p class="text-gray-600">{{ __tool('sitemap-validator', 'content.feature_strict_desc', 'We check against...') }}</p>
                    </div>
                    <!-- Feature 3 -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-pink-100 transition-all duration-300 group">
                        <div class="w-14 h-14 bg-pink-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-pink-600 transition-colors duration-300">
                             <!-- Heroicons 'document-check' (replacing list/box) -->
                             <svg class="h-8 w-8 text-pink-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                              </svg>
                        </div>
                        <h4 class="text-xl font-bold text-gray-900 mb-3">{{ __tool('sitemap-validator', 'content.feature_index_title', 'Sitemap Index Support') }}</h4>
                        <p class="text-gray-600">{{ __tool('sitemap-validator', 'content.feature_index_desc', 'Have a large site...') }}</p>
                    </div>
                </div>
            </div>

            <!-- Importance Section -->
            <div class="bg-gray-900 rounded-3xl p-8 md:p-16 text-white overflow-hidden relative">
                <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 -ml-20 -mb-20"></div>
                
                <div class="relative z-10">
                    <h3 class="text-3xl md:text-4xl font-bold mb-8 text-center">{{ __tool('sitemap-validator', 'content.importance_title', 'Why Valid Sitemaps Matter for SEO') }}</h3>
                    <div class="grid md:grid-cols-2 gap-8 md:gap-12">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center border border-gray-700">
                                <span class="font-bold text-lg text-indigo-400">01</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">{{ __tool('sitemap-validator', 'content.importance_budget_title', 'Crawl Budget Efficiency') }}</h4>
                                <p class="text-gray-400">{{ __tool('sitemap-validator', 'content.importance_budget_desc', 'Search engines allocate...') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center border border-gray-700">
                                <span class="font-bold text-lg text-indigo-400">02</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">{{ __tool('sitemap-validator', 'content.importance_indexing_title', 'Faster Indexing') }}</h4>
                                <p class="text-gray-400">{{ __tool('sitemap-validator', 'content.importance_indexing_desc', 'Directly feeding...') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center border border-gray-700">
                                <span class="font-bold text-lg text-indigo-400">03</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">{{ __tool('sitemap-validator', 'content.importance_discovery_title', 'Deep Page Discovery') }}</h4>
                                <p class="text-gray-400">{{ __tool('sitemap-validator', 'content.importance_discovery_desc', 'Orphan pages...') }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-800 rounded-full flex items-center justify-center border border-gray-700">
                                <span class="font-bold text-lg text-indigo-400">04</span>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold mb-2">{{ __tool('sitemap-validator', 'content.importance_troubleshooting_title', 'Error Troubleshooting') }}</h4>
                                <p class="text-gray-400">{{ __tool('sitemap-validator', 'content.importance_troubleshooting_desc', 'Validating regularly...') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- How to Guide -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12">
                <h3 class="text-3xl font-bold text-gray-900 mb-8">{{ __tool('sitemap-validator', 'content.guide_title', 'How to Validate Your Sitemap') }}</h3>
                <div class="space-y-8">
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg shadow-indigo-200">1</div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ __tool('sitemap-validator', 'content.guide_step1_title', 'Enter your Sitemap URL') }}</h4>
                            <p class="text-gray-600">{{ __tool('sitemap-validator', 'content.guide_step1_desc', 'Locate your sitemap...') }}</p>
                        </div>
                    </div>
                    <div class="relative pl-5 md:pl-0">
                        <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-100 hidden md:block"></div> <!-- Connector Line -->
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg shadow-indigo-200">2</div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ __tool('sitemap-validator', 'content.guide_step2_title', 'Run the Validation') }}</h4>
                            <p class="text-gray-600">{{ __tool('sitemap-validator', 'content.guide_step2_desc', 'Click the Validate Sitemap button...') }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg shadow-indigo-200">3</div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 mb-2">{{ __tool('sitemap-validator', 'content.guide_step3_title', 'Review Results') }}</h4>
                            <p class="text-gray-600">{{ __tool('sitemap-validator', 'content.guide_step3_desc', 'Youll see a detailed report...') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div>
                <h3 class="text-3xl font-bold text-gray-900 mb-8 text-center">{{ __tool('sitemap-validator', 'content.faq_title', 'Frequently Asked Questions') }}</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-xl p-6 hover:bg-white hover:shadow-lg transition-all border border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-3">{{ __tool('sitemap-validator', 'content.faq_privacy_question', 'Does this tool save my sitemap data?') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('sitemap-validator', 'content.faq_privacy_answer', 'No, we prioritize privacy...') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 hover:bg-white hover:shadow-lg transition-all border border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-3">{{ __tool('sitemap-validator', 'content.faq_frequency_question', 'How often should I validate my sitemap?') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('sitemap-validator', 'content.faq_frequency_answer', 'Its best practice to validate...') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 hover:bg-white hover:shadow-lg transition-all border border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-3">{{ __tool('sitemap-validator', 'content.faq_size_question', 'What is the limit for sitemap file size?') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('sitemap-validator', 'content.faq_size_answer', 'Standard protocols limit...') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-6 hover:bg-white hover:shadow-lg transition-all border border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-3">{{ __tool('sitemap-validator', 'content.faq_localhost_question', 'Can I validate a sitemap on a localhost?') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('sitemap-validator', 'content.faq_localhost_answer', 'Yes! Use the XML Input tab...') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // --- Helper Functions ---
            function clearErrors() {
                $('#sitemapUrl, #sitemapXml').removeClass('border-red-500 focus:ring-red-500 focus:border-red-500')
                    .addClass('border-gray-300 focus:ring-blue-500 focus:border-blue-500');
            }

            function highlightError(fieldId) {
                $(fieldId).removeClass('border-gray-300 focus:ring-blue-500 focus:border-blue-500')
                    .addClass('border-red-500 focus:ring-red-500 focus:border-red-500');
            }

            // --- Event Listeners ---

            // Tab Switching - XML
            $('#xmlInputBtn').click(function () {
                $('#xmlInputSection').removeClass('hidden');
                $('#urlInputSection').addClass('hidden');
                $('#sitemapUrl').val('');

                // Toggle Active State
                $(this).addClass('bg-gradient-to-r from-blue-600 to-blue-700 text-white').removeClass('bg-gray-200 text-gray-700');
                $('#urlInputBtn').removeClass('bg-gradient-to-r from-blue-600 to-blue-700 text-white').addClass('bg-gray-200 text-gray-700');

                clearErrors();
            });

            // Tab Switching - URL
            $('#urlInputBtn').click(function () {
                $('#urlInputSection').removeClass('hidden');
                $('#xmlInputSection').addClass('hidden');
                $('#sitemapXml').val('');

                // Toggle Active State
                $(this).addClass('bg-gradient-to-r from-blue-600 to-blue-700 text-white').removeClass('bg-gray-200 text-gray-700');
                $('#xmlInputBtn').removeClass('bg-gradient-to-r from-blue-600 to-blue-700 text-white').addClass('bg-gray-200 text-gray-700');

                clearErrors();
            });

            // Clear Button
            $('#clearBtn').click(function () {
                $('#sitemapUrl').val('');
                $('#sitemapXml').val('');
                $('#resultsContainer').empty();
                clearErrors();
            });

            // AJAX Form Submission
            $('#sitemapValidatorForm').submit(function (e) {
                e.preventDefault();

                var form = $(this);
                var btn = $('#validateBtn');
                var originalBtnContent = btn.html();

                // Clear previous results and errors immediately
                $('#resultsContainer').empty();
                clearErrors();

                // Loading State - Use double quotes for outer string to safely contain Blade directives
                var loadingText = '{{ __tool("sitemap-validator", "editor.btn_validating", "Validating...") }}';
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>' + loadingText);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $('#resultsContainer').html(response.html);

                            if (typeof showSuccess === 'function') {
                                showSuccess('Sitemap validated successfully!');
                            }

                            // Scroll to results
                            $('html, body').animate({
                                scrollTop: $("#resultsContainer").offset().top - 100
                            }, 500);
                        } else {
                            var msg = response.message || 'An error occurred during validation';
                            if (typeof showError === 'function') {
                                showError(msg);
                            } else {
                                alert(msg);
                            }

                            // Highlight active input if generic failure
                            if (!$('#urlInputSection').hasClass('hidden')) highlightError('#sitemapUrl');
                            if (!$('#xmlInputSection').hasClass('hidden')) highlightError('#sitemapXml');
                        }
                    },
                    error: function (xhr) {
                        var errorMessage = 'An error occurred';
                        var fieldError = false;
                        var response = xhr.responseJSON || {};

                        if (xhr.status === 422) {
                            // Validation errors
                            var errors = response.errors || {};

                            if (errors.url) {
                                highlightError('#sitemapUrl');
                                errorMessage = errors.url[0];
                                fieldError = true;
                            }
                            if (errors.xml) {
                                highlightError('#sitemapXml');
                                // Use this message if it wasn't the URL error
                                if (!fieldError) errorMessage = errors.xml[0];
                                fieldError = true;
                            }

                            // Fallback logic for generic 422 messages
                            if (!fieldError) {
                                if (response.message) {
                                    errorMessage = response.message;
                                }

                                // Highlight the active visible input
                                if (!$('#urlInputSection').hasClass('hidden')) highlightError('#sitemapUrl');
                                if (!$('#xmlInputSection').hasClass('hidden')) highlightError('#sitemapXml');
                            } else {
                                // If we have a field error, ensure we have the message
                                if (!errorMessage && response.message) {
                                    errorMessage = response.message;
                                }
                            }

                        } else {
                            if (response.message) {
                                errorMessage = response.message;
                            } else if (response.error) {
                                errorMessage = response.error;
                            } else {
                                errorMessage = 'HTTP Error: ' + xhr.status;
                            }
                        }

                        if (typeof showError === 'function') {
                            showError(errorMessage);
                        } else {
                            alert(errorMessage);
                        }
                    },
                    complete: function () {
                        btn.prop('disabled', false).html(originalBtnContent);
                    }
                });
            });
        });
    </script>
@endpush