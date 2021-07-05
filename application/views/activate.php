<!-- It's RESPONSIVE TOO! -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Activation Page</title>
		
  <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
		
		
		<style>
			.modal-footer {   border-top: 0px; }
		</style>
	</head>
	<body>
	<!--login form-->
	<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog">
	  <div class="modal-content">
	      <div class="modal-header">
	          <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true">×</button>
	          <h1>&nbsp;&nbsp;<img src="<?php echo base_url(); ?>assets/img/taisho.jpg" width="50" height="50">&nbsp;&nbsp;</img></h1>
	      </div>
	      <div class="modal-body">
	          <form class="form col-md-12 center-block" action="<?=base_url();?>Login/activateaccount" method="post">
				<div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
							<input type="text" class="form-control" name="email" id="email" value="<?php echo $key; ?>" placeholder="Enter your User Name" readonly/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-barcode"></span></span>
							<input type="text" class="form-control" name="code" id="code"  placeholder="Enter your Security Code"/>
						</div>
					</div>
				</div>
	            <div class="form-group">
	              <button class="btn btn-primary btn-block" type="submit">Activate</button><br>
	              <span id="error" class="pull-right" style='color:#a94442;'><?php if(isset($error)) echo "<span style='color:#a94442;'>$error</span>"; ?></span>
	            </div>
	          </form>
	      </div>
	      <div class="modal-footer ">
	          <div class="col-md-12">
	          <button class="btn hidden" data-dismiss="modal" aria-hidden="true">&nbsp;</button>
			  </div>	
	      </div>
	  </div>
	  </div>
	</div>
	</body>
<script>
var i=0;	
$("form").submit(function( event ) {
  if ($("input[name='code']").val()=="") 
  {
		$("#error").text("Security Code is are required");
		return false;	  
  } 	  
});
</script>	

	</html>