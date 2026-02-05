@props(['id' => 'dropZone', 'inputId' => 'imageInput', 'accept' => 'image/*', 'title' => 'Upload Image', 'subtitle' => 'Drag & drop or click to browse', 'icon' => 'upload'])

<div id="{{ $id }}" {{ $attributes->merge(['class' => 'relative border-2 border-dashed border-indigo-200 rounded-3xl p-10 md:p-16 text-center hover:border-indigo-500 hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300 cursor-pointer group bg-white shadow-[0_8px_30px_rgb(0,0,0,0.04)]']) }}>

    <input type="file" id="{{ $inputId }}" accept="{{ $accept }}"
        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">

    <div class="pointer-events-none relative z-10 transition-transform duration-300 group-hover:scale-105">
        <div
            class="inline-flex items-center justify-center w-24 h-24 bg-indigo-50 rounded-3xl mb-8 group-hover:rotate-6 transition-all duration-300">
            @if($icon === 'upload')
                <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
            @else
                <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-12 h-12 text-indigo-600" />
            @endif
        </div>

        <h3 class="text-3xl font-black text-gray-900 mb-3 tracking-tight">{{ $title }}</h3>
        <p class="text-lg text-gray-500 font-medium">{{ $subtitle }}</p>
    </div>
</div>