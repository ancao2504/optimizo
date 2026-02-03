@extends('layouts.app')

@section('title', __tool('image-color-replacer', 'meta.title'))
@section('meta_description', __tool('image-color-replacer', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{!! __tool('image-color-replacer', 'input.title') !!}</h2>
                <p class="text-gray-600">{!! __tool('image-color-replacer', 'input.desc') !!}</p>
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
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">
                            {!! __tool('image-color-replacer', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">{!! __tool('image-color-replacer', 'input.drop_desc') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Editor Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Canvas -->
                <div class="lg:col-span-2 bg-gray-50 rounded-xl p-4 flex items-center justify-center border border-gray-200 relative overflow-hidden"
                    style="min-height: 400px;">
                    <canvas id="imageCanvas" class="max-w-full rounded shadow-sm cursor-crosshair"></canvas>
                </div>

                <!-- Right Column: Controls -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100 space-y-6">

                        <!-- From Color -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Replace Color (From)</label>
                            <div class="flex items-center gap-3">
                                <div id="fromColorPreview"
                                    class="w-10 h-10 rounded-lg shadow-sm border border-gray-300 bg-white cursor-pointer"
                                    title="Click image to pick or click here to open color picker"></div>
                                <input type="color" id="fromColorInput" class="h-10 w-full rounded cursor-pointer">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Click on the image to pick this color.</p>
                        </div>

                        <!-- To Color -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">New Color (To)</label>
                            <div class="flex items-center gap-3">
                                <input type="color" id="toColorInput" class="h-10 w-full rounded cursor-pointer"
                                    value="#ff0000">
                            </div>
                        </div>

                        <!-- Tolerance -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Tolerance (Fuzziness): <span
                                    id="toleranceVal">15</span>%</label>
                            <input type="range" id="toleranceRange" min="0" max="100" value="15"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        </div>

                        <button id="previewBtn"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-md transition-all">
                            Apply Replacement
                        </button>

                        <button id="resetBtn"
                            class="w-full bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 rounded-xl transition-all">
                            Reset Image
                        </button>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg transform hover:scale-[1.01] transition-all flex items-center justify-center gap-2">
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

            // Pick color from canvas
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
                toleranceVal.textContent = e.target.value;
            });

            resetBtn.addEventListener('click', () => {
                if (originalImageData) {
                    ctx.putImageData(originalImageData, 0, 0);
                }
            });

            previewBtn.addEventListener('click', () => {
                if (!originalImageData) return;

                // Get fresh copy of original data
                const imageData = new ImageData(
                    new Uint8ClampedArray(originalImageData.data),
                    originalImageData.width,
                    originalImageData.height
                );
                const data = imageData.data;

                const targetRgb = hexToRgb(fromColorInput.value);
                const replaceRgb = hexToRgb(toColorInput.value);
                const tolerance = parseInt(toleranceRange.value);
                const toleranceSq = (tolerance * 2.55) ** 2 * 3; // Approx Euclidean distance squared logic

                for (let i = 0; i < data.length; i += 4) {
                    const r = data[i];
                    const g = data[i + 1];
                    const b = data[i + 2];

                    // Simple Euclidean distance check
                    // dist = (r1-r2)^2 + (g1-g2)^2 + (b1-b2)^2
                    const dist = (r - targetRgb.r) ** 2 + (g - targetRgb.g) ** 2 + (b - targetRgb.b) ** 2;

                    if (dist <= toleranceSq) {
                        data[i] = replaceRgb.r;
                        data[i + 1] = replaceRgb.g;
                        data[i + 2] = replaceRgb.b;
                        // Alpha remains same
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