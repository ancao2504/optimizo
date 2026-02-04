@extends('layouts.app')

@section('title', __tool('avif-to-jpg-converter', 'meta.title'))
@section('meta_description', __tool('avif-to-jpg-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('avif-to-jpg-converter', 'input.title')"
            :description="__tool('avif-to-jpg-converter', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/avif" :title="__tool('avif-to-jpg-converter', 'input.drop_title')" :subtitle="__tool('avif-to-jpg-converter', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Left Column: Image Preview -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 min-h-[400px]">
                    <img id="imagePreview" class="max-h-[500px] max-w-full object-contain rounded-lg shadow-sm" src=""
                        alt="{!! __tool('avif-to-jpg-converter', 'result.image_alt') !!}">
                </div>

                <!-- Right Column: Actions -->
                <div class="flex flex-col justify-center space-y-6">
                    <div class="text-center text-gray-600 font-medium">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-full mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <p>{!! __tool('avif-to-jpg-converter', 'result.converted_to') !!} <span
                                class="font-bold text-indigo-600">JPG</span></p>
                    </div>

                    <button id="convertBtn"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {!! __tool('avif-to-jpg-converter', 'result.btn_download') !!}
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
            const convertBtn = document.getElementById('convertBtn');
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
                imagePreview.src = '';
            });

            function handleFile(file) {
                if (!file.type.match('image/avif')) {
                    alert('Please upload a valid AVIF image.');
                    return;
                }
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

                    // Fill white background for JPG (no transparency)
                    ctx.fillStyle = '#FFFFFF';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    ctx.drawImage(img, 0, 0);

                    // Convert to JPG
                    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);

                    // Download
                    const link = document.createElement('a');
                    link.download = 'converted-image.jpg';
                    link.href = dataUrl;
                    link.click();
                };
            });
        </script>
    @endpush
@endsection