<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tools\Converters\AngleConverterController;
use App\Http\Controllers\Tools\Converters\AreaConverterController;
use App\Http\Controllers\Tools\Converters\AsciiConverterController;
use App\Http\Controllers\Tools\Converters\BinaryHexConverterController;
use App\Http\Controllers\Tools\Converters\BinaryToTextController;
use App\Http\Controllers\Tools\Converters\CamelCaseConverterController;
use App\Http\Controllers\Tools\Converters\CaseConverterController;
use App\Http\Controllers\Tools\Converters\CookingUnitConverterController;
use App\Http\Controllers\Tools\Converters\DataTransferRateConverterController;
use App\Http\Controllers\Tools\Converters\DecimalBinaryConverterController;
use App\Http\Controllers\Tools\Converters\DecimalHexConverterController;
use App\Http\Controllers\Tools\Converters\DecimalOctalConverterController;
use App\Http\Controllers\Tools\Converters\DensityConverterController;
use App\Http\Controllers\Tools\Converters\DigitalStorageConverterController;
use App\Http\Controllers\Tools\Converters\EnergyConverterController;
use App\Http\Controllers\Tools\Converters\ForceConverterController;
use App\Http\Controllers\Tools\Converters\FrequencyConverterController;
use App\Http\Controllers\Tools\Converters\FuelConsumptionConverterController;
use App\Http\Controllers\Tools\Converters\KebabCaseConverterController;
use App\Http\Controllers\Tools\Converters\LengthConverterController;
use App\Http\Controllers\Tools\Converters\MolarMassConverterController;
use App\Http\Controllers\Tools\Converters\NumberBaseConverterController;
use App\Http\Controllers\Tools\Converters\PascalCaseConverterController;
use App\Http\Controllers\Tools\Converters\PowerConverterController;
use App\Http\Controllers\Tools\Converters\PressureConverterController;
use App\Http\Controllers\Tools\Converters\RgbHexConverterController;
use App\Http\Controllers\Tools\Converters\SentenceCaseConverterController;
use App\Http\Controllers\Tools\Converters\SnakeCaseConverterController;
use App\Http\Controllers\Tools\Converters\SpeedConverterController;
use App\Http\Controllers\Tools\Converters\StudlyCaseConverterController;
use App\Http\Controllers\Tools\Converters\TemperatureConverterController;
use App\Http\Controllers\Tools\Converters\TextToBinaryController;
use App\Http\Controllers\Tools\Converters\TorqueConverterController;
use App\Http\Controllers\Tools\Converters\VolumeConverterController;
use App\Http\Controllers\Tools\Converters\WeightConverterController;
use App\Http\Controllers\Tools\Development\Base64EncoderDecoderController;
use App\Http\Controllers\Tools\Development\CodeFormatterController;
use App\Http\Controllers\Tools\Development\CronJobGeneratorController;
use App\Http\Controllers\Tools\Development\CssMinifierController;
use App\Http\Controllers\Tools\Development\CurlCommandBuilderController;
use App\Http\Controllers\Tools\Development\HtmlEncoderDecoderController;
use App\Http\Controllers\Tools\Development\HtmlMinifierController;
use App\Http\Controllers\Tools\Development\HtmlToMarkdownConverterController;
use App\Http\Controllers\Tools\Development\HtmlViewerController;
use App\Http\Controllers\Tools\Development\JsMinifierController;
use App\Http\Controllers\Tools\Development\JsonFormatterController;
use App\Http\Controllers\Tools\Development\JsonParserController;
use App\Http\Controllers\Tools\Development\JsonToCsvConverterController;
use App\Http\Controllers\Tools\Development\JsonToSqlConverterController;
use App\Http\Controllers\Tools\Development\JsonToXmlConverterController;
use App\Http\Controllers\Tools\Development\JsonToYamlConverterController;
use App\Http\Controllers\Tools\Development\JwtDecoderController;
use App\Http\Controllers\Tools\Development\MarkdownToHtmlConverterController;
use App\Http\Controllers\Tools\Development\Md5GeneratorController;
use App\Http\Controllers\Tools\Development\HashGeneratorController;
use App\Http\Controllers\Tools\Development\SqlToJsonConverterController;
use App\Http\Controllers\Tools\Development\UnicodeEncoderDecoderController;
use App\Http\Controllers\Tools\Development\UrlEncoderDecoderController;
use App\Http\Controllers\Tools\Development\UuidGeneratorController;
use App\Http\Controllers\Tools\Development\XmlFormatterController;
use App\Http\Controllers\Tools\Development\XmlToCsvController;
use App\Http\Controllers\Tools\Development\XmlToJsonController;
use App\Http\Controllers\Tools\Development\YamlToJsonController;
use App\Http\Controllers\Tools\Document\ExcelToPdfController;
use App\Http\Controllers\Tools\Document\JpgToPdfController;
use App\Http\Controllers\Tools\Document\PdfCompressorController;
use App\Http\Controllers\Tools\Document\PdfMergerController;
use App\Http\Controllers\Tools\Document\PdfSplitterController;
use App\Http\Controllers\Tools\Document\PdfToExcelController;
use App\Http\Controllers\Tools\Document\PdfToJpgController;
use App\Http\Controllers\Tools\Document\PdfToPptController;
use App\Http\Controllers\Tools\Document\PdfToWordController;
use App\Http\Controllers\Tools\Document\PptToPdfController;
use App\Http\Controllers\Tools\Document\WordToPdfController;
use App\Http\Controllers\Tools\Document\DigitalSignatureController;
use App\Http\Controllers\Tools\Image\Base64ToImageConverterController;
use App\Http\Controllers\Tools\Image\HeicToJpgConverterController;
use App\Http\Controllers\Tools\Image\JpgToHeicConverterController;
use App\Http\Controllers\Tools\Image\PngToHeicConverterController;
use App\Http\Controllers\Tools\Image\WebPToPngConverterController;
use App\Http\Controllers\Tools\Image\AvifToJpgConverterController;
use App\Http\Controllers\Tools\Image\AvifToPngConverterController;
use App\Http\Controllers\Tools\Image\TiffToJpgConverterController;
use App\Http\Controllers\Tools\Image\BmpToJpgConverterController;
use App\Http\Controllers\Tools\Image\RawToJpgConverterController;
use App\Http\Controllers\Tools\Image\ImageColorPickerController;
use App\Http\Controllers\Tools\Image\ImageColorReplacerController;
use App\Http\Controllers\Tools\Image\GrayscaleImageConverterController;
use App\Http\Controllers\Tools\Image\BlackAndWhiteImageConverterController;
use App\Http\Controllers\Tools\Image\ImageBrightnessContrastController;
use App\Http\Controllers\Tools\Image\ImageSharpenerController;
use App\Http\Controllers\Tools\Image\ImageNoiseReducerController;
use App\Http\Controllers\Tools\Image\ImageMetadataViewerController;
use App\Http\Controllers\Tools\Image\ImageMetadataRemoverController;
use App\Http\Controllers\Tools\Image\ImageCopyrightStampController;
use App\Http\Controllers\Tools\Image\SpriteSheetGeneratorController;
use App\Http\Controllers\Tools\Image\ImageLazyLoadGeneratorController;
use App\Http\Controllers\Tools\Image\ResponsiveImageGeneratorController;
use App\Http\Controllers\Tools\Image\IcoConverterController;
use App\Http\Controllers\Tools\Image\ImageCompressorController;
use App\Http\Controllers\Tools\Image\ImageConverterController;
use App\Http\Controllers\Tools\Image\ImageToBase64ConverterController;
use App\Http\Controllers\Tools\Image\JpgToPngConverterController;
use App\Http\Controllers\Tools\Image\JpgToWebpConverterController;
use App\Http\Controllers\Tools\Image\PngToJpgConverterController;
use App\Http\Controllers\Tools\Image\PngToWebpConverterController;
use App\Http\Controllers\Tools\Image\SvgToJpgConverterController;
use App\Http\Controllers\Tools\Image\SvgToPngConverterController;
use App\Http\Controllers\Tools\Image\WebpToJpgConverterController;
use App\Http\Controllers\Tools\Network\DnsLookupController;
use App\Http\Controllers\Tools\Network\DomainToIpController;
use App\Http\Controllers\Tools\Network\InternetSpeedTestController;
use App\Http\Controllers\Tools\Network\IpLookupController;
use App\Http\Controllers\Tools\Network\PingTestController;
use App\Http\Controllers\Tools\Network\PortCheckerController;
use App\Http\Controllers\Tools\Network\ReverseDnsLookupController;
use App\Http\Controllers\Tools\Network\TracerouteController;
use App\Http\Controllers\Tools\Network\UserAgentParserController;
use App\Http\Controllers\Tools\Network\WhatIsMyIpController;
use App\Http\Controllers\Tools\Network\WhatIsMyIspController;
use App\Http\Controllers\Tools\Network\WhoisLookupController;
use App\Http\Controllers\Tools\Seo\AllintitleCheckerController;
use App\Http\Controllers\Tools\Seo\BingSerpCheckerController;
use App\Http\Controllers\Tools\Seo\BrokenLinksCheckerController;
use App\Http\Controllers\Tools\Seo\GoogleSerpCheckerController;
use App\Http\Controllers\Tools\Seo\KeywordDensityCheckerController;
use App\Http\Controllers\Tools\Seo\MetaTagAnalyzerController;
use App\Http\Controllers\Tools\Seo\OnPageSeoCheckerController;
use App\Http\Controllers\Tools\Seo\RedirectCheckerController;
use App\Http\Controllers\Tools\Seo\SitemapValidatorController;
use App\Http\Controllers\Tools\Seo\SlugGeneratorController;
use App\Http\Controllers\Tools\Seo\YahooSerpCheckerController;
use App\Http\Controllers\Tools\Seo\HreflangCheckerController;
use App\Http\Controllers\Tools\Spreadsheet\CsvToExcelController;
use App\Http\Controllers\Tools\Spreadsheet\CsvToJsonController;
use App\Http\Controllers\Tools\Spreadsheet\CsvToSqlController;
use App\Http\Controllers\Tools\Spreadsheet\CsvToTsvController;
use App\Http\Controllers\Tools\Spreadsheet\CsvToXmlConverterController;
use App\Http\Controllers\Tools\Spreadsheet\ExcelToCsvController;
use App\Http\Controllers\Tools\Spreadsheet\GoogleSheetsToExcelController;
use App\Http\Controllers\Tools\Spreadsheet\TsvToCsvConverterController;
use App\Http\Controllers\Tools\Spreadsheet\XlsToXlsxController;
use App\Http\Controllers\Tools\Spreadsheet\XlsxToXlsController;
use App\Http\Controllers\Tools\Text\DuplicateLineRemoverController;
use App\Http\Controllers\Tools\Text\FileDifferenceCheckerController;
use App\Http\Controllers\Tools\Text\LoremIpsumGeneratorController;
use App\Http\Controllers\Tools\Text\MorseToTextConverterController;
use App\Http\Controllers\Tools\Text\TextReverserController;
use App\Http\Controllers\Tools\Text\TextToMorseConverterController;
use App\Http\Controllers\Tools\Text\WordCounterController;
use App\Http\Controllers\Tools\Youtube\TextToSpeechController;
use App\Http\Controllers\Tools\Time\DateToUnixTimestampController;
use App\Http\Controllers\Tools\Time\EpochTimeConverterController;
use App\Http\Controllers\Tools\Time\LocalTimeToUtcController;
use App\Http\Controllers\Tools\Time\TimeUnitConverterController;
use App\Http\Controllers\Tools\Time\TimeZoneConverterController;
use App\Http\Controllers\Tools\Time\UnixTimestampToDateController;
use App\Http\Controllers\Tools\Time\UtcToLocalTimeController;
use App\Http\Controllers\Tools\Utility\PasswordGeneratorController;
use App\Http\Controllers\Tools\Utility\QrCodeGeneratorController;
use App\Http\Controllers\Tools\Utility\RandomNumberGeneratorController;
use App\Http\Controllers\Tools\Utility\UsernameCheckerController;
use App\Http\Controllers\Tools\Utility\UrlOpenerController;
use App\Http\Controllers\Tools\Seo\LocationController;
use App\Http\Controllers\Tools\Youtube\YoutubeChannelDataExtractorController;
use App\Http\Controllers\Tools\Youtube\YoutubeHandleCheckerController;
use App\Http\Controllers\Tools\Youtube\YoutubeMonetizationCheckerController;
use App\Http\Controllers\Tools\Youtube\YoutubeChannelIdFinderController;
use App\Http\Controllers\Tools\Youtube\YoutubeEarningsCalculatorController;
use App\Http\Controllers\Tools\Youtube\YoutubeTagGeneratorController;
use App\Http\Controllers\Tools\Youtube\YoutubeThumbnailDownloaderController;
use App\Http\Controllers\Tools\Youtube\YoutubeVideoDataExtractorController;
use App\Http\Controllers\Tools\Youtube\YoutubeVideoTagsExtractorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\BlogController;


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name($n('home'));

