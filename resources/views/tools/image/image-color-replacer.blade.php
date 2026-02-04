@extends('layouts.app')

@section('title', __tool('image-color-replacer', 'meta.title'))
@section('meta_description', __tool('image-color-replacer', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-color-replacer', 'input.title')" :description="__tool('image-color-replacer', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-color-replacer', 'input.drop_title')" :subtitle="__tool('image-color-replacer', 'input.drop_desc')" />

            <!-- Editor Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Canvas -->
                <div
                    class="lg:col-span-2 bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 relative overflow-hidden min-h-[400px]">
                    <canvas id="imageCanvas" class="max-w-full rounded-lg shadow-sm cursor-crosshair"></canvas>
                </div>

                <!-- Right Column: Controls -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 space-y-6 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-2 border-b border-gray-100 pb-3">Replacement Settings</h3>

                        <!-- From Color -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Replace Color (From)</label>
                            <div class="flex items-center gap-3">
                                <div id="fromColorPreview"
                                    class="w-12 h-12 rounded-xl shadow-sm border border-gray-200 bg-white cursor-pointer ring-2 ring-transparent transition-all hover:ring-indigo-100"
                                    title="Click image to pick or click here to open color picker"></div>
                                <input type="color" id="fromColorInput"
                                    class="h-12 flex-1 rounded-xl cursor-pointer border border-gray-200 bg-gray-50 p-1">
                            </div>
                            <p class="text-xs text-gray-500 mt-2 font-medium flex items-center gap-1">
                                <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Tip: Click on the image to pick a color
                            </p>
                        </div>

                        <!-- To Color -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">New Color (To)</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="toColorInput"
                                    class="h-12 w-full rounded-xl cursor-pointer border border-gray-200 bg-gray-50 p-1"
                                    value="#ff0000">
                            </div>
                        </div>

                        <!-- Tolerance -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-sm font-bold text-gray-700">Tolerance</label>
                                <span id="toleranceVal"
                                    class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">15%</span>
                            </div>
                            <input type="range" id="toleranceRange" min="0" max="100" value="15"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <button id="previewBtn"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-md transition-all text-sm">
                                Apply
                            </button>
                            <button id="resetBtn"
                                class="w-full bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-xl transition-all text-sm">
                                Reset
                            </button>
                        </div>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
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
            const ctx = canvas.getContext('2d', { willReadFrequently: true });

            const fromColorInput = document.getElementById('fromColorInput');
            const fromColorPreview = document.getElementById('fromColorPreview');
            const toColorInput = document.getElementById('toColorInput');
            const toleranceRange = document.getElementById('toleranceRange');
            const toleranceVal = document.getElementById('toleranceVal');

            const previewBtn = document.getElementById('previewBtn');
            const resetBtn = document.getElementById('resetBtn');
            const downloadBtn = document.getElementById('downloadBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            let originalImageData = null;
            let img = new Image();

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
                reader.onload = (e) => { img.src = e.target.result; };
                reader.readAsDataURL(file);
            }

            img.onload = () => {
                const maxWidth = editorArea.clientWidth * 0.65;
                let width = img.width;
                let height = img.height;
                if (width > maxWidth) {
                    height = (maxWidth / width) * height;
                    width = maxWidth;
                }
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);
                originalImageData = ctx.getImageData(0, 0, width, height);

                dropZone.classList.add('hidden');
                editorArea.classList.remove('hidden');
            };

            // Pick color logic
            canvas.addEventListener('click', (e) => {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const pixel = ctx.getImageData(x, y, 1, 1).data;
                const hex = rgbToHex(pixel[0], pixel[1], pixel[2]);

                fromColorInput.value = hex;
                fromColorPreview.style.backgroundColor = hex;
            });

            fromColorInput.addEventListener('input', (e) => {
                fromColorPreview.style.backgroundColor = e.target.value;
            });

            toleranceRange.addEventListener('input', (e) => {
                toleranceVal.textContent = e.target.value + '%';
            });

            resetBtn.addEventListener('click', () => {
                if (originalImageData) {
                    ctx.putImageData(originalImageData, 0, 0);
                }
            });

            previewBtn.addEventListener('click', () => {
                if (!originalImageData) return;

                const imageData = new ImageData(
                    new Uint8ClampedArray(originalImageData.data),
                    originalImageData.width,
                    originalImageData.height
                );
                const data = imageData.data;

                const targetRgb = hexToRgb(fromColorInput.value);
                const replaceRgb = hexToRgb(toColorInput.value);
                const tolerance = parseInt(toleranceRange.value);
                const toleranceSq = (tolerance * 2.55) ** 2 * 3;

                for (let i = 0; i < data.length; i += 4) {
                    const r = data[i];
                    const g = data[i + 1];
                    const b = data[i + 2];

                    const dist = (r - targetRgb.r) ** 2 + (g - targetRgb.g) ** 2 + (b - targetRgb.b) ** 2;

                    if (dist <= toleranceSq) {
                        data[i] = replaceRgb.r;
                        data[i + 1] = replaceRgb.g;
                        data[i + 2] = replaceRgb.b;
                    }
                }
                ctx.putImageData(imageData, 0, 0);
            });

            downloadBtn.addEventListener('click', () => {
                const link = document.createElement('a');
                link.download = 'color-replaced.png';
                link.href = canvas.toDataURL();
                link.click();
            });

            function rgbToHex(r, g, b) {
                return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
            }

            function hexToRgb(hex) {
                const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
                return result ? {
                    r: parseInt(result[1], 16),
                    g: parseInt(result[2], 16),
                    b: parseInt(result[3], 16)
                } : null;
            }
        </script>
    @endpush
@endsection