<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LoginModule
 *
 * @author osman
 */
class Federations extends Module
{
    public function __construct() {
        
    }
    
    public function load()
    {
        $view = new View('federations/templates/Federations.view.php');
        $leftPanel = new View('admin/templates/LeftPanel.view.php');
        $row = new View('federations/templates/FederationRow.view.php');
        $table = new View('federations/templates/FederationsTable.view.php');
        
        $regionStateTable = '<div class="panel panel-default">
                                        <table class="table table-responsive table-striped">
                                          <thead>
                                            <tr>
                                                <th>State</th>
                                                <th>Region</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <%= rows %>
                                        </tbody>
                                        </table>
                                      </div>';
        
        $regionStateRow = '<tr stateId="<%= id %>" style="position:relative;">
                                                <td style="font-size: 24px;"><span style="margin-right: 3px;" class="icon-<%= short.toLowerCase() %>"""></span><%= name %></td>
                                                <td style="position:relative;">
                                                    <div class="btn-group">
                                                        <button type="button" name="mapping" value="" class="btn dropdown-toggle btn-default " data-toggle="dropdown">
                                                            <span class="selected-region"><% if(_.isNull(regionName)) { %>None Selected<% }else { %> <%= regionName %> <% } %></span>
                                                            <span class="caret" style="margin-left: 2px;"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" id="region-mapping-selection">
                                                            <ul id="region-mapping-selection" class="dropdown-menu scroll-menu scroll-menu-2x">
                                                            <%= regions %>
                                                            </ul>
                                                        </ul>
                                                    </div>
                                                    <span class="icon-checkmark map-success"></span>
                                                </td>
                                            </tr>';
        jsConfig('regionStateTable', $regionStateTable);
        jsConfig('regionStateRow', $regionStateRow);
        $feds = (array)EventManager::$db->selectAll('Federation');
        $rows = '';
        
        foreach($feds as $fed)
        {
            $rows .= $row->createHtml((array)$fed);
        }
        
        $nats = EventManager::$db->query('SELECT * FROM hizmet.Nationality left join (select id as fedId, name as fedName from hizmet.Federation) as f on Nationality.fedId=f.fedId;');
        $this->setVar('federations', $feds);
        $this->setVar('nations', $nats);
        jsConfig('federations', $feds);
        jsConfig('nations', $nats);
        $this->setVar('leftPanel', $leftPanel->createHTML());
        $this->setVar('table', $table->createHTML(array('rows' => $rows)));
        $this->setView($view);  
        $this->addCSS('css/admin.css');
        $this->addJS('js/admin.js');
        return $this->createHTML();
    }
    
    
}

?>
