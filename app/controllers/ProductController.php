<?php

require_once BASE_PATH . '/app/models/Product.php';

class ProductController
{
    public function index(): void
    {
        $productModel = new Product();

        $products = $productModel->getAll();

        require BASE_PATH . '/app/views/products.php';
    }
}