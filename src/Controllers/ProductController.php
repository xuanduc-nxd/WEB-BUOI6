<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\ProductRepository;

// TODO P3: Controller nhận ProductRepository qua constructor.
final class ProductController
{
    public function __construct(private ProductRepository $products) {}

    public function index(): void
    {
        // TODO P4: $products = $this->products->all();
        $products = $this->products->all();
        require __DIR__ . '/../../views/products/index.php';  // dung de tro den file index.php trong thu muc views/products
        // TODO P5: require views/products/index.php.
        // throw new \LogicException('TODO P4/P5: implement ProductController::index()');
    }
}
