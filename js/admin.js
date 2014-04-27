OZ.application = {
    name: '',
    createdBy : OZ.user.id,
    startDate : '',
    deadline : '',
    forms : []
};
$(document).ready(function(){
    $('#sidebar').affix({
        offset: {
          top: 50
        }
    });
    $('#datepicker').datepicker();
});
var $body   = $(document.body);

$body.scrollspy({
	target: '#leftCol',
	offset: 10
});

$(document).on('click', '#save-app', function(){
    var sanity = checkAppSanity(OZ.application);
    if(sanity.status)
    {
        $.post(url('ajax/create-app'), OZ.application, function(response){
            if(response.status)
            {
                
            }

            alert(response.message);
        }, 'json');
    }
    else
    {
        alert(sanity.message);
        return false;
    }
});

$(document).on('changeDate', '#datepicker', function(e){
    OZ.application[$(e.target).attr('name')] = e.format(0,'yyyy-mm-dd');
});

$(document).on('change', '#appName', function(e){
    OZ.application.name = $(this).val();
});

$('#forms-panel').scrollspy({
	target: '#forms-sidebar',
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
                        html += '<span class="icon-remove remove" style="font-size: 23px;margin:7px;position:absolute;top:0px;left:0px;color:firebrick;display: none;"></span><span class="id-holder">'
                    html += response.federation[prop] + '</span></td>';
                    i++;
                }
            }
            html += '</tr>';
            $('#items-table tbody').append(html);
        }, 'json');
    }
});

$(document).on('click', '#add-new-form', function(){
    var name = $('#form-name').val();
    var order = OZ.application.forms.length;
    if(name === '')
    {
        alert('Please enter a name for the form.')
        return false;
    }
    var form = _.template(OZ.formView, { order : order, name : name });
    
    $('#forms-panel > div').append(form);
    var num = order + 1;
    $('#forms-list').append('<li class="nav-list-item" order="' + order + '"><a href="#form-' + order + '">' + num + ') ' + name + '</a></li>');
    OZ.application.forms.push({ 
        order : order, 
        name : name,
        questions: []
    });
    $('#form-' + order + ' .form-action').each(function(){
        $(this).tooltip({
            placement : 'bottom'
        });
    });
    $('#form-name').val('');
    $('#createNewFormModal').modal('hide');
});

$(document).on('show.bs.modal', '#addNewQuestionModal', function(e){
    OZ.currentForm = OZ.application.forms[parseInt($(e.relatedTarget).closest('.oz-form').attr('order'))];
});

$(document).on('click', '#create-new-app', function(e){
    OZ.application = {
        name: '',
        createdBy : OZ.user.id,
        startDate : '',
        deadline : '',
        forms : []
    };
    
    OZ.currentForm = null;
    
    
});

$(document).on('click', '.remove-form', function(){
    var form = $(this).closest('.oz-form');
    var order = parseInt(form.attr('order'));
    var removed = OZ.application.forms.splice(order,1)[0];
    $('.nav-list-item[order="' + order + '"]').remove();
    form.remove();
    
    var i=0;
    $('.nav-list-item').each(function(){
        OZ.application.forms[i].order = i;
        $(this).attr('order', i);
        $('a', $(this)).attr('href', '#form-' + i).text((i+1) + ') ' + OZ.application.forms[i].name);
        $($('.oz-form')[i]).attr('order', i).attr('id', 'form-' + i);
        i++;
    });
    
});

$(document).on('click', '.dropdown-menu:not(.multiselect-container) li', function(){
    var button = $(this).closest('.btn-group').find('button');
    button.attr('value', $(this).attr('value'));
    button.html('<span class="selected-type">' + $(this).find('a').text() + '</span><span class="caret" style="margin-left: 2px;"></span>');
});

$(document).on('click', '#question-type li', function(){
    $('#add-choice-input').remove();
    switch(parseInt($(this).attr('value')))
    {
        case 0:
        case 1:
            break;
        case 2:
        case 3:
            var parent = $(this).closest('.modal-body');
            parent.append('<div id="add-choice-input" class="input-group"><input type="text" id="choice-text" class="form-control"><span class="input-group-btn"><button id="add-choice" class="btn btn-default" type="button"><span class="icon-plus" style="position:relative;top:1px;margin-right:5px;"></span>Add Choice</button></span></div>');
            break;
    }
});

$(document).on('click', '#add-choice', function(){
    var value = $('#choice-text').val();
    if(value != '')
    {
        $('#add-choice-input').before('<div order="' + $('.choice').length + '" class="well well-sm choice"><span class="label label-info" style="margin-right:5px;">Choice ' + ($('.choice').length + 1) + '</span><span class="choice-text">' + value + '</span><span class="icon-remove remove-choice trans-all" style=""></span></div>');
    }
    else alert('Please enter a value first!');
    
    $('#choice-text').val('');
    $('#choice-text').focus();
});

$(document).on('click', '.remove-choice', function(){
    var choice = $(this).closest('.choice');
    choice.remove();
    var i=0;
    $('.choice').each(function(){
        $(this).attr('order', i++);
        $(this).find('.label').text('Choice ' + (i+1));
    });
    
});

$(document).on('click', '#add-new-question', function(){
    var parent = $(this).closest('.modal');
    var text = $('#question-text').val();
    var type = parseInt($('#question-type').siblings('button').val());
    switch(type)
    {
        case 0:
        case 1:
            
            break;
        case 2:
        case 3:
            if(parent.find('.well').length === 0)
            {
                alert('Please add choices for the multiple choice question.');
                return false;
            }   
            var choices = [];
            parent.find('.well').each(function(){
                choices.push($('.choice-text', $(this)).text());
            });
            break; 
    }
    
    if(text === '')
    {
        alert('Please add the question text.');
                return false;
    }
    var question = {
        order : OZ.currentForm.questions.length,
        type : type,
        question : text,
        choices : choices || []
    };
    OZ.currentForm.questions.push(question);
    
    $('#form-' + OZ.currentForm.order).find('.panel-body').append(_.template(OZ.questionView, question));
    $('#question-' + (OZ.currentForm.questions.length-1) + ' select').multiselect({ maxHeight : 200});
    $('input', parent).val('');
    $('.oz-dropdown', parent).find('button').html('<span class="selected-type">Short Answer</span><span class="caret" style="margin-left: 2px;"></span>').val(0);
    
    $('.well, #add-choice-input', parent).remove();
    parent.modal('hide');
    
});

$(document).on('click', '.remove-item', function(){
    var row = $(this).closest('tr');
    var id = row.find('.id-holder').text();
    var type = row.attr('type');
    
    $.post(url('ajax/delete-item'), { id : id, type : type}, function(response){
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

$(document).on('keyup', '#add-choice-input', function(e){
    var keycode = parseInt(event.keyCode ? event.keyCode : event.which);
    if(keycode === 13) {
        $('#add-choice').click();	
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

// disabling dates
        
//		});

function checkAppSanity(app){
    if(app.name === '' || app.startDate === '' || app.deadline === '')
    {
        return {
            status : false,
            message: 'Please fill out all fields before saving.'
        };
    }
    
    if(app.forms.length === 0)
    {
        return {
            status : false,
            message: 'You did not create any forms. Please create forms and questions needed before saving.'
        };
    }
    
    return {
        status : true
    };
}