// Category Index Routes
Route::get('youtube-tools', [App\Http\Controllers\CategoryController::class, 'youtube'])->name($n('category.youtube'));
Route::get('seo-tools', [App\Http\Controllers\CategoryController::class, 'seo'])->name($n('category.seo'));
Route::get('utility-tools', [App\Http\Controllers\CategoryController::class, 'utility'])->name($n('category.utility'));
Route::get('network-tools', [App\Http\Controllers\CategoryController::class, 'network'])->name($n('category.network'));
Route::get('image-tools', [App\Http\Controllers\CategoryController::class, 'image'])->name($n('category.image'));
Route::get('document-tools', [App\Http\Controllers\CategoryController::class, 'document'])->name($n('category.document'));
Route::get('time-tools', [App\Http\Controllers\CategoryController::class, 'time'])->name($n('category.time'));
Route::get('text-tools', [App\Http\Controllers\CategoryController::class, 'text'])->name($n('category.text'));
Route::get('development-tools', [App\Http\Controllers\CategoryController::class, 'development'])->name($n('category.development'));
Route::get('converters-tools', [App\Http\Controllers\CategoryController::class, 'converters'])->name($n('category.converters'));
Route::get('spreadsheet-tools', [App\Http\Controllers\CategoryController::class, 'spreadsheet'])->name($n('category.spreadsheet'));
Route::get('video-downloader-tools', [App\Http\Controllers\CategoryController::class, 'videoDownloader'])->name($n('category.video-downloader'));
Route::get('downloader-tools', [App\Http\Controllers\CategoryController::class, 'downloader'])->name($n('category.downloader'));

// Auxiliary Routes
Route::get('lang-switch/{code}', [App\Http\Controllers\LanguageController::class, 'switch'])->name($n('lang.switch'));
Route::get('about-us', [App\Http\Controllers\PageController::class, 'about'])->name($n('about'));
Route::get('contact-us', [App\Http\Controllers\PageController::class, 'contact'])->name($n('contact'));
Route::post('contact-us', [App\Http\Controllers\PageController::class, 'contactSubmit'])->name($n('contact.submit'));
Route::get('privacy-policy', [App\Http\Controllers\PageController::class, 'privacy'])->name($n('privacy'));
Route::get('terms-of-use', [App\Http\Controllers\PageController::class, 'terms'])->name($n('terms'));
Route::get('sponsors', [App\Http\Controllers\PageController::class, 'sponsors'])->name($n('sponsors'));

