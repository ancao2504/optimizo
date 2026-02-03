@extends('layouts.app')

@section('title', __tool('image-sharpener', 'meta.title'))
@section('meta_description', __tool('image-sharpener', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{!! __tool('image-sharpener', 'input.title') !!}</h2>
                <p class="text-gray-600">{!! __tool('image-sharpener', 'input.desc') !!}</p>
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
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">{!! __tool('image-sharpener', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">{!! __tool('image-sharpener', 'input.drop_desc') !!}</p>
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
                        <h3 class="font-bold text-gray-800 mb-4">{!! __tool('image-sharpener', 'settings.title') !!}</h3>

                        <!-- Sharpness Strength -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label for="sharpnessRange" class="text-sm font-medium text-gray-700">Strength</label>
                                <span id="sharpnessVal" class="text-sm font-bold text-indigo-600">50%</span>
                            </div>
                            <input type="range" id="sharpnessRange" min="0" max="100" value="50"
                                class="w-full h-2 bg-white rounded-lg appearance-none cursor-pointer border border-gray-200">
                        </div>

                        <div class="flex gap-2">
                            <button id="resetBtn"
                                class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Reset</button>
                            <button id="applyBtn"
                                class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Apply</button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Note: Processing large images may take a few seconds.</p>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-teal-500 to-indigo-600 hover:from-teal-600 hover:to-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transform hover:scale-[1.01] transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Sharpened Image
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

            const sharpnessRange = document.getElementById('sharpnessRange');
            const sharpnessVal = document.getElementById('sharpnessVal');
            const applyBtn = document.getElementById('applyBtn');
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
                ctx.drawImage(originalImg, 0, 0);

                dropZone.classList.add('hidden');
                editorArea.classList.remove('hidden');
            };

            sharpnessRange.addEventListener('input', (e) => {
                sharpnessVal.textContent = e.target.value + '%';
            });

            applyBtn.addEventListener('click', () => {
                // Show loading state if needed
                setTimeout(applySharpen, 10);
            });

            resetBtn.addEventListener('click', () => {
                ctx.drawImage(originalImg, 0, 0);
                sharpnessRange.value = 50;
                sharpnessVal.textContent = '50%';
            });

            function applySharpen() {
                // Basic unsharp mask or convolution
                // Convolution approach

                // Get image data
                // To avoid cumulative precision loss, always redraw original first? 
                // IF we redraw original first, then "Apply" just applies the current setting to original.
                // This is safer.
                ctx.drawImage(originalImg, 0, 0);

                const w = canvas.width;
                const h = canvas.height;
                const imageData = ctx.getImageData(0, 0, w, h);
                const data = imageData.data;
                const mix = parseInt(sharpnessRange.value) / 100 * 2.0; // 0 to 2 conversion strength

                // Weights
                //  0 -1  0
                // -1  5 -1
                //  0 -1  0
                // Standard sharpening. We mix it with original based on strength.

                // For performance, we create a new buffer
                const output = ctx.createImageData(w, h);
                const dst = output.data;

                // Kernel: 
                // [ 0, -1,  0 ]
                // [-1,  5, -1 ]
                // [ 0, -1,  0 ]

                // Optimized loop (ignoring borders for speed)
                for (let y = 1; y < h - 1; y++) {
                    for (let x = 1; x < w - 1; x++) {
                        const i = (y * w + x) * 4;

                        // Neighbors
                        const top = i - w * 4;
                        const bottom = i + w * 4;
                        const left = i - 4;
                        const right = i + 4;

                        for (let c = 0; c < 3; c++) {
                            const val = data[i + c] * 5
                                - data[top + c]
                                - data[bottom + c]
                                - data[left + c]
                                - data[right + c];

                            // Mix original with sharpened result
                            dst[i + c] = Math.min(255, Math.max(0, data[i + c] * (1 - mix) + val * mix));
                        }
                        dst[i + 3] = 255; // Alpha
                    }
                }

                ctx.putImageData(output, 0, 0);
            }

            downloadBtn.addEventListener('click', () => {
                const link = document.createElement('a');
                link.download = 'sharpened-image.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        </script>
    @endpush
@endsection