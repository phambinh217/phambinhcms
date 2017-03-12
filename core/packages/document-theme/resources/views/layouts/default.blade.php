@extends('DocumentTheme::layouts.blank', [

])

@section('main')
	<span class="overlay"></span>
    <nav class="main">
        <a href="https://laravel.com/" class="brand nav-block">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="84.1px" height="57.6px" viewBox="0 0 84.1 57.6" enable-background="new 0 0 84.1 57.6" xml:space="preserve">
                <defs>
                </defs>
                <path fill="#FB503B" d="M83.8,26.9c-0.6-0.6-8.3-10.3-9.6-11.9c-1.4-1.6-2-1.3-2.9-1.2s-10.6,1.8-11.7,1.9c-1.1,0.2-1.8,0.6-1.1,1.6
    c0.6,0.9,7,9.9,8.4,12l-25.5,6.1L21.2,1.5c-0.8-1.2-1-1.6-2.8-1.5C16.6,0.1,2.5,1.3,1.5,1.3c-1,0.1-2.1,0.5-1.1,2.9
    c1,2.4,17,36.8,17.4,37.8c0.4,1,1.6,2.6,4.3,2c2.8-0.7,12.4-3.2,17.7-4.6c2.8,5,8.4,15.2,9.5,16.7c1.4,2,2.4,1.6,4.5,1
    c1.7-0.5,26.2-9.3,27.3-9.8c1.1-0.5,1.8-0.8,1-1.9c-0.6-0.8-7-9.5-10.4-14c2.3-0.6,10.6-2.8,11.5-3.1C84.2,28,84.4,27.5,83.8,26.9z
     M37.5,36.4c-0.3,0.1-14.6,3.5-15.3,3.7c-0.8,0.2-0.8,0.1-0.8-0.2C21.2,39.6,4.4,4.8,4.1,4.4c-0.2-0.4-0.2-0.8,0-0.8
    c0.2,0,13.5-1.2,13.9-1.2c0.5,0,0.4,0.1,0.6,0.4c0,0,18.7,32.3,19,32.8C38,36.1,37.8,36.3,37.5,36.4z M77.7,43.9
    c0.2,0.4,0.5,0.6-0.3,0.8c-0.7,0.3-24.1,8.2-24.6,8.4c-0.5,0.2-0.8,0.3-1.4-0.6s-8.2-14-8.2-14L68.1,32c0.6-0.2,0.8-0.3,1.2,0.3
    C69.7,33,77.5,43.6,77.7,43.9z M79.3,26.3c-0.6,0.1-9.7,2.4-9.7,2.4l-7.5-10.2c-0.2-0.3-0.4-0.6,0.1-0.7c0.5-0.1,9-1.6,9.4-1.7
    c0.4-0.1,0.7-0.2,1.2,0.5c0.5,0.6,6.9,8.8,7.2,9.1C80.3,26,79.9,26.2,79.3,26.3z" />
            </svg>
            <span>Laravel</span>
        </a>
        <div class="search nav-block">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/" x="0px" y="0px" width="16px" height="16px" viewBox="0 0 16 16" enable-background="new 0 0 16 16" xml:space="preserve">
                <defs>
                </defs>
                <g>
                    <g>
                        <path fill="#A1A1A1" d="M5.8,11.7c-1.6,0-3-0.6-4.1-1.7S0,7.4,0,5.8s0.6-3,1.7-4.1C2.8,0.6,4.3,0,5.8,0s3,0.6,4.1,1.7
            c2.3,2.3,2.3,6,0,8.3C8.9,11.1,7.4,11.7,5.8,11.7z M5.8,1C4.5,1,3.3,1.5,2.4,2.4C1.5,3.3,1,4.5,1,5.8s0.5,2.5,1.4,3.4
            c0.9,0.9,2.1,1.4,3.4,1.4s2.5-0.5,3.4-1.4c1.9-1.9,1.9-5,0-6.9C8.4,1.5,7.1,1,5.8,1z" />
                    </g>
                    <g>
                        <path fill="#A1A1A1" d="M15.5,16c-0.1,0-0.3,0-0.3-0.1L9.3,10c-0.2-0.2-0.2-0.5,0-0.7s0.5-0.2,0.7,0l5.9,5.9
            c0.2,0.2,0.2,0.5,0,0.7C15.8,16,15.6,16,15.5,16z" />
                    </g>
                </g>
            </svg>
            <input placeholder="search" type="text" v-model="search" id="search-input" v-on:blur="reset" />
        </div>
        <ul class="main-nav" v-if="! search">
            <li class="nav-docs"><a href="https://laravel.com/docs">Documentation</a></li>
            <li class="nav-laracasts"><a href="https://laracasts.com/">Laracasts</a></li>
            <li class="nav-laravel-news"><a href="https://laravel-news.com/">News</a></li>
            <li class="nav-forge"><a href="https://forge.laravel.com/">Forge</a></li>
            <li class="dropdown community-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Ecosystem <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="https://github.com/laravel/laravel">GitHub</a></li>
                    <li class="divider"></li>
                    <li><a href="https://envoyer.io/">Envoyer</a></li>
                    <li><a href="https://lumen.laravel.com/">Lumen</a></li>
                    <li><a href="https://spark.laravel.com/">Spark</a></li>
                    <li class="divider"></li>
                    <li><a href="https://laracasts.com/discuss">Forums</a></li>
                    <li><a href="https://larajobs.com/?partner=5#/">Jobs</a></li>
                    <li><a href="http://www.laravelpodcast.com/">Podcast</a></li>
                    <li><a href="http://larachat.co/">Slack</a></li>
                    <li><a href="https://twitter.com/laravelphp">Twitter</a></li>
                </ul>
            </li>
        </ul>
        <div class="switcher">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                    5.3
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="../master/installation.html">Master</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="installation.html">5.3</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="../5.2/installation.html">5.2</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="../5.1/installation.html">5.1</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="../5.0/installation.html">5.0</a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem" tabindex="-1" href="../4.2/installation.html">4.2</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="responsive-sidebar-nav">
            <a href="#" class="toggle-slide menu-link btn">&#9776;</a>
        </div>
    </nav>
    <nav id="slide-menu" class="slide-menu" role="navigation">
        <div class="brand">
            <a href="https://laravel.com/">
                <img src="../../assets/img/laravel-logo-white.png" height="50">
            </a>
        </div>
        <ul class="slide-main-nav">
            <li><a href="https://laravel.com/">Home</a></li>
            <li class="nav-docs"><a href="https://laravel.com/docs">Documentation</a></li>
            <li class="nav-laracasts"><a href="https://laracasts.com/">Laracasts</a></li>
            <li class="nav-laravel-news"><a href="https://laravel-news.com/">News</a></li>
            <li class="nav-forge"><a href="https://forge.laravel.com/">Forge</a></li>
            <li class="dropdown community-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Ecosystem <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="https://github.com/laravel/laravel">GitHub</a></li>
                    <li class="divider"></li>
                    <li><a href="https://envoyer.io/">Envoyer</a></li>
                    <li><a href="https://lumen.laravel.com/">Lumen</a></li>
                    <li><a href="https://spark.laravel.com/">Spark</a></li>
                    <li class="divider"></li>
                    <li><a href="https://laracasts.com/discuss">Forums</a></li>
                    <li><a href="https://larajobs.com/?partner=5#/">Jobs</a></li>
                    <li><a href="http://www.laravelpodcast.com/">Podcast</a></li>
                    <li><a href="http://larachat.co/">Slack</a></li>
                    <li><a href="https://twitter.com/laravelphp">Twitter</a></li>
                </ul>
            </li>
        </ul>
        <div class="slide-docs-nav">
            <h2>Documentation</h2>
            <ul>
                <li>Prologue
                    <ul>
                        <li><a href="releases.html">Release Notes</a></li>
                        <li><a href="upgrade.html">Upgrade Guide</a></li>
                        <li><a href="contributions.html">Contribution Guide</a></li>
                        <li><a href="https://laravel.com/api/5.3">API Documentation</a></li>
                    </ul>
                </li>
                <li>Getting Started
                    <ul>
                        <li><a href="installation.html">Installation</a></li>
                        <li><a href="configuration.html">Configuration</a></li>
                        <li><a href="structure.html">Directory Structure</a></li>
                        <li><a href="errors.html">Errors &amp; Logging</a></li>
                    </ul>
                </li>
                <li>Dev Environments
                    <ul>
                        <li><a href="homestead.html">Homestead</a></li>
                        <li><a href="valet.html">Valet</a></li>
                    </ul>
                </li>
                <li>Core Concepts
                    <ul>
                        <li><a href="container.html">Service Container</a></li>
                        <li><a href="providers.html">Service Providers</a></li>
                        <li><a href="facades.html">Facades</a></li>
                        <li><a href="contracts.html">Contracts</a></li>
                    </ul>
                </li>
                <li>The HTTP Layer
                    <ul>
                        <li><a href="routing.html">Routing</a></li>
                        <li><a href="middleware.html">Middleware</a></li>
                        <li><a href="csrf.html">CSRF Protection</a></li>
                        <li><a href="controllers.html">Controllers</a></li>
                        <li><a href="requests.html">Requests</a></li>
                        <li><a href="responses.html">Responses</a></li>
                        <li><a href="session.html">Session</a></li>
                        <li><a href="validation.html">Validation</a></li>
                    </ul>
                </li>
                <li>Views &amp; Templates
                    <ul>
                        <li><a href="views.html">Views</a></li>
                        <li><a href="blade.html">Blade Templates</a></li>
                        <li><a href="localization.html">Localization</a></li>
                    </ul>
                </li>
                <li>JavaScript &amp; CSS
                    <ul>
                        <li><a href="frontend.html">Getting Started</a></li>
                        <li><a href="elixir.html">Compiling Assets</a></li>
                    </ul>
                </li>
                <li>Security
                    <ul>
                        <li><a href="authentication.html">Authentication</a></li>
                        <li><a href="authorization.html">Authorization</a></li>
                        <li><a href="passwords.html">Password Reset</a></li>
                        <li><a href="passport.html">API Authentication</a></li>
                        <li><a href="encryption.html">Encryption</a></li>
                        <li><a href="hashing.html">Hashing</a></li>
                    </ul>
                </li>
                <li>General Topics
                    <ul>
                        <li><a href="broadcasting.html">Broadcasting</a></li>
                        <li><a href="cache.html">Cache</a></li>
                        <li><a href="events.html">Events</a></li>
                        <li><a href="filesystem.html">File Storage</a></li>
                        <li><a href="mail.html">Mail</a></li>
                        <li><a href="notifications.html">Notifications</a></li>
                        <li><a href="queues.html">Queues</a></li>
                    </ul>
                </li>
                <li>Database
                    <ul>
                        <li><a href="database.html">Getting Started</a></li>
                        <li><a href="queries.html">Query Builder</a></li>
                        <li><a href="pagination.html">Pagination</a></li>
                        <li><a href="migrations.html">Migrations</a></li>
                        <li><a href="seeding.html">Seeding</a></li>
                        <li><a href="redis.html">Redis</a></li>
                    </ul>
                </li>
                <li>Eloquent ORM
                    <ul>
                        <li><a href="eloquent.html">Getting Started</a></li>
                        <li><a href="eloquent-relationships.html">Relationships</a></li>
                        <li><a href="eloquent-collections.html">Collections</a></li>
                        <li><a href="eloquent-mutators.html">Mutators</a></li>
                        <li><a href="eloquent-serialization.html">Serialization</a></li>
                    </ul>
                </li>
                <li>Artisan Console
                    <ul>
                        <li><a href="artisan.html">Commands</a></li>
                        <li><a href="scheduling.html">Task Scheduling</a></li>
                    </ul>
                </li>
                <li>Testing
                    <ul>
                        <li><a href="testing.html">Getting Started</a></li>
                        <li><a href="application-testing.html">Application Testing</a></li>
                        <li><a href="database-testing.html">Database</a></li>
                        <li><a href="mocking.html">Mocking</a></li>
                    </ul>
                </li>
                <li>Official Packages
                    <ul>
                        <li><a href="billing.html">Cashier</a></li>
                        <li><a href="envoy.html">Envoy</a></li>
                        <li><a href="passport.html">Passport</a></li>
                        <li><a href="scout.html">Scout</a></li>
                        <li><a href="https://github.com/laravel/socialite">Socialite</a></li>
                    </ul>
                </li>
                <li>Appendix
                    <ul>
                        <li><a href="collections.html">Collections</a></li>
                        <li><a href="helpers.html">Helpers</a></li>
                        <li><a href="packages.html">Packages</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <div class="docs-wrapper container">
        <section class="sidebar">
            <ul>
                <li>Prologue
                    <ul>
                        <li><a href="releases.html">Release Notes</a></li>
                        <li><a href="upgrade.html">Upgrade Guide</a></li>
                        <li><a href="contributions.html">Contribution Guide</a></li>
                        <li><a href="https://laravel.com/api/5.3">API Documentation</a></li>
                    </ul>
                </li>
                <li>Getting Started
                    <ul>
                        <li><a href="installation.html">Installation</a></li>
                        <li><a href="configuration.html">Configuration</a></li>
                        <li><a href="structure.html">Directory Structure</a></li>
                        <li><a href="errors.html">Errors &amp; Logging</a></li>
                    </ul>
                </li>
                <li>Dev Environments
                    <ul>
                        <li><a href="homestead.html">Homestead</a></li>
                        <li><a href="valet.html">Valet</a></li>
                    </ul>
                </li>
                <li>Core Concepts
                    <ul>
                        <li><a href="container.html">Service Container</a></li>
                        <li><a href="providers.html">Service Providers</a></li>
                        <li><a href="facades.html">Facades</a></li>
                        <li><a href="contracts.html">Contracts</a></li>
                    </ul>
                </li>
                <li>The HTTP Layer
                    <ul>
                        <li><a href="routing.html">Routing</a></li>
                        <li><a href="middleware.html">Middleware</a></li>
                        <li><a href="csrf.html">CSRF Protection</a></li>
                        <li><a href="controllers.html">Controllers</a></li>
                        <li><a href="requests.html">Requests</a></li>
                        <li><a href="responses.html">Responses</a></li>
                        <li><a href="session.html">Session</a></li>
                        <li><a href="validation.html">Validation</a></li>
                    </ul>
                </li>
                <li>Views &amp; Templates
                    <ul>
                        <li><a href="views.html">Views</a></li>
                        <li><a href="blade.html">Blade Templates</a></li>
                        <li><a href="localization.html">Localization</a></li>
                    </ul>
                </li>
                <li>JavaScript &amp; CSS
                    <ul>
                        <li><a href="frontend.html">Getting Started</a></li>
                        <li><a href="elixir.html">Compiling Assets</a></li>
                    </ul>
                </li>
                <li>Security
                    <ul>
                        <li><a href="authentication.html">Authentication</a></li>
                        <li><a href="authorization.html">Authorization</a></li>
                        <li><a href="passwords.html">Password Reset</a></li>
                        <li><a href="passport.html">API Authentication</a></li>
                        <li><a href="encryption.html">Encryption</a></li>
                        <li><a href="hashing.html">Hashing</a></li>
                    </ul>
                </li>
                <li>General Topics
                    <ul>
                        <li><a href="broadcasting.html">Broadcasting</a></li>
                        <li><a href="cache.html">Cache</a></li>
                        <li><a href="events.html">Events</a></li>
                        <li><a href="filesystem.html">File Storage</a></li>
                        <li><a href="mail.html">Mail</a></li>
                        <li><a href="notifications.html">Notifications</a></li>
                        <li><a href="queues.html">Queues</a></li>
                    </ul>
                </li>
                <li>Database
                    <ul>
                        <li><a href="database.html">Getting Started</a></li>
                        <li><a href="queries.html">Query Builder</a></li>
                        <li><a href="pagination.html">Pagination</a></li>
                        <li><a href="migrations.html">Migrations</a></li>
                        <li><a href="seeding.html">Seeding</a></li>
                        <li><a href="redis.html">Redis</a></li>
                    </ul>
                </li>
                <li>Eloquent ORM
                    <ul>
                        <li><a href="eloquent.html">Getting Started</a></li>
                        <li><a href="eloquent-relationships.html">Relationships</a></li>
                        <li><a href="eloquent-collections.html">Collections</a></li>
                        <li><a href="eloquent-mutators.html">Mutators</a></li>
                        <li><a href="eloquent-serialization.html">Serialization</a></li>
                    </ul>
                </li>
                <li>Artisan Console
                    <ul>
                        <li><a href="artisan.html">Commands</a></li>
                        <li><a href="scheduling.html">Task Scheduling</a></li>
                    </ul>
                </li>
                <li>Testing
                    <ul>
                        <li><a href="testing.html">Getting Started</a></li>
                        <li><a href="application-testing.html">Application Testing</a></li>
                        <li><a href="database-testing.html">Database</a></li>
                        <li><a href="mocking.html">Mocking</a></li>
                    </ul>
                </li>
                <li>Official Packages
                    <ul>
                        <li><a href="billing.html">Cashier</a></li>
                        <li><a href="envoy.html">Envoy</a></li>
                        <li><a href="passport.html">Passport</a></li>
                        <li><a href="scout.html">Scout</a></li>
                        <li><a href="https://github.com/laravel/socialite">Socialite</a></li>
                    </ul>
                </li>
                <li>Appendix
                    <ul>
                        <li><a href="collections.html">Collections</a></li>
                        <li><a href="helpers.html">Helpers</a></li>
                        <li><a href="packages.html">Packages</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <article>
            <h1>Installation</h1>
            <ul>
                <li><a href="#installation">Installation</a>
                    <ul>
                        <li><a href="#server-requirements">Server Requirements</a></li>
                        <li><a href="#installing-laravel">Installing Laravel</a></li>
                        <li><a href="#configuration">Configuration</a></li>
                    </ul>
                </li>
            </ul>
            <p>
                <a name="installation"></a>
            </p>
            <h2>Installation</h2>
            <p>
                <a name="server-requirements"></a>
            </p>
            <h3>Server Requirements</h3>
            <p>The Laravel framework has a few system requirements. Of course, all of these requirements are satisfied by the <a href="homestead.html">Laravel Homestead</a> virtual machine, so it's highly recommended that you use Homestead as your local Laravel development environment.</p>
            <p>However, if you are not using Homestead, you will need to make sure your server meets the following requirements:</p>
            <div class="content-list">
                <ul>
                    <li>PHP &gt;= 5.6.4</li>
                    <li>OpenSSL PHP Extension</li>
                    <li>PDO PHP Extension</li>
                    <li>Mbstring PHP Extension</li>
                    <li>Tokenizer PHP Extension</li>
                </ul>
            </div>
            <p>
                <a name="installing-laravel"></a>
            </p>
            <h3>Installing Laravel</h3>
            <p>Laravel utilizes <a href="http://getcomposer.org/">Composer</a> to manage its dependencies. So, before using Laravel, make sure you have Composer installed on your machine.</p>
            <h4>Via Laravel Installer</h4>
            <p>First, download the Laravel installer using Composer:</p>
            <pre><code>composer global require "laravel/installer"</code></pre>
            <p>Make sure to place the <code>~/.composer/vendor/bin</code> directory (or the equivalent directory for your OS) in your $PATH so the <code>laravel</code> executable can be located by your system.</p>
            <p>Once installed, the <code>laravel new</code> command will create a fresh Laravel installation in the directory you specify. For instance, <code>laravel new blog</code> will create a directory named <code>blog</code> containing a fresh Laravel installation with all of Laravel's dependencies already installed:</p>
            <pre><code>laravel new blog</code></pre>
            <h4>Via Composer Create-Project</h4>
            <p>Alternatively, you may also install Laravel by issuing the Composer <code>create-project</code> command in your terminal:</p>
            <pre><code>composer create-project --prefer-dist laravel/laravel blog</code></pre>
            <h4>Local Development Server</h4>
            <p>If you have PHP installed locally and you would like to use PHP's built-in development server to serve your application, you may use the <code>serve</code> Artisan command. This command will start a development server at <code>http://localhost:8000</code>:</p>
            <pre><code>php artisan serve</code></pre>
            <p>Of course, more robust local development options are available via <a href="homestead.html">Homestead</a> and <a href="valet.html">Valet</a>.</p>
            <p>
                <a name="configuration"></a>
            </p>
            <h3>Configuration</h3>
            <h4>Public Directory</h4>
            <p>After installing Laravel, you should configure your web server's document / web root to be the <code>public</code> directory. The <code>index.php</code> in this directory serves as the front controller for all HTTP requests entering your application.</p>
            <h4>Configuration Files</h4>
            <p>All of the configuration files for the Laravel framework are stored in the <code>config</code> directory. Each option is documented, so feel free to look through the files and get familiar with the options available to you.</p>
            <h4>Directory Permissions</h4>
            <p>After installing Laravel, you may need to configure some permissions. Directories within the <code>storage</code> and the <code>bootstrap/cache</code> directories should be writable by your web server or Laravel will not run. If you are using the <a href="homestead.html">Homestead</a> virtual machine, these permissions should already be set.</p>
            <h4>Application Key</h4>
            <p>The next thing you should do after installing Laravel is set your application key to a random string. If you installed Laravel via Composer or the Laravel installer, this key has already been set for you by the <code>php artisan key:generate</code> command.</p>
            <p>Typically, this string should be 32 characters long. The key can be set in the <code>.env</code> environment file. If you have not renamed the <code>.env.example</code> file to <code>.env</code>, you should do that now. <strong>If the application key is not set, your user sessions and other encrypted data will not be secure!</strong></p>
            <h4>Additional Configuration</h4>
            <p>Laravel needs almost no other configuration out of the box. You are free to get started developing! However, you may wish to review the <code>config/app.php</code> file and its documentation. It contains several options such as <code>timezone</code> and <code>locale</code> that you may wish to change according to your application.</p>
            <p>You may also want to configure a few additional components of Laravel, such as:</p>
            <div class="content-list">
                <ul>
                    <li><a href="cache.html#configuration">Cache</a></li>
                    <li><a href="database.html#configuration">Database</a></li>
                    <li><a href="session.html#configuration">Session</a></li>
                </ul>
            </div>
            <p>Once Laravel is installed, you should also <a href="configuration.html#environment-configuration">configure your local environment</a>.</p>
        </article>
    </div>
    <footer class="main">
        <ul>
            <li class="nav-docs"><a href="https://laravel.com/docs">Documentation</a></li>
            <li class="nav-laracasts"><a href="https://laracasts.com/">Laracasts</a></li>
            <li class="nav-laravel-news"><a href="https://laravel-news.com/">News</a></li>
            <li class="nav-forge"><a href="https://forge.laravel.com/">Forge</a></li>
            <li class="dropdown community-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Ecosystem <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="https://github.com/laravel/laravel">GitHub</a></li>
                    <li class="divider"></li>
                    <li><a href="https://envoyer.io/">Envoyer</a></li>
                    <li><a href="https://lumen.laravel.com/">Lumen</a></li>
                    <li><a href="https://spark.laravel.com/">Spark</a></li>
                    <li class="divider"></li>
                    <li><a href="https://laracasts.com/discuss">Forums</a></li>
                    <li><a href="https://larajobs.com/?partner=5#/">Jobs</a></li>
                    <li><a href="http://www.laravelpodcast.com/">Podcast</a></li>
                    <li><a href="http://larachat.co/">Slack</a></li>
                    <li><a href="https://twitter.com/laravelphp">Twitter</a></li>
                </ul>
            </li>
        </ul>
        <p>Laravel is a trademark of Taylor Otwell. Copyright &copy; Taylor Otwell.</p>
        <p class="less-significant">
            <a href="http://jackmcdade.com/">
                Designed by<br>
                <svg version="1.1"
     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
     x="0px" y="0px" width="128.2px" height="28px" viewBox="0 0 128.2 28" enable-background="new 0 0 128.2 28" xml:space="preserve"
    >
