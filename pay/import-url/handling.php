<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

$vnp_SecretKey = $_GET['vnp_SecretKey'] ?? '';
$vnp_UrlRequest = $_GET['vnp_UrlRequest'] ?? '';
$vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
$vnp_Version = $_GET['vnp_Version'] ?? '';

$inputData = [];
foreach ($_GET as $key => $value) {
    if (strpos($key, 'vnp_') === 0 && !in_array($key, ['vnp_SecretKey', 'vnp_UrlRequest', 'vnp_SecureHash', 'vnp_SecureHashType', 'vnp_secure_hash_type', 'vnp_secure_hash'])) {
        $inputData[$key] = $value;
    }
}

ksort($inputData);
$hashData = urldecode(http_build_query($inputData));

// Xử lý hash dựa trên version
if ($vnp_Version === "2.1.0") {
    $secureHash = hash_hmac('sha512', $hashData, $vnp_SecretKey);
} elseif ($vnp_Version === "2.0.0") {
    $secureHash = hash('sha256', $vnp_SecretKey . $hashData);
} else {
    die("Phiên bản không hợp lệ!");
}

$vnp_UrlPay = $vnp_UrlRequest . '?' . http_build_query($inputData) . '&vnp_SecureHash=' . $secureHash;

// Hiển thị thông tin
function renderOutput($title, $content) {
    echo "<div class='highlight'><pre><code class='language-html' data-lang='html'><strong>$title</strong>:<br>$content</code></pre></div>";
}

renderOutput('Parameters Decode', urldecode(http_build_query($inputData, '', '<br>')));
renderOutput('Kết quả kiểm tra so sánh checksum', $vnp_SecureHash === $secureHash ? '✅ Trùng khớp' : '❌ Không khớp');
renderOutput('Hash Data', $hashData);
renderOutput('Full URL', $vnp_UrlPay);
?>