// Blog Routes
Route::get('blog', [BlogController::class, 'index'])->name($n('blog.index'));
Route::get('blog/{slug}', [BlogController::class, 'show'])->name($n('blog.show'));
Route::get('blog/preview/{slug}', [BlogController::class, 'preview'])->name($n('blog.preview'));
Route::get('blog/category/{slug}', [BlogController::class, 'category'])->name($n('blog.category'));

// Sitemap Routes
Route::get('sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name($n('sitemap.index'));
Route::get('sitemap_{locale}.xml', [App\Http\Controllers\SitemapController::class, 'language'])->name($n('sitemap.language'));

// Youtube Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('youtube-monetization-checker', [YoutubeMonetizationCheckerController::class, 'index'])->name($n('youtube.youtube-monetization-checker'));
    Route::post('youtube-monetization-checker', [YoutubeMonetizationCheckerController::class, 'check'])->name($n('youtube.youtube-monetization-checker.check'));
    Route::get('youtube-thumbnail-downloader', [YoutubeThumbnailDownloaderController::class, 'index'])->name($n('youtube.youtube-thumbnail-downloader'));
    Route::post('youtube-thumbnail-downloader', [YoutubeThumbnailDownloaderController::class, 'process'])->name($n('youtube.youtube-thumbnail-downloader.download'));
    Route::get('youtube-video-data-extractor', [YoutubeVideoDataExtractorController::class, 'index'])->name($n('youtube.youtube-video-data-extractor'));
    Route::post('youtube-video-data-extractor', [YoutubeVideoDataExtractorController::class, 'process'])->name($n('youtube.youtube-video-data-extractor.extract'));
    Route::get('youtube-tag-generator', [YoutubeTagGeneratorController::class, 'index'])->name($n('youtube.youtube-tag-generator'));
    Route::post('youtube-tag-generator', [YoutubeTagGeneratorController::class, 'process'])->name($n('youtube.youtube-tag-generator.generate'));
    Route::get('youtube-channel-data-extractor', [YoutubeChannelDataExtractorController::class, 'index'])->name($n('youtube.youtube-channel-data-extractor'));
    Route::post('youtube-channel-data-extractor', [YoutubeChannelDataExtractorController::class, 'extract'])->name($n('youtube.youtube-channel-data-extractor.extract'));
    Route::get('youtube-handle-checker', [YoutubeHandleCheckerController::class, 'index'])->name($n('youtube.youtube-handle-checker'));
    Route::post('youtube-handle-checker', [YoutubeHandleCheckerController::class, 'check'])->name($n('youtube.youtube-handle-checker.check'));
    Route::get('youtube-video-tags-extractor', [YoutubeVideoTagsExtractorController::class, 'index'])->name($n('youtube.youtube-video-tags-extractor'));
    Route::post('youtube-video-tags-extractor', [YoutubeVideoTagsExtractorController::class, 'extract'])->name($n('youtube.youtube-video-tags-extractor.extract'));
    Route::get('youtube-channel-id-finder', [YoutubeChannelIdFinderController::class, 'index'])->name($n('youtube.youtube-channel-id-finder'));
    Route::post('youtube-channel-id-finder', [YoutubeChannelIdFinderController::class, 'find'])->name($n('youtube.youtube-channel-id-finder.find'));
    Route::get('youtube-earnings-calculator', [YoutubeEarningsCalculatorController::class, 'index'])->name($n('youtube.youtube-earnings-calculator'));
    Route::post('youtube-earnings-calculator', [YoutubeEarningsCalculatorController::class, 'process'])->name($n('youtube.youtube-earnings-calculator.calculate'));
    Route::get('text-to-speech', [TextToSpeechController::class, 'index'])->name($n('youtube.text-to-speech'));
    Route::post('text-to-speech', [TextToSpeechController::class, 'process'])->name($n('youtube.text-to-speech.generate'));

    // Video Downloader Tools
    Route::get('youtube-video-downloader', [\App\Http\Controllers\Tools\Youtube\YoutubeVideoDownloaderController::class, 'index'])->name($n('downloader.youtube-video-downloader'));
    Route::post('youtube-video-downloader', [\App\Http\Controllers\Tools\Youtube\YoutubeVideoDownloaderController::class, 'process'])->name($n('downloader.youtube-video-downloader.process'));

    // New SSE Routes
    Route::get('youtube-video-downloader/search', [\App\Http\Controllers\Tools\Youtube\YoutubeVideoDownloaderController::class, 'downloadSearch'])->name($n('downloader.youtube-video-downloader.search'));
    Route::get('youtube-video-downloader/file', [\App\Http\Controllers\Tools\Youtube\YoutubeVideoDownloaderController::class, 'downloadFile'])->name($n('downloader.youtube-video-downloader.file'));
});

// Seo Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('slug-generator', [SlugGeneratorController::class, 'index'])->name($n('seo.slug-generator'));
    Route::post('slug-generator', [SlugGeneratorController::class, 'process'])->name($n('seo.slug-generator.generate'));
    Route::get('meta-tag-analyzer', [MetaTagAnalyzerController::class, 'index'])->name($n('seo.meta-tag-analyzer'));
    Route::post('meta-tag-analyzer', [MetaTagAnalyzerController::class, 'process'])->name($n('seo.meta-tag-analyzer.analyze'));
    Route::get('keyword-density-checker', [KeywordDensityCheckerController::class, 'index'])->name($n('seo.keyword-density-checker'));
    Route::post('keyword-density-checker', [KeywordDensityCheckerController::class, 'process'])->name($n('seo.keyword-density-checker.check'));
    Route::get('redirect-checker', [RedirectCheckerController::class, 'index'])->name($n('seo.redirect-checker'));
    Route::post('redirect-checker/check', [RedirectCheckerController::class, 'process'])->name($n('seo.redirect-checker.check'));
    Route::post('redirect-checker/canonical', [RedirectCheckerController::class, 'checkCanonical'])->name($n('seo.redirect-checker.canonical'));
    Route::get('sitemap-validator', [SitemapValidatorController::class, 'index'])->name($n('seo.sitemap-validator'));
    Route::post('sitemap-validator/fetch', [SitemapValidatorController::class, 'fetch'])->name($n('seo.sitemap-validator.fetch'));
    Route::post('sitemap-validator/validate', [SitemapValidatorController::class, 'validate'])->name($n('seo.sitemap-validator.validate'));
    Route::get('bing-serp-checker', [BingSerpCheckerController::class, 'index'])->name($n('seo.bing-serp-checker'));
    Route::post('bing-serp-checker', [BingSerpCheckerController::class, 'process'])->name($n('seo.bing-serp-checker.check'));
    Route::get('google-serp-checker', [GoogleSerpCheckerController::class, 'index'])->name($n('seo.google-serp-checker'));
    Route::post('google-serp-checker', [GoogleSerpCheckerController::class, 'process'])->name($n('seo.google-serp-checker.check'));
    Route::get('google-index-checker', [App\Http\Controllers\Tools\Seo\GoogleIndexCheckerController::class, 'index'])->name($n('seo.google-index-checker'));
    Route::post('google-index-checker', [App\Http\Controllers\Tools\Seo\GoogleIndexCheckerController::class, 'process'])->name($n('seo.google-index-checker.check'));
    Route::get('broken-links-checker', [BrokenLinksCheckerController::class, 'index'])->name($n('seo.broken-links-checker'));
    Route::post('broken-links-checker/extract', [BrokenLinksCheckerController::class, 'extract'])->name($n('seo.broken-links-checker.extract'));
    Route::post('broken-links-checker/status', [BrokenLinksCheckerController::class, 'checkStatus'])->name($n('seo.broken-links-checker.status'));
    Route::get('on-page-seo-checker', [OnPageSeoCheckerController::class, 'index'])->name($n('seo.on-page-seo-checker'));
    Route::post('on-page-seo-checker/init', [OnPageSeoCheckerController::class, 'init'])->name($n('seo.on-page-seo-checker.init'));
    Route::post('on-page-seo-checker/analyze', [OnPageSeoCheckerController::class, 'analyzeStep'])->name($n('seo.on-page-seo-checker.analyze-step'));
    Route::get('on-page-seo-checker/export', [OnPageSeoCheckerController::class, 'exportPdf'])->name($n('seo.on-page-seo-checker.export'));
    Route::get('locations/search', [LocationController::class, 'search'])->name($n('seo.locations.search'));
    Route::get('yahoo-serp-checker', [YahooSerpCheckerController::class, 'index'])->name($n('seo.yahoo-serp-checker'));
    Route::post('yahoo-serp-checker', [YahooSerpCheckerController::class, 'process'])->name($n('seo.yahoo-serp-checker.check'));
    Route::get('hreflang-checker', [HreflangCheckerController::class, 'index'])->name($n('seo.hreflang-checker'));
    Route::post('hreflang-checker', [HreflangCheckerController::class, 'process'])->name($n('seo.hreflang-checker.check'));
    Route::get('google-allintitle-checker', [AllintitleCheckerController::class, 'index'])->name($n('seo.google-allintitle-checker'));
    Route::post('google-allintitle-checker', [AllintitleCheckerController::class, 'process'])->name($n('seo.google-allintitle-checker.check'));
});

