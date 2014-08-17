<div id="question-<%= questionOrder %>" order="<%= questionOrder %>" questionid="<%= questionId %>" class="well">
    <%
    switch(questionType){
        case 0:
        %>
        <span class="label label-primary" style="margin-right:5px;"><%= questionOrder %></span>
        <span class="question-text"><%= question %></span>
        <br/>
        <br/>
        <p style=""><span class="label label-primary" style="margin-right:5px;">Answer:</span><%= answer %></p>
        <%
        break;
        case 1:
        %>
        <span class="label label-primary" style="margin-right:5px;"><%= questionOrder %></span>
        <span class="question-text"><%= question %></span>
        <br/>
        <br/>
        <p style=""><span class="label label-primary" style="margin-right:5px;">Answer:</span><%= answer %></p>
        <%
        break;
        case 2:
        %>
        <span class="label label-primary" style="margin-right:5px;"><%= questionOrder %></span>
        <span class="question-text"><%= question %></span>
        <br/>
        <br/>
        <p style=""><span class="label label-primary">Selected:</span><br/><%= choice %></p>
        <%
        break;
        case 3:
        %>
       <span class="label label-primary" style="margin-right:5px;"><%= questionOrder %></span>
        <span class="question-text"><%= question %></span>
        <br/>
        <br/>
        <p style=""><span class="label label-primary">Selected:</span><br/><%= chosen %></p>
        <%
        break;
        case 4:
        %>
            <span class="label label-primary" style="margin-right:5px;"><%= questionOrder %></span>
            <span class="question-text"><%= question %></span>
            <br/><br/>
            <%= files %>
            <%
            break;
        case 5:
        %>
        <span class="label label-primary" style="margin-right:5px;"><%= questionOrder %></span>
        <span class="question-text"><%= question %></span>
        <br/><br/>
        <%= files %>
        <%
        break;
    }
    %>
</div>