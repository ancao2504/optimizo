@extends('layouts.app')

@section('title', __tool('png-to-heic-converter', 'meta.title'))
@section('meta_description', __tool('png-to-heic-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('png-to-heic-converter', 'input.title')"
            :description="__tool('png-to-heic-converter', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/png" :title="__tool('png-to-heic-converter', 'input.drop_title')" :subtitle="__tool('png-to-heic-converter', 'input.drop_desc')" />

            <!-- Loading State -->
            <div id="loadingIndicator" class="hidden py-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 rounded-full mb-6 relative">
                    <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">{!! __tool('png-to-heic-converter', 'loading.title') !!}
                </h3>
                <p class="text-gray-500">{!! __tool('png-to-heic-converter', 'loading.desc') !!}</p>
            </div>

            <!-- Result Area -->
            <div id="resultArea" class="hidden mt-8 text-center animate-fade-in">
                <div class="bg-indigo-50 rounded-2xl p-8 max-w-md mx-auto border border-indigo-100 shadow-sm">
                    <div
                        class="w-20 h-20 bg-white text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-md">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Conversion Successful!</h3>
                    <p class="text-gray-600 mb-8 leading-relaxed">Your PNG file has been converted to HEIC format.</p>

                    <a id="downloadLink" href="#"
                        class="w-full inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-bold rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {!! __tool('png-to-heic-converter', 'result.btn_download') !!}
                    </a>
                </div>

                <button id="uploadNewBtn" class="mt-8 text-gray-500 hover:text-indigo-600 font-medium transition-colors">
                    Convert Another Image
                </button>
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
            const uploadNewBtn = document.getElementById('uploadNewBtn');

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
            });

            function processFile(file) {
                if (!file.type.match('image/png')) {
                    alert('Please upload a valid PNG image.');
                    return;
                }

                // Show loading
                dropZone.classList.add('hidden');
                loadingIndicator.classList.remove('hidden');
                resultArea.classList.add('hidden');

                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('image.png-to-heic-converter.convert') }}', {
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
                            alert(data.message || '{!! __tool('png-to-heic-converter', 'js.error_conversion') !!}');
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