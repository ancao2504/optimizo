@extends('layouts.app')

@section('title', __tool('image-converter', 'meta.title'))
@section('meta_description', __tool('image-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-converter', 'input.title')" :description="__tool('image-converter', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/png, image/jpeg, image/webp"
                :title="__tool('image-converter', 'input.drop_title')" :subtitle="__tool('image-converter', 'input.drop_desc')" />

            <!-- Controls & Preview (Hidden initially) -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Left Column: Image Preview -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 min-h-[400px]">
                    <img id="imagePreview" class="max-h-[500px] max-w-full object-contain rounded-lg shadow-sm" src=""
                        alt="{!! __tool('image-converter', 'editor.image_alt') !!}">
                </div>

                <!-- Right Column: Controls -->
                <div class="flex flex-col justify-center space-y-6">
                    <!-- Settings -->
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 space-y-6 shadow-sm">
                        <h3 class="font-bold text-gray-900 border-b border-gray-100 pb-3">Conversion Settings</h3>

                        <div>
                            <label
                                class="block text-sm font-bold text-gray-700 mb-2">{!! __tool('image-converter', 'editor.target_format') !!}</label>
                            <select id="formatSelect"
                                class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-gray-700 font-medium p-3 bg-gray-50">
                                <option value="image/png">PNG</option>
                                <option value="image/jpeg">JPG</option>
                                <option value="image/webp">WEBP</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 flex justify-between">
                                {!! __tool('image-converter', 'editor.quality') !!}
                                <span id="qualityValue" class="text-indigo-600 bg-indigo-50 px-2 py-1 rounded">90%</span>
                            </label>
                            <input type="range" id="qualityRange" min="0.1" max="1.0" step="0.1" value="0.9"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                        </div>
                    </div>

                    <!-- Actions -->
                    <button id="convertBtn"
                        class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        {!! __tool('image-converter', 'editor.btn_convert') !!}
                    </button>

                    <button id="uploadNewBtn"
                        class="text-gray-500 hover:text-indigo-600 font-medium transition-colors text-sm text-center">
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
            const qualityRange = document.getElementById('qualityRange');
            const qualityValue = document.getElementById('qualityValue');
            const convertBtn = document.getElementById('convertBtn');
            const formatSelect = document.getElementById('formatSelect');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

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

            // Quality Slider
            qualityRange.addEventListener('input', (e) => { qualityValue.innerText = Math.round(e.target.value * 100) + '%'; });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('{!! __tool('image-converter', 'js.invalid_image') !!}'); return; }
                const reader = new FileReader();
                reader.onload = (e) => {
                    imagePreview.src = e.target.result;
                    dropZone.classList.add('hidden');
                    editorArea.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }

            // Convert Logic
            convertBtn.addEventListener('click', () => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();

                img.src = imagePreview.src;

                img.onload = () => {
                    canvas.width = img.width;
                    canvas.height = img.height;

                    // Fill white background for JPEG conversion transparency handling
                    if (formatSelect.value === 'image/jpeg') {
                        ctx.fillStyle = '#FFFFFF';
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                    }

                    ctx.drawImage(img, 0, 0);

                    const format = formatSelect.value;
                    const quality = parseFloat(qualityRange.value);
                    const dataUrl = canvas.toDataURL(format, quality);

                    // Download
                    const link = document.createElement('a');
                    link.download = 'converted-image.' + format.split('/')[1];
                    link.href = dataUrl;
                    link.click();
                };
            });
        </script>
    @endpush
@endsection