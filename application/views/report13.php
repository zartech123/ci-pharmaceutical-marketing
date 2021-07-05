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
			<tr><td colspan="12"><center><div class="table-label" style="font-size:14px">&nbsp;<b>Coverage</b></div></center></td></tr>
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr>
				<!--td width="60px" style="font-size:14px">&nbsp;Start :&nbsp;</td>
				<td><input class="form-control input-sm" type="text" id="start_date" name="start_date" style="width:70px" placeholder="Start Date"/></td>
				<td width="50px" style="font-size:14px">&nbsp;End :&nbsp;</td>
				<td width="80px" ><input class="form-control input-sm" type="text" id="end_date" name="end_date" style="width:70px" placeholder="End Date"/></td>
				<td>
					<select id="type" class="form-control input-sm" style="width:120px">
						<option value="1" data-section="Channel" selected>Quantity</options>									
						<option value="2" data-section="Channel">Gross Sales</options>									
					</select>				
				</td>
				<td>&nbsp;</td-->
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
				<td>
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
		<br><br>
		<table width="100%">
		<tr>
		<td style="width:33%"><div id="chart" style="overflow:hidden"><canvas id="mychart2"></canvas></div></td>
		<td style="width:33%"><div id="chart3" style="overflow:hidden"><canvas id="mychart4"></canvas></div></td>
		<td style="width:33%"><div id="chart2" style="overflow:hidden"><canvas id="mychart3"></canvas></div></td>
		</tr>																	
        <input type="hidden" id="name_product3" name="name_product3" value="">
		</table>
		<br><br><br>
	</div>
</body>
<style type="text/css">
#chart {
  height:60vh;
}
#chart2 {
  height:60vh;
}
#chart3 {
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
      /*var id_product = $("#id_product").treeMultiselect({
        allowBatchSelection: true,
        enableSelectAll: true,
        searchable: true,
        sortable: true,
		startCollapsed: true,
		onChange: productOnChange,
		showSectionOnSelected: false,
		hideSidePanel: true
      });
	  var id_product2 = id_product[0];*/
	  
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

		var selectedChannel = ['1','2','3','4','5','6','7','8'];
//		createChannel(selectedChannel,$("#id_product").val(),$("#id_dist").val());

		var distributor = [];

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

/*		function productOnChange(allSelectedItems, addedItems, removedItems) 
		{
			$('#loading').text('Progress : 0%');
			$('.progress-bar').css( "width", "0%" ).attr( "aria-valuenow", 0);
//			alert($("#id_product").val());
//			createChannel($("#id_channel").val(),$("#id_product").val(),$("#id_dist").val(),$("#type").val());
//			alert("something changed!");
		}*/

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
		
		function createChannel(selected,selected3,type)
		{
			start = Date.now();
/*			Swal.fire({
				title: '',
				html: '<span style="font-size:14px">Please wait...</span>'
			});
			swal.showLoading();*/
//			$("#table").html(content);
//			swal.close();
			selected3.sort();
			selected.sort();
//			var currentTime = new Date().getTime();
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report13/getTotal?id_dist="+selected3.toString()+"&id_channel="+selected.toString(),
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
					$("#table").html(result2[0]);
					generate(result2[1]);
					generate2(result2[2]);
					generate3(result2[3]);
				},
				error: function(response)
				{
					alert("xxxx");
				},
			}).done(function (result) 
			{
				progress = progress + 50;
				$('#loading').text('Progress : '+progress+'%.');
				if(progress==100)
				{	
					end = Date.now();
					$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
					swal.close();
				}	
				$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
				$('#excel').css('visibility', 'visible');

			});



		}

		var myChart2;  
		var myChart3;  
		var myChart4;  

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
			saveAs(new Blob([s2ab(wbout)],{type:"application/vnd.ms-excel;charset=utf-8"}), 'Covered.xlsx');
		});
		
      apply_date.onclick = function() 
      {
			progress = 0;
			$('#chart').css('visibility', 'hidden');
			$('#excel').css('visibility', 'hidden');
			$('#url').css('visibility', 'hidden');
			createChannel($("#id_channel").val(),$("#id_dist").val());
      }





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

