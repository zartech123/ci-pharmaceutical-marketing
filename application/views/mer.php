<head>
	<meta name="viewport" content="width=1024">
    <title>MASTER EVENT REQUEST</title>
  <link
    rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous"
  />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
  <script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"
  ></script>
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.1.0/bootstrap-4.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link href="<?php echo base_url(); ?>assets/css/jquery.multiselect.css" rel="stylesheet"/>
<script src="<?php echo base_url(); ?>assets/js/jquery.multiselect.js"></script>

<body style="font-size:13px">
    <div class="container-fluid" style="border:1px solid black;padding-left:22px;padding-right:8px;padding-bottom:8px;padding-top:8px;width:1217px">
      <?php 
        $readonly = "";
        $readonly_note1="readonly";
        $readonly_note2="readonly";
        $readonly_note3="readonly";
        $readonly_note4="readonly";
        $readonly_note5="readonly";
        if(isset($_GET['access']))
        {
          if($_GET['access']==5 && $state==2)
          {
            $readonly_note1="";
          }
          if($_GET['access']==12 && $state==3)
          {
            $readonly_note2="";
          }
          if($_GET['access']==4 && $state==4)
          {
            $readonly_note3="";
          }
          if($_GET['access']==26 && $state==5)
          {
            $readonly_note4="";
          }
          if($_GET['access']==18 && $state==6)
          {
            $readonly_note5="";
          }
        }
        else
        {
          $_GET['access']=$this->session->userdata('id_group');
          if($this->session->userdata('id_group')==5 && $state==2)
          {
            $readonly_note1="";
          }
          if($this->session->userdata('id_group')==12 && $state==3)
          {
            $readonly_note2="";
          }
          if($this->session->userdata('id_group')==4 && $state==4)
          {
            $readonly_note3="";
          }
          if($this->session->userdata('id_group')==26 && $state==5)
          {
            $readonly_note4="";
          }
          if($this->session->userdata('id_group')==18 && $state==6)
          {
            $readonly_note5="";
          }
        }          
        if(isset($_GET['id'])) 
        { 
          $readonly="readonly"; 
        } 
      ?>

      <form action="<?php echo base_url().'index.php/MER/add'; ?>" method="post">
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:1200px">&nbsp;</div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:1200px"><img src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:1200px">
            <b>MASTER EVENT REQUEST FORM</b>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="height:30px;background:#efefef;text-align:right;width:510px">
            <b>Doc No.&nbsp;&nbsp;</b>
          </div>
          <span style="background:#efefef;"><?php echo substr($created_date,-4);?>/MER/<?php echo date("m",strtotime($created_date));?>/</span><div class="col-xs-1" style="height:30px;background:#efefef;width:607px">
            <div class="form-group">
              <input
                class="form-control"
                type="text"
                id="nodoc"
                name="nodoc"
                maxlength="4"
                style="width:150px;"
                readonly
                value="<?php echo $nodoc; ?>"
              />
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:1200px"><hr/></div>
        </div>
        <div class="row" style="height:38px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:150px;"><b>Type</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <select class="form-control" name="type" id="type" style="height:30px">
                <option value="1">Third Party</option>
                <option value="2">TPI</option>
              </select>
            </div>
          </div>
          <div class="col-xs-1" style="width:50px">&nbsp;</div>
          <div class="col-xs-1" style="width:93px"><b>Location</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <select class="form-control" name="location" id="location" style="height:30px">
                <option value="1">Local Event</option>
                <option value="2">Overseas Event</option>
              </select>
            </div>
          </div>
        </div>
        <div class="row" style="height:38px">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:150px"><b>Requested By</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <select class="form-control" id="requested_by" name="requested_by" style="height:30px;width:350px">
              </select>
            </div>
          </div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:150px"><b>Event Name</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="event_name" name="event_name"
				  style="height:60px;width:350px;"><?php echo $event_name; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:150px"><b>Organizer of Event</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="event_organizer" name="event_organizer"
				  style="height:60px;width:350px;"><?php echo $event_organizer; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:68px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:150px"><b>Venue</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
			<div class="col-xs-1">
			  <div class="form-group">
				<textarea rows="2" class="form-control" id="event_venue" name="event_venue"
				  style="height:60px;width:350px;"><?php echo $event_venue; ?></textarea>
			  </div>
			</div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:150px"><b>Date / Period</b></div>
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
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:150px"><b>Quota</b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <input class="form-control" id="event_quota" name="event_quota" type="text"  style="width:40px" maxlength="4" value="<?php echo $event_quota; ?>"/>
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
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;width:160px;text-align:center"
          >
            <b>&nbsp;Type of sponsor&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:100px;text-align:center;border-bottom:1px solid black;"
          >
            <b>&nbsp;No of Pax&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;"
          >
            <b>&nbsp;Cost of Each&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:201px;border-bottom:1px solid black;text-align:center"
          >
            <b>&nbsp;Estimated Amount (IDR)&nbsp;</b>
          </div>
        </div>
        <div class="row" style="height:30px;">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;width:160px;"
          >
            &nbsp;Symposium/Congres&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <div class="form-group">
              <input
                id="description1"
                name="description1"
                class="form-control"
                type="text"
				maxlength="3"
                value="<?php echo $description1; ?>"
                style="width:100px;height:30px;"
              />
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <div class="form-group">
              <input
                id="amount1"
                name="amount1"
                class="form-control"
                type="text"
                value="<?php echo $amount1; ?>"
				style="width:200px;height:30px" maxlength="10"
              />
            </div>
          </div>
  		  <div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total1"></div>
        </div>
        <div class="row" style="height:30px;">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;width:160px;"
          >
            &nbsp;Booth&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <div class="form-group">
              <input
                id="description2"
                name="description2"
				maxlength="3"
                class="form-control"
                type="text"
                value="<?php echo $description2; ?>"
                style="width:100px;height:30px;"
              />
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <div class="form-group">
              <input
                id="amount2"
                name="amount2"
                class="form-control"
                type="text"
                value="<?php echo $amount2; ?>"
				style="width:200px;height:30px" maxlength="10"
              />
            </div>
          </div>
			<div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total2"></div>

        </div>
        <div class="row" style="height:30px;">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;width:160px;"
          >
            &nbsp;Registration&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <div class="form-group">
              <input
                id="description3"
                name="description3"
				maxlength="3"
                class="form-control"
                type="text"
                value="<?php echo $description3; ?>"
                style="width:100px;height:30px;"
              />
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <div class="form-group">
              <input
                id="amount3"
                name="amount3"
                class="form-control"
                type="text"
                value="<?php echo $amount3; ?>"
				style="width:200px;height:30px" maxlength="10"
              />
            </div>
          </div>
			<div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total3"></div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:160px">
            &nbsp;Travel&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <div class="form-group">
              <input
                id="description4"
                name="description4"
				maxlength="3"
                class="form-control"
                type="text"
                value="<?php echo $description4; ?>"
                style="width:100px;height:30px;"
              />
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <div class="form-group">
              <input
                id="amount4"
                name="amount4"
                class="form-control"
                type="text"
                value="<?php echo $amount4; ?>"
				style="width:200px;height:30px" maxlength="10"
              />
            </div>
          </div>
			<div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total4"></div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:160px">
            &nbsp;Accommodation&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <div class="form-group">
              <input
                id="description5"
                name="description5"
				maxlength="3"
                class="form-control"
                type="text"
                value="<?php echo $description5; ?>"
                style="width:100px;height:30px;"
              />
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <div class="form-group">
              <input
                id="amount5"
                name="amount5"
                class="form-control"
                type="text"
                value="<?php echo $amount5; ?>"
				style="width:200px;height:30px" maxlength="10"
              />
            </div>
          </div>
 			<div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total5"></div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:160px">
            &nbsp;Business Meeting&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <div class="form-group">
              <input
                id="description6"
                name="description6"
				maxlength="3"
                class="form-control"
                type="text"
                value="<?php echo $description6; ?>"
                style="width:100px;height:30px;"
              />
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <div class="form-group">
              <input
                id="amount6"
                name="amount6"
                class="form-control"
                type="text"
                value="<?php echo $amount6; ?>"
				style="width:200px;height:30px" maxlength="10"
              />
            </div>
          </div>
 			<div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total6"></div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:160px">
            &nbsp;Spaker Fee&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <div class="form-group">
              <input
                id="description7"
                name="description7"
				maxlength="3"
                class="form-control"
                type="text"
                value="<?php echo $description7; ?>"
                style="width:100px;height:30px;"
              />
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <div class="form-group">
              <input
                id="amount7"
                name="amount7"
                class="form-control"
                type="text"
                value="<?php echo $amount7; ?>"
				style="width:200px;height:30px" maxlength="10"
              />
            </div>
          </div>
 			<div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total7"></div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:160px">
            &nbsp;Booth Construction&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <div class="form-group">
              <input
                id="description8"
                name="description8"
				maxlength="3"
                class="form-control"
                type="text"
                value="<?php echo $description8; ?>"
                style="width:100px;height:30px;"
              />
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <div class="form-group">
              <input
                id="amount8"
                name="amount8"
                class="form-control"
                type="text"
                value="<?php echo $amount8; ?>"
				style="width:200px;height:30px" maxlength="10"
              />
            </div>
          </div>
			<div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total8"></div>
        </div>
        <div class="row" style="height:30px;">
          <div class="col-xs-1" style="border-left:1px solid black;width:160px">
            &nbsp;PP&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <div class="form-group">
              <input
                id="description9"
                name="description9"
				maxlength="3"
                class="form-control"
                type="text"
                value="<?php echo $description9; ?>"
                style="width:100px;height:30px;"
              />
            </div>
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <div class="form-group">
              <input
                id="amount9"
                name="amount9"
                class="form-control"
                type="text"
                value="<?php echo $amount9; ?>"
				style="width:200px;height:30px" maxlength="10"
              />
            </div>
          </div>
			<div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total9"></div>
        </div>
        <div class="row" style="height:30px;">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;width:160px"
          >
            &nbsp;RTD&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <input
              id="description10"
              name="description10"
				maxlength="3"
              class="form-control"
              type="text"
              value="<?php echo $description10; ?>"
              style="width:100px;height:30px"
            />
          </div>
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <input
              id="amount10"
              name="amount10"
              class="form-control"
              type="text"
              value="<?php echo $amount10; ?>"
              style="width:200px;height:30px" maxlength="10"
            />
          </div>
			<div class="col-xs-1" style="border-right:1px solid black;width:200px;border-bottom:1px solid black;height:30px;" id="total10"></div>
        </div>
        <div class="field_wrapper">
        <?php

          if($budget==10)
          { 
              $sponsor_text = "sponsor11";
              $description_text = "description11";
              $amount_text = "amount11";            
              $total_text = "total11";            
            ?>
        <div class="row" style="height:30px;"> 
          <div
            class="col-xs-1"
            style="width:160px;"
          >
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:160px;height:30px"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <input
              id="description11"
              name="description[]"
				maxlength="3"
              class="form-control"
              type="text"
              value="<?php echo $$description_text; ?>"
              style="width:100px;height:30px"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <input
              id="amount11"
              name="amount[]"
              class="form-control"
              type="text"
              value="<?php echo $$amount_text; ?>"
              style="width:200px;height:30px" maxlength="10"
            />
          </div>
			<div class="col-xs-1" style="width:200px;border-bottom:1px solid black;height:30px;" id="<?php echo $total_text; ?>"></div>
          <div class="col-xs-1" style="border-left:1px solid black;width:25px">
            <a href="javascript:void(0);" class="add_button"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a>
          </div>
          <?php   
          }
          if($budget>10)
          {
            for($i=10;$i<$budget;$i++)
            {
              $sponsor_text = "sponsor".($i+1);
              $description_text = "description".($i+1);
              $amount_text = "amount".($i+1);
              $total_text = "total".($i+1);
        ?>
        <div class="row" style="height:30px;"> 
          <div
            class="col-xs-1"
            style="width:160px;"
          >
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:160px;height:30px"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:100px;"
          >
            <input
              id="<?php echo $description_text; ?>"
              name="description[]"
				maxlength="3"
              class="form-control"
              type="text"
              value="<?php echo $$description_text; ?>"
              style="width:100px;height:30px"
            />
          </div>        
          <div
            class="col-xs-1"
            style="width:200px;"
          >
            <input
              id="<?php echo $amount_text; ?>"
              name="amount[]"
              class="form-control"
              type="text"
              value="<?php echo $$amount_text; ?>"
              style="width:200px;height:30px" maxlength="10"
            />
          </div>
			<div class="col-xs-1" style="width:200px;border-bottom:1px solid black;height:30px;" id="<?php echo $total_text; ?>"></div>
          <div class="col-xs-1" style="border-left:1px solid black;width:25px">
          <?php 
            if($i==10)
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
            style="border-left:1px solid black;width:460px;border-bottom:1px solid black;text-align:center"
          >
            &nbsp;<b>TOTAL ESTIMATED BUDGET</b>&nbsp;
          </div>
          <div
            class="col-xs-1" id="total"
            style="border-left:1px solid black;width:201px;border-right:1px solid black;border-bottom:1px solid black;text-align:center"
          >
            &nbsp;
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1">&nbsp;</div>
        </div>
        <?php 
//          if($_GET['type']=="2") 
//          {  
        ?>
        <div class="tpi">
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;width:585px;border-right:1px solid black;border-top:1px solid black"
          >
            &nbsp;<b>Presentation Material</b>&nbsp;(<i>for TPI Event</i>)&nbsp;
          </div>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:185px;text-align:center;border-bottom:1px solid black;"
          >
            <b>&nbsp;No Docs&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;"
          >
            <b>&nbsp;Topics&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;"
          >
            <b>&nbsp;Presentation Name&nbsp;</b>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:185px">
            <div class="form-group">
              <textarea
                rows="5"
                class="form-control"
                id="nodoc2"
                name="nodoc2"                
                placeholder="Format number based on RAMED approval"
                style="width:200px;font-style: italic;"
              ><?php echo $nodoc2; ?></textarea
              >
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <textarea
                rows="5"
                class="form-control"
                id="topic"
                name="topic"
                placeholder="Product Presentation"
                style="width:200px;font-style: italic;"
              ><?php echo $topic; ?></textarea
              >
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <textarea
                rows="5"
                class="form-control"
                id="presentation"
                name="presentation"
                placeholder="Kenalog Product Presentation"
                style="width:200px;font-style: italic;"
              ><?php echo $presentation; ?></textarea
              >
            </div>
          </div>
        </div>
        </div>
        <?php 
//          }        
        ?>
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
        <div class="row">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:200px"><b>Speaker <i>(Medical to fill)</i></b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
              <div style="width:400px;word-wrap: break-word;" id="speciality2_text"></div>
          </div>
        </div>
        <div class="speciality3">
        <div class="row">
          <div class="col-xs-1" style="width:220px"></i></div>
          <div class="col-xs-1">&nbsp;&nbsp;&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <select class="3col active" id="speciality2" name="speciality2[]" multiple>
              </select>
            </div>
          </div>
        </div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
          <div class="col-xs-1" style="width:200px"><b>Attendance <i>(Medical to fill)</i></b></div>
          <div class="col-xs-1">&nbsp;:&nbsp;</div>
          <div class="col-xs-1">
              <div style="width:400px;word-wrap: break-word;" id="speciality_text"></div>
          </div>
        </div>
        <div class="speciality3">
        <div class="row">
          <div class="col-xs-1" style="width:220px"></i></div>
          <div class="col-xs-1">&nbsp;&nbsp;&nbsp;</div>
          <div class="col-xs-1">
            <div class="form-group">
              <select class="3col active" id="speciality" name="speciality[]" multiple>
              </select>
            </div>
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
          <div class="col-xs-1">
            <div class="form-group">
              <select class="form-control" id="file_type"  name="file_type" style="height:30px;width:270px">
                <option value="1">Proposal (Optional)</option>
                <option value="2">Event Clarification (Optional)</option>
                <option value="3">Presentation Material (Optional)</option>
                <option value="4">Announcement (Optional)</option>
                <option value="5">Others (Optional)</option>
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
            style="border-left:1px solid black;border-top:1px solid black;width:360px;text-align:center;border-bottom:1px solid black;"
          >
            <b>&nbsp;File Name&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:225px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;"
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
          <div
            id="approval_notes"
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
            <b>&nbsp;Prepared By&nbsp;</b>
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
          <div
            class="col-xs-1"
            id="president_director1"
            style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;visibility:hidden"
          >
            <b>&nbsp;Approval&nbsp;</b>
          </div>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center"
          >
            <br />Prepared by<br/><?php if($state>1) { echo $approver0; }  else { echo $GLOBALS['approver0']; } ?><br />(<?php echo $created_date;   ?>)<br><br><?php if($state>1) { echo $title0; }  else { echo $GLOBALS['title0']; } ?><br />&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;"
          >
            &nbsp;<br />Approved by<br/><?php if($state>2) { echo $approver1; }  else { echo $GLOBALS['approver1']; } ?><br />(<?php if($state>2)  { echo $updated_date1;  } ?>)<br /><br /><?php if($state>2) { echo $title1; }  else { echo $GLOBALS['title1']; } ?><br />&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;"
          >
            &nbsp;<br />Reviewed by<br/><?php if($state>3) { echo $approver2; }  else { echo $GLOBALS['approver2']; } ?><br />(<?php if($state>3)  { echo $updated_date2;  } ?>)<br /><br /><?php if($state>3) { echo $title2; }  else { echo $GLOBALS['title2']; } ?><br />&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;"
          >
            &nbsp;<br />Approved by<br/><?php if($state>4) { echo $approver3; }  else { echo $GLOBALS['approver3']; } ?><br />(<?php  if($state>4)  { echo $updated_date3; } ?>)<br /><br /><?php if($state>4) { echo $title3; }  else { echo $GLOBALS['title3']; } ?><br />&nbsp;
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;"
          >
            &nbsp;<br />Approved by<br/><?php if($state>5) { echo $approver4; }  else { echo $GLOBALS['approver4']; } ?><br />(<?php  if($state>5)  { echo $updated_date4; } ?>)<br /><br /><?php if($state>5) { echo $title4; }  else { echo $GLOBALS['title4']; } ?><br />&nbsp;
          </div>
          <div
            class="col-xs-1"
            id="president_director2"
            style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;visibility:hidden"
          >
            &nbsp;<br />Approved by<br/><?php if($state>6) { echo $approver5; }  else { echo $GLOBALS['approver5']; } ?><br />(<?php  if($state>6)  { echo $updated_date5;  } ?>)<br /><br /><?php if($state>6) { echo $title5; }  else { echo $GLOBALS['title5']; } ?><br />&nbsp;
          </div>
        </div>
        <div class="row">
          <div
            class="col-xs-1"
            style="width:200px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;height:90px;border-left:1px solid black;"
          >
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <textarea
                rows="3"
                class="form-control"
                id="note1"
                name="note1"
                <?php echo $readonly_note1; ?>
                style="height:90px;width:200px;border-right:1px solid black;border-bottom:1px solid black;"
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
                style="height:90px;width:200px;border-right:1px solid black;border-bottom:1px solid black;"
              ><?php echo $note2; ?></textarea>
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <textarea
                rows="3"
                class="form-control"
                id="note3"
                name="note3"
                <?php echo $readonly_note3; ?>
                style="height:90px;width:200px;border-right:1px solid black;border-bottom:1px solid black;"
              ><?php echo $note3; ?></textarea>
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <textarea
                rows="3"
                class="form-control"
                id="note4"
                name="note4"
                <?php echo $readonly_note4; ?>
                style="height:90px;width:200px;border-right:1px solid black;border-bottom:1px solid black;"
              ><?php echo $note4; ?></textarea>
            </div>
          </div>
          <div class="col-xs-1" style="width:200px">
            <div class="form-group">
              <textarea
                rows="3"
                class="form-control"
                id="note5"
                name="note5"
                <?php echo $readonly_note5; ?>
                style="height:90px;width:200px;border-right:1px solid black;border-bottom:1px solid black;visibility:hidden"
              ><?php echo $note5; ?></textarea>
            </div>
          </div>
        </div>
			<div class="row">
			  <div class="col-xs-1" style="width:1200px;"><?php if($state=="7")	{ echo "Document has been fully approved"; } ?></div>
			</div>
			<div class="row">
			  <div class="col-xs-1" style="width:1200px;">&nbsp;</div>
			</div>
        <div class="row">
          <div class="col-xs-1" style="width:1200px;"><i style='color:red'>* Note is mandatory to be filled if Reviewer / Approver want to Reject / Review this document</i></div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:1200px;"><hr/></div>
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
        <input type="hidden" id="speciality_temp" value="<?php echo $speciality; ?>">
        <input type="hidden" id="speciality_temp2" value="<?php echo $speciality2; ?>">
        <?php if(isset($_GET['access'])) { ?>        
        <input type="hidden" id="id_group" value="<?php echo $_GET['access']; ?>">
        <?php } else { ?>
        <input type="hidden" id="id_group" value="<?php echo $this->session->userdata('id_group'); ?>">
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
	if($("#state").val()!=7)
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
	if($("#state").val()==7 && ($("#id_group").val()==11 || $("#id_group").val()==6 || $("#id_group").val()==5 || $("#id_group").val()==12 || $("#id_group").val()==4 || $("#id_group").val()==26 || $("#id_group").val()==18))
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
	
	$('input[name^="amount[]"]').css("text-align","right");
    $('[id^=amount]').css("text-align","right");
	$('input[name^="description[]"]').css("text-align","right");
    $('[id^=description]').css("text-align","right");
    $('[id^=total]').css("text-align","right");

    if($("#id_group").val()==6 && $("#state").val()==1 && $("#id_parent").val()!=null)
    {

      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_mer = <?php echo $_GET['id'];  ?>;
      <?php  } else { ?>
        id_mer = "";
      <?php  } ?>

      var request_approval = document.getElementById('request_approval');
      $("#request_approval").attr("style", "visibility:show");
      request_approval.onclick = function() 
      {
        $("#save").click();
        if(error==0)
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/MER/updateState?id_group="+<?php echo $_GET['access']; ?>+"&id="+id_mer,
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

    if($("#id_group").val()==6 || $("#id_group").val()==5 || $("#id_group").val()==12 || $("#id_group").val()==4 || $("#id_group").val()==26 || $("#id_group").val()==18 || $("#id_group").val()==11)
    {
      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_mer = <?php echo $_GET['id'];  ?>;
      <?php  } else { ?>
        id_mer = "";
      <?php  } ?>

        $.ajax({
          url: "<?php echo base_url(); ?>index.php/MER/getAmount?id="+id_mer,
            type: "GET",
            dataType: "text",
            success: function(response){
              if(response>100000000)
              {
                $("#approval_notes").css("width","1200");
                $("#note5").attr("style", "height:90px;width:200px;border-right:1px solid black;border-bottom:1px solid black;visibility:show");
                $("#president_director1").attr("style", "border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;visibility:show");
                $("#president_director2").attr("style", "border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;visibility:show");
              }
			  else
			  {
                $("#approval_notes").css("width","1000");
				$("#note5").attr("style", "visibility:hidden");
				$("#president_director1").attr("style", "visibility:hidden");
				$("#president_director2").attr("style", "visibility:hidden");
			  }				  
          },
          error: function(response)
          {
          },
        });
    }

    if(($("#id_group").val()==5 && $("#state").val()==2) || ($("#id_group").val()==12 && $("#state").val()==3) || ($("#id_group").val()==4 && $("#state").val()==4) || ($("#id_group").val()==26 && $("#state").val()==5) || ($("#id_group").val()==18 && $("#state").val()==6))
    {
      var review = document.getElementById('review');
      var approve = document.getElementById('approve');
      var reject = document.getElementById('reject');
      $("#note1").css('border','1px solid #cdcdcd');
      $("#note2").css('border','1px solid #cdcdcd');
      $("#note3").css('border','1px solid #cdcdcd');
      $("#note4").css('border','1px solid #cdcdcd');
      $("#note5").css('border','1px solid #cdcdcd');

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
      //$("#approve").attr("style", "visibility:show");
      //$("#reject").attr("style", "visibility:show");
      //$("#freeze").attr("style", "visibility:show");

      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_mer = <?php echo $_GET['id'];  ?>;
      <?php  } else { ?>
        id_mer = "";
      <?php  } ?>

      review.onclick = function() 
      {
        if(($("#id_group").val()==5 && $("#note1").val()!="") || ($("#id_group").val()==12 && $("#note2").val()!="") || ($("#id_group").val()==4 && $("#note3").val()!="") || ($("#id_group").val()==26 && $("#note4").val()!="") || ($("#id_group").val()==18 && $("#note5").val()!=""))
        { 
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/MER/updateState2?id="+id_mer,
              type: "GET",
              dataType: "text",
              success: function(response){
					Swal.fire({
					  position: 'top-end',
					  icon: 'warning',
					  title: 'This request has been returned to Requestor',
					  showConfirmButton: true,
					  showCancelButton: false,
					  focusConfirm: false,
					  confirmButtonText:
						'Close'
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
          if($("#id_group").val()==12)
          {
            $("#note2").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==4)
          {
            $("#note3").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==26)
          {
            $("#note4").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==18)
          {
            $("#note5").css('border','1px solid #ff0000');
          }
        }  
      }

      approve.onclick = function() 
      {
        if($("#id_group").val()==5)
        {
			$("#save").click();
		}	
        if(error==0)
        {
		   $.ajax({
				url: "<?php echo base_url(); ?>index.php/MER/updateState?id_group="+<?php echo $_GET['access']; ?>+"&id="+id_mer,
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
				url: "<?php echo base_url(); ?>index.php/MER/updateState4?active="+active+"&id="+id_mer,
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
        if(($("#id_group").val()==5 && $("#note1").val()!="") || ($("#id_group").val()==12 && $("#note2").val()!="") || ($("#id_group").val()==4 && $("#note3").val()!="") || ($("#id_group").val()==26 && $("#note4").val()!="") || ($("#id_group").val()==18 && $("#note5").val()!=""))
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/MER/updateState3?id="+id_mer,
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
          if($("#id_group").val()==12)
          {
            $("#note2").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==4)
          {
            $("#note3").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==26)
          {
            $("#note4").css('border','1px solid #ff0000');
          }
          if($("#id_group").val()==18)
          {
            $("#note5").css('border','1px solid #ff0000');
          }
        }  
      }  
    }  
    if(($("#id_group").val()==6 && $("#state").val()==1) || ($("#id_group").val()==5 && $("#state").val()==2))
    {
      
      var save = document.getElementById('save');
//      $("#save").attr("style", "visibility:show");
		  <?php if($active==0)	
		  {			
		  ?>
			  $("#save").attr("style", "visibility:hidden");
		  <?php
		  } else	
		  {			
		  ?>
	  $("#save").attr("style", "visibility:show");
		  <?php
		  }			
		   ?>	

      save.onclick = function() 
      {
		error_text = "";  
		error = "0";
        $("#product1").css('border','1px solid #cdcdcd');
        $("#product2").css('border','1px solid #cdcdcd');
        $("#product3").css('border','1px solid #cdcdcd');
        $("#product4").css('border','1px solid #cdcdcd');
        $("#product_percent1").css('border','1px solid #cdcdcd');
        $("#product_percent2").css('border','1px solid #cdcdcd');
        $("#product_percent3").css('border','1px solid #cdcdcd');
        $("#product_percent4").css('border','1px solid #cdcdcd');
        $("#nodoc").css('border','1px solid #cdcdcd');
        $("#event_name").css('border','1px solid #cdcdcd');
        $("#event_organizer").css('border','1px solid #cdcdcd');
        $("#event_venue").css('border','1px solid #cdcdcd');
        $("#speciality").css('border','1px solid #cdcdcd');
        $("#event_start_date").css('border','1px solid #cdcdcd');
        $("#event_end_date").css('border','1px solid #cdcdcd');
        $("#file_type").css('border','1px solid #cdcdcd');
        //$("[id^=amount]").css('border','1px solid #cdcdcd');
        var product_percent = 0;
        product_percent = parseInt($("#product_percent1").val(),10)+parseInt($("#product_percent2").val(),10)+parseInt($("#product_percent3").val(),10)+parseInt($("#product_percent4").val(),10);
        if(product_percent!=100)
        {
          $("#product_percent1").css('border','1px solid #ff0000');
          $("#product_percent2").css('border','1px solid #ff0000');
          $("#product_percent3").css('border','1px solid #ff0000');
          $("#product_percent4").css('border','1px solid #ff0000');
          error = "1";
		  error_text = "Total Product should 100%";
        }
        if($("#product1").val()==$("#product2").val() || $("#product1").val()==$("#product3").val() || $("#product1").val()==$("#product4").val() || $("#product2").val()==$("#product3").val() || $("#product2").val()==$("#product4").val() || $("#product3").val()==$("#product4").val())
        {
          $("#product1").css('border','1px solid #ff0000');
          $("#product2").css('border','1px solid #ff0000');
          $("#product3").css('border','1px solid #ff0000');
          $("#product4").css('border','1px solid #ff0000');
          error = "1";
		  error_text = error_text+"<br>Product can't be duplicated";
        }
        <?php
          if(isset($_GET['id']))
          {
        ?>
/*        if($("#list_attachment").val()!="4" && $("#list_attachment").val()!="1")
        {
            $("#file_type").css('border','1px solid #ff0000');
            error = "2";
        }*/
        <?php } ?>
        if ($.datepicker.parseDate('dd/mm/yy', $("#event_start_date").val()) > $.datepicker.parseDate('dd/mm/yy', $("#event_end_date").val())) 
        {
          $("#event_start_date").css('border','1px solid #ff0000');
          error = "1";
		  error_text = error_text+"<br>End Date can't be earlier than Start Date";
        }        
        if($("#nodoc").val().trim()=="")
        {
          $("#nodoc").css('border','1px solid #ff0000');
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
        /*if($("#amount1").val()=="0" && $("#amount2").val()=="0" && $("#amount3").val()=="0" && $("#amount4").val()=="0" && $("#amount5").val()=="0" && $("#amount6").val()=="0" && $("#amount7").val()=="0" && $("#amount8").val()=="0" && $("#amount9").val()=="0" && $("#amount10").val()=="0")          
        {
          $("[id^=amount]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Cost of Each";
          error = "1";
        }
        if($("#description1").val()=="0" && $("#description2").val()=="0" && $("#description3").val()=="0" && $("#description4").val()=="0" && $("#description5").val()=="0" && $("#description6").val()=="0" && $("#description7").val()=="0" && $("#description8").val()=="0" && $("#description9").val()=="0" && $("#description10").val()=="0")          
        {
          $("[id^=description]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the No of Pax";
          error = "1";
        }*/
//		alert($("#speciality2").val());
		/*if($("#speciality2").val()==null && $("#id_group").val()==5)
		{
          $("[id^=speciality2]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Speaker";
          error = "1";
		}*/			
		/*if($("#speciality2").val()==null  && $("#id_group").val()==5)
		{
          $("[id^=speciality2]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please select the Attandance";
          error = "1";
		}*/			
//		alert(error);
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
        var id_mer = <?php echo $_GET['id'];  ?>;
      <?php  } else { ?>
        id_mer = "";
      <?php  } ?>

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/MER/deleteAttachment?id="+id,
          type: "GET",
          dataType: "text",
          success: function(response){
			$("#file_type").css('border','1px solid #cdcdcd');
            $.ajax({
              url: "<?php echo base_url(); ?>index.php/MER/getAttachment?tpi="+$("#type").val()+"&id="+id_mer+"&state="+<?php echo $state; ?>,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#attachment').html(response);

				$.ajax({
				  url: "<?php echo base_url(); ?>index.php/MER/getListAttachment?id="+id_mer,
					type: "GET",
					dataType: "text",
				  success: function(response){
					  $('#list_attachment').val(response);
//						  if(response=="3" || (response=="0" && $("#type").val()=="2"))
						  if(response=="3" || response=="0")
						  {	  
//      $("#save").attr("style", "visibility:show");
		  <?php if($active==0)	
		  {			
		  ?>
			  $("#save").attr("style", "visibility:hidden");
		  <?php
		  } else	
		  {			
		  ?>
	  $("#save").attr("style", "visibility:show");
		  <?php
		  }			
		   ?>	
							$("#request_approval").attr("style", "visibility:show");
						  }
						  else
						  {
							//$("#save").attr("style", "visibility:hidden");
							$("#request_approval").attr("style", "visibility:hidden");
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
      $("#total1").text($("#description1").val().split('.').join('')*$("#amount1").val().split('.').join(''));
      $("#total2").text($("#description2").val().split('.').join('')*$("#amount2").val().split('.').join(''));
      $("#total3").text($("#description3").val().split('.').join('')*$("#amount3").val().split('.').join(''));
      $("#total4").text($("#description4").val().split('.').join('')*$("#amount4").val().split('.').join(''));
      $("#total5").text($("#description5").val().split('.').join('')*$("#amount5").val().split('.').join(''));
      $("#total6").text($("#description6").val().split('.').join('')*$("#amount6").val().split('.').join(''));
      $("#total7").text($("#description7").val().split('.').join('')*$("#amount7").val().split('.').join(''));
      $("#total8").text($("#description8").val().split('.').join('')*$("#amount8").val().split('.').join(''));
      $("#total9").text($("#description9").val().split('.').join('')*$("#amount9").val().split('.').join(''));
      $("#total10").text($("#description10").val().split('.').join('')*$("#amount10").val().split('.').join(''));

	  var i = 0;	
	  var total = parseInt($("#total1").text().split('.').join(''),0)+parseInt($("#total2").text().split('.').join(''),0)+parseInt($("#total3").text().split('.').join(''),0)+parseInt($("#total4").text().split('.').join(''),0)+parseInt($("#total5").text().split('.').join(''),0)+parseInt($("#total6").text().split('.').join(''),0)+parseInt($("#total7").text().split('.').join(''),0)+parseInt($("#total8").text().split('.').join(''),0)+parseInt($("#total9").text().split('.').join(''),0)+parseInt($("#total10").text().split('.').join(''),0);
      for(i=11;i<=21;i++)
	  {
		  if($("#description"+i).val()!=null && $("#amount"+i).val()!=null)
		  {
			$("#total"+i).text($("#description"+i).val().split('.').join('')*$("#amount"+i).val().split('.').join(''));
			$("#total"+i).text(numeral($("#total"+i).text()).format('0,0'));
			total = total + parseInt($("#total"+i).text().split('.').join(''),0);
		  }  
	  }		  

              if(total>100000000)
              {
                $("#approval_notes").css("width","1200");
                $("#note5").attr("style", "height:90px;width:200px;border-right:1px solid black;border-bottom:1px solid black;visibility:show");
                $("#president_director1").attr("style", "border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;visibility:show");
                $("#president_director2").attr("style", "border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;visibility:show");
              }
			  else
			  {
                $("#approval_notes").css("width","1000");
				$("#note5").attr("style", "visibility:hidden");
				$("#president_director1").attr("style", "visibility:hidden");
				$("#president_director2").attr("style", "visibility:hidden");
			  }				  


	  $("#total").text(total);
	  $("#total").text(numeral($("#total").text()).format('0,0'));
	  $("#total1").text(numeral($("#total1").text()).format('0,0'));
	  $("#total2").text(numeral($("#total2").text()).format('0,0'));
	  $("#total3").text(numeral($("#total3").text()).format('0,0'));
	  $("#total4").text(numeral($("#total4").text()).format('0,0'));
	  $("#total5").text(numeral($("#total5").text()).format('0,0'));
	  $("#total6").text(numeral($("#total6").text()).format('0,0'));
	  $("#total7").text(numeral($("#total7").text()).format('0,0'));
	  $("#total8").text(numeral($("#total8").text()).format('0,0'));
	  $("#total9").text(numeral($("#total9").text()).format('0,0'));
	  $("#total10").text(numeral($("#total10").text()).format('0,0'));
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

//      var type = $("#type").val();

		numeral.locale('id');
      <?php
        if(isset($_GET['id']))
        {
      ?>
	  $("#type").val('<?php echo $type; ?>');
      <?php
        }
      ?>
        if($('#type').val()==1)
        {
          $(".tpi").attr("style", "visibility:hidden");
          $(".tpi").css("height", "0px");
        }
        else
        {
          $(".tpi").attr("style", "visibility:show");
          $(".tpi").css("height", "190px");
        }
//      $('#type').val(type);
      $('#type').change(function() 
      {
          if($('#type').val()==1)
          {
            $(".tpi").attr("style", "visibility:hidden");
            $(".tpi").css("height", "0px");
          }
          else
          {
            $(".tpi").attr("style", "visibility:show");
            $(".tpi").css("height", "190px");
          }
      });      
      calculate();
      $("[id^=amount]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });

      $("[id^=description]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });

      if($("#id_group").val()<=4 || ($("#id_group").val()>=6 && $("#state").val()>1))
      {
        $("#nodoc2").prop("readonly",true);
        $("#topic").prop("readonly",true);
        $("#presentation").prop("readonly",true);
        $("[id^=product_percent]").prop("readonly",true);
        $("[id^=amount]").prop("readonly",true);
        $("[id^=description]").prop("readonly",true);
        $("[id^=type_sponsor]").prop("readonly",true);
        $("[id^=event]").prop("readonly",true);
        $("[id^=upload]").prop("disabled",true);
        $(".add_button").attr("style", "visibility: hidden");
        $(".remove_button").attr("style", "visibility: hidden");
        $(".speciality3").attr("style", "visibility:hidden");
        $(".speciality3").css("height", "30px");

      }  

      if($("#id_group").val()>6)
      {
        $("[id^=upload]").prop("disabled",true);
      }

      var x = 1;  
      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_mer = <?php echo $_GET['id'];  ?>;
        <?php if($budget==10) {?>
        x = 1;  
        <?php } else { ?>
        x = <?php echo ($budget-10); ?>; //Initial field counter is 1        
    <?php  } } else { ?>
        id_mer = "";
        x = 1;
      <?php  } ?>

            $.ajax({
              url: "<?php echo base_url(); ?>index.php/MER/getListAttachment?id="+id_mer,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#list_attachment').val(response);
				  if($("#id_group").val()<=5 || ($("#id_group").val()>=6 && $("#state").val()>1))
				  {
				  }
				  else
				  {	  
//						  if(response=="3" || (response=="0" && $("#type").val()=="2"))
						  if(response=="3" || response=="0")
						  {	  
//      $("#save").attr("style", "visibility:show");
		  <?php if($active==0)	
		  {			
		  ?>
			  $("#save").attr("style", "visibility:hidden");
		  <?php
		  } else	
		  {			
		  ?>
	  $("#save").attr("style", "visibility:show");
		  <?php
		  }			
		   ?>	
							$("#request_approval").attr("style", "visibility:show");
						  }
						  else
						  {
							//$("#save").attr("style", "visibility:hidden");
							$("#request_approval").attr("style", "visibility:hidden");
						  }   					  
				  }	  
              },
              error: function(response)
              {
              },
            });

    $('[id^=amount]').keypress(validateNumber);
    $('[id^=description]').keypress(validateNumber);
    $('[id^=event_quota]').keypress(validateNumber);
    $('[id^=product_percent]').keypress(validateNumber);
    $('#location').val('<?php echo $location; ?>');
    $('#requested_by').val('<?php echo $requested_by; ?>');

    if($("#id_group").val()!=5)
    {
      $(".speciality3").attr("style", "visibility:hidden");
      $(".speciality3").css("height", "30px");
    }
	else
	{
      $(".speciality3").attr("style", "visibility:show");
      $(".speciality3").css("height", "90px");
	}		

		$.ajax({
			url: "<?php echo base_url(); ?>index.php/MER/getAttachment?tpi="+$("#type").val()+"&id="+id_mer+"&state="+<?php echo $state; ?>,
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

		$.ajax({
			url: "<?php echo base_url(); ?>index.php/MER/getUser?id=1",
				type: "GET",
				dataType: "text",
			success: function(response){
				var json = $.parseJSON(response);
				for (var i=0;i<json.length;++i)
				{
					  $('#requested_by').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
				}
        $("#requested_by").val('<?php echo $requested_by; ?>');
			},
			error: function(response)
			{
			},
		});


		$.ajax({
			url: "<?php echo base_url(); ?>index.php/MER/getSpeciality",
				type: "GET",
				dataType: "text",
			success: function(response){
				var json = $.parseJSON(response);
        var speciality = $('#speciality_temp').val();
        var strArray = speciality.split(",");
        var speciality2 = $('#speciality_temp2').val();
        var strArray2 = speciality2.split(",");
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
					if(strArray2.includes(json[i].id))
					{	
						$('#speciality2').append('<option value="'+json[i].id+'" selected>'+json[i].name+'</option>');
					}
					else
					{
						$('#speciality2').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
					}						
				}

        $('select[multiple].active.3col').multiselect({
            columns: 4,
            placeholder: 'Select Speciality',
            search: true,
            searchOptions: {
                'default': 'Search Speciality'
            },
			maxWidth: 800,
			maxPlaceholderWidth: 400,
			maxPlaceholderOpts: 6,
            selectAll: true
        });

//        $("#speciality").val(strArray);
//        $("#speciality2").val(strArray2);
        var text = $('#speciality option:selected').toArray().map(item => item.text).join();
        var text2 = $('#speciality2 option:selected').toArray().map(item => item.text).join();
          
        $("#speciality_text").text(text);
        $("#speciality2_text").text(text2);
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

        $('#speciality2').on('change', function() 
        {
        var text2 = $('#speciality2 option:selected').toArray().map(item => item.text).join();
          
        $("#speciality2_text").text(text2);
          
        });

    var maxField = 10;
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper');
    var description_text = "description"+(x+10);
    var amount_text = "amount"+(x+10);
    var total_text = "total"+(x+10);
    var fieldHTML = '<div class="row" style="height:30px"><div class="col-xs-1" style="width:160px;border-left:1px solid black;border-bottom:1px solid black;">';
	fieldHTML = fieldHTML + '<input name="type_sponsor[]" id="type_sponsor" class="form-control" type="text" style="width:160px;border-right:1px solid black;border-top:1px solid black;height:30px"/>';
	fieldHTML = fieldHTML + '</div>';
	fieldHTML = fieldHTML + '<div class="col-xs-1" style="width:100px;border-left:1px solid black;border-bottom:1px solid black;">';
	fieldHTML = fieldHTML + '<input name="description[]" id="'+description_text+'" class="form-control" type="text" style="width:100px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="3" value="0">';
	fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
	fieldHTML = fieldHTML + '<input name="amount[]" id="'+amount_text+'" class="form-control" type="text" style="text-align:right;width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';
	fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="border-bottom:1px solid black;width:200px;height:30px;text-align:right" id="'+total_text+'"></div>';
	fieldHTML = fieldHTML + '<div class="col-xs-1" style="border-left:1px solid black;width:25px">';
	fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>';
    
    //Once add button is clicked
    $(addButton).click(function()
    {
      var amountArray = new Array();
      $('input[name^="amount[]"]').each(function() {
        amountArray.push($(this).val().split('.').join(''));
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
        $('input[name^="type_sponsor"]').each(function() {       
          if(x < maxField)
          {
            if($(this).val().trim()!="")
            {
              if(sponsorArray[x-1]!="" && amountArray[x-1]>0)
              {
                x++; //Increment field counter
				description_text = "description"+(x+10);
				amount_text = "amount"+(x+10);
				total_text = "total"+(x+10);
				fieldHTML = '<div class="row" style="height:30px"><div class="col-xs-1" style="width:160px;border-left:1px solid black;border-bottom:1px solid black;">';
				fieldHTML = fieldHTML + '<input name="type_sponsor[]" id="type_sponsor" class="form-control" type="text" style="width:160px;border-right:1px solid black;border-top:1px solid black;height:30px"/>';
				fieldHTML = fieldHTML + '</div>';
				fieldHTML = fieldHTML + '<div class="col-xs-1" style="width:100px;border-left:1px solid black;border-bottom:1px solid black;">';
				fieldHTML = fieldHTML + '<input name="description[]" id="'+description_text+'" class="form-control" type="text" style="width:100px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="3" value="0">';
				fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
				fieldHTML = fieldHTML + '<input name="amount[]" id="'+amount_text+'" class="form-control" type="text" style="text-align:right;width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';
				fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="border-bottom:1px solid black;width:200px;height:30px;text-align:right" id="'+total_text+'"></div>';
				fieldHTML = fieldHTML + '<div class="col-xs-1" style="border-left:1px solid black;width:25px">';
				fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>';
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
        data.append('id_parent', id_mer);

        $.ajax({
            url : "<?php echo base_url(); ?>index.php/MER/upload",
            type : 'POST',
            data : data,
            contentType: false,
            processData: false,
            success : function(json) {
			  $("#file_type").css('border','1px solid #cdcdcd');
              $.ajax({
                url: "<?php echo base_url(); ?>index.php/MER/getAttachment?tpi="+$("#type").val()+"&id="+id_mer+"&state="+<?php echo $state; ?>,
                  type: "GET",
                  dataType: "text",
                  success: function(response){
                    $('#attachment').html(response);

					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/MER/getListAttachment?id="+id_mer,
						type: "GET",
						dataType: "text",
					  success: function(response){
						  $('#list_attachment').val(response);
//						  if(response=="3" || (response=="0" && $("#type").val()=="2"))
						  if(response=="3" || response=="0")
						  {	  
//      $("#save").attr("style", "visibility:show");
		  <?php if($active==0)	
		  {			
		  ?>
			  $("#save").attr("style", "visibility:hidden");
		  <?php
		  } else	
		  {			
		  ?>
	  $("#save").attr("style", "visibility:show");
		  <?php
		  }			
		   ?>	
							$("#request_approval").attr("style", "visibility:show");
						  }
						  else
						  {
							//$("#save").attr("style", "visibility:hidden");
							$("#request_approval").attr("style", "visibility:hidden");
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

    $("#event_start_date").datepicker({dateFormat: 'dd/mm/yy'});
    $("#event_end_date").datepicker({dateFormat: 'dd/mm/yy'});
  });
    </script>
</head>
