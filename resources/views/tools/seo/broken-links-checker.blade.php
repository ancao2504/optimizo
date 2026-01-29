@extends('layouts.app')

@section('title', __tool('broken-links-checker', 'meta.title'))
@section('meta_description', __tool('broken-links-checker', 'meta.description'))

@section('content')
    <div class="max-w-5xl mx-auto">
        <!-- Hero Section -->
        <x-tool-hero :tool="$tool" />


        <!-- Tool Interface -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-red-100 mb-8">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl shadow-lg mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    {{ __tool('broken-links-checker', 'interface.scan_title') }}</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">{{ __tool('broken-links-checker', 'interface.scan_subtitle') }}
                </p>
            </div>

            <form id="brokenLinksForm" class="max-w-3xl mx-auto">
                @csrf
                <div class="space-y-6">
                    <!-- URL Input -->
                    <div class="group">
                        <label for="urlInput"
                            class="block text-sm font-bold text-gray-600 uppercase tracking-wider mb-2 ml-1">
                            {{ __tool('broken-links-checker', 'interface.url_label') }}
                        </label>
                        <div class="relative transition-all duration-300 group-focus-within:-translate-y-1">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <input type="url" name="url" id="urlInput" required placeholder="https://example.com/page"
                                class="w-full bg-gray-50 text-gray-900 placeholder-gray-400 border-2 border-gray-100 rounded-xl px-6 py-4 pl-14 outline-none focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-semibold text-lg shadow-inner">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" id="submitBtn"
                            class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold text-xl rounded-xl px-8 py-5 shadow-xl shadow-gray-500/30 transform hover:scale-[1.01] active:scale-[0.99] transition-all duration-300 flex items-center justify-center gap-3">
                            <span id="btnText">{{ __tool('broken-links-checker', 'interface.button') }}</span>
                            <div id="btnLoading" class="hidden flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                {{ __tool('broken-links-checker', 'interface.button_scanning') }}
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Progress Section (Full Width) -->
        <div id="progressSection" class="hidden mb-8">
            <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-indigo-100">
                <div class="flex justify-between items-center mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600 animate-pulse" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="text-base font-bold text-gray-700"
                            id="progressStatus">{{ __tool('broken-links-checker', 'progress.extracting') }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <span
                            class="text-3xl font-black bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent"
                            id="progressPercent">0%</span>
                        <button id="stopBtn"
                            class="hidden px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-bold rounded-lg transition-all shadow-md">
                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            {{ __tool('broken-links-checker', 'progress.stop') }}
                        </button>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-6 overflow-hidden shadow-inner">
                    <div id="progressBar"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 h-full w-0 transition-all duration-300 ease-out relative">
                        <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
                    </div>
                </div>
                <div class="flex justify-between items-center mt-3">
                    <div class="text-sm text-gray-500 font-medium">
                        {{ __tool('broken-links-checker', 'progress.processing') }}</div>
                    <div class="text-sm font-bold text-gray-600">{{ __tool('broken-links-checker', 'progress.processed') }}
                        <span id="processedCount" class="text-indigo-600">0</span>
                        {{ __tool('broken-links-checker', 'progress.of') }} <span id="totalCount"
                            class="text-indigo-600">0</span> {{ __tool('broken-links-checker', 'progress.links') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div id="resultsSection" class="hidden mb-8 scroll-mt-24">
            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-blue-500">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">
                        {{ __tool('broken-links-checker', 'stats.total') }}</div>
                    <div class="text-3xl font-black text-gray-800" id="statTotal">0</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-green-500">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">
                        {{ __tool('broken-links-checker', 'stats.working') }}</div>
                    <div class="text-3xl font-black text-green-600" id="statWorking">0</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">
                        {{ __tool('broken-links-checker', 'stats.redirects') }}</div>
                    <div class="text-3xl font-black text-yellow-600" id="statRedirects">0</div>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-md border-l-4 border-red-500">
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider mb-1">
                        {{ __tool('broken-links-checker', 'stats.broken') }}</div>
                    <div class="text-3xl font-black text-red-600" id="statBroken">0</div>
                </div>
            </div>

            <!-- Export Button (Hidden until done) -->
            <div id="actionArea" class="hidden flex justify-end mb-4">
                <button onclick="downloadCSV()"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl flex items-center shadow-lg transform hover:scale-105 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    {{ __tool('broken-links-checker', 'results.download') }}
                </button>
            </div>

            <!-- Links Table -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="border-b border-gray-100 p-6 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                        <div class="bg-red-100 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        {{ __tool('broken-links-checker', 'results.detailed_analysis') }}
                    </h3>
                    <div class="flex space-x-2 text-xs">
                        <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-green-500 mr-1"></span>
                            {{ __tool('broken-links-checker', 'interface.legend_ok') }}</span>
                        <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-red-500 mr-1"></span>
                            {{ __tool('broken-links-checker', 'interface.legend_err') }}</span>
                    </div>
                </div>
                <div class="max-h-[600px] overflow-y-auto">
                    <table class="w-full text-left border-collapse relative">
                        <thead class="sticky top-0 bg-gray-100 z-10 shadow-sm">
                            <tr class="text-gray-500 uppercase text-xs tracking-wider border-b border-gray-200">
                                <th class="p-4 font-bold w-32">{{ __tool('broken-links-checker', 'results.status') }}</th>
                                <th class="p-4 font-bold">{{ __tool('broken-links-checker', 'results.link_url') }}</th>
                                <th class="p-4 font-bold w-48">{{ __tool('broken-links-checker', 'results.anchor_text') }}
                                </th>
                                <th class="p-4 font-bold text-right w-24">
                                    {{ __tool('broken-links-checker', 'results.type') }}</th>
                            </tr>
                        </thead>
                        <tbody id="linksTableBody" class="text-sm divide-y divide-gray-100">
                            <!-- Rows injected via JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SEO Content Section -->
        <div
            class="bg-gradient-to-br from-red-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-red-100 shadow-2xl mb-8 mt-8">

            <!-- Introduction -->
            <div class="text-center mb-12">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl shadow-xl mb-6">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">
                    {{ __tool('broken-links-checker', 'content.main_title') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    {{ __tool('broken-links-checker', 'content.main_subtitle') }}
                </p>
            </div>

            <!-- Key Benefits Grid -->
            <div class="grid md:grid-cols-3 gap-8 mb-16">
                <div
                    class="bg-white rounded-2xl p-6 shadow-lg border-2 border-transparent hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-2xl mb-4">📉</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">
                        {{ __tool('broken-links-checker', 'benefits.ux_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __tool('broken-links-checker', 'benefits.ux_desc') }}</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-lg border-2 border-transparent hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl mb-4">🤖</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">
                        {{ __tool('broken-links-checker', 'benefits.seo_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">{{ __tool('broken-links-checker', 'benefits.seo_desc') }}</p>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-lg border-2 border-transparent hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl mb-4">⚡</div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">
                        {{ __tool('broken-links-checker', 'benefits.maintenance_title') }}</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ __tool('broken-links-checker', 'benefits.maintenance_desc') }}</p>
                </div>
            </div>

            <!-- What is a Broken Link Checker -->
            <div class="bg-white rounded-2xl p-8 mb-12 border-l-4 border-red-500 shadow-sm">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">
                    {{ __tool('broken-links-checker', 'content.what_is_title') }}</h3>
                <p class="mb-6 text-gray-700 leading-relaxed">
                    {!! __tool('broken-links-checker', 'content.what_is_desc') !!}
                </p>

                <h4 class="text-lg font-bold text-gray-900 mb-3">
                    {{ __tool('broken-links-checker', 'content.how_works_title') }}</h4>
                <p class="mb-4 text-gray-700 leading-relaxed">
                    {{ __tool('broken-links-checker', 'content.how_works_intro') }}
                </p>
                <ol class="list-decimal list-inside space-y-2 text-gray-700 mb-6 ml-4">
                    <li>{!! __tool('broken-links-checker', 'content.how_works_step1') !!}</li>
                    <li>{!! __tool('broken-links-checker', 'content.how_works_step2') !!}</li>
                    <li>{!! __tool('broken-links-checker', 'content.how_works_step3') !!}</li>
                </ol>

                <div class="bg-red-50 p-4 rounded-lg">
                    <p class="text-sm text-red-900">
                        <strong>{{ __tool('broken-links-checker', 'content.pro_tip_title') }}</strong>
                        {{ __tool('broken-links-checker', 'content.pro_tip_desc') }}
                    </p>
                </div>
            </div>

            <!-- Types of Broken Links -->
            <div class="mb-12">
                <h3 class="text-2xl font-black text-gray-900 mb-8 border-b-2 border-red-100 pb-4">
                    {{ __tool('broken-links-checker', 'content.types_title') }}</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-white/80 p-6 rounded-xl border border-red-50 hover:bg-white transition-colors">
                        <h4 class="font-bold text-lg text-gray-900 mb-2 flex items-center gap-2">
                            {!! __tool('broken-links-checker', 'link_types.type1_title') !!}
                        </h4>
                        <p class="text-sm text-gray-600">
                            {{ __tool('broken-links-checker', 'link_types.type1_desc') }}
                        </p>
                    </div>
                    <div class="bg-white/80 p-6 rounded-xl border border-red-50 hover:bg-white transition-colors">
                        <h4 class="font-bold text-lg text-gray-900 mb-2 flex items-center gap-2">
                            {!! __tool('broken-links-checker', 'link_types.type2_title') !!}
                        </h4>
                        <p class="text-sm text-gray-600">
                            {{ __tool('broken-links-checker', 'link_types.type2_desc') }}
                        </p>
                    </div>
                    <div class="bg-white/80 p-6 rounded-xl border border-red-50 hover:bg-white transition-colors">
                        <h4 class="font-bold text-lg text-gray-900 mb-2 flex items-center gap-2">
                            {!! __tool('broken-links-checker', 'link_types.type3_title') !!}
                        </h4>
                        <p class="text-sm text-gray-600">
                            {{ __tool('broken-links-checker', 'link_types.type3_desc') }}
                        </p>
                    </div>
                    <div class="bg-white/80 p-6 rounded-xl border border-red-50 hover:bg-white transition-colors">
                        <h4 class="font-bold text-lg text-gray-900 mb-2 flex items-center gap-2">
                            {!! __tool('broken-links-checker', 'link_types.type4_title') !!}
                        </h4>
                        <p class="text-sm text-gray-600">
                            {{ __tool('broken-links-checker', 'link_types.type4_desc') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Common Causes -->
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-2xl p-8 mb-12">
                <h4 class="font-bold text-yellow-900 mb-4 flex items-center gap-3 text-xl">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __tool('broken-links-checker', 'content.common_causes_title') }}
                </h4>
                <ul class="text-yellow-800 leading-relaxed space-y-2">
                    <li>{!! __tool('broken-links-checker', 'content.cc_1') !!}</li>
                    <li>{!! __tool('broken-links-checker', 'content.cc_2') !!}</li>
                    <li>{!! __tool('broken-links-checker', 'content.cc_3') !!}</li>
                    <li>{!! __tool('broken-links-checker', 'content.cc_4') !!}</li>
                    <li>{!! __tool('broken-links-checker', 'content.cc_5') !!}</li>
                    <li>{!! __tool('broken-links-checker', 'content.cc_6') !!}</li>
                </ul>
            </div>

            <!-- Best Practices -->
            <div class="mb-12">
                <h3 class="text-3xl font-black text-gray-900 mb-8">
                    {{ __tool('broken-links-checker', 'content.best_practices_title') }}</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-red-300 transition-all shadow-lg hover:shadow-xl">
                        <div class="text-3xl mb-3">🔍</div>
                        <h4 class="font-bold text-gray-900 mb-2">
                            {{ __tool('broken-links-checker', 'best_practices.bp1_title') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('broken-links-checker', 'best_practices.bp1_desc') }}</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-red-300 transition-all shadow-lg hover:shadow-xl">
                        <div class="text-3xl mb-3">↪️</div>
                        <h4 class="font-bold text-gray-900 mb-2">
                            {{ __tool('broken-links-checker', 'best_practices.bp2_title') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('broken-links-checker', 'best_practices.bp2_desc') }}</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-red-300 transition-all shadow-lg hover:shadow-xl">
                        <div class="text-3xl mb-3">📊</div>
                        <h4 class="font-bold text-gray-900 mb-2">
                            {{ __tool('broken-links-checker', 'best_practices.bp3_title') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('broken-links-checker', 'best_practices.bp3_desc') }}</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-red-300 transition-all shadow-lg hover:shadow-xl">
                        <div class="text-3xl mb-3">📝</div>
                        <h4 class="font-bold text-gray-900 mb-2">
                            {{ __tool('broken-links-checker', 'best_practices.bp4_title') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('broken-links-checker', 'best_practices.bp4_desc') }}</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-red-300 transition-all shadow-lg hover:shadow-xl">
                        <div class="text-3xl mb-3">🔗</div>
                        <h4 class="font-bold text-gray-900 mb-2">
                            {{ __tool('broken-links-checker', 'best_practices.bp5_title') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('broken-links-checker', 'best_practices.bp5_desc') }}</p>
                    </div>
                    <div
                        class="bg-white rounded-xl p-6 border-2 border-gray-200 hover:border-red-300 transition-all shadow-lg hover:shadow-xl">
                        <div class="text-3xl mb-3">⚙️</div>
                        <h4 class="font-bold text-gray-900 mb-2">
                            {{ __tool('broken-links-checker', 'best_practices.bp6_title') }}</h4>
                        <p class="text-gray-600 text-sm">{{ __tool('broken-links-checker', 'best_practices.bp6_desc') }}</p>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="mb-8">
                <h3 class="text-3xl font-black text-center text-gray-900 mb-10">
                    {{ __tool('broken-links-checker', 'faq.title') }}</h3>
                <div class="space-y-4 max-w-3xl mx-auto">
                    <!-- FAQ Item 1 -->
                    <details class="group bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                        <summary
                            class="flex justify-between items-center font-bold text-gray-800 cursor-pointer list-none p-6 hover:bg-gray-50 transition-colors">
                            <span>{{ __tool('broken-links-checker', 'faq.q1') }}</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-red-600">
                                <svg fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <div class="text-gray-600 p-6 pt-0 leading-relaxed">
                            {{ __tool('broken-links-checker', 'faq.a1') }}
                        </div>
                    </details>

                    <!-- FAQ Item 2 -->
                    <details class="group bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                        <summary
                            class="flex justify-between items-center font-bold text-gray-800 cursor-pointer list-none p-6 hover:bg-gray-50 transition-colors">
                            <span>{{ __tool('broken-links-checker', 'faq.q2') }}</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-red-600">
                                <svg fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <div class="text-gray-600 p-6 pt-0 leading-relaxed">
                            {!! __tool('broken-links-checker', 'faq.a2') !!}
                        </div>
                    </details>

                    <!-- FAQ Item 3 -->
                    <details class="group bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                        <summary
                            class="flex justify-between items-center font-bold text-gray-800 cursor-pointer list-none p-6 hover:bg-gray-50 transition-colors">
                            <span>{{ __tool('broken-links-checker', 'faq.q3') }}</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-red-600">
                                <svg fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <div class="text-gray-600 p-6 pt-0 leading-relaxed">
                            {!! __tool('broken-links-checker', 'faq.a3') !!}
                        </div>
                    </details>

                    <!-- FAQ Item 4 -->
                    <details class="group bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                        <summary
                            class="flex justify-between items-center font-bold text-gray-800 cursor-pointer list-none p-6 hover:bg-gray-50 transition-colors">
                            <span>{{ __tool('broken-links-checker', 'faq.q4') }}</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-red-600">
                                <svg fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <div class="text-gray-600 p-6 pt-0 leading-relaxed">
                            {!! __tool('broken-links-checker', 'faq.a4') !!}
                        </div>
                    </details>

                    <!-- FAQ Item 5 -->
                    <details class="group bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                        <summary
                            class="flex justify-between items-center font-bold text-gray-800 cursor-pointer list-none p-6 hover:bg-gray-50 transition-colors">
                            <span>{{ __tool('broken-links-checker', 'faq.q_what_to_do') }}</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-red-600">
                                <svg fill="none" height="24" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                                    width="24">
                                    <path d="M6 9l6 6 6-6"></path>
                                </svg>
                            </span>
                        </summary>
                        <div class="text-gray-600 p-6 pt-0 leading-relaxed">
                            {{ __tool('broken-links-checker', 'faq.a_what_to_do_intro') }}
                            <ol class="list-decimal ml-6 mt-2 space-y-2">
                                <li>{!! __tool('broken-links-checker', 'faq.a_what_to_do_li1') !!}</li>
                                <li>{!! __tool('broken-links-checker', 'faq.a_what_to_do_li2') !!}</li>
                                <li>{!! __tool('broken-links-checker', 'faq.a_what_to_do_li3') !!}</li>
                                <li>{!! __tool('broken-links-checker', 'faq.a_what_to_do_li4') !!}</li>
                            </ol>
                        </div>
                    </details>
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script>
        let allLinks = [];
        let processedCount = 0;

        document.getElementById('brokenLinksForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const form = this;
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const resultsSection = document.getElementById('resultsSection');
            const progressSection = document.getElementById('progressSection');
            const tbody = document.getElementById('linksTableBody');
            const actionArea = document.getElementById('actionArea');

            // Reset
            processedCount = 0;
            allLinks = [];
            tbody.innerHTML = '';
            document.getElementById('statTotal').innerText = '0';
            document.getElementById('statWorking').innerText = '0';
            document.getElementById('statRedirects').innerText = '0';
            document.getElementById('statBroken').innerText = '0';
            document.getElementById('progressPercent').innerText = '0%';
            document.getElementById('progressBar').style.width = '0%';
            document.getElementById('processedCount').innerText = '0';
            document.getElementById('totalCount').innerText = '0';
            document.getElementById('progressStatus').innerText = '{{ __tool('broken-links-checker', 'progress.extracting') }}';

            btn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            resultsSection.classList.add('hidden'); // Hide results until extraction done? No, maybe show empty structure
            progressSection.classList.remove('hidden');
            actionArea.classList.add('hidden');

            try {
                // Phase 1: Extract
                const formData = new FormData(form);
                const extractResponse = await fetch("{{ route('seo.broken-links-checker.extract') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const extractData = await extractResponse.json();

                if (!extractResponse.ok) throw new Error(extractData.error || 'Extraction Failed');

                allLinks = extractData.links;
                const total = allLinks.length;

                document.getElementById('statTotal').innerText = total;
                document.getElementById('totalCount').innerText = total;
                document.getElementById('progressStatus').innerText = '{{ __tool('broken-links-checker', 'progress.checking') }}';

                // Show stop button
                const stopBtn = document.getElementById('stopBtn');
                stopBtn.classList.remove('hidden');
                let shouldStop = false;

                stopBtn.onclick = () => {
                    shouldStop = true;
                    stopBtn.disabled = true;
                    stopBtn.innerHTML = '<svg class="w-4 h-4 inline-block mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> {{ __tool('broken-links-checker', 'js.stopping') }}';
                    document.getElementById('progressStatus').innerText = '{{ __tool('broken-links-checker', 'js.stopping') }}';
                };

                // Render Initial Table (Pending Status)
                resultsSection.classList.remove('hidden');
                renderInitialRows(allLinks);

                // Phase 2: Check Links Sequentially (One at a time for resource efficiency)
                for (let i = 0; i < allLinks.length; i++) {
                    if (shouldStop) {
                        document.getElementById('progressStatus').innerText = '{{ __tool('broken-links-checker', 'js.scan_stopped') }}';
                        document.getElementById('progressBar').classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600');
                        document.getElementById('progressBar').classList.add('bg-yellow-500');
                        break;
                    }

                    await checkLink(allLinks[i]);
                }

                // Phase 3: Done
                if (!shouldStop) {
                    document.getElementById('progressStatus').innerText = '{{ __tool('broken-links-checker', 'js.scan_complete') }}';
                    document.getElementById('progressBar').classList.remove('bg-gradient-to-r', 'from-indigo-600', 'to-purple-600');
                    document.getElementById('progressBar').classList.add('bg-green-600');
                    actionArea.classList.remove('hidden');
                } else {
                    actionArea.classList.remove('hidden'); // Show export even if stopped
                }

                // Hide stop button
                stopBtn.classList.add('hidden');

            } catch (error) {
                console.error(error);
                showError('{{ __tool('broken-links-checker', 'js.error_prefix') }}' + error.message);
            } finally {
                btn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                document.getElementById('stopBtn').classList.add('hidden');
            }
        });

        function renderInitialRows(links) {
            const tbody = document.getElementById('linksTableBody');
            let html = '';
            links.forEach((link, index) => {
                html += `
                                    <tr id="row-${index}" class="hover:bg-gray-50/80 transition-colors border-b border-gray-100 last:border-0 opacity-60">
                                        <td class="p-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-500 status-badge">
                                                <svg class="animate-spin -ml-1 mr-1 h-3 w-3 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg> {{ __tool('broken-links-checker', 'js.pending') }}
                                            </span>
                                        </td>
                                        <td class="p-4 max-w-xs truncate" title="${link.url}">
                                             <a href="${link.url}" target="_blank" class="text-gray-400 font-medium hover:underline pointer-events-none link-url">
                                                ${link.url}
                                            </a>
                                        </td>
                                        <td class="p-4 text-gray-600 font-medium truncate">${link.text}</td>
                                         <td class="p-4 text-right">
                                            <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full uppercase tracking-wide">
                                                ${link.is_internal ? '{{ __tool('broken-links-checker', 'js.internal') }}' : '{{ __tool('broken-links-checker', 'js.external') }}'}
                                            </span>
                                        </td>
                                    </tr>
                                `;
            });
            tbody.innerHTML = html;
        }

        async function checkLink(link) {
            // Find raw index in allLinks to update row
            const index = allLinks.indexOf(link);
            const row = document.getElementById(`row-${index}`);

            try {
                const response = await fetch("{{ route('seo.broken-links-checker.status') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ url: link.url })
                });
                const data = await response.json();

                // Update Data Source
                allLinks[index].status = data.status;
                allLinks[index].health = data.health;

                // Update UI Row
                updateRow(row, data, link);
                updateStats();

            } catch (e) {
                console.error('Check failed', e);
                // Mark as error
                allLinks[index].status = 0;
                allLinks[index].health = 'broken';
                updateRow(row, { status: 0, health: 'broken' }, link);
                updateStats();
            }

            // Update Progress
            processedCount++;
            const percent = Math.round((processedCount / allLinks.length) * 100);
            document.getElementById('processedCount').innerText = processedCount;
            document.getElementById('progressPercent').innerText = percent + '%';
            document.getElementById('progressBar').style.width = percent + '%';
        }

        function updateRow(row, data, link) {
            row.classList.remove('opacity-60');
            const badgeCell = row.querySelector('.status-badge');
            const urlLink = row.querySelector('.link-url');

            let badgeClass = '';
            let icon = '';
            let statusText = data.status > 0 ? data.status : 'ERR';

            if (data.health === 'working') {
                badgeClass = 'bg-green-100 text-green-700 ring-1 ring-green-600/20';
                icon = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';
            } else if (data.health === 'redirect') {
                badgeClass = 'bg-yellow-100 text-yellow-800 ring-1 ring-yellow-600/20';
                icon = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>';
            } else {
                badgeClass = 'bg-red-100 text-red-700 ring-1 ring-red-600/20 font-bold';
                icon = '<svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            }

            badgeCell.className = `inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium status-badge ${badgeClass}`;
            badgeCell.innerHTML = `${icon} ${statusText}`;

            urlLink.classList.remove('text-gray-400', 'pointer-events-none');
            urlLink.classList.add('text-indigo-600');
        }

        function updateStats() {
            const working = allLinks.filter(l => l.health === 'working').length;
            const broken = allLinks.filter(l => l.health === 'broken').length;
            const redirects = allLinks.filter(l => l.health === 'redirect').length;

            document.getElementById('statWorking').innerText = working;
            document.getElementById('statBroken').innerText = broken;
            document.getElementById('statRedirects').innerText = redirects;
        }

        window.downloadCSV = function () {
            let csvContent = "data:text/csv;charset=utf-8,";
            csvContent += "URL,Text,Type,Status,Health\r\n";

            allLinks.forEach(function (link) {
                let row = [
                    `"${link.url}"`,
                    `"${link.text.replace(/"/g, '""')}"`,
                    link.is_internal ? 'Internal' : 'External',
                    link.status,
                    link.health
                ].join(",");
                csvContent += row + "\r\n";
            });

            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "broken_links_report.csv");
            document.body.appendChild(link); // Required for FF
            link.click();
            document.body.removeChild(link);
        }
    </script>
@endpush