@extends('layouts.app')

@section('title', __tool('css-grid-generator', 'meta.title'))
@section('meta_description', __tool('css-grid-generator', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="css-grid-generator" :title="__tool('css-grid-generator', 'meta.h1')"
            :subtitle="__tool('css-grid-generator', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __tool('css-grid-generator', 'editor.title') }}
            </h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">{{ __tool('css-grid-generator', 'editor.label_cols') }} <span
                                    id="colsVal">3</span></label>
                            <input type="range" id="cols" min="1" max="8" value="3" class="w-full accent-indigo-600"
                                oninput="document.getElementById('colsVal').textContent=this.value;updateGrid()">
                        </div>
                        <div>
                            <label class="form-label">{{ __tool('css-grid-generator', 'editor.label_rows') }} <span
                                    id="rowsVal">3</span></label>
                            <input type="range" id="rows" min="1" max="6" value="3" class="w-full accent-indigo-600"
                                oninput="document.getElementById('rowsVal').textContent=this.value;updateGrid()">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">{{ __tool('css-grid-generator', 'editor.label_col_template') }}</label>
                        <select id="colTemplate" class="form-input" onchange="updateGrid()">
                            <option value="repeat({n}, 1fr)">Equal (1fr each)</option>
                            <option value="200px repeat({n-1}, 1fr)">Fixed + Flex</option>
                            <option value="repeat({n}, minmax(150px, 1fr))">Responsive minmax</option>
                            <option value="auto">Auto</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">{{ __tool('css-grid-generator', 'editor.label_gap') }} <span
                                id="gapVal">16</span>px</label>
                        <input type="range" id="gap" min="0" max="48" value="16" class="w-full accent-indigo-600"
                            oninput="document.getElementById('gapVal').textContent=this.value;updateGrid()">
                    </div>
                    <div>
                        <label class="form-label">{{ __tool('css-grid-generator', 'editor.label_align') }}</label>
                        <select id="align" class="form-input" onchange="updateGrid()">
                            <option value="stretch">stretch</option>
                            <option value="start">start</option>
                            <option value="center">center</option>
                            <option value="end">end</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <p class="form-label">{{ __tool('css-grid-generator', 'editor.label_preview') }}</p>
                    <div id="gridPreview"
                        class="flex-1 min-h-[220px] bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 p-3 overflow-auto">
                    </div>
                    <div class="bg-gray-900 rounded-xl p-4"><code id="gridCSS"
                            class="text-green-400 font-mono text-xs break-all"></code></div>
                    <button onclick="copyCSS()"
                        class="btn-primary justify-center">{{ __tool('css-grid-generator', 'editor.btn_copy') }}</button>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('css-grid-generator', 'content.why_title') }}</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('css-grid-generator', 'content.why_desc') }}</p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['visual' => ['border-indigo-200', 'text-indigo-600'], 'fr' => ['border-purple-200', 'text-purple-600'], 'export' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("css-grid-generator", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">
                            {{ __tool("css-grid-generator", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("css-grid-generator", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('css-grid-generator', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('css-grid-generator', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">{{ __tool('css-grid-generator', "content.how_steps." . ($i + 1) . ".desc") }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('css-grid-generator', 'content.uses_title') }}</h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('css-grid-generator', 'content.uses') as $key => $use)
                    @php $c = ['layout' => 'blue', 'dashboard' => 'green', 'gallery' => 'purple', 'magazine' => 'orange'][$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('css-grid-generator', 'content.tips_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('css-grid-generator', 'content.tips') as $k => $tip)
                    @php $bc = ['fr' => 'green', 'minmax' => 'blue', 'named' => 'purple', 'auto' => 'orange'][$k] ?? 'green'; @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-{{ $bc }}-500">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-gray-700">{{ $tip['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('css-grid-generator', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('css-grid-generator', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('css-grid-generator', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const gridColors = ['#6366f1', '#ec4899', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#84cc16', '#f97316', '#14b8a6', '#64748b', '#e2e8f0'];
            function updateGrid() {
                const cols = parseInt(document.getElementById('cols').value);
                const rows = parseInt(document.getElementById('rows').value);
                const tmpl = document.getElementById('colTemplate').value.replace('{n}', cols).replace('{n-1}', Math.max(1, cols - 1));
                const gap = document.getElementById('gap').value;
                const al = document.getElementById('align').value;
                const p = document.getElementById('gridPreview');
                p.style.cssText = `display:grid;grid-template-columns:${tmpl};grid-template-rows:repeat(${rows}, minmax(40px,1fr));gap:${gap}px;align-items:${al};background:#f3f4f6;border-radius:12px;padding:12px;border:2px dashed #d1d5db;min-height:220px;max-height:350px;overflow:auto`;
                const total = cols * rows;
                p.innerHTML = [...Array(total)].map((_, i) => `<div style="background:${gridColors[i % gridColors.length]};border-radius:6px;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold;font-size:13px;min-height:40px;">${i + 1}</div>`).join('');
                document.getElementById('gridCSS').textContent = `.container {\n  display: grid;\n  grid-template-columns: ${tmpl};\n  grid-template-rows: repeat(${rows}, 1fr);\n  gap: ${gap}px;\n  align-items: ${al};\n}`;
            }
            function copyCSS() { navigator.clipboard.writeText(document.getElementById('gridCSS').textContent); }
            updateGrid();
        </script>
    @endpush
@endsection