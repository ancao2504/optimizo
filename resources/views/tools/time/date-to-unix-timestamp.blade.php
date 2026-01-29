@extends('layouts.app')

@section('title', __tool('date-to-unix-timestamp', 'meta.title'))
@section('meta_description', __tool('date-to-unix-timestamp', 'meta.description'))

@section('content')
    <div class="max-w-6xl mx-auto px-4">
        <x-tool-hero :tool="$tool" title="{{ __tool('date-to-unix-timestamp', 'meta.h1') }}"
            description="{{ __tool('date-to-unix-timestamp', 'meta.subtitle') }}" />

        {{-- Tool Editor --}}
        <div
            class="bg-white rounded-3xl shadow-xl border border-purple-50 p-8 md:p-12 mb-12 relative overflow-hidden group">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-purple-50 rounded-full mix-blend-multiply opacity-50 blur-3xl -mr-32 -mt-32 group-hover:scale-110 transition-transform duration-700">
            </div>

            <div class="relative z-10 max-w-3xl mx-auto">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-4 ml-1">
                            {{ __tool('date-to-unix-timestamp', 'editor.label_input') }}
                        </label>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Date Inputs --}}
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('date-to-unix-timestamp', 'editor.ph_year') }}</label>
                                        <input type="number" id="year"
                                            class="w-full text-center font-mono text-purple-700 bg-purple-50/50 border-2 border-purple-100 rounded-xl h-12 focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('date-to-unix-timestamp', 'editor.ph_month') }}</label>
                                        <input type="number" id="month" min="1" max="12"
                                            class="w-full text-center font-mono text-purple-700 bg-purple-50/50 border-2 border-purple-100 rounded-xl h-12 focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('date-to-unix-timestamp', 'editor.ph_day') }}</label>
                                        <input type="number" id="day" min="1" max="31"
                                            class="w-full text-center font-mono text-purple-700 bg-purple-50/50 border-2 border-purple-100 rounded-xl h-12 focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all">
                                    </div>
                                </div>
                            </div>

                            {{-- Time Inputs --}}
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('date-to-unix-timestamp', 'editor.ph_hour') }}</label>
                                        <input type="number" id="hour" min="0" max="23"
                                            class="w-full text-center font-mono text-purple-700 bg-purple-50/50 border-2 border-purple-100 rounded-xl h-12 focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('date-to-unix-timestamp', 'editor.ph_minute') }}</label>
                                        <input type="number" id="minute" min="0" max="59"
                                            class="w-full text-center font-mono text-purple-700 bg-purple-50/50 border-2 border-purple-100 rounded-xl h-12 focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all">
                                    </div>
                                    <div class="space-y-1">
                                        <label
                                            class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter ml-1">{{ __tool('date-to-unix-timestamp', 'editor.ph_second') }}</label>
                                        <input type="number" id="second" min="0" max="59"
                                            class="w-full text-center font-mono text-purple-700 bg-purple-50/50 border-2 border-purple-100 rounded-xl h-12 focus:ring-4 focus:ring-purple-500/20 focus:border-purple-500 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-6 ml-1">
                            <input type="checkbox" id="isGmt"
                                class="w-5 h-5 rounded border-2 border-purple-200 text-purple-600 focus:ring-purple-500/20 cursor-pointer">
                            <label for="isGmt"
                                class="text-sm font-bold text-gray-600 cursor-pointer select-none">{{ __tool('date-to-unix-timestamp', 'editor.checkbox_gmt') }}</label>
                        </div>
                    </div>

                    <button onclick="convertDate()"
                        class="w-full py-5 px-8 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-2xl font-bold text-xl shadow-xl hover:shadow-purple-500/30 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 group/btn">
                        <span>{{ __tool('date-to-unix-timestamp', 'editor.btn_convert') }}</span>
                        <svg class="w-6 h-6 group-hover/btn:translate-y-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </button>

                    <div id="dateResult" class="hidden pt-10 border-t border-gray-100 text-center animate-fade-in-up">
                        <span
                            class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-1">{{ __tool('date-to-unix-timestamp', 'editor.result_label') }}</span>
                        <div class="relative inline-block group/res">
                            <div id="resEpoch"
                                class="text-5xl md:text-6xl font-mono font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 tracking-tighter py-2 cursor-pointer select-all select-none"
                                title="Click to Copy"></div>
                            <div
                                class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] font-bold text-purple-400 opacity-0 group-hover/res:opacity-100 transition-opacity uppercase tracking-tighter">
                                Click to copy</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Info Section --}}
        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">
                    {{ __tool('date-to-unix-timestamp', 'content.what_is_title') }}
                </h2>
                <div class="prose prose-purple text-gray-600">
                    <p>{{ __tool('date-to-unix-timestamp', 'content.what_is_desc') }}</p>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col justify-center border-l-4 border-purple-500">
                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    {{ __tool('date-to-unix-timestamp', 'content.did_you_know_title') }}</h3>
                <p class="text-gray-600 leading-relaxed">
                    {{ __tool('date-to-unix-timestamp', 'content.did_you_know_desc') }}
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function convertDate() {
                const y = document.getElementById('year').value;
                const m = document.getElementById('month').value - 1; // 0-indexed
                const d = document.getElementById('day').value;
                const h = document.getElementById('hour').value || 0;
                const min = document.getElementById('minute').value || 0;
                const s = document.getElementById('second').value || 0;
                const isGmt = document.getElementById('isGmt').checked;

                if (!y || !d) return;

                let date;
                if (isGmt) {
                    date = new Date(Date.UTC(y, m, d, h, min, s));
                } else {
                    date = new Date(y, m, d, h, min, s);
                }

                if (isNaN(date.getTime())) {
                    document.getElementById('resEpoch').innerText = "Invalid Date";
                    document.getElementById('dateResult').classList.remove('hidden');
                    return;
                }

                const epoch = Math.floor(date.getTime() / 1000);
                document.getElementById('resEpoch').innerText = epoch;
                document.getElementById('dateResult').classList.remove('hidden');
            }

            // Init inputs with current date
            const now = new Date();
            document.getElementById('year').value = now.getFullYear();
            document.getElementById('month').value = now.getMonth() + 1;
            document.getElementById('day').value = now.getDate();
            document.getElementById('hour').value = now.getHours();
            document.getElementById('minute').value = now.getMinutes();
            document.getElementById('second').value = now.getSeconds();

            // Copy to clipboard
            document.getElementById('resEpoch').addEventListener('click', function () {
                const text = this.innerText;
                if (text && !isNaN(text)) {
                    navigator.clipboard.writeText(text).then(() => {
                        const originalText = text;
                        this.innerText = "COPIED!";
                        setTimeout(() => this.innerText = originalText, 1000);
                    });
                }
            });

            // Trigger on load
            window.addEventListener('load', convertDate);
        </script>
    @endpush
@endsection