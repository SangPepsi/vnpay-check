<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Check URL</title>
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

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: space-between;
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
            max-height: 200px; /* giới hạn chiều cao */
            overflow-y: auto; /* thêm thanh cuốn dọc */
            white-space: pre-wrap; /* Đảm bảo xuống dòng khi quá dài */
            word-wrap: break-word; /* Bẻ dòng cho cả từ dài */
            text-align: left; /* Căn trái nội dung */
            font-family: 'Courier New', Courier, monospace; /* Font code cho dễ nhìn */
            text-align: left;
        }
        .result-container {
            margin-top: 20px;
            padding: 15px;
            background-color: #f0f4f8;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            word-wrap: break-word;
            white-space: normal;
        }

        .result-container h3 {
            color: #4A90E2;
            font-size: 1.5em;
            margin-bottom: 10px;
            border-bottom: 2px solid #4A90E2;
            padding-bottom: 5px;
        }

        .result-line {
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .result-line span {
            font-weight: bold;
            color: #333;
        }

        .success {
            color: #28a745;
        }

        .error {
            color: #dc3545;
        }


    </style>
</head>

<body>
<div class="container">
    <h2>Check URL</h2>
    <form action="handling.php" method="post">
        <div class="form-group">
            <label for="url">URL Thanh Toán:</label>
            <input type="text" id="url" name="url" placeholder="Nhập URL..." required>
        </div>

        <div class="form-group">
            <label for="secretKey">Secret Key:</label>
            <input type="text" id="secretKey" name="secretKey" placeholder="Nhập Secret Key..." required>
        </div>

        <div class="form-group">
            <label for="version">Chọn phiên bản:</label>
            <select id="version" name="version">
                <option value="2.1.0">2.1.0</option>
                <option value="2.0.0">2.0.0</option>
            </select>
        </div>

        <button type="submit">Kiểm tra</button>
        <button type="button" onclick="window.location.href='http://localhost:8888/vnpay-check'">Quay lại trang chủ</button>

    </form>

    <div id="result"></div>
</div>
<script>
    document.querySelector('form').onsubmit = async (e) => {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, { method: 'POST', body: formData });
            const result = await response.json();

            const resultContainer = document.getElementById('result');
            const statusClass = result.valid ? 'success' : 'error';
            const statusText = result.valid ? '✅ Hợp lệ' : '❌ Không hợp lệ';

            resultContainer.innerHTML = `
            <div class="result-container">
                <h3>Kết quả kiểm tra</h3>
                <div class="result-line"><span>Kết quả:</span> <span class="${statusClass}">${statusText}</span></div>
                <div class="result-line"><span>Generated Hash:</span> ${result.generatedHash}</div>
                <div class="result-line"><span>Received Hash:</span> ${result.receivedHash}</div>
            </div>
        `;
        } catch (error) {
            console.error('Lỗi xử lý:', error);
            document.getElementById('result').innerHTML = '<div class="error">❌ Lỗi khi kiểm tra URL!</div>';
        }
    };


</script>


</body>
</html>
