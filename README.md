# VKUShop — Buổi 06: OOP + Composer + MVC-lite

**Học phần:** Công nghệ và lập trình web · VKU
**Mục tiêu:** refactor lại Product List và Category List, giữ nguyên các chức năng CRUD từ Buổi 4.

## Phạm vi và lưu ý nguồn gốc

Bộ này được xây dựng từ khung giảng dạy, slide và giáo án Buổi 6, cộng với các yêu cầu đã học ở Buổi 4–5. **File `VKUShop_Buoi04_Completed.zip` không có trong bộ đính kèm**, vì vậy đây là **baseline VKUShop tái dựng** thay vì bản sao từng dòng code/UI gốc. Có thể so sánh và đồng bộ giao diện hoặc DB với source Buổi 4 đang dùng tại lớp trước khi phát cho sinh viên.

Schema mẫu: `categories(id, name, slug)` và `products(id, category_id, name, price, stock)`. Không thêm bảng mới, không bổ sung nghiệp vụ mới trong Buổi 6.

## Yêu cầu môi trường

- PHP 8.0+; extension `pdo_mysql` bật; MySQL/MariaDB đang chạy.
- Composer 2 (dùng **autoload PSR-4**, không cài package nào khác).
- Browser; terminal; hoặc XAMPP trên Windows.

## Bước 1 — Import database

Dùng phpMyAdmin → Import `database/database.sql` vào MySQL. SQL có dữ liệu mẫu, và **không DROP bảng**; tuy vậy chỉ import vào database demo, không ghi đè dữ liệu học viên đang cần giữ.

Tùy máy, đổi host/user/password qua biến môi trường hoặc `config/database.php` (mặc định `127.0.0.1:3306`, DB `vkushop`, user `root`, mật khẩu rỗng).

## Bước 2 — Tạo Composer autoload

Mở terminal **tại thư mục chứa composer.json**:

```bash
composer --version
composer dump-autoload
```

Lệnh trên tạo `vendor/autoload.php`. **Thư mục vendor không được đóng gói**; mỗi máy tự tạo bằng Composer.

Mapping PSR-4: `App\` → `src/`. Ví dụ: `App\Repositories\ProductRepository` → `src/Repositories/ProductRepository.php`.

## Bước 3 — Chạy web

```bash
php -S localhost:8000 -t public
```

Truy cập:

- http://localhost:8000/
- http://localhost:8000/products.php
- http://localhost:8000/categories.php

**XAMPP:** nên cấu hình DocumentRoot của project trỏ vào thư mục `public/` hoặc truy cập `http://localhost/<folder>/public/`. Các link CRUD dùng đường dẫn tương đối nên không cần Router. Chỉ nên xuất bản thư mục `public/` khi deploy thực tế (không để `config/`, `src/`, `database/`, `vendor/` thành tài nguyên web công khai).

## Không dạy / không làm trong Buổi 6

Không có Laravel, DI Container, Interface, Inheritance, Routing framework, Session/Login, Search/Filter/Pagination/Upload. Các tính năng đó học ở các buổi sau.

## Kiểm thử hồi quy

Tham khảo `TEST_CHECKLIST.md`. Test trực tiếp các chức năng List, Create, Edit, Delete của cả Product và Category; JOIN, slug trùng, FK khi xóa danh mục, ID sai, escaping, CSS/link.

## Bài tập về nhà — BẮT BUỘC NỘP

Refactor nốt Create/Edit/Delete của Product + Category sang MVC-lite. Giữ validation, prepared statements và redirect sau POST. Không cần Router hoặc thêm chức năng mới. Nộp source, composer.json, hướng dẫn chạy và Git commit.
## STARTER — công việc trên lớp

1. Chạy baseline hiện tại: danh sách Product/Category và CRUD vẫn hoạt động bằng PHP truyền thống.
2. **P1/P2:** nhìn lại SQL Product trong `public/products.php`; viết `ProductRepository::all()` giữ đúng JOIN và `category_name`.
3. **Composer:** kiểm tra `composer.json`, chạy `composer dump-autoload`, nạp class theo namespace.
4. **P3/P4/P5:** viết `ProductController::index()`; chuyển HTML từ entry sang `views/products/index.php`.
5. Sửa `public/products.php` để chỉ bootstrap, tạo Controller/Repository và gọi `index()`.
6. **C1–C4:** tự làm tương tự cho Category, giữ nguyên các liên kết CRUD.
7. Chạy checklist kiểm thử và `git commit`.

**Chú ý:** Starter cố tình giữ List theo code cũ để chạy ngay, class có TODO chưa hoạt động; chỉ chuyển entry sang Controller **sau khi** hoàn tất class và View. Các file Create/Edit/Delete là baseline chạy được, không yêu cầu chuyển trong giờ.
