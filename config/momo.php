<?php

return [
    'endpoint' => 'https://test-payment.momo.vn/v2/gateway/api/create',

   // Lấy tại MoMo Business Portal > Thông tin tích hợp.
    'partner_code' => 'MOMO4MUD20240115_TEST',
    'access_key' => 'Ekj9og2VnRfOuIys',
    'secret_key' => 'PseUbm2s8QVJEbexsh8H3Jz2qa9tDqoa',

    // Redirect hoáº¡t Ä‘á»™ng trÃªn chÃ­nh mÃ¡y Ä‘ang cháº¡y Laragon.
    'redirect_url' => 'http://momo-shop.test/payment/result',

    // Localhost chÆ°a nháº­n IPN tá»« internet. Sau Ä‘Ã³ Ä‘á»•i sang URL ngrok/Cloudflare Tunnel.
    'ipn_url' => 'http://momo-shop.test/payment/momo/ipn',

    'request_type' => 'captureWallet',
    'lang' => 'vi',
];

