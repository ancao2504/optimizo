@extends('layouts.app')

@section('title', __tool('image-noise-reducer', 'meta.title'))
@section('meta_description', __tool('image-noise-reducer', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{!! __tool('image-noise-reducer', 'input.title') !!}</h2>
                <p class="text-gray-600">{!! __tool('image-noise-reducer', 'input.desc') !!}</p>
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
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">{!! __tool('image-noise-reducer', 'input.drop_title') !!}
                        </p>
                        <p class="text-sm text-gray-500">{!! __tool('image-noise-reducer', 'input.drop_desc') !!}</p>
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
                        <h3 class="font-bold text-gray-800 mb-4">{!! __tool('image-noise-reducer', 'settings.title') !!}
                        </h3>

                        <!-- Smoothness Level -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label for="strengthRange" class="text-sm font-medium text-gray-700">Denoise
                                    Strength</label>
                                <span id="strengthVal" class="text-sm font-bold text-indigo-600">Medium</span>
                            </div>
                            <input type="range" id="strengthRange" min="1" max="5" value="1" step="1"
                                class="w-full h-2 bg-white rounded-lg appearance-none cursor-pointer border border-gray-200">
                            <p class="text-xs text-gray-500 mt-2">Higher strength might blur details. "1" is a standard
                                Median filter.</p>
                        </div>

                        <div class="flex gap-2">
                            <button id="resetBtn"
                                class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Reset</button>
                            <button id="applyBtn"
                                class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Apply</button>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Note: Processing large images may take time.</p>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transform hover:scale-[1.01] transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Denoised Image
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

            const strengthRange = document.getElementById('strengthRange');
            const strengthVal = document.getElementById('strengthVal');
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

            const levels = { 1: 'Low (Median)', 2: 'Medium', 3: 'High', 4: 'Very High', 5: 'Max' };
            strengthRange.addEventListener('input', (e) => {
                strengthVal.textContent = levels[e.target.value] || e.target.value;
            });

            applyBtn.addEventListener('click', () => {
                setTimeout(applyDenoise, 10);
            });

            resetBtn.addEventListener('click', () => {
                ctx.drawImage(originalImg, 0, 0);
                strengthRange.value = 1;
                strengthVal.textContent = levels[1];
            });

            function applyDenoise() {
                // Using Median filter - distinct from Gaussian blur, better at preserving edges while removing salt-and-pepper noise
                // Strength determines window size? 
                // Window size: 1 -> 3x3, 2 -> 5x5 ?? 5x5 is very slow in JS
                // Let's stick to 3x3 window but iterate multiple times for strength > 1 or use simple blur for higher levels?
                // Actually Median filter is best for noise. 
                // Let's implement 3x3 median filter.

                // For higher strengths, maybe we just run it multiple times?
                // Or we can simple use a Mean filter (Blur) but that blurs edges too much.
                // Let's do: Level 1 = 1 pass Median 3x3
                // Level 2 = 2 passes Median 3x3
                // ...

                const w = canvas.width;
                const h = canvas.height;
                let imageData = ctx.getImageData(0, 0, w, h);
                const passes = parseInt(strengthRange.value);

                for (let p = 0; p < passes; p++) {
                    imageData = medianFilter(imageData, w, h);
                }

                ctx.putImageData(imageData, 0, 0);
            }

            function medianFilter(imageData, w, h) {
                const data = imageData.data;
                const output = new Uint8ClampedArray(data.length);

                // Copy alpha and borders
                output.set(data);

                for (let y = 1; y < h - 1; y++) {
                    for (let x = 1; x < w - 1; x++) {
                        const i = (y * w + x) * 4;

                        // Collect 3x3 neighborhood
                        let rs = [], gs = [], bs = [];

                        for (let ky = -1; ky <= 1; ky++) {
                            for (let kx = -1; kx <= 1; kx++) {
                                const idx = ((y + ky) * w + (x + kx)) * 4;
                                rs.push(data[idx]);
                                gs.push(data[idx + 1]);
                                bs.push(data[idx + 2]);
                            }
                        }

                        // Sort
                        rs.sort((a, b) => a - b);
                        gs.sort((a, b) => a - b);
                        bs.sort((a, b) => a - b);

                        // Median is at index 4 (middle of 9)
                        output[i] = rs[4];
                        output[i + 1] = gs[4];
                        output[i + 2] = bs[4];
                    }
                }

                return new ImageData(output, w, h);
            }

            downloadBtn.addEventListener('click', () => {
                const link = document.createElement('a');
                link.download = 'denoised-image.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        </script>
    @endpush
@endsection