<?php
error_reporting(E_ALL & E_NOTICE & E_DEPRECATED);

$vnp_Amount = $_POST["amount"];
$vnp_BankCode = $_POST["bank"];
$vnp_Command = $_POST["command"];
$vnp_CreateDate = $_POST["createDate"];
$vnp_CurrCode = $_POST["curr"];
$vnp_ExpireDate = $_POST["exp"];
$vnp_IpAddr = $_POST["ip"];
$vnp_Locale = $_POST["locale"];
$vnp_OrderInfo = $_POST["info"];
$vnp_OrderType = $_POST["type"];
$vnp_ReturnUrl = $_POST["return"];
$vnp_TmnCode = $_POST["tmn"];
$vnp_TxnRef = $_POST["txn"];
$vnp_Version = $_POST["version"];

$inputData = array(
    "vnp_Version" => $vnp_Version,
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => $vnp_Command,
    "vnp_CreateDate" => $vnp_CreateDate,
    "vnp_CurrCode" => $vnp_CurrCode,
    "vnp_ExpireDate" => $vnp_ExpireDate,
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_ReturnUrl,
    "vnp_TxnRef" => $vnp_TxnRef,
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}

ksort($inputData);
$i = 0;
$hashdata = "";

if ($vnp_Version == "2.1.0") {

    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
        } else {
            $hashdata .= urlencode($key) . "=" . urlencode($value);
            $i = 1;
        }
    }

}

//----------------------------------------------------------------------

else if ($vnp_Version == "2.0.0") {

    foreach ($inputData as $key => $value) {
        if ($i == 1) {
            $hashdata .= '&' . ($key) . "=" . ($value);
        } else {
            $hashdata .= ($key) . "=" . ($value);
            $i = 1;
        }
    }

}

?>