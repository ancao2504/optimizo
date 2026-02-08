<?php
function uploadFile($filePath, $filename)
{
    global $username, $password;
    $url = "https://optimizo.io/api/media";
    $cfile = new CURLFile($filePath, 'image/png', $filename);
    $data = ['file' => $cfile];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");

    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode >= 200 && $httpCode < 300) {
        $json = json_decode($result, true);
        if ($json['success'] ?? false) {
            return $json['data']['url'];
        }
    }
    return false;
}

$username = "4wellsolutions@gmail.com";
$password = "P@kistan123";
$artifactsDir = 'C:\Users\Ahmad\.gemini\antigravity\brain\34ce9a22-3a0e-4fee-8b95-73f75218a7c3';

// Map logical names to actual filenames in artifacts dir
$imagesToUpload = [
    'featured_image' => 'featured_image_1770575350399.png',
    'color_contrast_check' => 'color_contrast_check_1770575366696.png',
    'using_image_color_picker' => 'using_image_color_picker_1770575380262.png'
];

$results = [];

foreach ($imagesToUpload as $key => $filename) {
    $fullPath = $artifactsDir . '\\' . $filename;
    if (file_exists($fullPath)) {
        $url = uploadFile($fullPath, $filename);
        if ($url) {
            $results[$key] = $url;
        } else {
            echo "Failed to upload $filename\n";
        }
    } else {
        echo "File not found: $fullPath\n";
    }
}

// Output JSON for easy parsing by the next step
echo json_encode($results);
?>