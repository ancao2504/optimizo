@extends('layouts.app')

@section('title', __tool('image-compressor', 'meta.title'))
@section('meta_description', __tool('image-compressor', 'meta.description'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-compressor', 'editor.title_original')"
            :description="__tool('image-compressor', 'editor.drop_subtitle')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-compressor', 'editor.drop_title')" :subtitle="__tool('image-compressor', 'editor.drop_subtitle')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Original Image -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 flex flex-col items-center">
                    <h3 class="font-bold text-gray-800 mb-4">{{ __tool('image-compressor', 'editor.title_original') }}</h3>
                    <div class="flex-grow flex items-center justify-center w-full mb-4 min-h-[200px]">
                        <img id="originalImage" class="max-w-full max-h-[300px] object-contain rounded-lg shadow-sm" src="">
                    </div>
                    <p
                        class="text-sm font-medium text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm">
                        {{ __tool('image-compressor', 'editor.label_size') }} <span id="originalSize"
                            class="text-gray-900 font-bold"></span>
                    </p>
                </div>

                <!-- Compressed Image -->
                <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100 flex flex-col items-center relative">
                    <div class="absolute top-4 right-4 bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-xs border border-green-200 shadow-sm"
                        id="savedInfo">
                        {{ __tool('image-compressor', 'editor.label_saved') }} <span id="savedSize">0%</span>
                    </div>

                    <h3 class="font-bold text-indigo-900 mb-4">{{ __tool('image-compressor', 'editor.title_compressed') }}
                    </h3>
                    <div class="flex-grow flex items-center justify-center w-full mb-4 min-h-[200px]">
                        <img id="compressedImage" class="max-w-full max-h-[300px] object-contain rounded-lg shadow-sm"
                            src="">
                    </div>

                    <p
                        class="text-sm font-medium text-indigo-500 bg-white px-3 py-1 rounded-full border border-indigo-200 mb-6 shadow-sm">
                        {{ __tool('image-compressor', 'editor.label_size') }} <span id="compressedSize"
                            class="text-indigo-900 font-bold"></span>
                    </p>

                    <!-- Quality Slider -->
                    <div class="w-full bg-white p-5 rounded-xl border border-indigo-100 mb-6 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <label
                                class="text-sm font-bold text-gray-700">{{ __tool('image-compressor', 'editor.label_quality') }}</label>
                            <span id="qualityValue"
                                class="text-indigo-600 font-bold bg-indigo-50 px-2 py-1 rounded">80%</span>
                        </div>
                        <input type="range" id="qualitySlider" min="10" max="100" value="80"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {{ __tool('image-compressor', 'editor.btn_download') }}
                    </button>
                </div>
            </div>

            <div id="resetContainer" class="hidden text-center mt-8">
                <button id="uploadNewBtn"
                    class="text-gray-500 hover:text-indigo-600 font-bold transition-colors inline-flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-gray-200 hover:border-indigo-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Compress Another Image
                </button>
            </div>
        </x-tool-ui-card>

        <x-tool-content :tool="$tool" />
    </div>

    @push('scripts')
        <script>
            const imageInput = document.getElementById('imageInput');
            const dropZone = document.getElementById('dropZone');
            const editorArea = document.getElementById('editorArea');
            const resetContainer = document.getElementById('resetContainer');

            const originalImage = document.getElementById('originalImage');
            const compressedImage = document.getElementById('compressedImage');
            const originalSize = document.getElementById('originalSize');
            const compressedSize = document.getElementById('compressedSize');
            const savedSize = document.getElementById('savedSize');

            const qualitySlider = document.getElementById('qualitySlider');
            const qualityValue = document.getElementById('qualityValue');
            const downloadBtn = document.getElementById('downloadBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            let originalFile = null;
            let compressedBlob = null;

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50');
                if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                editorArea.classList.add('hidden');
                resetContainer.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            qualitySlider.addEventListener('input', (e) => {
                qualityValue.innerText = e.target.value + '%';
                // Debounce slightly or just run
                compressImage(originalImage.src, e.target.value);
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('Invalid image'); return; }
                originalFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    originalImage.src = e.target.result;
                    originalSize.textContent = formatFileSize(file.size);

                    dropZone.classList.add('hidden');
                    editorArea.classList.remove('hidden');
                    resetContainer.classList.remove('hidden');

                    // Initial Compress
                    compressImage(e.target.result, 80);
                };
                reader.readAsDataURL(file);
            }

            function compressImage(src, quality) {
                const img = new Image();
                img.onload = function () {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);

                    canvas.toBlob((blob) => {
                        compressedBlob = blob;
                        const url = URL.createObjectURL(blob);
                        compressedImage.src = url;
                        compressedSize.textContent = formatFileSize(blob.size);

                        const savedBytes = originalFile.size - blob.size;
                        const savedPercent = ((savedBytes / originalFile.size) * 100).toFixed(1);
                        savedSize.textContent = savedPercent > 0 ? `-${savedPercent}%` : '0%';

                    }, 'image/jpeg', quality / 100);
                };
                img.src = src;
            }

            function formatFileSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / 1048576).toFixed(2) + ' MB';
            }

            downloadBtn.addEventListener('click', () => {
                if (!compressedBlob) return;
                const url = URL.createObjectURL(compressedBlob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'compressed-' + (originalFile.name || 'image.jpg');
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });
        </script>
    @endpush
@endsection