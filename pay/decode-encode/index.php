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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decode & Encode Tool</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
        <div class="alert alert-info text-center" role="alert">
            <strong>Kết quả: </strong> <?php echo htmlspecialchars($result); ?>
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a class="btn btn-secondary" href="/vnpay-check/" role="button">Quay lại</a>
    </div>
</div>
</body>
</html>