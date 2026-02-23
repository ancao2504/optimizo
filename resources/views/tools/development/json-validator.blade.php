@extends('layouts.app')

@section('title', __tool('json-validator', 'meta.title'))
@section('meta_description', __tool('json-validator', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="json-validator" :title="__tool('json-validator', 'meta.h1')"
            :subtitle="__tool('json-validator', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __tool('json-validator', 'editor.title') }}
            </h2>
            <div class="mb-4">
                <label class="form-label">{{ __tool('json-validator', 'editor.label_input') }}</label>
                <textarea id="jsonInput" class="form-input font-mono text-sm min-h-[300px]"
                    placeholder='{{ __tool("json-validator", "editor.ph_input") }}' oninput="validateJSON()"></textarea>
            </div>
            <div id="validResult"
                class="hidden flex items-center gap-3 p-4 bg-green-50 border-2 border-green-300 rounded-xl mb-4">
                <svg class="w-8 h-8 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-bold text-green-800 text-lg">{{ __tool('json-validator', 'js.valid') }}</p>
                    <p id="validDetails" class="text-green-700 text-sm"></p>
                </div>
            </div>
            <div id="invalidResult"
                class="hidden flex items-start gap-3 p-4 bg-red-50 border-2 border-red-300 rounded-xl mb-4">
                <svg class="w-8 h-8 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-bold text-red-800 text-lg">{{ __tool('json-validator', 'js.invalid') }}</p>
                    <p id="errorDetails" class="text-red-700 text-sm font-mono mt-1"></p>
                </div>
            </div>
            <div id="statsPanel" class="hidden grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-indigo-50 rounded-xl p-3 text-center border border-indigo-200">
                    <p class="text-2xl font-bold text-indigo-700" id="statKeys">0</p>
                    <p class="text-xs text-gray-600">{{ __tool('json-validator', 'js.stat_keys') }}</p>
                </div>
                <div class="bg-purple-50 rounded-xl p-3 text-center border border-purple-200">
                    <p class="text-2xl font-bold text-purple-700" id="statDepth">0</p>
                    <p class="text-xs text-gray-600">{{ __tool('json-validator', 'js.stat_depth') }}</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-3 text-center border border-blue-200">
                    <p class="text-2xl font-bold text-blue-700" id="statSize">0</p>
                    <p class="text-xs text-gray-600">{{ __tool('json-validator', 'js.stat_size') }}</p>
                </div>
                <div class="bg-green-50 rounded-xl p-3 text-center border border-green-200">
                    <p class="text-2xl font-bold text-green-700" id="statType">-</p>
                    <p class="text-xs text-gray-600">{{ __tool('json-validator', 'js.stat_type') }}</p>
                </div>
            </div>
        </div>

        {{-- Why Section --}}
        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('json-validator', 'content.why_title') }}</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('json-validator', 'content.why_desc') }}</p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['instant' => 'border-indigo-200 text-indigo-600', 'stats' => 'border-purple-200 text-purple-600', 'privacy' => 'border-pink-200 text-pink-600'] as $f => $cls)
                    @php [$bc, $tc] = explode(' ', $cls); @endphp
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("json-validator", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">{{ __tool("json-validator", "content.features.$f.title") }}
                        </h3>
                        <p class="text-sm text-gray-600">{{ __tool("json-validator", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- How to Use --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('json-validator', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('json-validator', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">{{ __tool('json-validator', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Use Cases --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('json-validator', 'content.uses_title') }}</h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('json-validator', 'content.uses') as $key => $use)
                    @php $colors = ['api' => 'blue', 'config' => 'green', 'debug' => 'purple', 'ci' => 'orange'];
                    $c = $colors[$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('json-validator', 'content.tips_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('json-validator', 'content.tips') as $k => $tip)
                    @php $bc = ['always' => 'green', 'schema' => 'blue', 'errors' => 'purple', 'ci' => 'orange'][$k] ?? 'green'; @endphp
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
                {{ __tool('json-validator', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('json-validator', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('json-validator', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function countKeys(obj, depth = 0) { if (typeof obj !== 'object' || obj === null) return { keys: 0, depth }; let keys = 0, maxDepth = depth; for (const k in obj) { keys++; if (typeof obj[k] === 'object' && obj[k] !== null) { const r = countKeys(obj[k], depth + 1); keys += r.keys; maxDepth = Math.max(maxDepth, r.depth); } } return { keys, depth: maxDepth }; }
            function validateJSON() {
                const input = document.getElementById('jsonInput').value.trim();
                const validEl = document.getElementById('validResult'), invalidEl = document.getElementById('invalidResult'), statsEl = document.getElementById('statsPanel');
                if (!input) { [validEl, invalidEl, statsEl].forEach(el => el.classList.add('hidden')); return; }
                try {
                    const parsed = JSON.parse(input); validEl.classList.remove('hidden'); invalidEl.classList.add('hidden'); statsEl.classList.remove('hidden');
                    const { keys, depth } = countKeys(parsed);
                    document.getElementById('validDetails').textContent = '{{ __tool("json-validator", "js.valid_detail") }}';
                    document.getElementById('statKeys').textContent = keys;
                    document.getElementById('statDepth').textContent = depth;
                    document.getElementById('statSize').textContent = new Blob([input]).size + ' B';
                    document.getElementById('statType').textContent = Array.isArray(parsed) ? 'Array' : typeof parsed === 'object' ? 'Object' : typeof parsed;
                } catch (e) { validEl.classList.add('hidden'); invalidEl.classList.remove('hidden'); statsEl.classList.add('hidden'); document.getElementById('errorDetails').textContent = e.message; }
            }
        </script>
    @endpush
@endsection