@extends('layouts.app')

@section('title', __tool('javascript-obfuscator', 'meta.title'))
@section('meta_description', __tool('javascript-obfuscator', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="javascript-obfuscator" :title="__tool('javascript-obfuscator', 'meta.h1')"
            :subtitle="__tool('javascript-obfuscator', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('javascript-obfuscator', 'editor.title') }}</h2>
            <div class="mb-4">
                <label class="form-label">{{ __tool('javascript-obfuscator', 'editor.label_input') }}</label>
                <textarea id="jsInput" class="form-input font-mono text-sm min-h-[200px]"
                    placeholder="{{ __tool('javascript-obfuscator', 'editor.ph_input') }}"></textarea>
            </div>
            <div class="grid grid-cols-3 gap-3 mb-4">
                @foreach(['rename', 'strings', 'minify'] as $opt)
                    <label
                        class="flex items-center gap-2 p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-indigo-300 transition">
                        <input type="checkbox" id="{{ $opt }}Opt" class="w-4 h-4 accent-indigo-600" checked>
                        <span
                            class="text-sm font-medium text-gray-700">{{ __tool('javascript-obfuscator', "editor.opt_$opt") }}</span>
                    </label>
                @endforeach
            </div>
            <div class="bg-amber-50 border-2 border-amber-200 rounded-xl p-4 mb-4">
                <p class="text-amber-800 text-sm">{{ __tool('javascript-obfuscator', 'editor.disclaimer') }}</p>
            </div>
            <button onclick="obfuscateJS()" class="btn-primary w-full justify-center text-lg py-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                {{ __tool('javascript-obfuscator', 'editor.btn_obfuscate') }}
            </button>
            <div id="resultSection" class="hidden mt-4">
                <div class="flex items-center justify-between mb-2">
                    <label class="form-label mb-0">{{ __tool('javascript-obfuscator', 'editor.label_output') }}</label>
                    <button onclick="copyResult()"
                        class="btn-secondary text-sm">{{ __tool('javascript-obfuscator', 'editor.btn_copy') }}</button>
                </div>
                <div class="bg-gray-900 rounded-xl p-5 overflow-x-auto">
                    <pre id="jsOutput" class="text-green-400 font-mono text-sm whitespace-pre-wrap"></pre>
                </div>
            </div>
        </div>

        {{-- Shared SEO sections --}}
        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('javascript-obfuscator', 'content.why_title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('javascript-obfuscator', 'content.why_desc') }}
            </p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['rename' => ['border-indigo-200', 'text-indigo-600'], 'strings' => ['border-purple-200', 'text-purple-600'], 'minify' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("javascript-obfuscator", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">
                            {{ __tool("javascript-obfuscator", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("javascript-obfuscator", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('javascript-obfuscator', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('javascript-obfuscator', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">
                            {{ __tool('javascript-obfuscator', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('javascript-obfuscator', 'content.uses_title') }}
            </h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('javascript-obfuscator', 'content.uses') as $key => $use)
                    @php $c = ['library' => 'blue', 'game' => 'green', 'saas' => 'purple', 'competition' => 'orange'][$key] ?? 'blue'; @endphp
                    <div class="flex items-start gap-4 p-5 rounded-xl bg-{{ $c }}-50 border-2 border-{{ $c }}-200">
                        <div class="flex-shrink-0 text-3xl">{{ $use['icon'] }}</div>
                        <div>
                            <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $use['title'] }}</h3>
                            <p class="text-gray-700 text-sm">{{ $use['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div
            class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-blue-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('javascript-obfuscator', 'content.tips_title') }}
            </h2>
            <div class="space-y-4">
                @foreach(__tool('javascript-obfuscator', 'content.tips') as $k => $tip)
                    @php $bc = ['testing' => 'green', 'source' => 'blue', 'server' => 'purple', 'profiler' => 'orange'][$k] ?? 'green'; @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-{{ $bc }}-500">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-gray-700">{{ $tip['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('javascript-obfuscator', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('javascript-obfuscator', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('javascript-obfuscator', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function obfuscateJS() {
                let code = document.getElementById('jsInput').value.trim(); if (!code) return;
                const rename = document.getElementById('renameOpt').checked;
                const strings = document.getElementById('stringsOpt').checked;
                const minify = document.getElementById('minifyOpt').checked;
                if (rename) {
                    const reserved = ['function', 'var', 'let', 'const', 'return', 'if', 'else', 'for', 'while', 'do', 'switch', 'case', 'break', 'continue', 'new', 'this', 'class', 'extends', 'super', 'import', 'export', 'default', 'typeof', 'instanceof', 'in', 'of', 'true', 'false', 'null', 'undefined', 'try', 'catch', 'finally', 'throw', 'async', 'await', 'yield', 'delete', 'void', 'typeof'];
                    let counter = 0;
                    const names = {};
                    code = code.replace(/\b([a-zA-Z_$][a-zA-Z0-9_$]{2,})\b/g, (m) => {
                        if (reserved.includes(m) || m.startsWith('__')) return m;
                        if (!names[m]) names[m] = '_0x' + (counter++).toString(16).padStart(4, '0');
                        return names[m];
                    });
                }
                if (strings) {
                    code = code.replace(/(["'`])((?:(?!\1)[^\\]|\\.)*)(\1)/g, (m, q, content) => {
                        const hex = [...content].map(c => '\\x' + c.charCodeAt(0).toString(16).padStart(2, '0')).join('');
                        return '"' + hex + '"';
                    });
                }
                if (minify) {
                    code = code.replace(/\/\/[^\n]*/g, '').replace(/\/\*[\s\S]*?\*\//g, '').replace(/\s*\n\s*/g, ' ').replace(/\s{2,}/g, ' ').trim();
                }
                document.getElementById('jsOutput').textContent = code;
                document.getElementById('resultSection').classList.remove('hidden');
            }
            function copyResult() { navigator.clipboard.writeText(document.getElementById('jsOutput').textContent); }
        </script>
    @endpush
@endsection