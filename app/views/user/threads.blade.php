@extends('master')
@section('content')
<h1>Threads by {{ $user->username }}</h1>
<div class="table-responsive">
	  <table class="table">
      <thead>
        <tr>
          <th>Thread Name</th>
        </tr>
      </thead>
      <tbody>
      @foreach($threads as $thread)
        <tr>
			<td>
				<a href="{{{ $thread->permalink() }}}">{{{ $thread->name }}}</a>
			</td>
        </tr>
      @endforeach
      </tbody>
    </table>
	</div>
	{{ $threads->links() }}
@stop