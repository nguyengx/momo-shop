<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Techzone - Cửa hàng điện tử</title>
    
    <style>
        /* CSS Reset & Cấu hình cơ bản */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; background-color: #f4f4f4; color: #333; line-height: 1.5; display: flex; flex-direction: column; min-height: 100vh; }
        a { text-decoration: none; color: inherit; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }

        /* ================= HEADER ================= */
        .header { background-color: #d70018; padding: 15px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 1000; color: #fff; }
        .header-inner { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        
        .header-logo h1 { font-size: 2rem; font-weight: 900; text-transform: uppercase; margin: 0; letter-spacing: 1px; }
        .header-logo a { color: #ffffff; }
        
        /* Thanh tìm kiếm */
        .search-bar { flex-grow: 1; max-width: 500px; display: flex; background: #fff; border-radius: 4px; overflow: hidden; margin: 0 20px; }
        .search-bar input { width: 100%; padding: 10px 15px; border: none; outline: none; font-size: 0.95rem; color: #333; }
        .search-bar button { padding: 10px 20px; background: #333; color: white; border: none; cursor: pointer; font-weight: bold; transition: background 0.2s; }
        .search-bar button:hover { background: #555; }

        /* Menu điều hướng */
        .header-nav { display: flex; align-items: center; gap: 20px; }
        .header-nav a { font-weight: bold; font-size: 0.95rem; transition: opacity 0.2s; display: flex; align-items: center; gap: 5px; }
        .header-nav a:hover { opacity: 0.8; }
        
        /* ================= MAIN CONTENT ================= */
        main { flex: 1; padding: 120px 0 50px; }
        .section-title { font-size: 1.5rem; margin-bottom: 20px; color: #333; text-transform: uppercase; font-weight: bold; border-left: 4px solid #d70018; padding-left: 10px; }
        
        .product-grid-wrapper { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .product-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .empty-msg { text-align: center; color: #666; font-size: 1.1rem; width: 100%; grid-column: 1 / -1; padding: 30px 0; }

        /* Card Sản phẩm */
        .product-card { background: #ffffff; border: 1px solid #eee; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; padding: 15px; position: relative; transition: transform 0.2s, box-shadow 0.2s; }
        .product-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.1); transform: translateY(-3px); border-color: #d70018; }
        
        .product-image-wrapper { position: relative; width: 100%; text-align: center; margin-bottom: 15px; }
        .product-card img { max-width: 100%; height: 180px; object-fit: contain; transition: transform 0.3s ease; }
        .product-card:hover img { transform: scale(1.05); }
        
        .badge { position: absolute; top: 0; left: 0; background-color: #d70018; color: #fff; font-size: 0.75rem; font-weight: bold; padding: 4px 8px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
        
        .product-card h3 { font-size: 1rem; margin-bottom: 8px; color: #333; flex-grow: 1; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .product-card p { display: none; } 
        
        .rating { color: #ff9900; font-size: 1rem; margin-bottom: 8px; }
        
        .price-container { margin-bottom: 15px; }
        .product-card strong { font-size: 1.25rem; color: #d70018; font-weight: bold; }

        /* ================= BUTTONS ================= */
        .action-buttons { display: flex; flex-direction: column; gap: 8px; margin-top: auto; }
        .action-buttons form { width: 100%; }
        
        .btn-add-cart { width: 100%; background-color: #333; color: white; border: none; padding: 10px; border-radius: 6px; font-size: 0.9rem; font-weight: bold; cursor: pointer; transition: background 0.2s; text-transform: uppercase; }
        .btn-add-cart:hover { background-color: #555; }

        .btn-buy-now { width: 100%; background-color: #a50064; color: white; border: none; padding: 10px; border-radius: 6px; font-size: 0.9rem; font-weight: bold; cursor: pointer; transition: background 0.2s; text-transform: uppercase; }
        .btn-buy-now:hover { background-color: #8a0053; }

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
            .product-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 480px) {
            .product-grid { grid-template-columns: 1fr; }
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
        <h2 class="section-title">Sản phẩm nổi bật</h2>

        <div class="product-grid-wrapper">
            <div class="product-grid">
                <?php if (empty($products)): ?>
                    <p class="empty-msg">Chưa có sản phẩm nào.</p>
                <?php endif; ?>

                <?php foreach ($products as $product): ?>
                    <article class="product-card">
                        <div class="product-image-wrapper">
                            <span class="badge">Trả góp 0%</span>
                            <img 
                                src="<?= htmlspecialchars($product['image'] ?? '') ?>" 
                                alt="<?= htmlspecialchars($product['name']) ?>"
                            >
                        </div>

                        <h3>
                            <?= htmlspecialchars($product['name']) ?>
                        </h3>
                        
                        <div class="rating">&#9733;&#9733;&#9733;&#9733;&#9734;</div>

                        <p>
                            <?= htmlspecialchars($product['description'] ?? '') ?>
                        </p>

                        <div class="price-container">
                            <strong>
                                <?= number_format(
                                    (int) $product['price'],
                                    0,
                                    ',',
                                    '.'
                                ) ?> đ
                            </strong>
                        </div>

                        <div class="action-buttons">
                            <form action="/cart/add" method="POST">
                                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                                <input type="hidden" name="price" value="<?= (int) $product['price'] ?>">
                                <input type="hidden" name="image" value="<?= htmlspecialchars($product['image'] ?? '') ?>">
                                <button type="submit" class="btn-add-cart">Thêm vào giỏ</button>
                            </form>

                            <form action="/payment/momo/create" method="POST">
                                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                                <button type="submit" class="btn-buy-now">Mua ngay với MoMo</button>
                            </form>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-inner">
                <div class="footer-col">
                    <h4>Về Techzone</h4>
                    <p>Techzone là hệ thống bán lẻ các thiết bị điện tử, điện thoại, laptop chính hãng hàng đầu. Chúng tôi cam kết mang lại giá trị tốt nhất cho khách hàng.</p>
                    <p><strong>Hotline:</strong> 1900 xxxx</p>
                    <p><strong>Email:</strong> support@techzone.vn</p>
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
                &copy; <?= date('Y') ?> Techzone. Bản quyền thuộc về Công ty TNHH Techzone Việt Nam.
            </div>
        </div>
    </footer>
</body>
</html>
