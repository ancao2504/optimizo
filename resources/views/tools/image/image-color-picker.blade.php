@extends('layouts.app')

@section('title', __tool('image-color-picker', 'meta.title'))
@section('meta_description', __tool('image-color-picker', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />


            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-color-picker', 'input.drop_title')" :subtitle="__tool('image-color-picker', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Image Canvas -->
                <div class="lg:col-span-2 bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 relative overflow-hidden min-h-[400px]"
                    style="cursor: crosshair;">
                    <canvas id="imageCanvas" class="max-w-full rounded-lg shadow-sm"></canvas>

                    <!-- Magnifier Glass -->
                    <div id="magnifier"
                        class="hidden absolute w-32 h-32 border-4 border-white rounded-full pointer-events-none shadow-2xl overflow-hidden z-20 bg-white ring-4 ring-black/5"
                        style="background-repeat: no-repeat;">
                        <!-- Crosshair in center -->
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-4 h-4 border-2 border-indigo-500 rounded-full bg-white/20"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Color Info -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-gray-800 text-lg">Selected Color</h3>
                            <div id="colorPreview"
                                class="w-16 h-16 rounded-2xl shadow-sm border border-gray-200 bg-white ring-4 ring-gray-50">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">HEX</label>
                                <div class="flex rounded-xl shadow-sm">
                                    <input type="text" id="hexVal" readonly
                                        class="flex-1 block w-full rounded-l-xl border-gray-200 bg-gray-50 text-gray-700 font-mono text-sm focus:ring-indigo-500 focus:border-indigo-500 border-r-0"
                                        value="#FFFFFF">
                                    <button
                                        class="copy-btn px-4 py-2 bg-gray-100 border border-l-0 border-gray-200 text-gray-600 rounded-r-xl hover:bg-gray-200 transition-colors"
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
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">RGB</label>
                                <div class="flex rounded-xl shadow-sm">
                                    <input type="text" id="rgbVal" readonly
                                        class="flex-1 block w-full rounded-l-xl border-gray-200 bg-gray-50 text-gray-700 font-mono text-sm border-r-0"
                                        value="rgb(255, 255, 255)">
                                    <button
                                        class="copy-btn px-4 py-2 bg-gray-100 border border-l-0 border-gray-200 text-gray-600 rounded-r-xl hover:bg-gray-200 transition-colors"
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
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">HSL</label>
                                <div class="flex rounded-xl shadow-sm">
                                    <input type="text" id="hslVal" readonly
                                        class="flex-1 block w-full rounded-l-xl border-gray-200 bg-gray-50 text-gray-700 font-mono text-sm border-r-0"
                                        value="hsl(0, 0%, 100%)">
                                    <button
                                        class="copy-btn px-4 py-2 bg-gray-100 border border-l-0 border-gray-200 text-gray-600 rounded-r-xl hover:bg-gray-200 transition-colors"
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
                        class="text-center text-gray-500 hover:text-indigo-600 font-medium transition-colors text-sm">
                        Pick Color from Another Image
                    </button>
                </div>
            </div>


        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-pink-600 font-bold tracking-widest uppercase text-sm mb-3 block">{{ __tool('image-color-picker', 'content.features.badge') ?: 'Why Use This Tool?' }}</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('image-color-picker', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">{{ __tool('image-color-picker', 'content.features.subtitle') ?: 'Get precise colors for your designs.' }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('image-color-picker', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-pink-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('image-color-picker', "content.features.f{$i}_desc") }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- How-to Section -->
             <section class="max-w-5xl mx-auto bg-gray-900 text-white rounded-[3rem] p-8 md:p-16 border border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-pink-600/20 rounded-full blur-[100px] -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[80px] -ml-16 -mb-16"></div>

                <div class="relative z-10 text-center mb-16">
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('image-color-picker', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">{{ __tool('image-color-picker', 'content.how_to.subtitle') ?: 'Identify any color in seconds.' }}</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('image-color-picker', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-pink-600 text-white font-bold text-lg shadow-lg shadow-pink-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('image-color-picker', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('image-color-picker', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('image-color-picker', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-pink-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('image-color-picker', "content.faq.a$i"); @endphp
                                        @if(is_array($a))
                                            <ul class="list-disc pl-4 space-y-2">@foreach($a as $item) <li>{{ $item }}</li> @endforeach</ul>
                                        @else
                                            {{ $a }}
                                        @endif
                                    </div>
                                </details>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        </div>
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

            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const targetId = btn.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    input.select();
                    document.execCommand('copy');
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    setTimeout(() => btn.innerHTML = originalHtml, 1500);
                });
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('Please upload a valid image.'); return; }
                const reader = new FileReader();
                reader.onload = (e) => { img.src = e.target.result; };
                reader.readAsDataURL(file);
            }

            img.onload = () => {
                // Show editor first so we can get valid dimensions
                dropZone.classList.add('hidden');
                editorArea.classList.remove('hidden');

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
            };

            canvas.addEventListener('mousemove', (e) => {
                pickColor(e);
                showMagnifier(e);
            });

            canvas.addEventListener('click', (e) => {
                pickColor(e);
            });

            canvas.addEventListener('mouseleave', () => {
                magnifier.classList.add('hidden');
            });

            function pickColor(e) {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                const pixel = ctx.getImageData(x, y, 1, 1).data;
                const r = pixel[0], g = pixel[1], b = pixel[2];
                updateColorInfo(r, g, b);
            }

            function showMagnifier(e) {
                const rect = canvas.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                magnifier.classList.remove('hidden');
                // Center magnifier on mouse
                magnifier.style.left = (x - magnifier.offsetWidth / 2) + 'px';
                magnifier.style.top = (y - magnifier.offsetHeight / 2 - 80) + 'px'; // Offset above finger/cursor

                // We need to set the background image of the magnifier div to the canvas data
                // This is expensive if done on every move, but necessary for the zoom effect on canvas content
                magnifier.style.backgroundImage = `url('${canvas.toDataURL()}')`;
                magnifier.style.backgroundRepeat = 'no-repeat';

                const zoom = 4;
                // Calculate background position to match the cursor
                const bgX = -x * zoom + (magnifier.offsetWidth / 2);
                const bgY = -y * zoom + (magnifier.offsetHeight / 2);

                magnifier.style.backgroundSize = `${canvas.width * zoom}px ${canvas.height * zoom}px`;
                magnifier.style.backgroundPosition = `${bgX}px ${bgY}px`;
            }

            function updateColorInfo(r, g, b) {
                const rgbString = `rgb(${r}, ${g}, ${b})`;
                colorPreview.style.backgroundColor = rgbString;
                rgbVal.value = rgbString;
                hexVal.value = rgbToHex(r, g, b);
                hslVal.value = rgbToHsl(r, g, b);
            }

            function rgbToHex(r, g, b) {
                return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
            }

            function rgbToHsl(r, g, b) {
                r /= 255, g /= 255, b /= 255;
                const max = Math.max(r, g, b), min = Math.min(r, g, b);
                let h, s, l = (max + min) / 2;
                if (max === min) { h = s = 0; } else {
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