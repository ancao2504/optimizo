@extends('layouts.app')

@section('title', isset($category) ? ($category->meta_title ?: $category->name . ' - ' . config('app.name')) : __('Blog - ' . config('app.name')))

@if(isset($category) && $category->meta_description)
@section('meta_description', $category->meta_description)
@endif

@push('scripts')
    {{-- Schema.org JSON-LD --}}
    <script type="application/ld+json">
            @php
                $breadcrumbItems = [
                    ['@type' => 'ListItem', 'position' => 1, 'name' => __('Home'), 'item' => localeRoute('home')],
                    ['@type' => 'ListItem', 'position' => 2, 'name' => __('Blog'), 'item' => localeRoute('blog.index')],
                ];
                if (isset($category)) {
                    $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $category->name, 'item' => url()->current()];
                }
            @endphp
            {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbItems
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
            </script>
@endpush

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">
                @if(isset($category))
                    {{ __('Category: :name', ['name' => $category->name]) }}
                @else
                    {{ __('Our Blog') }}
                @endif
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                {{ __('Exploring insights, tutorials, and latest updates from the Optimizo team.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article
                    class="bg-white rounded-[2rem] overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_50px_rgb(0,0,0,0.08)] transition-all duration-500 border border-gray-100/50 flex flex-col group h-full">
                    <a href="{{ localeRoute('blog.show', ['slug' => $post->slug]) }}"
                        class="relative aspect-video overflow-hidden">
                        @if($post->featured_image_url)
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div
                                class="w-full h-full bg-gradient-to-br from-indigo-600 to-purple-700 flex items-center justify-center p-8 group-hover:scale-110 transition-transform duration-700">
                                <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 2v6h6" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                        <div class="absolute top-4 left-4 flex gap-2">
                            @foreach($post->categories->take(1) as $cat)
                                <span
                                    class="px-3 py-1 bg-white/90 backdrop-blur-sm text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest shadow-sm">
                                    {{ $cat->name }}
                                </span>
                            @endforeach
                        </div>
                    </a>

                    <div class="p-8 flex-grow flex flex-col">
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                class="text-[10px] font-black text-gray-400 uppercase tracking-widest">{{ $post->published_at->format('M d, Y') }}</span>
                        </div>

                        <h2
                            class="text-2xl font-black text-gray-900 mb-4 group-hover:text-indigo-600 transition-colors leading-tight tracking-tight">
                            <a href="{{ localeRoute('blog.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                        </h2>

                        <p class="text-gray-600 line-clamp-3 mb-8 flex-grow leading-relaxed font-medium">
                            {{ $post->excerpt }}
                        </p>

                        <div class="flex items-center pt-6 border-t border-gray-50 mt-auto">
                            <div class="flex items-center">
                                <div
                                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white text-xs font-black mr-3 shadow-lg shadow-indigo-100">
                                    {{ strtoupper(substr($post->author->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-bold text-gray-700 tracking-tight">{{ $post->author->name }}</span>
                            </div>
                            <a href="{{ localeRoute('blog.show', ['slug' => $post->slug]) }}"
                                class="ml-auto text-indigo-600 font-extrabold text-sm flex items-center gap-1 group-hover:gap-2 transition-all">
                                {{ __('Read More') }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-20 text-center bg-gray-50 rounded-3xl border-2 border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ __('No posts found') }}</h2>
                    <p class="text-gray-500">{{ __('We haven\'t published any posts here yet. Check back soon!') }}</p>
                </div>
            @endforelse
        </div>

        <div class="mt-16 mb-8 flex justify-center">
            {{ $posts->links('partials.pagination') }}
        </div>
    </div>
@endsection