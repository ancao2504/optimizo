@extends('layouts.app')

@section('title', __tool('image-lazy-load-generator', 'meta.title'))
@section('meta_description', __tool('image-lazy-load-generator', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('image-lazy-load-generator', 'input.title')"
            :description="__tool('image-lazy-load-generator', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-lazy-load-generator', 'input.drop_title')" :subtitle="__tool('image-lazy-load-generator', 'input.drop_desc')" />

            <!-- Editor/Result Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-2 gap-8">
                <!-- Left Column: Settings & Preview -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-4 text-lg border-b border-gray-100 pb-3">
                            {!! __tool('image-lazy-load-generator', 'settings.title') !!}
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Placeholder Style</label>
                                <select id="styleSelect"
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                                    <option value="lqip">Low Quality Image Placeholder (LQIP)</option>
                                    <option value="color">Dominant Color</option>
                                    <option value="blur">Blurred</option>
                                </select>
                            </div>

                            <div id="qualityControl">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Blur Amount</label>
                                <input type="range" id="blurRange" min="0" max="20" value="10"
                                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-50 rounded-2xl p-6 border border-gray-100 shadow-inner flex flex-col items-center justify-center">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Preview</h4>
                        <img id="previewImg"
                            class="max-w-full rounded shadow-sm border border-gray-200 w-full object-cover" />
                        <p class="text-xs text-indigo-600 font-mono mt-3 bg-white px-3 py-1 rounded-full border border-gray-200 shadow-sm"
                            id="previewSize">Size: 0kb</p>
                    </div>
                </div>

                <!-- Right Column: Code Output -->
                <div class="flex flex-col space-y-6">
                    <h3 class="font-bold text-gray-900 text-lg">Generated Code</h3>

                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">HTML Code</label>
                        <textarea id="htmlOutput"
                            class="w-full h-32 rounded-xl border-gray-200 font-mono text-xs bg-gray-900 text-gray-300 p-4 focus:ring-indigo-500 focus:border-indigo-500"
                            readonly></textarea>
                        <button
                            class="absolute top-9 right-3 bg-white/10 hover:bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors copy-btn backdrop-blur-sm"
                            data-target="htmlOutput">Copy</button>
                    </div>

                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">CSS</label>
                        <textarea id="cssOutput"
                            class="w-full h-24 rounded-xl border-gray-200 font-mono text-xs bg-gray-900 text-gray-300 p-4"
                            readonly>.lazy { opacity: 0; transition: opacity 0.3s; }
    .lazy.loaded { opacity: 1; }</textarea>
                        <button
                            class="absolute top-9 right-3 bg-white/10 hover:bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors copy-btn backdrop-blur-sm"
                            data-target="cssOutput">Copy</button>
                    </div>

                    <div class="relative">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">JavaScript</label>
                        <textarea id="jsOutput"
                            class="w-full h-48 rounded-xl border-gray-200 font-mono text-xs bg-gray-900 text-gray-300 p-4"
                            readonly>document.addEventListener("DOMContentLoaded", function() {
      const lazyImages = document.querySelectorAll("img.lazy");
      const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.onload = () => img.classList.add("loaded");
            observer.unobserve(img);
          }
        });
      });
      lazyImages.forEach(img => observer.observe(img));
    });</textarea>
                        <button
                            class="absolute top-9 right-3 bg-white/10 hover:bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors copy-btn backdrop-blur-sm"
                            data-target="jsOutput">Copy</button>
                    </div>

                    <button id="uploadNewBtn"
                        class="w-full bg-white border border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:bg-gray-50 hover:text-indigo-600 transition-all shadow-sm">
                        Process Another Image
                    </button>
                </div>
            </div>
        </x-tool-ui-card>

        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Intro Section -->
            <section class="max-w-5xl mx-auto text-center relative">
                <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(167,139,250,0.15)_0%,rgba(255,255,255,0)_70%)] blur-3xl"></div>
                
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-violet-50 border border-violet-100 shadow-sm mb-10 transition-transform hover:scale-105 cursor-default">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-violet-500"></span>
                    </span>
                    <span class="text-xs font-bold tracking-wide uppercase text-violet-700">Web Performance</span>
                </div>

                <h2 class="text-5xl md:text-7xl font-black text-gray-900 mb-8 tracking-tight leading-[1.1] drop-shadow-sm">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-gray-900 via-violet-800 to-fuchsia-800">
                        {{ __tool('image-lazy-load-generator', 'content.intro.title') ?: 'Generate Lazy Load Code' }}
                    </span>
                </h2>
                
                <p class="text-xl md:text-2xl text-gray-600 mb-14 leading-relaxed font-light max-w-3xl mx-auto">
                    {{ __tool('image-lazy-load-generator', 'content.intro.subtitle') }}
                </p>
            </section>

            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-violet-600 font-bold tracking-widest uppercase text-sm mb-3 block">Why Use This Tool?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('image-lazy-load-generator', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Boost your website speed significantly.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('image-lazy-load-generator', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-violet-50 text-violet-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('image-lazy-load-generator', "content.features.f{$i}_desc") }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- How-to Section -->
             <section class="max-w-5xl mx-auto bg-gray-900 text-white rounded-[3rem] p-8 md:p-16 border border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-violet-600/20 rounded-full blur-[100px] -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-fuchsia-600/20 rounded-full blur-[80px] -ml-16 -mb-16"></div>

                <div class="relative z-10 text-center mb-16">
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('image-lazy-load-generator', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">Generate optimized code in steps.</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('image-lazy-load-generator', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-violet-600 text-white font-bold text-lg shadow-lg shadow-violet-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('image-lazy-load-generator', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('image-lazy-load-generator', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('image-lazy-load-generator', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-violet-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('image-lazy-load-generator', "content.faq.a$i"); @endphp
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
            const previewImg = document.getElementById('previewImg');
            const previewSize = document.getElementById('previewSize');

            const styleSelect = document.getElementById('styleSelect');
            const blurRange = document.getElementById('blurRange');

            const htmlOutput = document.getElementById('htmlOutput');
            const uploadNewBtn = document.getElementById('uploadNewBtn');
            const copyBtns = document.querySelectorAll('.copy-btn');

            let originalFile = null;
            let originalImg = new Image();

            // Setup Canvas for LQIP generation
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

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

            styleSelect.addEventListener('change', generateCode);
            blurRange.addEventListener('input', generateCode);

            copyBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const target = document.getElementById(btn.dataset.target);
                    target.select();
                    document.execCommand('copy');
                    const originalText = btn.innerText;
                    btn.innerText = 'Copied!';
                    setTimeout(() => btn.innerText = 'Copy', 2000);
                });
            });

            function handleFile(file) {
                if (!file.type.match('image.*')) { alert('Invalid image'); return; }
                originalFile = file;
                const reader = new FileReader();
                reader.onload = (e) => {
                    originalImg.src = e.target.result;
                    originalImg.onload = () => {
                        editorArea.classList.remove('hidden');
                        dropZone.classList.add('hidden');
                        generateCode();
                    };
                };
                reader.readAsDataURL(file);
            }

            function generateCode() {
                const style = styleSelect.value;
                const blur = parseInt(blurRange.value);

                // LQIP Dimensions (Very small)
                const w = 20;
                const h = 20 * (originalImg.height / originalImg.width);

                canvas.width = w;
                canvas.height = h;

                // Draw resized image
                ctx.drawImage(originalImg, 0, 0, w, h);

                let placeholderDataUrl = '';

                if (style === 'color') {
                    // Get dominant color (average of resized image)
                    const data = ctx.getImageData(0, 0, w, h).data;
                    let r = 0, g = 0, b = 0;
                    for (let i = 0; i < data.length; i += 4) {
                        r += data[i]; g += data[i + 1]; b += data[i + 2];
                    }
                    const pxCount = data.length / 4;
                    r = Math.round(r / pxCount);
                    g = Math.round(g / pxCount);
                    b = Math.round(b / pxCount);

                    // Create 1x1 pixel with color
                    canvas.width = 1; canvas.height = 1;
                    ctx.fillStyle = `rgb(${r},${g},${b})`;
                    ctx.fillRect(0, 0, 1, 1);
                    placeholderDataUrl = canvas.toDataURL('image/png');

                } else {
                    // LQIP - use JPEG logic
                    placeholderDataUrl = canvas.toDataURL('image/jpeg', 0.5);
                }

                previewImg.src = placeholderDataUrl;
                previewImg.style.filter = (style === 'blur' || style === 'lqip') ? `blur(${blur}px)` : 'none';

                // Calculate size
                const sizeKB = (placeholderDataUrl.length * 3 / 4) / 1024;
                previewSize.textContent = `Base64 Size: ${sizeKB.toFixed(2)} KB`;

                // Generate HTML
                const imgTag = `<img src="${placeholderDataUrl}" 
              data-src="${originalFile.name}" 
              class="lazy" 
              alt="Lazy loaded image"
              width="${originalImg.width}" height="${originalImg.height}"
              style="width: 100%; height: auto; aspect-ratio: ${originalImg.width}/${originalImg.height}; ${(style === 'blur' || style === 'lqip') ? 'filter: blur(' + blur + 'px); transition: filter 0.3s;' : ''}"
              onload="this.style.filter='none'">`;

                htmlOutput.value = imgTag;
            }
        </script>
    @endpush
@endsection