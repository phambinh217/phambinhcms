<?php
/**
 * ModuleAlias: document
 * ModuleName: document
 * Description: This is the first file run of module. You can assign bootstrap or register module Services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Packages\Document\Providers;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application Services.
     *
     * @return void
     */
    public function boot()
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Document');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Document');

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->publishes([
            __DIR__.'/../../publishes/database/migrations' => database_path('migrations'),
        ], 'migration');

        $this->registerPolices();
    }

    /**
     * Register the application Services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromJsonFile('document', __DIR__ .'/../../module.json');
        $this->registerAdminMenu();
    }

    private function registerPolices()
    {
        \AccessControl::define('Tài liệu - Danh sách bài viết', 'admin.document.index');
        \AccessControl::define('Tài liệu - Thêm bài viết mới', 'admin.document.create');
        \AccessControl::define('Tài liệu - Chỉnh sửa bài viết', 'admin.document.edit');
        \AccessControl::define('Tài liệu - Ẩn bài viết', 'admin.document.disable');
        \AccessControl::define('Tài liệu - Công khai bài viết', 'admin.document.enable');
        \AccessControl::define('Tài liệu - Xóa bài viết', 'admin.document.destroy');
        \AccessControl::define('Tài liệu - Danh sách phiên bản', 'admin.document.version.index');
        \AccessControl::define('Tài liệu - Thêm phiên bản mới', 'admin.document.version.create');
        \AccessControl::define('Tài liệu - Xóa phiên bản', 'admin.document.destroy');
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            if (\Auth::user()->can('admin.document.index')) {
                \AdminMenu::register('document', [
                    'parent'    =>  'main-manage',
                    'label'     =>  'Tài liệu',
                    'url'       =>  route('admin.document.index'),
                    'icon'      =>  'icon-book-open',
                    'order' => '1',
                ]);
            }

            if (\Auth::user()->can('admin.document.create')) {
                \AdminMenu::register('document.create', [
                    'parent'    =>  'document',
                    'label'     =>  'Thêm bài viết mới',
                    'url'       =>  route('admin.document.create'),
                    'icon'      =>  'icon-note',
                ]);
            }

            if (\Auth::user()->can('admin.document.index')) {
                \AdminMenu::register('document.all', [
                    'parent'    =>  'document',
                    'label'     =>  'Tất cả bài viết',
                    'url'       =>  route('admin.document.index'),
                    'icon'      =>  'icon-magnifier',
                ]);
            }

            if (\Auth::user()->can('admin.document.version.index')) {
                \AdminMenu::register('document.version', [
                    'parent'    =>  'document',
                    'label'     =>  'Phiên bản tài liệu',
                    'url'       =>  route('admin.document.version.index'),
                    'icon'      =>  'icon-list',
                ]);
            }
        });
    }
}
