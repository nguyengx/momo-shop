<?php

class CartController {
    
    public function __construct() {
        // Đảm bảo session đã được khởi tạo để lưu trữ giỏ hàng
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Khởi tạo mảng giỏ hàng rỗng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Hiển thị giao diện giỏ hàng
    public function index() {
        $cart = $_SESSION['cart'];
        $total = 0;
        
        // Tính tổng tiền giỏ hàng
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Gọi view hiển thị
        require_once __DIR__ . '/../views/cart.php';
    }

    // Thêm sản phẩm vào giỏ hàng (Gợi ý logic để bạn gọi từ các trang khác)
    public function add() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['product_id'] ?? 0;
        $quantity = 1;

        if ($id) {
            // Đảm bảo đã nhúng file model Product
            require_once __DIR__ . '/../models/Product.php';
            
            // Khởi tạo đối tượng và gọi hàm find có sẵn của bạn
            $productModel = new Product();
            $productInfo = $productModel->find($id);

            // Kiểm tra xem sản phẩm có tồn tại trong database không
            if ($productInfo) {
                // Nếu sản phẩm đã có trong giỏ, tăng số lượng
                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['quantity'] += $quantity;
                } else {
                    // Nếu chưa có, thêm mới với dữ liệu an toàn từ database
                    $_SESSION['cart'][$id] = [
                        'id' => $id,
                        'name' => $productInfo['name'],
                        'price' => $productInfo['price'],
                        'image' => $productInfo['image'] ?? '',
                        'quantity' => $quantity
                    ];
                }
            }
        }
        
        // Chuyển hướng về trang giỏ hàng sau khi thêm thành công
        header("Location: /cart");
        exit;
    }
}

    // Cập nhật số lượng
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['product_id'] ?? 0;
            $quantity = (int)($_POST['quantity'] ?? 1);

            if ($id && isset($_SESSION['cart'][$id])) {
                if ($quantity > 0) {
                    $_SESSION['cart'][$id]['quantity'] = $quantity;
                } else {
                    unset($_SESSION['cart'][$id]); // Xóa nếu số lượng <= 0
                }
            }
            header("Location: /cart");
            exit;
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['product_id'] ?? 0;
            
            if ($id && isset($_SESSION['cart'][$id])) {
                unset($_SESSION['cart'][$id]);
            }
            header("Location: /cart");
            exit;
        }
    }
}
