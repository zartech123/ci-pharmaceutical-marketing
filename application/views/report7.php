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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
	<script src="//cdn.jsdelivr.net/npm/file-saver@2.0.2/dist/FileSaver.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/Blob.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chartjs-plugin-datalabels.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css"/>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.tree-multiselect.min.css">
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.1.0/bootstrap-4.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/jquery.tree-multiselect.min.js"></script>

	</head>
<body>
    <div class="container-fluid">
		<table width="100%">
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr><td colspan="12"><center><div class="table-label" style="font-size:14px">&nbsp;<b>Summary</b></div></center></td></tr>
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr>
				<td width="60px" style="font-size:14px">&nbsp;Start :&nbsp;</td>
				<td><input class="form-control input-sm" type="text" id="start_date" name="start_date" style="width:70px" placeholder="Start Date"/></td>
				<td width="50px" style="font-size:14px">&nbsp;End :&nbsp;</td>
				<td width="80px" ><input class="form-control input-sm" type="text" id="end_date" name="end_date" style="width:70px" placeholder="End Date"/></td>
				<td>&nbsp;</td>
				<td><button type="button" id="apply_date" class="btn btn-info btn-sm">Generate Report</button></td>
				<td>&nbsp;</td>
				<td><a id="url" download="filename.png" style="visibility:hidden"><i class="fa fa-bar-chart fa-border" style="font-size:21px"></i></a>&nbsp;<a id="excel" style="visibility:hidden;cursor:pointer"><i class="fa fa-file-text-o fa-border" style="font-size:21px"></i></a></td>
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
							$query2 = $this->db->query("SELECT id_dist, code from distributor where id_dist  not in (1,7) order by code");
							foreach ($query2->result() as $row2)
							{	
						
						   ?>		
							<option value="<?php echo $row2->id_dist; ?>" data-section="Distributor" selected data-index="1"><?php echo $row2->code; ?></options>									
						<?php } ?>
					</select>
				</td>
				<td style="vertical-align:top">
					<select id="id_product" multiple="multiple">
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
				</td>
			</tr>
			<tr><td colspan=12><hr></td></tr>
		</table>
		<table cellpadding="0" cellspacing="0" style="font-size:13px;border-spacing:0px">
			<div><span id="loading">Progress : 0%</span></div>
			<div class="progress">
			  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0"
			  aria-valuemin="0" aria-valuemax="100" style="width:0%">
				<span class="sr-only">70% Complete</span>
			  </div>
			</div>
		</table>
		<div style="overflow: auto">
		<table cellpadding="0" cellspacing="0" style="font-size:13px;border-spacing:0px">
			<div id="table"></div>
		</table>
		<!--tr><td colspan="2" style="text-align:center;"><button type="button" class="btn btn-info" style="width:170px"><div id="year1"></div></button></td>
		<td colspan="<?php echo "14"; ?>" style="text-align:center;"><button id="buttonyear" type="button" class="btn btn-info" style="width:<?php echo $width; ?>"><div id="year2"></div></button></td><td style="text-align:center;"></td><td style="text-align:center;"></td></tr-->
		<br>
		</div>
		<br>
		<div style="overflow: auto">
		<table cellpadding="0" cellspacing="0" style="font-size:13px;border-spacing:0px">
			<div id="table2"></div>
		</table>
		</div>
		<br>
		<br>
		<table width="100%">
		<tr><td><div id="chart" style="overflow:hidden"><canvas id="mychart2"></canvas></div></td></tr>																	
		</table>
		<br>
		<!--table width="100%">
		<tr>
		<td><iframe id="iframe1" frameBorder="0" src="<?php echo base_url(); ?>index.php/Report4?menu=0" style="height:600px;width:100%;overflow:hidden;"></iframe></td>
		</tr>
		</table-->		
		<br><br><br>
	</div>
