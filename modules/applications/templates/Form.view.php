<div data-id="<%= id %>" data-order="<%= order %>" data-name="<%= name %>" id="form-<%= order %>" order="<%= order %>" class="panel panel-primary oz-form">
    <div class="panel-heading" style="position:relative;">
        <a><%= name %></a>
        <span data-toggle="tooltip" data-placement="bottom" title="Remove Form"  class="form-action icon-close trans-all remove-form"></span>
        <span order="<%= order %>" title="Add Question" data-toggle="modal" data-target="#addNewQuestionModal" class="form-action icon-plus trans-all" id="add-question"></span>
    </div>
    <div class="panel-body">
    <% if(!_.isUndefined(questions) && questions.length > 0)
        {
            var q = '';
            _.each(questions, function(question, i, list){
                q += _.template(OZ.questionView, question);
            }) 
    %>
    <%= q %>     
    <% } %>
    
    </div>
</div>