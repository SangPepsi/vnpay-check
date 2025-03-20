<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tạo url</title>

    <!-- Bootstrap core CSS -->
    <link href="/vnpay-check/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="/vnpay-check/assets/css/styles.css" rel="stylesheet" />
    <script src="/vnpay-check/assets/jquery-1.11.3.min.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            margin-top: 20px;
            color: #090a0a;
            font-size: 1.8em;
            text-transform: uppercase;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }
        #result {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            white-space: pre-wrap; /* Xuống dòng khi hết chiều rộng */
            word-break: break-word; /* Bẻ dòng nếu gặp chuỗi quá dài */
            text-align: left; /* Căn trái cho dễ nhìn */
            font-family: 'Courier New', Courier, monospace; /* Font nhìn kiểu code cho gọn */
            line-height: 1.4; /* Tăng khoảng cách giữa các dòng cho thoáng */
        }

        .form-row {
            display: flex;
            flex-direction: column;
            gap: 15px;
            justify-content: center;
            align-items: stretch;
        }
        .col-md-12.mb-3 {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .col-md-12.mb-3 label {
            width: 30%;
            font-weight: bold;
            text-align: left;
        }

        .col-md-12.mb-3 input,
        .col-md-12.mb-3 select {
            width: 70%;
            height: 40px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group {
            flex: 1;
            min-width: calc(50% - 10px);
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Căn label về đầu dòng */
            gap: 5px; /* Tạo khoảng cách nhỏ giữa label và input */
        }

        button {
            background-color: #367cd1;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease;
            margin: 10px 5px;
        }

        button:hover {
            background-color: #357ABD;
            transform: scale(1.05);
        }
        input, select {
            width: 100%; /* Đảm bảo input ô nào cũng chiếm đủ độ rộng */
            height: 40px;
            line-height: 40px;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        label {
            font-weight: bold;
            margin-bottom: 3px;
            color: #333;
            text-align: left; /* Đảm bảo text label căn trái */
        }
        .highlight {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            max-height: 200px; /* Giới hạn chiều cao */
            overflow-y: auto; /* Thêm thanh cuộn dọc */
            white-space: pre-wrap; /* Đảm bảo xuống dòng khi quá dài */
            word-break: break-word; /* Bẻ dòng khi cần */
            text-align: left; /* Căn trái nội dung */
        }

    </style>
</head>

<body>
<div class="container">

    <h1>Nhập chỗi data</h1>
    <form class="needs-validation" method="post" novalidate>
        <div class="form-row">

            <div class="col-md-12 mb-3">
                <label for="validationCustom">Hash data:</label>
                <input type="text" name="hash" class="form-control" id="validationCustom" placeholder="Data" required>
            </div>

            <div class="col-md-12 mb-3">
                <label for="validationCustom">Secret key:</label>
                <input type="text" name="key" class="form-control" id="validationCustom" placeholder="Key" required>
            </div>

            <div class="col-md-12 mb-3">
                <label for="validationCustom">Thuật toán:</label>
                <label for="inputState"></label> <select name="check" id="inputState" class="form-control">
                    <option value="sha512" selected>HMACSHA512</option>
                    <option value="sha256">SHA256</option>
                </select>
            </div>

        </div>
        <button class="btn btn-light" type="submit" value="Submit">Submit form</button>
        <button type="button" onclick="window.location.href='http://localhost:8888/vnpay-check'">Quay lại trang chủ</button>

    </form>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>

    <hr>
<?php
require_once ("./controls.php");
if (empty($secureHash)) {
} else {
    echo"
<label for='secureHash'>Secure hash</label>
<div class='highlight'>
<pre>
<code class='language-html' data-lang='html'>$secureHash<br>
$fullUrl
</code>
</pre>
</div>";
}
?>
</div>
</body>

</html>
