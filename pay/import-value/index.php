<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>VNPAY CHECK</title>

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
            color: #4A90E2;
            font-size: 2.8em;
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

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between;
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
            background-color: #4A90E2;
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

    <h1>Nhập giá trị</h1>

    <form class="needs-validation" method="post" novalidate>
        <div class="form-row">
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" name="amount" class="form-control" id="amount" placeholder="Số tiền" required>
            </div>

            <div class="form-group">
                <label for="bank">BankCode:</label>
                <select name="bank" id="bank" class="form-control">
                    <option value="" selected></option>
                    <option value="NCB">NCB</option>
                </select>
            </div>

            <div class="form-group">
                <label for="command">Command:</label>
                <select name="command" id="command" class="form-control">
                    <option value="pay" selected>pay</option>
                </select>
            </div>

            <div class="form-group">
                <label for="createDate">CreateDate:</label>
                <input type="text" name="createDate" class="form-control" id="createDate" placeholder="Thời gian" required>
            </div>

            <div class="form-group">
                <label for="curr">CurrCode:</label>
                <select name="curr" id="curr" class="form-control">
                    <option value="VND" selected>VND</option>
                </select>
            </div>
            <div class="form-group">
                <label for="expireDate">ExpireDate:</label>
                <input type="text" name="exp" class="form-control" id="exp" placeholder="Thời gian hết hạn" required>
            </div>
            <div class="form-group">
                <label for="ip">IpAddr:</label>
                <input type="text" name="ip" class="form-control" id="ip" placeholder="Địa chỉ IP" required>
            </div>

            <div class="form-group">
                <label for="locale">Locale:</label>
                <select name="locale" id="locale" class="form-control">
                    <option value="vn" selected>vn</option>
                    <option value="en">en</option>
                </select>
            </div>

            <div class="form-group">
                <label for="info">OrderInfo:</label>
                <input type="text" name="info" class="form-control" id="info" placeholder="Nội dung thanh toán" required>
            </div>

            <div class="form-group">
                <label for="type">OrderType:</label>
                <input type="text" name="type" class="form-control" id="type" placeholder="Mã danh mục hàng hoá" required>
            </div>

            <div class="form-group">
                <label for="return">ReturnUrl:</label>
                <input type="text" name="return" class="form-control" id="return" placeholder="URL thông báo kết quả" required>
            </div>

            <div class="form-group">
                <label for="tmn">TmnCode:</label>
                <input type="text" name="tmn" class="form-control" id="tmn" placeholder="Mã website" required>
            </div>

            <div class="form-group">
                <label for="txn">TxnRef:</label>
                <input type="text" name="txn" class="form-control" id="txn" placeholder="Mã tham chiếu giao dịch" required>
            </div>

            <div class="form-group">
                <label for="version">Version:</label>
                <select name="version" id="version" class="form-control">
                    <option value="2.1.0" selected>2.1.0</option>
                    <option value="2.0.0">2.0.0</option>
                </select>
            </div>
        </div>

        <button class="btn btn-light btn-block" type="submit">Submit Form</button>

        <button type="button" onclick="window.location.href='http://localhost:8888/vnpay-check'">Quay lại trang chủ</button>
    </form>

    <hr>
    <?php
    require_once("./controls.php");
    if (!empty($hashdata)) {
        echo "<label for='hashdata'>Hash data</label>
                <div class='highlight'>
                    <pre><code class='language-html' data-lang='html'>$hashdata</code></pre>
                </div>";
    }
    ?>

</div>
</body>

</html>