// Document Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('pdf-to-word', [PdfToWordController::class, 'index'])->name($n('document.pdf-to-word'));
    Route::post('pdf-to-word', [PdfToWordController::class, 'process'])->name($n('document.pdf-to-word.process'));
    Route::get('word-to-pdf', [WordToPdfController::class, 'index'])->name($n('document.word-to-pdf'));
    Route::post('word-to-pdf', [WordToPdfController::class, 'process'])->name($n('document.word-to-pdf.process'));
    Route::get('pdf-to-excel', [PdfToExcelController::class, 'index'])->name($n('document.pdf-to-excel'));
    Route::post('pdf-to-excel', [PdfToExcelController::class, 'process'])->name($n('document.pdf-to-excel.process'));
    Route::get('excel-to-pdf', [ExcelToPdfController::class, 'index'])->name($n('document.excel-to-pdf'));
    Route::post('excel-to-pdf', [ExcelToPdfController::class, 'process'])->name($n('document.excel-to-pdf.process'));
    Route::get('ppt-to-pdf', [PptToPdfController::class, 'index'])->name($n('document.ppt-to-pdf'));
    Route::post('ppt-to-pdf', [PptToPdfController::class, 'process'])->name($n('document.ppt-to-pdf.process'));
    Route::get('pdf-to-ppt', [PdfToPptController::class, 'index'])->name($n('document.pdf-to-ppt'));
    Route::post('pdf-to-ppt', [PdfToPptController::class, 'process'])->name($n('document.pdf-to-ppt.process'));
    Route::get('pdf-to-jpg', [PdfToJpgController::class, 'index'])->name($n('document.pdf-to-jpg'));
    Route::post('pdf-to-jpg', [PdfToJpgController::class, 'process'])->name($n('document.pdf-to-jpg.process'));
    Route::get('jpg-to-pdf', [JpgToPdfController::class, 'index'])->name($n('document.jpg-to-pdf'));
    Route::post('jpg-to-pdf', [JpgToPdfController::class, 'process'])->name($n('document.jpg-to-pdf.process'));
    Route::get('pdf-compressor', [PdfCompressorController::class, 'index'])->name($n('document.pdf-compressor'));
    Route::post('pdf-compressor', [PdfCompressorController::class, 'process'])->name($n('document.pdf-compressor.process'));
    Route::get('pdf-merger', [PdfMergerController::class, 'index'])->name($n('document.pdf-merger'));
    Route::post('pdf-merger', [PdfMergerController::class, 'process'])->name($n('document.pdf-merger.process'));
    Route::get('pdf-splitter', [PdfSplitterController::class, 'index'])->name($n('document.pdf-splitter'));
    Route::post('pdf-splitter', [PdfSplitterController::class, 'process'])->name($n('document.pdf-splitter.process'));
    Route::get('digital-signature', [DigitalSignatureController::class, 'index'])->name($n('document.digital-signature'));
});

