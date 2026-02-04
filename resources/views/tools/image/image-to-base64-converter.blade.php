@extends('layouts.app')

@section('title', __tool('image-to-base64-converter', 'meta.title'))
@section('meta_description', __tool('image-to-base64-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-to-base64-converter', 'input.title')"
            :description="__tool('image-to-base64-converter', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-to-base64-converter', 'input.drop_title')" :subtitle="__tool('image-to-base64-converter', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-2 gap-8">
                <!-- Left Column: Image Preview -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 min-h-[300px]">
                    <img id="imagePreview" class="max-h-[400px] max-w-full object-contain rounded-lg shadow-sm" src=""
                        alt="{!! __tool('image-to-base64-converter', 'editor.image_alt') !!}">
                </div>

                <!-- Right Column: Output -->
                <div class="flex flex-col space-y-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label
                                class="block text-sm font-bold text-gray-700">{!! __tool('image-to-base64-converter', 'editor.label_string') !!}</label>
                            <button id="copyBtn"
                                class="text-indigo-600 hover:text-indigo-800 font-bold text-xs uppercase tracking-wider flex items-center gap-1 bg-indigo-50 px-2 py-1 rounded transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                                {!! __tool('image-to-base64-converter', 'editor.btn_copy') !!}
                            </button>
                        </div>
                        <textarea id="base64Output" readonly
                            class="w-full h-48 bg-gray-50 border border-gray-200 rounded-xl p-4 font-mono text-xs text-gray-600 focus:border-indigo-500 focus:ring-0 resize-none shadow-inner"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                            <span
                                class="block text-xs font-bold text-gray-500 uppercase mb-1">{!! __tool('image-to-base64-converter', 'editor.char_count') !!}</span>
                            <span id="charCount" class="text-xl font-black text-indigo-600">0</span>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                            <span
                                class="block text-xs font-bold text-gray-500 uppercase mb-1">{!! __tool('image-to-base64-converter', 'editor.mime_type') !!}</span>
                            <span id="mimeType" class="text-xl font-black text-green-600">-</span>
                        </div>
                    </div>

                    <button id="uploadNewBtn"
                        class="text-gray-500 hover:text-indigo-600 font-medium transition-colors text-sm text-center w-full py-2">
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
            const base64Output = document.getElementById('base64Output');
            const charCount = document.getElementById('charCount');
            const mimeType = document.getElementById('mimeType');
            const copyBtn = document.getElementById('copyBtn');
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
                base64Output.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            function handleFile(file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const result = e.target.result;
                    imagePreview.src = result;
                    base64Output.value = result;
                    charCount.innerText = result.length.toLocaleString();
                    mimeType.innerText = result.match(/:(.*?);/) ? result.match(/:(.*?);/)[1] : 'unknown';
                    dropZone.classList.add('hidden');
                    editorArea.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }

            copyBtn.addEventListener('click', () => {
                base64Output.select();
                document.execCommand('copy');
                const originalText = copyBtn.innerHTML;
                copyBtn.innerText = '{!! __tool('image-to-base64-converter', 'js.copied') !!}';
                setTimeout(() => { copyBtn.innerHTML = originalText; }, 2000);
            });
        </script>
    @endpush
@endsection