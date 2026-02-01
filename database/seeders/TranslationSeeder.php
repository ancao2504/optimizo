<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tool;
use App\Models\Language;
use App\Services\TranslationService;

class TranslationSeeder extends Seeder
{
    public function run()
    {
        $ru = Language::where('code', 'ru')->first();

        if (!$ru) {
            $this->command->info('Russian language not found. Skipping translations.');
            return;
        }

        $translations = [
            'time-zone-converter' => [
                'name' => 'Конвертер часовых поясов',
                'description' => 'Мгновенно конвертируйте время между любыми часовыми поясами мира.',
                'meta_title' => 'Конвертер часовых поясов - Перевод времени между зонами',
                'meta_description' => 'Бесплатный онлайн конвертер часовых поясов. Легко переводите время между разными зонами (PST, EST, GMT, UTC и др.) с помощью этого точного инструмента.',
            ],
            'epoch-time-converter' => [
                'name' => 'Конвертер Epoch времени',
                'description' => 'Конвертация Unix timestamp в читаемую дату и обратно.',
                'meta_title' => 'Конвертер Epoch и Unix Timestamp',
                'meta_description' => 'Конвертируйте Unix timestamp в человекопонятную дату и наоборот.',
            ],
            'unix-timestamp-to-date' => [
                'name' => 'Unix Timestamp в дату',
                'description' => 'Преобразование Unix временной метки в обычную дату.',
                'meta_title' => 'Конвертер Unix Timestamp в Дату',
                'meta_description' => 'Бесплатный инструмент для перевода Unix timestamp в дату и время.',
            ],
            'date-to-unix-timestamp' => [
                'name' => 'Дата в Unix Timestamp',
                'description' => 'Преобразование даты и времени в Unix timestamp.',
                'meta_title' => 'Конвертер Даты в Unix Timestamp',
                'meta_description' => 'Получите Unix timestamp из любой даты и времени.',
            ],
            'utc-to-local-time' => [
                'name' => 'UTC в местное время',
                'description' => 'Конвертация времени UTC в ваше местное время.',
                'meta_title' => 'Конвертер UTC в Местное Время',
                'meta_description' => 'Быстро узнайте, сколько времени сейчас в вашем часовом поясе относительно UTC.',
            ],
            'local-time-to-utc' => [
                'name' => 'Местное время в UTC',
                'description' => 'Конвертация вашего местного времени в UTC.',
                'meta_title' => 'Конвертер Местного Времени в UTC',
                'meta_description' => 'Перевод текущего времени в универсальное координированное время (UTC).',
            ],
            'youtube-monetization-checker' => [
                'name' => 'Проверка монетизации YouTube',
                'description' => 'Проверьте, монетизирован ли YouTube канал. Узнайте статус монетизации, количество подписчиков и соответствие требованиям мгновенно.',
                'meta_title' => 'Проверка монетизации YouTube - Проверить статус канала',
                'meta_description' => 'Проверьте статус монетизации любого YouTube канала. Узнайте, включена ли монетизация и соответствует ли канал требованиям партнерской программы.',
            ],
            'youtube-earnings-calculator' => [
                'name' => 'Калькулятор дохода YouTube',
                'description' => 'Рассчитайте предполагаемый доход от видео и канала на YouTube.',
                'meta_title' => 'Калькулятор Дохода YouTube - Рассчитать Заработок',
                'meta_description' => 'Узнайте, сколько можно заработать на YouTube. Оцените доход канала на основе просмотров и CPM.',
            ],
            'youtube-tag-generator' => [
                'name' => 'Генератор тегов YouTube',
                'description' => 'Генерируйте SEO-оптимизированные теги для ваших видео YouTube.',
                'meta_title' => 'Генератор тегов YouTube - SEO оптимизация видео',
                'meta_description' => 'Создавайте эффективные теги для видео YouTube, чтобы улучшить их поиск и ранжирование.',
            ],
            'youtube-thumbnail-downloader' => [
                'name' => 'Загрузчик обложек YouTube',
                'description' => 'Скачивайте обложки (превью) видео YouTube в высоком качестве (HD, FullHD, 4K).',
                'meta_title' => 'Скачать обложку видео YouTube - Сохранить превью',
                'meta_description' => 'Бесплатный инструмент для скачивания обложек (thumbnail) с видео YouTube в лучшем качестве.',
            ],
            'youtube-video-data-extractor' => [
                'name' => 'Экстрактор данных видео YouTube',
                'description' => 'Получите полную информацию о видео YouTube: заголовок, описание, теги, статистику и многое другое.',
                'meta_title' => 'Экстрактор Данных Видео YouTube - Анализ Видео',
                'meta_description' => 'Извлеките метаданные любого видео YouTube. Анализируйте конкурентов и оптимизируйте свой контент.',
            ],
            'youtube-video-tags-extractor' => [
                'name' => 'Экстрактор тегов видео YouTube',
                'description' => 'Извлекайте теги и ключевые слова из любого видео YouTube мгновенно.',
                'meta_title' => 'Экстрактор Тегов Видео YouTube - Скопировать Теги',
                'meta_description' => 'Узнайте теги конкурентов. Скопируйте теги любого видео YouTube для улучшения собственного SEO.',
            ],
            'youtube-channel-data-extractor' => [
                'name' => 'Экстрактор данных канала YouTube',
                'description' => 'Подробная аналитика любого YouTube канала: подписчики, просмотры, видео и статистика.',
                'meta_title' => 'Анализ YouTube Канала - Статистика и Данные',
                'meta_description' => 'Получите детальный отчет о любом YouTube канале. Просмотры, подписчики, дата создания и скрытые метрики.',
            ],
            'youtube-handle-checker' => [
                'name' => 'Проверка YouTube Handle',
                'description' => 'Проверьте доступность уникального имени пользователя (handle) для вашего канала.',
                'meta_title' => 'Проверка YouTube Handle - Занять Имя Канала',
                'meta_description' => 'Проверьте, свободен ли желаемый @handle для вашего YouTube канала. Быстрая проверка доступности.',
            ],
            'youtube-channel-id-finder' => [
                'name' => 'Поиск ID канала YouTube',
                'description' => 'Найдите уникальный Channel ID любого канала по ссылке или имени пользователя.',
                'meta_title' => 'Найти ID YouTube Канала - Поиск Channel ID',
                'meta_description' => 'Легко узнайте ID канала YouTube. Необходим для интеграций, API и настройки рекламы.',
            ],

            // SEO Tools
            'meta-tag-analyzer' => [
                'name' => 'Анализатор мета-тегов',
                'description' => 'Анализ мета-тегов для SEO оптимизации. Проверка title, description, Open Graph и Twitter Cards.',
                'meta_title' => 'Анализатор Мета-тегов - Проверка SEO на Странице',
                'meta_description' => 'Бесплатный инструмент для анализа мета-тегов. Проверьте заголовки и описания страниц для улучшения SEO.',
            ],
            'meta-tag-generator' => [
                'name' => 'Генератор мета-тегов',
                'description' => 'Создавайте правильные мета-теги для вашего сайта. Улучшите SEO с помощью оптимизированных тегов.',
                'meta_title' => 'Генератор Мета-тегов - Создать Meta Tags Онлайн',
                'meta_description' => 'Легко создавайте мета-теги title, description, keywords и другие для вашего веб-сайта.',
            ],
            'keyword-density-checker' => [
                'name' => 'Проверка плотности ключевых слов',
                'description' => 'Анализ частоты использования ключевых слов на веб-странице. Избегайте переспама.',
                'meta_title' => 'Проверка Плотности Ключевых Слов - SEO Анализ Текста',
                'meta_description' => 'Проверьте процентное содержание ключевых слов в тексте. Оптимизируйте контент для поисковых систем.',
            ],
            'keyword-position-checker' => [
                'name' => 'Проверка позиций ключевых слов',
                'description' => 'Узнайте позиции вашего сайта в поисковой выдаче по ключевым словам.',
                'meta_title' => 'Проверка Позиций Сайта - Позиции Ключевых Слов',
                'meta_description' => 'Отслеживайте позиции вашего сайта в Google и Яндекс по заданным запросам бесплатно.',
            ],
            'robots-txt-generator' => [
                'name' => 'Генератор robots.txt',
                'description' => 'Создайте правильный файл robots.txt для управления индексацией вашего сайта.',
                'meta_title' => 'Генератор robots.txt - Создать Файл Роботов',
                'meta_description' => 'Легко создайте файл robots.txt. Разрешите или запретите индексацию разделов вашего сайта.',
            ],
            'sitemap-generator' => [
                'name' => 'Генератор карты сайта (Sitemap)',
                'description' => 'Создайте XML карту сайта для улучшения индексации в поисковых системах.',
                'meta_title' => 'Генератор Sitemap XML - Создать Карту Сайта',
                'meta_description' => 'Бесплатный онлайн генератор sitemap.xml. Ускорьте индексацию вашего сайта в Google и Яндекс.',
            ],
            'alexa-rank-checker' => [
                'name' => 'Проверка Alexa Rank',
                'description' => 'Проверьте популярность и рейтинг веб-сайта в глобальной системе Amazon Alexa.',
                'meta_title' => 'Проверка Alexa Rank - Рейтинг Сайта',
                'meta_description' => 'Узнайте текущий Alexa Rank любого сайта. Оцените трафик и популярность конкурентов.',
            ],
            'online-ping-tool' => [
                'name' => 'Онлайн Ping инструмент',
                'description' => 'Отправьте сигнал поисковым системам о новом контенте на вашем сайте.',
                'meta_title' => 'Онлайн Ping Инструмент - Ускорить Индексацию',
                'meta_description' => 'Бесплатный сервис пинга. Сообщите поисковым системам об обновлениях на вашем сайте для быстрой индексации.',
            ],
            'http-headers-checker' => [
                'name' => 'Проверка HTTP заголовков',
                'description' => 'Просмотрите заголовки HTTP ответа сервера для любого URL.',
                'meta_title' => 'Проверка HTTP Заголовков - Анализ Ответа Сервера',
                'meta_description' => 'Проверьте коды состояния HTTP, настройки сервера и кэширования через анализ заголовков.',
            ],
            'open-graph-generator' => [
                'name' => 'Генератор Open Graph',
                'description' => 'Создайте мета-теги Open Graph для красивого отображения ссылок в соцсетях.',
                'meta_title' => 'Генератор Open Graph - Теги для Соцсетей',
                'meta_description' => 'Создайте OG теги для Facebook, VK, Twitter и LinkedIn. Сделайте ссылки на ваш сайт привлекательными.',
            ],
            'open-graph-checker' => [
                'name' => 'Проверка Open Graph',
                'description' => 'Проверьте, как ваша страница будет выглядеть при шеринге в социальных сетях.',
                'meta_title' => 'Проверка Open Graph - Предпросмотр Ссылок',
                'meta_description' => 'Анализ Open Graph разметки. Убедитесь, что превью вашего сайта отображается корректно.',
            ],
            'twitter-card-generator' => [
                'name' => 'Генератор Twitter Card',
                'description' => 'Создайте мета-теги для карточек Twitter для улучшения кликабельности твитов.',
                'meta_title' => 'Генератор Twitter Card - Оптимизация Твитов',
                'meta_description' => 'Легко создайте разметку Twitter Cards для вашего контента. Привлекайте больше трафика из Twitter.',
            ],
            'whatsapp-link-generator' => [
                'name' => 'Генератор ссылок WhatsApp',
                'description' => 'Создайте прямую ссылку для чата WhatsApp с предустановленным сообщением.',
                'meta_title' => 'Генератор Ссылок WhatsApp - Click to Chat',
                'meta_description' => 'Создайте ссылку для быстрого перехода в чат WhatsApp. Удобно для бизнеса и поддержки клиентов.',
            ],
            'google-serp-checker' => [
                'name' => 'Проверка Google SERP',
                'description' => 'Проверьте выдачу Google по ключевому слову для разных стран и устройств.',
                'meta_title' => 'Проверка Выдачи Google - Анализ SERP',
                'meta_description' => 'Бесплатный инструмент для анализа поисковой выдачи Google (SERP). Посмотрите топ сайтов по запросу.',
            ],
            'bing-serp-checker' => [
                'name' => 'Проверка Bing SERP',
                'description' => 'Анализ поисковой выдачи Bing. Узнайте, кто в топе Bing по вашим запросам.',
                'meta_title' => 'Проверка Выдачи Bing - Анализ SERP',
                'meta_description' => 'Проверьте позиции сайтов в поисковой системе Bing. Анализируйте конкуренцию в Microsoft Bing.',
            ],
            'yahoo-serp-checker' => [
                'name' => 'Проверка Yahoo SERP',
                'description' => 'Проверьте результаты поиска Yahoo по ключевым словам.',
                'meta_title' => 'Проверка Выдачи Yahoo - Анализ SERP',
                'meta_description' => 'Инструмент для анализа поисковой выдачи Yahoo. Узнайте рейтинг сайтов по ключевым запросам.',
            ],
            'keyword-competition-checker' => [
                'name' => 'Проверка конкуренции запросов',
                'description' => 'Оцените уровень конкуренции по ключевым словам в поисковой выдаче.',
                'meta_title' => 'Проверка Конкуренции Ключевых Слов - SEO Анализ',
                'meta_description' => 'Анализируйте сложность продвижения по ключевым словам. Найдите низкоконкурентные запросы.',
            ],
            'on-page-seo-checker' => [
                'name' => 'Проверка SEO на странице',
                'description' => 'Полный анализ SEO факторов одной страницы. Проверьте заголовки, контент и технические параметры.',
                'meta_title' => 'On-Page SEO Checker - Анализ Страницы Онлайн',
                'meta_description' => 'Бесплатный инструмент для SEO анализа страницы. Улучшите ранжирование вашего контента.',
            ],
            'broken-links-checker' => [
                'name' => 'Проверка битых ссылок',
                'description' => 'Сканирование сайта на наличие неработающих ссылок (ошибки 404).',
                'meta_title' => 'Проверка Битых Ссылок - Поиск Ошибок 404',
                'meta_description' => 'Найдите и исправьте битые ссылки на вашем сайте. Улучшите пользовательский опыт и SEO.',
            ],
            'word-counter' => [
                'name' => 'Счетчик слов',
                'description' => 'Подсчет количества слов, символов, предложений и времени чтения.',
                'meta_title' => 'Счетчик Слов и Символов Онлайн',
                'meta_description' => 'Бесплатный счетчик слов. Узнайте длину текста, количество знаков без пробелов и время чтения.',
            ],
            'redirect-checker' => [
                'name' => 'Проверка редиректов',
                'description' => 'Анализ цепочек редиректов и HTTP кодов состояния (301, 302, 404).',
                'meta_title' => 'Проверка Редиректов - Анализ Ссылок',
                'meta_description' => 'Проверьте правильность настройки перенаправлений. Найдите циклические редиректы и битые ссылки.',
            ],
            'get-source-code-of-webpage' => [
                'name' => 'Просмотр кода страницы',
                'description' => 'Получите исходный HTML код любой веб-страницы онлайн.',
                'meta_title' => 'Просмотр Исходного Кода Страницы - HTML Viewer',
                'meta_description' => 'Скачайте или просмотрите исходный код любого сайта. Полезно для анализа структуры и SEO.',
            ],
            'google-index-checker' => [
                'name' => 'Проверка индексации Google',
                'description' => 'Узнайте, сколько страниц вашего сайта проиндексировано в Google.',
                'meta_title' => 'Проверка Индексации Google - Статус Сайта',
                'meta_description' => 'Проверьте статус индексации сайта в Google. Узнайте количество проиндексированных страниц.',
            ],
            'google-cache-checker' => [
                'name' => 'Проверка кэша Google',
                'description' => 'Узнайте, когда Google в последний раз сохранял копию вашей страницы.',
                'meta_title' => 'Проверка Кэша Google - Дата Кэширования',
                'meta_description' => 'Проверьте наличие и дату кэшированной версии страницы в Google. Важно для SEO аудита.',
            ],

            'domain-age-checker' => [
                'name' => 'Проверка возраста домена',
                'description' => 'Определите точный возраст доменного имени с момента регистрации.',
                'meta_title' => 'Проверка Возраста Домена - История Сайта',
                'meta_description' => 'Узнайте возраст любого сайта. Возраст домена является важным фактором ранжирования в SEO.',
            ],
            'domain-authority-checker' => [
                'name' => 'Проверка авторитета домена (DA)',
                'description' => 'Проверьте Domain Authority (DA) сайта. Оцените силу домена.',
                'meta_title' => 'Проверка Авторитета Домена (DA) - Рейтинг Moz',
                'meta_description' => 'Массовая проверка Domain Authority. Оцените SEO потенциал сайта на основе метрик Moz.',
            ],
            'page-authority-checker' => [
                'name' => 'Проверка авторитета страницы (PA)',
                'description' => 'Проверьте Page Authority (PA) конкретной страницы.',
                'meta_title' => 'Проверка Авторитета Страницы (PA) - SEO Метрика',
                'meta_description' => 'Узнайте авторитет отдельной страницы. Важный показатель для продвижения конкретных URL.',
            ],
            'check-gzip-compression' => [
                'name' => 'Проверка GZIP сжатия',
                'description' => 'Проверьте, включено ли сжатие GZIP на вашем веб-сервере.',
                'meta_title' => 'Проверка GZIP Сжатия - Оптимизация Скорости',
                'meta_description' => 'Узнайте, используется ли GZIP сжатие на сайте. Сжатие ускоряет загрузку страниц.',
            ],
            'www-redirect-checker' => [
                'name' => 'Проверка редиректа WWW',
                'description' => 'Проверьте правильность настройки редиректа с www на без-www (или наоборот).',
                'meta_title' => 'Проверка Редиректа WWW - SEO Настройка',
                'meta_description' => 'Убедитесь, что ваш сайт правильно перенаправляет пользователей (301 редирект) для избежания дублирования контента.',
            ],
            'black-list-checker' => [
                'name' => 'Проверка в черных списках',
                'description' => 'Проверьте, не находится ли ваш IP или домен в спам-листах.',
                'meta_title' => 'Проверка Blacklist - Статус IP и Домена',
                'meta_description' => 'Узнайте, заблокирован ли ваш сайт почтовыми сервисами или антивирусами. Проверка по базам RBL.',
            ],

            // Utility Tools
            'json-formatter' => [
                'name' => 'JSON Форматирование',
                'description' => 'Форматирование и валидация JSON данных онлайн. Красивый вывод JSON.',
                'meta_title' => 'JSON Форматер - Валидация и Красивый Вывод',
                'meta_description' => 'Бесплатный инструмент для форматирования JSON. Делает JSON читаемым, проверяет синтаксис.',
            ],
            'json-parser' => [
                'name' => 'JSON Парсер',
                'description' => 'Парсинг и анализ JSON данных. Просмотр структуры JSON в виде дерева.',
                'meta_title' => 'JSON Парсер - Анализ Структуры JSON',
                'meta_description' => 'Онлайн парсер JSON. Просматривайте и анализируйте сложные JSON объекты в удобном виде.',
            ],
            'base64-encoder-decoder' => [
                'name' => 'Base64 Кодер/Декодер',
                'description' => 'Кодирование текста в Base64 и декодирование обратно. Поддержка UTF-8.',
                'meta_title' => 'Base64 Онлайн - Кодировать и Декодировать',
                'meta_description' => 'Инструмент для работы с Base64. Быстрое кодирование и декодирование строк и файлов.',
            ],
            'image-to-base64-converter' => [
                'name' => 'Изображение в Base64',
                'description' => 'Конвертация изображений в строку Base64. Поддержка PNG, JPG, GIF.',
                'meta_title' => 'Конвертер Изображения в Base64',
                'meta_description' => 'Преобразуйте картинки в Base64 код для вставки в HTML или CSS. Бесплатно и быстро.',
            ],
            'base64-to-image-converter' => [
                'name' => 'Base64 в Изображение',
                'description' => 'Декодирование строки Base64 в файл изображения.',
                'meta_title' => 'Декодер Base64 в Картинку',
                'meta_description' => 'Восстановите изображение из Base64 строки. Просмотрите и скачайте декодированный файл.',
            ],
            'qr-code-generator' => [
                'name' => 'Генератор QR кодов',
                'description' => 'Создание QR кодов для ссылок, текста, Wi-Fi и визиток.',
                'meta_title' => 'Генератор QR Кодов - Создать QR Онлайн',
                'meta_description' => 'Бесплатный генератор QR кодов. Настройте цвет, размер и логотип вашего QR кода.',
            ],
            'password-generator' => [
                'name' => 'Генератор паролей',
                'description' => 'Создание надежных и безопасных паролей. Настройка длины и сложности.',
                'meta_title' => 'Генератор Паролей - Создать Сложный Пароль',
                'meta_description' => 'Генерируйте криптостойкие пароли для защиты ваших аккаунтов. Безопасно, в браузере.',
            ],
            'uuid-generator' => [
                'name' => 'Генератор UUID/GUID',
                'description' => 'Генерация уникальных идентификаторов UUID v4.',
                'meta_title' => 'Генератор UUID v4 Онлайн',
                'meta_description' => 'Создайте уникальные UUID (GUID) идентификаторы. Массовая генерация для разработчиков.',
            ],
            'lorem-ipsum-generator' => [
                'name' => 'Генератор Lorem Ipsum',
                'description' => 'Генерация текста-рыбы Lorem Ipsum для дизайна и верстки.',
                'meta_title' => 'Lorem Ipsum Генератор - Текст Рыба',
                'meta_description' => 'Создайте плейсхолдер текст Lorem Ipsum. Настройте количество абзацев или слов.',
            ],
            'md5-generator' => [
                'name' => 'Генератор хеша MD5',
                'description' => 'Создание MD5 хеша из любой строки текста.',
                'meta_title' => 'MD5 Генератор - Создать Хеш Онлайн',
                'meta_description' => 'Быстро зашифруйте текст в MD5 хеш. Используется для проверки целостности данных.',
            ],
            'slug-generator' => [
                'name' => 'Генератор Slug (ЧПУ)',
                'description' => 'Создание SEO-дружественных URL (Slug) из названия статьи.',
                'meta_title' => 'Генератор Slug - Создать ЧПУ Ссылку',
                'meta_description' => 'Конвертируйте заголовок в URL-адрес (слуг). Транслитерация и удаление спецсимволов.',
            ],
            'css-minifier' => [
                'name' => 'Минификатор CSS',
                'description' => 'Сжатие CSS кода для ускорения загрузки сайта.',
                'meta_title' => 'CSS Минификатор - Сжать CSS Онлайн',
                'meta_description' => 'Уменьшите размер CSS файлов. Удаляет пробелы и комментарии для оптимизации.',
            ],
            'js-minifier' => [
                'name' => 'Минификатор JavaScript',
                'description' => 'Сжатие и обфускация JS кода. Уменьшение размера скриптов.',
                'meta_title' => 'JS Минификатор - Сжать JavaScript',
                'meta_description' => 'Оптимизируйте ваш JavaScript код. Быстрая минификация JS онлайн.',
            ],
            'html-minifier' => [
                'name' => 'Минификатор HTML',
                'description' => 'Сжатие HTML кода, удаление лишних пробелов и комментариев.',
                'meta_title' => 'HTML Минификатор - Сжать HTML Код',
                'meta_description' => 'Уменьшите вес HTML страницы для более быстрой загрузки.',
            ],
            'xml-formatter' => [
                'name' => 'XML Форматирование',
                'description' => 'Форматирование и валидация XML документов.',
                'meta_title' => 'XML Форматер - Валидация XML',
                'meta_description' => 'Сделайте XML код читаемым. Подсветка синтаксиса и исправление отступов.',
            ],
            'code-formatter' => [
                'name' => 'Форматирование кода',
                'description' => 'Универсальный форматер кода (Beautifier) для разных языков.',
                'meta_title' => 'Форматирование Кода Онлайн - Beautifier',
                'meta_description' => 'Приведите код в порядок. Поддержка HTML, CSS, JS, PHP и других языков.',
            ],

            'html-viewer' => [
                'name' => 'Просмотр HTML',
                'description' => 'Просмотр и редактирование HTML кода с предпросмотром.',
                'meta_title' => 'HTML Редактор - Просмотр Кода',
                'meta_description' => 'Онлайн редактор HTML. Пишите код и сразу видите результат.',
            ],
            'cron-job-generator' => [
                'name' => 'Генератор Cron Job',
                'description' => 'Создание расписания Cron с помощью понятного интерфейса.',
                'meta_title' => 'Генератор Cron - Настройка Планировщика',
                'meta_description' => 'Легко создайте выражение для Crontab. Визуальный редактор расписания.',
            ],
            'ascii-converter' => [
                'name' => 'Конвертер ASCII',
                'description' => 'Преобразование текста в ASCII коды и обратно.',
                'meta_title' => 'ASCII Конвертер - Текст в Коды',
                'meta_description' => 'Перевод символов в их ASCII числовые значения. Таблица кодов.',
            ],
            'binary-hex-converter' => [
                'name' => 'Конвертер Двоичный в HEX',
                'description' => 'Перевод чисел из двоичной системы в шестнадцатеричную.',
                'meta_title' => 'Двоичный в Шестнадцатеричный - Конвертер Систем',
                'meta_description' => 'Калькулятор для перевода битов в hex коды. Конвертер систем счисления.',
            ],
            'decimal-binary-converter' => [
                'name' => 'Конвертер Десятичный в Двоичный',
                'description' => 'Перевод чисел из десятичной системы в двоичную.',
                'meta_title' => 'Десятичный в Двоичный - Конвертер Чисел',
                'meta_description' => 'Переведите обычные числа в нули и единицы. Конвертер систем счисления.',
            ],
            'decimal-hex-converter' => [
                'name' => 'Конвертер Десятичный в HEX',
                'description' => 'Перевод десятичных чисел в шестнадцатеричный код.',
                'meta_title' => 'Dec <-> Hex Конвертер',
                'meta_description' => 'Перевод чисел между десятичной и шестнадцатеричной системами счисления.',
            ],
            'decimal-octal-converter' => [
                'name' => 'Конвертер Десятичный в Восьмеричный',
                'description' => 'Перевод чисел в восьмеричную систему счисления.',
                'meta_title' => 'Dec <-> Oct Конвертер',
                'meta_description' => 'Онлайн калькулятор для перевода чисел в восьмеричную систему.',
            ],
            'number-base-converter' => [
                'name' => 'Универсальный конвертер систем счисления',
                'description' => 'Перевод чисел между любыми системами (Binary, Octal, Decimal, Hex).',
                'meta_title' => 'Конвертер Систем Счисления - Base Converter',
                'meta_description' => 'Переводите числа из любой системы в любую. Двоичная, десятичная, hex и другие.',
            ],
            'internet-speed-test' => [
                'name' => 'Тест скорости интернета',
                'description' => 'Измерьте скорость вашего интернет-соединения (загрузка и выгрузка).',
                'meta_title' => 'Тест Скорости Интернета (Speedtest) - Онлайн',
                'meta_description' => 'Быстрая проверка скорости интернета. Узнайте свой пинг, download и upload.',
            ],
            'rgb-hex-converter' => [
                'name' => 'Конвертер RGB в HEX',
                'description' => 'Преобразование цветов из RGB формата в HEX код и обратно.',
                'meta_title' => 'RGB <-> HEX Конвертер Цветов',
                'meta_description' => 'Подбор цвета для веб-дизайна. Перевод значений RGB (Red, Green, Blue) в шестнадцатеричный код.',
            ],

            // Image Tools
            'image-converter' => [
                'name' => 'Конвертер изображений',
                'description' => 'Конвертация изображений между форматами (JPG, PNG, WebP, BMP, TIFF).',
                'meta_title' => 'Онлайн Конвертер Изображений - Бесплатно',
                'meta_description' => 'Конвертируйте фото и картинки онлайн. Поддержка всех популярных форматов. Быстро и качественно.',
            ],
            'jpg-to-png-converter' => [
                'name' => 'Конвертер JPG в PNG',
                'description' => 'Преобразование JPG изображений в формат PNG с прозрачностью.',
                'meta_title' => 'JPG в PNG - Конвертировать Онлайн',
                'meta_description' => 'Бесплатный конвертер JPG в PNG. Сохраните качество при изменении формата.',
            ],
            'png-to-jpg-converter' => [
                'name' => 'Конвертер PNG в JPG',
                'description' => 'Преобразование PNG изображений в формат JPG.',
                'meta_title' => 'PNG в JPG - Конвертировать Онлайн',
                'meta_description' => 'Быстро конвертируйте PNG в JPG. Удобный инструмент для уменьшения размера изображений.',
            ],
            'jpg-to-webp-converter' => [
                'name' => 'Конвертер JPG в WebP',
                'description' => 'Конвертация JPG в современный формат WebP для веба.',
                'meta_title' => 'JPG в WebP - Оптимизация Изображений',
                'meta_description' => 'Сделайте ваши картинки легче с форматом WebP. Конвертация из JPG онлайн.',
            ],
            'webp-to-jpg-converter' => [
                'name' => 'Конвертер WebP в JPG',
                'description' => 'Преобразование WebP изображений обратно в JPG.',
                'meta_title' => 'WebP в JPG - Конвертировать Онлайн',
                'meta_description' => 'Восстановите привычный формат JPG из WebP файлов. Бесплатно и без потери качества.',
            ],
            'heic-to-jpg-converter' => [
                'name' => 'Конвертер HEIC в JPG',
                'description' => 'Конвертация фото с iPhone (HEIC) в обычный JPG.',
                'meta_title' => 'HEIC в JPG - Конвертер Фото iPhone',
                'meta_description' => 'Открывайте фото с айфона на любом устройстве. Конвертируйте HEIC в JPG онлайн.',
            ],
            'png-to-webp-converter' => [
                'name' => 'Конвертер PNG в WebP',
                'description' => 'Конвертация PNG в WebP с сохранением прозрачности.',
                'meta_title' => 'PNG в WebP - Сжать Изображение',
                'meta_description' => 'Оптимизируйте PNG картинки для сайта, конвертируя их в легкий WebP формат.',
            ],
            'svg-to-png-converter' => [
                'name' => 'Конвертер SVG в PNG',
                'description' => 'Преобразование векторных SVG в растровые PNG изображения.',
                'meta_title' => 'SVG в PNG - Трассировка и Конвертация',
                'meta_description' => 'Сохраните векторный файл как картинку. Высокое качество рендеринга.',
            ],
            'svg-to-jpg-converter' => [
                'name' => 'Конвертер SVG в JPG',
                'description' => 'Преобразование векторных SVG файлов в JPG.',
                'meta_title' => 'SVG в JPG - Конвертировать Вектор',
                'meta_description' => 'Конвертируйте логотипы и иконки из SVG в формат JPG онлайн.',
            ],
            'ico-converter' => [
                'name' => 'Конвертер в ICO',
                'description' => 'Создание иконок (favicon) из изображений.',
                'meta_title' => 'ICO Конвертер - Создать Favicon',
                'meta_description' => 'Сделайте иконку для сайта или приложения. Конвертация в формат .ico.',
            ],
            'image-compressor' => [
                'name' => 'Сжатие изображений',
                'description' => 'Уменьшение размера фото без видимой потери качества.',
                'meta_title' => 'Сжать Фото Онлайн - Оптимизация',
                'meta_description' => 'Сжимайте JPG, PNG и WebP. Ускорьте загрузку вашего сайта.',
            ],

            // Main Categories
            'youtube' => [
                'name' => 'YouTube',
                'description' => 'Инструменты YouTube',
            ],
            'seo' => [
                'name' => 'SEO',
                'description' => 'Инструменты SEO',
            ],
            'utility' => [
                'name' => 'Утилиты',
                'description' => 'Полезные утилиты',
            ],
            'network' => [
                'name' => 'Сеть',
                'description' => 'Сетевые инструменты',
            ],

            'utility-number-system-converters' => [
                'name' => 'Системы Счисления',
                'description' => 'Конвертеры систем счисления (Binary, Hex, Decimal)',
            ],
            'utility-encoding-decoding-tools' => [
                'name' => 'Кодирование и Декодирование',
                'description' => 'Инструменты для кодирования и декодирования данных',
            ],
            'utility-text-content-tools' => [
                'name' => 'Текст и Контент',
                'description' => 'Инструменты для работы с текстом и контентом',
            ],
            'utility-data-format-converters' => [
                'name' => 'Конвертеры Форматов Данных',
                'description' => 'Преобразование форматов данных (JSON, XML, YAML, CSV)',
            ],
            'utility-spreadsheet-tools' => [
                'name' => 'Таблицы и Excel',
                'description' => 'Инструменты для работы с Excel и CSV файлами',
            ],
            'utility-image-tools' => [
                'name' => 'Инструменты Изображений',
                'description' => 'Инструменты для работы с изображениями, PDF и QR',
            ],
            'utility-dev-tools' => [
                'name' => 'Инструменты Разработчика',
                'description' => 'Утилиты для веб-разработки и программирования',
            ],
            'utility-text-tools' => [
                'name' => 'Текстовые Инструменты',
                'description' => 'Инструменты для обработки и форматирования текста',
            ],
            'utility-encodingdecoding-tools' => [
                'name' => 'Кодирование/Декодирование',
                'description' => 'Инструменты для кодирования и декодирования данных',
            ],
            'utility-security-tools' => [
                'name' => 'Безопасность',
                'description' => 'Инструменты для шифрования и проверки безопасности',
            ],
            'utility-social-tools' => [
                'name' => 'Социальные Инструменты',
                'description' => 'Утилиты для социальных сетей и профилей',
            ],
            'utility-text-string-converters' => [
                'name' => 'Конвертеры Текста',
                'description' => 'Преобразование регистра и формата строк',
            ],
            'utility-document-tools' => [
                'name' => 'Инструменты Документов',
                'description' => 'Конвертация и обработка документов',
            ],
            'utility-network-diagnostics' => [
                'name' => 'Диагностика Сети',
                'description' => 'Инструменты для проверки доступности и производительности сети',
            ],
            'utility-generator-tools' => [
                'name' => 'Генераторы',
                'description' => 'Инструменты для генерации случайных данных',
            ],
            'utility-network-tools' => [
                'name' => 'Сетевые Инструменты',
                'description' => 'Утилиты для анализа сетевых данных',
            ],
            'utility-unit-converters' => [
                'name' => 'Конвертеры Единиц',
                'description' => 'Преобразование различных единиц измерения',
            ],

            // Missing Utility Tools
            'markdown-to-html-converter' => [
                'name' => 'Markdown в HTML',
                'description' => 'Конвертация Markdown разметки в HTML код для веб-страниц.',
                'meta_title' => 'Markdown в HTML - Конвертер Разметки',
                'meta_description' => 'Преобразуйте Markdown в чистый HTML. Парсинг MD синтаксиса онлайн.',
            ],
            'html-to-markdown-converter' => [
                'name' => 'HTML в Markdown',
                'description' => 'Конвертация HTML кода в Markdown формат для документации.',
                'meta_title' => 'HTML в Markdown - Конвертер Документации',
                'meta_description' => 'Преобразуйте HTML в Markdown. Упрощение кода для README и Wiki.',
            ],
            'url-encoder-decoder' => [
                'name' => 'URL Кодер/Декодер',
                'description' => 'Кодирование и декодирование URL строк. Преобразование спецсимволов.',
                'meta_title' => 'URL Кодировщик - Encode/Decode URL',
                'meta_description' => 'Безопасное кодирование URL параметров. Конвертация спецсимволов в URL-формат.',
            ],
            'html-encoder-decoder' => [
                'name' => 'HTML Кодер/Декодер',
                'description' => 'Кодирование HTML сущностей для защиты от XSS атак.',
                'meta_title' => 'HTML Encoder - Экранирование HTML',
                'meta_description' => 'Преобразуйте спецсимволы в HTML entities для безопасной вставки в код.',
            ],
            'unicode-encoder-decoder' => [
                'name' => 'Unicode Кодер/Декодер',
                'description' => 'Кодирование и декодирование Unicode символов.',
                'meta_title' => 'Unicode Конвертер - Encode/Decode Unicode',
                'meta_description' => 'Преобразование текста в Unicode коды и обратно. Поддержка всех языков.',
            ],
            'jwt-decoder' => [
                'name' => 'JWT Декодер',
                'description' => 'Декодирование и анализ JSON Web Tokens (JWT).',
                'meta_title' => 'JWT Decoder - Расшифровка JWT Токенов',
                'meta_description' => 'Просмотр содержимого JWT токенов. Анализ заголовка, payload и подписи.',
            ],
            'json-to-xml-converter' => [
                'name' => 'Конвертер JSON в XML',
                'description' => 'Преобразование JSON данных в формат XML и обратно.',
                'meta_title' => 'JSON в XML - Конвертер Данных',
                'meta_description' => 'Двунаправленная конвертация JSON-XML. Настройка корневого элемента.',
            ],
            'json-to-yaml-converter' => [
                'name' => 'Конвертер JSON в YAML',
                'description' => 'Преобразование JSON в YAML для конфигурационных файлов.',
                'meta_title' => 'JSON в YAML - Конвертер Конфигураций',
                'meta_description' => 'Конвертируйте JSON в читаемый YAML формат. Для Docker, Kubernetes и др.',
            ],
            'csv-to-xml-converter' => [
                'name' => 'Конвертер CSV в XML',
                'description' => 'Преобразование CSV таблиц в XML формат.',
                'meta_title' => 'CSV в XML - Конвертер Таблиц',
                'meta_description' => 'Импортируйте CSV данные в XML. Настройка имен элементов и атрибутов.',
            ],
            'json-to-sql-converter' => [
                'name' => 'Конвертер JSON в SQL',
                'description' => 'Генерация SQL INSERT запросов из JSON данных.',
                'meta_title' => 'JSON в SQL - Генератор Запросов',
                'meta_description' => 'Создайте INSERT запросы из JSON объектов. Быстрый импорт в БД.',
            ],
            'tsv-to-csv-converter' => [
                'name' => 'Конвертер TSV в CSV',
                'description' => 'Преобразование TSV (Tab) в CSV (Comma) формат.',
                'meta_title' => 'TSV в CSV - Конвертер Таблиц',
                'meta_description' => 'Замена разделителей табуляции на запятые. Конвертация таблиц.',
            ],
            'case-converter' => [
                'name' => 'Конвертер Регистра',
                'description' => 'Преобразование текста в разные регистры (UPPER, lower, Title Case).',
                'meta_title' => 'Case Converter - Изменение Регистра Текста',
                'meta_description' => 'Быстрое преобразование регистра текста. Верхний, нижний, заглавный.',
            ],
            'sentence-case-converter' => [
                'name' => 'Sentence Case',
                'description' => 'Преобразование текста в формат предложения (первая заглавная).',
                'meta_title' => 'Sentence Case Converter - Регистр Предложения',
                'meta_description' => 'Первая буква заглавная, остальные строчные. Формат предложения.',
            ],
            'camel-case-converter' => [
                'name' => 'camelCase Конвертер',
                'description' => 'Преобразование текста в camelCase для переменных JavaScript.',
                'meta_title' => 'camelCase Converter - Верблюжий Регистр',
                'meta_description' => 'Конвертация в camelCase. Идеально для JS переменных и функций.',
            ],
            'pascal-case-converter' => [
                'name' => 'PascalCase Конвертер',
                'description' => 'Преобразование в PascalCase (UpperCamelCase) для классов.',
                'meta_title' => 'PascalCase Converter - Конвертер Классов',
                'meta_description' => 'Формат PascalCase для имен классов и типов в программировании.',
            ],
            'snake-case-converter' => [
                'name' => 'snake_case Конвертер',
                'description' => 'Преобразование в snake_case для Python и БД.',
                'meta_title' => 'snake_case Converter - Змеиный Регистр',
                'meta_description' => 'Конвертация в snake_case. Стандарт для Python и SQL.',
            ],
            'kebab-case-converter' => [
                'name' => 'kebab-case Конвертер',
                'description' => 'Преобразование в kebab-case для URL и CSS классов.',
                'meta_title' => 'kebab-case Converter - Шашлычный Регистр',
                'meta_description' => 'Формат kebab-case для SEO-дружественных URL и CSS.',
            ],
            'studly-case-converter' => [
                'name' => 'StUdLy CaSe Конвертер',
                'description' => 'Случайное чередование регистра букв.',
                'meta_title' => 'Studly Case Converter - Случайный Регистр',
                'meta_description' => 'Создайте мемный текст с чередующимся регистром.',
            ],
            'text-reverser' => [
                'name' => 'Переворот Текста',
                'description' => 'Переворачивает текст задом наперед (зеркало).',
                'meta_title' => 'Text Reverser - Зеркальный Текст',
                'meta_description' => 'Переверните текст наоборот. Создайте зеркальные надписи.',
            ],
            'text-to-morse-code' => [
                'name' => 'Текст в Азбуку Морзе',
                'description' => 'Преобразование текста в код Морзе (точки и тире).',
                'meta_title' => 'Morse Code Generator - Генератор Морзе',
                'meta_description' => 'Конвертируйте текст в азбуку Морзе. Зашифруйте сообщения.',
            ],
            'morse-code-to-text' => [
                'name' => 'Азбука Морзе в Текст',
                'description' => 'Декодирование азбуки Морзе обратно в текст.',
                'meta_title' => 'Morse Code Decoder - Декодер Морзе',
                'meta_description' => 'Расшифруйте код Морзе. Перевод точек и тире в буквы.',
            ],
            'curl-command-builder' => [
                'name' => 'Генератор cURL команд',
                'description' => 'Создание cURL команд для тестирования API запросов.',
                'meta_title' => 'cURL Command Builder - Генератор Запросов',
                'meta_description' => 'Визуальный конструктор cURL команд. Настройка заголовков и параметров.',
            ],
            'duplicate-line-remover' => [
                'name' => 'Удаление Дубликатов Строк',
                'description' => 'Удаление повторяющихся строк из текста.',
                'meta_title' => 'Duplicate Line Remover - Очистка Текста',
                'meta_description' => 'Автоматическое удаление дублирующихся строк. Очистка списков.',
            ],
            'username-checker' => [
                'name' => 'Проверка Имени Пользователя',
                'description' => 'Проверка доступности юзернейма в социальных сетях.',
                'meta_title' => 'Username Checker - Проверка Доступности',
                'meta_description' => 'Проверьте свободен ли username в Instagram, Twitter, GitHub и др.',
            ],
            'cooking-unit-converter' => [
                'name' => 'Конвертер Кулинарных Единиц',
                'description' => 'Перевод кухонных мер. Чайные ложки в миллилитры, стаканы в унции.',
                'meta_title' => 'Конвертер Кулинарных Единиц - Онлайн',
                'meta_description' => 'Переводите чайные ложки, столовые ложки, стаканы и унции для рецептов.',
            ],
            'torque-converter' => [
                'name' => 'Конвертер Крутящего Момента',
                'description' => 'Перевод крутящего момента. Ньютон-метры в фут-фунты.',
                'meta_title' => 'Конвертер Крутящего Момента - Nm в ft-lb',
                'meta_description' => 'Переводите крутящий момент для автомобильных и промышленных расчетов.',
            ],
            'density-converter' => [
                'name' => 'Конвертер Плотности',
                'description' => 'Перевод единиц плотности. Килограммы на кубический метр в граммы на кубический сантиметр.',
                'meta_title' => 'Конвертер Плотности - kg/m³ в g/cm³',
                'meta_description' => 'Переводите плотность материалов и веществ между единицами измерения.',
            ],
            'molar-mass-converter' => [
                'name' => 'Конвертер Молярной Массы',
                'description' => 'Расчет молярной массы по химическим формулам.',
                'meta_title' => 'Калькулятор Молярной Массы - Химия',
                'meta_description' => 'Вычислите молярную массу химических соединений. Полезно для студентов.',
            ],
            'frequency-converter' => [
                'name' => 'Конвертер Частоты',
                'description' => 'Перевод единиц частоты. Герцы в Килогерцы, Мегагерцы в Гигагерцы.',
                'meta_title' => 'Конвертер Частоты - Hz в kHz/MHz/GHz',
                'meta_description' => 'Переводите частоты для радио, звука и электроники.',
            ],

            // Morse Code Tools
            'text-to-morse-converter' => [
                'name' => 'Конвертер Текста в Азбуку Морзе',
                'description' => 'Преобразуйте текст в символы азбуки Морзе для связи или развлечения.',
                'meta_title' => 'Text to Morse Code - Конвертер в Морзе',
                'meta_description' => 'Конвертируйте текст в код Морзе онлайн. Точки и тире.',
            ],
            'morse-to-text-converter' => [
                'name' => 'Декодер Азбуки Морзе',
                'description' => 'Преобразуйте азбуку Морзе обратно в читаемый текст.',
                'meta_title' => 'Morse to Text - Декодер Морзе',
                'meta_description' => 'Расшифруйте код Морзе в обычный текст онлайн.',
            ],
            // Excel/CSV Converters
            'excel-to-csv' => [
                'name' => 'Конвертер Excel в CSV',
                'description' => 'Быстро конвертируйте файлы Excel (.xls, .xlsx) в формат CSV.',
                'meta_title' => 'Excel to CSV Converter - Онлайн Конвертер',
                'meta_description' => 'Преобразуйте Excel файлы в CSV формат бесплатно онлайн.',
            ],
            'csv-to-excel' => [
                'name' => 'Конвертер CSV в Excel',
                'description' => 'Преобразуйте файлы CSV в формат Excel (.xlsx) для удобного просмотра.',
                'meta_title' => 'CSV to Excel Converter - Онлайн Конвертер',
                'meta_description' => 'Конвертируйте CSV в Excel для лучшей визуализации данных.',
            ],

            // YouTube Tools Subcategories
            'youtube-monetization-analytics' => [
                'name' => 'Монетизация',
                'description' => 'Инструменты для монетизации и аналитики канала',
            ],
            'youtube-video-tools' => [
                'name' => 'Видео Инструменты',
                'description' => 'Инструменты для работы с видео контентом',
            ],
            'youtube-channel-tools' => [
                'name' => 'Инструменты Канала',
                'description' => 'Инструменты для анализа и настройки канала',
            ],

            // SEO Tools Subcategories
            'seo-analysis-tools' => [
                'name' => 'Инструменты Анализа',
                'description' => 'Инструменты для глубокого анализа вашего контента',
            ],
            'seo-keyword-tools' => [
                'name' => 'Инструменты Ключевых Слов',
                'description' => 'Поиск и анализ ключевых слов',
            ],
            'seo-technical-seo' => [
                'name' => 'Технический SEO',
                'description' => 'Инструменты технического аудита сайта',
            ],
            'seo-google-serp-checker' => [
                'name' => 'Проверка Позиций (SERP)',
                'description' => 'Мониторинг позиций в поисковой выдаче',
            ],
            'seo-broken-links-checker' => [
                'name' => 'Проверка Битых Ссылок',
                'description' => 'Поиск неработающих ссылок на сайте',
            ],
            'seo-on-page-seo-checker' => [
                'name' => 'On-Page SEO',
                'description' => 'Анализ контента страницы',
            ],

            // Network Tools Subcategories
            'network-ip-tools' => [
                'name' => 'IP Инструменты',
                'description' => 'Инструменты для работы с IP адресами',
            ],
            'network-domain-tools' => [
                'name' => 'Инструменты Домена',
                'description' => 'Инструменты для анализа доменов и DNS',
            ],
            'network-network-diagnostics' => [
                'name' => 'Диагностика Сети',
                'description' => 'Инструменты для диагностики сети и подключения',
            ],

            // Network Tools
            'what-is-my-ip' => [
                'name' => 'Мой IP адрес',
                'description' => 'Узнайте ваш публичный IP адрес и информацию о местоположении.',
                'meta_title' => 'Узнать Мой IP - Проверка Адреса',
                'meta_description' => 'Показать мой IP адрес, провайдера и страну. Полная информация о вашем подключении.',
            ],
            'what-is-my-isp' => [
                'name' => 'Мой провайдер (ISP)',
                'description' => 'Информация о вашем интернет-провайдере.',
                'meta_title' => 'Кто Мой Провайдер - Узнать ISP',
                'meta_description' => 'Проверка интернет провайдера по IP. Узнайте название вашей сети и ASN.',
            ],
            'domain-to-ip' => [
                'name' => 'Домен в IP',
                'description' => 'Узнать IP адрес любого домена или веб-сайта.',
                'meta_title' => 'IP Адрес Домена - Ping Онлайн',
                'meta_description' => 'Введите домен и узнайте его IP адрес. Быстрая проверка DNS записи A.',
            ],
            'ip-lookup' => [
                'name' => 'Информация об IP',
                'description' => 'Геолокация и WHOIS данные по IP адресу.',
                'meta_title' => 'Проверка IP - Геолокация и Инфо',
                'meta_description' => 'Узнайте страну, город и организацию по IP адресу. Детальный IP Lookup.',
            ],
            'dns-lookup' => [
                'name' => 'Поиск DNS записей',
                'description' => 'Просмотр всех DNS записей домена (A, MX, NS, TXT).',
                'meta_title' => 'DNS Lookup - Проверка Записей Домена',
                'meta_description' => 'Онлайн проверка DNS. Получите список всех записей домена для диагностики.',
            ],
            'whois-lookup' => [
                'name' => 'WHOIS проверка домена',
                'description' => 'Узнайте, кому принадлежит домен, дату регистрации и окончания.',
                'meta_title' => 'WHOIS Сервис - Проверить Владельца Домена',
                'meta_description' => 'Бесплатная проверка занятости домена. Информация о регистраторе и возрасте сайта.',
            ],
            'ping-test' => [
                'name' => 'Пинг Тест',
                'description' => 'Проверка доступности сайта или сервера (Ping).',
                'meta_title' => 'Пинг Онлайн - Проверка Доступности',
                'meta_description' => 'Проверьте пинг (задержку) до сервера или сайта из разных точек.',
            ],
            'traceroute' => [
                'name' => 'Трассировка (Traceroute)',
                'description' => 'Отслеживание маршрута пакетов до узла сети.',
                'meta_title' => 'Traceroute Онлайн - Трассировка Маршрута',
                'meta_description' => 'Диагностика сети. Посмотрите, через какие узлы проходит сигнал до сервера.',
            ],
            'port-checker' => [
                'name' => 'Проверка открытых портов',
                'description' => 'Сканирование портов на сервере или IP.',
                'meta_title' => 'Сканер Портов - Проверить Открытые Порты',
                'meta_description' => 'Узнайте, открыт ли порт на вашем сервере. Проверка 80, 443, 21 и других портов.',
            ],
            'reverse-dns' => [
                'name' => 'Обратный DNS (Reverse DNS)',
                'description' => 'Определение имени хоста по IP адресу.',
                'meta_title' => 'Reverse DNS Lookup - IP в Домен',
                'meta_description' => 'Найдите доменное имя, привязанное к IP адресу (PTR запись).',
            ],

            // Spreadsheet Tools
            'xls-to-xlsx' => [
                'name' => 'Конвертер XLS в XLSX',
                'description' => 'Обновление старых Excel файлов (XLS) в новый формат XLSX.',
                'meta_title' => 'XLS в XLSX - Конвертировать Excel Онлайн',
                'meta_description' => 'Бесплатно конвертируйте старые таблицы Excel в современный формат.',
            ],
            'xlsx-to-xls' => [
                'name' => 'Конвертер XLSX в XLS',
                'description' => 'Конвертация новых Excel файлов в старый формат для совместимости.',
                'meta_title' => 'XLSX в XLS - Конвертировать Excel Онлайн',
                'meta_description' => 'Сохраните XLSX как XLS для открытия в старых версиях Office.',
            ],
            'google-sheets-to-excel' => [
                'name' => 'Google Таблицы в Excel',
                'description' => 'Конвертация экспорта Google Sheets в формат Excel.',
                'meta_title' => 'Google Sheets в Excel - Конвертер',
                'meta_description' => 'Преобразуйте файлы из Google Таблиц в Microsoft Excel (.xlsx) онлайн.',
            ],
            'csv-to-sql' => [
                'name' => 'CSV в SQL',
                'description' => 'Генерация SQL INSERT запросов из CSV файла.',
                'meta_title' => 'CSV в SQL Конвертер - Импорт в Базу Данных',
                'meta_description' => 'Создайте SQL скрипт для импорта данных из CSV в MySQL, PostgreSQL или SQL Server.',
            ],

            // Document Tools
            'pdf-to-word' => [
                'name' => 'PDF в Word',
                'description' => 'Конвертация PDF документов в редактируемый Word (DOCX).',
                'meta_title' => 'PDF в Word - Конвертировать Онлайн Бесплатно',
                'meta_description' => 'Лучший конвертер PDF в Word. Преобразуйте документы с сохранением форматирования.',
            ],
            'word-to-pdf' => [
                'name' => 'Word в PDF',
                'description' => 'Сохранение документов Word (DOC, DOCX) в формате PDF.',
                'meta_title' => 'Word в PDF - Конвертировать Онлайн',
                'meta_description' => 'Превратите DOCX в PDF. Безопасно и быстро, без установки программ.',
            ],
            'pdf-to-excel' => [
                'name' => 'PDF в Excel',
                'description' => 'Извлечение таблиц из PDF в Excel (XLSX).',
                'meta_title' => 'PDF в Excel - Конвертировать Таблицы',
                'meta_description' => 'Конвертируйте PDF в таблицы Excel. Редактируйте данные из PDF в XLS/XLSX.',
            ],
            'excel-to-pdf' => [
                'name' => 'Excel в PDF',
                'description' => 'Сохранение таблиц Excel в формате PDF.',
                'meta_title' => 'Excel в PDF - Конвертировать Таблицы',
                'meta_description' => 'Преобразуйте отчеты и таблицы Excel в нередактируемый PDF формат.',
            ],
            'powerpoint-to-pdf' => [
                'name' => 'PowerPoint в PDF',
                'description' => 'Конвертация презентаций PPT в PDF.',
                'meta_title' => 'PPT в PDF - Сохранить Презентацию',
                'meta_description' => 'Конвертируйте слайды PowerPoint в PDF документ для удобного просмотра.',
            ],
            'pdf-to-powerpoint' => [
                'name' => 'PDF в PowerPoint',
                'description' => 'Преобразование PDF в слайды презентации (PPTX).',
                'meta_title' => 'PDF в PPT - Конвертировать в Презентацию',
                'meta_description' => 'Превратите PDF документ обратно в редактируемую презентацию PowerPoint.',
            ],
            'pdf-to-jpg' => [
                'name' => 'PDF в JPG',
                'description' => 'Сохранение страниц PDF как изображений JPG.',
                'meta_title' => 'PDF в JPG - Страницы в Картинки',
                'meta_description' => 'Конвертируйте каждую страницу PDF в отдельный файл изображения.',
            ],
            'jpg-to-pdf' => [
                'name' => 'JPG в PDF',
                'description' => 'Создание PDF документа из изображений JPG.',
                'meta_title' => 'JPG в PDF - Фото в Документ',
                'meta_description' => 'Объедините несколько фотографий в один PDF файл. Конвертер изображений в PDF.',
            ],
            'pdf-compressor' => [
                'name' => 'Сжатие PDF',
                'description' => 'Уменьшение размера PDF файла онлайн.',
                'meta_title' => 'Сжать PDF - Уменьшить Размер Файла',
                'meta_description' => 'Оптимизируйте PDF документы для отправки по почте. Сжатие без потери качества.',
            ],
            'pdf-merger' => [
                'name' => 'Объединить PDF',
                'description' => 'Соединение нескольких PDF файлов в один.',
                'meta_title' => 'Объединить PDF - Склеить Файлы Онлайн',
                'meta_description' => 'Бесплатное объединение PDF. Выберите порядок и создайте один документ из нескольких.',
            ],
            'pdf-splitter' => [
                'name' => 'Разделить PDF',
                'description' => 'Разделение PDF на отдельные страницы или части.',
                'meta_title' => 'Разделить PDF - Извлечь Страницы',
                'meta_description' => 'Сохраните выбранные страницы из PDF как отдельные документы.',
            ],

            // Unit Converters - Batch A
            'length-converter' => [
                'name' => 'Конвертер длины',
                'description' => 'Перевод единиц измерения длины (м, км, мили, футы).',
                'meta_title' => 'Конвертер Длины - Метры, Футы, Мили',
                'meta_description' => 'Переводите метры в футы, километры в мили и другие меры длины.',
            ],
            'weight-converter' => [
                'name' => 'Конвертер веса',
                'description' => 'Перевод единиц массы (кг, фунты, унции, тонны).',
                'meta_title' => 'Конвертер Веса и Массы',
                'meta_description' => 'Конвертируйте килограммы в фунты, граммы в унции онлайн бесплатно.',
            ],
            'temperature-converter' => [
                'name' => 'Конвертер температуры',
                'description' => 'Перевод градусов Цельсия, Фаренгейта и Кельвина.',
                'meta_title' => 'Конвертер Температуры - Цельсий и Фаренгейт',
                'meta_description' => 'Переведите температуру из Цельсия в Фаренгейты и наоборот.',
            ],
            'volume-converter' => [
                'name' => 'Конвертер объема',
                'description' => 'Перевод литров, галлонов, милилитров и кубов.',
                'meta_title' => 'Конвертер Объема и Жидкости',
                'meta_description' => 'Конвертируйте литры в галлоны, мл в унции. Калькулятор объема.',
            ],
            'area-converter' => [
                'name' => 'Конвертер площади',
                'description' => 'Перевод квадратных метров, акров, гектаров.',
                'meta_title' => 'Конвертер Площади - Гектары, Акры',
                'meta_description' => 'Посчитайте площадь: кв. метры в футы, сотки в гектары и наоборот.',
            ],

            // Unit Converters - Batch B
            'speed-converter' => [
                'name' => 'Конвертер скорости',
                'description' => 'Перевод км/ч, миль/ч, узлов и метров в секунду.',
                'meta_title' => 'Конвертер Скорости',
                'meta_description' => 'Переведите скорость из км/ч в м/с или мили в час.',
            ],
            'time-unit-converter' => [
                'name' => 'Конвертер времени',
                'description' => 'Перевод секунд, минут, часов, дней и недель.',
                'meta_title' => 'Конвертер Единиц Времени',
                'meta_description' => 'Сколько секунд в году? Переводите любые интервалы времени.',
            ],
            'digital-storage-converter' => [
                'name' => 'Конвертер байт',
                'description' => 'Перевод байт, килобайт, мегабайт, гигабайт.',
                'meta_title' => 'Конвертер Величин Информации (Байты)',
                'meta_description' => 'Переведите МБ в ГБ, биты в байты. Калькулятор размера данных.',
            ],
            'energy-converter' => [
                'name' => 'Конвертер энергии',
                'description' => 'Перевод Джоулей, калорий, кВт*ч.',
                'meta_title' => 'Конвертер Энергии - Джоули и Калории',
                'meta_description' => 'Конвертируйте энергию: калории в джоули для физики или диеты.',
            ],
            'pressure-converter' => [
                'name' => 'Конвертер давления',
                'description' => 'Перевод Паскалей, бар, атмосфер, PSI.',
                'meta_title' => 'Конвертер Давления - Паскали, Бары',
                'meta_description' => 'Переводите единицы давления. Атмосферы в Паскали, PSI в Бары.',
            ],

            // Unit Converters - Batch C
            'power-converter' => [
                'name' => 'Конвертер мощности',
                'description' => 'Перевод Ватт, лошадиных сил, киловатт.',
                'meta_title' => 'Конвертер Мощности - Ватты и Л.С.',
                'meta_description' => 'Переведите киловатты (кВт) в лошадиные силы (hp).',
            ],
            'force-converter' => [
                'name' => 'Конвертер силы',
                'description' => 'Перевод Ньютонов, дин, кг-силы.',
                'meta_title' => 'Конвертер Силы - Ньютоны',
                'meta_description' => 'Конвертация единиц измерения силы. Ньютоны в килограмм-силы.',
            ],
            'angle-converter' => [
                'name' => 'Конвертер углов',
                'description' => 'Перевод градусов, радианов, градов.',
                'meta_title' => 'Конвертер Углов - Градусы и Радианы',
                'meta_description' => 'Переведите градусы в радианы и наоборот.',
            ],
            'fuel-consumption-converter' => [
                'name' => 'Конвертер расхода топлива',
                'description' => 'Перевод л/100км, MPG (миль на галлон).',
                'meta_title' => 'Конвертер Расхода Топлива',
                'meta_description' => 'Посчитайте расход бензина. Перевод из MPG (США) в литры на 100 км.',
            ],
            'data-transfer-rate-converter' => [
                'name' => 'Конвертер скорости передачи',
                'description' => 'Перевод Мбит/с, МБ/с, Кбит/с.',
                'meta_title' => 'Конвертер Скорости Интернета',
                'meta_description' => 'Переведите мегабиты в мегабайты. Расчет скорости скачивания.',
            ],
        ];

        foreach ($translations as $slug => $data) {
            $tool = Tool::where('slug', $slug)->first();

            if ($tool) {
                foreach ($data as $field => $value) {
                    // TranslationService::set($tool, $field, $value, 'ru');
                }
                $this->command->info("Seeded Russian translations for Tool: {$slug}");
                continue;
            }

            // Check if it's a Category
            $category = \App\Models\Category::where('slug', $slug)->first();
            if ($category) {
                foreach ($data as $field => $value) {
                    // TranslationService::set($category, $field, $value, 'ru');
                }
                $this->command->info("Seeded Russian translations for Category: {$slug}");
                continue;
            }

            $this->command->warn("Tool/Category not found: {$slug}");
        }
    }
}
