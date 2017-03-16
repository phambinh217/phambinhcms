<?php
/**
 * ModuleAlias: news
 * ModuleName: news
 * Description: This is the first file run of module. You can assign bootstrap or register module services
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
namespace Phambinh\News\Providers;

use Illuminate\Support\Facades\Gate;
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
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'News');

        // Load translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'News');

        // Load helper
        if (\File::exists(__DIR__ . '/../../helper/helper.php')) {
            include __DIR__ . '/../../helper/helper.php';
        }

        $this->publishes([
            __DIR__.'/../../publishes/resources' => resource_path(),
        ], 'resource');
        
        $this->publishes([
            __DIR__.'/../../publishes/database/migrations' => database_path('migrations'),
        ], 'migration');

        $this->registerPolicies();
    }

    public function registerPolicies()
    {
        \AccessControl::define(trans('news.news') .' - '. trans('news.list-news'), 'admin.news.index');
        \AccessControl::define(trans('news.news') .' - '. trans('news.add-new-news'), 'admin.news.create');
        \AccessControl::define(trans('news.news') .' - '. trans('news.edit-news'), 'admin.news.edit');
        \AccessControl::define(trans('news.news') .' - '. trans('news.disable-news'), 'admin.news.disable');
        \AccessControl::define(trans('news.news') .' - '. trans('news.enable-news'), 'admin.news.enable');
        \AccessControl::define(trans('news.news') .' - '. trans('news.destroy-news'), 'admin.news.destroy');

        \AccessControl::define(trans('news.news') .' - '. trans('news.category.list-category'), 'admin.news.category.index');
        \AccessControl::define(trans('news.news') .' - '. trans('news.category.add-new-category'), 'admin.news.category.create');
        \AccessControl::define(trans('news.news') .' - '. trans('news.category.edit-category'), 'admin.news.category.edit');
        \AccessControl::define(trans('news.news') .' - '. trans('news.category.destroy'), 'admin.news.category.destroy');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        \Module::registerFromComposerJson(__DIR__.'/../..');
        \Menu::registerType('Danh mục tin', \Phambinh\News\Category::class);
        $this->registerAdminMenu();
    }

    private function registerAdminMenu()
    {
        add_action('admin.init', function () {
            if (\Auth::user()->can('admin.news.index')) {
                \AdminMenu::register('news', [
                    'parent'    =>  'main-manage',
                    'label'     =>  trans('news.news'),
                    'url'       =>  route('admin.news.index'),
                    'icon'      =>  'icon-notebook',
                    'order' => '1',
                ]);
            }

            if (\Auth::user()->can('admin.news.create')) {
                \AdminMenu::register('news.create', [
                    'parent'    =>  'news',
                    'label'     =>  trans('news.add-new-news'),
                    'url'       =>  route('admin.news.create'),
                    'icon'      =>  'icon-note',
                ]);
            }

            if (\Auth::user()->can('admin.news.index')) {
                \AdminMenu::register('news.all', [
                    'parent'    =>  'news',
                    'label'     =>  trans('news.list-news'),
                    'url'       =>  route('admin.news.index'),
                    'icon'      =>  'icon-magnifier',
                ]);
            }

            if (\Auth::user()->can('admin.news.category.index')) {
                \AdminMenu::register('news.category', [
                    'parent'    =>  'news',
                    'label'     =>  trans('news.category.category'),
                    'url'       =>  route('admin.news.category.index'),
                    'icon'      =>  'icon-list',
                ]);
            }
        });
    }
}
