@extends('master')
@section('content')
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="row">
				<div class="col-md-4">
					<img src="/uploads/profile/{{$user->profile_picture}}">
				</div>
				<div class="col-md-8">
					<h2>Hello {{{ $user->username }}}!</h2>
					<p>This is your personal profile settings page.</p>
				</div>
			</div>
			<h2>User Details</h2>
			{{ Form::open(array('url' => '/user/settings/save')) }}
				<div class="form-group">
					<div class="row">
				    	<label class="col-sm-2 control-label">Email</label>
						<div class="col-sm-10">
							<input type="email" name="email" class="form-control" value="{{{ $user->email }}}">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<label class="checkbox-inline pull-right public-email">
						@if ($user->email_public)
							<input type="checkbox" name="email_public" checked> Show your email to the public?
						@else
							<input type="checkbox" name="email_public"> Show your email to the public?
						@endif
						</label>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
				    	<label class="col-sm-2 control-label">Monero Address <small>(optional)</small></label>
						<div class="col-sm-10">
							<input type="text" name="monero_address" class="form-control" value="{{{ $user->monero_address }}}">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
				    	<label class="col-sm-2 control-label">Website Address <small>(optional)</small></label>
						<div class="col-sm-10">
							<input type="text" name="website" class="form-control" value="{{{ $user->website }}}">
						</div>
					</div>
				</div>
				<p>Only enter a new password if you wish to change it.</p>
				<div class="form-group">
					<div class="row">
					    <label class="col-sm-2 control-label">New Password</label>
					    <div class="col-sm-10">
					      <input type="password" name="password" class="form-control">
					    </div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
					    <label class="col-sm-2 control-label">Repeat Password</label>
					    <div class="col-sm-10">
					      <input type="password" name="password_confirmation" class="form-control">
					    </div>
					</div>
				</div>
				<button class="btn btn-sm btn-success pull-right" type="submit" name="submit">Save</button>
			{{ Form::close() }}
		</div>
	</div>
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2>Profile Picture</h2>
			{{ Form::open(array('url' => '/user/upload/profile', 'files' => true)) }}
				<div class="form-group">
					<input type="file" class="file-inputs" name="profile" title="Choose a picture.">
					<p class="helpblock">The picture has to be 150 x 150 pixels in size. If it is bigger than that, it will be resized.</p>
				</div>
				<button class="btn btn-sm btn-success pull-right" type="submit" name="submit">Upload</button>
			{{ Form::close() }}
		</div>
	</div>
@stop

@section('javascript')
<script src="/js/bootstrap.file-input.js"></script>
<script>
$('.file-inputs').bootstrapFileInput();
</script>
@stop