</body>
<style type="text/css">
#chart {
  height:60vh;
}
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
	var progress = 0;
	var is_exist = 0;
	var chartData2 = "";
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
				url: "<?php echo base_url(); ?>index.php/Report3/getDistributor",
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
//			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());
//			alert("something changed!");
		}

		function channelOnChange(allSelectedItems, addedItems, removedItems) 
		{
			$('#loading').text('Progress : 0%');
//			alert($("#id_channel").val());
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
//			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());
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


		function createChannel2(selected,selected2,selected3)
		{
			var date = new Date();
			var content = "";
				content = content + "<tr><td style='text-align:center;'></td>";
				for(var i = y1; i <= y2; i++)
				{
					if(y2==y1)
					{
						content = content + '<td colspan="'+(m2-m1+1)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+((m2-m1+1)*70)+'px">'+i+'</button></td>';
					}
					else
					{	
						if(i==y1)
						{
							content = content + '<td colspan="'+(12-m1)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+((12-m1)*70)+'px">'+i+'</button></td>';
						}	
						else if(i==y2)
						{	
							content = content + '<td colspan="'+(m2+1)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+((m2+1)*70)+'px">'+i+'</button></td>';
						}	
						else
						{	
							content = content + '<td colspan="12" style="text-align:center;"><button type="button" class="btn btn-info" style="width:840px">'+i+'</button></td>';
						}	
					}	
				}
				content = content + '</tr><tr>';
				content = content + '<td style="text-align:center"><button type="button" class="btn btn-danger">Trend Outlet Covered</button></td>';
				var month = ["Ytd Jan", "Ytd Feb", "Ytd Mar", "Ytd Apr", "Ytd May", "Ytd Jun", "Ytd Jul", "Ytd Aug", "Ytd Sept", "Ytd Oct", "Ytd Nov", "Ytd Dec"];
				for(var j = y1; j <= y2; j++)
				{
					if(y2==y1)
					{
							for(var i = m1+1;i<=m2+1;i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:70px;">'+month[i-1]+'</button></td>';
							}
					}
					else
					{	
						if(j==y1)
						{	
							for(var i = m1+1;i<=12;i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:70px;">'+month[i-1]+'</button></td>';
							}
						}	
						else if(j==y2)
						{	
							for(var i = 1;i<=(m2+1);i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:70px;">'+month[i-1]+'</button></td>';
							}
						}	
						else
						{	
							for(var i = 1;i<=12;i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:70px;">'+month[i-1]+'</button></td>';
							}
						}	
					}	
//					content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:90px">TOTAL</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:95px">AVERAGE</button></td>';
				}	
				content = content + '</tr>';

			selected3.sort();

				var l = 0;
				var m = 0;
				var monthbutton = "";
//				var	monthtotalbutton = "";
//				var	monthavgbutton = "";
				for(var k = 0; k < selected3.length; k++)
				{
					m = k;
					content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">'+distributor[selected3[k]-1]+'</button></td>';

					for(var i = y1; i <= y2; i++)
					{
						if(y2==y1)
						{
								for(var j = m1+1;j<=m2+1;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:70px;"></button></td>';
									l = l + 1;
								}
						}
						else
						{	
							if(i==y1)
							{
								for(var j = m1+1;j<=12;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
							else if(i==y2)
							{	
								for(var j = 1;j<=(m2+1);j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
							else
							{	
								for(var j = 1;j<=12;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
						}	
//						monthtotalbutton = "monthtotalbutton-"+m;
//						monthavgbutton = "monthavgbutton-"+m;
//						content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-default" style="width:90px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-default" style="width:95px"></button></td>';
						m = m + (selected3.length + 1);
					}	
					content = content + '</tr>';
				}
				content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">TOTAL</button></td>';

					m = selected3.length;
					for(var i = y1; i <= y2; i++)
					{
						if(y2==y1)
						{
								for(var j = m1+1;j<=m2+1;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-primary" style="width:70px;"></button></td>';
									l = l + 1;
								}
						}
						else
						{	
							if(i==y1)
							{	
								for(var j = m1+1;j<=12;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-primary" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
							else if(i==y2)
							{	
								for(var j = 1;j<=(m2+1);j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-primary" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
							else
							{	
								for(var j = 1;j<=12;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-primary" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
						}	
//						monthtotalbutton = "monthtotalbutton-"+m;
//						monthavgbutton = "monthavgbutton-"+m;
//						content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-success" style="width:90px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-warning" style="width:95px"></button></td>';
						m = m + (selected3.length + 1);
					}	
					content = content + '</tr>';
//					$('#loading').text('Progress : 40%. Please wait');
//					$('.progress-bar').css('width', 40+'%').attr('aria-valuenow', 40);

			$("#table2").html(content);
		
		}

		function createChannel(selected,selected2,selected3)
		{
			var date = new Date();
			Swal.fire({
				title: '',
				html: '<span style="font-size:14px">Please wait...</span>'
			});
			swal.showLoading();
			start = Date.now();
			var content = "";
				content = content + "<tr><td style='text-align:center;'></td>";
				for(var i = y1; i <= y2; i++)
				{
					if(y2==y1)
					{
						content = content + '<td colspan="'+(m2-m1+3)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+(190+(m2-m1+1)*70)+'px">'+i+'</button></td>';
					}
					else
					{		
						if(i==y1)
						{
							content = content + '<td colspan="'+(12-m1+2)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+(190+(12-m1)*70)+'px">'+i+'</button></td>';
						}	
						else if(i==y2)
						{	
							content = content + '<td colspan="'+(m2+3)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+(190+(m2+1)*70)+'px">'+i+'</button></td>';
						}	
						else
						{	
							content = content + '<td colspan="14" style="text-align:center;"><button type="button" class="btn btn-info" style="width:1030px">'+i+'</button></td>';
						}	
					}	
				}
				content = content + '</tr><tr>';
				content = content + '<td style="text-align:center"><button type="button" class="btn btn-danger">Trend Active Outlet</button></td>';
				var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
				for(var j = y1; j <= y2; j++)
				{
					if(y2==y1)
					{
							for(var i = m1+1;i<=m2+1;i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:70px;">'+month[i-1]+'</button></td>';
							}
					}
					else
					{	
						if(j==y1)
						{	
							for(var i = m1+1;i<=12;i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:70px;">'+month[i-1]+'</button></td>';
							}
						}	
						else if(j==y2)
						{	
							for(var i = 1;i<=(m2+1);i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:70px;">'+month[i-1]+'</button></td>';
							}
						}	
						else
						{	
							for(var i = 1;i<=12;i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:70px;">'+month[i-1]+'</button></td>';
							}
						}	
					}	
					content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:90px">TOTAL</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:95px">AVERAGE</button></td>';
				}	
				if(y1<y2)
				{	
					content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:90px">GROWTH</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:95px">GAP</button></td>';
				}	
				content = content + '</tr>';

			selected3.sort();

				var l = 0;
				var m = 0;
				var monthbutton = "";
				var	monthtotalbutton = "";
				var	monthavgbutton = "";
				var monthgrowthbutton = "";
				var monthgapbutton = "";
				for(var k = 0; k < selected3.length; k++)
				{
//					m = k;
					content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">'+distributor[selected3[k]-1]+'</button></td>';

					for(var i = y1; i <= y2; i++)
					{
						if(y2==y1)
						{
								for(var j = m1+1;j<=m2+1;j++)
								{
									monthbutton = "monthbutton-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:70px;"></button></td>';
									l = l + 1;
								}
						}
						else
						{	
							if(i==y1)
							{
								for(var j = m1+1;j<=12;j++)
								{
									monthbutton = "monthbutton-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
							else if(i==y2)
							{	
								for(var j = 1;j<=(m2+1);j++)
								{
									monthbutton = "monthbutton-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
							else
							{	
								for(var j = 1;j<=12;j++)
								{
									monthbutton = "monthbutton-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
						}	
						monthtotalbutton = "monthtotalbutton-"+m;
						monthavgbutton = "monthavgbutton-"+m;
						content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-default" style="width:90px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-default" style="width:95px"></button></td>';
//						m = m + (selected3.length + 1);
						m = m + 1;
					}	
					monthgrowthbutton = "monthgrowthbutton-"+k;
					monthgapbutton = "monthgapbutton-"+k;
					if(y1<y2)
					{	
						content = content + '<td><button type="button" id="'+monthgrowthbutton+'" class="btn btn-default" style="width:90px"></button></td><td><button type="button" id="'+monthgapbutton+'" class="btn btn-default" style="width:95px"></button></td>';
					}	
					content = content + '</tr>';
				}
				content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">TOTAL</button></td>';
//					m = selected3.length;
					for(var i = y1; i <= y2; i++)
					{
						if(y2==y1)
						{
								for(var j = m1+1;j<=m2+1;j++)
								{
									monthbutton = "monthbutton-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-primary" style="width:70px;"></button></td>';
									l = l + 1;
								}
						}
						else
						{	
							if(i==y1)
							{	
								for(var j = m1+1;j<=12;j++)
								{
									monthbutton = "monthbutton-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-primary" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
							else if(i==y2)
							{	
								for(var j = 1;j<=(m2+1);j++)
								{
									monthbutton = "monthbutton-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-primary" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
							else
							{	
								for(var j = 1;j<=12;j++)
								{
									monthbutton = "monthbutton-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-primary" style="width:70px;"></button></td>';
									l = l + 1;
								}
							}	
						}	
						monthtotalbutton = "monthtotalbutton-"+m;
						monthavgbutton = "monthavgbutton-"+m;
						content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-success" style="width:90px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-warning" style="width:95px"></button></td>';
//						m = m + (selected3.length + 1);
						m = m + 1;
					}	
					monthgrowthbutton = "monthgrowthbutton-"+(selected3.length);
					monthgapbutton = "monthgapbutton-"+(selected3.length);
					if(y1<y2)
					{	
						content = content + '<td><button type="button" id="'+monthgrowthbutton+'" class="btn btn-success" style="width:90px"></button></td><td><button type="button" id="'+monthgapbutton+'" class="btn btn-warning" style="width:95px"></button></td>';
					}
					content = content + '</tr>';

			$("#table").html(content);
//			$('#loading').text('Progress : 20%. Please wait');
//			$('.progress-bar').css('width', 20+'%').attr('aria-valuenow', 20);


			createChannel2($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());

			var currentTime = new Date().getTime();
			

			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report3/getTotal3?month1="+(m1+1)+"&month2="+(m2+1)+"&id_dist="+selected3.toString()+"&year2="+y2+"&year1="+y1+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime,
					timeout:1200000,
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
					var result2 = response.split("|");
					var result = result2[0].replace('/.00/g','').split(";");
					var i = 0;
					var monthbutton = "";
					for(i=0;i<result.length;i++)
					{
						monthbutton = "#monthbutton-"+i;
						$(monthbutton).text(result[i]);
					}

					result = result2[1].replace('/.00/g','').split(";");
					var monthtotalbutton = "";
					var monthavgbutton = "";
//					alert(response);
					for(i=0;i<result.length;i+=2)
					{
						monthtotalbutton = "#monthtotalbutton-"+(i/2);
						monthavgbutton = "#monthavgbutton-"+(i/2);
						if(parseInt(result[i])<0)
						{	
							$(monthtotalbutton).removeClass("btn btn-default").addClass('btn btn-danger');
						}	
						if(parseInt(result[i+1])<0)
						{	
							$(monthavgbutton).removeClass("btn btn-default").addClass('btn btn-danger');
						}	
						$(monthtotalbutton).text(result[i]);
						$(monthavgbutton).text(result[i+1]);
					}
					
					//chartData2 = result2[2];
					chartData2 = result2[2].substring(0, result2[2].length - 2)+",";
//					alert(chartData2);
					//generate(selected,selected3,selected2,result2[2]);
				},
				error: function(response)
				{
							alert("error1");
				},
			}).done(function (result) 
			{
				progress = progress + 25;
				$('#loading').text('Progress : '+progress+'%.');
				$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
			});

			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report3/getTotal2?month2="+(m2+1)+"&month1="+(m1+1)+"&id_dist="+selected3.toString()+"&year1="+y1+"&year2="+y2+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime,
					timeout:1200000,
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
					var result = response.replace('/.00/g','').split(";");
					var i = 0;
					var j = 0;
					var monthgrowthbutton = "";
					var monthgapbutton = "";
					for(i=0;i<(result.length/2);i++)
					{
						monthgrowthbutton = "#monthgrowthbutton-"+i;
						if(parseInt(result[i])<0)
						{	
							$(monthgrowthbutton).removeClass("btn btn-default").addClass('btn btn-danger');
						}	
						$(monthgrowthbutton).text(result[i]);		
					}
					for(i=(result.length/2);i<result.length;i++)
					{
						monthgapbutton = "#monthgapbutton-"+j;
						if(parseInt(result[i])<0)
						{	
							$(monthgapbutton).removeClass("btn btn-default").addClass('btn btn-danger');
						}	
						$(monthgapbutton).text(result[i]);
						j = j + 1;
					}
				},
				error: function(response)
				{
					alert("Error 2");
				},
			}).done(function (result) 
			{
				progress = progress + 25;
				$('#loading').text('Progress : '+progress+'%.');
				$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
			});

			/*$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report3/getTotal?id_channel="+selected.toString()+"&id_dist="+selected3.toString()+"&year1="+y1+"&year2="+y2+"&month1="+(m1+1)+"&month2="+(m2+1)+"&id_product="+selected2.toString()+"&date="+currentTime,
					timeout:90000,
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
					var result = response.replace('/.00/g','').split(";");
					var i = 0;
					var monthtotalbutton = "";
					var monthavgbutton = "";
//					alert(response);
					for(i=0;i<result.length;i+=2)
					{
						monthtotalbutton = "#monthtotalbutton-"+(i/2);
						monthavgbutton = "#monthavgbutton-"+(i/2);
						if(parseInt(result[i])<0)
						{	
							$(monthtotalbutton).removeClass("btn btn-default").addClass('btn btn-danger');
						}	
						if(parseInt(result[i+1])<0)
						{	
							$(monthavgbutton).removeClass("btn btn-default").addClass('btn btn-danger');
						}	
						$(monthtotalbutton).text(result[i]);
						$(monthavgbutton).text(result[i+1]);
					}
				},
				error: function(response)
				{
					alert("Error 3");
				},
			}).done(function (result) 
			{



			});*/

				$.ajax({
					url: "<?php echo base_url(); ?>index.php/Report4/getTotal4?month1="+(m1+1)+"&month2="+(m2+1)+"&id_dist="+selected3.toString()+"&year2="+y2+"&year1="+y1+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime,
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
						var i = 0;
						for (i=0;i<25;++i)
						{	
							(function (x) 
							{
								setTimeout(function()
								{ 
									$.ajax({
										url:"<?php echo base_url(); ?>assets/uploads/ReportOutletCovered.txt",
										type:'HEAD',
										error: function()
										{
											is_exist = 0;
										},
										success: function()
										{
											is_exist = 1;
											$("#apply_date").removeClass('disabled');
										}
									});
									if(progress<75)
									{	
										progress = progress + 1;
										$('#loading').text('Progress : '+progress+'%.');
										$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
									}	
									if(is_exist==1 && progress<75)
									{
										//alert(i);
										$.ajax({
											url:"<?php echo base_url(); ?>assets/uploads/ReportOutletCovered.txt",
											type:'GET',
											error: function()
											{
											},
											success: function(response)
											{
												var result2 = response.split("|");
												var result = result2[0].replace('/.00/g','').split(";");
												var y = 0;
												var monthbutton = "";
												for(y=0;y<result.length;y++)
												{
													monthbutton = "#monthbutton4-"+y;
													$(monthbutton).text(result[y]);
												}
												progress = 75;
												$('#loading').text('Progress : '+progress+'%.');
												$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
												var result3 = result2[1].split("\"datasets\"");
												var result4 = result3[1].substring(3);
//												console.log(chartData2+result4);
//												var result5 = result4.substring(0, result4.length - 2);
//												alert(chartData2+"\",datasets"+result3[1]);
												generate(selected,selected3,selected2,chartData2+result4);
											}
										});
										i = 26;
									}
								}, i*10000);
							}
							//return i;
							)(i);
						}	
						
					},
					error: function(response)
					{
						alert("Error2");
					},
				}).done(function (result) 
				{					
				});

//			generate(selected,selected3,selected2);

		}

		var myChart2;  
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
					var workbook = XLSX.utils.book_new();
					var ws1 = XLSX.utils.table_to_sheet(document.getElementById('table'));
					XLSX.utils.book_append_sheet(workbook, ws1, "Trend Active Outlet");
					var ws2 = XLSX.utils.table_to_sheet(document.getElementById('table2'));
					XLSX.utils.book_append_sheet(workbook, ws2, "Trend Outlet Covered");
					var pad = "00";
					var m1pad = ""+(m1+1);
					var m2pad = ""+(m2+1);
					var wbout = XLSX.write(workbook, {bookType:'xlsx',  type: 'binary'});
					function s2ab(s) { 
								var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
								var view = new Uint8Array(buf);  //create uint8array as viewer
								for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
								return buf;    
					}
					saveAs(new Blob([s2ab(wbout)],{type:"application/vnd.ms-excel;charset=utf-8"}), 'Summary ['+y1+'-'+pad.substring(0, pad.length - m1pad.length) + m1pad+' to '+y2+'-'+pad.substring(0, pad.length - m2pad.length) + m2pad+'].xlsx');
		});

      apply_date.onclick = function() 
      {
			progress = 0;
			$('#chart').css('visibility', 'hidden');
			$('#url').css('visibility', 'hidden');
			$('#excel').css('visibility', 'hidden');
			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val());
			$('#iframe1').attr('src', '<?php echo base_url(); ?>index.php/Report4?menu=0&y1='+y1+'&y2='+y2+'&m1='+m1+'&m2='+m2+'&id_channel='+$("#id_channel").val()+'&id_dist='+$("#id_dist").val()+'&id_product='+$("#id_product").val());
      }


		$('#start_date').datepicker().on('changeDate', function(e) {
			$('#loading').text('Progress : 0%. Please wait');
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
			var start_date = e.format(0, "mm/yyyy").split("/");
			m1 = start_date[0];
			m1 = Number(m1).toString();
			m1 = parseInt(m1,0)-1;
			y1 = start_date[1];
		});

		$('#end_date').datepicker().on('changeDate', function(e) {
			$('#loading').text('Progress : 0%. Please wait');
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

function done()
{
	
	var url = myChart2.toBase64Image();
	$("#url").attr('href',url);
	$("#url").attr('download','Summary.png');

}

function generate(selected,selected3,selected2,response)
{

	var currentTime = new Date().getTime();


			/*$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report7/getData?id_channel="+selected.toString()+"&id_dist="+selected3.toString()+"&id_product="+selected2.toString()+"&year1="+y1+"&year2="+y2+"&month1="+(m1+1)+"&month2="+(m2+1)+"&date="+currentTime,
					type: "GET",
					dataType: "text",
					headers: {
						 'Cache-Control': 'no-cache, no-store, must-revalidate', 
						 'Pragma': 'no-cache', 
						 'Expires': '0'
					   },
					cache:false,
				success: function(data)
				{*/
//					alert(data);
				   var chartData = jQuery.parseJSON('' + response + '');
					//var lengthcanvas = chartData['labels'].length * 60;
					//$("#chart2").css("width", lengthcanvas);

					var chartOptions = {
						animation: {
							onComplete: done
						},	
						responsive: true,
						maintainAspectRatio: false,
legend: {
	position: "bottom",
    labels: {
      /* filter */
      filter: function(legendItem, data) {
        /* filter already loops throw legendItem & data (console.log) to see this idea */
        //var currentDataValue =  data.datasets[0].data[index];
        //console.log("current value is: " + currentDataValue)
        if (legendItem.datasetIndex > 6)
        {
          return false; //only show when the label is cash
        }
		return true;
      }
	}
},	

						/*legend: {
							position: "bottom"
						},*/
		//                centertext: 'Total : ' + total + ' Miliar',
						title: {
							display: true,
							text: 'Summary'
						},
						tooltips: {
									callbacks: {
										label: function(tooltipItem, data) {

											let label = data.labels[tooltipItem.index];
											let value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
											return ' ' + label + ': ' + numeral(value).format('0,0.00');

										}
									}
								},						
						plugins: {
							datalabels: {
								display: false,
								formatter: (value, ctx) => {

									var datasets = ctx.chart.data.datasets;
									if (value == 0) value = '';
									return value;
								},
								color: function(context) {
									var index = context.dataIndex;
									var value = context.dataset.data[index];
									return 'white';
								},
								align: 'middle',
								font: {
									size: "10"
								}
							}
						},
						scales: {
							yAxes: [{
								stacked: false,
								id: "bar-stacked",
								position: 'right',
								scaleLabel: {
									display: true,
									labelString: 'Trend Active Outlet (Bar)'
								},
//								display: false,
								ticks: {
									callback: function(label, index, labels) {
										return numeral(label).format('0,0');
									},
									beginAtZero: true
								},
								//type: 'linear'
							},
							{
								stacked: false,
								id: "line-stacked",
								position: 'left',
								gridLines: {
									display:false
								},
								scaleLabel: {
									display: true,
									labelString: 'Trend Outlet Covered (Line)'
								},
								ticks: {
									callback: function(label, index, labels) {
										return numeral(label).format('0,0');
									},
									beginAtZero: true
								}
							}
							],
							xAxes: [{
								stacked: false,
								scaleLabel: {
									display: true,
									labelString: 'Month'
								}
							}]
						}
					}

					if (myChart2) {
						myChart2.destroy();
					}

					myChart2 = new Chart(document.getElementById("mychart2"), {
						type: 'bar',
						data: chartData,
						options: chartOptions
					});

				/*},
				error: function(response)
				{
				},
			}).done(function (result) 
			{*/
				progress = progress + 25;
				$('#loading').text('Progress : '+progress+'%.');
				$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
				if(progress==100)
				{	
					end = Date.now();
					$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
					swal.close();
				}	
			//});
			$('#chart').css('visibility', 'visible');
			$('#url').css('visibility', 'visible');
}
</script>
</html>

