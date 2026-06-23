<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giỏ hàng của bạn - Techzone</title>
    
    <style>
        /* CSS Reset & Cấu hình cơ bản (Giữ nguyên của bạn) */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4; color: #333; line-height: 1.5; display: flex; flex-direction: column; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }

        /* ================= HEADER ================= */
        .header { background-color: #d70018; padding: 15px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; color: #fff; }
        .header-inner { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        
        .header-logo h1 { font-size: 2rem; font-weight: 900; text-transform: uppercase; margin: 0; letter-spacing: 1px; }
        .header-logo a { color: #ffffff; }
        
        .search-bar { flex-grow: 1; max-width: 500px; display: flex; background: #fff; border-radius: 4px; overflow: hidden; margin: 0 20px; }
        .search-bar input { width: 100%; padding: 10px 15px; border: none; outline: none; font-size: 0.95rem; color: #333; }
        .search-bar button { padding: 10px 20px; background: #333; color: white; border: none; cursor: pointer; font-weight: bold; transition: background 0.2s; }
        .search-bar button:hover { background: #555; }

        .header-nav { display: flex; align-items: center; gap: 20px; }
        .header-nav a { font-weight: bold; font-size: 0.95rem; transition: opacity 0.2s; display: flex; align-items: center; gap: 5px; }
        .header-nav a:hover { opacity: 0.8; }
        
        /* ================= MAIN CONTENT ================= */
        main { flex: 1; padding: 40px 0 50px; }
        .section-title { font-size: 1.5rem; margin-bottom: 20px; color: #333; text-transform: uppercase; font-weight: bold; border-left: 4px solid #d70018; padding-left: 10px; }
        
        /* ================= CART SPECIFIC STYLES ================= */
        .cart-wrapper { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .cart-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .cart-table th, .cart-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; vertical-align: middle; }
        .cart-table th { background-color: #f9f9f9; font-weight: bold; color: #555; text-transform: uppercase; font-size: 0.9rem; }
        
        .cart-item-info { display: flex; align-items: center; gap: 15px; }
        .cart-item-info img { width: 80px; height: 80px; object-fit: contain; border-radius: 4px; border: 1px solid #eee; }
        .cart-item-info h4 { font-size: 1rem; color: #333; margin-bottom: 5px; }
        
        .price-text { color: #d70018; font-weight: bold; }
        
        .qty-form { display: flex; align-items: center; gap: 5px; }
        .qty-input { width: 60px; padding: 8px; text-align: center; border: 1px solid #ddd; border-radius: 4px; outline: none; }
        
        .btn { padding: 8px 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 0.85rem; font-weight: bold; transition: background 0.2s; text-transform: uppercase; }
        .btn-update { background-color: #333; color: white; }
        .btn-update:hover { background-color: #555; }
        .btn-remove { background-color: #fff; color: #d70018; border: 1px solid #d70018; }
        .btn-remove:hover { background-color: #d70018; color: #fff; }
        
        .cart-summary { margin-top: 30px; text-align: right; border-top: 2px solid #f4f4f4; padding-top: 20px; }
        .cart-summary h3 { font-size: 1.5rem; color: #333; margin-bottom: 15px; }
        .cart-summary h3 span { color: #d70018; font-size: 1.8rem; }
        
        .btn-checkout { display: inline-block; background-color: #a50064; color: white; padding: 12px 30px; border-radius: 6px; font-size: 1.1rem; font-weight: bold; text-transform: uppercase; transition: background 0.2s; }
        .btn-checkout:hover { background-color: #8a0053; }
        
        .empty-cart { text-align: center; padding: 50px 20px; }
        .empty-cart p { color: #666; font-size: 1.1rem; margin-bottom: 20px; }
        .btn-continue { display: inline-block; color: #d70018; font-weight: bold; text-decoration: underline; margin-top: 15px; }

        /* ================= FOOTER ================= */
        .footer { background-color: #222; color: #ccc; padding: 50px 0 20px; font-size: 0.9rem; }
        .footer-inner { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; margin-bottom: 30px; }
        .footer-col h4 { color: #fff; font-size: 1.1rem; margin-bottom: 20px; text-transform: uppercase; position: relative; padding-bottom: 10px; }
        .footer-col h4::after { content: ''; position: absolute; left: 0; bottom: 0; width: 40px; height: 3px; background-color: #d70018; }
        .footer-col p { margin-bottom: 10px; line-height: 1.6; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 12px; }
        .footer-col ul li a { color: #ccc; transition: color 0.2s; }
        .footer-col ul li a:hover { color: #d70018; padding-left: 5px; }
        .footer-bottom { text-align: center; padding-top: 20px; border-top: 1px solid #444; font-size: 0.85rem; color: #888; }
        
        /* Responsive cơ bản */
        @media (max-width: 768px) {
            .header-inner { flex-direction: column; text-align: center; }
            .search-bar { width: 100%; margin: 10px 0; max-width: 100%; }
            .header-nav { width: 100%; justify-content: center; }
            .cart-table, .cart-table tbody, .cart-table tr, .cart-table td { display: block; width: 100%; }
            .cart-table thead { display: none; }
            .cart-table tr { margin-bottom: 15px; border: 1px solid #eee; padding: 10px; border-radius: 8px; }
            .cart-table td { text-align: right; padding: 10px 5px; border-bottom: none; }
            .cart-table td::before { content: attr(data-label); float: left; font-weight: bold; text-transform: uppercase; color: #555; }
            .cart-item-info { justify-content: flex-end; text-align: right; }
            .qty-form { justify-content: flex-end; }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="container header-inner">
            <div class="header-logo">
                <h1><a href="/">Techzone</a></h1>
            </div>
            
            <form class="search-bar" action="/search" method="GET">
                <input type="text" name="q" placeholder="Bạn muốn tìm sản phẩm gì?">
                <button type="submit">Tìm kiếm</button>
            </form>

            <nav class="header-nav">
                <a href="/">Sản phẩm</a>
                <a href="/admin/orders">Quản lý đơn</a>
                <a href="/cart">Giỏ hàng (<?= count($_SESSION['cart'] ?? []) ?>)</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2 class="section-title">Giỏ hàng của bạn</h2>

        <div class="cart-wrapper">
            <?php if (empty($cart)): ?>
                <div class="empty-cart">
                    <p>Giỏ hàng của bạn hiện đang trống.</p>
                    <a href="/" class="btn-checkout">Tiếp tục mua sắm</a>
                </div>
            <?php else: ?>
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $id => $item): ?>
                            <tr>
                                <td data-label="Sản phẩm">
                                    <div class="cart-item-info">
                                        <img src="<?= htmlspecialchars($item['image'] ?? '') ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                        <div>
                                            <h4><?= htmlspecialchars($item['name']) ?></h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Đơn giá" class="price-text">
                                    <?= number_format($item['price'], 0, ',', '.') ?> đ
                                </td>
                                <td data-label="Số lượng">
                                    <form class="qty-form" action="/cart/update" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $id ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="qty-input">
                                        <button type="submit" class="btn btn-update">Cập nhật</button>
                                    </form>
                                </td>
                                <td data-label="Thành tiền" class="price-text">
                                    <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> đ
                                </td>
                                <td data-label="Thao tác">
                                    <form action="/cart/remove" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $id ?>">
                                        <button type="submit" class="btn btn-remove">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="cart-summary">
                    <h3>Tổng thanh toán: <span><?= number_format($total, 0, ',', '.') ?> đ</span></h3>
                    <a href="/checkout" class="btn-checkout">Tiến hành đặt hàng</a>
                    <br>
                    <a href="/" class="btn-continue">Hoặc tiếp tục mua sắm</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-inner">
                <div class="footer-col">
                    <h4>Về Techzone</h4>
                    <p>Techzone là hệ thống bán lẻ các thiết bị điện tử, điện thoại, laptop chính hãng hàng đầu. Chúng tôi cam kết mang lại giá trị tốt nhất cho khách hàng.</p>
                    <p><strong>Hotline:</strong> 1900 xxxx</p>
                    <p><strong>Email:</strong> support@technify.vn</p>
                </div>
                
                <div class="footer-col">
                    <h4>Chính sách</h4>
                    <ul>
                        <li><a href="#">Chính sách bảo hành</a></li>
                        <li><a href="#">Chính sách đổi trả</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Hướng dẫn trả góp</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Hỗ trợ khách hàng</h4>
                    <ul>
                        <li><a href="#">Tìm hiểu về mua trả góp</a></li>
                        <li><a href="#">Hướng dẫn mua hàng online</a></li>
                        <li><a href="#">Tra cứu đơn hàng</a></li>
                        <li><a href="#">Góp ý, khiếu nại</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Kết nối với chúng tôi</h4>
                    <p>Theo dõi Techzone trên các nền tảng mạng xã hội để cập nhật những khuyến mãi mới nhất.</p>
                    <div style="margin-top: 15px;">
                        <a href="#" style="display: inline-block; padding: 8px 15px; background: #3b5998; color: white; border-radius: 4px; margin-right: 5px;">Facebook</a>
                        <a href="#" style="display: inline-block; padding: 8px 15px; background: #ff0000; color: white; border-radius: 4px;">YouTube</a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                &copy; <?= date('Y') ?> Techzone. Bản quyền thuộc về Công ty TNHH Technify Việt Nam.
            </div>
        </div>
    </footer>
</body>
</html>
