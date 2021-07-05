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
	<script src="<?php echo base_url(); ?>assets/js/Chart.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chartjs-plugin-datalabels.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css"/>
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.1.0/bootstrap-4.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.tree-multiselect.min.css">

    <script src="<?php echo base_url(); ?>assets/js/jquery.tree-multiselect.min.js"></script>

	</head>
<body>
    <div class="container-fluid">
		<table width="100%">
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr><td colspan="12"><center><div class="table-label" style="font-size:14px">&nbsp;<b>After Redistribution Sales</b></div></center></td></tr>
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr>
				<td width="60px" style="font-size:14px">&nbsp;Start :&nbsp;</td>
				<td><input class="form-control input-sm" type="text" id="start_date" name="start_date" style="width:70px" placeholder="Start Date"/></td>
				<td width="50px" style="font-size:14px">&nbsp;End :&nbsp;</td>
				<td width="80px" ><input class="form-control input-sm" type="text" id="end_date" name="end_date" style="width:70px" placeholder="End Date"/></td>
				<td>
					<select id="type" class="form-control input-sm" style="width:120px">
						<option value="1" data-section="Channel" selected>Quantity</options>									
						<option value="2" data-section="Channel">Gross Sales</options>									
					</select>				
				</td>
				<td>&nbsp;</td>
				<td><button type="button" id="apply_date" class="btn btn-info btn-sm">Generate Report</button>
				</td>
				<td><a id="url" download="filename.png" style="visibility:hidden"><i class="fa fa-bar-chart fa-border" style="font-size:21px"></i></a>&nbsp;<a id="excel" style="visibility:hidden;cursor:pointer"><i class="fa fa-file-text-o fa-border" style="font-size:21px;"></i></a></td>
			</tr>
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr>
				<td colspan="5" style="vertical-align:top" width="26%">
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
							$query2 = $this->db->query("SELECT id_dist, code from distributor where id_dist not in (1,7) order by code");
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
 			<div class="input-group" style="visibility:hidden">
				<label for="fun" class="col-xs-3 control-label text-right">Scale</label>
				<div class="col-xs-9">
   				<div id="scaleBtn" class="btn-group">
   					<a class="btn btn-primary btn-sm active" data-toggle="scale" data-title="0">1</a>
                    <a class="btn btn-primary btn-sm notActive" data-toggle="scale" data-title="3">1 K</a>
   					<a class="btn btn-primary btn-sm notActive" data-toggle="scale" data-title="6">1 M</a>
   					<a class="btn btn-primary btn-sm notActive" data-toggle="scale" data-title="9">1 B</a>
   				</div>				
   				<input type="hidden" name="scale" id="scale">				
				</div>
 			</div>
			<br>
		<div style="overflow: auto">
		<table cellpadding="0" cellspacing="0" style="font-size:13px;border-spacing:0px">
			<div id="table"></div>
		</table>
		<!--tr><td colspan="2" style="text-align:center;"><button type="button" class="btn btn-info" style="width:170px"><div id="year1"></div></button></td>
		<td colspan="<?php echo "14"; ?>" style="text-align:center;"><button id="buttonyear" type="button" class="btn btn-info" style="width:<?php echo $width; ?>"><div id="year2"></div></button></td><td style="text-align:center;"></td><td style="text-align:center;"></td></tr-->
		<br>
		</div>
		<br><br>
		<table width="100%">
		<tr><td><div id="chart" style="overflow:hidden"><canvas id="mychart2"></canvas></div></td></tr>																	
        <input type="hidden" id="name_product3" name="name_product3" value="">
        <input type="hidden" id="response3" name="response3" value="">
        <input type="hidden" id="response2" name="response2" value="">
        <input type="hidden" id="response" name="response" value="">
		</table>
		<br><br><br>
	</div>
