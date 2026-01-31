@extends('layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' - ' . config('app.name'))
@section('meta_description', $post->meta_description)
@section('canonical', localeRoute('blog.show', ['slug' => $post->slug]))

@push('scripts')
    {{-- Schema.org JSON-LD --}}
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "BlogPosting",
            "headline": {!! json_encode($post->title) !!},
            "image": {!! json_encode($post->featured_image_url ?? '') !!},
            "author": {
                "@@type": "Person",
                "name": {!! json_encode($post->author->name) !!}
            },
            "publisher": {
                "@@type": "Organization",
                "name": {!! json_encode(config('app.name')) !!},
                "logo": {
                    "@@type": "ImageObject",
                    "url": {!! json_encode(asset('logo.png')) !!}
                }
            },
            "datePublished": "{!! $post->published_at->toIso8601String() !!}",
            "dateModified": "{!! $post->updated_at->toIso8601String() !!}",
            "description": {!! json_encode($post->meta_description ?: Str::limit(strip_tags(str_replace(["\r\n", "\r", "\n"], ' ', $post->content)), 160)) !!},
            "mainEntityOfPage": {
                "@@type": "WebPage",
                "@@id": {!! json_encode(url()->current()) !!}
            }
        }
        </script>

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "BreadcrumbList",
            "itemListElement": [
                {
                    "@@type": "ListItem",
                    "position": 1,
                    "name": "Home",
                    "item": {!! json_encode(localeRoute('home')) !!}
                },
                {
                    "@@type": "ListItem",
                    "position": 2,
                    "name": "Blog",
                    "item": {!! json_encode(localeRoute('blog.index')) !!}
                },
                {
                    "@@type": "ListItem",
                    "position": 3,
                    "name": {!! json_encode($post->title) !!},
                    "item": {!! json_encode(url()->current()) !!}
                }
            ]
        }
        </script>
@endpush

