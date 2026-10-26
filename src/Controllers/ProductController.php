<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use PDOException;

final class ProductController
{
    public function __construct(
        private ProductRepository $products,
        private CategoryRepository $categories
    ) {}

    public function index(): void
    {
        $products = $this->products->all();
        require __DIR__ . '/../../views/products/index.php';
    }

    public function show(): void
    {
        $id = positive_id($_GET['id'] ?? null);
        if (!$id) page_not_found('ID sản phẩm không hợp lệ.');
        $product = $this->products->findWithCategory($id);
        if (!$product) page_not_found('Sản phẩm không tồn tại.');
        require __DIR__ . '/../../views/products/detail.php';
    }

    public function create(): void
    {
        $errors = [];
        $data = ['name' => '', 'price' => '', 'stock' => '', 'category_id' => ''];
        $categories = $this->categories->options();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->input($data);
            $errors = $this->validate($data);
            if (!$errors) {
                try {
                    $this->products->create($this->values($data));
                    redirect('products.php?created=1');
                } catch (PDOException $exception) {
                    if ((int) ($exception->errorInfo[1] ?? 0) !== 1452) throw $exception;
                    $errors['category_id'] = 'Danh mục không tồn tại.';
                }
            }
        }
        require __DIR__ . '/../../views/products/create.php';
    }

    public function edit(): void
    {
        $id = positive_id($_GET['id'] ?? null);
        if (!$id) page_not_found('ID sản phẩm không hợp lệ.');
        $product = $this->products->findById($id);
        if (!$product) page_not_found('Sản phẩm không tồn tại.');
        $categories = $this->categories->options();
        $errors = [];
        $data = [
            'name' => (string) $product['name'],
            'price' => (string) $product['price'],
            'stock' => (string) $product['stock'],
            'category_id' => (string) $product['category_id'],
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $this->input($data);
            $errors = $this->validate($data);
            if (!$errors) {
                try {
                    $this->products->update($id, $this->values($data));
                    redirect('products.php?updated=1');
                } catch (PDOException $exception) {
                    if ((int) ($exception->errorInfo[1] ?? 0) !== 1452) throw $exception;
                    $errors['category_id'] = 'Danh mục không tồn tại.';
                }
            }
        }
        require __DIR__ . '/../../views/products/edit.php';
    }

    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            exit('Chỉ hỗ trợ POST.');
        }
        $id = positive_id($_POST['id'] ?? null);
        if (!$id) page_not_found('ID sản phẩm không hợp lệ.');
        if (!$this->products->delete($id)) page_not_found('Sản phẩm không tồn tại.');
        redirect('products.php?deleted=1');
    }

    private function input(array $data): array
    {
        foreach (array_keys($data) as $key) {
            $value = $_POST[$key] ?? '';
            $data[$key] = is_string($value) ? trim($value) : '';
        }
        return $data;
    }

    private function validate(array $data): array
    {
        $errors = [];
        if ($data['name'] === '') $errors['name'] = 'Vui lòng nhập tên sản phẩm.';
        elseif (!preg_match('/^.{1,150}$/us', $data['name'])) $errors['name'] = 'Tên sản phẩm tối đa 150 ký tự.';
        if ($data['price'] === '' || !ctype_digit($data['price']) || (int) $data['price'] <= 0 || strlen(ltrim($data['price'], '0')) > 12) $errors['price'] = 'Giá phải là số nguyên dương, tối đa 12 chữ số.';
        if ($data['stock'] === '' || !ctype_digit($data['stock']) || strlen(ltrim($data['stock'], '0')) > 10 || (float) $data['stock'] > 4294967295) $errors['stock'] = 'Tồn kho phải là số nguyên từ 0 đến 4294967295.';
        $categoryId = positive_id($data['category_id']);
        if (!$categoryId) $errors['category_id'] = 'Vui lòng chọn danh mục hợp lệ.';
        elseif (!$this->categories->exists($categoryId)) $errors['category_id'] = 'Danh mục không tồn tại.';
        return $errors;
    }

    private function values(array $data): array
    {
        return [
            'name' => $data['name'],
            'price' => (int) $data['price'],
            'stock' => (int) $data['stock'],
            'category_id' => positive_id($data['category_id']),
        ];
    }
}
