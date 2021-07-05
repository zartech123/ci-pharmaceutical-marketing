<!-- It's RESPONSIVE TOO! -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Change Password Page</title>
		
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
	          <h1>&nbsp;&nbsp;<img src="<?php echo base_url(); ?>assets/img/taisho.jpg" width="50" height="50">&nbsp;&nbsp;</img></h1>
	      </div>
	      <div class="modal-body">
	          <form class="form col-md-12 center-block" action="<?=base_url();?>index.php/Login/changepassword2" method="post">
				<div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" name="email" id="email" value="<?php echo $key; ?>" placeholder="Enter your User Name" readonly/>
						</div>
					</div>
				</div>
				<!--div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-barcode"></span></span>
							<input type="text" class="form-control" name="code" id="code"  placeholder="Enter your Security Code"/>
						</div>
					</div>
				</div-->
				<div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" class="form-control" name="password1" id="password1"  placeholder="Enter your New Password"/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" class="form-control" name="password2" id="password2"  placeholder="Enter your Password Confirmation"/>
						</div>
					</div>
				</div>
	            <div class="form-group">
	              <button class="btn btn-primary btn-block" type="submit">Change Password</button><br>
	              <a href="<?php echo base_url(); ?>index.php/Login">Back to Login</a><span id="error" class="pull-right" style='color:#a94442;'><?php if(isset($error)) echo "<span style='color:#a94442;'>$error</span>"; ?></span>
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
  if ($("input[name='password1']").val()!="" && $("input[name='password2']").val()!="") 
  {	
	  if ($("input[name='password1']").val()==$("input[name='password2']").val()) 
	  {

		if ($("input[name='password1']").val().length < 8) 
		{
			i=1;
			$("#error").text("Your password must be at least 6 characters");
			return false;
		}
		/*if ($("input[name='password1']").val().search(/[a-z]/i) < 0) 
		{
			i=1;
			$("#error").text("Your password must contain at least one letter."); 
			return false;
		}
		if ($("input[name='password1']").val().search(/[0-9]/) < 0) 
		{
			i=1;
			$("#error").text("Your password must contain at least one digit.");
			return false;
		}*/

		if(i==0)
		{	
			return true;
		}	
	  }
	  else
	  {
		$("#error").text("New Password and Confirmation is not match");
		return false;
	  }	   
  }
  else
  {
		$("#error").text("Security Code, New Password and Confirmation are required");
		return false;	  
  } 	  
});
</script>	

	</html>