function updateForms(){
    var i = 0;
    $('.oz-form').each(function(){
        if($(this).find('.well .label-success').length > 0 && $(this).find('.well .label-success').length === $(this).find('.well .label').length)
        {
            $(this).removeClass('panel-primary').addClass('panel-success');
            i++;
        }
    });
    
    if($('.oz-form').length === i)
    {
        $('.btn-danger').removeClass('btn-danger').addClass('btn-success');
    }
};

$(function(){
    $('#sidebar').affix({
        offset: {
          top: 50
        }
    });
    $('select').each(function(){
        var cls = 'btn btn-primary';
        if($(this).find('[selected]').length > 0 && $(this).find('[selected]').val() !== '')
        {
            cls = 'btn btn-success';
        }
        $(this).multiselect({ 
            maxHeight : 200,
            buttonClass: cls,
            onChange : function(option, checked){
                if(option.closest('.multiselect').length > 0)
                {
                    if(option.val() === 'multiselect-all')
                    {
                        var params = {
                            choiceId : 'all',
                            questionId: option.parent().attr('name'),
                            type : 3,
                            checked : checked,
                            chosen : _.pluck(option.parent().serializeArray(), 'value').splice(1)
                        };
                    }
                    else
                    {
                        var params = {
                            choiceId : option.val(),
                            questionId: option.parent().attr('name'),
                            type : 3,
                            checked : checked
                        };
                    }

                }
                else
                {
                    var params = {
                        choiceId : option.val(),
                        questionId: option.parent().attr('name'),
                        type : 2
                    };
                    
                    if(option.parent().find('option[value=""]').length > 0)
                    {
                        option.parent().find('option[value=""]').remove();
                        this.rebuild();
                    }
                }
                var select = this
                $.post(url('ajax/save-chosen'),params,function(response){
                    if(response.status)
                    {
                        select.$button.addClass('btn-success');
                        var question = select.$container.closest('.well');
                        question.find('.label').addClass('label-success');
                        question.find('.question-text').addClass('text-success');
                        updateForms();
                    }
                },'json');
            }
        });
    });
    
    updateForms();
        
});

var $body   = $(document.body);

$body.scrollspy({
	target: '#leftCol',
	offset: 50
});

/* smooth scrolling sections */
$('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        $('html,body').animate({
          scrollTop: target.offset().top - 50
        }, 1000);
        return false;
      }
    }
});

$(document).on('click', '.save-answer', function(){
    var question = $(this).closest('.well');
    var params = $(this).closest('.input-group').find('input').serializeArray()[0];
    if(_.isUndefined(params))
    {
        params = {
            name : $(this).parent().find('textarea').attr('name'),
            value : $(this).parent().find('textarea').val()
        };
        
    }
    $.post(url('ajax/save-answer'), params, function(data){
        if(data.status)
        {
            question.find('.label').addClass('label-success');
            question.find('.question-text').addClass('text-success');
            question.find('.form-control').addClass('success');
            question.find('.save-answer').addClass('btn-success');
            updateForms();
        }
    }, 'json');
});

$(document).on('click', '.submit-application', function(){
    if($(this).hasClass('btn-success'))
    {
        var params = {
            save : true
        };
        $.post(url('ajax/submit-app'), params, function(data){
            if(data.status)
            {
                alert('Application successfully submitted. Redirecting...');
                window.location.href = url('home');
            }
        }, 'json');
    }
    else
    {
        alert('There are blank fields you haven\'t filled out yet. Please finish your application before submitting.');
    }
});