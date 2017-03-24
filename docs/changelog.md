# [Beta 0.3](#beta-03)
**Bổ sung - Thay đổi**
* Khái niệm package, bổ sung packages cms-dev cung cấp nhiều artisan cho package
* Giao diện trang quản trị hiển thị đẹp trên trên các thiết bị màn hình lớn
* Đưa phambinhcms lên packagist
* Thay đổi cách cài đặt Phambinhcms

**Fix lỗi**
* Fix lỗi hiển thị không đúng ngôn ngữ
* Fix lỗi hàm kiểm tra cập nhật trong trang module chức năng và module theme
* Fix lỗi hiển thị tại các trang tinh tức, trang tĩnh
* Fix lỗi không cập nhật thông tin tác giả

---------------
# [Beta 0.2](#beta-02)
**Bổ sung - Thay đổi**
* Giao diện cài đặt có gợi ý chi tiết, chạy cài đặt hiển thị progress bar thể hiện tiến trình cài đặt
* Hỗ trợ cài đặt bằng terminal `php artisan cms:install`
* Loại bỏ một số lệnh artisan dành cho nhà phát triển (sẽ quay lại ở phiên bản sau)
* Đổi lại cấu trúc thư mục theo cấu trúc mặc định của laravel
* Quản lí file upload bằng Filesystem
* Thư mục chứa các file upload đổi thành `storage`

**Fix lỗi**
* Fix lỗi hiển thị không đúng ngôn ngữ