@props(['position' => 'header'])

@php
    $currentLocale = app()->getLocale();
    $languages = $availableLanguages ?? \App\Models\Language::active()->orderBy('order')->get();
    $currentLang = $languages->firstWhere('code', $currentLocale) ?? $languages->first();
@endphp

<div class="relative inline-block text-left language-switcher" x-data="{ open: false }">
    <div>
        <button @click="open = !open" @click.away="open = false" type="button"
            class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors"
            style="min-width: 130px;">
            <span class="mr-2 flex items-center">
                <span class="fi fi-{{ $currentLang->flag_code ?? $currentLang->code }} rounded-sm shadow-sm"
                    style="font-size: 1.25em;"></span>
            </span>
            <span>{{ $currentLang->native_name }}</span>
            <svg class="-mr-1 ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 w-48 rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
        style="display: none;">
        <div class="py-1" style="max-height: 300px; overflow-y: auto;">
            @foreach($languages as $language)
                @php
                    // Get current path without locale prefix
                    $currentPath = request()->path();
                    $segments = explode('/', $currentPath);

                    // Remove existing locale if present
                    $activeCodes = $languages->pluck('code')->toArray();
                    if (!empty($segments) && in_array($segments[0], $activeCodes)) {
                        array_shift($segments);
                    }

                    // Build new URL with locale prefix (except for 'en')
                    // If we are in blog, always redirect to blog index because blogs are language based
                    if (!empty($segments) && $segments[0] === 'blog') {
                        $segments = ['blog'];
                    }

                    if ($language->code !== 'en') {
                        $newPath = '/' . $language->code . '/' . implode('/', $segments);
                    } else {
                        $newPath = '/' . implode('/', $segments);
                    }

                    // Clean up double slashes
                    $newPath = preg_replace('#/+#', '/', $newPath);
                    if ($newPath === '/') {
                        $newPath = $language->code !== 'en' ? '/' . $language->code : '/';
                    }
                @endphp
                <a href="{{ url($newPath) }}"
                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors {{ $language->code === $currentLocale ? 'bg-indigo-50 text-indigo-600 font-semibold' : '' }}">
                    <span class="mr-3 flex items-center">
                        <span class="fi fi-{{ $language->flag_code ?? $language->code }} rounded-sm shadow-sm"
                            style="font-size: 1.25em;"></span>
                    </span>
                    <span class="flex-1">{{ $language->native_name }}</span>
                    @if($language->code === $currentLocale)
                        <svg class="h-4 w-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>