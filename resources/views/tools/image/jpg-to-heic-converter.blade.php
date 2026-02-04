@extends('layouts.app')

@section('title', __tool('jpg-to-heic-converter', 'meta.title'))
@section('meta_description', __tool('jpg-to-heic-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('jpg-to-heic-converter', 'input.title')"
            :description="__tool('jpg-to-heic-converter', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/jpeg, image/jpg"
                :title="__tool('jpg-to-heic-converter', 'input.drop_title')" :subtitle="__tool('jpg-to-heic-converter', 'input.drop_desc')" />

            <!-- Loading State -->
            <div id="loadingIndicator" class="hidden py-12 text-center">
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
                <h3 class="text-xl font-bold text-gray-900 mb-2">{!! __tool('jpg-to-heic-converter', 'loading.title') !!}
                </h3>
                <p class="text-gray-500">{!! __tool('jpg-to-heic-converter', 'loading.desc') !!}</p>
            </div>

            <!-- Result Area -->
            <div id="resultArea" class="hidden py-12 text-center max-w-lg mx-auto">
                <div
                    class="bg-gradient-to-br from-indigo-50 to-white rounded-3xl p-10 border border-indigo-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 -mt-8 -mr-8 w-32 h-32 bg-indigo-100 rounded-full opacity-50 blur-2xl">
                    </div>

                    <div
                        class="w-20 h-20 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-sm relative z-10">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-black text-gray-900 mb-2 relative z-10">Conversion Successful!</h3>
                    <p class="text-gray-500 mb-8 relative z-10">Your image has been converted to high-efficiency HEIC
                        format.</p>

                    <a id="downloadLink" href="#"
                        class="inline-flex items-center justify-center w-full px-8 py-4 border border-transparent text-lg font-bold rounded-2xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 relative z-10">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {!! __tool('jpg-to-heic-converter', 'result.btn_download') !!}
                    </a>

                    <button id="convertAnother"
                        class="mt-6 text-gray-500 hover:text-indigo-600 font-bold text-sm transition-colors relative z-10">
                        Convert Another Image
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
            const resultArea = document.getElementById('resultArea');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const downloadLink = document.getElementById('downloadLink');
            const convertAnother = document.getElementById('convertAnother');

            imageInput.addEventListener('change', (e) => {
                if (e.target.files[0]) processFile(e.target.files[0]);
            });

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50');
                if (e.dataTransfer.files[0]) processFile(e.dataTransfer.files[0]);
            });

            convertAnother.addEventListener('click', () => {
                imageInput.value = '';
                resultArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            function processFile(file) {
                if (!file.type.match('image/jp.*')) {
                    alert('Please upload a valid JPG image.');
                    return;
                }

                // Show loading
                dropZone.classList.add('hidden');
                loadingIndicator.classList.remove('hidden');
                resultArea.classList.add('hidden');

                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('image.jpg-to-heic-converter.convert') }}', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        loadingIndicator.classList.add('hidden');
                        if (data.success) {
                            downloadLink.href = data.download_url;
                            resultArea.classList.remove('hidden');
                        } else {
                            dropZone.classList.remove('hidden');
                            alert(data.message || '{!! __tool('jpg-to-heic-converter', 'js.error_conversion') !!}');
                        }
                    })
                    .catch(error => {
                        loadingIndicator.classList.add('hidden');
                        dropZone.classList.remove('hidden');
                        console.error('Error:', error);
                        alert('An error occurred during conversion.');
                    });
            }
        </script>
    @endpush
@endsection