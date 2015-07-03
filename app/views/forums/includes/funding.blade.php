<div class="col-lg-6">
	<div class="funding-info-box">
		{{ $thread->funding->symbol().number_format ($thread->funding->funded(), 2, ".", ",") }} / {{ $thread->funding->symbol().number_format ($thread->funding->target, 2, ".", ",") }} raised in {{ $thread->funding->contributions() }} contributions
	</div>
	<div>
		<i class="fa fa-usd funding-icon"></i>
		<div class="progress forum-progress">
			<div class="progress-bar progress-monero progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{ $thread->funding->percentage() }}%;">
			</div>
		</div>
	</div>
</div>
<div class="col-lg-6">
	<div class="funding-info-box">
		{{ Milestone::completed($thread->funding->id)  }} / {{ Milestone::total($thread->funding->id) }} milestones reached
	</div>
	<div>
		<i class="fa fa-wrench funding-icon"></i>
		<div class="progress forum-progress">
			<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: {{ Milestone::percentage($thread->funding->id) }}%;">
			</div>
		</div>
	</div>
</div>