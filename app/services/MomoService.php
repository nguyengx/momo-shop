<?php

class MomoService
{
    private array $config;

    public function __construct()
    {
        $this->config = require BASE_PATH . '/config/momo.php';
        $this->assertConfigured();
    }

    public function createPayment(array $order, string $requestId): array
    {
        $partnerCode = $this->config['partner_code'];
        $accessKey = $this->config['access_key'];
        $secretKey = $this->config['secret_key'];
        $amount = (string) ((int) $order['total_amount']);
        $orderId = (string) $order['order_code'];
        $orderInfo = 'Thanh toan don hang ' . $orderId;
        $redirectUrl = $this->config['redirect_url'];
        $ipnUrl = $this->config['ipn_url'];
        $requestType = $this->config['request_type'];
        $extraData = '';

        $rawSignature =
            'accessKey=' . $accessKey .
            '&amount=' . $amount .
            '&extraData=' . $extraData .
            '&ipnUrl=' . $ipnUrl .
            '&orderId=' . $orderId .
            '&orderInfo=' . $orderInfo .
            '&partnerCode=' . $partnerCode .
            '&redirectUrl=' . $redirectUrl .
            '&requestId=' . $requestId .
            '&requestType=' . $requestType;

        $payload = [
            'partnerCode' => $partnerCode,
            'partnerName' => 'MoMo Shop Demo',
            'storeId' => 'MomoShopDemo',
            'requestId' => $requestId,
            'amount' => (int) $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => $this->config['lang'],
            'requestType' => $requestType,
            'autoCapture' => true,
            'extraData' => $extraData,
            'signature' => hash_hmac('sha256', $rawSignature, $secretKey),
        ];

        return $this->postJson($this->config['endpoint'], $payload);
    }

    public function verifyResult(array $data): bool
    {
        if (empty($data['signature'])) {
            return false;
        }

        $rawSignature =
            'accessKey=' . $this->config['access_key'] .
            '&amount=' . ($data['amount'] ?? '') .
            '&extraData=' . ($data['extraData'] ?? '') .
            '&message=' . ($data['message'] ?? '') .
            '&orderId=' . ($data['orderId'] ?? '') .
            '&orderInfo=' . ($data['orderInfo'] ?? '') .
            '&orderType=' . ($data['orderType'] ?? '') .
            '&partnerCode=' . ($data['partnerCode'] ?? '') .
            '&payType=' . ($data['payType'] ?? '') .
            '&requestId=' . ($data['requestId'] ?? '') .
            '&responseTime=' . ($data['responseTime'] ?? '') .
            '&resultCode=' . ($data['resultCode'] ?? '') .
            '&transId=' . ($data['transId'] ?? '');

        $expected = hash_hmac(
            'sha256',
            $rawSignature,
            $this->config['secret_key']
        );

        return hash_equals($expected, (string) $data['signature']);
    }

    public function partnerCode(): string
    {
        return $this->config['partner_code'];
    }

    private function postJson(string $url, array $payload): array
    {
        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30,
        ]);

        $body = curl_exec($curl);
        $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        $this->writeLog([
            'time' => date('c'),
            'http_code' => $httpCode,
            'order_id' => $payload['orderId'] ?? null,
            'request_id' => $payload['requestId'] ?? null,
            'response' => $body,
            'curl_error' => $curlError ?: null,
        ]);

        if ($body === false || $curlError !== '') {
            throw new RuntimeException('Không gọi được MoMo: ' . $curlError);
        }

        $decoded = json_decode($body, true);

        if (!is_array($decoded)) {
            throw new RuntimeException('MoMo trả về dữ liệu không hợp lệ. HTTP ' . $httpCode);
        }

        return $decoded;
    }

    private function assertConfigured(): void
    {
        foreach (['partner_code', 'access_key', 'secret_key'] as $key) {
            $value = (string) ($this->config[$key] ?? '');

            if ($value === '' || str_starts_with($value, 'YOUR_')) {
                throw new RuntimeException(
                    'Chưa cấu hình ' . $key . ' trong config/momo.php'
                );
            }
        }
    }

    private function writeLog(array $data): void
    {
        file_put_contents(
            BASE_PATH . '/storage/momo.log',
            json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL,
            FILE_APPEND
        );
    }
}
