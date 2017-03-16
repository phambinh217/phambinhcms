<?php

namespace Phambinh\CmsInstall\Services;

use Phambinh\Cms\Role;
use Phambinh\Cms\User;
use File;
use Artisan;

class Install
{
    public function migrate()
    {
        \Artisan::call('migrate', ['--force' => true]);
    }

    public function setDatabaseInfo($dbHost, $dbUsername, $dbPassword, $dbName)
    {
        \EnvReader::setEnv('DB_CONNECTION', 'mysql');
        \EnvReader::setEnv('DB_PORT', '3306');
        \EnvReader::setEnv('DB_HOST', trim($dbHost));
        \EnvReader::setEnv('DB_DATABASE', trim($dbName));
        \EnvReader::setEnv('DB_USERNAME', trim($dbUsername));
        \EnvReader::setEnv('DB_PASSWORD', trim($dbPassword));
        \EnvReader::write();
    }

    public function markAsInstalled()
    {
        \EnvReader::setEnv('INSTALLED', 'true')->write();
    }

    public function markAsUninstall()
    {
        \EnvReader::setEnv('INSTALLED', 'false')->write();
    }

    public function createRole($roleName)
    {
        return $role = Role::firstOrCreate([
            'name' => $roleName,
            'type' => '*',
        ]);
    }

    public function createUser($role, $email, $password, $name)
    {
        $user = User::firstOrCreate([
            'name' => $name,
            'email' => $email,
        ]);

        $user->update([
            'api_token' => str_random(60),
            'password' => $password,
            'role_id' => $role->id,
            'status' => '1',
        ]);

        return $user;
    }

    public function createSetting($settings)
    {
        foreach ($settings as $key => $value) {
            setting()->sync($key, $value);
        }
    }
}
