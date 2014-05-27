OZ.application = {
    id: 0,
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
                OZ.application = response.app;
                layoutForms();
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
    if(e.format(0,'yyyy-mm-dd') !== '')
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
    var order = OZ.application.forms.length+1;
    if(name === '')
    {
        alert('Please enter a name for the form.')
        return false;
    }
    var form = _.template(OZ.formView, { id : 0, order : order, name : name, questions: [] });
    
    $('#forms-panel > div').append(form);
    var num = order;
    $('#forms-list').append('<li class="nav-list-item" order="' + order + '"><a href="#form-' + order + '">' + num + ') ' + name + '</a></li>');
    OZ.application.forms.push({ 
        id : 0,
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
    OZ.currentForm = OZ.application.forms[parseInt($(e.relatedTarget).closest('.oz-form').attr('order')) - 1];
});

$(document).on('click', '#create-new-app', function(e){
    OZ.application = {
        id : 0,
        name: '',
        createdBy : OZ.user.id,
        startDate : '',
        deadline : '',
        forms : []
    };
    
    OZ.currentForm = null;
    $.ajax({
        url: url('create/new'),
        type: "POST",
        dataType: "html",
        timeout: 10000,
        statusCode: {
            404: function() {
                serverb();
            }
        },
        success: function(response) {
            $('#createNewAppModal .modal-body').html(response);
            $('#createNewAppModal .modal-body select').multiselect({ 
                maxHeight : 200,
                buttonClass: 'btn btn-primary'
            });
            $('#createNewAppModal .modal-body .form-action, .create-new-form, .question-action').each(function(){
                $(this).tooltip({
                    placement : 'bottom'
                });
            });
            $('#sidebar').affix({
                offset: {
                  top: 50
                }
            });
            $('#forms-panel').scrollspy({
                    target: '#forms-sidebar',
                    offset: 10
            });
            $('#datepicker').datepicker();
            var data = $('#createNewAppModal .creation-modal-content').data();
            OZ.application = {
                id: data.id,
                name: data.name,
                createdBy : OZ.user.id,
                startDate : data.startdate,
                deadline : data.deadline
            };
            
            OZ.application.forms = [];
            var f=0,q=0,c=0;
            $('.oz-form').each(function(){
                OZ.application.forms.push($(this).data());
                OZ.application.forms[f].questions = [];
                q=0;
                $('.oz-question', $(this)).each(function(){
                    OZ.application.forms[f].questions.push($(this).data());
                    OZ.application.forms[f].questions[q].choices = [];
                    c=0;
                    $('.oz-choice', $(this)).each(function(){
                        OZ.application.forms[f].questions[q].choices.push($(this).data());
                        c++;
                    });
                    q++;
                });
                f++;
            });
            
        },
        error: function(x, t, m) {
            if (t === "timeout") {
            } else {
            }
        }
    });
    
});

$(document).on('click', '.remove-form', function(){
    var form = $(this).closest('.oz-form');
    var order = parseInt(form.attr('order'));
    var removed = OZ.application.forms.splice(order-1,1)[0];
    $('.nav-list-item[order="' + order + '"]').remove();
    form.remove();
    
    layoutForms();
    
    if(removed.id > 0)
    {
        delete removed.questions;
        $.post(url('ajax/delete-form'), removed, function(response){
            $.post(url('ajax/create-app'), OZ.application, function(response){
                if(response.status)
                {
                    OZ.application = response.app;
                    layoutForms();
                }
                alert(response.message);
            },'json');
        },'json');
    }
});

$(document).on('click', '.remove-question', function(){
    var form = $(this).closest('.oz-form').data();
    var question = $(this).closest('.oz-question');
    var q = question.data();
    var ind = {};
    
    var removed = OZ.application.forms[form.order-1].questions.splice(q.order-1,1)[0];
    _.each(OZ.application.forms[form.order-1].questions, function(item, index,list){
        item.order = index+1;
    });
    question.remove();
    layoutForms();
    if(removed.id > 0)
    {
        delete removed.choices;
        $.post(url('ajax/delete-question'), removed, function(response){
            console.log(OZ.application)
            $.post(url('ajax/create-app'), OZ.application, function(response){
                if(response.status)
                {
                    OZ.application = response.app;
                    layoutForms();
                }
                alert(response.message);
            },'json');
        },'json');
    }
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
        $('#add-choice-input').before('<div order="' + $('.choice').length + '" class="well well-sm choice"><span class="label label-primary" style="margin-right:5px;">Choice ' + ($('.choice').length + 1) + '</span><span class="choice-text">' + value + '</span><span class="icon-remove remove-choice trans-all" style=""></span></div>');
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
                choices.push({
                    id : 0,
                    choice : $('.choice-text', $(this)).text()
                });
            });
            break; 
    }
    
    if(text === '')
    {
        alert('Please add the question text.');
                return false;
    }
    var question = {
        id : 0,
        order : OZ.currentForm.questions.length+1,
        type : type,
        question : text,
        choices : choices || []
    };
    OZ.currentForm.questions.push(question);
    
    layoutForms();
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

