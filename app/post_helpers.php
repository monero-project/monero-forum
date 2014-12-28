<?php

//Post helper functions. Mainly for displaying the tree view and helping to easily accommodate the endless flow + pagination.

function display_posts($parent_id, $thread_id, $level) {

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
		
			$breadcrumbs = array();
			$i = 0;
			
			if ($post->parent_id != NULL)
			{
				$upper_post = Post::find($post->parent_id);
				if ($upper_post && (!$upper_post->deleted_at || $upper_post->children()->count() > 0))
					$breadcrumbs[] = $upper_post;
			}
			
			while ($upper_post && $i < 5)
			{
				$upper_post = Post::find($upper_post->parent_id);
				if ($upper_post && (!$upper_post->deleted_at || $upper_post->children()->count() > 0))
					$breadcrumbs[] = $upper_post;
				$i++;
			}
			if($post && (!$post->deleted_at || $post->children()->count() > 0))
				$the_posts .= View::make('content.post', array('post' => $post, 'level' => $level, 'thread_id' => $thread_id, 'breadcrumbs' => $breadcrumbs));
			
		}
	}

	return $the_posts.'</div>';
}

function thread_posts($posts, $thread_id, $level) {
	$post_list = '<div class="post-batch">';
	foreach ($posts as $post)
	{
		$post_obj = Post::withTrashed()->where('id',$post['id'])->first();
		if($post_obj && (!$post_obj->deleted_at || $post_obj->children()->count() > 0))
			$post_list .= View::make('content.post', array('post' => $post_obj, 'level' => $level, 'thread_id' => $thread_id, 'breadcrumbs' => array()));
	}
	return $post_list.'</div>';
}

function unthreaded_posts($posts, $thread_id) {
	$post_list = '<div class="post-batch">';
	foreach ($posts as $key => $post)
	{
		$post_obj = Post::where('id',$post['id'])->first();
		
		$breadcrumbs = array();
		$i = 0;
		$upper_post = false;
		
		if ($post_obj->parent_id != NULL)
		{
			$upper_post = Post::find($post_obj->parent_id);
			if ($upper_post && (!$upper_post->deleted_at || $upper_post->children()->count() > 0))
				$breadcrumbs[] = $upper_post;
		}
		
		while ($upper_post && $i < 5)
		{
			$upper_post = Post::find($upper_post->parent_id);
			if ($upper_post && (!$upper_post->deleted_at || $upper_post->children()->count() > 0))
				$breadcrumbs[] = $upper_post;
			$i++;
		}

		if($post_obj && (!$post_obj->deleted_at || $post_obj->children()->count() > 0))
		{
			$level = 0;
			$post_list .= View::make('content.post', array('post' => $post_obj, 'level' => $level, 'thread_id' => $thread_id, 'breadcrumbs' => $breadcrumbs));
		}
	}
	return $post_list.'</div>';
}

?>