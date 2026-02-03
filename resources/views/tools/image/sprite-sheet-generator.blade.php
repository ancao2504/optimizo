@extends('layouts.app')

@section('title', __tool('sprite-sheet-generator', 'meta.title'))
@section('meta_description', __tool('sprite-sheet-generator', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-indigo-50 mb-12">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">{!! __tool('sprite-sheet-generator', 'input.title') !!}
                </h2>
                <p class="text-gray-600">{!! __tool('sprite-sheet-generator', 'input.desc') !!}</p>
            </div>

            <!-- Upload Area -->
            <div id="dropZone"
                class="border-3 border-dashed border-indigo-200 rounded-2xl p-8 hover:border-indigo-400 hover:bg-indigo-50 transition-all cursor-pointer text-center relative group">
                <input type="file" id="imageInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                    accept="image/*" multiple>
                <div class="space-y-4 pointer-events-none">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-700">
                            {!! __tool('sprite-sheet-generator', 'input.drop_title') !!}</p>
                        <p class="text-sm text-gray-500">{!! __tool('sprite-sheet-generator', 'input.drop_desc') !!}</p>
                    </div>
                </div>
            </div>

            <!-- Editor/Result Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-3 gap-8">
                <!-- Left Column: Preview -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 overflow-auto" style="max-height: 600px;">
                        <canvas id="spriteCanvas" class="max-w-none bg-white shadow-sm border border-gray-300"></canvas>
                    </div>

                    <!-- CSS Output -->
                    <div class="mt-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">CSS Output</label>
                        <textarea id="cssOutput" class="w-full h-32 rounded-lg border-gray-300 font-mono text-xs bg-gray-50"
                            readonly></textarea>
                    </div>
                </div>

                <!-- Right Column: Settings -->
                <div class="flex flex-col space-y-6">
                    <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100">
                        <h3 class="font-bold text-gray-800 mb-4">{!! __tool('sprite-sheet-generator', 'settings.title') !!}
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Padding (px)</label>
                                <input type="number" id="paddingInput" value="5" min="0"
                                    class="w-full rounded border-gray-300">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Columns</label>
                                <input type="number" id="columnsInput" value="0" min="0"
                                    class="w-full rounded border-gray-300">
                                <p class="text-xs text-gray-500 mt-1">Set to 0 for auto-calculating columns.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Algorithm</label>
                                <select id="algoSelect" class="w-full rounded border-gray-300">
                                    <option value="horizontal">Horizontal Strip</option>
                                    <option value="vertical">Vertical Strip</option>
                                    <option value="grid" selected>Grid / Smart Pack</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-4 mt-4 border-t border-indigo-200">
                            <button id="generateBtn"
                                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 rounded-lg text-sm mb-2">
                                Regenerate Sprite Sheet
                            </button>
                            <button id="clearBtn"
                                class="w-full bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 py-2 rounded-lg text-sm">
                                Clear All
                            </button>
                        </div>
                    </div>

                    <button id="downloadBtn"
                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg transform hover:scale-[1.01] transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Sprite Sheet
                    </button>

                    <button id="uploadNewBtn"
                        class="text-center text-gray-500 hover:text-indigo-600 font-medium transition-colors">
                        Add More Images
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

            let images = [];

            // Listeners
            dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('dragleave', (e) => { e.preventDefault(); dropZone.classList.remove('border-indigo-500', 'bg-indigo-50'); });
            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
                if (e.dataTransfer.files.length) handleFiles(e.dataTransfer.files);
            });

            imageInput.addEventListener('change', (e) => { if (e.target.files.length) handleFiles(e.target.files); });

            uploadNewBtn.addEventListener('click', () => {
                imageInput.click();
            });

            generateBtn.addEventListener('click', generateSprite);

            clearBtn.addEventListener('click', () => {
                images = [];
                drawEmpty();
                cssOutput.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            // Handle Input
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
                                name: file.name.replace(/\.[^/.]+$/, "").replace(/\s+/g, '-').toLowerCase(),
                                width: img.width,
                                height: img.height
                            });
                            loaded++;
                            if (loaded === total || loaded === images.length) { // Simple check
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

            function drawEmpty() {
                canvas.width = 0;
                canvas.height = 0;
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

                // Calculate Layout positions

                if (algo === 'horizontal') {
                    // All in one row
                    images.forEach((img, i) => {
                        img.x = currentX;
                        img.y = 0;
                        currentX += img.width + padding;
                        maxYInRow = Math.max(maxYInRow, img.height);
                    });
                    // Remove last padding
                    totalWidth = currentX - padding;
                    totalHeight = maxYInRow;

                } else if (algo === 'vertical') {
                    // All in one column
                    let maxX = 0;
                    images.forEach((img, i) => {
                        img.x = 0;
                        img.y = currentY;
                        currentY += img.height + padding;
                        maxX = Math.max(maxX, img.width);
                    });
                    totalWidth = maxX;
                    totalHeight = currentY - padding;

                } else {
                    // Grid / Smart
                    // Simple logic: If fixedCols is 0, estimate sqrt.
                    const cols = fixedCols > 0 ? fixedCols : Math.ceil(Math.sqrt(images.length));

                    images.forEach((img, i) => {
                        // New Row
                        if (i > 0 && i % cols === 0) {
                            currentX = 0;
                            currentY += maxYInRow + padding;
                            maxYInRow = 0; // Reset for new row
                        }

                        img.x = currentX;
                        img.y = currentY;

                        currentX += img.width + padding;
                        maxYInRow = Math.max(maxYInRow, img.height);

                        totalWidth = Math.max(totalWidth, currentX - padding); // Track max width reached
                    });
                    totalHeight = currentY + maxYInRow;
                }

                // Set Canvas
                canvas.width = totalWidth;
                canvas.height = totalHeight;

                // Draw
                // Background transparent by default on canvas
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                let css = "/* CSS Sprite Sheet generated by Optimizo */\n";
                css += `.sprite { background-image: url('sprite.png'); background-repeat: no-repeat; display: inline-block; }\n\n`;

                images.forEach(img => {
                    ctx.drawImage(img.element, img.x, img.y);

                    // Generate CSS
                    css += `.sprite-${img.name} {\n`;
                    css += `    width: ${img.width}px;\n`;
                    css += `    height: ${img.height}px;\n`;
                    css += `    background-position: -${img.x}px -${img.y}px;\n`;
                    css += `}\n`;
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