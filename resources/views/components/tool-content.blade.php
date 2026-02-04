@props(['tool'])

@php
    $slug = $tool->slug ?? '';
    
    // Check for V2 content using specific unique keys
    // V1 shares 'features', 'how_to', 'faq' keys but with different structure
    $hasV2Content = 
        __tool($slug, "content.intro", false) || 
        __tool($slug, "content.story", false) || 
        __tool($slug, "content.features.f1_title", false) || 
        __tool($slug, "content.how_to.step1_title", false) || 
        __tool($slug, "content.faq.q1", false);

    // Check for V1 content (standard structure in most JSONs)
    $title = __tool($slug, 'content.title', false);
    $p1 = __tool($slug, 'content.p1', false);
    $hasV1Content = $title || $p1;
@endphp

@if($hasV2Content)
    <div class="space-y-24 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- V2 Intro Section -->
        @if(__tool($slug, 'content.intro.p1', false))
            <section class="max-w-4xl mx-auto text-center relative">
                <div class="absolute inset-0 -z-10 bg-[radial-gradient(45%_45%_at_50%_50%,rgba(99,102,241,0.08)_0%,rgba(255,255,255,0)_100%)]"></div>
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold tracking-wide uppercase mb-8 border border-indigo-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600"></span>
                    Professional Tool
                </span>
                <h1 class="text-5xl md:text-6xl font-black text-gray-900 mb-8 tracking-tight leading-[1.1] bg-clip-text">
                    {{ __tool($slug, 'content.intro.title') ?: $tool->name }}
                </h1>
                <p class="text-xl md:text-2xl text-gray-500 mb-12 leading-relaxed font-light max-w-2xl mx-auto">
                    {{ __tool($slug, 'content.intro.subtitle') }}
                </p>
                <div class="prose prose-lg prose-indigo mx-auto text-gray-600 text-left bg-white rounded-3xl p-8 md:p-12 shadow-[0_2px_40px_-12px_rgba(0,0,0,0.08)] border border-gray-100">
                     @foreach(range(1, 10) as $i)
                        @if($p = __tool($slug, "content.intro.p$i", false))
                            <p class="leading-relaxed">{{ $p }}</p>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <!-- V2 Story Layout -->
        @if(__tool($slug, 'content.story.title', false))
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-8">
                     <h2 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-4">
                        <span class="flex-shrink-0 w-12 h-1 bg-indigo-600 rounded-full"></span>
                        {{ __tool($slug, 'content.story.title') }}
                    </h2>
                    <div class="prose prose-indigo prose-lg text-gray-600 max-w-none">
                        @foreach(range(1, 10) as $i)
                            @if($p = __tool($slug, "content.story.p$i", false))
                                <p>{{ $p }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="lg:col-span-4 space-y-8 sticky top-8">
                    <div class="bg-slate-900 rounded-2xl p-8 text-white shadow-xl overflow-hidden relative group">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500 opacity-20 blur-3xl group-hover:opacity-30 transition-opacity"></div>
                        <h3 class="text-lg font-bold mb-6 flex items-center gap-2 border-b border-indigo-500/30 pb-4">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            Key Insights
                        </h3>
                        <div class="space-y-4 text-sm font-light text-slate-300">
                             @foreach(range(11, 20) as $i)
                                @if($p = __tool($slug, "content.story.p$i", false))
                                    <div class="flex gap-3">
                                        <span class="text-indigo-500 mt-1">●</span>
                                        <p class="leading-relaxed">{{ $p }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="bg-indigo-50/50 rounded-2xl p-6 border border-indigo-100">
                        <x-tool-icon :slug="$slug" class="w-8 h-8 text-indigo-600 mb-4" />
                        <p class="text-sm text-indigo-900 font-medium italic">"{{ __tool($slug, 'content.intro.subtitle') }}"</p>
                    </div>
                </div>
            </section>
        @endif

        <!-- V2 Features -->
        @if(__tool($slug, 'content.features.f1_title', false))
            <section>
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">{{ __tool($slug, 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-gray-500">Everything you need, nothing you don't.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 auto-rows-[minmax(200px,auto)] gap-6">
                    @foreach(range(1, 15) as $i)
                        @if($title = __tool($slug, "content.features.f{$i}_title", false))
                            @php
                                $isLarge = $i === 1 || $i === 7;
                                $classes = $isLarge ? 'md:col-span-2 md:row-span-1 bg-indigo-600 text-white' : 'bg-white text-gray-900 border border-gray-100';
                                $textClass = $isLarge ? 'text-indigo-100' : 'text-gray-500';
                                $titleClass = $isLarge ? 'text-white' : 'text-gray-900';
                                $iconBg = $isLarge ? 'bg-white/20 text-white' : 'bg-indigo-50 text-indigo-600';
                            @endphp
                            <div class="{{ $classes }} rounded-3xl p-8 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                                <div class="relative z-10 h-full flex flex-col justify-between">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="w-12 h-12 {{ $iconBg }} rounded-2xl flex items-center justify-center text-xl font-bold">{{ $i }}</div>
                                        @if($isLarge) <div class="bg-white/20 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Featured</div> @endif
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold {{ $titleClass }} mb-2">{{ $title }}</h3>
                                        <p class="{{ $textClass }} text-sm leading-relaxed">{{ __tool($slug, "content.features.f{$i}_desc") }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <!-- V2 How-to -->
        @if(__tool($slug, 'content.how_to.step1_title', false))
             <section class="max-w-5xl mx-auto">
                <div class="text-center mb-16">
                     <h2 class="text-3xl font-black text-gray-900">{{ __tool($slug, 'content.how_to.title') ?: 'How to Use' }}</h2>
                </div>
                <div class="space-y-4">
                    @foreach(range(1, 10) as $i)
                        @if($title = __tool($slug, "content.how_to.step{$i}_title", false))
                            <div class="group flex md:items-center gap-6 p-6 rounded-2xl bg-white border border-gray-100 hover:border-indigo-100 hover:shadow-md transition-all">
                                <span class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-xl bg-gray-50 text-gray-400 font-bold group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <div class="flex-grow">
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $title }}</h3>
                                    <p class="text-gray-500 text-sm mt-1">{{ __tool($slug, "content.how_to.step{$i}_desc") }}</p>
                                </div>
                                <div class="hidden md:block text-indigo-200 group-hover:text-indigo-400 transition-colors">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>
        @endif

        <!-- V2 FAQ -->
        @if(__tool($slug, 'content.faq.q1', false))
            <section class="border-t border-gray-100 pt-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div>
                        <span class="text-indigo-600 font-bold uppercase tracking-widest text-xs mb-2 block">Support</span>
                        <h2 class="text-3xl font-black text-gray-900 mb-4">{{ __tool($slug, 'content.faq.title') ?: 'FAQs' }}</h2>
                        <p class="text-gray-500">Common questions about this tool and its technology.</p>
                    </div>
                    <div class="md:col-span-2 space-y-6">
                        @foreach(range(1, 15) as $i)
                            @if($q = __tool($slug, "content.faq.q$i", false))
                                <div class="pb-6 border-b border-gray-100">
                                    <h3 class="text-lg font-bold text-gray-900 mb-2 flex gap-3">
                                        <span class="text-indigo-300">Q.</span> {{ $q }}
                                    </h3>
                                    <div class="text-gray-600 pl-7 text-sm leading-relaxed">
                                        @php $a = __tool($slug, "content.faq.a$i"); @endphp
                                        @if(is_array($a))
                                            <ul class="list-disc pl-4 space-y-1">@foreach($a as $item) <li>{{ $item }}</li> @endforeach</ul>
                                        @else
                                            {{ $a }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </div>

@elseif($hasV1Content)
    <!-- V1 Compatibility Mode -->
    <div class="space-y-16 mt-16 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(__tool($slug, 'content.title', false))
            <section class="text-center max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">{{ __tool($slug, 'content.title') }}</h2>
                <div class="prose prose-lg mx-auto text-gray-600">
                    @if($p1 = __tool($slug, 'content.p1', false)) <p>{{ $p1 }}</p> @endif
                    @if($p2 = __tool($slug, 'content.p2', false)) <p>{{ $p2 }}</p> @endif
                </div>
            </section>
        @endif

        @if($features = __tool($slug, 'content.features', false))
            @if(is_array($features))
                <section>
                    <h3 class="text-2xl font-bold text-gray-900 text-center mb-10">Features</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($features as $key => $feature)
                             @if(is_array($feature) && isset($feature['title']))
                                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
                                    <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $feature['title'] }}</h4>
                                    <p class="text-gray-600 text-sm">{{ $feature['desc'] ?? '' }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif
        @endif

        @if($howTo = __tool($slug, 'content.how_to', false))
            <section class="bg-gray-50 rounded-2xl p-8 md:p-12">
                 <h3 class="text-2xl font-bold text-gray-900 text-center mb-8">{{ $howTo['title'] ?? 'How to Use' }}</h3>
                 @if(isset($howTo['list']) && is_array($howTo['list']))
                    <div class="grid gap-4 max-w-3xl mx-auto">
                        @foreach($howTo['list'] as $index => $step)
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold flex-shrink-0">
                                    {{ $index + 1 }}
                                </div>
                                <p class="text-gray-700 pt-1">{{ $step }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        @endif
        
        @if($why = __tool($slug, 'content.why', false))
            <section class="max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $why['title'] ?? 'Why use this tool?' }}</h3>
                 @if(isset($why['list']) && is_array($why['list']))
                    <ul class="space-y-3">
                        @foreach($why['list'] as $item)
                            <li class="flex gap-3 items-start">
                                <svg class="w-5 h-5 text-green-500 mt-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                <span class="text-gray-700">{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                 @endif
                 @if(isset($why['p1'])) <p class="mt-4 text-gray-600">{{ $why['p1'] }}</p> @endif
            </section>
        @endif
    </div>
@else
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center border-2 border-dashed border-red-300 bg-red-50 rounded-xl mt-16">
        <h3 class="text-lg font-bold text-red-700">Content Not Found (Debug Mode)</h3>
        <p class="text-red-600">
            Slug: {{ $slug }}<br>
            V2 Detected: {{ $hasV2Content ? 'YES' : 'NO' }}<br>
            V1 Detected: {{ $hasV1Content ? 'YES' : 'NO' }}
        </p>
        <div class="mt-4 text-left bg-white p-4 rounded border border-red-200 text-xs font-mono overflow-auto max-h-48">
            <strong>Check Details:</strong><br>
            V1 Title: {{ __tool($slug, 'content.title', 'NULL') }}<br>
            V1 P1: {{ __tool($slug, 'content.p1', 'NULL') }}
        </div>
    </div>
@endif