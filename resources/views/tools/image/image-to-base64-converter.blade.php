@extends('layouts.app')

@section('title', __tool('image-to-base64-converter', 'meta.title'))
@section('meta_description', __tool('image-to-base64-converter', 'meta.desc'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />


            <!-- Upload Area -->
            <x-file-dropzone id="dropZone" inputId="imageInput" accept="image/*" :title="__tool('image-to-base64-converter', 'input.drop_title')" :subtitle="__tool('image-to-base64-converter', 'input.drop_desc')" />

            <!-- Editor/Preview Area -->
            <div id="editorArea" class="hidden mt-8 grid lg:grid-cols-2 gap-8">
                <!-- Left Column: Image Preview -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 min-h-[300px]">
                    <img id="imagePreview" class="max-h-[400px] max-w-full object-contain rounded-lg shadow-sm" src=""
                        alt="{!! __tool('image-to-base64-converter', 'editor.image_alt') !!}">
                </div>

                <!-- Right Column: Output -->
                <div class="flex flex-col space-y-6">
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label
                                class="block text-sm font-bold text-gray-700">{!! __tool('image-to-base64-converter', 'editor.label_string') !!}</label>
                            <button id="copyBtn"
                                class="text-indigo-600 hover:text-indigo-800 font-bold text-xs uppercase tracking-wider flex items-center gap-1 bg-indigo-50 px-2 py-1 rounded transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                                {!! __tool('image-to-base64-converter', 'editor.btn_copy') !!}
                            </button>
                        </div>
                        <textarea id="base64Output" readonly
                            class="w-full h-48 bg-gray-50 border border-gray-200 rounded-xl p-4 font-mono text-xs text-gray-600 focus:border-indigo-500 focus:ring-0 resize-none shadow-inner"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                            <span
                                class="block text-xs font-bold text-gray-500 uppercase mb-1">{!! __tool('image-to-base64-converter', 'editor.char_count') !!}</span>
                            <span id="charCount" class="text-xl font-black text-indigo-600">0</span>
                        </div>
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
                            <span
                                class="block text-xs font-bold text-gray-500 uppercase mb-1">{!! __tool('image-to-base64-converter', 'editor.mime_type') !!}</span>
                            <span id="mimeType" class="text-xl font-black text-green-600">-</span>
                        </div>
                    </div>

                    <button id="uploadNewBtn"
                        class="text-gray-500 hover:text-indigo-600 font-medium transition-colors text-sm text-center w-full py-2">{{ __tool('image-to-base64-converter', 'editor.btn_upload_new') ?: 'Upload New Image' }}</button>
                </div>
            </div>


        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-3 block">{{ __tool('image-to-base64-converter', 'content.features.badge') ?: 'Why Use This Tool?' }}</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('image-to-base64-converter', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">{{ __tool('image-to-base64-converter', 'content.features.subtitle') ?: 'Essential for developers and designers.' }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('image-to-base64-converter', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('image-to-base64-converter', "content.features.f{$i}_desc") }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>

            <!-- How-to Section -->
             <section class="max-w-5xl mx-auto bg-gray-900 text-white rounded-[3rem] p-8 md:p-16 border border-gray-800 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-96 h-96 bg-indigo-600/20 rounded-full blur-[100px] -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-600/20 rounded-full blur-[80px] -ml-16 -mb-16"></div>

                <div class="relative z-10 text-center mb-16">
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('image-to-base64-converter', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">{{ __tool('image-to-base64-converter', 'content.how_to.subtitle') ?: 'Simple steps to encode your images.' }}</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('image-to-base64-converter', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg shadow-indigo-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('image-to-base64-converter', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('image-to-base64-converter', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('image-to-base64-converter', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('image-to-base64-converter', "content.faq.a$i"); @endphp
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
            const imagePreview = document.getElementById('imagePreview');
            const base64Output = document.getElementById('base64Output');
            const charCount = document.getElementById('charCount');
            const mimeType = document.getElementById('mimeType');
            const copyBtn = document.getElementById('copyBtn');
            const uploadNewBtn = document.getElementById('uploadNewBtn');

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
                base64Output.value = '';
                editorArea.classList.add('hidden');
                dropZone.classList.remove('hidden');
            });

            function handleFile(file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const result = e.target.result;
                    imagePreview.src = result;
                    base64Output.value = result;
                    charCount.innerText = result.length.toLocaleString();
                    mimeType.innerText = result.match(/:(.*?);/) ? result.match(/:(.*?);/)[1] : 'unknown';
                    dropZone.classList.add('hidden');
                    editorArea.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }

            copyBtn.addEventListener('click', () => {
                base64Output.select();
                document.execCommand('copy');
                const originalText = copyBtn.innerHTML;
                copyBtn.innerText = '{!! __tool('image-to-base64-converter', 'js.copied') !!}';
                setTimeout(() => { copyBtn.innerHTML = originalText; }, 2000);
            });
        </script>
    @endpush
@endsection