@extends('master')

@section('content')

	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
	{{ Breadcrumbs::addCrumb('Funds Management', '/admin/manage/funds') }}
	{{ Breadcrumbs::addCrumb('Note Refund') }}

	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<form action="{{ route('refund.create.post') }}" method="post" role="form">
				<div class="form-group">
					<label for="thread_id">Thread</label>
					<select name="thread_id" id="thread_id" class="form-control">
						@foreach (Funding::lists('thread_id') as $item)
							@if(Input::has('thread_id') && Input::get('thread_id') == $item)
							<option value="{{ $item }}" selected>{{{ Thread::findOrFail($item)->name }}}</option>
							@else
							<option value="{{ $item }}">{{{ Thread::findOrFail($item)->name }}}</option>
							@endif
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="amount">Refund Amount</label>
					<input type="number" class="form-control" name="amount" id="amount" placeholder="">
					<p class="help-block">Keep in mind that the units used here are in Piconero, thus usually you would want to enter desired amount * 1,000,000,000,000</p>
				</div>
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>

@stop