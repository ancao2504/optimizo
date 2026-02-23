@extends('layouts.app')

@section('title', __tool('chmod-calculator', 'meta.title'))
@section('meta_description', __tool('chmod-calculator', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="chmod-calculator" :title="__tool('chmod-calculator', 'meta.h1')"
            :subtitle="__tool('chmod-calculator', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">{{ __tool('chmod-calculator', 'editor.title') }}
            </h2>
            <div class="flex items-center gap-4 mb-6 justify-center">
                <label class="font-semibold text-gray-700">{{ __tool('chmod-calculator', 'editor.label_octal') }}</label>
                <input id="octalInput" type="text" maxlength="3" value="755"
                    class="form-input w-24 text-center font-mono text-2xl font-bold" oninput="octalToCheckboxes()">
                <span id="symbolicDisplay"
                    class="font-mono text-lg text-gray-700 bg-gray-100 px-3 py-2 rounded-lg">-rwxr-xr-x</span>
            </div>
            <div class="overflow-x-auto mb-6">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-indigo-50">
                            <th class="p-3 text-left font-semibold text-gray-700">
                                {{ __tool('chmod-calculator', 'editor.col_type') }}</th>
                            <th class="p-3 text-center font-semibold text-indigo-600">
                                {{ __tool('chmod-calculator', 'editor.col_read') }}</th>
                            <th class="p-3 text-center font-semibold text-purple-600">
                                {{ __tool('chmod-calculator', 'editor.col_write') }}</th>
                            <th class="p-3 text-center font-semibold text-pink-600">
                                {{ __tool('chmod-calculator', 'editor.col_exec') }}</th>
                            <th class="p-3 text-center font-semibold text-gray-700">
                                {{ __tool('chmod-calculator', 'editor.col_octal') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(['owner' => '所有者', 'group' => '组', 'others' => '其他'] as $row => $label)
                            <tr class="border-t border-gray-200 hover:bg-gray-50">
                                <td class="p-3 font-semibold text-gray-800">{{ __tool("chmod-calculator", "editor.row_$row") }}
                                </td>
                                @foreach(['r', 'w', 'x'] as $perm)
                                    <td class="p-3 text-center"><input type="checkbox" id="{{ $row }}_{{ $perm }}"
                                            class="w-5 h-5 accent-indigo-600 cursor-pointer" onchange="checkboxesToOctal()" {{ $row === 'owner' || ($row === 'group' && $perm === 'r') || ($row === 'others' && $perm === 'r') ? 'checked' : '' }}></td>
                                @endforeach
                                <td class="p-3 text-center font-mono font-bold text-lg" id="{{ $row }}_val">5</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-900 rounded-xl p-4 flex items-center justify-between">
                <code id="chmodCmd" class="text-green-400 font-mono text-lg">chmod 755 filename</code>
                <button onclick="copyCmd()"
                    class="btn-secondary text-sm">{{ __tool('chmod-calculator', 'editor.btn_copy') }}</button>
            </div>
        </div>

        {{-- Why Section --}}
        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('chmod-calculator', 'content.why_title') }}</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('chmod-calculator', 'content.why_desc') }}</p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['visual' => ['border-indigo-200', 'text-indigo-600'], 'sync' => ['border-purple-200', 'text-purple-600'], 'cmd' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("chmod-calculator", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">
                            {{ __tool("chmod-calculator", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("chmod-calculator", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- How to Use --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('chmod-calculator', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('chmod-calculator', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">{{ __tool('chmod-calculator', "content.how_steps." . ($i + 1) . ".desc") }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Use Cases --}}
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('chmod-calculator', 'content.uses_title') }}</h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('chmod-calculator', 'content.uses') as $key => $use)
                    @php $c = ['web' => 'blue', 'scripts' => 'green', 'ssh' => 'purple', 'uploads' => 'orange'][$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('chmod-calculator', 'content.tips_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('chmod-calculator', 'content.tips') as $k => $tip)
                    @php $bc = ['never777' => 'green', 'least' => 'blue', 'recursive' => 'purple', 'umask' => 'orange'][$k] ?? 'green'; @endphp
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
                {{ __tool('chmod-calculator', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('chmod-calculator', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('chmod-calculator', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            const perms = ['r', 'w', 'x']; const rows = ['owner', 'group', 'others'];
            function getVal(row) { return perms.reduce((sum, p, i) => { const el = document.getElementById(row + '_' + p); return sum + (el && el.checked ? [4, 2, 1][i] : 0); }, 0); }
            function updateSymbolic() { const vals = rows.map(r => getVal(r)); const sym = vals.map(v => (v & 4 ? 'r' : '-') + (v & 2 ? 'w' : '-') + (v & 1 ? 'x' : '-')).join(''); document.getElementById('symbolicDisplay').textContent = '-' + sym; document.getElementById('chmodCmd').textContent = 'chmod ' + vals.join('') + ' filename'; rows.forEach((r, i) => document.getElementById(r + '_val').textContent = vals[i]); }
            function checkboxesToOctal() { const octal = rows.map(r => getVal(r)).join(''); document.getElementById('octalInput').value = octal; updateSymbolic(); }
            function octalToCheckboxes() { const val = document.getElementById('octalInput').value; if (val.length !== 3 || !/^[0-7]{3}$/.test(val)) return; rows.forEach((r, i) => { const n = parseInt(val[i]); perms.forEach((p, j) => document.getElementById(r + '_' + p).checked = !!(n & [4, 2, 1][j])); }); updateSymbolic(); }
            updateSymbolic();
            function copyCmd() { navigator.clipboard.writeText(document.getElementById('chmodCmd').textContent); }
        </script>
    @endpush
@endsection