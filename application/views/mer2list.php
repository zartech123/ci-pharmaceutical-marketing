<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="refresh" content="120">
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
        <h5 class="modal-title"><strong>MASTER EVENT REQUEST FORM</strong></h5>
      </div>
      <div class="modal-body">
        <p>Do you want to delete this document <span id="bookId"></span>&nbsp;?</p>
      </div>
      <div class="modal-footer">
        <button id="yes" type="button" target="popup" class="btn btn-danger btn-sm" data-dismiss="modal" onclick='javascript:deleteData()'>Yes</a>
        <button id="no" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="basicModal2">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>MASTER EVENT REQUEST FORM</strong></h5>
      </div>
      <div class="modal-body">
        <p>Do you want to reject this document <span id="bookId2"></span>&nbsp;?</p>
      </div>
      <div class="modal-footer">
        <button id="yes" type="button" target="popup" class="btn btn-danger btn-sm" data-dismiss="modal" onclick='javascript:deleteData()'>Yes</a>
        <button id="no" type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="basicModal3">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>MASTER EVENT REQUEST FORM</strong></h5>
      </div>
      <div class="modal-body">
        <p>Do you want to review this document <span id="bookId3"></span>&nbsp;?</p>
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
<script type="text/javascript">
var Id = "";
var Url = "";

$('#basicModal').on('show.bs.modal', function(e) 
{
    Id = $(e.relatedTarget).data('id');
    Url = $(e.relatedTarget).data('url');
	  $("#bookId").text(Id);
});

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

function deleteData()
{
  window.open(Url,"popup","width=300,height=100");
  location.reload();
}

$(function()
{
		$("input[name='action']").after("<a id='create' href='MER' target='_blank' class='btn btn-warning btn-xs' style='width:270px'><i class='fa fa-plus'></i>&nbsp;&nbsp;MER</a>");
		$("input[name='action']").hide();
		$("input[name='action2']").after("<a style='width:175px' class='btn btn-disabled btn-xs'></a>");
		$("input[name='action2']").hide();

	var checkbox = $('select');

	var id = '';
	var id2 = '';

	$( "select" ).each( function( index, element )
	{
		$(this).on('change', function() 
		{
			id2 = $(this).attr('id');
			id = id2.replace("select", "");
			  $.ajax({
				url: "<?php echo base_url(); ?>index.php/MER2List/updateState?val="+$(this).val()+"&id="+id,
				  type: "GET",
				  dataType: "text",
				  success: function(response)
				  {
				},
				error: function(response)
				{
				},
			  });
					if($(this).val()=='0')
					{	
						$("#hcp1-"+id).hide();
						$("#hcp-"+id).hide();
						$("#sc-"+id).hide();
						$("#hco-"+id).hide();
						location.reload();
					}	
					else 
					{	
						$("#hcp1-"+id).show();
						$("#hcp-"+id).show();
						$("#sc-"+id).show();
						$("#hco-"+id).show();
						location.reload();					
					}
		});
	});


});
</script>
</html>
