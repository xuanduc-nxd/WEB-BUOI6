<?php
$pageTitle = 'Sửa sản phẩm';
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-head"><h1>Sửa sản phẩm #<?= $id ?></h1><a class="btn btn-outline" href="products.php">Quay lại</a></div>
<section class="card form-card"><form method="post" action="edit-product.php?id=<?= $id ?>">
 <div class="field"><label for="name">Tên sản phẩm</label><input id="name" name="name" value="<?= e($data['name']) ?>" maxlength="150" required><p class="field-error"><?= e($errors['name'] ?? '') ?></p></div>
 <div class="field"><label for="price">Giá (đ)</label><input id="price" name="price" value="<?= e($data['price']) ?>" inputmode="numeric" required><p class="field-error"><?= e($errors['price'] ?? '') ?></p></div>
 <div class="field"><label for="stock">Tồn kho</label><input id="stock" name="stock" value="<?= e($data['stock']) ?>" inputmode="numeric" required><p class="field-error"><?= e($errors['stock'] ?? '') ?></p></div>
 <div class="field"><label for="category_id">Danh mục</label><select id="category_id" name="category_id" required>
 <?php foreach ($categories as $category): ?><option value="<?= (int)$category['id'] ?>" <?= (string)$category['id'] === $data['category_id'] ? 'selected' : '' ?>><?= e($category['name']) ?></option><?php endforeach; ?>
 </select><p class="field-error"><?= e($errors['category_id'] ?? '') ?></p></div>
 <div class="form-actions"><button class="btn" type="submit">Cập nhật</button><a href="products.php">Hủy</a></div>
</form></section>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
