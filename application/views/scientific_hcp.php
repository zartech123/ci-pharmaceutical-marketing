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

	$("#field-type").css("width","360");
	$("#field-name_hcp").css("width","360");
	$("#field-npwp_hcp").css("width","360");
	$("#field-fee_hcp").css("width","360");
	$("#field-account_name_hcp").css("width","360");
	$("#field-bank_hcp").css("width","360");
	$("#field-institution_hcp").css("width","360");
	$(".form-group.name_hcp_form_group").hide();
	$(".form-group.npwp_hcp_form_group").hide();
	$(".form-group.ktp_hcp_form_group").hide();
	$(".form-group.bank_hcp_form_group").hide();
	$(".form-group.fee_hcp_form_group").hide();
	$(".form-group.service_hcp_form_group").hide();
	$(".form-group.institution_hcp_form_group").hide();
	$(".form-group.file_ktp_form_group").hide();
	$(".form-group.file_npwp_form_group").hide();
	$(".form-group.file_bank_form_group").hide();
	$(".form-group.file_cv_form_group").hide();
	$(".form-group.speaker_criteria_form_group").hide();
	if(read[7]=="add")
	{
		$('#field-type').val(read[6]).trigger('chosen:updated');
	}	

//	$(".form-group.id_sc_form_group").hide();


	$('#field-type').on('change', function() 
	{
		  if($("#field-type").val()=='2')
		  {
			$(".form-group.bank_name_hcp_form_group").show();
			$(".form-group.account_name_hcp_form_group").show();
			$(".form-group.name_hcp_form_group").show();
			$(".form-group.npwp_hcp_form_group").show();
			$(".form-group.ktp_hcp_form_group").show();
			$(".form-group.bank_hcp_form_group").show();
			$(".form-group.fee_hcp_form_group").show();
			$(".form-group.service_hcp_form_group").show();
			$(".form-group.institution_hcp_form_group").show();
			$(".form-group.file_ktp_form_group").show();
			$(".form-group.file_npwp_form_group").show();
			$(".form-group.file_bank_form_group").show();
			$(".form-group.file_cv_form_group").show();
			$(".form-group.speaker_criteria_form_group").show();
			$(".form-group.internal_speaker_form_group").hide();
		  }
		  else if($("#field-type").val()=='1')
		  {
			$(".form-group.bank_name_hcp_form_group").hide();
			$(".form-group.account_name_hcp_form_group").hide();
			$(".form-group.name_hcp_form_group").hide();
			$(".form-group.npwp_hcp_form_group").hide();
			$(".form-group.ktp_hcp_form_group").hide();
			$(".form-group.bank_hcp_form_group").hide();
			$(".form-group.fee_hcp_form_group").hide();
			$(".form-group.service_hcp_form_group").hide();
			$(".form-group.institution_hcp_form_group").hide();
			$(".form-group.file_ktp_form_group").hide();
			$(".form-group.file_npwp_form_group").hide();
			$(".form-group.file_bank_form_group").hide();
			$(".form-group.file_cv_form_group").hide();
			$(".form-group.speaker_criteria_form_group").hide();

		  }
    });      

		  if($("#field-type").val()=='2')
		  {
			$(".form-group.bank_name_hcp_form_group").show();
			$(".form-group.account_name_hcp_form_group").show();
			$(".form-group.name_hcp_form_group").show();
			$(".form-group.npwp_hcp_form_group").show();
			$(".form-group.ktp_hcp_form_group").show();
			$(".form-group.bank_hcp_form_group").show();
			$(".form-group.fee_hcp_form_group").show();
			$(".form-group.service_hcp_form_group").show();
			$(".form-group.institution_hcp_form_group").show();
			$(".form-group.file_ktp_form_group").show();
			$(".form-group.file_npwp_form_group").show();
			$(".form-group.file_bank_form_group").show();
			$(".form-group.file_cv_form_group").show();
			$(".form-group.speaker_criteria_form_group").show();
			$(".form-group.internal_speaker_form_group").hide();
		  }
		  else if($("#field-type").val()=='1')
		  {
			$(".form-group.bank_name_hcp_form_group").hide();
			$(".form-group.account_name_hcp_form_group").hide();
			$(".form-group.name_hcp_form_group").hide();
			$(".form-group.npwp_hcp_form_group").hide();
			$(".form-group.ktp_hcp_form_group").hide();
			$(".form-group.bank_hcp_form_group").hide();
			$(".form-group.fee_hcp_form_group").hide();
			$(".form-group.service_hcp_form_group").hide();
			$(".form-group.institution_hcp_form_group").hide();
			$(".form-group.file_ktp_form_group").hide();
			$(".form-group.file_npwp_form_group").hide();
			$(".form-group.file_bank_form_group").hide();
			$(".form-group.file_cv_form_group").hide();
			$(".form-group.speaker_criteria_form_group").hide();

		  }

});
</script>
</html>
