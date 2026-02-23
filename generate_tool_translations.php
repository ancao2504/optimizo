<?php
/**
 * Tool Translation Generator
 * Generates translation JSON files for 16 new dev tools across 23 languages.
 * Run: php generate_tool_translations.php
 */

$langBase = __DIR__ . '/resources/lang';
$enBase = "$langBase/en/tools/development";

// The 16 tools to translate
$tools = [
    'regex-tester',
    'json-validator',
    'sql-formatter',
    'yaml-formatter',
    'chmod-calculator',
    'api-request-builder',
    'color-palette-generator',
    'svg-optimizer',
    'javascript-obfuscator',
    'css-flexbox-generator',
    'css-grid-generator',
    'css-gradient-generator',
    'html-to-jsx-converter',
    'csv-to-yaml-converter',
    'toml-to-json-converter',
    'json-to-toml-converter',
];

// Translation overrides for meta/editor/common UI strings per language
// Format: lang => [ 'key.path' => 'translation' ]
// For content body we translate only the meta title, description, h1, subtitle
// and common editor labels/buttons. The content body (why, how, faq) defaults
// to English with [Pending Translation] marker so __tool() falls back to English.

$translations = [
    'ar' => [
        'meta.suffix' => 'عبر الإنترنت - مجاناً | Optimizo',
        'editor.btn_copy' => 'نسخ',
        'editor.btn_format' => 'تنسيق',
        'editor.btn_validate' => 'تحقق',
        'editor.btn_obfuscate' => 'تشويش',
        'editor.btn_optimize' => 'تحسين',
        'editor.btn_send' => 'إرسال الطلب',
        'editor.btn_test' => 'اختبار',
        'editor.btn_diff' => 'مقارنة',
        'content.why_title_prefix' => 'لماذا تستخدم',
        'content.how_title_prefix' => 'كيفية الاستخدام',
        'content.uses_title' => 'حالات الاستخدام الشائعة',
        'content.tips_title' => 'أفضل الممارسات والنصائح',
        'content.faq_title' => '❓ الأسئلة الشائعة',
    ],
    'bn' => [
        'editor.btn_copy' => 'কপি করুন',
        'editor.btn_format' => 'ফরম্যাট করুন',
        'editor.btn_validate' => 'যাচাই করুন',
        'editor.btn_obfuscate' => 'অস্পষ্ট করুন',
        'editor.btn_optimize' => 'অপটিমাইজ করুন',
        'editor.btn_send' => 'অনুরোধ পাঠান',
        'content.faq_title' => '❓ সচরাচর জিজ্ঞাসিত প্রশ্নাবলী',
    ],
    'cs' => [
        'editor.btn_copy' => 'Kopírovat',
        'editor.btn_format' => 'Formátovat',
        'editor.btn_validate' => 'Ověřit',
        'editor.btn_obfuscate' => 'Obfuskovat',
        'editor.btn_optimize' => 'Optimalizovat',
        'editor.btn_send' => 'Odeslat požadavek',
        'content.faq_title' => '❓ Nejčastěji kladené otázky',
    ],
    'da' => [
        'editor.btn_copy' => 'Kopiér',
        'editor.btn_format' => 'Formater',
        'editor.btn_validate' => 'Validér',
        'editor.btn_obfuscate' => 'Obfuskér',
        'editor.btn_optimize' => 'Optimer',
        'editor.btn_send' => 'Send forespørgsel',
        'content.faq_title' => '❓ Ofte stillede spørgsmål',
    ],
    'de' => [
        'editor.btn_copy' => 'Kopieren',
        'editor.btn_format' => 'Formatieren',
        'editor.btn_validate' => 'Validieren',
        'editor.btn_obfuscate' => 'Verschleiern',
        'editor.btn_optimize' => 'Optimieren',
        'editor.btn_send' => 'Anfrage senden',
        'content.faq_title' => '❓ Häufig gestellte Fragen',
    ],
    'el' => [
        'editor.btn_copy' => 'Αντιγραφή',
        'editor.btn_format' => 'Μορφοποίηση',
        'editor.btn_validate' => 'Επικύρωση',
        'editor.btn_obfuscate' => 'Συσκότιση',
        'editor.btn_optimize' => 'Βελτιστοποίηση',
        'editor.btn_send' => 'Αποστολή αιτήματος',
        'content.faq_title' => '❓ Συχνές ερωτήσεις',
    ],
    'es' => [
        'editor.btn_copy' => 'Copiar',
        'editor.btn_format' => 'Formatear',
        'editor.btn_validate' => 'Validar',
        'editor.btn_obfuscate' => 'Ofuscar',
        'editor.btn_optimize' => 'Optimizar',
        'editor.btn_send' => 'Enviar solicitud',
        'content.faq_title' => '❓ Preguntas frecuentes',
    ],
    'fi' => [
        'editor.btn_copy' => 'Kopioi',
        'editor.btn_format' => 'Muotoile',
        'editor.btn_validate' => 'Validoi',
        'editor.btn_obfuscate' => 'Obfuskoi',
        'editor.btn_optimize' => 'Optimoi',
        'editor.btn_send' => 'Lähetä pyyntö',
        'content.faq_title' => '❓ Usein kysytyt kysymykset',
    ],
    'fr' => [
        'editor.btn_copy' => 'Copier',
        'editor.btn_format' => 'Formater',
        'editor.btn_validate' => 'Valider',
        'editor.btn_obfuscate' => 'Obscurcir',
        'editor.btn_optimize' => 'Optimiser',
        'editor.btn_send' => 'Envoyer la requête',
        'content.faq_title' => '❓ Foire aux questions',
    ],
    'hi' => [
        'editor.btn_copy' => 'कॉपी करें',
        'editor.btn_format' => 'फॉर्मेट करें',
        'editor.btn_validate' => 'सत्यापित करें',
        'editor.btn_obfuscate' => 'अस्पष्ट करें',
        'editor.btn_optimize' => 'अनुकूलित करें',
        'editor.btn_send' => 'अनुरोध भेजें',
        'content.faq_title' => '❓ अक्सर पूछे जाने वाले प्रश्न',
    ],
    'id' => [
        'editor.btn_copy' => 'Salin',
        'editor.btn_format' => 'Format',
        'editor.btn_validate' => 'Validasi',
        'editor.btn_obfuscate' => 'Obfuskasi',
        'editor.btn_optimize' => 'Optimalkan',
        'editor.btn_send' => 'Kirim Permintaan',
        'content.faq_title' => '❓ Pertanyaan yang Sering Diajukan',
    ],
    'it' => [
        'editor.btn_copy' => 'Copia',
        'editor.btn_format' => 'Formatta',
        'editor.btn_validate' => 'Valida',
        'editor.btn_obfuscate' => 'Offusca',
        'editor.btn_optimize' => 'Ottimizza',
        'editor.btn_send' => 'Invia richiesta',
        'content.faq_title' => '❓ Domande frequenti',
    ],
    'ja' => [
        'editor.btn_copy' => 'コピー',
        'editor.btn_format' => 'フォーマット',
        'editor.btn_validate' => '検証',
        'editor.btn_obfuscate' => '難読化',
        'editor.btn_optimize' => '最適化',
        'editor.btn_send' => 'リクエスト送信',
        'content.faq_title' => '❓ よくある質問',
    ],
    'ko' => [
        'editor.btn_copy' => '복사',
        'editor.btn_format' => '포맷',
        'editor.btn_validate' => '검증',
        'editor.btn_obfuscate' => '난독화',
        'editor.btn_optimize' => '최적화',
        'editor.btn_send' => '요청 보내기',
        'content.faq_title' => '❓ 자주 묻는 질문',
    ],
    'nl' => [
        'editor.btn_copy' => 'Kopiëren',
        'editor.btn_format' => 'Formatteren',
        'editor.btn_validate' => 'Valideren',
        'editor.btn_obfuscate' => 'Obfusceren',
        'editor.btn_optimize' => 'Optimaliseren',
        'editor.btn_send' => 'Verzoek verzenden',
        'content.faq_title' => '❓ Veelgestelde vragen',
    ],
    'no' => [
        'editor.btn_copy' => 'Kopier',
        'editor.btn_format' => 'Formater',
        'editor.btn_validate' => 'Valider',
        'editor.btn_obfuscate' => 'Obfusker',
        'editor.btn_optimize' => 'Optimer',
        'editor.btn_send' => 'Send forespørsel',
        'content.faq_title' => '❓ Ofte stilte spørsmål',
    ],
    'pl' => [
        'editor.btn_copy' => 'Kopiuj',
        'editor.btn_format' => 'Formatuj',
        'editor.btn_validate' => 'Sprawdź',
        'editor.btn_obfuscate' => 'Zaciemnij',
        'editor.btn_optimize' => 'Optymalizuj',
        'editor.btn_send' => 'Wyślij żądanie',
        'content.faq_title' => '❓ Często zadawane pytania',
    ],
    'pt' => [
        'editor.btn_copy' => 'Copiar',
        'editor.btn_format' => 'Formatar',
        'editor.btn_validate' => 'Validar',
        'editor.btn_obfuscate' => 'Ofuscar',
        'editor.btn_optimize' => 'Otimizar',
        'editor.btn_send' => 'Enviar requisição',
        'content.faq_title' => '❓ Perguntas frequentes',
    ],
    'ro' => [
        'editor.btn_copy' => 'Copiază',
        'editor.btn_format' => 'Formatează',
        'editor.btn_validate' => 'Validează',
        'editor.btn_obfuscate' => 'Ofuscă',
        'editor.btn_optimize' => 'Optimizează',
        'editor.btn_send' => 'Trimite cererea',
        'content.faq_title' => '❓ Întrebări frecvente',
    ],
    'ru' => [
        'editor.btn_copy' => 'Копировать',
        'editor.btn_format' => 'Форматировать',
        'editor.btn_validate' => 'Проверить',
        'editor.btn_obfuscate' => 'Обфусцировать',
        'editor.btn_optimize' => 'Оптимизировать',
        'editor.btn_send' => 'Отправить запрос',
        'content.faq_title' => '❓ Часто задаваемые вопросы',
    ],
    'sv' => [
        'editor.btn_copy' => 'Kopiera',
        'editor.btn_format' => 'Formatera',
        'editor.btn_validate' => 'Validera',
        'editor.btn_obfuscate' => 'Obfuskera',
        'editor.btn_optimize' => 'Optimera',
        'editor.btn_send' => 'Skicka förfrågan',
        'content.faq_title' => '❓ Vanliga frågor',
    ],
    'tr' => [
        'editor.btn_copy' => 'Kopyala',
        'editor.btn_format' => 'Biçimlendir',
        'editor.btn_validate' => 'Doğrula',
        'editor.btn_obfuscate' => 'Karıştır',
        'editor.btn_optimize' => 'Optimize Et',
        'editor.btn_send' => 'İstek Gönder',
        'content.faq_title' => '❓ Sık Sorulan Sorular',
    ],
    'vi' => [
        'editor.btn_copy' => 'Sao chép',
        'editor.btn_format' => 'Định dạng',
        'editor.btn_validate' => 'Xác thực',
        'editor.btn_obfuscate' => 'Làm rối',
        'editor.btn_optimize' => 'Tối ưu hóa',
        'editor.btn_send' => 'Gửi yêu cầu',
        'content.faq_title' => '❓ Câu hỏi thường gặp',
    ],
];

