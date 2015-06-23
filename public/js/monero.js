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

$(document).ready(function() {
    $('.markdown-editor').markdown(
        {
            parser: function(val) {
                return getKramdown(val);
            }
        }
    );
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