<?php
/**
 * ModuleAlias: fb-comment
 * ModuleName: fb-comment
 * Description: This is the first file run of module. You can assign bootstrap or register module Services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Packages\FbComment\Providers;

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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'FbComment');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'FbComment');

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->publishes([
            __DIR__.'/../../publishes/resources' => resource_path(),
        ], 'resource');

        $this->registerPolices();
    }

    /**
     * Register the application Services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromJsonFile('fb-comment', __DIR__ .'/../../module.json');
        $this->registerAdminMenu();
    }

    private function registerPolices()
    {
        \AccessControl::define(trans('fb-comment.fb-comment').' - '.trans('fb-comment.setting'), 'admin.fb-comment.setting');
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            if (\Auth::user()->can('admin.fb-comment.setting')) {
                \AdminMenu::register('fb-comment.setting', [
                    'label'     => trans('fb-comment.fb-comment'),
                    'parent'    =>  'setting',
                    'url'       =>  route('admin.fb-comment.setting.index'),
                    'icon'      =>  'icon-social-facebook',
                ]);
            }
        });
    }
}
