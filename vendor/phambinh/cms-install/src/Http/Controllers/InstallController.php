<?php

namespace Phambinh\CmsInstall\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Phambinh\Cms\Role;
use Phambinh\Cms\User;

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

        \Install::setDatabaseInfo($request->input('db.localhost'), $request->input('db.username'), $request->input('db.password'), $request->input('db.name'));

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
        $info = json_decode(file_get_contents(base_path('info.json')));

        \Artisan::call('migrate', ['--force' => true]);
        
        \Install::migrate();
        \Install::markAsInstalled();
        \Install::createUser(\Install::createRole('Super Admin'), $info->email, $info->password, $info->username);
        
        \File::delete(base_path('info.json'));

        return response()->json([
            'title' => trans('cms.success'),
            'message' => 'Cài đặt hoàn tất',
        ]);
    }
}
