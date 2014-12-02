@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb($user->username) }}
	<h1>
	@if ($user->in_wot)
	<span class="label label-success" id="username">{{{ $user->username }}}</span>
	@else
	<span id="username">{{{ $user->username }}}</span>
	@endif
	@if (isset($self) && $self && $user->in_wot)
		<button type="button" class="btn btn-success pull-right" onclick="syncWoT()">Sync with WoT</button>
	@endif
	<span id="user_id" style="display: none">
		{{ $user->id }}
	</span>
	</h1>
	<div class="row">
		<div class="col-md-6">
			<img src="/uploads/profile/{{{ $user->profile_picture }}}">
		</div>
		<div class="col-md-6">
		<h2>User Details</h2>
			<ul>
			@if ($user->monero_address != NULL)
				<li class="user-details">Monero Address: {{{ $user->monero_address }}}</li>
			@endif
			@if ($user->website != NULL)
				<li class="user-details">Website Address: <a href="{{{ $user->website }}}" rel="nofollow" target="_blank">{{{ $user->website }}}</a></li>
			@endif
			@if ($user->email_public == true)
				<li class="user-details">Email: {{ HTML::obfuscate($user->email) }}</li>
			@endif
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h2>Forum Activity</h2>
			<p>Last Seen on <em>{{ $user->updated_at }}</em></p>
			<h4>Posts</h4>
			<ul>
				<li>Total Posts: <a href="{{ URL::to('/user/'.$user->id.'/posts') }}">{{ $user->posts()->count() }}</a></li>
			</ul>
			<h4>Threads</h4>
			<ul>
				<li>Total Threads: <a href="{{ URL::to('/user/'.$user->id.'/threads') }}">{{ $user->threads()->count() }}</a></li>
			</ul>
		</div>
		<div class="col-md-6">
			<h2>Ratings</h2>
				<h4>Overall</h4>
				<ul>
					<li>Ratings Received: <a href="{{ URL::to('/user/'.$user->id.'/received/all') }}">{{ $user->rated()->count() }}</a></li>
					<li>Ratings Given: <a href="{{ URL::to('/user/'.$user->id.'/given/all') }}">{{ $user->ratings()->count() }}</a></li>
				</ul>
				<h4>Negative Ratings</h4>
				<ul>
					<li>Negative Ratings Received: <a href="{{ URL::to('/user/'.$user->id.'/received/negative') }}">{{ $user->rated()->whereRaw('rating < 0')->count() }}</a></li>
					<li>Negative Ratings Given: <a href="{{ URL::to('/user/'.$user->id.'/given/negative') }}">{{ $user->ratings()->whereRaw('rating < 0')->count() }}</a></li>
				</ul>
				<h4>Positive Ratings</h4>
				<ul>
					<li>Positive Ratings Received: <a href="{{ URL::to('/user/'.$user->id.'/received/positive') }}">{{ $user->rated()->whereRaw('rating > 0')->count() }}</a></li>
					<li>Positive Ratings Given: <a href="{{ URL::to('/user/'.$user->id.'/given/positive') }}">{{ $user->ratings()->whereRaw('rating > 0')->count() }}</a></li>
				</ul>
			</ul>
		</div>
	</div>
	<!--
	<div class="row">
		<div class="col-md-12">
			<h2>Relationships</h2>
			<canvas id="viewport" class="relationships" height="600" width="800"></canvas>
		</div>
	</div>
	-->
	@if (Auth::check() && $user->id != Auth::user()->id)
	<h2>Rate {{{ $user->username }}}</h2>
	<form role="form" method="post" action="/ratings/rate">
	<input type="hidden" name="user_id" value="{{ $user->id }}">
	  <div class="form-group">
	    <label>Rating</label>
	    <input name="rating" class="form-control">
	    <p class="help-block">The rating has to be within -10 to 10, exclusive of 0.</p>
	  </div>
	  <div class="form-group">
	    <label>Notes</label>
	    <textarea name="notes" class="form-control" rows="5"></textarea>
	  </div>
	  <button type="submit" class="btn btn-primary">Rate</button>
	</form>
	@endif
@stop

@section('modals')
	@if (isset($self) && $self && $user->in_wot)
		<div class="modal fade" id="syncModal" tabindex="-1" role="dialog" aria-labelledby="syncModal" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <h4 class="modal-title" id="syncModal">Sync with the WoT</h4>
		      </div>
		      <div class="modal-body">
		        <h4 class="text-center sync-status">Pulling your ratings</h4>
		      <form role="form" class="sync-form" style="display: none;" method="post" action="/keychain/sync/push/ratings">
		      	  <p>Please clearsign the contents of <a target="_blank" href="/keychain/ratings">this page</a> and paste it in the box below. Alternatively, you can download a <a target="_blank" href="/keychain/ratings/download">file here</a> and upload the clearsigned contents of the file.</p>
				  <div class="form-group">
				    <label>Encrypted Message</label>
				  </div>
				  <textarea name="signed_message" class="encrypted-message form-control" rows="3"></textarea>
				  <br>
				  <div class="form-group">
				  	<a href="#" onClick="pushRatings()" class="btn btn-success sync-push">Save</a>
				  </div>
			  </form>
			  </div>
		      <div class="modal-footer">
		        <button type="button" style="display: none;" class="btn btn-default sync-close" data-dismiss="modal">Close</button>
		      </div>
		    </div>
		  </div>
		</div>
	@endif
@stop

@section('javascript')
<script src="/js/arbor.js"></script>
<script src="/js/graphics.js"></script>
<script src="/js/renderer.js"></script>
<script src="/js/relationships.js"></script>
@stop