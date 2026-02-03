@extends('layouts.app')

@section('title', __tool('image-metadata-viewer', 'meta.title'))
@section('meta_description', __tool('image-metadata-viewer', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{!! __tool('image-metadata-viewer', 'input.title') !!}
                </h2>
                <p class="text-gray-600">{!! __tool('image-metadata-viewer', 'input.desc') !!}</p>
            </div>

            <!-- Upload Area -->
            <div id="dropZone"
                class="border-3 border-dashed border-indigo-200 rounded-2xl p-8 hover:border-indigo-400 hover:bg-indigo-50 transition-all cursor-pointer text-center relative group">
                <input type="file" id="imageInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    accept="image/*">
                <div class="space-y-4 pointer-events-none">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">
                            {!! __tool('image-metadata-viewer', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">{!! __tool('image-metadata-viewer', 'input.drop_desc') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div id="loadingState" class="hidden text-center py-12">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-indigo-600 mx-auto mb-4"></div>
                <p class="text-gray-600 font-medium">Extracting EXIF data...</p>
            </div>

            <!-- Result Area -->
            <div id="resultArea" class="hidden mt-8">
                <div class="bg-indigo-50 rounded-xl p-6 border border-indigo-100 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Image Metadata
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 bg-indigo-100 font-semibold text-gray-700 rounded-tl-lg">Property
                                    </th>
                                    <th class="py-3 px-4 bg-indigo-100 font-semibold text-gray-700 rounded-tr-lg">Value</th>
                                </tr>
                            </thead>
                            <tbody id="metadataTableBody" class="text-sm text-gray-600 divide-y divide-gray-200 bg-white">
                                <!-- Rows will be inserted here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <button id="uploadNewBtn"
                    class="w-full bg-white border border-gray-300 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-50 transition-all">
                    Check Another Image
                </button>
            </div>
        </div>

        <x-tool-content :tool="$tool" />
    </div>

    @push('scripts')
        <script>
            const imageInput = document.getElementById('imageInput');
            const dropZone = document.getElementById('dropZone');
            const loadingState = document.getElementById('loadingState');
            const resultArea = document.getElementById('resultArea');
            const tableBody = document.getElementById('metadataTableBody');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            // CSRF Token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                if (e.dataTransfer.files[0]) processFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) processFile(e.target.files[0]); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                resultArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
                tableBody.innerHTML = '';
            });

            function processFile(file) {
                const formData = new FormData();
                formData.append('file', file);

                dropZone.classList.add('hidden');
                loadingState.classList.remove('hidden');

                fetch('{{ route('image.image-metadata-viewer.process') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        loadingState.classList.add('hidden');
                        resultArea.classList.remove('hidden');

                        let rows = '';
                        if (Object.keys(data).length === 0) {
                            rows = '<tr><td colspan="2" class="py-4 px-4 text-center">No metadata found.</td></tr>';
                        } else {
                            for (const [key, value] of Object.entries(data)) {
                                rows += `
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-3 px-4 font-medium text-gray-800 border-r border-gray-100 w-1/3 break-words">${key}</td>
                                            <td class="py-3 px-4 break-all">${value}</td>
                                        </tr>
                                    `;
                            }
                        }
                        tableBody.innerHTML = rows;
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