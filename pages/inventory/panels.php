<!DOCTYPE html><html class=''>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<style>
body{
  padding: 60px;
}
.panel-heading .colpsible-panel:after {
    
    font-family: 'Glyphicons Halflings'; 
    content: "\e114";    
    float: right;        
    color: #408080;         
}
.panel-heading .colpsible-panel.collapsed:after {
    content: "\e080"; 
}


</style>
</head>
<body>


<div class = "container">

  
  <div class="panel-group" id="accordion">

  <div class="panel panel-danger">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="colpsible-panel" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Heading for collapsible item
        </a>
      </h4>
    </div>
    
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        The panel content comes here where you may use text, images and even videos. You may also place HTML tables, list etc here. 
      </div>
    </div>
  </div>

  <div class="panel panel-info">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="colpsible-panel" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          Heading 2 for collapsible item
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
        The panel content comes here where you may use text, images and even videos. You may also place HTML tables, list etc here.
      </div>
    </div>
  </div>
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="colpsible-panel" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          Heading 3 for collapsible item
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
        The panel content comes here where you may use text, images and even videos. You may also place HTML tables, list etc here.
      </div>
    </div>
  </div>
</div>
  
  
</div> <!-- end container -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>