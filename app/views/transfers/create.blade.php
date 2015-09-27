@extends('master')

@section('content')
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<form action="{{ route('transfer.store') }}" method="post" role="form">
				<div class="form-group">
					<label for="from_id">Transfer From</label>
					<select name="from_id" id="from_id" class="form-control">
						@foreach (Funding::lists('thread_id') as $item)
							@if(Input::has('from_id') && Input::get('from_id') == $item)
								<option value="{{ $item }}" selected>{{{ Thread::findOrFail($item)->name }}}</option>
							@else
								<option value="{{ $item }}">{{{ Thread::findOrFail($item)->name }}}</option>
							@endif
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="to_id">Transfer To</label>
					<select name="to_id" id="to_id" class="form-control">
						@foreach (Funding::lists('thread_id') as $item)
							@if(Input::has('to_id') && Input::get('to_id') == $item)
								<option value="{{ $item }}" selected>{{{ Thread::findOrFail($item)->name }}}</option>
							@else
								<option value="{{ $item }}">{{{ Thread::findOrFail($item)->name }}}</option>
							@endif
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="amount">Transfer Amount</label>
					<input type="number" class="form-control" name="amount" id="amount" placeholder="">
					<p class="help-block">Keep in mind that the units used here are in Piconero, thus usually you would want to enter desired amount * 1,000,000,000,000</p>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
@stop