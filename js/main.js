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
    var form = $(this).closest('form');
    var params = form.serializeArray();
    
    $.post(url('ajax/authenticate'), params, 
        function(data){
            console.log(data);
//            location.reload();
        },
    'json');
});

function url(extension)
{
    return OZ.base + extension;
}