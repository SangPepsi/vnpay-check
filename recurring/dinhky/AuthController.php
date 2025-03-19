<?php
namespace Controllers;

class AuthController {
    private $config;

    public function __construct() {
       $configPath = realpath($_SERVER['DOCUMENT_ROOT'] . '/dinhky/config/default.php');
        if ($configPath) {
            $this->config = require $configPath;

            // Kiểm tra xem $this->config có dữ liệu không
            if (!is_array($this->config)) {
                die("Lỗi: Cấu hình không hợp lệ! Hãy kiểm tra file default.php");
            }
        } else {
            die("Lỗi: Không tìm thấy file cấu hình! Đường dẫn: " . __DIR__ . '/../config/default.php');
        }
    }

    public function getAuthToken() {
        try {
            if (!isset($this->config['vnp_url_authen'])) {
                throw new \Exception("Lỗi: URL xác thực không tồn tại trong cấu hình!");
            }

            $url = $this->config['vnp_url_authen'];

            // Dữ liệu gửi đi
            $postData = json_encode([
                'clientId' => $this->config['clientId'] ?? '',
                'username' => $this->config['username'] ?? '',
                'password' => $this->config['password'] ?? '',
                'clientSecret' => $this->config['clientSecret'] ?? ''
            ]);

            // Khởi tạo cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);

            // Thực thi request
            $response = curl_exec($ch);

            // Kiểm tra lỗi cURL
            if (curl_errno($ch)) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }

            curl_close($ch);

            // Chuyển đổi dữ liệu JSON nhận được
            $data = json_decode($response, true);

            // Debug phản hồi từ API
            if ($data === null) {
                throw new \Exception('Lỗi: API trả về JSON không hợp lệ! Response: ' . $response);
            }

            if (!isset($data['data']['tokenType']) || !isset($data['data']['accessToken'])) {
                throw new \Exception('Lỗi: Phản hồi từ API không chứa token!');
            }

            $tokenType = $data['data']['tokenType'];
            $accessToken = $data['data']['accessToken'];

            return $tokenType . ' ' . $accessToken;
        } catch (\Exception $e) {
            error_log('Error fetching auth token: ' . $e->getMessage());
            throw $e;
        }
    }
}

/* Tạo đối tượng AuthController và lấy token
try {
    $AuthController = new AuthController(); // Không cần truyền tham số
    $authToken = $AuthController->getAuthToken();
    echo "Auth Token: " . $authToken;
} catch (\Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}*/
?>
