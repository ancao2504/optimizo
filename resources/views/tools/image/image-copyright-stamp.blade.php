@extends('layouts.app')

@section('title', __tool('image-copyright-stamp', 'meta.title'))
@section('meta_description', __tool('image-copyright-stamp', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />


            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-copyright-stamp', 'input.drop_title')" :subtitle="__tool('image-copyright-stamp', 'input.drop_desc')" />

            <!-- Editor Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Canvas -->
                <div
                    class="lg:col-span-2 bg-gray-50 rounded-2xl p-4 flex items-center justify-center border border-gray-100 relative overflow-hidden min-h-[400px]">
                    <canvas id="imageCanvas" class="max-w-full rounded shadow-sm cursor-crosshair"></canvas>
                </div>

                <!-- Right Column: Controls -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100 space-y-6">

                        <!-- Tabs for Text vs Image -->
                        <div class="flex border-b border-gray-200">
                            <button id="tabText"
                                class="flex-1 py-2 font-bold text-indigo-600 border-b-2 border-indigo-600 transition-colors">Text
                                Stamp</button>
                            <button id="tabImage"
                                class="flex-1 py-2 font-bold text-gray-400 hover:text-indigo-600 transition-colors">Logo
                                Stamp</button>
                        </div>

                        <!-- Text Controls -->
                        <div id="textControls">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Watermark Text</label>
                                    <input type="text" id="watermarkText"
                                        class="w-full rounded-xl border-gray-200 bg-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5"
                                        placeholder="© Copyright 2026">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Color</label>
                                        <div class="relative">
                                            <input type="color" id="textColor"
                                                class="w-full h-10 rounded-lg cursor-pointer border border-gray-200 p-1"
                                                value="#ffffff">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Font
                                            Size</label>
                                        <input type="number" id="textSize"
                                            class="w-full rounded-xl border-gray-200 h-10 bg-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5"
                                            value="30" min="10" max="200">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Controls -->
                        <div id="imageControls" class="hidden">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Upload Logo</label>
                                    <input type="file" id="logoInput"
                                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors"
                                        accept="image/*">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Size Scale
                                        (%)</label>
                                    <input type="range" id="logoSize" min="10" max="200" value="50"
                                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                                </div>
                            </div>
                        </div>

                        <!-- Common Controls -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Opacity (%)</label>
                                <input type="range" id="opacityRange" min="0" max="100" value="80"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                            </div>

                            <div class="grid grid-cols-3 gap-2">
                                <button
                                    class="pos-btn bg-white border border-gray-200 rounded-xl p-2 hover:bg-indigo-50 hover:text-indigo-600 font-bold text-xs text-gray-600 transition-colors shadow-sm"
                                    data-pos="top-left">Top Left</button>
                                <button
                                    class="pos-btn bg-white border border-gray-200 rounded-xl p-2 hover:bg-indigo-50 hover:text-indigo-600 font-bold text-xs text-gray-600 transition-colors shadow-sm"
                                    data-pos="center">Center</button>
                                <button
                                    class="pos-btn bg-white border border-gray-200 rounded-xl p-2 hover:bg-indigo-50 hover:text-indigo-600 font-bold text-xs text-gray-600 transition-colors shadow-sm"
                                    data-pos="bottom-right">Bottom Right</button>
                            </div>
                            <p class="text-xs text-gray-400 mt-3 text-center">
                                <span class="inline-block w-2 h-2 rounded-full bg-indigo-500 mr-1"></span>
                                Drag watermark on image to position manually
                            </p>
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
                        Stamp Another Image
                    </button>
                </div>
            </div>


        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-blue-600 font-bold tracking-widest uppercase text-sm mb-3 block">{{ __tool('image-copyright-stamp', 'content.features.badge') ?: 'Why Use This Tool?' }}</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('image-copyright-stamp', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">{{ __tool('image-copyright-stamp', 'content.features.subtitle') ?: 'Secure your creative work easily.' }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('image-copyright-stamp', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('image-copyright-stamp', "content.features.f{$i}_desc") }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- How-to Section -->
             <section class="max-w-5xl mx-auto bg-gray-900 text-white rounded-[3rem] p-8 md:p-16 border border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[80px] -ml-16 -mb-16"></div>

                <div class="relative z-10 text-center mb-16">
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('image-copyright-stamp', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">{{ __tool('image-copyright-stamp', 'content.how_to.subtitle') ?: 'Add protection in seconds.' }}</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('image-copyright-stamp', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-blue-600 text-white font-bold text-lg shadow-lg shadow-blue-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('image-copyright-stamp', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('image-copyright-stamp', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('image-copyright-stamp', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-blue-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('image-copyright-stamp', "content.faq.a$i"); @endphp
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
            const ctx = canvas.getContext('2d');

            // Controls
            const tabText = document.getElementById('tabText');
            const tabImage = document.getElementById('tabImage');
            const textControls = document.getElementById('textControls');
            const imageControls = document.getElementById('imageControls');

            const watermarkText = document.getElementById('watermarkText');
            const textColor = document.getElementById('textColor');
            const textSize = document.getElementById('textSize');

            const logoInput = document.getElementById('logoInput');
            const logoSize = document.getElementById('logoSize');

            const opacityRange = document.getElementById('opacityRange');
            const posBtns = document.querySelectorAll('.pos-btn');

            const downloadBtn = document.getElementById('downloadBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            let mainImg = new Image();
            let logoImg = new Image();
            let activeMode = 'text'; // 'text' or 'image'
            let watermarkPos = { x: 50, y: 50 };
            let isDragging = false;

            // Init
            logoImg.src = '';

            // Tabs
            tabText.addEventListener('click', () => {
                activeMode = 'text';
                textControls.classList.remove('hidden');
                imageControls.classList.add('hidden');
                tabText.classList.add('text-indigo-600', 'border-indigo-600');
                tabText.classList.remove('text-gray-400');
                tabImage.classList.remove('text-indigo-600', 'border-indigo-600');
                tabImage.classList.add('text-gray-400');
                draw();
            });

            tabImage.addEventListener('click', () => {
                activeMode = 'image';
                imageControls.classList.remove('hidden');
                textControls.classList.add('hidden');
                tabImage.classList.add('text-indigo-600', 'border-indigo-600');
                tabImage.classList.remove('text-gray-400');
                tabText.classList.remove('text-indigo-600', 'border-indigo-600');
                tabText.classList.add('text-gray-400');
                draw();
            });

            // File Uploads
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50');
                if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('Invalid image'); return; }
                const reader = new FileReader();
                reader.onload = (e) => { mainImg.src = e.target.result; };
                reader.readAsDataURL(file);
            }

            mainImg.onload = () => {
                canvas.width = mainImg.width;
                canvas.height = mainImg.height;

                // Initial Pos center
                watermarkPos = { x: canvas.width / 2, y: canvas.height / 2 };

                draw();

                dropZone.classList.add('hidden');
                editorArea.classList.remove('hidden');
            };

            logoInput.addEventListener('change', (e) => {
                if (e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (evt) => {
                        logoImg.src = evt.target.result;
                        logoImg.onload = draw;
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            // Controls Events
            [watermarkText, textColor, textSize, opacityRange, logoSize].forEach(el => {
                el.addEventListener('input', draw);
            });

            posBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const pos = btn.getAttribute('data-pos');
                    if (pos === 'center') {
                        watermarkPos = { x: canvas.width / 2, y: canvas.height / 2 };
                    } else if (pos === 'top-left') {
                        watermarkPos = { x: canvas.width * 0.1, y: canvas.height * 0.1 };
                    } else if (pos === 'bottom-right') {
                        watermarkPos = { x: canvas.width * 0.9, y: canvas.height * 0.9 };
                    }
                    draw();
                });
            });

            // Dragging Logic
            canvas.addEventListener('mousedown', (e) => {
                isDragging = true;
                updateDragPos(e);
            });
            window.addEventListener('mousemove', (e) => {
                if (isDragging) updateDragPos(e);
            });
            window.addEventListener('mouseup', () => {
                isDragging = false;
            });

            function updateDragPos(e) {
                // Map screen coords to canvas coords
                const rect = canvas.getBoundingClientRect();
                const scaleX = canvas.width / rect.width;
                const scaleY = canvas.height / rect.height;

                let x = (e.clientX - rect.left) * scaleX;
                let y = (e.clientY - rect.top) * scaleY;

                watermarkPos = { x, y };
                requestAnimationFrame(draw);
            }

            function draw() {
                if (!mainImg.src) return;

                // Draw background
                ctx.globalAlpha = 1.0;
                ctx.drawImage(mainImg, 0, 0);

                const opacity = opacityRange.value / 100;
                ctx.globalAlpha = opacity;

                if (activeMode === 'text') {
                    const text = watermarkText.value || '© Copyright';
                    const size = parseInt(textSize.value);
                    const color = textColor.value;

                    ctx.font = `bold ${size}px Arial, sans-serif`;
                    ctx.fillStyle = color;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    // Shadow for legibility
                    ctx.shadowColor = "rgba(0,0,0,0.5)";
                    ctx.shadowBlur = 4;
                    ctx.shadowOffsetX = 2;
                    ctx.shadowOffsetY = 2;

                    ctx.fillText(text, watermarkPos.x, watermarkPos.y);

                    // Reset shadow
                    ctx.shadowColor = "transparent";

                } else if (activeMode === 'image' && logoImg.src) {
                    const scale = logoSize.value / 100;
                    const w = logoImg.width * scale;
                    const h = logoImg.height * scale;

                    // Center draw
                    ctx.drawImage(logoImg, watermarkPos.x - w / 2, watermarkPos.y - h / 2, w, h);
                }
            }

            downloadBtn.addEventListener('click', () => {
                const link = document.createElement('a');
                link.download = 'watermarked-image.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        </script>
    @endpush
@endsection