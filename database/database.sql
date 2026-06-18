CREATE DATABASE IF NOT EXISTS momo_shop
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE momo_shop;

CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    price INT UNSIGNED NOT NULL,
    image VARCHAR(255) NULL,
    stock INT UNSIGNED NOT NULL DEFAULT 100,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) NOT NULL UNIQUE,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_address TEXT NOT NULL,
    total_amount INT UNSIGNED NOT NULL,
    order_status VARCHAR(30) NOT NULL DEFAULT 'pending',
    payment_status VARCHAR(30) NOT NULL DEFAULT 'pending',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    price INT UNSIGNED NOT NULL,

    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_order_items_product
        FOREIGN KEY (product_id)
        REFERENCES products(id)
);

CREATE TABLE payments (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id INT UNSIGNED NOT NULL,
    request_id VARCHAR(100) NOT NULL UNIQUE,
    momo_order_id VARCHAR(100) NULL,
    momo_trans_id VARCHAR(100) NULL,
    amount INT UNSIGNED NOT NULL,
    result_code INT NULL,
    message VARCHAR(255) NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'pending',
    raw_data LONGTEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NULL,

    CONSTRAINT fk_payments_order
        FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE
);

INSERT INTO products
    (name, description, price, image, stock)
VALUES
    (
        'Tai nghe Bluetooth',
        'Tai nghe không dây dùng để demo thanh toán.',
        350000,
        'https://placehold.co/600x400?text=Tai+nghe',
        50
    ),
    (
        'Chuột không dây',
        'Chuột không dây nhỏ gọn.',
        250000,
        'https://placehold.co/600x400?text=Chuot',
        50
    ),
    (
        'Bàn phím cơ',
        'Bàn phím cơ dùng cho học tập và làm việc.',
        790000,
        'https://placehold.co/600x400?text=Ban+phim',
        30
    ),
    (
        'Loa Bluetooth',
        'Loa Bluetooth mini.',
        450000,
        'https://placehold.co/600x400?text=Loa',
        40
    );