@extends('master')

@section('content')
	@if(count($messages))
		@foreach($messages as $message)
			<div class="panel panel-default">
				<div class="panel-heading">{{ $message->sender }} - {{ $message->date }}</div>
				<div class="panel-body">
					{{ $message->body }}
				</div>
			</div>
		@endforeach
	@else
		<div class="row">
			<div class="well">
				You have no messages.
			</div>
		</div>
	@endif
@stop