<defs>
</defs>
<g>
    <path fill="#c3c3c3" d="M14.2,0.4c0,0.2,0,0.5,0,0.7c0,0.2,0,0.5,0,0.7l-1.4-0.3C12.9,3,13,4.5,13.1,6c0.1,1.5,0,3-0.1,4.5
        c0,0.4-0.1,0.8-0.1,1.2c-0.1,0.4-0.1,0.8-0.3,1.2c-0.1,0.4-0.3,0.7-0.5,1.1c-0.2,0.3-0.5,0.6-0.9,0.9c-0.4,0.2-0.9,0.4-1.5,0.6
        c-0.6,0.2-1.1,0.3-1.6,0.3c-0.6,0-1.2-0.1-1.6-0.3c-0.5-0.2-0.9-0.6-1.1-1c-0.3-0.5-0.5-1-0.6-1.6c-0.1-0.6-0.1-1.3,0-2.1
        c0-0.2,0.1-0.5,0.2-0.7C4.9,9.9,5,9.7,5.1,9.5c0.1-0.2,0.2-0.4,0.3-0.6l1.1,0.4C6.7,9.3,7,9.4,7.3,9.5c0.3,0.1,0.5,0.1,0.6,0.2
        c0,0.2,0,0.4-0.1,0.5c-0.1,0.2-0.1,0.3-0.2,0.4c-0.1,0.1-0.2,0.3-0.2,0.4c-0.1,0.2-0.1,0.3-0.1,0.5l-1.3-0.7
        c-0.1,0.3-0.2,0.7-0.2,1.1c0,0.4,0.1,0.8,0.2,1.2c0.2,0.4,0.4,0.7,0.6,1c0.3,0.3,0.6,0.4,1,0.3c0.6,0,1.1-0.3,1.4-0.6
        c0.3-0.4,0.5-0.9,0.7-1.7c0.1-0.7,0.2-1.6,0.2-2.8c0-1.1,0-2.4,0-3.9c0-0.6-0.1-1.3-0.1-2C9.7,2.8,9.6,2.1,9.5,1.4
        c-0.2,0-0.5,0-0.8,0c-0.3,0-0.6,0-0.8,0c-0.8,0-1.5,0-2.2,0c-0.7,0-1.5,0-2.2,0.2c-0.3,0.1-0.6,0.2-1,0.4C2.2,2.1,1.9,2.4,1.6,2.6
        C1.4,2.9,1.2,3.2,1.1,3.6C1,3.9,1,4.3,1.1,4.6c0.1,0.5,0.3,0.8,0.4,0.9V5.4c0-0.4,0.1-0.8,0.4-1c0.3-0.2,0.6-0.3,0.9-0.3
        c0.3,0,0.6,0.1,0.9,0.3C4,4.6,4.1,5,4.1,5.4c0,0.4-0.1,0.8-0.4,1c-0.3,0.2-0.6,0.3-1,0.3H2.7C1.9,6.7,1.3,6.5,0.9,6
        C0.5,5.6,0.2,5.1,0.1,4.5C0,4,0,3.4,0.2,2.7c0.2-0.6,0.5-1.1,1-1.5c0.4-0.3,0.8-0.5,1.2-0.7c0.4-0.1,0.9-0.2,1.4-0.3
        c0.5-0.1,0.9-0.1,1.4-0.1c0.5,0,0.9,0,1.4,0h1.5c0.6,0,1.1,0,1.6,0.1c0.5,0,1,0.1,1.5,0.1c0.5,0,1,0.1,1.5,0.1
        C13.1,0.5,13.6,0.5,14.2,0.4z"/>
    <path fill="#c3c3c3" d="M25.2,14.3c0,0.2,0.1,0.4,0.1,0.6c0,0.2,0.1,0.4,0.1,0.7c-1-0.1-2-0.2-3-0.1c-1.1,0.1-2.1,0.2-3,0.4
        c0-0.2-0.1-0.4-0.1-0.5c0-0.2-0.1-0.4-0.1-0.5c0.2,0,0.5-0.1,0.7-0.1c0.2,0,0.4-0.1,0.6-0.1c-0.1-1.5-0.3-3.1-0.5-4.6
        c-0.5,0.1-0.9,0.1-1.4,0.2c-0.5,0.1-0.9,0.1-1.4,0.2c-0.2,0.7-0.3,1.3-0.5,2c-0.2,0.7-0.3,1.3-0.5,2c0.2,0,0.4,0,0.6,0
        c0.1,0,0.3,0,0.4,0.1c0,0.2,0,0.3,0,0.5c0,0.1,0,0.2,0,0.4c0,0.1,0,0.2-0.1,0.3H14v-1.2h1c0.2-0.5,0.3-1,0.4-1.5
        c0.1-0.5,0.3-1,0.4-1.5c0.2-0.6,0.3-1.2,0.5-1.7c0.2-0.6,0.3-1.2,0.5-1.7c0.2-1.1,0.4-2.1,0.6-3.2c0.2-1.1,0.3-2.1,0.4-3.2
        c-0.2,0-0.5,0-0.7,0c-0.2,0-0.4,0-0.7,0c0-0.2,0.1-0.4,0.1-0.6c0-0.2,0-0.4,0.1-0.6c0.9,0,1.9,0,2.9,0c1,0,2,0,2.9,0l0.2,1.2
        c-0.2,0-0.3,0-0.5,0c-0.2,0-0.3,0-0.5,0c0.3,2.1,0.7,4.3,1,6.5c0.3,2.2,0.7,4.4,1,6.5H25.2z M17.5,9c0.4-0.1,0.7-0.1,1.1-0.2
        c0.4-0.1,0.8-0.1,1.2-0.2c-0.2-1-0.3-2-0.5-2.9c-0.2-1-0.4-1.9-0.6-2.9c-0.2,1-0.4,2.1-0.5,3.1C17.9,6.9,17.7,8,17.5,9z"/>
    <path fill="#c3c3c3" d="M36.7,10.4c-0.1,0-0.2,0-0.3,0c-0.1,0-0.2,0-0.3,0c0,0.6,0,1.2-0.2,1.9c-0.2,0.6-0.5,1.2-1,1.6
        c-0.5,0.5-1,0.9-1.6,1.1c-0.6,0.3-1.3,0.4-2,0.5c-0.6,0.1-1.1,0.1-1.8,0c-0.6-0.1-1.1-0.4-1.6-0.7c-0.2-0.2-0.5-0.4-0.8-0.7
        c-0.3-0.3-0.5-0.5-0.6-0.8c-0.3-0.5-0.5-1-0.6-1.5c-0.2-0.5-0.3-0.9-0.4-1.4c-0.1-0.5-0.2-1-0.2-1.5c0-0.5,0-1,0.1-1.6
        c0.2-1,0.4-2,0.8-2.9c0.4-0.9,0.8-1.7,1.4-2.3c0.5-0.7,1.2-1.2,1.9-1.6C30.2,0.2,30.9,0,31.7,0c0.3,0,0.5,0,0.8,0.1
        c0.3,0.1,0.5,0.2,0.7,0.4c0.3,0.3,0.7,0.7,1,1.2c0.3,0.5,0.6,1.2,0.7,1.9c0.1,0,0.2,0,0.3,0c0.1,0,0.2,0,0.3,0c0,0.1,0,0.2,0,0.3
        c0,0.1,0,0.2,0,0.3L33,4.6c-0.3,0.1-0.5,0.1-0.6,0c-0.1,0-0.2-0.1-0.2-0.2c-0.1-0.1-0.1-0.2,0-0.3c0.1,0,0.2,0,0.2,0
        c0.1,0,0.1,0,0.2,0c0.2-0.2,0.3-0.3,0.3-0.6c0-0.2,0-0.5,0-0.7c0-0.5-0.2-0.9-0.5-1.3c-0.2-0.2-0.3-0.3-0.4-0.4
        C31.8,1,31.6,1,31.4,1.1c-0.2,0-0.4,0.2-0.6,0.4c-0.2,0.2-0.4,0.5-0.5,0.9C30,2.6,29.9,3,29.8,3.3c-0.1,0.3-0.2,0.5-0.2,0.7
        c-0.6,2.6-0.7,5.3-0.2,8c0.1,0.3,0.2,0.7,0.3,1s0.3,0.6,0.5,0.9c0.2,0.3,0.5,0.5,0.8,0.7c0.3,0.2,0.6,0.2,1,0.1
        c0.6-0.1,1-0.4,1.4-1c0.3-0.5,0.6-1.1,0.7-1.8c0.1-0.3,0.1-0.6,0.1-0.9v-0.5c-0.2,0-0.4,0-0.6-0.1c-0.1-0.1-0.2-0.2-0.2-0.3
        c0-0.1,0-0.2,0.1-0.3c0.6,0,1.2,0,1.7,0c0.6,0,1.2,0,1.7,0c0,0.1,0,0.2-0.1,0.3C36.7,10.2,36.7,10.3,36.7,10.4z"/>
    <path fill="#c3c3c3" d="M48,14.2c0.1,0.2,0.3,0.3,0.5,0.4c0.2,0.1,0.5,0.1,0.7,0c0.1,0.1,0.1,0.2,0.1,0.4c0,0.2-0.1,0.3-0.2,0.4
        c-0.1,0.1-0.2,0.2-0.4,0.2c-0.2,0-0.3,0-0.4,0c-0.3,0-0.7,0-1,0c-0.3,0-0.7,0-1-0.1c-0.3-0.1-0.7-0.2-1-0.4
        c-0.3-0.2-0.5-0.4-0.7-0.7c-0.2-0.3-0.3-0.6-0.3-1c0-0.3,0-0.7,0-1.1V9.9c0-0.1,0-0.3,0-0.4c0-0.2-0.1-0.3-0.2-0.5
        c-0.1-0.2-0.3-0.3-0.4-0.4c-0.2-0.1-0.4-0.1-0.7-0.1c-0.1,0-0.2,0-0.5,0.1c-0.2,0.3-0.3,0.5-0.5,0.8c-0.2,0.3-0.3,0.5-0.5,0.7
        c0,0.8,0,1.5-0.1,2.2c0,0.7-0.1,1.5-0.1,2.1h1.4v1.1c-0.5,0-0.9,0.1-1.3,0c-0.4,0-0.8,0-1.2-0.1c-0.4,0-0.8-0.1-1.2-0.1
        c-0.4,0-0.8,0-1.3,0c-0.1,0-0.3,0-0.4,0c-0.1,0-0.2,0-0.3-0.1c-0.1,0-0.1-0.1-0.1-0.2c0-0.1-0.1-0.3-0.1-0.4c0-0.1,0-0.3,0-0.4
        c0-0.1,0.1-0.2,0.1-0.2c0.2,0.1,0.4,0.2,0.6,0.1s0.4-0.2,0.5-0.4c0-0.1,0.1-0.3,0.1-0.7c0-0.4,0-0.9,0.1-1.6c0-0.6,0.1-1.3,0.1-2.1
        c0-0.8,0-1.6,0.1-2.4c0-0.8,0-1.5,0.1-2.3c0-0.7,0.1-1.3,0.1-1.8c0-0.2,0-0.5,0-0.7c0-0.2-0.1-0.4-0.2-0.6
        c-0.1-0.2-0.3-0.3-0.5-0.4c-0.2-0.1-0.4,0-0.6,0.1c0-0.2-0.1-0.5-0.1-0.7c0-0.2,0-0.4-0.1-0.7c1,0,2,0.1,3,0.1c0.9,0,1.9,0.1,3,0.1
        c0,0.1,0,0.2,0,0.3c0,0.1,0,0.3,0.1,0.4c0,0.1,0,0.3,0,0.4c0,0.1,0,0.2-0.1,0.2c-0.1,0.1-0.2,0.1-0.3,0.1c-0.1,0-0.2,0-0.4-0.1
        c-0.1-0.1-0.3-0.1-0.4-0.2c-0.1-0.1-0.3-0.1-0.3-0.1c-0.1,0.9-0.1,1.9-0.1,2.9c0,1-0.1,2-0.1,3.1c0.7-1.2,1.4-2.5,2-3.8
        c0.2-0.3,0.3-0.6,0.4-0.9c0.1-0.3,0.3-0.6,0.5-0.9c0.2-0.3,0.4-0.5,0.7-0.7C45.4,1,45.7,0.9,46,0.8c0.3-0.1,0.7-0.1,1,0
        c0.3,0.1,0.6,0.2,0.9,0.5c0.2,0.3,0.4,0.6,0.4,1c0,0.4,0.1,0.8,0,1.1c0,0.2,0,0.3,0,0.5c0,0.2-0.1,0.3-0.2,0.4
        c-0.1,0.2-0.2,0.3-0.4,0.4c-0.2,0.1-0.4,0.1-0.5,0.2c-0.1,0-0.3,0.1-0.4,0.1c-0.1,0-0.3,0-0.4,0C46.2,4.7,46,4.6,46,4.4
        c-0.1-0.2-0.1-0.4,0-0.5c0.1-0.2,0.2-0.3,0.3-0.3c0.1,0,0.2-0.1,0.4-0.1c0.2-0.1,0.3-0.2,0.3-0.3c0.1-0.2,0.1-0.3,0.1-0.5
        C47.1,2.4,47,2.2,47,2c-0.1-0.2-0.2-0.3-0.3-0.3c-0.2,0-0.3,0-0.5,0.1C46,1.9,45.9,2,45.7,2.2c-0.2,0.2-0.3,0.4-0.4,0.6
        C45.2,3,45,3.3,44.9,3.5c-0.1,0.3-0.3,0.6-0.4,0.8c-0.2,0.2-0.3,0.5-0.4,0.8c-0.4,0.9-0.8,1.7-1.2,2.5c0.3,0,0.6-0.1,1,0
        c0.4,0,0.7,0,1,0c0.3,0,0.7,0.1,1,0.2c0.3,0.1,0.6,0.3,0.8,0.6c0.3,0.3,0.4,0.6,0.5,1c0.1,0.4,0.1,0.8,0.2,1.1l0.2,2.1
        c0,0.2,0.1,0.5,0.1,0.7C47.7,13.7,47.8,14,48,14.2z"/>
    <path fill="#c3c3c3" d="M71.7,13.9c0.2,0.2,0.4,0.4,0.7,0.5c0.3,0.1,0.5,0,0.8-0.1c0,0.2,0.1,0.3,0.1,0.6c0.1,0.2,0.1,0.4,0.1,0.6
        c-0.3,0-0.7,0-1.1,0s-0.8,0-1.3,0.1c-0.4,0-0.9,0-1.3,0c-0.4,0-0.8,0-1,0c0-0.1,0-0.1,0-0.2c0-0.1,0.1-0.2,0.2-0.3
        c0.1-0.1,0.2-0.2,0.4-0.3c0.2-0.1,0.3-0.1,0.6-0.1c0.1,0,0.1-0.2,0.1-0.7c0-0.4,0-1,0-1.6c0-0.6,0-1.2-0.1-1.9s0-1.1,0-1.5
        c0-1,0-1.9,0-2.6c0-0.7,0.1-1.5,0.1-2.2c-0.6,1.3-1.1,2.7-1.6,4.1c-0.5,1.5-1,3-1.5,4.4c0,0,0.1,0.1,0.1,0.2c-0.2,0-0.4,0-0.7,0.1
        c-0.3,0.1-0.5,0.1-0.7,0.1c-0.5-1.9-1.1-3.7-1.6-5.5c-0.5-1.8-1.1-3.6-1.6-5.5c-0.1,1-0.1,2-0.1,3c0,1.1-0.1,2.1-0.1,3.2
        c0,1.1,0,2.1-0.1,3.2c0,1-0.1,2-0.1,3h1.4v1.1c-0.5,0-0.9,0.1-1.3,0c-0.4,0-0.8,0-1.2-0.1c-0.4,0-0.8-0.1-1.2-0.1
        c-0.4,0-0.8,0-1.3,0c-0.1,0-0.3,0-0.4,0c-0.1,0-0.2,0-0.3-0.1c-0.1,0-0.1-0.1-0.1-0.2c0-0.1-0.1-0.3-0.1-0.4c0-0.1,0-0.3,0-0.4
        c0-0.1,0.1-0.2,0.1-0.2c0.2,0.1,0.4,0.2,0.6,0.1s0.4-0.2,0.5-0.4c0-0.1,0.1-0.3,0.1-0.7c0-0.4,0-0.9,0.1-1.6c0-0.6,0.1-1.3,0.1-2.1
        C59,8.8,59,8,59,7.2c0-0.8,0-1.5,0.1-2.3c0-0.7,0.1-1.3,0.1-1.8c0-0.2,0-0.5,0-0.7c0-0.2-0.1-0.4-0.2-0.6c-0.1-0.2-0.3-0.3-0.5-0.4
        c-0.2-0.1-0.4,0-0.6,0.1c0-0.2-0.1-0.5-0.1-0.7c0-0.2,0-0.4-0.1-0.7c1,0,2,0.1,3,0.1c0.9,0,1.9,0.1,3,0.1c0,0.3-0.1,0.5-0.4,0.7
        c0.3,1.3,0.6,2.6,1,3.9c0.4,1.3,0.8,2.6,1.2,3.9c0.2-0.6,0.4-1.3,0.6-1.9c0.2-0.6,0.4-1.2,0.6-1.8C67,4.6,67.2,4,67.5,3.4
        c0.2-0.6,0.4-1.3,0.6-2c-0.1,0-0.3,0-0.4-0.1c-0.1,0-0.2,0-0.4-0.1c-0.1,0-0.1-0.1-0.1-0.3c0-0.1,0.1-0.2,0.1-0.3
        c0.1-0.1,0.2-0.1,0.3-0.1c0.1,0,0.2,0,0.3,0c0.4,0,0.7,0,1,0s0.6,0,0.9,0c0.3,0,0.6,0,0.9,0c0.3,0,0.6,0,1,0c0.1,0,0.3,0,0.4,0
        c0.1,0,0.3,0.1,0.4,0.2c0.1,0.1,0.2,0.2,0.2,0.4c0,0.2,0,0.3-0.2,0.3c-0.1-0.1-0.2-0.1-0.3-0.1c-0.1,0-0.2,0.1-0.3,0.1
        c-0.2,0.4-0.3,0.8-0.4,1.3c-0.1,0.5-0.1,0.9-0.1,1.4c-0.2,2.8-0.2,5.6,0,8.4c0,0.3,0,0.5,0.1,0.7C71.4,13.5,71.5,13.7,71.7,13.9z"
        />
    <path fill="#c3c3c3" d="M81.7,12c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0-0.2,0c0,0.4,0,0.9-0.2,1.3c-0.1,0.4-0.4,0.8-0.7,1.1
        c-0.3,0.3-0.7,0.6-1.1,0.8c-0.4,0.2-0.9,0.3-1.3,0.4c-0.4,0.1-0.8,0-1.2,0c-0.4-0.1-0.8-0.2-1.1-0.5c-0.2-0.1-0.3-0.3-0.5-0.5
        c-0.2-0.2-0.3-0.4-0.4-0.6c-0.2-0.4-0.3-0.7-0.4-1c-0.1-0.3-0.2-0.6-0.3-1C74,11.7,74,11.4,74,11c0-0.3,0-0.7,0.1-1.1
        c0.1-0.7,0.3-1.4,0.5-2c0.3-0.6,0.6-1.1,0.9-1.6s0.8-0.8,1.3-1.1c0.5-0.3,1-0.4,1.5-0.4c0.2,0,0.4,0,0.6,0.1
        c0.2,0.1,0.3,0.1,0.5,0.3C79.6,5.4,79.8,5.6,80,6c0.2,0.4,0.4,0.8,0.5,1.3c0.1,0,0.1,0,0.2,0c0.1,0,0.1,0,0.2,0c0,0.1,0,0.1,0,0.2
        c0,0.1,0,0.1,0,0.2L79.2,8c-0.2,0.1-0.3,0.1-0.4,0c-0.1,0-0.1-0.1-0.2-0.2c0-0.1,0-0.1,0-0.2c0.1,0,0.1,0,0.2,0c0,0,0.1,0,0.2,0
        c0.1-0.1,0.2-0.2,0.2-0.4c0-0.2,0-0.3,0-0.5c0-0.3-0.1-0.6-0.3-0.9c-0.1-0.1-0.2-0.2-0.3-0.3c-0.1-0.1-0.2-0.1-0.4,0
        c-0.1,0-0.3,0.1-0.4,0.3c-0.1,0.2-0.3,0.4-0.4,0.6c-0.1,0.2-0.2,0.4-0.3,0.6c-0.1,0.2-0.1,0.4-0.1,0.5c-0.4,1.8-0.5,3.6-0.1,5.5
        c0.1,0.2,0.1,0.4,0.2,0.7c0.1,0.2,0.2,0.4,0.3,0.6c0.1,0.2,0.3,0.3,0.6,0.5c0.2,0.1,0.4,0.1,0.7,0.1c0.4-0.1,0.7-0.3,1-0.7
        c0.2-0.4,0.4-0.8,0.5-1.2c0-0.2,0.1-0.4,0.1-0.6v-0.3c-0.2,0-0.3,0-0.4,0c-0.1,0-0.1-0.1-0.1-0.2c0-0.1,0-0.2,0.1-0.2
        c0.4,0,0.8,0,1.2,0c0.4,0,0.8,0,1.2,0c0,0.1,0,0.1,0,0.2C81.8,11.8,81.8,11.9,81.7,12z"/>
    <path fill="#c3c3c3" d="M83.5,14.2c0.2-4.3,0.3-8.5,0.2-12.8c-0.3,0-0.6,0-0.9,0c-0.3,0-0.6,0-0.9,0c0-0.2,0-0.3,0-0.5s0-0.3,0-0.5
        c0.7,0,1.3,0,2-0.1c0.7,0,1.3,0,2-0.1c0.8-0.2,1.6-0.2,2.4-0.1c0.8,0.1,1.6,0.3,2.4,0.5c0.7,0.3,1.4,0.7,1.9,1.2
        c0.5,0.5,0.9,1.1,1.1,1.8C94,4.9,94.1,6.1,94,7.4C94,8.6,93.8,9.8,93.7,11c0,0.4-0.1,0.8-0.2,1.2c-0.1,0.4-0.3,0.8-0.5,1.1
        c-0.3,0.5-0.8,1-1.3,1.3c-0.5,0.3-1.1,0.5-1.7,0.6c-0.5,0.1-0.9,0.2-1.4,0.1c-0.5,0-0.9,0-1.4-0.1v0c-0.2,0-0.3,0-0.5,0
        s-0.4,0-0.5,0l-0.1,0c0,0,0,0,0,0c-0.6,0-1.3,0-1.9,0c-0.6,0-1.3,0-1.9,0c-0.2-0.4-0.1-0.8,0.2-1.1c0.2-0.2,0.3-0.2,0.5-0.3
        C83.2,14.1,83.4,14.1,83.5,14.2z M89.4,1.9c-0.4-0.3-0.8-0.5-1.3-0.6c-0.5-0.1-1-0.1-1.5-0.1c-0.3,4.5-0.2,9.1,0.4,13.6
        c0.2,0,0.4,0,0.5-0.1c0.2,0,0.4-0.1,0.6-0.1c0.3-0.1,0.6-0.2,0.9-0.4c0.3-0.2,0.6-0.4,0.8-0.7c0.2-0.3,0.4-0.6,0.5-1
        s0.2-0.7,0.2-1.1c0.4-2.1,0.4-4.2,0.2-6.3c-0.1-0.6-0.2-1.2-0.4-1.9C90.3,2.8,89.9,2.3,89.4,1.9z"/>
    <path fill="#c3c3c3" d="M102.4,9.7c-0.6-0.1-1.3-0.1-2,0c-0.7,0.1-1.4,0.4-2,0.8l-0.2-1.4L99.1,9c0-0.4-0.1-0.7-0.1-1
        c0-0.2-0.1-0.5-0.1-0.9c-0.3,0-0.6,0.1-0.9,0.1c-0.3,0-0.6,0.1-1,0.1c-0.2,0.7-0.3,1.3-0.4,1.8c-0.1,0.5-0.2,1.1-0.4,1.6l0.2-0.1
        l0.7,0.6c-0.4,0.2-0.8,0.6-1.2,1.1c-0.4,0.5-0.7,1-0.9,1.5l-0.9-0.5c0-0.1,0.1-0.2,0.2-0.4c0.1-0.2,0.2-0.3,0.2-0.4
        c0.1-0.2,0.2-0.5,0.3-1c0.1-0.4,0.2-0.9,0.4-1.3c0.1-0.5,0.2-0.9,0.3-1.3c0.1-0.4,0.2-0.7,0.2-0.9c0.1-0.4,0.2-0.8,0.3-1.2
        c0.1-0.4,0.2-0.8,0.3-1.2c0.2-0.7,0.3-1.4,0.4-2.1c0.1-0.7,0.2-1.4,0.3-2.2c-0.1,0-0.2,0-0.3,0c-0.1,0-0.2,0-0.3,0l0.1-0.8l4-0.1
        l0.1,0.8c-0.1,0-0.2,0-0.2,0c0,0-0.1,0-0.2,0c0.1,0.7,0.2,1.4,0.3,2c0.1,0.6,0.2,1.2,0.3,1.8c0.1,0.6,0.2,1.2,0.3,1.8
        c0.1,0.6,0.2,1.3,0.4,2c0.2,0,0.3,0,0.3,0c0,0,0.1,0,0.3,0L102.4,9.7z M98.8,6.1c-0.1-0.7-0.2-1.3-0.3-2c-0.1-0.6-0.3-1.3-0.4-2
        c-0.1,0.6-0.2,1.3-0.4,2.1c-0.1,0.7-0.3,1.5-0.5,2.2L98.8,6.1z"/>
    <path fill="#c3c3c3" d="M124.9,20.1c0-0.3,0.1-0.6,0.3-0.8c0.2-0.2,0.4-0.3,0.7-0.4c0.3-0.1,0.5,0,0.8,0.1c0.3,0.1,0.5,0.3,0.6,0.5
        c0.3,0.4,0.6,0.9,0.7,1.4c0.2,0.5,0.2,1,0.2,1.5c0,0.5-0.1,1-0.3,1.5c-0.2,0.5-0.4,1-0.7,1.4c-0.6,0.9-1.4,1.6-2.4,2
        c-1,0.5-2,0.7-3,0.7c-1.5,0-2.8-0.3-3.9-1s-2.1-1.4-3-2.4c-0.9-1-1.8-2.1-2.5-3.2c-0.8-1.2-1.5-2.3-2.3-3.5c-1.1,1.2-2.4,2.2-3.9,3
        c-1.5,0.8-3,1.1-4.5,1c-1.1,0-2.1-0.1-3-0.5c-0.9-0.3-1.6-0.8-2.2-1.4c-0.6-0.6-0.9-1.3-1.1-2.2c-0.2-0.8-0.1-1.7,0.2-2.7
        c0.3-0.9,0.7-1.6,1.3-2.2c0.6-0.6,1.2-1.1,2-1.5c0.7-0.4,1.5-0.6,2.4-0.7c0.8-0.1,1.7,0,2.6,0.2c0-1.7,0-3.4,0-5c0-1.7,0-3.2,0-4.6
        c-0.3,0-0.6,0-0.9,0c-0.3,0-0.6,0-0.9,0c0-0.2,0-0.3,0-0.5s0-0.3,0-0.5l3.7-0.1c0.8-0.2,1.6-0.2,2.4-0.1c0.8,0.1,1.6,0.3,2.4,0.5
        c0.7,0.3,1.4,0.7,1.9,1.2c0.5,0.5,0.9,1.1,1.1,1.8c0.3,1.2,0.4,2.4,0.3,3.6c-0.1,1.2-0.2,2.5-0.4,3.7c-0.1,1-0.4,2-0.8,3
        c-0.5,1-1,2-1.7,2.9c0.3,0.4,0.6,0.8,0.8,1.2c0.3,0.4,0.5,0.8,0.8,1.2c0.5,0.8,1.1,1.6,1.7,2.5c0.6,0.8,1.3,1.6,2,2.4
        c0.7,0.7,1.5,1.3,2.4,1.8s1.8,0.7,2.9,0.8c1.1,0,2.1-0.2,3-0.7c0.9-0.5,1.6-1.2,2.1-2.2c0.2-0.4,0.3-0.8,0.4-1.3
        c0.1-0.5,0-0.9-0.1-1.3c-0.2,0.1-0.4,0.2-0.6,0.2c-0.2,0-0.4,0-0.6-0.1c-0.2-0.1-0.4-0.2-0.5-0.4S124.9,20.4,124.9,20.1z M102.9,21
        c1.5-0.4,2.8-1,3.7-1.8c0.9-0.8,1.7-1.7,2.3-2.8c-0.2-0.2-0.3-0.5-0.6-0.7c-0.6-0.7-1.2-1.4-1.9-1.9c0,0.6,0.1,1.2,0.1,1.8
        c0,0.6,0.1,1.1,0.2,1.6h0v0.1c-0.5,0-0.9,0-1.3,0c-0.4,0-0.8,0-1.2,0c-0.3,0-0.6,0-0.9,0c-0.3,0-0.6,0-0.9,0
        c-0.1-0.2-0.1-0.4,0-0.7c0-0.2,0.1-0.3,0.3-0.5c0.3-0.3,0.7-0.4,1.1-0.2l0.1-3.5c-0.5-0.2-1-0.3-1.5-0.3c-0.5,0-1.1,0-1.6,0.1
        c-0.6,0.1-1.1,0.3-1.6,0.6c-0.5,0.3-0.9,0.7-1.3,1.1c-0.4,0.4-0.7,0.9-0.9,1.5c-0.2,0.5-0.3,1.1-0.3,1.6c0,0.7,0.2,1.3,0.6,1.8
        c0.4,0.5,0.9,0.9,1.4,1.4c0.2,0.2,0.5,0.3,0.8,0.5c0.3,0.1,0.7,0.2,1.1,0.3c0.4,0.1,0.8,0.1,1.2,0.1
        C102.1,21.1,102.5,21.1,102.9,21z M109.3,1.9c-0.4-0.3-0.8-0.5-1.2-0.6c-0.5-0.1-0.9-0.1-1.4-0.1c-0.1,1.7-0.2,3.4-0.3,5.3
        c-0.1,1.9-0.1,3.7,0,5.6c0.6,0.4,1.2,0.8,1.7,1.4c0.5,0.5,1,1.1,1.5,1.6c0.2-0.6,0.4-1.2,0.6-1.9c0.2-0.6,0.3-1.2,0.3-1.7
        c0.2-1.1,0.2-2.1,0.3-3.1c0-1,0-2.1-0.1-3.1c-0.1-0.6-0.2-1.2-0.4-1.9C110.1,2.8,109.8,2.3,109.3,1.9z"/>
    <path fill="#c3c3c3" d="M116.5,1.2c-0.3,0-0.6,0-0.9,0c-0.3,0-0.6,0-0.9,0V0.4c0.5,0,0.9,0,1.2-0.1s0.7,0,1.1,0c0.4,0,0.7,0,1.1,0
        s0.8,0,1.3-0.1c0.9,0,1.8,0,2.8-0.1c0.9,0,1.8,0,2.8-0.1c0,0.6,0,1.2,0,1.8c0,0.6,0,1.2,0,1.8c-0.2,0-0.3,0-0.5,0
        c-0.2,0-0.3,0-0.5,0c-0.1,0-0.2,0-0.3,0c-0.1,0-0.1-0.1,0-0.1c0.1-0.2,0.1-0.4,0.1-0.6s0-0.4-0.1-0.6c-0.1-0.2-0.2-0.4-0.3-0.6
        c-0.1-0.2-0.2-0.3-0.4-0.4c-0.2-0.1-0.4-0.2-0.6-0.2c-0.2,0-0.5,0-0.7,0c-0.3,0-0.5,0.1-0.8,0.1c-0.3,0.1-0.5,0.2-0.6,0.4
        c-0.1,0.2-0.1,0.3-0.1,0.3c0,0.1,0,0.2,0,0.3c0,0.7-0.1,1.3-0.1,2c0,0.6-0.1,1.3-0.1,1.9c0,0.2,0,0.3,0,0.5c0,0.2,0,0.3,0,0.5
        c0.6-0.2,1.2-0.3,1.9-0.4c0.6-0.1,1.2-0.3,1.9-0.4c0,0.1,0.1,0.2,0.1,0.3c0,0.1,0,0.3,0,0.4c0,0.2-0.1,0.3-0.1,0.4
        c-0.1,0.1-0.1,0.2-0.1,0.3c-0.1,0.1-0.2,0.1-0.4,0.2c-0.1,0-0.3,0.1-0.4,0.1c-0.5,0.1-0.9,0.2-1.4,0.3c-0.5,0.1-0.9,0.1-1.4,0.2
        c0,1-0.1,2-0.2,2.9c-0.1,1-0.1,1.9-0.2,2.9c0.8,0.2,1.5,0.3,2,0.1c0.6-0.2,1.2-0.5,1.9-1c0.2-0.1,0.2-0.3,0.2-0.5
        c0-0.2,0-0.5,0-0.7c0-0.2,0.1-0.5,0.2-0.6c0.1-0.2,0.3-0.3,0.7-0.4c0.4,0,0.6,0.1,0.7,0.4c0.1,0.3,0.2,0.7,0.2,1.1
        c0,0.5,0,0.9-0.1,1.4c-0.1,0.5-0.1,0.9,0,1.2c-0.5,0-1,0-1.4,0c-0.4,0-0.8,0-1.2,0.1c-0.4,0-0.8,0-1.2,0.1c-0.4,0-0.9,0-1.3,0
        c-0.9,0-1.7,0-2.5,0.1c-0.7,0.1-1.6,0.1-2.4,0.1c-0.2-0.2-0.2-0.4-0.2-0.7c0-0.2,0.1-0.5,0.3-0.6c0.2-0.2,0.3-0.3,0.6-0.3
        c0.2-0.1,0.5,0,0.7,0.1c0.1-2.1,0.2-4.3,0.1-6.5C116.3,5.5,116.3,3.4,116.5,1.2z"/>
</g>
</svg>

            </a>
        </p>
    </footer>
@endsection

@push('blank.css')
	@stack('css')
@endpush

@push('blank.html_footer')
	@stack('html_footer')
@endpush

@push('blank.js_footer')
	@stack('js_footer')
@endpush