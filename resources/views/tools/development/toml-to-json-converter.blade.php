@extends('layouts.app')

@section('title', __tool('toml-to-json-converter', 'meta.title'))
@section('meta_description', __tool('toml-to-json-converter', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="toml-to-json-converter" :title="__tool('toml-to-json-converter', 'meta.h1')"
            :subtitle="__tool('toml-to-json-converter', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('toml-to-json-converter', 'editor.title') }}</h2>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="form-label">{{ __tool('toml-to-json-converter', 'editor.label_toml') }}</label>
                    <textarea id="tomlInput" class="form-input font-mono text-sm min-h-[280px]"
                        placeholder="{{ __tool('toml-to-json-converter', 'editor.ph_toml') }}"
                        oninput="convertToJSON()"></textarea>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="form-label mb-0">{{ __tool('toml-to-json-converter', 'editor.label_json') }}</label>
                        <button onclick="navigator.clipboard.writeText(document.getElementById('jsonOutput').textContent)"
                            class="btn-secondary text-sm">{{ __tool('toml-to-json-converter', 'editor.btn_copy') }}</button>
                    </div>
                    <div class="bg-gray-900 rounded-xl p-5 min-h-[280px] overflow-auto">
                        <pre id="jsonOutput" class="text-green-400 font-mono text-sm whitespace-pre-wrap"></pre>
                    </div>
                </div>
            </div>
            <div id="tomlError"
                class="hidden bg-red-50 border-2 border-red-200 rounded-xl p-4 text-red-800 font-mono text-sm"></div>
        </div>

        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('toml-to-json-converter', 'content.why_title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('toml-to-json-converter', 'content.why_desc') }}
            </p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['types' => ['border-indigo-200', 'text-indigo-600'], 'tables' => ['border-purple-200', 'text-purple-600'], 'format' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("toml-to-json-converter", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">
                            {{ __tool("toml-to-json-converter", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("toml-to-json-converter", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('toml-to-json-converter', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('toml-to-json-converter', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">
                            {{ __tool('toml-to-json-converter', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('toml-to-json-converter', 'content.uses_title') }}
            </h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('toml-to-json-converter', 'content.uses') as $key => $use)
                    @php $c = ['rust' => 'blue', 'hugo' => 'green', 'api' => 'purple', 'compare' => 'orange'][$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('toml-to-json-converter', 'content.tips_title') }}
            </h2>
            <div class="space-y-4">
                @foreach(__tool('toml-to-json-converter', 'content.tips') as $k => $tip)
                    @php $bc = ['tables' => 'green', 'strings' => 'blue', 'comments' => 'purple', 'datetime' => 'orange'][$k] ?? 'green'; @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-{{ $bc }}-500">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-gray-700">{{ $tip['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('toml-to-json-converter', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('toml-to-json-converter', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('toml-to-json-converter', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/@ltd/j-toml@1.38.0/src/j-toml.js"></script>
        <script>
            function convertToJSON() {
                const toml = document.getElementById('tomlInput').value.trim();
                const errEl = document.getElementById('tomlError');
                if (!toml) { document.getElementById('jsonOutput').textContent = ''; errEl.classList.add('hidden'); return; }
                try {
                    let result;
                    if (typeof TOML !== 'undefined') { result = TOML.parse(toml); }
                    else {
                        // Fallback: basic TOML parser for simple cases
                        result = {};
                        let current = result;
                        toml.split('\n').forEach(line => {
                            line = line.replace(/#.*/, '').trim();
                            if (!line) return;
                            const tableMatch = line.match(/^\[([^\]]+)\]$/);
                            if (tableMatch) {
                                const keys = tableMatch[1].split('.');
                                current = result;
                                keys.forEach(k => { if (!current[k]) current[k] = {}; current = current[k]; });
                                return;
                            }
                            const kv = line.match(/^(\w+)\s*=\s*(.+)$/);
                            if (kv) {
                                let v = kv[2].trim();
                                if (v.startsWith('"') && v.endsWith('"')) v = v.slice(1, -1);
                                else if (v.startsWith("'") && v.endsWith("'")) v = v.slice(1, -1);
                                else if (v === 'true') v = true;
                                else if (v === 'false') v = false;
                                else if (!isNaN(v)) v = Number(v);
                                current[kv[1]] = v;
                            }
                        });
                    }
                    document.getElementById('jsonOutput').textContent = JSON.stringify(result, null, 2);
                    errEl.classList.add('hidden');
                } catch (e) { errEl.textContent = e.message; errEl.classList.remove('hidden'); document.getElementById('jsonOutput').textContent = ''; }
            }
        </script>
    @endpush
@endsection