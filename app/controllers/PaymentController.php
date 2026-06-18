<?php

require_once BASE_PATH . '/app/models/Product.php';
require_once BASE_PATH . '/app/models/Order.php';
require_once BASE_PATH . '/app/models/Payment.php';
require_once BASE_PATH . '/app/services/MomoService.php';

class PaymentController
{
    public function create(): void
    {
        try {
            $productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

            if (!$productId) {
                throw new InvalidArgumentException('Sản phẩm không hợp lệ.');
            }

            $product = (new Product())->find((int) $productId);

            if (!$product) {
                throw new RuntimeException('Không tìm thấy sản phẩm.');
            }

            $order = (new Order())->createFromProduct($product);
            $requestId = 'REQ' . round(microtime(true) * 1000) . strtoupper(bin2hex(random_bytes(2)));

            $paymentModel = new Payment();
            $paymentModel->createPending(
                (int) $order['id'],
                $requestId,
                (string) $order['order_code'],
                (int) $order['total_amount']
            );

            $response = (new MomoService())->createPayment($order, $requestId);
            $paymentModel->saveCreateResponse((string) $order['order_code'], $response);

            if ((int) ($response['resultCode'] ?? -1) !== 0 || empty($response['payUrl'])) {
                throw new RuntimeException(
                    'MoMo từ chối tạo giao dịch: ' . ($response['message'] ?? 'Không rõ lỗi')
                );
            }

            header('Location: ' . $response['payUrl']);
            exit;
        } catch (Throwable $exception) {
            http_response_code(500);
            echo '<h2>Không tạo được thanh toán MoMo</h2>';
            echo '<p>' . htmlspecialchars($exception->getMessage()) . '</p>';
            echo '<p><a href="/">Quay lại trang sản phẩm</a></p>';
        }
    }

    public function result(): void
    {
        $payload = $_GET;
        $success = false;
        $verified = false;
        $message = (string) ($payload['message'] ?? 'Không nhận được kết quả từ MoMo.');
        $orderId = (string) ($payload['orderId'] ?? '');
        $transId = (string) ($payload['transId'] ?? '');

        try {
            $momo = new MomoService();
            $paymentModel = new Payment();
            $payment = $paymentModel->findByMomoOrderId($orderId);

            $verified = $momo->verifyResult($payload);

            if (!$verified) {
                throw new RuntimeException('Chữ ký kết quả MoMo không hợp lệ.');
            }

            if (!$payment) {
                throw new RuntimeException('Không tìm thấy đơn hàng trên hệ thống.');
            }

            if (($payload['partnerCode'] ?? '') !== $momo->partnerCode()) {
                throw new RuntimeException('PartnerCode không khớp.');
            }

            if ((int) ($payload['amount'] ?? 0) !== (int) $payment['amount']) {
                throw new RuntimeException('Số tiền MoMo trả về không khớp đơn hàng.');
            }

            // Hỗ trợ chạy local khi IPN chưa truy cập được momo-shop.test.
            $paymentModel->applyMomoResult($payload);
            $success = (int) ($payload['resultCode'] ?? -1) === 0;
        } catch (Throwable $exception) {
            $message = $exception->getMessage();
        }

        require BASE_PATH . '/app/views/payment-result.php';
    }

    public function ipn(): void
    {
        $payload = json_decode(file_get_contents('php://input'), true);

        if (!is_array($payload)) {
            http_response_code(400);
            exit;
        }

        try {
            $momo = new MomoService();
            $paymentModel = new Payment();
            $payment = $paymentModel->findByMomoOrderId((string) ($payload['orderId'] ?? ''));

            if (!$momo->verifyResult($payload) || !$payment) {
                http_response_code(400);
                exit;
            }

            if (($payload['partnerCode'] ?? '') !== $momo->partnerCode()) {
                http_response_code(400);
                exit;
            }

            if ((int) ($payload['amount'] ?? 0) !== (int) $payment['amount']) {
                http_response_code(400);
                exit;
            }

            $paymentModel->applyMomoResult($payload);
            http_response_code(204);
        } catch (Throwable $exception) {
            file_put_contents(
                BASE_PATH . '/storage/momo.log',
                json_encode([
                    'time' => date('c'),
                    'ipn_error' => $exception->getMessage(),
                ], JSON_UNESCAPED_UNICODE) . PHP_EOL,
                FILE_APPEND
            );

            http_response_code(500);
        }

        exit;
    }
}
