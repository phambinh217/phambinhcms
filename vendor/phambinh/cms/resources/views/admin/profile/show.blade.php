@extends('Cms::layouts.default', [
    'active_admin_menu' => ['profile', 'profile.info'],
    'breadcrumbs'   =>  [
        'title' =>  [trans('user.profile'), trans('user.profile-info')],
        'url'   =>  [
            route('admin.profile.show')
        ],
    ],
])

@section('page_title', trans('user.profile'))

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="profile-sidebar">
            <div class="portlet light profile-sidebar-portlet bordered">
                <div class="profile-userpic">
                    <img src="{{ thumbnail_url($user->avatar, ['width' => '100', 'height' => '100']) }}" class="img-responsive" alt=""> </div>
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> {{ $user->full_name }} </div>
                    <div class="profile-usertitle-job"> {{ $user->role()->first()->name }} </div>
                </div>
                <div class="profile-userbuttons">
                    <button onclick="event.preventDefault();document.getElementById('logout-form').submit();" type="button" class="btn btn-circle red btn-sm">@lang('user.logout')</button>
                </div>
                <div class="profile-usermenu">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('admin.profile.show') }}">
                                <i class="icon-info"></i> @lang('user.profile-info')
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.profile.change-password') }}">
                                <i class="icon-key"></i> @lang('user.change-password')
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold">@lang('user.about') {{ $user->full_name }}</span>
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse"> </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <span class="profile-desc-text">
                        {{ $user->about }}
                    </span>
                    @if(! empty($user->website))
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-globe"></i>
                            <a href="{{ $user->website }}">{{ $user->website }}</a>
                        </div>
                    @endif
                    @if(! empty($user->email))
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-envelope"></i>
                            <a href="{{ $user->email }}">{{ $user->email }}</a>
                        </div>
                    @endif
                    @if(! empty($user->facebook))
                        <div class="margin-top-20 profile-desc-link">
                            <i class="fa fa-facebook"></i>
                            <a href="{{ $user->facebook }}">{{ $user->facebook }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered form-fit">
                        <div class="portlet-title with-tab">
                            <div class="tab-default">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">@lang('user.profile-info')</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab">@lang('user.change-avatar')</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_3" data-toggle="tab">@lang('user.change-api-token')</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            {!! Form::ajax(['method' => 'PUT', 'class' => 'form-horizontal form-bordered form-row-stripped']) !!}
                                <div class="form-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab_1_1">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.lastname')</label>
                                                <div class="col-sm-9">
                                                    <input name="user[last_name]" value="{{ $user->last_name }}" type="text" placeholder="" class="form-control" />
                                                </div>
                                            </div> 
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.firstname')</label>
                                                <div class="col-sm-9">
                                                    <input name="user[first_name]" value="{{ $user->first_name }}" type="text" placeholder="" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.phone-number')</label>
                                                <div class="col-sm-9">
                                                    <input name="user[phone]" value="{{ $user->phone }}" type="text" placeholder="" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.email')</label>
                                                <div class="col-sm-9">
                                                    <input name="user[email]" value="{{ $user->email }}" type="text" placeholder="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3 pull-left">@lang('user.birth')</label>
                                                <div class="col-sm-7">
                                                    <input value="{{ $user->birth->format('d-m-Y') }}" name="user[birth]" type="text" class="form-control" placeholder="Ví dụ: 21-07-1996">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.job')</label>
                                                <div class="col-sm-9">
                                                    <input name="user[job]" value="{{ $user->job }}" type="text" placeholder="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.address')</label>
                                                <div class="col-sm-9">
                                                    <textarea name="user[address]" class="form-control" rows="3" placeholder="">{{ $user->address }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.about')</label>
                                                <div class="col-sm-9">
                                                    <textarea name="user[about]" class="form-control" rows="3" placeholder="">{{ $user->about }}</textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.facebook')</label>
                                                <div class="col-sm-9">
                                                    <input name="user[facebook]" value="{{ $user->facebook }}" type="text" placeholder="fb.com/xxx" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.google-plus')</label>
                                                <div class="col-sm-9">
                                                    <input name="user[google_plus]" value="{{ $user->google_plus }}" type="text" placeholder="" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.website')</label>
                                                <div class="col-sm-9">
                                                    <input name="user[website]" value="{{ $user->website }}" type="text" placeholder="google.com" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_1_2">
                                            <div class="form-group media-box-group">
                                                <label class="control-label col-md-3">@lang('user.upload-avatar')</label>
                                                <div class="col-sm-9">
                                                    {!! Form::btnMediaBox('user[avatar]', $user->avatar, thumbnail_url($user->avatar, ['width' => '100', 'height' => '100'])) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab_1_3">
                                            <div class="form-group">
                                                <label class="control-label col-sm-3">@lang('user.api-token')</label>
                                                <div class="col-sm-9">
                                                    <div class="input-group">
                                                        <input name="user[api_token]" readonly value="{{ $user->api_token }}" type="password" placeholder="" class="form-control" />
                                                        <span class="input-group-btn">
                                                            <button id="gen-api-token" class="btn btn-success" type="button">
                                                                <i class="fa fa-undo"></i> @lang('cms.change')
                                                            </button>
                                                        </span>
                                                    </div>
                                                    <label class="mt-checkbox mt-checkbox-outline"> 
                                                        <input type="checkbox" id="view-api-token" />
                                                        @lang('cms.display')
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions util-btn-margin-bottom-5">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-9">
                                            {!! Form::btnSaveCancel() !!}
                                        </div>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js_footer')
    <script type="text/javascript">
        $(function(){
            $('#view-api-token').change(function(){
                if(this.checked) {
                    $('*[name="user[api_token]"]').attr('type','text');
                } else {
                    $('*[name="user[api_token]"]').attr('type','password');
                }
            });

            $('#gen-api-token').click(function(e){
                e.preventDefault();
                $.ajax({
                    url: '{{ route('api.user.gen-api-token') }}',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        _token: csrfToken(),
                        api_token: '{{ \Auth::user()->api_token }}',
                    },
                    success: function (res) {
                        $('input[name="user[api_token]"]').val(res.api_token);
                    },
                });
            });
        });
    </script>
@endpush
