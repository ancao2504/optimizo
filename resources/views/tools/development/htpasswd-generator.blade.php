@extends('layouts.app')

@section('title', __tool($slug, 'meta.title'))
@section('meta_description', __tool($slug, 'meta.description'))
@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <x-tool-hero :tool="$tool" />

        <!-- Tool UI -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <div class="grid md:grid-cols-2 gap-5 mb-6">
                <div>
                    <label for="htUsername"
                        class="form-label text-base">{{ __tool($slug, 'editor.label_username') }}</label>
                    <input type="text" id="htUsername" class="form-input"
                        placeholder="{{ __tool($slug, 'editor.ph_username') }}">
                </div>
                <div>
                    <label for="htPassword"
                        class="form-label text-base">{{ __tool($slug, 'editor.label_password') }}</label>
                    <div class="relative">
                        <input type="password" id="htPassword" class="form-input pr-12"
                            placeholder="{{ __tool($slug, 'editor.ph_password') }}">
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="htAlgorithm" class="form-label text-base">{{ __tool($slug, 'editor.label_algorithm') }}</label>
                <select id="htAlgorithm" class="form-input">
                    <option value="bcrypt">bcrypt ($2y$) — {{ __tool($slug, 'editor.algo_bcrypt') }}</option>
                    <option value="apr1">APR1 MD5 ($apr1$) — {{ __tool($slug, 'editor.algo_apr1') }}</option>
                    <option value="sha1">SHA-1 ({SHA}) — {{ __tool($slug, 'editor.algo_sha1') }}</option>
                    <option value="crypt">crypt() — {{ __tool($slug, 'editor.algo_crypt') }}</option>
                </select>
            </div>

            <button onclick="generateHtpasswd()" class="btn-primary w-full justify-center text-lg py-4 mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span>{{ __tool($slug, 'editor.btn_generate') }}</span>
            </button>

            <div id="result" class="hidden">
                <label class="form-label text-base">{{ __tool($slug, 'editor.label_result') }}</label>
                <div class="relative">
                    <input type="text" id="htOutput" readonly class="form-input font-mono text-sm bg-gray-50">
                    <button onclick="copyEntry()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                        {{ __tool($slug, 'editor.btn_copy') }}
                    </button>
                </div>

                @include('components.hero-actions')
            </div>
        </div>

        <!-- SEO Content -->
        <div
            class="bg-gradient-to-br from-indigo-50 via-blue-50 to-cyan-50 rounded-3xl p-8 md:p-12 mt-8 border-2 border-indigo-100 shadow-2xl">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl shadow-xl mb-4">
                    <svg class="w-9 h-9 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-gray-900 mb-3">{{ __tool($slug, 'content.hero_title') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ __tool($slug, 'content.hero_subtitle') }}</p>
            </div>

            <p class="text-gray-700 leading-relaxed text-lg mb-8">
                {{ __tool($slug, 'content.p1') }}
            </p>

            <h3 class="text-3xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool($slug, 'content.what_title') }}
            </h3>
            <p class="text-gray-700 leading-relaxed mb-8 text-center max-w-3xl mx-auto">
                {{ __tool($slug, 'content.what_desc') }}
            </p>

            <div class="grid md:grid-cols-2 gap-6 mb-10">
                <div class="bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
                    <h4 class="font-bold text-2xl mb-3">{{ __tool($slug, 'content.features_title') }}</h4>
                    <ul class="space-y-2 text-white/90">
                        <li>• {!! __tool($slug, 'content.features.fast') !!}</li>
                        <li>• {!! __tool($slug, 'content.features.fixed') !!}</li>
                        <li>• {!! __tool($slug, 'content.features.deterministic') !!}</li>
                        <li>• {!! __tool($slug, 'content.features.support') !!}</li>
                    </ul>
                </div>
                <div class="bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl p-6 text-white shadow-xl">
                    <h4 class="font-bold text-2xl mb-3">{{ __tool($slug, 'content.uses_title') }}</h4>
                    <ul class="space-y-2 text-white/90">
                        <li>• {!! __tool($slug, 'content.uses.verify') !!}</li>
                        <li>• {!! __tool($slug, 'content.uses.checksum') !!}</li>
                        <li>• {!! __tool($slug, 'content.uses.cache') !!}</li>
                        <li>• {!! __tool($slug, 'content.uses.integrity') !!}</li>
                    </ul>
                </div>
            </div>

            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-2 border-red-200 rounded-2xl p-8 mb-10">
                <h4 class="font-bold text-red-900 mb-3 flex items-center gap-3 text-xl">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __tool($slug, 'content.warning_title') }}
                </h4>
                <p class="text-red-800 leading-relaxed mb-3">
                    {!! __tool($slug, 'content.warning_desc') !!}
                </p>
            </div>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool($slug, 'content.compare_title') }}</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-indigo-300 transition-all shadow-lg">
                    <div class="text-3xl mb-3">🔵</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool($slug, 'content.compare.md5.title') }}</h4>
                    <p class="text-gray-600 text-sm mb-2">{{ __tool($slug, 'content.compare.md5.desc1') }}</p>
                    <p class="text-gray-600 text-sm">{{ __tool($slug, 'content.compare.md5.desc2') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-blue-300 transition-all shadow-lg">
                    <div class="text-3xl mb-3">🟢</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool($slug, 'content.compare.sha1.title') }}</h4>
                    <p class="text-gray-600 text-sm mb-2">{{ __tool($slug, 'content.compare.sha1.desc1') }}</p>
                    <p class="text-gray-600 text-sm">{{ __tool($slug, 'content.compare.sha1.desc2') }}</p>
                </div>
                <div
                    class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-cyan-300 transition-all shadow-lg">
                    <div class="text-3xl mb-3">🟡</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool($slug, 'content.compare.sha256.title') }}</h4>
                    <p class="text-gray-600 text-sm mb-2">{{ __tool($slug, 'content.compare.sha256.desc1') }}</p>
                    <p class="text-gray-600 text-sm">{{ __tool($slug, 'content.compare.sha256.desc2') }}</p>
                </div>
            </div>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool($slug, 'content.faq_title') }}</h3>
            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool($slug, 'content.faq.q1') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool($slug, 'content.faq.a1') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool($slug, 'content.faq.q2') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool($slug, 'content.faq.a2') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool($slug, 'content.faq.q3') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool($slug, 'content.faq.a3') }}</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const HTPASSWD_URL = "{{ url('/tools/htpasswd-generator') }}";
            const CSRF = "{{ csrf_token() }}";

            function togglePassword() {
                const input = document.getElementById('htPassword');
                const icon = document.getElementById('eyeIcon');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />';
                } else {
                    input.type = 'password';
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                }
            }

            async function generateHtpasswd() {
                const username = document.getElementById('htUsername').value;
                const password = document.getElementById('htPassword').value;
                const algorithm = document.getElementById('htAlgorithm').value;

                if (!username) {
                    alert("{{ __tool($slug, 'js.error_no_username') }}");
                    return;
                }
                if (!password) {
                    alert("{{ __tool($slug, 'js.error_no_password') }}");
                    return;
                }

                const btn = event.target.closest('button');
                const originalHTML = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> <span>{{ __tool($slug, 'js.btn_generating') }}</span>';

                try {
                    const response = await fetch(HTPASSWD_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ username, password, algorithm })
                    });

                    const data = await response.json();
                    document.getElementById('htOutput').value = data.entry;
                    document.getElementById('result').classList.remove('hidden');
                } catch (error) {
                    alert("{{ __tool($slug, 'js.error_failed') }}");
                }

                btn.disabled = false;
                btn.innerHTML = originalHTML;
            }

            function copyEntry() {
                const output = document.getElementById('htOutput');
                output.select();
                navigator.clipboard.writeText(output.value);

                const btn = event.target.closest('button');
                const originalText = btn.textContent;
                btn.textContent = '{{ __tool($slug, 'js.btn_copied') }}';
                setTimeout(() => btn.textContent = originalText, 2000);
            }
        </script>
    @endpush
@endsection