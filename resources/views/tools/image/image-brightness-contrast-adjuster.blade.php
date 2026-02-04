@extends('layouts.app')

@section('title', __tool('image-brightness-contrast-adjuster', 'meta.title'))
@section('meta_description', __tool('image-brightness-contrast-adjuster', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-brightness-contrast-adjuster', 'input.title')"
            :description="__tool('image-brightness-contrast-adjuster', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*"
                :title="__tool('image-brightness-contrast-adjuster', 'input.drop_title')"
                :subtitle="__tool('image-brightness-contrast-adjuster', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Canvas -->
                <div
                    class="lg:col-span-2 bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 min-h-[400px]">
                    <canvas id="imageCanvas" class="max-w-full rounded-lg shadow-sm"></canvas>
                </div>

                <!-- Right Column: Settings -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-6 text-lg border-b border-gray-100 pb-3">
                            {!! __tool('image-brightness-contrast-adjuster', 'settings.title') !!}
                        </h3>

                        <!-- Brightness Slider -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label for="brightnessRange" class="text-sm font-bold text-gray-700">Brightness</label>
                                <span id="brightnessVal"
                                    class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">0</span>
                            </div>
                            <input type="range" id="brightnessRange" min="-100" max="100" value="0"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                        </div>

                        <!-- Contrast Slider -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-2">
                                <label for="contrastRange" class="text-sm font-bold text-gray-700">Contrast</label>
                                <span id="contrastVal"
                                    class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">0</span>
                            </div>
                            <input type="range" id="contrastRange" min="-100" max="100" value="0"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                        </div>

                        <button id="resetBtn"
                            class="w-full bg-white border border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:bg-gray-50 transition-all text-sm flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Reset Defaults
                        </button>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Image
                    </button>

                    <button id="uploadNewBtn"
                        class="text-center text-gray-500 hover:text-indigo-600 font-medium transition-colors text-sm">
                        Upload New Image
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

            const brightnessRange = document.getElementById('brightnessRange');
            const brightnessVal = document.getElementById('brightnessVal');
            const contrastRange = document.getElementById('contrastRange');
            const contrastVal = document.getElementById('contrastVal');
            const resetBtn = document.getElementById('resetBtn');
            const downloadBtn = document.getElementById('downloadBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            let originalImg = new Image();

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
                resetBtn.click();
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('Invalid image'); return; }
                const reader = new FileReader();
                reader.onload = (e) => { originalImg.src = e.target.result; };
                reader.readAsDataURL(file);
            }

            originalImg.onload = () => {
                const maxWidth = editorArea.clientWidth * 0.65;
                let width = originalImg.width;
                let height = originalImg.height;

                if (width > maxWidth) {
                    height = (maxWidth / width) * height;
                    width = maxWidth;
                }

                canvas.width = width;
                canvas.height = height;
                applyEffects();
                dropZone.classList.add('hidden');
                editorArea.classList.remove('hidden');
            };

            function updatePreview() {
                brightnessVal.textContent = brightnessRange.value;
                contrastVal.textContent = contrastRange.value;
                requestAnimationFrame(applyEffects);
            }

            brightnessRange.addEventListener('input', updatePreview);
            contrastRange.addEventListener('input', updatePreview);

            resetBtn.addEventListener('click', () => {
                brightnessRange.value = 0;
                contrastRange.value = 0;
                updatePreview();
            });

            function applyEffects() {
                ctx.drawImage(originalImg, 0, 0, canvas.width, canvas.height); // Redraw with scaling
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imageData.data;

                const brightness = parseInt(brightnessRange.value);
                const contrast = parseInt(contrastRange.value);
                const factor = (259 * (contrast + 255)) / (255 * (259 - contrast));

                for (let i = 0; i < data.length; i += 4) {
                    let r = data[i] + brightness;
                    let g = data[i + 1] + brightness;
                    let b = data[i + 2] + brightness;

                    r = factor * (r - 128) + 128;
                    g = factor * (g - 128) + 128;
                    b = factor * (b - 128) + 128;

                    data[i] = Math.min(255, Math.max(0, r));
                    data[i + 1] = Math.min(255, Math.max(0, g));
                    data[i + 2] = Math.min(255, Math.max(0, b));
                }
                ctx.putImageData(imageData, 0, 0);
            }

            downloadBtn.addEventListener('click', () => {
                const link = document.createElement('a');
                link.download = 'adjusted-image.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        </script>
    @endpush
@endsection