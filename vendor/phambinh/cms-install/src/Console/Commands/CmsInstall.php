<?php

namespace Phambinh\CmsInstall\Console\Commands;

use Illuminate\Console\Command;

class CmsInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Phambinhcms install wizard';

    protected $roleName;
    protected $username;
    protected $email;
    protected $password;
    protected $siteTitle;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (env('installed')) {
            $this->line('Phambinhcms has already been installed.');
        } else {
            $this->comment(PHP_EOL.'Welcome to the Phambinhcms Install Wizard! You\'ll be up and running in no time...');

            // Attempt to link storage/app/public folder to public/storage;
            // This won't work on an OS without symlink support (e.g. Windows)
            try {
                \Artisan::call('storage:link');
            } catch (\Exception $e) {
                $this->line(PHP_EOL.'Could not link <info>storage/app/public</info> folder to <info>public/storage</info>:');
                $this->line("{$e->getMessage()}");
            }

            try {
                new \mysqli(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'));
                $this->line(PHP_EOL.'Success! Your database is set up and configured.');

                $this->comment(PHP_EOL.'<info>Step 2/3: Creating the admin user account</info>');
                $this->roleName = $this->ask('Role name', 'Super admin');
                $this->email = $this->ask('Email');
                $this->password = $this->secret('Password (Min length 6 characters)');
                $this->username = $this->ask('Username', 'admin');
                $this->line(PHP_EOL.'Success! Your admin user account has been created.');

                $this->siteTitle = $this->ask(PHP_EOL.'Step 3/3: Title of your blog');
                
                \Install::migrate();
                \Install::markAsInstalled();
                $user = \Install::createUser(\Install::createRole($this->roleName), $this->email, bcrypt($this->password), $this->username);
                
                \Install::createSetting([
                    'home-title' => $this->siteTitle,
                    'company-name' => $this->siteTitle,
                    'company-email' => $this->email,
                ]);

                $this->line(PHP_EOL.'Phambinhcms has been installed. Pretty easy?'.PHP_EOL);

                // Display installation info...
                $user = \Phambinh\Cms\User::first();
                $headers = ['Login Email', 'Login Password'];
                $data[0]['email'] = $user->email;
                $data[0]['password'] = 'Your chosen password.';
                $this->table($headers, $data);
                $this->line(PHP_EOL);
            } catch (\Exception $e) {
                \Install::markAsUninstall();
                $this->line(PHP_EOL.'<error>An unexpected error occurred. Installation could not continue.</error>');
                $this->error("{$e->getMessage()}");
                $this->comment(PHP_EOL.'Please run the installer again.');
                $this->line(PHP_EOL.'If this error persists please consult https://github.com/phambinh217/phambinhcms/issues.'.PHP_EOL);
            }
        }
    }
}
