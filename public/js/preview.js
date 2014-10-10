$('.content-preview').show();
$('.preview-button').hide();


$('#content-body').change(function(){
	$('.preview-window').html(Markdown(htmlDecode($('#content-body').val())));
});

$('#content-body').keyup(function(){
	$('.preview-window').html(Markdown(htmlDecode($('#content-body').val())));
});


function htmlDecode(str) {
    return String(str)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
}