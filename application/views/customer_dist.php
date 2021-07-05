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
		$("#field-id_product3").css("width","100");

		$('#field-id_dist').on('change', function() 
		{
//			alert("<?php echo base_url(); ?>index.php/CustomerDist/getCustomer?id_dist="+$("#field-id_dist").val());
			var id_dist = $("#field-id_dist").val();
			var keyword = '';
			
			if(id_dist=='3')
			{
				keyword='DAYAMUDAAGUNG';
			}				
			else if(id_dist=='4')
			{
				keyword='KFTD';
			}				
			else if(id_dist=='5')
			{
				keyword='TRISAPTAJAYA';
			}				
			else if(id_dist=='6')
			{
				keyword='ENSEVALPUTERA';
			}				

//			alert("<?php echo base_url(); ?>index.php/CustomerDist/getCustomer?id_dist="+$("#field-id_dist").val()+"&keyword="+keyword);
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/CustomerDist/getCustomer?id_dist="+$("#field-id_dist").val()+"&keyword="+keyword,
					type: "GET",
					dataType: "text",
				success: function(response){
					var id_cust = '';
					var json = $.parseJSON(response);
					$('#field-id_cust').empty(); 
					$('#field-id_cust').trigger("chosen:updated");
					for (var i=0;i<json.length;++i)
					{
						if(i==0)
						{
							id_cust = json[i];
						}								
						$('#field-id_cust').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
						$('#field-id_cust').trigger("chosen:updated");
					}
					if(id_cust!="")	
					{	
						$('#field-id_cust').val(id_cust).trigger('chosen:updated');								
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
