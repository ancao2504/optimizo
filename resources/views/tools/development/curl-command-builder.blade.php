@extends('layouts.app')

@section('title', __tool('curl-command-builder', 'meta.title'))
@section('meta_description', __tool('curl-command-builder', 'meta.description'))
@section('content')
    <div class="max-w-6xl mx-auto">
        <x-tool-hero :tool="$tool" icon="curl-command-builder" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <!-- URL & Method -->
            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="w-full md:w-1/4">
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2">{!! __tool('curl-command-builder', 'editor.method_label') !!}</label>
                    <select id="method" onchange="updateCurl()"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all font-bold">
                        <option value="GET">GET</option>
                        <option value="POST">POST</option>
                        <option value="PUT">PUT</option>
                        <option value="DELETE">DELETE</option>
                        <option value="PATCH">PATCH</option>
                    </select>
                </div>
                <div class="w-full md:w-3/4">
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2">{!! __tool('curl-command-builder', 'editor.url_label') !!}</label>
                    <input type="text" id="url" placeholder="https://api.example.com/v1/resource" oninput="updateCurl()"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all">
                </div>
            </div>

            <!-- Parameters Type -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="switchTab('headers')" id="tab-headers"
                            class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {!! __tool('curl-command-builder', 'editor.headers_tab') !!}
                        </button>
                        <button onclick="switchTab('body')" id="tab-body"
                            class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            {!! __tool('curl-command-builder', 'editor.body_tab') !!}
                        </button>
                    </nav>
                </div>

                <!-- Headers -->
                <div id="panel-headers" class="py-4">
                    <div id="headersList" class="space-y-3">
                        <div class="flex gap-2">
                            <input type="text" placeholder="{!! __tool('curl-command-builder', 'editor.key_ph') !!}"
                                class="header-key flex-1 px-3 py-2 border rounded-lg">
                            <input type="text" placeholder="{!! __tool('curl-command-builder', 'editor.value_ph') !!}"
                                class="header-val flex-1 px-3 py-2 border rounded-lg">
                        </div>
                    </div>
                    <button onclick="addHeaderRow()"
                        class="mt-3 text-sm text-indigo-600 font-semibold flex items-center gap-1">
                        <span>{!! __tool('curl-command-builder', 'editor.add_header') !!}</span>
                    </button>
                </div>

                <!-- Body -->
                <div id="panel-body" class="py-4 hidden">
                    <label
                        class="block text-sm font-medium text-gray-700 mb-2">{!! __tool('curl-command-builder', 'editor.raw_data_label') !!}</label>
                    <textarea id="bodyContent" rows="5" oninput="updateCurl()"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 font-mono text-sm"
                        placeholder='{"key": "value"}'></textarea>
                </div>
            </div>

            <!-- Result -->
            <div class="bg-gray-900 rounded-xl p-4 md:p-6 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <label
                        class="text-xs font-bold text-gray-400 uppercase tracking-wider">{!! __tool('curl-command-builder', 'editor.generated_label') !!}</label>
                    <span class="text-xs text-green-400 font-mono">bash</span>
                </div>
                <div class="relative group">
                    <pre class="text-gray-100 font-mono text-sm overflow-x-auto whitespace-pre-wrap break-all p-2"
                        id="curlOutput">curl -X GET "https://api.example.com/v1/resource"</pre>
                </div>
            </div>

            <button onclick="copyOutput()"
                class="w-full py-4 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all font-bold shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                </svg>
                <span>{!! __tool('curl-command-builder', 'editor.btn_copy') !!}</span>
            </button>

            <div id="statusMessage" class="hidden mt-4 p-4 rounded-xl font-semibold text-center"></div>
        </div>
        <!-- SEO Content -->
        <div class="space-y-12 mt-8 font-sans">
            <!-- Intro Card -->
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-3xl p-8 md:p-12 border border-indigo-100 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-gradient-to-br from-indigo-200 to-blue-200 rounded-full opacity-20 blur-3xl"></div>
                <div class="relative z-10 text-center">
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6 tracking-tight leading-tight">
                        {{ __tool('curl-command-builder', 'content.main_title') }}
                    </h2>
                    <p class="text-xl text-gray-600 max-w-4xl mx-auto leading-relaxed">
                        {{ __tool('curl-command-builder', 'content.main_subtitle') }}
                    </p>
                    <div class="mt-8 text-gray-700 leading-relaxed text-lg">
                        {{ __tool('curl-command-builder', 'content.intro') }}
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div>
                <h3 class="text-3xl font-bold text-gray-900 mb-10 text-center">
                    {{ __tool('curl-command-builder', 'content.features_title') }}</h3>
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach (['feature1', 'feature2', 'feature3'] as $feature)
                        <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl hover:border-indigo-100 transition-all duration-300 group">
                            <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors duration-300">
                                <svg class="h-8 w-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    @if($loop->index == 0)
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                    @elseif($loop->index == 1)
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                                    @endif
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">
                                {{ __tool('curl-command-builder', "content.{$feature}_title") }}</h4>
                            <p class="text-gray-600">{{ __tool('curl-command-builder', "content.{$feature}_desc") }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- How to Guide -->
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 md:p-12">
                <h3 class="text-3xl font-bold text-gray-900 mb-8">{{ __tool('curl-command-builder', 'content.how_title') }}</h3>
                <div class="space-y-8">
                    @foreach(range(1, 4) as $step)
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg shadow-indigo-200">
                                {{ $step }}
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-2">
                                    {{ __tool('curl-command-builder', "content.step{$step}_title") }}</h4>
                                <p class="text-gray-600">{{ __tool('curl-command-builder', "content.step{$step}_desc") }}</p>
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="relative pl-5 md:pl-0">
                                <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-gray-100 hidden md:block"></div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- FAQ Section -->
            <div>
                <h3 class="text-3xl font-bold text-gray-900 mb-8 text-center">
                    {{ __tool('curl-command-builder', 'content.faq_title') }}</h3>
                <div class="grid md:grid-cols-2 gap-6">
                    @foreach(range(1, 6) as $i)
                        <div class="bg-gray-50 rounded-xl p-6 hover:bg-white hover:shadow-lg transition-all border border-gray-100 h-full">
                            <h4 class="font-bold text-gray-900 mb-3">{{ __tool('curl-command-builder', "content.faq{$i}_q") }}</h4>
                            <p class="text-gray-600 text-sm">{{ __tool('curl-command-builder', "content.faq{$i}_a") }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function switchTab(tab) {
                document.getElementById('panel-headers').classList.add('hidden');
                document.getElementById('panel-body').classList.add('hidden');
                document.getElementById('tab-headers').className = "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm";
                document.getElementById('tab-body').className = "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm";

                document.getElementById('panel-' + tab).classList.remove('hidden');
                document.getElementById('tab-' + tab).className = "border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm";
            }

            function addHeaderRow() {
                const div = document.createElement('div');
                div.className = "flex gap-2";
                div.innerHTML = '<input type="text" placeholder="{!! __tool('curl-command-builder', 'editor.key_ph') !!}" class="header-key flex-1 px-3 py-2 border rounded-lg" oninput="updateCurl()"> <input type="text" placeholder="{!! __tool('curl-command-builder', 'editor.value_ph') !!}" class="header-val flex-1 px-3 py-2 border rounded-lg" oninput="updateCurl()">';
                document.getElementById('headersList').appendChild(div);
            }

            function updateCurl() {
                const method = document.getElementById('method').value;
                let url = document.getElementById('url').value || 'https://api.example.com';

                let cmd = `curl -X ${method} "${url}"`;

                // Headers
                const keys = document.querySelectorAll('.header-key');
                const vals = document.querySelectorAll('.header-val');

                keys.forEach((k, i) => {
                    const key = k.value.trim();
                    const val = vals[i].value.trim();
                    if (key && val) {
                        cmd += ` \\\n     -H "${key}: ${val}"`;
                    }
                });

                // Body
                const body = document.getElementById('bodyContent').value;
                if (body && method !== 'GET') {
                    // Escape single quotes better for safety, but simple for now
                    cmd += ` \\\n     -d '${body.replace(/'/g, "'\\''")}'`;
                }

                document.getElementById('curlOutput').innerText = cmd;
            }

            function copyOutput() {
                const cmd = document.getElementById('curlOutput').innerText;
                navigator.clipboard.writeText(cmd).then(() => {
                    showStatus("{!! __tool('curl-command-builder', 'js.success_copy') !!}", 'success');
                });
            }

            function showStatus(message, type) {
                const status = document.getElementById('statusMessage');
                status.textContent = message;
                status.className = type === 'success'
                    ? 'mt-4 p-4 rounded-xl font-semibold bg-green-100 text-green-800 border-2 border-green-300 text-center'
                    : 'mt-4 p-4 rounded-xl font-semibold bg-red-100 text-red-800 border-2 border-red-300 text-center';
                status.classList.remove('hidden');
                setTimeout(() => status.classList.add('hidden'), 3000);
            }
        </script>
    @endpush
@endsection