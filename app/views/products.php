<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>MoMo Shop</title>

    <link
        rel="stylesheet"
        href="/assets/css/style.css"
    >
</head>

<body>
    <header class="header">
        <div class="container header-inner">
            <h1>MoMo Shop</h1>

            <nav>
                <a href="/">Sản phẩm</a>
                <a href="/admin/orders">Quản lý đơn</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2>Sản phẩm demo thanh toán MoMo</h2>

        <div class="product-grid">
            <?php if (empty($products)): ?>
                <p>Chưa có sản phẩm nào.</p>
            <?php endif; ?>

            <?php foreach ($products as $product): ?>
                <article class="product-card">
                    <img
                        src="<?= htmlspecialchars(
                            $product['image'] ?? ''
                        ) ?>"
                        alt="<?= htmlspecialchars(
                            $product['name']
                        ) ?>"
                    >

                    <h3>
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>

                    <p>
                        <?= htmlspecialchars(
                            $product['description'] ?? ''
                        ) ?>
                    </p>

                    <strong>
                        <?= number_format(
                            (int) $product['price'],
                            0,
                            ',',
                            '.'
                        ) ?> đ
                    </strong>

                    <form
                        action="/payment/momo/create"
                        method="POST"
                    >
                        <input
                            type="hidden"
                            name="product_id"
                            value="<?= (int) $product['id'] ?>"
                        >

                        <button type="submit">
                            Thanh toán bằng MoMo
                        </button>
                    </form>
                </article>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>