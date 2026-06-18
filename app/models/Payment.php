<?php

class Payment
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function createPending(
        int $orderId,
        string $requestId,
        string $momoOrderId,
        int $amount
    ): void {
        $statement = $this->db->prepare(
            'INSERT INTO payments
            (order_id, request_id, momo_order_id, amount, status)
            VALUES (:order_id, :request_id, :momo_order_id, :amount, :status)'
        );

        $statement->execute([
            'order_id' => $orderId,
            'request_id' => $requestId,
            'momo_order_id' => $momoOrderId,
            'amount' => $amount,
            'status' => 'pending',
        ]);
    }

    public function saveCreateResponse(string $momoOrderId, array $response): void
    {
        $resultCode = isset($response['resultCode'])
            ? (int) $response['resultCode']
            : -1;

        // resultCode=0 ở bước create chỉ có nghĩa tạo yêu cầu thành công,
        // chưa có nghĩa khách đã thanh toán.
        $status = $resultCode === 0 ? 'pending' : 'failed';

        $statement = $this->db->prepare(
            'UPDATE payments
             SET result_code = :result_code,
                 message = :message,
                 status = :status,
                 raw_data = :raw_data,
                 updated_at = NOW()
             WHERE momo_order_id = :momo_order_id'
        );

        $statement->execute([
            'result_code' => $resultCode,
            'message' => $response['message'] ?? '',
            'status' => $status,
            'raw_data' => json_encode($response, JSON_UNESCAPED_UNICODE),
            'momo_order_id' => $momoOrderId,
        ]);
    }

    public function findByMomoOrderId(string $momoOrderId): ?array
    {
        $statement = $this->db->prepare(
            'SELECT payments.*, orders.order_code, orders.payment_status
             FROM payments
             INNER JOIN orders ON orders.id = payments.order_id
             WHERE payments.momo_order_id = :momo_order_id
             LIMIT 1'
        );

        $statement->execute(['momo_order_id' => $momoOrderId]);
        $payment = $statement->fetch();

        return $payment ?: null;
    }

    public function applyMomoResult(array $payload): void
    {
        $momoOrderId = (string) $payload['orderId'];
        $resultCode = (int) $payload['resultCode'];

        $this->db->beginTransaction();

        try {
            $statement = $this->db->prepare(
                'SELECT * FROM payments
                 WHERE momo_order_id = :momo_order_id
                 LIMIT 1
                 FOR UPDATE'
            );
            $statement->execute(['momo_order_id' => $momoOrderId]);
            $payment = $statement->fetch();

            if (!$payment) {
                throw new RuntimeException('Không tìm thấy giao dịch trong database.');
            }

            // IPN/redirect có thể gửi lại nhiều lần.
            if ($payment['status'] === 'paid' && $resultCode === 0) {
                $this->db->commit();
                return;
            }

            $paymentStatus = $resultCode === 0 ? 'paid' : 'failed';
            $orderStatus = $resultCode === 0 ? 'processing' : 'pending';

            $updatePayment = $this->db->prepare(
                'UPDATE payments
                 SET momo_trans_id = :momo_trans_id,
                     result_code = :result_code,
                     message = :message,
                     status = :status,
                     raw_data = :raw_data,
                     updated_at = NOW()
                 WHERE id = :id'
            );

            $updatePayment->execute([
                'momo_trans_id' => (string) ($payload['transId'] ?? ''),
                'result_code' => $resultCode,
                'message' => (string) ($payload['message'] ?? ''),
                'status' => $paymentStatus,
                'raw_data' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'id' => (int) $payment['id'],
            ]);

            $updateOrder = $this->db->prepare(
                'UPDATE orders
                 SET payment_status = :payment_status,
                     order_status = :order_status
                 WHERE id = :order_id'
            );

            $updateOrder->execute([
                'payment_status' => $paymentStatus,
                'order_status' => $orderStatus,
                'order_id' => (int) $payment['order_id'],
            ]);

            $this->db->commit();
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }
}
