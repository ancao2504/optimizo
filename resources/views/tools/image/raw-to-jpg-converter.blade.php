@extends('layouts.app')

@section('title', __tool('raw-to-jpg-converter', 'meta.title'))
@section('meta_description', __tool('raw-to-jpg-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{!! __tool('raw-to-jpg-converter', 'input.title') !!}</h2>
                <p class="text-gray-600">{!! __tool('raw-to-jpg-converter', 'input.desc') !!}</p>
            </div>

            <!-- Upload Area -->
            <div id="dropZone"
                class="border-3 border-dashed border-indigo-200 rounded-2xl p-8 hover:border-indigo-400 hover:bg-indigo-50 transition-all cursor-pointer text-center relative group">
                <input type="file" id="imageInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    accept=".cr2,.nef,.arw,.dng,.orf,.rw2,.pef,.sr2,.raf">
                <div class="space-y-4 pointer-events-none">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">
                            {!! __tool('raw-to-jpg-converter', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">{!! __tool('raw-to-jpg-converter', 'input.drop_desc') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingIndicator" class="hidden mt-8 text-center">
                <svg class="animate-spin h-10 w-10 text-indigo-600 mx-auto mb-4" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <p class="text-lg font-bold text-gray-700">{!! __tool('raw-to-jpg-converter', 'loading.title') !!}</p>
                <p class="text-sm text-gray-500">{!! __tool('raw-to-jpg-converter', 'loading.desc') !!}</p>
            </div>

            <!-- Result Area -->
            <div id="resultArea" class="hidden mt-8 text-center">
                <div class="bg-indigo-50 rounded-xl p-8 max-w-md mx-auto border border-indigo-100">
                    <div
                        class="w-16 h-16 bg-white text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Conversion Successful!</h3>
                    <p class="text-gray-600 mb-6">Your RAW photo has been developed to JPG.</p>

                    <a id="downloadLink" href="#"
                        class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition-all w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {!! __tool('raw-to-jpg-converter', 'result.btn_download') !!}
                    </a>

                    <button id="convertNewBtn" class="mt-4 text-sm text-gray-500 hover:text-indigo-600 underline">Convert
                        Another File</button>
                </div>
            </div>
        </div>

        <x-tool-content :tool="$tool" />
    </div>

    @push('scripts')
        <script>
            const imageInput = document.getElementById('imageInput');
            const dropZone = document.getElementById('dropZone');
            const resultArea = document.getElementById('resultArea');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const downloadLink = document.getElementById('downloadLink');
            const convertNewBtn = document.getElementById('convertNewBtn');

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                if (e.dataTransfer.files[0]) processFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) processFile(e.target.files[0]); });

            convertNewBtn.addEventListener('click', () => {
                resultArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
                imageInput.value = '';
            });

            function processFile(file) {
                // Show loading
                dropZone.classList.add('hidden');
                loadingIndicator.classList.remove('hidden');
                resultArea.classList.add('hidden');

                const formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route('image.raw-to-jpg-converter.convert') }}', {
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
                            alert(data.message || '{!! __tool('raw-to-jpg-converter', 'js.error_conversion') !!}');
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