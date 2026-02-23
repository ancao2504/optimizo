@extends('layouts.app')

@section('title', __tool('svg-optimizer', 'meta.title'))
@section('meta_description', __tool('svg-optimizer', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="svg-optimizer" :title="__tool('svg-optimizer', 'meta.h1')"
            :subtitle="__tool('svg-optimizer', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __tool('svg-optimizer', 'editor.title') }}</h2>
            <div class="grid md:grid-cols-3 gap-4 mb-5 text-sm">
                @foreach(['remove_comments', 'remove_metadata', 'remove_ids', 'remove_dimensions', 'remove_doctype', 'round_numbers', 'collapse_groups', 'remove_empty_containers'] as $opt)
                    <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-gray-50">
                        <input type="checkbox" id="{{ $opt }}" class="w-4 h-4 accent-indigo-600" {{ in_array($opt, ['remove_comments', 'remove_metadata', 'remove_doctype', 'round_numbers', 'collapse_groups', 'remove_empty_containers']) ? 'checked' : '' }}>
                        <span class="text-gray-700">{{ __tool('svg-optimizer', "editor.opt_$opt") }}</span>
                    </label>
                @endforeach
            </div>
            <div class="mb-4">
                <label class="form-label">{{ __tool('svg-optimizer', 'editor.label_input') }}</label>
                <textarea id="svgInput" class="form-input font-mono text-sm min-h-[200px]"
                    placeholder="{{ __tool('svg-optimizer', 'editor.ph_input') }}"></textarea>
            </div>
            <button onclick="optimizeSVG()" class="btn-primary w-full justify-center text-lg py-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                {{ __tool('svg-optimizer', 'editor.btn_optimize') }}
            </button>
            <div id="resultSection" class="hidden mt-4">
                <div id="statsBar" class="grid grid-cols-3 gap-3 mb-4">
                    <div class="bg-gray-50 rounded-xl p-3 text-center border">
                        <p class="text-lg font-bold text-gray-700" id="origSize">-</p>
                        <p class="text-xs text-gray-500">{{ __tool('svg-optimizer', 'js.original_size') }}</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-3 text-center border border-green-200">
                        <p class="text-lg font-bold text-green-700" id="optSize">-</p>
                        <p class="text-xs text-gray-500">{{ __tool('svg-optimizer', 'js.optimized_size') }}</p>
                    </div>
                    <div class="bg-indigo-50 rounded-xl p-3 text-center border border-indigo-200">
                        <p class="text-lg font-bold text-indigo-700" id="savings">-</p>
                        <p class="text-xs text-gray-500">{{ __tool('svg-optimizer', 'js.savings') }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <label class="form-label mb-0">{{ __tool('svg-optimizer', 'editor.label_output') }}</label>
                    <button onclick="copyResult()"
                        class="btn-secondary text-sm">{{ __tool('svg-optimizer', 'editor.btn_copy') }}</button>
                </div>
                <div class="bg-gray-900 rounded-xl p-5 overflow-x-auto">
                    <pre id="svgOutput" class="text-green-400 font-mono text-sm whitespace-pre-wrap"></pre>
                </div>
            </div>
        </div>

        {{-- Why Section --}}
        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('svg-optimizer', 'content.why_title') }}</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('svg-optimizer', 'content.why_desc') }}</p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['strategies' => ['border-indigo-200', 'text-indigo-600'], 'stats' => ['border-purple-200', 'text-purple-600'], 'safe' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("svg-optimizer", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">{{ __tool("svg-optimizer", "content.features.$f.title") }}
                        </h3>
                        <p class="text-sm text-gray-600">{{ __tool("svg-optimizer", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- How to Use --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">{{ __tool('svg-optimizer', 'content.how_title') }}
            </h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('svg-optimizer', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">{{ __tool('svg-optimizer', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Use Cases --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('svg-optimizer', 'content.uses_title') }}</h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('svg-optimizer', 'content.uses') as $key => $use)
                    @php $c = ['icons' => 'blue', 'logos' => 'green', 'animation' => 'purple', 'pwa' => 'orange'][$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('svg-optimizer', 'content.tips_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('svg-optimizer', 'content.tips') as $k => $tip)
                    @php $bc = ['ids' => 'green', 'viewbox' => 'blue', 'precision' => 'purple', 'pipeline' => 'orange'][$k] ?? 'green'; @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-{{ $bc }}-500">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-gray-700">{{ $tip['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- FAQ --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">{{ __tool('svg-optimizer', 'content.faq_title') }}
            </h2>
            <div class="space-y-4">
                @foreach(__tool('svg-optimizer', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('svg-optimizer', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function optimizeSVG() {
                let svg = document.getElementById('svgInput').value.trim(); if (!svg) return;
                const orig = new Blob([svg]).size;
                const opts = { remove_comments: document.getElementById('remove_comments').checked, remove_metadata: document.getElementById('remove_metadata').checked, remove_ids: document.getElementById('remove_ids').checked, remove_dimensions: document.getElementById('remove_dimensions').checked, remove_doctype: document.getElementById('remove_doctype').checked, round_numbers: document.getElementById('round_numbers').checked, collapse_groups: document.getElementById('collapse_groups').checked, remove_empty_containers: document.getElementById('remove_empty_containers').checked };
                if (opts.remove_comments) svg = svg.replace(/<!--[\s\S]*?-->/g,'');
            if (opts.remove_doctype) svg = svg.replace(/<!DOCTYPE[^>]*>/gi, '');
                if (opts.remove_metadata) svg = svg.replace(/<metadata[\s\S]*?<\/metadata>/gi, '').replace(/<title[\s\S]*?<\/title>/gi, '').replace(/<desc[\s\S]*?<\/desc>/gi, '');
                if (opts.remove_ids) svg = svg.replace(/\s+id="[^"]*"/g, '');
                if (opts.remove_dimensions) svg = svg.replace(/\s+(width|height)="[^"]*"/g, '');
                if (opts.round_numbers) svg = svg.replace(/-?\d+\.\d+/g, m => parseFloat(parseFloat(m).toFixed(2)).toString());
                if (opts.collapse_groups) svg = svg.replace(/<g>\s*<\/g>/g, '');
                if (opts.remove_empty_containers) svg = svg.replace(/<(defs|g|symbol)[^>]*>\s*<\/\1>/g, '');
                svg = svg.replace(/\s+/g, ' ').replace(/>\s+</g, '><').trim();
                const opt = new Blob([svg]).size;
                const pct = orig > 0 ? Math.round((1 - opt / orig) * 100) : 0;
                document.getElementById('origSize').textContent = orig + ' B';
                document.getElementById('optSize').textContent = opt + ' B';
                document.getElementById('savings').textContent = pct + '%';
                document.getElementById('svgOutput').textContent = svg;
                document.getElementById('resultSection').classList.remove('hidden');
            }
            function copyResult() { navigator.clipboard.writeText(document.getElementById('svgOutput').textContent); }
        </script>
    @endpush
@endsection