@extends('layouts.app')

@section('title', __tool('digital-signature', 'meta.title', 'Digital Signature - Free Online Document Signing Tool'))
@section('meta_description', __tool('digital-signature', 'meta.description', 'Sign PDF documents online for free. Upload your PDF, draw or type your signature, and download the signed document securely.'))

@section('content')
    <x-tool-hero :tool="$tool" />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-20" x-data="digitalSignatureApp()">
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-2xl border border-gray-100">

            <!-- Upload Section -->
            <div x-show="!fileLoaded" class="transition-all duration-300">
                <div class="border-4 border-dashed border-indigo-100 rounded-3xl p-10 text-center hover:border-indigo-300 hover:bg-indigo-50 transition-all cursor-pointer relative group bg-gray-50/50"
                    id="dropzone">
                    <input type="file" @change="handleFileSelect" id="fileInput"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".pdf">
                    <div class="space-y-6 pointer-events-none">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full group-hover:scale-110 transition-transform">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xl font-bold text-gray-700">{{ __tool('digital-signature', 'editor.upload_text') ?: 'Drop your PDF here or click to upload' }}</p>
                            <p class="text-base text-gray-500 mt-2">{{ __tool('digital-signature', 'editor.max_file_size') ?: 'Maximum file size: 10MB' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Editor Section -->
            <div x-show="fileLoaded" style="display: none;" class="flex flex-col h-[80vh]">
                <!-- Toolbar -->
                <div
                    class="flex flex-wrap items-center justify-between gap-4 mb-4 p-4 bg-gray-50 rounded-2xl border border-gray-200">
                    <div class="flex items-center space-x-2">
                        <button @click="prevPage" :disabled="currentPage <= 1"
                            class="p-2 rounded-lg hover:bg-white disabled:opacity-50 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <span class="text-sm font-medium text-gray-700">{{ __tool('digital-signature', 'editor.page_label') ?: 'Page' }} <span x-text="currentPage"></span> {{ __tool('digital-signature', 'editor.page_of') ?: 'of' }} <span
                                x-text="totalPages"></span></span>
                        <button @click="nextPage" :disabled="currentPage >= totalPages"
                            class="p-2 rounded-lg hover:bg-white disabled:opacity-50 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <div class="flex items-center space-x-4">
                        <button @click="openSignatureModal"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-medium shadow-sm transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            {{ __tool('digital-signature', 'editor.btn_add_signature') ?: 'Add Signature' }}
                        </button>
                        <button @click="downloadPdf" :disabled="isProcessing"
                            class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 font-medium shadow-sm transition-colors flex items-center disabled:opacity-50">
                            <svg x-show="!isProcessing" class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <svg x-show="isProcessing" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            {{ __tool('digital-signature', 'editor.btn_download') ?: 'Download PDF' }}
                        </button>
                        <button @click="resetApp" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Canvas Container -->
                <div class="flex-1 overflow-auto bg-gray-100 rounded-xl p-4 flex justify-center relative" id="pdfContainer">
                    <div class="relative shadow-lg" :style="`width: ${canvasWidth}px; height: ${canvasHeight}px;`">
                        <canvas id="pdfRenderer" class="absolute inset-0 z-0"></canvas>
                        <!-- Signature Layer -->
                        <div id="signatureLayer" class="absolute inset-0 z-10 overflow-hidden">
                            <template x-for="sig in signatures">
                                <template x-if="sig.page === currentPage">
                                    <div class="absolute border-2 border-indigo-500 border-dashed cursor-move group hover:bg-indigo-50/10"
                                        :style="`left: ${sig.x}px; top: ${sig.y}px; width: ${sig.width}px; height: ${sig.height}px;`"
                                        @mousedown="startDrag($event, sig.id)">
                                        <img :src="sig.data" class="w-full h-full object-contain pointer-events-none">
                                        <!-- Delete Button -->
                                        <button @click.stop="removeSignature(sig.id)"
                                            class="absolute -top-3 -right-3 bg-red-500 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition-opacity transform hover:scale-110">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                        <!-- Resize Handle -->
                                        <div class="absolute bottom-0 right-0 w-4 h-4 bg-indigo-500 cursor-se-resize opacity-0 group-hover:opacity-100"
                                            @mousedown.stop="startResize($event, sig.id)"></div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Signature Modal -->
    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" @click="showModal = false"
                class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4" id="modal-title">{{ __tool('digital-signature', 'modal.title') ?: 'Create Signature' }}</h3>

                    <!-- Tabs -->
                    <div class="flex border-b border-gray-200 mb-4">
                        <button @click="activeTab = 'draw'"
                            :class="{'border-indigo-500 text-indigo-600': activeTab === 'draw', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'draw'}"
                            class="flex-1 py-2 px-4 border-b-2 font-medium text-sm">{{ __tool('digital-signature', 'modal.tab_draw') ?: 'Draw' }}</button>
                        <button @click="activeTab = 'type'"
                            :class="{'border-indigo-500 text-indigo-600': activeTab === 'type', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'type'}"
                            class="flex-1 py-2 px-4 border-b-2 font-medium text-sm">{{ __tool('digital-signature', 'modal.tab_type') ?: 'Type' }}</button>
                        <button @click="activeTab = 'upload'"
                            :class="{'border-indigo-500 text-indigo-600': activeTab === 'upload', 'border-transparent text-gray-500 hover:text-gray-700': activeTab !== 'upload'}"
                            class="flex-1 py-2 px-4 border-b-2 font-medium text-sm">{{ __tool('digital-signature', 'modal.tab_upload') ?: 'Upload' }}</button>
                    </div>

                    <!-- Draw Tab -->
                    <div x-show="activeTab === 'draw'">
                        <div class="border border-gray-300 rounded-lg bg-gray-50 h-48 relative touch-none">
                            <canvas id="signaturePad"
                                class="absolute inset-0 w-full h-full rounded-lg cursor-crosshair"></canvas>
                            <button @click="clearSignaturePad"
                                class="absolute top-2 right-2 text-xs bg-white border border-gray-200 px-2 py-1 rounded text-gray-500 hover:text-red-500">{{ __tool('digital-signature', 'modal.btn_clear') ?: 'Clear' }}</button>
                        </div>
                    </div>

                    <!-- Type Tab -->
                    <div x-show="activeTab === 'type'">
                        <input type="text" x-model="typedSignature" placeholder="{{ __tool('digital-signature', 'modal.ph_name') ?: 'Type your name' }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-3 text-2xl font-cursive text-center"
                            style="font-family: 'Dancing Script', cursive;">
                    </div>

                    <!-- Upload Tab -->
                    <div x-show="activeTab === 'upload'">
                        <input type="file" @change="handleSignatureUpload" accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="addSignature" type="button"
                        class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __tool('digital-signature', 'modal.btn_create') ?: 'Create Signature' }}
                    </button>
                    <button @click="showModal = false" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ __tool('digital-signature', 'modal.btn_cancel') ?: 'Cancel' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <!-- External Libraries -->
    <script src="https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.min.js"></script>
    <script>
        // Set worker explicitly before loading app
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://unpkg.com/pdfjs-dist@3.11.174/build/pdf.worker.min.js';
    </script>
    <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
    <!-- Google Fonts for Typed Signature -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('digitalSignatureApp', () => ({
                fileLoaded: false,
                pdfDoc: null,
                currentPage: 1,
                totalPages: 0,
                scale: 1.5,
                canvasWidth: 0,
                canvasHeight: 0,
                showModal: false,
                activeTab: 'draw',
                signaturePad: null,
                typedSignature: '',
                uploadedSignature: null,
                signatures: [], // Array of {id, page, x, y, width, height, data}
                isProcessing: false,
                isDragging: false,
                isResizing: false,
                activeSigId: null,
                dragStartX: 0,
                dragStartY: 0,
                initialSigX: 0,
                initialSigY: 0,
                initialSigW: 0,
                initialSigH: 0,

                init() {
                    // Setup global mouse events for drag/resize
                    window.addEventListener('mousemove', (e) => this.handleMouseMove(e));
                    window.addEventListener('mouseup', () => this.handleMouseUp());
                },

                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file && file.type === 'application/pdf') {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.loadPdf(e.target.result);
                        };
                        reader.readAsArrayBuffer(file);
                    } else {
                        alert('Please upload a valid PDF file.');
                    }
                },

                async loadPdf(data) {
                    try {
                        this.pdfDoc = await pdfjsLib.getDocument({ data: data }).promise;
                        this.totalPages = this.pdfDoc.numPages;
                        this.currentPage = 1;
                        this.fileLoaded = true;
                        this.signatures = [];
                        this.$nextTick(() => {
                            this.renderPage(this.currentPage);
                        });
                    } catch (error) {
                        console.error('Error loading PDF:', error);
                        alert('Error loading PDF.');
                    }
                },

                async renderPage(num) {
                    const page = await this.pdfDoc.getPage(num);
                    const viewport = page.getViewport({ scale: this.scale });
                    const canvas = document.getElementById('pdfRenderer');
                    const context = canvas.getContext('2d');

                    this.canvasWidth = viewport.width;
                    this.canvasHeight = viewport.height;
                    canvas.width = viewport.width;
                    canvas.height = viewport.height;

                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    await page.render(renderContext).promise;
                },

                prevPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                        this.renderPage(this.currentPage);
                    }
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                        this.renderPage(this.currentPage);
                    }
                },

                openSignatureModal() {
                    this.showModal = true;
                    this.$nextTick(() => {
                        if (!this.signaturePad) {
                            const canvas = document.getElementById('signaturePad');
                            // Handle high DPI screens for signature pad
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            canvas.width = canvas.offsetWidth * ratio;
                            canvas.height = canvas.offsetHeight * ratio;
                            canvas.getContext("2d").scale(ratio, ratio);

                            this.signaturePad = new SignaturePad(canvas, {
                                backgroundColor: 'rgb(255, 255, 255)'
                            });
                        } else {
                            this.signaturePad.clear();
                        }
                    });
                },

                clearSignaturePad() {
                    if (this.signaturePad) {
                        this.signaturePad.clear();
                    }
                },

                handleSignatureUpload(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (evt) => {
                            this.uploadedSignature = evt.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                addSignature() {
                    let signatureData = null;

                    if (this.activeTab === 'draw') {
                        if (this.signaturePad.isEmpty()) {
                            alert("Please draw your signature.");
                            return;
                        }
                        signatureData = this.signaturePad.toDataURL('image/png');
                    } else if (this.activeTab === 'type') {
                        if (!this.typedSignature.trim()) {
                            alert("Please type your name.");
                            return;
                        }
                        // Create a temporary canvas to convert text to image
                        const tCanvas = document.createElement('canvas');
                        const tCtx = tCanvas.getContext('2d');
                        tCanvas.width = 400;
                        tCanvas.height = 100;
                        tCtx.font = "bold 48px 'Dancing Script', cursive";
                        tCtx.fillStyle = "black";
                        tCtx.textAlign = "center";
                        tCtx.textBaseline = "middle";
                        tCtx.fillText(this.typedSignature, tCanvas.width / 2, tCanvas.height / 2);
                        signatureData = tCanvas.toDataURL('image/png');
                    } else if (this.activeTab === 'upload') {
                        if (!this.uploadedSignature) {
                            alert("Please upload an image.");
                            return;
                        }
                        signatureData = this.uploadedSignature;
                    }

                    if (signatureData) {
                        this.signatures.push({
                            id: Date.now(),
                            page: this.currentPage,
                            x: 50, // Default position
                            y: 50,
                            width: 200, // Default size
                            height: 100, // Approximate aspect ratio, effectively auto for image
                            data: signatureData
                        });
                        this.showModal = false;

                        // Reset inputs
                        this.typedSignature = '';
                        this.uploadedSignature = null;
                        if (this.signaturePad) this.signaturePad.clear();
                    }
                },

                removeSignature(id) {
                    this.signatures = this.signatures.filter(s => s.id !== id);
                },

                // Drag and Resize Logic
                startDrag(e, id) {
                    if (e.target.classList.contains('cursor-se-resize')) return; // Ignore if clicking handle

                    e.preventDefault(); // Prevent default image dragging
                    this.isDragging = true;
                    this.activeSigId = id;
                    this.dragStartX = e.clientX;
                    this.dragStartY = e.clientY;

                    const sig = this.signatures.find(s => s.id === id);
                    this.initialSigX = sig.x;
                    this.initialSigY = sig.y;
                },

                startResize(e, id) {
                    this.isResizing = true;
                    this.activeSigId = id;
                    this.dragStartX = e.clientX;
                    this.dragStartY = e.clientY;

                    const sig = this.signatures.find(s => s.id === id);
                    this.initialSigW = sig.width;
                    this.initialSigH = sig.height;
                },

                handleMouseMove(e) {
                    if (this.isDragging && this.activeSigId) {
                        const dx = e.clientX - this.dragStartX;
                        const dy = e.clientY - this.dragStartY;

                        const sigIndex = this.signatures.findIndex(s => s.id === this.activeSigId);
                        if (sigIndex !== -1) {
                            // Boundary checks could be added here
                            this.signatures[sigIndex].x = this.initialSigX + dx;
                            this.signatures[sigIndex].y = this.initialSigY + dy;
                        }
                    } else if (this.isResizing && this.activeSigId) {
                        const dx = e.clientX - this.dragStartX;
                        const dy = e.clientY - this.dragStartY; // Optional: maintain aspect ratio

                        const sigIndex = this.signatures.findIndex(s => s.id === this.activeSigId);
                        if (sigIndex !== -1) {
                            const newW = Math.max(50, this.initialSigW + dx);
                            // Simple aspect ratio locking based on initial drag only? 
                            // For now, just independent resizing or standard behavior
                            // Let's assume proportional scale for simplicity if needed, or free for now
                            const newH = Math.max(25, this.initialSigH + dy);

                            this.signatures[sigIndex].width = newW;
                            this.signatures[sigIndex].height = newH;
                        }
                    }
                },

                handleMouseUp() {
                    this.isDragging = false;
                    this.isResizing = false;
                    this.activeSigId = null;
                },

                resetApp() {
                    this.fileLoaded = false;
                    this.pdfDoc = null;
                    this.signatures = [];
                    // Clear file input
                    document.getElementById('fileInput').value = '';
                },

                async downloadPdf() {
                    this.isProcessing = true;
                    try {
                        const { PDFDocument } = PDFLib;

                        // Reload the original PDF to PDF-Lib
                        // We need the array buffer again. Since we store 'data' in loadPdf (which is passed from file reader), 
                        // we might not have stored the raw buffer globally (efficiently), but pdfjs takes data.
                        // Let's rely on the file input essentially or cache the buffer on load.
                        // Ideally we should cache the ArrayBuffer on load.
                        // Let's fix loadPdf to store the buffer.

                        // Retrieving buffer from the original file input is safest if we didn't store it
                        const fileInput = document.getElementById('fileInput');
                        if (!fileInput.files[0]) {
                            alert("Original file not found.");
                            return;
                        }
                        const fileBuffer = await fileInput.files[0].arrayBuffer();

                        const pdfDoc = await PDFDocument.load(fileBuffer);
                        const pages = pdfDoc.getPages();

                        // Embed signatures
                        // Note: Alpine coordinates are based on the *Display* size (canvasWidth/Height)
                        // PDF coordinates are based on the *PDF Page* size (pages[i].getSize())
                        // We must convert coordinates.

                        for (const sig of this.signatures) {
                            const pageIndex = sig.page - 1;
                            const page = pages[pageIndex];
                            const { width: pageWidth, height: pageHeight } = page.getSize();

                            // Calculate scale factors
                            // Display is usually scaled by this.scale (1.5) compared to 'viewport(1.0)'
                            // But pdfjs viewport size depends on the DPI/scale passed.
                            // We used viewport = page.getViewport({scale: this.scale});
                            // So this.canvasWidth == viewport.width

                            const scaleX = pageWidth / this.canvasWidth;
                            const scaleY = pageHeight / this.canvasHeight;

                            const embedImage = await pdfDoc.embedPng(sig.data); // Assuming PNG

                            // PDF coordinate system: Origin (0,0) is usually BOTTOM-LEFT.
                            // HTML/Canvas coordinate system: Origin (0,0) is TOP-LEFT.
                            // So Y must be flipped.

                            const x = sig.x * scaleX;
                            // y in PDF = height - (y on canvas * scaleY) - (imageHeight)
                            // Wait, simplistic flip: 
                            const y = pageHeight - (sig.y * scaleY) - (sig.height * scaleY);

                            page.drawImage(embedImage, {
                                x: x,
                                y: y,
                                width: sig.width * scaleX,
                                height: sig.height * scaleY,
                            });
                        }

                        const pdfBytes = await pdfDoc.save();
                        const blob = new Blob([pdfBytes], { type: 'application/pdf' });
                        const link = document.createElement('a');
                        link.href = URL.createObjectURL(blob);
                        link.download = 'signed_document_optimizo.pdf';
                        link.click();

                    } catch (error) {
                        console.error("Error saving PDF:", error);
                        alert("Failed to save PDF. Please try again.");
                    } finally {
                        this.isProcessing = false;
                    }
                }
            }));
        });
    </script>
@endpush