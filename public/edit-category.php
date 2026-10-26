<?php

use App\Controllers\CategoryController;
use App\Repositories\CategoryRepository;

require __DIR__ . '/../includes/bootstrap.php';

$controller = new CategoryController(new CategoryRepository($pdo));
$controller->edit();