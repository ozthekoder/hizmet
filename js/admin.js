
$(document).ready(function(){
    
    OZ.appTpl = _.template(OZ.appView);
    
    OZ.application = {
        id: 0,
        name: '',
        createdBy : OZ.user.id,
        startDate : '',
        deadline : '',
        forms : [],
        formTpl : _.template(OZ.formView)
    };
    
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

$(document).on('click', '[modalid="createNewAppModal"] .modalDone', function(e){
    e.preventDefault();
    var sanity = checkAppSanity(OZ.application);
    if(sanity.status)
    {
        
        var params = _.omit(OZ.application, ['formTpl']);
        
        _.each(params.forms, function(form, i, list){
            params.forms[i] = _.omit(form, ['questionTpl']);
            
            _.each(form.questions, function(question, j, clist){ 
                params.forms[i].questions[j] = _.omit(question, ['choiceTpl']);
            });
        });
        $.post(url('ajax/create-app'), params, function(response){
            if(response.status)
            {
                var newApp = OZ.application.id === 0;
                _.extend(OZ.application, response.app);
                var app = _.omit(OZ.application, ['formTpl', 'forms']);
                if(newApp)
                {
                    $('#items-table tbody').append(_.template(OZ.rowView, app));
                }
                else
                {
                    $('#items-table tbody tr[itemid="' + OZ.application.id + '"]').replaceWith(_.template(OZ.rowView, app));
                }
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

$(document).on('hidden.bs.modal', '.generalModal', function(){
    $(this).remove();
});

$(document).on('click', '.modalDone', function(){
    $(this).closest('.modal').modal('hide');
});

$(document).on('click', '.modalCancel', function(){
    $(this).closest('.modal').modal('hide');
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
            html += '<tr type="Federation">';
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

$(document).on('click', '[modalid="createNewFormModal"] .modalDone', function(e){
    var name = $('#form-name').val();
    var order = OZ.application.forms.length+1;
    if(name === '')
    {
        alert('Please enter a name for the form.')
        return false;
    }
    
    OZ.application.forms.push({ 
        id : 0,
        order : order, 
        name : name,
        questions: [],
        questionTpl : _.template(OZ.questionView)
    });
    layoutForms();
});


$(document).on('click', '#create-new-app', function(e){
    
    if(OZ.application.forms.length > 0 || OZ.application.name !== '' || OZ.application.deadline !== '' || OZ.application.startDate !== '')
    {
        var r = confirm('Would you like to continue from where you left off?');
        if(!r){
            OZ.application = {
                id : 0,
                name: '',
                createdBy : OZ.user.id,
                startDate : '',
                deadline : '',
                forms : [],
                formTpl : _.template(OZ.formView)
            };
        }

        OZ.currentForm = null;




        var template = _.template(OZ.modal, { 
                        modalId : 'createNewAppModal',
                        modalTitle : 'Create Application',
                        closeButton : true,
                        closeButtonText : 'Close',
                        doneButton : true,
                        doneButtonText : 'Save',
                        size: 'large',
                        modalContent : ''
                    });

        $(template).modal();

        layoutForms();
    }
    else
    {
        OZ.application = {
            id : 0,
            name: '',
            createdBy : OZ.user.id,
            startDate : '',
            deadline : '',
            forms : [],
            formTpl : _.template(OZ.formView)
        };
        OZ.currentForm = null;
        var template = _.template(OZ.modal, { 
                            modalId : 'createNewAppModal',
                            modalTitle : 'Create Application',
                            closeButton : true,
                            closeButtonText : 'Close',
                            doneButton : true,
                            doneButtonText : 'Save',
                            size: 'large',
                            modalContent : ''
                        });

        $(template).modal();
        
        layoutForms();
    }
});

$(document).on('shown.bs.modal', '[modalid="createNewAppModal"]', function(e){
    layoutForms();
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
                    OZ.application.formTpl = _.template(OZ.formView);
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
                    OZ.application.formTpl = _.template(OZ.formView);
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
        case 4:
        case 5:
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

$(document).on('click', '[modalid="createNewQuestionModal"] .modalDone', function(){
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
        choices : choices || [],
        choiceTpl : _.template(OZ.choiceView)
    };
    OZ.currentForm.questions.push(question);
    
    layoutForms();
    
});

$(document).on('click', '.remove-item', function(e){
    e.stopPropagation();
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

$(document).on('change', '[modalid="permissions"] input[type="checkbox"]', function(){
    var value = $(this).prop('checked');
    var fedId = $(this).attr('fedId');
    var userId = $(this).attr('userId');
    $.post(url('ajax/set-permission'), { fedId : fedId, userId : userId, value : value }, function(response){
        alert(response.message);
    }, 'json');
});

$(document).on('click', '#add-new-region', function(){
    
    var template = _.template(OZ.modal, { 
                    modalId : 'addNewRegionModal',
                    modalTitle : 'Add New Region',
                    closeButton : true,
                    closeButtonText : 'Close',
                    doneButton : true,
                    doneButtonText : 'Add',
                    size: 'medium',
                    modalContent : OZ.createRegion
                });

        $(template).modal();
        
});

$(document).on('click', '[modalid="addNewRegionModal"] .modalDone', function(){
    var modal = $(this).closest('.modal');
    var params = $('input', modal).serializeArray();
    
    $.post(url('ajax/add-new-region'), params, function(response){
        alert(response.message);
        var html = '';
        html += '<tr type="Region">';
        var i = 0;
        for(var prop in response.region)
        {
            if(response.region.hasOwnProperty(prop))
            {
                html += '<td style="position:relative;">' 
                if(i === 0)
                    html += '<span class="icon-remove remove-item" style="font-size: 23px;margin:7px;position:absolute;top:0px;left:0px;color:firebrick;display: none;"></span><span class="id-holder">'
                html += response.region[prop] + '</span></td>';
                i++;
            }
        }
        html += '</tr>';
        $('#items-table tbody').append(html);
    }, 'json');
});

$(document).on('click', '.create-new-form', function(){
    var template = _.template(OZ.modal, { 
                    modalId : 'createNewFormModal',
                    modalTitle : 'Add New Form',
                    closeButton : true,
                    closeButtonText : 'Close',
                    doneButton : true,
                    doneButtonText : 'Add',
                    size: 'medium',
                    modalContent : OZ.createFormView
                });
    $(template).modal();
});

$(document).on('click', '.add-question', function(){
    
    OZ.currentForm = OZ.application.forms[parseInt($(this).attr('order')) - 1];
    
    var template = _.template(OZ.modal, { 
                    modalId : 'createNewQuestionModal',
                    modalTitle : 'Add New Question',
                    closeButton : true,
                    closeButtonText : 'Close',
                    doneButton : true,
                    doneButtonText : 'Add',
                    size: 'medium',
                    modalContent : OZ.createQuestionView
                });
    $(template).modal();
});

$(document).on('click', '#edit-state-region-mappings', function(){
    
    $.post(url('ajax/get-region-state-mappings'),{},function(response){
        var rows = '';
        var regions = '';
        _.each(response.regions, function(item, index, list){
            regions += _.template('<li regionId="<%= id %>"><a href="#"><%= name %></a></li>', item);
        });
        
        _.each(response.mappings, function(item, index, list){
            item.regions = regions;
            rows += _.template(OZ.regionStateRow, item);
        });
        
        var content = _.template(OZ.regionStateTable, { rows : rows });
        
        var template = _.template(OZ.modal, { 
                    modalId : 'permissions',
                    modalTitle : 'Region - State Mappings',
                    doneButton : false,
                    closeButton : true,
                    closeButtonText : 'Close',
                    modalContent : content,
                    size : 'medium'
                });

        $(template).modal();
        
    }, 'json');
        
});

$(document).on('click', '.permissions-item', function(){
    var row = $(this).closest('tr');
    var id = row.find('.id-holder').text();
    var type = row.attr('type');
    
    $.post(url('ajax/get-permissions'), { userId : id }, function(response){
        if(response.status)
        {
            var tpl = '<tr fedId="<%= id %>"><td><%= name %></td><td><input fedId="<%= id %>" userId="' + id + '" type="checkbox" value="<%= !_.isNull(uid) %>" <%= !_.isNull(uid) ? "checked" : ""  %> /></td></tr>';
            var rows = '';
            _.each(response.permissions, function(item, index, list){
                rows += _.template(tpl, item);
            });
            
            var table = _.template(OZ.modalTable, { tableContent : rows });
            
            var template = _.template(OZ.modal, { 
                modalId : 'permissions',
                modalTitle : 'Edit Permissions',
                doneButton : true,
                closeButton : false,
                doneButtonText : 'Done',
                modalContent : table,
                size : 'medium'
            });
            
            $(template).modal();
        }
        else
        {
            alert('Opps server problem dude.')
        }
        console.log(response);
    }, 'json');
});

$(document).on('click', '.edit-item', function(e){
    e.stopPropagation();
    var row = $(this).closest('tr');
    var id = row.find('.id-holder').text();
    var type = row.attr('type');
    
    $.post(url('create'),{ id : id }, function(response) {
            OZ.application = response;
            OZ.application.formTpl = _.template(OZ.formView);
            _.each(OZ.application.forms, function(form, i, fl){
                OZ.application.forms[i].questionTpl = _.template(OZ.questionView);
                _.each(form.questions, function(question, j, ql){
                    OZ.application.forms[i].questions[j].choiceTpl = _.template(OZ.choiceView);
                });
            });
            var template = _.template(OZ.modal, { 
                    modalId : 'createNewAppModal',
                    modalTitle : 'Create Application',
                    closeButton : true,
                    closeButtonText : 'Close',
                    doneButton : true,
                    doneButtonText : 'Save',
                    size: 'large',
                    modalContent : ''
                });

            $(template).modal();
            layoutForms();
        },'json');
});

$(document).on('click', '#region-mapping-selection li', function(){
    var row = $(this).closest('tr');
    var stateId = row.attr('stateid');
    var regionId = $(this).attr('regionid');
    var that = this;
    $.post(url('ajax/map-state'), { stateId : stateId, regionId : regionId }, function(response){
        if(response.status)
        {
            row.find('.selected-region').text($(that).find('a').text());
            row.find('.map-success').fadeIn(500, function(){
                $(this).fadeOut(500);
            });
        }
        
        
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
    $('[modalid="createNewAppModal"] .modal-body').html(OZ.appTpl(OZ.application));
    $('[modalid="createNewAppModal"] .modal-body select').multiselect({ 
        maxHeight : 200,
        buttonClass: 'btn btn-primary'
    });
    $('[modalid="createNewAppModal"] .modal-body .form-action, .create-new-form, .question-action').each(function(){
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
    $('input[type="file"]').fileinput();
}

$(document).on('click', '#items-table > tbody > tr:not([type="Detail"])', function(){
    var id = parseInt($(this).attr('itemid'));
    if(id !== OZ.editingRow)
    {
        closeItemDetails(OZ.editingRow);
        var id = parseInt($(this).attr('itemid'));
        var type = $(this).attr('type');
        loadItemDetails(type, id, this);
    }
    else
    {
        closeItemDetails(id);
    }
});

$(document).on('click', '#detail-submissions-table tr', function(){
    var id = parseInt($(this).attr('id'));
    var userId = parseInt($(this).attr('userId'));
    $.post(url('ajax/load-submission'), { id : id, userId : userId }, function(response){
        console.log(response);
        var questions = _.groupBy(response.sub, function(item){ return item.questionId });
        OZ.foo = response.sub;
        var q = {};
        if(response.status)
        {
            _.each(questions, function(item, index, list){
                var questionType = item[0].questionType;
                var concat = '';
                _.each(item, function(answer, i, l){
                    if(questionType > 1 && questionType < 4)
                    {
                        concat += answer.choice + '<br/>'
                    }
                });
                
                if(questionType > 1 && questionType < 4)
                {
                    item[0].chosen = concat;
                }
                else if(questionType === 5)
                {
                    _.each(item[0].uploads, function(upload, i, l){
                        concat += '<img style="cursor:pointer;margin:5px;max-width:100px;height:auto;" class="img-thumbnail uploaded-img" src="' + url('uploads/' + upload.hash + '.' + upload.extension) + '" />'
                    });
                    item[0].files = concat;
                }
                else if(questionType === 4)
                {
                    _.each(item[0].uploads, function(upload, i, l){
                        concat += '<a style="" class="" href="' + url('uploads/' + upload.hash + '.' + upload.extension) + '">Uploaded File</a>'
                    });
                    item[0].files = concat;
                }
                
                var questionView = _.template(OZ.questionSubView, item[0]);
                q[item[0].formId] = q[item[0].formId] || '';
                q[item[0].formId] += questionView; 
            });
            console.log(q);
            var forms = _.groupBy(response.sub, function(el){ return el.formId });
            var tpl = '';
            _.each(forms, function(item, index, list){
                item[0].questions = q[item[0].formId];
                tpl += _.template(OZ.formSubView, item[0]);
                
            });
            
            var template = _.template(OZ.modal, { 
                    modalId : 'submissionDetails',
                    modalTitle : 'Submission Details',
                    closeButton : true,
                    closeButtonText : 'Close',
                    doneButton : false,
                    modalContent : tpl,
                    size: 'large'
                });

        $(template).modal();
        }
        else
        {
            
        }
    }, 'json');
});

$(document).on('click', '.uploaded-img', function(){
    var tpl = '<img class="img-thumbnail" style="width:100%;height:auto;" src="' + $(this).attr('src') + '" />';
    var template = _.template(OZ.modal, { 
                    modalId : 'imgPreview',
                    modalTitle : 'Uploaded Image File',
                    closeButton : true,
                    closeButtonText : 'Close',
                    doneButton : false,
                    modalContent : tpl,
                    size: 'medium'
                });
    $(template).modal();
});

function loadItemDetails(type, id, row)
{
    OZ.editingRow = id;
    var count = $('td', $(row)).length;
    $(row).after('<tr type="Detail" itemid="' + id + '" style="background:#fff;"><td colspan="' + count + '"><div class="well" style="height:0px;"><br/><br/><br/><br/><br/><br/></div></td><tr>');
            TweenMax.to($('tr[type="Detail"][itemid="' + id + '"] .well'), 0.2, { height: 'auto', ease : Quart.EaseOut, onComplete: function(){  } });
    
    $.post(url('ajax/load-item-details'), { type : type, id : id }, function(response){
        if(response.status)
        {
            OZ.response = response;
            $('tr[type="Detail"][itemid="' + id + '"] .well').html(_.template(OZ.detailsView, response.item));
            $('.user-permission-select').multiselect({ 
                maxHeight : 200,
                buttonClass: 'btn btn-primary',
                onChange : function(option, checked){
                    if(option.val() === 'multiselect-all')
                    {
                        var params = {
                            all : true,
                            selected : _.pluck(option.parent().serializeArray(), 'value').splice(1),
                            type : option.attr('type'),
                            checked : checked,
                            userId : option.attr('userId')
                        };
                    }
                    else
                    {
                        var params = {
                            all : false,
                            selected : option.val(),
                            type : option.attr('type'),
                            checked : checked,
                            userId : option.attr('userId')
                        };
                    }
                    
                    $.post(url('ajax/save-user-permission'), params, function(response){
                        if(response.status)
                        {
                            
                        }
                        else
                        {
                            
                        }
                    }, 'json');
                }
            });
            
            $('.app-permission-select').multiselect({ 
                maxHeight : 200,
                buttonClass: 'btn btn-primary',
                onChange : function(option, checked){
                    if(option.val() === 'multiselect-all')
                    {
                        var params = {
                            all : true,
                            selected : _.pluck(option.parent().serializeArray(), 'value').splice(1),
                            type : option.attr('type'),
                            checked : checked,
                            appId : option.attr('appId')
                        };
                    }
                    else
                    {
                        var params = {
                            all : false,
                            selected : option.val(),
                            type : option.attr('type'),
                            checked : checked,
                            appId : option.attr('appId')
                        };
                    }
                    
                    $.post(url('ajax/save-app-permission'), params, function(response){
                        if(response.status)
                        {
                            
                        }
                        else
                        {
                            
                        }
                    }, 'json');
                }
            });
        }
        else
        {
            
        }
    }, 'json');
}

function closeItemDetails(id)
{   OZ.editingRow = null;
    $('tr[type="Detail"][itemid="' + id + '"]').remove();
}