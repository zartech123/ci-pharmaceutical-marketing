<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
    <meta name="viewport" content="width=1024">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/Chart.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/file-saver@2.0.2/dist/FileSaver.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/Blob.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chartjs-plugin-datalabels.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css"/>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.tree-multiselect.min.css">

    <script src="<?php echo base_url(); ?>assets/js/jquery.tree-multiselect.min.js"></script>

	</head>
<body>
    <div class="container-fluid">
		<table width="100%">
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr><td colspan="12"><center><div class="table-label" style="font-size:14px">&nbsp;<b>Dashboard</b></div></center></td></tr>
			<tr><td colspan=12><hr></td></tr>
		</table>
		<div style="height:0">
		<table width="100%">
			<tr>
				<td><input class="form-control input-sm" type="text" id="start_date" name="start_date" style="width:70px;visibility:hidden" placeholder="Start Date"/></td>
				<td width="80px" ><input class="form-control input-sm" type="text" id="end_date" name="end_date" style="width:70px;visibility:hidden" placeholder="End Date"/></td>
				<td>
					<select id="type" class="form-control input-sm" style="width:90px;visibility:hidden">
						<option value="1" data-section="Channel">Quantity</options>									
						<option value="2" data-section="Channel" selected>Sales</options>									
					</select>				
				</td>
			</tr>
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr>
				<td colspan="5" style="vertical-align:top" width="26%">
					<div style="visibility:hidden;height:0px">
					<select id="id_channel" multiple="multiple" style="visibility:hidden">
						<option value="1" data-section="Channel" selected data-index="1">1 HOSPITAL</options>									
						<option value="2" data-section="Channel" selected data-index="1">2 PHARMACY</options>									
						<option value="3" data-section="Channel" selected data-index="1">3 DRUGSTORE</options>									
						<option value="4" data-section="Channel" selected data-index="1">4 INSTITUTION</options>									
						<option value="5" data-section="Channel" selected data-index="1">5 MTC</options>									
						<option value="6" data-section="Channel" selected data-index="1">6 PHARMA CHAIN</options>									
						<option value="7" data-section="Channel" selected data-index="1">7 GT & OTHERS</options>									
						<option value="8" data-section="Channel" selected data-index="1">8 PBF</options>									
					</select>
					</div>
				</td>
				<td colspan="2" style="vertical-align:top" width="22%">
					<div style="visibility:hidden;height:0px">
					<select id="id_dist" multiple="multiple" style="visibility:hidden">
						<?php
							$query2 = $this->db->query("SELECT id_dist, code from distributor where id_dist  not in (1,7) order by code");
							foreach ($query2->result() as $row2)
							{	
						
						   ?>		
							<option value="<?php echo $row2->id_dist; ?>" data-section="Distributor" selected data-index="1"><?php echo $row2->code; ?></options>									
						<?php } ?>
					</select>
					</div>
				</td>
				<td>
					<div style="visibility:hidden;height:0px">
					<select id="id_product" multiple="multiple" style="visibility:hidden">
					<?php
						$query = $this->db->query("SELECT id_group, name from product_group order by name");
						foreach ($query->result() as $row)
						{	
							$query2 = $this->db->query("select distinct a.id_product, a.name_product, c.name from product a, product_dist b, product_group c where a.id_group=c.id_group and a.id_product=b.id_product and a.id_group=".$row->id_group." order by name_product");
//							$query2 = $this->db->query("SELECT distinct id_product, name_product from product where id_group=".$row->id_group." order by name_product");
							foreach ($query2->result() as $row2)
							{	
						
						   ?>		
							<option value="<?php echo $row2->id_product; ?>" data-section="<?php echo $row->name; ?>" selected data-index="1"><?php echo $row2->name_product; ?></options>									
						<?php }
						}
						?>
					</select>
					</div>
				</td>
			</tr>
		</table>
		</div>
		<!--tr><td colspan="2" style="text-align:center;"><button type="button" class="btn btn-info" style="width:170px"><div id="year1"></div></button></td>
		<td colspan="<?php echo "14"; ?>" style="text-align:center;"><button id="buttonyear" type="button" class="btn btn-info" style="width:<?php echo $width; ?>"><div id="year2"></div></button></td><td style="text-align:center;"></td><td style="text-align:center;"></td></tr-->
		<br>
		<table width="100%">
		<tr>
		<td><iframe id="iframe1" frameBorder="0" src="<?php echo base_url(); ?>index.php/Report5?menu=0" style="height:900px;width:100%;overflow:hidden;"></iframe></td>
		</tr>
		<tr><td><hr></td></tr>
		<tr>
		<td><iframe id="iframe2" frameBorder="0" src="<?php echo base_url(); ?>index.php/Report3?menu=0" style="height:900px;width:100%;overflow:hidden;"></iframe></td>
		</tr>
		</table>
		<br>
		<br>
	</div>
