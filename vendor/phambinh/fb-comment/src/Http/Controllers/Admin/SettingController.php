<?php

namespace Phambinh\FbComment\Http\Controllers\Admin;

use Illuminate\Http\Request;
use AdminController;

class SettingController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['fb_comment_apply'] = setting('fb-comment-apply', false);
        $this->data['fb_js_sdk'] = setting('fb-js-sdk', null);
        $this->data['fb_comment_perpage'] = setting('fb-comment-perpage', 5);
        
        \Metatag::set('title', 'Bình luận facebook');
        return view('FbComment::admin.setting.index', $this->data);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'fb_comment_apply'      => 'required|in:true,false',
            'fb_js_sdk'            => 'required_if:fb_comment_apply,true|max:500',
            'fb_comment_perpage'    => 'required_if:fb_comment_apply,true|integer',
        ]);

        setting()->sync('fb-comment-apply', $request->input('fb_comment_apply'));
        setting()->sync('fb-comment-perpage', $request->input('fb_comment_perpage'));
        setting()->sync('fb-js-sdk', $request->input('fb_js_sdk'));

        if ($request->ajax()) {
            return response()->json([
                'title' => trans('cms.success'),
                'message' => 'Đã lưu cài đặt',
            ]);
        }

        return redirect()->back();
    }
}
