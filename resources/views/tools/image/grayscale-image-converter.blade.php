@extends('layouts.app')

@section('title', __tool('grayscale-image-converter', 'meta.title'))
@section('meta_description', __tool('grayscale-image-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{!! __tool('grayscale-image-converter', 'input.title') !!}
                </h2>
                <p class="text-gray-600">{!! __tool('grayscale-image-converter', 'input.desc') !!}</p>
            </div>

            <!-- Upload Area -->
            <div id="dropZone"
                class="border-3 border-dashed border-indigo-200 rounded-2xl p-8 hover:border-indigo-400 hover:bg-indigo-50 transition-all cursor-pointer text-center relative group">
                <input type="file" id="imageInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    accept="image/*">
                <div class="space-y-4 pointer-events-none">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">
                            {!! __tool('grayscale-image-converter', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">{!! __tool('grayscale-image-converter', 'input.drop_desc') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Left Column: Image Preview -->
                <div class="bg-gray-50 rounded-xl p-4 flex items-center justify-center border border-gray-200 relative"
                    style="min-height: 400px;">
                    <canvas id="imageCanvas" class="max-w-full rounded shadow-sm"></canvas>
                </div>

                <!-- Right Column: Actions -->
                <div class="flex flex-col justify-center space-y-6">
                    <div class="text-center text-gray-600 font-medium mb-4">
                        <p>Image converted to <span class="font-bold text-indigo-600">Grayscale</span></p>
                    </div>

                    <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 mb-4">
                        <p class="text-sm text-gray-600 mb-2 font-semibold">Comparison</p>
                        <div class="flex justify-center gap-4">
                            <button id="showOriginalBtn"
                                class="px-4 py-2 bg-white border border-gray-300 rounded text-sm hover:bg-gray-50">Show
                                Original</button>
                            <button id="showGrayscaleBtn"
                                class="px-4 py-2 bg-indigo-600 text-white rounded text-sm hover:bg-indigo-700">Show
                                Grayscale</button>
                        </div>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-gray-700 to-gray-900 hover:from-gray-800 hover:to-black text-white font-bold py-4 rounded-xl shadow-lg transform hover:scale-[1.01] transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Grayscale Image
                    </button>

                    <button id="uploadNewBtn" class="text-gray-500 hover:text-indigo-600 font-medium transition-colors">
                        Upload New Image
                    </button>
                </div>
            </div>
        </div>

        <x-tool-content :tool="$tool" />
    </div>

    @push('scripts')
        <script>
            const imageInput = document.getElementById('imageInput');
            const dropZone = document.getElementById('dropZone');
            const editorArea = document.getElementById('editorArea');
            const canvas = document.getElementById('imageCanvas');
            const ctx = canvas.getContext('2d');

            const downloadBtn = document.getElementById('downloadBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');
            const showOriginalBtn = document.getElementById('showOriginalBtn');
            const showGrayscaleBtn = document.getElementById('showGrayscaleBtn');

            let originalImg = new Image();
            let isGrayscale = true;

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('Invalid image'); return; }
                const reader = new FileReader();
                reader.onload = (e) => { originalImg.src = e.target.result; };
                reader.readAsDataURL(file);
            }

            originalImg.onload = () => {
                // Determine dimensions
                const maxWidth = editorArea.clientWidth * 0.5; // ~Half for preview
                let width = originalImg.width;
                let height = originalImg.height;

                // We actually want high res for download, but simple display for preview
                // Simple approach: set canvas to full res, scale via CSS
                canvas.width = originalImg.width;
                canvas.height = originalImg.height;

                applyGrayscale();

                dropZone.classList.add('hidden');
                editorArea.classList.remove('hidden');
            };

            function applyGrayscale() {
                ctx.drawImage(originalImg, 0, 0);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imageData.data;

                for (let i = 0; i < data.length; i += 4) {
                    const r = data[i];
                    const g = data[i + 1];
                    const b = data[i + 2];

                    // Luminance formula
                    const gray = 0.299 * r + 0.587 * g + 0.114 * b;

                    data[i] = gray;
                    data[i + 1] = gray;
                    data[i + 2] = gray;
                }

                ctx.putImageData(imageData, 0, 0);
                isGrayscale = true;
            }

            showOriginalBtn.addEventListener('click', () => {
                ctx.drawImage(originalImg, 0, 0);
                isGrayscale = false;
            });

            showGrayscaleBtn.addEventListener('click', () => {
                applyGrayscale();
            });

            downloadBtn.addEventListener('click', () => {
                if (!isGrayscale) applyGrayscale(); // Ensure grayscale before download
                const link = document.createElement('a');
                link.download = 'grayscale-image.png'; // PNG to keep quality
                link.href = canvas.toDataURL();
                link.click();
            });
        </script>
    @endpush
@endsection