@extends('layouts.app')

@section('title', __tool('image-metadata-remover', 'meta.title'))
@section('meta_description', __tool('image-metadata-remover', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />


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


        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-3 block">Why Use This Tool?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('image-metadata-remover', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Protect your privacy by cleaning image data.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('image-metadata-remover', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('image-metadata-remover', "content.features.f{$i}_desc") }}</p>
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
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('image-metadata-remover', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">Clean your images in just a few clicks.</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('image-metadata-remover', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg shadow-indigo-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('image-metadata-remover', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('image-metadata-remover', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('image-metadata-remover', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('image-metadata-remover', "content.faq.a$i"); @endphp
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