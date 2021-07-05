<head>
    <meta name="viewport" content="width=1024">
    <title>SPONSORSHIP CONFIRMATION LETTER HCP</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<body style="font-size:13px">
    <div class="container-fluid">
        <form action="<?php echo base_url().'index.php/ConfirmationLetterHCP/add'; ?>" method="post"> 
            <div class="row">
            <div class="col-xs-1" style="background:#efefef;text-align:center;width:650px">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:650px"><img src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:650px">
                    <b>SPONSORSHIP CONFIRMATION LETTER HCP</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:650px;background:#efefef;">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:650px"><hr/></div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Tanggal</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="event_date" name="event_date"  type="text" style="width:90px" value="<?php echo $event_date; ?>" readonly/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">No Referensi Surat</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <?php echo substr($created_date,-4);?>/HCP2/<?php echo date("m",strtotime($created_date));?>/<div class="col-xs-1">
                    <div class="form-group">
                      <input class="form-control" id="nodoc2" name="nodoc2" type="text" style="width:170px" value="<?php echo $nodoc2; ?>" readonly/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:38px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Event Institution</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
					<div style="width:400px;word-wrap: break-word;" id="event_institution_text"></div>
                    <div class="form-group" style="visibility:hidden">
                    <select class="form-control" id="event_institution" name="event_institution" style="height:30px">
                    </select>
                    </div>
                </div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Alamat</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="event_address" name="event_address" readonly
					  style="height:60px;width:350px;"><?php echo $event_address; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Fasilitas</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="facility" name="facility" readonly
					  style="height:60px;width:350px;"><?php echo $facility; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:38px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Doctor</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <select class="form-control" id="doctor" name="doctor" style="height:30px;">
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Event Date</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                    <input class="form-control" type="text" id="event_start_date" name="event_start_date" style="width:90px" value="<?php echo $event_start_date; ?>" readonly/>
                    </div>
                </div>  
                <div class="col-xs-1">&nbsp;-&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                    <input class="form-control" type="text" id="event_end_date" name="event_end_date" style="width:90px" value="<?php echo $event_end_date; ?>" readonly/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Judul Kegiatan Ilmiah</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="event_name" name="event_name" readonly
					  style="height:60px;width:350px;"><?php echo $event_name; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Kota</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="event_venue" name="event_venue" readonly
					  style="height:60px;width:350px;"><?php echo $event_venue; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Surat</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="letter" name="letter"
					  style="height:60px;width:350px;"><?php echo $letter; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Tanggal Surat Rujukan</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="letter_date" name="letter_date" type="text" style="width:90px" value="<?php echo $letter_date; ?>"/>
                    </div>
                </div>
            </div>
        <div class="row">
          <div class="col-xs-1" style="width:650px;"><hr/></div>
        </div>
            <button type="submit" id="save" class="btn btn-primary btn-sm" style="visibility:hidden">Save</button>
            <a type="button" href="<?php echo base_url(); ?>assets/uploads/ConfirmationLetter-<?php echo substr($created_date,-4);?>-HCP2-<?php echo date("m",strtotime($created_date));?>-<?php echo $nodoc2; ?>.docx?t=<?php echo time(); ?>" id="download" class="btn btn-primary btn-sm">Download File</a>
            <input type="hidden" id="id_group" value="<?php echo $this->session->userdata('id_group'); ?>">
            <input type="hidden" id="id_hcp2" name="id_hcp2" value="<?php echo $_GET['id_hcp2']; ?>">
            <?php if(isset($_GET['id'])) { ?>
            <input type="hidden" id="id_parent" name="id_parent" value="<?php echo $_GET['id']; ?>">
            <?php } ?>
        </form>
    </div>
</body>
<style type="text/css">
    .form-control {
        border-radius: 0.5rem;
        padding: 0px;
      font-size: 13px;
    }
