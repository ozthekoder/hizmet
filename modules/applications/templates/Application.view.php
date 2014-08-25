<div data-id="<%= id %>" data-name="<%= name %>" data-startDate="<%= startDate %>" data-deadline="<%= deadline %>" data-createdBy="<%= createdBy %>" class="row creation-modal-content" style="position: relative;">
    <div data-spy="affix" class="col-md-3" id="forms-sidebar" style="padding-top: 15px;height: 448px;overflow: auto;">
        <ul class="nav nav-stacked left-panel" id="forms-list">
        <% _.each(forms, function(form, index ,list){ %>
        <li class="nav-list-item" formid="<%= form.id %>" order="<%= form.order %>"><a href="#form-<%= form.order %>"><%= form.order %>) <%= form.name %></a></li>
        <% }); %>
        </ul>
    </div>
    <div class="col-md-9" >
        <div class="container-fluid" style="height: 60px;background: #e0e0e0" id="app-create-top-panel">
            <div class="input-group" style="max-width:154px;float:left;margin-top:15px;">
                <span class="input-group-addon">Name</span>
                <input type="text" name="applicationName" id="appName" value="<%= name %>" class="form-control input-sm" placeholder="Name..">
            </div>
            <div style="margin-left: 10px;margin-top: 15px;float: left;max-width: 300px;" data-date-format="yyyy-mm-dd" class="input-daterange input-group" id="datepicker">
                <span class="input-group-addon" style="border-width: 1px 0px 1px 1px;">Start: </span>
                <input type="text" class="input form-control input-sm" value="<%= startDate %>" name="startDate">
                <span class="input-group-addon">End: </span>
                <input type="text" class="input form-control input-sm" value="<%= deadline %>" name="deadline">
            </div>
            <button id="toggleStatus" status="<%= status %>" style="float:left;margin-top:15px;margin-left: 10px;" class="btn btn-primary btn-sm"><%= status ? 'Deactivate' : 'Activate' %></button>
            <span title="Add New Form" style="font-size:24px;margin-left: 10px;margin-top: 18px;float: left;" class="create-new-form icon-plus trans-all"></span>
        </div>
        <div class="container-fluid" style="height: 388px;overflow: auto;background: #f9f9f9;" id="forms-panel">
            <div style="padding-top: 15px;">
            <% _.each(forms, function(item, index, list){ %>
                <%= formTpl(item) %>
            <% }); %>
            </div>
        </div>
    </div>
</div>