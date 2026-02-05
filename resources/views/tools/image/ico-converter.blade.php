@extends('layouts.app')

@section('title', __tool('ico-converter', 'meta.title'))
@section('meta_description', __tool('ico-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />


            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/png, image/jpeg, image/jpg"
                :title="__tool('ico-converter', 'input.drop_title')" :subtitle="__tool('ico-converter', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Left Column: Preview Area -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex flex-col items-center justify-center border border-gray-100 min-h-[400px] space-y-6">
                    <div class="flex items-center justify-center gap-8">
                        <div>
                            <p class="text-xs text-gray-500 mb-2 text-center uppercase tracking-wider font-bold">
                                {!! __tool('ico-converter', 'editor.original') !!}
                            </p>
                            <img id="imagePreview" class="h-24 w-auto rounded-lg shadow-sm border border-gray-200" src=""
                                alt="{!! __tool('ico-converter', 'editor.image_alt') !!}">
                        </div>
                        <div class="text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-2 text-center uppercase tracking-wider font-bold">
                                {!! __tool('ico-converter', 'editor.favicon') !!}
                            </p>
                            <div
                                class="w-24 h-24 flex items-center justify-center bg-white border border-gray-200 rounded-lg shadow-sm">
                                <canvas id="faviconCanvas" width="32" height="32"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Settings & Actions -->
                <div class="flex flex-col justify-center space-y-6">
                    <div class="w-full bg-white border border-gray-100 rounded-xl p-6 shadow-sm">
                        <label
                            class="block text-sm font-bold text-gray-700 mb-4">{!! __tool('ico-converter', 'editor.size_label') !!}</label>
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button"
                                class="size-btn px-4 py-3 border-2 border-amber-500 bg-amber-50 text-amber-700 font-bold rounded-xl transition-all"
                                data-size="32">32x32</button>
                            <button type="button"
                                class="size-btn px-4 py-3 border-2 border-transparent bg-gray-50 text-gray-600 font-medium rounded-xl hover:bg-gray-100 transition-all"
                                data-size="64">64x64</button>
                            <button type="button"
                                class="size-btn px-4 py-3 border-2 border-transparent bg-gray-50 text-gray-600 font-medium rounded-xl hover:bg-gray-100 transition-all"
                                data-size="128">128x128</button>
                        </div>
                        <input type="hidden" id="selectedSize" value="32">
                    </div>

                    <div class="text-center text-gray-600 font-medium">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 bg-amber-50 text-amber-600 rounded-full mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <p>{!! __tool('ico-converter', 'editor.output_format') !!} <span
                                class="font-bold text-amber-600">ICO</span></p>
                    </div>

                    <button id="convertBtn"
                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {!! __tool('ico-converter', 'editor.btn_download') !!}
                    </button>

                    <button id="uploadNewBtn"
                        class="text-gray-500 hover:text-amber-600 font-medium transition-colors text-sm text-center">
                        Upload New Image
                    </button>
                </div>
            </div>


        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-amber-600 font-bold tracking-widest uppercase text-sm mb-3 block">Why Use This Tool?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('ico-converter', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Create perfect favicons instantly.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('ico-converter', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('ico-converter', "content.features.f{$i}_desc") }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- How-to Section -->
             <section class="max-w-5xl mx-auto bg-gray-900 text-white rounded-[3rem] p-8 md:p-16 border border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-amber-600/20 rounded-full blur-[100px] -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-orange-600/20 rounded-full blur-[80px] -ml-16 -mb-16"></div>

                <div class="relative z-10 text-center mb-16">
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('ico-converter', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">Generate icons in simple steps.</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('ico-converter', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-amber-600 text-white font-bold text-lg shadow-lg shadow-amber-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('ico-converter', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('ico-converter', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('ico-converter', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-amber-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('ico-converter', "content.faq.a$i"); @endphp
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
            const editorArea = document.getElementById('editorArea');
            const imagePreview = document.getElementById('imagePreview');
            const convertBtn = document.getElementById('convertBtn');
            const faviconCanvas = document.getElementById('faviconCanvas');
            const ctx = faviconCanvas.getContext('2d');
            const sizeBtns = document.querySelectorAll('.size-btn');
            const selectedSizeInput = document.getElementById('selectedSize');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            let currentImg = new Image();

            // Size Selection
            sizeBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    sizeBtns.forEach(b => {
                        b.classList.remove('border-amber-500', 'bg-amber-50', 'text-amber-700', 'font-bold');
                        b.classList.add('border-transparent', 'bg-gray-50', 'text-gray-600', 'font-medium');
                    });
                    btn.classList.add('border-amber-500', 'bg-amber-50', 'text-amber-700', 'font-bold');
                    btn.classList.remove('border-transparent', 'bg-gray-50', 'text-gray-600', 'font-medium');

                    const size = parseInt(btn.dataset.size);
                    selectedSizeInput.value = size;
                    faviconCanvas.width = size;
                    faviconCanvas.height = size;
                    updateCanvas();
                });
            });

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-amber-500', 'bg-amber-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-amber-500', 'bg-amber-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-amber-500', 'bg-amber-50/50');
                if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('{!! __tool('ico-converter', 'js.invalid_image') !!}'); return; }
                const reader = new FileReader();
                reader.onload = (e) => {
                    currentImg = new Image();
                    currentImg.src = e.target.result;
                    imagePreview.src = e.target.result;
                    currentImg.onload = updateCanvas;
                    editorArea.classList.remove('hidden');
                    dropZone.classList.add('hidden');
                };
                reader.readAsDataURL(file);
            }

            function updateCanvas() {
                if (!currentImg.src) return;
                ctx.clearRect(0, 0, faviconCanvas.width, faviconCanvas.height);
                ctx.drawImage(currentImg, 0, 0, faviconCanvas.width, faviconCanvas.height);
            }

            convertBtn.addEventListener('click', () => {
                const dataUrl = faviconCanvas.toDataURL('image/png');
                const link = document.createElement('a');
                link.download = 'favicon.ico';
                link.href = dataUrl;
                link.click();
            });
        </script>
    @endpush
@endsection