</body>
<style type="text/css">
#chart {
  height:80vh;
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
var scale = "0";
$('#scaleBtn a').on('click', function(){
    var sel = $(this).data('title');
    var tog = $(this).data('toggle');
    $('#'+tog).prop('value', sel);
//	var diff = parseInt($('#'+tog).prop('value'))-parseInt(scale);
	scale = $('#'+tog).prop('value');

	if(scale=='3')
	{
		$('#scaleText').text('in Thousand (IDR)');
	}		
 	else if(scale=='6')
	{
		$('#scaleText').text('in Million (IDR)');
	}		
 	else if(scale=='9')
	{
		$('#scaleText').text('in Billion (IDR)');
	}		
 	else
	{
		$('#scaleText').text('in (IDR)');
	}		
    
	createResponse3($('#response3').val(),scale);	
	createResponse2($('#response2').val(),scale);	
	createResponse($('#response').val(),scale);	
    $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
    $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
})

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
//		createChannel(selectedChannel,$("#id_product").val(),$("#id_dist").val());

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
		
		function createChannel(selected,selected2,selected3,type)
		{
			start = Date.now();
			Swal.fire({
				title: '',
				html: '<span style="font-size:14px">Please wait...</span>'
			});
			swal.showLoading();
			var channel = ['1 HOSPITAL', '2 PHARMACY', '3 DRUGSTORE', '4 INSTITUTION', '5 MTC', '6 PHARMA CHAIN', '7 GT & OTHERS', '8 PBF'];
			var date = new Date();
			var content = "";

			if(y1==y2 && y2==date.getFullYear() && m1<m2)
			{
				content = content + "<tr><td id='scaleText' style='text-align:center;'>in (IDR)</td>";
				content = content + '<td colspan="'+(m2-m1+3)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+(260+(m2-m1+1)*130)+'">'+y2+'</button></td>';
				content = content + '</tr><tr>';
				content = content + '<td style="text-align:center"><button type="button" class="btn btn-danger">After Redistribution Sales</button></td>';
				var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
				for(var i = (m1+1);i<=(m2+1);i++)
				{
					content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:130px;">'+month[i-1]+'</button></td>';
				}
				content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:130px">TOTAL</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:130px">AVERAGE</button></td>';
//				content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:130px">GROWTH</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:130px">GAP</button></td>';
				content = content + '</tr>';
			}
			else if(y2==date.getFullYear() && y1<y2)
			{
				content = content + "<tr><td style='text-align:center;'></td>";
				for(var i = y1; i <= (y2-1); i++)
				{
					content = content + '<td colspan="2" style="text-align:center;"><button type="button" class="btn btn-info" style="width:260px">'+i+'</button></td>';
				}
				content = content + '<td colspan="'+(m2+3)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+(260+(m2+1)*130)+'">'+y2+'</button></td>';
				content = content + '</tr><tr>';
				content = content + '<td style="text-align:center"><button type="button" class="btn btn-danger">After Redistribution Sales</button></td>';
				var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
				for(var i = y1; i <= (y2-1); i++)
				{
					//for(var j = 1;j<=12;j++)
					{
						//monthtitle = "monthtitle-"+i+"-"+j;
//						content = content + '<td style="text-align:center;display:inline-block;width:0px;padding:0px" name="'+monthtitle+'">xxxxxx</td>';
					}
					content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:130px">TOTAL</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:130px">AVERAGE</button></td>';
				}
				for(var i = 1;i<=(m2+1);i++)
				{
					content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:130px;">'+month[i-1]+'</button></td>';
				}
				content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:130px">TOTAL</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:130px">AVERAGE</button></td>';
				content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:130px">GROWTH</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:130px">GAP</button></td>';
				content = content + '</tr>';
			}
			else if(y2<date.getFullYear() && y1<=y2)
			{
				var monthtitle = "";			
				content = content + "<tr><td style='text-align:center;'></td>";
				for(var i = y1; i <= y2; i++)
				{
					content = content + '<td colspan="2" style="text-align:center;"><button type="button" class="btn btn-info" style="width:260px">'+i+'</button></td>';
				}	
				content = content + '</tr><tr>';
				content = content + '<td style="text-align:center"><button type="button" class="btn btn-danger">After Redistribution Sales</button></td>';
				for(var i = y1; i <= y2; i++)
				{
//					for(var j = 1;j<=12;j++)
					{
//						monthtitle = "monthtitle-"+i+"-"+j;
//						content = content + '<td style="text-align:center;visibility:" name="'+monthtitle+'"></td>';
					}
					content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:130px">TOTAL</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:130px">AVERAGE</button></td>';
				}	
				if(y1<y2)
				{	
					content = content + '<td style="text-align:center;"><button type="button" class="btn btn-success" style="width:130px">GROWTH</button></td><td style="text-align:center;"><button type="button" class="btn btn-warning" style="width:130px">GAP</button></td>';
				}	
				content = content + '</tr>';
			}			
			selected.sort();
			if(y1==y2 && y2==date.getFullYear() && m1<m2)
			{
				var k = 0;
				var l = 0;
				var monthbutton = "";
				var totalmonthbutton = "";
				var monthtotalbutton = "";
				var monthavgbutton = "";
				var monthgrowthbutton = "";
				var monthgapbutton = "";
				for(var i = 0; i < selected.length; i++)
				{
					content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">'+channel[selected[i]-1]+'</button></td>';

					for(var j = (m1+1);j<=(m2+1);j++)
					{
						monthbutton = "monthbutton-"+k;
						content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
						k = k + 1;
					}
					monthtotalbutton = "monthtotalbutton-"+l;
					monthavgbutton = "monthavgbutton-"+l;
					monthgrowthbutton = "monthgrowthbutton-"+l;
					monthgapbutton = "monthgapbutton-"+l;
					content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-default" style="width:130px"></button></td><td><button type="button" id="'+monthavgbutton+'" class="btn btn-default" style="width:130px"></button></td>';
//					content = content + '<td><button type="button" id="'+monthgrowthbutton+'" class="btn btn-default" style="width:130px"></button></td><td><button type="button" id="'+monthgapbutton+'" class="btn btn-default" style="width:130px"></button></td>';
					content = content + '</tr>';
					l = l + 1;
				}
				content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">TOTAL</button></td>';
				for(var j = (m1+1);j<=(m2+1);j++)
				{
					totalmonthbutton = "totalmonthbutton-"+k;
					content = content + '<td style="text-align:center;"><button id="'+totalmonthbutton+'" type="button" class="btn btn-primary" style="width:130px;"></button></td>';
					k = k + 1;
				}
				monthtotalbutton = "monthtotalbutton-"+l;
				monthavgbutton = "monthavgbutton-"+l;
				monthgrowthbutton = "monthgrowthbutton-"+l;
				monthgapbutton = "monthgapbutton-"+l;
				content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-success" style="width:130px"></button></td><td><button type="button" id="'+monthavgbutton+'" class="btn btn-warning" style="width:130px"></button></td>';
//				content = content + '<td><button type="button" id="'+monthgrowthbutton+'" class="btn btn-success" style="width:130px"></button></td><td><button type="button" id="'+monthgapbutton+'" class="btn btn-warning" style="width:130px"></button></td>';
				content = content + '</tr>';
			}	
			else if(y2==date.getFullYear() && y1<y2)
			{
				var k = 0;
				var l = 0;
				var n = 0;
				var monthbutton = "";
				var monthavgbutton = "";
				var monthtotalbutton = "";
				var monthgrowthbutton = "";
				var monthgapbutton = "";
				for(var i = 0; i < selected.length; i++)
				{
					content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">'+channel[selected[i]-1]+'</button></td>';

					n = 0;
					for(var j = y1; j <= (y2-1); j++)
					{
						monthtotalbutton = "monthtotalbutton-"+(n+l+i);
						monthavgbutton = "monthavgbutton-"+(n+l+i);
						content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-default" style="width:130px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-default" style="width:130px"></button></td>';
						n = n + 1;
					}
					for(var j = 1;j<=(m2+1);j++)
					{
						monthbutton = "monthbutton-"+k;
						content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
						k = k + 1;
					}
					monthtotalbutton = "monthtotalbutton-"+(n+l+i);
					monthavgbutton = "monthavgbutton-"+(n+l+i);
					monthgrowthbutton = "monthgrowthbutton-"+i;
					monthgapbutton = "monthgapbutton-"+i;
					content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-default" style="width:130px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-default" style="width:130px"></button></td>';
					content = content + '<td><button type="button" id="'+monthgrowthbutton+'" class="btn btn-default" style="width:130px"></button></td><td><button type="button" id="'+monthgapbutton+'" class="btn btn-default" style="width:130px"></button></td>';
					content = content + '</tr>';
					l = l + (y2-y1);
				}
				content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">TOTAL</button></td>';
				l = selected.length*(y2-y1+1);
				n = 0;
				for(var j = y1; j <= (y2-1); j++)
				{
					monthtotalbutton = "monthtotalbutton-"+(n+l);
					monthavgbutton = "monthavgbutton-"+(n+l);
					content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-success" style="width:130px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-warning" style="width:130px"></button></td>';
//					n = n + (selected.length+1);
					n = n + 1;
				}	
				for(var j = 1;j<=(m2+1);j++)
				{
					totalmonthbutton = "totalmonthbutton-"+k;
					content = content + '<td style="text-align:center;"><button id="'+totalmonthbutton+'" type="button" class="btn btn-primary" style="width:130px;"></button></td>';
					k = k + 1;
				}
				monthtotalbutton = "monthtotalbutton-"+(l+n);
				monthavgbutton = "monthavgbutton-"+(l+n);
				monthgrowthbutton = "monthgrowthbutton-"+i;
				monthgapbutton = "monthgapbutton-"+i;
				content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-success" style="width:130px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-warning" style="width:130px"></button></td>';
				content = content + '<td><button type="button" id="'+monthgrowthbutton+'" class="btn btn-success" style="width:130px"></button></td><td><button type="button" id="'+monthgapbutton+'" class="btn btn-warning" style="width:130px"></button></td>';
				content = content + '</tr>';
			}
			else if(y2<date.getFullYear() && y1<=y2)
			{
				var monthgrowthbutton = "";
				var monthgapbutton = "";
				var monthavgbutton = "";
				var monthtotalbutton = "";
				var n = 0;
				var l = 0;
				for(var i = 0; i < selected.length; i++)
				{
					content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">'+channel[selected[i]-1]+'</button></td>';

//					n = 0;
					for(var j = y1; j <= y2; j++)
					{
						monthtotalbutton = "monthtotalbutton-"+n;
						monthavgbutton = "monthavgbutton-"+n;
						content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-default" style="width:130px"></button></td><td><button type="button" id="'+monthavgbutton+'" class="btn btn-default" style="width:130px"></button></td>';
//						n = n + (selected.length+1);
						n = n + 1;
					}	
					if(y1<y2)
					{	
						monthgrowthbutton = "monthgrowthbutton-"+i;
						monthgapbutton = "monthgapbutton-"+i;
						content = content + '<td><button type="button" id="'+monthgrowthbutton+'" class="btn btn-default" style="width:130px"></button></td><td><button type="button" id="'+monthgapbutton+'" class="btn btn-default" style="width:130px"></button></td>';
					}	
					content = content + '</tr>';
				}
				content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">TOTAL</button></td>';
//				l = selected.length;
				l = selected.length*(y2-y1+1);
				n = 0;
				for(var i = y1; i <= y2; i++)
				{
					monthtotalbutton = "monthtotalbutton-"+(l+n);
					monthavgbutton = "monthavgbutton-"+(l+n);
					content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-success" style="width:130px"></button></td><td><button type="button" id="'+monthavgbutton+'" class="btn btn-warning" style="width:130px"></button></td>';
//					n = n + (selected.length+1);
					n = n + 1;
				}	
				if(y1<y2)
				{	
					monthgrowthbutton = "monthgrowthbutton-"+selected.length;
					monthgapbutton = "monthgapbutton-"+selected.length;
					content = content + '<td><button type="button" id="'+monthgrowthbutton+'" class="btn btn-success" style="width:130px"></button></td><td><button type="button" id="'+monthgapbutton+'" class="btn btn-warning" style="width:130px"></button></td>';
				}	
				content = content + '</tr>';
			}
			$("#table").html(content);
//			alert('xxx');
//			$('#loading').text('Progress : 20%.');
//			$('.progress-bar').css('width', 20+'%').attr('aria-valuenow', 20);

			var currentTime = new Date().getTime();
			
//			alert("<?php echo base_url(); ?>index.php/Report1/getTotal3?month="+(m2+1)+"&id_dist="+selected3.toString()+"&year="+y2+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime+"&type="+type);	

			if(y2>=y1)
			{	
				if(y2==date.getFullYear())
				{
					var month1=1;
					if(y2==y1)
					{
						month1 = (m1+1);
					}						
					$.ajax({
						url: "<?php echo base_url(); ?>index.php/Report1/getTotal3?month1="+month1+"&month2="+(m2+1)+"&id_dist="+selected3.toString()+"&year="+y2+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime+"&type="+type,
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
							$('#response3').val(response);
							createResponse3($('#response3').val(),0);
						},
						error: function(response)
						{
						},
					}).done(function (result) 
					{
						progress = progress + 25;
						$('#loading').text('Progress : '+progress+'%.');
						$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
						if(progress==100)
						{	
							end = Date.now();
							$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
							swal.close();
							if($('#type').val()=='2')
							{	
								$('.input-group').css('visibility', 'visible');
							}	
						}	
					});
				}	

				$.ajax({
					url: "<?php echo base_url(); ?>index.php/Report1/getTotal2?month2="+(m2+1)+"&month1="+(m1+1)+"&id_dist="+selected3.toString()+"&year1="+y1+"&year2="+y2+"&id_product="+selected2.toString()+"&id_channel="+selected.toString()+"&date="+currentTime+"&type="+type,
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
							$('#response2').val(response);
							createResponse2(response,0);
					},
					error: function(response)
					{
					},
				}).done(function (result) 
					{
						if(y2==date.getFullYear())
						{
							progress = progress + 25;
						}
						else
						{		
							progress = progress + 50;
						}	
						$('#loading').text('Progress : '+progress+'%.');
						$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
						if(progress==100)
						{	
							end = Date.now();
							$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
							swal.close();
							if($('#type').val()=='2')
							{	
								$('.input-group').css('visibility', 'visible');
							}	
						}	
					});
			}	

			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report1/getTotal?id_channel="+selected.toString()+"&id_dist="+selected3.toString()+"&year1="+y1+"&year2="+y2+"&month1="+(m1+1)+"&month2="+(m2+1)+"&id_product="+selected2.toString()+"&date="+currentTime+"&type="+type,
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
					$('#response').val(response);
					createResponse(response,0);
					var result2 = response.split("|");
					generate(selected,selected3,selected2,type,result2[1]);
				},
				error: function(response)
				{
				},
			}).done(function (result) 
			{
				progress = progress + 50;
				$('#loading').text('Progress : '+progress+'%.');
				$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
				if(progress==100)
				{	
					end = Date.now();
					$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
					swal.close();
					if($('#type').val()=='2')
					{	
						$('.input-group').css('visibility', 'visible');
					}	
				}	
				$('#excel').css('visibility', 'visible');
				$('#chart').css('visibility', 'visible');
				$('#url').css('visibility', 'visible');
			});


		}
		
		function createResponse3(response,scale)
		{
//			alert(scale);
								
//							var result = response.replace('/.00/g','').split(";");
							var result = response.split(";");
							var i = 0;
							var monthbutton = "";
							var totalmonthbutton = "";
							var month1=1;
							if(y2==y1)
							{
								month1 = (m1+1);
							}						
							
							for(i=0;i<result.length-(m2-month1+2);i++)
							{								
								if(scale>0)
								{	
									var x = parseFloat(result[i].replace(/,/g, ""))/Math.pow(10,scale);
									result[i]=numeral(x).format('0,0.00');
								}
								
								monthbutton = "#monthbutton-"+i;
								if(parseInt(result[i])<0)
								{	
									$(monthbutton).removeClass("btn btn-default").addClass('btn btn-danger');
								}	
								$(monthbutton).text(result[i]);		
							}
							for(i=result.length-(m2-month1+2);i<result.length;i++)
							{
								if(scale>0)
								{
									var x = parseFloat(result[i].split(',').join(""))/Math.pow(10,scale);
									result[i]=numeral(x).format('0,0.00');
								}

								totalmonthbutton = "#totalmonthbutton-"+i;
								if(parseInt(result[i])<0)
								{	
									$(totalmonthbutton).removeClass("btn btn-default").addClass('btn btn-danger');
								}	
								$(totalmonthbutton).text(result[i]);		
							}
		}

		function createResponse2(response,scale)
		{
//						var result = response.replace('/.00/g','').split(";");
						var result = response.split(";");
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
								if(scale>0)
								{	
									var x = parseFloat(result[i].replace(/,/g, ""))/Math.pow(10,scale);
									result[i]=numeral(x).format('0,0.00');
								}
							monthgapbutton = "#monthgapbutton-"+j;
							if(parseInt(result[i])<0)
							{	
								$(monthgapbutton).removeClass("btn btn-default").addClass('btn btn-danger');
							}	
							$(monthgapbutton).text(result[i]);
							j = j + 1;
						}
		}

		function createResponse(response,scale)
		{
					var result2 = response.split("|");
					var result = result2[0].split(";");
//					var result = response.replace('/.00/g','').split(";");
					var i = 0;
					var monthtotalbutton = "";
					var monthavgbutton = "";
					for(i=0;i<result.length;i+=2)
					{
						monthtotalbutton = "#monthtotalbutton-"+(i/2);
						monthavgbutton = "#monthavgbutton-"+(i/2);
								if(scale>0)
								{	
									var x = parseFloat(result[i].replace(/,/g, ""))/Math.pow(10,scale);
									result[i]=numeral(x).format('0,0.00');

									var x1 = parseFloat(result[i+1].replace(/,/g, ""))/Math.pow(10,scale);
									result[i+1]=numeral(x1).format('0,0.00');
								}
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
			var wb = XLSX.utils.table_to_book(document.getElementById('table'), {sheet:"After Redistribution Sales"});
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
			saveAs(new Blob([s2ab(wbout)],{type:"application/vnd.ms-excel;charset=utf-8"}), 'After Redistribution Sales ['+y1+'-'+pad.substring(0, pad.length - m1pad.length) + m1pad+' to '+y2+'-'+pad.substring(0, pad.length - m2pad.length) + m2pad+'].xlsx');
		});
		
      apply_date.onclick = function() 
      {
			progress = 0;
			$('#chart').css('visibility', 'hidden');
			$('#excel').css('visibility', 'hidden');
			$('#url').css('visibility', 'hidden');
			$('.input-group').css('visibility', 'hidden');
			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val(),$("#type").val());
      }


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

