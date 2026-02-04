@extends('layouts.app')

@section('title', __tool('base64-to-image-converter', 'meta.title'))
@section('meta_description', __tool('base64-to-image-converter', 'meta.description'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('base64-to-image-converter', 'input.title')"
            :description="__tool('base64-to-image-converter', 'input.desc')">

            <div class="space-y-6">
                <!-- Input Area -->
                <div>
                    <label for="base64Input" class="block text-sm font-bold text-gray-700 mb-2">
                        Paste your Base64 string here
                    </label>
                    <textarea id="base64Input"
                        placeholder="{!! __tool('base64-to-image-converter', 'input.placeholder') !!}"
                        class="w-full h-48 bg-gray-50 border border-gray-200 rounded-xl p-4 font-mono text-sm text-gray-700 focus:border-indigo-500 focus:ring-0 resize-none transition-all placeholder-gray-400 shadow-inner"></textarea>
                </div>

                <div class="flex justify-center">
                    <button id="convertBtn"
                        class="w-full md:w-auto px-8 py-3.5 bg-gray-900 hover:bg-black text-white font-bold rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {!! __tool('base64-to-image-converter', 'input.btn_decode') !!}
                    </button>
                </div>
            </div>

            <!-- Result Area -->
            <div id="resultArea"
                class="hidden mt-12 pt-12 border-t border-gray-100 grid md:grid-cols-2 gap-8 animate-fade-in">
                <!-- Left Column: Image Preview -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 min-h-[300px]">
                    <img id="imagePreview" class="max-h-[400px] max-w-full object-contain rounded-lg shadow-sm" src=""
                        alt="{!! __tool('base64-to-image-converter', 'result.image_alt') !!}">
                </div>

                <!-- Right Column: Actions -->
                <div class="flex flex-col justify-center space-y-6">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 bg-green-100 text-green-600 rounded-full mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                            {!! __tool('base64-to-image-converter', 'result.success') !!}</h3>
                        <p class="text-gray-500 text-sm">Your image is ready to download</p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button id="downloadBtn"
                            class="w-full px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            {!! __tool('base64-to-image-converter', 'result.btn_download') !!}
                        </button>
                        <button id="clearBtn"
                            class="w-full px-8 py-3.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-colors">
                            {!! __tool('base64-to-image-converter', 'result.btn_clear') !!}
                        </button>
                    </div>
                </div>
            </div>
        </x-tool-ui-card>

        <x-tool-content :tool="$tool" />
    </div>

    @push('scripts')
        <script>
            const base64Input = document.getElementById('base64Input');
            const convertBtn = document.getElementById('convertBtn');
            const resultArea = document.getElementById('resultArea');
            const imagePreview = document.getElementById('imagePreview');
            const downloadBtn = document.getElementById('downloadBtn');
            const clearBtn = document.getElementById('clearBtn');

            convertBtn.addEventListener('click', () => {
                const input = base64Input.value.trim();
                if (!input) { alert('{!! __tool('base64-to-image-converter', 'js.input_required') !!}'); return; }

                imagePreview.src = input;

                imagePreview.onerror = () => {
                    alert('{!! __tool('base64-to-image-converter', 'js.invalid_error') !!}');
                    resultArea.classList.add('hidden');
                };

                imagePreview.onload = () => {
                    resultArea.classList.remove('hidden');
                    resultArea.scrollIntoView({ behavior: 'smooth' });
                };
            });

            downloadBtn.addEventListener('click', () => {
                const link = document.createElement('a');
                link.href = imagePreview.src;
                // Try to guess extension from mime
                let ext = 'png';
                const match = imagePreview.src.match(/data:image\/(.*?);/);
                if (match && match[1]) ext = match[1];

                link.download = 'decoded-image.' + ext;
                link.click();
            });

            clearBtn.addEventListener('click', () => {
                base64Input.value = '';
                resultArea.classList.add('hidden');
                imagePreview.src = '';
            });
        </script>
    @endpush
@endsection