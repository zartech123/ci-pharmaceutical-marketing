<head>
  <meta name="viewport" content="width=1024">
    <title>HCP CONSULTANT SPONSORSHIP REQUEST FORM</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.1.0/bootstrap-4.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>

<body style="font-size:13px">
    <div class="container-fluid" style="border:1px solid black;padding-left:22px;padding-right:8px;padding-bottom:8px;padding-top:8px;width:927px">
      <?php 
        $readonly = "";
        $readonly_note1="readonly";
        $readonly_note2="readonly";
        if(isset($_GET['access']))
        {
          if($_GET['access']==5 && $state==2)
          {
            $readonly_note1="";
          }
          if($_GET['access']==4 && $state==3)
          {
            $readonly_note2="";
          }
        }
        else
        {
          $_GET['access']=$this->session->userdata('id_group');
          if($this->session->userdata('id_group')==5 && $state==2)
          {
            $readonly_note1="";
          }
          if($this->session->userdata('id_group')==4 && $state==3)
          {
            $readonly_note2="";
          }
        }  
        if(isset($_GET['id'])) 
        { 
          $readonly="readonly"; 
        } 
      ?>
    <form action="<?php echo base_url().'index.php/HCP/add'; ?>" method="post"> 
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:910px">&nbsp;</div>
        </div>
      <div class="row">
        <div class="col-xs-1" style="background:#efefef;text-align:center;width:910px"><img src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
      </div>
      <div class="row">
        <div class="col-xs-1" style="background:#efefef;text-align:center;width:910px">
          <b>HCP CONSULTANT</b>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1" style="height:30px;background:#efefef;text-align:right;width:370px">
          <b>Doc No.&nbsp;&nbsp;</b>
        </div>
        <span style="background:#efefef;"><?php echo substr($created_date,-4);?>/HCPC/<?php echo date("m",strtotime($created_date));?>/</span><div class="col-xs-1" style="height:30px;background:#efefef;width:451px">
          <div class="form-group">
            <input class="form-control" type="text" id="nodoc2" name="nodoc2" style="width:150px" value="<?php echo $nodoc2; ?>" readonly/>
          </div>
        </div>
      </div>
        <div class="row">
          <div class="col-xs-1" style="width:910px"><hr/></div>
        </div>
      <div class="row" style="height:38px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px"><b>Requested by</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1">
          <div class="form-group">
              <select class="form-control" id="requested_by1" name="requested_by1" style="height:30px;width:170px">
              </select>
          </div>
        </div>
        <div class="col-xs-1" style="width:128px">&nbsp;</div>
        <div class="col-xs-1" style="width:108px"><b>Leader</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1">
          <div class="form-group">
              <select class="form-control" id="requested_by2" name="requested_by2" style="height:30px">
              </select>
          </div>
        </div>
      </div>
      <div class="row" style="height:68px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px"><b>Event Name</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="event_name" name="event_name" readonly
			  style="height:60px;width:280px;"><?php echo $event_name; ?></textarea>
		  </div>
		</div>
		<?php if(isset($_GET['id_mer'])==true) {?>
        <div class="col-xs-1" style="width:18px">&nbsp;</div>
        <div class="col-xs-1" style="width:108px"><b>MER</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1"><?php echo substr($created_date2,-4);?>/MER/<?php echo date("m",strtotime($created_date2));?>/</div>
        <div class="col-xs-1">
          <div class="form-group">
              <input class="form-control" id="nodoc" name="nodoc" type="text" style="width:170px" value="<?php echo $nodoc; ?>" readonly/>
          </div>
        </div>
		<?php } ?>
      </div>
      <div class="row" style="height:68px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px"><b>Organizer of Event</b></div>
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
        <div class="col-xs-1" style="width:210px"><b>Venue</b></div>
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
        <div class="col-xs-1" style="width:210px"><b>Date</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input class="form-control" type="text" id="event_start_date" name="event_start_date" style="width:90px" value="<?php echo $event_start_date; ?>"  readonly/>
            </div>
          </div>  
          <div class="col-xs-1">&nbsp;-&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input class="form-control" type="text" id="event_end_date" name="event_end_date" style="width:90px" value="<?php echo $event_end_date; ?>" readonly/>
            </div>
          </div>
      </div>
      <div class="row" style="height:38px">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px">
          <b>Doctor</b>
        </div>
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
        <div class="col-xs-1" style="width:210px">
          <b>Medicheck Number</b>
        </div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1">
          <div class="form-group">
            <input class="form-control" id="medicheck" name="medicheck" type="text" style="width:170px" value="<?php echo $medicheck; ?>" readonly/>
          </div>
        </div>
      </div>
      <div class="row" style="height:38px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px"><b>Institution</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1" style="width:665px">
          <div class="form-group">
              <select class="form-control" id="event_institution" name="event_institution" style="height:30px">
              </select>
          </div>
        </div>
      </div>
      <div class="row" style="height:68px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px"><b>Contactable Phone</b></div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="event_contact" name="event_contact"
			  style="height:60px;width:350px;"><?php echo $event_contact; ?></textarea>
		  </div>
		</div>
      </div>
      <div class="row" style="height:38px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px">
          <b>Payee (Type)</b>
        </div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1">
          <div class="form-group">
            <select class="form-control" id="payee_type" name="payee_type" style="height:30px">
              <option value="1">Institution</option>
              <option value="2">Individual</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row" style="height:68px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px">
          <b>Payee (Name)</b>
        </div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="payee" name="payee"
			  style="height:60px;width:350px;"><?php echo $payee; ?></textarea>
		  </div>
		</div>
      </div>
      <div class="row" style="height:68px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px">
          <b>Payee (AC Number)</b>
        </div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="account_number" name="account_number"
			  style="height:60px;width:350px;"><?php echo $account_number; ?></textarea>
		  </div>
		</div>
      </div>
      <div class="row" style="height:38px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px">
          <b>Payee (Bank)</b>
        </div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
        <div class="col-xs-1">
          <div class="form-group">
              <select class="form-control" id="bank" name="bank" style="height:30px">
              </select>
          </div>
        </div>
      </div>
      <div class="row" style="height:68px;">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px">
          <b>Payee (Branch)</b>
        </div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="branch" name="branch"
			  style="height:60px;width:350px;"><?php echo $branch; ?></textarea>
		  </div>
		</div>
      </div>
      <div class="row">
        <div class="col-xs-1">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:210px">
          <b>SPONSORSHIP REQUEST:</b>
        </div>
      </div>
       <div class="row">
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;width:200px;text-align:center">
          <b>&nbsp;Reason of this Engagement&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="width:700px;text-align:center;">
              <textarea rows="3" class="form-control" id="reason" name="reason"
                style="height:90px;width:699px;"><?php echo $reason; ?></textarea>
        </div>
      </div>
     <div class="row">
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;width:200px;text-align:center">
          <b>&nbsp;Type of sponsor&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;width:400px;text-align:center;border-bottom:1px solid black;">
          <b>&nbsp;Description&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;width:150px;text-align:center;border-bottom:1px solid black;">
          <b>&nbsp;Local Currency<br>(IDR)&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:150px;text-align:center;border-bottom:1px solid black;">
          <b>&nbsp;Foreign Currency<input id="exchange" name="exchange" class="form-control" type="text" style="width:148px;height:30px;" value="<?php echo $exchange; ?>"/></b>
        </div>
      </div>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:201px;border-right:1px solid black;">
          <div class="form-group row">
            <label>&nbsp;&nbsp;&nbsp;&nbsp;Travel :&nbsp;</label>
            <input id="flight" name="flight" class="form-control" type="text" style="width:100px;height:30px;" value="<?php echo $flight; ?>"/>
          </div>
        </div>
        <div class="col-xs-1" style="width:400px">
          <div class="form-group row">
            <label>&nbsp;&nbsp;&nbsp;&nbsp;Depart`&nbsp;:&nbsp;</label>
            <input id="event_start_date1" name="event_start_date1" value="<?php echo $event_start_date1; ?>" class="form-control" type="text" style="width:90px;height:30px;" />
            <label>&nbsp;Return&nbsp;:&nbsp;</label>
            <input id="event_end_date1" name="event_end_date1" value="<?php echo $event_end_date1; ?>" class="form-control" type="text" style="width:90px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="local_amount1" name="local_amount1" class="form-control" type="text" value="<?php echo $local_amount1; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="foreign_amount1" name="foreign_amount1" class="form-control" type="text" value="<?php echo $foreign_amount1; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
      </div>
      <div class="row" style="height:60px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:201px;border-right:1px solid black;height:60px">
          &nbsp;Accommodation Hotel
          <div class="form-group row">
            <label>&nbsp;&nbsp;&nbsp;&nbsp;Type of Room :&nbsp;</label>
            <input id="room" name="room" class="form-control" type="text" style="width:80px;height:30px;" value="<?php echo $room; ?>"/>
          </div>
        </div>
        <div class="col-xs-1" style="width:400px;">
          <div class="form-group row">
            <label>&nbsp;&nbsp;&nbsp;&nbsp;No. of nights&nbsp;:&nbsp;|&nbsp;</label>
            <input id="night" name="night" class="form-control" type="text" style="width:25px;height:30px;" value="<?php echo $night; ?>" maxlength="2"/>
            <label>&nbsp;In`&nbsp;:&nbsp;</label>
            <input id="event_start_date2" name="event_start_date2" value="<?php echo $event_start_date2; ?>" class="form-control" type="text" style="width:90px;height:30px;" />
            <label>&nbsp;Out&nbsp;:&nbsp;</label>
            <input id="event_end_date2" name="event_end_date2" value="<?php echo $event_end_date2; ?>" class="form-control" type="text" style="width:90px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="local_amount2" name="local_amount2" class="form-control" type="text" value="<?php echo $local_amount2; ?>"
              style="width:150px;height:60px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="foreign_amount2" name="foreign_amount2" class="form-control" type="text" value="<?php echo $foreign_amount2; ?>"
              style="width:150px;height:60px;" maxlength="9" />
          </div>
        </div>
      </div>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:200px;">
          &nbsp;Registration Fee&nbsp;
        </div>
        <div class="col-xs-1" style="width:400px">
          <div class="form-group">
            <input id="description3" name="description3" class="form-control" type="text" value="<?php echo $description3; ?>"
              style="width:400px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="local_amount3" name="local_amount3" class="form-control" type="text" value="<?php echo $local_amount3; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="foreign_amount3" name="foreign_amount3" class="form-control" type="text" value="<?php echo $foreign_amount3; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
      </div>
        <div class="field_wrapper">
        <?php
          if($budget==3)
          { 
              $sponsor_text = "sponsor4";
              $description_text = "description4";
              $local_amount_text = "local_amount4";            
              $foreign_amount_text = "foreign_amount4";            
            ?>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:200px">
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:200px;height:30px"
            />
        </div>
        <div class="col-xs-1">
          <div class="form-group">
            <input id="description" name="description[]" class="form-control" type="text" value="<?php echo $$description_text; ?>"
              style="width:400px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="local_amount" name="local_amount[]" class="form-control" type="text" value="<?php echo $$local_amount_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="foreign_amount" name="foreign_amount[]" class="form-control" type="text" value="<?php echo $$foreign_amount_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
          <div class="col-xs-1" style="width:25px">
            <a href="javascript:void(0);" class="add_button"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a>
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
              $local_amount_text = "local_amount".($i+1);
              $foreign_amount_text = "foreign_amount".($i+1);            
        ?>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:200px">
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:200px;height:30px"
            />
        </div>
        <div class="col-xs-1">
          <div class="form-group">
            <input id="description" name="description[]" class="form-control" type="text" value="<?php echo $$description_text; ?>"
              style="width:400px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="local_amount" name="local_amount[]" class="form-control" type="text" value="<?php echo $$local_amount_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="foreign_amount" name="foreign_amount[]" class="form-control" type="text" value="<?php echo $$foreign_amount_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
          <div class="col-xs-1" style="width:25px">
          <?php 
            if($i==3)
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
        <div class="col-xs-1"
          style="border-left:1px solid black;width:600px;border-bottom:1px solid black;text-align:center;border-top:1px solid black;">
          &nbsp;<b>Total Cost Of Sponsorship to this individual</b>&nbsp;
        </div>
        <div class="col-xs-1" id="total1"
          style="border-left:1px solid black;width:150px;border-bottom:1px solid black;text-align:center;border-top:1px solid black;">
          &nbsp;
        </div>
        <div class="col-xs-1" id="total2"
          style="border-left:1px solid black;width:150px;border-right:1px solid black;border-bottom:1px solid black;text-align:center;border-top:1px solid black;">
          &nbsp;
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1">&nbsp;</div>
      </div>
      <div class="row">
        <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
        <div class="col-xs-1" style="width:300px">
          <b>CHARGED TO PRODUCTS (IDR)</b>
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
                maxlength="10"
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
                maxlength="10"
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
                maxlength="10"
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
                maxlength="10"
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
              <option value="1">Travel Itinerary (Optional)</option>
              <option value="2">Others</option>
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
              <button type="button" id="upload" class="btn btn-primary btn-sm">Upload</button>
            </div>
          </div>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:340px;text-align:center;border-bottom:1px solid black;"
          >
            <b>&nbsp;File Name&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:260px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;"
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
        <div class="col-xs-1"
          style="border-left:1px solid black;width:600px;border-right:1px solid black;border-top:1px solid black">
          &nbsp;<b>APPROVAL AND NOTES</b>&nbsp;
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center">
          <b>&nbsp;Prepared By&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center">
          <b>&nbsp;Reviewed&nbsp;</b>
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center">
          <b>&nbsp;Approval&nbsp;</b>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center">
          <br>Prepared by<br/><?php if($state>1)  { echo $approver0;  } else { echo $GLOBALS['approver0']; } ?><br />(<?php echo $created_date;   ?>)<br /><br /><?php if($state>1)  { echo $title0;  } else { echo $GLOBALS['title0']; } ?><br />&nbsp;
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center">
          &nbsp;<br />Reviewed by<br/><?php if($state>2)  { echo $approver1;  } else { echo $GLOBALS['approver1']; } ?><br />(<?php  if($state>2)  { echo $updated_date1;  } ?>)<br /><br /><?php if($state>2)  { echo $title1;  } else { echo $GLOBALS['title1']; } ?><br />&nbsp;
        </div>
        <div class="col-xs-1"
          style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center">
          &nbsp;<br />Approved by<br/><?php if($state>3)  { echo $approver2;  } else { echo $GLOBALS['approver2']; } ?><br />(<?php  if($state>3)  { echo $updated_date2;  } ?>)<br /><br /><?php if($state>3)  { echo $title2;  } else { echo $GLOBALS['title2']; } ?><br />&nbsp;
        </div>
      </div>
      <div class="row">
        <div class="col-xs-1"
          style="width:200px;text-align:center;border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;height:90px">
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
              <textarea rows="3" class="form-control" id="note2" name="note2" <?php echo $readonly_note2; ?>
                style="height:90px;width:200px;border:1px solid black;"><?php echo $note2; ?></textarea>
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
          <div class="col-xs-1" style="width:800px;"><i style='color:red'>* Note is mandatory to be filled if Reviewer / Approver want to Reject / Review this document</i></div>
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
        <input type="hidden" id="list_attachment" value="">
        <input type="hidden" id="state" value="<?php echo $state; ?>">
        <?php if(isset($_GET['access'])) { ?>        
        <input type="hidden" id="id_group" value="<?php echo $_GET['access']; ?>">
        <?php } else { ?>
        <input type="hidden" id="id_group" value="<?php echo $this->session->userdata('id_group'); ?>">
        <?php } ?>
        <?php if(isset($_GET['id_mer'])) { ?>
        <input type="hidden" id="id_mer" name="id_mer" value="<?php echo $_GET['id_mer']; ?>">
        <?php } ?>
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
	if($("#state").val()==6 && ($("#id_group").val()==11 || $("#id_group").val()==6 || $("#id_group").val()==5 || $("#id_group").val()==4))
	{
      $("#print").attr("style", "visibility:show");
	}		
	function printPage()
	{
		window.print();
	}

    var error = "0";
	var error_text = "";
	var calculator = "0";
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
	
	$('input[name^="local_amount[]"]').css("text-align","right");
    $('[id^=local_amount]').css("text-align","right");
	$('input[name^="foreign_amount[]"]').css("text-align","right");
    $('[id^=foreign_amount]').css("text-align","right");
    $('[id^=total]').css("text-align","right");


    if($("#id_group").val()==6 && $("#state").val()==1 && $("#id_parent").val()!=null)
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
            url: "<?php echo base_url(); ?>index.php/HCP/updateState?id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
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

    if(($("#id_group").val()==5 && $("#state").val()==2) || ($("#id_group").val()==4 && $("#state").val()==3))
    {
      var review = document.getElementById('review');
      var approve = document.getElementById('approve');
      var reject = document.getElementById('reject');
      $("#note1").css('border','1px solid #cdcdcd');
      $("#note2").css('border','1px solid #cdcdcd');
//      $("#review").attr("style", "visibility:show");
//      $("#reject").attr("style", "visibility:show");
//      $("#approve").attr("style", "visibility:show");

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
        if(($("#id_group").val()==5 && $("#note1").val()!="") || ($("#id_group").val()==4 && $("#note2").val()!=""))
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/HCP/updateState2?id="+id_sc,
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
          if($("#id_group").val()==5)
          {
            $("#note1").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==4)
          {
            $("#note2").css('border','1px solid #ff0000');
          }
          return false;
        }
      }

      approve.onclick = function() 
      {
        $.ajax({
          url: "<?php echo base_url(); ?>index.php/HCP/updateState?id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
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
				url: "<?php echo base_url(); ?>index.php/HCP/updateState4?active="+active+"&id="+id_sc,
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
        if(($("#id_group").val()==5 && $("#note1").val()!="") || ($("#id_group").val()==4 && $("#note2").val()!=""))
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/HCP/updateState3?id="+id_sc,
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
          if($("#id_group").val()==5)
          {
            $("#note1").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==4)
          {
            $("#note2").css('border','1px solid #ff0000');
          }
          return false;
        }
      }

    }  

