# TEST CHECKLIST — Buổi 06

Đánh dấu cả trước và sau refactor:

- [ ] Trang chủ, link nav và CSS không lỗi.
- [ ] Product List chạy, hiển thị **tên Category bằng JOIN**, giá/tồn kho đúng.
- [ ] Category List chạy, hiển thị tên và slug đúng.
- [ ] Create Product hợp lệ; giá sai; stock âm; Category không tồn tại.
- [ ] Edit Product thành công; `id=0`, `id=abc`, `id=999999` có thông báo 404.
- [ ] Delete Product bằng POST; GET trả HTTP 405.
- [ ] Create Category; slug trùng báo lỗi, không fatal.
- [ ] Edit Category; slug trùng báo lỗi, không fatal.
- [ ] Delete Category không có Product thành công.
- [ ] Delete Category đang được Product tham chiếu: bị chặn, có thông báo.
- [ ] Output `<script>alert(1)</script>` trong name hiển thị thành văn bản, không chạy JS.
- [ ] Trang Edit/Create/Delete không 404 sau khi List refactor.
- [ ] `composer dump-autoload` xong không còn `Class not found`.
- [ ] `git add .` / `git commit -m "Buoi 06 - OOP Composer MVC-lite refactor"`.

## Checkpoint

| A (50') | `ProductRepository` nhận PDO, `all()` có JOIN và trả về mảng. |
| B (70') | Composer PSR-4 nạp class được. |
| C (125') | Product List chạy qua Controller/Repository/View, CRUD cũ không hỏng. |
| D (160') | Category List tự refactor tương tự. |
| E (180') | Test lại 2 List và 2 CRUD. |

**Kiểm thử tự động trong bộ:** `tests/php/smoke.php` là smoke test **không cần MySQL** cho lớp Repository/Controller của Completed; kiểm thử CRUD ghi dữ liệu bắt buộc chạy thủ công trên MySQL/MariaDB.
