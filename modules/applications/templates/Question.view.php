<div data-id="<%= id %>" data-type="<%= type %>" data-order="<%= order %>" data-question="<%= question %>" id="question-<%= order %>" order="<%= order %>" class="well oz-question">
    <span data-toggle="tooltip" data-placement="bottom" title="Remove Question" class="icon-close question-action remove-question trans-all" style="font-size:16px;position:absolute;top:10px;right: 10px;"></span>
    <span data-toggle="tooltip" data-placement="bottom" title="Edit Question" class="icon-edit question-action edit-question trans-all" style="font-size:16px;position:absolute;top:10px;right: 31px;"></span>
    <span class="label label-primary" style="margin-right:5px;"><%= parseInt(order) %></span>
    <span class="question-text text-primary"><%= question %></span>
    <%
    switch(parseInt(type)){
        case 0:
        %>
        <div class="input-group" style="margin-top:20px;">
            <input  type="text" class="form-control" value="" name="" placeholder="Type answer here..">
            <span class="input-group-btn">
                <button class="btn  btn-primary save-answer" type="button">Save</button>
            </span>
        </div>
        <%
        break;
        case 1:
        %>
        <textarea style="margin-top:20px;margin-bottom: 30px;" class="form-control" rows="3" name="" placeholder="Type answer here.."></textarea>
        <a class="btn btn-xs save-answer btn-primary" style="float:right;position:relative;bottom:15px;">Save</a>
        <%
        break;
        case 2:
        %>
        <br/><br/>
        <select name="answer">
            <option value="" selected>None Selected</option>
            <% _.each(choices, function(element, index, list){ %>
            <option data-id="<%= element.id %>" data-choice="<%= element.choice %>" choiceid="<% element.id %>" value="<%= element.id %>"><%= element.choice %></option>
            <% }); %>
            
        </select>
        <%
        break;
        case 3:
        %>
        <br/><br/>
        <select class="multiselect" multiple="multiple" name="answer">
            <option value="multiselect-all"> Select all</option>
            <% _.each(choices, function(element, index, list){ %>
            <option data-id="<%= element.id %>" data-choice="<%= element.choice %>" choiceid="<% element.id %>" value="<%= element.id %>"><%= element.choice %></option>
            <% }); %>
        </select>
        <%
        break;
        case 4:
        %>
        <br/><br/>
        <input type="file" name="answer">
        <%
        break;
        case 5:
        %>
        <br/><br/>
        <input type="file" multiple="multiple" name="answer">
        <%
        break;
    }
    %>
</div>