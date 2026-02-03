@extends('layouts.app')

@section('title', __tool('image-brightness-contrast-adjuster', 'meta.title'))
@section('meta_description', __tool('image-brightness-contrast-adjuster', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    {!! __tool('image-brightness-contrast-adjuster', 'input.title') !!}</h2>
                <p class="text-gray-600">{!! __tool('image-brightness-contrast-adjuster', 'input.desc') !!}</p>
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
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">
                            {!! __tool('image-brightness-contrast-adjuster', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">
                            {!! __tool('image-brightness-contrast-adjuster', 'input.drop_desc') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Canvas -->
                <div class="lg:col-span-2 bg-gray-50 rounded-xl p-4 flex items-center justify-center border border-gray-200 relative"
                    style="min-height: 400px;">
                    <canvas id="imageCanvas" class="max-w-full rounded shadow-sm"></canvas>
                </div>

                <!-- Right Column: Settings -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                        <h3 class="font-bold text-gray-800 mb-6">
                            {!! __tool('image-brightness-contrast-adjuster', 'settings.title') !!}</h3>

                        <!-- Brightness Slider -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label for="brightnessRange" class="text-sm font-medium text-gray-700">Brightness</label>
                                <span id="brightnessVal" class="text-sm font-bold text-indigo-600">0</span>
                            </div>
                            <input type="range" id="brightnessRange" min="-100" max="100" value="0"
                                class="w-full h-2 bg-white rounded-lg appearance-none cursor-pointer border border-gray-200">
                        </div>

                        <!-- Contrast Slider -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label for="contrastRange" class="text-sm font-medium text-gray-700">Contrast</label>
                                <span id="contrastVal" class="text-sm font-bold text-indigo-600">0</span>
                            </div>
                            <input type="range" id="contrastRange" min="-100" max="100" value="0"
                                class="w-full h-2 bg-white rounded-lg appearance-none cursor-pointer border border-gray-200">
                        </div>

                        <div class="flex gap-2">
                            <button id="resetBtn"
                                class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Reset
                                Defaults</button>
                        </div>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold py-4 rounded-xl shadow-lg transform hover:scale-[1.01] transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Image
                    </button>

                    <button id="uploadNewBtn"
                        class="text-center text-gray-500 hover:text-indigo-600 font-medium transition-colors">
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

            const brightnessRange = document.getElementById('brightnessRange');
            const brightnessVal = document.getElementById('brightnessVal');
            const contrastRange = document.getElementById('contrastRange');
            const contrastVal = document.getElementById('contrastVal');
            const resetBtn = document.getElementById('resetBtn');
            const downloadBtn = document.getElementById('downloadBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            let originalImg = new Image();

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
                canvas.width = originalImg.width;
                canvas.height = originalImg.height;
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
                ctx.drawImage(originalImg, 0, 0);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imageData.data;

                const brightness = parseInt(brightnessRange.value);
                const contrast = parseInt(contrastRange.value);

                // Contrast factor
                const factor = (259 * (contrast + 255)) / (255 * (259 - contrast));

                for (let i = 0; i < data.length; i += 4) {
                    // Apply Brightness
                    let r = data[i] + brightness;
                    let g = data[i + 1] + brightness;
                    let b = data[i + 2] + brightness;

                    // Apply Contrast
                    r = factor * (r - 128) + 128;
                    g = factor * (g - 128) + 128;
                    b = factor * (b - 128) + 128;

                    // Clamp values 0-255
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