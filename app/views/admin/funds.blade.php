@extends('master')
@section('content')
	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
	{{ Breadcrumbs::addCrumb('Funds') }}

		<div class="row">
			<div class="col-lg-12">
				<a href="{{ route('refund.create') }}"><button class="btn btn-success">Note a Refund</button></a>
				<a href="{{ route('refund.all') }}"><button class="btn btn-success">All Refunds</button></a>
				<a href="{{ route('payout.all') }}"><button class="btn btn-success">All Payouts</button></a>
			</div>
		</div>

		<div class="row funding-info-block">
			<div class="col-md-4">
				<h3 class="text-center">Total Required</h3>
				<h4 class="text-center">XMR {{ number_format(Funding::totalRequired(), 2, ".", ",") }}</h4>
			</div>
			<div class="col-md-4">
				<h3 class="text-center">Total Funded</h3>
				<h4 class="text-center">XMR {{ number_format(Funding::totalFunded(), 2, ".", ",") }}</h4>
			</div>
			<div class="col-md-4">
				<h3 class="text-center">Available Funds</h3>
				<h4 class="text-center">XMR {{ number_format(Funding::totalAvailable(), 2, ".", ",") }}</h4>
			</div>
		</div>

		<div class="row funding-threads-block">
			<div class="col-lg-12">
				<h3>Funding Threads</h3>
				@foreach($items as $item)
					@if($item->thread)
						<div class="media funding-thread-item">
							<div class="media-body">
								<h4 class="media-heading"><a href="{{ route('thread.short', $item->thread->id) }}" target="_blank">{{{ $item->thread->name }}}</a></h4>
								<div class="row">
									<div class="col-lg-12">
										<i class="fa fa-li fa-money"></i> <b>Funded:</b> {{ number_format ($item->funded(), 2, ".", ",") }} {{ $item->currency }} |
										<i class="fa fa-li fa-money"></i> <b>Paid Out:</b> {{ $item->payouts()->sum('amount') }} XMR |
										<i class="fa fa-li fa-money"></i> <b>Remaining Balance:</b> {{ number_format ($item->balance(), 2, ".", ",") }} {{ $item->currency }}
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<a href="{{ route('payout.create', [$item->id]) }}"><button class="btn btn-success btn-xs">Create Payout</button></a>
										<a href="{{ route('payout.all', ['funding_id' => $item->id]) }}"><button class="btn btn-success btn-xs">View Payouts</button></a>
										<a href="{{ route('transfer.create', ['from_id' => $item->thread->id]) }}"><button class="btn btn-warning btn-xs">Transfer Funds</button></a>
										<a href="{{ route('refund.create', ['thread_id' => $item->thread->id]) }}"><button class="btn btn-danger btn-xs">Note a Refund</button></a>
									</div>
								</div>
							</div>
						</div>
					@endif
				@endforeach
			</div>
			<div class="col-lg-12">
				{{ $items->links() }}
			</div>
		</div>
@stop