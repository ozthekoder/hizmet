$(document).on('ready', function(){
    
    if(!Modernizr.input.multiple)
    {
        window.location.href = url('browser-failure');
    }
    
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

function timeConverter(UNIX_timestamp){
 var a = new Date(UNIX_timestamp*1000);
 var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
     var year = a.getFullYear();
     var month = months[a.getMonth()];
     var date = a.getDate();
     var hour = a.getHours();
     var min = a.getMinutes();
     var sec = a.getSeconds();
     date = date < 10 ? '0' + date: date;
     hour = hour < 10 ? '0' + hour: hour;
     min = min < 10 ? '0' + min: min;
     sec = sec < 10 ? '0' + sec: sec;
     
     var time = date + ',' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec ;
     return time;
 }