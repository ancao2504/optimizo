@extends('layouts.app')

@section('title', __tool('image-color-picker', 'meta.title'))
@section('meta_description', __tool('image-color-picker', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{!! __tool('image-color-picker', 'input.title') !!}</h2>
                <p class="text-gray-600">{!! __tool('image-color-picker', 'input.desc') !!}</p>
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
                        <p class="text-lg font-bold text-gray-700">{!! __tool('image-color-picker', 'input.drop_title') !!}
                        </p>
                        <p class="text-sm text-gray-500">{!! __tool('image-color-picker', 'input.drop_desc') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Image Canvas -->
                <div class="lg:col-span-2 bg-gray-50 rounded-xl p-4 flex items-center justify-center border border-gray-200 relative overflow-hidden"
                    style="min-height: 400px; cursor: crosshair;">
                    <canvas id="imageCanvas" class="max-w-full rounded shadow-sm"></canvas>

                    <!-- Magnifier Glass -->
                    <div id="magnifier"
                        class="hidden absolute w-32 h-32 border-4 border-white rounded-full pointer-events-none shadow-xl overflow-hidden z-10 bg-white"
                        style="background-repeat: no-repeat;">
                        <!-- Crosshair in center -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-2 h-2 border border-gray-400 bg-transparent"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Color Info -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-gray-800">Selected Color</h3>
                            <div id="colorPreview"
                                class="w-12 h-12 rounded-lg shadow-inner border border-gray-200 bg-white"></div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">HEX</label>
                                <div class="flex">
                                    <input type="text" id="hexVal" readonly
                                        class="flex-1 block w-full rounded-l-lg border-gray-300 bg-white text-gray-800 sm:text-sm focus:ring-indigo-500 focus:border-indigo-500"
                                        value="#FFFFFF">
                                    <button
                                        class="copy-btn px-3 py-2 bg-gray-200 text-gray-600 rounded-r-lg hover:bg-gray-300"
                                        data-target="hexVal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">RGB</label>
                                <div class="flex">
                                    <input type="text" id="rgbVal" readonly
                                        class="flex-1 block w-full rounded-l-lg border-gray-300 bg-white text-gray-800 sm:text-sm"
                                        value="rgb(255, 255, 255)">
                                    <button
                                        class="copy-btn px-3 py-2 bg-gray-200 text-gray-600 rounded-r-lg hover:bg-gray-300"
                                        data-target="rgbVal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label
                                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">HSL</label>
                                <div class="flex">
                                    <input type="text" id="hslVal" readonly
                                        class="flex-1 block w-full rounded-l-lg border-gray-300 bg-white text-gray-800 sm:text-sm"
                                        value="hsl(0, 0%, 100%)">
                                    <button
                                        class="copy-btn px-3 py-2 bg-gray-200 text-gray-600 rounded-r-lg hover:bg-gray-300"
                                        data-target="hslVal">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button id="uploadNewBtn"
                        class="w-full bg-white border border-gray-300 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Load New Image
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
            const uploadNewBtn = document.getElementById('uploadNewBtn');
            const magnifier = document.getElementById('magnifier');

            const colorPreview = document.getElementById('colorPreview');
            const hexVal = document.getElementById('hexVal');
            const rgbVal = document.getElementById('rgbVal');
            const hslVal = document.getElementById('hslVal');

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

            // Copy Buttons
            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    input.select();
                    document.execCommand('copy');

                    // Visual feedback
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    setTimeout(() => btn.innerHTML = originalHtml, 1500);
                });
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) {
                    alert('Please upload a valid image.');
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }

            img.onload = () => {
                // Resize Canvas to fit image but constrained by max width
                const maxWidth = editorArea.clientWidth * 0.65; // ~2/3 width
                let width = img.width;
                let height = img.height;

                if (width > maxWidth) {
                    height = (maxWidth / width) * height;
                    width = maxWidth;
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                dropZone.classList.add('hidden');
                editorArea.classList.remove('hidden');
            };

            // Color Picking Logic
            canvas.addEventListener('mousemove', (e) => {
                pickColor(e);
                showMagnifier(e);
            });

            canvas.addEventListener('click', (e) => {
                pickColor(e);
                // Maybe lock color? 
            });

            canvas.addEventListener('mouseleave', () => {
                magnifier.classList.add('hidden');
            });

            function pickColor(e) {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                // Get pixel data
                const pixel = ctx.getImageData(x, y, 1, 1).data;
                const r = pixel[0];
                const g = pixel[1];
                const b = pixel[2];

                updateColorInfo(r, g, b);
            }

            function showMagnifier(e) {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                magnifier.classList.remove('hidden');

                // Position magnifier nearby
                magnifier.style.left = (x + 20) + 'px';
                magnifier.style.top = (y - 20) + 'px';

                // Show zoomed region
                // We use background-image to "zoom"
                magnifier.style.backgroundImage = `url('${canvas.toDataURL()}')`;
                magnifier.style.backgroundRepeat = 'no-repeat';

                // Calculate background position
                // Zoom level approx 4x
                const zoom = 4;
                const bgX = -x * zoom + (magnifier.offsetWidth / 2);
                const bgY = -y * zoom + (magnifier.offsetHeight / 2);

                magnifier.style.backgroundSize = `${canvas.width * zoom}px ${canvas.height * zoom}px`;
                magnifier.style.backgroundPosition = `${bgX}px ${bgY}px`;
            }

            function updateColorInfo(r, g, b) {
                const rgbString = `rgb(${r}, ${g}, ${b})`;
                const hexString = rgbToHex(r, g, b);
                const hslString = rgbToHsl(r, g, b);

                colorPreview.style.backgroundColor = rgbString;
                rgbVal.value = rgbString;
                hexVal.value = hexString;
                hslVal.value = hslString;
            }

            function rgbToHex(r, g, b) {
                return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
            }

            function rgbToHsl(r, g, b) {
                r /= 255, g /= 255, b /= 255;
                const max = Math.max(r, g, b), min = Math.min(r, g, b);
                let h, s, l = (max + min) / 2;

                if (max === min) {
                    h = s = 0; // achromatic
                } else {
                    const d = max - min;
                    s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                    switch (max) {
                        case r: h = (g - b) / d + (g < b ? 6 : 0); break;
                        case g: h = (b - r) / d + 2; break;
                        case b: h = (r - g) / d + 4; break;
                    }
                    h /= 6;
                }

                return `hsl(${Math.round(h * 360)}, ${Math.round(s * 100)}%, ${Math.round(l * 100)}%)`;
            }
        </script>
    @endpush
@endsection