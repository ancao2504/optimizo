@extends('layouts.app')

@section('title', __tool('yaml-formatter', 'meta.title'))
@section('meta_description', __tool('yaml-formatter', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="yaml-formatter" :title="__tool('yaml-formatter', 'meta.h1')"
            :subtitle="__tool('yaml-formatter', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __tool('yaml-formatter', 'editor.title') }}
            </h2>
            <div class="mb-4">
                <label class="form-label">{{ __tool('yaml-formatter', 'editor.label_input') }}</label>
                <textarea id="yamlInput" class="form-input font-mono text-sm min-h-[250px]"
                    placeholder="{{ __tool('yaml-formatter', 'editor.ph_input') }}"></textarea>
            </div>
            <div class="flex gap-3 mb-4">
                <button onclick="formatYAML()" class="btn-primary flex-1 justify-center text-lg py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    {{ __tool('yaml-formatter', 'editor.btn_format') }}
                </button>
                <button onclick="validateYAML()" class="btn-secondary flex-1 justify-center text-lg py-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ __tool('yaml-formatter', 'editor.btn_validate') }}
                </button>
            </div>
            <div id="resultSection" class="hidden">
                <div class="flex items-center justify-between mb-2">
                    <label class="form-label mb-0">{{ __tool('yaml-formatter', 'editor.label_output') }}</label>
                    <button onclick="copyResult()"
                        class="btn-secondary text-sm">{{ __tool('yaml-formatter', 'editor.btn_copy') }}</button>
                </div>
                <div class="bg-gray-900 rounded-xl p-5 overflow-x-auto">
                    <pre id="yamlOutput" class="text-green-400 font-mono text-sm whitespace-pre-wrap"></pre>
                </div>
            </div>
            <div id="errorMsg"
                class="hidden bg-red-50 border-2 border-red-200 rounded-xl p-4 text-red-800 font-mono text-sm mt-3"></div>
            <div id="validMsg"
                class="hidden bg-green-50 border-2 border-green-200 rounded-xl p-4 text-green-800 font-semibold mt-3"></div>
        </div>

        {{-- Why Section --}}
        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('yaml-formatter', 'content.why_title') }}</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('yaml-formatter', 'content.why_desc') }}</p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['validate' => ['border-indigo-200', 'text-indigo-600'], 'format' => ['border-purple-200', 'text-purple-600'], 'privacy' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("yaml-formatter", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">{{ __tool("yaml-formatter", "content.features.$f.title") }}
                        </h3>
                        <p class="text-sm text-gray-600">{{ __tool("yaml-formatter", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- How to Use --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('yaml-formatter', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('yaml-formatter', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">{{ __tool('yaml-formatter', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Use Cases --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('yaml-formatter', 'content.uses_title') }}</h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('yaml-formatter', 'content.uses') as $key => $use)
                    @php $c = ['docker' => 'blue', 'k8s' => 'green', 'ci' => 'purple', 'ansible' => 'orange'][$key] ?? 'blue'; @endphp
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

        {{-- Best Practices --}}
        <div
            class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-blue-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('yaml-formatter', 'content.tips_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('yaml-formatter', 'content.tips') as $k => $tip)
                    @php $bc = ['spaces' => 'green', 'strings' => 'blue', 'anchors' => 'purple', 'comments' => 'orange'][$k] ?? 'green'; @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-{{ $bc }}-500">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-gray-700">{{ $tip['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- FAQ --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('yaml-formatter', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('yaml-formatter', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('yaml-formatter', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/js-yaml@4.1.0/dist/js-yaml.min.js"></script>
        <script>
            function formatYAML() {
                const input = document.getElementById('yamlInput').value.trim();
                const errEl = document.getElementById('errorMsg'), validEl = document.getElementById('validMsg'), resEl = document.getElementById('resultSection');
                if (!input) return;
                try { const parsed = jsyaml.load(input); const formatted = jsyaml.dump(parsed, { indent: 2, lineWidth: 120 }); document.getElementById('yamlOutput').textContent = formatted; resEl.classList.remove('hidden'); errEl.classList.add('hidden'); validEl.classList.add('hidden'); }
                catch (e) { errEl.textContent = e.message; errEl.classList.remove('hidden'); resEl.classList.add('hidden'); validEl.classList.add('hidden'); }
            }
            function validateYAML() {
                const input = document.getElementById('yamlInput').value.trim();
                const errEl = document.getElementById('errorMsg'), validEl = document.getElementById('validMsg');
                if (!input) return;
                try { jsyaml.load(input); validEl.textContent = '{{ __tool("yaml-formatter", "js.valid") }}'; validEl.classList.remove('hidden'); errEl.classList.add('hidden'); }
                catch (e) { errEl.textContent = e.message; errEl.classList.remove('hidden'); validEl.classList.add('hidden'); }
            }
            function copyResult() { navigator.clipboard.writeText(document.getElementById('yamlOutput').textContent); }
        </script>
    @endpush
@endsection