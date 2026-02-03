@extends('layouts.app')

@section('title', __tool('unix-timestamp-to-date', 'meta.title'))
@section('meta_description', __tool('unix-timestamp-to-date', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto px-4">
        <x-tool-hero :tool="$tool" title="{{ __tool('unix-timestamp-to-date', 'meta.h1') }}"
            description="{{ __tool('unix-timestamp-to-date', 'meta.subtitle') }}" />

        {{-- Tool Editor --}}
        <div
            class="bg-white rounded-3xl shadow-xl border border-indigo-50 p-8 md:p-12 mb-12 relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-indigo-50 rounded-full mix-blend-multiply opacity-50 blur-3xl -mr-32 -mt-32 group-hover:scale-110 transition-transform duration-700">
            </div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2 ml-1">
                            {{ __tool('unix-timestamp-to-date', 'editor.label_input') }}
                        </label>
                        <div class="relative">
                            <input type="text" id="tsInput"
                                class="w-full text-2xl font-mono text-indigo-700 bg-indigo-50/50 border-2 border-indigo-100 rounded-2xl px-6 py-5 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all placeholder-indigo-200"
                                placeholder="{{ __tool('unix-timestamp-to-date', 'editor.ph_input') }}"
                                value="{{ time() }}">
                            <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                <button onclick="convertTs()"
                                    class="p-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-lg transition-all hover:scale-105">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="tsResult" class="hidden space-y-4 pt-8 border-t border-gray-100 animate-fade-in">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100">
                                <span
                                    class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">{{ __tool('unix-timestamp-to-date', 'editor.result_gmt') }}</span>
                                <div id="resGmt" class="text-lg font-mono text-gray-800 font-bold break-all"></div>
                            </div>
                            <div class="p-6 bg-indigo-50 border border-indigo-100 rounded-2xl">
                                <span
                                    class="text-xs font-bold text-indigo-400 uppercase tracking-widest block mb-2">{{ __tool('unix-timestamp-to-date', 'editor.result_local') }}</span>
                                <div id="resLocal" class="text-lg font-mono text-indigo-900 font-black break-all"></div>
                            </div>
                        </div>
                        <div class="p-6 bg-purple-50 border border-purple-100 rounded-2xl text-center">
                            <span
                                class="text-xs font-bold text-purple-400 uppercase tracking-widest block mb-1">{{ __tool('unix-timestamp-to-date', 'editor.result_relative') }}</span>
                            <div id="resRelative" class="text-xl font-bold text-purple-900"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Section --}}
        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __tool('unix-timestamp-to-date', 'content.what_is_title') }}
                </h2>
                <div class="prose prose-indigo text-gray-600">
                    <p>{{ __tool('unix-timestamp-to-date', 'content.what_is_desc') }}</p>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl shadow-xl p-8 text-white flex flex-col justify-center">
                <h3 class="text-xl font-bold mb-2">{{ __tool('unix-timestamp-to-date', 'content.pro_tip_title') }}</h3>
                <p class="opacity-90 leading-relaxed">
                    {{ __tool('unix-timestamp-to-date', 'content.pro_tip_desc') }}
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function convertTs() {
                const ts = document.getElementById('tsInput').value.trim();
                const resGmt = document.getElementById('resGmt');
                const resLocal = document.getElementById('resLocal');
                const resRelative = document.getElementById('resRelative');
                const resultDiv = document.getElementById('tsResult');

                if (!ts) return;

                // Handle both seconds and milliseconds
                let timestamp = parseFloat(ts);
                if (ts.length > 11) { // Likely milliseconds
                    timestamp = timestamp / 1000;
                }

                const date = new Date(timestamp * 1000);

                if (isNaN(date.getTime())) {
                    resGmt.innerText = "Invalid Timestamp";
                    resLocal.innerText = "Invalid Timestamp";
                    resRelative.innerText = "-";
                    resultDiv.classList.remove('hidden');
                    return;
                }

                resGmt.innerText = date.toUTCString();
                resLocal.innerText = date.toLocaleString();

                // Relative time logic
                const diff = Math.floor(Date.now() / 1000) - timestamp;
                let relText = "";
                const absDiff = Math.abs(diff);

                if (absDiff < 60) relText = absDiff + " seconds " + (diff > 0 ? "ago" : "from now");
                else if (absDiff < 3600) relText = Math.floor(absDiff / 60) + " minutes " + (diff > 0 ? "ago" : "from now");
                else if (absDiff < 86400) relText = Math.floor(absDiff / 3600) + " hours " + (diff > 0 ? "ago" : "from now");
                else if (absDiff < 2592000) relText = Math.floor(absDiff / 86400) + " days " + (diff > 0 ? "ago" : "from now");
                else relText = date.toLocaleDateString();

                resRelative.innerText = relText;

                resultDiv.classList.remove('hidden');
            }

            // Trigger on load
            window.addEventListener('load', convertTs);
            // Trigger on enter
            document.getElementById('tsInput').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') convertTs();
            });
        </script>
    @endpush
@endsection