$(document).on('click', '.edit-item', function(){
    var row = $(this).closest('tr');
    var id = row.find('.id-holder').text();
    var type = row.attr('type');
    
    $.ajax({
        url: url('create/' + id),
        type: "POST",
        dataType: "html",
        timeout: 10000,
        statusCode: {
            404: function() {
                serverb();
            }
        },
        success: function(response) {
            $('#createNewAppModal .modal-body').html(response);
            $('#createNewAppModal').modal('show');
            $('#createNewAppModal .modal-body select').multiselect({ 
                maxHeight : 200,
                buttonClass: 'btn btn-primary'
            });
            $('#createNewAppModal .modal-body .form-action, .create-new-form, .question-action').each(function(){
                $(this).tooltip({
                    placement : 'bottom'
                });
            });
            $('#sidebar').affix({
                offset: {
                  top: 50
                }
            });
            $('#forms-panel').scrollspy({
                    target: '#forms-sidebar',
                    offset: 10
            });
            $('#datepicker').datepicker();
            
            var data = $('#createNewAppModal .creation-modal-content').data();
            
            OZ.application = {
                id: data.id,
                name: data.name,
                createdBy : OZ.user.id,
                startDate : data.startdate,
                deadline : data.deadline
            };
            
            OZ.application.forms = [];
            var f=0,q=0,c=0;
            $('.oz-form').each(function(){
                OZ.application.forms.push($(this).data());
                OZ.application.forms[f].questions = [];
                q=0;
                $('.oz-question', $(this)).each(function(){
                    OZ.application.forms[f].questions.push($(this).data());
                    OZ.application.forms[f].questions[q].choices = [];
                    c=0;
                    $('.oz-choice', $(this)).each(function(){
                        OZ.application.forms[f].questions[q].choices.push($(this).data());
                        c++;
                    });
                    q++;
                });
                f++;
            });
            
        },
        error: function(x, t, m) {
            if (t === "timeout") {
            } else {
            }
        }
    });
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

$(document).on('click', '#toggleStatus', function(){
    if(OZ.application.id > 0)
    {
        var button = $(this);
        var status = parseInt($(this).attr('status'));
        if(status === 0)
            status = 1;
        else
            status = 0;
        $.post(url('ajax/toggle-app-status'), { id: OZ.application.id, status :  status}, function(response){
            if(response.status)
            {
                button.attr('status', status);
                if(status === 0)
                    button.text('Activate');
                else
                    button.text('Deactivate');
            }
            else
            {

            }
            alert(response.message);
        }, 'json');
    }
    else
    {
        alert('You need to save this application first');
    }
        
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
    
    _.each(OZ.application.forms, function(form,i,forms){
        if(form.questions.length === 0)
        {
            return {
                status : false,
                message: 'You cannot save a form without questions.'
            };
        }
    });
    
    return {
        status : true
    };
}

function layoutForms()
{
    var forms = '';
    $('#forms-list').empty();
    _.each(OZ.application.forms, function(form, i, formsList){ 
        $('#forms-list').append('<li class="nav-list-item" order="' + form.order + '"><a href="#form-' + form.order + '">' + (parseInt(form.order)) + ') ' + form.name + '</a></li>');
        forms += _.template(OZ.formView, form);
        
    });
    $('#forms-panel > div').html(forms);
    $('#createNewAppModal .modal-body select').multiselect({ 
                maxHeight : 200,
                buttonClass: 'btn btn-primary'
            });
            $('#createNewAppModal .modal-body .form-action, .create-new-form, .question-action').each(function(){
                $(this).tooltip({
                    placement : 'bottom'
                });
            });
            $('#sidebar').affix({
                offset: {
                  top: 50
                }
            });
            $('#forms-panel').scrollspy({
                    target: '#forms-sidebar',
                    offset: 10
            });
            $('#datepicker').datepicker();
    
}