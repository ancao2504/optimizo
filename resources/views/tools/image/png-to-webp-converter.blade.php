@extends('layouts.app')

@section('title', __tool('png-to-webp-converter', 'meta.title'))
@section('meta_description', __tool('png-to-webp-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('png-to-webp-converter', 'input.title')"
            :description="__tool('png-to-webp-converter', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/png" :title="__tool('png-to-webp-converter', 'input.drop_title')" :subtitle="__tool('png-to-webp-converter', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Left Column: Image Preview -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 min-h-[400px]">
                    <img id="imagePreview" class="max-h-[500px] max-w-full object-contain rounded-lg shadow-sm" src=""
                        alt="{!! __tool('png-to-webp-converter', 'editor.image_alt') !!}">
                </div>

                <!-- Right Column: Actions -->
                <div class="flex flex-col justify-center space-y-6">
                    <div class="text-center text-gray-600 font-medium">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 bg-purple-50 text-purple-600 rounded-full mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <p>{!! __tool('png-to-webp-converter', 'editor.output_format') !!} <span
                                class="font-bold text-purple-600">WEBP</span></p>
                    </div>

                    <div class="w-full bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                        <label class="block text-sm font-bold text-gray-700 mb-4 flex justify-between">
                            {!! __tool('png-to-webp-converter', 'editor.quality') !!}
                            <span id="qualityValue" class="text-purple-600 bg-purple-50 px-2 py-1 rounded">90%</span>
                        </label>
                        <input type="range" id="qualityRange" min="0.1" max="1.0" step="0.1" value="0.9"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-purple-600">
                    </div>

                    <button id="convertBtn"
                        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        {!! __tool('png-to-webp-converter', 'editor.btn_convert') !!}
                    </button>

                    <button id="uploadNewBtn"
                        class="text-gray-500 hover:text-purple-600 font-medium transition-colors text-sm text-center">
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
            const qualityRange = document.getElementById('qualityRange');
            const qualityValue = document.getElementById('qualityValue');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-purple-500', 'bg-purple-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-purple-500', 'bg-purple-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-purple-500', 'bg-purple-50/50');
                if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
                imagePreview.src = '';
            });

            qualityRange.addEventListener('input', (e) => { qualityValue.innerText = Math.round(e.target.value * 100) + '%'; });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('{!! __tool('png-to-webp-converter', 'js.invalid_image') !!}'); return; }
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    dropZone.classList.add('hidden');
                    editorArea.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }

            convertBtn.addEventListener('click', () => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();
                img.src = imagePreview.src;
                img.onload = () => {
                    canvas.width = img.width;
                    canvas.height = img.height;
                    ctx.drawImage(img, 0, 0);
                    const quality = parseFloat(qualityRange.value);
                    const dataUrl = canvas.toDataURL('image/webp', quality);
                    const link = document.createElement('a');
                    link.download = 'converted-image.webp';
                    link.href = dataUrl;
                    link.click();
                };
            });
        </script>
    @endpush
@endsection