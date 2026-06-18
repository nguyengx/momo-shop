<?php

return [
    'endpoint' => 'https://test-payment.momo.vn/v2/gateway/api/create',

    // Láº¥y táº¡i MoMo Business Portal > ThÃ´ng tin tÃ­ch há»£p.
    'partner_code' => 'YOUR_PARTNER_CODE',
    'access_key' => 'YOUR_ACCESS_KEY',
    'secret_key' => 'YOUR_SECRET_KEY',

    // Redirect hoáº¡t Ä‘á»™ng trÃªn chÃ­nh mÃ¡y Ä‘ang cháº¡y Laragon.
    'redirect_url' => 'http://momo-shop.test/payment/result',

    // Localhost chÆ°a nháº­n IPN tá»« internet. Sau Ä‘Ã³ Ä‘á»•i sang URL ngrok/Cloudflare Tunnel.
    'ipn_url' => 'http://momo-shop.test/payment/momo/ipn',

    'request_type' => 'captureWallet',
    'lang' => 'vi',
];

