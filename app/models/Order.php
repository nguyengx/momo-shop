<?php

class Order
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function createFromProduct(array $product): array
    {
        $orderCode = 'ORD' . date('YmdHis') . strtoupper(bin2hex(random_bytes(3)));
        $amount = (int) $product['price'];

        $this->db->beginTransaction();

        try {
            $statement = $this->db->prepare(
                'INSERT INTO orders
                (order_code, customer_name, customer_phone, customer_address,
                 total_amount, order_status, payment_status)
                VALUES
                (:order_code, :customer_name, :customer_phone, :customer_address,
                 :total_amount, :order_status, :payment_status)'
            );

            $statement->execute([
                'order_code' => $orderCode,
                'customer_name' => 'Khách demo MoMo',
                'customer_phone' => '0000000000',
                'customer_address' => 'Thanh toán trực tuyến',
                'total_amount' => $amount,
                'order_status' => 'pending',
                'payment_status' => 'pending',
            ]);

            $orderId = (int) $this->db->lastInsertId();

            $itemStatement = $this->db->prepare(
                'INSERT INTO order_items
                (order_id, product_id, product_name, quantity, price)
                VALUES (:order_id, :product_id, :product_name, 1, :price)'
            );

            $itemStatement->execute([
                'order_id' => $orderId,
                'product_id' => (int) $product['id'],
                'product_name' => $product['name'],
                'price' => $amount,
            ]);

            $this->db->commit();

            return [
                'id' => $orderId,
                'order_code' => $orderCode,
                'total_amount' => $amount,
            ];
        } catch (Throwable $exception) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $exception;
        }
    }
}
