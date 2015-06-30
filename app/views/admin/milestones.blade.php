@extends('master')
@section('content')
	{{ Breadcrumbs::addCrumb('Home', '/') }}
	{{ Breadcrumbs::addCrumb('Admin Panel', '/admin') }}
	{{ Breadcrumbs::addCrumb('Milestones') }}
		<div class="row">
			<div class="col-lg-12">
				<ul>
				@foreach($items as $item)
					<li><a href="{{ route('milestones.index', [$item->thread->id]) }}">{{{ $item->thread->name }}}</a></li>
				@endforeach
				</ul>
			</div>
			<div class="col-lg-12">
				{{ $items->links() }}
			</div>
		</div>
@stop