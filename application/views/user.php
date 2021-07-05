<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php 
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
</head>
<body>
	<?php echo $output; ?>
    <?php foreach($js_files as $file): ?>
        <script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
	<?php 
		echo "<footer>
        <center><small>&nbsp;&nbsp;&copy; Copyright 2019, <a href='https://www.taisho.co.id/' target='_blank'>PT Taisho Pharmaceutical Indonesia Tbk</a></small></center>
		</footer>" 
	?>
	<?php echo "<hr>"; ?>
</body>
<div id="message" style="position: fixed;top: 50%;left: 28%;"><?php echo $this->session->flashdata('message'); ?></div>
<style type="text/css">

</style>
<script>

	var pathname = $(location).attr('pathname');
	var read=pathname.split('/');

	
$(function(){
		$("#field-user_name").css("width","360");
		$("#field-name").css("width","360");
		$("#field-email").css("width","360");
		$("#field-account_number").css("width","360");
		$("#field-account_name").css("width","360");
		$("input[name='photo']").hide();
		$("input[name='active']").hide();
//		$("#field-old_password").after('<i>&nbsp;Please fill to change your password</i>');
//		$("#field-new_password").after('<i>&nbsp;Please fill to change your password</i>');
		$("#field-old_password").css("width","100");
		$("#field-new_password1").css("width","100");
		$("#field-new_password2").css("width","100");

		if(read[4]=="edit" || read[4]=="add")
		{
			$("div[id='message']").hide();
		}		
		else
		{
			if($("div[id='message']").text().length>0)
			{	
				$("div[id='message']").addClass( "alert alert-success" );
			}	
		}			
});
</script>
</html>
