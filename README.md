# VKUShop — Buổi 06: OOP + Composer + MVC-lite

**Học phần:** Công nghệ và lập trình web · VKU
**Mục tiêu:** refactor Product/Category List và toàn bộ Create/Edit/Delete sang MVC-lite, giữ URL và hành vi CRUD.

## Phạm vi và lưu ý nguồn gốc

Bộ này được xây dựng từ khung giảng dạy, slide và giáo án Buổi 6, cộng với các yêu cầu đã học ở Buổi 4–5. **File `VKUShop_Buoi04_Completed.zip` không có trong bộ đính kèm**, vì vậy đây là **baseline VKUShop tái dựng** thay vì bản sao từng dòng code/UI gốc. Có thể so sánh và đồng bộ giao diện hoặc DB với source Buổi 4 đang dùng tại lớp trước khi phát cho sinh viên.

Schema mẫu: `categories(id, name, slug)` và `products(id, category_id, name, price, stock)`. Không thêm bảng mới, không bổ sung nghiệp vụ mới trong Buổi 6.

## Yêu cầu môi trường

- PHP 8.0+; extension `pdo_mysql` bật; MySQL/MariaDB đang chạy.
- Composer 2 (dùng **autoload PSR-4**, không cài package nào khác).
- Browser; terminal; hoặc XAMPP trên Windows.

## Bước 1 — Import database

Dùng phpMyAdmin → Import `database/database.sql` vào MySQL. SQL có dữ liệu mẫu, và **không DROP bảng**; tuy vậy chỉ import vào database demo, không ghi đè dữ liệu học viên đang cần giữ.

Tùy máy, đổi host/user/password qua biến môi trường hoặc `config/database.php` (mặc định `127.0.0.1:3306`, DB `vku_shop`, user `root`, mật khẩu rỗng).

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

## Luồng mã nguồn

`GET /products.php` → `public/products.php` (entry, bootstrap) → `ProductController::index()` (điều phối) → `ProductRepository::all()` (SQL/PDO) → `views/products/index.php` (HTML). Category đi theo luồng tương tự. `App\` ánh xạ tới `src/`, nên `App\Repositories\\ProductRepository` nằm ở `src/Repositories/ProductRepository.php`. PDO được truyền qua constructor để các method dùng chung một kết nối và dễ kiểm thử.

Muốn đổi SQL JOIN thì sửa `ProductRepository::all()`; muốn đổi bảng HTML thì sửa View. Các câu SQL có tham số trong `findById()`, `create()`, `update()` và `delete()` dùng prepared statement; `all()` dùng `query()` vì SQL cố định, không chứa dữ liệu từ request.

Các entry trong `public/` chỉ bootstrap và gọi Controller. Controller xử lý GET/POST, validation và redirect. Repository chỉ truy xuất dữ liệu. View trình bày HTML và dùng `e()` để escape dữ liệu người dùng.

## Ngoài phạm vi

Không có Laravel, DI Container, Interface, Inheritance, Routing framework, Session/Login, Search/Filter/Pagination/Upload. Các tính năng đó học ở các buổi sau.

## Kiểm thử hồi quy

Tham khảo `TEST_CHECKLIST.md`. Test trực tiếp các chức năng List, Create, Edit, Delete của cả Product và Category; JOIN, slug trùng, FK khi xóa danh mục, ID sai, escaping, CSS/link.

## Kiểm thử nhanh

```bash
php tests/php/smoke.php
```

Smoke test dùng SQLite trong bộ nhớ để kiểm tra Repository, danh sách và validation mà không sửa dữ liệu MySQL. Để kiểm thử đủ HTTP và các lỗi riêng của MySQL (slug trùng, khóa ngoại), import DB demo và thực hiện `TEST_CHECKLIST.md` trên trình duyệt. SQL trong `database/database.sql` đã dùng tên `vku_shop` trùng với cấu hình mặc định.

## Bài tập về nhà — BẮT BUỘC NỘP

Create/Edit/Delete của Product + Category đã được chuyển sang MVC-lite. Giữ validation, prepared statements và redirect sau POST. Nộp source, composer.json, hướng dẫn chạy và Git commit theo yêu cầu giảng viên.
