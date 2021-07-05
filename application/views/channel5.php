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

		$('#field-id_dist').on('change', function() 
		{
			$('#field-id_branch').empty(); 
			var id = 	$('#field-id_dist').val();
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Channel5/getBranch?id="+id,
					type: "GET",
					dataType: "text",
				success: function(response){
					var json = $.parseJSON(response);
    			    $('#field-id_branch').append('<option value="">- Select Branch -</option>');
					for (var i=0;i<json.length;++i)
					{
						  $('#field-id_branch').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
					}
					$('#field-id_branch').trigger("chosen:updated");
				},
				error: function(response)
				{
				},
			});
		});


});
</script>
</html>