function generate(data) 
{
    /*$.ajax({
        url: "<?php echo base_url(); ?>index.php/Report13/getNilai?start_date=" + start_date4 + "&end_date=" +
            end_date4 + "&divisi=" + divisi,
        type: "GET",
        dataType: "text",
        success: function(data) {*/
            var chartData = jQuery.parseJSON('' + data + '');

            /*var total = parseFloat(chartData['datasets'][0]['data'][0]) + parseFloat(chartData['datasets'][
                0
            ]['data'][1]) + parseFloat(chartData['datasets'][0]['data'][2]) + parseFloat(chartData[
                'datasets'][0]['data'][3]) + parseFloat(chartData['datasets'][0]['data'][4]);
	    total = total.toFixed(2);*/
			var total = 0;
            var chartOptions = {
                animation: {
                    animateRotate: true,
                    animateScale: true
                },
                cutoutPercentage: 65,
                maintainAspectRatio: false,
                responsive: true,
                tooltips: {
                    enabled: true,
                    mode: 'single',
                },
				plugins: {
					datalabels: {
						color: '#FFFFFF',
						formatter: (value, ctx) => {
								 let datasets = ctx.chart.data.datasets;
								 if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
								   let sum = datasets[0].data.reduce((a, b) => parseInt(a) + parseInt(b), 0);
								   let percentage = ((value / sum) * 100).toFixed(2) + '%';
								   if(percentage=='0.00%')
								   {
										return '';
								   }
								   else
								   {			
										return percentage;
								   }	
								 } else {
								   return percentage;
								 }
							   }
					},
                },
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        generateLabels: function(chart) {
                            var data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map(function(label, i) {
                                    var meta = chart.getDatasetMeta(0);
                                    var ds = data.datasets[0];
                                    var arc = meta.data[i];
                                    var custom = arc && arc.custom || {};
                                    var getValueAtIndexOrDefault = Chart.helpers
                                        .getValueAtIndexOrDefault;
                                    var arcOpts = chart.options.elements.arc;
                                    var fill = custom.backgroundColor ? custom
                                        .backgroundColor : getValueAtIndexOrDefault(ds
                                            .backgroundColor, i, arcOpts.backgroundColor);
                                    var stroke = custom.borderColor ? custom.borderColor :
                                        getValueAtIndexOrDefault(ds.borderColor, i, arcOpts
                                            .borderColor);
                                    var bw = custom.borderWidth ? custom.borderWidth :
                                        getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts
                                            .borderWidth);

                                    // We get the value of the current label
                                    var value = chart.config.data.datasets[arc
                                        ._datasetIndex].data[arc._index];

                                    return {
                                        // Instead of `text: label,`
                                        // We add the value to the string
                                        text: label + " : " + value,
                                        fillStyle: fill,
                                        strokeStyle: stroke,
                                        lineWidth: bw,
                                        hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                                        index: i
                                    };
                                });
                            } else {
                                return [];
                            }
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Total Covered Outlet',
                    fontColor: '#381d72'
                }
            }

            if (myChart2) {
                myChart2.destroy();
            }

            myChart2 = new Chart(document.getElementById("mychart2"), {
                type: 'pie',
                data: chartData,
                options: chartOptions
            });
				/*},
				error: function(response)
				{
				},
			}).done(function (result) 
			{*/
				progress = progress + 50;
				$('#loading').text('Progress : '+progress+'%.');
				if(progress==100)
				{	
					end = Date.now();
					$('#loading').text('Progress : '+progress+'%. Elapsed Time : '+(end-start)/1000+' s');
					swal.close();
				}	
				$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);
			//});
			$('#chart').css('visibility', 'visible');
			$('#url').css('visibility', 'visible');

}

function generate2(data) 
{
    /*$.ajax({
        url: "<?php echo base_url(); ?>index.php/Report13/getNilai?start_date=" + start_date4 + "&end_date=" +
            end_date4 + "&divisi=" + divisi,
        type: "GET",
        dataType: "text",
        success: function(data) {*/
            var chartData = jQuery.parseJSON('' + data + '');

            /*var total = parseFloat(chartData['datasets'][0]['data'][0]) + parseFloat(chartData['datasets'][
                0
            ]['data'][1]) + parseFloat(chartData['datasets'][0]['data'][2]) + parseFloat(chartData[
                'datasets'][0]['data'][3]) + parseFloat(chartData['datasets'][0]['data'][4]);
	    total = total.toFixed(2);*/
			var total = 0;
            var chartOptions = {
                animation: {
                    animateRotate: true,
                    animateScale: true
                },
                cutoutPercentage: 65,
                maintainAspectRatio: false,
                responsive: true,
                tooltips: {
                    enabled: true,
                    mode: 'single',
                },
				plugins: {
					datalabels: {
						color: '#FFFFFF',
						formatter: (value, ctx) => {
								 let datasets = ctx.chart.data.datasets;
								 if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
								   let sum = datasets[0].data.reduce((a, b) => parseInt(a) + parseInt(b), 0);
								   let percentage = ((value / sum) * 100).toFixed(2) + '%';
								   if(percentage=='0.00%')
								   {
										return '';
								   }
								   else
								   {			
										return percentage;
								   }	
								 } else {
								   return percentage;
								 }
							   }
					},
                },
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        generateLabels: function(chart) {
                            var data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map(function(label, i) {
                                    var meta = chart.getDatasetMeta(0);
                                    var ds = data.datasets[0];
                                    var arc = meta.data[i];
                                    var custom = arc && arc.custom || {};
                                    var getValueAtIndexOrDefault = Chart.helpers
                                        .getValueAtIndexOrDefault;
                                    var arcOpts = chart.options.elements.arc;
                                    var fill = custom.backgroundColor ? custom
                                        .backgroundColor : getValueAtIndexOrDefault(ds
                                            .backgroundColor, i, arcOpts.backgroundColor);
                                    var stroke = custom.borderColor ? custom.borderColor :
                                        getValueAtIndexOrDefault(ds.borderColor, i, arcOpts
                                            .borderColor);
                                    var bw = custom.borderWidth ? custom.borderWidth :
                                        getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts
                                            .borderWidth);

                                    // We get the value of the current label
                                    var value = chart.config.data.datasets[arc
                                        ._datasetIndex].data[arc._index];

                                    return {
                                        // Instead of `text: label,`
                                        // We add the value to the string
                                        text: label + " : " + value,
                                        fillStyle: fill,
                                        strokeStyle: stroke,
                                        lineWidth: bw,
                                        hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                                        index: i
                                    };
                                });
                            } else {
                                return [];
                            }
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Overlap Coverage by Distributor - Sub Distributor',
                    fontColor: '#381d72'
                }
            }

            if (myChart3) {
                myChart3.destroy();
            }

            myChart3 = new Chart(document.getElementById("mychart3"), {
                type: 'pie',
                data: chartData,
                options: chartOptions
            });
				/*},
				error: function(response)
				{
				},
			}).done(function (result) 
			{*/
			//});
			$('#chart2').css('visibility', 'visible');
			$('#url').css('visibility', 'visible');

}

