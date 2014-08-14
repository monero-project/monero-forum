<?php

//Post helper functions. Mainly for displaying the tree view and helping to easily accommodate the endless flow + pagination.

function display_posts($parent_id, $thread_id, $level) {

	if ($parent_id == NULL)
	{
		$posts = Post::where('thread_id', '=', $thread_id)->whereNull('parent_id')->orderBy('weight', 'DESC')->get();
		$the_posts = '<div class="col-lg-12 trunk">';
	}
	else
	{
		$posts = Post::withTrashed()->where('parent_id', '=', $parent_id)->orderBy('weight', 'DESC')->get();
		$the_posts = '<div class="col-lg-12 drawer drawer-'.$parent_id.'">';
	}
	if ($posts) {
		foreach ($posts as $post) {
			$the_posts .= View::make('content.post', array('post' => $post, 'level' => $level, 'thread_id' => $thread_id));
		}
	}

	return $the_posts.'</div>';
}

function thread_posts($posts, $thread_id, $level) {
	$post_list = '<div class="post-batch">';
	foreach ($posts as $post)
	{
		$post_obj = Post::find($post['id']);
		$post_list .= View::make('content.post', array('post' => $post_obj, 'level' => $level, 'thread_id' => $thread_id));
	}
	return $post_list.'</div>';
}

?>