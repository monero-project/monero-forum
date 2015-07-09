<div class="row post-breadcrumbs">
	@if (sizeof($breadcrumbs))
		<span class="reply-to"> Reply to: </span>
	@endif
	@foreach (($breadcrumbs) as $key => $breadcrumb)
		<a class="post-crumb" href="#post-{{ $breadcrumb->id }}" data-toggle="tooltip" data-placement="top" title="{{ str_limit(trim(preg_replace('/\s\s+/', ' ', strip_tags($breadcrumb->body))), 155, '[...]')  }}" alt="{{ str_limit(e($breadcrumb->body), 200, '...') }}">{{ $breadcrumb->user->username }}</a>@if (sizeof($breadcrumbs)-1 != $key)<i class="fa fa-angle-right reply-bullet"></i>@endif
	@endforeach
</div>