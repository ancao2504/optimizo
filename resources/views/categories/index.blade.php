@extends('layouts.app')

@section('title', __("categories." . str_replace('-', '_', $category->slug) . "_meta_title", [], 
    __('categories.meta_title', ['category' => __('categories.' . str_replace('-', '_', $category->slug) . '_title')])
))
@section('meta_description', __("categories." . str_replace('-', '_', $category->slug) . "_meta_description", [], 
    __('categories.meta_description', ['category' => strtolower(__('categories.' . str_replace('-', '_', $category->slug) . '_title'))])
))

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Hero Section -->
        <div class="relative overflow-hidden bg-gradient-to-br from-[{{ $category->bg_gradient_from }}] via-[{{ $category->bg_gradient_from }}] to-[{{ $category->bg_gradient_to }}] rounded-2xl p-6 mb-8 shadow-xl"
            style="background: linear-gradient(to bottom right, {{ $category->bg_gradient_from }}, {{ $category->bg_gradient_to }});">

            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-xl shadow-lg mb-3">
                    <!-- Dynamic Icon based on slug -->
                    <svg class="w-10 h-10" style="color: {{ $category->bg_gradient_to }}" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        @if($category->slug == 'youtube')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        @elseif($category->slug == 'seo')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        @elseif($category->slug == 'utility')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        @elseif($category->slug == 'network')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        @endif
                    </svg>
                </div>
                <h1 class="text-2xl md:text-3xl font-black text-white mb-2 leading-tight">
                    {{ __('categories.' . str_replace('-', '_', $category->slug) . '_title', ['default' => $category->name]) }}
                </h1>
                <p class="text-sm md:text-base text-white/90 font-medium max-w-2xl mx-auto mb-3">
                    {{ __('categories.' . str_replace('-', '_', $category->slug) . '_subtitle', ['default' => $category->description]) }}
                </p>

                <!-- Stats -->
                <div class="flex flex-wrap justify-center gap-3">
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <div class="text-2xl font-black text-white">{{ collect($tools)->count() }}</div>
                        <div class="text-xs text-white/80">{{ __('categories.free_tools') }}</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <div class="text-2xl font-black text-white">100%</div>
                        <div class="text-xs text-white/80">{{ __('categories.free_forever') }}</div>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                        <div class="text-2xl font-black text-white">⚡</div>
                        <div class="text-xs text-white/80">{{ __('categories.instant_access') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tools by Subcategory -->
        @php
            // Group tools by subcategory slug using the relationship
            // Ensure $tools is a Collection
            $toolsBySubcategory = collect($tools)->groupBy(function ($tool) {
                return $tool->subcategoryRelation ? $tool->subcategoryRelation->slug : 'general';
            });
        @endphp

        @foreach($toolsBySubcategory as $subcategorySlug => $subcategoryTools)
            <div class="mb-10">
                <!-- Subcategory Header -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex-1 h-px"
                        style="background: linear-gradient(to right, transparent, {{ $category->bg_gradient_from }}66, transparent);">
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 px-4">
                        {{ $subcategorySlug === 'general' ? __('categories.general') : __('categories.' . str_replace('-', '_', $subcategorySlug) . '_title', ['default' => ucwords(str_replace('-', ' ', $subcategorySlug))]) }}
                        <span class="text-sm font-normal text-gray-500 ml-2">({{ $subcategoryTools->count() }}
                            {{ __('categories.tools_count') }})</span>
                    </h2>
                    <div class="flex-1 h-px"
                        style="background: linear-gradient(to right, transparent, {{ $category->bg_gradient_from }}66, transparent);">
                    </div>
                </div>

                <!-- Tools Grid for this Subcategory -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($subcategoryTools as $tool)
                        <x-tool-card 
                            :tool="$tool" 
                            :gradientFrom="$category->bg_gradient_from" 
                            :gradientTo="$category->bg_gradient_to" 
                        />
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Back to Home -->
        <div class="text-center mb-12">
            <a href="{{ localeRoute('home') }}"
                class="inline-flex items-center gap-2 px-8 py-4 text-white rounded-xl font-bold shadow-lg hover:shadow-2xl transition-all hover:scale-105"
                style="background: linear-gradient(to right, {{ $category->bg_gradient_from }}, {{ $category->bg_gradient_to }});">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('categories.back_to_home') }}
            </a>
        </div>
    </div>
@endsection