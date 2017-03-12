<?php

namespace Packages\CmsInstall\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Packages\Cms\Role;
use Packages\Cms\User;

class InstallController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        \Metatag::set('title', 'Cài đặt');
    }

    public function index()
    {
        \Metatag::set('title', 'Kết nối cơ sở dữ liệu');
        return view('Install::index');
    }

    public function siteInfo()
    {
        \Metatag::set('title', 'Thông tin website');
        return view('Install::site-info');
    }

    public function runInstall()
    {
        \Metatag::set('title', 'Chạy cài đặt');
        $data = json_decode(file_get_contents(base_path('info.json')), true);
        return view('Install::run-install', $data);
    }

    public function checkConnect(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'db.localhost'    => 'required',
            'db.name'        => 'required',
            'db.username'        => 'required',
            'db.password'        => '',
        ]);

        $validator->after(function ($validator) use ($request) {
            try {
                $conn = new \mysqli($request->input('db.localhost'), $request->input('db.username'), $request->input('db.password'), $request->input('db.name'));
            } catch (\ErrorException $e) {
                $validator->errors()->add('message', 'Không thể kết nối đến cơ sở dữ liệu với thông tin bên dưới.');
            }
        });

        $validator->validate();

        $env = \File::get(base_path('.env'));
        if ($length = strpos($env, '# database info')) {
            $env = trim(substr($env, 0, $length));
        }

        $env .= "\n".
            "\n"."# database info".
            "\n"."DB_CONNECTION=mysql".
            "\n"."DB_PORT=3306".
            "\n"."DB_HOST=".trim($request->input('db.localhost')).
            "\n"."DB_DATABASE=".trim($request->input('db.name')).
            "\n"."DB_USERNAME=".trim($request->input('db.username')).
            "\n"."DB_PASSWORD=".trim($request->input('db.password'));

        \File::put(base_path('.env'), $env);

        return redirect()->route('install.site-info');
    }

    public function checkSiteInfo(Request $request)
    {
        $this->validate($request, [
            'company_name'            => 'required|max:255',
            'username'                => 'required|max:255',
            'email'                   => 'required|email|max:255',
            'password'                => 'required|confirmed|min:6',
            'password_confirmation'   => 'required|min:6',
        ]);
        
        file_put_contents(base_path('info.json'), json_encode([
            'company_name' => $request->input('company_name'),
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]));

        return redirect()->route('install.run-install');
    }

    public function installing(Request $request)
    {
        \Artisan::call('migrate', ['--force' => true]);

        $env = \File::get(base_path('.env'));
        if ($length = strpos($env, '# installed')) {
            $env = trim(substr($env, 0, $length));
        }

        $env .= "\n".
            "\n"."# installed".
            "\n"."INSTALLED=true";

        $this->databaseSeeder();

        \File::put(base_path('.env'), $env);

        return response()->json([
            'title' => trans('cms.success'),
            'message' => 'Cài đặt hoàn tất',
        ]);
    }

    private function databaseSeeder()
    {
        $info = json_decode(file_get_contents(base_path('info.json')));
        $role = Role::firstOrCreate([
            'name' => 'Super admin',
            'type' => '*',
        ]);

        $user = User::firstOrCreate([
            'name' => $info->username,
            'email' => $info->email,
            'api_token' => str_random(60),
        ]);

        $user->update([
            'password' => $info->password,
            'role_id' => $role->id,
            'status' => '1',
        ]);

        setting()->sync('company-name', $info->company_name);
        setting()->sync('company-email', $info->email);
        setting()->sync('system-install-at', date(DTF_DB));

        \File::delete(base_path('info.json'));
    }
}
