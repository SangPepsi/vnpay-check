<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kiểm tra URL</title>

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
            align-items: flex-start;
            gap: 5px;
        }

        button {
            background-color: #4A90E2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px 5px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }

        button:hover {
            background-color: #357ABD;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        input,
        select {
            width: 100%;
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
            text-align: left;
        }

        .highlight {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            max-height: 200px;
            overflow-y: auto;
            white-space: pre-wrap;
            word-break: break-word;
            text-align: left;
        }
    </style>
</head>

<body>
<div class="container">

    <h1>Kiểm tra url</h1>
    <form class="needs-validation" method="post" novalidate>
        <div class="form-row">

            <div class="col-md-12 mb-3">
                <label for="url">Full URL:</label>
                <input type="text" name="url" class="form-control" id="url" placeholder="Enter URL" required>
            </div>

            <div class="col-md-12 mb-3">
                <label for="key">Secret key:</label>
                <input type="text" name="key" class="form-control" id="key" placeholder="Enter Key" required>
            </div>

            <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                <button type="submit" name="redirect" id="redirect" class="btn btn-light">Redirect</button>
                <button type="button" onclick="window.location.href='http://localhost:8888/vnpay-check'">Quay lại trang chủ</button>
            </div>
        </div>
    </form>

    <script>
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', () => {
                const url = document.querySelector('#url').value.trim();
                const key = document.querySelector('#key').value.trim();
                const submitBtn = document.querySelector('#submitBtn');
                submitBtn.disabled = !(url && key);
            });
        });
    </script>

    <hr>

    <?php
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    $redirect = "http://localhost:8888/vnpay-check/pay/import-url/handling.php";
    $urlPos = $_POST["url"] ?? "";

    $url = strpos($urlPos, "?") === false ? "ApiUndefined?$urlPos" : $urlPos;

    $data = explode("?", $url);
    $decode = urldecode($data[1] ?? "");
    $parameters = str_replace("&", "<br>", $decode);

    $vnp_Url = $redirect . "?" . ($data[1] ?? "") . "&vnp_UrlRequest=" . $data[0] . "&vnp_SecretKey=" . ($_POST["key"] ?? "");
    if (isset($_POST['redirect'])) {
        header('Location: ' . $vnp_Url);
        die();
    }

    if (!empty($parameters)) {
        echo "<label for='secureHash'>Parameters</label><div class='highlight'><pre><code class='language-html'>$data[0]<br>$parameters</code></pre></div>";
    }
    ?>

</div>
</body>

</html>