// Image Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('image-converter', [ImageConverterController::class, 'index'])->name($n('image.image-converter'));
    Route::post('image-converter', [ImageConverterController::class, 'process']);
    Route::get('jpg-to-png-converter', [JpgToPngConverterController::class, 'index'])->name($n('image.jpg-to-png-converter'));
    Route::post('jpg-to-png-converter', [JpgToPngConverterController::class, 'process']);
    Route::get('png-to-jpg-converter', [PngToJpgConverterController::class, 'index'])->name($n('image.png-to-jpg-converter'));
    Route::post('png-to-jpg-converter', [PngToJpgConverterController::class, 'process']);
    Route::get('jpg-to-webp-converter', [JpgToWebpConverterController::class, 'index'])->name($n('image.jpg-to-webp-converter'));
    Route::post('jpg-to-webp-converter', [JpgToWebpConverterController::class, 'process']);
    Route::get('webp-to-jpg-converter', [WebpToJpgConverterController::class, 'index'])->name($n('image.webp-to-jpg-converter'));
    Route::post('webp-to-jpg-converter', [WebpToJpgConverterController::class, 'process']);
    Route::get('heic-to-jpg-converter', [HeicToJpgConverterController::class, 'index'])->name($n('image.heic-to-jpg-converter'));
    Route::post('heic-to-jpg-converter', [HeicToJpgConverterController::class, 'process']);
    Route::get('image-to-base64-converter', [ImageToBase64ConverterController::class, 'index'])->name($n('image.image-to-base64-converter'));
    Route::post('image-to-base64-converter', [ImageToBase64ConverterController::class, 'process'])->name($n('image.image-to-base64-converter.convert'));
    Route::get('base64-to-image-converter', [Base64ToImageConverterController::class, 'index'])->name($n('image.base64-to-image-converter'));
    Route::post('base64-to-image-converter', [Base64ToImageConverterController::class, 'process'])->name($n('image.base64-to-image-converter.convert'));
    Route::get('png-to-webp-converter', [PngToWebpConverterController::class, 'index'])->name($n('image.png-to-webp-converter'));
    Route::post('png-to-webp-converter', [PngToWebpConverterController::class, 'process'])->name($n('image.png-to-webp-converter.convert'));
    Route::get('svg-to-png-converter', [SvgToPngConverterController::class, 'index'])->name($n('image.svg-to-png-converter'));
    Route::post('svg-to-png-converter', [SvgToPngConverterController::class, 'process'])->name($n('image.svg-to-png-converter.convert'));
    Route::get('svg-to-jpg-converter', [SvgToJpgConverterController::class, 'index'])->name($n('image.svg-to-jpg-converter'));
    Route::post('svg-to-jpg-converter', [SvgToJpgConverterController::class, 'process'])->name($n('image.svg-to-jpg-converter.convert'));
    Route::get('ico-converter', [IcoConverterController::class, 'index'])->name($n('image.ico-converter'));
    Route::post('ico-converter', [IcoConverterController::class, 'process'])->name($n('image.ico-converter.convert'));
    Route::get('image-compressor', [ImageCompressorController::class, 'index'])->name($n('image.image-compressor'));
    Route::post('image-compressor', [ImageCompressorController::class, 'process'])->name($n('image.image-compressor.compress'));
    Route::get('jpg-to-heic-converter', [JpgToHeicConverterController::class, 'index'])->name($n('image.jpg-to-heic-converter'));
    Route::post('jpg-to-heic-converter', [JpgToHeicConverterController::class, 'process'])->name($n('image.jpg-to-heic-converter.convert'));
    Route::get('png-to-heic-converter', [PngToHeicConverterController::class, 'index'])->name($n('image.png-to-heic-converter'));
    Route::post('png-to-heic-converter', [PngToHeicConverterController::class, 'process'])->name($n('image.png-to-heic-converter.convert'));
    Route::get('webp-to-png-converter', [WebPToPngConverterController::class, 'index'])->name($n('image.webp-to-png-converter'));
    Route::get('avif-to-jpg-converter', [AvifToJpgConverterController::class, 'index'])->name($n('image.avif-to-jpg-converter'));
    Route::get('avif-to-png-converter', [AvifToPngConverterController::class, 'index'])->name($n('image.avif-to-png-converter'));
    Route::get('tiff-to-jpg-converter', [TiffToJpgConverterController::class, 'index'])->name($n('image.tiff-to-jpg-converter'));
    Route::post('tiff-to-jpg-converter', [TiffToJpgConverterController::class, 'process'])->name($n('image.tiff-to-jpg-converter.convert'));
    Route::get('bmp-to-jpg-converter', [BmpToJpgConverterController::class, 'index'])->name($n('image.bmp-to-jpg-converter'));
    Route::get('raw-to-jpg-converter', [RawToJpgConverterController::class, 'index'])->name($n('image.raw-to-jpg-converter'));
    Route::post('raw-to-jpg-converter', [RawToJpgConverterController::class, 'process'])->name($n('image.raw-to-jpg-converter.convert'));
    Route::get('image-color-picker', [ImageColorPickerController::class, 'index'])->name($n('image.image-color-picker'));
    Route::get('image-color-replacer', [ImageColorReplacerController::class, 'index'])->name($n('image.image-color-replacer'));
    Route::get('grayscale-image-converter', [GrayscaleImageConverterController::class, 'index'])->name($n('image.grayscale-image-converter'));
    Route::get('black-and-white-image-converter', [BlackAndWhiteImageConverterController::class, 'index'])->name($n('image.black-and-white-image-converter'));
    Route::get('image-brightness-contrast-adjuster', [ImageBrightnessContrastController::class, 'index'])->name($n('image.image-brightness-contrast-adjuster'));
    Route::get('image-sharpener', [ImageSharpenerController::class, 'index'])->name($n('image.image-sharpener'));
    Route::get('image-noise-reducer', [ImageNoiseReducerController::class, 'index'])->name($n('image.image-noise-reducer'));
    Route::get('image-metadata-viewer', [ImageMetadataViewerController::class, 'index'])->name($n('image.image-metadata-viewer'));
    Route::post('image-metadata-viewer', [ImageMetadataViewerController::class, 'process'])->name($n('image.image-metadata-viewer.process'));
    Route::get('image-metadata-remover', [ImageMetadataRemoverController::class, 'index'])->name($n('image.image-metadata-remover'));
    Route::post('image-metadata-remover', [ImageMetadataRemoverController::class, 'process'])->name($n('image.image-metadata-remover.process'));
    Route::get('image-copyright-stamp', [ImageCopyrightStampController::class, 'index'])->name($n('image.image-copyright-stamp'));
    Route::get('sprite-sheet-generator', [SpriteSheetGeneratorController::class, 'index'])->name($n('image.sprite-sheet-generator'));
    Route::get('image-lazy-load-generator', [ImageLazyLoadGeneratorController::class, 'index'])->name($n('image.image-lazy-load-generator'));
    Route::get('responsive-image-generator', [ResponsiveImageGeneratorController::class, 'index'])->name($n('image.responsive-image-generator'));
});

// Time Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('time-zone-converter', [TimeZoneConverterController::class, 'index'])->name($n('time.time-zone-converter'));
    Route::post('time-zone-converter', [TimeZoneConverterController::class, 'process'])->name($n('time.time-zone-converter.generate'));
    Route::get('epoch-time-converter', [EpochTimeConverterController::class, 'index'])->name($n('time.epoch-time-converter'));
    Route::post('epoch-time-converter', [EpochTimeConverterController::class, 'process'])->name($n('time.epoch-time-converter.generate'));
    Route::get('time-unit-converter', [TimeUnitConverterController::class, 'index'])->name($n('time.time-unit-converter'));
    Route::post('time-unit-converter', [TimeUnitConverterController::class, 'process'])->name($n('time.time-unit-converter.generate'));
    Route::get('unix-timestamp-to-date', [UnixTimestampToDateController::class, 'index'])->name($n('time.unix-timestamp-to-date'));
    Route::post('unix-timestamp-to-date', [UnixTimestampToDateController::class, 'process'])->name($n('time.unix-timestamp-to-date.generate'));
    Route::get('date-to-unix-timestamp', [DateToUnixTimestampController::class, 'index'])->name($n('time.date-to-unix-timestamp'));
    Route::post('date-to-unix-timestamp', [DateToUnixTimestampController::class, 'process'])->name($n('time.date-to-unix-timestamp.generate'));
    Route::get('utc-to-local-time', [UtcToLocalTimeController::class, 'index'])->name($n('time.utc-to-local-time'));
    Route::post('utc-to-local-time', [UtcToLocalTimeController::class, 'process'])->name($n('time.utc-to-local-time.generate'));
    Route::get('local-time-to-utc', [LocalTimeToUtcController::class, 'index'])->name($n('time.local-time-to-utc'));
    Route::post('local-time-to-utc', [LocalTimeToUtcController::class, 'process'])->name($n('time.local-time-to-utc.generate'));
});

// Text Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('morse-to-text-converter', [MorseToTextConverterController::class, 'index'])->name($n('text.morse-to-text-converter'));
    Route::post('morse-to-text-converter', [MorseToTextConverterController::class, 'process'])->name($n('text.morse-to-text-converter.convert'));
    Route::get('text-reverser', [TextReverserController::class, 'index'])->name($n('text.text-reverser'));
    Route::post('text-reverser', [TextReverserController::class, 'process'])->name($n('text.text-reverser.reverse'));
    Route::get('text-to-morse-converter', [TextToMorseConverterController::class, 'index'])->name($n('text.text-to-morse-converter'));
    Route::post('text-to-morse-converter', [TextToMorseConverterController::class, 'process'])->name($n('text.text-to-morse-converter.convert'));
    Route::get('lorem-ipsum-generator', [LoremIpsumGeneratorController::class, 'index'])->name($n('text.lorem-ipsum-generator'));
    Route::post('lorem-ipsum-generator', [LoremIpsumGeneratorController::class, 'process'])->name($n('text.lorem-ipsum-generator.generate'));
    Route::get('duplicate-line-remover', [DuplicateLineRemoverController::class, 'index'])->name($n('text.duplicate-line-remover'));
    Route::post('duplicate-line-remover', [DuplicateLineRemoverController::class, 'process'])->name($n('text.duplicate-line-remover.remove'));
    Route::get('file-difference-checker', [FileDifferenceCheckerController::class, 'index'])->name($n('text.file-difference-checker'));
    Route::post('file-difference-checker', [FileDifferenceCheckerController::class, 'process'])->name($n('text.file-difference-checker.check'));
    Route::get('word-counter', [WordCounterController::class, 'index'])->name($n('text.word-counter'));
    Route::post('word-counter', [WordCounterController::class, 'process'])->name($n('text.word-counter.count'));
});

