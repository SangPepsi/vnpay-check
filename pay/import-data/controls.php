<?php
error_reporting(E_ALL & E_NOTICE & E_DEPRECATED);

$hash = $_POST["hash"];
$key = $_POST["key"];
$check = $_POST["check"];
$url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";

if ($check == "sha512") {
    $secureHash = hash_hmac('sha512', $hash, $key);
} else if ($check == "sha256") {
    $secureHash = hash('sha256',$key . $hash);
}

$fullUrl = $url . "?" . $hash . "&vnp_SecureHash=" . $secureHash;

?>