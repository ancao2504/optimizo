<?php

/**
 * Add missing translated strings to all 10 target language JSON files.
 * 
 * Strategy:
 * 1. For commonly-shared values (same text across many tools), use a pre-built dictionary
 * 2. For tool-specific subtitles/descriptions, generate contextual translations
 * 3. Process all tool categories
 */

$basePath = realpath(__DIR__ . '/..');
$langPath = "$basePath/resources/lang";
$targetLangs = ['id', 'ja', 'ko', 'nl', 'no', 'pl', 'ro', 'sv', 'tr', 'zh'];
$categories = ['image', 'development', 'youtube', 'seo', 'text', 'network', 'utility', 'converters', 'document', 'time'];

// ============================================
// Translation Dictionary for Common Strings
// ============================================
$translations = [
    'Why Use This Tool?' => [
        'id' => 'Mengapa Menggunakan Alat Ini?',
        'ja' => 'このツールを使う理由',
        'ko' => '이 도구를 사용하는 이유',
        'nl' => 'Waarom deze tool gebruiken?',
        'no' => 'Hvorfor bruke dette verktøyet?',
        'pl' => 'Dlaczego warto używać tego narzędzia?',
        'ro' => 'De ce să folosiți acest instrument?',
        'sv' => 'Varför använda detta verktyg?',
        'tr' => 'Bu Aracı Neden Kullanmalısınız?',
        'zh' => '为什么使用此工具？',
    ],
    'Upload New Image' => [
        'id' => 'Unggah Gambar Baru',
        'ja' => '新しい画像をアップロード',
        'ko' => '새 이미지 업로드',
        'nl' => 'Nieuwe afbeelding uploaden',
        'no' => 'Last opp nytt bilde',
        'pl' => 'Prześlij nowy obraz',
        'ro' => 'Încarcă imagine nouă',
        'sv' => 'Ladda upp ny bild',
        'tr' => 'Yeni Görsel Yükle',
        'zh' => '上传新图片',
    ],
    'Frequently Asked Questions' => [
        'id' => 'Pertanyaan yang Sering Diajukan',
        'ja' => 'よくある質問',
        'ko' => '자주 묻는 질문',
        'nl' => 'Veelgestelde vragen',
        'no' => 'Vanlige spørsmål',
        'pl' => 'Często zadawane pytania',
        'ro' => 'Întrebări frecvente',
        'sv' => 'Vanliga frågor',
        'tr' => 'Sıkça Sorulan Sorular',
        'zh' => '常见问题',
    ],
    'Your image is ready to download' => [
        'id' => 'Gambar Anda siap untuk diunduh',
        'ja' => '画像のダウンロード準備ができました',
        'ko' => '이미지를 다운로드할 준비가 되었습니다',
        'nl' => 'Uw afbeelding is klaar om te downloaden',
        'no' => 'Bildet ditt er klart for nedlasting',
        'pl' => 'Twój obraz jest gotowy do pobrania',
        'ro' => 'Imaginea dvs. este gata de descărcat',
        'sv' => 'Din bild är redo att laddas ner',
        'tr' => 'Görseliniz indirmeye hazır',
        'zh' => '您的图片已准备好下载',
    ],
    'Paste your Base64 string here' => [
        'id' => 'Tempelkan string Base64 Anda di sini',
        'ja' => 'Base64文字列をここに貼り付けてください',
        'ko' => '여기에 Base64 문자열을 붙여넣으세요',
        'nl' => 'Plak hier uw Base64-tekenreeks',
        'no' => 'Lim inn Base64-strengen din her',
        'pl' => 'Wklej tutaj swój ciąg Base64',
        'ro' => 'Lipiți șirul Base64 aici',
        'sv' => 'Klistra in din Base64-sträng här',
        'tr' => 'Base64 dizginizi buraya yapıştırın',
        'zh' => '在此粘贴您的Base64字符串',
    ],
    // Phase 3: digital-signature strings
    'Drop your PDF here or click to upload' => [
        'id' => 'Letakkan PDF Anda di sini atau klik untuk mengunggah',
        'ja' => 'PDFをここにドロップするか、クリックしてアップロード',
        'ko' => 'PDF를 여기에 놓거나 클릭하여 업로드',
        'nl' => 'Sleep uw PDF hierheen of klik om te uploaden',
        'no' => 'Slipp PDF-en din her eller klikk for å laste opp',
        'pl' => 'Upuść plik PDF tutaj lub kliknij, aby przesłać',
        'ro' => 'Plasați PDF-ul aici sau faceți clic pentru a încărca',
        'sv' => 'Släpp din PDF här eller klicka för att ladda upp',
        'tr' => 'PDF\'nizi buraya bırakın veya yüklemek için tıklayın',
        'zh' => '将PDF拖放到此处或点击上传',
    ],
    'Maximum file size: 10MB' => [
        'id' => 'Ukuran file maksimum: 10MB',
        'ja' => '最大ファイルサイズ：10MB',
        'ko' => '최대 파일 크기: 10MB',
        'nl' => 'Maximale bestandsgrootte: 10MB',
        'no' => 'Maksimal filstørrelse: 10MB',
        'pl' => 'Maksymalny rozmiar pliku: 10MB',
        'ro' => 'Dimensiune maximă fișier: 10MB',
        'sv' => 'Maximal filstorlek: 10MB',
        'tr' => 'Maksimum dosya boyutu: 10MB',
        'zh' => '最大文件大小：10MB',
    ],
    'Page' => [
        'id' => 'Halaman',
        'ja' => 'ページ',
        'ko' => '페이지',
        'nl' => 'Pagina',
        'no' => 'Side',
        'pl' => 'Strona',
        'ro' => 'Pagina',
        'sv' => 'Sida',
        'tr' => 'Sayfa',
        'zh' => '页面',
    ],
    'of' => [
        'id' => 'dari',
        'ja' => '/',
        'ko' => '/',
        'nl' => 'van',
        'no' => 'av',
        'pl' => 'z',
        'ro' => 'din',
        'sv' => 'av',
        'tr' => '/',
        'zh' => '/',
    ],
    'Add Signature' => [
        'id' => 'Tambah Tanda Tangan',
        'ja' => '署名を追加',
        'ko' => '서명 추가',
        'nl' => 'Handtekening toevoegen',
        'no' => 'Legg til signatur',
        'pl' => 'Dodaj podpis',
        'ro' => 'Adaugă semnătură',
        'sv' => 'Lägg till signatur',
        'tr' => 'İmza Ekle',
        'zh' => '添加签名',
    ],
    'Download PDF' => [
        'id' => 'Unduh PDF',
        'ja' => 'PDFをダウンロード',
        'ko' => 'PDF 다운로드',
        'nl' => 'PDF downloaden',
        'no' => 'Last ned PDF',
        'pl' => 'Pobierz PDF',
        'ro' => 'Descarcă PDF',
        'sv' => 'Ladda ner PDF',
        'tr' => 'PDF İndir',
        'zh' => '下载PDF',
    ],
    'Create Signature' => [
        'id' => 'Buat Tanda Tangan',
        'ja' => '署名を作成',
        'ko' => '서명 만들기',
        'nl' => 'Handtekening maken',
        'no' => 'Opprett signatur',
        'pl' => 'Utwórz podpis',
        'ro' => 'Creează semnătură',
        'sv' => 'Skapa signatur',
        'tr' => 'İmza Oluştur',
        'zh' => '创建签名',
    ],
    'Draw' => [
        'id' => 'Gambar',
        'ja' => '描画',
        'ko' => '그리기',
        'nl' => 'Tekenen',
        'no' => 'Tegne',
        'pl' => 'Rysuj',
        'ro' => 'Desenează',
        'sv' => 'Rita',
        'tr' => 'Çiz',
        'zh' => '绘制',
    ],
    'Type' => [
        'id' => 'Ketik',
        'ja' => '入力',
        'ko' => '입력',
        'nl' => 'Typen',
        'no' => 'Skriv',
        'pl' => 'Wpisz',
        'ro' => 'Tastează',
        'sv' => 'Skriv',
        'tr' => 'Yaz',
        'zh' => '输入',
    ],
    'Upload' => [
        'id' => 'Unggah',
        'ja' => 'アップロード',
        'ko' => '업로드',
        'nl' => 'Uploaden',
        'no' => 'Last opp',
        'pl' => 'Prześlij',
        'ro' => 'Încarcă',
        'sv' => 'Ladda upp',
        'tr' => 'Yükle',
        'zh' => '上传',
    ],
    'Clear' => [
        'id' => 'Hapus',
        'ja' => 'クリア',
        'ko' => '지우기',
        'nl' => 'Wissen',
        'no' => 'Slett',
        'pl' => 'Wyczyść',
        'ro' => 'Șterge',
        'sv' => 'Rensa',
        'tr' => 'Temizle',
        'zh' => '清除',
    ],
    'Type your name' => [
        'id' => 'Ketik nama Anda',
        'ja' => '名前を入力してください',
        'ko' => '이름을 입력하세요',
        'nl' => 'Typ uw naam',
        'no' => 'Skriv navnet ditt',
        'pl' => 'Wpisz swoje imię',
        'ro' => 'Introduceți numele dvs.',
        'sv' => 'Skriv ditt namn',
        'tr' => 'Adınızı yazın',
        'zh' => '输入您的姓名',
    ],
    'Cancel' => [
        'id' => 'Batal',
        'ja' => 'キャンセル',
        'ko' => '취소',
        'nl' => 'Annuleren',
        'no' => 'Avbryt',
        'pl' => 'Anuluj',
        'ro' => 'Anulează',
        'sv' => 'Avbryt',
        'tr' => 'İptal',
        'zh' => '取消',
    ],
    'Digital Signature - Free Online Document Signing Tool' => [
        'id' => 'Tanda Tangan Digital - Alat Tanda Tangan Dokumen Online Gratis',
        'ja' => 'デジタル署名 - 無料オンライン文書署名ツール',
        'ko' => '디지털 서명 - 무료 온라인 문서 서명 도구',
        'nl' => 'Digitale handtekening - Gratis online documentondertekeningstool',
        'no' => 'Digital signatur - Gratis online dokumentsigneringsverktøy',
        'pl' => 'Podpis cyfrowy - Darmowe narzędzie do podpisywania dokumentów online',
        'ro' => 'Semnătură digitală - Instrument gratuit de semnare a documentelor online',
        'sv' => 'Digital signatur - Gratis online dokumentsigneringsverktyg',
        'tr' => 'Dijital İmza - Ücretsiz Çevrimiçi Belge İmzalama Aracı',
        'zh' => '数字签名 - 免费在线文档签名工具',
    ],
    'Sign PDF documents online for free. Upload your PDF, draw or type your signature, and download the signed document securely.' => [
        'id' => 'Tanda tangani dokumen PDF secara online gratis. Unggah PDF Anda, gambar atau ketik tanda tangan Anda, lalu unduh dokumen yang ditandatangani dengan aman.',
        'ja' => 'PDFドキュメントを無料でオンラインで署名。PDFをアップロードし、署名を描画または入力して、署名済みドキュメントを安全にダウンロードします。',
        'ko' => 'PDF 문서를 무료로 온라인으로 서명하세요. PDF를 업로드하고 서명을 그리거나 입력한 후 서명된 문서를 안전하게 다운로드하세요.',
        'nl' => 'Onderteken PDF-documenten gratis online. Upload uw PDF, teken of typ uw handtekening en download het ondertekende document veilig.',
        'no' => 'Signer PDF-dokumenter gratis online. Last opp PDF-en din, tegn eller skriv signaturen din, og last ned det signerte dokumentet sikkert.',
        'pl' => 'Podpisuj dokumenty PDF online za darmo. Prześlij plik PDF, narysuj lub wpisz podpis i pobierz bezpiecznie podpisany dokument.',
        'ro' => 'Semnați documente PDF online gratuit. Încărcați PDF-ul, desenați sau tastați semnătura și descărcați documentul semnat în siguranță.',
        'sv' => 'Signera PDF-dokument gratis online. Ladda upp din PDF, rita eller skriv din signatur och ladda ner det signerade dokumentet säkert.',
        'tr' => 'PDF belgelerini çevrimiçi ücretsiz imzalayın. PDF\'nizi yükleyin, imzanızı çizin veya yazın ve imzalı belgeyi güvenle indirin.',
        'zh' => '免费在线签署PDF文档。上传您的PDF，绘制或输入您的签名，然后安全下载已签署的文档。',
    ],
    // Phase 3: utc-to-local-time
    'Local vs UTC' => [
        'id' => 'Lokal vs UTC',
        'ja' => 'ローカル時間 vs UTC',
        'ko' => '현지 시간 vs UTC',
        'nl' => 'Lokaal vs UTC',
        'no' => 'Lokal vs UTC',
        'pl' => 'Czas lokalny vs UTC',
        'ro' => 'Local vs UTC',
        'sv' => 'Lokal vs UTC',
        'tr' => 'Yerel vs UTC',
        'zh' => '本地时间 vs UTC',
    ],
    'Local time is the time in your specific time zone, which may include adjustments for daylight saving time. UTC is the worldwide baseline that stays constant regardless of location or season.' => [
        'id' => 'Waktu lokal adalah waktu di zona waktu spesifik Anda, yang mungkin termasuk penyesuaian waktu musim panas. UTC adalah acuan di seluruh dunia yang tetap konstan terlepas dari lokasi atau musim.',
        'ja' => 'ローカル時間はあなたの特定のタイムゾーンの時間で、夏時間の調整が含まれる場合があります。UTCは場所や季節に関係なく一定の世界基準です。',
        'ko' => '현지 시간은 일광 절약 시간 조정이 포함될 수 있는 특정 시간대의 시간입니다. UTC는 위치나 계절에 관계없이 일정한 전 세계 기준입니다.',
        'nl' => 'Lokale tijd is de tijd in uw specifieke tijdzone, inclusief eventuele aanpassingen voor zomertijd. UTC is de wereldwijde basislijn die constant blijft ongeacht locatie of seizoen.',
        'no' => 'Lokal tid er tiden i din spesifikke tidssone, som kan inkludere justeringer for sommertid. UTC er den verdensomspennende referansen som forblir konstant uansett plassering eller sesong.',
        'pl' => 'Czas lokalny to czas w Twojej strefie czasowej, który może uwzględniać zmiany czasu letniego. UTC to światowy punkt odniesienia, który pozostaje stały niezależnie od lokalizacji czy pory roku.',
        'ro' => 'Ora locală este ora din fusul orar specific, care poate include ajustări pentru ora de vară. UTC este referința mondială care rămâne constantă indiferent de locație sau anotimp.',
        'sv' => 'Lokal tid är tiden i din specifika tidszon, vilken kan inkludera justeringar för sommartid. UTC är den världsomspännande referensen som förblir konstant oavsett plats eller säsong.',
        'tr' => 'Yerel saat, yaz saati uygulaması ayarlamalarını içerebilen belirli zaman diliminizdeki saattir. UTC, konuma veya mevsime bakılmaksızın sabit kalan dünya genelindeki temel referanstır.',
        'zh' => '本地时间是您特定时区的时间，可能包含夏令时调整。UTC是全球基准时间，无论位置或季节如何都保持不变。',
    ],
    // Phase 3: frequency-converter  
    'Frequency Units' => [
        'id' => 'Satuan Frekuensi',
        'ja' => '周波数の単位',
        'ko' => '주파수 단위',
        'nl' => 'Frequentie-eenheden',
        'no' => 'Frekvensenheter',
        'pl' => 'Jednostki częstotliwości',
        'ro' => 'Unități de frecvență',
        'sv' => 'Frekvensenheter',
        'tr' => 'Frekans Birimleri',
        'zh' => '频率单位',
    ],
    'Convert between Hz, kHz, MHz, GHz, RPM, and more frequency units.' => [
        'id' => 'Konversi antara Hz, kHz, MHz, GHz, RPM, dan unit frekuensi lainnya.',
        'ja' => 'Hz、kHz、MHz、GHz、RPMなどの周波数単位を変換します。',
        'ko' => 'Hz, kHz, MHz, GHz, RPM 등 다양한 주파수 단위 간 변환합니다.',
        'nl' => 'Converteer tussen Hz, kHz, MHz, GHz, RPM en meer frequentie-eenheden.',
        'no' => 'Konverter mellom Hz, kHz, MHz, GHz, RPM og andre frekvensenheter.',
        'pl' => 'Konwertuj między Hz, kHz, MHz, GHz, RPM i innymi jednostkami częstotliwości.',
        'ro' => 'Convertiți între Hz, kHz, MHz, GHz, RPM și alte unități de frecvență.',
        'sv' => 'Konvertera mellan Hz, kHz, MHz, GHz, RPM och fler frekvensenheter.',
        'tr' => 'Hz, kHz, MHz, GHz, RPM ve daha fazla frekans birimi arasında dönüştürün.',
        'zh' => '在Hz、kHz、MHz、GHz、RPM等频率单位之间转换。',
    ],
    'Electronics & Computing' => [
        'id' => 'Elektronik & Komputasi',
        'ja' => 'エレクトロニクス&コンピューティング',
        'ko' => '전자공학 & 컴퓨팅',
        'nl' => 'Elektronica & Computing',
        'no' => 'Elektronikk & Databehandling',
        'pl' => 'Elektronika i informatyka',
        'ro' => 'Electronică și calcul',
        'sv' => 'Elektronik & datateknik',
        'tr' => 'Elektronik & Bilişim',
        'zh' => '电子与计算',
    ],
    'Perfect for CPU speeds, radio frequencies, and wave calculations.' => [
        'id' => 'Sempurna untuk kecepatan CPU, frekuensi radio, dan perhitungan gelombang.',
        'ja' => 'CPU速度、ラジオ周波数、波動計算に最適です。',
        'ko' => 'CPU 속도, 라디오 주파수 및 파동 계산에 적합합니다.',
        'nl' => 'Perfect voor CPU-snelheden, radiofrequenties en golfberekeningen.',
        'no' => 'Perfekt for CPU-hastigheter, radiofrekvenser og bølgeberegninger.',
        'pl' => 'Idealne do prędkości procesora, częstotliwości radiowych i obliczeń falowych.',
        'ro' => 'Perfect pentru viteze CPU, frecvențe radio și calcule de undă.',
        'sv' => 'Perfekt för CPU-hastigheter, radiofrekvenser och vågberäkningar.',
        'tr' => 'CPU hızları, radyo frekansları ve dalga hesaplamaları için mükemmeldir.',
        'zh' => '适用于CPU速度、无线电频率和波动计算。',
    ],
    'Cycles Per Second' => [
        'id' => 'Siklus Per Detik',
        'ja' => '毎秒サイクル数',
        'ko' => '초당 사이클',
        'nl' => 'Cycli per seconde',
        'no' => 'Sykluser per sekund',
        'pl' => 'Cykli na sekundę',
        'ro' => 'Cicluri pe secundă',
        'sv' => 'Cykler per sekund',
        'tr' => 'Saniye Başına Döngü',
        'zh' => '每秒周期数',
    ],
    'Accurate conversions for oscillations, rotations, and wave frequencies.' => [
        'id' => 'Konversi akurat untuk osilasi, rotasi, dan frekuensi gelombang.',
        'ja' => '振動、回転、波動周波数の正確な変換。',
        'ko' => '진동, 회전 및 파동 주파수에 대한 정확한 변환.',
        'nl' => 'Nauwkeurige conversies voor oscillaties, rotaties en golffrequenties.',
        'no' => 'Nøyaktige konverteringer for svingninger, rotasjoner og bølgefrekvenser.',
        'pl' => 'Dokładne konwersje dla oscylacji, obrotów i częstotliwości falowych.',
        'ro' => 'Conversii precise pentru oscilații, rotații și frecvențe de undă.',
        'sv' => 'Noggranna konverteringar för oscillationer, rotationer och vågfrekvenser.',
        'tr' => 'Salınımlar, dönüşler ve dalga frekansları için doğru dönüşümler.',
        'zh' => '振荡、旋转和波频率的精确转换。',
    ],
    // Phase 3: sitemap-validator-results
    'Valid Sitemap!' => [
        'id' => 'Sitemap Valid!',
        'ja' => '有効なサイトマップ！',
        'ko' => '유효한 사이트맵!',
        'nl' => 'Geldige sitemap!',
        'no' => 'Gyldig sidekart!',
        'pl' => 'Prawidłowa mapa witryny!',
        'ro' => 'Sitemap valid!',
        'sv' => 'Giltig webbkarta!',
        'tr' => 'Geçerli Site Haritası!',
        'zh' => '有效的站点地图！',
    ],
    'Your sitemap is properly formatted and ready to submit.' => [
        'id' => 'Sitemap Anda diformat dengan benar dan siap dikirimkan.',
        'ja' => 'サイトマップは正しくフォーマットされており、送信の準備ができています。',
        'ko' => '사이트맵이 올바르게 포맷되어 제출할 준비가 되었습니다.',
        'nl' => 'Uw sitemap is correct opgemaakt en klaar om in te dienen.',
        'no' => 'Sidekartet ditt er riktig formatert og klart til innsending.',
        'pl' => 'Twoja mapa witryny jest prawidłowo sformatowana i gotowa do przesłania.',
        'ro' => 'Sitemap-ul dvs. este formatat corect și gata de trimitere.',
        'sv' => 'Din webbkarta är korrekt formaterad och redo att skickas in.',
        'tr' => 'Site haritanız doğru biçimlendirilmiş ve gönderilmeye hazır.',
        'zh' => '您的站点地图格式正确，可以提交。',
    ],
    'Invalid Sitemap' => [
        'id' => 'Sitemap Tidak Valid',
        'ja' => '無効なサイトマップ',
        'ko' => '유효하지 않은 사이트맵',
        'nl' => 'Ongeldige sitemap',
        'no' => 'Ugyldig sidekart',
        'pl' => 'Nieprawidłowa mapa witryny',
        'ro' => 'Sitemap invalid',
        'sv' => 'Ogiltig webbkarta',
        'tr' => 'Geçersiz Site Haritası',
        'zh' => '无效的站点地图',
    ],
    'Please fix the errors below.' => [
        'id' => 'Silakan perbaiki kesalahan di bawah ini.',
        'ja' => '以下のエラーを修正してください。',
        'ko' => '아래 오류를 수정해 주세요.',
        'nl' => 'Corrigeer de onderstaande fouten.',
        'no' => 'Vennligst fiks feilene nedenfor.',
        'pl' => 'Proszę naprawić poniższe błędy.',
        'ro' => 'Vă rugăm să corectați erorile de mai jos.',
        'sv' => 'Åtgärda felen nedan.',
        'tr' => 'Lütfen aşağıdaki hataları düzeltin.',
        'zh' => '请修复以下错误。',
    ],
    'Sitemaps' => [
        'id' => 'Peta Situs',
        'ja' => 'サイトマップ',
        'ko' => '사이트맵',
        'nl' => 'Sitemaps',
        'no' => 'Sidekart',
        'pl' => 'Mapy witryny',
        'ro' => 'Sitemaps',
        'sv' => 'Webbkartor',
        'tr' => 'Site Haritaları',
        'zh' => '站点地图',
    ],
    'Total URLs' => [
        'id' => 'Total URL',
        'ja' => '合計URL数',
        'ko' => '전체 URL',
        'nl' => 'Totaal URL\'s',
        'no' => 'Totalt antall URL-er',
        'pl' => 'Łączna liczba adresów URL',
        'ro' => 'Total URL-uri',
        'sv' => 'Totalt antal URL:er',
        'tr' => 'Toplam URL',
        'zh' => '总URL数',
    ],
    'URLs' => [
        'id' => 'URL',
        'ja' => 'URL',
        'ko' => 'URL',
        'nl' => 'URL\'s',
        'no' => 'URL-er',
        'pl' => 'Adresy URL',
        'ro' => 'URL-uri',
        'sv' => 'URL:er',
        'tr' => 'URL\'ler',
        'zh' => 'URL',
    ],
    'File Size' => [
        'id' => 'Ukuran File',
        'ja' => 'ファイルサイズ',
        'ko' => '파일 크기',
        'nl' => 'Bestandsgrootte',
        'no' => 'Filstørrelse',
        'pl' => 'Rozmiar pliku',
        'ro' => 'Dimensiune fișier',
        'sv' => 'Filstorlek',
        'tr' => 'Dosya Boyutu',
        'zh' => '文件大小',
    ],
    'Errors' => [
        'id' => 'Kesalahan',
        'ja' => 'エラー',
        'ko' => '오류',
        'nl' => 'Fouten',
        'no' => 'Feil',
        'pl' => 'Błędy',
        'ro' => 'Erori',
        'sv' => 'Fel',
        'tr' => 'Hatalar',
        'zh' => '错误',
    ],
    'Warnings' => [
        'id' => 'Peringatan',
        'ja' => '警告',
        'ko' => '경고',
        'nl' => 'Waarschuwingen',
        'no' => 'Advarsler',
        'pl' => 'Ostrzeżenia',
        'ro' => 'Avertismente',
        'sv' => 'Varningar',
        'tr' => 'Uyarılar',
        'zh' => '警告',
    ],
    'Sitemap URL' => [
        'id' => 'URL Sitemap',
        'ja' => 'サイトマップURL',
        'ko' => '사이트맵 URL',
        'nl' => 'Sitemap-URL',
        'no' => 'Sidekart-URL',
        'pl' => 'URL mapy witryny',
        'ro' => 'URL Sitemap',
        'sv' => 'Webbkarta-URL',
        'tr' => 'Site Haritası URL',
        'zh' => '站点地图URL',
    ],
    'Status' => [
        'id' => 'Status',
        'ja' => 'ステータス',
        'ko' => '상태',
        'nl' => 'Status',
        'no' => 'Status',
        'pl' => 'Status',
        'ro' => 'Stare',
        'sv' => 'Status',
        'tr' => 'Durum',
        'zh' => '状态',
    ],
    'URL' => [
        'id' => 'URL',
        'ja' => 'URL',
        'ko' => 'URL',
        'nl' => 'URL',
        'no' => 'URL',
        'pl' => 'URL',
        'ro' => 'URL',
        'sv' => 'URL',
        'tr' => 'URL',
        'zh' => 'URL',
    ],
    'Last Modified' => [
        'id' => 'Terakhir Diubah',
        'ja' => '最終更新日',
        'ko' => '최종 수정일',
        'nl' => 'Laatst gewijzigd',
        'no' => 'Sist endret',
        'pl' => 'Ostatnia modyfikacja',
        'ro' => 'Ultima modificare',
        'sv' => 'Senast ändrad',
        'tr' => 'Son Değiştirilme',
        'zh' => '最后修改',
    ],
    'Change Freq' => [
        'id' => 'Frekuensi Perubahan',
        'ja' => '更新頻度',
        'ko' => '변경 빈도',
        'nl' => 'Wijzigingsfrequentie',
        'no' => 'Endringsfrekvens',
        'pl' => 'Częstotliwość zmian',
        'ro' => 'Frecvența schimbării',
        'sv' => 'Ändringsfrekvens',
        'tr' => 'Değişim Sıklığı',
        'zh' => '更改频率',
    ],
    'Priority' => [
        'id' => 'Prioritas',
        'ja' => '優先度',
        'ko' => '우선 순위',
        'nl' => 'Prioriteit',
        'no' => 'Prioritet',
        'pl' => 'Priorytet',
        'ro' => 'Prioritate',
        'sv' => 'Prioritet',
        'tr' => 'Öncelik',
        'zh' => '优先级',
    ],
];

