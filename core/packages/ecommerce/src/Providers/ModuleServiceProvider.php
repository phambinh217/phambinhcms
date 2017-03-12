<?php
/**
 * ModuleAlias: shop
 * ModuleName: shop
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Packages\Ecommerce\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Ecommerce');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Ecommerce');

        $this->publishes([
            __DIR__.'/../../publishes/database/migrations'  => database_path('migrations'),
            __DIR__.'/../../publishes/database/seeds'       => database_path('seeds'),
        ], 'migration');
        
        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->registerPolices();
    }

    private function registerPolices()
    {
        \AccessControl::define('Cửa hàng - Xem danh sách sản phẩm', 'admin.ecommerce.product.index');
        \AccessControl::define('Cửa hàng - Thêm sản phẩm', 'admin.ecommerce.product.create');
        \AccessControl::define('Cửa hàng - Sửa sản phẩm', 'admin.ecommerce.product.edit');
        \AccessControl::define('Cửa hàng - Ẩn sản phẩm', 'admin.ecommerce.product.disable');
        \AccessControl::define('Cửa hàng - Công khai sản phẩm', 'admin.ecommerce.product.enable');
        \AccessControl::define('Cửa hàng - Xóa sản phẩm', 'admin.ecommerce.product.destroy');

        \AccessControl::define('Cửa hàng - Xem danh sách danh mục', 'admin.ecommerce.category.index');
        \AccessControl::define('Cửa hàng - Thêm danh mục', 'admin.ecommerce.category.create');
        \AccessControl::define('Cửa hàng - Sửa danh mục', 'admin.ecommerce.category.edit');
        \AccessControl::define('Cửa hàng - Xóa danh mục', 'admin.ecommerce.category.destroy');

        \AccessControl::define('Cửa hàng - Xem danh sách thương hiệu', 'admin.ecommerce.brand.index');
        \AccessControl::define('Cửa hàng - Thêm thương hiệu', 'admin.ecommerce.brand.create');
        \AccessControl::define('Cửa hàng - Sửa thương hiệu', 'admin.ecommerce.brand.edit');
        \AccessControl::define('Cửa hàng - Xóa thương hiệu', 'admin.ecommerce.brand.destroy');

        \AccessControl::define('Cửa hàng - Xem danh sách bộ lọc', 'admin.ecommerce.filter.index');
        \AccessControl::define('Cửa hàng - Thêm bộ lọc', 'admin.ecommerce.filter.create');
        \AccessControl::define('Cửa hàng - Sửa bộ lọc', 'admin.ecommerce.filter.edit');
        \AccessControl::define('Cửa hàng - Xóa bộ lọc', 'admin.ecommerce.filter.destroy');

        \AccessControl::define('Cửa hàng - Cài đặt', 'admin.ecommerce.setting');
        \AccessControl::define('Cửa hàng - Trình duyệt sản phẩm', 'admin.ecommerce.product.browser');

        \AccessControl::define('Khách hàng - Xem danh sách', 'admin.ecommerce.customer.index');
        \AccessControl::define('Khách hàng - Thêm mới', 'admin.ecommerce.customer.create');
        \AccessControl::define('Khách hàng - Chỉnh sửa', 'admin.ecommerce.customer.edit');
        \AccessControl::define('Khách hàng - Cấm', 'admin.ecommerce.customer.disable');
        \AccessControl::define('Khách hàng - Kích hoạt', 'admin.ecommerce.customer.enable');
        \AccessControl::define('Khách hàng - Xóa', 'admin.ecommerce.customer.destroy');

        \AccessControl::define('Đơn hàng - Xem danh sách', 'admin.ecommerce.order.index');
        \AccessControl::define('Đơn hàng - Thêm mới', 'admin.ecommerce.order.create');
        \AccessControl::define('Đơn hàng - Thay đổi trạng thái', 'admin.ecommerce.order.change-status');
        \AccessControl::define('Đơn hàng - Chỉnh sửa', 'admin.ecommerce.order.edit');
        \AccessControl::define('Đơn hàng - Cài đặt', 'admin.ecommerce.setting.order');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromJsonFile('ecommerce', __DIR__ .'/../../module.json');
        \Menu::registerType('Thương hiệu', \Packages\Ecommerce\Brand::class);
        \Menu::registerType('Danh mục', \Packages\Ecommerce\Category::class);
        \Menu::registerType('Bộ lọc', \Packages\Ecommerce\Filter::class);

        $this->app['events']->listen(Logout::class, function () {
            if ($this->app['config']->get('cart.destroy_on_logout')) {
                $this->app->make(SessionManager::class)->forget('cart');
            }
        });

        $this->registerAdminMenu();
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            if (\Auth::user()->can('admin')) {
                \AdminMenu::register( 'ecommerce', [
                    'parent'=>  '0',
                    'url'   =>  route('admin.ecommerce.product.index'),
                    'label' =>  'Cửa hàng',
                    'order'     =>  '2',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.product.index')) {
                \AdminMenu::register(' ecommerce.product', [
                    'parent'=>   'ecommerce',
                    'icon'  =>  'icon-basket',
                    'url'   =>  route('admin.ecommerce.product.index'),
                    'label' =>  'Sản phẩm',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.product.create')) {
                \AdminMenu::register(' ecommerce.product.create', [
                    'parent'=>  ' ecommerce.product',
                    'icon'  =>  'icon-plus',
                    'url'   =>  route('admin.ecommerce.product.create'),
                    'label' =>  'Thêm sản phẩm mới',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.product.index')) {
                \AdminMenu::register(' ecommerce.product.index', [
                    'parent'=>  ' ecommerce.product',
                    'icon'  =>  'icon-list',
                    'url'   =>  route('admin.ecommerce.product.index'),
                    'label' =>  'Danh sách sản phẩm',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.category.index')) {
                \AdminMenu::register(' ecommerce.category', [
                    'parent'=>   'ecommerce',
                    'icon'  =>  'icon-folder',
                    'url'   =>  route('admin.ecommerce.category.index'),
                    'label' =>  'Danh mục',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.category.create')) {
                \AdminMenu::register(' ecommerce.category.create', [
                    'parent'=>  ' ecommerce.category',
                    'icon'  =>  'icon-plus',
                    'url'   =>  route('admin.ecommerce.category.create'),
                    'label' =>  'Thêm danh mục mới',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.category.index')) {
                \AdminMenu::register(' ecommerce.category.index', [
                    'parent'=>  ' ecommerce.category',
                    'icon'  =>  'icon-list',
                    'url'   =>  route('admin.ecommerce.category.index'),
                    'label' =>  'Tất cả danh mục',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.product.index')) {
                \AdminMenu::register(' ecommerce.brand', [
                    'parent'=>   'ecommerce',
                    'icon'  =>  'icon-globe',
                    'url'   =>  route('admin.ecommerce.product.index'),
                    'label' =>  'Thương hiệu',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.brand.create')) {
                \AdminMenu::register(' ecommerce.brand.create', [
                    'parent'=>  ' ecommerce.brand',
                    'icon'  =>  'icon-plus',
                    'url'   =>  route('admin.ecommerce.brand.create'),
                    'label' =>  'Thêm thương hiệu mới',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.brand.index')) {
                \AdminMenu::register(' ecommerce.brand.index', [
                    'parent'=>  ' ecommerce.brand',
                    'icon'  =>  'icon-list',
                    'url'   =>  route('admin.ecommerce.brand.index'),
                    'label' =>  'Tất cả thương hiệu',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.filter.index')) {
                \AdminMenu::register(' ecommerce.filter', [
                    'parent'=>   'ecommerce',
                    'icon'  =>  'icon-hourglass',
                    'url'   =>  route('admin.ecommerce.filter.index'),
                    'label' =>  'Bộ lọc',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.filter.create')) {
                \AdminMenu::register(' ecommerce.filter.create', [
                    'parent'=>  ' ecommerce.filter',
                    'icon'  =>  'icon-plus',
                    'url'   =>  route('admin.ecommerce.filter.create'),
                    'label' =>  'Thêm bộ lọc mới',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.filter.index')) {
                \AdminMenu::register(' ecommerce.filter.index', [
                    'parent'=>  ' ecommerce.filter',
                    'icon'  =>  'icon-list',
                    'url'   =>  route('admin.ecommerce.filter.index'),
                    'label' =>  'Tất cả bộ lọc',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.product.edit')) {
                \AdminMenu::register(' ecommerce.tag', [
                    'parent'=>   'ecommerce',
                    'icon'  =>  'icon-tag',
                    'url'   =>  route('admin.ecommerce.tag.index'),
                    'label' =>  'Thẻ',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.product.edit')) {
                \AdminMenu::register(' ecommerce.tag.create', [
                    'parent'=>  ' ecommerce.tag',
                    'icon'  =>  'icon-plus',
                    'url'   =>  route('admin.ecommerce.tag.create'),
                    'label' =>  'Thêm thẻ mới',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.product.edit')) {
                \AdminMenu::register(' ecommerce.tag.index', [
                    'parent'=>  ' ecommerce.tag',
                    'icon'  =>  'icon-list',
                    'url'   =>  route('admin.ecommerce.tag.index'),
                    'label' =>  'Tất cả thẻ',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.customer.index')) {
                \AdminMenu::register('customer', [
                    'parent'    =>  'main-manage',
                    'label'     =>  'Khách hàng',
                    'url'       =>  route('admin.ecommerce.customer.index'),
                    'icon'      =>  'icon-users',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.customer.index')) {
                \AdminMenu::register('customer.create', [
                    'parent'    =>  'customer',
                    'label'     =>  'Thêm khách hàng mới',
                    'url'       =>  route('admin.ecommerce.customer.create'),
                    'icon'      =>  'icon-user-follow',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.customer.index')) {
                \AdminMenu::register('customer.all', [
                    'parent'    =>  'customer',
                    'label'     =>  'Tất cả khách hàng',
                    'url'       =>  route('admin.ecommerce.customer.index'),
                    'icon'      =>  'icon-list',
                ]);
            }

            if (\Auth::user()->can('admin')) {
                \AdminMenu::register('sales', [
                    'order'     =>  '2',
                    'parent'    => '0',
                    'label'     =>  'Doanh số bán hàng',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.order.index')) {
                \AdminMenu::register('sales.order', [
                    'parent'    => 'sales',
                    'label'     => 'Đơn hàng',
                    'url'       => route('admin.ecommerce.order.index'),
                    'icon'      => 'icon-speech',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.order.create')) {
                \AdminMenu::register('sales.order.create', [
                    'parent'    => 'sales.order',
                    'label'     => 'Thêm đơn hàng mới',
                    'url'       => route('admin.ecommerce.order.create'),
                    'icon'      => 'icon-plus',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.order.index')) {
                \AdminMenu::register('sales.order.index', [
                    'parent'    => 'sales.order',
                    'label'     => 'Danh sách đơn hàng',
                    'url'       => route('admin.ecommerce.order.index'),
                    'icon'      => 'icon-list',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.order.index')) {
                \AdminMenu::register('sales.return', [
                    'parent'    => 'sales',
                    'label'     => 'Hàng trả lại',
                    'url'       => route('admin.ecommerce.order.index'),
                    'icon'      => 'icon-action-undo',
                ]);
            }

            if (\Auth::user()->can('admin.ecommerce.setting')) {
                \AdminMenu::register('ecommerce.setting', [
                    'parent'=>  'setting',
                    'icon'  =>  'icon-diamond',
                    'url'   =>  route('admin.ecommerce.setting.currency'),
                    'label' =>  'Cài đặt cửa hàng',
                ]);
            }

            if (\Auth::user()->can('admin')) {
                \AdminMenu::register(' ecommerce.setting.currency', [
                    'parent'=>  'ecommerce.setting',
                    'icon'  =>  'icon-diamond',
                    'url'   =>  route('admin.ecommerce.setting.currency'),
                    'label' =>  'Cài đặt tiền tệ',
                ]);
            }

            if (\Auth::user()->can('admin')) {
                \AdminMenu::register(' ecommerce.setting.customer', [
                    'parent'=>  'ecommerce.setting',
                    'icon'  =>  'icon-users',
                    'url'   =>  route('admin.ecommerce.setting.customer'),
                    'label' =>  'Cài đặt khách hàng',
                ]);
            }
            
            if (\Auth::user()->can('admin.ecommerce.setting.order')) {
                \AdminMenu::register('ecommerce.setting.order', [
                    'parent'    => 'ecommerce.setting',
                    'label'     => 'Cài đặt đơn hàng',
                    'url'       => route('admin.ecommerce.setting.order'),
                    'icon'      => 'icon-speech',
                ]);
            }
        });
    }
}
