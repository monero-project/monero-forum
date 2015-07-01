$('.reg-username').on('input', function() {
	registration();
});

$('.wot_register_check').change(function() {
	registration();
	if ($('.wot_register_check').not(":checked")) {
		$('.username-alert').hide();
		$('.reg-key').hide();
	}
});

function registration() {
	$.ajax({
		url: "/keychain/exists/" + $('.reg-username').val(),
		success: function(result) {
			if (result === 'true') {
				$('.username-alert').show();
				$('.reg-key').hide();
				$('.wot_register').hide();
			} else {
				$('.username-alert').hide();
				if ($('.wot_register_check').is(":checked")) $('.reg-key').show();
				$('.wot_register').show();
			}
		}
	});
}

var pullResponse = false;

function pullRatings() {
	$.ajax({
	  async: false,
      cache: false,
      type: "GET",
      dataType: "text",
	  url: "/keychain/sync/pull/ratings"
	})
	  .always(function( data ) {
	    window.pullResponse = data;
	});
	return window.pullResponse;
}


var checkResponse = false;

function checkRatings() {
	$.ajax({
	  async: false,
      cache: false,
      type: "GET",
      dataType: "text",
	  url: "/keychain/ratings"
	})
	  .always(function( data ) {
	    window.checkResponse = data;
	});
	return window.checkResponse;
}

function pushRatings() {
	var data = $('.encrypted-message').val();
	$.ajax({
	  async: false,
      cache: false,
	  type: "POST",
	  url: "/keychain/sync/push/ratings",
	  data: { signed_message: data },
	  dataType: 'text'
	}).always(function( data ) {
	    if (data == 'true')
	    {
		    $('.sync-status').text('Sync complete!');
			$('.sync-status').show();
			$('.sync-close').show();
			$('.sync-form').hide();
			$('.sync-push').hide();
	    }
	    else {
		    $('.sync-status').text('Could not push the data. Try again later.');
			$('.sync-status').show();
	    }
	});
}

function syncWoT() {
	$('#syncModal').modal('show');
	if (pullRatings() === 'true')
	{
		$('.sync-status').hide();
		if (checkRatings() == '[]')
		{
			$('.sync-status').text('Sync complete!');
			$('.sync-status').show();
		}
		else {
			$('.sync-form').show();
			$('.sync-close').hide();
		}
	}
	else
	{
		$('.sync-status').text('Pull Failed.');
	}
}

function parseVideo(url) {
    // - Supported YouTube URL formats:
    //   - http://www.youtube.com/watch?v=My2FRPA3Gf8
    //   - http://youtu.be/My2FRPA3Gf8
    //   - https://youtube.googleapis.com/v/My2FRPA3Gf8
    // - Supported Vimeo URL formats:
    //   - http://vimeo.com/25451551
    //   - http://player.vimeo.com/video/25451551
    // - Also supports relative URLs:
    //   - //player.vimeo.com/video/25451551

    url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

    if (RegExp.$3.indexOf('youtu') > -1) {
        var type = 'youtube';
    } else if (RegExp.$3.indexOf('vimeo') > -1) {
        var type = 'vimeo';
    }

    return {
        type: type,
        id: RegExp.$6
    };
}

$(document).ready(function() {
    $('.markdown-editor').markdown(
        {
            parser: function(val) {
                return getKramdown(val);
            }
        }
    );

    //hide non-js
    $('.non-js').hide();
    $('.no-js').show();
});

function getKramdown(body)
{
    var kramdown_content;
    $.ajax({
        async: false,
        cache: false,
        type: "POST",
        dataType: "text",
        url: "/posts/kramdown",
        data: {
            'body': body
        }
    }).success(function (data) {
        if (data != 'false')
            kramdown_content = data;
        else
            kramdown_content = 'Oops! There was an error trying to get a preview!';

    });
    return kramdown_content;
}

$('document').ready(function(){
    $(function () {
        $("[data-toggle='tooltip']").tooltip();
        $('.file-inputs').bootstrapFileInput();
        $('.no-js-show').hide();
        $('.no-js').show();
    });

    $('#show-payments-list').click(function (e) {
        var button = $(this);
        if(button.hasClass('fa-plus-square-o')) {
            $('#payments-list').slideDown();
            button.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
        }
        else
        {
            $('#payments-list').slideUp();
            button.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
        }
    });

    $('#show-milestones-list').click(function (e) {
        var button = $(this);
        if(button.hasClass('fa-plus-square-o')) {
            $('#milestones-list').slideDown();
            button.removeClass('fa-plus-square-o').addClass('fa-minus-square-o');
        }
        else
        {
            $('#milestones-list').slideUp();
            button.removeClass('fa-minus-square-o').addClass('fa-plus-square-o');
        }
    });

    $('#expand-all').click(function () {
        $('.post .content-block').slideDown();
    });

    $('.post-block a').each(function() {
        video_uri = $(this).attr('href');
        console.log(video_uri.match(/(?:http:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?([^<]+)/g));
    });

    //$('body').html(function(i, html) {
    //    return html
    //        .replace(/(?:http:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?([^<]+)/g, '<center><iframe width="640" height="360" src="http://www.youtube.com/embed/$1?modestbranding=1&rel=0&wmode=transparent&theme=light&color=white" frameborder="0" allowfullscreen></iframe></center>')
    //        .replace(/(?:http:\/\/)?(?:www\.)?(?:vimeo\.com)\/([^<]+)/g, '<center><iframe src="//player.vimeo.com/video/$1" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></center>')
    //        .replace(/(?:http:\/\/)?(?:dailymotion\.com|dai\.ly)\/([^<]+)/g, '<center><iframe frameborder="0" width="560" height="315" src="http://www.dailymotion.com/embed/video/$1?logo=0&foreground=ffffff&highlight=1bb4c6&background=000000" allowfullscreen></iframe></center>');
    //});
});