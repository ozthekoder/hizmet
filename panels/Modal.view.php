<div modalId="<%= modalId %>" class="modal fade generalModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog <% if(size === 'large'){ %> modal-lg <% }else if(size === 'small'){ %> modal-sm <% } %>">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 style="font-family:Architects Daughter;" class="modal-title" id=""><%= modalTitle %></h4>
            </div>
            <div class="modal-body">
                <%= modalContent %>
              </div>
              <div class="modal-footer">
                  <% if(closeButton){ %>
                      <button type="button" id="modalCancel" class="btn btn-default" data-dismiss="modal"><%= closeButtonText %></button>
                  <% } %>
                  <% if(doneButton){ %>
                      <button type="button" id="modalDone" class="btn btn-primary"><%= doneButtonText %></button>
                  <% } %>
                    
              </div>
        </div>
    </div>
</div>