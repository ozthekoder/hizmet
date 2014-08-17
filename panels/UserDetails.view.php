<div class="item-details-view container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="panel">
                <div class="panel-body">
                    <img style="width:100%;height:auto" src="<%= window.url(avatar) %>"  class="img-thumbnail">
                    <ul style="margin-top:15px;" class="list-group">
                        <li class="list-group-item"><span><span class="label label-primary">Name</span> <%= firstName + ' ' + lastName %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Federation</span> <%= fedName %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Region</span> <%= regionName %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">E-mail</span> <%= email %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Gender</span> <%= gender === 0 ? 'Male' : 'Female' %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Date of Birth</span> <%= dob %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Registered On</span> <%= timeConverter(registeredOn) %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Address</span> <%= street %>, <%= city %>, <%= zip %>, <%= state %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Phone</span> <%= phone %></span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel">
                <div class="panel-body">
                <% if(submissions.length === 0){ %>
                <div style="font-family: Architects Daughter;" class="well-sm">This User has no submissions yet.</div>
                <% } else { %>
                <table class="table table-hover" id="detail-submissions-table">
                    <thead>
                        <tr>
                            <td>Application</td>
                            <td>Deadline</td>
                            <td>Submitted On</td>
                        </tr>
                    </thead>
                    <tbody>
                        <%
                        _.each(submissions, function(sub,index,list){
                            %>
                            <tr id="<%= sub.id %>">
                                <td><%= sub.name %></td>
                                <td><%= sub.startDate %> - <%= sub.deadline %></td>
                                <td><%= window.timeConverter(sub.submittedOn) %></td>
                            </tr>
                            <%
                        });
                        %>
                    </tbody>
                </table>
                <% } %>
                </div>
            </div>
        </div>
    </div>
</div>