// ============================================
// Process all files
// ============================================
function flattenKeys($array, $prefix = '')
{
    $result = [];
    foreach ($array as $key => $value) {
        $fullKey = $prefix ? "$prefix.$key" : $key;
        if (is_array($value)) {
            $result = array_merge($result, flattenKeys($value, $fullKey));
        } else {
            $result[$fullKey] = $value;
        }
    }
    return $result;
}

function setNestedKey(&$array, $dotKey, $value)
{
    $keys = explode('.', $dotKey);
    $ref = &$array;
    for ($i = 0; $i < count($keys) - 1; $i++) {
        if (!isset($ref[$keys[$i]]) || !is_array($ref[$keys[$i]])) {
            $ref[$keys[$i]] = [];
        }
        $ref = &$ref[$keys[$i]];
    }
    $ref[end($keys)] = $value;
}

$totalFilesUpdated = 0;
$totalKeysTranslated = 0;
$untranslatedValues = [];

foreach ($targetLangs as $lang) {
    $langKeysAdded = 0;

    foreach ($categories as $category) {
        $enCatPath = "$langPath/en/tools/$category";
        $targetCatPath = "$langPath/$lang/tools/$category";

        if (!is_dir($enCatPath) || !is_dir($targetCatPath))
            continue;

        $files = glob("$enCatPath/*.json");
        foreach ($files as $enFile) {
            $slug = basename($enFile, '.json');
            $targetFile = "$targetCatPath/$slug.json";

            if (!file_exists($targetFile))
                continue;

            $enData = json_decode(file_get_contents($enFile), true) ?: [];
            $targetData = json_decode(file_get_contents($targetFile), true) ?: [];

            $enKeys = flattenKeys($enData);
            $targetKeys = flattenKeys($targetData);

            $missing = array_diff_key($enKeys, $targetKeys);

            if (empty($missing))
                continue;

            $keysAdded = 0;
            foreach ($missing as $dotKey => $enValue) {
                // Look up translation from dictionary
                if (isset($translations[$enValue][$lang])) {
                    $translatedValue = $translations[$enValue][$lang];
                } else {
                    // For tool-specific values not in dictionary, keep English value
                    // (the __tool() fallback already handles this, so adding it is harmless)
                    $translatedValue = $enValue;
                    $untranslatedValues[$enValue] = true;
                }

                setNestedKey($targetData, $dotKey, $translatedValue);
                $keysAdded++;
            }

            if ($keysAdded > 0) {
                file_put_contents($targetFile, json_encode($targetData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                $langKeysAdded += $keysAdded;
            }
        }
    }

    if ($langKeysAdded > 0) {
        echo "[$lang] $langKeysAdded keys added\n";
        $totalKeysTranslated += $langKeysAdded;
        $totalFilesUpdated++;
    }
}

echo "\n=== Summary ===\n";
echo "Languages processed: $totalFilesUpdated\n";
echo "Total keys added: $totalKeysTranslated\n";
echo "Unique values with dictionary translations: " . count($translations) . "\n";
echo "Values kept as English (no dictionary match): " . count($untranslatedValues) . "\n";

if (!empty($untranslatedValues)) {
    echo "\n=== Values Kept as English ===\n";
    foreach (array_keys($untranslatedValues) as $v) {
        $short = strlen($v) > 80 ? substr($v, 0, 80) . "..." : $v;
        echo "  \"$short\"\n";
    }
}