//    if(($("#id_group").val()==7 || $("#id_group").val()==8 || $("#id_group").val()==9 || $("#id_group").val()==10) && $("#state").val()==1)
    if($("#id_group").val()==6 && $("#state").val()==1)
    {
      var save = document.getElementById('save');
      $("#save").attr("style", "visibility:show");

      save.onclick = function() 
      {
		error = "0";  
		error_text = "";  
        $("#product1").css('border','1px solid #cdcdcd');
        $("#product2").css('border','1px solid #cdcdcd');
        $("#product3").css('border','1px solid #cdcdcd');
        $("#product4").css('border','1px solid #cdcdcd');
        $("#product_percent1").css('border','1px solid #cdcdcd');
        $("#product_percent2").css('border','1px solid #cdcdcd');
        $("#product_percent3").css('border','1px solid #cdcdcd');
        $("#product_percent4").css('border','1px solid #cdcdcd');
        $("#nodoc2").css('border','1px solid #cdcdcd');
        $("#event_organizer").css('border','1px solid #cdcdcd');
        $("#event_name").css('border','1px solid #cdcdcd');
        $("#event_venue").css('border','1px solid #cdcdcd');
        $("#event_start_date").css('border','1px solid #cdcdcd');
        $("#event_end_date").css('border','1px solid #cdcdcd');
        $("#event_start_date1").css('border','1px solid #cdcdcd');
        $("#event_end_date1").css('border','1px solid #cdcdcd');
        $("#event_start_date2").css('border','1px solid #cdcdcd');
        $("#event_end_date2").css('border','1px solid #cdcdcd');
        $("#event_institution").css('border','1px solid #cdcdcd');
        $("#event_contact").css('border','1px solid #cdcdcd');
        $("#room").css('border','1px solid #cdcdcd');
        $("#flight").css('border','1px solid #cdcdcd');
        $("#payee").css('border','1px solid #cdcdcd');
        $("#branch").css('border','1px solid #cdcdcd');
        $("#bank").css('border','1px solid #cdcdcd');
        $("#account_number").css('border','1px solid #cdcdcd');
        $("#doctor").css('border','1px solid #cdcdcd');
        $("#medicheck").css('border','1px solid #cdcdcd');
        $("#file_type").css('border','1px solid #cdcdcd');
        $("[id^=local_amount]").css('border','1px solid #cdcdcd');
        $("[id^=foreign_amount]").css('border','1px solid #cdcdcd');
        if($("#product1").val()==$("#product2").val() || $("#product1").val()==$("#product3").val() || $("#product1").val()==$("#product4").val() || $("#product2").val()==$("#product3").val() || $("#product2").val()==$("#product4").val() || $("#product3").val()==$("#product4").val())
        {
          $("#product1").css('border','1px solid #ff0000');
          $("#product2").css('border','1px solid #ff0000');
          $("#product3").css('border','1px solid #ff0000');
          $("#product4").css('border','1px solid #ff0000');
          error = "1";
        }
        var product_percent = 0;
        product_percent = parseInt($("#product_percent1").val().split('.').join(''),10)+parseInt($("#product_percent2").val().split('.').join(''),10)+parseInt($("#product_percent3").val().split('.').join(''),10)+parseInt($("#product_percent4").val().split('.').join(''),10);
        if(product_percent!=calculator)
        {
          $("#product_percent1").css('border','1px solid #ff0000');
          $("#product_percent2").css('border','1px solid #ff0000');
          $("#product_percent3").css('border','1px solid #ff0000');
          $("#product_percent4").css('border','1px solid #ff0000');
          error = "1";
		  error_text = error_text+"<br>Total Product should match with Estimated Budget";
        }
        if ($.datepicker.parseDate('dd/mm/yy', $("#event_start_date").val()) > $.datepicker.parseDate('dd/mm/yy', $("#event_end_date").val())) 
        {
          $("#event_start_date").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>End Date can't be earlier than Start Date";
          error = "1";
        }        
        if ($.datepicker.parseDate('dd/mm/yy', $("#event_start_date1").val()) > $.datepicker.parseDate('dd/mm/yy', $("#event_end_date1").val())) 
        {
          $("#event_start_date1").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Return Date can't be earlier than Depart Date";
          error = "1";
        }        
        if ($.datepicker.parseDate('dd/mm/yy', $("#event_start_date2").val()) > $.datepicker.parseDate('dd/mm/yy', $("#event_end_date2").val())) 
        {
          $("#event_start_date2").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Check Out Date can't be earlier than Check In Date";
          error = "1";
        }        
        if($("#nodoc2").val().trim()=="")
        {
          $("#nodoc2").css('border','1px solid #ff0000');
          error = "1";
        }
        if($("#room").val().trim()=="")
        {
          $("#room").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Type of Room";
          error = "1";
        }
        if($("#event_institution").val()==null)
        {
          $("#event_institution").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Event Institution";
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
        if($("#event_start_date1").val().trim()=="")
        {
          $("#event_start_date1").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Depart Date";
          error = "1";
        }
        if($("#event_end_date1").val().trim()==null)
        {
          $("#event_end_date1").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Return Date";
          error = "1";
        }
        if($("#event_start_date2").val().trim()=="")
        {
          $("#event_start_date2").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Check In Date";
          error = "1";
        }
        if($("#event_end_date2").val().trim()=="")
        {
          $("#event_end_date2").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Check Out Date";
          error = "1";
        }
        if($("#flight").val().trim()=="")
        {
          $("#flight").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Travel";
          error = "1";
        }
        if($("#account_number").val().trim()=="")
        {
          $("#account_number").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Account Number";
          error = "1";
        }
        if($("#payee").val().trim()=="")
        {
          $("#payee").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Payee";
          error = "1";
        }
        if($("#bank").val()==null)
        {
          $("#bank").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please select the Bank Name";
          error = "1";
        }
        if($("#branch").val().trim()=="")
        {
          $("#branch").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Bank Branch";
          error = "1";
        }
        if($("#doctor").val()==null)
        {
          $("#doctor").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please select the Doctor";
          error = "1";
        }
        if($("#medicheck").val().trim()=="")
        {
          $("#medicheck").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Medicheck Number";
          error = "1";
        }
        if($("#local_amount1").val()=="0" && $("#local_amount2").val()=="0" && $("#local_amount3").val()=="0")
        {
          $("[id^=local_amount]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Local Amount";
          error = "1";
        }
        if(($("#local_amount1").val()>0 || $("#local_amount2").val()>0 || $("#local_amount3").val()>0) && ($("#foreign_amount1").val()>0 || $("#foreign_amount2").val()>0 || $("#foreign_amount3").val()>0))
        {
          $("[id^=local_amount]").css('border','1px solid #ff0000');
          $("[id^=foreign_amount]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Local Amount or Foreign Amount Only";
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

    function calculate()
    {
      var local_amount = 0;
      $('input[name^="local_amount[]"]').each(function() {
        local_amount = local_amount + parseInt($(this).val().split('.').join(''),0);
      });
      var foreign_amount = 0;
      $('input[name^="foreign_amount[]"]').each(function() {
        foreign_amount = foreign_amount + parseInt($(this).val().split('.').join(''),0);
      });

      $("#total1").text(parseInt($("#local_amount1").val().split('.').join(''),0)+parseInt($("#local_amount2").val().split('.').join(''),0)+parseInt($("#local_amount3").val().split('.').join(''),0)+parseInt(local_amount,0));
      $("#total2").text(parseInt($("#foreign_amount1").val().split('.').join(''),0)+parseInt($("#foreign_amount2").val().split('.').join(''),0)+parseInt($("#foreign_amount3").val().split('.').join(''),0)+parseInt(foreign_amount,0));
	  calculator = parseInt($("#total1").text(),0);
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
        url: "<?php echo base_url(); ?>index.php/HCP/deleteAttachment?id="+id,
          type: "GET",
          dataType: "text",
          success: function(response){
            $.ajax({
              url: "<?php echo base_url(); ?>index.php/HCP/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#attachment').html(response);

					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/HCP/getListAttachment?id="+id_sc,
						type: "GET",
						dataType: "text",
					  success: function(response){
						  $('#list_attachment').val(response);
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


    $(function () {

		numeral.locale('id');
      calculate();

      $("[id^=product_percent]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
      });      
      $("[id^=local_amount]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });      
      $("[id^=foreign_amount]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });      

      if($("#id_group").val()<=5 || ($("#id_group").val()>=6 && $("#state").val()>1))
      {
        $("#doctor").prop("readonly",true);
        $("#medicheck").prop("readonly",true);
        $("#bank").prop("readonly",true);
        $("#payee").prop("readonly",true);
        $("#branch").prop("readonly",true);
        $("#account_number").prop("readonly",true);
        $("#room").prop("readonly",true);
        $("#exchange").prop("readonly",true);
        $("#flight").prop("readonly",true);
        $("#nodoc2").prop("readonly",true);
        $("[id^=product_percent]").prop("readonly",true);
        $("[id^=local_amount]").prop("readonly",true);
        $("[id^=foreign_amount]").prop("readonly",true);
        $("[id^=description]").prop("readonly",true);
        $("[id^=type_sponsor]").prop("readonly",true);
        $("[id^=reason]").prop("readonly",true);
        $("[id^=event]").prop("readonly",true);
        $("[id^=upload]").prop("disabled",true);
        $(".add_button").attr("style", "visibility: hidden");
        $(".remove_button").attr("style", "visibility: hidden");
      }

      if($("#id_group").val()>6 || $("#id_group").val()<=5)
      {
        $("[id^=upload]").prop("disabled",true);
      }


//****
      var x = 1;  
		var id_user = 0;
      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_sc = <?php echo $_GET['id'];  ?>;
        id_user = <?php echo $requested_by; ?>;
        <?php if($budget==3) {?>
        x = 1;  
        <?php } else { ?>
        x = <?php echo ($budget-3); ?>; //Initial field counter is 1        
		<?php } } else { ?>
        id_sc = "";
        id_user = <?php echo $this->session->userdata('id_user'); ?>;
		x = 1;
      <?php  } ?>

            $.ajax({
              url: "<?php echo base_url(); ?>index.php/HCP/getListAttachment?id="+id_sc,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#list_attachment').val(response);

              },
              error: function(response)
              {
              },
            });

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/HCP/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
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
        url: "<?php echo base_url(); ?>index.php/HCP/getDoctor",
          type: "GET",
          dataType: "text",
        success: function(response){
          var json = $.parseJSON(response);
          $('#doctor').append('<option value="0">-- Please Select the Doctor --</option>');
          for (var i=0;i<json.length;++i)
          {
              $('#doctor').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
		  <?php
			if(isset($_GET['id']))
			{
		  ?>
          $("#doctor").val('<?php echo $doctor; ?>');
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/HCP/getMedicheck?id_doctor="+<?php echo $doctor; ?>,
              type: "GET",
              dataType: "text",
            success: function(response){
              $("#medicheck").val(response);
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

      $("#doctor").change(function(){
          var doctor = this.value;
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/HCP/getMedicheck?id_doctor="+doctor,
              type: "GET",
              dataType: "text",
            success: function(response){
              $("#medicheck").val(response);
            },
            error: function(response)
            {
            },
          });
        });


      $.ajax({
        url: "<?php echo base_url(); ?>index.php/HCP/getBank",
          type: "GET",
          dataType: "text",
        success: function(response){
          var json = $.parseJSON(response);
          for (var i=0;i<json.length;++i)
          {
              $('#bank').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
          $("#bank").val('<?php echo $bank; ?>');
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
        },
        error: function(response)
        {
        },
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

//****

      var maxField = 10;
      var addButton = $('.add_button');
      var wrapper = $('.field_wrapper');
      var description_text = "description"+(x+3);
      var local_amount_text = "local_amount"+(x+3);
      var foreign_amount_text = "foreign_amount"+(x+3);
      var total_text = "total"+(x+3);
      var fieldHTML = '<div class="row" style="height:30px"><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="type_sponsor[]" id="type_sponsor" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px"/>';
      fieldHTML = fieldHTML + '</div>';
      fieldHTML = fieldHTML + '<div class="col-xs-1" style="width:400px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="description[]" id="'+description_text+'" class="form-control" type="text" style="width:400px;border-right:1px solid black;border-top:1px solid black;height:30px">';
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:150px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="local_amount[]" id="'+local_amount_text+'" class="form-control" type="text" style="width:150px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';    
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:150px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="foreign_amount[]" id="'+foreign_amount_text+'" class="form-control" type="text" style="width:150px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';    
      fieldHTML = fieldHTML + '</div>';
      fieldHTML = fieldHTML + '<div class="col-xs-1" style="border-left:1px solid black;width:25px">';    
      fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>'; 


      $('#account_number').keypress(validateNumber);
      $('[id^=product_percent]').keypress(validateNumber);
      $('[id^=local_amount]').keypress(validateNumber);
      $('[id^=foreign_amount]').keypress(validateNumber);
      $('#requested_by1').val('<?php echo $requested_by; ?>');
      $('#payee_type').val('<?php echo $payee_type; ?>');

      $(addButton).click(function(){
          //Check maximum number of input fields
          var localArray = new Array();
          $('input[name^="local_amount[]"]').each(function() {
            localArray.push($(this).val().split('.').join(''));
          });

          var sponsorArray = new Array();
          $('input[name^="type_sponsor[]"]').each(function() {
            sponsorArray.push($(this).val());
          });

          var descArray = new Array();
          $('input[name^="description[]"]').each(function() {
            descArray.push($(this).val());
          });

            //Check maximum number of input fields
            $('input[name^="type_sponsor[]"]').each(function() {       
              if(x < maxField)
              {
                if($(this).val().trim()!="")
                {
                  if(sponsorArray[x-1]!="" && localArray[x-1]>0)
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
              url : "<?php echo base_url(); ?>index.php/HCP/upload",
              type : 'POST',
              data : data,
              contentType: false,
              processData: false,
              success : function(json) {
                $.ajax({
                  url: "<?php echo base_url(); ?>index.php/HCP/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                    type: "GET",
                    dataType: "text",
                    success: function(response){
                      $('#attachment').html(response);

					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/HCP/getListAttachment?id="+id_sc,
						type: "GET",
						dataType: "text",
					  success: function(response){
						  $('#list_attachment').val(response);
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
//    $("#event_start_date").datepicker({dateFormat: 'dd/mm/yy'});
//    $("#event_end_date").datepicker({dateFormat: 'dd/mm/yy'});
    $("#event_start_date1").datepicker({dateFormat: 'dd/mm/yy'});
    $("#event_end_date1").datepicker({dateFormat: 'dd/mm/yy'});
    $("#event_start_date2").datepicker({dateFormat: 'dd/mm/yy'});
    $("#event_end_date2").datepicker({dateFormat: 'dd/mm/yy'});
  });
</script>
</head>
