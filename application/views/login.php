	<head>
		<title>Login Page</title>
		
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!--script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script-->

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>		
	<body>
	<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	  <div class="modal-content">
	      <div class="modal-header">
	          <button type="button" class="close hidden" data-dismiss="modal" aria-hidden="true"></button>
	          <h1>&nbsp;&nbsp;<img src="<?php echo base_url(); ?>assets/img/taisho.jpg" width="70" height="90">&nbsp;&nbsp;</img></h1>
	      </div>
	      <div class="modal-body">
	          <form class="form col-md-12 center-block" action="<?=base_url();?>index.php/Login/login" method="post">
				<div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" name="username" id="username"  placeholder="Enter your User Name"/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="cols-sm-10">
						<div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
							<input type="text" class="form-control" name="code" id="code" placeholder="Enter your Verification Code from Email"/>
						</div>
					</div>
				</div>
	            <div class="form-group">
	              <button class="btn btn-primary btn-block" type="submit">Login</button><br>
	              <a href="<?php echo base_url(); ?>index.php/Login/forgot">Forgot Password</a>
	            </div>
				<div>
					<span class="pull-right" style='color:#a94442;'><?php if(isset($error)) echo "<span style='color:#a94442;'>$error</span>"; ?></span>
				</div>
				<?php if(isset($url))	
				{ ?> 
			  <input type="hidden" id="url" name="url" value="<?php echo $url; ?>">
				<? } ?>
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

		<style>
			.modal-footer {   border-top: 0px; }
		</style>
<script type="text/javascript">



		$(document).ready(function(){
			$("#loginModal").modal('show');
		});	
		<?php if(isset($access) && isset($id))	
		{ ?> 
		$("#username").val('<?php echo $access; ?>');
								$.ajax({
									url : "<?php echo base_url(); ?>index.php/Login/getFirstTime?id="+$("#username").val(),
									type : "GET",
									dataType: "text",
									success : function(response)
									{
										$("#username").prop("readonly",true);
										//$("#code").val(response);
										/*if(response=="0")
										{	
											window.location.replace("<?php echo base_url(); ?>index.php/Login/first_login?key="+$("#username").val());
										}*/
									},
									error: function(response)
									{
									},	
								  });		
		<? } ?>
 		$("#username").on("change",function()
		{
			
					$.ajax({
						url : "<?php echo base_url(); ?>index.php/Login/getActive?id="+$("#username").val(),
						type : "GET",
						dataType: "text",
						success : function(response)
						{
							if(response=="0")
							{	
								$(".btn.btn-primary.btn-block").attr("style", "visibility:hidden");
								$(".pull-right").text("Your account is not available, Please contact Administrator");
							}
							else
							{
								$.ajax({
									url : "<?php echo base_url(); ?>index.php/Login/getFirstTime?id="+$("#username").val(),
									type : "GET",
									dataType: "text",
									success : function(response)
									{
										$("#username").prop("readonly",true);
										//$("#code").val(response);
										/*if(response=="0")
										{	
											window.location.replace("<?php echo base_url(); ?>index.php/Login/first_login?key="+$("#username").val());
										}*/
									},
									error: function(response)
									{
									},	
								  });		
							}								
						},
						error: function(response)
						{
						},	
					  });		
		});

$("form").submit(function( event ) {
  if ($("input[name='username']").val()!="" && $("input[name='password']").val()!="" && $("input[name='code']").val()!="") 
  {
    return true;
  }
  else
  {
	var error_text = ""; 	
	if ($("input[name='username']").val()=="")
    {	
		$("input[name='username']").css('border', '1px solid #ff0000');
		error_text = " User Name,";
	}	
	if ($("input[name='password']").val()=="")
    {	
		$("input[name='password']").css('border', '1px solid #ff0000');
		error_text = error_text+" Password,";
	}	
	if ($("input[name='code']").val()=="")
    {	
		$("input[name='code']").css('border', '1px solid #ff0000');
		error_text = error_text+" Verification Code,";
	}	

	  
    $(".pull-right").text(error_text.slice(0, -1)+" are required");
	return false;
  }	   
 });
</script>

	</head>
