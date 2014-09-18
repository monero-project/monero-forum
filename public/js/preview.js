$('.content-preview').show();
$('.preview-button').hide();


$('#content-body').change(function(){
	$('.preview-window').html(Markdown($('#content-body').val()));
});

$('#content-body').keyup(function(){
	$('.preview-window').html(Markdown($('#content-body').val()));
});

