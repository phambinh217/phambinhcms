@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="col-sm-8 col-sm-offset-2">
			@include('components.note')
			<div class="panel panel-default">
				<div class="panel-heading">Liên hệ chúng tôi</div>
				<div class="panel-body">
					<form method="post" action="{{ route('contact.store', ['alias' => 'contact']) }}" class="form-horizontal">
						{{ csrf_field() }}
						<div class="form-group{{ $errors->has('contact.name') ? ' has-error' : '' }}">
							<label for="" class="control-label col-sm-3">Tên của bạn</label>
							<div class="col-sm-7">
								<input name="contact[name]" type="text" class="form-control" />
								@if ($errors->has('contact.name'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('contact.name') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="form-group {{ $errors->has('contact.email') ? ' has-error' : '' }}">
							<label for="" class="control-label col-sm-3">Email của bạn</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="contact[email]" />
								@if ($errors->has('contact.email'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('contact.email') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="form-group {{ $errors->has('contact.content') ? ' has-error' : '' }}">
							<label for="" class="control-label col-sm-3">Nội dung</label>
							<div class="col-sm-7">
								<textarea class="form-control" name="contact[content]" id="" cols="30" rows="10"></textarea>
								@if ($errors->has('contact.content'))
					                <span class="help-block">
					                    <strong>{{ $errors->first('contact.content') }}</strong>
					                </span>
					            @endif
							</div>
						</div>
						<div class="text-right">
							<button type="submit" class="btn btn-primary">Gửi</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection