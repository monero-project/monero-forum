@extends('master')

@section('content')
<div class="row">
    <div class="col-lg-12">
    @if (Auth::check())
    	Hello, <a href="{{{ URL::to('/user/profile') }}}">{{{ Auth::user()->username }}}</a>! <a href="{{{ URL::to('logout') }}}">Logout</a>
    	<br>
    @else
    	Please <a href="/login" class="link-disabled login-modal">login</a> or <a href="/register" class="link-disabled" data-toggle="modal" data-target="#registerModal">register</a>.
    @endif
    </div>
</div>
    
@foreach ($categories as $category)
<h2>{{ $category->name }}</h2>
	@foreach ($category->forums as $forum)
	<h3><a href="{{ $forum->slug() }}/{{ $forum->id }}">{{ $forum->name }}</a></h3>
	<p>{{ $forum->description }}</p>
	@endforeach
@endforeach
@stop