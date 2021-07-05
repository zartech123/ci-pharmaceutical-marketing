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
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css"/>
	<script src="//cdn.jsdelivr.net/npm/file-saver@2.0.2/dist/FileSaver.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/Blob.js"></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.tree-multiselect.min.css">
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.1.0/bootstrap-4.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/jquery.tree-multiselect.min.js"></script>

	</head>
<body>
    <div class="container-fluid">
		<table width="100%">
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr><td colspan="12"><center><div class="table-label" style="font-size:14px">&nbsp;<b>Non Active Outlet</b></div></center></td></tr>
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr>
				<td width="60px" style="font-size:14px">&nbsp;Start :&nbsp;</td>
				<td><input class="form-control input-sm" type="text" id="start_date" name="start_date" style="width:70px" placeholder="Start Date"/></td>
				<td width="50px" style="font-size:14px">&nbsp;End :&nbsp;</td>
				<td width="80px" ><input class="form-control input-sm" type="text" id="end_date" name="end_date" style="width:70px" placeholder="End Date"/></td>
				<td>&nbsp;</td>
				<?php
					$state = "0";
					$state2 = "0";
					$disabled  = "";
					$disabled2  = "";
					$query = $this->db->query("select state from job where id_job=2");
					foreach ($query->result() as $row2)
					{			
						$state = $row2->state;
					}	
					$query = $this->db->query("select state from job where id_job=3");
					foreach ($query->result() as $row2)
					{			
						$state2 = $row2->state;
					}	
					if($state==1)
					{
						$disabled = "disabled";
					}						
					if($state2==1)
					{
						$disabled2 = "disabled";
					}						
				?>
				<td><button type="button" id="apply_date" class="btn btn-info btn-sm" <?php echo $disabled; ?>>Generate Detail Report</button></td>
				<td>
				<?php
				if($state2==0)
				{
				?>
				<button type="button" id="apply_date2" class="btn btn-success btn-sm" <?php echo $disabled2; ?>>Generate Summary Report</button></td>
				<?php } ?>
				<td>
				<?php
				if($state==0)
				{
				?>
				<a id="excel" href="<?php echo base_url(); ?>assets/uploads/DetailReportNonActiveOutlet.xlsx" style="cursor:pointer"><i class="fa fa-file-text-o fa-border" style="font-size:21px"></i></a>
				<?php } ?>
				<a id="excel2" style="visibility:hidden;cursor:pointer"><i class="fa fa-file-text-o fa-border" style="font-size:21px"></i></a>
				</td>
			</tr>
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr>
				<td colspan="6" style="vertical-align:top" width="26%">
					<select id="id_channel" multiple="multiple">
						<option value="1" data-section="Channel" selected data-index="1">1 HOSPITAL</options>									
						<option value="2" data-section="Channel" selected data-index="1">2 PHARMACY</options>									
						<option value="3" data-section="Channel" selected data-index="1">3 DRUGSTORE</options>									
						<option value="4" data-section="Channel" selected data-index="1">4 INSTITUTION</options>									
						<option value="5" data-section="Channel" selected data-index="1">5 MTC</options>									
						<option value="6" data-section="Channel" selected data-index="1">6 PHARMA CHAIN</options>									
						<option value="7" data-section="Channel" selected data-index="1">7 GT & OTHERS</options>									
						<option value="8" data-section="Channel" selected data-index="1">8 PBF</options>									
					</select>
					<select id="id_channel3" multiple="multiple">
						<?php
							$query2 = $this->db->query("SELECT id_channel, name from channel2");
							foreach ($query2->result() as $row2)
							{	
						
						   ?>		
							<option value="<?php echo $row2->id_channel; ?>" data-section="Internal Channel" selected data-index="1"><?php echo $row2->name; ?></options>									
						<?php } ?>
					</select>
				</td>
				<td colspan="2" style="vertical-align:top" width="22%">
					<select id="id_dist" multiple="multiple">
						<?php
							$query2 = $this->db->query("SELECT id_dist, code from distributor where id_dist not in (1,2,7) order by code");
							foreach ($query2->result() as $row2)
							{	
						
						   ?>		
							<option value="<?php echo $row2->id_dist; ?>" data-section="Sub Distributor" data-index="1"><?php echo $row2->code; ?></options>									
						<?php } ?>
					</select>
				</td>
				<td style="vertical-align:top">
					<select id="id_product" multiple="multiple">
					<?php
						$query = $this->db->query("SELECT id_group, name from product_group order by name");
						foreach ($query->result() as $row)
						{	
							$query2 = $this->db->query("select distinct a.id_product, a.name_product, c.name from product a, product_dist b, product_group c where b.id_dist not in (2) and a.id_group=c.id_group and a.id_product=b.id_product and a.id_group=".$row->id_group." order by name_product");
//							$query2 = $this->db->query("SELECT distinct id_product, name_product from product where id_group=".$row->id_group." order by name_product");
							foreach ($query2->result() as $row2)
							{							
						   ?>		
							<option value="<?php echo $row2->id_product; ?>" data-section="<?php echo $row->name; ?>" selected data-index="1"><?php echo $row2->name_product; ?></options>									
						<?php }
						}
						?>
					</select>
				</td>
			</tr>
			<tr><td colspan=12><hr></td></tr>
		</table>
		<table cellpadding="0" cellspacing="0" style="font-size:13px;border-spacing:0px">
			<div ><span id="loading">Progress : 0%</span></div>
			<div class="progress">
			  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0"
			  aria-valuemin="0" aria-valuemax="100" style="width:0%">
				<span class="sr-only">70% Complete</span>
			  </div>
			</div>
		</table>
		<table cellpadding="0" cellspacing="0" style="font-size:13px;border-spacing:0px">
			<div id="table" class="table-responsive"></div>
		</table>
		<br><br>
		<!--tr><td colspan="2" style="text-align:center;"><button type="button" class="btn btn-info" style="width:170px"><div id="year1"></div></td>
		<td colspan="<?php echo "14"; ?>" style="text-align:center;"><button id="buttonyear" type="button" class="btn btn-info" style="width:<?php echo $width; ?>"><div id="year2"></div></td><td style="text-align:center;"></td><td style="text-align:center;"></td></tr-->
		<br><br><br>
		<br><br><br>
	</div>
