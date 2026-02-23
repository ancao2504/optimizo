@extends('layouts.app')

@section('title', __tool('html-to-jsx-converter', 'meta.title'))
@section('meta_description', __tool('html-to-jsx-converter', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="html-to-jsx-converter" :title="__tool('html-to-jsx-converter', 'meta.h1')"
            :subtitle="__tool('html-to-jsx-converter', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl shadow-2xl border border-gray-200 mb-8 overflow-hidden">
            {{-- Editor Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4 flex items-center justify-between">
                <h2 class="text-white font-bold text-xl">{{ __tool('html-to-jsx-converter', 'editor.title') }}</h2>
                <span class="bg-white/20 text-white text-xs font-bold px-3 py-1 rounded-full border border-white/30 tracking-widest">HTML → JSX</span>
            </div>
            <div class="grid md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                {{-- HTML Input Panel --}}
                <div class="flex flex-col">
                    <div class="flex items-center justify-between px-4 py-2.5 bg-gray-900 border-b border-gray-700">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500"></span><span class="w-3 h-3 rounded-full bg-yellow-500"></span><span class="w-3 h-3 rounded-full bg-green-500"></span></div>
                            <span class="text-xs font-semibold text-gray-400 ml-1">{{ __tool('html-to-jsx-converter', 'editor.label_html') }}</span>
                        </div>
                        <span class="text-xs bg-orange-500/20 text-orange-400 font-bold px-2 py-0.5 rounded border border-orange-500/30">HTML</span>
                    </div>
                    <textarea
                        id="htmlInput"
                        class="w-full font-mono text-sm p-5 bg-gray-950 text-orange-200 resize-none min-h-[320px] focus:outline-none placeholder-gray-700 leading-relaxed"
                        placeholder="{{ __tool('html-to-jsx-converter', 'editor.ph_html') }}"
                        oninput="convertToJSX()"
                        spellcheck="false"
                    ></textarea>
                </div>
                {{-- JSX Output Panel --}}
                <div class="flex flex-col">
                    <div class="flex items-center justify-between px-4 py-2.5 bg-gray-900 border-b border-gray-700">
                        <div class="flex items-center gap-2">
                            <div class="flex gap-1.5"><span class="w-3 h-3 rounded-full bg-gray-600"></span><span class="w-3 h-3 rounded-full bg-gray-600"></span><span class="w-3 h-3 rounded-full bg-gray-600"></span></div>
                            <span class="text-xs font-semibold text-gray-400 ml-1">{{ __tool('html-to-jsx-converter', 'editor.label_jsx') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-xs bg-blue-500/20 text-blue-400 font-bold px-2 py-0.5 rounded border border-blue-500/30">JSX</span>
                            <button id="copyBtn" onclick="copyJSX()" class="flex items-center gap-1.5 text-xs font-semibold bg-indigo-600 hover:bg-indigo-500 text-white px-3 py-1.5 rounded-lg transition-all duration-200 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                {{ __tool('html-to-jsx-converter', 'editor.btn_copy') }}
                            </button>
                        </div>
                    </div>
                    <div class="flex-1 min-h-[320px] bg-gray-950 p-5 overflow-auto relative">
                        <pre id="jsxOutput" class="text-green-400 font-mono text-sm whitespace-pre-wrap leading-relaxed"></pre>
                        <div id="jsxPlaceholder" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="text-center text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-3 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                <p class="text-sm opacity-40 font-mono">// JSX output appears here</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('html-to-jsx-converter', 'content.why_title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('html-to-jsx-converter', 'content.why_desc') }}
            </p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['attrs' => ['border-indigo-200', 'text-indigo-600'], 'style' => ['border-purple-200', 'text-purple-600'], 'tags' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("html-to-jsx-converter", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">
                            {{ __tool("html-to-jsx-converter", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("html-to-jsx-converter", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('html-to-jsx-converter', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('html-to-jsx-converter', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">
                            {{ __tool('html-to-jsx-converter', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('html-to-jsx-converter', 'content.uses_title') }}
            </h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('html-to-jsx-converter', 'content.uses') as $key => $use)
                    @php $c = ['migration' => 'blue', 'bootstrap' => 'green', 'email' => 'purple', 'cms' => 'orange'][$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('html-to-jsx-converter', 'content.tips_title') }}
            </h2>
            <div class="space-y-4">
                @foreach(__tool('html-to-jsx-converter', 'content.tips') as $k => $tip)
                    @php $bc = ['class' => 'green', 'for' => 'blue', 'events' => 'purple', 'comments' => 'orange'][$k] ?? 'green'; @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-{{ $bc }}-500">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-gray-700">{{ $tip['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('html-to-jsx-converter', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('html-to-jsx-converter', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('html-to-jsx-converter', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function convertToJSX() {
                let html = document.getElementById('htmlInput').value;
                const out = document.getElementById('jsxOutput');
                const ph = document.getElementById('jsxPlaceholder');
                if (!html.trim()) { out.textContent = ''; ph.style.display = 'flex'; return; }
                html = html
                    .replace(/\bclass=/g, 'className=')
                    .replace(/\bfor=/g, 'htmlFor=')
                    .replace(/\btabindex=/g, 'tabIndex=')
                    .replace(/\breadonly\b/g, 'readOnly')
                    .replace(/\bmaxlength=/gi, 'maxLength=')
                    .replace(/\bautocomplete=/gi, 'autoComplete=')
                    .replace(/\bautoplay\b/gi, 'autoPlay')
                    .replace(/\benctype=/gi, 'encType=')
                    .replace(/\bcellpadding=/gi, 'cellPadding=')
                    .replace(/\bcellspacing=/gi, 'cellSpacing=')
                    .replace(/\bcolspan=/gi, 'colSpan=')
                    .replace(/\browspan=/gi, 'rowSpan=')
                    .replace(/\bcrossorigin=/gi, 'crossOrigin=')
                    .replace(/\bframeborder=/gi, 'frameBorder=')
                    .replace(/<(br|hr|img|input|area|base|col|embed|link|meta|param|source|track|wbr)\b([^>]*?)\s*\/?>/gi, (_, tag, attrs) => `<${tag}${attrs} />`)
                    .replace(/style="([^"]*)"/g, (_, s) => {
                        const obj = s.split(';').filter(Boolean).map(p => {
                            const [k, ...v] = p.trim().split(':');
                            if (!k || !v.length) return null;
                            const prop = k.trim().replace(/-([a-z])/g, (_, c) => c.toUpperCase());
                            return `${prop}: '${v.join(':').trim()}'`;
                        }).filter(Boolean).join(', ');
                        return 'style={{' + obj + '}}';
                    })
                    .replace(/<!--([\s\S]*?)-->/g, (_, c) => `{/*${c}*/}`);
                out.textContent = html;
                ph.style.display = 'none';
            }
            function copyJSX() {
                const text = document.getElementById('jsxOutput').textContent;
                if (!text) return;
                navigator.clipboard.writeText(text).then(() => {
                    const btn = document.getElementById('copyBtn');
                    const orig = btn.innerHTML;
                    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Copied!';
                    btn.classList.replace('bg-indigo-600', 'bg-green-600');
                    setTimeout(() => { btn.innerHTML = orig; btn.classList.replace('bg-green-600', 'bg-indigo-600'); }, 2000);
                });
            }
        </script>
    @endpush
@endsection