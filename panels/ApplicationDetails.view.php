<div class="item-details-view container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="panel">
                <div class="panel-heading">Application Details</div>
                <div class="panel-body">
                    <ul style="margin-top:15px;" class="list-group">
                        <li class="list-group-item"><span><span class="label label-primary">Name</span> <%= appName %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Last Edited On</span> <%= timeConverter(lastEditedOn) %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Start Date</span> <%= startDate %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">End Date</span> <%= deadline %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Created By</span> <%= name %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">Status</span> <%= status ? 'Active' : 'Inactive' %></span></li>
                    </ul>
                    <div class="btn-group" style="display: flex;margin: 5px auto;min-height: 34px;">
                        <button style="width:186px;" disabled="disabled" type="button" class="btn btn-default">Regional Permissions</button>
                        <select class="app-permission-select multiselect" multiple="multiple" name="regionPermissions">
                            <option appId="<%= id %>" type="regionId" value="multiselect-all"> Select all</option>
                            <%
                            _.each(myPermissions.Region, function(permission, index, list){
                                var selected = '';
                                if(_.where(permissions.Region, { regionId : permission.regionId }).length > 0)
                                {
                                    selected = 'selected';
                                }
                                
                                %>
                                <option appId="<%= id %>" type="regionId" <%= selected %> value="<%= permission.regionId %>"><%= permission.name %></option>
                                <%
                            })
                            %>
                        </select>
                    </div>
                    <div class="btn-group" style="display: flex;margin: 5px auto;min-height: 34px;">
                        <button disabled="disabled" type="button" class="btn btn-default">Federational Permissions</button>
                        <select class="app-permission-select multiselect" multiple="multiple" name="fedPermissions">
                            <option appId="<%= id %>" type="fedId" value="multiselect-all"> Select all</option>
                            <%
                            _.each(myPermissions.Federation, function(permission, index, list){
                                var selected = '';
                                if(_.where(permissions.Federation, { fedId : permission.fedId }).length > 0)
                                {
                                    selected = 'selected';
                                }
                                
                                %>
                                <option appId="<%= id %>" type="fedId" <%= selected %> value="<%= permission.fedId %>"><%= permission.name %></option>
                                <%
                            })
                            %>
                        </select>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel">
                 <div class="panel-heading">Submissions Made for This Application</div>
                <div class="panel-body">
                <% if(submissions.length === 0){ %>
                <div style="font-family: Architects Daughter;" class="well-sm">No submissions have been made yet.</div>
                <% } else { %>
                <table class="table table-hover" id="detail-submissions-table">
                    <thead>
                        <tr>
                            <td>Submitted By</td>
                            <td>LastEdited On</td>
                            <td>Status</td>
                        </tr>
                    </thead>
                    <tbody>
                        <%
                        _.each(submissions, function(sub,index,list){
                            %>
                            <tr id="<%= sub.id %>" userId="<%= sub.userId %>">
                                <td><%= sub.firstName + ' ' + sub.lastName %></td>
                                <td><%= window.timeConverter(sub.lastEditedOn) %></td>
                                <td class="<%= sub.status ? 'success' : 'danger' %>"><%= sub.status ? 'Complete' : 'Incomplete' %></td>
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