// Per-tool meta translations per language
$toolMeta = [
    'regex-tester' => [
        'ar' => ['title' => 'اختبار التعبيرات النمطية مجاناً عبر الإنترنت', 'h1' => 'اختبار Regex', 'subtitle' => 'اختبر التعبيرات النمطية مباشرة مع تمييز التطابقات'],
        'bn' => ['title' => 'অনলাইনে রেজেক্স পরীক্ষক - বিনামূল্যে', 'h1' => 'রেজেক্স পরীক্ষক', 'subtitle' => 'লাইভ ম্যাচ হাইলাইটিং সহ রেজুলার এক্সপ্রেশন পরীক্ষা করুন'],
        'cs' => ['title' => 'Testovač regulárních výrazů online - zdarma', 'h1' => 'Testovač Regex', 'subtitle' => 'Testujte regulární výrazy živě se zvýrazněním shod'],
        'da' => ['title' => 'Regex-tester online - gratis', 'h1' => 'Regex-tester', 'subtitle' => 'Test regulære udtryk live med fremhævning af matches'],
        'de' => ['title' => 'Reguläre Ausdrücke online testen - kostenlos', 'h1' => 'Regex-Tester', 'subtitle' => 'Testen Sie reguläre Ausdrücke live mit Treffer-Hervorhebung'],
        'el' => ['title' => 'Δοκιμαστής Regex online - δωρεάν', 'h1' => 'Δοκιμαστής Regex', 'subtitle' => 'Δοκιμάστε κανονικές εκφράσεις ζωντανά με ανάδειξη αποτελεσμάτων'],
        'es' => ['title' => 'Probador de Regex online - gratis', 'h1' => 'Probador de Regex', 'subtitle' => 'Prueba expresiones regulares en vivo con resaltado de coincidencias'],
        'fi' => ['title' => 'Regex-testausväline verkossa - ilmainen', 'h1' => 'Regex-testausväline', 'subtitle' => 'Testaa säännöllisiä lausekkeita reaaliajassa hakutulosten korostuksella'],
        'fr' => ['title' => 'Testeur de Regex en ligne - gratuit', 'h1' => 'Testeur Regex', 'subtitle' => 'Testez vos expressions régulières en direct avec mise en évidence des correspondances'],
        'hi' => ['title' => 'ऑनलाइन रेगेक्स टेस्टर - मुफ्त', 'h1' => 'रेगेक्स टेस्टर', 'subtitle' => 'लाइव मिलान हाइलाइटिंग के साथ रेगुलर एक्सप्रेशन का परीक्षण करें'],
        'id' => ['title' => 'Penguji Regex online - gratis', 'h1' => 'Penguji Regex', 'subtitle' => 'Uji ekspresi reguler secara langsung dengan sorotan kecocokan'],
        'it' => ['title' => 'Tester Regex online - gratuito', 'h1' => 'Tester Regex', 'subtitle' => 'Testa le espressioni regolari in tempo reale con evidenziazione delle corrispondenze'],
        'ja' => ['title' => 'オンライン正規表現テスター - 無料', 'h1' => '正規表現テスター', 'subtitle' => 'マッチハイライト付きで正規表現をリアルタイムテスト'],
        'ko' => ['title' => '온라인 정규식 테스터 - 무료', 'h1' => '정규식 테스터', 'subtitle' => '실시간 매치 하이라이팅으로 정규식 테스트'],
        'nl' => ['title' => 'Regex-tester online - gratis', 'h1' => 'Regex-tester', 'subtitle' => 'Test reguliere expressies live met markering van overeenkomsten'],
        'no' => ['title' => 'Regex-tester på nett - gratis', 'h1' => 'Regex-tester', 'subtitle' => 'Test regulære uttrykk live med fremheving av treff'],
        'pl' => ['title' => 'Tester wyrażeń regularnych online - darmowy', 'h1' => 'Tester Regex', 'subtitle' => 'Testuj wyrażenia regularne na żywo z podświetlaniem dopasowań'],
        'pt' => ['title' => 'Testador de Regex online - gratuito', 'h1' => 'Testador Regex', 'subtitle' => 'Teste expressões regulares ao vivo com destaque de correspondências'],
        'ro' => ['title' => 'Tester Regex online - gratuit', 'h1' => 'Tester Regex', 'subtitle' => 'Testați expresii regulate live cu evidențierea potrivirilor'],
        'ru' => ['title' => 'Онлайн тестер регулярных выражений - бесплатно', 'h1' => 'Тестер Regex', 'subtitle' => 'Тестируйте регулярные выражения в реальном времени с подсветкой совпадений'],
        'sv' => ['title' => 'Regex-testare online - gratis', 'h1' => 'Regex-testare', 'subtitle' => 'Testa reguljära uttryck live med markering av träffar'],
        'tr' => ['title' => 'Çevrimiçi Regex Test Aracı - ücretsiz', 'h1' => 'Regex Test Aracı', 'subtitle' => 'Eşleşme vurgulaması ile düzenli ifadeleri canlı test edin'],
        'vi' => ['title' => 'Công cụ kiểm tra Regex trực tuyến - miễn phí', 'h1' => 'Kiểm tra Regex', 'subtitle' => 'Kiểm tra biểu thức chính quy trực tiếp với tô sáng kết quả khớp'],
    ],
    'json-validator' => [
        'ar' => ['title' => 'أداة التحقق من JSON مجاناً عبر الإنترنت', 'h1' => 'مدقق JSON', 'subtitle' => 'تحقق من بنية JSON فوراً واكتشف الأخطاء النحوية'],
        'bn' => ['title' => 'অনলাইনে JSON যাচাইকারী - বিনামূল্যে', 'h1' => 'JSON যাচাইকারী', 'subtitle' => 'তাৎক্ষণিকভাবে JSON সিনট্যাক্স যাচাই করুন'],
        'cs' => ['title' => 'Validátor JSON online - zdarma', 'h1' => 'Validátor JSON', 'subtitle' => 'Okamžitě ověřte syntaxi JSON a odhalte chyby'],
        'da' => ['title' => 'JSON-validator online - gratis', 'h1' => 'JSON-validator', 'subtitle' => 'Valider JSON-syntaks øjeblikkeligt og find fejl'],
        'de' => ['title' => 'JSON-Validator online - kostenlos', 'h1' => 'JSON-Validator', 'subtitle' => 'JSON-Syntax sofort validieren und Fehler erkennen'],
        'el' => ['title' => 'Επικυρωτής JSON online - δωρεάν', 'h1' => 'Επικυρωτής JSON', 'subtitle' => 'Επικυρώστε άμεσα τη σύνταξη JSON και εντοπίστε σφάλματα'],
        'es' => ['title' => 'Validador de JSON online - gratis', 'h1' => 'Validador JSON', 'subtitle' => 'Valida la sintaxis JSON al instante y detecta errores'],
        'fi' => ['title' => 'JSON-validaattori verkossa - ilmainen', 'h1' => 'JSON-validaattori', 'subtitle' => 'Validoi JSON-syntaksi välittömästi ja löydä virheet'],
        'fr' => ['title' => 'Validateur JSON en ligne - gratuit', 'h1' => 'Validateur JSON', 'subtitle' => 'Validez la syntaxe JSON instantanément et détectez les erreurs'],
        'hi' => ['title' => 'ऑनलाइन JSON वैलिडेटर - मुफ्त', 'h1' => 'JSON वैलिडेटर', 'subtitle' => 'JSON सिंटैक्स तुरंत जांचें और त्रुटियां खोजें'],
        'id' => ['title' => 'Validator JSON online - gratis', 'h1' => 'Validator JSON', 'subtitle' => 'Validasi sintaks JSON secara instan dan temukan kesalahan'],
        'it' => ['title' => 'Validatore JSON online - gratuito', 'h1' => 'Validatore JSON', 'subtitle' => 'Valida la sintassi JSON istantaneamente e rileva errori'],
        'ja' => ['title' => 'オンラインJSONバリデーター - 無料', 'h1' => 'JSONバリデーター', 'subtitle' => 'JSON構文を瞬時に検証してエラーを検出'],
        'ko' => ['title' => '온라인 JSON 유효성 검사기 - 무료', 'h1' => 'JSON 유효성 검사기', 'subtitle' => 'JSON 구문을 즉시 검증하고 오류 감지'],
        'nl' => ['title' => 'JSON-validator online - gratis', 'h1' => 'JSON-validator', 'subtitle' => 'Valideer JSON-syntaxis direct en detecteer fouten'],
        'no' => ['title' => 'JSON-validator på nett - gratis', 'h1' => 'JSON-validator', 'subtitle' => 'Valider JSON-syntaks umiddelbart og finn feil'],
        'pl' => ['title' => 'Walidator JSON online - darmowy', 'h1' => 'Walidator JSON', 'subtitle' => 'Waliduj składnię JSON natychmiast i wykrywaj błędy'],
        'pt' => ['title' => 'Validador de JSON online - gratuito', 'h1' => 'Validador JSON', 'subtitle' => 'Valide a sintaxe JSON instantaneamente e detecte erros'],
        'ro' => ['title' => 'Validatorul JSON online - gratuit', 'h1' => 'Validator JSON', 'subtitle' => 'Validați sintaxa JSON instant și detectați erori'],
        'ru' => ['title' => 'Онлайн валидатор JSON - бесплатно', 'h1' => 'Валидатор JSON', 'subtitle' => 'Мгновенно проверьте синтаксис JSON и обнаружьте ошибки'],
        'sv' => ['title' => 'JSON-validator online - gratis', 'h1' => 'JSON-validator', 'subtitle' => 'Validera JSON-syntax direkt och hitta fel'],
        'tr' => ['title' => 'Çevrimiçi JSON Doğrulayıcı - ücretsiz', 'h1' => 'JSON Doğrulayıcı', 'subtitle' => 'JSON sözdizimini anında doğrulayın ve hataları tespit edin'],
        'vi' => ['title' => 'Công cụ xác thực JSON trực tuyến - miễn phí', 'h1' => 'Xác thực JSON', 'subtitle' => 'Xác thực cú pháp JSON ngay lập tức và phát hiện lỗi'],
    ],
    'sql-formatter' => [
        'ar' => ['title' => 'أداة تنسيق SQL مجاناً عبر الإنترنت', 'h1' => 'منسق SQL', 'subtitle' => 'جمّل استعلامات SQL وأضف تنسيقاً صحيحاً للمسافات البادئة'],
        'bn' => ['title' => 'অনলাইনে SQL ফরম্যাটার - বিনামূল্যে', 'h1' => 'SQL ফরম্যাটার', 'subtitle' => 'SQL কোয়েরি তাৎক্ষণিকভাবে ফরম্যাট ও সুন্দর করুন'],
        'cs' => ['title' => 'SQL Formátovač online - zdarma', 'h1' => 'SQL Formátovač', 'subtitle' => 'Okamžitě naformátujte a zkrášlete SQL dotazy'],
        'da' => ['title' => 'SQL-formatter online - gratis', 'h1' => 'SQL-formatter', 'subtitle' => 'Formater og forskønne SQL-forespørgsler øjeblikkeligt'],
        'de' => ['title' => 'SQL Formatter online - kostenlos', 'h1' => 'SQL Formatter', 'subtitle' => 'SQL-Abfragen sofort formatieren und verschönern'],
        'el' => ['title' => 'SQL Formatter online - δωρεάν', 'h1' => 'SQL Formatter', 'subtitle' => 'Μορφοποιήστε και ομορφύνετε ερωτήματα SQL άμεσα'],
        'es' => ['title' => 'Formateador SQL online - gratis', 'h1' => 'Formateador SQL', 'subtitle' => 'Formatea y embellece consultas SQL al instante'],
        'fi' => ['title' => 'SQL-muotoilija verkossa - ilmainen', 'h1' => 'SQL-muotoilija', 'subtitle' => 'Muotoile ja kaunista SQL-kyselyt välittömästi'],
        'fr' => ['title' => 'Formateur SQL en ligne - gratuit', 'h1' => 'Formateur SQL', 'subtitle' => 'Formatez et embellissez vos requêtes SQL instantanément'],
        'hi' => ['title' => 'ऑनलाइन SQL फॉर्मेटर - मुफ्त', 'h1' => 'SQL फॉर्मेटर', 'subtitle' => 'SQL क्वेरीज को तुरंत फॉर्मेट और सुंदर बनाएं'],
        'id' => ['title' => 'Formatter SQL online - gratis', 'h1' => 'Formatter SQL', 'subtitle' => 'Format dan perindah kueri SQL secara instan'],
        'it' => ['title' => 'Formattatore SQL online - gratuito', 'h1' => 'Formattatore SQL', 'subtitle' => 'Formatta e abbellisce le query SQL istantaneamente'],
        'ja' => ['title' => 'オンラインSQLフォーマッター - 無料', 'h1' => 'SQLフォーマッター', 'subtitle' => 'SQLクエリを瞬時にフォーマットして整形'],
        'ko' => ['title' => '온라인 SQL 포매터 - 무료', 'h1' => 'SQL 포매터', 'subtitle' => 'SQL 쿼리를 즉시 포맷하고 보기 좋게 만들기'],
        'nl' => ['title' => 'SQL-formatter online - gratis', 'h1' => 'SQL-formatter', 'subtitle' => 'Formatteer en verfraai SQL-query\'s direct'],
        'no' => ['title' => 'SQL-formatter på nett - gratis', 'h1' => 'SQL-formatter', 'subtitle' => 'Formater og forskjønn SQL-spørringer umiddelbart'],
        'pl' => ['title' => 'Formatyzator SQL online - darmowy', 'h1' => 'Formatyzator SQL', 'subtitle' => 'Formatuj i upiększaj zapytania SQL natychmiast'],
        'pt' => ['title' => 'Formatador SQL online - gratuito', 'h1' => 'Formatador SQL', 'subtitle' => 'Formate e embeleze consultas SQL instantaneamente'],
        'ro' => ['title' => 'Formatator SQL online - gratuit', 'h1' => 'Formatator SQL', 'subtitle' => 'Formatați și înfrumusețați interogările SQL instant'],
        'ru' => ['title' => 'Онлайн форматтер SQL - бесплатно', 'h1' => 'Форматтер SQL', 'subtitle' => 'Форматируйте и украшайте SQL-запросы мгновенно'],
        'sv' => ['title' => 'SQL-formaterare online - gratis', 'h1' => 'SQL-formaterare', 'subtitle' => 'Formatera och förskönna SQL-frågor direkt'],
        'tr' => ['title' => 'Çevrimiçi SQL Biçimlendirici - ücretsiz', 'h1' => 'SQL Biçimlendirici', 'subtitle' => 'SQL sorgularını anında biçimlendirin ve güzelleştirin'],
        'vi' => ['title' => 'Công cụ định dạng SQL trực tuyến - miễn phí', 'h1' => 'Định dạng SQL', 'subtitle' => 'Định dạng và làm đẹp truy vấn SQL ngay lập tức'],
    ],
];