// Utility Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('qr-code-generator', [QrCodeGeneratorController::class, 'index'])->name($n('utility.qr-code-generator'));
    Route::post('qr-code-generator', [QrCodeGeneratorController::class, 'process'])->name($n('utility.qr-code-generator.generate'));
    Route::get('username-checker', [UsernameCheckerController::class, 'index'])->name($n('utility.username-checker'));
    Route::post('username-checker', [UsernameCheckerController::class, 'process'])->name($n('utility.username-checker.check'));
    Route::get('password-generator', [PasswordGeneratorController::class, 'index'])->name($n('utility.password-generator'));
    Route::post('password-generator', [PasswordGeneratorController::class, 'process'])->name($n('utility.password-generator.generate'));
    Route::get('random-number-generator', [RandomNumberGeneratorController::class, 'index'])->name($n('utility.random-number-generator'));
    Route::post('random-number-generator', [RandomNumberGeneratorController::class, 'process'])->name($n('utility.random-number-generator.generate'));
    Route::get('url-opener', [UrlOpenerController::class, 'index'])->name($n('utility.url-opener'));
});

// Spreadsheet Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('csv-to-xml-converter', [CsvToXmlConverterController::class, 'index'])->name($n('spreadsheet.csv-to-xml-converter'));
    Route::post('csv-to-xml-converter', [CsvToXmlConverterController::class, 'process'])->name($n('spreadsheet.csv-to-xml-converter.convert'));
    Route::get('tsv-to-csv-converter', [TsvToCsvConverterController::class, 'index'])->name($n('spreadsheet.tsv-to-csv-converter'));
    Route::post('tsv-to-csv-converter', [TsvToCsvConverterController::class, 'process'])->name($n('spreadsheet.tsv-to-csv-converter.convert'));
    Route::get('excel-to-csv', [ExcelToCsvController::class, 'index'])->name($n('spreadsheet.excel-to-csv'));
    Route::post('excel-to-csv', [ExcelToCsvController::class, 'process'])->name($n('spreadsheet.excel-to-csv.convert'));
    Route::get('csv-to-excel', [CsvToExcelController::class, 'index'])->name($n('spreadsheet.csv-to-excel'));
    Route::post('csv-to-excel', [CsvToExcelController::class, 'process'])->name($n('spreadsheet.csv-to-excel.convert'));
    Route::get('xls-to-xlsx', [XlsToXlsxController::class, 'index'])->name($n('spreadsheet.xls-to-xlsx'));
    Route::post('xls-to-xlsx', [XlsToXlsxController::class, 'process'])->name($n('spreadsheet.xls-to-xlsx.convert'));
    Route::get('xlsx-to-xls', [XlsxToXlsController::class, 'index'])->name($n('spreadsheet.xlsx-to-xls'));
    Route::post('xlsx-to-xls', [XlsxToXlsController::class, 'process'])->name($n('spreadsheet.xlsx-to-xls.convert'));
    Route::get('google-sheets-to-excel', [GoogleSheetsToExcelController::class, 'index'])->name($n('spreadsheet.google-sheets-to-excel'));
    Route::post('google-sheets-to-excel', [GoogleSheetsToExcelController::class, 'process'])->name($n('spreadsheet.google-sheets-to-excel.convert'));
    Route::get('csv-to-sql', [CsvToSqlController::class, 'index'])->name($n('spreadsheet.csv-to-sql'));
    Route::post('csv-to-sql', [CsvToSqlController::class, 'process'])->name($n('spreadsheet.csv-to-sql.convert'));
    Route::get('csv-to-json', [CsvToJsonController::class, 'index'])->name($n('spreadsheet.csv-to-json'));
    Route::post('csv-to-json', [CsvToJsonController::class, 'process'])->name($n('spreadsheet.csv-to-json.convert'));
    Route::get('csv-to-tsv', [CsvToTsvController::class, 'index'])->name($n('spreadsheet.csv-to-tsv'));
    Route::post('csv-to-tsv', [CsvToTsvController::class, 'process'])->name($n('spreadsheet.csv-to-tsv.convert'));
});

