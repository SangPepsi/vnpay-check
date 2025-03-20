<?php
if (isset($_POST['check'])) {
    $ipn_url = trim($_POST['ipn_url']);
    $hashData1 = trim($_POST['hash_data1']);
    $txnRef = trim($_POST['txn_ref']);
    $hashSecret = trim($_POST['hash_secret']);

    // Lấy phần đầu IPN URL
    $baseUrl = strtok($ipn_url, '?');

    // Case 1: Giao dịch thất bại
    $hashData = str_replace("vnp_ResponseCode=00", "vnp_ResponseCode=99", $hashData1);
    $hashData = str_replace("vnp_TransactionStatus=00", "vnp_TransactionStatus=99", $hashData);
    $vnp_SecureHash = hash_hmac('sha512', $hashData, $hashSecret);
    $case1_url = "$baseUrl?$hashData&vnp_SecureHash=$vnp_SecureHash";
    $result = file_get_contents($case1_url);
    $expectedResult = json_encode(["RspCode" => "00", "Message" => "Confirm Success"]);
    $isPassed = strpos($result, '"RspCode":"00"') !== false ? "Đạt" : "Không Đạt";

    // Case 2: Không tìm thấy giao dịch confirm
    $randomTxnRef = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
    $hashData2 = str_replace($txnRef, $randomTxnRef, $hashData1);
    $vnp_SecureHash2 = hash_hmac('sha512', $hashData2, $hashSecret);
    $case2_url = "$baseUrl?$hashData2&vnp_SecureHash=$vnp_SecureHash2";
    $result2 = file_get_contents($case2_url);
    $expectedResult2 = json_encode(["RspCode" => "01", "Message" => "Order Not Found"]);
    $isPassed2 = strpos($result2, '"RspCode":"01"') !== false ? "Đạt" : "Không Đạt";

    // Case 3: Giao dịch đã confirm (gọi lại IPN của case 1)
    $result3 = file_get_contents($case1_url);
    $expectedResult3 = json_encode(["RspCode" => "02", "Message" => "Order already confirmed"]);
    $isPassed3 = strpos($result3, '"RspCode":"02"') !== false ? "Đạt" : "Không Đạt";

    // Case 4: Số tiền không hợp lệ
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tool Check IPN</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        input { width: 100%; padding: 10px; margin: 5px 0; }
        button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .result-box { width: 100%; height: 150px; overflow: auto; border: 1px solid #ddd; padding: 10px; background: #f9f9f9; }
    </style>
</head>
<body>
<h2>Tool Kiểm Tra IPN</h2>
<form method="post">
    <label>Nhập đầu IPN:</label>
    <input type="text" name="ipn_url" required>

    <label>Nhập giá trị hashData1:</label>
    <input type="text" name="hash_data1" required>

    <label>Nhập mã giao dịch (vnp_TxnRef):</label>
    <input type="text" name="txn_ref" required>

    <label>Nhập giá trị vnp_HashSecret:</label>
    <input type="text" name="hash_secret" required>

    <button type="submit" name="check">Kiểm tra</button>
    <button type="reset">Quay lại</button>
</form>

<?php if (isset($result)): ?>
    <h3>Kết quả kiểm tra</h3>
    <p><strong>Case 1: Giao dịch thất bại</strong></p>
    <div class="result-box">
        <p><strong>IPN URL:</strong> <?= htmlspecialchars($case1_url) ?></p>
        <p><strong>Giá trị mong muốn:</strong> <?= $expectedResult ?></p>
        <p><strong>Giá trị nhận được:</strong> <?= htmlspecialchars($result) ?></p>
        <p><strong>Đánh giá:</strong> <?= $isPassed ?></p>
    </div>

    <p><strong>Case 2: Không tìm thấy giao dịch confirm</strong></p>
    <div class="result-box">
        <p><strong>IPN URL:</strong> <?= htmlspecialchars($case2_url) ?></p>
        <p><strong>Giá trị mong muốn:</strong> <?= $expectedResult2 ?></p>
        <p><strong>Giá trị nhận được:</strong> <?= htmlspecialchars($result2) ?></p>
        <p><strong>Đánh giá:</strong> <?= $isPassed2 ?></p>
    </div>

    <p><strong>Case 3: Giao dịch đã confirm</strong></p>
    <div class="result-box">
        <p><strong>IPN URL:</strong> <?= htmlspecialchars($case1_url) ?></p>
        <p><strong>Giá trị mong muốn:</strong> <?= $expectedResult3 ?></p>
        <p><strong>Giá trị nhận được:</strong> <?= htmlspecialchars($result3) ?></p>
        <p><strong>Đánh giá:</strong> <?= $isPassed3 ?></p>
    </div>
<?php endif; ?>
</body>
</html>
