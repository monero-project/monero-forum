@extends('master')
@section('content')
	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
	{{ Breadcrumbs::addCrumb('Funds') }}
		<div class="row">
			<div class="col-lg-12">
					@foreach($items as $item)
						<div class="col-lg-12">
							<div class="row">
								<a href="{{ route('thread.short', $item->thread->id) }}" target="_blank">{{{ $item->thread->name }}}</a>
								<div class="col-lg-12">
									<a href="{{ route('payout.create', [$item->id]) }}">Create Payout</a>
									<ul class="fa-ul">
										<li><i class="fa fa-li fa-money"></i> <b>Funded:</b> {{ number_format ($item->funded(), 2, ".", ",") }} {{ $item->currency }}</li>
										<li><i class="fa fa-li fa-money"></i> <b>Paid Out:</b> {{ $item->payouts()->sum('amount') }} XMR</li>
										<li><i class="fa fa-li fa-money"></i> <b>Remaining Balance:</b> {{ number_format ($item->balance(), 2, ".", ",") }} {{ $item->currency }}</li>
									</ul>
									<ul>
										@foreach($item->payouts as $payout)
											<li>{{ $payout->amount }} XMR - {{ $payout->created_at->formatLocalized('%A %d %B %Y') }}</li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
				@endforeach
			</div>
			<div class="col-lg-12">
				{{ $items->links() }}
			</div>
		</div>
@stop