<?php
$pageTitle = 'Danh sách sản phẩm';
require __DIR__ . '/../../includes/header.php';
?>
<div class="page-head">
 <div><h1>Danh sách sản phẩm</h1><p class="muted">Sản phẩm và danh mục được lấy từ MySQL.</p></div>
 <a class="btn" href="create-product.php">+ Thêm sản phẩm</a>
</div>
<!-- ham nay dung de hien thi thong bao -->
<?php if (isset($_GET['created']) || isset($_GET['updated']) || isset($_GET['deleted'])): ?>
<div class="notice success">Đã cập nhật dữ liệu sản phẩm.</div>
<?php endif; ?>


<div class="card table-scroll">
 <table class="data-table">
  <thead><tr><th>ID</th><th>Sản phẩm</th><th>Danh mục</th><th>Giá</th><th>Tồn kho</th><th>Thao tác</th></tr></thead>
  <tbody>
  <?php foreach ($products as $product):  ?>
  <tr>
   <td><?= (int)$product['id'] ?></td>
   <td><a href="product-detail.php?id=<?= (int)$product['id'] ?>"><?= e($product['name']) ?></a></td>
   <td><?= e($product['category_name']) ?></td>
   <td><?= number_format((float)$product['price'], 0, ',', '.') ?> đ</td>
   <td><span class="tag <?= (int)$product['stock'] > 0 ? '' : 'missing' ?>"><?= (int)$product['stock'] > 0 ? 'Còn ' . (int)$product['stock'] : 'Hết hàng' ?></span></td>
   <td><div class="actions">
      <a class="btn btn-sm btn-outline" href="edit-product.php?id=<?= (int)$product['id'] ?>">Sửa</a>
      <form action="delete-product.php" method="post" onsubmit="return confirm('Xóa sản phẩm này?')">
       <input type="hidden" name="id" value="<?= (int)$product['id'] ?>">
       <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
      </form>
   </div></td>
  </tr>
  <?php endforeach; ?>
  <?php if (!$products): ?><tr><td colspan="6" class="muted">Chưa có sản phẩm.</td></tr><?php endif; ?>
  </tbody>
 </table>
</div>
<?php require __DIR__ . '/../../includes/footer.php'; ?>
