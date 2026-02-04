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

        <x-tool-content :tool="$tool" />
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