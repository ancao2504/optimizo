@extends('layouts.app')

@section('title', __tool('image-metadata-remover', 'meta.title'))
@section('meta_description', __tool('image-metadata-remover', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-metadata-remover', 'input.title')"
            :description="__tool('image-metadata-remover', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-metadata-remover', 'input.drop_title')" :subtitle="__tool('image-metadata-remover', 'input.drop_desc')" />

            <!-- Loading State -->
            <div id="loadingState" class="hidden text-center py-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 rounded-full mb-6 relative">
                    <div class="absolute inset-0 rounded-full border-4 border-indigo-100"></div>
                    <div class="absolute inset-0 rounded-full border-4 border-indigo-500 border-t-transparent animate-spin">
                    </div>
                    <svg class="w-6 h-6 text-indigo-600 relative z-10" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                        </path>
                    </svg>
                </div>
                <p class="text-gray-600 font-medium text-lg">Removing Metadata...</p>
            </div>

            <!-- Result Area -->
            <div id="resultArea" class="hidden mt-8 text-center max-w-xl mx-auto animate-fade-in">
                <div
                    class="bg-gradient-to-br from-indigo-50 to-white rounded-3xl p-10 border border-indigo-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden mb-8">
                    <div
                        class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-indigo-100 rounded-full opacity-50 blur-2xl">
                    </div>

                    <div
                        class="mx-auto w-20 h-20 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-sm relative z-10">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-black text-gray-900 mb-2 relative z-10">Metadata Removed!</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed relative z-10">Your image has been scrubbed of all EXIF
                        data, GPS
                        location, and camera settings.</p>

                    <a id="downloadLink" href="#"
                        class="w-full inline-flex justify-center items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all text-lg relative z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Clean Image
                    </a>
                </div>

                <button id="uploadNewBtn" class="text-gray-500 hover:text-indigo-600 font-bold transition-colors">
                    Remove Metadata from Another Image
                </button>
            </div>
        </x-tool-ui-card>

        <x-tool-content :tool="$tool" />
    </div>

    @push('scripts')
        <script>
            const imageInput = document.getElementById('imageInput');
            const dropZone = document.getElementById('dropZone');
            const loadingState = document.getElementById('loadingState');
            const resultArea = document.getElementById('resultArea');
            const downloadLink = document.getElementById('downloadLink');
            const uploadNewBtn = document.getElementById('uploadNewBtn');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50');
                if (e.dataTransfer.files[0]) processFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) processFile(e.target.files[0]); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                resultArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
                downloadLink.href = '#';
            });

            function processFile(file) {
                const formData = new FormData();
                formData.append('file', file);

                dropZone.classList.add('hidden');
                loadingState.classList.remove('hidden');

                fetch('{{ route('image.image-metadata-remover.process') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        loadingState.classList.add('hidden');
                        if (data.download_url) {
                            downloadLink.href = data.download_url;
                            downloadLink.download = data.filename;
                            resultArea.classList.remove('hidden');
                        } else {
                            dropZone.classList.remove('hidden');
                            alert('Something went wrong. Please try again.');
                        }
                    })
                    .catch(error => {
                        loadingState.classList.add('hidden');
                        dropZone.classList.remove('hidden');
                        alert('Error processing file. Please try again.');
                        console.error(error);
                    });
            }
        </script>
    @endpush
@endsection