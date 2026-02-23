@extends('layouts.app')

@section('title', __tool('regex-tester', 'meta.title'))
@section('meta_description', __tool('regex-tester', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="regex-tester" :title="__tool('regex-tester', 'meta.h1')"
            :subtitle="__tool('regex-tester', 'meta.subtitle')" />

        {{-- Tool Card --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __tool('regex-tester', 'editor.title') }}</h2>

            <div class="mb-4">
                <label class="form-label">{{ __tool('regex-tester', 'editor.label_regex') }}</label>
                <div class="flex gap-0">
                    <span
                        class="flex items-center px-4 bg-gray-100 border border-r-0 border-gray-300 rounded-l-xl text-gray-500 font-mono text-xl">/</span>
                    <input id="regexInput" type="text"
                        class="form-input rounded-none flex-1 font-mono border-l-0 border-r-0"
                        placeholder="{{ __tool('regex-tester', 'editor.ph_regex') }}" oninput="runRegex()">
                    <span
                        class="flex items-center px-4 bg-gray-100 border border-l-0 border-gray-300 text-gray-500 font-mono text-xl">/</span>
                    <input id="flagsInput" type="text" value="g"
                        class="form-input w-20 text-center font-mono rounded-l-none" placeholder="gim" oninput="runRegex()">
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ __tool('regex-tester', 'editor.flags_hint') }}</p>
            </div>

            <div class="mb-4">
                <label class="form-label">{{ __tool('regex-tester', 'editor.label_test') }}</label>
                <textarea id="testInput" class="form-input font-mono text-sm min-h-[160px]"
                    placeholder="{{ __tool('regex-tester', 'editor.ph_test') }}" oninput="runRegex()"></textarea>
            </div>

            <div id="statsBar" class="hidden flex gap-3 mb-4 flex-wrap">
                <span class="px-3 py-1.5 bg-green-100 text-green-800 rounded-full font-semibold text-sm"
                    id="matchCount"></span>
                <span class="px-3 py-1.5 bg-blue-100 text-blue-800 rounded-full font-semibold text-sm"
                    id="groupCount"></span>
            </div>
            <div id="highlightedOutput"
                class="hidden bg-gray-50 rounded-xl p-4 border-2 border-indigo-100 font-mono text-sm whitespace-pre-wrap mb-4 min-h-[60px] leading-relaxed">
            </div>
            <div id="matchesList" class="hidden space-y-2"></div>
            <div id="errorMsg" class="hidden bg-red-50 border-2 border-red-200 rounded-xl p-4 text-red-800 font-semibold">
            </div>
        </div>

        {{-- Why Section --}}
        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('regex-tester', 'content.why_title') }}</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('regex-tester', 'content.why_desc') }}</p>
            <div class="grid md:grid-cols-3 gap-4 mt-6">
                @foreach(['instant', 'highlight', 'groups'] as $f)
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ ['instant' => 'border-indigo-200', 'highlight' => 'border-purple-200', 'groups' => 'border-pink-200'][$f] }}">
                        <div class="text-4xl mb-3">{{ __tool("regex-tester", "content.features.$f.icon") }}</div>
                        <h3
                            class="font-bold text-lg mb-2 {{ ['instant' => 'text-indigo-600', 'highlight' => 'text-purple-600', 'groups' => 'text-pink-600'][$f] }}">
                            {{ __tool("regex-tester", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("regex-tester", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- How to Use --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">{{ __tool('regex-tester', 'content.how_title') }}
            </h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('regex-tester', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">{{ __tool('regex-tester', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Use Cases --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('regex-tester', 'content.uses_title') }}</h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('regex-tester', 'content.uses') as $key => $use)
                    @php $colors = ['validation' => 'blue', 'search' => 'green', 'security' => 'purple', 'parsing' => 'orange'];
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('regex-tester', 'content.tips_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('regex-tester', 'content.tips') as $k => $tip)
                    @php $bcolors = ['anchor' => 'green', 'groups' => 'blue', 'lookahead' => 'purple', 'flags' => 'orange'];
                    $bc = $bcolors[$k] ?? 'green'; @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-{{ $bc }}-500">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-gray-700">{{ $tip['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- FAQ --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">{{ __tool('regex-tester', 'content.faq_title') }}
            </h2>
            <div class="space-y-4">
                @foreach(__tool('regex-tester', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('regex-tester', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function runRegex() {
                const pattern = document.getElementById('regexInput').value;
                const flags = document.getElementById('flagsInput').value;
                const text = document.getElementById('testInput').value;
                const errEl = document.getElementById('errorMsg');
                const statsBar = document.getElementById('statsBar');
                const output = document.getElementById('highlightedOutput');
                const matchesList = document.getElementById('matchesList');
                if (!pattern) { [errEl, statsBar, output, matchesList].forEach(el => el.classList.add('hidden')); return; }
                try {
                    const gFlags = flags.includes('g') ? flags : flags + 'g';
                    const matches = [...text.matchAll(new RegExp(pattern, gFlags))];
                    errEl.classList.add('hidden');
                    statsBar.classList.remove('hidden'); output.classList.remove('hidden'); matchesList.classList.remove('hidden');
                    document.getElementById('matchCount').textContent = `{{ __tool("regex-tester", "js.matches") }}: ${matches.length}`;
                    document.getElementById('groupCount').textContent = `{{ __tool("regex-tester", "js.groups") }}: ${matches.length > 0 ? matches[0].length - 1 : 0}`;
                    let highlighted = text.replace(new RegExp(pattern, gFlags), m => `<mark class="bg-yellow-300 rounded px-0.5 font-semibold">${m.replace(/</g, '&lt;')}</mark>`);
                    output.innerHTML = highlighted.replace(/\n/g, '<br>') || `<span class="text-gray-400">{{ __tool("regex-tester", "js.no_match") }}</span>`;
                    matchesList.innerHTML = matches.length === 0 ? `<p class="text-gray-500 text-sm">{{ __tool("regex-tester", "js.no_match") }}</p>` : matches.map((m, i) => `<div class="bg-indigo-50 rounded-lg p-3 border border-indigo-200"><span class="text-xs font-bold text-indigo-600 uppercase">Match ${i + 1}</span><code class="block mt-1 text-gray-900 font-mono text-sm">${m[0].replace(/</g, '&lt;')}</code>${m.slice(1).map((g, gi) => `<span class="text-xs text-gray-500 mt-1 block">Group ${gi + 1}: <code class="font-mono">${(g || '―').replace(/</g, '&lt;')}</code></span>`).join('')}</div>`).join('');
                } catch (e) {
                    errEl.textContent = '{{ __tool("regex-tester", "js.invalid") }} ' + e.message;
                    errEl.classList.remove('hidden');[statsBar, output, matchesList].forEach(el => el.classList.add('hidden'));
                }
            }
        </script>
    @endpush
@endsection