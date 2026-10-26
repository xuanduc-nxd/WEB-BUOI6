<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class ProductRepository
{
    public function __construct(private PDO $pdo) {}

    public function all(): array
    {
        return $this->pdo->query(
            'SELECT p.id, p.name, p.price, p.stock, c.name AS category_name
             FROM products p
             JOIN categories c ON c.id = p.category_id
             ORDER BY p.id DESC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function findWithCategory(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.*, c.name AS category_name FROM products p
             JOIN categories c ON c.id = p.category_id WHERE p.id = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function create(array $data): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO products (name, price, stock, category_id)
             VALUES (:name, :price, :stock, :category_id)'
        );
        $stmt->execute($data);
    }

    public function update(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE products SET name = :name, price = :price, stock = :stock,
             category_id = :category_id WHERE id = :id'
        );
        $stmt->execute($data + ['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
