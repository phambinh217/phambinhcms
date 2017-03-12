<?php
/**
 * ModuleAlias: class1
 * ModuleName: class1
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Packages\Deky\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'Deky');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'Deky');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        // Merge configs
        if (\File::exists(__DIR__ . '/../../config/config.php')) {
            $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'deky');
        }

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->registerPolices();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAdminMenu();
    }

    private function registerPolices()
    {
        \AccessControl::define('Khóa học - Xem danh sách khóa học', 'admin.course.index');
        \AccessControl::define('Khóa học - Thêm khóa học mới', 'admin.course.create');
        \AccessControl::define('Khóa học - Chỉnh sửa khóa học', 'admin.course.edit');
        \AccessControl::define('Khóa học - Ẩn khóa học', 'admin.course.disable');
        \AccessControl::define('Khóa học - Công khai khóa học', 'admin.course.enable');
        \AccessControl::define('Khóa học - Xóa khóa học', 'admin.course.destroy');
        
        \AccessControl::define('Cộng tác viên - Xem danh sách cộng tác viên', 'admin.partner.index');
        \AccessControl::define('Cộng tác viên - Thêm cộng tác viên', 'admin.partner.create');
        \AccessControl::define('Cộng tác viên - Chỉnh sửa cộng tác viên', 'admin.partner.edit');
        \AccessControl::define('Cộng tác viên - Xóa cộng tác viên', 'admin.partner.destroy');

        \AccessControl::define('Giảng viên - Xem danh sách cộng tác viên', 'admin.trainer.index');
        \AccessControl::define('Giảng viên - Thêm cộng tác viên', 'admin.trainer.create');
        \AccessControl::define('Giảng viên - Chỉnh sửa cộng tác viên', 'admin.trainer.edit');
        \AccessControl::define('Giảng viên - Xóa cộng tác viên', 'admin.trainer.destroy');

        \AccessControl::define('Học viên - Xem danh sách cộng tác viên', 'admin.student.index');
        \AccessControl::define('Học viên - Thêm cộng tác viên', 'admin.student.create');
        \AccessControl::define('Học viên - Chỉnh sửa cộng tác viên', 'admin.student.edit');
        \AccessControl::define('Học viên - Xóa cộng tác viên', 'admin.student.destroy');
        \AccessControl::define('Học viên - Thay đổi nhóm', 'admin.student.change-group');
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            \AdminMenu::register('course', [
                'parent'    =>  'main-manage',
                'label'     =>  'Khóa học',
                'url'       =>  route('admin.course.index'),
                'icon'      =>  'icon-book-open',
                'order' => '0',
            ]);

            \AdminMenu::register('course.create', [
                'parent'    =>  'course',
                'label'     =>  'Thêm khóa học mới',
                'url'       =>  route('admin.course.create'),
                'icon'      =>  'icon-note',
                ]);

            \AdminMenu::register('course.all', [
                'parent'    =>  'course',
                'label'     =>  'Tất cả khóa học',
                'url'       =>  route('admin.course.index'),
                'icon'      =>  'icon-magnifier',
                ]);

            \AdminMenu::register('course.category', [
                'parent'    =>  'course',
                'label'     =>  'Danh mục khóa học',
                'url'       =>  route('admin.course.category.index'),
                'icon'      =>  'icon-list',
            ]);

            \AdminMenu::register('partner', [
                'parent'    =>  'main-manage',
                'label'     =>  'Cộng tác viên',
                'url'       =>  route('admin.partner.index'),
                'icon'      =>  'icon-user-female',
                'order' => '3',
            ]);

            \AdminMenu::register('partner.create', [
                'parent'    =>  'partner',
                'label'     =>  'Thêm cộng tác viên mới',
                'url'       =>  route('admin.partner.create'),
                'icon'      =>  'icon-user-follow',
            ]);

            \AdminMenu::register('partner.all', [
                'parent'    =>  'partner',
                'label'     =>  'Tất cả cộng tác viên',
                'url'       =>  route('admin.partner.index'),
                'icon'      =>  'icon-magnifier',
            ]);

            \AdminMenu::register('student', [
                'parent'    =>  'main-manage',
                'label'     =>  'Học viên',
                'url'       =>  route('admin.student.index'),
                'icon'      =>  'icon-user',
                'order' => '4',
            ]);

            \AdminMenu::register('student.create', [
                'parent'    =>  'student',
                'label'     =>  'Thêm học viên mới',
                'url'       =>  route('admin.student.create'),
                'icon'      =>  'icon-user-follow',
            ]);

            \AdminMenu::register('student.all', [
                'parent'    =>  'student',
                'label'     =>  'Tất cả học viên',
                'url'       =>  route('admin.student.index'),
                'icon'      =>  'icon-magnifier',
            ]);

            \AdminMenu::register('student.group', [
                'parent'    =>  'student',
                'label'     =>  'Nhóm học viên',
                'url'       =>  route('admin.student.group.index'),
                'icon'      =>  'icon-fire',
            ]);

            \AdminMenu::register('trainer', [
                'parent'    =>  'main-manage',
                'label'     =>  'Giảng viên',
                'url'       =>  route('admin.trainer.index'),
                'icon'      =>  'icon-user-female',
                'order' => '2',
            ]);

            \AdminMenu::register('trainer.create', [
                'parent'    =>  'trainer',
                'label'     =>  'Thêm giảng viên mới',
                'url'       =>  route('admin.trainer.create'),
                'icon'      =>  'icon-user-follow',
            ]);

            \AdminMenu::register('trainer.all', [
                'parent'    =>  'trainer',
                'label'     =>  'Tất cả giảng viên',
                'url'       =>  route('admin.trainer.index'),
                'icon'      =>  'icon-magnifier',
            ]);

            \AdminMenu::register('work', [
                'parent'    =>  '0',
                'label'     =>  'Công việc',
                'order' => '5',
            ]);

            \AdminMenu::register('work.course', [
                'parent'    =>  'work',
                'label'     =>  'Giới thiệu khóa học',
                'url'       =>  route('admin.course.intro'),
                'icon'      =>  'icon-book-open',
            ]);

            \AdminMenu::register('work.my-class', [
                'parent'    =>  'work',
                'label'     =>  'Lớp học của tôi',
                'url'       =>  route('admin.my-class.index'),
                'icon'      =>  'icon-briefcase',
            ]);

            \AdminMenu::register('work.my-student', [
                'parent'    =>  'work',
                'label'     =>  'Học viên của tôi',
                'url'       =>  route('admin.my-student.index'),
                'icon'      =>  'icon-users',
            ]);

            \AdminMenu::register('deky.setting', [
                'parent'    =>  'setting',
                'label'     =>  'Cài đặt khóa học',
                'url'       =>  route('admin.setting.partner'),
                'icon'      =>  'icon-book-open',
            ]);

            \AdminMenu::register('partner.setting', [
                'parent'    =>  'deky.setting',
                'label'     =>  'Cài đặt cộng tác viên',
                'url'       =>  route('admin.setting.partner'),
                'icon'      =>  'icon-user',
            ]);

            \AdminMenu::register('trainer.setting', [
                'parent'    =>  'deky.setting',
                'label'     =>  'Cài đặt giảng viên',
                'url'       =>  route('admin.setting.trainer'),
                'icon'      =>  'icon-user',
            ]);

            \AdminMenu::register('student.setting', [
                'parent'    =>  'deky.setting',
                'label'     =>  'Cài đặt học viên',
                'url'       =>  route('admin.setting.student'),
                'icon'      =>  'icon-user',
            ]);
        });
    }
}
