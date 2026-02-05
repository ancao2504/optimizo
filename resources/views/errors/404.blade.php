@extends('layouts.app')

@section('title', 'Page Not Found - Optimizo')
@section('meta_description', 'The page you are looking for could not be found.')

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center -mt-10 overflow-hidden relative">
        <!-- Decorative Background Elements -->
        <div
            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-100 rounded-full blur-3xl opacity-30 -z-10 animate-pulse">
        </div>
        <div
            class="absolute top-1/2 left-1/3 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] bg-purple-100 rounded-full blur-3xl opacity-30 -z-10 mix-blend-multiply">
        </div>

        <div class="text-center px-4 max-w-2xl mx-auto z-10">
            <!-- 404 Text -->
            <div class="relative mb-8">
                <h1
                    class="text-[10rem] md:text-[12rem] font-black leading-none bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent select-none drop-shadow-sm">
                    404
                </h1>
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full text-[10rem] md:text-[12rem] font-black leading-none text-indigo-600/5 blur-lg -z-10 select-none">
                    404
                </div>
            </div>

            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6 tracking-tight">
                Oops! Page Not Found
            </h2>

            <p class="text-lg text-gray-600 mb-10 leading-relaxed max-w-lg mx-auto">
                The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ localeRoute('home') }}"
                    class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Home
                </a>

                <a href="{{ localeRoute('contact') }}"
                    class="w-full sm:w-auto px-8 py-4 bg-white border border-gray-200 hover:border-indigo-200 text-gray-700 hover:text-indigo-600 font-bold rounded-xl hover:shadow-md transition-all duration-300 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Contact Support
                </a>
            </div>
        </div>
    </div>
@endsection