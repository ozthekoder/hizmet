<?php if($rows === ''): ?>
<h3 style="text-align: center;font-family:Architects Daughter;text-shadow:0px 2px 3px rgba(0,0,0,0.3)">There are no applications for you to apply yet.</h3>
<?php else: ?>
<table id="apps-table" class="table table-responsive">
    <thead>
        <tr style="white-space: nowrap;">
            <th>Name</th>
            <th>Deadline</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?= $rows ?>
    </tbody>
</table>
<?php endif; ?>