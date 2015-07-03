@extends('master')
@section('content')
	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
	{{ Breadcrumbs::addCrumb('Funds', '/admin/manage/funds') }}
	{{ Breadcrumbs::addCrumb('Create Payout') }}
	<div class="row">
		{{ Form::open(array('route' => ['payout.store', $id], 'method' => 'post')) }}
			<div class="form-group">
				<label for="amount">Amount</label>
				<input type="text" class="form-control" id="amount" name="amount" placeholder="200">
			</div>
		<button class="btn btn-success" type="submit">Create</button>
		{{ Form::close() }}
	</div>
@stop