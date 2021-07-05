<head>
    <title>SPEAKER AGREEMENT LETTER - HCP CONSULTANT</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<body style="font-size:13px">
    <div class="container-fluid">
    <?php
        $readonly = "";
        $name_doctor = "";
		$query = $this->db->query("select name from doctor where id_doctor='".$doctor."'");
		foreach ($query->result() as $row2)
		{			
            $name_doctor = $row2->name;
		}
        if(isset($_GET['id'])) 
        { 
          $readonly="readonly"; 
        } 

    ?>
        <form action="<?php echo base_url().'index.php/PermitLetter/add'; ?>" method="post"> 
            <div class="row">
            <div class="col-xs-1" style="background:#efefef;text-align:center;width:650px">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:650px"><img src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:650px">
                    <b>PERMIT LETTER - HCP CONSULTANT SPEAKER</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:right;width:240px">
                <b>Doc No.&nbsp;&nbsp;</b>
                </div>
                <span style="background:#efefef;"><?php echo substr($created_date,-4);?>/PL/<?php echo date("m",strtotime($created_date));?>/</span><div class="col-xs-1" style="height:30px;background:#efefef;width:337px">
                <div class="form-group">
                    <input class="form-control" type="text" id="nodoc2" name="nodoc2" style="width:150px" value="<?php echo $nodoc2; ?>" readonly/>
                </div>
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
                <div class="col-xs-1" style="width:220px">Leader</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="leader" name="leader"  type="text" style="width:350px" value="<?php echo $leader; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Department</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="department" name="department"  type="text" style="width:350px" value="<?php echo $department; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Event Title</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                      <input class="form-control" id="event_title" name="event_title" type="text" style="width:350px" value="<?php echo $event_title; ?>"  readonly/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:108px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Event Description</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
					  <textarea
						rows="5"
						class="form-control"
						id="event_description"
						name="event_description"                
						style="width:350px;border-bottom:1px solid black;border-left:1px solid black;border-left:1px solid black;font-style: italic;"
					  ><?php echo $event_description; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Event Organizer</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                      <input class="form-control" id="event_organizer" name="event_organizer" type="text" style="width:350px" value="<?php echo $event_organizer; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Topic</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="topic" name="topic" type="text" style="width:350px" value="<?php echo $topic; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Type</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="type" name="type" type="text" style="width:350px" value="<?php echo $type; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:108px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Facility</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
					  <textarea
						rows="5"
						class="form-control"
						id="facility"
						name="facility"                
						style="width:350px;border-bottom:1px solid black;border-left:1px solid black;border-left:1px solid black;font-style: italic;"
					  ><?php echo $facility; ?></textarea>
                    </div>
                </div>
            </div>
                    <div class="form-group">
                        <select class="form-control" id="doctor" name="doctor" style="visibility:hidden;height:30px;">
                        </select>
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
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Event Date (Detail)</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                    <input class="form-control" type="text" id="event_start_date2" name="event_start_date2" style="width:90px" value="<?php echo $event_start_date2; ?>"/>
                    </div>
                </div>  
                <div class="col-xs-1">&nbsp;-&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                    <input class="form-control" type="text" id="event_end_date2" name="event_end_date2" style="width:90px" value="<?php echo $event_end_date2; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:38px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Event Institution</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
					  <select class="form-control" id="event_institution" name="event_institution" style="height:30px">
					  </select>
                    </div>
                </div>  
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:220px">Event Venue</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="event_venue" name="event_venue" type="text" style="width:350px" value="<?php echo $event_venue; ?>" readonly/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:650px"><hr/></div>
            </div>
            <button type="submit" id="save" class="btn btn-primary btn-sm" style="visibility:hidden">Save</button>
            <a type="button" href="<?php echo base_url(); ?>assets/uploads/OfferLetter-<?php echo substr($created_date,-4);?>-SERF-<?php echo date("m",strtotime($created_date));?>-<?php echo $nodoc2; ?>.docx" id="download" class="btn btn-primary btn-sm">Download File</a>
            <input type="hidden" id="id_group" value="<?php echo $this->session->userdata('id_group'); ?>">
            <input type="hidden" id="id_sc" name="id_hcp" value="<?php echo $_GET['id_hcp']; ?>">
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

    $(function () 
    {

        if($("#id_group").val()==11 || $("#id_group").val()==5)
        {
            var save = document.getElementById('save');
            $("#save").attr("style", "visibility:show");
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


      $.ajax({
        url: "<?php echo base_url(); ?>index.php/OfferLetter/getHospital",
          type: "GET",
          dataType: "text",
        success: function(response){
          var json = $.parseJSON(response);
          for (var i=0;i<json.length;++i)
          {
              $('#event_institution').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
          $("#event_institution").val('<?php echo $event_institution; ?>');
        },
        error: function(response)
        {
        },
      });

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/AgreementLetter2/getDoctor?id="+<?php echo $doctor; ?>,
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


        $("#event_start_date2").datepicker({dateFormat: 'dd/mm/yy'});
        $("#event_end_date2").datepicker({dateFormat: 'dd/mm/yy'});
        $("#letter_date").datepicker({dateFormat: 'dd/mm/yy'});
    });
</script>
</head>
