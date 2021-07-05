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
			<tr><td colspan="12"><center><div class="table-label" style="font-size:14px">&nbsp;<b>Event OTC Overtime Report</b></div></center></td></tr>
			<tr><td colspan="12">&nbsp;</td></tr>
			<tr>
				<td width="60px" style="font-size:14px">&nbsp;Start :&nbsp;</td>
				<td><input class="form-control input-sm" type="text" id="start_date" name="start_date" style="width:130px" placeholder="Start Date"/></td>
				<td width="50px" style="font-size:14px">&nbsp;End :&nbsp;</td>
				<td width="80px" ><input class="form-control input-sm" type="text" id="end_date" name="end_date" style="width:130px" placeholder="End Date"/></td>
				<td>&nbsp;</td>
				<td><button type="button" id="apply_date" class="btn btn-info btn-sm">Generate Report</button></td>
				<td>&nbsp;</td>
				<td><a id="url" download="filename.png" style="visibility:hidden"><i class="fa fa-bar-chart fa-border" style="font-size:21px"></i></a>&nbsp;<a id="excel" style="visibility:hidden;cursor:pointer"><i class="fa fa-file-text-o fa-border" style="font-size:21px"></i></a></td>
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
		<!--tr><td colspan="2" style="text-align:center;"><button type="button" class="btn btn-info" style="width:1130px"><div id="year1"></div></button></td>
		<td colspan="<?php echo "14"; ?>" style="text-align:center;"><button id="buttonyear" type="button" class="btn btn-info" style="width:<?php echo $width; ?>"><div id="year2"></div></button></td><td style="text-align:center;"></td><td style="text-align:center;"></td></tr-->
		</div>
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
	  
		var date = new Date();
//		var y1 = (date.getFullYear()-1);
		var y1 = date.getFullYear();
//		var m1 = date.getMonth();
		var m1 = 0;
		var y2 = date.getFullYear();
		var m2 = date.getMonth();

		var firstDay = (m1 < 9 ? '0' : '') + (m1 + 1) + "/" + y1;
		var firstDay2 = (m2 < 9 ? '0' : '') + (m2 + 1) + "/" + y2;

//		createChannel(selectedChannel,$("#id_product").val(),$("#id_dist").val());

		function createChannel()
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
						content = content + '<td colspan="'+(m2-m1+1)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+((m2-m1+1)*130)+'px">'+i+'</button></td>';
					}
					else
					{		
						if(i==y1)
						{
							content = content + '<td colspan="'+(12-m1)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+((12-m1)*130)+'px">'+i+'</button></td>';
						}	
						else if(i==y2)
						{	
							content = content + '<td colspan="'+(m2+1)+'" style="text-align:center;"><button type="button" class="btn btn-info" style="width:'+((m2+1)*130)+'px">'+i+'</button></td>';
						}	
						else
						{	
							content = content + '<td colspan="12" style="text-align:center;"><button type="button" class="btn btn-info" style="width:1560px">'+i+'</button></td>';
						}	
					}	
				}
				content = content + '</tr><tr>';
				content = content + '<td style="text-align:center"><button type="button" class="btn btn-danger">Item</button></td>';
				var month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
				for(var j = y1; j <= y2; j++)
				{
					if(y2==y1)
					{
							for(var i = m1+1;i<=m2+1;i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:130px;">'+month[i-1]+'</button></td>';
							}
					}
					else
					{	
						if(j==y1)
						{	
							for(var i = m1+1;i<=12;i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:130px;">'+month[i-1]+'</button></td>';
							}
						}	
						else if(j==y2)
						{	
							for(var i = 1;i<=(m2+1);i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:130px;">'+month[i-1]+'</button></td>';
							}
						}	
						else
						{	
							for(var i = 1;i<=12;i++)
							{
								content = content + '<td style="text-align:center;"><button type="button" class="btn btn-primary" style="width:130px;">'+month[i-1]+'</button></td>';
							}
						}	
					}	
				}	
				content = content + '</tr>';

				m = 0;
				l = 0;
					content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">Sales (IDR)</button></td>';

					m = 0;
					for(var i = y1; i <= y2; i++)
					{
						if(y2==y1)
						{
								for(var j = m1+1;j<=m2+1;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
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
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
									l = l + 1;
								}
							}	
							else if(i==y2)
							{	
								for(var j = 1;j<=(m2+1);j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
									l = l + 1;
								}
							}	
							else
							{	
								for(var j = 1;j<=12;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
									l = l + 1;
								}
							}	
						}	
