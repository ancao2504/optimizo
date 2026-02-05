@extends('layouts.app')

@section('title', __tool('image-sharpener', 'meta.title'))
@section('meta_description', __tool('image-sharpener', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />


            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-sharpener', 'input.drop_title')" :subtitle="__tool('image-sharpener', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Canvas -->
                <div
                    class="lg:col-span-2 bg-gray-50 rounded-2xl p-4 flex items-center justify-center border border-gray-100 relative min-h-[400px]">
                    <canvas id="imageCanvas" class="max-w-full rounded shadow-sm"></canvas>
                </div>

                <!-- Right Column: Settings -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-gray-50 p-6 rounded-2xl border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4 text-lg">{!! __tool('image-sharpener', 'settings.title') !!}
                        </h3>

                        <!-- Sharpness Strength -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <label for="sharpnessRange" class="text-sm font-bold text-gray-700">Strength</label>
                                <span id="sharpnessVal" class="text-sm font-bold text-indigo-600">50%</span>
                            </div>
                            <input type="range" id="sharpnessRange" min="0" max="100" value="50"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                        </div>

                        <div class="flex gap-3">
                            <button id="resetBtn"
                                class="flex-1 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">Reset</button>
                            <button id="applyBtn"
                                class="flex-1 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-colors shadow-md">Apply</button>
                        </div>
                        <p class="text-xs text-gray-400 mt-4 text-center">Processing large images may take a specific
                            moment.</p>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Sharpened Image
                    </button>

                    <button id="uploadNewBtn"
                        class="text-center text-gray-500 hover:text-indigo-600 font-medium transition-colors text-sm">
                        Process Another Image
                    </button>
                </div>
            </div>


        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-3 block">Why Use This Tool?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('image-sharpener', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Restore details and clarity instantly.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('image-sharpener', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('image-sharpener', "content.features.f{$i}_desc") }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- How-to Section -->
             <section class="max-w-5xl mx-auto bg-gray-900 text-white rounded-[3rem] p-8 md:p-16 border border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-violet-600/20 rounded-full blur-[80px] -ml-16 -mb-16"></div>

                <div class="relative z-10 text-center mb-16">
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('image-sharpener', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">Fix blur in seconds.</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('image-sharpener', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg shadow-indigo-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('image-sharpener', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('image-sharpener', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('image-sharpener', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('image-sharpener', "content.faq.a$i"); @endphp
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
            const canvas = document.getElementById('imageCanvas');
            const ctx = canvas.getContext('2d');

            const sharpnessRange = document.getElementById('sharpnessRange');
            const sharpnessVal = document.getElementById('sharpnessVal');
            const applyBtn = document.getElementById('applyBtn');
            const resetBtn = document.getElementById('resetBtn');
            const downloadBtn = document.getElementById('downloadBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

            let originalImg = new Image();

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
                dropZone.classList.remove('hidden');
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('Invalid image'); return; }
                const reader = new FileReader();
                reader.onload = (e) => { originalImg.src = e.target.result; };
                reader.readAsDataURL(file);
            }

            originalImg.onload = () => {
                canvas.width = originalImg.width;
                canvas.height = originalImg.height;
                ctx.drawImage(originalImg, 0, 0);

                dropZone.classList.add('hidden');
                editorArea.classList.remove('hidden');
            };

            sharpnessRange.addEventListener('input', (e) => {
                sharpnessVal.textContent = e.target.value + '%';
            });

            applyBtn.addEventListener('click', () => {
                const originalText = applyBtn.innerText;
                applyBtn.innerText = 'Processing...';
                applyBtn.disabled = true;

                setTimeout(() => {
                    applySharpen();
                    applyBtn.innerText = originalText;
                    applyBtn.disabled = false;
                }, 50);
            });

            resetBtn.addEventListener('click', () => {
                ctx.drawImage(originalImg, 0, 0);
                sharpnessRange.value = 50;
                sharpnessVal.textContent = '50%';
            });

            function applySharpen() {
                // Ensure we start from original to prevent cumulative processing
                ctx.drawImage(originalImg, 0, 0);

                const w = canvas.width;
                const h = canvas.height;
                const imageData = ctx.getImageData(0, 0, w, h);
                const data = imageData.data;
                const mix = parseInt(sharpnessRange.value) / 100 * 2.0;

                const output = ctx.createImageData(w, h);
                const dst = output.data;

                // Simple sharpening kernel
                for (let y = 1; y < h - 1; y++) {
                    for (let x = 1; x < w - 1; x++) {
                        const i = (y * w + x) * 4;

                        // Offsets
                        const top = i - w * 4;
                        const bottom = i + w * 4;
                        const left = i - 4;
                        const right = i + 4;

                        for (let c = 0; c < 3; c++) {
                            const val = data[i + c] * 5
                                - data[top + c]
                                - data[bottom + c]
                                - data[left + c]
                                - data[right + c];

                            dst[i + c] = Math.min(255, Math.max(0, data[i + c] * (1 - mix) + val * mix));
                        }
                        dst[i + 3] = 255;
                    }
                }

                ctx.putImageData(output, 0, 0);
            }

            downloadBtn.addEventListener('click', () => {
                const link = document.createElement('a');
                link.download = 'sharpened-image.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        </script>
    @endpush
@endsection