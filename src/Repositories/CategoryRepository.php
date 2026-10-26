<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class CategoryRepository
{
    public function __construct(private PDO $pdo) {}

    public function all(): array
    {
        return $this->pdo->query(
            'SELECT id, name, slug FROM categories ORDER BY id DESC'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function options(): array
    {
        return $this->pdo->query(
            'SELECT id, name FROM categories ORDER BY name'
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function exists(int $id): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function hasProducts(int $id): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM products WHERE category_id = :id');
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function create(string $name, string $slug): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO categories (name, slug) VALUES (:name, :slug)');
        $stmt->execute(['name' => $name, 'slug' => $slug]);
    }

    public function update(int $id, string $name, string $slug): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE categories SET name = :name, slug = :slug WHERE id = :id'
        );
        $stmt->execute(['name' => $name, 'slug' => $slug, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
