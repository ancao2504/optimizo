@extends('layouts.app')

@section('title', __tool('slug-generator', 'meta.title'))
@section('meta_description', __tool('slug-generator', 'meta.description'))
@section('content')
    <div class="max-w-5xl mx-auto">
        <x-tool-hero :tool="$tool" icon="slug-generator" />

        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-purple-200 mb-8">
            <div class="mb-6">
                <label for="inputString" class="block text-sm font-semibold text-gray-700 mb-2">{{ __tool('slug-generator', 'editor.label_input') }}</label>
                <input type="text" id="inputString"
                    placeholder="{{ __tool('slug-generator', 'editor.ph_input') }}"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                    oninput="generateSlug()">
            </div>

            <div class="mb-6">
                <label for="separator" class="block text-sm font-semibold text-gray-700 mb-2">Separator</label>
                <select id="separator"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all"
                    onchange="generateSlug()">
                    <option value="-">Hyphen (-)</option>
                    <option value="_">Underscore (_)</option>
                    <option value=".">Dot (.)</option>
                </select>
            </div>

            <div class="mb-6">
                <label for="outputSlug" class="block text-sm font-semibold text-gray-700 mb-2">Generated Slug</label>
                <div class="relative">
                    <input type="text" id="outputSlug" readonly
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl bg-gray-50 font-mono text-gray-600 focus:outline-none">
                    <button onclick="copyToClipboard()"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 text-gray-500 hover:text-purple-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </button>
                </div>
            </div>
             <div id="copyMessage" class="hidden mt-2 text-center text-sm font-medium text-green-600 transition-opacity duration-300"></div>
        </div>

        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-purple-100 shadow-2xl mt-8">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-xl mb-4">
                    <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                </div>
                <h2 class="text-4xl font-black text-gray-900 mb-3">{{ __tool('slug-generator', 'content.hero_title') }}</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">{{ __tool('slug-generator', 'content.hero_subtitle') }}</p>
            </div>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('slug-generator', 'content.what_title') }}</h3>
            <p class="text-gray-700 leading-relaxed mb-8">{{ __tool('slug-generator', 'content.what_desc') }}</p>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('slug-generator', 'content.why_title') }}</h3>
            <div class="bg-white rounded-xl p-6 border-2 border-gray-200 mb-10 shadow-lg">
                <ul class="space-y-3">
                    @foreach(__tool('slug-generator', 'content.why_list') as $item)
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('slug-generator', 'content.practices_title') }}</h3>
            <div class="bg-white rounded-xl p-6 border-2 border-gray-200 mb-10 shadow-lg">
                <ul class="grid md:grid-cols-2 gap-3">
                    @foreach(__tool('slug-generator', 'content.practices_list') as $practice)
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">{{ $practice }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('slug-generator', 'content.how_works_title') }}</h3>
            <p class="text-gray-700 leading-relaxed mb-10">{{ __tool('slug-generator', 'content.how_works_desc') }}</p>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('slug-generator', 'content.uses_title') }}</h3>
            <div class="grid md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200 shadow-lg">
                    <h4 class="font-bold text-lg text-gray-900 mb-3">{{ __tool('slug-generator', 'content.uses.blog.title') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('slug-generator', 'content.uses.blog.desc') }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200 shadow-lg">
                    <h4 class="font-bold text-lg text-gray-900 mb-3">{{ __tool('slug-generator', 'content.uses.ecommerce.title') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('slug-generator', 'content.uses.ecommerce.desc') }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200 shadow-lg">
                    <h4 class="font-bold text-lg text-gray-900 mb-3">{{ __tool('slug-generator', 'content.uses.docs.title') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('slug-generator', 'content.uses.docs.desc') }}</p>
                </div>
                <div class="bg-white rounded-xl p-6 border-2 border-gray-200 shadow-lg">
                    <h4 class="font-bold text-lg text-gray-900 mb-3">{{ __tool('slug-generator', 'content.uses.landing.title') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('slug-generator', 'content.uses.landing.desc') }}</p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-100 to-pink-100 rounded-2xl p-6 border-2 border-purple-200 mb-10">
                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ __tool('slug-generator', 'content.pro_tip_title') }}</h3>
                <p class="text-gray-700 leading-relaxed">{{ __tool('slug-generator', 'content.pro_tip_desc') }}</p>
            </div>

            <h3 class="text-3xl font-bold text-gray-900 mb-6">{{ __tool('slug-generator', 'content.faq_title') }}</h3>
            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('slug-generator', 'content.faq.q1') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('slug-generator', 'content.faq.a1') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('slug-generator', 'content.faq.q2') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('slug-generator', 'content.faq.a2') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('slug-generator', 'content.faq.q3') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('slug-generator', 'content.faq.a3') }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 border-2 border-gray-200 shadow-lg hover:shadow-xl transition-all">
                    <h4 class="font-bold text-gray-900 mb-3 text-lg">{{ __tool('slug-generator', 'content.faq.q4') }}</h4>
                    <p class="text-gray-700 leading-relaxed">{{ __tool('slug-generator', 'content.faq.a4') }}</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function generateSlug() {
            const input = document.getElementById('inputString').value;
            const separator = document.getElementById('separator').value;
            const slug = input.toString().toLowerCase()
                .trim()
                .replace(/\\s+/g, separator)     // Replace spaces with separator
                .replace(/[^\\w\\-\\.]+/g, '')     // Remove all non-word chars
                .replace(/\\-\\-+/g, separator);  // Replace multiple separators with single separator

            document.getElementById('outputSlug').value = slug;
        }

        function copyToClipboard() {
            const copyText = document.getElementById("outputSlug");
            if (!copyText.value) return;
            
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            
            const msg = document.getElementById('copyMessage');
            msg.innerText = "{{ __tool('slug-generator', 'js.copied') }}";
            msg.classList.remove('hidden');
            setTimeout(() => {
                msg.classList.add('hidden');
            }, 3000);
        }
    </script>
    @endpush
@endsection