<head>
  <meta name="viewport" content="width=1024">
    <title>HCP-POST EVENT REPORT</title>
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
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.1.0/bootstrap-4.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<link href="<?php echo base_url(); ?>assets/css/jquery.multiselect.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>assets/js/jquery.multiselect.js"></script>

<body style="font-size:13px">
    <div class="container-fluid" style="border:1px solid black;padding-left:22px;padding-right:8px;padding-bottom:8px;padding-top:8px;width:927px">
      <?php 
        $readonly = "";
        $readonly_note1="readonly";
		$readonly_prepared_note="readonly";
        if(isset($_GET['access']))
        {
          if($_GET['access']==12 && $state==2)
          {
            $readonly_note1="";
          }
          if($_GET['access']==7 && $state==1)
          {
            $readonly_prepared_note="";
          }
        }
        else
        {
          $_GET['access']=$this->session->userdata('id_group');
          if($this->session->userdata('id_group')==12 && $state==2)
          {
            $readonly_note1="";
          }
          if($this->session->userdata('id_group')==7 && $state==1)
          {
            $readonly_prepared_note="";
          }
        }  
        if(isset($_GET['id'])) 
        { 
          $readonly="readonly"; 
        } 
      ?>
    <form action="<?php echo base_url().'index.php/HCPReport/add'; ?>" method="post"> 
      <div class="row">
        <div class="col-xs-1" style="background:#efefef;text-align:center;width:910px">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-xs-1" style="background:#efefef;text-align:center;width:910px"><img src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
      </div>
      <div class="row">
        <div class="col-xs-1" style="background:#efefef;text-align:center;width:910px">
          <b>HCP-POST EVENT REPORT</b>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1" style="background:#efefef;text-align:right;width:360px">
          <b>Doc No.&nbsp;&nbsp;</b>
        </div>
        <span style="background:#efefef;"><?php echo substr($created_date,-4);?>/R-HCP/<?php echo date("m",strtotime($created_date));?>/</span><div class="col-xs-1" style="height:30px;background:#efefef;width:455px">
          <div class="form-group">
            <input class="form-control" type="text" id="nodoc2" name="nodoc2" style="width:150px" value="<?php echo $nodoc2; ?>" readonly/>
          </div>
        </div>
      </div>
        <div class="row">
          <div class="col-xs-1" style="width:910px"><hr/></div>
        </div>
      <div class="row" style="height:38px">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:180px"><b>Requested by</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1">
          <div class="form-group">
              <select class="form-control" id="requested_by1" name="requested_by1" style="height:30px;width:170px">
              </select>
          </div>
        </div>
      </div>
      <div class="row" style="height:68px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:180px"><b>Event Name</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="event_name" name="event_name" readonly
			  style="height:60px;width:180px;"><?php echo $event_name; ?></textarea>
		  </div>
		</div>
        <div class="col-xs-1" style="width:18px">&nbsp;</div>
        <div class="col-xs-1" style="width:35px"><b>MER</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1"><?php echo substr($created_date2,-4);?>/MER/<?php echo date("m",strtotime($created_date2));?>/</div>
        <div class="col-xs-1">
          <div class="form-group">
              <input class="form-control" id="nodoc" name="nodoc" type="text" style="width:170px" value="<?php echo $nodoc; ?>" readonly/>
          </div>
        </div>
      </div>
      <div class="row" style="height:68px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:180px"><b>Organizer of Event</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="event_organizer" name="event_organizer" readonly
			  style="height:60px;width:350px;"><?php echo $event_organizer; ?></textarea>
		  </div>
		</div>
      </div>
      <div class="row" style="height:68px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:180px"><b>Venue</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="event_venue" name="event_venue" readonly
			  style="height:60px;width:350px;"><?php echo $event_venue; ?></textarea>
		  </div>
		</div>
      </div>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:180px"><b>Date</b></div>
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
      <div class="row" style="height:38px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:180px"><b>Institution</b></div>
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
        <div class="col-xs-1" style="width:180px"><b>Contactable Phone</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="event_contact" name="event_contact" readonly
			  style="height:60px;width:350px;"><?php echo $event_contact; ?></textarea>
		  </div>
		</div>
      </div>
        <div class="row">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:180px"><b>HCP Specialty</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
              <div style="width:400px;word-wrap: break-word;" id="speciality_text"></div>
          </div>
        </div>
      <div class="speciality3">
      <div class="row">
        <div class="col-xs-1" style="width:200px">
        </div>
        <div class="col-xs-1">&nbsp;&nbsp;&nbsp;</div>
        <div class="col-xs-1">
          <div class="form-group">
              <select class="3col active" id="speciality" name="speciality[]" multiple>
              </select>
          </div>
        </div>
      </div>
      </div>
      <div class="row" style="height:38px">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:180px">
          <b>HCP</b>
        </div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1">
          <div class="form-group">
              <select class="form-control" id="hcp" name="hcp" style="height:30px;">
              </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:150px">
          <b>Estimated Budget:</b>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;width:160px;text-align:center">
          <b>&nbsp;Type of Sponsorship&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;">
          <b>&nbsp;Description&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;width:150px;text-align:center;border-bottom:1px solid black;">
          <b>&nbsp;BUDGET (IDR)&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;">
          <b>&nbsp;ACTUAL (IDR)&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;">
          <b>&nbsp;KPK Report&nbsp;</b>
        </div>
      </div>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:160px">
          &nbsp;Travel&nbsp;
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <input id="description1" name="description1" class="form-control" type="text" value="<?php echo $description1; ?>"
              style="width:200px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="budget1" name="budget1" class="form-control" type="text" value="<?php echo $budget1; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <input id="actual1" name="actual1" class="form-control" type="text" value="<?php echo $actual1; ?>"
              style="width:200px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <select class="form-control" id="kpk1" name="kpk1" style="height:30px">
              <option value="1" selected>Registrasi</option>
              <option value="2">Akomodasi</option>
              <option value="3">Transportasi</option>
              <option value="4">Honor</option>
              <option value="5">Nominal (Institusi)</option>
			  <option value="6">None</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:160px">
          &nbsp;Accommodation&nbsp;
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <input id="description2" name="description2" class="form-control" type="text" value="<?php echo $description2; ?>"
              style="width:200px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="budget2" name="budget2" class="form-control" type="text" value="<?php echo $budget2; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <input id="actual2" name="actual2" class="form-control" type="text" value="<?php echo $actual2; ?>"
              style="width:200px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <select class="form-control" id="kpk2" name="kpk2" style="height:30px">
              <option value="1" selected>Registrasi</option>
              <option value="2">Akomodasi</option>
              <option value="3">Transportasi</option>
              <option value="4">Honor</option>
              <option value="5">Nominal (Institusi)</option>
			  <option value="6">None</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:160px">
          &nbsp;Registration&nbsp;
        </div>
        <div class="col-xs-1">
          <div class="form-group">
            <input id="description3" name="description3" class="form-control" type="text" value="<?php echo $description3; ?>"
              style="width:200px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="budget3" name="budget3" class="form-control" type="text" value="<?php echo $budget3; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px;height:30px;">
          <div class="form-group">
            <input id="actual3" name="actual3" class="form-control" type="text" value="<?php echo $actual3; ?>"
              style="width:200px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <select class="form-control" id="kpk3" name="kpk3" style="height:30px">
              <option value="1" selected>Registrasi</option>
              <option value="2">Akomodasi</option>
              <option value="3">Transportasi</option>
              <option value="4">Honor</option>
              <option value="5">Nominal (Institusi)</option>
			  <option value="6">None</option>
            </select>
          </div>
        </div>
      </div>
      <!--div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:160px">
          &nbsp;Speaker&nbsp;
        </div>
        <div class="col-xs-1">
          <div class="form-group">
            <input id="description4" name="description4" class="form-control" type="text" value="<?php echo $description4; ?>"
              style="width:200px;height:30px;border-left:1px solid black;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="budget4" name="budget4" class="form-control" type="text" value="<?php echo $budget4; ?>"
              style="width:150px;height:30px;border-left:1px solid black;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <input id="actual4" name="actual4" class="form-control" type="text" value="<?php echo $actual4; ?>"
              style="width:200px;height:30px;border-left:1px solid black;border-right:1px solid black;" maxlength="9" />
          </div>
        </div>
      </div-->
        <div class="field_wrapper">
        <?php
          if($budget==3)
          { 
              $sponsor_text = "sponsor4";
              $description_text = "description4";
              $budget_text = "budget4";            
              $actual_text = "actual4";            
			  $val = $kpk4;
            ?>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:160px">
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:160px;border-right:1px solid black;border-top:1px solid black;height:30px"
            />
        </div>
        <div class="col-xs-1">
          <div class="form-group">
            <input id="description4" name="description[]" class="form-control" type="text" value="<?php echo $$description_text; ?>"
              style="width:200px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="budget4" name="budget[]" class="form-control" type="text" value="<?php echo $$budget_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <input id="actual4" name="actual[]" class="form-control" type="text" value="<?php echo $$actual_text; ?>"
              style="width:200px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <select class="form-control" id="kpk4" name="kpk[]" style="height:30px">
				  <option value="1" <?php if($val==1) { echo "selected"; } ?>>Registrasi</option>
				  <option value="2" <?php if($val==2) { echo "selected"; } ?>>Akomodasi</option>
				  <option value="3" <?php if($val==3) { echo "selected"; } ?>>Transportasi</option>
				  <option value="4" <?php if($val==4) { echo "selected"; } ?>>Honor</option>
				  <option value="5" <?php if($val==5) { echo "selected"; } ?>>Nominal (Institusi)</option>
				  <option value="6" <?php if($val==6) { echo "selected"; } ?>>None</option>
            </select>
          </div>
        </div>
          <div class="col-xs-1" style="width:25px">
            <!--a href="javascript:void(0);" class="add_button"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a-->
          </div>
      </div>
          <?php   
          }
          if($budget>3)
          {
            for($i=3;$i<$budget;$i++)
            {
              $sponsor_text = "sponsor".($i+1);
              $description_text = "description".($i+1);
              $budget_text = "budget".($i+1);
              $actual_text = "actual".($i+1);            
              $total_text = "total".($i+1);
              $kpk_text = "kpk".($i+1);
			  $val = $$kpk_text;
        ?>
      <div class="row" style="height:30px;border-left:1px solid black;">
        <div class="col-xs-1" style="width:160px">
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:160px;height:30px"
            />
        </div>
        <div class="col-xs-1">
          <div class="form-group">
            <input id="<?php echo $description_text; ?>" name="description[]" class="form-control" type="text" value="<?php echo $$description_text; ?>"
              style="width:200px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="<?php echo $budget_text; ?>" name="budget[]" class="form-control" type="text" value="<?php echo $$budget_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <input id="<?php echo $actual_text; ?>" name="actual[]" class="form-control" type="text" value="<?php echo $$actual_text; ?>"
              style="width:200px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <select class="form-control" id="<?php echo $kpk_text; ?>" name="kpk[]" style="height:30px">
				  <option value="1" <?php if($val==1) { echo "selected"; } ?>>Registrasi</option>
				  <option value="2" <?php if($val==2) { echo "selected"; } ?>>Akomodasi</option>
				  <option value="3" <?php if($val==3) { echo "selected"; } ?>>Transportasi</option>
				  <option value="4" <?php if($val==4) { echo "selected"; } ?>>Honor</option>
				  <option value="5" <?php if($val==5) { echo "selected"; } ?>>Nominal (Institusi)</option>
				  <option value="6" <?php if($val==6) { echo "selected"; } ?>>None</option>
            </select>
          </div>
        </div>
          <div class="col-xs-1" style="width:25px">
          <?php 
            //if($i==4)
            //{  
          ?>
            <!--a href="javascript:void(0);" class="add_button"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a-->
            <?php //} else { ?>    
            <a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a>
            <?php //} ?>  
          </div>                  
        </div>
        <?php 
          }
        }
        ?>
        </div>
      <div class="row">
        <div class="col-xs-1"
          style="border-left:1px solid black;width:359px;border-top:1px solid black;text-align:center;border-bottom:1px solid black;">
          &nbsp;<b>TOTAL ESTIMATED BUDGET</b>&nbsp;
        </div>
        <div class="col-xs-1" id="total1"
          style="border-left:1px solid black;width:150px;border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;text-align:center">
          &nbsp;
        </div>
        <div class="col-xs-1" id="total2"
          style="border-left:1px solid black;width:200px;border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;text-align:center">
          &nbsp;
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-xs-1">
          &nbsp;
        </div>
      </div>
        <?php if(isset($_GET['id'])==true)  {?>
        <div class="row">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:150px">
            <b>Attachment :</b>
          </div>
        </div>
      <div class="row">
        <div class="col-xs-1" style="width:400px">
          <div class="form-group">
            <select class="form-control" id="file_type" style="height:30px;">
              <option value="1">Others (Optional)</option>
              <option value="2">Attendance List (Mandatory)</option>
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
            style="border-left:1px solid black;border-top:1px solid black;width:240px;text-align:center;border-bottom:1px solid black;"
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
        <?php  } ?>
        <div class="row">
          <div class="col-xs-1" style="width:200px">&nbsp;</div>
          <div class="col-xs-1" style="width:200px">&nbsp;</div>
        </div>
      <div class="row">
        <div class="col-xs-1">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-xs-1"
          style="border-left:1px solid black;width:400px;border-right:1px solid black;border-top:1px solid black">
          &nbsp;<b>APPROVAL AND NOTES</b>&nbsp;
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center">
          <b>&nbsp;Prepared By&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center">
          <b>&nbsp;Reviewed&nbsp;</b>
        </div>
      </div>
            <div class="row">
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-right:1px solid black;border-top:1px solid black;width:200px;text-align:center">
                    &nbsp;<br />Prepared by<br/><?php if($state>1)  { echo $approver0;  } else { echo $GLOBALS['approver0']; } ?><br />(<?php echo $created_date; ?>)<br /><br /><?php if($state>1)  { echo $title0;  } else { echo $GLOBALS['title0']; } ?><br />&nbsp;
                </div>
                <div class="col-xs-1"
                    style="border-right:1px solid black;border-top:1px solid black;width:200px;text-align:center">
                    &nbsp;<br />Approved by<br/><?php if($state>2)  { echo $approver1;  } else { echo $GLOBALS['approver1']; } ?><br />(<?php  if($state>2)  { echo $updated_date1;  } ?>)<br /><br /><?php if($state>2)  { echo $title1;  } else { echo $GLOBALS['title1']; } ?><br />&nbsp;
                </div>
            </div>
      <div class="row">
		<div class="col-xs-1"
		  style="width:200px;text-align:center;height:90px;">
			<textarea rows="3" class="form-control" id="prepared_note" name="prepared_note" <?php echo $readonly_prepared_note; ?>
			  style="height:90px;width:200px;border:1px solid black;"><?php echo $prepared_note; ?></textarea>
		</div>
        <div class="col-xs-1" style="width:200px">
          <div class="form-group">
            <textarea rows="3" class="form-control" id="note1" name="note1" <?php echo $readonly_note1; ?>
              style="height:90px;width:200px;border:1px solid black;"><?php echo $note1; ?></textarea>
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
			  <div class="col-xs-1" style="width:910px;"><i style='color:red'>* Note is mandatory to be filled if Reviewer / Approver want to Reject / Review this document</i></div>
			</div>
        <div class="row">
          <div class="col-xs-1" style="width:910px"><hr/></div>
        </div>
        <button type="submit" id="save" class="btn btn-primary btn-sm" style="visibility:hidden"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Save</button>
        <button type="submit" id="request_approval" class="btn btn-success btn-sm" style="visibility:hidden"><i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Request Approval</button>
        <button type="submit" id="review" class="btn btn-warning btn-sm" style="visibility:hidden"><i class="fa fa-undo" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Review</button>
        <button type="submit" id="approve" class="btn btn-success btn-sm" style="visibility:hidden"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Approve</button>
        <button type="submit" id="reject" class="btn btn-danger btn-sm" style="visibility:hidden"><i class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Reject</button>
        <button type="submit" id="freeze" class="btn btn-primary btn-sm" style="visibility:hidden"><i class="fa fa-pause" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Freeze</button>
        <button type="button" id="print" style="visibility:hidden" class="btn btn-primary btn-sm" onclick="printPage();"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Print</button>
			<button type="submit" id="kpkmapping" class="btn btn-primary btn-sm" style="visibility:hidden"><i class="fa fa-table" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;KPK Mapping</button>
        <input type="hidden" id="list_attachment" value="">
        <input type="hidden" id="state" value="<?php echo $state; ?>">
        <input type="hidden" id="speciality_temp" value="<?php echo $speciality; ?>">
        <?php if(isset($_GET['access'])) { ?>        
        <input type="hidden" id="id_group" value="<?php echo $_GET['access']; ?>">
        <?php } else { ?>
        <input type="hidden" id="id_group" value="<?php echo $this->session->userdata('id_group'); ?>">
        <?php } ?>
        <input type="hidden" id="id_mer" name="id_mer" value="<?php echo $_GET['id_mer']; ?>">
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
	if($("#state").val()==6 && ($("#id_group").val()==11 || $("#id_group").val()==7 || $("#id_group").val()==12))
	{
      $("#print").attr("style", "visibility:show");
	}		
	function printPage()
	{
		window.print();
	}

    $("#kpk1").val(<?php echo $kpk1; ?>);
    $("#kpk2").val(<?php echo $kpk2; ?>);
    $("#kpk3").val(<?php echo $kpk3; ?>);

