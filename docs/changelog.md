# [Beta 02](#beta-02)
**Bổ sung - Thay đổi**
* Giao diện cài đặt có gợi ý chi tiết, chạy cài đặt hiển thị progress bar thể hiện tiến trình cài đặt
* Hỗ trợ cài đặt bằng terminal `php artisan cms:install`
* Loại bỏ một số lệnh artisan dành cho nhà phát triển (sẽ quay lại ở phiên bản sau)
* Đổi lại cấu trúc thư mục theo cấu trúc mặc định của laravel
* Quản lí file upload bằng Filesystem
* Thư mục chứa các file upload đổi thành `storage`

**Fix lỗi**
* Fix lỗi hiển thị không đúng ngôn ngữ
* Các trang lỗi 404, 403 hiển thị giao diện có css