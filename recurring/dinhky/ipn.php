<?php
/* Payment Notify
 * IPN URL: Ghi nhận kết quả thanh toán từ VNPAY
 * Các bước thực hiện:
 * Kiểm tra checksum 
 * Tìm giao dịch trong database
 * Kiểm tra số tiền giữa hai hệ thống
 * Kiểm tra tình trạng của giao dịch trước khi cập nhật
 * Cập nhật kết quả vào Database
 * Trả kết quả ghi nhận lại cho VNPAY
 */

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
$responseCode = htmlspecialchars($_GET['vnp_response_code'] ?? '');


$Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
$orderId = $inputData['vnp_txn_ref'];

try {
     
    //Kiểm tra checksum của dữ liệu
    if ($secureHash == $vnp_secure_hash) {
        
            if ($inputData['vnp_response_code'] == '00' && $inputData['vnp_transaction_status'] == '00') {
                        $Status = 1; // Trạng thái thanh toán thành công
            } else {
                        $Status = 2; // Trạng thái thanh toán thất bại / lỗi
            }                   
             $returnData['RspCode'] = '00';
             $returnData['Message'] = 'Confirm Success';
               
            
    } else {
        $returnData['RspCode'] = '97';
        $returnData['Message'] = 'Invalid signature';
    }
} catch (Exception $e) {
    $returnData['RspCode'] = '99';
    $returnData['Message'] = 'Unknow error';
}
//Trả lại VNPAY theo định dạng JSON
echo json_encode($returnData);
