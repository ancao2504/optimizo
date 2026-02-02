@extends('layouts.app')

@section('title', __tool('youtube-video-downloader', 'meta.title'))
@section('meta_description', __tool('youtube-video-downloader', 'meta.description'))


@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- SEO-Optimized Header with Gradient Background -->
        <x-tool-hero :tool="$tool" />

        <!-- Video Downloader Tool -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-2xl border-2 border-red-200 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">
                {{ __tool('youtube-video-downloader', 'form.title', 'Download YouTube Videos') }}
            </h2>
            <form id="extractorForm">
                @csrf
                <div class="mb-6">
                    <label for="url"
                        class="form-label text-base">{{ __tool('youtube-video-downloader', 'form.url_label', 'YouTube Video URL') }}</label>
                    <input type="url" id="url" name="url" class="form-input"
                        placeholder="{{ __tool('youtube-video-downloader', 'form.url_placeholder', 'https://www.youtube.com/watch?v=...') }}"
                        required>
                    <p class="text-sm text-gray-500 mt-2">
                        {{ __tool('youtube-video-downloader', 'form.url_help', 'Paste any YouTube video URL to download in high quality') }}
                    </p>
                </div>

                <button type="submit" class="btn-primary w-full justify-center text-lg py-4">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                    </svg>
                    <span id="btnText">{{ __tool('youtube-video-downloader', 'form.submit', 'Process Video') }}</span>
                </button>
            </form>

            <!-- Error Message -->
            <div id="errorMessage" class="hidden mt-6 bg-red-50 border-2 border-red-200 rounded-2xl p-6">
                <p class="text-red-800 font-semibold flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    <span id="errorText"></span>
                </p>
            </div>

            <!-- Results Section -->
            <div id="resultsSection" class="hidden mt-8">
                <div class="bg-white border-2 border-gray-100 rounded-2xl p-6 shadow-xl">
                    <div id="videoInfo" class="flex flex-col md:flex-row gap-6 mb-8">
                        <!-- Populated by JS -->
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download Options
                    </h3>
                    <div id="downloadOptions" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Download buttons populated here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Premium Progress Modal -->
        <div id="progressModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75 backdrop-blur-sm" aria-hidden="true">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="relative inline-block overflow-hidden align-bottom transition-all transform bg-white rounded-3xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-gray-100">
                    <div class="px-4 pt-5 pb-4 bg-white sm:p-8">
                        <div class="flex flex-col items-center">
                            <!-- Animated Icon -->
                            <div class="relative flex items-center justify-center w-20 h-20 mb-6 bg-red-50 rounded-full">
                                <span
                                    class="absolute inline-flex w-full h-full rounded-full opacity-75 animate-ping bg-red-100"></span>
                                <svg class="w-10 h-10 text-red-600 animate-bounce" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </div>

                            <div class="w-full text-center">
                                <h3 class="mb-2 text-2xl font-bold text-gray-900" id="modal-title">
                                    Downloading Video...
                                </h3>
                                <p class="mb-8 text-sm text-gray-500">
                                    Please wait while we prepare your high-quality file. This usually takes just a few
                                    seconds.
                                </p>

                                <!-- Premium Progress Bar -->
                                <div class="relative w-full h-4 mb-2 overflow-hidden bg-gray-100 rounded-full shadow-inner">
                                    <div id="progressBar"
                                        class="absolute top-0 left-0 h-full transition-all duration-300 ease-out shadow-lg bg-gradient-to-r from-red-500 to-pink-600 rounded-full"
                                        style="width: 0%">
                                        <div class="absolute inset-0 opacity-25 bg-stripes animate-progress-stripes"></div>
                                    </div>
                                </div>

                                <div
                                    class="flex justify-between w-full text-xs font-semibold uppercase tracking-wider mb-6">
                                    <span class="text-gray-400">Progress</span>
                                    <span id="progressText" class="text-red-600">0%</span>
                                </div>

                                <!-- Cancel Button -->
                                <div class="mt-4">
                                    <button type="button" onclick="cancelDownload()"
                                        class="inline-flex justify-center px-6 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                        Cancel Process
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .bg-stripes {
                background-image: linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
                background-size: 1rem 1rem;
            }

            @keyframes progress-stripes {
                from {
                    background-position: 1rem 0;
                }

                to {
                    background-position: 0 0;
                }
            }

            .animate-progress-stripes {
                animation: progress-stripes 1s linear infinite;
            }
        </style>


        <!-- SEO Content Section -->
        <div class="mt-8 space-y-8">
            <!-- Main Content & Guide -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-3xl p-8 md:p-12 border-2 border-red-100 shadow-xl">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-black text-gray-900 mb-4">
                        {{ __tool('youtube-video-downloader', 'content.main_title', 'The Ultimate YouTube Video Downloader & Converter') }}
                    </h2>
                    <p class="text-lg text-gray-600 max-w-4xl mx-auto leading-relaxed">
                        {{ __tool('youtube-video-downloader', 'content.main_subtitle', 'Save your favorite YouTube videos directly to your device with our fast, free, and secure online downloader. Whether you need an MP4 for offline viewing or an MP3 for your music collection, our tool handles it all in high definition.') }}
                    </p>
                </div>

                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">
                            {{ __tool('youtube-video-downloader', 'content.guide_title', 'How to Download YouTube Videos Online') }}
                        </h3>
                        <ol class="space-y-4">
                            <li class="flex items-start gap-4">
                                <span
                                    class="bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 font-bold">1</span>
                                <p class="text-gray-700 mt-1">
                                    <strong>{{ __tool('youtube-video-downloader', 'content.guide_step1_title', 'Copy URL:') }}</strong>
                                    {{ __tool('youtube-video-downloader', 'content.guide_step1_desc', 'Open YouTube and copy the link of the video you wish to download.') }}
                                </p>
                            </li>
                            <li class="flex items-start gap-4">
                                <span
                                    class="bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 font-bold">2</span>
                                <p class="text-gray-700 mt-1">
                                    <strong>{{ __tool('youtube-video-downloader', 'content.guide_step2_title', 'Paste Link:') }}</strong>
                                    {{ __tool('youtube-video-downloader', 'content.guide_step2_desc', 'Return here and paste the video URL into the input field above.') }}
                                </p>
                            </li>
                            <li class="flex items-start gap-4">
                                <span
                                    class="bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 font-bold">3</span>
                                <p class="text-gray-700 mt-1">
                                    <strong>{{ __tool('youtube-video-downloader', 'content.guide_step3_title', 'Choose Quality:') }}</strong>
                                    {{ __tool('youtube-video-downloader', 'content.guide_step3_desc', 'Click "Process Video", then select your preferred resolution (1080p, 720p, etc.) or MP3 format.') }}
                                </p>
                            </li>
                            <li class="flex items-start gap-4">
                                <span
                                    class="bg-red-600 text-white w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 font-bold">4</span>
                                <p class="text-gray-700 mt-1">
                                    <strong>{{ __tool('youtube-video-downloader', 'content.guide_step4_title', 'Download:') }}</strong>
                                    {{ __tool('youtube-video-downloader', 'content.guide_step4_desc', 'Our server will process the file, and once ready, it will automatically download to your device.') }}
                                </p>
                            </li>
                        </ol>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-red-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="text-2xl">✨</span>
                            {{ __tool('youtube-video-downloader', 'content.why_choose_title', 'Why Choose Our Downloader?') }}
                        </h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ __tool('youtube-video-downloader', 'content.why_choose_1', 'No registration or software installation required.') }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ __tool('youtube-video-downloader', 'content.why_choose_2', 'Download in resolutions up to 1080p Full HD.') }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ __tool('youtube-video-downloader', 'content.why_choose_3', 'Lightning-fast conversion from YouTube to MP3/MP4.') }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ __tool('youtube-video-downloader', 'content.why_choose_4', 'Works perfectly on mobile, tablet, and desktop.') }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>{{ __tool('youtube-video-downloader', 'content.why_choose_5', '100% free with unlimited daily downloads.') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="text-3xl mb-3">⚡</div>
                    <h4 class="font-bold text-xl text-gray-900 mb-2">
                        {{ __tool('youtube-video-downloader', 'content.feature_speed_title', 'High Speed') }}
                    </h4>
                    <p class="text-gray-600 text-sm">
                        {{ __tool('youtube-video-downloader', 'content.feature_speed_desc', 'Our powerful servers utilize advanced multi-threading to fetch and process YouTube streams at peak speeds, ensuring minimal wait times.') }}
                    </p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="text-3xl mb-3">🎬</div>
                    <h4 class="font-bold text-xl text-gray-900 mb-2">
                        {{ __tool('youtube-video-downloader', 'content.feature_formats_title', 'Multiple Formats') }}
                    </h4>
                    <p class="text-gray-600 text-sm">
                        {{ __tool('youtube-video-downloader', 'content.feature_formats_desc', 'Choose between MP4 and WebM for high-quality video, or extract only the audio as a crisp 320kbps MP3 file for your music library.') }}
                    </p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <div class="text-3xl mb-3">🛡️</div>
                    <h4 class="font-bold text-xl text-gray-900 mb-2">
                        {{ __tool('youtube-video-downloader', 'content.feature_security_title', 'Secure & Privacy') }}
                    </h4>
                    <p class="text-gray-600 text-sm">
                        {{ __tool('youtube-video-downloader', 'content.feature_security_desc', "We don't track your downloads or store your data. Our service is transparent, secure, and respectful of your digital privacy.") }}
                    </p>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="bg-white rounded-3xl p-8 md:p-12 border border-gray-100 shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">
                    {{ __tool('youtube-video-downloader', 'content.faq_title', 'Frequently Asked Questions') }}
                </h3>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-2">
                                {{ __tool('youtube-video-downloader', 'content.faq_q1', 'Is it free to download YouTube videos?') }}
                            </h4>
                            <p class="text-gray-600 text-sm">
                                {{ __tool('youtube-video-downloader', 'content.faq_a1', 'Yes, our service is completely free to use. You can download as many videos as you want without any hidden costs or registration.') }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-2">
                                {{ __tool('youtube-video-downloader', 'content.faq_q2', 'What resolutions are supported?') }}
                            </h4>
                            <p class="text-gray-600 text-sm">
                                {{ __tool('youtube-video-downloader', 'content.faq_a2', 'We support all resolutions provided by the YouTube video, including 360p, 480p, 720p HD, and up to 1080p Full HD.') }}
                            </p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-2">
                                {{ __tool('youtube-video-downloader', 'content.faq_q3', 'Can I convert YouTube videos to MP3?') }}
                            </h4>
                            <p class="text-gray-600 text-sm">
                                {{ __tool('youtube-video-downloader', 'content.faq_a3', 'Absolutely! You can select the "Audio (MP3)" option to extract only the sound from a video and save it as an audio file.') }}
                            </p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-2">
                                {{ __tool('youtube-video-downloader', 'content.faq_q4', 'Do I need to install any software?') }}
                            </h4>
                            <p class="text-gray-600 text-sm">
                                {{ __tool('youtube-video-downloader', 'content.faq_a4', 'No, this is an entirely web-based tool. It works directly in your browser on Windows, Mac, iOS, and Android without plugins.') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-center text-sm text-gray-400">
                    <p>{{ __tool('youtube-video-downloader', 'content.terms_notice', 'By using our service, you agree to our Terms of Use and confirm you will only download content for personal use where allowed by law.') }}
                    </p>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const translations = {
            error_enter_url: "{{ __tool('youtube-video-downloader', 'js.error_enter_url', 'Please enter a YouTube URL') }}",
            error_valid_url: "{{ __tool('youtube-video-downloader', 'js.error_valid_url', 'Please enter a valid YouTube URL') }}",
            processing: "{{ __tool('youtube-video-downloader', 'js.processing', 'Processing...') }}",
            error_failed: "{{ __tool('youtube-video-downloader', 'js.error_failed', 'Failed to process video') }}"
        };



        let currentVideoData = null;
        let currentEventSource = null;

        $(document).ready(function () {
            $('#extractorForm').on('submit', function (e) {
                e.preventDefault();

                const url = $('#url').val().trim();
                const btn = $(this).find('button[type="submit"]');
                const btnText = $('#btnText');
                const originalText = btnText.text();

                $('#resultsSection').addClass('hidden');
                $('#errorMessage').addClass('hidden');

                if (!url) {
                    showError(translations.error_enter_url);
                    return;
                }

                const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/;
                if (!youtubeRegex.test(url)) {
                    showError(translations.error_valid_url);
                    return;
                }

                btn.prop('disabled', true).addClass('opacity-75');
                btnText.text(translations.processing);

                $.ajax({
                    url: '{{ route("downloader.youtube-video-downloader.process") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        url: url
                    },
                    success: function (response) {
                        if (response.success) {
                            currentVideoData = response.data;
                            displayResults(response.data);
                            $('#resultsSection').removeClass('hidden');
                            setTimeout(() => {
                                $('#resultsSection')[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                            }, 100);
                        }
                    },
                    error: function (xhr) {
                        const error = xhr.responseJSON?.error || translations.error_failed;
                        showError(error);
                    },
                    complete: function () {
                        btn.prop('disabled', false).removeClass('opacity-75');
                        btnText.text(originalText);
                    }
                });
            });

            function displayResults(data) {
                // Video Info
                const videoInfoHtml = `
                                                    <div class="w-full md:w-1/3">
                                                        <img src="${data.thumbnail}" class="w-full rounded-lg shadow-lg border border-gray-200" alt="Thumbnail">
                                                    </div>
                                                    <div class="w-full md:w-2/3 space-y-3">
                                                        <h3 class="text-xl font-bold text-gray-900 line-clamp-2">${data.title}</h3>
                                                        <div class="flex flex-wrap gap-2 text-sm text-gray-600">
                                                            <span class="bg-gray-100 px-3 py-1 rounded-full">Duration: ${formatDuration(data.duration)}</span>
                                                            <span class="bg-gray-100 px-3 py-1 rounded-full">Views: ${formatNumber(data.view_count)}</span>
                                                        </div>
                                                    </div>
                                                `;
                $('#videoInfo').html(videoInfoHtml);

                // Download Buttons
                const buttonsContainer = $('#downloadOptions');
                buttonsContainer.empty();

                if (data.qualities && data.qualities.length > 0) {
                    data.qualities.forEach(q => {
                        const btnHtml = `
                                                            <button onclick="startDownload('${q.id}')" 
                                                                class="flex items-center justify-between w-full px-5 py-4 bg-gray-50 hover:bg-red-50 border border-gray-200 hover:border-red-200 rounded-xl transition-all group">
                                                                <div class="flex items-center gap-3">
                                                                    <span class="bg-white p-2 rounded-lg shadow-sm text-gray-700 group-hover:text-red-600">
                                                                        ${q.icon === 'audio' ? '🎵' : '📺'}
                                                                    </span>
                                                                    <div class="text-left">
                                                                        <div class="font-bold text-gray-900 group-hover:text-red-700">${q.label}</div>
                                                                        <div class="text-xs text-gray-500">${q.description}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="bg-white px-3 py-1 rounded-lg text-sm font-semibold text-gray-600 shadow-sm border border-gray-100 group-hover:border-red-100 group-hover:text-red-600">
                                                                    Download
                                                                </div>
                                                            </button>
                                                        `;
                        buttonsContainer.append(btnHtml);
                    });
                }
            }

            function formatNumber(num) {
                return new Intl.NumberFormat('en-US', { notation: "compact", maximumFractionDigits: 1 }).format(num);
            }

            function formatDuration(seconds) {
                const h = Math.floor(seconds / 3600);
                const m = Math.floor((seconds % 3600) / 60);
                const s = seconds % 60;
                return [h, m, s]
                    .map(v => v < 10 ? "0" + v : v)
                    .filter((v, i) => v !== "00" || i > 0)
                    .join(":");
            }

            function showError(message) {
                $('#errorText').text(message);
                $('#errorMessage').removeClass('hidden');
            }
        });

        function startDownload(qualityId) {
            if (!currentVideoData) return;

            const q = currentVideoData.qualities.find(x => x.id === qualityId);
            if (!q) return;

            // Show Progress Modal
            $('#progressModal').removeClass('hidden');
            $('#progressBar').css('width', '0%');
            $('#progressText').text('0%');

            const url = `{{ route('downloader.youtube-video-downloader.search') }}?url=${encodeURIComponent(currentVideoData.url)}&format_str=${encodeURIComponent(q.format_str)}&title=${encodeURIComponent(currentVideoData.title)}&ext=${encodeURIComponent(q.ext || 'mp4')}&_token={{ csrf_token() }}`;

            if (currentEventSource) {
                currentEventSource.close();
            }

            const eventSource = new EventSource(url);
            currentEventSource = eventSource;

            eventSource.onmessage = function (event) {
                const data = JSON.parse(event.data);

                if (data.error) {
                    eventSource.close();
                    currentEventSource = null;
                    $('#progressModal').addClass('hidden');
                    alert('Error: ' + data.error);
                    return;
                }

                if (data.progress) {
                    const percent = Math.round(data.progress);
                    $('#progressBar').css('width', percent + '%');
                    $('#progressText').text(percent + '%');
                }

                if (data.done) {
                    eventSource.close();
                    currentEventSource = null;
                    $('#progressBar').css('width', '100%');
                    $('#progressText').text('100%');

                    // Trigger download
                    window.location.href = `{{ route('downloader.youtube-video-downloader.file') }}?filename=${encodeURIComponent(data.filename)}`;

                    // Close modal after short delay
                    setTimeout(() => {
                        $('#progressModal').addClass('hidden');
                    }, 2000);
                }
            };

            eventSource.onerror = function (event) {
                console.error("EventSource failed:", event);
                eventSource.close();
                currentEventSource = null;
                // Check if it was a network error or complete
                $('#progressModal').addClass('hidden');
            };
        }

        function cancelDownload() {
            if (currentEventSource) {
                currentEventSource.close();
                currentEventSource = null;
            }
            $('#progressModal').addClass('hidden');
        }
    </script>
@endpush