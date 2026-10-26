<?php

use App\Controllers\ProductController;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

require __DIR__ . '/../includes/bootstrap.php';

$controller = new ProductController(new ProductRepository($pdo), new CategoryRepository($pdo));
$controller->index();