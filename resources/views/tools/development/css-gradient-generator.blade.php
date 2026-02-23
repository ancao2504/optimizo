@extends('layouts.app')

@section('title', __tool('css-gradient-generator', 'meta.title'))
@section('meta_description', __tool('css-gradient-generator', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="css-gradient-generator" :title="__tool('css-gradient-generator', 'meta.h1')"
            :subtitle="__tool('css-gradient-generator', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('css-gradient-generator', 'editor.title') }}</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div>
                        <label class="form-label">{{ __tool('css-gradient-generator', 'editor.label_type') }}</label>
                        <select id="gradType" class="form-input" onchange="updateGrad()">
                            <option value="linear">Linear</option>
                            <option value="radial">Radial</option>
                            <option value="conic">Conic</option>
                        </select>
                    </div>
                    <div id="angleGroup">
                        <label class="form-label">{{ __tool('css-gradient-generator', 'editor.label_angle') }} <span
                                id="angleVal">135</span>°</label>
                        <input type="range" id="angle" min="0" max="360" value="135" class="w-full accent-indigo-600"
                            oninput="document.getElementById('angleVal').textContent=this.value;updateGrad()">
                    </div>
                    <div>
                        <label class="form-label">{{ __tool('css-gradient-generator', 'editor.label_stops') }}</label>
                        <div id="colorStops" class="space-y-2"></div>
                        <button onclick="addStop()" class="btn-secondary mt-2 text-sm">+
                            {{ __tool('css-gradient-generator', 'editor.btn_add_stop') }}</button>
                    </div>
                </div>
                <div class="flex flex-col gap-4">
                    <div id="gradPreview" class="flex-1 rounded-2xl min-h-[200px] shadow-inner border-2 border-gray-200"
                        style="background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%)"></div>
                    <div class="bg-gray-900 rounded-xl p-4">
                        <code id="gradCSS"
                            class="text-green-400 font-mono text-sm break-all">background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);</code>
                    </div>
                    <button onclick="copyGrad()"
                        class="btn-primary justify-center">{{ __tool('css-gradient-generator', 'editor.btn_copy') }}</button>
                </div>
            </div>
        </div>

        {{-- Why Section --}}
        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('css-gradient-generator', 'content.why_title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('css-gradient-generator', 'content.why_desc') }}
            </p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['types' => ['border-indigo-200', 'text-indigo-600'], 'stops' => ['border-purple-200', 'text-purple-600'], 'preview' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("css-gradient-generator", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">
                            {{ __tool("css-gradient-generator", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("css-gradient-generator", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- How to Use --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('css-gradient-generator', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('css-gradient-generator', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">
                            {{ __tool('css-gradient-generator', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Use Cases --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('css-gradient-generator', 'content.uses_title') }}
            </h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('css-gradient-generator', 'content.uses') as $key => $use)
                    @php $c = ['bg' => 'blue', 'text' => 'green', 'border' => 'purple', 'overlay' => 'orange'][$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('css-gradient-generator', 'content.tips_title') }}
            </h2>
            <div class="space-y-4">
                @foreach(__tool('css-gradient-generator', 'content.tips') as $k => $tip)
                    @php $bc = ['angle' => 'green', 'subtle' => 'blue', 'fallback' => 'purple', 'animation' => 'orange'][$k] ?? 'green'; @endphp
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
                {{ __tool('css-gradient-generator', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('css-gradient-generator', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('css-gradient-generator', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            let stops = [{ color: '#6366f1', pos: 0 }, { color: '#ec4899', pos: 100 }];
            function renderStops() {
                const c = document.getElementById('colorStops');
                c.innerHTML = stops.map((s, i) => `<div class="flex items-center gap-3 bg-gray-50 p-2 rounded-lg border"><input type="color" value="${s.color}" class="w-10 h-10 rounded cursor-pointer border-0" oninput="stops[${i}].color=this.value;updateGrad()"><input type="range" min="0" max="100" value="${s.pos}" class="flex-1 accent-indigo-600" oninput="stops[${i}].pos=parseInt(this.value);updateGrad()"><span class="text-xs text-gray-500 w-8">${s.pos}%</span><button onclick="stops.splice(${i},1);renderStops();updateGrad()" class="text-red-400 hover:text-red-600 text-lg font-bold">×</button></div>`).join('');
            }
            function addStop() { stops.push({ color: '#a855f7', pos: 50 }); renderStops(); updateGrad(); }
            function updateGrad() {
                const type = document.getElementById('gradType').value;
                const angle = document.getElementById('angle').value;
                document.getElementById('angleGroup').style.display = type === 'radial' ? 'none' : 'block';
                const sorted = [...stops].sort((a, b) => a.pos - b.pos);
                const stopsStr = sorted.map(s => `${s.color} ${s.pos}%`).join(', ');
                let css;
                if (type === 'linear') css = `linear-gradient(${angle}deg, ${stopsStr})`;
                else if (type === 'radial') css = `radial-gradient(circle, ${stopsStr})`;
                else css = `conic-gradient(from 0deg, ${stopsStr})`;
                document.getElementById('gradPreview').style.background = css;
                const full = `background: ${css};`;
                document.getElementById('gradCSS').textContent = full;
            }
            function copyGrad() { navigator.clipboard.writeText(document.getElementById('gradCSS').textContent); }
            renderStops(); updateGrad();
        </script>
    @endpush
@endsection