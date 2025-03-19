<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VNPAY RESPONSE</title>
    <link href="/vnpay_php/assets/bootstrap.min.css" rel="stylesheet"/>
    <link href="/vnpay_php/assets/jumbotron-narrow.css" rel="stylesheet">         
    <script src="/vnpay_php/assets/jquery-1.11.3.min.js"></script>
</head>
<body>
    <?php
    // Đọc cấu hình
    $configPath = $_SERVER['DOCUMENT_ROOT'] . '/dinhky/config/default.php';
    if (file_exists($configPath)) {
        $config = require $configPath;
    } else {
        die("<div class='container'><h3 class='text-danger'>Lỗi: Không tìm thấy file cấu hình!</h3></div>");
    }

    // Lấy thông tin từ VNPAY
    $vnp_secure_hash = $_GET['vnp_secure_hash'] ?? ''; // Tránh lỗi "Undefined index"
    $inputData = [];

    foreach ($_GET as $key => $value) {
        if (strpos($key, "vnp_") === 0) {
            $inputData[$key] = $value;
        }
    }

    unset($inputData['vnp_secure_hash']); // Loại bỏ tham số chữ ký
    ksort($inputData);

   // Tạo chuỗi dữ liệu để hash (chỉ urlencode giá trị)
    $hashData = "";
    foreach ($inputData as $key => $value) {
        $hashData .= $key . "=" . urlencode($value) . "&";
    }
    $hashData = rtrim($hashData, "&"); // Loại bỏ dấu & cuối cùng
    
    $secureHash = hash_hmac('sha512', $hashData, $config['vnp_hash_secret']);

    echo "<pre>";
    print_r($vnp_secure_hash . PHP_EOL);
    print_r($hashData . PHP_EOL);
    print_r($secureHash . PHP_EOL);
    print_r($config['vnp_hash_secret'] . PHP_EOL);
    echo "</pre>";
    // Lấy các tham số từ request
    $txnRef = htmlspecialchars($_GET['vnp_txn_ref'] ?? '');
    $amount = htmlspecialchars($_GET['vnp_amount'] ?? '');
    $orderInfo = htmlspecialchars($_GET['vnp_order_info'] ?? '');
    $responseCode = htmlspecialchars($_GET['vnp_response_code'] ?? '');
    $transactionNo = htmlspecialchars($_GET['vnp_transaction_no'] ?? '');
    $bankCode = htmlspecialchars($_GET['vnp_bank_code'] ?? '');
    $payDate = htmlspecialchars($_GET['vnp_pay_date'] ?? '');
    ?>
    
    <!-- Begin display -->
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY RESPONSE</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng:</label>
                <label><?php echo $txnRef; ?></label>
            </div>    
            <div class="form-group">
                <label>Số tiền:</label>
                <label><?php echo number_format((int)$amount / 100, 2) . " VND"; ?></label>
                <!-- Chia 100 vì VNPAY trả về số tiền theo đơn vị VNĐ * 100 -->
            </div>  
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label><?php echo $orderInfo; ?></label>
            </div> 
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode):</label>
                <label><?php echo $responseCode; ?></label>
            </div> 
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>
                <label><?php echo $transactionNo; ?></label>
            </div> 
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label><?php echo $bankCode; ?></label>
            </div> 
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label><?php echo $payDate; ?></label>
            </div> 
            <div class="form-group">
                <label>Kết quả:</label>
                <label>
                    <?php
                    if ($secureHash === $vnp_secure_hash) {
                        if ($responseCode === '00') {
                            echo "<span style='color:blue'>Giao dịch thành công</span>";
                        } else {
                            echo "<span style='color:red'>Giao dịch không thành công</span>";
                        }
                    } else {
                        echo "<span style='color:red'>Chữ ký không hợp lệ</span>";
                    }
                    ?>
                </label>
            </div> 
        </div>
        <p>&nbsp;</p>
        <footer class="footer">
            <p>&copy; VNPAY <?php echo date('Y'); ?></p>
        </footer>
    </div>  
</body>
</html>
