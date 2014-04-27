<div id="question-<%= order %>" order="<%= order %>" class="well">
    <span class="label label-info" style="margin-right:5px;"><%= order+1 %></span>
    <span class="question-text"><%= question %></span>
    <%
    switch(type){
        case 0:
        %>
        <input style="margin-top:20px;" type="text" class="form-control" name="answer" placeholder="Type answer here..">
        <%
        break;
        case 1:
        %>
        <textarea style="margin-top:20px;" class="form-control" rows="3" name="answer" placeholder="Type answer here.."></textarea>
        <%
        break;
        case 2:
        %>
        <br/><br/>
        <select name="answer">
            <option value="" selected>None Selected</option>
            <% _.each(choices, function(element, index, list){ %>
            <option order="<%= order %>" value="<%= element %>"><%= element %></option>
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
            <option order="<%= order %>" value="<%= element %>"><%= element %></option>
            <% }); %>
            
        </select>
        <%
        break;
    }
    %>
</div>