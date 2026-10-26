# Ghi chú hoàn thành bài Buổi 06

## Task 0 — Nhận diện trách nhiệm trong code cũ

Trước refactor, `public/products.php` và `public/categories.php` cùng chứa ba phần: câu `SELECT`/PDO (truy xuất dữ liệu), biến `$products` hoặc `$categories` và `require bootstrap.php` (điều phối), cùng bảng HTML/links/thông báo (hiển thị). Vì mỗi file gánh nhiều trách nhiệm nên đổi SQL hoặc giao diện đều phải sửa entry, khó kiểm thử riêng và dễ làm hỏng CRUD.

## Task 1–5 — OOP, Composer và MVC-lite

- `App\` trong `composer.json` ánh xạ tới `src/`; `App\Repositories\ProductRepository` ở `src/Repositories/ProductRepository.php`.
- Repository nhận PDO qua constructor để dùng chung kết nối và có thể truyền database test. `ProductRepository::all()` giữ `JOIN`, `category_name`, `ORDER BY p.id DESC` và trả về `fetchAll(PDO::FETCH_ASSOC)`.
- `public/products.php` và `public/categories.php` chỉ bootstrap và gọi Controller; Controller lấy dữ liệu rồi require View. SQL nằm trong Repository, HTML nằm trong View.
- `CategoryRepository::findById()` trả về `null` khi không có ID. `findById()` dùng prepared statement vì ID là dữ liệu từ request; `all()` dùng `query()` vì SQL cố định.
- Toàn bộ Create/Edit/Delete của hai module cũng đã chuyển sang Repository → Controller → View. `product-detail.php` được chuyển theo cùng luồng.

## Task 6 — Kiểm thử

Chạy `composer dump-autoload`, `php tests/php/smoke.php`, rồi thử HTTP theo `TEST_CHECKLIST.md`. Kết quả kiểm thử thực tế và lỗi đã sửa ở `TEST_REPORT.md`.
