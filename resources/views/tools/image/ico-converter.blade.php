@extends('layouts.app')

@section('title', __tool('ico-converter', 'meta.title'))
@section('meta_description', __tool('ico-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('ico-converter', 'input.title')" :description="__tool('ico-converter', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/png, image/jpeg, image/jpg"
                :title="__tool('ico-converter', 'input.drop_title')" :subtitle="__tool('ico-converter', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Left Column: Preview Area -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex flex-col items-center justify-center border border-gray-100 min-h-[400px] space-y-6">
                    <div class="flex items-center justify-center gap-8">
                        <div>
                            <p class="text-xs text-gray-500 mb-2 text-center uppercase tracking-wider font-bold">
                                {!! __tool('ico-converter', 'editor.original') !!}
                            </p>
                            <img id="imagePreview" class="h-24 w-auto rounded-lg shadow-sm border border-gray-200" src=""
                                alt="{!! __tool('ico-converter', 'editor.image_alt') !!}">
                        </div>
                        <div class="text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-2 text-center uppercase tracking-wider font-bold">
                                {!! __tool('ico-converter', 'editor.favicon') !!}
                            </p>
                            <div
                                class="w-24 h-24 flex items-center justify-center bg-white border border-gray-200 rounded-lg shadow-sm">
                                <canvas id="faviconCanvas" width="32" height="32"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Settings & Actions -->
                <div class="flex flex-col justify-center space-y-6">
                    <div class="w-full bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                        <label
                            class="block text-sm font-bold text-gray-700 mb-4">{!! __tool('ico-converter', 'editor.size_label') !!}</label>
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button"
                                class="size-btn px-4 py-3 border-2 border-amber-500 bg-amber-50 text-amber-700 font-bold rounded-xl transition-all"
                                data-size="32">32x32</button>
                            <button type="button"
                                class="size-btn px-4 py-3 border-2 border-transparent bg-gray-50 text-gray-600 font-medium rounded-xl hover:bg-gray-100 transition-all"
                                data-size="64">64x64</button>
                            <button type="button"
                                class="size-btn px-4 py-3 border-2 border-transparent bg-gray-50 text-gray-600 font-medium rounded-xl hover:bg-gray-100 transition-all"
                                data-size="128">128x128</button>
                        </div>
                        <input type="hidden" id="selectedSize" value="32">
                    </div>

                    <div class="text-center text-gray-600 font-medium">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 bg-amber-50 text-amber-600 rounded-full mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <p>{!! __tool('ico-converter', 'editor.output_format') !!} <span
                                class="font-bold text-amber-600">ICO</span></p>
                    </div>

                    <button id="convertBtn"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {!! __tool('ico-converter', 'editor.btn_download') !!}
                    </button>

                    <button id="uploadNewBtn"
                        class="text-gray-500 hover:text-amber-600 font-medium transition-colors text-sm text-center">
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
            const imagePreview = document.getElementById('imagePreview');
            const convertBtn = document.getElementById('convertBtn');
            const faviconCanvas = document.getElementById('faviconCanvas');
            const ctx = faviconCanvas.getContext('2d');
            const sizeBtns = document.querySelectorAll('.size-btn');
            const selectedSizeInput = document.getElementById('selectedSize');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            let currentImg = new Image();

            // Size Selection
            sizeBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    sizeBtns.forEach(b => {
                        b.classList.remove('border-amber-500', 'bg-amber-50', 'text-amber-700', 'font-bold');
                        b.classList.add('border-transparent', 'bg-gray-50', 'text-gray-600', 'font-medium');
                    });
                    btn.classList.add('border-amber-500', 'bg-amber-50', 'text-amber-700', 'font-bold');
                    btn.classList.remove('border-transparent', 'bg-gray-50', 'text-gray-600', 'font-medium');

                    const size = parseInt(btn.dataset.size);
                    selectedSizeInput.value = size;
                    faviconCanvas.width = size;
                    faviconCanvas.height = size;
                    updateCanvas();
                });
            });

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-amber-500', 'bg-amber-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-amber-500', 'bg-amber-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-amber-500', 'bg-amber-50/50');
                if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('{!! __tool('ico-converter', 'js.invalid_image') !!}'); return; }
                const reader = new FileReader();
                reader.onload = (e) => {
                    currentImg = new Image();
                    currentImg.src = e.target.result;
                    imagePreview.src = e.target.result;
                    currentImg.onload = updateCanvas;
                    editorArea.classList.remove('hidden');
                    dropZone.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }

            function updateCanvas() {
                if (!currentImg.src) return;
                ctx.clearRect(0, 0, faviconCanvas.width, faviconCanvas.height);
                ctx.drawImage(currentImg, 0, 0, faviconCanvas.width, faviconCanvas.height);
            }

            convertBtn.addEventListener('click', () => {
                const dataUrl = faviconCanvas.toDataURL('image/png');
                const link = document.createElement('a');
                link.download = 'favicon.ico';
                link.href = dataUrl;
                link.click();
            });
        </script>
    @endpush
@endsection