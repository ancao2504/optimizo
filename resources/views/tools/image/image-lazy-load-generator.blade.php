@extends('layouts.app')

@section('title', __tool('image-lazy-load-generator', 'meta.title'))
@section('meta_description', __tool('image-lazy-load-generator', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{!! __tool('image-lazy-load-generator', 'input.title') !!}
                </h2>
                <p class="text-gray-600">{!! __tool('image-lazy-load-generator', 'input.desc') !!}</p>
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
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">
                            {!! __tool('image-lazy-load-generator', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">{!! __tool('image-lazy-load-generator', 'input.drop_desc') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Editor/Result Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-2 gap-8">
                <!-- Left Column: Settings & Preview -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                        <h3 class="font-bold text-gray-800 mb-4">
                            {!! __tool('image-lazy-load-generator', 'settings.title') !!}</h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Placeholder Style</label>
                                <select id="styleSelect" class="w-full rounded border-gray-300">
                                    <option value="lqip">Low Quality Image Placeholder (LQIP)</option>
                                    <option value="color">Dominant Color</option>
                                    <option value="blur">Blurred</option>
                                </select>
                            </div>

                            <div id="qualityControl">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Blur Amount</label>
                                <input type="range" id="blurRange" min="0" max="20" value="10"
                                    class="w-full h-2 bg-white rounded-lg appearance-none cursor-pointer border border-gray-200">
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 flex flex-col items-center justify-center">
                        <h4 class="text-sm font-bold text-gray-600 mb-2">Preview (Placeholder)</h4>
                        <img id="previewImg" class="max-w-full rounded shadow-sm border border-gray-300" />
                        <p class="text-xs text-gray-400 mt-2" id="previewSize">Size: 0kb</p>
                    </div>
                </div>

                <!-- Right Column: Code Output -->
                <div class="flex flex-col space-y-4">
                    <h3 class="font-bold text-gray-800">Generated HTML & JS</h3>

                    <div class="relative">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">HTML Code</label>
                        <textarea id="htmlOutput"
                            class="w-full h-32 rounded-lg border-gray-300 font-mono text-xs bg-gray-50" readonly></textarea>
                        <button
                            class="absolute top-6 right-2 text-indigo-600 hover:text-indigo-800 text-xs font-bold copy-btn"
                            data-target="htmlOutput">Copy</button>
                    </div>

                    <div class="relative">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">CSS (Optional)</label>
                        <textarea id="cssOutput" class="w-full h-24 rounded-lg border-gray-300 font-mono text-xs bg-gray-50"
                            readonly>.lazy { opacity: 0; transition: opacity 0.3s; }
    .lazy.loaded { opacity: 1; }</textarea>
                        <button
                            class="absolute top-6 right-2 text-indigo-600 hover:text-indigo-800 text-xs font-bold copy-btn"
                            data-target="cssOutput">Copy</button>
                    </div>

                    <div class="relative">
                        <label class="block text-xs font-semibold text-gray-500 mb-1">JavaScript (Intersection
                            Observer)</label>
                        <textarea id="jsOutput" class="w-full h-48 rounded-lg border-gray-300 font-mono text-xs bg-gray-50"
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
                            class="absolute top-6 right-2 text-indigo-600 hover:text-indigo-800 text-xs font-bold copy-btn"
                            data-target="jsOutput">Copy</button>
                    </div>

                    <button id="uploadNewBtn"
                        class="w-full bg-white border border-gray-300 text-gray-700 font-bold py-3 rounded-xl hover:bg-gray-50 transition-all">
                        Process Another Image
                    </button>
                </div>
            </div>
        </div>

        <x-tool-content :tool="$tool" />
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

            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
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
                    setTimeout(() => btn.innerText = originalText, 2000);
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
                    // LQIP
                    // If blur needed, we can apply css blur to the preview img
                    placeholderDataUrl = canvas.toDataURL('image/jpeg', 0.5);
                }

                previewImg.src = placeholderDataUrl;
                previewImg.style.filter = (style === 'blur' || style === 'lqip') ? `blur(${blur}px)` : 'none';
                previewImg.style.width = '100%';

                // Calculate size
                const sizeKB = (placeholderDataUrl.length * 3 / 4) / 1024;
                previewSize.textContent = `Base64 Size: ${sizeKB.toFixed(2)} KB`;

                // Generate HTML
                const imgTag = `<img src="${placeholderDataUrl}" 
             data-src="${originalFile.name}" 
             class="lazy" 
             alt="Lazy loaded image"
             style="width: 100%; aspect-ratio: ${originalImg.width}/${originalImg.height}; ${(style === 'blur' || style === 'lqip') ? 'filter: blur(' + blur + 'px); transition: filter 0.3s;' : ''}"
             onload="this.style.filter='none'">`;

                htmlOutput.value = imgTag;
            }
        </script>
    @endpush
@endsection