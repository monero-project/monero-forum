@extends('master')
@section('content')
	@if(count($messages))
		@foreach($messages as $message)
			<div class="panel panel-default post-panel">
				<div class="panel-heading">
					<img class="profile-picture-sm" src="/uploads/profile/small_davidlatapie.jpg"><a href="/user/davidlatapie" target="_blank">davidlatapie</a> <span class="mobile-hide-text">posted this on</span> <span class="date">2014-11-24 21:00:58</span>
					<small>
						Weight: 390 | <a class="meta-permalink" href="http://monero.app/4/academic-and-technical/79/is-monero-compatible-with-automated-transactions?page=&amp;noscroll=1#post-457">Link</a>
					</small>
					<small class="content-control content-control-457" style="display: inline;"><span onclick="content_hide(457)">[ - ]</span></small>
							  			<span class="meta-buttons pull-right">
		  				   						   							<a href="/votes/vote/?post_id=457&amp;vote=insightful" class="disabled-link" onclick="vote(457, 'insightful')">
																		        <button type="button" class="btn btn-default btn-xs insightful-457"><span class="glyphicon glyphicon-thumbs-up"></span> Insightful</button>
																	        </a>
							<a href="/votes/vote/?post_id=457&amp;vote=irrelevant" class="disabled-link" onclick="vote(457, 'irrelevant')">
								<button type="button" class="btn btn-default btn-xs irrelevant-457"><span class="glyphicon glyphicon-thumbs-down"></span> Irrelevant</button>
							</a>
						  <a href="/posts/reply/457" class="post-action-btn"><button type="button" onclick="post_reply(457, 79, '')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-arrow-left"></span>
								  Reply</button></a>
			 			  			 			  				 					<a href="/posts/report/457/1"><button type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span>
																					        Flag</button></a>

			  			</span>
				</div>
				<div class="panel-body content-block-457 hidden-post-content" style="display: block;">
					<div class="post-content-457">
						<p>I'd love to see it implemented.</p>


						<div class="mobile-meta-buttons">
							<a href="/votes/vote/?post_id=457&amp;vote=insightful" class="disabled-link" onclick="vote(457, 'insightful')">
								<button type="button" class="btn btn-default btn-xs insightful-457"><span class="glyphicon glyphicon-thumbs-up"></span> </button>
							</a>
							<a href="/votes/vote/?post_id=457&amp;vote=irrelevant" class="disabled-link" onclick="vote(457, 'irrelevant')">
								<button type="button" class="btn btn-default btn-xs irrelevant-457"><span class="glyphicon glyphicon-thumbs-down"></span> </button>
							</a>
							<a href="/posts/reply/457" class="post-action-btn"><button type="button" onclick="post_reply(457, 79, '')" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-arrow-left"></span>
								</button></a>
							<a href="/posts/report/457/1" class="post-action-btn"><button type="button" onclick="post_flag(457)" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-flag"></span>
								</button></a>
						</div>


					</div>
				</div>
			</div>
		@endforeach
	@else
		<div class="row">
			<div class="well">
				You have no messages.
			</div>
		</div>
	@endif
@stop