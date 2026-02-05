@extends('layouts.app')

@section('title', __tool('png-to-heic-converter', 'meta.title'))
@section('meta_description', __tool('png-to-heic-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />


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
                    <p class="text-gray-500 mb-8 relative z-10">Your PNG file has been converted to HEIC format.</p>

                    <a id="downloadLink" href="#"
                        class="inline-flex items-center justify-center w-full px-8 py-4 border border-transparent text-lg font-bold rounded-2xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 relative z-10">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {!! __tool('png-to-heic-converter', 'result.btn_download') !!}
                    </a>

                    <button id="uploadNewBtn"
                        class="mt-6 text-gray-500 hover:text-indigo-600 font-bold text-sm transition-colors relative z-10">
                        Convert Another Image
                    </button>
                </div>
            </div>


        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-3 block">Why Use This Tool?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('png-to-heic-converter', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Optimized for performance and quality.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('png-to-heic-converter', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('png-to-heic-converter', "content.features.f{$i}_desc") }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- How-to Section -->
             <section class="max-w-5xl mx-auto bg-gray-900 text-white rounded-[3rem] p-8 md:p-16 border border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-600/20 rounded-full blur-[80px] -ml-16 -mb-16"></div>

                <div class="relative z-10 text-center mb-16">
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('png-to-heic-converter', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">Simple steps to high-efficiency images.</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('png-to-heic-converter', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg shadow-indigo-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('png-to-heic-converter', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('png-to-heic-converter', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('png-to-heic-converter', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('png-to-heic-converter', "content.faq.a$i"); @endphp
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