function generate3(data) 
{
    /*$.ajax({
        url: "<?php echo base_url(); ?>index.php/Report13/getNilai?start_date=" + start_date4 + "&end_date=" +
            end_date4 + "&divisi=" + divisi,
        type: "GET",
        dataType: "text",
        success: function(data) {*/
            var chartData = jQuery.parseJSON('' + data + '');

            /*var total = parseFloat(chartData['datasets'][0]['data'][0]) + parseFloat(chartData['datasets'][
                0
            ]['data'][1]) + parseFloat(chartData['datasets'][0]['data'][2]) + parseFloat(chartData[
                'datasets'][0]['data'][3]) + parseFloat(chartData['datasets'][0]['data'][4]);
	    total = total.toFixed(2);*/
			var total = 0;
            var chartOptions = {
                animation: {
                    animateRotate: true,
                    animateScale: true
                },
                cutoutPercentage: 65,
                maintainAspectRatio: false,
                responsive: true,
                tooltips: {
                    enabled: true,
                    mode: 'single',
                },
				plugins: {
					datalabels: {
						color: '#FFFFFF',
						formatter: (value, ctx) => {
								 let datasets = ctx.chart.data.datasets;
								 if (datasets.indexOf(ctx.dataset) === datasets.length - 1) {
								   let sum = datasets[0].data.reduce((a, b) => parseInt(a) + parseInt(b), 0);
								   let percentage = ((value / sum) * 100).toFixed(2) + '%';
								   if(percentage=='0.00%')
								   {
										return '';
								   }
								   else
								   {			
										return percentage;
								   }	
								 } else {
								   return percentage;
								 }
							   }
					}
                },
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        generateLabels: function(chart) {
                            var data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map(function(label, i) {
                                    var meta = chart.getDatasetMeta(0);
                                    var ds = data.datasets[0];
                                    var arc = meta.data[i];
                                    var custom = arc && arc.custom || {};
                                    var getValueAtIndexOrDefault = Chart.helpers
                                        .getValueAtIndexOrDefault;
                                    var arcOpts = chart.options.elements.arc;
                                    var fill = custom.backgroundColor ? custom
                                        .backgroundColor : getValueAtIndexOrDefault(ds
                                            .backgroundColor, i, arcOpts.backgroundColor);
                                    var stroke = custom.borderColor ? custom.borderColor :
                                        getValueAtIndexOrDefault(ds.borderColor, i, arcOpts
                                            .borderColor);
                                    var bw = custom.borderWidth ? custom.borderWidth :
                                        getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts
                                            .borderWidth);

                                    // We get the value of the current label
                                    var value = chart.config.data.datasets[arc
                                        ._datasetIndex].data[arc._index];

                                    return {
                                        // Instead of `text: label,`
                                        // We add the value to the string
                                        text: label + " : " + value,
                                        fillStyle: fill,
                                        strokeStyle: stroke,
                                        lineWidth: bw,
                                        hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                                        index: i
                                    };
                                });
                            } else {
                                return [];
                            }
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Dedicated Coverage by Distributor - Sub Distributor',
                    fontColor: '#381d72'
                }
            }

            if (myChart4) {
                myChart4.destroy();
            }

            myChart4 = new Chart(document.getElementById("mychart4"), {
                type: 'pie',
                data: chartData,
                options: chartOptions
            });
				/*},
				error: function(response)
				{
				},
			}).done(function (result) 
			{*/
			//});
			$('#chart3').css('visibility', 'visible');
			$('#url').css('visibility', 'visible');

}

</script>
</html>

