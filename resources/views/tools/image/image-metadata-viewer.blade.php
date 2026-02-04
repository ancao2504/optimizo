@extends('layouts.app')

@section('title', __tool('image-metadata-viewer', 'meta.title'))
@section('meta_description', __tool('image-metadata-viewer', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-metadata-viewer', 'input.title')"
            :description="__tool('image-metadata-viewer', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-metadata-viewer', 'input.drop_title')" :subtitle="__tool('image-metadata-viewer', 'input.drop_desc')" />

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
                <p class="text-gray-600 font-medium">Extracting EXIF data...</p>
            </div>

            <!-- Result Area -->
            <div id="resultArea" class="hidden mt-8">
                <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 mb-8 shadow-sm">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3 border-b border-gray-200 pb-4">
                        <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        Detected Metadata
                    </h3>
                    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th class="py-4 px-6 bg-gray-50 font-bold text-gray-700 border-b border-gray-200 w-1/3">
                                        Property</th>
                                    <th class="py-4 px-6 bg-gray-50 font-bold text-gray-700 border-b border-gray-200">
                                        Value</th>
                                </tr>
                            </thead>
                            <tbody id="metadataTableBody" class="text-sm text-gray-700 divide-y divide-gray-100">
                                <!-- Rows will be inserted here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="text-center">
                    <button id="uploadNewBtn"
                        class="px-8 py-4 bg-white border-2 border-indigo-100 text-indigo-600 font-bold rounded-2xl hover:bg-indigo-50 hover:border-indigo-200 transition-all shadow-sm hover:shadow-md inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Check Another Image
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
            const loadingState = document.getElementById('loadingState');
            const resultArea = document.getElementById('resultArea');
            const tableBody = document.getElementById('metadataTableBody');
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
                tableBody.innerHTML = '';
            });

            function processFile(file) {
                const formData = new FormData();
                formData.append('file', file);

                dropZone.classList.add('hidden');
                loadingState.classList.remove('hidden');

                fetch('{{ route('image.image-metadata-viewer.process') }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        loadingState.classList.add('hidden');
                        resultArea.classList.remove('hidden');

                        let rows = '';
                        if (Object.keys(data).length === 0) {
                            rows = '<tr><td colspan="2" class="py-6 px-6 text-center text-gray-500 italic">No metadata found in this image.</td></tr>';
                        } else {
                            for (const [key, value] of Object.entries(data)) {
                                rows += `
                                                        <tr class="hover:bg-indigo-50/30 transition-colors group">
                                                            <td class="py-3 px-6 font-semibold text-gray-800 border-r border-gray-100 break-words group-hover:text-indigo-700">${key}</td>
                                                            <td class="py-3 px-6 break-all text-gray-600 font-mono text-xs md:text-sm bg-gray-50/30">${value}</td>
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