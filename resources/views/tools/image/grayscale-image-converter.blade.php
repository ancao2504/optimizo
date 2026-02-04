@extends('layouts.app')

@section('title', __tool('grayscale-image-converter', 'meta.title'))
@section('meta_description', __tool('grayscale-image-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('grayscale-image-converter', 'input.title')"
            :description="__tool('grayscale-image-converter', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('grayscale-image-converter', 'input.drop_title')" :subtitle="__tool('grayscale-image-converter', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Left Column: Image Preview -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 relative min-h-[400px]">
                    <canvas id="imageCanvas" class="max-w-full max-h-[600px] rounded-lg shadow-sm"></canvas>
                </div>

                <!-- Right Column: Actions -->
                <div class="flex flex-col justify-center space-y-6">
                    <div class="text-center text-gray-600 font-medium mb-4">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 bg-green-100 text-green-600 rounded-full mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <p>Image converted to <span class="font-bold text-gray-900">Grayscale</span></p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 mb-4">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-4 text-center">Preview Mode
                        </p>
                        <div class="flex justify-center gap-4">
                            <button id="showOriginalBtn"
                                class="flex-1 px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors shadow-sm">
                                Show Original
                            </button>
                            <button id="showGrayscaleBtn"
                                class="flex-1 px-4 py-3 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-colors shadow-md">
                                Show Grayscale
                            </button>
                        </div>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Grayscale Image
                    </button>

                    <button id="uploadNewBtn"
                        class="text-gray-500 hover:text-indigo-600 font-medium transition-colors text-sm text-center">
                        Process Another Image
                    </button>
                </div>
            </div>
        </x-tool-ui-card>

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
                dropZone.classList.remove('hidden');
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('Invalid image'); return; }
                const reader = new FileReader();
                reader.onload = (e) => { originalImg.src = e.target.result; };
                reader.readAsDataURL(file);
            }

            originalImg.onload = () => {
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
                    const gray = 0.299 * r + 0.587 * g + 0.114 * b;
                    data[i] = gray;
                    data[i + 1] = gray;
                    data[i + 2] = gray;
                }
                ctx.putImageData(imageData, 0, 0);
                isGrayscale = true;

                showGrayscaleBtn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
                showGrayscaleBtn.classList.add('bg-gray-900', 'text-white');

                showOriginalBtn.classList.remove('bg-gray-900', 'text-white');
                showOriginalBtn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
            }

            showOriginalBtn.addEventListener('click', () => {
                ctx.drawImage(originalImg, 0, 0);
                isGrayscale = false;

                showOriginalBtn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
                showOriginalBtn.classList.add('bg-gray-900', 'text-white');

                showGrayscaleBtn.classList.remove('bg-gray-900', 'text-white');
                showGrayscaleBtn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
            });

            showGrayscaleBtn.addEventListener('click', () => {
                applyGrayscale();
            });

            downloadBtn.addEventListener('click', () => {
                if (!isGrayscale) applyGrayscale();
                const link = document.createElement('a');
                link.download = 'grayscale-image.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        </script>
    @endpush
@endsection