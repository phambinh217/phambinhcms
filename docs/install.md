# Cài đặt
Hiện tại Phambinhcms mới chỉ có mặt trên github, bạn có thể download phiên bản mới nhất bằng cách clone hoặc download zip repo về máy.

**Clone**
`git clone https://github.com/phambinh217/phambinhcms.git`

**Cài đặt phía lệnh artisan**

Cập nhật thông tin kết nối đến database của bạn trong file .env

`
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
`

Chạy lệnh artisan ([Tìm hiểu về artisan](https://laravel.com/docs/5.4/artisan))

`php artisan cms:install`

để hiện thị cài đặt theo thuật sĩ.

Sau khi cài đặt xong. Chạy lệnh

`php artisan serve`

Sau đó truy cập

`localhost:8000/login`

để đăng nhập

Truy cập 

`localhost:8000/admin`

để quản trị website.

**Cài đặt phía website**

Sau khi có được repo trên máy. Các bạn truy cập vào

`<your-project>/public`

để cài đặt

Trong trường hợp trình duyệt không hiểu thị giao diện cài đặt. Bạn hãy truy cập

`<your-project>/public/install`

để cài đặt.

---------------------------------

Trong trường hợp không thể cài đặt. Bạn có thể liên hệ với tác giả để được hỗ trợ, hoặc sử dụng issues của github.

**Lưu ý: Phambinhcms sử dụng địa chỉ email để đăng nhập**

Xin cảm ơn.