@extends('layouts.app')

@section('title', __tool('image-noise-reducer', 'meta.title'))
@section('meta_description', __tool('image-noise-reducer', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-noise-reducer', 'input.title')" :description="__tool('image-noise-reducer', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-noise-reducer', 'input.drop_title')" :subtitle="__tool('image-noise-reducer', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Canvas -->
                <div
                    class="lg:col-span-2 bg-gray-50 rounded-2xl p-4 flex items-center justify-center border border-gray-100 relative min-h-[400px]">
                    <canvas id="imageCanvas" class="max-w-full rounded shadow-sm"></canvas>
                </div>

                <!-- Right Column: Settings -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4 text-lg">
                            {!! __tool('image-noise-reducer', 'settings.title') !!}
                        </h3>

                        <!-- Smoothness Level -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label for="strengthRange" class="text-sm font-bold text-gray-700">Denoise
                                    Strength</label>
                                <span id="strengthVal" class="text-sm font-bold text-indigo-600">Low (Median)</span>
                            </div>
                            <input type="range" id="strengthRange" min="1" max="5" value="1" step="1"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                            <p class="text-xs text-gray-500 mt-2 bg-white p-2 rounded border border-gray-100">
                                <strong>Tip:</strong> Higher strength applies multiple passes but might blur extensive
                                details.
                            </p>
                        </div>

                        <div class="flex gap-3">
                            <button id="resetBtn"
                                class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">Reset</button>
                            <button id="applyBtn"
                                class="flex-1 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-colors shadow-md">Apply</button>
                        </div>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Image
                    </button>

                    <button id="uploadNewBtn"
                        class="text-center text-gray-500 hover:text-indigo-600 font-medium transition-colors text-sm">
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

            const strengthRange = document.getElementById('strengthRange');
            const strengthVal = document.getElementById('strengthVal');
            const applyBtn = document.getElementById('applyBtn');
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
                const originalText = applyBtn.innerText;
                applyBtn.innerText = 'Processing...';
                applyBtn.disabled = true;

                setTimeout(() => {
                    applyDenoise();
                    applyBtn.innerText = originalText;
                    applyBtn.disabled = false;
                }, 50);
            });

            resetBtn.addEventListener('click', () => {
                ctx.drawImage(originalImg, 0, 0);
                strengthRange.value = 1;
                strengthVal.textContent = levels[1];
            });

            function applyDenoise() {
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