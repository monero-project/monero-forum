@extends('master')
@section('content')
<h1>Ratings of {{ $user->username }}</h1>
<div class="table-responsive">
	  <table class="table">
      <thead>
        <tr>
          <th>Rating</th>
          <th>Giver</th>
          <th>Receiver</th>
          <th>Notes</th>
        </tr>
      </thead>
      <tbody>
      @foreach($ratings as $rating)
        <tr>
          <td>{{{ $rating->rating }}}</td>
          @if (User::where('username', '=', $rating->username)->first())
          <td>{{ User::where('username', '=', $rating->username)->first()->profile() }}</td>
          @else
          <td>{{{ $rating->username }}}</td>
          @endif
          @if (User::where('username', '=', $rating->rated_username)->first())
          <td>{{ User::where('username', '=', $rating->rated_username)->first()->profile() }}</td>
          @else
          <td>{{{ $rating->rated_username }}}</td>
          @endif
          <td>{{{ $rating->notes }}}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
	</div>
	{{ $ratings->links() }}
@stop