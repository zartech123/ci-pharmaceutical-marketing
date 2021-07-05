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
	
$(function()
{
	
	var pathArray = window.location.pathname.split('/');
	if(pathArray[4]=='edit')
	{
//		alert($("#field-id_menu").val());
	    if($("#field-id_menu").val()=='1' || $("#field-id_menu").val()=='3' || $("#field-id_menu").val()=='5' || $("#field-id_menu").val()=='7' || $("#field-id_menu").val()=='9')
		{
			  $(".form-group.approver2_form_group").hide();
			  $(".form-group.approver3_form_group").hide();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		}			
		  else if($("#field-id_menu").val()=='2')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").hide();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		  }
		  else if($("#field-id_menu").val()=='4')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").hide();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		  }
		  else if($("#field-id_menu").val()=='6')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").hide();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		  }
		  else if($("#field-id_menu").val()=='8')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").show();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		  }
		  else if($("#field-id_menu").val()=='10')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").show();
			  $(".form-group.approver4_form_group").show();
			  $(".form-group.approver5_form_group").show();
		  }
	}		
	
	$('#field-id_menu').on('change', function() 
	{
		  if($("#field-id_menu").val()=='1' || $("#field-id_menu").val()=='3' || $("#field-id_menu").val()=='5' || $("#field-id_menu").val()=='7' || $("#field-id_menu").val()=='9')
		  {
			  $(".form-group.approver2_form_group").hide();
			  $(".form-group.approver3_form_group").hide();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		  }
		  else if($("#field-id_menu").val()=='2')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").hide();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		  }
		  else if($("#field-id_menu").val()=='4')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").hide();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		  }
		  else if($("#field-id_menu").val()=='6')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").hide();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		  }
		  else if($("#field-id_menu").val()=='8')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").show();
			  $(".form-group.approver4_form_group").hide();
			  $(".form-group.approver5_form_group").hide();
		  }
		  else if($("#field-id_menu").val()=='10')
		  {
			  $(".form-group.approver2_form_group").show();
			  $(".form-group.approver3_form_group").show();
			  $(".form-group.approver4_form_group").show();
			  $(".form-group.approver5_form_group").show();
		  }
    });      
});
</script>
</html>
