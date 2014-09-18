@extends('master')
@section('content')
{{ Breadcrumbs::addCrumb('Home', '/') }}
{{ Breadcrumbs::addCrumb('Posts') }}
<h1>Posts by {{ $user->username }}</h1>
<div class="table-responsive">
	  <table class="table">
      <thead>
        <tr>
          <th>Thread</th>
          <th>Post Title</th>
          <th>Post Excerpt</th>
        </tr>
      </thead>
      <tbody>
      @foreach($posts as $post)
        <tr>
			<td>
				<a href="{{{ $post->thread->permalink() }}}">{{{ $post->thread->name }}}</a>
			</td>
			<td>
				{{{ $post->title }}}
			</td>
			<td>
				{{{ str_limit($post->body, 100, '...') }}}
			</td>
        </tr>
      @endforeach
      </tbody>
    </table>
	</div>
	{{ $posts->links() }}
@stop