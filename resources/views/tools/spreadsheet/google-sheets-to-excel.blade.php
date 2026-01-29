@extends('layouts.app')

@section('title', __tool('google-sheets-to-excel', 'meta.title'))
@section('meta_description', __tool('google-sheets-to-excel', 'meta.description'))

@section('content')
    <x-tool-hero :tool="$tool" />

    <div class="mb-16 px-4">
        <div class="bg-white rounded-3xl p-8 md:p-10 shadow-xl border border-gray-100 mb-16">
            <div class="text-center mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    {{ __tool('google-sheets-to-excel', 'form.title') }}</h2>
                <p class="text-lg text-gray-600">{{ __tool('google-sheets-to-excel', 'form.subtitle') }}</p>
            </div>

            <form id="converterForm" method="POST" enctype="multipart/form-data" class="space-y-8" onsubmit="return false;">
                @csrf
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <label
                        class="block text-gray-700 font-bold mb-2">{{ __tool('google-sheets-to-excel', 'form.url_label') }}</label>
                    <input type="text" name="url" id="urlInput" placeholder="https://docs.google.com/spreadsheets/d/..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <p class="text-sm text-gray-500 mt-2">{{ __tool('google-sheets-to-excel', 'form.url_help') }}</p>
                </div>

                <div class="text-center">
                    <button type="button" id="convertBtn"
                        class="w-full md:w-auto min-w-[300px] inline-flex items-center justify-center px-10 py-5 border border-transparent text-xl font-bold rounded-2xl shadow-xl text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-500/50 transform hover:-translate-y-1 transition-all">
                        {{ __tool('google-sheets-to-excel', 'form.button') }}
                        <svg class="ml-3 w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100 mb-12">
            <article class="prose prose-lg md:prose-xl max-w-none text-gray-600">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">
                        {{ __tool('google-sheets-to-excel', 'content.hero_title') }}</h2>
                    <p class="text-xl leading-relaxed text-gray-600">
                        {{ __tool('google-sheets-to-excel', 'content.hero_description') }}</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 mb-16 not-prose">
                    <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100 hover:shadow-lg transition-shadow">
                        <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-2xl text-gray-900 mb-3">
                            {{ __tool('google-sheets-to-excel', 'content.feature1_title') }}</h3>
                        <p class="text-base text-gray-600 leading-relaxed">
                            {{ __tool('google-sheets-to-excel', 'content.feature1_desc') }}</p>
                    </div>
                    <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100 hover:shadow-lg transition-shadow">
                        <div
                            class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M3 14h18m-9-4v8m-7-4h14M4 6h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-2xl text-gray-900 mb-3">
                            {{ __tool('google-sheets-to-excel', 'content.feature2_title') }}</h3>
                        <p class="text-base text-gray-600 leading-relaxed">
                            {{ __tool('google-sheets-to-excel', 'content.feature2_desc') }}</p>
                    </div>
                    <div class="bg-gray-50/50 p-8 rounded-3xl border border-gray-100 hover:shadow-lg transition-shadow">
                        <div class="w-14 h-14 bg-cyan-100 text-cyan-600 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-2xl text-gray-900 mb-3">
                            {{ __tool('google-sheets-to-excel', 'content.feature3_title') }}</h3>
                        <p class="text-base text-gray-600 leading-relaxed">
                            {{ __tool('google-sheets-to-excel', 'content.feature3_desc') }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-12">
                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-10">
                        {{ __tool('google-sheets-to-excel', 'faq.title') }}</h3>
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">
                                {{ __tool('google-sheets-to-excel', 'faq.q1') }}</h4>
                            <p class="text-gray-600">{{ __tool('google-sheets-to-excel', 'faq.a1') }}</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-lg mb-2">
                                {{ __tool('google-sheets-to-excel', 'faq.q2') }}</h4>
                            <p class="text-gray-600">{{ __tool('google-sheets-to-excel', 'faq.a2') }}</p>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            const urlInput = document.getElementById('urlInput');
            const convertBtn = document.getElementById('convertBtn');
            const form = document.getElementById('converterForm');

            convertBtn.addEventListener('click', async function () {
                if (!urlInput.value.trim()) {
                    showError("{{ __tool('google-sheets-to-excel', 'js.error_empty_url') }}");
                    return;
                }

                const formData = new FormData(form);
                const originalText = convertBtn.innerHTML;

                convertBtn.disabled = true;
                convertBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 inline-block" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> {{ __tool("google-sheets-to-excel", "js.converting") }}';

                try {
                    const response = await fetch('{{ route("spreadsheet.google-sheets-to-excel.convert") }}', {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });

                    if (!response.ok) throw new Error("{{ __tool('google-sheets-to-excel', 'js.error_conversion_failed') }}");

                    const blob = await response.blob();
                    const disposition = response.headers.get('Content-Disposition');
                    let filename = 'google-sheet.xlsx';
                    if (disposition) {
                        const match = disposition.match(/filename="?([^"]+)"?/);
                        if (match) filename = match[1];
                    }

                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = filename;
                    document.body.appendChild(a);
                    a.click();
                    URL.revokeObjectURL(url);
                    document.body.removeChild(a);

                    form.reset();

                    const toast = document.createElement('div');
                    toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50';
                    toast.textContent = "{{ __tool('google-sheets-to-excel', 'js.success_conversion') }}";
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 3000);
                } catch (error) {
                    showError("{{ __tool('google-sheets-to-excel', 'js.error_conversion_failed') }}: " + error.message);
                } finally {
                    convertBtn.disabled = false;
                    convertBtn.innerHTML = originalText;
                }
            });
        })();
    </script>
@endpush