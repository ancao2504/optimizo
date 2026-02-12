@extends('layouts.app')

@section('title', __tool('base64-to-image-converter', 'meta.title'))
@section('meta_description', __tool('base64-to-image-converter', 'meta.description'))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-tool-hero :tool="$tool" />



            <div class="space-y-6">
                <!-- Input Area -->
                <div>
                    <label for="base64Input" class="block text-sm font-bold text-gray-700 mb-2">
                        {{ __tool('base64-to-image-converter', 'input.label') ?: 'Paste your Base64 string here' }}
                    </label>
                    <textarea id="base64Input"
                        placeholder="{!! __tool('base64-to-image-converter', 'input.placeholder') !!}"
                        class="w-full h-48 bg-gray-50 border border-gray-200 rounded-xl p-4 font-mono text-sm text-gray-700 focus:border-indigo-500 focus:ring-0 resize-none transition-all placeholder-gray-400 shadow-inner"></textarea>
                </div>

                <div class="flex justify-center">
                    <button id="convertBtn"
                        class="w-full md:w-auto px-8 py-3.5 bg-gray-900 hover:bg-black text-white font-bold rounded-xl shadow-lg transform hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {!! __tool('base64-to-image-converter', 'input.btn_decode') !!}
                    </button>
                </div>
            </div>

            <!-- Result Area -->
            <div id="resultArea"
                class="hidden mt-12 pt-12 border-t border-gray-100 grid md:grid-cols-2 gap-8 animate-fade-in">
                <!-- Left Column: Image Preview -->
                <div
                    class="bg-gray-50 rounded-2xl p-6 flex items-center justify-center border border-gray-100 min-h-[300px]">
                    <img id="imagePreview" class="max-h-[400px] max-w-full object-contain rounded-lg shadow-sm" src=""
                        alt="{!! __tool('base64-to-image-converter', 'result.image_alt') !!}">
                </div>

                <!-- Right Column: Actions -->
                <div class="flex flex-col justify-center space-y-6">
                    <div class="text-center">
                        <div
                            class="inline-flex items-center justify-center w-12 h-12 bg-green-100 text-green-600 rounded-full mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-1">
                            {!! __tool('base64-to-image-converter', 'result.success') !!}</h3>
                        <p class="text-gray-500 text-sm">{{ __tool('base64-to-image-converter', 'result.ready_message') ?: 'Your image is ready to download' }}</p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button id="downloadBtn"
                            class="w-full px-8 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            {!! __tool('base64-to-image-converter', 'result.btn_download') !!}
                        </button>
                        <button id="clearBtn"
                            class="w-full px-8 py-3.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold rounded-xl transition-colors">
                            {!! __tool('base64-to-image-converter', 'result.btn_clear') !!}
                        </button>
                    </div>
                </div>
            </div>


        <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- Features Grid -->
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-3 block">{{ __tool('base64-to-image-converter', 'content.features.badge') ?: 'Why Use This Tool?' }}</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool('base64-to-image-converter', 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">{{ __tool('base64-to-image-converter', 'content.features.subtitle') ?: 'Essential for developers and designers.' }}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 6) as $i)
                        @if($title = __tool('base64-to-image-converter', "content.features.f{$i}_title", false))
                            <div class="bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                                <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                                    {{ $i }}
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $title }}</h3>
                                <p class="text-gray-500 leading-relaxed">{{ __tool('base64-to-image-converter', "content.features.f{$i}_desc") }}</p>
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
                     <h2 class="text-3xl md:text-5xl font-black mb-6 text-white">{{ __tool('base64-to-image-converter', 'content.how_to.title') ?: 'How it Works' }}</h2>
                     <p class="text-gray-400 text-lg">{{ __tool('base64-to-image-converter', 'content.how_to.subtitle') ?: 'Simple steps to decode your images.' }}</p>
                </div>

                <div class="relative z-10 grid gap-8">
                    @foreach(range(1, 5) as $i)
                        @if($title = __tool('base64-to-image-converter', "content.how_to.step{$i}_title", false))
                            <div class="flex flex-col md:flex-row gap-6 items-start md:items-center p-6 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-indigo-600 text-white font-bold text-lg shadow-lg shadow-indigo-600/20">
                                    {{ $i }}
                                </span>
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $title }}</h3>
                                    <p class="text-gray-400 leading-relaxed">{{ __tool('base64-to-image-converter', "content.how_to.step{$i}_desc") }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>

            <!-- FAQ Section -->
            <section class="max-w-4xl mx-auto">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool('base64-to-image-converter', 'content.faq.title') ?: 'Frequently Asked Questions' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($q = __tool('base64-to-image-converter', "content.faq.q$i", false))
                            <div class="group rounded-2xl border border-gray-200 bg-white overflow-hidden transition-all duration-300 hover:border-indigo-200 hover:shadow-lg">
                                <details class="group">
                                    <summary class="flex justify-between items-center font-bold cursor-pointer list-none p-6 text-lg text-gray-900">
                                        <span>{{ $q }}</span>
                                        <span class="transition group-open:rotate-180">
                                            <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                                        </span>
                                    </summary>
                                    <div class="text-gray-600 px-6 pb-6 leading-relaxed">
                                        @php $a = __tool('base64-to-image-converter', "content.faq.a$i"); @endphp
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
            const base64Input = document.getElementById('base64Input');
            const convertBtn = document.getElementById('convertBtn');
            const resultArea = document.getElementById('resultArea');
            const imagePreview = document.getElementById('imagePreview');
            const downloadBtn = document.getElementById('downloadBtn');
            const clearBtn = document.getElementById('clearBtn');

            convertBtn.addEventListener('click', () => {
                const input = base64Input.value.trim();
                if (!input) { alert('{!! __tool('base64-to-image-converter', 'js.input_required') !!}'); return; }

                imagePreview.src = input;

                imagePreview.onerror = () => {
                    alert('{!! __tool('base64-to-image-converter', 'js.invalid_error') !!}');
                    resultArea.classList.add('hidden');
                };

                imagePreview.onload = () => {
                    resultArea.classList.remove('hidden');
                    resultArea.scrollIntoView({ behavior: 'smooth' });
                };
            });

            downloadBtn.addEventListener('click', () => {
                const link = document.createElement('a');
                link.href = imagePreview.src;
                // Try to guess extension from mime
                let ext = 'png';
                const match = imagePreview.src.match(/data:image\/(.*?);/);
                if (match && match[1]) ext = match[1];

                link.download = 'decoded-image.' + ext;
                link.click();
            });

            clearBtn.addEventListener('click', () => {
                base64Input.value = '';
                resultArea.classList.add('hidden');
                imagePreview.src = '';
            });
        </script>
    @endpush
@endsection