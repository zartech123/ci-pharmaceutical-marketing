<head>
  <meta name="viewport" content="width=1024">
  <link
    rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous"
  />
  <script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"
  ></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.6/xlsx.full.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/file-saver@2.0.2/dist/FileSaver.min.js"></script>

<body>
  <?php
    $month_desc = array('01' => 'Januari','02' => 'Februari', '03' => 'Maret', '04' => 'April', '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember')
  ?>
	 <table id="table" style="width:100%">	
      <tr style="text-align:center;">
        <td>&nbsp;</td>
      </tr>
      <tr style="text-align:center;">
        <td colspan="17" style="text-align:center;font-size:24px">
          <b>Event OTC Monthly Report Periode <?php echo $month_desc[$month]; ?> / <?php echo $year; ?></b>
        </td>
      </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr style="border-top:1px solid black;font-weight:bold;font-size:15px;">
                <td style="text-align:center;border-left:1px solid black;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
                <td colspan="3" style="text-align:center;color:red;border-right:1px solid black;">Perhitungan Reward</td>
                <td colspan="3" style="text-align:center;border-right:1px solid black;">Performance Sales (Harga Konsumen)</td>
                <td colspan="1" style="text-align:center;border-right:1px solid black;">Team</td>
                <td style="text-align:center;border-right:1px solid black;"></td>
            </tr>
            <tr style="font-weight:bold;font-size:15px;">
                <td style="text-align:center;border-left:1px solid black;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
            </tr>
            <tr style="font-weight:bold;font-size:15px;border-bottom:1px solid black;">
                <td style="text-align:center;border-left:1px solid black;border-right:1px solid black;">No</td>
                <td style="text-align:center;border-right:1px solid black;">Area</td>
                <td style="text-align:center;border-right:1px solid black;">Bulan</td>
                <td style="text-align:center;border-right:1px solid black;">Nama Event</td>
                <td style="text-align:center;color:red;border-right:1px solid black;">Actual Sales = Qty x HNA (IDR)</td>
                <td style="text-align:center;color:red;border-right:1px solid black;">% Cost Ratio</td>
                <td style="text-align:center;color:red;border-right:1px solid black;">Bundling</td>
                <td style="text-align:center;border-right:1px solid black;">Target (IDR)</td>
                <td style="text-align:center;border-right:1px solid black;">Actual (IDR)</td>
                <td style="text-align:center;border-right:1px solid black;">% ACH = Sales/Target</td>
                <td style="text-align:center;border-right:1px solid black;">SPO/SMD/KAE/COMBO</td>
                <td style="text-align:center;border-right:1px solid black;">PIC</td>
            </tr>
        <?php        
        $i = 0;
		foreach ($kpk as $a){ 
            ?>
            <tr style="border:1px solid black;">
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo ($i+1); ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['area']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['month']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['event_name']; ?>&nbsp;</td>
                <td style="text-align:right;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['actual_sales']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['cost_ratio']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['bundling']; ?>&nbsp;</td>
                <td style="text-align:right;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['target']; ?>&nbsp;</td>
                <td style="text-align:right;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['actual']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['ach']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['pic']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['team']; ?>&nbsp;</td>
            </tr>
        <?php
            $i = $i + 1;
        }
        ?>
		</table>	
		<br>
        <input type="hidden" id="count" name="count" value="<?php echo $i; ?>">
        <input type="hidden" id="month" name="month" value="<?php echo $_GET['month']; ?>">
        <input type="hidden" id="year" name="year" value="<?php echo $_GET['year']; ?>">
        <button type="button" id="download" class="btn btn-primary btn-sm">Download File</button>

</body>
<style type="text/css">
  .form-control {
    border-radius: 0.5rem;
    padding: 0px;
  }
</style>
<script type="text/javascript">
		$('#download').click(function(e){
			var wb = XLSX.utils.table_to_book(document.getElementById('table'), {sheet:"Event OTC Monthly Report"});
			var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
			function s2ab(s) { 
						var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
						var view = new Uint8Array(buf);  //create uint8array as viewer
						for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
						return buf;    
			}
			saveAs(new Blob([s2ab(wbout)],{type:"application/vnd.ms-excel;charset=utf-8"}), 'Event OTC Monthly Report.xlsx');
		});

</script>
</head>
