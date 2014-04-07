$(document).on('ready', function(){
    $('#login-opener').popover({
        animation: true,
        html : true,
        placement : 'bottom',
        content : OZ.loginBox,
        container : 'body'
    });
});
$(document).on('click', '#login-opener', function(){
    if($(this).parent().hasClass('active'))
        $(this).parent().removeClass('active');
    else
        $(this).parent().addClass('active');
});

$(document).on('click', '#login-button', function(e){
    e.preventDefault();
    var form = $(this).closest('div').find('input');
    var params = form.serializeArray();
    var request = url('ajax/authenticate');
    $.post(request, params, 
        function(data){
            if(data.status)
                location.reload();
            else
                alert(data.message);
        },
    'json');
});

function url(extension)
{
    return 'http://' + OZ.host + OZ.base + extension;
}