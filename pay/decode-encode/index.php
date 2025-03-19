<?php
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $input = $_POST['input'];
    $result = '';

    if ($action == 'encode') {
        $result = base64_encode($input);
    } elseif ($action == 'decode') {
        $result = base64_decode($input);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
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

        #result {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-top: 10px;
            white-space: pre-wrap;
            word-break: break-word;
            text-align: left;
            font-family: 'Courier New', Courier, monospace;
            line-height: 1.4;
            font-size: 1.2em;
            height: 300px; /* Tăng chiều cao ô kết quả */
            overflow-y: auto;
        }

        textarea {
            width: 100%;
            height: 200px; /* Tăng chiều cao ô nhập liệu */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1.2em;
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

        label {
            font-weight: bold;
            margin-bottom: 3px;
            color: #333;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Decode & Encode</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="input" class="form-label">Nhập dữ liệu:</label>
            <textarea name="input" class="form-control" rows="4" required><?php echo isset($input) ? htmlspecialchars($input) : ''; ?></textarea>
        </div>
        <div class="d-flex justify-content-center gap-2 mb-3">
            <button type="submit" name="action" value="encode" class="btn btn-primary">Encode</button>
            <button type="submit" name="action" value="decode" class="btn btn-success">Decode</button>
        </div>
    </form>

    <?php if (isset($result)): ?>
        <div id="result" class="alert alert-info text-center" role="alert">
            <strong>Kết quả: </strong><br><?php echo htmlspecialchars($result); ?>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a class="btn btn-secondary" href="/vnpay-check/" role="button">Quay lại</a>
    </div>
</div>
</body>
</html>