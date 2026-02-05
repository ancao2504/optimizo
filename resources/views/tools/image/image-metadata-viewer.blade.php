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

        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Intro Section -->
            <section class="max-w-5xl mx-auto text-center relative">
                <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(99,102,241,0.15)_0%,rgba(255,255,255,0)_70%)] blur-3xl"></div>
                
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 shadow-sm mb-10 transition-transform hover:scale-105 cursor-default">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-xs font-bold tracking-wide uppercase text-indigo-700">Detailed Analysis</span>
                </div>

                <h2 class="text-5xl md:text-7xl font-black text-gray-900 mb-8 tracking-tight leading-[1.1] drop-shadow-sm">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-gray-900 via-indigo-900 to-indigo-800">
                        {{ __tool('image-metadata-viewer', 'content.intro.title') ?: 'View Hidden Image Metadata' }}
                    </span>
                </h2>
                
                <p class="text-xl md:text-2xl text-gray-600 mb-14 leading-relaxed font-light max-w-3xl mx-auto">
                    {{ __tool('image-metadata-viewer', 'content.intro.subtitle') }}
                </p>
            </section>

            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-3 block">Why Use This Tool?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('image-metadata-viewer', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Uncover the details behind your photos.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('image-metadata-viewer', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('image-metadata-viewer', "content.features.f{$i}_desc") }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- How-to Section -->
             <section class="max-w-5xl mx-auto bg-gray-900 text-white rounded-[3rem] p-8 md:p-16 border border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-600/20 rounded-full blur-[80px] -ml-16 -mb-16"></div>

                <div class="relative z-10 text-center mb-16">
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('image-metadata-viewer', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">See EXIF data instantly.</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('image-metadata-viewer', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg shadow-indigo-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('image-metadata-viewer', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('image-metadata-viewer', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('image-metadata-viewer', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('image-metadata-viewer', "content.faq.a$i"); @endphp
                                        @if(is_array($a))
                                            <ul class="list-disc pl-4 space-y-2">@foreach($a as $item) <li>{{ $item }}</li> @endforeach</ul>
                                        @else
                                            {{ $a }}
                                        @endif
                                    </div>
                                </details>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        </div>
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