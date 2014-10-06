@extends('master')
@section('content')
	<p>{{ $debug['query'] }}</p>
	@foreach($debug['results'] as $result)
	<pre>{{ var_dump($result) }}</pre>
	<hr>
	@endforeach
@stop