function done()
{
	
	var url = myChart2.toBase64Image();
	$("#url").attr('href',url);
	$("#url").attr('download','After Redistribution Sales.png');

}

function generate(selected,selected3,selected2,type,data)
{
	
//	alert(type);

	var currentTime = new Date().getTime();

	var remark = '';
	if(type==2)	remark = ' Gross Sales (IDR)';
	if(type==1)	remark = ' Quantity';

			/*$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report1/getData?id_channel="+selected.toString()+"&id_dist="+selected3.toString()+"&id_product="+selected2.toString()+"&year1="+y1+"&year2="+y2+"&month1="+(m1+1)+"&month2="+(m2+1)+"&date="+currentTime+"&type="+type,
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
				   var chartData = jQuery.parseJSON('' + data + '');
					//var lengthcanvas = chartData['labels'].length * 60;
					//$("#chart2").css("width", lengthcanvas);

					var chartOptions = {
						animation: {
							onComplete: done
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
						responsive: true,
						maintainAspectRatio: false,
						legend: {
								position : "bottom",
								labels: {
									filter: function(legendItem, chartData) {
//										if (chartData.datasetIndex === null ) {
//											return false;
//										}
									return true;
									}
								}
						},		//                centertext: 'Total : ' + total + ' Miliar',
						title: {
							display: true,
							text: 'After Redistribution Sales'
						},
						plugins: {
							datalabels: {
								display: true,
								formatter: (value, ctx) => {

									var datasets = ctx.chart.data.datasets;
										
									var sum = 0;	
									if (value == 0) 
									{
										sum = '';
									}
									else
									{		
										datasets.map(dataset => 
										{
											sum = sum + parseInt(dataset.data[ctx.dataIndex].toString(),10);
										});
										if(Math.round((value / sum) * 100)==0)
										{
											sum = '';
										}											
										else
										{	
											sum = numeral(value).format('0,0.00') + ' ( '+Math.round((value / sum) * 100) + '% )';			
										}	
									}
								    return sum;
								},
								/*color: function(context) {
									var index = context.dataIndex;
									var value = context.dataset.data[index];
									return 'white';
								},*/
								color: 'black',
								offset: 0,
								align: 'center',
								anchor: 'center',
								font: {
									size: "10"
								}
							}
						},
						scales: {
							yAxes: [{
								stacked: true,
								scaleLabel: {
									display: true,
									labelString: 'Average'+remark
								},
								ticks: {
									callback: function(label, index, labels) {
										return numeral(label).format('0,0');
									},
									beginAtZero: true
								}
							}],
							xAxes: [{
								stacked: true,
								scaleLabel: {
									display: true,
									labelString: 'Year'
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
			{
//				progress = progress + 25;
				$('#loading').text('Progress : '+progress+'%.');
				$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
				if(progress==100)
				{	
					end = Date.now();
					$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
					swal.close();
				}	
//				$('.progress-bar').removeClass('active');
				$('#chart').css('visibility', 'visible');
				$('#url').css('visibility', 'visible');
			});*/
}
</script>
</html>

