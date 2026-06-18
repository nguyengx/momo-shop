<?php

return [
    'GET /' => [
        'ProductController',
        'index'
    ],

    'GET /cart' => [
        'CartController',
        'index'
    ],

    'POST /cart/add' => [
        'CartController',
        'add'
    ],

    'GET /checkout' => [
        'CheckoutController',
        'index'
    ],

    'POST /checkout' => [
        'CheckoutController',
        'store'
    ],

    'POST /payment/momo/create' => [
        'PaymentController',
        'create'
    ],

    'GET /payment/result' => [
        'PaymentController',
        'result'
    ],

    'POST /payment/momo/ipn' => [
        'PaymentController',
        'ipn'
    ],

    'GET /admin/orders' => [
        'AdminController',
        'orders'
    ],
];