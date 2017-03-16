const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */
elixir.config.sourcemaps = false;
elixir(mix => {
    mix
        // .sass('admin/apps/inbox.scss', '../assets/admin/apps/css/inbox.min.css')
        // .sass('admin/apps/ticket.scss', '../assets/admin/apps/css/ticket.min.css')
        // .sass('admin/apps/todo.scss', '../assets/admin/apps/css/todo.min.css')
        // .sass('admin/apps/todo-2.scss', '../assets/admin/apps/css/todo-2.min.css')
        // .sass('admin/global/plugins.scss', '../assets/admin/global/css/plugins.min.css')
        // .sass('admin/global/plugins-md.scss', '../assets/admin/global/css/plugins-md.min.css')
        // .sass('admin/layouts/layout4/customs.scss', '../assets/admin/layouts/layout4/css/customs.min.css')
        // .sass('admin/layouts/layout4/layout.scss', '../assets/admin/layouts/layout4/css/layout.min.css')
        // .sass('admin/layouts/layout4/themes/default.scss', '../assets/admin/layouts/layout4/css/themes/default.min.css')
        // .sass('admin/layouts/layout4/themes/light.scss', '../assets/admin/layouts/layout4/css/themes/light.min.css')
        
        // .sass('admin/global/components.scss', '../assets/admin/global/css/components.min.css')
        .sass('admin/global/components-md.scss', '../assets/admin/global/css/components-md.min.css')
        // .sass('admin/global/components-rounded.scss', '../assets/admin/global/css/components-rounded.min.css')
        // .sass('admin/bootstrap.scss', '../assets/admin/global/plugins/bootstrap/css/bootstrap.min.css')
        // .sass('admin/layouts/layout4/custom.scss', '../assets/admin/layouts/layout4/css/custom.min.css')
        
        // .sass('admin/pages/about.scss', '../assets/admin/pages/css/about.min.css')
        // .sass('admin/pages/blog.scss', '../assets/admin/pages/css/blog.min.css')
        // .sass('admin/pages/coming-soon.scss', '../assets/admin/pages/css/coming-soon.min.css')
        // .sass('admin/pages/contact.scss', '../assets/admin/pages/css/contact.min.css')
        // .sass('admin/pages/image-crop.scss', '../assets/admin/pages/css/image-crop.min.css')
        // .sass('admin/pages/invoice.scss', '../assets/admin/pages/css/invoice.min.css')
        // .sass('admin/pages/invoice-2.scss', '../assets/admin/pages/css/invoice-2.min.css')
        // .sass('admin/pages/lock-2.scss', '../assets/admin/pages/css/lock-2.min.css')
        // .sass('admin/pages/login-2.scss', '../assets/admin/pages/css/login-2.min.css')
        // .sass('admin/pages/login-3.scss', '../assets/admin/pages/css/login-3.min.css')
        // .sass('admin/pages/login-4.scss', '../assets/admin/pages/css/login-4.min.css')
        // .sass('admin/pages/login-5.scss', '../assets/admin/pages/css/login-5.min.css')
        // .sass('admin/pages/portfolio.scss', '../assets/admin/pages/css/portfolio.min.css')
        // .sass('admin/pages/pricing.scss', '../assets/admin/pages/css/pricing.min.css')
        // .sass('admin/pages/profile.scss', '../assets/admin/pages/css/profile.min.css')
        // .sass('admin/pages/profile-2.scss', '../assets/admin/pages/css/profile-2.min.css')
        // .sass('admin/pages/search.scss', '../assets/admin/pages/css/search.min.css')
        // .sass('admin/pages/tasks.scss', '../assets/admin/pages/css/tasks.min.css')

        // .sass('app.scss', '../assets/app/css/app.min.css')
        // .webpack('app.js', '../assets/app/js/app.js')
});
