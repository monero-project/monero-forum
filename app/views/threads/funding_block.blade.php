<div class="funding-wrapper">
	<div class="row funding-block" style="text-align: center; padding-top: 50px;">
		<h3 style="font-size:35px;">{{ $thread->funding->symbol() }}{{ number_format ($thread->funding->funded(), 2, ".", ",") }}
		</h3>
		<p style="text-transform: uppercase; font-size:18px;">funded of {{ $thread->funding->symbol() }}{{ number_format($thread->funding->target, 2, ".", ",") }} target</p>
	</div>
	<div class="row the-bar" style="font-size:18px; height: 150px; padding-top: 50px;">
		<div class="col-xs-6">
			{{ $thread->funding->contributions() }} individual contributions
		</div>
		<div class="col-xs-6 text-right">
			{{ number_format($thread->funding->percentage(), 2) }}%
		</div>
		<div class="col-lg-12">
			<div class="progress">
				<div class="progress-bar progress-bar-monero progress-bar-striped" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{ $thread->funding->percentage() }}%; background: #ff6c3c;">
					<span class="sr-only">{{ $thread->funding->percentage() }}% Complete</span>
				</div>
			</div>
		</div>
		<div class="col-lg-12 text-center">
			<a href="{{ URL::route('contribute', $thread->id) }}"><button class="btn btn-success btn-lg">Contribute</button></a>
		</div>
	</div>
</div>