@extends('layouts.app')

@section('title', __tool('api-request-builder', 'meta.title'))
@section('meta_description', __tool('api-request-builder', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="api-request-builder" :title="__tool('api-request-builder', 'meta.h1')"
            :subtitle="__tool('api-request-builder', 'meta.subtitle')" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('api-request-builder', 'editor.title') }}</h2>
            <div class="flex gap-3 mb-4">
                <select id="method" class="form-input w-32 font-bold text-indigo-700">
                    <option>GET</option>
                    <option>POST</option>
                    <option>PUT</option>
                    <option>PATCH</option>
                    <option>DELETE</option>
                </select>
                <input type="url" id="url" class="form-input flex-1" placeholder="https://api.example.com/users">
                <button onclick="sendRequest()"
                    class="btn-primary px-6">{{ __tool('api-request-builder', 'editor.btn_send') }}</button>
            </div>
            <div class="flex border-b border-gray-200 mb-4">
                @foreach(['headers', 'body', 'params'] as $tab)
                    <button onclick="switchTab('{{ $tab }}')" id="tab_{{ $tab }}"
                        class="px-4 py-2 text-sm font-semibold border-b-2 border-transparent text-gray-600 hover:text-indigo-600 {{ $tab === 'headers' ? 'active-tab border-indigo-600 text-indigo-700' : '' }}">{{ __tool('api-request-builder', "editor.tab_$tab") }}</button>
                @endforeach
            </div>
            <div id="tab_headers_content">
                <div id="headersRows" class="space-y-2 mb-3"></div>
                <button onclick="addRow('headers')" class="btn-secondary text-sm">+
                    {{ __tool('api-request-builder', 'editor.btn_add_header') }}</button>
            </div>
            <div id="tab_body_content" class="hidden">
                <textarea id="requestBody" class="form-input font-mono text-sm min-h-[120px]"
                    placeholder='{"key": "value"}'></textarea>
            </div>
            <div id="tab_params_content" class="hidden">
                <div id="paramsRows" class="space-y-2 mb-3"></div>
                <button onclick="addRow('params')" class="btn-secondary text-sm">+
                    {{ __tool('api-request-builder', 'editor.btn_add_param') }}</button>
            </div>
            <div id="responseSection" class="hidden mt-5">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <label class="form-label mb-0">{{ __tool('api-request-builder', 'editor.label_response') }}</label>
                        <span id="statusBadge" class="px-3 py-1 rounded-full text-sm font-bold"></span>
                        <span id="timeBadge" class="text-xs text-gray-500"></span>
                    </div>
                    <button onclick="navigator.clipboard.writeText(document.getElementById('responseBody').textContent)"
                        class="btn-secondary text-sm">{{ __tool('api-request-builder', 'editor.btn_copy_response') }}</button>
                </div>
                <div class="bg-gray-900 rounded-xl p-5 overflow-auto max-h-72">
                    <pre id="responseBody" class="text-green-400 font-mono text-sm whitespace-pre-wrap"></pre>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-6 md:p-8 mt-8 border-2 border-indigo-100 shadow-xl">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ __tool('api-request-builder', 'content.why_title') }}</h2>
            <p class="text-gray-700 leading-relaxed mb-6 text-lg">{{ __tool('api-request-builder', 'content.why_desc') }}
            </p>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach(['methods' => ['border-indigo-200', 'text-indigo-600'], 'response' => ['border-purple-200', 'text-purple-600'], 'setup' => ['border-pink-200', 'text-pink-600']] as $f => [$bc, $tc])
                    <div
                        class="bg-white rounded-xl p-5 shadow-lg hover:shadow-2xl transition-all duration-300 border-2 {{ $bc }}">
                        <div class="text-4xl mb-3">{{ __tool("api-request-builder", "content.features.$f.icon") }}</div>
                        <h3 class="font-bold text-lg mb-2 {{ $tc }}">
                            {{ __tool("api-request-builder", "content.features.$f.title") }}</h3>
                        <p class="text-sm text-gray-600">{{ __tool("api-request-builder", "content.features.$f.desc") }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('api-request-builder', 'content.how_title') }}</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([['bg-indigo-50', 'border-indigo-200', 'from-indigo-600 to-purple-600'], ['bg-purple-50', 'border-purple-200', 'from-purple-600 to-pink-600'], ['bg-pink-50', 'border-pink-200', 'from-pink-600 to-red-600']] as $i => $s)
                    <div class="flex flex-col items-center text-center p-5 rounded-xl {{ $s[0] }} border-2 {{ $s[1] }}">
                        <div
                            class="w-12 h-12 bg-gradient-to-br {{ $s[2] }} text-white rounded-full flex items-center justify-center font-bold text-xl shadow-lg mb-4">
                            {{ $i + 1 }}</div>
                        <h3 class="font-bold text-lg text-gray-900 mb-2">
                            {{ __tool('api-request-builder', "content.how_steps." . ($i + 1) . ".title") }}</h3>
                        <p class="text-gray-700 text-sm">{{ __tool('api-request-builder', "content.how_steps." . ($i + 1) . ".desc") }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('api-request-builder', 'content.uses_title') }}</h2>
            <div class="grid md:grid-cols-2 gap-5">
                @foreach(__tool('api-request-builder', 'content.uses') as $key => $use)
                    @php $c = ['debug' => 'blue', 'oauth' => 'green', 'explore' => 'purple', 'report' => 'orange'][$key] ?? 'blue'; @endphp
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
            <h2 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('api-request-builder', 'content.tips_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('api-request-builder', 'content.tips') as $k => $tip)
                    @php $bc = ['headers' => 'green', 'cors' => 'blue', 'auth' => 'purple', 'status' => 'orange'][$k] ?? 'green'; @endphp
                    <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-{{ $bc }}-500">
                        <h3 class="font-bold text-lg text-gray-900 mb-1">{{ $tip['title'] }}</h3>
                        <p class="text-gray-700">{{ $tip['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-xl border-2 border-gray-200 mt-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('api-request-builder', 'content.faq_title') }}</h2>
            <div class="space-y-4">
                @foreach(__tool('api-request-builder', 'content.faq') as $key => $value)
                    @if(str_starts_with($key, 'q'))
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:border-indigo-300 transition">
                            <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $value }}</h3>
                            <p class="text-gray-700">{{ __tool('api-request-builder', 'content.faq.a' . substr($key, 1)) }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function addRow(type) {
                const container = document.getElementById(type + 'Rows');
                const row = document.createElement('div');
                row.className = 'flex gap-2 items-center';
                row.innerHTML = `<input type="text" placeholder="${type === 'headers' ? 'Header Name' : 'Parameter'}" class="form-input flex-1 text-sm"><input type="text" placeholder="Value" class="form-input flex-1 text-sm"><button onclick="this.parentElement.remove()" class="text-red-400 hover:text-red-600 px-2 text-xl">&times;</button>`;
                container.appendChild(row);
            }
            function switchTab(tab) {
                ['headers', 'body', 'params'].forEach(t => {
                    document.getElementById('tab_' + t + '_content').classList.toggle('hidden', t !== tab);
                    document.getElementById('tab_' + t).classList.toggle('border-indigo-600', t === tab);
                    document.getElementById('tab_' + t).classList.toggle('text-indigo-700', t === tab);
                    document.getElementById('tab_' + t).classList.toggle('border-transparent', t !== tab);
                });
            }
            async function sendRequest() {
                const method = document.getElementById('method').value;
                let url = document.getElementById('url').value.trim();
                if (!url) return;
                const headers = {};
                document.querySelectorAll('#headersRows .flex input:first-child').forEach((k, i) => {
                    const v = document.querySelectorAll('#headersRows .flex input:nth-child(2)')[i];
                    if (k.value && v.value) headers[k.value] = v.value;
                });
                const params = {};
                document.querySelectorAll('#paramsRows .flex input:first-child').forEach((k, i) => {
                    const v = document.querySelectorAll('#paramsRows .flex input:nth-child(2)')[i];
                    if (k.value && v.value) params[k.value] = v.value;
                });
                if (Object.keys(params).length) url += '?' + new URLSearchParams(params);
                const opts = { method, headers };
                if (['POST', 'PUT', 'PATCH'].includes(method)) { const b = document.getElementById('requestBody').value.trim(); if (b) opts.body = b; }
                const t0 = Date.now();
                try {
                    const res = await fetch(url, opts);
                    const ms = Date.now() - t0;
                    const text = await res.text();
                    let body = text;
                    try { body = JSON.stringify(JSON.parse(text), null, 2); } catch (e) { }
                    const sb = document.getElementById('statusBadge');
                    sb.textContent = res.status + ' ' + res.statusText;
                    sb.className = 'px-3 py-1 rounded-full text-sm font-bold ' + (res.ok ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800');
                    document.getElementById('timeBadge').textContent = ms + 'ms';
                    document.getElementById('responseBody').textContent = body;
                    document.getElementById('responseSection').classList.remove('hidden');
                } catch (e) {
                    document.getElementById('statusBadge').textContent = 'Error';
                    document.getElementById('statusBadge').className = 'px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-800';
                    document.getElementById('responseBody').textContent = e.message;
                    document.getElementById('responseSection').classList.remove('hidden');
                }
            }
            addRow('headers');
        </script>
    @endpush
@endsection