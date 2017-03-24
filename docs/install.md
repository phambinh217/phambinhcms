# Cài đặt

## Yêu cầu server
* PHP >= 5.6.4
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* GD PHP Image Extension

## Cài đặt
Phambinhcms sử dụng [Composer](https://getcomposer.org/) để quản lí các gói thư viện bên thứ 3, vì vậy để cài đặt được Phambinhcms bạn phải đảm bảo rằng trên máy của bạn đã được cài đặt [Composer](https://getcomposer.org/).

Chạy lệnh composer sau để cài đặt.

`composer create-project --prefer-dist phambinh/phambinhcms phambinhcms dev-master`

Việc chạy lệnh trên sẽ giúp phambinhcms thực hiện các thao tác cài đặt cơ bản. Sau khi hoàn tất bước này, bạn sẽ tiến hành kết nối đến cơ sở dữ liệu.

Mở file `phambinhcms/.env` và chỉnh sửa thông tin kết nối đến cơ sở dữ liệu của bạn

`DB_CONNECTION=mysql`

`DB_HOST=localhost`

`DB_PORT=3306`

`DB_DATABASE=<your-database>`

`DB_USERNAME=<your-database-userame>`

`DB_PASSWORD=<your-database-password>`

Sau khi hoàn tất thông tin cấu hình trên. Bạn tiếp tục chạy lệnh

`php artisan cms:install`

Trên cửa sổ dòng lệnh sẽ hiển thị trình cài đặt của Phambinhcms và bạn chỉ việc làm theo hướng dẫn.

Nếu cài đặt thành công, Phambinhcms sẽ đưa ra thông tin email và mật khẩu đăng nhập cho bạn.

Chạy lệnh

`php artisan serve`

để khởi động sever

Truy cập

`locahost:8000/login`

để đăng nhập

Truy cập 

`localhost:8000/admin`

để quản trị.

---------------------------------

Trong trường hợp không thể cài đặt. Bạn có thể liên hệ với tác giả để được hỗ trợ, hoặc sử dụng issues của github.

**Lưu ý: Phambinhcms sử dụng địa chỉ email để đăng nhập**

Xin cảm ơn.