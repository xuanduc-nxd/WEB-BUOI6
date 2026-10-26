<?php
$pageTitle = 'Thêm danh mục';
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-head"><h1>Thêm danh mục</h1><a class="btn btn-outline" href="categories.php">Quay lại</a></div>
<section class="card form-card"><form method="post">
 <div class="field"><label for="name">Tên danh mục</label><input id="name" name="name" value="<?= e($name) ?>" maxlength="100" required><p class="field-error"><?= e($errors['name'] ?? '') ?></p></div>
 <div class="field"><label for="slug">Slug (không dấu)</label><input id="slug" name="slug" value="<?= e($slug) ?>" maxlength="120" required><p class="help">Ví dụ: phu-kien</p><p class="field-error"><?= e($errors['slug'] ?? '') ?></p></div>
 <button class="btn" type="submit">Lưu danh mục</button>
</form></section>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
