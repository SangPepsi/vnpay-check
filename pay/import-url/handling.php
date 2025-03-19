<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $url = $_POST['url'];
    $secretKey = $_POST['secretKey'];
    $version = $_POST['version'];

    // Parse URL và tách query string
    $urlParts = parse_url($url);
    parse_str($urlParts['query'], $params);

    // Lấy và xóa secure hash từ params
    $receivedHash = $params['vnp_SecureHash'];
    unset($params['vnp_SecureHash']);
    unset($params['vnp_SecureHashType']);

    // Sắp xếp tham số theo key
    ksort($params);
    $queryString = urldecode(http_build_query($params));

    // Tạo hash dựa trên version
    if ($version === '2.1.0') {
        $secureHash = hash_hmac('sha512', $queryString, $secretKey);
    } elseif ($version === '2.0.0') {
        $secureHash = hash('sha256', $secretKey . $queryString);
    } else {
        echo 'Phiên bản không hợp lệ';
        exit;
    }

    // So sánh hash
    $isValid = strtoupper($secureHash) === strtoupper($receivedHash);

    echo json_encode(["valid" => $isValid, "generatedHash" => $secureHash, "receivedHash" => $receivedHash]);
} else {
    echo 'Phương thức không hợp lệ!';
}
?>