@if(Auth::check() && Auth::user()->hasRole('Admin') && Funding::isUnbalanced())
	<div class="row">
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<p>
				There's a difference between the recorded funds and the funds in the wallet! (Wallet funds: {{ number_format(Funding::getWalletFunds(), 2) }} | Database funds: {{ number_format(Funding::getDatabaseFunds(), 2) }})
				<a href="{{ route('funds.refresh') }}">
					<button class="btn btn-success btn-xs no-margin"><i class="fa fa-refresh"></i> Refresh</button>
				</a>
			</p>
		</div>
	</div>
@endif