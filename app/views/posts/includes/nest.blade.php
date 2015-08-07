@if ((Input::has('sort') && Input::get('sort') == 'weight') || (!Input::has('sort') && (Auth::check() && Auth::user()->default_sort == 'weight')) || !Input::has('sort') && !Auth::check())
	{{ display_posts($post->id, $thread_id, $level + 1, $unread_count) }}
@endif