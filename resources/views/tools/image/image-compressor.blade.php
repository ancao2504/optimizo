@extends('layouts.app')

@section('title', __tool('image-compressor', 'meta.title'))
@section('meta_description', __tool('image-compressor', 'meta.description'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-compressor', 'editor.title_original')"
            :description="__tool('image-compressor', 'editor.drop_subtitle')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-compressor', 'editor.drop_title')" :subtitle="__tool('image-compressor', 'editor.drop_subtitle')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid md:grid-cols-2 gap-8">
                <!-- Original Image -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 flex flex-col items-center">
                    <h3 class="font-bold text-gray-800 mb-4">{{ __tool('image-compressor', 'editor.title_original') }}</h3>
                    <div class="flex-grow flex items-center justify-center w-full mb-4 min-h-[200px]">
                        <img id="originalImage" class="max-w-full max-h-[300px] object-contain rounded-lg shadow-sm" src="">
                    </div>
                    <p
                        class="text-sm font-medium text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm">
                        {{ __tool('image-compressor', 'editor.label_size') }} <span id="originalSize"
                            class="text-gray-900 font-bold"></span>
                    </p>
                </div>

                <!-- Compressed Image -->
                <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100 flex flex-col items-center relative">
                    <div class="absolute top-4 right-4 bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-xs border border-green-200 shadow-sm"
                        id="savedInfo">
                        {{ __tool('image-compressor', 'editor.label_saved') }} <span id="savedSize">0%</span>
                    </div>

                    <h3 class="font-bold text-indigo-900 mb-4">{{ __tool('image-compressor', 'editor.title_compressed') }}
                    </h3>
                    <div class="flex-grow flex items-center justify-center w-full mb-4 min-h-[200px]">
                        <img id="compressedImage" class="max-w-full max-h-[300px] object-contain rounded-lg shadow-sm"
                            src="">
                    </div>

                    <p
                        class="text-sm font-medium text-indigo-500 bg-white px-3 py-1 rounded-full border border-indigo-200 mb-6 shadow-sm">
                        {{ __tool('image-compressor', 'editor.label_size') }} <span id="compressedSize"
                            class="text-indigo-900 font-bold"></span>
                    </p>

                    <!-- Quality Slider -->
                    <div class="w-full bg-white p-5 rounded-xl border border-indigo-100 mb-6 shadow-sm">
                        <div class="flex justify-between items-center mb-3">
                            <label
                                class="text-sm font-bold text-gray-700">{{ __tool('image-compressor', 'editor.label_quality') }}</label>
                            <span id="qualityValue"
                                class="text-indigo-600 font-bold bg-indigo-50 px-2 py-1 rounded">80%</span>
                        </div>
                        <input type="range" id="qualitySlider" min="10" max="100" value="80"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {{ __tool('image-compressor', 'editor.btn_download') }}
                    </button>
                </div>
            </div>

            <div id="resetContainer" class="hidden text-center mt-8">
                <button id="uploadNewBtn"
                    class="text-gray-500 hover:text-indigo-600 font-bold transition-colors inline-flex items-center gap-2 bg-white px-4 py-2 rounded-lg border border-gray-200 hover:border-indigo-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                        </path>
                    </svg>
                    Compress Another Image
                </button>
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
                    <span class="text-xs font-bold tracking-wide uppercase text-indigo-700">Size Optimization</span>
                </div>

                <h2 class="text-5xl md:text-7xl font-black text-gray-900 mb-8 tracking-tight leading-[1.1] drop-shadow-sm">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-gray-900 via-indigo-900 to-indigo-800">
                        {{ __tool('image-compressor', 'content.intro.title') ?: 'Compress Images Without Quality Loss' }}
                    </span>
                </h2>
                
                <p class="text-xl md:text-2xl text-gray-600 mb-14 leading-relaxed font-light max-w-3xl mx-auto">
                    {{ __tool('image-compressor', 'content.intro.subtitle') }}
                </p>
            </section>

            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-3 block">Why Use This Tool?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('image-compressor', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Efficient compression for faster websites.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('image-compressor', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('image-compressor', "content.features.f{$i}_desc") }}</p>
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
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('image-compressor', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">Simple steps to smaller files.</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('image-compressor', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg shadow-indigo-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('image-compressor', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('image-compressor', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('image-compressor', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('image-compressor', "content.faq.a$i"); @endphp
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
            const resetContainer = document.getElementById('resetContainer');

            const originalImage = document.getElementById('originalImage');
            const compressedImage = document.getElementById('compressedImage');
            const originalSize = document.getElementById('originalSize');
            const compressedSize = document.getElementById('compressedSize');
            const savedSize = document.getElementById('savedSize');

            const qualitySlider = document.getElementById('qualitySlider');
            const qualityValue = document.getElementById('qualityValue');
            const downloadBtn = document.getElementById('downloadBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            let originalFile = null;
            let compressedBlob = null;

            // Drag & Drop
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50');
                if (e.dataTransfer.files[0]) handleFile(e.dataTransfer.files[0]);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files[0]) handleFile(e.target.files[0]); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.value = '';
                editorArea.classList.add('hidden');
                resetContainer.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            qualitySlider.addEventListener('input', (e) => {
                qualityValue.innerText = e.target.value + '%';
                // Debounce slightly or just run
                compressImage(originalImage.src, e.target.value);
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('Invalid image'); return; }
                originalFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    originalImage.src = e.target.result;
                    originalSize.textContent = formatFileSize(file.size);

                    dropZone.classList.add('hidden');
                    editorArea.classList.remove('hidden');
                    resetContainer.classList.remove('hidden');

                    // Initial Compress
                    compressImage(e.target.result, 80);
                };
                reader.readAsDataURL(file);
            }

            function compressImage(src, quality) {
                const img = new Image();
                img.onload = function () {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);

                    canvas.toBlob((blob) => {
                        compressedBlob = blob;
                        const url = URL.createObjectURL(blob);
                        compressedImage.src = url;
                        compressedSize.textContent = formatFileSize(blob.size);

                        const savedBytes = originalFile.size - blob.size;
                        const savedPercent = ((savedBytes / originalFile.size) * 100).toFixed(1);
                        savedSize.textContent = savedPercent > 0 ? `-${savedPercent}%` : '0%';

                    }, 'image/jpeg', quality / 100);
                };
                img.src = src;
            }

            function formatFileSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / 1048576).toFixed(2) + ' MB';
            }

            downloadBtn.addEventListener('click', () => {
                if (!compressedBlob) return;
                const url = URL.createObjectURL(compressedBlob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'compressed-' + (originalFile.name || 'image.jpg');
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            });
        </script>
    @endpush
@endsection