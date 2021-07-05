<head>
    <meta name="viewport" content="width=1024">
    <title>SCIENTIFIC EVENT REQUEST FORM</title>
  <link
    rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous"
  />
	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
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
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.1.0/bootstrap-4.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>


  <body style="font-size:13px">
    <div class="container-fluid" style="border:1px solid black;padding-left:22px;padding-right:8px;padding-bottom:8px;padding-top:8px;width:922px">
      <?php 
        $readonly = "";
        $readonly_note1="readonly";
        $readonly_note2="readonly";
        $readonly_note3="readonly";
        if(isset($_GET['access']))
        {
          if($_GET['access']==6 && $state==2)
          {
            $readonly_note1="";
          }
          if($_GET['access']==5 && $state==3)
          {
            $readonly_note2="";
          }
          if($_GET['access']==4 && $state==4)
          {
            $readonly_note3="";
          }
        }
        else
        {
          $_GET['access']=$this->session->userdata('id_group');
          if($this->session->userdata('id_group')==6 && $state==2)
          {
            $readonly_note1="";
          }
          if($this->session->userdata('id_group')==5 && $state==3)
          {
            $readonly_note2="";
          }
          if($this->session->userdata('id_group')==4 && $state==4)
          {
            $readonly_note3="";
          }
        }  
        if(isset($_GET['id'])) 
        { 
          $readonly="readonly"; 
        } 

      ?>
      <form action="<?php echo base_url().'index.php/Scientific/add'; ?>" method="post">
        
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:900px">&nbsp;</div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:900px"><img src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:900px">
            <b>SCIENTIFIC EVENT REQUEST FORM</b>
          </div>
        </div>
      <div class="row">
        <div class="col-xs-1" style="background:#efefef;text-align:right;width:360px">
          <b>Doc No.&nbsp;&nbsp;</b>
        </div>
        <span style="background:#efefef;"><?php echo substr($created_date,-4);?>/SERF/<?php echo date("m",strtotime($created_date));?>/</span><div class="col-xs-1" style="height:30px;background:#efefef;width:455px">
          <div class="form-group">
            <input class="form-control" type="text" id="nodoc" name="nodoc" style="width:150px" value="<?php echo $nodoc; ?>" readonly/>
          </div>
        </div>
      </div>
        <div class="row">
          <div class="col-xs-1" style="width:900px"><hr/></div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px"><b>Date</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1"><?php echo date("d/m/Y"); ?>
          </div>
        </div>
        <div class="row" style="height:38px">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Name of Event Initiator</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <select class="form-control" id="requested_by1" name="requested_by1" style="height:30px;width:170px">
              </select>
            </div>
          </div>
          <div class="col-xs-1" style="width:60px">&nbsp;</div>
          <div class="col-xs-1" style="width:60px"><b>Leader</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <select class="form-control" id="requested_by2" name="requested_by2" style="height:30px">
              </select>
            </div>
          </div>
        </div>
        <div class="row" style="height:68px">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px"><b>Topic</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="topic" name="topic"
				  style="height:60px;width:210px;"><?php echo $topic; ?></textarea>
			  </div>
			</div>
          <div class="col-xs-1" style="width:20px">&nbsp;</div>
          <div class="col-xs-1" style="width:60px"><b>City</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input class="form-control" id="event_city" name="event_city" type="text" style="width:270px" value="<?php echo $event_city; ?>"/>
            </div>
          </div>
        </div>
        <div class="row" style="height:30px">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px"><b>Time</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input class="form-control" type="text" id="event_start_time" name="event_start_time" style="width:90px" value="<?php echo $event_start_time; ?>"/>
            </div>
          </div>  
          <div class="col-xs-1">&nbsp;-&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input class="form-control" type="text" id="event_end_time" name="event_end_time" style="width:90px" value="<?php echo $event_end_time; ?>"/>
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px"><b>Date Event</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input class="form-control" type="text" id="event_start_date" name="event_start_date" style="width:90px" value="<?php echo $event_start_date; ?>"/>
            </div>
          </div>  
          <div class="col-xs-1">&nbsp;-&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input class="form-control" type="text" id="event_end_date" name="event_end_date" style="width:90px" value="<?php echo $event_end_date; ?>"/>
            </div>
          </div>
          <div class="col-xs-1" style="width:40px">&nbsp;</div>
          <div class="col-xs-1" style="width:60px"><b>Venue</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input class="form-control" id="event_venue" name="event_venue" type="text" style="width:270px" value="<?php echo $event_venue; ?>"/>
            </div>
          </div>
        </div>
        <div class="row" style="height:38px">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px"><b>Objective</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <select class="form-control" id="event_objective" name="event_objective"  style="height:30px;width:570px">
                <option value="1">Introduce Taisho & Increase brand awareness in Dentist untuk PP di Dentist</option>
                <option value="2">Introduce Taisho & Increase brand awareness in Pediatrician untuk PP di Pediatrician</option>
                <option value="3">Introduce Taisho & Increase brand awareness in Dermatologist untuk PP di Dermatologist</option>
                <option value="4">Update Knowledge of Oral Inflammation and The Management untuk RTD di Dentist</option>
                <option value="5">Update Knowledge of Atopic Dermatitis and The Management untuk RTD di Pediatric, Dermatologist, Pharmacist</option>
                <option value="6">Update Knowledge of Stomatitis and The Management, increase brand awareness untuk BME di Pharmacist</option>
                <option value="7">Other</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row" style="height:68px">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px"><b>Other Objective</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="event_objective2" name="event_objective2"
				  style="height:60px;width:350px;"><?php echo $event_objective2; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:38px">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px"><b>Type of Activity</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <select class="form-control" id="event_activity" name="event_activity"  style="height:30px">
                <option value="1">Product Presentation</option>
                <option value="2">Round Table Discussion</option>
                <option value="3">Symposia by External Presenter</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row" style="height:68px">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px"><b>Agenda</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="event_agenda" name="event_agenda"
				  style="height:60px;width:350px;"><?php echo $event_agenda; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:68px">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Slide Presentation will be used</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group" style="width:300px">
              <textarea
                rows="2"
                class="form-control"
                id="event_slide"
                name="event_slide"
				style="height:60px;width:350px;"
              ><?php echo $event_slide; ?></textarea
              >
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>No of Planned Physicians Participants</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input
                class="form-control"
                id="physician"
                name="physician"
                type="text"
                style="width:70px"
                value="<?php echo $physician; ?>"
                maxlength="3"
              />
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>No of Planned Others (Nurse/Pharmacist)</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input
                class="form-control"
                id="nurse"
                name="nurse"
                type="text"
                style="width:70px"
                value="<?php echo $nurse; ?>"
                maxlength="3"
              />
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>No of Taisho Representatives</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input
                class="form-control"
                id="taisho"
                name="taisho"
                type="text"
                style="width:70px"
                value="<?php echo $taisho; ?>"
                maxlength="3"
              />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1">&nbsp;</div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:500px">
            <b>BUDGET PLAN : ACCOUNT 22613 - SCIENTIFIC MEETING</b>
          </div>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;width:355px;text-align:center"
          >
            <b>&nbsp;Category&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:150px;text-align:center"
          >
            <b>&nbsp;Budget Per Person (IDR)&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center"
          >
            <b>&nbsp;Total Budget (IDR)&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center"
          >
            <b>&nbsp;Remark&nbsp;</b>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:355px;">
            &nbsp;Meal&nbsp;
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="budget1"
                name="budget1"
                class="form-control"
                type="text"
                value="<?php echo $budget1; ?>"
                style="width:150px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="total_budget1"
                name="total_budget1"
                class="form-control"
                type="text"
                value="<?php echo $total_budget1; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="remark1"
                name="remark1"
                class="form-control"
                type="text"
                value="<?php echo $remark1; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:355px;">
            &nbsp;Meeting Room Rent Fee/Institution Fee&nbsp;
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="budget2"
                name="budget2"
                class="form-control"
                type="text"
                value="<?php echo $budget2; ?>"
                style="width:150px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="total_budget2"
                name="total_budget2"
                class="form-control"
                type="text"
                value="<?php echo $total_budget2; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="remark2"
                name="remark2"
                class="form-control"
                type="text"
                value="<?php echo $remark2; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:355px;">
            &nbsp;Association / Organisation Fee&nbsp;
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="budget3"
                name="budget3"
                class="form-control"
                type="text"
                value="<?php echo $budget3; ?>"
                style="width:150px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="total_budget3"
                name="total_budget3"
                class="form-control"
                type="text"
                value="<?php echo $total_budget3; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="remark3"
                name="remark3"
                class="form-control"
                type="text"
                value="<?php echo $remark3; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:355px;">
            &nbsp;Speaker 1 Fee&nbsp;
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="budget4"
                name="budget4"
                class="form-control"
                type="text"
                value="<?php echo $budget4; ?>"
                style="width:150px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="total_budget4"
                name="total_budget4"
                class="form-control"
                type="text"
                value="<?php echo $total_budget4; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="remark4"
                name="remark4"
                class="form-control"
                type="text"
                value="<?php echo $remark4; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:355px;">
            &nbsp;Speaker 2 Fee&nbsp;
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="budget5"
                name="budget5"
                class="form-control"
                type="text"
                value="<?php echo $budget5; ?>"
                style="width:150px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="total_budget5"
                name="total_budget5"
                class="form-control"
                type="text"
                value="<?php echo $total_budget5; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="remark5"
                name="remark5"
                class="form-control"
                type="text"
                value="<?php echo $remark5; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:355px;">
            &nbsp;Moderator Fee&nbsp;
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="budget6"
                name="budget6"
                class="form-control"
                type="text"
                value="<?php echo $budget6; ?>"
                style="width:150px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="total_budget6"
                name="total_budget6"
                class="form-control"
                type="text"
                value="<?php echo $total_budget6; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="remark6"
                name="remark6"
                class="form-control"
                type="text"
                value="<?php echo $remark6; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:355px;">
            &nbsp;Flight Ticket Speaker / Moderator (if any)&nbsp;
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="budget7"
                name="budget7"
                class="form-control"
                type="text"
                value="<?php echo $budget7; ?>"
                style="width:150px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="total_budget7"
                name="total_budget7"
                class="form-control"
                type="text"
                value="<?php echo $total_budget7; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="remark7"
                name="remark7"
                class="form-control"
                type="text"
                value="<?php echo $remark7; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:355px;">
            &nbsp;Accommodation Speaker / Moderator (if any)&nbsp;
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="budget8"
                name="budget8"
                class="form-control"
                type="text"
                value="<?php echo $budget8; ?>"
                style="width:150px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="total_budget8"
                name="total_budget8"
                class="form-control"
                type="text"
                value="<?php echo $total_budget8; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <input
                id="remark8"
                name="remark8"
                class="form-control"
                type="text"
                value="<?php echo $remark8; ?>"
                style="width:200px;height:30px;"
              />
            </div>
          </div>
        </div>
        <div class="field_wrapper">
        <?php
          if($budget==8)
          { 
              $sponsor_text = "sponsor9";
              $remark_text = "remark9";
              $budget_text = "budget9";            
              $total_budget_text = "total_budget9";            
            ?>
        <div class="row" style="height:30px;"> 
          <div
            class="col-xs-1"
            style="width:355px;"
          >
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:355px;height:30px"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:150px;"
          >
            <input
              id="budget"
              name="budget[]"
              class="form-control"
              type="text"
              value="<?php echo $$budget_text; ?>"
              style="width:150px;height:30px"  maxlength="10"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <input
              id="total_budget"
              name="total_budget[]"
              class="form-control"
              type="text"
              value="<?php echo $$total_budget_text; ?>"
              style="width:200px;height:30px"  maxlength="10"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <input
              id="remark"
              name="remark[]"
              class="form-control"
              type="text"
              value="<?php echo $$remark_text; ?>"
              style="width:200px;height:30px"
            />
          </div>
          <div class="col-xs-1" style="width:25px">
            <a href="javascript:void(0);" class="add_button"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a>
          </div>                  
        </div>
          <?php   
          }
          if($budget>8)
          {
            for($i=8;$i<$budget;$i++)
            {
              $sponsor_text = "sponsor".($i+1);
              $remark_text = "remark".($i+1);
              $budget_text = "budget".($i+1);
              $total_budget_text = "total_budget".($i+1);            
              $total_text = "total".($i+1);
        ?>
        <div class="row" style="height:30px;"> 
          <div
            class="col-xs-1"
            style="width:355px;"
          >
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:355px;height:30px"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:150px;"
          >
            <input
              id="budget"
              name="budget[]"
              class="form-control"
              type="text"
              value="<?php echo $$budget_text; ?>"
              style="width:150px;height:30px"  maxlength="10"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <input
              id="total_budget"
              name="total_budget[]"
              class="form-control"
              type="text"
              value="<?php echo $$total_budget_text; ?>"
              style="width:200px;height:30px"  maxlength="10"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <input
              id="remark"
              name="remark[]"
              class="form-control"
              type="text"
              value="<?php echo $$remark_text; ?>"
              style="width:200px;height:30px"
            />
          </div>
          <div class="col-xs-1" style="width:25px">
          <?php 
            if($i==8)
            {  
          ?>
            <a href="javascript:void(0);" class="add_button"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a>
            <?php } else { ?>    
            <a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a>
            <?php } ?>  
          </div>                  
        </div>
        <?php 
          }
        }
        ?>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;width:355px;border-top:1px solid black;text-align:center;border-bottom:1px solid black;"
          >
            &nbsp;<b>TOTAL</b>&nbsp;
          </div>
          <div
            class="col-xs-1" id="total1"
            style="border-left:1px solid black;width:150px;border-top:1px solid black;text-align:center;border-bottom:1px solid black;"
          >
            &nbsp;
          </div>
          <div
            class="col-xs-1" id="total2"
            style="border-left:1px solid black;width:200px;border-top:1px solid black;text-align:center;border-bottom:1px solid black;"
          >
            &nbsp;
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;width:200px;border-right:1px solid black;border-top:1px solid black;text-align:center;border-bottom:1px solid black;"
          >
            &nbsp;
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:300px">
            &nbsp;
          </div>
        </div>
        <div class="institution">
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Name of Institution</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="institution_name" name="institution_name"
				  style="height:60px;width:350px;"><?php echo $institution_name; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Purpose</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="institution_purpose" name="institution_purpose"
				  style="height:60px;width:350px;"><?php echo $institution_purpose; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Estimated Fee</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="institution_fee" name="institution_fee"
				  style="height:60px;width:350px;"><?php echo $institution_fee; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Bank Account</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="institution_bank" name="institution_bank"
				  style="height:60px;width:350px;"><?php echo $institution_bank; ?></textarea>
			  </div>
			</div>
        </div>
        </div>
        <div class="association">
        <div class="row">
          <div class="col-xs-1">&nbsp;</div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Name of Association</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="assoc_name" name="assoc_name"
				  style="height:60px;width:350px;"><?php echo $assoc_name; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Purpose</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="assoc_purpose" name="assoc_purpose"
				  style="height:60px;width:350px;"><?php echo $assoc_purpose; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Estimated Fee</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="assoc_fee" name="assoc_fee"
				  style="height:60px;width:350px;"><?php echo $assoc_fee; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>Bank Account</b>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="assoc_bank" name="assoc_bank"
				  style="height:60px;width:350px;"><?php echo $assoc_bank; ?></textarea>
			  </div>
			</div>
        </div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:300px">
            &nbsp;
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:300px">
            <b>CHARGED TO PRODUCTS (%)</b>
          </div>
        </div>
        <div class="row" style="height:30px">
          <div
            class="col-xs-1"
            style="width:150px;text-align:center;"
          >
            <div class="form-group">
              <select class="form-control" name="product1" id="product1" style="height:30px">
              </select>
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:150px;text-align:center;"
          >
            <div class="form-group">
              <select class="form-control" name="product2" id="product2" style="height:30px">
              </select>
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:150px;text-align:center;"
          >
            <div class="form-group">
              <select class="form-control" name="product3" id="product3" style="height:30px;">
              </select>
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:150px;text-align:center;"
          >
            <div class="form-group">
              <select class="form-control" name="product4" id="product4" style="height:30px">
              </select>
            </div>
          </div>
        </div>
        <div class="row" style="height:30px">
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="product_percent1"
                name="product_percent1"
                class="form-control"
                type="text"
                maxlength="3"
                value="<?php echo $product_percent1; ?>"
                style="width:150px;height:30px"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="product_percent2"
                name="product_percent2"
                class="form-control"
                type="text"
                maxlength="3"
                value="<?php echo $product_percent2; ?>"
                style="width:150px;height:30px"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="product_percent3"
                name="product_percent3"
                class="form-control"
                type="text"
                maxlength="3"
                value="<?php echo $product_percent3; ?>"
                style="width:150px;height:30px"
              />
            </div>
          </div>
          <div class="col-xs-1" style="width:150px">
            <div class="form-group">
              <input
                id="product_percent4"
                name="product_percent4"
                class="form-control"
                type="text"
                maxlength="3"
                value="<?php echo $product_percent4; ?>"
                style="width:150px;height:30px"
              />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1">&nbsp;</div>
        </div>
        <?php if(isset($_GET['id'])==true)  {?>
        <div class="row">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:150px">
            <b>Attachment :</b>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:290px">
            <div class="form-group">
              <select class="form-control" id="file_type" style="height:30px">
                <option value="1">Proposal (Optional)</option>
                <option value="2">Participant List (Mandatory)</option>
              </select>
            </div>
          </div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input type="file" class="form-control-file" id="file_name" name="file_name" />
            </div>
          </div>
          <div class="col-xs-1">
            <div class="form-group">
              <button type="button" id="upload" class="btn btn-primary btn-sm"><i class="fa fa-upload" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Upload</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:440px;text-align:center;border-bottom:1px solid black;"
          >
            <b>&nbsp;File Name&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:160px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;"
          >
            <b>&nbsp;Type&nbsp;</b>
          </div>
        </div>
        <div id="attachment">
        </div>
        <div class="row">
          <div class="col-xs-1">&nbsp;</div>
        </div>
        <div class="row">
          <div class="col-xs-1">
			<iframe width="900" height="564" src="<?php echo base_url(); ?>index.php/ScientificHCP/index/id/<?php echo $_GET['id']; ?>"></iframe>
		  </div>
        </div>
        <!--a type="button" id="invite" class="btn btn-primary btn-sm" href="javascript:invite('<?php echo base_url(); ?>index.php/ScientificHCP/index/id/<?php echo $_GET['id']; ?>');">Scientific HCP</a-->
        <?php  } ?>
        <div class="row">
          <div class="col-xs-1" style="width:200px">&nbsp;</div>
          <div class="col-xs-1" style="width:200px">&nbsp;</div>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;width:800px;border-right:1px solid black;border-top:1px solid black"
          >
            &nbsp;<b>APPROVAL AND NOTES</b>&nbsp;
          </div>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center"
          >
            <b>&nbsp;Proposed By&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center"
          >
            <b>&nbsp;Reviewed&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center"
          >
            <b>&nbsp;Reviewed&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center"
          >
            <b>&nbsp;Approval&nbsp;</b>
          </div>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center"
          >
            &nbsp;<br>Prepared by<br/><?php if($state>1)  { echo $approver0;  } else { echo $GLOBALS['approver0']; } ?><br />(<?php echo $created_date;   ?>)<br /><br /><?php if($state>1)  { echo $title0;  } else { echo $GLOBALS['title0']; } ?><br />&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center"
          >
            &nbsp;<br />Reviewed by<br/><?php if($state>2)  { echo $approver1;  } else { echo $GLOBALS['approver1']; } ?><br />(<?php  if($state>2)  { echo $updated_date1;  } ?>)<br /><br /><?php if($state>2)  { echo $title1;  } else { echo $GLOBALS['title1']; } ?><br />&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center"
          >
            &nbsp;<br />Reviewed by<br/><?php if($state>3)  { echo $approver2;  } else { echo $GLOBALS['approver2']; } ?><br />(<?php  if($state>3)  { echo $updated_date2;  } ?>)<br /><br /><?php if($state>3)  { echo $title2;  } else { echo $GLOBALS['title2']; } ?><br />&nbsp;
          </div>
          <div class="col-xs-1" style="border-right:1px solid black;border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center">
            &nbsp;<br />Approved by<br/><?php if($state>4)  { echo $approver3;  } else { echo $GLOBALS['approver3']; } ?><br />(<?php  if($state>4)  { echo $updated_date3;  } ?>)<br /><br /><?php if($state>4)  { echo $title3;  } else { echo $GLOBALS['title3']; } ?><br />&nbsp;
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:200px;text-align:center;border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid black;height:90px">
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <textarea
                rows="3"
                class="form-control"
                id="note1"
                name="note1"
                <?php echo $readonly_note1; ?>
                style="height:90px;width:200px;border:1px solid black;"
              ><?php echo $note1; ?></textarea>
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <textarea
                rows="3"
                class="form-control"
                id="note2"
                name="note2"
                <?php echo $readonly_note2; ?>
                style="height:90px;width:200px;border:1px solid black;"
              ><?php echo $note2; ?></textarea>
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <textarea rows="3" class="form-control" id="note3" name="note3" <?php echo $readonly_note3; ?>
                style="height:90px;width:200px;border:1px solid black;"><?php echo $note3; ?></textarea>
            </div>
          </div>
        </div>
			<div class="row">
			  <div class="col-xs-1" style="width:900px;"><?php if($state=="6")	{ echo "Document has been fully approved"; } ?></div>
			</div>
			<div class="row">
			  <div class="col-xs-1" style="width:900px;">&nbsp;</div>
			</div>
			<div class="row">
			  <div class="col-xs-1" style="width:900px;"><i style='color:red'>* Note is mandatory to be filled if Reviewer / Approver want to Reject / Review this document</i></div>
			</div>
        <div class="row">
          <div class="col-xs-1" style="width:900px"><hr/></div>
        </div>
        <button type="submit" id="save" class="btn btn-primary btn-sm" style="visibility:hidden"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Save</button>
        <button type="submit" id="request_approval" class="btn btn-success btn-sm" style="visibility:hidden"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Request Approval</button>
        <button type="submit" id="review" class="btn btn-warning btn-sm" style="visibility:hidden"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Review</button>
        <button type="submit" id="approve" class="btn btn-success btn-sm" style="visibility:hidden"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Approve</button>
        <button type="submit" id="reject" class="btn btn-danger btn-sm" style="visibility:hidden"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Reject</button>
        <button type="submit" id="freeze" class="btn btn-primary btn-sm" style="visibility:hidden"><i class="fa fa-pause" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Freeze</button>
        <button type="button" id="print" style="visibility:hidden" class="btn btn-primary btn-sm" onclick="printPage();"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Print</button>
         <input type="hidden" id="list_attachment" value="">
        <input type="hidden" id="state" value="<?php echo $state; ?>">
        <?php if(isset($_GET['access'])) { ?>        
        <input type="hidden" id="id_group" value="<?php echo $_GET['access']; ?>">
        <?php } else { ?>
        <input type="hidden" id="id_group" value="<?php echo $this->session->userdata('id_group'); ?>">
        <?php } ?>
        <input type="hidden" id="id_mer" name="id_mer" value="<?php echo $_GET['id_mer']; ?>">
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
  .btn {
    border-radius: 1rem;
  }
  </style>
  <script type="text/javascript">
	if($("#state").val()!=6)
	{	
		document.addEventListener('contextmenu', event => {
		  event.preventDefault()
		});
		document.body.addEventListener('keydown', event => {
		  if (event.ctrlKey && 'p'.indexOf(event.key) !== -1) {
			event.preventDefault()
		  }
		});
	}	
	if($("#state").val()==6 && ($("#id_group").val()==11 || $("#id_group").val()==7 || $("#id_group").val()==6 || $("#id_group").val()==5 || $("#id_group").val()==4))
	{
      $("#print").attr("style", "visibility:show");
	}		
	function printPage()
	{
		window.print();
	}

    var error = "0";
	var error_text = "";
	numeral.register('locale', 'id', {
		delimiters: {
			thousands: '.',
			decimal: ','
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

	$('input[name^="budget[]"]').css("text-align","right");
    $('[id^=budget]').css("text-align","right");
	$('input[name^="total_budget[]"]').css("text-align","right");
    $('[id^=total_budget]').css("text-align","right");
    $('[id^=total]').css("text-align","right");

    function invite(url)
    {
      window.open(url,'_blank');
    }

    function toSeconds(t) 
    {
        var bits = t.split(':');
        return bits[0]*3600 + bits[1]*60;
    }

    if($("#id_group").val()==7 && $("#state").val()==1 && $("#id_parent").val()!=null)
    {
      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_sc = <?php echo $_GET['id'];  ?>;
      <?php  } else { ?>
        id_sc = "";
      <?php  } ?>

      var request_approval = document.getElementById('request_approval');
      $("#request_approval").attr("style", "visibility:show");

      request_approval.onclick = function() 
      {
        $("#save").click();
        if(error==0)
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/Scientific/updateState?id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
              type: "GET",
              dataType: "text",
              success: function(response){
            },
            error: function(response)
            {
            },
          });
        }  
      }

    }  

    if(($("#id_group").val()==6 && $("#state").val()==2) || ($("#id_group").val()==5 && $("#state").val()==3) || ($("#id_group").val()==4 && $("#state").val()==4))
    {
      var review = document.getElementById('review');
      var approve = document.getElementById('approve');
      var reject = document.getElementById('reject');
      $("#note1").css('border','1px solid #cdcdcd');
      $("#note2").css('border','1px solid #cdcdcd');
      $("#note3").css('border','1px solid #cdcdcd');

		  <?php if($active==0)	
		  {			
		  ?>
			$("#freeze").text("Activate");
			  $("#freeze").attr("style", "visibility:show");
			  $("#review").attr("style", "visibility:hidden");
			  $("#approve").attr("style", "visibility:hidden");
			  $("#reject").attr("style", "visibility:hidden");
		  <?php
		  } else	
		  {			
		  ?>
			$("#freeze").text("Freeze");
      $("#freeze").attr("style", "visibility:show");
      $("#review").attr("style", "visibility:show");
      $("#approve").attr("style", "visibility:show");
      $("#reject").attr("style", "visibility:show");
		  <?php
		  }			
		   ?>	

//      $("#review").attr("style", "visibility:show");
//      $("#reject").attr("style", "visibility:show");
//      $("#approve").attr("style", "visibility:show");

      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_sc = <?php echo $_GET['id'];  ?>;
      <?php  } else { ?>
        id_sc = "";
      <?php  } ?>

      review.onclick = function() 
      {
        if(($("#id_group").val()==6 && $("#note1").val()!="") || ($("#id_group").val()==5 && $("#note2").val()!="") || ($("#id_group").val()==4 && $("#note3").val()!=""))
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/Scientific/updateState2?id="+id_sc,
              type: "GET",
              dataType: "text",
              success: function(response){
					Swal.fire({
					  position: 'top-end',
					  icon: 'warning',
					  title: 'This request has been returned to Requestor',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					});
            },
            error: function(response)
            {
            },
          });
        }  
        else
        {
          if($("#id_group").val()==6)
          {
            $("#note1").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==5)
          {
            $("#note2").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==4)
          {
            $("#note3").css('border','1px solid #ff0000');
          }
          return false;
        }
      }

      approve.onclick = function() 
      {
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/Scientific/updateState?id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
            type: "GET",
            dataType: "text",
            success: function(response){
					Swal.fire({
					  position: 'top-end',
					  icon: 'success',
					  title: 'This Request has been Approved',
					  showConfirmButton: true,
					  confirmButtonText: 'Close'
					});				
          },
          error: function(response)
          {
          },
        });
      }

      freeze.onclick = function() 
      {
		  var active = 1;
		  <?php if($active==0)	
		  {			
		  ?>
			active = 1;
		  <?php
		  } else	
		  {			
		  ?>
			active = 0;
		  <?php
		  }			
		  ?>
		   $.ajax({
				url: "<?php echo base_url(); ?>index.php/Scientific/updateState4?active="+active+"&id="+id_sc,
				type: "GET",
				dataType: "text",
				success: function(response){
					if(active==0)
					{	
						Swal.fire({
						  position: 'top-end',
						  icon: 'info',
						  title: 'This Request has been Locked',
						  showConfirmButton: true,
						  confirmButtonText: 'Close'
						});
					}
					else if(active==1)
					{
						Swal.fire({
						  position: 'top-end',
						  icon: 'info',
						  title: 'This Request has been UnLocked',
						  showConfirmButton: true,
						  confirmButtonText: 'Close'
						});
					}
			  },
			  error: function(response)
			  {
			  },
			});
      }


      reject.onclick = function() 
      {
        if(($("#id_group").val()==6 && $("#note1").val()!="") || ($("#id_group").val()==5 && $("#note2").val()!="") || ($("#id_group").val()==4 && $("#note3").val()!=""))
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/Scientific/updateState3?id="+id_sc,
              type: "GET",
              dataType: "text",
              success: function(response){
				Swal.fire({
				  position: 'top-end',
				  icon: 'error',
				  title: 'This Request has been Rejected',
				  showConfirmButton: true,
				  confirmButtonText: 'Close'
				});
            },
            error: function(response)
            {
            },
          });
        }  
        else
        {
          if($("#id_group").val()==6)
          {
            $("#note1").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==5)
          {
            $("#note2").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==4)
          {
            $("#note3").css('border','1px solid #ff0000');
          }
          return false;
        }
      }

    }  

    if(($("#id_group").val()==7 || $("#id_group").val()==8 || $("#id_group").val()==9 || $("#id_group").val()==10) && $("#state").val()==1)
    {
      var save = document.getElementById('save');
      $("#save").attr("style", "visibility:show");

      save.onclick = function() 
      {
		error_text = "";  
		error = "0";
        $("#product_percent1").css('border','1px solid #cdcdcd');
        $("#product_percent2").css('border','1px solid #cdcdcd');
        $("#product_percent3").css('border','1px solid #cdcdcd');
        $("#product_percent4").css('border','1px solid #cdcdcd');
        $("#nodoc").css('border','1px solid #cdcdcd');
        $("#event_venue").css('border','1px solid #cdcdcd');
        $("#event_city").css('border','1px solid #cdcdcd');
        $("#event_start_date").css('border','1px solid #cdcdcd');
        $("#event_end_date").css('border','1px solid #cdcdcd');
        $("#event_agenda").css('border','1px solid #cdcdcd');
        $("#event_objective").css('border','1px solid #cdcdcd');
        $("#event_end_time").css('border','1px solid #cdcdcd');
        $("#event_start_time").css('border','1px solid #cdcdcd');
        $("#event_slide").css('border','1px solid #cdcdcd');
        $("#taisho").css('border','1px solid #cdcdcd');
        $("#nurse").css('border','1px solid #cdcdcd');
        $("#physician").css('border','1px solid #cdcdcd');
        $("#file_type").css('border','1px solid #cdcdcd');
        $("[id^=total_budget]").css('border','1px solid #cdcdcd');
        $("[id^=budget]").css('border','1px solid #cdcdcd');
        var product_percent = 0;
        product_percent = parseInt($("#product_percent1").val(),10)+parseInt($("#product_percent2").val(),10)+parseInt($("#product_percent3").val(),10)+parseInt($("#product_percent4").val(),10);
        if(product_percent!=100)
        {
          $("#product_percent1").css('border','1px solid #ff0000');
          $("#product_percent2").css('border','1px solid #ff0000');
          $("#product_percent3").css('border','1px solid #ff0000');
          $("#product_percent4").css('border','1px solid #ff0000');
		  error_text = "Total Product should 100%";
          error = "1";
        }
        <?php
          if(isset($_GET['id']))
          {
        ?>
        if($("#list_attachment").val()!="2")
        {
            $("#file_type").css('border','1px solid #ff0000');
            error = "2";
        }
        <?php } ?>
        if($("#product1").val()==$("#product2").val() || $("#product1").val()==$("#product3").val() || $("#product1").val()==$("#product4").val() || $("#product2").val()==$("#product3").val() || $("#product2").val()==$("#product4").val() || $("#product3").val()==$("#product4").val())
        {
          $("#product1").css('border','1px solid #ff0000');
          $("#product2").css('border','1px solid #ff0000');
          $("#product3").css('border','1px solid #ff0000');
          $("#product4").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Product can't be duplicated";
          error = "1";
        }
        if(toSeconds($("#event_start_time").val())>=toSeconds($("#event_end_time").val()))
        {
          $("#event_start_time").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>End Time can't be earlier than Start Time";
          error = "1";
        }
        if ($.datepicker.parseDate('dd/mm/yy', $("#event_start_date").val()) > $.datepicker.parseDate('dd/mm/yy', $("#event_end_date").val())) 
        {
          $("#event_start_date").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>End Date can't be earlier than Start Date";
          error = "1";
        }        
        if($("#nodoc").val().trim()=="")
        {
          $("#nodoc").css('border','1px solid #ff0000');
          error = "1";
        }
        if($("#topic").val().trim()=="")
        {
          $("#topic").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Topic";
          error = "1";
        }
        if($("#taisho").val().trim()=="")
        {
          $("#taisho").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Taisho Representatives";
          error = "1";
        }
        if($("#physician").val().trim()=="")
        {
          $("#physician").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Physicians";
          error = "1";
        }
        if($("#nurse").val().trim()=="")
        {
          $("#nurse").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Nurse/Pharmacist";
          error = "1";
        }
        if($("#event_agenda").val().trim()=="")
        {
          $("#event_agenda").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Event Agenda";
          error = "1";
        }
        if($("#event_objective").val().trim()=="")
        {
          $("#event_objective").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Event Objective";
          error = "1";
        }
        if($("#event_venue").val().trim()=="")
        {
          $("#event_venue").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Event Venue";
          error = "1";
        }
        if($("#event_city").val().trim()=="")
        {
          $("#event_city").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the City";
          error = "1";
        }
        if($("#event_start_date").val().trim()=="")
        {
          $("#event_start_date").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Start Date";
          error = "1";
        }
        if($("#event_end_date").val().trim()=="")
        {
          $("#event_end_date").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the End Date";
          error = "1";
        }
        if($("#event_start_time").val().trim()=="")
        {
          $("#event_start_time").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Start Time";
          error = "1";
        }
        if($("#event_end_time").val().trim()=="")
        {
          $("#event_end_time").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the End Time";
          error = "1";
        }
        if($("#event_slide").val().trim()=="")
        {
          $("#event_slide").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Slide";
          error = "1";
        }
        if($("#budget1").val()=="0" && $("#budget2").val()=="0" && $("#budget3").val()=="0" && $("#budget4").val()=="0" && $("#budget5").val()=="0" && $("#budget6").val()=="0" && $("#budget7").val()=="0" && $("#budget8").val()=="0" && $("#budget9").val()=="0")          
        {
          $("[id^=budget]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Budget";
          error = "1";
        }
        if($("#total_budget1").val()=="0" && $("#total_budget2").val()=="0" && $("#total_budget3").val()=="0" && $("#total_budget4").val()=="0" && $("#total_budget5").val()=="0" && $("#total_budget6").val()=="0" && $("#total_budget7").val()=="0" && $("#total_budget8").val()=="0" && $("#total_budget9").val()=="0")          
        {
          $("[id^=total_budget]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Total Budget";
          error = "1";
        }

        if(error=="1")
        {
			Swal.fire({
		title: 'Please Check Your Data',
		  icon: 'error',
		  html: '<span style="font-size:14px">'+error_text,
		  showCloseButton: false,
		  showCancelButton: false,
		  focusConfirm: false,
		  confirmButtonText:
			'Close'
			})
          return false;
        }
      }

    }


    function deleteAttachment(id)
    {

      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_sc = <?php echo $_GET['id'];  ?>;
      <?php  } else { ?>
        id_sc = "";
      <?php  } ?>

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/Scientific/deleteAttachment?id="+id,
          type: "GET",
          dataType: "text",
          success: function(response){
            $.ajax({
              url: "<?php echo base_url(); ?>index.php/Scientific/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#attachment').html(response);

					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/Scientific/getListAttachment?id="+id_sc,
						type: "GET",
						dataType: "text",
					  success: function(response){
						  $('#list_attachment').val(response);
						  if(response!="2")
						  {	  
							//$("#save").attr("style", "visibility:hidden");
							$("#request_approval").attr("style", "visibility:hidden");
						  }
						  else
						  {
							$("#save").attr("style", "visibility:show");
							$("#request_approval").attr("style", "visibility:show");
						  }   					  

					  },
					  error: function(response)
					  {
					  },
					});

              },
              error: function(response)
              {
              },
            });
        },
        error: function(response)
        {
        },
      });
    }

    function calculate()
    {

      var budget = 0;
      $('input[name^="budget[]"]').each(function() {
        budget = budget + parseInt($(this).val().split('.').join(''),0);
      });
      var total_budget = 0;
      $('input[name^="total_budget[]"]').each(function() {
        total_budget = total_budget + parseInt($(this).val().split('.').join(''),0);
      });

      $("#total1").text(parseInt($("#budget1").val().split('.').join(''),0)+parseInt($("#budget2").val().split('.').join(''),0)+parseInt($("#budget3").val().split('.').join(''),0)+parseInt($("#budget4").val().split('.').join(''),0)+parseInt($("#budget5").val().split('.').join(''),0)+parseInt($("#budget6").val().split('.').join(''),0)+parseInt($("#budget7").val().split('.').join(''),0)+parseInt($("#budget8").val().split('.').join(''),0)+parseInt(budget,0));
      $("#total2").text(parseInt($("#total_budget1").val().split('.').join(''),0)+parseInt($("#total_budget2").val().split('.').join(''),0)+parseInt($("#total_budget3").val().split('.').join(''),0)+parseInt($("#total_budget4").val().split('.').join(''),0)+parseInt($("#total_budget5").val().split('.').join(''),0)+parseInt($("#total_budget6").val().split('.').join(''),0)+parseInt($("#total_budget7").val().split('.').join(''),0)+parseInt($("#total_budget8").val().split('.').join(''),0)+parseInt(total_budget,0));
	  $("#total1").text(numeral($("#total1").text()).format('0,0'));
	  $("#total2").text(numeral($("#total2").text()).format('0,0'));
    }

	function format(sel)
	{
        if(sel.value=="")
        {
          sel.value = "0";
        }
		var x = numeral(sel.value).value();
		sel.value = numeral(x).format('0,0');
        calculate();
	}


    $(function () {

		numeral.locale('id');
      calculate();
      $("[id^=budget]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
        if($("[id^=budget]").val()=="")
        {
          $("[id^=budget]").val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });      
      $("[id^=total_budget]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
        if($("#total_budget2").val()>0)
        {
            $(".institution").attr("style", "visibility:show");
            $(".institution").css("height", "120px");
        }
        else
        {
            $(".institution").attr("style", "visibility:hidden");
            $(".institution").css("height", "0px");
        }

        if($("#total_budget3").val()>0)
        {
            $(".association").attr("style", "visibility:show");
            $(".association").css("height", "120px");
        }
        else
        {
            $(".association").attr("style", "visibility:hidden");
            $(".association").css("height", "00px");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });      

      if($("#id_group").val()<=6 || ($("#id_group").val()>=7 && $("#state").val()>1))
      {
        $("#nurse").prop("readonly",true);
        $("#taisho").prop("readonly",true);
        $("#physician").prop("readonly",true);
        $("#nodoc").prop("readonly",true);
        $("#topic").prop("readonly",true);
        $("[id^=product_percent]").prop("readonly",true);
        $("[id^=budget]").prop("readonly",true);
        $("[id^=total_budget]").prop("readonly",true);
        $("[id^=remark]").prop("readonly",true);
        $("[id^=type_sponsor]").prop("readonly",true);
		$("[id^=institution]").prop("readonly",true);
		$("[id^=assoc]").prop("readonly",true);
        $("[id^=event]").prop("readonly",true);
        $("[id^=upload]").prop("disabled",true);
        $(".add_button").attr("style", "visibility: hidden");
        $(".remove_button").attr("style", "visibility: hidden");
      }

      if($("#id_group").val()>9)
      {
        $("[id^=upload]").prop("disabled",true);
      }

      var x = 1;  

      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_sc = <?php echo $_GET['id'];  ?>;
        var id_user = <?php echo $requested_by; ?>;
        <?php if($budget==8) {?>
        x = 1;  
        <?php } else { ?>
        x = <?php echo ($budget-8); ?>; //Initial field counter is 1        
    <?php  } } else { ?>
        id_sc = "";
        id_user = <?php echo $this->session->userdata('id_user'); ?>;
      <?php  } ?>

            $.ajax({
              url: "<?php echo base_url(); ?>index.php/Scientific/getListAttachment?id="+id_sc,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#list_attachment').val(response);
				  if($("#id_group").val()<=6 || ($("#id_group").val()>=7 && $("#state").val()>1))
				  {
				  }
				  else
				  {	  
						  if(response!="2")
						  {	  
							//$("#save").attr("style", "visibility:hidden");
							$("#request_approval").attr("style", "visibility:hidden");
						  }
						  else
						  {
							$("#save").attr("style", "visibility:show");
							$("#request_approval").attr("style", "visibility:show");
						  }   					  
				  }	  
              },
              error: function(response)
              {
              },
            });

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/MER/getUser2",
          type: "GET",
          dataType: "text",
        success: function(response){
          var json = $.parseJSON(response);
          for (var i=0;i<json.length;++i)
          {
              $('#internal_speaker').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
          $("#requested_by1").val(id_user);

        },
        error: function(response)
        {
        },
      });

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/Scientific/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
          type: "GET",
          dataType: "text",
        success: function(response){
            $('#attachment').html(response);
        },
        error: function(response)
        {
        },
      });

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/MER/getUser?id="+id_user,
          type: "GET",
          dataType: "text",
        success: function(response){
          var json = $.parseJSON(response);
          for (var i=0;i<json.length;++i)
          {
              $('#requested_by1').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
          $("#requested_by1").val(id_user);

          $.ajax({
            url: "<?php echo base_url(); ?>index.php/MER/getLeader?id="+$("#requested_by1").val(),
              type: "GET",
              dataType: "text",
            success: function(response){
              var json = $.parseJSON(response);
              for (var i=0;i<json.length;++i)
              {
                  $('#requested_by2').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
              }
            },
            error: function(response)
            {
            },
          });

        },
        error: function(response)
        {
        },
      });

      $("#event_activity").val(<?php echo $event_activity; ?>);

      $("#requested_by1").change(function() {
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/MER/getLeader?id="+$("#requested_by1").val(),
            type: "GET",
            dataType: "text",
          success: function(response){
            var json = $.parseJSON(response);
            for (var i=0;i<json.length;++i)
            {
                $('#requested_by2').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
            }
          },
          error: function(response)
          {
          },
        });
      });      


      $.ajax({
        url: "<?php echo base_url(); ?>index.php/MER/getProduct",
          type: "GET",
          dataType: "text",
        success: function(response){
          var json = $.parseJSON(response);
          for (var i=0;i<json.length;++i)
          {
              $('[id^=product]').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
          $("#product1").val('<?php echo $product1; ?>');
          $("#product2").val('<?php echo $product2; ?>');
          $("#product3").val('<?php echo $product3; ?>');
          $("#product4").val('<?php echo $product4; ?>');
        },
        error: function(response)
        {
        },
      });


      var maxField = 10;
      var addButton = $('.add_button');
      var wrapper = $('.field_wrapper');
      var fieldHTML = '<div class="row" style="height:30px"><div class="col-xs-1" style="width:355px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="type_sponsor[]" id="type_sponsor" class="form-control" type="text" style="width:355px;border-right:1px solid black;border-top:1px solid black;height:30px"/>';
      fieldHTML = fieldHTML + '</div>';
      fieldHTML = fieldHTML + '<div class="col-xs-1" style="width:150px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="budget[]" id="budget" class="form-control" type="text" style="width:150px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="total_budget[]" id="total_budget" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';    
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="remark[]" id="remark" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px">';    
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="border-left:1px solid black;width:25px">';    
      fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>'; 


      $('[id^=product_percent]').keypress(validateNumber);
      $('#taisho').keypress(validateNumber);
      $('#nurse').keypress(validateNumber);
      $('#taisho').keypress(validateNumber);
      $('[id^=budget]').keypress(validateNumber);
      $('[id^=total_budget]').keypress(validateNumber);
      $('#requested_by1').val('<?php echo $requested_by; ?>');

      
      //Once add button is clicked
      $(addButton).click(function(){
          //Check maximum number of input fields
          var total_budgetArray = new Array();
          $('input[name^="total_budget[]"]').each(function() {
            total_budgetArray.push($(this).val().split('.').join(''));
          });

          var sponsorArray = new Array();
          $('input[name^="type_sponsor[]"]').each(function() {
            sponsorArray.push($(this).val());
          });

          var budgetArray = new Array();
          $('input[name^="budget[]"]').each(function() {
            budgetArray.push($(this).val().split('.').join(''));
          });

          var remarkArray = new Array();
          $('input[name^="remark[]"]').each(function() {
            remarkArray.push($(this).val());
          });

            //Check maximum number of input fields
            $('input[name^="type_sponsor"]').each(function() {       
              if(x < maxField)
              {
                if($(this).val().trim()!="")
                {
                  if(sponsorArray[x-1]!="" && budgetArray[x-1]>0 && total_budgetArray[x-1]>0)
                  {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                  }  
                }
              }
            });
      });
      
      //Once remove button is clicked
      $(wrapper).on('click', '.remove_button', function(e){
          e.preventDefault();
          $(this).parent('div').parent('div').remove(); //Remove field html
          x--; //Decrement field counter
          $(addButton).css('visibility','visible');
          calculate();
      });


      $('#upload').bind('click', function(){
          var data = new FormData;
          data.append('file', document.getElementById('file_name').files[0]);
          data.append('file_type', $('#file_type').val());
          data.append('id_parent', id_sc);

          $.ajax({
              url : "<?php echo base_url(); ?>index.php/Scientific/upload",
              type : 'POST',
              data : data,
              contentType: false,
              processData: false,
              success : function(json) {
                $.ajax({
                  url: "<?php echo base_url(); ?>index.php/Scientific/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                    type: "GET",
                    dataType: "text",
                    success: function(response){
                      $('#attachment').html(response);
                  },
                  error: function(response)
                  {
                  },
                });

              }
          });


            $.ajax({
              url: "<?php echo base_url(); ?>index.php/Scientific/getListAttachment?id="+id_sc,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#list_attachment').val(response);
						  if(response!="2")
						  {	  
							//$("#save").attr("style", "visibility:hidden");
							$("#request_approval").attr("style", "visibility:hidden");
						  }
						  else
						  {
							$("#save").attr("style", "visibility:show");
							$("#request_approval").attr("style", "visibility:show");
						  }   					  
              },
              error: function(response)
              {
              },
            });

      });

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
//    alert("xxxx");

//      $("#event_start_date").datepicker({dateFormat: 'dd/mm/yy'});
//      $("#event_end_date").datepicker({dateFormat: 'dd/mm/yy'});
    });  

  </script>
</head>
