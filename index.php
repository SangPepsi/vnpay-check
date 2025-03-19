<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VNPAY Check Tool</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
            color: #4278b0;
            font-size: 2.0em;
            text-transform: uppercase;
        }

        .menu {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        h2 {
            background-color: #4A90E2;
            color: #fff;
            padding: 12px 18px;
            cursor: pointer;
            border-radius: 10px;
            transition: 0.3s ease;
            width: calc(50% - 8px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            font-size: 1.2em;
        }

        h2:hover {
            background-color: #357ABD;
            transform: scale(1.05);
        }

        ul {
            list-style-type: none;
            padding: 0;
            display: none;
            margin: 10px 0;
            transition: all 0.3s ease-in-out;
        }

        ul li {
            margin: 10px 0;
        }

        a {
            text-decoration: none;
            color: #4A90E2;
            font-weight: bold;
            transition: 0.3s ease;
        }

        a:hover {
            color: #357ABD;
        }

        .arrow::after {
            content: '\25BC';
            display: inline-block;
            margin-left: 10px;
            transition: transform 0.3s ease;
        }

        .arrow.open::after {
            transform: rotate(-180deg);
        }
    </style>
    <script>
        function toggleMenu(id, heading) {
            const section = document.getElementById(id);
            const headingElement = document.getElementById(heading);
            section.style.display = section.style.display === 'none' ? 'block' : 'none';
            headingElement.classList.toggle('open');
        }
    </script>
</head>
<body>
<h1>VNPAY CHECK TOOL</h1>
<div class="menu">
    <section>
        <h2 id="pay-heading" class="arrow" onclick="toggleMenu('pay-menu', 'pay-heading')">1. Luồng Thường (PAY)</h2>
        <ul id="pay-menu" style="display: none;">
            <li><a href="pay/pay">demo thanh toán</a></li>
            <li><a href="pay/import-value">Check HashData</a></li>
            <li><a href="pay/import-data">URL Thanh Toán</a></li>
            <li><a href="pay/import-url">Check URL Thanh Toán</a></li>
            <li><a href="pay/decode-encode">Encode & Decode</a></li>

        </ul>
    </section>

    <section>
        <h2 id="token-heading" class="arrow" onclick="toggleMenu('token-menu', 'token-heading')">2. Luồng Token</h2>
        <ul id="token-menu" style="display: none;">
            <li><a href="token/token_flow.php">Luồng Token</a></li>
        </ul>
    </section>

    <section>
        <h2 id="installment-heading" class="arrow" onclick="toggleMenu('installment-menu', 'installment-heading')">3. Luồng Trả Góp</h2>
        <ul id="installment-menu" style="display: none;">
            <li><a href="installment/installment_flow.php">Luồng Trả Góp</a></li>
        </ul>
    </section>

    <section>
        <h2 id="recurring-heading" class="arrow" onclick="toggleMenu('recurring-menu', 'recurring-heading')">4. Luồng Định Kỳ</h2>
        <ul id="recurring-menu" style="display: none;">
            <li><a href="recurring/dinhky">demo thanh toán</a></li>
        </ul>
    </section>

    <section>
        <h2 id="sit-check-heading" class="arrow" onclick="toggleMenu('sit-check-menu', 'sit-check-heading')">5. SIT CHECK</h2>
        <ul id="sit-check-menu" style="display: none;">
            <li><a href="sit_check/sit_pay.php">SIT PAY</a></li>
            <li><a href="sit_check/sit_token.php">SIT Token</a></li>
            <li><a href="sit_check/sit_installment.php">SIT Trả Góp</a></li>
            <li><a href="sit_check/sit_recurring.php">SIT Định Kỳ</a></li>
        </ul>
    </section>
</div>
</body>
</html>