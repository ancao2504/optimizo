<?php
/**
 * Script to generate hash tool translations for all remaining languages
 * by translating the shared UI elements and keeping technical terms
 */

$tools = [
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

// Languages that already have translations
$done = ['en', 'ar', 'de'];

// All languages that need translations
$languages = [
    'cs' => ['name' => 'Czech', 'free_online' => 'Bezplatný online nástroj', 'generate' => 'Generovat', 'enter_text' => 'Zadejte text', 'enter_text_to' => 'Zadejte text pro generování', 'copy' => 'Kopírovat', 'copied' => 'Zkopírováno!', 'generating' => 'Generování...', 'enter_text_please' => 'Prosím zadejte text', 'error_failed' => 'Generování hashe selhalo. Zkuste to znovu.', 'security_note' => 'Bezpečnostní poznámka', 'common_uses' => 'Běžné případy použití', 'advantages' => 'Výhody', 'comparison' => 'Srovnání', 'faq' => 'Často kladené otázky', 'what_is' => 'Co je'],
    'da' => ['name' => 'Danish', 'free_online' => 'Gratis onlineværktøj', 'generate' => 'Generer', 'enter_text' => 'Indtast tekst', 'enter_text_to' => 'Indtast tekst for at generere', 'copy' => 'Kopier', 'copied' => 'Kopieret!', 'generating' => 'Genererer...', 'enter_text_please' => 'Indtast venligst tekst', 'error_failed' => 'Hash-generering mislykkedes. Prøv igen.', 'security_note' => 'Sikkerhedsnote', 'common_uses' => 'Almindelige anvendelser', 'advantages' => 'Fordele', 'comparison' => 'Sammenligning', 'faq' => 'Ofte stillede spørgsmål', 'what_is' => 'Hvad er'],
    'es' => ['name' => 'Spanish', 'free_online' => 'Herramienta online gratuita', 'generate' => 'Generar', 'enter_text' => 'Introducir texto', 'enter_text_to' => 'Introduce texto para generar', 'copy' => 'Copiar', 'copied' => '¡Copiado!', 'generating' => 'Generando...', 'enter_text_please' => 'Por favor introduce texto', 'error_failed' => 'Error al generar el hash. Inténtalo de nuevo.', 'security_note' => 'Nota de seguridad', 'common_uses' => 'Casos de uso comunes', 'advantages' => 'Ventajas', 'comparison' => 'Comparación', 'faq' => 'Preguntas frecuentes', 'what_is' => 'Qué es'],
    'fi' => ['name' => 'Finnish', 'free_online' => 'Ilmainen online-työkalu', 'generate' => 'Luo', 'enter_text' => 'Syötä teksti', 'enter_text_to' => 'Syötä teksti luodaksesi', 'copy' => 'Kopioi', 'copied' => 'Kopioitu!', 'generating' => 'Luodaan...', 'enter_text_please' => 'Syötä teksti', 'error_failed' => 'Tiivisteen luominen epäonnistui. Yritä uudelleen.', 'security_note' => 'Turvallisuushuomautus', 'common_uses' => 'Yleiset käyttötapaukset', 'advantages' => 'Edut', 'comparison' => 'Vertailu', 'faq' => 'Usein kysytyt kysymykset', 'what_is' => 'Mikä on'],
    'fr' => ['name' => 'French', 'free_online' => 'Outil en ligne gratuit', 'generate' => 'Générer', 'enter_text' => 'Saisir le texte', 'enter_text_to' => 'Saisissez le texte pour générer', 'copy' => 'Copier', 'copied' => 'Copié !', 'generating' => 'Génération...', 'enter_text_please' => 'Veuillez saisir du texte', 'error_failed' => 'Échec de la génération du hash. Réessayez.', 'security_note' => 'Note de sécurité', 'common_uses' => 'Cas d\'utilisation courants', 'advantages' => 'Avantages', 'comparison' => 'Comparaison', 'faq' => 'Questions fréquemment posées', 'what_is' => 'Qu\'est-ce que'],
    'id' => ['name' => 'Indonesian', 'free_online' => 'Alat online gratis', 'generate' => 'Hasilkan', 'enter_text' => 'Masukkan teks', 'enter_text_to' => 'Masukkan teks untuk menghasilkan', 'copy' => 'Salin', 'copied' => 'Disalin!', 'generating' => 'Menghasilkan...', 'enter_text_please' => 'Silakan masukkan teks', 'error_failed' => 'Gagal menghasilkan hash. Coba lagi.', 'security_note' => 'Catatan keamanan', 'common_uses' => 'Kasus penggunaan umum', 'advantages' => 'Keunggulan', 'comparison' => 'Perbandingan', 'faq' => 'Pertanyaan yang sering diajukan', 'what_is' => 'Apa itu'],
    'it' => ['name' => 'Italian', 'free_online' => 'Strumento online gratuito', 'generate' => 'Genera', 'enter_text' => 'Inserisci testo', 'enter_text_to' => 'Inserisci il testo per generare', 'copy' => 'Copia', 'copied' => 'Copiato!', 'generating' => 'Generazione...', 'enter_text_please' => 'Inserisci del testo', 'error_failed' => 'Generazione hash fallita. Riprova.', 'security_note' => 'Nota sulla sicurezza', 'common_uses' => 'Casi d\'uso comuni', 'advantages' => 'Vantaggi', 'comparison' => 'Confronto', 'faq' => 'Domande frequenti', 'what_is' => 'Cos\'è'],
    'ja' => ['name' => 'Japanese', 'free_online' => '無料オンラインツール', 'generate' => '生成', 'enter_text' => 'テキストを入力', 'enter_text_to' => 'ハッシュを生成するテキストを入力...', 'copy' => 'コピー', 'copied' => 'コピーしました！', 'generating' => '生成中...', 'enter_text_please' => 'テキストを入力してください', 'error_failed' => 'ハッシュの生成に失敗しました。もう一度お試しください。', 'security_note' => 'セキュリティに関する注意', 'common_uses' => '一般的な使用例', 'advantages' => '利点', 'comparison' => '比較', 'faq' => 'よくある質問', 'what_is' => 'とは'],
    'ko' => ['name' => 'Korean', 'free_online' => '무료 온라인 도구', 'generate' => '생성', 'enter_text' => '텍스트 입력', 'enter_text_to' => '해시를 생성할 텍스트를 입력하세요...', 'copy' => '복사', 'copied' => '복사됨!', 'generating' => '생성 중...', 'enter_text_please' => '텍스트를 입력하세요', 'error_failed' => '해시 생성에 실패했습니다. 다시 시도하세요.', 'security_note' => '보안 참고 사항', 'common_uses' => '일반적인 사용 사례', 'advantages' => '장점', 'comparison' => '비교', 'faq' => '자주 묻는 질문', 'what_is' => '이란'],
    'nl' => ['name' => 'Dutch', 'free_online' => 'Gratis online tool', 'generate' => 'Genereer', 'enter_text' => 'Voer tekst in', 'enter_text_to' => 'Voer tekst in om te genereren', 'copy' => 'Kopiëren', 'copied' => 'Gekopieerd!', 'generating' => 'Genereren...', 'enter_text_please' => 'Voer tekst in', 'error_failed' => 'Hash generatie mislukt. Probeer opnieuw.', 'security_note' => 'Beveiligingsopmerking', 'common_uses' => 'Veelvoorkomende toepassingen', 'advantages' => 'Voordelen', 'comparison' => 'Vergelijking', 'faq' => 'Veelgestelde vragen', 'what_is' => 'Wat is'],
    'no' => ['name' => 'Norwegian', 'free_online' => 'Gratis nettverktøy', 'generate' => 'Generer', 'enter_text' => 'Skriv inn tekst', 'enter_text_to' => 'Skriv inn tekst for å generere', 'copy' => 'Kopier', 'copied' => 'Kopiert!', 'generating' => 'Genererer...', 'enter_text_please' => 'Vennligst skriv inn tekst', 'error_failed' => 'Hash-generering mislyktes. Prøv igjen.', 'security_note' => 'Sikkerhetsnotat', 'common_uses' => 'Vanlige bruksområder', 'advantages' => 'Fordeler', 'comparison' => 'Sammenligning', 'faq' => 'Ofte stilte spørsmål', 'what_is' => 'Hva er'],
    'pl' => ['name' => 'Polish', 'free_online' => 'Darmowe narzędzie online', 'generate' => 'Generuj', 'enter_text' => 'Wprowadź tekst', 'enter_text_to' => 'Wprowadź tekst, aby wygenerować', 'copy' => 'Kopiuj', 'copied' => 'Skopiowano!', 'generating' => 'Generowanie...', 'enter_text_please' => 'Proszę wprowadzić tekst', 'error_failed' => 'Generowanie hasha nie powiodło się. Spróbuj ponownie.', 'security_note' => 'Uwaga dotycząca bezpieczeństwa', 'common_uses' => 'Typowe zastosowania', 'advantages' => 'Zalety', 'comparison' => 'Porównanie', 'faq' => 'Często zadawane pytania', 'what_is' => 'Czym jest'],
    'pt' => ['name' => 'Portuguese', 'free_online' => 'Ferramenta online gratuita', 'generate' => 'Gerar', 'enter_text' => 'Inserir texto', 'enter_text_to' => 'Insira o texto para gerar', 'copy' => 'Copiar', 'copied' => 'Copiado!', 'generating' => 'Gerando...', 'enter_text_please' => 'Por favor insira o texto', 'error_failed' => 'Falha ao gerar hash. Tente novamente.', 'security_note' => 'Nota de segurança', 'common_uses' => 'Casos de uso comuns', 'advantages' => 'Vantagens', 'comparison' => 'Comparação', 'faq' => 'Perguntas frequentes', 'what_is' => 'O que é'],
    'ro' => ['name' => 'Romanian', 'free_online' => 'Instrument online gratuit', 'generate' => 'Generează', 'enter_text' => 'Introduceți textul', 'enter_text_to' => 'Introduceți textul pentru a genera', 'copy' => 'Copiază', 'copied' => 'Copiat!', 'generating' => 'Se generează...', 'enter_text_please' => 'Vă rugăm introduceți textul', 'error_failed' => 'Generarea hash-ului a eșuat. Încercați din nou.', 'security_note' => 'Notă de securitate', 'common_uses' => 'Cazuri comune de utilizare', 'advantages' => 'Avantaje', 'comparison' => 'Comparație', 'faq' => 'Întrebări frecvente', 'what_is' => 'Ce este'],
    'ru' => ['name' => 'Russian', 'free_online' => 'Бесплатный онлайн-инструмент', 'generate' => 'Сгенерировать', 'enter_text' => 'Введите текст', 'enter_text_to' => 'Введите текст для генерации', 'copy' => 'Копировать', 'copied' => 'Скопировано!', 'generating' => 'Генерация...', 'enter_text_please' => 'Пожалуйста, введите текст', 'error_failed' => 'Ошибка генерации хеша. Попробуйте снова.', 'security_note' => 'Примечание по безопасности', 'common_uses' => 'Распространённые случаи использования', 'advantages' => 'Преимущества', 'comparison' => 'Сравнение', 'faq' => 'Часто задаваемые вопросы', 'what_is' => 'Что такое'],
    'sv' => ['name' => 'Swedish', 'free_online' => 'Gratis onlineverktyg', 'generate' => 'Generera', 'enter_text' => 'Ange text', 'enter_text_to' => 'Ange text för att generera', 'copy' => 'Kopiera', 'copied' => 'Kopierat!', 'generating' => 'Genererar...', 'enter_text_please' => 'Vänligen ange text', 'error_failed' => 'Hash-generering misslyckades. Försök igen.', 'security_note' => 'Säkerhetsanmärkning', 'common_uses' => 'Vanliga användningsfall', 'advantages' => 'Fördelar', 'comparison' => 'Jämförelse', 'faq' => 'Vanliga frågor', 'what_is' => 'Vad är'],
    'tr' => ['name' => 'Turkish', 'free_online' => 'Ücretsiz çevrimiçi araç', 'generate' => 'Oluştur', 'enter_text' => 'Metin girin', 'enter_text_to' => 'Hash oluşturmak için metin girin', 'copy' => 'Kopyala', 'copied' => 'Kopyalandı!', 'generating' => 'Oluşturuluyor...', 'enter_text_please' => 'Lütfen metin girin', 'error_failed' => 'Hash oluşturma başarısız. Tekrar deneyin.', 'security_note' => 'Güvenlik notu', 'common_uses' => 'Yaygın kullanım alanları', 'advantages' => 'Avantajlar', 'comparison' => 'Karşılaştırma', 'faq' => 'Sık sorulan sorular', 'what_is' => 'Nedir'],
    'vi' => ['name' => 'Vietnamese', 'free_online' => 'Công cụ trực tuyến miễn phí', 'generate' => 'Tạo', 'enter_text' => 'Nhập văn bản', 'enter_text_to' => 'Nhập văn bản để tạo', 'copy' => 'Sao chép', 'copied' => 'Đã sao chép!', 'generating' => 'Đang tạo...', 'enter_text_please' => 'Vui lòng nhập văn bản', 'error_failed' => 'Tạo hash thất bại. Vui lòng thử lại.', 'security_note' => 'Lưu ý bảo mật', 'common_uses' => 'Các trường hợp sử dụng phổ biến', 'advantages' => 'Ưu điểm', 'comparison' => 'So sánh', 'faq' => 'Câu hỏi thường gặp', 'what_is' => 'là gì'],
    'zh' => ['name' => 'Chinese', 'free_online' => '免费在线工具', 'generate' => '生成', 'enter_text' => '输入文本', 'enter_text_to' => '输入文本以生成', 'copy' => '复制', 'copied' => '已复制！', 'generating' => '生成中...', 'enter_text_please' => '请输入文本', 'error_failed' => '哈希生成失败。请重试。', 'security_note' => '安全注意事项', 'common_uses' => '常见用例', 'advantages' => '优势', 'comparison' => '比较', 'faq' => '常见问题', 'what_is' => '什么是'],
];

$basePath = __DIR__ . '/resources/lang';
$created = 0;

foreach ($languages as $lang => $l) {
    if (in_array($lang, $done))
        continue;

    foreach ($tools as $tool) {
        $targetDir = "$basePath/$lang/tools/development";
        $targetFile = "$targetDir/$tool.json";

        // Skip if already exists
        if (file_exists($targetFile)) {
            echo "SKIP: $lang/$tool (exists)\n";
            continue;
        }

        // Read English source
        $enFile = "$basePath/en/tools/development/$tool.json";
        if (!file_exists($enFile)) {
            echo "ERROR: Missing English source for $tool\n";
            continue;
        }

        $en = json_decode(file_get_contents($enFile), true);
        if (!$en) {
            echo "ERROR: Invalid JSON in English $tool\n";
            continue;
        }

        // Extract algorithm display name from English
        $algoName = str_replace(' Hash Generator', '', $en['meta']['h1'] ?? $tool);

        // Create translated version
        $translated = [
            'meta' => [
                'title' => "$algoName Hash Generator - {$l['free_online']}",
                'description' => $en['meta']['description'], // Keep English description as fallback (SEO in English is fine for many markets)
                'h1' => "$algoName Hash Generator",
                'subtitle' => $en['meta']['subtitle'],
            ],
            'editor' => [
                'label_input' => $l['enter_text'],
                'ph_input' => "{$l['enter_text_to']} $algoName hash...",
                'btn_generate' => "{$l['generate']} $algoName Hash",
                'label_result' => "$algoName Hash",
                'btn_copy' => $l['copy'],
            ],
            'content' => $en['content'], // Keep English content (technical content)
            'js' => [
                'error_empty' => $l['enter_text_please'],
                'btn_copied' => $l['copied'],
                'btn_generating' => $l['generating'],
                'error_failed' => $l['error_failed'],
            ],
        ];

        // Ensure directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // Write file
        $json = json_encode($translated, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents($targetFile, $json . "\n");
        $created++;
        echo "OK: $lang/$tool\n";
    }
}

echo "\nDone! Created $created files.\n";
