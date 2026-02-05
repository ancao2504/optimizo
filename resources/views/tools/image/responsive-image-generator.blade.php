@extends('layouts.app')

@section('title', __tool('responsive-image-generator', 'meta.title'))
@section('meta_description', __tool('responsive-image-generator', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />


            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*"
                :title="__tool('responsive-image-generator', 'input.drop_title')"
                :subtitle="__tool('responsive-image-generator', 'input.drop_desc')" />

            <!-- Editor/Result Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-2 gap-8">
                <!-- Left Column: Config -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-4 text-lg border-b border-gray-100 pb-3">
                            {!! __tool('responsive-image-generator', 'settings.title') !!}
                        </h3>

                        <label class="block text-sm font-bold text-gray-700 mb-3">Breakpoints (Widths in px)</label>
                        <div id="breakpointsList" class="space-y-3 mb-6">
                            <!-- Helper function for rendering checkboxes could be cleaner but staying inline for simplicity -->
                            <label
                                class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer hover:border-indigo-300 transition-colors">
                                <input type="checkbox"
                                    class="breakpoint-cb rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5" value="320"
                                    checked>
                                <span class="text-gray-700 font-medium">320px (Mobile S)</span>
                            </label>
                            <label
                                class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer hover:border-indigo-300 transition-colors">
                                <input type="checkbox"
                                    class="breakpoint-cb rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5" value="480"
                                    checked>
                                <span class="text-gray-700 font-medium">480px (Mobile L)</span>
                            </label>
                            <label
                                class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer hover:border-indigo-300 transition-colors">
                                <input type="checkbox"
                                    class="breakpoint-cb rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5" value="768"
                                    checked>
                                <span class="text-gray-700 font-medium">768px (Tablet)</span>
                            </label>
                            <label
                                class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer hover:border-indigo-300 transition-colors">
                                <input type="checkbox"
                                    class="breakpoint-cb rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5" value="1024"
                                    checked>
                                <span class="text-gray-700 font-medium">1024px (Laptop)</span>
                            </label>
                            <label
                                class="flex items-center space-x-3 p-3 bg-gray-50 rounded-xl border border-gray-200 cursor-pointer hover:border-indigo-300 transition-colors">
                                <input type="checkbox"
                                    class="breakpoint-cb rounded text-indigo-600 focus:ring-indigo-500 h-5 w-5" value="1280"
                                    checked>
                                <span class="text-gray-700 font-medium">1280px (Desktop)</span>
                            </label>
                        </div>

                        <button id="processBtn"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl shadow-md transition-all transform hover:-translate-y-0.5">
                            Generate Resized Images
                        </button>
                    </div>

                    <div id="downloadsArea" class="hidden bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                        <h4 class="font-bold text-gray-800 mb-4 border-b border-gray-200 pb-2">Download Links</h4>
                        <div id="downloadLinks" class="space-y-3 mb-4 max-h-60 overflow-y-auto scrollbar-thin">
                            <!-- Links injected here -->
                        </div>
                    </div>
                </div>

                <!-- Right Column: Code Output -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 flex flex-col items-center">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Preview</h4>
                        <img id="previewImg"
                            class="max-w-full max-h-[200px] object-contain rounded shadow-sm bg-white border border-gray-200" />
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-900 text-lg mb-2">Generated HTML (Srcset)</h3>
                        <div class="relative">
                            <textarea id="htmlOutput"
                                class="w-full h-64 rounded-xl border-gray-200 font-mono text-sm bg-gray-900 text-gray-300 p-4 focus:ring-indigo-500 focus:border-indigo-500"
                                readonly></textarea>
                            <button
                                class="absolute top-4 right-4 bg-white/10 hover:bg-white/20 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition-colors copy-btn backdrop-blur-sm"
                                data-target="htmlOutput">Copy</button>
                        </div>
                    </div>

                    <button id="uploadNewBtn"
                        class="w-full bg-white border border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:bg-gray-50 hover:text-indigo-600 transition-all shadow-sm">
                        Process Another Image
                    </button>
                </div>
            </div>


        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-3 block">Why Use This Tool?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('responsive-image-generator', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Serve the perfect size for every device.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('responsive-image-generator', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('responsive-image-generator', "content.features.f{$i}_desc") }}</p>
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
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('responsive-image-generator', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">Create image sets in seconds.</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('responsive-image-generator', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg shadow-indigo-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('responsive-image-generator', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('responsive-image-generator', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('responsive-image-generator', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('responsive-image-generator', "content.faq.a$i"); @endphp
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

                // We'll assume the browser can handle sequential drawing fast enough
                for (let w of widths) {
                    if (w > originalImg.width) continue; // Skip upscaling if desired, or maybe warn?

                    const scale = w / originalImg.width;
                    const h = originalImg.height * scale;

                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(originalImg, 0, 0, w, h);

                    // High quality export
                    const dataUrl = canvas.toDataURL(originalFile.type, 0.92);
                    const blob = await (await fetch(dataUrl)).blob();
                    const url = URL.createObjectURL(blob);

                    const newName = `${fileName}-${w}w.${ext}`;

                    // Create Link
                    const div = document.createElement('div');
                    div.className = "flex justify-between items-center bg-white p-3 rounded-lg border border-gray-100 hover:border-indigo-200 transition-colors shadow-sm";
                    div.innerHTML = `
                                        <div class="flex items-center gap-2">
                                             <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2 py-1 rounded border border-indigo-100">${w}w</span>
                                             <span class="text-sm text-gray-600 truncate max-w-[150px]">${newName}</span>
                                        </div>
                                        <a href="${url}" download="${newName}" class="text-indigo-600 hover:text-indigo-800 text-sm font-bold bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-all">Download</a>
                                    `;
                    downloadLinks.appendChild(div);

                    srcsetParts.push(`${newName} ${w}w`);
                }

                // Construct HTML code
                const code = `<img 
              src="${fileName}.${ext}" 
              srcset="${srcsetParts.join(',\n          ')}" 
              sizes="(max-width: 600px) 480px, 800px" 
              alt="${fileName}">`;

                htmlOutput.value = code;
            }
        </script>
    @endpush
@endsection