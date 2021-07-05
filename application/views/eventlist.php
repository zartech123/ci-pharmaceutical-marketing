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
<div class="modal" tabindex="-1" role="dialog" id="basicModal2">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>EVENT OTC REQUEST FORM</strong></h5>
      </div>
      <div class="modal-body">
        <p>Do you want to reject this document <span id="bookId2"></span>&nbsp;?</p>
        <p></p>
        <p>Note</p>
        <p><textarea id="note2" cols="77" rows="5" class="form-control"></textarea></p>
      </div>
      <div class="modal-footer">
        <button id="yes2" type="button" target="popup" class="btn btn-danger btn-sm" style="visibility:hidden" data-dismiss="modal" onclick='javascript:deleteData2()'>Yes</a>
        <button id="no2" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="basicModal3">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>EVENT OTC REQUEST FORM</strong></h5>
      </div>
      <div class="modal-body">
        <p>Do you want to review this document <span id="bookId3"></span>&nbsp;?</p>
        <p></p>
        <p>Note</p>
        <p><textarea id="note3" cols="77" rows="5" class="form-control"></textarea></p>
      </div>
      <div class="modal-footer">
        <button id="yes3" type="button" target="popup" class="btn btn-danger btn-sm" style="visibility:hidden" data-dismiss="modal" onclick='javascript:deleteData3()'>Yes</a>
        <button id="no3" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
</style>
<script tyle="javascript">


function deleteData3()
{
	Url = Url + "&note="+encodeURI($("#basicModal3").find("#note3").val());
	
	window.open(Url,"popup","width=0,height=0");
	location.reload();
}

function deleteData2()
{
	Url = Url + "&note="+encodeURI($("#basicModal2").find("#note2").val());
	
	window.open(Url,"popup","width=0,height=0");
	location.reload();
}


$('#basicModal2').on('show.bs.modal', function(e) 
{
    Id = $(e.relatedTarget).data('id');
    Url = $(e.relatedTarget).data('url');
	  $("#bookId2").text(Id);
});

$('#basicModal3').on('show.bs.modal', function(e) 
{
	Id = $(e.relatedTarget).data('id');
	Url = $(e.relatedTarget).data('url');
	  $("#bookId3").text(Id);
});

	
$(function()
{
		$("#basicModal3").find("#note3").keyup(function()
		{ 
			if ($("#basicModal3").find("#note3").val()=="")
			{
				$("#yes3").attr("style", "visibility:hidden")
			}
			else
			{
				$("#yes3").attr("style", "visibility:show")
			}
		});

		$("#basicModal2").find("#note2").keyup(function()
		{ 
			if ($("#basicModal2").find("#note3").val()=="")
			{
				$("#yes2").attr("style", "visibility:hidden")
			}
			else
			{
				$("#yes2").attr("style", "visibility:show")
			}
		});

		$("input[name='action']").after("<a id='create' href='Event' target='_blank' class='btn btn-warning btn-xs' style='width:100px'><i class='fa fa-plus'></i>&nbsp;&nbsp;Event OTC</a>");
		$("input[name='action']").hide();
		$("input[name='action2']").after("<a style='width:110px' class='btn btn-disabled btn-xs'></a>");
		$("input[name='action2']").hide();
});


</script>
</html>
