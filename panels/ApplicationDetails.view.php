<div class="item-details-view container-fluid">
    <div class="row">
        <div class="col-md-5">
            <div class="panel">
                <div class="panel-heading">Application Details</div>
                <div class="panel-body">
                    <ul style="margin-top:15px;" class="list-group">
                        <li class="list-group-item"><span><span class="label label-primary">Name</span> <%= firstName + ' ' + lastName %></span></li>
                        <li class="list-group-item"><span><span class="label label-primary">E-mail</span> <%= email %></span></li>
                    </ul>
                    <div class="btn-group" style="display: block;margin: 5px auto;min-height: 34px;">
                        <button style="width:186px;" disabled="disabled" type="button" class="btn btn-default">Regional Permissions</button>
                        <select class="user-permission-select multiselect" multiple="multiple" name="regionPermissions">
                            <option userId="<%= id %>" type="regionId" value="multiselect-all"> Select all</option>
                            <%
                            _.each(myPermissions.Region, function(permission, index, list){
                                var selected = '';
                                if(_.where(permissions.Region, { regionId : permission.regionId }).length > 0)
                                {
                                    selected = 'selected';
                                }
                                
                                %>
                                <option userId="<%= id %>" type="regionId" <%= selected %> value="<%= permission.regionId %>"><%= permission.name %></option>
                                <%
                            })
                            %>
                        </select>
                    </div>
                    <div class="btn-group" style="display: block;margin: 5px auto;min-height: 34px;">
                        <button disabled="disabled" type="button" class="btn btn-default">Federational Permissions</button>
                        <select class="user-permission-select multiselect" multiple="multiple" name="fedPermissions">
                            <option userId="<%= id %>" type="fedId" value="multiselect-all"> Select all</option>
                            <%
                            _.each(myPermissions.Federation, function(permission, index, list){
                                var selected = '';
                                if(_.where(permissions.Federation, { fedId : permission.fedId }).length > 0)
                                {
                                    selected = 'selected';
                                }
                                
                                %>
                                <option userId="<%= id %>" type="fedId" <%= selected %> value="<%= permission.fedId %>"><%= permission.name %></option>
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
                <div class="panel-heading">Applications Created By User</div>
                <div class="panel-body">
                <% if(applications.length === 0){ %>
                <div style="font-family: Architects Daughter;" class="well-sm">This User has not created any applications yet.</div>
                <% } else { %>
                <table class="table table-hover" id="detail-applications-table">
                    <thead>
                        <tr>
                            <td>Application</td>
                            <td>Deadline</td>
                            <td>Last Edited On</td>
                        </tr>
                    </thead>
                    <tbody>
                        <%
                        _.each(applications, function(app,index,list){
                            %>
                            <tr id="<%= app.id %>">
                                <td><%= app.name %></td>
                                <td><%= app.startDate %> - <%= app.deadline %></td>
                                <td><%= window.timeConverter(app.lastEditedOn) %></td>
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