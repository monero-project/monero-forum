<?php

//Post helper functions. Mainly for displaying the tree view and helping to easily accommodate the endless flow + pagination.

function display_posts($parent_id, $thread_id, $level, $unread_count) {

	if ($parent_id == NULL)
	{
		$posts = Post::where('thread_id', '=', $thread_id)->whereNull('parent_id')->withTrashed()->orderBy('weight', 'DESC')->get();
		$the_posts = '<div class="col-lg-12 trunk">';
	}
	else
	{
		$posts = Post::withTrashed()->where('parent_id', '=', $parent_id)->orderBy('weight', 'DESC')->get();
		$the_posts = '<div class="col-lg-12 drawer drawer-'.$parent_id.'">';
	}
	if ($posts) {
		foreach ($posts as $post) {

			$full_breadcrumbs = get_breadcrumbs($post);
			$breadcrumbs = array_slice($full_breadcrumbs, 0, 5, true);
			$head = array_reverse($full_breadcrumbs)[0];
			$children = Post::where('parent_id', $post->id)->lists('id');
			$children = json_encode($children);

			if($post && (!$post->deleted_at || $post->children()->count() > 0)) {
				$serialized_bread = serialize_bread($full_breadcrumbs);
				if($post->is_unread)
				{
					$unread = $unread_count++;
				}
				else
				{
					$unread = $unread_count;
				}
				$the_posts .= View::make('posts.item', array('stickied' => false, 'post' => $post, 'level' => $level, 'thread_id' => $thread_id, 'breadcrumbs' => $breadcrumbs, 'serialized_bread' => $serialized_bread, 'head' => $head, 'children' => $children, 'unread_count' => $unread))->render();
			}
		}
	}

	return $the_posts.'</div>';
}

function thread_posts($posts, $thread_id, $level, $unread_count, $stickied = 0) {
	$post_list = '<div class="post-batch">';
	foreach ($posts as $post)
	{
		$post_obj = Post::withTrashed()->where('id',$post['id'])->first();
		if($post_obj && (!$post_obj->deleted_at || $post_obj->children()->count() > 0)) {
			if($post_obj->is_unread)
			{
				$unread = $unread_count++;
			}
			else
			{
				$unread = $unread_count;
			}
			$post_list .= View::make('posts.item', array('stickied' => $stickied, 'post' => $post_obj, 'level' => $level, 'thread_id' => $thread_id, 'breadcrumbs' => [], 'serialized_bread' => '', 'head' => '', 'children' => '', 'unread_count' => $unread))->render();
		}
	}
	return $post_list.'</div>';
}

function unthreaded_posts($posts, $thread_id, $unread_count, $stickied = 0) {
	$post_list = '<div class="post-batch">';
	foreach ($posts as $key => $post)
	{
		$post_obj = Post::where('id',$post['id'])->first();

		if($post_obj) {

			$full_breadcrumbs = get_breadcrumbs($post_obj);
			$breadcrumbs = array_slice($full_breadcrumbs, 0, 5, true);
			if (count($full_breadcrumbs)) {
				$head = array_reverse($full_breadcrumbs)[0];
			} else {
				$head = false;
			}
			$children = Post::where('parent_id', $post->id)->lists('id');
			$children = json_encode($children);

			if ($post_obj && (!$post_obj->deleted_at || $post_obj->children()->count())) {
				$level = 0;
				$serialized_bread = serialize_bread($full_breadcrumbs);
				if($post_obj->is_unread)
				{
					$unread = $unread_count++;
				}
				else
				{
					$unread = $unread_count;
				}
				$post_list .= View::make('posts.item', array('stickied' => $stickied, 'post' => $post_obj, 'level' => $level, 'thread_id' => $thread_id, 'breadcrumbs' => $breadcrumbs, 'serialized_bread' => $serialized_bread, 'head' => $head, 'children' => $children, 'unread_count' => $unread))->render();
			}
		}
	}
	return $post_list.'</div>';
}

function serialize_bread($breadcrumbs)
{
	$serialized_bread = [];
	foreach($breadcrumbs as $breadcrumb)
	{
		$serialized_bread[] = $breadcrumb->id;
	}
	//remove the first parent from the array.
	//array_shift($serialized_bread);
	$serialized_bread = json_encode($serialized_bread);
	return $serialized_bread;
}

function get_breadcrumbs(Post $post, $amount = false)
{

	$breadcrumbs = [];
	$upper_post = false;

	if ($post && $post->parent_id != NULL)
	{
		$upper_post = Post::find($post->parent_id);
		if ($upper_post && (!$upper_post->deleted_at || $upper_post->children()->count()))
			$breadcrumbs[] = $upper_post;
	}

	for ($i = 0; $upper_post && (($amount && $i < $amount) || !$amount); $i++)
	{
		$upper_post = Post::find($upper_post->parent_id);
		if ($upper_post && (!$upper_post->deleted_at || $upper_post->children()->count()))
			$breadcrumbs[] = $upper_post;
	}

	return $breadcrumbs;

}

?>