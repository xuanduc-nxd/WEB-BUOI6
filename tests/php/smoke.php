<?php

declare(strict_types=1);

use App\Controllers\CategoryController;
use App\Controllers\ProductController;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
require dirname(__DIR__, 2) . '/includes/functions.php';

function check(bool $condition, string $message): void
{
    if (!$condition) throw new RuntimeException($message);
}

$pdo = new PDO('sqlite::memory:', null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec('PRAGMA foreign_keys = ON');
$pdo->exec('CREATE TABLE categories (id INTEGER PRIMARY KEY, name TEXT NOT NULL, slug TEXT NOT NULL UNIQUE)');
$pdo->exec('CREATE TABLE products (id INTEGER PRIMARY KEY, category_id INTEGER NOT NULL REFERENCES categories(id) ON DELETE RESTRICT, name TEXT NOT NULL, price INTEGER NOT NULL, stock INTEGER NOT NULL)');

$categories = new CategoryRepository($pdo);
$products = new ProductRepository($pdo);
$categories->create('Phụ kiện', 'phu-kien');
$categoryId = (int) $pdo->lastInsertId();
$categories->create('Học tập', 'hoc-tap');
check(count($categories->all()) === 2, 'Category all()');
check($categories->exists($categoryId), 'Category exists()');
check($categories->findById(999999) === null, 'Category findById() missing');

$products->create(['name' => '<script>alert(1)</script>', 'price' => 1000, 'stock' => 2, 'category_id' => $categoryId]);
$productId = (int) $pdo->lastInsertId();
check($products->all()[0]['category_name'] === 'Phụ kiện', 'Product JOIN category_name');
check($products->findWithCategory($productId)['category_name'] === 'Phụ kiện', 'Product detail JOIN');
check($categories->hasProducts($categoryId), 'Category FK usage');

$_GET = [];
$_SERVER['REQUEST_METHOD'] = 'GET';
ob_start();
(new ProductController($products, $categories))->index();
$html = ob_get_clean();
check(str_contains($html, '&lt;script&gt;alert(1)&lt;/script&gt;'), 'Product output escaped');
check(!str_contains($html, '<script>alert(1)</script>'), 'Product script must not render');
check(str_contains($html, 'product-detail.php?id=' . $productId), 'Product detail link');

ob_start();
(new CategoryController($categories))->index();
$html = ob_get_clean();
check(str_contains($html, 'phu-kien'), 'Category slug rendered');
check(str_contains($html, 'delete-category.php'), 'Category delete link');

$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = ['name' => 'Sai', 'price' => '-1', 'stock' => '-2', 'category_id' => '999999'];
ob_start();
(new ProductController($products, $categories))->create();
$html = ob_get_clean();
check(str_contains($html, 'Giá phải là số nguyên dương'), 'Invalid price rejected');
check(str_contains($html, 'Tồn kho phải là số nguyên'), 'Negative stock rejected');
check(str_contains($html, 'Danh mục không tồn tại'), 'Invalid category rejected');
check(count($products->all()) === 1, 'Invalid Product not inserted');

$_POST = ['name' => 'Sai', 'slug' => 'SLUG TRUNG'];
ob_start();
(new CategoryController($categories))->create();
$html = ob_get_clean();
check(str_contains($html, 'Slug tối đa 120 ký tự'), 'Invalid slug rejected');
check(count($categories->all()) === 2, 'Invalid Category not inserted');

$products->update($productId, ['name' => 'Bút', 'price' => 2500, 'stock' => 0, 'category_id' => $categoryId]);
check($products->findById($productId)['name'] === 'Bút', 'Product update()');
$categories->update($categoryId, 'Phụ kiện mới', 'phu-kien-moi');
check($categories->findById($categoryId)['slug'] === 'phu-kien-moi', 'Category update()');
check($products->delete($productId), 'Product delete()');
check($products->findById($productId) === null, 'Product deleted');
check($categories->delete($categoryId), 'Category delete()');
check(!$categories->exists($categoryId), 'Category deleted');

echo "Smoke tests passed.\n";
