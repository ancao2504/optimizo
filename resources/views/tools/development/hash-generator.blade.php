@extends('layouts.app')

@section('title', __tool($slug, 'meta.title'))
@section('meta_description', __tool($slug, 'meta.description'))
@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <x-tool-hero :tool="$tool" />

        <!-- Tool UI -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-200 mb-8">
            <div class="mb-6">
                <label for="inputText"
                    class="form-label text-base">{{ __tool($slug, 'editor.label_input') }}</label>
                <textarea id="inputText" class="form-input min-h-[200px]"
                    placeholder="{{ __tool($slug, 'editor.ph_input') }}"></textarea>
            </div>

            <button onclick="generateHash()" class="btn-primary w-full justify-center text-lg py-4 mb-6">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <span>{{ __tool($slug, 'editor.btn_generate') }}</span>
            </button>

            <div id="result" class="hidden">
                <label class="form-label text-base">{{ __tool($slug, 'editor.label_result') }}</label>
                <div class="relative">
                    <input type="text" id="hashOutput" readonly class="form-input font-mono text-sm bg-gray-50">
                    <button onclick="copyHash()"
                        class="absolute right-2 top-1/2 -translate-y-1/2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                        {{ __tool($slug, 'editor.btn_copy') }}
                    </button>
                </div>

                @include('components.hero-actions')
            </div>
        </div>

        <!-- SEO Content -->
        <div class="bg-gradient-to-br from-indigo-50 via-blue-50 to-cyan-50 rounded-3xl p-8 md:p-12 mt-8 border-2 border-indigo-100 shadow-2xl">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl shadow-xl mb-4">
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
                {{ __tool($slug, 'content.what_title') }}</h3>
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
                <div class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-indigo-300 transition-all shadow-lg">
                    <div class="text-3xl mb-3">🔵</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool($slug, 'content.compare.md5.title') }}</h4>
                    <p class="text-gray-600 text-sm mb-2">{{ __tool($slug, 'content.compare.md5.desc1') }}</p>
                    <p class="text-gray-600 text-sm">{{ __tool($slug, 'content.compare.md5.desc2') }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-blue-300 transition-all shadow-lg">
                    <div class="text-3xl mb-3">🟢</div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ __tool($slug, 'content.compare.sha1.title') }}</h4>
                    <p class="text-gray-600 text-sm mb-2">{{ __tool($slug, 'content.compare.sha1.desc1') }}</p>
                    <p class="text-gray-600 text-sm">{{ __tool($slug, 'content.compare.sha1.desc2') }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border-2 border-gray-200 hover:border-cyan-300 transition-all shadow-lg">
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
            const HASH_URL = "{{ url('/tools/' . $slug) }}";
            const CSRF = "{{ csrf_token() }}";

            async function generateHash() {
                const text = document.getElementById('inputText').value;
                if (!text) {
                    alert("{{ __tool($slug, 'js.error_empty') }}");
                    return;
                }

                const btn = event.target.closest('button');
                const originalHTML = btn.innerHTML;
                btn.disabled = true;
                btn.innerHTML = '<svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> <span>{{ __tool($slug, 'js.btn_generating') }}</span>';

                try {
                    const response = await fetch(HASH_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CSRF,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ text: text })
                    });

                    const data = await response.json();
                    document.getElementById('hashOutput').value = data.hash;
                    document.getElementById('result').classList.remove('hidden');
                } catch (error) {
                    alert("{{ __tool($slug, 'js.error_failed') }}");
                }

                btn.disabled = false;
                btn.innerHTML = originalHTML;
            }

            function copyHash() {
                const output = document.getElementById('hashOutput');
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