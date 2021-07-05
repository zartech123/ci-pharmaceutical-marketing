<head>
    <meta name="viewport" content="width=1024">
    <title>HCO SPONSORSHIP REQUEST FORM</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.1.0/bootstrap-4.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<body style="font-size:13px">
    <div class="container-fluid" style="border:1px solid black;padding-left:22px;padding-right:8px;padding-bottom:8px;padding-top:8px;width:777px">
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

      <form action="<?php echo base_url().'index.php/HCO/add'; ?>" method="post">
          <div class="row">
            <div class="col-xs-1" style="background:#efefef;text-align:center;width:760px">&nbsp;</div>
          </div>
          <div class="row">
            <div class="col-xs-1" style="background:#efefef;text-align:center;width:760px"><img src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
          </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:760px">
                    <b>HCO SPONSORSHIP REQUEST FORM</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:760px">
                    <b>For Scientific Meeting by Third Party&nbsp;&nbsp;</b>
                </div>
            </div>
            <div class="row">
              <div class="col-xs-1" style="background:#efefef;text-align:right;width:290px">
                <b>Doc No.&nbsp;&nbsp;</b>
              </div>
              <span style="background:#efefef;"><?php echo substr($created_date,-4);?>/HCO/<?php echo date("m",strtotime($created_date));?>/</span></span><div class="col-xs-1" style="height:30px;background:#efefef;width:386px">
                <div class="form-group">
                  <input class="form-control" type="text" id="nodoc2" name="nodoc2" style="width:150px" value="<?php echo $nodoc2; ?>" readonly/>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-1" style="width:760px"><hr/></div>
            </div>
            <div class="row" style="height:38px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:180px">Requested by</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                    <select class="form-control" id="requested_by" name="requested_by" style="height:30px;width:200px">
                    </select>
                <div class="col-xs-1"></div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:180px">MER</div>
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
                <div class="col-xs-1" style="width:180px">Event Name / Activity</div>
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
                <div class="col-xs-1" style="width:180px">Organizer of Event</div>
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
                <div class="col-xs-1" style="width:180px">Venue</div>
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
              <div class="col-xs-1" style="width:180px">Date</div>
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
        <div class="col-xs-1" style="width:180px">
          Payee (Type)
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
        <div class="col-xs-1" style="width:180px">
          Payee (Name)
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
        <div class="col-xs-1" style="width:180px">
          Payee (AC Number)
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
        <div class="col-xs-1" style="width:180px">
          Payee (Bank)
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
        <div class="col-xs-1" style="width:180px">
          Payee (Branch)
        </div>
        <div class="col-xs-1">&nbsp;:&nbsp;</div>
		<div class="col-xs-1">
		  <div class="form-group">
			<textarea rows="2" class="form-control" id="branch" name="branch"
			  style="height:60px;width:350px;"><?php echo $branch; ?></textarea>
		  </div>
		</div>
      </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:150px">
                    <b>Estimated Budget:</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;width:100px;text-align:center">
                    <b>&nbsp;&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:160px;text-align:center;border-bottom:1px solid black;">
                    <b>&nbsp;Type of Sponsorship&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;">
                    <b>&nbsp;Description&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:150px;text-align:center;border-bottom:1px solid black;">
                    <b>&nbsp;Local Currenty<br />(IDR)&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:150px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;">
                    <b>&nbsp;Foreign Currency<input id="exchange" name="exchange" class="form-control" type="text" style="width:148px;height:30px;" value="<?php echo $exchange; ?>"/></b>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:100px;text-align:center">
                    &nbsp;A / 22613&nbsp;
                </div>
                <div class="col-xs-1" style="width:160px;border-left:1px solid black;height:30px">
                    &nbsp;Booth Stand&nbsp;
                </div>
              <div class="col-xs-1" style="width:200px">
                <div class="form-group">
                  <input id="description1" name="description1" class="form-control" type="text" value="<?php echo $description1; ?>"
                    style="width:200px;height:30px;" />
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
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:100px;text-align:center">
                    &nbsp;B / 22613&nbsp;
                </div>
                <div class="col-xs-1" style="width:160px;border-left:1px solid black;height:30px">
                    &nbsp;Symposia&nbsp;
                </div>
              <div class="col-xs-1" style="width:200px">
                <div class="form-group">
                  <input id="description2" name="description2" class="form-control" type="text" value="<?php echo $description2; ?>"
                    style="width:200px;height:30px;" />
                </div>
              </div>
              <div class="col-xs-1" style="width:150px">
                <div class="form-group">
                  <input id="local_amount2" name="local_amount2" class="form-control" type="text" value="<?php echo $local_amount2; ?>"
					style="width:150px;height:30px;" maxlength="9" />
                </div>
              </div>
              <div class="col-xs-1" style="width:150px">
                <div class="form-group">
                  <input id="foreign_amount2" name="foreign_amount2" class="form-control" type="text" value="<?php echo $foreign_amount2; ?>"
					style="width:150px;height:30px;" maxlength="9" />
                </div>
              </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:100px;text-align:center">
                    &nbsp;C / 22613&nbsp;
                </div>
                <div class="col-xs-1" style="width:160px;border-left:1px solid black;height:30px">
                    &nbsp;Institution Fee&nbsp;
                </div>
              <div class="col-xs-1" style="width:200px">
                <div class="form-group">
                  <input id="description3" name="description3" class="form-control" type="text" value="<?php echo $description3; ?>"
                    style="width:200px;height:30px;" />
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
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:100px;text-align:center">
                    &nbsp;D / 22613&nbsp;
                </div>
                <div class="col-xs-1" style="width:160px;border-left:1px solid black;height:30px">
                    &nbsp;Assosiation Fee&nbsp;
                </div>
              <div class="col-xs-1" style="width:200px">
                <div class="form-group">
                  <input id="description4" name="description4" class="form-control" type="text" value="<?php echo $description4; ?>"
                    style="width:200px;height:30px;" />
                </div>
              </div>
              <div class="col-xs-1" style="width:150px">
                <div class="form-group">
                  <input id="local_amount4" name="local_amount4" class="form-control" type="text" value="<?php echo $local_amount4; ?>"
					style="width:150px;height:30px;" maxlength="9" />
                </div>
              </div>
              <div class="col-xs-1" style="width:150px">
                <div class="form-group">
                  <input id="foreign_amount4" name="foreign_amount4" class="form-control" type="text" value="<?php echo $foreign_amount4; ?>"
					style="width:150px;height:30px;" maxlength="9" />
                </div>
              </div>
            </div>
        <div class="field_wrapper">
        <?php
          if($budget==4)
          { 
              $sponsor_text = "sponsor5";
              $description_text = "description5";
              $local_amount_text = "local_amount5";            
              $foreign_amount_text = "foreign_amount5";            
            ?>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:260px">
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:260px;height:30px"
            />
        </div>
        <div class="col-xs-1">
          <div class="form-group">
            <input id="description5" name="description[]" class="form-control" type="text" value="<?php echo $$description_text; ?>"
              style="width:200px;height:30px;border:1px solid black;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="local_amount5" name="local_amount[]" class="form-control" type="text" value="<?php echo $$local_amount_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="foreign_amount5" name="foreign_amount[]" class="form-control" type="text" value="<?php echo $$foreign_amount_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
          <div class="col-xs-1" style="width:25px">
            <a href="javascript:void(0);" class="add_button"><i class="fa fa-plus fa-2x" aria-hidden="true"></i></a>
          </div>
      </div>
          <?php   
          }
          if($budget>4)
          {
            for($i=4;$i<$budget;$i++)
            {
              $sponsor_text = "sponsor".($i+1);
              $description_text = "description".($i+1);
              $local_amount_text = "local_amount".($i+1);
              $foreign_amount_text = "foreign_amount".($i+1);            
        ?>
      <div class="row" style="height:30px;">
        <div class="col-xs-1" style="border-left:1px solid black;width:260px">
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:260px;height:30px"
            />
        </div>
        <div class="col-xs-1">
          <div class="form-group">
            <input id="description5" name="description[]" class="form-control" type="text" value="<?php echo $$description_text; ?>"
              style="width:200px;height:30px;" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="local_amount5" name="local_amount[]" class="form-control" type="text" value="<?php echo $$local_amount_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
        <div class="col-xs-1" style="width:150px">
          <div class="form-group">
            <input id="foreign_amount5" name="foreign_amount[]" class="form-control" type="text" value="<?php echo $$foreign_amount_text; ?>"
              style="width:150px;height:30px;" maxlength="9" />
          </div>
        </div>
          <div class="col-xs-1" style="width:25px">
          <?php 
            if($i==4)
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
                style="border-left:1px solid black;width:460px;border-bottom:1px solid black;text-align:center;border-top:1px solid black;">
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
        <div class="col-xs-1" style="width:290px">
          <div class="form-group">
            <select class="form-control" id="file_type" style="height:30px">
              <option value="1">Proposal/Letter from the Organizing Committee (Mandatory)</option>
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
            style="border-left:1px solid black;border-top:1px solid black;width:260px;text-align:center;border-bottom:1px solid black;"
          >
            <b>&nbsp;File Name&nbsp;</b>
          </div>
          <div
            class="col-xs-1"
            style="border-left:1px solid black;border-top:1px solid black;width:340px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;"
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
                    style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center">
                    &nbsp;<br>Prepared by<br/><?php if($state>1)  { echo $approver0;  } else { echo $GLOBALS['approver0']; } ?><br />(<?php echo $created_date;   ?>)<br /><br /><?php if($state>1)  { echo $title0;  } else { echo $GLOBALS['title0']; } ?><br />&nbsp;
                </div>
                <div class="col-xs-1"
                    style="border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center">
                    &nbsp;<br>Reviewed by<br/><?php if($state>2)  { echo $approver1;  } else { echo $GLOBALS['approver1']; } ?><br />(<?php  if($state>2)  { echo $updated_date1;  } ?>)<br /><br /><?php if($state>2)  { echo $title1;  } else { echo $GLOBALS['title1']; } ?><br />&nbsp;
                </div>
                <div class="col-xs-1"
                    style="border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center">
                    &nbsp;<br>Approved by<br/><?php if($state>3)  { echo $approver2;  } else { echo $GLOBALS['approver2']; } ?><br />(<?php  if($state>3)  { echo $updated_date2;  } ?>)<br /><br /><?php if($state>3)  { echo $title2;  } else { echo $GLOBALS['title2']; } ?><br />&nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1"
                    style="width:200px;text-align:center;border-left:1px solid black;border-bottom:1px solid black;border-right:1px solid black;height:90px">&nbsp;
                </div>
                <div class="col-xs-1" style="width:200px;">
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
                <div class="col-xs-1" style="width:200px;">
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
              <div class="col-xs-1" style="width:760px"><hr/></div>
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
	if($("#state").val()==6 && ($("#id_group").val()==11 || $("#id_group").val()==6 || $("#id_group").val()==5 || $("#id_group").val()==4))
	{
      $("#print").attr("style", "visibility:show");
	}		
	function printPage()
	{
		window.print();
	}

    var error = "0";
	var calculator = "0";
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
	
	$('input[name^="local_amount[]"]').css("text-align","right");
    $('[id^=local_amount]').css("text-align","right");
	$('input[name^="foreign_amount[]"]').css("text-align","right");
    $('[id^=foreign_amount]').css("text-align","right");
    $('[id^=total]').css("text-align","right");
	$('input[name^="product_percent[]"]').css("text-align","right");
    $('[id^=product_percent]').css("text-align","right");

    function toSeconds(t) 
    {
        var bits = t.split(':');
        return bits[0]*3600 + bits[1]*60;
    }

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
            url: "<?php echo base_url(); ?>index.php/HCO/updateState?id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
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
        if(($("#id_group").val()==5 && $("#note1").val()!="") || ($("#id_group").val()==4 && $("#note2").val()!=""))
        {
          $.ajax({
            url: "<?php echo base_url(); ?>index.php/HCO/updateState2?id="+id_sc,
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
          url: "<?php echo base_url(); ?>index.php/HCO/updateState?id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
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
				url: "<?php echo base_url(); ?>index.php/HCO/updateState4?active="+active+"&id="+id_sc,
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
            url: "<?php echo base_url(); ?>index.php/HCO/updateState3?id="+id_sc,
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
        $("#event_start_date").css('border','1px solid #cdcdcd');
        $("#event_end_date").css('border','1px solid #cdcdcd');
        $("#payee").css('border','1px solid #cdcdcd');
        $("#nodoc2").css('border','1px solid #cdcdcd');
        $("#branch").css('border','1px solid #cdcdcd');
        $("#bank").css('border','1px solid #cdcdcd');
        $("#account_number").css('border','1px solid #cdcdcd');
        $("#event_organizer").css('border','1px solid #cdcdcd');
        $("#event_name").css('border','1px solid #cdcdcd');
        $("#event_venue").css('border','1px solid #cdcdcd');
        $("#file_type").css('border','1px solid #cdcdcd');
        $("[id^=local_amount]").css('border','1px solid #cdcdcd');
        $("[id^=foreign_amount]").css('border','1px solid #cdcdcd');
        var product_percent = 0;
        product_percent = parseInt($("#product_percent1").val().split('.').join(''),10)+parseInt($("#product_percent2").val().split('.').join(''),10)+parseInt($("#product_percent3").val().split('.').join(''),10)+parseInt($("#product_percent4").val().split('.').join(''),10);
//		alert($("#bank").val());
//		alert(calculator+" "+product_percent);
        if(product_percent!=calculator)
        {
          $("#product_percent1").css('border','1px solid #ff0000');
          $("#product_percent2").css('border','1px solid #ff0000');
          $("#product_percent3").css('border','1px solid #ff0000');
          $("#product_percent4").css('border','1px solid #ff0000');
          error = "1";
		  error_text = error_text+"<br>Total Product should match with Estimated Budget";
        }
        <?php
          if(isset($_GET['id']))
          {
        ?>
        if($("#list_attachment").val()!="1")
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
          error = "1";
		  error_text = error_text+"<br>Product can't be duplicated";
        }
        if ($.datepicker.parseDate('dd/mm/yy', $("#event_start_date").val()) > $.datepicker.parseDate('dd/mm/yy', $("#event_end_date").val())) 
        {
          $("#event_start_date").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>End Date can't be earlier than Start Date";
          error = "1";
        }        
        if($("#event_start_date").val().trim()=="")
        {
          $("#event_start_date").css('border','1px solid #ff0000');
          error = "1";
		  error_text = error_text+"<br>Please fill the Start Date";
        }
        if($("#event_end_date").val().trim()=="")
        {
          $("#event_end_date").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the End Date";
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
        if($("#nodoc2").val().trim()=="")
        {
          $("#nodoc2").css('border','1px solid #ff0000');
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
        /*if($("#local_amount1").val()=="0" && $("#local_amount2").val()=="0" && $("#local_amount3").val()=="0" && $("#local_amount4").val()=="0")
        {
          $("[id^=local_amount]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Local Amount";
          error = "1";
        }
        if(($("#local_amount1").val()>0 || $("#local_amount2").val()>0 || $("#local_amount3").val()>0 || $("#local_amount4").val()>0) && ($("#foreign_amount1").val()>0 || $("#foreign_amount2").val()>0 || $("#foreign_amount3").val()>0 || $("#foreign_amount4").val()>0))
        {
          $("[id^=local_amount]").css('border','1px solid #ff0000');
          $("[id^=foreign_amount]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Local Amount or Foreign Amount Only";
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

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/HCO/getBank",
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
        url: "<?php echo base_url(); ?>index.php/HCO/deleteAttachment?id="+id,
          type: "GET",
          dataType: "text",
          success: function(response){
            $.ajax({
              url: "<?php echo base_url(); ?>index.php/HCO/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#attachment').html(response);

				$.ajax({
				  url: "<?php echo base_url(); ?>index.php/HCO/getListAttachment?id="+id_sc,
					type: "GET",
					dataType: "text",
				  success: function(response){
					  $('#list_attachment').val(response);
					  if(response!="1")
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
      var local_amount = 0;
      $('input[name^="local_amount[]"]').each(function() {
        local_amount = local_amount + parseInt($(this).val().split('.').join(''),0);
      });

      var foreign_amount = 0;
      $('input[name^="foreign_amount[]"]').each(function() {
        foreign_amount = foreign_amount + parseInt($(this).val().split('.').join(''),0);
      });

      $("#total1").text(parseInt($("#local_amount1").val().split('.').join(''),0)+parseInt($("#local_amount2").val().split('.').join(''),0)+parseInt($("#local_amount3").val().split('.').join(''),0)+parseInt($("#local_amount4").val().split('.').join(''),0)+parseInt(local_amount,0));
      $("#total2").text(parseInt($("#foreign_amount1").val().split('.').join(''),0)+parseInt($("#foreign_amount2").val().split('.').join(''),0)+parseInt($("#foreign_amount3").val().split('.').join(''),0)+parseInt($("#foreign_amount4").val().split('.').join(''),0)+parseInt(foreign_amount,0));
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
        $("#bank").prop("readonly",true);
        $("#payee").prop("readonly",true);
        $("#branch").prop("readonly",true);
        $("#account_number").prop("readonly",true);
        $("[id^=product_percent]").prop("readonly",true);
        $("[id^=local_amount]").prop("readonly",true);
        $("[id^=foreign_amount]").prop("readonly",true);
        $("[id^=description]").prop("readonly",true);
        $("[id^=type_sponsor]").prop("readonly",true);
        $("[id^=event]").prop("readonly",true);
        $("[id^=upload]").prop("disabled",true);
        $(".add_button").attr("style", "visibility: hidden");
        $(".remove_button").attr("style", "visibility: hidden");
      }

      if($("#id_group").val()>6)
      {
        $("[id^=upload]").prop("disabled",true);
      }

      var x = 1;  
	  var id_user = 1;
      <?php
        if(isset($_GET['id']))
        {
      ?>
        var id_sc = <?php echo $_GET['id'];  ?>;
        id_user = <?php echo $requested_by; ?>;
        <?php if($budget==4) {?>
        x = 1;  
        <?php } else { ?>
        x = <?php echo ($budget-4); ?>; //Initial field counter is 1        
    <?php  } } else { ?>
        id_sc = "";
        id_user = <?php echo $this->session->userdata('id_user'); ?>;
      <?php  } ?>

//YYYYY


            $.ajax({
              url: "<?php echo base_url(); ?>index.php/HCO/getListAttachment?id="+id_sc,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#list_attachment').val(response);

				  if($("#id_group").val()<=5 || ($("#id_group").val()>=6 && $("#state").val()>1))
				  {
				  }
				  else
				  {	  
					  if(response!="1")
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
        url: "<?php echo base_url(); ?>index.php/HCO/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
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
              $('#requested_by').append('<option value="'+json[i].id+'">'+json[i].name+'</option>');
          }
          $("#requested_by1").val(id_user);
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

      var maxField = 10;
      var addButton = $('.add_button');
      var wrapper = $('.field_wrapper');
      var fieldHTML = '<div class="row" style="height:30px"><div class="col-xs-1" style="width:260px;border-left:1px solid black;border-bottom:1px solid black;">';
      var description_text = "description"+(x+4);
      var local_mount_text = "local_mount"+(x+4);
      var foreign_amount_text = "foreign_amount"+(x+4);
      fieldHTML = fieldHTML + '<input name="type_sponsor[]" id="type_sponsor" class="form-control" type="text" style="width:260px;border-right:1px solid black;border-top:1px solid black;height:30px"/>';
      fieldHTML = fieldHTML + '</div>';
      fieldHTML = fieldHTML + '<div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="description[]" id="'+description_text+'" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px">';
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:150px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="local_amount[]" id="'+local_mount_text+'" class="form-control" type="text" style="width:150px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';    
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:150px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="foreign_amount[]" id="'+foreign_amount_text+'" class="form-control" type="text" style="width:150px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';    
      fieldHTML = fieldHTML + '</div>';
      fieldHTML = fieldHTML + '<div class="col-xs-1" style="border-left:1px solid black;width:25px">';    
      fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>'; 


      $('[id^=product_percent]').keypress(validateNumber);
      $('[id^=local_amount]').keypress(validateNumber);
      $('[id^=foreign_amount]').keypress(validateNumber);
      $('#requested_by').val('<?php echo $requested_by; ?>');

      $(addButton).click(function()
      {

          //Check maximum number of input fields
          var localArray = new Array();
          $('input[name^="local_amount[]"]').each(function() {
            localArray.push($(this).val().split('.').join(''));
          });

          var sponsorArray = new Array();
          $('input[name^="type_sponsor[]"]').each(function() {
            sponsorArray.push($(this).val());
          });

          var foreign_amountArray = new Array();
          $('input[name^="foreign_amount[]"]').each(function() {
            foreign_amountArray.push($(this).val().split('.').join(''));
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
          $(addButton).css('visibility','visible');
          calculate();
      });


      $('#upload').bind('click', function(){
          var data = new FormData;
          data.append('file', document.getElementById('file_name').files[0]);
          data.append('file_type', $('#file_type').val());
          data.append('id_parent', id_sc);

          $.ajax({
              url : "<?php echo base_url(); ?>index.php/HCO/upload",
              type : 'POST',
              data : data,
              contentType: false,
              processData: false,
              success : function(json) {
                $.ajax({
                  url: "<?php echo base_url(); ?>index.php/HCO/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                    type: "GET",
                    dataType: "text",
                    success: function(response){
                      $('#attachment').html(response);

					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/HCO/getListAttachment?id="+id_sc,
						type: "GET",
						dataType: "text",
					  success: function(response){
						  $('#list_attachment').val(response);
						  if(response!="1")
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

    });  
//      $("#event_start_date").datepicker({dateFormat: 'dd/mm/yy'});
//      $("#event_end_date").datepicker({dateFormat: 'dd/mm/yy'});

</script>
</head>
