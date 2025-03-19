<?php
require_once 'OrderController.php';
require_once 'AuthController.php';

use Controllers\OrderController;

header('Content-Type: application/json'); // Định dạng JSON cho response

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Nhận JSON từ request
        $data = json_decode(file_get_contents("php://input"), true);
        
        // Debug dữ liệu nhận được
		file_put_contents("debug.log", print_r($data, true));

		if (!$data || !isset($data['Amount'], $data['recurringFrequencyNumber'], $data['recurringFrequency'], $data['language'], $data['command'])) {
			echo json_encode(["error" => "Dữ liệu không hợp lệ.", "received" => $data]);
			exit;
		}

        // Gán giá trị từ request
        $amount = $data['Amount'];
        $frequencyNumber = $data['recurringFrequencyNumber'];
        $frequency = $data['recurringFrequency'];
        $language = $data['language'];
        $command = $data['command'];

        // Gọi OrderController để tạo thanh toán
        $orderController = new OrderController();
        $response = $orderController->initPayment($command, $amount, $frequencyNumber, $frequency, $language);

        // Kiểm tra nếu response hợp lệ
        if (isset($response['ispTxnId'], $response['dataKey'], $response['tmnCode'])) {
            echo json_encode([
                "ispTxnId" => $response['ispTxnId'],
                "dataKey" => $response['dataKey'],
                "tmnCode" => $response['tmnCode'],
            ]);
        } else {
            echo json_encode(["error" => "Không thể tạo thanh toán."]);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => "Lỗi: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Phương thức không hợp lệ."]);
}

?>