</style>
<script type="text/javascript">    
    function toSeconds(t) 
    {
        var bits = t.split(':');
        return bits[0]*3600 + bits[1]*60;
    }

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/OfferLetter/getHospital",
          type: "GET",
          dataType: "text",
        success: function(response){
          var json = $.parseJSON(response);
          $('#event_institution').append('<option value="0">-- Please Select the Hospital --</option>');
          for (var i=0;i<json.length;++i)
          {
              $('#event_institution').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
		  <?php
			if(isset($_GET['id']))
			{
		  ?>
				  $.ajax({
					url: "<?php echo base_url(); ?>index.php/OfferLetter/getHospitalName?event_institution="+<?php echo $event_institution; ?>,
					  type: "GET",
					  dataType: "text",
					success: function(response){
						//alert(response);
					  $("#event_institution_text").text(response);
					},
					error: function(response)
					{
					},
				  });
          $("#event_institution").val('<?php echo $event_institution; ?>');
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/OfferLetter/getHospitalAddress?event_institution="+<?php echo $event_institution; ?>,
              type: "GET",
              dataType: "text",
            success: function(response){
              $("#event_address").val(response);
            },
            error: function(response)
            {
            },
          });
		  <?php
			}
			?>
        },
        error: function(response)
        {
        },
      });

      $("#event_institution").change(function(){
          var event_institution = this.value;
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/OfferLetter/getHospitalAddress?event_institution="+event_institution,
              type: "GET",
              dataType: "text",
            success: function(response){
              $("#event_address").val(response);
            },
            error: function(response)
            {
            },
          });
        });


    $(function () 
    {

        if($("#id_group").val()==11 || $("#id_group").val()==12)
        {
            var save = document.getElementById('save');
            $("#save").attr("style", "visibility:show");

            save.onclick = function() 
            {
                $("#facility").css('border','1px solid #cdcdcd');
                $("#doctor").css('border','1px solid #cdcdcd');
                $("#event_venue").css('border','1px solid #cdcdcd');
                $("#nodoc2").css('border','1px solid #cdcdcd');
                $("#event_institution").css('border','1px solid #cdcdcd');
                $("#event_address").css('border','1px solid #cdcdcd');
                $("#event_start_date").css('border','1px solid #cdcdcd');
                $("#event_end_date").css('border','1px solid #cdcdcd');
                $("#event_end_time").css('border','1px solid #cdcdcd');
                $("#event_start_time").css('border','1px solid #cdcdcd');
                var error = "0";
                if(toSeconds($("#event_start_time").val())>=toSeconds($("#event_end_time").val()))
                {
                    $("#event_start_time").css('border','1px solid #ff0000');
                    error = "1";
                }
                if ($.datepicker.parseDate('dd/mm/yy', $("#event_start_date").val()) > $.datepicker.parseDate('dd/mm/yy', $("#event_end_date").val())) 
                {
                    $("#event_start_date").css('border','1px solid #ff0000');
                    error = "1";
                }        
                if($("#nodoc2").val().trim()=="")
                {
                    $("#nodoc2").css('border','1px solid #ff0000');
                    error = "1";
                }
                if($("#doctor").val().trim()=="")
                {
                    $("#doctor").css('border','1px solid #ff0000');
                    error = "1";
                }
                if($("#facility").val().trim()=="")
                {
                    $("#facility").css('border','1px solid #ff0000');
                    error = "1";
                }
                if($("#event_venue").val().trim()=="")
                {
                    $("#event_venue").css('border','1px solid #ff0000');
                    error = "1";
                }
                if($("#event_address").val().trim()=="")
                {
                    $("#event_address").css('border','1px solid #ff0000');
                    error = "1";
                }
                if($("#event_institution").val().trim()=="")
                {
                    $("#event_institution").css('border','1px solid #ff0000');
                    error = "1";
                }
                if($("#event_start_date").val().trim()=="")
                {
                    $("#event_start_date").css('border','1px solid #ff0000');
                    error = "1";
                }
                if($("#event_end_date").val().trim()=="")
                {
                    $("#event_end_date").css('border','1px solid #ff0000');
                    error = "1";
                }
                if($("#event_start_time").val().trim()=="")
                {
                    $("#event_start_time").css('border','1px solid #ff0000');
                    error = "1";
                }
                if($("#event_end_time").val().trim()=="")
                {
                    $("#event_end_time").css('border','1px solid #ff0000');
                    error = "1";
                }

                if(error=="1")
                {
                return false;
                }
            }

        }

        function validateNumber(event) {
            var key = window.event ? event.keyCode : event.which;
            /*if (event.keyCode === 8 || event.keyCode === 46) {
                return true;
            } else*/ if ( key < 48 || key > 57 ) {
                return false;
            } else {
                return true;
            }
        };

        $("#event_start_time").timepicker(
            {
            timeFormat: 'H:mm',
            interval: 15,          
            dropdown: true,
            scrollbar: true
            }
        );
        $("#event_end_time").timepicker(
            {
            timeFormat: 'H:mm',
            interval: 15,          
            dropdown: true,
            scrollbar: true
            }
        );

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/ConfirmationLetterHCP/getDoctor?id="+<?php echo $doctor; ?>,
          type: "GET",
          dataType: "text",
        success: function(response){
          var json = $.parseJSON(response);
          for (var i=0;i<json.length;++i)
          {
              $('#doctor').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
          $("#doctor").val('<?php echo $doctor; ?>');
        },
        error: function(response)
        {
        },
      });

//        $("#event_start_date").datepicker({dateFormat: 'dd/mm/yy'});
//        $("#event_end_date").datepicker({dateFormat: 'dd/mm/yy'});
        $("#event_date").datepicker({dateFormat: 'dd/mm/yy'});
        $("#letter_date").datepicker({dateFormat: 'dd/mm/yy'});
    });
</script>
</head>
