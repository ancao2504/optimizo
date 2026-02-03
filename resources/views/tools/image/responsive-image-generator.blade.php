@extends('layouts.app')

@section('title', __tool('responsive-image-generator', 'meta.title'))
@section('meta_description', __tool('responsive-image-generator', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    {!! __tool('responsive-image-generator', 'input.title') !!}</h2>
                <p class="text-gray-600">{!! __tool('responsive-image-generator', 'input.desc') !!}</p>
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
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">
                            {!! __tool('responsive-image-generator', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">{!! __tool('responsive-image-generator', 'input.drop_desc') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Editor/Result Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-2 gap-8">

                <!-- Left Column: Config -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                        <h3 class="font-bold text-gray-800 mb-4">
                            {!! __tool('responsive-image-generator', 'settings.title') !!}</h3>

                        <label class="block text-sm font-medium text-gray-700 mb-2">Breakpoints (Widths in px)</label>
                        <div id="breakpointsList" class="space-y-2 mb-4">
                            <!-- Dynamic Checkboxes -->
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="breakpoint-cb rounded text-indigo-600" value="320" checked>
                                <span class="text-gray-700 text-sm">320px (Mobile S)</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="breakpoint-cb rounded text-indigo-600" value="480" checked>
                                <span class="text-gray-700 text-sm">480px (Mobile L)</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="breakpoint-cb rounded text-indigo-600" value="768" checked>
                                <span class="text-gray-700 text-sm">768px (Tablet)</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="breakpoint-cb rounded text-indigo-600" value="1024" checked>
                                <span class="text-gray-700 text-sm">1024px (Laptop)</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" class="breakpoint-cb rounded text-indigo-600" value="1280" checked>
                                <span class="text-gray-700 text-sm">1280px (Desktop)</span>
                            </label>
                        </div>

                        <button id="processBtn"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-lg text-sm">
                            Generate Resized Images
                        </button>
                    </div>

                    <div id="downloadsArea" class="hidden bg-white p-6 rounded-2xl border border-gray-200">
                        <h4 class="font-bold text-gray-800 mb-4">Resized Images</h4>
                        <div id="downloadLinks" class="space-y-2 text-sm overflow-y-auto max-h-48 scrollbar-thin">
                            <!-- Links injected here -->
                        </div>
                        <button id="downloadAllBtn"
                            class="w-full mt-4 bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded-lg text-sm hidden">
                            Download All (ZIP)
                        </button>
                        <p class="text-xs text-gray-400 mt-2 text-center">Note: ZIP download requires JSZip loaded (optional
                            feature)</p>
                    </div>
                </div>

                <!-- Right Column: Code Output -->
                <div class="flex flex-col space-y-4">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 text-center">
                        <h4 class="text-sm font-bold text-gray-600 mb-2">Original Preview</h4>
                        <img id="previewImg"
                            class="max-w-full h-32 object-contain mx-auto rounded shadow-sm border border-gray-300" />
                    </div>

                    <h3 class="font-bold text-gray-800">Generated HTML (Srcset)</h3>

                    <div class="relative">
                        <textarea id="htmlOutput"
                            class="w-full h-64 rounded-lg border-gray-300 font-mono text-xs bg-gray-50 p-3"
                            readonly></textarea>
                        <button
                            class="absolute top-2 right-2 text-indigo-600 hover:text-indigo-800 text-xs font-bold copy-btn"
                            data-target="htmlOutput">Copy</button>
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

            const processBtn = document.getElementById('processBtn');
            const downloadsArea = document.getElementById('downloadsArea');
            const downloadLinks = document.getElementById('downloadLinks');
            const htmlOutput = document.getElementById('htmlOutput');
            const uploadNewBtn = document.getElementById('uploadNewBtn');
            const copyBtns = document.querySelectorAll('.copy-btn');

            let originalFile = null;
            let originalImg = new Image();

            // Checkboxes
            const checkboxes = document.querySelectorAll('.breakpoint-cb');

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
                downloadsArea.classList.add('hidden');
            });

            processBtn.addEventListener('click', generateImages);

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
                        previewImg.src = e.target.result;
                        editorArea.classList.remove('hidden');
                        dropZone.classList.add('hidden');
                    };
                };
                reader.readAsDataURL(file);
            }

            async function generateImages() {
                const widths = Array.from(checkboxes).filter(cb => cb.checked).map(cb => parseInt(cb.value));
                if (widths.length === 0) { alert('Please select at least one breakpoint.'); return; }

                downloadLinks.innerHTML = '';
                downloadsArea.classList.remove('hidden');

                let srcsetParts = [];
                const fileName = originalFile.name.replace(/\.[^/.]+$/, "");
                const ext = originalFile.type.split('/')[1] || 'jpg';

                // Process each width
                // For better performance, we should probably do this sequentially or use a worker, 
                // but for ~5 images it is fine on main thread usually.

                for (let w of widths) {
                    if (w > originalImg.width) continue; // Skip upscaling

                    const scale = w / originalImg.width;
                    const h = originalImg.height * scale;

                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d');

                    // High quality resize (stepping?) or just drawImage
                    // Browser implementations of drawImage are usually decent now.
                    ctx.drawImage(originalImg, 0, 0, w, h);

                    const dataUrl = canvas.toDataURL(originalFile.type, 0.9);
                    const blob = await (await fetch(dataUrl)).blob();
                    const url = URL.createObjectURL(blob);

                    const newName = `${fileName}-${w}w.${ext}`;

                    // Create Link
                    const link = document.createElement('div');
                    link.className = "flex justify-between items-center bg-gray-50 p-2 rounded";
                    link.innerHTML = `
                                <span class="font-medium text-gray-700">${w}w</span>
                                <a href="${url}" download="${newName}" class="text-indigo-600 hover:text-indigo-800 text-xs font-bold bg-white border border-gray-200 px-3 py-1 rounded shadow-sm hover:shadow-md transition-all">Download</a>
                            `;
                    downloadLinks.appendChild(link);

                    srcsetParts.push(`${newName} ${w}w`);
                }

                // Construct HTML code
                // Assuming the user will place images in same folder
                const code = `<img 
            src="${fileName}.${ext}" 
            srcset="${srcsetParts.join(',\n            ')}" 
            sizes="(max-width: 600px) 480px, 800px" 
            alt="${fileName}">`;

                htmlOutput.value = code;
            }
        </script>
    @endpush
@endsection