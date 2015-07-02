<div class="col-md-6 search-bar">
	{{ Form::open(array('url' => '/search', 'class' => 'form-inline')) }}
	<div class="form-group">
		<input type="text" name="query" class="form-control search-text" placeholder="Search...">
	</div>
	@if(Route::current() && (Route::current()->getName() == 'threadView' || Route::current()->getName() == 'forum.index'))
	<div class="form-group search-location">
		<input type="checkbox" name="closed_location" checked value="{{ Route::current()->getName() }}"> <span class="mobile-hidden">This location</span>
		<input type="hidden" name="resource_id" value="{{ $resource_id or 0 }}"/>
	</div>
	@endif
	<div class="form-group">
		<button class="btn btn-success btn-search" type="submit"><i class="fa fa-search"></i> Go!</button>
	</div>
	{{ Form::close() }}
</div>