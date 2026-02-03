@extends('layouts.app')

@section('title', __tool('black-and-white-image-converter', 'meta.title'))
@section('meta_description', __tool('black-and-white-image-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    {!! __tool('black-and-white-image-converter', 'input.title') !!}</h2>
                <p class="text-gray-600">{!! __tool('black-and-white-image-converter', 'input.desc') !!}</p>
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
                            {!! __tool('black-and-white-image-converter', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">
                            {!! __tool('black-and-white-image-converter', 'input.drop_desc') !!}</p>
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
                        <h3 class="font-bold text-gray-800 mb-4">
                            {!! __tool('black-and-white-image-converter', 'settings.title') !!}</h3>

                        <!-- Threshold Slider -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label for="thresholdRange" class="text-sm font-medium text-gray-700">Threshold</label>
                                <span id="thresholdVal" class="text-sm font-bold text-indigo-600">128</span>
                            </div>
                            <input type="range" id="thresholdRange" min="0" max="255" value="128"
                                class="w-full h-2 bg-white rounded-lg appearance-none cursor-pointer border border-gray-200">
                            <p class="text-xs text-gray-500 mt-2">Pixels brighter than this value become white, others
                                become black.</p>
                        </div>

                        <div class="flex gap-2">
                            <button id="resetBtn"
                                class="flex-1 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50">Reset</button>
                            <button id="applyBtn"
                                class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">Apply</button>
                        </div>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-gray-800 to-black hover:from-gray-900 hover:to-black text-white font-bold py-4 rounded-xl shadow-lg transform hover:scale-[1.01] transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download B&W Image
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

            const thresholdRange = document.getElementById('thresholdRange');
            const thresholdVal = document.getElementById('thresholdVal');
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
                // Determine dimensions - fit to screen but keep high res for processing
                // We'll perform operations on full res, but display scaled via CSS
                canvas.width = originalImg.width;
                canvas.height = originalImg.height;

                applyThreshold();

                dropZone.classList.add('hidden');
                editorArea.classList.remove('hidden');
            };

            thresholdRange.addEventListener('input', (e) => {
                thresholdVal.textContent = e.target.value;
                // Optional: Live preview (can be slow for large images)
                // Debounce could be good here, but for now we rely on Apply button or let user drag
                // Let's do live preview as it's more interactive
                requestAnimationFrame(applyThreshold);
            });

            applyBtn.addEventListener('click', applyThreshold);

            resetBtn.addEventListener('click', () => {
                thresholdRange.value = 128;
                thresholdVal.textContent = 128;
                applyThreshold();
            });

            function applyThreshold() {
                ctx.drawImage(originalImg, 0, 0);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                const data = imageData.data;
                const threshold = parseInt(thresholdRange.value);

                for (let i = 0; i < data.length; i += 4) {
                    const r = data[i];
                    const g = data[i + 1];
                    const b = data[i + 2];

                    // Grayscale first (luminance)
                    const gray = 0.299 * r + 0.587 * g + 0.114 * b;

                    // Apply threshold
                    const val = gray >= threshold ? 255 : 0;

                    data[i] = val;
                    data[i + 1] = val;
                    data[i + 2] = val;
                }

                ctx.putImageData(imageData, 0, 0);
            }

            downloadBtn.addEventListener('click', () => {
                const link = document.createElement('a');
                link.download = 'black-and-white.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        </script>
    @endpush
@endsection