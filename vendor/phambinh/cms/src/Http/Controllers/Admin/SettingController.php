<?php

namespace Phambinh\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Validator;

class SettingController extends AdminController
{
    public function general()
    {
        $this->data['company_name'] = setting('company-name');
        $this->data['company_address'] = setting('company-address');
        $this->data['company_phone'] = setting('company-phone');
        $this->data['company_email'] = setting('company-email');
        $this->data['home_title'] = setting('home-title');
        $this->data['home_description'] = setting('home-description');
        $this->data['home_keyword'] = setting('home-keyword');
        $this->data['default_thumbnail'] = setting('default-thumbnail', upload_url('no-thumbnail.png'));
        $this->data['default_avatar'] = setting('default-avatar', upload_url('no-avatar.png'));
        $this->data['logo'] = setting('logo', url('logo.png'));
        $this->data['language'] = setting('language', config('app.locale'));

        \Metatag::set('title', trans('setting.general-setting'));
        return view('Cms::admin.setting.general', $this->data);
    }

    public function generalUpdate(Request $request)
    {
        $this->validate($request, [
            'company_name' => 'required',
            'company_phone' => 'required',
            'company_email' => 'required',
            'company_address' => 'required',
            'home_title' => '',
            'home_keyword' => '',
            'home_description' => '',
            'logo' => '',
            'default_thumbnail' => '',
            'default_avatar' => '',
            'language' => \Language::rules(),
        ]);

        setting()->sync('company-name', $request->input('company_name'));
        setting()->sync('company-email', $request->input('company_email'));
        setting()->sync('company-phone', $request->input('company_phone'));
        setting()->sync('company-address', $request->input('company_address'));

        setting()->sync('home-title', $request->input('home_title'));
        setting()->sync('home-description', $request->input('home_description'));
        setting()->sync('home-keyword', $request->input('home_keyword'));
        setting()->sync('logo', $request->input('logo'));
        setting()->sync('default-avatar', $request->input('default_avatar'));
        setting()->sync('default-thumbnail', $request->input('default_thumbnail'));
        setting()->sync('language', $request->input('language'));

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => trans('setting.update-setting-success'),
            ]);
        }

        return redirect()->back();
    }
}
