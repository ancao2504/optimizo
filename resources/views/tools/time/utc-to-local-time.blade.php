@extends('layouts.app')

@section('title', __tool('utc-to-local-time', 'meta.title'))
@section('meta_description', __tool('utc-to-local-time', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto px-4">
        <x-tool-hero :tool="$tool" title="{{ __tool('utc-to-local-time', 'meta.h1') }}"
            description="{{ __tool('utc-to-local-time', 'meta.subtitle') }}" />

        {{-- Tool Editor --}}
        <div class="bg-white rounded-3xl shadow-xl border border-teal-50 p-8 md:p-12 mb-12 relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-teal-50 rounded-full mix-blend-multiply opacity-50 blur-3xl -mr-32 -mt-32 group-hover:scale-110 transition-transform duration-700">
            </div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-4 ml-1">
                            {{ __tool('utc-to-local-time', 'editor.label_input') }}
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Date Inputs --}}
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('utc-to-local-time', 'editor.ph_year') }}</label>
                                        <input type="number" id="year"
                                            class="w-full text-center font-mono text-teal-700 bg-teal-50/50 border-2 border-teal-100 rounded-xl h-12 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('utc-to-local-time', 'editor.ph_month') }}</label>
                                        <input type="number" id="month" min="1" max="12"
                                            class="w-full text-center font-mono text-teal-700 bg-teal-50/50 border-2 border-teal-100 rounded-xl h-12 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('utc-to-local-time', 'editor.ph_day') }}</label>
                                        <input type="number" id="day" min="1" max="31"
                                            class="w-full text-center font-mono text-teal-700 bg-teal-50/50 border-2 border-teal-100 rounded-xl h-12 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                                    </div>
                                </div>
                            </div>

                            {{-- Time Inputs --}}
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('utc-to-local-time', 'editor.ph_hour') }}</label>
                                        <input type="number" id="hour" min="0" max="23"
                                            class="w-full text-center font-mono text-teal-700 bg-teal-50/50 border-2 border-teal-100 rounded-xl h-12 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('utc-to-local-time', 'editor.ph_minute') }}</label>
                                        <input type="number" id="minute" min="0" max="59"
                                            class="w-full text-center font-mono text-teal-700 bg-teal-50/50 border-2 border-teal-100 rounded-xl h-12 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('utc-to-local-time', 'editor.ph_second') }}</label>
                                        <input type="number" id="second" min="0" max="59"
                                            class="w-full text-center font-mono text-teal-700 bg-teal-50/50 border-2 border-teal-100 rounded-xl h-12 focus:ring-4 focus:ring-teal-500/20 focus:border-teal-500 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button onclick="convertToLocal()"
                        class="w-full py-5 px-8 bg-teal-600 hover:bg-teal-700 text-white rounded-2xl font-bold text-xl shadow-xl hover:shadow-teal-500/30 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 group/btn">
                        <span>{{ __tool('utc-to-local-time', 'editor.btn_convert') }}</span>
                        <svg class="w-6 h-6 group-hover/btn:rotate-180 transition-transform duration-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>

                    <div id="localResult" class="hidden pt-10 border-t border-gray-100 space-y-4 animate-fade-in-up">
                        <div class="p-6 bg-teal-50 border border-teal-100 rounded-2xl text-center">
                            <span
                                class="text-xs font-bold text-teal-400 uppercase tracking-widest block mb-2">{{ __tool('utc-to-local-time', 'editor.result_label') }}</span>
                            <div id="resLocal" class="text-3xl font-mono font-black text-teal-900 break-all"></div>
                        </div>
                        <div class="p-6 bg-gray-50 border border-gray-100 rounded-2xl text-center">
                            <span
                                class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __tool('utc-to-local-time', 'editor.result_relative') }}</span>
                            <div id="resRelative" class="text-xl font-bold text-gray-600"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Section --}}
        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __tool('utc-to-local-time', 'content.what_is_title') }}
                </h2>
                <div class="prose prose-teal text-gray-600">
                    <p>{{ __tool('utc-to-local-time', 'content.what_is_desc') }}</p>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col justify-center border-l-4 border-teal-500">
                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __tool('utc-to-local-time', 'content.local_vs_utc_title') ?: 'Local vs UTC' }}</h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ __tool('utc-to-local-time', 'content.local_vs_utc_desc') ?: 'Local time is the time in your specific time zone, which may include adjustments for daylight saving time. UTC is the worldwide baseline that stays constant regardless of location or season.' }}
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function convertToLocal() {
                const y = document.getElementById('year').value;
                const m = document.getElementById('month').value - 1; // 0-indexed
                const d = document.getElementById('day').value;
                const h = document.getElementById('hour').value || 0;
                const min = document.getElementById('minute').value || 0;
                const s = document.getElementById('second').value || 0;

                if (!y || !d) return;

                // Create date from UTC components
                const date = new Date(Date.UTC(y, m, d, h, min, s));

                if (isNaN(date.getTime())) {
                    document.getElementById('resLocal').innerText = "Invalid Date";
                    document.getElementById('resRelative').innerText = "-";
                    document.getElementById('localResult').classList.remove('hidden');
                    return;
                }

                document.getElementById('resLocal').innerText = date.toLocaleString();

                // Relative time
                const diff = Math.floor(Date.now() / 1000) - Math.floor(date.getTime() / 1000);
                let relText = "";
                const absDiff = Math.abs(diff);
                if (absDiff < 60) relText = absDiff + " seconds " + (diff > 0 ? "ago" : "from now");
                else if (absDiff < 3600) relText = Math.floor(absDiff / 60) + " minutes " + (diff > 0 ? "ago" : "from now");
                else if (absDiff < 86400) relText = Math.floor(absDiff / 3600) + " hours " + (diff > 0 ? "ago" : "from now");
                else relText = date.toLocaleDateString();

                document.getElementById('resRelative').innerText = relText;
                document.getElementById('localResult').classList.remove('hidden');
            }

            // Init inputs with current UTC date
            const now = new Date();
            document.getElementById('year').value = now.getUTCFullYear();
            document.getElementById('month').value = now.getUTCMonth() + 1;
            document.getElementById('day').value = now.getUTCDate();
            document.getElementById('hour').value = now.getUTCHours();
            document.getElementById('minute').value = now.getUTCMinutes();
            document.getElementById('second').value = now.getUTCSeconds();

            // Trigger on load
            window.addEventListener('load', convertToLocal);
        </script>
    @endpush
@endsection