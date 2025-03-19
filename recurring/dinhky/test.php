<?php
require_once 'OrderController.php';
require_once 'AuthController.php';

use Controllers\OrderController;

try {
    $orderController = new OrderController();
    $response = $orderController->initPayment(
        "recurring",       // Command
        500000,      // Số tiền thanh toán định kỳ (VND)
        1,           // Số lần thanh toán định kỳ
        "month",     // Chu kỳ thanh toán (ngày/tháng/năm)
        "vi"         // Ngôn ngữ giao diện
    );

    echo "<pre>";
    print_r($response);
    echo "</pre>";
} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
?>
