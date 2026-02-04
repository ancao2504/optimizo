@extends('layouts.app')

@section('title', 'Optimizo - Free SEO & Utility Tools for Digital Success')
@section('meta_description', 'Discover 11+ free SEO and utility tools to optimize your digital presence. Password generator, YouTube tools, JSON formatter, Base64 encoder, QR generator, and more!')

@section('content')
    <!-- Modern Hero Section -->
    <div
        class="relative overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-3xl mb-8 shadow-2xl">
        <!-- Animated Background Elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -mr-32 -mt-32 animate-pulse">
        </div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-white opacity-10 rounded-full blur-3xl -ml-24 -mb-24 animate-pulse"
            style="animation-delay: 1s;"></div>

        <div class="relative z-10 px-6 md:px-12 py-8 md:py-12 text-center">
            <!-- Logo/Icon -->
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-2xl shadow-2xl mb-4 transform hover:scale-110 transition-transform duration-300">
                <svg class="w-9 h-9 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>

            <!-- Main Heading -->
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white mb-3 leading-tight">
                Free SEO & Utility Tools
            </h1>

            <!-- Subheading -->
            <p class="text-base md:text-lg lg:text-xl text-white/90 font-medium max-w-3xl mx-auto mb-6 leading-relaxed">
                Powerful, professional tools to optimize your digital presence - 100% free, no registration required!
            </p>

            <!-- Stats -->
            <div class="flex flex-wrap items-center justify-center gap-6 mb-6">
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black text-white mb-1">40+</div>
                    <div class="text-sm text-white/80 font-semibold">Free Tools</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black text-white mb-1">100%</div>
                    <div class="text-sm text-white/80 font-semibold">Free Forever</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl md:text-4xl font-black text-white mb-1">0</div>
                    <div class="text-sm text-white/80 font-semibold">Registration</div>
                </div>
            </div>

            <!-- CTA Button -->
            <a href="#tools"
                class="inline-flex items-center gap-2 bg-white text-indigo-600 px-6 py-3 rounded-full font-bold text-base shadow-2xl hover:shadow-3xl hover:scale-105 transition-all duration-300">
                <span>Explore Tools</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Tools Grid Section -->
    <div id="tools" class="mb-12">
        <div class="text-center mb-10">
            <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">Our Free Tools</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Choose from our collection of professional-grade tools
                designed to boost your productivity</p>
        </div>

        <!-- YouTube Tools -->
        <div class="mb-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                    <path
                        d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                </svg>
                YouTube Tools (9)
            </h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- YouTube Thumbnail Downloader -->
                <a href="{{ route('youtube.thumbnail') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-red-200 hover:border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors">Thumbnail
                                Downloader</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Download HD thumbnails from any YouTube video in all
                        available resolutions</p>
                </a>

                <!-- YouTube Video Data Extractor -->
                <a href="{{ route('youtube.extractor') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-red-200 hover:border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors">Video
                                Data Extractor</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Extract title, description, tags, views, likes,
                        channel, category, and more from any YouTube video</p>
                </a>

                <!-- YouTube Tag Generator -->
                <a href="{{ route('youtube.tags') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-red-200 hover:border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors">Tag
                                Generator</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Generate SEO-optimized tags to boost your video's
                        visibility and rankings</p>
                </a>

                <!-- YouTube Channel Data Extractor -->
                <a href="{{ route('youtube.channel') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-red-200 hover:border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors">Channel
                                Data Extractor</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Extract channel statistics, subscribers, videos, views,
                        and more from any YouTube channel</p>
                </a>

                <!-- YouTube Monetization Checker -->
                <a href="{{ route('youtube.monetization') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-red-200 hover:border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V16h-2.67v2.09c-2.45-.4-4.32-2.24-4.32-4.59h2.67c0 1.71 1.39 3.1 3.1 3.1s3.1-1.39 3.1-3.1c0-1.71-1.39-3.1-3.1-3.1-2.76 0-5-2.24-5-5h2.67c0 1.71 1.39 3.1 3.1 3.1s3.1-1.39 3.1-3.1h2.67c0 2.35-1.87 4.19-4.32 4.59z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors">
                                Monetization Checker</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Check if a YouTube channel is monetized and eligible
                        for ads</p>
                </a>

                <!-- YouTube Handle Checker -->
                <a href="{{ route('youtube.handle') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-red-200 hover:border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors">Handle
                                Checker</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Check if a YouTube handle is available for your channel
                    </p>
                </a>

                <!-- YouTube Video Tags Extractor -->
                <a href="{{ route('youtube.video-tags') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-red-200 hover:border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors">Video
                                Tags Extractor</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Extract tags and keywords from any YouTube video
                    </p>
                </a>

                <!-- YouTube Channel ID Finder -->
                <a href="{{ route('youtube.channel-id') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-red-200 hover:border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors">Channel
                                ID Finder</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Find YouTube channel ID from URL or username
                    </p>
                </a>

                <!-- YouTube Earnings Calculator -->
                <a href="{{ route('youtube.earnings') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-red-200 hover:border-red-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-red-600 transition-colors">Earnings
                                Calculator</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Calculate estimated YouTube earnings and revenue
                    </p>
                </a>
            </div>
        </div>

        <!-- SEO Tools -->
        <div class="mb-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                SEO Tools (3)
            </h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Meta Tag Analyzer -->
                <a href="{{ route('seo.meta-analyzer') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-green-200 hover:border-green-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-green-600 transition-colors">Meta
                                Tag Analyzer</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Analyze and optimize your website's meta tags for
                        better SEO performance</p>
                </a>

                <!-- Keyword Density Checker -->
                <a href="{{ route('seo.keyword-density') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-purple-200 hover:border-purple-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-purple-600 transition-colors">
                                Keyword Density</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Analyze keyword frequency and density in your content
                        for SEO optimization</p>
                </a>

                <!-- Word Counter -->
                <a href="{{ route('seo.word-counter') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-blue-200 hover:border-blue-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition-colors">Word
                                Counter</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Count words, characters, sentences, and estimate
                        reading time for your content</p>
                </a>
            </div>
        </div>

        <!-- Utility Tools -->
        <div class="mb-12">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Utility Tools (18)
            </h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Password Generator -->
                <a href="{{ route('utility.password-generator') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-indigo-200 hover:border-indigo-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-indigo-600 transition-colors">
                                Password Generator</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Generate strong, secure passwords with customizable
                        options and strength meter</p>
                </a>

                <!-- JSON Formatter -->
                <a href="{{ route('utility.json-formatter') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-indigo-200 hover:border-indigo-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-indigo-600 transition-colors">JSON
                                Formatter</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Format, beautify, and minify JSON data with syntax
                        highlighting and error detection</p>
                </a>

                <!-- Base64 Encoder/Decoder -->
                <a href="{{ route('utility.base64') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-green-200 hover:border-green-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-green-600 transition-colors">Base64
                                Encoder</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Encode text to Base64 or decode Base64 strings
                        instantly with Unicode support</p>
                </a>

                <!-- QR Code Generator -->
                <a href="{{ route('utility.qr-generator') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-purple-200 hover:border-purple-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-purple-600 transition-colors">QR
                                Code Generator</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Create custom QR codes for URLs, text, and more in
                        multiple sizes</p>
                </a>

                <!-- Username Checker -->
                <a href="{{ route('utility.username-checker') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-purple-200 hover:border-purple-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-purple-600 transition-colors">
                                Username
                                Checker</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Check username availability across multiple social
                        media platforms</p>
                </a>

                <!-- MD5 Generator -->
                <a href="{{ route('utility.md5-generator') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-green-200 hover:border-green-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-green-600 transition-colors">MD5
                                Generator</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Generate MD5 hashes from text for passwords and data
                        encryption</p>
                </a>

                <!-- Case Converter -->
                <a href="{{ route('utility.case-converter') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-orange-200 hover:border-orange-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M9.4 16.6L4.8 12l4.6-4.6L8 6l-6 6 6 6 1.4-1.4zm5.2 0l4.6-4.6-4.6-4.6L16 6l6 6-6 6-1.4-1.4z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-orange-600 transition-colors">Case
                                Converter</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Convert text between uppercase, lowercase, title, and
                        sentence case</p>
                </a>

                <!-- RGB to HEX Converter -->
                <a href="{{ route('utility.rgb-hex-converter') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-pink-200 hover:border-pink-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-pink-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 3c-4.97 0-9 4.03-9 9s4.03 9 9 9c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-pink-600 transition-colors">RGB to
                                HEX</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Convert colors between RGB and HEX formats with live
                        preview</p>
                </a>

                <!-- Slug Generator -->
                <a href="{{ route('utility.slug-generator') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-violet-200 hover:border-violet-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3.9 12c0-1.71 1.39-3.1 3.1-3.1h4V7H7c-2.76 0-5 2.24-5 5s2.24 5 5 5h4v-1.9H7c-1.71 0-3.1-1.39-3.1-3.1zM8 13h8v-2H8v2zm9-6h-4v1.9h4c1.71 0 3.1 1.39 3.1 3.1s-1.39 3.1-3.1 3.1h-4V17h4c2.76 0 5-2.24 5-5s-2.24-5-5-5z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-violet-600 transition-colors">Slug
                                Generator</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Create SEO-friendly URL slugs from any text or title
                    </p>
                </a>

                <!-- Image Compressor -->
                <a href="{{ route('utility.image-compressor') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-cyan-200 hover:border-cyan-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-cyan-600 transition-colors">Image
                                Compressor</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Compress images while maintaining quality with
                        adjustable settings</p>
                </a>

                <!-- Internet Speed Test -->
                <a href="{{ route('network.internet-speed-test') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-teal-200 hover:border-teal-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-teal-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20.38 8.57l-1.23 1.85a8 8 0 0 1-.22 7.58H5.07A8 8 0 0 1 15.58 6.85l1.85-1.23A10 10 0 0 0 3.35 19a2 2 0 0 0 1.72 1h13.85a2 2 0 0 0 1.74-1 10 10 0 0 0-.27-10.44z" />
                                <path d="M10.59 15.41a2 2 0 0 0 2.83 0l5.66-8.49-8.49 5.66a2 2 0 0 0 0 2.83z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-teal-600 transition-colors">Speed
                                Test</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Test your internet connection speed and latency</p>
                </a>

                <!-- HTML Viewer -->
                <a href="{{ route('utility.html-viewer') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-orange-200 hover:border-orange-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-orange-600 transition-colors">HTML
                                Viewer</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Preview HTML code in real-time with live rendering</p>
                </a>

                <!-- JSON Parser -->
                <a href="{{ route('utility.json-parser') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-blue-200 hover:border-blue-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition-colors">JSON
                                Parser</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Parse and validate JSON data with syntax highlighting
                    </p>
                </a>

                <!-- Code Formatter -->
                <a href="{{ route('utility.code-formatter') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-violet-200 hover:border-violet-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-violet-600 transition-colors">Code
                                Formatter</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Format and beautify code in multiple programming
                        languages</p>
                </a>

                <!-- CSS Minifier -->
                <a href="{{ route('utility.css-minifier') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-blue-200 hover:border-blue-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M4.192 3.143h15.615l-1.42 16.034-6.404 1.812-6.369-1.813L4.192 3.143zM16.9 6.424l-9.8-.002.158 1.949 7.529.002-.189 2.02H9.66l.179 1.913h4.597l-.272 2.62-2.164.598-2.197-.603-.141-1.569h-1.94l.216 2.867L12 17.484l3.995-1.137.905-9.923z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition-colors">CSS
                                Minifier</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Minify and beautify CSS code online</p>
                </a>

                <!-- JavaScript Minifier -->
                <a href="{{ route('utility.js-minifier') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-yellow-200 hover:border-yellow-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3 3h18v18H3V3zm16.525 13.707c-.131-.821-.666-1.511-2.252-2.155-.552-.259-1.165-.438-1.349-.854-.068-.248-.078-.382-.034-.529.113-.484.687-.629 1.137-.495.293.09.563.315.732.676.775-.507.775-.507 1.316-.844-.203-.314-.304-.451-.439-.586-.473-.528-1.103-.798-2.126-.775l-.528.067c-.507.124-.991.395-1.283.754-.855.968-.611 2.655.427 3.354 1.023.765 2.521.933 2.712 1.653.18.878-.652 1.159-1.475 1.058-.607-.136-.945-.439-1.316-1.002l-1.372.788c.157.359.337.517.607.832 1.305 1.316 4.568 1.249 5.153-.754.021-.067.18-.528.056-1.237l.034.049zm-6.737-5.434h-1.686c0 1.453-.007 2.898-.007 4.354 0 .924.047 1.772-.104 2.033-.247.517-.886.451-1.175.359-.297-.146-.448-.349-.623-.641-.047-.078-.082-.146-.095-.146l-1.368.844c.229.473.563.879.994 1.137.641.383 1.502.507 2.404.305.588-.17 1.095-.519 1.358-1.059.384-.697.302-1.553.299-2.509.008-1.541 0-3.083 0-4.635l.003-.042z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-yellow-600 transition-colors">
                                JavaScript Minifier</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Minify and beautify JavaScript code online</p>
                </a>

                <!-- HTML Minifier -->
                <a href="{{ route('utility.html-minifier') }}"
                    class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-pink-200 hover:border-pink-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex items-center gap-4 mb-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 17.56l-6.94 3.64 1.33-7.74L.78 8.1l7.78-1.13L12 0l3.44 6.97 7.78 1.13-5.61 5.36 1.33 7.74z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-gray-900 group-hover:text-pink-600 transition-colors">HTML
                                Minifier</h4>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm leading-relaxed">Minify and beautify HTML code online</p>
                </a>
            </div>
        </div>
    </div>

    <!-- Network Tools -->
    <div class="mb-12">
        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
            </svg>
            Network Tools (10)
        </h3>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- What Is My IP -->
            <a href="{{ route('network.what-is-my-ip') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-blue-200 hover:border-blue-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition-colors">What Is My
                            IP</h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Find your public IP address and location information</p>
            </a>

            <!-- What Is My ISP -->
            <a href="{{ route('network.what-is-my-isp') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-indigo-200 hover:border-indigo-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3c-1.65-1.66-4.34-1.66-6 0zm-4-4l2 2c2.76-2.76 7.24-2.76 10 0l2-2C15.14 9.14 8.87 9.14 5 13z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-indigo-600 transition-colors">What Is My
                            ISP</h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Discover your Internet Service Provider details</p>
            </a>

            <!-- Domain to IP -->
            <a href="{{ route('network.domain-to-ip') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-emerald-200 hover:border-emerald-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-emerald-600 transition-colors">Domain to
                            IP</h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Convert domain names to IP addresses with DNS lookup</p>
            </a>

            <!-- IP Lookup -->
            <a href="{{ route('network.ip-lookup') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-blue-200 hover:border-blue-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-blue-600 transition-colors">IP Lookup
                        </h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Get detailed information about any IP address</p>
            </a>

            <!-- DNS Lookup -->
            <a href="{{ route('network.dns-lookup') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-purple-200 hover:border-purple-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-purple-600 transition-colors">DNS Lookup
                        </h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Look up DNS records for any domain</p>
            </a>

            <!-- WHOIS Lookup -->
            <a href="{{ route('network.whois-lookup') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-teal-200 hover:border-teal-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-teal-600 transition-colors">WHOIS Lookup
                        </h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Get domain registration information</p>
            </a>

            <!-- Ping Test -->
            <a href="{{ route('network.ping-test') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-green-200 hover:border-green-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-green-600 transition-colors">Ping Test
                        </h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Test connectivity and latency to any host</p>
            </a>

            <!-- Traceroute -->
            <a href="{{ route('network.traceroute') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-indigo-200 hover:border-indigo-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 013.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-indigo-600 transition-colors">Traceroute
                        </h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Trace the route packets take to destination</p>
            </a>

            <!-- Port Checker -->
            <a href="{{ route('network.port-checker') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-rose-200 hover:border-rose-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-rose-600 transition-colors">Port Checker
                        </h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Check if a port is open on any server</p>
            </a>

            <!-- Reverse DNS -->
            <a href="{{ route('network.reverse-dns') }}"
                class="group bg-white rounded-2xl p-6 shadow-lg border-2 border-pink-200 hover:border-pink-500 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-pink-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-900 group-hover:text-pink-600 transition-colors">Reverse DNS
                        </h4>
                    </div>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">Find hostname from IP address</p>
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-8 md:p-12 mb-12 shadow-xl">
        <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-8 text-center">Why Choose Optimizo?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">100% Free</h3>
                <p class="text-gray-600">All tools are completely free with no hidden costs or premium features</p>
            </div>
            <div class="text-center">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Secure & Private</h3>
                <p class="text-gray-600">All processing happens in your browser - your data never leaves your computer</p>
            </div>
            <div class="text-center">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Instant Results</h3>
                <p class="text-gray-600">Get results immediately with our fast, client-side processing technology</p>
            </div>
        </div>
    </div>
@endsection