// Development Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('uuid-generator', [UuidGeneratorController::class, 'index'])->name($n('development.uuid-generator'));
    Route::post('uuid-generator', [UuidGeneratorController::class, 'process'])->name($n('development.uuid-generator.generate'));
    Route::get('md5-generator', [Md5GeneratorController::class, 'index'])->name($n('development.md5-generator'));
    Route::post('md5-generator', [Md5GeneratorController::class, 'process'])->name($n('development.md5-generator.generate'));
    Route::get('json-formatter', [JsonFormatterController::class, 'index'])->name($n('development.json-formatter'));
    Route::post('json-formatter', [JsonFormatterController::class, 'process'])->name($n('development.json-formatter.generate'));
    Route::get('base64-encoder-decoder', [Base64EncoderDecoderController::class, 'index'])->name($n('development.base64-encoder-decoder'));
    Route::post('base64-encoder-decoder', [Base64EncoderDecoderController::class, 'process'])->name($n('development.base64-encoder-decoder.generate'));
    Route::get('html-viewer', [HtmlViewerController::class, 'index'])->name($n('development.html-viewer'));
    Route::post('html-viewer', [HtmlViewerController::class, 'process'])->name($n('development.html-viewer.generate'));
    Route::get('json-parser', [JsonParserController::class, 'index'])->name($n('development.json-parser'));
    Route::post('json-parser', [JsonParserController::class, 'process'])->name($n('development.json-parser.generate'));
    Route::get('code-formatter', [CodeFormatterController::class, 'index'])->name($n('development.code-formatter'));
    Route::post('code-formatter', [CodeFormatterController::class, 'process'])->name($n('development.code-formatter.generate'));
    Route::get('css-minifier', [CssMinifierController::class, 'index'])->name($n('development.css-minifier'));
    Route::post('css-minifier', [CssMinifierController::class, 'process'])->name($n('development.css-minifier.generate'));
    Route::get('js-minifier', [JsMinifierController::class, 'index'])->name($n('development.js-minifier'));
    Route::post('js-minifier', [JsMinifierController::class, 'process'])->name($n('development.js-minifier.generate'));
    Route::get('html-minifier', [HtmlMinifierController::class, 'index'])->name($n('development.html-minifier'));
    Route::post('html-minifier', [HtmlMinifierController::class, 'process'])->name($n('development.html-minifier.generate'));
    Route::get('html-encoder-decoder', [HtmlEncoderDecoderController::class, 'index'])->name($n('development.html-encoder-decoder'));
    Route::post('html-encoder-decoder', [HtmlEncoderDecoderController::class, 'process'])->name($n('development.html-encoder-decoder.generate'));
    Route::get('html-to-markdown-converter', [HtmlToMarkdownConverterController::class, 'index'])->name($n('development.html-to-markdown-converter'));
    Route::post('html-to-markdown-converter', [HtmlToMarkdownConverterController::class, 'process'])->name($n('development.html-to-markdown-converter.generate'));
    Route::get('json-to-sql-converter', [JsonToSqlConverterController::class, 'index'])->name($n('development.json-to-sql-converter'));
    Route::post('json-to-sql-converter', [JsonToSqlConverterController::class, 'process'])->name($n('development.json-to-sql-converter.generate'));
    Route::get('json-to-xml-converter', [JsonToXmlConverterController::class, 'index'])->name($n('development.json-to-xml-converter'));
    Route::post('json-to-xml-converter', [JsonToXmlConverterController::class, 'process'])->name($n('development.json-to-xml-converter.generate'));
    Route::get('json-to-yaml-converter', [JsonToYamlConverterController::class, 'index'])->name($n('development.json-to-yaml-converter'));
    Route::post('json-to-yaml-converter', [JsonToYamlConverterController::class, 'process'])->name($n('development.json-to-yaml-converter.generate'));
    Route::get('jwt-decoder', [JwtDecoderController::class, 'index'])->name($n('development.jwt-decoder'));
    Route::post('jwt-decoder', [JwtDecoderController::class, 'process'])->name($n('development.jwt-decoder.generate'));
    Route::get('markdown-to-html-converter', [MarkdownToHtmlConverterController::class, 'index'])->name($n('development.markdown-to-html-converter'));
    Route::post('markdown-to-html-converter', [MarkdownToHtmlConverterController::class, 'process'])->name($n('development.markdown-to-html-converter.convert'));
    Route::get('unicode-encoder-decoder', [UnicodeEncoderDecoderController::class, 'index'])->name($n('development.unicode-encoder-decoder'));
    Route::post('unicode-encoder-decoder', [UnicodeEncoderDecoderController::class, 'process'])->name($n('development.unicode-encoder-decoder.generate'));
    Route::get('url-encoder-decoder', [UrlEncoderDecoderController::class, 'index'])->name($n('development.url-encoder-decoder'));
    Route::post('url-encoder-decoder', [UrlEncoderDecoderController::class, 'process'])->name($n('development.url-encoder-decoder.generate'));
    Route::get('xml-formatter', [XmlFormatterController::class, 'index'])->name($n('development.xml-formatter'));
    Route::post('xml-formatter', [XmlFormatterController::class, 'process'])->name($n('development.xml-formatter.generate'));
    Route::get('cron-job-generator', [CronJobGeneratorController::class, 'index'])->name($n('development.cron-job-generator'));
    Route::post('cron-job-generator', [CronJobGeneratorController::class, 'process'])->name($n('development.cron-job-generator.generate'));
    Route::get('curl-command-builder', [CurlCommandBuilderController::class, 'index'])->name($n('development.curl-command-builder'));
    Route::post('curl-command-builder', [CurlCommandBuilderController::class, 'process'])->name($n('development.curl-command-builder.generate'));
    Route::get('json-to-csv-converter', [JsonToCsvConverterController::class, 'index'])->name($n('development.json-to-csv-converter'));
    Route::post('json-to-csv-converter', [JsonToCsvConverterController::class, 'process'])->name($n('development.json-to-csv-converter.generate'));
    Route::get('xml-to-csv', [XmlToCsvController::class, 'index'])->name($n('development.xml-to-csv'));
    Route::post('xml-to-csv', [XmlToCsvController::class, 'process'])->name($n('development.xml-to-csv.convert'));
    Route::get('xml-to-json', [XmlToJsonController::class, 'index'])->name($n('development.xml-to-json'));
    Route::post('xml-to-json', [XmlToJsonController::class, 'process'])->name($n('development.xml-to-json.convert'));
    Route::get('yaml-to-json', [YamlToJsonController::class, 'index'])->name($n('development.yaml-to-json'));
    Route::post('yaml-to-json', [YamlToJsonController::class, 'process'])->name($n('development.yaml-to-json.convert'));
    Route::get('sql-to-json', function () {
        return redirect()->route('development.sql-to-json-converter', [], 301);
    });
    Route::get('sql-to-json-converter', [SqlToJsonConverterController::class, 'index'])->name($n('development.sql-to-json-converter'));

    // Hash Generator Tools
    $hashTools = [
        'adler32-hash-generator',
        'crc32-hash-generator',
        'crc32b-hash-generator',
        'md4-hash-generator',
        'sha1-hash-generator',
        'sha256-hash-generator',
        'sha384-hash-generator',
        'sha512-hash-generator',
        'ripemd128-hash-generator',
        'ripemd160-hash-generator',
        'tiger128-hash-generator',
        'tiger160-hash-generator',
        'tiger192-hash-generator',
        'whirlpool-hash-generator',
        'snefru-hash-generator',
        'haval128-hash-generator',
        'gost-hash-generator',
    ];
    foreach ($hashTools as $ht) {
        Route::get($ht, [HashGeneratorController::class, 'index'])->defaults('slug', $ht)->name($n('development.' . $ht));
        Route::post($ht, [HashGeneratorController::class, 'process'])->defaults('slug', $ht)->name($n('development.' . $ht . '.generate'));
    }
});

