# Packages (Gói)
* Giới thiệu
* Tạo một package
* Cấu trúc package
* Các artisan console trên package

## Giới thiệu
Mặc định laravel cung cấp cho bạn mô hình làm việc MVC, thời gian đầu bạn cảm thấy làm việc với mô hình này là khá ổn. Nhưng về sau, khi quy mô dự án của bạn ngày càng tăng, số lượng thành viên tham gia vào dự án càng nhiều, bạn sẽ bắt đầu cảm thấy MVC dường như là chưa đủ với bạn, bạn muốm một cái gì nữa rõ ràng hơn, mang tính đóng gói nhiều hơn.
Hiểu được điều này, Phambinhcms đã phát triển riêng một package cho phép bạn quản lí dự án theo một mô hình mạnh hơn mô hình MVC, đó là chính là khái niệm package.

## Tạo một package

Bước 1: Chạy lệnh

`php artisan make:package ten-package`

Một thư mục mới sẽ được tạo ra ở thư mục `packages/` theo cấu trúc tương tự như thư mục `app/`. Và đây chính là package của bạn vừa tạo ra. Nhưng hãy khoan, package này chưa hoạt động được đâu, bạn phải hoàn thành các bước sau đây nữa đã.

Bước 2: Chỉnh sửa `composer.json`

```json
"autoload": {
        "classmap": [
            "database"
        ],
        "psr-4": {
            "App\\": "app/",
            "Packages\\TenPackage\\": "packages/ten-package"
        }
    },
```

Bước 3: Chạy lệnh

`composer dump-autoload`

Bước 4: Mở `config/cms.php` chỉnh sửa

```php
	'providers' => [
		...
		\Packages\TenPackage\Providers\ModuleServiceProvider::class,
        	\Packages\TenPackage\Providers\RoutingServiceProvider::class,
	]
```

Giờ bạn đã có thể sử dụng package rồi đó.

## Cấu trúc một package
Một package về mặt có bản có cấu trúc tương tự với cấu trúc trong thư mục `app`, giúp bạn có thể làm quen dễ dàng ngay lập tức với package.
Và đặc biệt, đi theo mỗi package sẽ có một file `composer.json`, file này sẽ lưu thông tin về package của bạn như: Tên package, tên tác giả, mô tả về package,... Đồng thời file `composer.json` sẽ được sử dụng đến khi các bạn đưa package của mình lên [Packagist](http://packagist.org), giúp bạn có thể quản lí phiên bản package của mình hoặc có thể dễ dàng chia sẻ, cài đặt bằng [Composer](http://getcomposer.org).

## Artisan console trên package
Nếu như laravel cung cấp Artisan console làm việc trên thư mục `app/`, thì cms-dev cung cấp các artisan làm việc trên package. Các Artisan console trên package sẽ được liệt kê dưới đây

**Tạo Controller**

`php artisan package:make:controller <ten-package> <TenController> --resource`

Tùy chọn --resource sẽ giúp bạn tạo ra một [controller resource](https://laravel.com/docs/5.4/controllers#resource-controllers)


**Tạo Model**

`php artisan package:make:model <ten-package> <TenModel> --migration} --controller --resource`


**Tạo Command**

`php artisan package:make:command <ten-package> <TenCommand>`

**Tạo Request**

`php artisan package:make:request <ten-package> <TenRequest>`

**Tạo Provider**

`php artisan package:make:provider <ten-package> <TenProvider>`

và còn nhiều artisan console khác, bạn có thể xem bằng cách

`php artisan list`
---
Package cms-dev vẫn đang trong quá trình hoàn thiện nốt, rất mong nhận được góp ý cũng như báo lỗi từ các bạn.
