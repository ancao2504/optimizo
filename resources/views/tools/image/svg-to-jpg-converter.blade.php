@extends('layouts.app')

@section('title', __tool('svg-to-jpg-converter', 'meta.title'))
@section('meta_description', __tool('svg-to-jpg-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('svg-to-jpg-converter', 'input.title')" :description="__tool('svg-to-jpg-converter', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/svg+xml"
                :title="__tool('svg-to-jpg-converter', 'input.drop_title')" :subtitle="__tool('svg-to-jpg-converter', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Left Column: Image Preview -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 min-h-[400px]">
                    <img id="imagePreview" class="max-h-[500px] max-w-full object-contain rounded-lg shadow-sm" src=""
                        alt="{!! __tool('svg-to-jpg-converter', 'editor.image_alt') !!}">
                </div>

                <!-- Right Column: Actions -->
                <div class="flex flex-col justify-center space-y-6">
                    <div class="bg-teal-50 border border-teal-100 rounded-xl p-6 text-sm text-teal-900 shadow-sm">
                        <span class="font-bold block mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {!! __tool('svg-to-jpg-converter', 'editor.note') !!}
                        </span>
                        {!! __tool('svg-to-jpg-converter', 'editor.note_text') !!}
                    </div>

                    <div class="text-center text-gray-600 font-medium">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 bg-teal-50 text-teal-600 rounded-full mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <p>{!! __tool('svg-to-jpg-converter', 'editor.output_format') !!} <span
                                class="font-bold text-teal-600">JPG</span></p>
                    </div>

                    <div class="w-full bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                        <label
                            class="block text-sm font-bold text-gray-700 mb-2">{!! __tool('svg-to-jpg-converter', 'editor.scale_label') !!}</label>
                        <select id="scaleSelect"
                            class="w-full rounded-lg border-gray-200 focus:border-teal-500 focus:ring focus:ring-teal-200 shadow-sm p-3 bg-white">
                            <option value="1">{!! __tool('svg-to-jpg-converter', 'editor.scale_1') !!}</option>
                            <option value="2">{!! __tool('svg-to-jpg-converter', 'editor.scale_2') !!}</option>
                            <option value="4">{!! __tool('svg-to-jpg-converter', 'editor.scale_4') !!}</option>
                        </select>
                    </div>

                    <button id="convertBtn"
                        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {!! __tool('svg-to-jpg-converter', 'editor.btn_convert') !!}
                    </button>

                    <button id="uploadNewBtn"
                        class="text-gray-500 hover:text-teal-600 font-medium transition-colors text-sm text-center">
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
            const scaleSelect = document.getElementById('scaleSelect');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-teal-500', 'bg-teal-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-teal-500', 'bg-teal-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-teal-500', 'bg-teal-50/50');
                if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            function handleFile(file) {
                if (!file.type.match('image/svg.*')) {
                    alert('{!! __tool('svg-to-jpg-converter', 'js.invalid_image') !!}');
                    return;
                }
                const reader = new FileReader();
                reader.onload = (e) => { imagePreview.src = e.target.result; editorArea.classList.remove('hidden'); dropZone.classList.add('hidden'); };
                reader.readAsDataURL(file);
            }

            convertBtn.addEventListener('click', () => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const img = new Image();
                img.src = imagePreview.src;

                img.onload = () => {
                    const scale = parseInt(scaleSelect.value);
                    canvas.width = img.width * scale;
                    canvas.height = img.height * scale;

                    // White BG for JPG
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);
                    const link = document.createElement('a');
                    link.download = 'converted-svg.jpg';
                    link.href = dataUrl;
                    link.click();
                };
            });
        </script>
    @endpush
@endsection