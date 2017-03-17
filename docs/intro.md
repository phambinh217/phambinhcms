# Giới thiệu
Phambinhcms đơn giản giống như một start project đối với dự án laravel framework. Nó cung cấp các chức năng cơ bản của một một dự án thông thường như:
* Quản lí thành viên
* Phân quyền thành viên
* Quản lí tin tức
* Quản lí các bài giới thiệu
* Menu
* ...

Phambinhcms sử dụng trên nền tảng [laravel 5.4](http://laravel.com) (Phiên bản mới nhất tính đến thời điểm ngày 13/03/2017) để làm backend, giao diện [metronic material](http://keenthemes.com/preview/metronic/theme/admin_4/) để làm Frontend.
Đặc biệt Phambinhcms có thao tác với form vô cùng đơn giản, validate nhanh, rõ ràng. Các view được tổ chức dưới dạng components có thể sử dụng lại được nhiều. Ngoài ra Phambinhcms còn có cơ chế hook, filter, widget giống wordpress (Tuy chưa được mạnh mẽ như wordpress) hứa hẹn một ngày nào đó sẽ đem lại cảm giác thú vị cho cả người sử dụng và người phát triển.

Phambinhcms được tổ chức dưới dạng các module, mỗi module là một chức năng, nếu bạn thấy dự án của mình không cần thiết với chức năng nào mà Phambinhcms cung cấp sẵn thì bạn hoàn toàn có thể gỡ module đó ra mà không làm ảnh hưởng đến sự vận hành của mã nguồn.

# Cách hoạt động của Phambinhcms
Phambinhcms được đóng gói thành packages nằm tại `vendor/phambinh/cms`, và kết nối với laravel thông qua provider `Phambinh\Cms\Providers\ModuleServiceProvider::class`. Tại provider này, tiếp tục load thêm nhiều thành phần khác mà bạn có thể xem tại `config/cms.php`
