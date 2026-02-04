@props(['title' => '', 'description' => ''])

<div {{ $attributes->merge(['class' => 'bg-white rounded-3xl p-6 md:p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 mb-12 relative overflow-hidden']) }}>
    <!-- Decorative background elements -->
    <div
        class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-gradient-to-br from-indigo-50 to-blue-50 rounded-full opacity-50 blur-3xl pointer-events-none">
    </div>

    <div class="relative z-10">
        @if($title)
            <div class="text-center max-w-2xl mx-auto mb-10">
                <h2 class="text-3xl font-black text-gray-900 mb-3 tracking-tight">{{ $title }}</h2>
                @if($description)
                    <p class="text-lg text-gray-500 font-light leading-relaxed">{{ $description }}</p>
                @endif
            </div>
        @endif

        {{ $slot }}
    </div>
</div>