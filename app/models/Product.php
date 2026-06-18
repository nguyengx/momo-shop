<?php

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAll(): array
    {
        $statement = $this->db->query(
            'SELECT *
             FROM products
             WHERE stock > 0
             ORDER BY id DESC'
        );

        return $statement->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->db->prepare(
            'SELECT *
             FROM products
             WHERE id = :id
             LIMIT 1'
        );

        $statement->execute([
            'id' => $id
        ]);

        $product = $statement->fetch();

        return $product ?: null;
    }
}