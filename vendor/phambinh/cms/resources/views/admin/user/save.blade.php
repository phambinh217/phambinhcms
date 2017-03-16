@extends('Cms::layouts.default',[
	'active_admin_menu' 	=> ['user', isset($user_id) ? 'user.all' : 'user.create'],
	'breadcrumbs' 			=> [
		'title'	=> [trans('user.user'), isset($user_id) ? trans('cms.edit') : trans('cms.add-new')],
		'url'	=> [
			route('admin.user.index'),
		],
	],
])

@section('page_title', isset($user_id) ? trans('user.edit-user') : trans('user.add-new-user'))

@if(isset($user_id))
	@section('page_sub_title', $user->full_name)
	@can('admin.user.create')
		@section('tool_bar')
			<a href="{{ route('admin.user.create') }}" class="btn btn-primary">
				<i class="fa fa-plus"></i> <span class="hidden-xs">@lang('user.add-new-user')</span>
			</a>
		@endsection
	@endcan
@endif

@section('content')
	@if (isset($user_id))
		<div class="hidden-xs">
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<span class="caption-subject bold">@lang('user.summary')</span>
					</div>
					<div class="tools">
						<a href="javascript:;" class="collapse"> </a>
						<a href="" class="fullscreen"> </a>
					</div>
				</div>
				<div class="portlet-body">
					<div class="row">
						<div class="col-sm-2">
							<div>
								<img class="img-responsive" src="{{ thumbnail_url($user->avatar, ['width' => '150', 'height' => '150']) }}" />
							</div>
							@can('admin.user.login-as')
								<a href="{{ route('admin.user.login-as', ['id' => $user->id]) }}"></i> @lang('user.login-as')</a>
							@endcan
						</div>
						<div class="col-sm-5">
							<table class="table table-hover">
								<tbody>
									<tr>
										<td><strong>@lang('user.fullname')</strong></td>
										<td>{{ $user->full_name }}</td>
									</tr>
									<tr>
										<td><strong>@lang('user.birth')</strong></td>
										<td>{{ $user->birth }}</td>
									</tr>
									<tr>
										<td><strong>@lang('user.phone-number')</strong></td>
										<td>{{ $user->phone }}</td>
									</tr>
									<tr>
										<td><strong>@lang('user.email')</strong></td>
										<td>{{ $user->email }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-sm-5">
							<table class="table table-hover">
								<tbody>
									<tr>
										<td><strong>@lang('user.id')</strong></td>
										<td>{{ $user->id }}</td>
									</tr>
									<tr>
										<td><strong>@lang('user.nick')</strong></td>
										<td>{{ $user->name }}</td>
									</tr>
									<tr>
										<td><strong>@lang('user.status')</strong></td>
										<td>{{ $user->status_name }}</td>
									</tr>
									<tr>
										<td><strong>@lang('user.role')</strong></td>
										<td>{{ $user->role->name }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif
	{!! Form::ajax(['method' => isset($user_id) ? 'PUT' : 'POST', 'url' => isset($user_id) ? route('admin.user.update', ['id' => $user_id]) : route('admin.user.store'), 'class' => 'form-horizontal']) !!}
		<div class="form-body">
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					@lang('user.lastname') <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $user->last_name or '' }}" name="user[last_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					@lang('user.firstname') <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $user->first_name or '' }}" name="user[first_name]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					@lang('user.nick') <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $user->name or '' }}"  name="user[name]" type="text" placeholder="" class="form-control" />
					<span class="help-block"> @lang('user.short-name-spaces-and-special-characters') </span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					@lang('user.phone-number') <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $user->phone or '' }}" name="user[phone]" type="text" placeholder="" class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">@lang('user.birth')</label>
				<div class="col-sm-7">
					<input value="{{ isset($user_id) ? $user->birth->format('d-m-Y') : '' }}" name="user[birth]" type="text" class="form-control" placeholder="Ví dụ: 21-07-1996">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3 pull-left">
					@lang('user.email') <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					<input value="{{ $user->email or '' }}" name="user[email]" type="text" placeholder="" class="form-control">
					<span class="help-block"> @lang('user.the-email-address-will-be-used-to-login-to-the-account') </span>
				</div>
			</div>
			
			<div class="form-group">
                <label class="control-label col-sm-3">@lang('user.about')</label>
                <div class="col-sm-7">
                    <textarea name="user[about]" class="form-control" rows="3" placeholder="">{{ $user->about }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">@lang('user.facebook')</label>
                <div class="col-sm-7">
                    <input name="user[facebook]" value="{{ $user->facebook }}" type="text" placeholder="fb.com/xxx" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">@lang('user.google-plus')</label>
                <div class="col-sm-7">
                    <input name="user[google_plus]" value="{{ $user->google_plus }}" type="text" placeholder="" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">@lang('user.website')</label>
                <div class="col-sm-7">
                    <input name="user[website]" value="{{ $user->website }}" type="text" placeholder="google.com" class="form-control">
                </div>
            </div>

			@if(! isset($user_id))
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						@lang('user.password') <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="user[password]" type="password" placeholder="" class="form-control">
						<span class="help-block"> @lang('user.this-password-is-used-to-login-to-the-account') </span>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-3 pull-left">
						@lang('user.confirm-password') <span class="required">*</span>
					</label>
					<div class="col-sm-7">
						<input name="user[password_confirmation]" type="password" placeholder="" class="form-control">
					</div>
					<div class="col-sm-2">
						<div class="mt-checkbox-list">
							<label class="mt-checkbox mt-checkbox-outline"> @lang('cms.display')
								<input type="checkbox" name="test" view-password />
								<span></span>
							</label>
						</div>
					</div>
				</div>
			@endif
			
			<div class="form-group media-box-group">
                <label class="control-label col-md-3">@lang('user.upload-avatar')</label>
                <div class="col-sm-7">
                	{!! Form::btnMediaBox('user[avatar]', $user->avatar, thumbnail_url($user->avatar, ['width' => '100', 'height' => '100'])) !!}
                </div>
            </div>

			<div class="form-group last">
				<label class="control-label col-sm-3 pull-left">
					@lang('user.role') <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					{!! Form::select('user[role_id]', Phambinh\Cms\Role::get()->mapWithKeys(function ($item) {
						return [$item->id => $item->name];
					}), isset($user_id) ? $user->role_id : NULL, ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
				</div>
			</div>

			<div class="form-group last">
				<label class="control-label col-sm-3 pull-left">
					@lang('user.status') <span class="required">*</span>
				</label>
				<div class="col-sm-7">
					{!! Form::select('user[status]', \Phambinh\Cms\User::statusable()->mapWithKeys(function ($item) {
						return [$item['slug'] => $item['name']];
					})->all(), $user->status_slug, ['class' => 'form-control width-auto', 'placeholder' => '']) !!}
				</div>
			</div>

		</div>
		<div class="form-actions util-btn-margin-bottom-5">
			<div class="row">
				<div class="col-md-offset-3 col-md-9">
					@if(! isset($user_id))
						{!! Form::btnSaveNew() !!}
					@else
						{!! Form::btnSaveOut() !!}
					@endif
				</div>
			</div>
		</div>
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