// Generate a translated version of the English JSON
function generateTranslation(array $enData, string $lang, string $tool, array $toolMeta, array $commonOverrides): array
{
    $data = $enData;

    // Apply tool-specific meta translations
    if (isset($toolMeta[$tool][$lang])) {
        $m = $toolMeta[$tool][$lang];
        if (isset($m['title']))
            $data['meta']['title'] = $m['title'];
        if (isset($m['h1']))
            $data['meta']['h1'] = $m['h1'];
        if (isset($m['subtitle']))
            $data['meta']['subtitle'] = $m['subtitle'];
    }

    // Apply common editor button overrides
    foreach ($commonOverrides as $keyPath => $value) {
        $keys = explode('.', $keyPath);
        if (count($keys) === 2) {
            [$section, $key] = $keys;
            if (isset($data[$section][$key])) {
                $data[$section][$key] = $value;
            }
        }
    }

    // Mark content body as needing translation (fallback to EN)
    // Only mark the why_desc and faq answers as pending — titles and short strings get translated above
    if (isset($commonOverrides['content.faq_title'])) {
        $data['content']['faq_title'] = $commonOverrides['content.faq_title'];
    }

    return $data;
}

$langs = array_keys($translations);
$created = 0;
$skipped = 0;

foreach ($tools as $tool) {
    $enFile = "$enBase/$tool.json";
    if (!file_exists($enFile)) {
        echo "⚠️  Missing EN source: $tool.json\n";
        continue;
    }
    $enData = json_decode(file_get_contents($enFile), true);
    if (!$enData) {
        echo "⚠️  Invalid JSON: $tool.json\n";
        continue;
    }

    foreach ($langs as $lang) {
        $dir = "$langBase/$lang/tools/development";
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $outFile = "$dir/$tool.json";
        if (file_exists($outFile)) {
            $skipped++;
            continue; // Don't overwrite existing
        }

        $translated = generateTranslation(
            $enData,
            $lang,
            $tool,
            $toolMeta,
            $translations[$lang]
        );

        file_put_contents($outFile, json_encode($translated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        $created++;
        echo "✅ Created: $lang/$tool.json\n";
    }
}

echo "\n🎉 Done! Created: $created files, Skipped (already exist): $skipped files\n";
