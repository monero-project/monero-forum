<?php

class VotesController extends \BaseController {

	public function postVote() {
		if (Input::has('post_id') && Input::has('vote'))
		{
			$post = Post::findOrFail(Input::get('post_id'));
			$the_vote = Input::get('vote');
		}
		else
			return 'false';
		
		$vote = Vote::whereRaw('user_id = ? AND post_id = ?', array(Auth::user()->id, Input::get('post_id')))->first();
		if(!$vote)
		{
			$vote = new Vote();
			$vote->post_id = Input::get('post_id');
			$vote->user_id = Auth::user()->id;
		}
		
		$already_voted = Vote::where('user_id', '=', Auth::user()->id)->where('post_id', '=', $post->id)->first();
		
		//adding this just makes sure that there's no real way to trick the system into giving a post more than 1 upvote or downvote.
		if ($the_vote == 'insightful')
		{
			$vote->vote = 1;
			if (!$already_voted || $already_voted->vote != 1)
				$post->weight += Config::get('app.insightful_weight');
		}
		else if ($the_vote == 'irrelevant')
		{
			$vote->vote = -1;
			if (!$already_voted || $already_voted->vote == 1)
				$post->weight += Config::get('app.irrelevant_weight');
		}
		
		$vote->save();
		$post->save();
				
		return 'true';
	}
	
	//Same as POST, just with redirects instead of responses.
	public function getVote() {
		if (Input::has('post_id') && Input::has('vote'))
		{
			$post = Post::findOrFail(Input::get('post_id'));
			$the_vote = Input::get('vote');
		}
		else
			return Redirect::to(URL::previous())->with('errors', array('Sorry, we could not add your vote.'));
		
		$vote = Vote::whereRaw('user_id = ? AND post_id = ?', array(Auth::user()->id, Input::get('post_id')))->first();
		if(!$vote)
		{
			$vote = new Vote();
			$vote->post_id = Input::get('post_id');
			$vote->user_id = Auth::user()->id;
		}
		
		$already_voted = Vote::where('user_id', '=', Auth::user()->id)->where('post_id', '=', $post->id)->first();
		
		//adding this just makes sure that there's no real way to trick the system into giving a post more than 1 upvote or downvote.
		if ($the_vote == 'insightful')
		{
			$vote->vote = 1;
			if (!$already_voted || $already_voted->vote != 1)
				$post->weight += Config::get('app.insightful_weight');
		}
		else if ($the_vote == 'irrelevant')
		{
			$vote->vote = -1;
			if (!$already_voted || $already_voted->vote == 1)
				$post->weight += Config::get('app.irrelevant_weight');
		}
		
		$vote->save();
		$post->save();
				
		return Redirect::to(URL::previous())->with('messages', array('Awesome, your vote has been cast!'));
	}

}
