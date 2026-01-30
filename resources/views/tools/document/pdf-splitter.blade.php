@extends('layouts.app')

@section('title', __tool('pdf-splitter', 'meta.title'))
@section('meta_description', __tool('pdf-splitter', 'meta.description'))
@if($tool->meta_keywords)
@endif

@section('content')
    <x-tool-hero :tool="$tool" />

    <!-- Tool Interface Section -->
    <!-- Wide Form -->
    <div class="bg-white rounded-3xl p-8 md:p-10 shadow-xl border border-gray-100 mb-16">
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ __tool('pdf-splitter', 'form.upload_title') }}
            </h2>
            <p class="text-lg text-gray-600">{{ __tool('pdf-splitter', 'form.upload_subtitle') }}</p>
        </div>

        <form id="converterForm" action="{{ route('document.pdf-splitter.process') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <div class="border-4 border-dashed border-pink-100 rounded-3xl p-10 text-center hover:border-pink-300 hover:bg-pink-50 transition-all cursor-pointer relative group bg-gray-50/50"
                id="dropzone">
                <input type="file" name="file" id="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    accept=".pdf">
                <div class="space-y-6 pointer-events-none">
                    <div
                        class="inline-flex items-center justify-center w-20 h-20 bg-pink-100 text-pink-600 rounded-full group-hover:scale-110 transition-transform">
                        <!-- Icon: Cloud Upload -->
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-700">{{ __tool('pdf-splitter', 'form.upload_text') }}</p>
                        <p class="text-base text-gray-500 mt-2">{{ __tool('pdf-splitter', 'form.file_size_limit') }}</p>
                    </div>
                </div>
                <div id="file-name" class="mt-4 text-pink-600 font-medium hidden text-lg"></div>
            </div>

            <!-- Split Options -->
            <div class="grid md:grid-cols-2 gap-6">
                <label
                    class="relative flex flex-col p-6 bg-white border-2 border-pink-500 rounded-2xl cursor-pointer ring-4 ring-pink-50">
                    <input type="radio" name="split_mode" value="ranges" class="peer sr-only" checked>
                    <span class="text-lg font-bold text-gray-900 mb-2">{{ __tool('pdf-splitter', 'form.split_by_range') }}</span>
                    <span class="text-sm text-gray-500">{{ __tool('pdf-splitter', 'form.split_by_range_desc') }}</span>
                    <div
                        class="absolute top-4 right-4 w-6 h-6 bg-pink-500 border-2 border-pink-500 rounded-full peer-checked:bg-pink-500 peer-checked:border-pink-500">
                    </div>
                </label>

                <label
                    class="relative flex flex-col p-6 bg-white border-2 border-gray-200 rounded-2xl cursor-pointer hover:border-pink-300 transition-colors">
                    <input type="radio" name="split_mode" value="all" class="peer sr-only">
                    <span class="text-lg font-bold text-gray-900 mb-2">{{ __tool('pdf-splitter', 'form.extract_all') }}</span>
                    <span class="text-sm text-gray-500">{{ __tool('pdf-splitter', 'form.extract_all_desc') }}</span>
                    <div
                        class="absolute top-4 right-4 w-6 h-6 border-2 border-gray-300 rounded-full peer-checked:bg-pink-500 peer-checked:border-pink-500">
                    </div>
                </label>
            </div>

            <!-- Page Range Input (Hidden by default) -->
            <div class="mt-6 hidden bg-gray-50 border border-gray-200 rounded-2xl p-6" id="range-section">
                <label for="range" class="block text-gray-900 font-bold mb-2">{{ __tool('pdf-splitter', 'form.range_label', 'Page Ranges') }}</label>
                <input type="text" name="range" id="range" 
                    class="w-full border-gray-300 rounded-xl shadow-sm focus:border-pink-500 focus:ring-pink-500" 
                    placeholder="e.g. 1-5, 8, 11-13">
                <p class="text-sm text-gray-500 mt-2">{{ __tool('pdf-splitter', 'form.range_help', 'Enter page numbers and/or ranges separated by commas.') }}</p>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="w-full md:w-auto min-w-[300px] inline-flex items-center justify-center px-10 py-5 border border-transparent text-xl font-bold rounded-2xl shadow-xl text-white bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 focus:outline-none focus:ring-4 focus:ring-pink-500/50 transform hover:-translate-y-1 transition-all">
                    {{ __tool('pdf-splitter', 'form.button') }}
                    <!-- Icon: Arrow Right -->
                    <svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
                <p class="mt-4 text-sm text-gray-400">{{ __tool('pdf-splitter', 'form.dev_notice') }}</p>
            </div>
        </form>
    </div>

    <!-- SEO Content Section -->
    <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100 mb-12">
        <article class="prose prose-lg md:prose-xl max-w-none text-gray-600">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">{{ __tool('pdf-splitter', 'content.main_title') }}</h2>
                <p class="text-xl leading-relaxed text-gray-600">
                    {{ __tool('pdf-splitter', 'content.main_desc') }}
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-16 not-prose">
                <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-pink-100 text-pink-600 rounded-2xl flex items-center justify-center mb-6">
                        <!-- Icon: Document Remove -->
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 13h6m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-gray-900 mb-3">{{ __tool('pdf-splitter', 'content.feature1_title') }}</h3>
                    <p class="text-base text-gray-600 leading-relaxed">{{ __tool('pdf-splitter', 'content.feature1_desc') }}</p>
                </div>
                <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mb-6">
                        <!-- Icon: Switch Horizontal -->
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-gray-900 mb-3">{{ __tool('pdf-splitter', 'content.feature2_title') }}</h3>
                    <p class="text-base text-gray-600 leading-relaxed">{{ __tool('pdf-splitter', 'content.feature2_desc') }}</p>
                </div>
                <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100 hover:shadow-lg transition-shadow">
                    <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mb-6">
                        <!-- Icon: Collection -->
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-2xl text-gray-900 mb-3">{{ __tool('pdf-splitter', 'content.feature3_title') }}</h3>
                    <p class="text-base text-gray-600 leading-relaxed">{{ __tool('pdf-splitter', 'content.feature3_desc') }}</p>
                </div>
            </div>

            <div class="max-w-4xl mx-auto space-y-12">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __tool('pdf-splitter', 'content.how_to_title') }}</h3>
                    <ol class="space-y-4">
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-pink-100 text-pink-600 rounded-full font-bold mr-4 mt-1">1</span>
                            <div>
                                <strong class="text-gray-900 text-lg">{{ __tool('pdf-splitter', 'content.step1_title') }}</strong>
                                <p class="mt-1 text-gray-600">{{ __tool('pdf-splitter', 'content.step1_desc') }}</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-pink-100 text-pink-600 rounded-full font-bold mr-4 mt-1">2</span>
                            <div>
                                <strong class="text-gray-900 text-lg">{{ __tool('pdf-splitter', 'content.step2_title') }}</strong>
                                <p class="mt-1 text-gray-600">{{ __tool('pdf-splitter', 'content.step2_desc') }}</p>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <span
                                class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-pink-100 text-pink-600 rounded-full font-bold mr-4 mt-1">3</span>
                            <div>
                                <strong class="text-gray-900 text-lg">{{ __tool('pdf-splitter', 'content.step3_title') }}</strong>
                                <p class="mt-1 text-gray-600">{{ __tool('pdf-splitter', 'content.step3_desc') }}</p>
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </article>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/document-converter-ajax.js') }}"></script>
    <script src="{{ asset('js/document-converter-ajax.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rangeSection = document.getElementById('range-section');
            const radioButtons = document.querySelectorAll('input[name="split_mode"]');
            
            function toggleRange() {
                const selected = document.querySelector('input[name="split_mode"]:checked').value;
                if (selected === 'ranges') {
                    rangeSection.classList.remove('hidden');
                } else {
                    rangeSection.classList.add('hidden');
                }
            }
            
            radioButtons.forEach(radio => {
                radio.addEventListener('change', toggleRange);
            });
            
            // Initial check
            toggleRange();
        });
    </script>
@endpush