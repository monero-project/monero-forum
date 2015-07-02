<div class="row user-block">
	<div class="col-md-6">
		@if (Auth::check())
			Hello,
			<a class="name" href="{{ URL::to('/user/profile') }}">{{{ Auth::user()->username }}}</a>.
			<a class="action-link" href="{{ URL::to('/messages') }}" alt="Private Messages" title="Private Messages" data-toggle="tooltip" data-placement="bottom" data-original-title="Private Messages">
				@if(Message::unreadCount() > 0)
					<i class="fa fa-envelope kicks"></i>
				@else
					<i class="fa fa-envelope-o"></i>
				@endif
			</a>
			<a class="action-link" href="{{ URL::route('notifications.index') }}"  alt="Notifications" title="Notifications">
				@if(Notification::unreadCount() > 0)
					<i class="fa fa-bell kicks" data-toggle="tooltip" data-placement="bottom" data-original-title="Notifications"></i>
				@else
					<i class="fa fa-bell-o" data-toggle="tooltip" data-placement="bottom" data-original-title="Notifications"></i>
				@endif
			</a>
			<a class="action-link" href="{{ URL::to('/user/settings') }}"  alt="Settings" title="Settings"><i class="fa fa-cog" data-toggle="tooltip" data-placement="bottom" data-original-title="Settings"></i></a>
			<a class="action-link" href="{{ URL::to('/users/action/allread') }}" alt="Mark everything as read" title="Mark as Read" data-toggle="tooltip" data-placement="bottom" data-original-title="Mark forum as read"><i class="fa fa-check"></i></a>
			<a class="action-link" href="{{ URL::to('/logout') }}" alt="Logout" title="Logout"><i class="fa fa-sign-out" data-toggle="tooltip" data-placement="bottom" data-original-title="Log Out"></i></a>
			<br>
		@else
			Please <a href="/login" class="link-disabled action-link">login</a> or <a href="/register" class="link-disabled action-link">register</a>.
		@endif
	</div>
	@include('includes.searchbar')
</div>