//						monthtotalbutton = "monthtotalbutton-"+m;
//						monthavgbutton = "monthavgbutton-"+m;
//						content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-default" style="width:90px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-default" style="width:95px"></button></td>';
						m = m + (2 + 1);
					}	
					content = content + '</tr>';

					content = content + '<tr><td style="text-align:left;"><button type="button" class="btn btn-default" style="border:0px;text-align:left">Event</button></td>';

					m = 1;
					for(var i = y1; i <= y2; i++)
					{
						if(y2==y1)
						{
								for(var j = m1+1;j<=m2+1;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
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
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
									l = l + 1;
								}
							}	
							else if(i==y2)
							{	
								for(var j = 1;j<=(m2+1);j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
									l = l + 1;
								}
							}	
							else
							{	
								for(var j = 1;j<=12;j++)
								{
									monthbutton = "monthbutton4-"+l;
									content = content + '<td style="text-align:center;"><button id="'+monthbutton+'" type="button" class="btn btn-default" style="width:130px;"></button></td>';
									l = l + 1;
								}
							}	
						}	
//						monthtotalbutton = "monthtotalbutton-"+m;
//						monthavgbutton = "monthavgbutton-"+m;
//						content = content + '<td><button type="button" id="'+monthtotalbutton+'" class="btn btn-default" style="width:90px"></button></td><td><button id="'+monthavgbutton+'" type="button" class="btn btn-default" style="width:95px"></button></td>';
						m = m + (2 + 1);
					}	
					content = content + '</tr>';

			$("#table").html(content);
//			$('#loading').text('Progress : 20%. Please wait');
//			$('.progress-bar').css('width', 20+'%').attr('aria-valuenow', 20);


			var currentTime = new Date().getTime();
			

			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report19/getSales?month1="+(m1+1)+"&month2="+(m2+1)+"&year2="+y2+"&year1="+y1+"&date="+currentTime,
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
					var k = 0;
//					alert(response);
					var monthbutton = "";
					for(i=0;i<result.length;i++)
					{
						monthbutton = "#monthbutton4-"+i;
						$(monthbutton).text(result[i]);
						k = k + 1;
					}
					

					result = result2[1].replace('/.00/g','').split(";");
					
					for(i=k;i<result.length+k;i++)
					{
						monthbutton = "#monthbutton4-"+i;
						$(monthbutton).text(result[i-k]);
					}
					generate(result2[2]);
				},
				error: function(response)
				{
							alert("error1");
				},
			}).done(function (result) 
			{
				/*progress = progress + 75;
				$('#loading').text('Progress : '+progress+'%.');
				$('.progress-bar').css('width', progress+'%').attr('aria-valuenow', progress);*/
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
					XLSX.utils.book_append_sheet(workbook, ws1, "Event OTC OverTime");
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
					saveAs(new Blob([s2ab(wbout)],{type:"application/vnd.ms-excel;charset=utf-8"}), 'OverTime ['+y1+'-'+pad.substring(0, pad.length - m1pad.length) + m1pad+' to '+y2+'-'+pad.substring(0, pad.length - m2pad.length) + m2pad+'].xlsx');
		});

      apply_date.onclick = function() 
      {
			progress = 0;
			$('#chart').css('visibility', 'hidden');
			$('#url').css('visibility', 'hidden');
			$('#excel').css('visibility', 'hidden');
			createChannel();
//			$('#iframe1').attr('src', '<?php echo base_url(); ?>index.php/Report4?menu=0&y1='+y1+'&y2='+y2+'&m1='+m1+'&m2='+m2+'&id_channel='+$("#id_channel").val()+'&id_dist='+$("#id_dist").val()+'&id_product='+$("#id_product").val());
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
	$("#url").attr('download','Event OTC Overtime.png');

}

function generate(response)
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
							text: 'Event OTC Over Time Report'
						},
						tooltips: {
									callbacks: {
										label: function(tooltipItem, data) {
											
//											let label = data.labels[tooltipItem.index];
//											let label = tooltipItem.datasetIndex;
											let label = '';	
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
									fontColor: "#0275d8",
									display: true,
									labelString: 'Sales IDR (Bar)'
								},
//								display: false,
								ticks: {
									fontColor: "#0275d8",
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
									fontColor: "#888888",
									display: true,
									labelString: 'Event (Line)'
								},
								ticks: {
									fontColor: "#888888",
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
				progress = progress + 100;
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
			$('#excel').css('visibility', 'visible');
}
</script>
</html>