// Converters Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('rgb-hex-converter', [RgbHexConverterController::class, 'index'])->name($n('converters.rgb-hex-converter'));
    Route::post('rgb-hex-converter', [RgbHexConverterController::class, 'process'])->name($n('converters.rgb-hex-converter.convert'));
    Route::get('case-converter', [CaseConverterController::class, 'index'])->name($n('converters.case-converter'));
    Route::post('case-converter', [CaseConverterController::class, 'process'])->name($n('converters.case-converter.convert'));
    Route::get('ascii-converter', [AsciiConverterController::class, 'index'])->name($n('converters.ascii-converter'));
    Route::post('ascii-converter', [AsciiConverterController::class, 'process'])->name($n('converters.ascii-converter.convert'));
    Route::get('binary-hex-converter', [BinaryHexConverterController::class, 'index'])->name($n('converters.binary-hex-converter'));
    Route::post('binary-hex-converter', [BinaryHexConverterController::class, 'process'])->name($n('converters.binary-hex-converter.convert'));
    Route::get('camel-case-converter', [CamelCaseConverterController::class, 'index'])->name($n('converters.camel-case-converter'));
    Route::post('camel-case-converter', [CamelCaseConverterController::class, 'process'])->name($n('converters.camel-case-converter.convert'));
    Route::get('decimal-binary-converter', [DecimalBinaryConverterController::class, 'index'])->name($n('converters.decimal-binary-converter'));
    Route::post('decimal-binary-converter', [DecimalBinaryConverterController::class, 'process'])->name($n('converters.decimal-binary-converter.convert'));
    Route::get('decimal-hex-converter', [DecimalHexConverterController::class, 'index'])->name($n('converters.decimal-hex-converter'));
    Route::post('decimal-hex-converter', [DecimalHexConverterController::class, 'process'])->name($n('converters.decimal-hex-converter.convert'));
    Route::get('decimal-octal-converter', [DecimalOctalConverterController::class, 'index'])->name($n('converters.decimal-octal-converter'));
    Route::post('decimal-octal-converter', [DecimalOctalConverterController::class, 'process'])->name($n('converters.decimal-octal-converter.convert'));
    Route::get('kebab-case-converter', [KebabCaseConverterController::class, 'index'])->name($n('converters.kebab-case-converter'));
    Route::post('kebab-case-converter', [KebabCaseConverterController::class, 'process'])->name($n('converters.kebab-case-converter.convert'));
    Route::get('number-base-converter', [NumberBaseConverterController::class, 'index'])->name($n('converters.number-base-converter'));
    Route::post('number-base-converter', [NumberBaseConverterController::class, 'process'])->name($n('converters.number-base-converter.convert'));
    Route::get('pascal-case-converter', [PascalCaseConverterController::class, 'index'])->name($n('converters.pascal-case-converter'));
    Route::post('pascal-case-converter', [PascalCaseConverterController::class, 'process'])->name($n('converters.pascal-case-converter.convert'));
    Route::get('sentence-case-converter', [SentenceCaseConverterController::class, 'index'])->name($n('converters.sentence-case-converter'));
    Route::post('sentence-case-converter', [SentenceCaseConverterController::class, 'process'])->name($n('converters.sentence-case-converter.convert'));
    Route::get('snake-case-converter', [SnakeCaseConverterController::class, 'index'])->name($n('converters.snake-case-converter'));
    Route::post('snake-case-converter', [SnakeCaseConverterController::class, 'process'])->name($n('converters.snake-case-converter.convert'));
    Route::get('studly-case-converter', [StudlyCaseConverterController::class, 'index'])->name($n('converters.studly-case-converter'));
    Route::post('studly-case-converter', [StudlyCaseConverterController::class, 'process'])->name($n('converters.studly-case-converter.convert'));
    Route::get('length-converter', [LengthConverterController::class, 'index'])->name($n('converters.length-converter'));
    Route::post('length-converter', [LengthConverterController::class, 'process'])->name($n('converters.length-converter.convert'));
    Route::get('weight-converter', [WeightConverterController::class, 'index'])->name($n('converters.weight-converter'));
    Route::post('weight-converter', [WeightConverterController::class, 'process'])->name($n('converters.weight-converter.convert'));
    Route::get('temperature-converter', [TemperatureConverterController::class, 'index'])->name($n('converters.temperature-converter'));
    Route::post('temperature-converter', [TemperatureConverterController::class, 'process'])->name($n('converters.temperature-converter.convert'));
    Route::get('volume-converter', [VolumeConverterController::class, 'index'])->name($n('converters.volume-converter'));
    Route::post('volume-converter', [VolumeConverterController::class, 'process'])->name($n('converters.volume-converter.convert'));
    Route::get('area-converter', [AreaConverterController::class, 'index'])->name($n('converters.area-converter'));
    Route::post('area-converter', [AreaConverterController::class, 'process'])->name($n('converters.area-converter.convert'));
    Route::get('speed-converter', [SpeedConverterController::class, 'index'])->name($n('converters.speed-converter'));
    Route::post('speed-converter', [SpeedConverterController::class, 'process'])->name($n('converters.speed-converter.convert'));
    Route::get('digital-storage-converter', [DigitalStorageConverterController::class, 'index'])->name($n('converters.digital-storage-converter'));
    Route::post('digital-storage-converter', [DigitalStorageConverterController::class, 'process'])->name($n('converters.digital-storage-converter.convert'));
    Route::get('energy-converter', [EnergyConverterController::class, 'index'])->name($n('converters.energy-converter'));
    Route::post('energy-converter', [EnergyConverterController::class, 'process'])->name($n('converters.energy-converter.convert'));
    Route::get('pressure-converter', [PressureConverterController::class, 'index'])->name($n('converters.pressure-converter'));
    Route::post('pressure-converter', [PressureConverterController::class, 'process'])->name($n('converters.pressure-converter.convert'));
    Route::get('power-converter', [PowerConverterController::class, 'index'])->name($n('converters.power-converter'));
    Route::post('power-converter', [PowerConverterController::class, 'process'])->name($n('converters.power-converter.convert'));
    Route::get('force-converter', [ForceConverterController::class, 'index'])->name($n('converters.force-converter'));
    Route::post('force-converter', [ForceConverterController::class, 'process'])->name($n('converters.force-converter.convert'));
    Route::get('angle-converter', [AngleConverterController::class, 'index'])->name($n('converters.angle-converter'));
    Route::post('angle-converter', [AngleConverterController::class, 'process'])->name($n('converters.angle-converter.convert'));
    Route::get('fuel-consumption-converter', [FuelConsumptionConverterController::class, 'index'])->name($n('converters.fuel-consumption-converter'));
    Route::post('fuel-consumption-converter', [FuelConsumptionConverterController::class, 'process'])->name($n('converters.fuel-consumption-converter.convert'));
    Route::get('data-transfer-rate-converter', [DataTransferRateConverterController::class, 'index'])->name($n('converters.data-transfer-rate-converter'));
    Route::post('data-transfer-rate-converter', [DataTransferRateConverterController::class, 'process'])->name($n('converters.data-transfer-rate-converter.convert'));
    Route::get('cooking-unit-converter', [CookingUnitConverterController::class, 'index'])->name($n('converters.cooking-unit-converter'));
    Route::post('cooking-unit-converter', [CookingUnitConverterController::class, 'process'])->name($n('converters.cooking-unit-converter.convert'));
    Route::get('torque-converter', [TorqueConverterController::class, 'index'])->name($n('converters.torque-converter'));
    Route::post('torque-converter', [TorqueConverterController::class, 'process'])->name($n('converters.torque-converter.convert'));
    Route::get('density-converter', [DensityConverterController::class, 'index'])->name($n('converters.density-converter'));
    Route::post('density-converter', [DensityConverterController::class, 'process'])->name($n('converters.density-converter.convert'));
    Route::get('molar-mass-converter', [MolarMassConverterController::class, 'index'])->name($n('converters.molar-mass-converter'));
    Route::post('molar-mass-converter', [MolarMassConverterController::class, 'process'])->name($n('converters.molar-mass-converter.convert'));
    Route::get('frequency-converter', [FrequencyConverterController::class, 'index'])->name($n('converters.frequency-converter'));
    Route::post('frequency-converter', [FrequencyConverterController::class, 'process'])->name($n('converters.frequency-converter.convert'));
    Route::get('binary-to-text', [BinaryToTextController::class, 'index'])->name($n('converters.binary-to-text'));
    Route::get('text-to-binary', [TextToBinaryController::class, 'index'])->name($n('converters.text-to-binary'));
});

// Network Tools
Route::prefix('tools')->group(function () use ($n) {
    Route::get('user-agent-parser', [UserAgentParserController::class, 'index'])->name($n('network.user-agent-parser'));
    Route::post('user-agent-parser', [UserAgentParserController::class, 'process'])->name($n('network.user-agent-parser.parse'));
    Route::get('what-is-my-ip', [WhatIsMyIpController::class, 'index'])->name($n('network.what-is-my-ip'));
    Route::get('what-is-my-isp', [WhatIsMyIspController::class, 'index'])->name($n('network.what-is-my-isp'));
    Route::get('domain-to-ip', [DomainToIpController::class, 'index'])->name($n('network.domain-to-ip'));
    Route::post('domain-to-ip', [DomainToIpController::class, 'process'])->name($n('network.domain-to-ip.lookup'));
    Route::get('ip-lookup', [IpLookupController::class, 'index'])->name($n('network.ip-lookup'));
    Route::post('ip-lookup', [IpLookupController::class, 'process'])->name($n('network.ip-lookup.lookup'));
    Route::get('dns-lookup', [DnsLookupController::class, 'index'])->name($n('network.dns-lookup'));
    Route::post('dns-lookup/lookup', [DnsLookupController::class, 'lookup'])->name($n('network.dns-lookup.lookup'));
    Route::get('whois-lookup', [WhoisLookupController::class, 'index'])->name($n('network.whois-lookup'));
    Route::post('whois-lookup', [WhoisLookupController::class, 'process'])->name($n('network.whois-lookup.lookup'));
    Route::get('ping-test', [PingTestController::class, 'index'])->name($n('network.ping-test'));
    Route::post('ping-test', [PingTestController::class, 'process'])->name($n('network.ping-test.ping'));
    Route::get('traceroute', [TracerouteController::class, 'index'])->name($n('network.traceroute'));
    Route::post('traceroute', [TracerouteController::class, 'process'])->name($n('network.traceroute.trace'));
    Route::get('port-checker', [PortCheckerController::class, 'index'])->name($n('network.port-checker'));
    Route::post('port-checker', [PortCheckerController::class, 'process'])->name($n('network.port-checker.check'));
    Route::get('reverse-dns-lookup', [ReverseDnsLookupController::class, 'index'])->name($n('network.reverse-dns-lookup'));
    Route::post('reverse-dns-lookup', [ReverseDnsLookupController::class, 'process'])->name($n('network.reverse-dns-lookup.lookup'));
    Route::get('internet-speed-test', [InternetSpeedTestController::class, 'index'])->name($n('network.internet-speed-test'));
    // Route::post('internet-speed-test', [InternetSpeedTestController::class, 'process'])->name($n('network.internet-speed-test.check'));
});






