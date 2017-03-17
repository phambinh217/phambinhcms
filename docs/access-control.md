# Giới thiệu
Khi làm việc với các dự án, chúng ta thường gặp phải bài toán phân quyền đối với nhiều thanh viên khác nhau. Ví dụ như `super admin`, `admin`, `customer`... Hiểu được điều đó, Phambinhcms đã phát triên một lớp giúp các dev có thể sử dụng chức năng này một cách đơn giản nhất
Bạn nên xem qua bài viết này trước
* [Laravel docs - Authorization](https://laravel.com/docs/5.4/authorization)

# Cách sử dụng
## Đăng ký
`\AccessControl::define('Tên quyền', 'namespace')`
Việc đăng ký một quyền thường sẽ đặt trong phương thức `boot()` của provider. Bạn cũng có thể tham khảo những quyền đã được Phambinhcms đăng ký tại `Phambinh\Cms\Providers\ModuleServiceProvider@boot`

## Kiểm tra

