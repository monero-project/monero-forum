@if (Session::has('messages'))
	<div class="row">
		<div class="alert alert-info fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			@foreach(Session::pull('messages') as $message)
				<p>{{ $message }}</p>
			@endforeach
		</div>
	</div>
@endif
@if (Session::has('errors'))
	<div class="row">
		<div class="alert alert-danger fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
			@foreach(Session::pull('errors') as $error)
				<p>{{ $error }}</p>
			@endforeach
		</div>
	</div>
@endif