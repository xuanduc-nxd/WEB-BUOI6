<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

// TODO P1: quan sát class, object, constructor và property.
final class ProductRepository
{
    public function __construct(private PDO $pdo) {}

    public function all(): array
    {
        // TODO P2: Chuyển nguyên câu SELECT + JOIN ở public/products.php vào đây.
        // Trả về mảng bằng ->fetchAll(PDO::FETCH_ASSOC).

        return $this->pdo->query(
            'SELECT p.id, p.name, p.price, p.stock, c.name AS category_name
             FROM products p
             JOIN categories c ON c.id = p.category_id
             ORDER BY p.id DESC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }
}
