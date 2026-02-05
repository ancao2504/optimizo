@extends('layouts.app')

@section('title', __tool('sprite-sheet-generator', 'meta.title'))
@section('meta_description', __tool('sprite-sheet-generator', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <x-tool-ui-card :title="__tool('sprite-sheet-generator', 'input.title')"
            :description="__tool('sprite-sheet-generator', 'input.desc')">
            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('sprite-sheet-generator', 'input.drop_title')" :subtitle="__tool('sprite-sheet-generator', 'input.drop_desc')" :multiple="true" />

            <!-- Editor/Result Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Preview -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200 overflow-auto flex items-center justify-center min-h-[300px] shadow-inner"
                        style="max-height: 600px;">
                        <canvas id="spriteCanvas"
                            class="max-w-none bg-[url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAF0lEQVQ4T2N89+7df3Qmo2F4NAyjYQAAq003wQ2u5x4AAAAASUVORK5CYII=')] bg-repeat shadow-sm border border-gray-300"></canvas>
                        <p id="emptyText" class="text-gray-400 font-medium hidden">Preview will appear here</p>
                    </div>

                    <!-- CSS Output -->
                    <div class="relative">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-bold text-gray-700">CSS Output</label>
                            <button class="text-indigo-600 hover:text-indigo-800 text-xs font-bold copy-btn"
                                data-target="cssOutput">Copy CSS</button>
                        </div>
                        <textarea id="cssOutput"
                            class="w-full h-48 rounded-xl border-gray-200 font-mono text-xs bg-gray-900 text-gray-300 p-4 focus:ring-indigo-500 focus:border-indigo-500"
                            readonly></textarea>
                    </div>
                </div>

                <!-- Right Column: Settings -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-4 text-lg border-b border-gray-100 pb-3">
                            {!! __tool('sprite-sheet-generator', 'settings.title') !!}
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Padding (px)</label>
                                <input type="number" id="paddingInput" value="5" min="0"
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 shadow-sm p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Columns</label>
                                <input type="number" id="columnsInput" value="0" min="0"
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 shadow-sm p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Set to 0 for auto-calculating columns.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Algorithm</label>
                                <select id="algoSelect"
                                    class="w-full rounded-xl border-gray-200 bg-gray-50 shadow-sm p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="horizontal">Horizontal Strip</option>
                                    <option value="vertical">Vertical Strip</option>
                                    <option value="grid" selected>Grid / Smart Pack</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-4 mt-6 border-t border-gray-100 grid grid-cols-2 gap-3">
                            <button id="generateBtn"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 rounded-xl text-sm transition-all shadow-md">
                                Generate
                            </button>
                            <button id="clearBtn"
                                class="w-full bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 py-2.5 rounded-xl text-sm font-bold transition-all">
                                Clear
                            </button>
                        </div>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Sprite Sheet
                    </button>

                    <button id="uploadNewBtn"
                        class="w-full bg-white border border-gray-200 text-gray-600 font-bold py-3 rounded-xl hover:bg-gray-50 hover:text-indigo-600 transition-all shadow-sm">
                        Add More Images
                    </button>

                    <button id="resetAllBtn"
                        class="text-center text-red-500 hover:text-red-700 font-medium transition-colors text-sm">
                        Start Over
                    </button>
                </div>
            </div>
        </x-tool-ui-card>

        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Intro Section -->
            <section class="max-w-5xl mx-auto text-center relative">
                <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(59,130,246,0.15)_0%,rgba(255,255,255,0)_70%)] blur-3xl"></div>
                
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 border border-blue-100 shadow-sm mb-10 transition-transform hover:scale-105 cursor-default">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    <span class="text-xs font-bold tracking-wide uppercase text-blue-700">Optimization Tools</span>
                </div>

                <h2 class="text-5xl md:text-7xl font-black text-gray-900 mb-8 tracking-tight leading-[1.1] drop-shadow-sm">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-800">
                        {{ __tool('sprite-sheet-generator', 'content.intro.title') ?: 'Generate CSS Sprite Sheets' }}
                    </span>
                </h2>
                
                <p class="text-xl md:text-2xl text-gray-600 mb-14 leading-relaxed font-light max-w-3xl mx-auto">
                    {{ __tool('sprite-sheet-generator', 'content.intro.subtitle') }}
                </p>
            </section>

            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-blue-600 font-bold tracking-widest uppercase text-sm mb-3 block">Why Use This Tool?</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('sprite-sheet-generator', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Reduce HTTP requests and speed up loading.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('sprite-sheet-generator', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('sprite-sheet-generator', "content.features.f{$i}_desc") }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- How-to Section -->
             <section class="max-w-5xl mx-auto bg-gray-900 text-white rounded-[3rem] p-8 md:p-16 border border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-blue-600/20 rounded-full blur-[100px] -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[80px] -ml-16 -mb-16"></div>

                <div class="relative z-10 text-center mb-16">
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('sprite-sheet-generator', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">Create sprites in minimal steps.</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('sprite-sheet-generator', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-blue-600 text-white font-bold text-lg shadow-lg shadow-blue-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('sprite-sheet-generator', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('sprite-sheet-generator', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('sprite-sheet-generator', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-blue-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('sprite-sheet-generator', "content.faq.a$i"); @endphp
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
            const canvas = document.getElementById('spriteCanvas');
            const ctx = canvas.getContext('2d');
            const cssOutput = document.getElementById('cssOutput');

            const paddingInput = document.getElementById('paddingInput');
            const columnsInput = document.getElementById('columnsInput');
            const algoSelect = document.getElementById('algoSelect');

            const generateBtn = document.getElementById('generateBtn');
            const clearBtn = document.getElementById('clearBtn');
            const downloadBtn = document.getElementById('downloadBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');
            const resetAllBtn = document.getElementById('resetAllBtn');
            const copyBtn = document.querySelector('.copy-btn');

            let images = [];

            // Listeners
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/50');
                if (e.dataTransfer.files.length) handleFiles(e.dataTransfer.files);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files.length) handleFiles(e.target.files); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.click();
            });

            copyBtn.addEventListener('click', () => {
                cssOutput.select();
                document.execCommand('copy');
                const orig = copyBtn.innerText;
                copyBtn.innerText = 'Copied!';
                setTimeout(() => copyBtn.innerText = orig, 1500);
            });

            generateBtn.addEventListener('click', generateSprite);

            // Clears logic
            clearBtn.addEventListener('click', () => {
                images = [];
                canvas.width = 0; canvas.height = 0;
                cssOutput.value = '';
                // Don't hide editor, just clear data
            });

            resetAllBtn.addEventListener('click', () => {
                images = [];
                canvas.width = 0; canvas.height = 0;
                cssOutput.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
                imageInput.value = '';
            });

            function handleFiles(fileList) {
                let loaded = 0;
                const total = fileList.length;

                Array.from(fileList).forEach(file => {
                    if (!file.type.match('image.*')) return;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const img = new Image();
                        img.onload = () => {
                            images.push({
                                element: img,
                                name: file.name.replace(/\.[^/.]+$/, "").replace(/[^a-z0-9]/gi, '-').toLowerCase(),
                                width: img.width,
                                height: img.height
                            });
                            loaded++;
                            if (loaded === total || loaded === images.length) {
                                editorArea.classList.remove('hidden');
                                dropZone.classList.add('hidden');
                                generateSprite();
                            }
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
            }

            function generateSprite() {
                if (images.length === 0) return;

                const padding = parseInt(paddingInput.value) || 0;
                const algo = algoSelect.value;
                const fixedCols = parseInt(columnsInput.value) || 0;

                let currentX = 0;
                let currentY = 0;
                let maxYInRow = 0;
                let totalWidth = 0;
                let totalHeight = 0;

                if (algo === 'horizontal') {
                    images.forEach((img) => {
                        img.x = currentX;
                        img.y = 0;
                        currentX += img.width + padding;
                        maxYInRow = Math.max(maxYInRow, img.height);
                    });
                    totalWidth = currentX - padding;
                    totalHeight = maxYInRow;

                } else if (algo === 'vertical') {
                    let maxX = 0;
                    images.forEach((img) => {
                        img.x = 0;
                        img.y = currentY;
                        currentY += img.height + padding;
                        maxX = Math.max(maxX, img.width);
                    });
                    totalWidth = maxX;
                    totalHeight = currentY - padding;

                } else {
                    // Grid
                    const cols = fixedCols > 0 ? fixedCols : Math.ceil(Math.sqrt(images.length));

                    images.forEach((img, i) => {
                        if (i > 0 && i % cols === 0) {
                            currentX = 0;
                            currentY += maxYInRow + padding;
                            maxYInRow = 0;
                        }
                        img.x = currentX;
                        img.y = currentY;

                        currentX += img.width + padding;
                        maxYInRow = Math.max(maxYInRow, img.height);
                        totalWidth = Math.max(totalWidth, currentX - padding);
                    });
                    totalHeight = currentY + maxYInRow;
                }

                canvas.width = totalWidth;
                canvas.height = totalHeight;
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                let css = "/* CSS Sprite Sheet generated by Optimizo */\n";
                // Add common class
                css += `.sprite { display: inline-block; background-image: url('sprite.png'); background-repeat: no-repeat; }\n\n`;

                images.forEach(img => {
                    ctx.drawImage(img.element, img.x, img.y);
                    css += `.sprite-${img.name} {\n  width: ${img.width}px;\n  height: ${img.height}px;\n  background-position: -${img.x}px -${img.y}px;\n}\n`;
                });

                cssOutput.value = css;
            }

            downloadBtn.addEventListener('click', () => {
                if (canvas.width === 0) return;
                const link = document.createElement('a');
                link.download = 'sprite-sheet.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        </script>
    @endpush
@endsection