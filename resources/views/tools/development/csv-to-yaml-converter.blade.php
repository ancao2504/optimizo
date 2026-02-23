@extends('layouts.app')

@section('title', __tool('csv-to-yaml-converter', 'meta.title'))
@section('meta_description', __tool('csv-to-yaml-converter', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="csv-to-yaml-converter" :title="__tool('csv-to-yaml-converter', 'meta.h1')"
            :subtitle="__tool('csv-to-yaml-converter', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('csv-to-yaml-converter', 'editor.title') }}</h2>
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="form-label">{{ __tool('csv-to-yaml-converter', 'editor.label_csv') }}</label>
                    <textarea id="csvInput" class="form-input font-mono text-sm min-h-[260px]"
                        placeholder="{{ __tool('csv-to-yaml-converter', 'editor.ph_csv') }}"
                        oninput="convertToYAML()"></textarea>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="form-label mb-0">{{ __tool('csv-to-yaml-converter', 'editor.label_yaml') }}</label>
                        <button onclick="navigator.clipboard.writeText(document.getElementById('yamlOutput').textContent)"
                            class="btn-secondary text-sm">{{ __tool('csv-to-yaml-converter', 'editor.btn_copy') }}</button>
                    </div>
                    <div class="bg-gray-900 rounded-xl p-5 min-h-[260px] overflow-auto">
                        <pre id="yamlOutput" class="text-green-400 font-mono text-sm whitespace-pre-wrap"></pre>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('csv-to-yaml-converter', 'content.why_title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('csv-to-yaml-converter', 'content.why_desc') }}
            </p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['auto' => ['border-indigo-200', 'text-indigo-600'], 'header' => ['border-purple-200', 'text-purple-600'], 'instant' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("csv-to-yaml-converter", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">
                            {{ __tool("csv-to-yaml-converter", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("csv-to-yaml-converter", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('csv-to-yaml-converter', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('csv-to-yaml-converter', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">
                            {{ __tool('csv-to-yaml-converter', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('csv-to-yaml-converter', 'content.uses_title') }}
            </h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('csv-to-yaml-converter', 'content.uses') as $key => $use)
                    @php $c = ['test' => 'blue', 'config' => 'green', 'seed' => 'purple', 'api' => 'orange'][$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('csv-to-yaml-converter', 'content.tips_title') }}
            </h2>
            <div class="space-y-4">
                @foreach(__tool('csv-to-yaml-converter', 'content.tips') as $k => $tip)
                    @php $bc = ['headers' => 'green', 'quotes' => 'blue', 'encoding' => 'purple', 'validate' => 'orange'][$k] ?? 'green'; @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-{{ $bc }}-500">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-gray-700">{{ $tip['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('csv-to-yaml-converter', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('csv-to-yaml-converter', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('csv-to-yaml-converter', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function parseCSVLine(line) {
                const result = []; let cur = '', inQ = false;
                for (let i = 0; i < line.length; i++) {
                    const c = line[i];
                    if (c === '"') { if (inQ && line[i + 1] === '"') { cur += '"'; i++; } else inQ = !inQ; }
                    else if (c === ',' && !inQ) { result.push(cur.trim()); cur = ''; }
                    else cur += c;
                }
                result.push(cur.trim());
                return result;
            }
            function convertToYAML() {
                const csv = document.getElementById('csvInput').value.trim();
                if (!csv) { document.getElementById('yamlOutput').textContent = ''; return; }
                const lines = csv.split('\n').filter(l => l.trim());
                if (lines.length < 2) { document.getElementById('yamlOutput').textContent = ''; return; }
                const headers = parseCSVLine(lines[0]);
                const yaml = lines.slice(1).map(line => {
                    const vals = parseCSVLine(line);
                    const obj = headers.map((h, i) => {
                        const v = (vals[i] || '').trim();
                        const isNum = /^-?\d+(\.\d+)?$/.test(v);
                        const isBool = v === 'true' || v === 'false';
                        const val = isNum || isBool ? v : `"${v.replace(/"/g, '\\"')}"`;
                        return `  ${h}: ${val}`;
                    }).join('\n');
                    return '-\n' + obj;
                }).join('\n');
                document.getElementById('yamlOutput').textContent = yaml;
            }
        </script>
    @endpush
@endsection