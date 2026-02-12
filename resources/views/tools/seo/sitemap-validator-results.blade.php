<div class="bg-white rounded-2xl shadow-xl p-8">
    <h3 class="text-2xl font-bold mb-6">{{ __tool('sitemap-validator', 'results.title', 'Validation Results') }}</h3>

    <!-- Status Card -->
    <div class="mb-6">
        @if($result['valid'])
            <div class="bg-green-50 border-2 border-green-500 rounded-xl p-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 text-4xl mr-4"></i>
                    <div>
                        <h3 class="text-2xl font-bold text-green-800">{{ __tool('sitemap-validator', 'results.valid_title', 'Valid Sitemap!') }}</h3>
                        <p class="text-green-600">{{ __tool('sitemap-validator', 'results.valid_desc', 'Your sitemap is properly formatted and ready to submit.') }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-red-50 border-2 border-red-500 rounded-xl p-6">
                <div class="flex items-center">
                    <i class="fas fa-times-circle text-red-600 text-4xl mr-4"></i>
                    <div>
                        <h3 class="text-2xl font-bold text-red-800">{{ __tool('sitemap-validator', 'results.invalid_title', 'Invalid Sitemap') }}</h3>
                        <p class="text-red-600">{{ __tool('sitemap-validator', 'results.invalid_desc', 'Please fix the errors below.') }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @if($result['isSitemapIndex'])
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $result['stats']['totalSitemaps'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">{{ __tool('sitemap-validator', 'results.label_sitemaps', 'Sitemaps') }}</div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ $result['stats']['totalUrls'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">{{ __tool('sitemap-validator', 'results.label_total_urls', 'Total URLs') }}</div>
            </div>
        @else
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $result['stats']['totalUrls'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">{{ __tool('sitemap-validator', 'results.label_urls', 'URLs') }}</div>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ $result['stats']['fileSizeMB'] ?? 0 }} MB</div>
                <div class="text-sm text-gray-600">{{ __tool('sitemap-validator', 'results.label_file_size', 'File Size') }}</div>
            </div>
        @endif
        <div class="bg-red-50 p-4 rounded-lg">
            <div class="text-2xl font-bold text-red-600">{{ $result['stats']['errors'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">{{ __tool('sitemap-validator', 'results.label_errors', 'Errors') }}</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg">
            <div class="text-2xl font-bold text-yellow-600">{{ $result['stats']['warnings'] ?? 0 }}</div>
            <div class="text-sm text-gray-600">{{ __tool('sitemap-validator', 'results.label_warnings', 'Warnings') }}</div>
        </div>
    </div>

    <!-- Errors -->
    @if(!empty($result['errors']))
        <div class="mb-6">
            <h4 class="text-lg font-bold text-red-600 mb-3">{{ __tool('sitemap-validator', 'results.errors_heading', 'Errors') }}</h4>
            <div class="space-y-2">
                @foreach($result['errors'] as $error)
                    <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded">
                        <strong class="text-red-800">{{ $error['type'] }}:</strong>
                        <span class="text-red-700">{{ $error['message'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Warnings -->
    @if(!empty($result['warnings']))
        <div class="mb-6">
            <h4 class="text-lg font-bold text-yellow-600 mb-3">{{ __tool('sitemap-validator', 'results.warnings_heading', 'Warnings') }}</h4>
            <div class="space-y-2">
                @foreach($result['warnings'] as $warning)
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-3 rounded">
                        <strong class="text-yellow-800">{{ $warning['type'] }}:</strong>
                        <span class="text-yellow-700">{{ $warning['message'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- URLs/Sitemaps Table -->
    @if($result['isSitemapIndex'] && !empty($result['sitemaps']))
        <div>
            <h4 class="text-xl font-bold mb-4">Sitemaps</h4>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 text-left">#</th>
                            <th class="p-2 text-left">{{ __tool('sitemap-validator', 'results.th_sitemap_url', 'Sitemap URL') }}</th>
                            <th class="p-2 text-left">URLs</th>
                            <th class="p-2 text-left">{{ __tool('sitemap-validator', 'results.th_status', 'Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($result['sitemaps'] as $index => $sitemap)
                            <tr class="border-b">
                                <td class="p-2">{{ $index + 1 }}</td>
                                <td class="p-2 break-all">{{ $sitemap['url'] }}</td>
                                <td class="p-2">{{ $sitemap['urlCount'] }}</td>
                                <td class="p-2">
                                    <span
                                        class="px-2 py-1 bg-{{ $sitemap['status'] === 'valid' ? 'green' : ($sitemap['status'] === 'failed' ? 'red' : 'yellow') }}-100 text-{{ $sitemap['status'] === 'valid' ? 'green' : ($sitemap['status'] === 'failed' ? 'red' : 'yellow') }}-800 rounded">
                                        {{ $sitemap['status'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @elseif(!empty($result['urls']))
        <div>
            <h4 class="text-xl font-bold mb-4">URLs ({{ count($result['urls']) }})</h4>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2">#</th>
                            <th class="p-2 text-left">{{ __tool('sitemap-validator', 'results.th_url', 'URL') }}</th>
                            <th class="p-2">{{ __tool('sitemap-validator', 'results.th_last_modified', 'Last Modified') }}</th>
                            <th class="p-2">{{ __tool('sitemap-validator', 'results.th_change_freq', 'Change Freq') }}</th>
                            <th class="p-2">{{ __tool('sitemap-validator', 'results.th_priority', 'Priority') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($result['urls'] as $index => $url)
                            <tr class="border-b">
                                <td class="p-2">{{ $index + 1 }}</td>
                                <td class="p-2 break-all">{{ $url['url'] }}</td>
                                <td class="p-2">{{ $url['lastmod'] ?? '-' }}</td>
                                <td class="p-2">{{ $url['changefreq'] ?? '-' }}</td>
                                <td class="p-2">{{ $url['priority'] ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>