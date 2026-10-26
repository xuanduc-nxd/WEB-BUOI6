# Kết quả kiểm thử Buổi 06

Ngày kiểm thử: 26/10/2026. Môi trường: PHP 8.0.30, Composer 2.10.3, MariaDB 10.4.32 (instance tạm riêng), SQLite trong bộ nhớ.

| Kiểm tra | Kết quả |
| --- | --- |
| `composer validate --no-check-publish` và `composer dump-autoload` | Đạt; class Product/Category nạp được qua PSR-4. Composer chỉ nhắc chưa khai báo license. |
| `php -l` toàn bộ file PHP | Đạt, không lỗi cú pháp. |
| `php tests/php/smoke.php` | Đạt: Repository CRUD, JOIN, Controller List, validation và escape HTML. |
| HTTP trên PHP server + MariaDB tạm | Đạt: trang chủ, CSS, danh sách, form, chi tiết, URL CRUD, thông báo. |
| Dữ liệu không hợp lệ | Đạt: giá âm, tồn kho âm, Category không tồn tại, slug sai và slug trùng. |
| ID và phương thức HTTP | Đạt: `id=0`, `id=abc`, ID không tồn tại trả 404; Delete bằng GET trả 405; Delete bản ghi không tồn tại trả 404. |
| CRUD và khóa ngoại | Đạt: tạo/sửa/xóa Product và Category; không xóa Category còn Product; redirect 303 sau POST thành công. |
| XSS | Đạt: tên Product chứa `<script>alert(1)</script>` được escape thành văn bản. |

Lỗi đã gặp và cách sửa:

1. `composer.json` có dòng `//` nên Composer báo JSON không hợp lệ. Đã bỏ comment khỏi JSON và chuyển giải thích PSR-4 vào README.
2. `database/database.sql` tạo `vkushop` nhưng lại `USE vku_shop`. Đã thống nhất là `vku_shop` theo `config/database.php`.
3. MySQL mặc định trên máy không chạy. Đã tạo MariaDB tạm với data riêng, import SQL mẫu, kiểm thử HTTP và dọn instance/data test sau khi xong.

Baseline trước refactor không thể kiểm thử với MySQL vì dịch vụ chưa chạy lúc bắt đầu. Kiểm thử sau refactor đã chạy trên database tạm và không dùng dữ liệu MySQL cá nhân.
