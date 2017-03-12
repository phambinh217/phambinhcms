1, Install Packagescms
2, run `composer require Packages/ecommerce dev-master`
3, Open config/cms.php, append
\Packages\Ecommerce\Providers\ModuleServiceProvider::class,
\Packages\Ecommerce\Providers\ModuleServiceProvider::class,
\Packages\Ecommerce\Providers\ModuleServiceProvider::class,
\Packages\Ecommerce\Home\Providers\ModuleServiceProvider::class,
