<?php
$pageTitle = $product['name'];
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-head"><div><h1><?= e($product['name']) ?></h1><p class="muted">Danh mục: <?= e($product['category_name']) ?></p></div><a href="products.php" class="btn btn-outline">Quay lại</a></div>
<section class="card form-card"><p><strong>Giá:</strong> <?= number_format((float) $product['price'], 0, ',', '.') ?> đ</p><p><strong>Tồn kho:</strong> <?= (int) $product['stock'] ?></p><a href="edit-product.php?id=<?= (int)$product['id'] ?>" class="btn">Sửa sản phẩm</a></section>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
