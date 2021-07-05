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
	<script src="<?php echo base_url(); ?>assets/js/Chart.min.js"></script>
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
		<br>
		<table cellpadding="0" cellspacing="0" style="font-size:13px;border-spacing:0px">
			<div id="table"></div>
		</table>
		<br>
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
</style>
<script>
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

		
			Swal.fire({
				title: '',
				html: '<span style="font-size:14px">Please wait...</span>'
			});
			swal.showLoading();
			$.ajax({
				url: "<?php echo base_url(); ?>index.php/Report10/getTotal3",
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
					$("#table").html(response);
				},
				error: function(response)
				{
				},
			}).done(function (result) 
			{
				swal.close();
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

