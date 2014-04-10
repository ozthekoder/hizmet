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
        }, 'json');
    }
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