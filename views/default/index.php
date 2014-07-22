<?php
    
    use yii\helpers\Html;
    
?>

<div class="filemanager-default-index">

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="pull-left">
                <?= Html::button(Html::tag('span','',['class' => 'glyphicon glyphicon-cloud-upload']),['class' => 'btn btn-default navbar-btn', 'data-toggle' => 'modal', 'data-target' => '#filemanagerUpload']); ?>
            </div>
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
            </form>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body">
            <div class="row">
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
              <div class="col-xs-6 col-md-3">
                <a href="#" class="thumbnail">
                  <img src="http://themes.goodlayers.com/modernize/wp-content/uploads/2012/01/Fotolia_21995387_Subscription_Monthly_XXL-390x250.jpg" alt="...">
                </a>
              </div>
            </div>
        </div>
        <div class="panel-footer">
            <ul class="pagination" style="margin:0;">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&raquo;</a></li>
            </ul>
        </div>
    </div>
    
</div>


<!-- Modal -->
<div class="modal fade" id="filemanagerUpload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload File</h4>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancl</button>
        <button type="button" class="btn btn-primary">Upload</button>
      </div>
    </div>
  </div>
</div>
