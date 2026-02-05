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
    <div class="space-y-32 mt-24 font-sans mb-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- V2 Intro Section -->
        @if(__tool($slug, 'content.intro.p1', false))
            <section class="max-w-5xl mx-auto text-center relative">
                <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_center,rgba(99,102,241,0.15)_0%,rgba(255,255,255,0)_70%)] blur-3xl"></div>
                
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 shadow-sm mb-10 transition-transform hover:scale-105 cursor-default">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    <span class="text-xs font-bold tracking-wide uppercase text-indigo-700">Professional Tool</span>
                </div>

                <h2 class="text-5xl md:text-7xl font-black text-gray-900 mb-8 tracking-tight leading-[1.1] drop-shadow-sm">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-gray-900 via-indigo-900 to-indigo-800">
                        {{ __tool($slug, 'content.intro.title') ?: $tool->name }}
                    </span>
                </h2>
                
                <p class="text-xl md:text-2xl text-gray-600 mb-14 leading-relaxed font-light max-w-3xl mx-auto">
                    {{ __tool($slug, 'content.intro.subtitle') }}
                </p>

                <div class="prose prose-lg md:prose-xl prose-indigo mx-auto text-gray-600 text-left bg-white/80 backdrop-blur-sm rounded-[2rem] p-8 md:p-14 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100/50 ring-1 ring-gray-900/5">
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
            <section class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
                <div class="lg:col-span-7">
                     <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-10 flex items-center gap-4">
                        <span class="flex-shrink-0 w-16 h-1.5 bg-indigo-600 rounded-full"></span>
                        {{ __tool($slug, 'content.story.title') }}
                    </h2>
                    <div class="prose prose-lg prose-slate text-gray-600 max-w-none space-y-6">
                        @foreach(range(1, 10) as $i)
                            @if($p = __tool($slug, "content.story.p$i", false))
                                <p>{{ $p }}</p>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="lg:col-span-5 space-y-8 sticky top-12">
                    <div class="bg-slate-900 rounded-[2rem] p-10 text-white shadow-2xl shadow-indigo-900/20 overflow-hidden relative group transform transition-all hover:scale-[1.02] duration-500">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-indigo-500 opacity-20 blur-[60px] group-hover:opacity-30 transition-opacity duration-700"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-purple-500 opacity-10 blur-[50px]"></div>
                        
                        <h3 class="relative text-xl font-bold mb-8 flex items-center gap-3 border-b border-white/10 pb-6">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            Key Insights
                        </h3>
                        <div class="relative space-y-5 text-slate-300">
                             @foreach(range(11, 20) as $i)
                                @if($p = __tool($slug, "content.story.p$i", false))
                                    <div class="flex gap-4 items-start group/item">
                                        <span class="flex-shrink-0 mt-1.5 w-1.5 h-1.5 rounded-full bg-indigo-500 group-hover/item:bg-indigo-400 transition-colors"></span>
                                        <p class="leading-relaxed text-sm md:text-base font-light">{{ $p }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-indigo-50 to-white rounded-3xl p-8 border border-indigo-100/60 shadow-lg shadow-indigo-100/30">
                        <div class="flex items-start gap-4">
                            <div class="p-3 bg-white rounded-2xl shadow-sm border border-indigo-50">
                                <x-tool-icon :slug="$slug" class="w-8 h-8 text-indigo-600" />
                            </div>
                            <div>
                                <h4 class="text-indigo-900 font-bold mb-2">Did you know?</h4>
                                <p class="text-sm text-indigo-800/80 italic leading-relaxed">"{{ __tool($slug, 'content.intro.subtitle') }}"</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- V2 Features -->
        @if(__tool($slug, 'content.features.f1_title', false))
            <section class="relative">
                <div class="text-center max-w-3xl mx-auto mb-20">
                    <span class="text-indigo-600 font-bold tracking-widest uppercase text-sm mb-3 block">Powerful Capabilities</span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 mb-6">{{ __tool($slug, 'content.features.title') ?: 'Key Features' }}</h2>
                    <p class="text-xl text-gray-500 font-light">Everything you need to get the job done efficiently.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach(range(1, 15) as $i)
                        @if($title = __tool($slug, "content.features.f{$i}_title", false))
                            @php
                                $isLarge = $i === 1 || $i === 7;
                                $classes = $isLarge 
                                    ? 'md:col-span-2 bg-gradient-to-br from-indigo-600 to-indigo-800 text-white shadow-xl shadow-indigo-900/20' 
                                    : 'bg-white text-gray-900 border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1';
                                $textClass = $isLarge ? 'text-indigo-100' : 'text-gray-500';
                                $titleClass = $isLarge ? 'text-white' : 'text-gray-900';
                                $iconBg = $isLarge ? 'bg-white/20 text-white backdrop-blur-sm' : 'bg-indigo-50 text-indigo-600 group-hover:scale-110 transition-transform duration-300';
                            @endphp
                            <div class="{{ $classes }} rounded-[2rem] p-10 relative overflow-hidden group transition-all duration-300">
                                @if($isLarge)
                                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16"></div>
                                @endif
                                
                                <div class="relative z-10 h-full flex flex-col items-start gap-6">
                                    <div class="w-14 h-14 {{ $iconBg }} rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm">
                                        {{ $i }}
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-2xl font-bold {{ $titleClass }} mb-3">{{ $title }}</h3>
                                        <p class="{{ $textClass }} text-base leading-relaxed">{{ __tool($slug, "content.features.f{$i}_desc") }}</p>
                                    </div>
                                    
                                    @if($isLarge) 
                                        <div class="mt-auto pt-4">
                                            <span class="inline-block bg-white/20 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider text-white backdrop-blur-sm">Featured Capability</span>
                                        </div> 
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </section>
        @endif

        <!-- V2 How-to -->
        @if(__tool($slug, 'content.how_to.step1_title', false))
             <section class="max-w-5xl mx-auto bg-gray-50/50 rounded-[3rem] p-8 md:p-16 border border-gray-100">
                <div class="text-center mb-16">
                     <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">{{ __tool($slug, 'content.how_to.title') ?: 'How to Use' }}</h2>
                     <p class="text-gray-500">Step-by-step guide to mastery.</p>
                </div>
                <div class="space-y-6">
                    @foreach(range(1, 10) as $i)
                        @if($title = __tool($slug, "content.how_to.step{$i}_title", false))
                            <div class="group flex flex-col md:flex-row md:items-center gap-8 p-8 rounded-3xl bg-white border border-gray-100 hover:border-indigo-200 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all duration-300">
                                <span class="flex-shrink-0 w-16 h-16 flex items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-50 to-white border border-indigo-100 text-indigo-600 font-black text-xl shadow-sm group-hover:scale-110 transition-transform duration-300">
                                    {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                                </span>
                                <div class="flex-grow">
                                    <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors mb-2">{{ $title }}</h3>
                                    <p class="text-gray-600 leading-relaxed">{{ __tool($slug, "content.how_to.step{$i}_desc") }}</p>
                                </div>
                                <div class="hidden md:block text-indigo-100 group-hover:text-indigo-400 group-hover:translate-x-2 transition-all duration-300">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
             </section>
        @endif

        <!-- V2 FAQ -->
        @if(__tool($slug, 'content.faq.q1', false))
            <section class="border-t border-gray-100 pt-24">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                    <div class="lg:col-span-4">
                        <div class="sticky top-12">
                            <span class="text-indigo-600 font-bold uppercase tracking-widest text-xs mb-3 block">Generic Support</span>
                            <h2 class="text-4xl font-black text-gray-900 mb-6">{{ __tool($slug, 'content.faq.title') ?: 'FAQs' }}</h2>
                            <p class="text-gray-500 text-lg mb-8 leading-relaxed">Common questions about this tool, its technology, and how to get the best results.</p>
                            <div class="bg-indigo-50 rounded-2xl p-6">
                                <p class="text-sm text-indigo-900 font-medium mb-2">Still have questions?</p>
                                <a href="/contact" class="text-indigo-600 font-bold hover:underline">Contact our support team &rarr;</a>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-8 space-y-4">
                        @foreach(range(1, 15) as $i)
                            @if($q = __tool($slug, "content.faq.q$i", false))
                                <div class="rounded-2xl border border-gray-100 bg-white overflow-hidden hover:border-indigo-100 transition-colors">
                                    <div class="p-8">
                                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-start gap-4">
                                            <span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 font-bold text-sm mt-0.5">Q</span>
                                            {{ $q }}
                                        </h3>
                                        <div class="text-gray-600 pl-12 text-base leading-relaxed">
                                            @php $a = __tool($slug, "content.faq.a$i"); @endphp
                                            @if(is_array($a))
                                                <ul class="list-disc pl-4 space-y-2">@foreach($a as $item) <li>{{ $item }}</li> @endforeach</ul>
                                            @else
                                                {{ $a }}
                                            @endif
                                        </div>
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
@endif