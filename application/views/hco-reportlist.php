<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="30">
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
<div class="modal" tabindex="-1" role="dialog" id="basicModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>HCO POST EVENT REPORT</strong></h5>
      </div>
      <div class="modal-body">
        <p>Do you want to delete this data <span id="bookId"></span>&nbsp;?</p>
      </div>
      <div class="modal-footer">
        <button id="yes" type="button" target="popup" class="btn btn-danger btn-sm" data-dismiss="modal" onclick='javascript:deleteData()'>Yes</a>
        <button id="no" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
</style>
<script>
var Id = "";
var Url = "";

$('#basicModal').on('show.bs.modal', function(e) 
{
    Id = $(e.relatedTarget).data('id');
    Url = $(e.relatedTarget).data('url');
	  $("#bookId").text(Id);
});

function deleteData()
{
  window.open(Url,"popup","width=300,height=100");
  location.reload();
}
	
$(function()
{
		$("input[name='action']").hide();
		$("input[name='action2']").after("<a style='width:110px' class='btn btn-disabled btn-xs'></a>");
		$("input[name='nodoc2']").after("<a style='width:20px' class='btn btn-disabled btn-xs'></a>");
		$("input[name='action2']").hide();
});
</script>
</html>