</body>
<style type="text/css">
div.tree-multiselect
{
	font-size:12px;
	font-weight: normal;
}
.btn {
  border-radius:                    0px;
  -webkit-border-radius:            0px;
  -moz-border-radius:               0px;
}
</style>
<script>
      var id_product = $("#id_product").treeMultiselect({
        allowBatchSelection: true,
        enableSelectAll: true,
        searchable: true,
        sortable: true,
		startCollapsed: true,
		onChange: productOnChange,
		showSectionOnSelected: false,
		hideSidePanel: true
      });
	  var id_product2 = id_product[0];
	  
      var id_channel = $("#id_channel").treeMultiselect({
        allowBatchSelection: true,
        enableSelectAll: true,
//        searchable: true,
        sortable: true,
        startCollapsed: false,
		onChange: channelOnChange,
		showSectionOnSelected: false,
		hideSidePanel: true
      });
	  let id_channel2 = id_channel[0];

      var id_dist = $("#id_dist").treeMultiselect({
        allowBatchSelection: true,
        enableSelectAll: true,
//        searchable: true,
        sortable: true,
        startCollapsed: false,
		onChange: distOnChange,
		showSectionOnSelected: false,
		hideSidePanel: true
      });
	  let id_dist2 = id_dist[0];

		var date = new Date();
		var y1 = date.getFullYear();
		var m1 = 0;
		var y2 = date.getFullYear();
		var m2 = date.getMonth();

		var firstDay = (m1 < 9 ? '0' : '') + (m1 + 1) + "/" + y1;
		var firstDay2 = (m2 < 9 ? '0' : '') + (m2 + 1) + "/" + y2;



		var selectedChannel = ['1','2','3','4','5','6','7','8'];
		var distributor = [];
//		createChannel(selectedChannel,$("#id_product").val(),$("#id_dist").val());

			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report5/getDistributor",
					type: "GET",
					dataType: "text",
				success: function(response)
				{
//					alert(response);
					var json = $.parseJSON(response);
					for (var i=0;i<json.length;++i)
					{
						distributor[json[i].id-1] = json[i].name;
					}
				},
				error: function(response)
				{
				},
			});

		var url = "<?php echo base_url(); ?>index.php/Report5?menu=0&id_channel="+$("#id_channel").val()+"&id_product="+$("#id_product").val()+"&id_dist="+$("#id_dist").val()+"&type="+$("#type").val()+"&y1="+y1+"&y2="+y2+"&m1="+m1+"&m2="+m2;
//			alert(url);
		$('#iframe1').attr('src', url);

		var url2 = "<?php echo base_url(); ?>index.php/Report3?menu=0&id_channel="+$("#id_channel").val()+"&id_product="+$("#id_product").val()+"&id_dist="+$("#id_dist").val()+"&type="+$("#type").val()+"&y1="+y1+"&y2="+y2+"&m1="+m1+"&m2="+m2;
		$('#iframe2').attr('src', url2);


		function productOnChange(allSelectedItems, addedItems, removedItems) 
		{
			$('#loading').text('Progress : 0%');
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
//			alert($("#id_product").val());
//			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val(),$("#type").val());
//			alert("something changed!");
		}

		function channelOnChange(allSelectedItems, addedItems, removedItems) 
		{
			$('#loading').text('Progress : 0%');
//			alert($("#id_channel").val());
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
//			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val(),$("#type").val());
		}

		function distOnChange(allSelectedItems, addedItems, removedItems) 
		{
			$('#loading').text('Progress : 0%');
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
			var id_dist2 = $("#id_dist").val().toString();
			var currentTime = new Date().getTime();
//			alert($("#id_dist").val());
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report1/getProduct?id="+id_dist2+"&date="+currentTime,
					type: "GET",
					dataType: "text",
				success: function(response)
				{
					$("#id_product option").remove();
					id_product2.remove();
					var json = $.parseJSON(response);
					for (var i=0;i<json.length;++i)
					{
						$('#id_product').append("<option value='"+json[i].id+"' data-section='"+json[i].name_group+"' selected data-index='1'>"+json[i].name+"</option>");
					}	
					id_product = $("#id_product").treeMultiselect({
						allowBatchSelection: true,
						enableSelectAll: true,
						searchable: true,
						sortable: true,
						startCollapsed: true,
						onChange: productOnChange,
						showSectionOnSelected: false,
						hideSidePanel: true
					});
					id_product2 = id_product[0];
					id_product2.reload();
				},
				error: function(response)
				{
				},
			});
//			alert($("#id_product").val());
//			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val(),$("#type").val());
		}

		$("#start_date").val(firstDay);
		$("#end_date").val(firstDay2);
		$("#start_date").datepicker( {
			format: "mm/yyyy",
			startView: "year", 
			minViewMode: "months",
			autoclose: true,
//			minDate: date('mm/yyyy',strtotime('01/2017')),
			endDate: new Date()
		});
		$("#end_date").datepicker( {
			format: "mm/yyyy",
			startView: "year", 
			minViewMode: "months",
			autoclose: true,
//			minDate: date('mm/yyyy',strtotime('01/2017')),
			endDate: new Date()
		});

      apply_date.onclick = function() 
      {
			var url = "<?php echo base_url(); ?>index.php/Report5?menu=0&id_channel="+$("#id_channel").val()+"&id_product="+$("#id_product").val()+"&id_dist="+$("#id_dist").val()+"&type="+$("#type").val()+"&y1="+y1+"&y2="+y2+"&m1="+m1+"&m2="+m2;
//			alert(url);
			$('#iframe1').attr('src', url);

			var url2 = "<?php echo base_url(); ?>index.php/Report3?menu=0&id_channel="+$("#id_channel").val()+"&id_product="+$("#id_product").val()+"&id_dist="+$("#id_dist").val()+"&type="+$("#type").val()+"&y1="+y1+"&y2="+y2+"&m1="+m1+"&m2="+m2;
			$('#iframe2').attr('src', url2);

//			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());
      }


		$('#start_date').datepicker().on('changeDate', function(e) {
			var start_date = e.format(0, "mm/yyyy").split("/");
			m1 = start_date[0];
			m1 = Number(m1).toString();
			m1 = parseInt(m1,0)-1;
			y1 = start_date[1];
		});

		$('#end_date').datepicker().on('changeDate', function(e) {
			var end_date = e.format(0, "mm/yyyy").split("/");
			m2 = end_date[0];
			m2 = Number(m2).toString();
			m2 = parseInt(m2,0)-1;
			y2 = end_date[1];
		});

		
</script>
</html>