//    alert("#speciality_temp").val();
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
	$('input[name^="actual[]"]').css("text-align","right");
    $('[id^=actual]').css("text-align","right");
    $('[id^=total]').css("text-align","right");
	
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
            url: "<?php echo base_url(); ?>index.php/HCPReport/updateState?id_hcp2="+<?php echo $_GET['id_hcp2']; ?>+"&id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
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

      if($("#state").val()>=2)
      {
		  <?php
			if(isset($_GET['id']))
			{
		  ?>
			var id_sc = <?php echo $_GET['id'];  ?>;
		  <?php  } else { ?>
			id_sc = "";
		  <?php  } ?>

		  var kpkmapping = document.getElementById('kpkmapping');
		  $("#kpkmapping").attr("style", "visibility:show");

		  kpkmapping.onclick = function() 
		  {		  
			  $.ajax({
				url: "<?php echo base_url(); ?>index.php/HCPReport/updateState5?id_hcp2="+<?php echo $_GET['id_hcp2']; ?>+"&id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
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

    if(($("#id_group").val()==12 && $("#state").val()==2))
    {
      var review = document.getElementById('review');
      var approve = document.getElementById('approve');
      var reject = document.getElementById('reject');
      $("#note1").css('border','1px solid #cdcdcd');

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
      //$("#review").attr("style", "visibility:show");
      //$("#reject").attr("style", "visibility:show");
      //$("#approve").attr("style", "visibility:show");

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
        if(($("#id_group").val()==12 && $("#note1").val()!=""))
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/HCPReport/updateState2?id="+id_sc,
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
          if($("#id_group").val()==12)
          {
            $("#note1").css('border','1px solid #ff0000');
          }
          return false;
        }
      }

      approve.onclick = function() 
      {
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/HCPReport/updateState?id_hcp2="+<?php echo $_GET['id_hcp2']; ?>+"&id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
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
				url: "<?php echo base_url(); ?>index.php/HCPReport/updateState4?active="+active+"&id="+id_sc,
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
        if(($("#id_group").val()==12 && $("#note1").val()!=""))
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/HCPReport/updateState3?id="+id_sc,
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
          if($("#id_group").val()==12)
          {
            $("#note1").css('border','1px solid #ff0000');
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
		error = "0";  
		error_text = "";  
        $("#nodoc2").css('border','1px solid #cdcdcd');
        $("#event_organizer").css('border','1px solid #cdcdcd');
        $("#event_name").css('border','1px solid #cdcdcd');
        $("#event_venue").css('border','1px solid #cdcdcd');
        $("#event_start_date").css('border','1px solid #cdcdcd');
        $("#event_end_date").css('border','1px solid #cdcdcd');
        $("#event_institution").css('border','1px solid #cdcdcd');
        $("#event_contact").css('border','1px solid #cdcdcd');
        $("#hcp").css('border','1px solid #cdcdcd');
        $("#speciality").css('border','1px solid #cdcdcd');
        $("#file_type").css('border','1px solid #cdcdcd');
        $("[id^=actual]").css('border','1px solid #cdcdcd');
        $("[id^=budget]").css('border','1px solid #cdcdcd');
        if ($.datepicker.parseDate('dd/mm/yy', $("#event_start_date").val()) > $.datepicker.parseDate('dd/mm/yy', $("#event_end_date").val())) 
        {
          $("#event_start_date").css('border','1px solid #ff0000');
          error = "1";
		  error_text = error_text+"<br>End Date can't be earlier than Start Date";
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
        if($("#nodoc2").val().trim()=="")
        {
          $("#nodoc2").css('border','1px solid #ff0000');
          error = "1";
        }
        if($("#hcp").val()==null)
        {
          $("#hcp").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please select the HCP";
          error = "1";
        }
        if($("#event_institution").val()==null)
        {
          $("#event_institution").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please select the Event Institution";
          error = "1";
        }
        if($("#event_contact").val().trim()=="")
        {
          $("#event_contact").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Event Contact";
          error = "1";
        }
        if($("#event_name").val().trim()=="")
        {
          $("#event_name").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Event Name";
          error = "1";
        }
        if($("#event_organizer").val().trim()=="")
        {
          $("#event_organizer").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Event Organizer";
          error = "1";
        }
        if($("#event_venue").val().trim()=="")
        {
          $("#event_venue").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Event Venue";
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
        if($("#speciality").val()==null)
        {
          $("#speciality").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please select the Specialty";
          error = "1";
        }
        /*if($("#budget1").val()=="0" && $("#budget2").val()=="0" && $("#budget3").val()=="0")          
        {
          $("[id^=budget]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Budget";
          error = "1";
        }
        if($("#actual1").val()=="0" && $("#actual2").val()=="0" && $("#actual3").val()=="0")          
        {
          $("[id^=actual]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Actual";
          error = "1";
        }*/

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
		else
		{
			<?php if(isset($_GET['id'])) { ?>
			if(error=="2")
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
			<?php } ?>
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
        url: "<?php echo base_url(); ?>index.php/HCPReport/deleteAttachment?id="+id,
          type: "GET",
          dataType: "text",
          success: function(response){
            $.ajax({
              url: "<?php echo base_url(); ?>index.php/HCPReport/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#attachment').html(response);
					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/HCPReport/getListAttachment?id="+id_sc,
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
      var actual = 0;
      $('input[name^="actual[]"]').each(function() {
        actual = actual + parseInt($(this).val().split('.').join(''),0);
      });
      $("#total1").text(parseInt($("#budget1").val().split('.').join(''),0)+parseInt($("#budget2").val().split('.').join(''),0)+parseInt($("#budget3").val().split('.').join(''),0)+parseInt(budget,0));
      $("#total2").text(parseInt($("#actual1").val().split('.').join(''),0)+parseInt($("#actual2").val().split('.').join(''),0)+parseInt($("#actual3").val().split('.').join(''),0)+parseInt(actual,0));

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
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });      
      $("[id^=actual]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });      

      if($("#id_group").val()>9)
      {
        $("[id^=upload]").prop("disabled",true);
      }

      $("[id^=budget]").prop("readonly",true);
      if($("#id_group").val()<=6 || ($("#id_group").val()>=7 && $("#state").val()>1))
      {
        $("#hcp").prop("readonly",true);
        $("#nodoc2").prop("readonly",true);
        $("[id^=actual]").prop("readonly",true);
        $("[id^=budget]").prop("readonly",true);
        $("[id^=description]").prop("readonly",true);
        $("[id^=type_sponsor]").prop("readonly",true);
        $("[id^=event]").prop("readonly",true);
        $("[id^=upload]").prop("disabled",true);
        $(".add_button").attr("style", "visibility: hidden");
        $(".remove_button").attr("style", "visibility: hidden");
        $(".speciality3").attr("style", "visibility:hidden");
        $(".speciality3").css("height", "30px");
      }

      var x = 1;  
      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_sc = <?php echo $_GET['id'];  ?>;
        var id_user = <?php echo $requested_by; ?>;
        <?php if($budget==3) {?>
        x = 1;  
        <?php } else { ?>
        x = <?php echo ($budget-3); ?>; //Initial field counter is 1        
    <?php  } } else { ?>
        id_sc = "";
        id_user = <?php echo $this->session->userdata('id_user'); ?>;
        x = 1;
      <?php  } ?>

            $.ajax({
              url: "<?php echo base_url(); ?>index.php/HCPReport/getListAttachment?id="+id_sc,
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

//      var speciality = $('#speciality_temp').val();
//      var strArray = speciality.split(",");
        
//      $("#speciality").val(strArray);

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/HCPReport/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
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

		$.ajax({
			url: "<?php echo base_url(); ?>index.php/MER/getSpeciality2?id_hcp2="+<?php echo $_GET['id_hcp2'];  ?>,
				type: "GET",
				dataType: "text",
			success: function(response){
				var json = $.parseJSON(response);
				var speciality = $('#speciality_temp').val();
				var strArray = speciality.split(",");
				for (var i=0;i<json.length;++i)
				{
					if(strArray.includes(json[i].id))
					{	
					  $('#speciality').append('<option value="'+json[i].id+'" selected>'+json[i].name+'</option>');
					}
					else
					{
					  $('#speciality').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
					}						
				}


        $('select[multiple].active.3col').multiselect({
            columns: 3,
            placeholder: 'Select Speciality',
            search: true,
            searchOptions: {
                'default': 'Search Speciality'
            },
			maxWidth: 600,
			maxPlaceholderWidth: 600,
            selectAll: true
        });

        
//          $("#speciality").val(strArray);

        var text = $('#speciality option:selected').toArray().map(item => item.text).join();
          
        $("#speciality_text").text(text);

			},
			error: function(response)
			{
			},
		});

      $('#speciality').on('change', function() 
      {
        var text = $('#speciality option:selected').toArray().map(item => item.text).join();
          
        $("#speciality_text").text(text);
          
      });

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/AgreementLetter2/getDoctor?id="+<?php echo $hcp; ?>,
          type: "GET",
          dataType: "text",
        success: function(response){
          var json = $.parseJSON(response);
          for (var i=0;i<json.length;++i)
          {
              $('#hcp').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
      <?php
        if(isset($_GET['id']))
        {
      ?>
          $("#hcp").val('<?php echo $hcp; ?>');
      <?php
		}
      ?>
        },
        error: function(response)
        {
        },
      });


      var maxField = 10;
      var addButton = $('.add_button');
      var wrapper = $('.field_wrapper');
      var description_text = "description"+(x+3);
      var budget_text = "pax"+(x+3);
      var actual_text = "cost_each"+(x+3);
      var total_text = "total"+(x+3);
      var fieldHTML = '<div class="row" style="height:30px"><div class="col-xs-1" style="width:160px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="type_sponsor[]" id="type_sponsor" class="form-control" type="text" style="width:160px;border-right:1px solid black;border-top:1px solid black;height:30px"/>';
      fieldHTML = fieldHTML + '</div>';
      fieldHTML = fieldHTML + '<div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="description[]" id="'+description_text+'" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px">';
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:150px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="budget[]" id="'+budget_text+'" class="form-control" type="text" style="width:150px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';    
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="actual[]" id="'+actual_text+'" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';    
      fieldHTML = fieldHTML + '</div>';
      fieldHTML = fieldHTML + '<div class="col-xs-1" style="border-left:1px solid black;width:25px">';    
      fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>'; 


      $('#hcp').keypress(validateNumber);
      $('[id^=budget]').keypress(validateNumber);
      $('[id^=actual]').keypress(validateNumber);
      $('#requested_by1').val('<?php echo $requested_by; ?>');

      
      for (var i=1;i<=x;++i)
      {
		var kpk_text = "kpk"+(3+i);
		$("#"+kpk_text).val(<?php echo $$kpk_text; ?>);
	  }

      //Once add button is clicked
      $(addButton).click(function(){
          //Check maximum number of input fields
          var actualArray = new Array();
          $('input[name^="actual[]"]').each(function() {
            actualArray.push($(this).val().split('.').join(''));
          });

          var sponsorArray = new Array();
          $('input[name^="type_sponsor[]"]').each(function() {
            sponsorArray.push($(this).val());
          });

          var budgetArray = new Array();
          $('input[name^="budget[]"]').each(function() {
            budgetArray.push($(this).val().split('.').join(''));
          });

          var descArray = new Array();
          $('input[name^="description[]"]').each(function() {
            descArray.push($(this).val());
          });

            //Check maximum number of input fields
            $('input[name^="type_sponsor"]').each(function() {       
              if(x < maxField)
              {
                if($(this).val().trim()!="")
                {
                  if(sponsorArray[x-1]!="")
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
          calculate();
          $(addButton).css('visibility','visible');
      });

      $('#upload').bind('click', function(){
          var data = new FormData;
          data.append('file', document.getElementById('file_name').files[0]);
          data.append('file_type', $('#file_type').val());
          data.append('id_parent', id_sc);


          $.ajax({
              url : "<?php echo base_url(); ?>index.php/HCPReport/upload",
              type : 'POST',
              data : data,
              contentType: false,
              processData: false,
              success : function(json) {
                $.ajax({
                  url: "<?php echo base_url(); ?>index.php/HCPReport/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                    type: "GET",
                    dataType: "text",
                    success: function(response){
                      $('#attachment').html(response);

					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/HCPReport/getListAttachment?id="+id_sc,
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

              }
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

//      $("#event_start_date").datepicker({dateFormat: 'dd/mm/yy'});
//      $("#event_end_date").datepicker({dateFormat: 'dd/mm/yy'});
    });  
</script>
</head>
