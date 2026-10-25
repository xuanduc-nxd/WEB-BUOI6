<?php
$pageTitle = $pageTitle ?? 'VKUShop';
?><!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> · VKUShop</title>
    <link rel="stylesheet" href="<?= e(asset_path('css/style.css')) ?>">
</head>
<body>
<header class="site-header">
  <div class="container nav-inner">
    <a class="brand" href="index.php"><span class="brand-mark">V</span><span>VKUShop</span></a>
    <nav aria-label="Điều hướng chính">
      <a href="index.php">Trang chủ</a>
      <a href="products.php">Sản phẩm</a>
      <a href="categories.php">Danh mục</a>
    </nav>
  </div>
</header>
<main class="container main-content">
