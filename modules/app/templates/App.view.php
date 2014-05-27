<div class="container-fluid" style="margin-top:50px;height:100%;">
    <div class="row" style="height:100%;">
        <?= $leftPanel ?>
        <div class="col-md-10" style="height:100%;">
            <div class="page-header">
                <h1 style="font-family: Architects Daughter;"><?= $application['name'] ?></h1>
            </div>
            <?= $application['app'] ?>
            
            <a class="btn btn-danger submit-application" style="float: right;margin-bottom: 15px;">Submit Application</a>
        </div> 
    </div>
</div>


