<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
  
$vnp_TmnCode = "PF2UQWSU"; //Website ID in VNPAY System
$vnp_HashSecret = "T68N8N2567G7YB79YM8ZLW3VAUG4GK1L"; //Secret key
$vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
// $vnp_Returnurl = "https://sieuhoc.com/return_redirect_app_vnpay_payment";
$vnp_Returnurl = "https://demo.dalieu.vn/payment-finish.html/";
$vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
//Config input format
//Expire
$startTime = date("YmdHis");
$expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

// $vnp_tmn_code = "STMPTEST";
// $vnp_secure_hash = "T41NMBE86O5OXVSCL89JW8LSJYUZ1UCG";
// $vnp_Url = "https://sandbox.vnpayment.vn/token_ui/create-token.html";
// $vnp_Returnurl = "http://localhost:1111/vnpay_php/vnpay_return.php";
// $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
// //Config input format
// //Expire
// $startTime = date("YmdHis");
// $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
