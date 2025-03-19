<?php
namespace Controllers;

use DateTime;
use DateTimeZone;

class OrderController {
    private $config;
    private $authController;

    public function __construct() {
        $configPath = realpath($_SERVER['DOCUMENT_ROOT'] . '/dinhky/config/default.php');
        if ($configPath) {
            $this->config = require $configPath;
        } else {
            die("Lỗi: Không tìm thấy file cấu hình!");
        }
        $this->authController = new AuthController();
    }

    public function initPayment($command, $recurringAmount, $recurringFrequencyNumber, $recurringFrequency, $language) {
        try {
			if (empty($this->config)) {
				die("Lỗi: Cấu hình rỗng!");
			}
            $authToken = $this->authController->getAuthToken();
			$reqId = generateRandomNumber(15);
            $orderReference = generateRandomNumber(10);
            $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
            $mcDate = (new DateTime('now', $timezone))->format('YmdHis');
            $recurringDate = (new DateTime('now', $timezone))->format('Ymd');

            $payload = [
					'tmnCode' => $this->config['tmn_code'],
					'reqId' => $reqId,
					'order' => [
						'orderReference' => $orderReference,
						'orderInfo' => 'Test',
						'orderType' => 'baohiem'
					],
					'app' => ['userId' => 'Pham Van Tu'],
					'transaction' => [
						'recurringAmount' => $recurringAmount,
						'recurringFrequencyNumber' => $recurringFrequencyNumber,
						'recurringFrequency' => $recurringFrequency,
						'recurringNumber' => '0',
						'recurringDate' => $recurringDate,
						'recurringStartDate' => $recurringDate,
						'recurringEndDate' => $recurringDate,
						'amount' => 0,
						'currCode' => 'VND',
						'returnUrl' => $this->config['returnUrl'],
						'cancelUrl' => $this->config['cancelUrl'],
						'mcDate' => $mcDate
					],
					'customerInfo' => [
						'forename' => 'A',
						'surname' => 'NGUYEN VAN'
					],
					'ipAddr' => '192.168.22.88',
					'command' => $command,
					'userAgent' => 'Firefox',
					'addData' => 'Thong tin bo sung',
					'version' => '2.1.0',
					'locale' => $language,
					'secureHash' => hash_hmac('sha512', implode('|', [
						$reqId,
						$command,
						$orderReference,
						'Test',
						'baohiem',
						$this->config['tmn_code'],
						$recurringAmount,
						$recurringFrequencyNumber,
						$recurringFrequency,
						'0',
						$recurringDate,
						$recurringDate,
						$recurringDate,
						0,
						'VND',
						'Thong tin bo sung',
						'Pham Van Tu',
						'A',
						'NGUYEN VAN',
						'192.168.22.88',
						'Firefox',
						$this->config['returnUrl'],
						$this->config['cancelUrl'],
						'2.1.0',
						$language,
						$mcDate
					]), $this->config['vnp_hash_secret'])
				];

			/*echo "<pre>";
			print_r($payload);
			echo "</pre>";*/
            $ch = curl_init($this->config['vnp_url_recurring_payment_execute']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Authorization: ' . $authToken
            ]);
            
            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }

            curl_close($ch);

            $data = json_decode($response, true);
            if (!isset($data['transaction']['id']) || !isset($data['dataKey'])) {
                throw new \Exception('Invalid response format');
            }

            return ['ispTxnId' => $data['transaction']['id'], 'dataKey' => $data['dataKey'], 'tmnCode' => $this->config['tmn_code']];
        } catch (\Exception $e) {
            error_log('Error initializing payment: ' . $e->getMessage());
            throw $e;
        }
    }
}


function generateRandomNumber($length = 10) {
    $randomNumber = '';
    for ($i = 0; $i < $length; $i++) {
        $randomNumber .= rand(0, 9);
    }
    return $randomNumber;
}
