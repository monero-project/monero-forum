//infinite scrolling. Courtesy of jQuery infinitescroll.js
$('#trunk').infinitescroll({
    navSelector: ".pagination",
    nextSelector: ".pagination a:last",
    itemSelector: ".post-batch",
    debug: false,
    dataType: 'html',
    animate: false,
    path: function (index) {
        var sort = get_url_param('sort');
        if (sort !== '') {
            return "?page=" + index + '&sort=' + sort;
        }
        else {
            return "?page=" + index;
        }
    }
}, function (newElements, data, url) {

    var $newElems = $(newElements);

});
var loadedAll = false;
var replyOpen = false;

init();

//Change default link functionality
$('.post-action-btn').click(function (e) {
    e.preventDefault();
});

$('.disabled-link').click(function (e) {
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
    $('.content-control').show();
    $('.hidden-post-content').hide();
}

//Post and thread manipulation

function thread_reply() {
    $(".reply-box").slideDown();
    $(".reply-thread").slideUp();
}

function post_reply(post_id, thread_id, post_title) {
    if (!replyOpen) {
        $('#post-' + post_id).append('<form role="form" class="col-lg-12 post-reply-form post-reply-form-' + post_id + '" style="display: none;" action="/posts/submit" method="POST"><input type="hidden" name="post_id" value="' + post_id + '"><input type="hidden" name="thread_id" value="' + thread_id + '"><div class="markdown-buttons"><button type="button" class="btn btn-sm btn-default" onClick="$(\'.markdown-insert\').surroundSelectedText(\'**\', \'**\')"><span class="glyphicon glyphicon-bold"></span></button><button type="button" class="btn btn-sm btn-default" onClick="$(\'.markdown-insert\').surroundSelectedText(\'*\', \'*\')"><span class="glyphicon glyphicon-italic"></span></button><button type="button" class="btn btn-sm btn-default" onClick="$(\'.markdown-insert\').surroundSelectedText(\'![alt text](\', \')\')"><span class="glyphicon glyphicon-picture"></span></button><button type="button" class="btn btn-sm btn-default" onClick="$(\'.markdown-insert\').surroundSelectedText(\'[Link Text](\', \')\')"><span class="glyphicon glyphicon-globe"></span></button></div><div><p class="syntax">For post formatting please use Markdown, <a href="http://daringfireball.net/projects/markdown/syntax">click here</a> for a syntax guide. </p></div><div class="form-group"><textarea class="form-control markdown-insert" name="body" id="reply-body" rows="6" placeholder="Your insightful masterpiece goes here..."></textarea></div><button type="submit" class="btn btn-success btn-sm" name="submit">Submit Reply</button><button type="button" onclick="cancel_post_reply(' + post_id + ')" class="btn btn-danger btn-sm reply-cancel" style="margin-left: 10px;">Cancel</button><div class="row content-preview"><div class="col-lg-12 preview-window-reply">Hey, whenever you type something in the upper box using markdown, you will see a preview of it over here!</div></div></form>');
        $('.post-reply-form-' + post_id).slideDown();
        replyOpen = true;

        $('#reply-body').change(function () {
            $('.preview-window-reply').html(Markdown($('#reply-body').val()));
        });

        $('#reply-body').keyup(function () {
            $('.preview-window-reply').html(Markdown($('#reply-body').val()));
        });
    }
}

function post_edit(post_id, thread_id, post_title) {
    if (!replyOpen) {
        get_post_content(post_id);
        $('#post-' + post_id).append('<form role="form" class="col-lg-12 post-edit-form post-edit-form-' + post_id + '" style="display: none;" action="/posts/update" method="POST"><input type="hidden" name="post_id" value="' + post_id + '"><input type="hidden" name="thread_id" value="' + thread_id + '"><div class="markdown-buttons"><button type="button" class="btn btn-sm btn-default" onClick="$(\'.markdown-insert\').surroundSelectedText(\'**\', \'**\')"><span class="glyphicon glyphicon-bold"></span></button><button type="button" class="btn btn-sm btn-default" onClick="$(\'.markdown-insert\').surroundSelectedText(\'*\', \'*\')"><span class="glyphicon glyphicon-italic"></span></button><button type="button" class="btn btn-sm btn-default" onClick="$(\'.markdown-insert\').surroundSelectedText(\'![alt text](\', \')\')"><span class="glyphicon glyphicon-picture"></span></button><button type="button" class="btn btn-sm btn-default" onClick="$(\'.markdown-insert\').surroundSelectedText(\'[Link Text](\', \')\')"><span class="glyphicon glyphicon-globe"></span></button></div><div><p class="syntax">For post formatting please use Markdown, <a href="http://daringfireball.net/projects/markdown/syntax">click here</a> for a syntax guide. </p></div><div class="form-group"><textarea class="form-control markdown-insert" id="reply-edit" name="body" rows="6" >' + post_content + '</textarea></div><button type="submit" class="btn btn-sm btn-success" name="submit">Save</button><button type="button" onclick="cancel_post_edit(' + post_id + ')" class="btn btn-danger btn-sm reply-cancel" style="margin-left: 10px;">Cancel</button><div class="row content-preview"><div class="col-lg-12 preview-window-edit">Hey, whenever you type something in the upper box using markdown, you will see a preview of it over here!</div></div></form>');
        $('.post-edit-form-' + post_id).slideDown();
        replyOpen = true;

        $('#reply-edit').change(function () {
            $('.preview-window-edit').html(Markdown($('#reply-edit').val()));
        });

        $('#reply-edit').keyup(function () {
            $('.preview-window-edit').html(Markdown($('#reply-edit').val()));
        });
    }
}

function cancel_thread_reply() {
    $(".reply-box").slideUp();
    $(".reply-thread").slideDown();
}

function cancel_post_reply(post_id) {
    $('.post-reply-form-' + post_id).slideUp(function () {
        $('.post-reply-form-' + post_id).remove();
        replyOpen = false;
    });
}

function cancel_post_edit(post_id) {
    $('.post-edit-form-' + post_id).slideUp(function () {
        $('.post-edit-form-' + post_id).remove();
        replyOpen = false;
    });
}

function post_delete(post_id) {
    $.ajax({
        async: false,
        cache: false,
        type: "GET",
        dataType: "text",
        url: "/posts/delete/" + post_id
    })
        .always(function (data) {
            if (data == 'true') {
                $('.post-content-' + post_id).html('<p><em>[deleted]</em></p>');
            }
        });
}

function drawer_open(drawer_id) {
    $('.drawer-' + drawer_id).slideDown(function () {
        $('.drawer-buttons-' + drawer_id).html('<span onClick="drawer_close(' + drawer_id + ')" class="glyphicon glyphicon-collapse-up"></span>')
    });
}

function drawer_close(drawer_id) {
    $('.drawer-' + drawer_id).slideUp(function () {
        $('.drawer-buttons-' + drawer_id).html('<span onClick="drawer_open(' + drawer_id + ')" class="glyphicon glyphicon-collapse-down"></span>')
    });
}

var post_content = null;

function get_post_content(post_id) {
    $.ajax({
        async: false,
        cache: false,
        type: "GET",
        dataType: "text",
        url: "/posts/get/" + post_id
    })
        .success(function (data) {
            if (data != 'false')
                post_content = data;
            else
                post_content = 'Oops! There was an error trying to edit your post!';

        });
}

// Content Control

function content_hide(post_id) {
    $('.content-control-' + post_id).html('<span onclick="content_show(' + post_id + ')">[ + ]</span>');
    $('.content-block-' + post_id).slideUp();
    drawer_close(post_id);
}

function content_show(post_id) {
    $('.content-control-' + post_id).html('<span onclick="content_hide(' + post_id + ')">[ - ]</span>');
    $('.content-block-' + post_id).slideDown();
    drawer_open(post_id);
}

// Voting

function vote(post_id, vote) {
    $.ajax({
        async: false,
        cache: false,
        type: "POST",
        url: "/votes/vote",
        data: {post_id: post_id, vote: vote}
    })
        .done(function (data) {
            if (vote == 'insightful' && data == 'true') {
                $('.insightful-' + post_id).addClass('disabled');
                $('.irrelevant-' + post_id).removeClass('disabled');
            }
            else if (vote == 'irrelevant' && data == 'true') {
                $('.irrelevant-' + post_id).addClass('disabled');
                $('.insightful-' + post_id).removeClass('disabled');
            }
        });
}

// Form handlers

$('.edit-submit').click(function () {
    $(".post-edit-form").ajaxSubmit({url: '/posts/update', type: 'post'});
});

//For getting the URL params.
function get_url_param(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

$('.content-block').each(function () {
    if (!$(this).hasClass('.hidden-post-content')) {
        id = $(this).attr('id');
        post = $('#post-' + id);
        parents = post.attr('parents');
        if (parents.length) {
            parents = JSON.parse(parents);
            first_child = parents.slice();
            first_child.reverse();
            first_child = first_child[1];
            one_up = parents.shift();
            reply_count = 0;
            parents.forEach(function (parent) {
                parent_object = $('#post-' + parent);
                head = parent_object.attr('head');
                if (head.length) {
                    parent_object.hide();
                    reply_count++;
                    if(first_child)
                    {
                        username = $('.user-post-'+first_child).html();
                    }
                    $('.content-block-' + head).show();
                    $('.content-block-' + one_up).show();
                    $('.expand-label-' + head).html(username+' and '+reply_count+' others replied');
                }
            });
        }
    }
});


