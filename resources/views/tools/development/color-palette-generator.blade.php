@extends('layouts.app')

@section('title', __tool('color-palette-generator', 'meta.title'))
@section('meta_description', __tool('color-palette-generator', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="color-palette-generator" :title="__tool('color-palette-generator', 'meta.h1')"
            :subtitle="__tool('color-palette-generator', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('color-palette-generator', 'editor.title') }}</h2>
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="form-label">{{ __tool('color-palette-generator', 'editor.label_base') }}</label>
                    <div class="flex gap-3 items-center">
                        <input type="color" id="baseColor" value="#6366f1"
                            class="w-14 h-12 rounded-lg border-2 border-gray-300 cursor-pointer"
                            oninput="generatePalette()">
                        <input type="text" id="baseHex" value="#6366f1" class="form-input flex-1 font-mono"
                            oninput="document.getElementById('baseColor').value=this.value;generatePalette()">
                    </div>
                </div>
                <div>
                    <label class="form-label">{{ __tool('color-palette-generator', 'editor.label_harmony') }}</label>
                    <select id="harmonyType" class="form-input" onchange="generatePalette()">
                        <option value="complementary">{{ __tool('color-palette-generator', 'editor.opt_complementary') }}
                        </option>
                        <option value="triadic">{{ __tool('color-palette-generator', 'editor.opt_triadic') }}</option>
                        <option value="analogous">{{ __tool('color-palette-generator', 'editor.opt_analogous') }}</option>
                        <option value="split">{{ __tool('color-palette-generator', 'editor.opt_split') }}</option>
                        <option value="tetradic">{{ __tool('color-palette-generator', 'editor.opt_tetradic') }}</option>
                        <option value="shades">{{ __tool('color-palette-generator', 'editor.opt_shades') }}</option>
                    </select>
                </div>
            </div>
            <div id="paletteGrid" class="grid grid-cols-3 md:grid-cols-6 gap-3 mb-5"></div>
            <button onclick="copyCSSVars()"
                class="btn-primary w-full justify-center">{{ __tool('color-palette-generator', 'editor.btn_copy') }}</button>
        </div>

        {{-- Why Section --}}
        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('color-palette-generator', 'content.why_title') }}
            </h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">
                {{ __tool('color-palette-generator', 'content.why_desc') }}</p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['harmony' => ['border-indigo-200', 'text-indigo-600'], 'preview' => ['border-purple-200', 'text-purple-600'], 'export' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("color-palette-generator", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">
                            {{ __tool("color-palette-generator", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("color-palette-generator", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- How to Use --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('color-palette-generator', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('color-palette-generator', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">
                            {{ __tool('color-palette-generator', "content.how_steps." . ($i + 1) . ".desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Use Cases --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('color-palette-generator', 'content.uses_title') }}
            </h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('color-palette-generator', 'content.uses') as $key => $use)
                    @php $c = ['web' => 'blue', 'brand' => 'green', 'app' => 'purple', 'data' => 'orange'][$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('color-palette-generator', 'content.tips_title') }}
            </h2>
            <div class="space-y-4">
                @foreach(__tool('color-palette-generator', 'content.tips') as $k => $tip)
                    @php $bc = ['contrast' => 'green', 'limit' => 'blue', 'psychology' => 'purple', 'dark' => 'orange'][$k] ?? 'green'; @endphp
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
                {{ __tool('color-palette-generator', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('color-palette-generator', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('color-palette-generator', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function hexToHsl(hex) { let r = parseInt(hex.slice(1, 3), 16) / 255, g = parseInt(hex.slice(3, 5), 16) / 255, b = parseInt(hex.slice(5, 7), 16) / 255; const max = Math.max(r, g, b), min = Math.min(r, g, b); let h, s, l = (max + min) / 2; if (max === min) { h = s = 0; } else { const d = max - min; s = l > 0.5 ? d / (2 - max - min) : d / (max + min); switch (max) { case r: h = ((g - b) / d + (g < b ? 6 : 0)) / 6; break; case g: h = ((b - r) / d + 2) / 6; break; case b: h = ((r - g) / d + 4) / 6; break; } } return [h * 360, s * 100, l * 100]; }
            function hslToHex(h, s, l) { h /= 360; s /= 100; l /= 100; const q = l < 0.5 ? l * (1 + s) : l + s - l * s, p = 2 * l - q; const hue2rgb = t => { if (t < 0) t += 1; if (t > 1) t -= 1; if (t < 1 / 6) return p + (q - p) * 6 * t; if (t < 1 / 2) return q; if (t < 2 / 3) return p + (q - p) * (2 / 3 - t) * 6; return p; }; const r = hue2rgb(h + 1 / 3), g = hue2rgb(h), b = hue2rgb(h - 1 / 3); return '#' + [r, g, b].map(x => Math.round(x * 255).toString(16).padStart(2, '0')).join(''); }
            function generateColors(hex, type) { const [h, s, l] = hexToHsl(hex); switch (type) { case 'complementary': return [hex, hslToHex((h + 180) % 360, s, l)]; case 'triadic': return [hex, hslToHex((h + 120) % 360, s, l), hslToHex((h + 240) % 360, s, l)]; case 'analogous': return [hslToHex((h - 30 + 360) % 360, s, l), hex, hslToHex((h + 30) % 360, s, l)]; case 'split': return [hex, hslToHex((h + 150) % 360, s, l), hslToHex((h + 210) % 360, s, l)]; case 'tetradic': return [hex, hslToHex((h + 90) % 360, s, l), hslToHex((h + 180) % 360, s, l), hslToHex((h + 270) % 360, s, l)]; case 'shades': return [20, 35, 50, 65, 75, 85].map(lightness => hslToHex(h, s, lightness)); default: return [hex]; } }
            let currentColors = [];
            function generatePalette() {
                const hex = document.getElementById('baseColor').value;
                document.getElementById('baseHex').value = hex;
                const type = document.getElementById('harmonyType').value;
                currentColors = generateColors(hex, type);
                const grid = document.getElementById('paletteGrid');
                grid.innerHTML = currentColors.map((c, i) => `<div class="cursor-pointer rounded-xl overflow-hidden shadow-md hover:shadow-xl hover:scale-105 transition-all duration-200 border-2 border-gray-200" onclick="navigator.clipboard.writeText('${c}');this.querySelector('span').textContent='✓ 已复制';setTimeout(()=>this.querySelector('span').textContent='${c}',1500)"><div style="background:${c};height:80px"></div><div class="p-2 bg-white text-center"><span class="text-xs font-mono font-semibold text-gray-700">${c}</span></div></div>`).join('');
            }
            function copyCSSVars() { const vars = currentColors.map((c, i) => `  --color-${i + 1}: ${c};`).join('\n'); navigator.clipboard.writeText(`:root {\n${vars}\n}`); }
            generatePalette();
        </script>
    @endpush
@endsection