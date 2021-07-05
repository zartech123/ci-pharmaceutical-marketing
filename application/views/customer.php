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

		var pathname = $(location).attr('pathname');
		var read=pathname.split('/');

		$("#field-id_channel2").css("width","100");
		$("#field-name").css("width","360");
		$("#field-postcode2").css("width","100");
		$("#field-address").css("width","360");
		$("#field-latitude").css("width","240");
		$("#field-longitude").css("width","240");
		$("#field-npwp").css("width","240");
		$("#field-city").css("width","360");
		$("#field-phone2").css("width","360");
		$("#field-id_cust2").css("width","360");
		$("#field-fax").css("width","360");
		$("#field-id_cust2").css("width","240");

		var id_dist = $("#field-id_dist").val();
		if(read[4]=="edit")
		{
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Customer/getChannel?id_dist="+id_dist,
					type: "GET",
					dataType: "text",
				success: function(response){
					var json = $.parseJSON(response);
					var id_channel = $("#field-id_channel").val();
					$('#field-id_channel').empty(); 
					$('#field-id_channel').trigger("chosen:updated");
					for (var i=0;i<json.length;++i)
					{
						$('#field-id_channel').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
						$('#field-id_channel').trigger("chosen:updated");
					}
					if(id_channel!="")	
					{	
						$('#field-id_channel').val(id_channel).trigger('chosen:updated');								
					}
				},
				error: function(response)
				{
				},
			});

			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Customer/getBranch?id_dist="+id_dist,
					type: "GET",
					dataType: "text",
				success: function(response){
					var json = $.parseJSON(response);
					var id_branch = $("#field-id_branch").val();
					$('#field-id_branch').empty(); 
					$('#field-id_branch').trigger("chosen:updated");
					for (var i=0;i<json.length;++i)
					{
						$('#field-id_branch').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
						$('#field-id_branch').trigger("chosen:updated");
					}
					if(id_branch!="")	
					{	
						$('#field-id_branch').val(id_branch).trigger('chosen:updated');								
					}
				},
				error: function(response)
				{
				},
			});

		}
		else
		{
//			alert(id_dist);
		}			
		
		$('#field-id_dist').on('change', function() 
		{
			id_dist = $("#field-id_dist").val();
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Customer/getChannel?id_dist="+id_dist,
					type: "GET",
					dataType: "text",
				success: function(response){
					var id_channel = "";
					var json = $.parseJSON(response);
					$('#field-id_channel').empty(); 
					$('#field-id_channel').trigger("chosen:updated");
					for (var i=0;i<json.length;++i)
					{
						if(i==0)
						{
							id_channel = json[i];
						}								
						$('#field-id_channel').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
						$('#field-id_channel').trigger("chosen:updated");
					}
					if(id_channel!="")	
					{	
						$('#field-id_channel').val(id_channel).trigger('chosen:updated');								
					}
				},
				error: function(response)
				{
				},
			});


			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Customer/getBranch?id_dist="+id_dist,
					type: "GET",
					dataType: "text",
				success: function(response){
					var id_branch = "";
					var json = $.parseJSON(response);
					$('#field-id_branch').empty(); 
					$('#field-id_branch').trigger("chosen:updated");
					for (var i=0;i<json.length;++i)
					{
						if(i==0)
						{
							id_branch = json[i];
						}								
						$('#field-id_branch').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
						$('#field-id_branch').trigger("chosen:updated");
					}
					if(id_branch!="")	
					{	
						$('#field-id_branch').val(id_branch).trigger('chosen:updated');								
					}
				},
				error: function(response)
				{
				},
			});


		});


});
</script>
</html>
