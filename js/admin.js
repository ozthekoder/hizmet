$(document).ready(function(){
    $('#sidebar').affix({
        offset: {
          top: 50
        }
    });
});
var $body   = $(document.body);

$body.scrollspy({
	target: '#leftCol',
	offset: 10
});

$(document).on('click', '#add-new-federation', function(){
    if($('input[name="name"]', $('#addNewFederationModal')).val() !== '')
    {
        var params = $('#addNewFederationModal input').serializeArray();
        $.post(url('ajax/add-new-federation'), params, function(response){
            alert(response.message);
            var html = '';
            html += '<tr>';
            var i = 0;
            for(var prop in response.federation)
            {
                if(response.federation.hasOwnProperty(prop))
                {
                    html += '<td style="position:relative;">' 
                    if(i === 0)
                        html += '<span class="icon-remove remove-fed" style="font-size: 23px;margin:7px;position:absolute;top:0px;left:0px;color:firebrick;display: none;"></span><span class="id-holder">'
                    html += response.federation[prop] + '</span></td>';
                    i++;
                }
            }
            html += '</tr>';
            $('#federations-table tbody').append(html);
        }, 'json');
    }
});

$(document).on('click', '.remove-fed', function(){
    var row = $(this).closest('tr');
    var id = row.attr('fedid');
    
    $.post(url('ajax/delete-federation'), { id : id}, function(response){
        if(response.status)
        {
            row.fadeOut('fast', function(){
                this.remove();
            });
        }
        
        alert(response.message);
    }, 'json');
});

$(document).on('click', '#mapping-selection li', function(){
    var row = $(this).closest('tr');
    var nationid = row.attr('nationid');
    var fedid = $(this).attr('fedid');
    var that = this;
    $.post(url('ajax/map-nation'), { nationid : nationid, fedid : fedid }, function(response){
        if(response.status)
        {
            row.find('.selected-fed').text($(that).find('a').text());
            row.find('.map-success').fadeIn(500, function(){
                $(this).fadeOut(500);
            });
        }
        
        
    }, 'json');
});

/* smooth scrolling sections */
//$('a[href*=#]:not([href=#])').click(function() {
//    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
//      var target = $(this.hash);
//      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
//      if (target.length) {
//        $('html,body').animate({
//          scrollTop: target.offset().top - 50
//        }, 1000);
//        return false;
//      }
//    }
//});