@section('content')
    {{-- Reading Progress Bar --}}
    <div class="fixed top-[64px] left-0 w-full h-1.5 z-[100] pointer-events-none">
        <div id="readingProgress"
            class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 w-0 transition-all duration-150 shadow-[0_0_20px_rgba(139,92,246,0.6)]">
        </div>
    </div>

    {{-- Cinematic Full-Bleed Hero --}}
    <section class="relative h-[40vh] md:h-[50vh] min-h-[400px] w-full overflow-hidden mb-[-8vh] md:mb-[-12vh]">
        @if($post->featured_image_url)
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}"
                class="absolute inset-0 w-full h-full object-cover scale-105 animate-slow-zoom">
        @else
            <div class="absolute inset-0 bg-gradient-to-tr from-gray-900 via-indigo-950 to-purple-900"></div>
        @endif

        <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/80"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-transparent to-transparent"></div>

        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-end pb-24 md:pb-36">
            <div class="max-w-4xl space-y-4">
                <nav class="flex items-center gap-3 text-white/70 text-[10px] font-black uppercase tracking-[0.3em]">
                    <a href="{{ localeRoute('home') }}" class="hover:text-white transition-colors">Home</a>
                    <span class="w-1 h-1 rounded-full bg-indigo-500"></span>
                    <a href="{{ localeRoute('blog.index') }}" class="hover:text-white transition-colors">Blog</a>
                </nav>

                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white leading-[1.1] tracking-tight text-glow">
                    {{ $post->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-6 text-white pt-2">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center text-lg font-black">
                            {{ strtoupper(substr($post->author->name, 0, 1)) }}
                        </div>
                        <span class="font-bold text-sm tracking-wide">{{ $post->author->name }}</span>
                    </div>
                    <div class="w-px h-4 bg-white/20 hidden sm:block"></div>
                    <span class="text-white/60 text-sm font-medium">{{ $post->published_at->format('M d, Y') }}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Unified Content Container --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Background Effects --}}
        <div
            class="absolute -top-[10%] left-1/4 w-[40rem] h-[40rem] bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none">
        </div>
        <div
            class="absolute top-[30%] -right-1/4 w-[40rem] h-[40rem] bg-purple-600/10 rounded-full blur-[120px] pointer-events-none">
        </div>

        {{-- Author Bio Card: Stunning Redesign --}}
        <div class="mb-12 md:mb-20">
            <div
                class="relative p-1 md:p-1.5 bg-gradient-to-br from-indigo-500/30 via-purple-500/30 to-pink-500/30 rounded-[3rem] md:rounded-[4rem] group overflow-hidden shadow-2xl">
                <div class="absolute inset-0 bg-gray-950 rounded-[2.9rem] md:rounded-[3.9rem]"></div>
                <div
                    class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/dark-matter.png')] opacity-20 pointer-events-none">
                </div>
                <div
                    class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-600/20 rounded-full blur-[100px] group-hover:bg-indigo-600/40 transition-all duration-700">
                </div>

                <div class="relative p-8 md:p-12 lg:p-16 flex flex-col md:flex-row items-center gap-10 md:gap-14">
                    <div class="relative flex-shrink-0">
                        <div
                            class="w-28 h-28 md:w-40 md:h-40 rounded-[2.5rem] bg-gradient-to-tr from-indigo-500 to-purple-600 p-1.5 shadow-2xl rotate-3 group-hover:rotate-6 transition-transform duration-500">
                            <div
                                class="w-full h-full bg-gray-950 rounded-[2.2rem] flex items-center justify-center text-4xl md:text-5xl font-black text-white">
                                {{ strtoupper(substr($post->author->name, 0, 1)) }}
                            </div>
                        </div>
                        <div
                            class="absolute -bottom-2 -right-2 w-10 h-10 md:w-12 md:h-12 bg-green-500 border-4 md:border-8 border-gray-950 rounded-full">
                        </div>
                    </div>
                    <div class="text-center md:text-left flex-grow">
                        <span
                            class="text-indigo-400 text-xs md:text-sm font-black uppercase tracking-[0.4em] mb-3 block">Expert
                            Reviewer</span>
                        <h3 class="text-2xl md:text-4xl font-black text-white mb-4 tracking-tight leading-tight">
                            Masterfully written by {{ $post->author->name }}
                        </h3>
                        <p class="text-gray-400 leading-relaxed text-base md:text-xl max-w-3xl opacity-80">
                            Deep-diving into tech trends and architectural paradigms. Bringing you over 15 years of industry
                            insights concentrated into every single word you read.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Content & Sidebar Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 lg:gap-16">

            {{-- Article Main Column (Span 8) --}}
            <main class="md:col-span-8 space-y-12">
                <div
                    class="bg-white/70 backdrop-blur-3xl rounded-[3rem] md:rounded-[4rem] p-8 md:p-16 lg:p-20 shadow-[0_20px_80px_rgba(0,0,0,0.02)] border border-white/50">

                    {{-- Blog Categories --}}
                    <div class="flex flex-wrap gap-3 mb-12">
                        @foreach($post->categories as $cat)
                            <a href="{{ localeRoute('blog.category', ['slug' => $cat->slug]) }}"
                                class="px-6 py-2.5 bg-indigo-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-[0.1em] shadow-xl shadow-indigo-100 ring-4 ring-indigo-50 hover:ring-indigo-100 transition-all">
                                {{ $cat->name }}
                            </a>
                        @endforeach
                    </div>

                    {{-- Dynamic Reading Content --}}
                    <article
                        class="prose prose-lg md:prose-xl prose-indigo max-w-none blog-content selection:bg-indigo-100">
                        {!! $post->content !!}
                    </article>

                    <div
                        class="mt-20 pt-10 border-t border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-8">
                        <div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] block mb-4">Share
                                this story</span>
                            <div class="flex gap-4">
                                <button
                                    class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </button>
                                <button
                                    class="w-12 h-12 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-black hover:text-white transition-all shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25h6.91l4.715 6.238L18.244 2.25z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <a href="{{ localeRoute('blog.index') }}"
                            class="group flex items-center gap-3 px-8 py-5 bg-gray-50 rounded-3xl text-gray-900 font-black hover:bg-gray-950 hover:text-white transition-all">
                            Back to Blog
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </main>

            {{-- Sidebar Column (Span 4) --}}
            <aside class="md:col-span-4 space-y-12">
                <div class="sticky top-28 space-y-12">

                    {{-- Stunning Categories Widget --}}
                    <div class="relative group">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-[3rem] blur-3xl opacity-5 group-hover:opacity-20 transition-all duration-700">
                        </div>
                        <div
                            class="relative bg-white/70 backdrop-blur-3xl rounded-[3rem] p-10 border border-white/50 shadow-2xl">
                            <div class="flex items-center gap-5 mb-10">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-xl shadow-indigo-100">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-gray-950 tracking-tight">Categories</h3>
                            </div>

                            <div class="space-y-3">
                                @foreach($categories as $cat)
                                    <a href="{{ localeRoute('blog.category', ['slug' => $cat->slug]) }}"
                                        class="group/item flex items-center justify-between p-5 rounded-[1.8rem] bg-gray-50/50 hover:bg-indigo-600 transition-all duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-200">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-3 h-3 rounded-full bg-indigo-400 group-hover/item:bg-white transition-colors">
                                            </div>
                                            <span
                                                class="text-gray-900 group-hover/item:text-white font-black text-lg tracking-tight transition-colors">{{ $cat->name }}</span>
                                        </div>
                                        <span
                                            class="px-4 py-1.5 bg-white/20 text-gray-400 group-hover/item:text-white rounded-xl text-xs font-black transition-all">
                                            {{ $cat->posts_count }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Stunning Hot Stories Widget --}}
                    <div class="relative overflow-hidden bg-gray-950 rounded-[3rem] shadow-2xl group/stories">
                        <div
                            class="absolute inset-x-0 bottom-0 h-64 bg-gradient-to-t from-indigo-500/20 to-transparent opacity-0 group-hover/stories:opacity-100 transition-opacity duration-1000">
                        </div>
                        <div class="p-10 relative">
                            <div class="flex items-center gap-5 mb-14">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-purple-600 to-pink-600 flex items-center justify-center shadow-xl shadow-purple-500/20">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.5-7 3 3 3.5 1.3 5 3 2 2 2 2 2 5a7.978 7.978 0 01-1.343 4.657z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-white tracking-tight">Hot Stories</h3>
                            </div>

                            <div class="space-y-12">
                                @foreach($recentPosts as $recent)
                                    <a href="{{ localeRoute('blog.show', ['slug' => $recent->slug]) }}"
                                        class="group/story block relative">
                                        <div class="flex items-center gap-3 mb-4">
                                            <span
                                                class="px-3 py-1 bg-white/5 text-indigo-400 text-[9px] font-black uppercase tracking-[0.2em] rounded-lg group-hover/story:bg-indigo-600 group-hover/story:text-white transition-all">
                                                {{ $recent->published_at->format('M d, Y') }}
                                            </span>
                                            <div
                                                class="flex-grow h-px bg-white/10 group-hover/story:bg-indigo-500/30 transition-all">
                                            </div>
                                        </div>
                                        <h4
                                            class="text-xl font-black text-gray-200 group-hover/story:text-white leading-[1.3] transition-colors tracking-tight">
                                            {{ $recent->title }}
                                        </h4>
                                        <p
                                            class="mt-4 text-sm text-gray-500 group-hover/story:text-gray-400 transition-colors line-clamp-2 leading-relaxed opacity-70">
                                            {{ Str::limit(strip_tags($recent->content), 90) }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-14">
                                <a href="{{ localeRoute('blog.index') }}"
                                    class="flex items-center justify-center p-6 rounded-[2rem] bg-white/5 border border-white/10 text-white font-black hover:bg-white hover:text-black transition-all group/btn">
                                    View All Articles
                                    <svg class="ml-3 w-5 h-5 transform group-hover/btn:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>


    <script>
        document.addEventListener('scroll', () => {
            const h = document.documentElement,
                b = document.body,
                st = 'scrollTop',
                sh = 'scrollHeight';
            const progress = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
            const progressBar = document.getElementById('readingProgress');
            if (progressBar) progressBar.style.width = progress + '%';
        });

        // Use a more subtle entry animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, { threshold: 0.05 });

        document.querySelectorAll('.blog-content > *').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'all 0.8s cubic-bezier(0.2, 0.8, 0.2, 1)';

            // Add a class when it becomes visible
            observer.observe(el);
        });

        // Add class helper for visibility
        const style = document.createElement('style');
        style.innerHTML = `
                                                .is-visible {
                                                    opacity: 1 !important;
                                                    transform: translateY(0) !important;
                                                }
                                            `;
        document.head.appendChild(style);
    </script>
@endsection