</body>
<style type="text/css">
div.tree-multiselect
{
	font-size:12px;
	font-weight: normal;
}
</style>
<script>
	var is_exist = 0;
	var is_exist2 = 0;
	var progress = 0;
	var start = Date.now();
	var	end = Date.now();
	numeral.register('locale', 'id', {
		delimiters: {
			thousands: ',',
			decimal: '.'
		},
		abbreviations: {
			thousand: 'K',
			million: 'M',
			billion: 'B',
			trillion: 'T'
		},
		ordinal : function (number) {
			return number === 1 ? 'er' : 'ème';
		},
		currency: {
			symbol: '€'
		}
	});

	numeral.locale('id');

	  $('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
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

      var id_channel3 = $("#id_channel3").treeMultiselect({
        allowBatchSelection: true,
        enableSelectAll: true,
//        searchable: true,
        sortable: true,
        startCollapsed: false,
		onChange: channelOnChange,
		showSectionOnSelected: false,
		hideSidePanel: true
      });
	  let id_channel4 = id_channel3[0];

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
		var y1 = (date.getFullYear()-1);
		var m1 = date.getMonth();
		var y2 = date.getFullYear();
		var m2 = date.getMonth();

		var firstDay = (m1 < 9 ? '0' : '') + (m1 + 1) + "/" + y1;
		var firstDay2 = (m2 < 9 ? '0' : '') + (m2 + 1) + "/" + y2;

		var selectedChannel = ['1','2','3','4','5','6','7','8'];
		var distributor = [];
//		createChannel(selectedChannel,$("#id_product").val(),$("#id_dist").val());

			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report9/getDistributor",
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


		function productOnChange(allSelectedItems, addedItems, removedItems) 
		{
			$('#loading').text('Progress : 0%');
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
//			alert($("#id_product").val());
			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());
//			alert("something changed!");
		}

		function channelOnChange(allSelectedItems, addedItems, removedItems) 
		{
			$('#loading').text('Progress : 0%');
//			alert($("#id_channel").val());
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());
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
//			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());
		}

		function createChannel(selected,selected2,selected3)
		{
			var currentTime = new Date().getTime();
			Swal.fire({
				title: '',
				html: '<span style="font-size:14px">Please wait...</span>'
			});
			swal.showLoading();
			start = Date.now();
			$('#loading').text('Progress : '+progress+'%.');
			$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
			if(selected3==null)
			{
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/Report11/getTotal?month1="+(m1+1)+"&month2="+(m2+1)+"&id_dist=0&year2="+y2+"&year1="+y1+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime,
						type: "GET",
						dataType: "text",
						headers: {
							 'Cache-Control': 'no-cache, no-store, must-revalidate', 
							 'Pragma': 'no-cache', 
							 'Expires': '0'
						   },
						cache:false,
					success: function(response)
					{
						$("#apply_date").addClass('disabled');
						for (var i=0;i<50;++i)
						{	
							(function (x) 
							{
								setTimeout(function()
								{ 
									$.ajax({
										url:"<?php echo base_url(); ?>assets/uploads/DetailReportNonActiveOutlet.xlsx",
										type:'HEAD',
										error: function()
										{
										},
										success: function()
										{
											is_exist = 1;
											$("#apply_date").removeClass('disabled');
										}
									});
									if(progress<100)
									{
										progress = progress + 1;
										$('#loading').text('Progress : '+progress+'%.');
										$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
									}	
									if(is_exist==1 && progress<100)
									{
										i = 51;
										progress = 100;
										$('#loading').text('Progress : '+progress+'%.');
										$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
										if(progress==100)
										{	
											end = Date.now();
											$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
											swal.close();
										}	
										$('#excel').css('visibility', 'visible');
									}
								}, i*10000);
							})(i);							
						}	
						
					},
					error: function(response)
					{
						alert("Error2");
					},
				}).done(function (result) 
				{					
				});
			}
			else
			{		
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/Report11/getTotal?month1="+(m1+1)+"&month2="+(m2+1)+"&id_dist="+selected3.toString()+"&year2="+y2+"&year1="+y1+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime,
						type: "GET",
						dataType: "text",
						headers: {
							 'Cache-Control': 'no-cache, no-store, must-revalidate', 
							 'Pragma': 'no-cache', 
							 'Expires': '0'
						   },
						cache:false,
					success: function(response)
					{
						$("#apply_date").addClass('disabled');
						for (var i=0;i<50;++i)
						{	
							(function (x) 
							{
								setTimeout(function()
								{ 
									$.ajax({
										url:"<?php echo base_url(); ?>assets/uploads/DetailReportNonActiveOutlet.xlsx",
										type:'HEAD',
										error: function()
										{
										},
										success: function()
										{
											is_exist = 1;
											$("#apply_date").removeClass('disabled');
										}
									});
									if(progress<100)
									{
										progress = progress + 1;
										$('#loading').text('Progress : '+progress+'%.');
										$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
									}	
									if(is_exist==1 && progress<100)
									{
										i = 51;
										progress = 100;
										$('#loading').text('Progress : '+progress+'%.');
										$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
										if(progress==100)
										{	
											end = Date.now();
											$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
											swal.close();
										}	
										$('#excel').css('visibility', 'visible');
									}
								}, i*10000);
							})(i);							
						}	
						
					},
					error: function(response)
					{
						alert("Error2");
					},
				}).done(function (result) 
				{					
				});
			}
		}

		function createChannel2(selected,selected2,selected3)
		{
			var currentTime = new Date().getTime();
			Swal.fire({
				title: '',
				html: '<span style="font-size:14px">Please wait...</span>'
			});
			swal.showLoading();
			start = Date.now();
			$('#loading').text('Progress : '+progress+'%.');
			$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
			if(selected3==null)
			{
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/Report11/getTotal2?month1="+(m1+1)+"&month2="+(m2+1)+"&id_dist=0&year2="+y2+"&year1="+y1+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime,
						type: "GET",
						timeout:1200000,
						dataType: "text",
						headers: {
							 'Cache-Control': 'no-cache, no-store, must-revalidate', 
							 'Pragma': 'no-cache', 
							 'Expires': '0'
						   },
						cache:false,
					success: function(response)
					{
						$("#apply_date2").addClass('disabled');
						for (var i=0;i<50;++i)
						{	
							(function (x) 
							{
								setTimeout(function()
								{ 
									$.ajax({
										url:"<?php echo base_url(); ?>assets/uploads/SummaryReportNonActiveOutlet.txt",
										type:'GET',
										error: function()
										{
										},
										success: function(response)
										{
											is_exist2 = 1;
											$("#apply_date2").removeClass('disabled');
											$("#table").html(response);
										}
									});
									if(progress<100)
									{
										progress = progress + 1;
										$('#loading').text('Progress : '+progress+'%.');
										$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
									}	
									if(is_exist2==1 && progress<100)
									{
										i = 51;
										progress = 100;
										$('#loading').text('Progress : '+progress+'%.');
										$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
										if(progress==100)
										{	
											end = Date.now();
											$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
											swal.close();
										}	
										$('#excel2').css('visibility', 'visible');
									}
								}, i*10000);
							})(i);							
						}	
					},
					error: function(response)
					{
						alert("Error2");
					},
				}).done(function (result) 
				{
				});
			}
			else
			{		
				$.ajax({
					url: "<?php echo base_url(); ?>index.php/Report11/getTotal2?month1="+(m1+1)+"&month2="+(m2+1)+"&id_dist="+selected3.toString()+"&year2="+y2+"&year1="+y1+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime,
						type: "GET",
						timeout:1200000,
						dataType: "text",
						headers: {
							 'Cache-Control': 'no-cache, no-store, must-revalidate', 
							 'Pragma': 'no-cache', 
							 'Expires': '0'
						   },
						cache:false,
					success: function(response)
					{
						$("#apply_date2").addClass('disabled');
						for (var i=0;i<50;++i)
						{	
							(function (x) 
							{
								setTimeout(function()
								{ 
									$.ajax({
										url:"<?php echo base_url(); ?>assets/uploads/SummaryReportNonActiveOutlet.txt",
										type:'GET',
										error: function()
										{
										},
										success: function(response)
										{
											is_exist2 = 1;
											$("#apply_date2").removeClass('disabled');
											$("#table").html(response);
										}
									});
									if(progress<100)
									{
										progress = progress + 1;
										$('#loading').text('Progress : '+progress+'%.');
										$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
									}	
									if(is_exist2==1 && progress<100)
									{
										i = 51;
										progress = 100;
										$('#loading').text('Progress : '+progress+'%.');
										$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
										if(progress==100)
										{	
											end = Date.now();
											$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
											swal.close();
										}	
										$('#excel2').css('visibility', 'visible');
									}
								}, i*10000);
							})(i);							
						}	
					},
					error: function(response)
					{
						alert("Error2");
					},
				}).done(function (result) 
				{
				});
			}


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

		$('#excel').click(function(e){
		});


      apply_date.onclick = function() 
      {
			progress = 0;
			$('#excel').css('visibility', 'hidden');
			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());
      }

      apply_date2.onclick = function() 
      {
			progress = 0;
			$("#table").html("");
			$('#excel2').css('visibility', 'hidden');
			createChannel2($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());
      }

		$('#excel2').click(function(e){
					var wb = XLSX.utils.table_to_book(document.getElementById('table'), {sheet:"Summary Non Active Outlet"});
					var pad = "00";
					var m1pad = ""+(m1+1);
					var m2pad = ""+(m2+1);
					var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
					function s2ab(s) { 
								var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
								var view = new Uint8Array(buf);  //create uint8array as viewer
								for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
								return buf;    
					}
					saveAs(new Blob([s2ab(wbout)],{type:"application/vnd.ms-excel;charset=utf-8"}), 'Summary Non Active Outlet ['+y1+'-'+pad.substring(0, pad.length - m1pad.length) + m1pad+' to '+y2+'-'+pad.substring(0, pad.length - m2pad.length) + m2pad+'].xlsx');
		});


		$('#start_date').datepicker().on('changeDate', function(e) {
			$('#loading').text('Progress : 0%.');
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
			var start_date = e.format(0, "mm/yyyy").split("/");
			m1 = start_date[0];
			m1 = Number(m1).toString();
			m1 = parseInt(m1,0)-1;
			y1 = start_date[1];
		});

		$('#end_date').datepicker().on('changeDate', function(e) {
			$('#loading').text('Progress : 0%.');
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
			var end_date = e.format(0, "mm/yyyy").split("/");
			m2 = end_date[0];
			m2 = Number(m2).toString();
			m2 = parseInt(m2,0)-1;
			y2 = end_date[1];
		});


/*var canvas = document.getElementById("mychart");
var context = canvas.getContext('2d');
var dragging = false;
var lastX;
var marginLeft = 0;


canvas.addEventListener('mousedown', function(e) {
    var evt = e || event;
    dragging = true;
    lastX = evt.clientX;
    e.preventDefault();
}, false);

window.addEventListener('mousemove', function(e) {
    var evt = e || event;
    if (dragging) {
        var delta = evt.clientX - lastX;
        lastX = evt.clientX;
        marginLeft += delta;
        canvas.style.marginLeft = marginLeft + "px";
    }
    e.preventDefault();
}, false);

window.addEventListener('mouseup', function() {
    dragging = false;
}, false);*/


</script>
</html>

