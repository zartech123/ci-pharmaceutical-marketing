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
    <form method="post" action="<?php echo base_url().'index.php/KPKReport/add'; ?>">
	 <table id="table" style="width:100%">	
      <tr style="text-align:right;">
        <td colspan="17" style="text-align:right;">Lampiran III : Format Pelaporan Pemberian Sponsorship Bagi Pemberi Sponsorship</td>
      </tr>
      <tr style="text-align:center;">
        <td>&nbsp;</td>
      </tr>
      <tr style="text-align:center;">
        <td colspan="17" style="text-align:center;font-size:24px">
          <b>Rekapitulasi Pemberian Sponsorship Periode <?php echo $month_desc[$month]; ?> / <?php echo $year; ?></b>
        </td>
      </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr style="font-size:18px">
                <td colspan="3">Nama Perusahaan</td>
                <td style="text-align:center">&nbsp;:&nbsp;</td>
                <td colspan="5">PT TAISHO PHARMACEUTICAL INDONESIA</td>
            </tr>
            <tr style="font-size:18px">
                <td colspan="3">Alamat</td>
                <td style="text-align:center">&nbsp;:&nbsp;</td>
                <td colspan="8"> WISMA TAMARA LT. 10 JL. JEND. SUDIRMAN KAV 24 JAKARTA 12920</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr style="border-top:1px solid black;font-weight:bold;font-size:15px;">
                <td style="text-align:center;border-left:1px solid black;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
                <td style="text-align:center;border-right:1px solid black;"></td>
                <td colspan="3" style="text-align:center;border-right:1px solid black;">Kategori Penerima (beri tanda √)</td>
                <td colspan="7" style="text-align:center;border-right:1px solid black;">Besaran Nilai Sponsorship Yang Diberikan (Dalam Rupiah)</td>
                <td colspan="3" style="text-align:center;border-right:1px solid black;">Nama Penerima</td>
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
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;"></td>
                <td colspan="2" style="text-align:center;border-right:1px solid black;border-top:1px solid black;">Institusi Sebagai Penyelenggara</td>
                <td colspan="3" style="text-align:center;border-right:1px solid black;"></td>
            </tr>
            <tr style="font-weight:bold;font-size:15px;">
                <td style="text-align:center;border-left:1px solid black;border-right:1px solid black;">No</td>
                <td style="text-align:center;border-right:1px solid black;">Nama Kegiatan</td>
                <td style="text-align:center;border-right:1px solid black;">Tanggal Kegiatan</td>
                <td style="text-align:center;border-right:1px solid black;">Lokasi Kegiatan</td>
                <td style="text-align:center;border-right:1px solid black;">Institusi Sebagai Penyelenggara</td>
                <td style="text-align:center;border-right:1px solid black;">Institusi Bukan Sebagai Penyelenggara</td>
                <td style="text-align:center;border-right:1px solid black;">Tenaga Kesehatan Praktik Perorangan</td>
                <td style="text-align:center;border-right:1px solid black;">Registrasi</td>
                <td style="text-align:center;border-right:1px solid black;">Akomodasi</td>
                <td style="text-align:center;border-right:1px solid black;">Transportasi</td>
                <td style="text-align:center;border-right:1px solid black;">Honor</td>
                <td style="text-align:center;border-right:1px solid black;">Jumlah</td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;">Nominal</td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;">Keterangan</td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;">Tenaga Kesehatan/ Institusi</td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;">Bidang Keahlian</td>
                <td style="text-align:center;border-right:1px solid black;border-top:1px solid black;width:200px">Alamat</td>
            </tr>
            <tr style="border:1px solid black;">
                <td style="text-align:center;border-right:1px solid black;">1</td>
                <td style="text-align:center;border-right:1px solid black;">2</td>
                <td style="text-align:center;border-right:1px solid black;">3</td>
                <td style="text-align:center;border-right:1px solid black;">4</td>
                <td style="text-align:center;border-right:1px solid black;">5</td>
                <td style="text-align:center;border-right:1px solid black;">6</td>
                <td style="text-align:center;border-right:1px solid black;">7</td>
                <td style="text-align:center;border-right:1px solid black;">8</td>
                <td style="text-align:center;border-right:1px solid black;">9</td>
                <td style="text-align:center;border-right:1px solid black;">10</td>
                <td style="text-align:center;border-right:1px solid black;">11</td>
                <td style="text-align:center;border-right:1px solid black;">12</td>
                <td style="text-align:center;border-right:1px solid black;">13</td>
                <td style="text-align:center;border-right:1px solid black;">14</td>
                <td style="text-align:center;border-right:1px solid black;">15</td>
                <td style="text-align:center;border-right:1px solid black;">16</td>
                <td style="text-align:center;border-right:1px solid black;width:200px">17</td>
            </tr>
        <?php        
        $i = 0;
		foreach ($kpk as $a){ 
            //$check5 = "check5-".$kpk[$i]['id_mer']."-".$kpk[$i]['id_hcp2']."-".$kpk[$i]['id_hco'];
            //$check6 = "check6-".$kpk[$i]['id_mer']."-".$kpk[$i]['id_hcp2']."-".$kpk[$i]['id_hco'];
            //$check7 = "check7-".$kpk[$i]['id_mer']."-".$kpk[$i]['id_hcp2']."-".$kpk[$i]['id_hco'];
            //$desc = "description-".$kpk[$i]['id_mer']."-".$kpk[$i]['id_hcp2']."-".$kpk[$i]['id_hco'];
            //$address = "address-".$kpk[$i]['id_mer']."-".$kpk[$i]['id_hcp2']."-".$kpk[$i]['id_hco'];
            $id_tl2 = "id_tl2-".($i+1);
            $id_hcp = "id_hcp-".($i+1);
            $id_mer = "id_mer-".($i+1);
            $id_sc = "id_sc-".($i+1);
            $id_hcp2 = "id_hcp2-".($i+1);
            $id_hco = "id_hco-".($i+1);
            $check5 = "check5-".($i+1);
            $check6 = "check6-".($i+1);
            $check7 = "check7-".($i+1);
            $desc = "description-".($i+1);
            $address = "address-".($i+1);
            $speciality = "speciality-".($i+1);
            $checked5 = "";
            $checked6 = "";
            $checked7 = "";
            if($kpk[$i]['check5']=="on")
            {
              $checked5 = "checked";
            }
            if($kpk[$i]['check6']=="on")
            {
              $checked6 = "checked";
            }
            if($kpk[$i]['check7']=="on")
            {
              $checked7 = "checked";
            }
            ?>
            <tr style="border:1px solid black;">
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo ($i+1); ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['event_name']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['event_start_date']." - ".$kpk[$i]['event_end_date']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo $kpk[$i]['event_venue']; ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<input name="<?php echo $check5; ?>" id="<?php echo $check5; ?>" type="checkbox" <?php echo $checked5; ?>>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<input name="<?php echo $check6; ?>" id="<?php echo $check6; ?>" type="checkbox" <?php echo $checked6; ?>>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<input name="<?php echo $check7; ?>" id="<?php echo $check7; ?>" type="checkbox" <?php echo $checked7; ?>>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo number_format($kpk[$i]['registration'],0); ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo number_format($kpk[$i]['accommodation'],0); ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo number_format($kpk[$i]['travel'],0); ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo number_format($kpk[$i]['honor'],0); ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo number_format(($kpk[$i]['registration']+$kpk[$i]['accommodation']+$kpk[$i]['travel']+$kpk[$i]['honor']),0); ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;<?php echo number_format($kpk[$i]['nominal'],0); ?>&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;"><input name="<?php echo $desc; ?>" type="text" value="<?php echo $kpk[$i]['description']; ?>">&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;">&nbsp;
                <?php
                if($kpk[$i]['id_hco']!="0")
                {
                    echo $kpk[$i]['event_organizer'];
                }
                else 
                {
                    echo $kpk[$i]['doctor'];
                }
                ?>                
                &nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;"><input name="<?php echo $speciality; ?>" type="text" value="<?php echo $kpk[$i]['speciality']; ?>">&nbsp;</td>
                <td style="text-align:center;border-right:1px solid black;width:200px">
                <?php
                if($kpk[$i]['id_tl2']!="0" || $kpk[$i]['id_hcp2']!="0" || $kpk[$i]['id_hcp']!="0")
                {
					echo $kpk[$i]['event_institution'];
                    ?> <input name="<?php echo $address; ?>" type="hidden" value="<?php echo $kpk[$i]['event_institution']; ?>"> <?php
                }
                else 
                { ?>
                    <input name="<?php echo $address; ?>" type="text" style="" value="<?php echo $kpk[$i]['address']; ?>">
                <?php }
                ?>                
                &nbsp;</td>
            </tr>
			<input type="hidden" id="id_tl2" name="<?php echo $id_tl2; ?>" value="<?php echo $kpk[$i]['id_tl2']; ?>">
			<input type="hidden" id="id_hcp" name="<?php echo $id_hcp; ?>" value="<?php echo $kpk[$i]['id_hcp']; ?>">
			<input type="hidden" id="id_sc" name="<?php echo $id_sc; ?>" value="<?php echo $kpk[$i]['id_sc']; ?>">
			<input type="hidden" id="id_mer" name="<?php echo $id_mer; ?>" value="<?php echo $kpk[$i]['id_mer']; ?>">
			<input type="hidden" id="id_hcp2" name="<?php echo $id_hcp2; ?>" value="<?php echo $kpk[$i]['id_hcp2']; ?>">
			<input type="hidden" id="id_hco" name="<?php echo $id_hco; ?>" value="<?php echo $kpk[$i]['id_hco']; ?>">
        <?php
            $i = $i + 1;
        }
        ?>
		</table>	
		<br>
        <input type="hidden" id="count" name="count" value="<?php echo $i; ?>">
        <button type="submit" id="save" class="btn btn-primary btn-sm">Save</button>
        <input type="hidden" id="month" name="month" value="<?php echo $_GET['month']; ?>">
        <input type="hidden" id="year" name="year" value="<?php echo $_GET['year']; ?>">
        <button type="button" id="download" class="btn btn-primary btn-sm">Download File</button>
        </form>

</body>
<style type="text/css">
  .form-control {
    border-radius: 0.5rem;
    padding: 0px;
  }
</style>
<script type="text/javascript">
		$('#download').click(function(e){
			var wb = XLSX.utils.table_to_book(document.getElementById('table'), {sheet:"KPK Report"});
			var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
			function s2ab(s) { 
						var buf = new ArrayBuffer(s.length); //convert s to arrayBuffer
						var view = new Uint8Array(buf);  //create uint8array as viewer
						for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF; //convert to octet
						return buf;    
			}
			saveAs(new Blob([s2ab(wbout)],{type:"application/vnd.ms-excel;charset=utf-8"}), 'KPK Report.xlsx');
		});

</script>
</head>
