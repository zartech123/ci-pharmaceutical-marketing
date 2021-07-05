<!-- It's RESPONSIVE TOO! -->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		  <link rel="icon" href="<?php echo base_url(); ?>assets/img/taisho.jpg" type="image/png"/>
		  <title>Voter</title>
		
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
	          <h1>&nbsp;&nbsp;<img src="<?php echo base_url(); ?>assets/img/taisho.jpg" width="70" height="50">&nbsp;&nbsp;</img></h1>
	      </div>
	      <div class="modal-body">
		     <div class="form-group">
	         &nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/Login">Back to Login</a><span class="pull-right" style='color:#a94442;'><?php if(isset($error)) echo "<span style='color:#a94442;'>$error</span>"; ?>&nbsp;&nbsp;&nbsp;&nbsp;</span>
			 </div> 
  		  </div>
	  </div>
	  </div>
	</div>
	</body>
<script>	
</script>	

	</html>