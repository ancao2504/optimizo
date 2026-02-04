@props(['id' => 'dropZone', 'inputId' => 'imageInput', 'accept' => 'image/*', 'title' => 'Upload Image', 'subtitle' => 'Drag & drop or click to browse', 'icon' => 'upload'])

<div id="{{ $id }}" {{ $attributes->merge(['class' => 'relative border-2 border-dashed border-gray-300 rounded-2xl p-12 text-center hover:border-indigo-500 hover:bg-indigo-50/50 transition-all duration-300 cursor-pointer group bg-gray-50/30']) }}>

    <input type="file" id="{{ $inputId }}" accept="{{ $accept }}"
        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">

    <div class="pointer-events-none relative z-10 transition-transform duration-300 group-hover:scale-105">
        <div
            class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-sm mb-6 group-hover:shadow-md transition-shadow">
            @if($icon === 'upload')
                <svg class="w-10 h-10 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
            @else
                <x-dynamic-component :component="'heroicon-o-' . $icon" class="w-10 h-10 text-indigo-500" />
            @endif
        </div>

        <h3 class="text-xl font-bold text-gray-900 mb-2 tracking-tight">{{ $title }}</h3>
        <p class="text-gray-500 font-medium">{{ $subtitle }}</p>
    </div>
</div>