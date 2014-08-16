//infinite scrolling. Courtesy of jQuery infinitescroll.js
$('#trunk').infinitescroll({
    navSelector     : ".pagination",
    nextSelector    : ".pagination a:last",
    itemSelector    : ".post-batch",
    debug           : false,
    dataType        : 'html',
    path: function(index) {
        return "?page=" + index;
    }
}, function(newElements, data, url){

    var $newElems = $( newElements );

});
var loadedAll = false;
var replyOpen = false;

init();

//Change default link functionality
$('.post-action-btn').click(function(e) {
		e.preventDefault();
});
$('.disabled-link').click(function(e) {
		e.preventDefault();
});

//Change the page looks for JS functionality
function init() {
	$('.reply-thread').show();
	$('.reply-box').hide();
	$('.drawer-button').show();
	$('.reply-cancel').show();
	$('.hide').hide();
	$('.pagination').hide();
	$('.replies-list b').show();
}

//Post and thread manipulation

function thread_reply() {
	$(".reply-box").slideDown();
	$(".reply-thread").slideUp();
}

function post_reply(post_id, thread_id, post_title) {
	if (!replyOpen)
	{
		$('#post-'+post_id).append('<form role="form" class="col-lg-12 post-reply-form post-reply-form-'+post_id+'" style="display: none;" action="/posts/submit" method="POST"><input type="hidden" name="post_id" value="'+post_id+'"><input type="hidden" name="thread_id" value="'+thread_id+'"><div class="form-group"><textarea class="form-control" name="body" rows="6" placeholder="Your insightful masterpiece goes here..."></textarea></div><button type="submit" class="btn btn-success btn-sm">Submit Reply</button><button type="button" onclick="cancel_post_reply('+post_id+')" class="btn btn-danger btn-sm reply-cancel" style="margin-left: 10px;">Cancel</button></form>');
		$('.post-reply-form-'+post_id).slideDown();
		replyOpen = true;
	}
}

function post_edit(post_id, thread_id, post_title) {
	if (!replyOpen)
	{
		get_post_content(post_id);
		$('#post-'+post_id).append('<form role="form" class="col-lg-12 post-edit-form post-edit-form-'+post_id+'" style="display: none;" action="/posts/update" method="POST"><input type="hidden" name="post_id" value="'+post_id+'"><input type="hidden" name="thread_id" value="'+thread_id+'"><div class="form-group"><textarea class="form-control" name="body" rows="6" >'+post_content+'</textarea></div><button type="submit" class="btn btn-sm btn-success">Save</button><button type="button" onclick="cancel_post_edit('+post_id+')" class="btn btn-danger btn-sm reply-cancel" style="margin-left: 10px;">Cancel</button></form>');
		$('.post-edit-form-'+post_id).slideDown();
		replyOpen = true;
	}
}

function cancel_thread_reply() {
	$(".reply-box").slideUp();
	$(".reply-thread").slideDown();
}

function cancel_post_reply(post_id) {
	$('.post-reply-form-'+post_id).slideUp(function() {
		$('.post-reply-form-'+post_id).remove();
		replyOpen = false;
	});
}

function cancel_post_edit(post_id) {
	$('.post-edit-form-'+post_id).slideUp(function() {
		$('.post-edit-form-'+post_id).remove();
		replyOpen = false;
	});
}

function post_delete(post_id) {
	$.ajax({
	  async: false,
      cache: false,
      type: "GET",
      dataType: "text",
	  url: "/posts/delete/"+post_id
	})
	  .always(function( data ) {
	    if (data == 'true')
	    {
	    	$('.post-content-'+post_id).html('<p><em>[deleted]</em></p>');
	    }
	});
}

function drawer_open(drawer_id) {
	$('.drawer-'+drawer_id).slideDown(function() {
		$('.drawer-buttons-'+drawer_id).html('<span onClick="drawer_close('+drawer_id+')" class="glyphicon glyphicon-collapse-up"></span>')
	});
}

function drawer_close(drawer_id) {
	$('.drawer-'+drawer_id).slideUp(function() {
		$('.drawer-buttons-'+drawer_id).html('<span onClick="drawer_open('+drawer_id+')" class="glyphicon glyphicon-collapse-down"></span>')
	});
}

function post_flag(post_id)
{
	alert('dirty snitch.');
}

var post_content = null;

function get_post_content(post_id)
{
	$.ajax({
	  async: false,
      cache: false,
      type: "GET",
      dataType: "text",
	  url: "/posts/get/"+post_id
	})
	  .success(function( data ) {
	    if (data != 'false')
	    	post_content = data;
	    else
	    	post_content = 'Oops! There was an error trying to edit your post!';
	    
	});
}

// Voting

function vote(post_id, vote) {
	$.ajax({
      async: false,
      cache: false,
	  type: "POST",
	  url: "/votes/vote",
	  data: { post_id: post_id, vote: vote }
	})
	.done(function( data ) {
	    if (vote == 'insightful' && data == 'true')
	    {
		    $('.insightful-'+post_id).addClass('disabled');
		    $('.irrelevant-'+post_id).removeClass('disabled');
	    }
	    else if (vote == 'irrelevant' && data == 'true')
		{
			$('.irrelevant-'+post_id).addClass('disabled');
			$('.insightful-'+post_id).removeClass('disabled');
		}
	});
}

// Form handlers

$('.edit-submit').click(function() {
	$(".post-edit-form").ajaxSubmit({url: '/posts/update', type: 'post'});
});