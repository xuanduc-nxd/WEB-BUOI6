## STARTER — công việc trên lớp

1. Chạy baseline hiện tại: danh sách Product/Category và CRUD vẫn hoạt động bằng PHP truyền thống.
2. **P1/P2:** nhìn lại SQL Product trong `public/products.php`; viết `ProductRepository::all()` giữ đúng JOIN và `category_name`.
3. **Composer:** kiểm tra `composer.json`, chạy `composer dump-autoload`, nạp class theo namespace.
4. **P3/P4/P5:** viết `ProductController::index()`; chuyển HTML từ entry sang `views/products/index.php`.
5. Sửa `public/products.php` để chỉ bootstrap, tạo Controller/Repository và gọi `index()`.
6. **C1–C4:** tự làm tương tự cho Category, giữ nguyên các liên kết CRUD.
7. Chạy checklist kiểm thử và `git commit`.

**Chú ý:** Starter cố tình giữ List theo code cũ để chạy ngay, class có TODO chưa hoạt động; chỉ chuyển entry sang Controller **sau khi** hoàn tất class và View. Các file Create/Edit/Delete là baseline chạy được, không yêu cầu chuyển trong giờ.
