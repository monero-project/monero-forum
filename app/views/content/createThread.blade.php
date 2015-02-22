@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb(e($forum->name), $forum->permalink()) }}
{{ Breadcrumbs::addCrumb('Create a thread') }}
	<div class="row">
		<div class="col-lg-12">
			<h1>Create a Thread</h1>
			{{ Form::open(array('url' => '/thread/create')) }}
			 <input type="hidden" value="{{ $forum->id }}" name="forum_id">
			  <div class="form-group">
			    <input type="text" class="form-control" name="name" placeholder="Your descriptive thread title goes here." value="{{ Input::old('name') }}">
			  </div>
				<div class="row markdown-buttons markdown-buttons-main">
					<button type="button" class="btn btn-sm btn-default" onclick="$('#content-body').surroundSelectedText('**', '**')"><span class="glyphicon glyphicon-bold"></span></button>
					<button type="button" class="btn btn-sm btn-default" onclick="$('#content-body').surroundSelectedText('*', '*')"><span class="glyphicon glyphicon-italic"></span></button>
					<button type="button" class="btn btn-sm btn-default" onclick="$('#content-body').surroundSelectedText('![alt text](', ')')"><span class="glyphicon glyphicon-picture"></span></button>
					<button type="button" class="btn btn-sm btn-default" onclick="$('#content-body').surroundSelectedText('[Link Text](', ')')"><span class="glyphicon glyphicon-globe"></span></button>
				</div>
			  <div class="form-group">
			    <textarea id="content-body" name="body" class="form-control" rows="10" placeholder="Anything you want to say in your thread should be here.">{{ Input::old('body') }}</textarea>
			  </div>
			  <button name="submit" type="submit" class="btn btn-success">Create Thread</button>
			  <button name="preview" class="btn btn-success preview-button">Preview</button>
			  <a href="{{ $forum->permalink() }}"><button type="button" class="btn btn-danger">Back</button></a>
			  
			{{ Form::close() }}
		</div>
	</div>
	@if (Session::has('preview'))
	<div class="row content-preview">
		<div class="col-lg-12 preview-window">
		{{ Markdown::string(Session::get('preview')) }}
		</div>
	@else
	<div class="row content-preview" style="display: none">
		<div class="col-lg-12 preview-window">
		Hey, whenever you type something in the upper box using markdown, you will see a preview of it over here!
		</div>
	@endif
	</div>
@stop

@section('javascript')
	{{ HTML::script('js/js-markdown-extra.js') }}
	{{ HTML::script('js/preview.js') }}
	{{ HTML::script('js/rangyinputs-jquery-1.1.2.min.js') }}
@stop