<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kết quả thanh toán</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .result-box { max-width: 620px; margin: 60px auto; background: #fff; padding: 28px; border-radius: 14px; box-shadow: 0 4px 18px rgb(0 0 0 / 8%); }
        .success { color: #16833b; }
        .failed { color: #b42318; }
        .result-box a { display: inline-block; margin-top: 16px; color: #a50064; }
    </style>
</head>
<body>
    <main class="container">
        <section class="result-box">
            <h1 class="<?= $success ? 'success' : 'failed' ?>">
                <?= $success ? 'Thanh toán thành công' : 'Thanh toán chưa thành công' ?>
            </h1>

            <p><strong>Mã đơn:</strong> <?= htmlspecialchars($orderId) ?></p>
            <p><strong>Mã giao dịch MoMo:</strong> <?= htmlspecialchars($transId ?: 'Chưa có') ?></p>
            <p><strong>Thông báo:</strong> <?= htmlspecialchars($message) ?></p>
            <p><strong>Xác minh chữ ký:</strong> <?= $verified ? 'Hợp lệ' : 'Không hợp lệ' ?></p>

            <a href="/">Quay lại trang sản phẩm</a>
        </section>
    </main>
</body>
</html>
