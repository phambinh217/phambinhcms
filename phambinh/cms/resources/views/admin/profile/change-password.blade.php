@extends('Cms::layouts.default', [
    'active_admin_menu' => ['profile', 'profile.change-password'],
    'breadcrumbs'   =>  [
        'title' =>  [trans('user.profile'), trans('user.change-password')],
        'url'   =>  [
            route('admin.profile.show'),
            route('admin.profile.change-password'),
        ],
    ],
])

@section('page_title', trans('user.change-password'))

@section('content')
    {!! Form::ajax(['method' => 'PUT', 'class' => 'form-horizontal']) !!}
        <p>@lang('user.change-password-login-change-api-token')</p>
        <div class="form-group{{$errors->has('user.old_pasword') ? ' has-error' : ''}}">
            <label class="control-lalel col-sm-3 pull-left">
                @lang('user.old-password')
            </label>
            <div class="col-sm-3">
                <input type="password" name="user[old_pasword]" value="" class="form-control">
                @if($errors->has('user.old_pasword'))
                    <span class="help-block">
                        {{$errors->first('user.old_pasword')}}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{$errors->has('user.password') ? ' has-error' : ''}}">
            <label class="control-lalel col-sm-3 pull-left">
                @lang('user.old-password')
            </label>
            <div class="col-sm-3">
                <input type="password" name="user[password]" value="" class="form-control">
                @if($errors->has('user.password'))
                    <span class="help-block">
                        {{$errors->first('user.password')}}
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group{{$errors->has('user.password_confirmation') ? ' has-error' : ''}}">
            <label class="control-lalel col-sm-3 pull-left">
                @lang('user.confirm-password')
            </label>
            <div class="col-sm-3">
                <input type="password" name="user[password_confirmation]" value="" class="form-control">
                <label class="mt-checkbox mt-checkbox-outline"> 
                    <input type="checkbox" view-password />
                    @lang('cms.display')
                </label>
                @if($errors->has('user.password_confirmation'))
                    <span class="help-block">
                        {{$errors->first('user.password_confirmation')}}
                    </span>
                @endif
            </div>
        </div>
        {!! Form::btnSaveCancel() !!}
    {!! Form::close() !!}
@endsection

@push('js_footer')
    <script type="text/javascript">
        $(function(){
            $('*[view-password]').change(function(){
                if(this.checked) {
                    $('*[name="user[password]"]').attr('type','text');
                    $('*[name="user[password_confirmation]"]').attr('type','text');
                } else {
                    $('*[name="user[password]"]').attr('type','password');
                    $('*[name="user[password_confirmation]"]').attr('type','password');
                }
            });
        });
    </script>
@endpush
