<!-- It's RESPONSIVE TOO! -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Forgot Password Page</title>
		
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
	          <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true"></button>
	          <h1>&nbsp;&nbsp;<img src="<?php echo base_url(); ?>assets/img/taisho.jpg" width="70" height="90">&nbsp;&nbsp;</img></h1>
	      </div>
	      <div class="modal-body">
	          <form class="form col-md-12 center-block" action="<?=base_url();?>index.php/Login/forgotpassword" method="post">
				<div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" name="username" id="username"  placeholder="Enter your User Name"/>
						</div>
					</div>
				</div>
	            <div class="form-group">
	              <button class="btn btn-primary btn-block" type="submit">Forgot Password</button><br>
	              <a href="<?php echo base_url(); ?>index.php/Login">Back to Login</a>
	            </div>
				<div>
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
$("form").submit(function( event ) {
  if ($("input[name='username']").val()!="") 
  {
    return true;
  }
  else
  {
    $("#error").text("User Name is required");
	return false;
  }	   
});
</script>	
	</html>