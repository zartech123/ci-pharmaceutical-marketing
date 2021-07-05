<head>
    <meta name="viewport" content="width=1024">
    <title>SCIENTIFIC POST EVENT REPORT</title>
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
    <div class="container-fluid" style="border:1px solid black;padding-left:22px;padding-right:8px;padding-bottom:8px;padding-top:8px;width:878px">
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
    <form action="<?php echo base_url().'index.php/ScientificReport/add'; ?>" method="post"> 
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:860px">&nbsp;</div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:860px"><img src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="background:#efefef;text-align:center;width:860px">
            <b>SCIENTIFIC POST EVENT REPORT</b>
          </div>
        </div>
      <div class="row">
        <div class="col-xs-1" style="background:#efefef;text-align:right;width:325px">
          <b>Doc No.&nbsp;&nbsp;</b>
        </div>
        <span style="background:#efefef;"><?php echo substr($created_date,-4);?>/R-SERF/<?php echo date("m",strtotime($created_date));?>/</span><div class="col-xs-1" style="height:30px;background:#efefef;width:438px">
          <div class="form-group">
            <input class="form-control" type="text" id="nodoc" name="nodoc" style="width:150px" value="<?php echo $nodoc2; ?>" readonly/>
          </div>
        </div>
      </div>
        <div class="row">
          <div class="col-xs-1" style="width:860px"><hr/></div>
        </div>
            <div class="row" style="height:38px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:180px"><b>Requested by (MR)</b></div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="form-group">
                    <select class="form-control" id="requested_by1" name="requested_by1" style="height:30px;width:170px">
                    </select>
                </div>
                <div class="col-xs-1" style="width:80px"></div>
                <div class="col-xs-1" style="width:140px"><b>Employee Number</b></div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <input class="form-control" id="hcp" name="hcp" type="text" style="width:70px" value="<?php echo $hcp; ?>"/>
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
                <div class="col-xs-1" style="width:55px"></div>
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:100px"><strong>Location</strong></div>
                <div class="col-xs-1"></div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:180px"><b>City</b></div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
 				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="event_venue" name="event_venue" readonly
					  style="height:60px;width:170px;"><?php echo $event_venue; ?></textarea>
				  </div>
				</div>
                <div class="col-xs-1" style="width:80px"></div>
                <div class="col-xs-1" style="width:100px">Hospital</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
 				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="location1" name="location1"
					  style="height:60px;width:250px;"><?php echo $location1; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:180px"><strong>Time</strong></div>
                <div class="col-xs-1" style="width:260px"></div>
                <div class="col-xs-1" style="width:100px">Clinic</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
 				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="location2" name="location2"
					  style="height:60px;width:250px;"><?php echo $location2; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:200px">
                    < 11:00</div> <div class="col-xs-1">&nbsp;:&nbsp;
                </div>
                <div class="col-xs-1">
                    <input class="form-control" id="time1" name="time1" type="text" style="width:170px" value="<?php echo $time1; ?>"/>
                </div>
                <div class="col-xs-1" style="width:80px"></div>
                <div class="col-xs-1" style="width:100px">Restaurant</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
 				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="location3" name="location3"
					  style="height:60px;width:250px;"><?php echo $location3; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:200px">11:00 - 13:00</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <input class="form-control" id="time2" name="time2" type="text" style="width:170px" value="<?php echo $time2; ?>"/>
                </div>
                <div class="col-xs-1" style="width:80px"></div>
                <div class="col-xs-1" style="width:100px">Others</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
 				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="location4" name="location4"
					  style="height:60px;width:250px;"><?php echo $location4; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:200px">13:00 - 15:00</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <input class="form-control" id="time3" name="time3" type="text" style="width:170px" value="<?php echo $time3; ?>"/>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:200px">18:00 - 20:00</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <input class="form-control" id="time4" name="time4" type="text" style="width:170px" value="<?php echo $time4; ?>"/>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="width:200px">> 20:00</div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <input class="form-control" id="time5" name="time5" type="text" style="width:170px" value="<?php echo $time5; ?>"/>
                </div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:180px"><b>Product Name</b></div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="product" name="product"
					  style="height:60px;width:350px;"><?php echo $product; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:180px"><b>Topic</b></div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
				<div class="col-xs-1">
				  <div class="form-group">
					<textarea rows="2" class="form-control" id="topic" name="topic"
					  style="height:60px;width:350px;"><?php echo $topic; ?></textarea>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:360px">
                    <b>No of Attendance :</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;border-bottom:1px solid black;width:160px;text-align:center">
                    <b>&nbsp;&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:100px;text-align:center;border-bottom:1px solid black;">
                    <b>&nbsp;Plan&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:100px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;">
                    <b>&nbsp;Actual&nbsp;</b>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:160px;">
                    &nbsp;Physicians Participant&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="plana1" name="plana1" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $plana1; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="actuala1" name="actuala1" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actuala1; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:160px;">
                    &nbsp;Others (Nurse/Pharmacist)&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="plana2" name="plana2" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $plana2; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="actuala2" name="actuala2" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actuala2; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:160px;">
                    &nbsp;Taisho Representatives&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="plana3" name="plana3" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $plana3; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="actuala3" name="actuala3" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actuala3; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;</div>
                <div class="col-xs-1" style="width:760px">
                    <b>Cost</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:280px;">&nbsp;</div>
                <div class="col-xs-1" style="border-left:1px solid black;border-top:1px solid black;width:100px;text-align:center;font-weight:bold">&nbsp;Plan&nbsp;</div>
                <div class="col-xs-1" style="border-left:1px solid black;border-top:1px solid black;width:100px;text-align:center;font-weight:bold">&nbsp;Actual&nbsp;</div>
                <div class="col-xs-1" style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;font-weight:bold">&nbsp;KPK Mapping&nbsp;</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;">
                    &nbsp;Meal&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="planb1" name="planb1" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $planb1; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="actualb1" name="actualb1" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actualb1; ?>"/>
                    </div>
                </div>
				<div class="col-xs-1" style="width:200px">
				  <div class="form-group">
					<select class="form-control" id="kpk1" name="kpk1" style="height:30px">
					  <option value="1">Registrasi</option>
					  <option value="2">Akomodasi</option>
					  <option value="3">Transportasi</option>
					  <option value="4" selected>Honor</option>
					  <option value="5">Nominal (Institusi)</option>
					  <option value="6">None</option>
					</select>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;">
                    &nbsp;Meeting Room Rent Fee/Institution Fee&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="planb2" name="planb2" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $planb2; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="actualb2" name="actualb2" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actualb2; ?>"/>
                    </div>
                </div>
				<div class="col-xs-1" style="width:200px">
				  <div class="form-group">
					<select class="form-control" id="kpk2" name="kpk2" style="height:30px">
					  <option value="1">Registrasi</option>
					  <option value="2">Akomodasi</option>
					  <option value="3">Transportasi</option>
					  <option value="4" selected>Honor</option>
					  <option value="5">Nominal (Institusi)</option>
					  <option value="6">None</option>
					</select>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;">
                    &nbsp;Association / Organisation Fee&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="planb3" name="planb3" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $planb3; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="actualb3" name="actualb3" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actualb3; ?>"/>
                    </div>
                </div>
				<div class="col-xs-1" style="width:200px">
				  <div class="form-group">
					<select class="form-control" id="kpk3" name="kpk3" style="height:30px">
					  <option value="1">Registrasi</option>
					  <option value="2">Akomodasi</option>
					  <option value="3">Transportasi</option>
					  <option value="4" selected>Honor</option>
					  <option value="5">Nominal (Institusi)</option>
					  <option value="6">None</option>
					</select>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;">
                    &nbsp;Speaker 1 Fee&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="planb4" name="planb4" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $planb4; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="actualb4" name="actualb4" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actualb4; ?>"/>
                    </div>
                </div>
				<div class="col-xs-1" style="width:200px">
				  <div class="form-group">
					<select class="form-control" id="kpk4" name="kpk4" style="height:30px">
					  <option value="1">Registrasi</option>
					  <option value="2">Akomodasi</option>
					  <option value="3">Transportasi</option>
					  <option value="4" selected>Honor</option>
					  <option value="5">Nominal (Institusi)</option>
					  <option value="6">None</option>
					</select>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;">
                    &nbsp;Speaker 2 Fee&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="planb5" name="planb5" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $planb5; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="actualb5" name="actualb5" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actualb5; ?>"/>
                    </div>
                </div>
				<div class="col-xs-1" style="width:200px">
				  <div class="form-group">
					<select class="form-control" id="kpk5" name="kpk5" style="height:30px">
					  <option value="1">Registrasi</option>
					  <option value="2">Akomodasi</option>
					  <option value="3">Transportasi</option>
					  <option value="4" selected>Honor</option>
					  <option value="5">Nominal (Institusi)</option>
					  <option value="6">None</option>
					</select>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;">
                    &nbsp;Moderator Fee&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="planb6" name="planb6" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $planb6; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="actualb6" name="actualb6" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actualb6; ?>"/>
                    </div>
                </div>
				<div class="col-xs-1" style="width:200px">
				  <div class="form-group">
					<select class="form-control" id="kpk6" name="kpk6" style="height:30px">
					  <option value="1">Registrasi</option>
					  <option value="2">Akomodasi</option>
					  <option value="3">Transportasi</option>
					  <option value="4" selected>Honor</option>
					  <option value="5">Nominal (Institusi)</option>
					  <option value="6">None</option>
					</select>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;">
                    &nbsp;Flight Ticket Speaker / Moderator (if any)&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="planb7" name="planb7" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $planb7; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="actualb7" name="actualb7" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actualb7; ?>"/>
                    </div>
                </div>
				<div class="col-xs-1" style="width:200px">
				  <div class="form-group">
					<select class="form-control" id="kpk7" name="kpk7" style="height:30px">
					  <option value="1">Registrasi</option>
					  <option value="2">Akomodasi</option>
					  <option value="3">Transportasi</option>
					  <option value="4" selected>Honor</option>
					  <option value="5">Nominal (Institusi)</option>
					  <option value="6">None</option>
					</select>
				  </div>
				</div>
            </div>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;">
                    &nbsp;Accommodation Speaker / Moderator (if any)&nbsp;
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="planb8" name="planb8" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $planb8; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="actualb8" name="actualb8" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $actualb8; ?>"/>
                    </div>
                </div>
				<div class="col-xs-1" style="width:200px">
				  <div class="form-group">
					<select class="form-control" id="kpk8" name="kpk8" style="height:30px">
					  <option value="1">Registrasi</option>
					  <option value="2">Akomodasi</option>
					  <option value="3">Transportasi</option>
					  <option value="4" selected>Honor</option>
					  <option value="5">Nominal (Institusi)</option>
					  <option value="6">None</option>
					</select>
				  </div>
				</div>
            </div>
        <div class="field_wrapper">
        <?php
          if($budget==8)
          { 
              $sponsor_text = "sponsor9";
              $planb_text = "planb9";            
              $actualb_text = "actualb9";            
			  $val = $kpk9;
            ?>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;text-align:center">
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:280px;height:30px"
            />
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="planb9" name="planb[]" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $$planb_text; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="actual9" name="actualb[]" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $$actualb_text; ?>"/>
                    </div>
                </div>
				<div class="col-xs-1" style="width:200px">
				  <div class="form-group">
					<select class="form-control" id="kpk9" name="kpk[]" style="height:30px">
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
		  
          if($budget>8)
          {
            for($i=8;$i<$budget;$i++)
            {
              $sponsor_text = "sponsor".($i+1);
              $planb_text = "planb".($i+1);
              $actualb_text = "actualb".($i+1);
              $kpk_text = "kpk".($i+1);
			  $val = $$kpk_text;
          ?>
            <div class="row" style="height:30px;">
                <div class="col-xs-1" style="border-left:1px solid black;width:280px;text-align:center">
            <input
              id="type_sponsor"
              name="type_sponsor[]"
              class="form-control"
              type="text"
              value="<?php echo $$sponsor_text; ?>"
              style="width:280px;height:30px"
            />
                </div>
                <div class="col-xs-1" style="width:100px">
                    <div class="form-group">
                        <input id="<?php echo $planb_text; ?>" name="planb[]" class="form-control" type="text"
                            style="width:100px;height:30px;"  value="<?php echo $$planb_text; ?>"/>
                    </div>
                </div>
                <div class="col-xs-1" style="border-right:1px solid black;width:100px;height:30px;">
                    <div class="form-group">
                        <input id="<?php echo $actualb_text; ?>" name="actualb[]" class="form-control" type="text"
                            style="width:100px;height:30px;" value="<?php echo $$actualb_text; ?>"/>
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
                //if($i==6)
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
                    style="border-left:1px solid black;width:280px;border-top:1px solid black;text-align:center;border-bottom:1px solid black;">
                    &nbsp;<b>Sub Total Cost</b>&nbsp;
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;width:100px;border-top:1px solid black;border-bottom:1px solid black;text-align:center"  id="total3">
                    &nbsp;
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;width:100px;border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;text-align:center"  id="total4">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1"
                    style="border-left:1px solid black;width:560px;border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;">
                    &nbsp;<i>*If more than 20% increase, explain in below:</i>&nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:560px">
                    <div class="form-group">
                        <textarea rows="3" class="form-control" id="reason" name="reason"
                            style="width:560px;"><?php echo $reason; ?></textarea>
                    </div>
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
        <div class="col-xs-1" style="width:250px">
          <div class="form-group">
            <select class="form-control" id="file_type" style="height:30px">
              <option value="1">Q & A (Optional)</option>
              <option value="2">Photo (Mandatory)</option>
              <option value="3">Attendance List (Mandatory)</option>
              <option value="4">Speaker Agreement (if any)</option>
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
            style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;"
          >
            <b>&nbsp;Type&nbsp;</b>
          </div>
        </div>
        <div id="attachment">
        </div>
        <?php  } ?>
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
			  <div class="col-xs-1" style="width:860px;"><?php if($state=="6")	{ echo "Document has been fully approved"; } ?></div>
			</div>
			<div class="row">
			  <div class="col-xs-1" style="width:860px;">&nbsp;</div>
			</div>
			<div class="row">
			  <div class="col-xs-1" style="width:860px;"><i style='color:red'>* Note is mandatory to be filled if Reviewer / Approver want to Reject / Review this document</i></div>
			</div>
        <div class="row">
          <div class="col-xs-1" style="width:860px"><hr/></div>
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
        <?php if(isset($_GET['access'])) { ?>        
        <input type="hidden" id="id_group" value="<?php echo $_GET['access']; ?>">
        <?php } else { ?>
        <input type="hidden" id="id_group" value="<?php echo $this->session->userdata('id_group'); ?>">
        <?php } ?>
        <input type="hidden" id="id_mer" name="id_mer" value="<?php echo $_GET['id_mer']; ?>">
        <input type="hidden" id="id_sc" name="id_sc" value="<?php echo $_GET['id_sc']; ?>">
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
    $("#kpk4").val(<?php echo $kpk4; ?>);
    $("#kpk5").val(<?php echo $kpk5; ?>);
    $("#kpk6").val(<?php echo $kpk6; ?>);
    $("#kpk7").val(<?php echo $kpk7; ?>);
    $("#kpk8").val(<?php echo $kpk8; ?>);

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

	$('input[name^="plana[]"]').css("text-align","right");
    $('[id^=plana]').css("text-align","right");
	$('input[name^="planb[]"]').css("text-align","right");
    $('[id^=planb]').css("text-align","right");
	$('input[name^="actuala[]"]').css("text-align","right");
    $('[id^=actuala]').css("text-align","right");
	$('input[name^="actualb[]"]').css("text-align","right");
    $('[id^=actualb]').css("text-align","right");
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
            url: "<?php echo base_url(); ?>index.php/ScientificReport/updateState?id_sc="+<?php echo $_GET['id_sc']; ?>+"&id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
              type: "GET",
              dataType: "text",
              success: function(response){
            },
            error: function(response)
            {
				alert(response);
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
				url: "<?php echo base_url(); ?>index.php/ScientificReport/updateState5?id_sc="+<?php echo $_GET['id_sc']; ?>+"&id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
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
            url: "<?php echo base_url(); ?>index.php/ScientificReport/updateState2?id="+id_sc,
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
          url: "<?php echo base_url(); ?>index.php/ScientificReport/updateState?id_sc="+<?php echo $_GET['id_sc']; ?>+"&id_mer="+<?php echo $_GET['id_mer']; ?>+"&id_group="+<?php echo $_GET['access']; ?>+"&id="+id_sc,
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
				url: "<?php echo base_url(); ?>index.php/ScientificReport/updateState4?active="+active+"&id="+id_sc,
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
            url: "<?php echo base_url(); ?>index.php/ScientificReport/updateState3?id="+id_sc,
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
        $("#topic").css('border','1px solid #cdcdcd');
        $("#product").css('border','1px solid #cdcdcd');
        $("#event_venue").css('border','1px solid #cdcdcd');
        $("#event_start_date").css('border','1px solid #cdcdcd');
        $("#event_end_date").css('border','1px solid #cdcdcd');
        $("#hcp").css('border','1px solid #cdcdcd');
        $("#file_type").css('border','1px solid #cdcdcd');
        $("[id^=time]").css('border','1px solid #cdcdcd');
        $("[id^=location]").css('border','1px solid #cdcdcd');
        $("[id^=plan]").css('border','1px solid #cdcdcd');
        $("[id^=actual]").css('border','1px solid #cdcdcd');
        <?php
          if(isset($_GET['id']))
          {
        ?>
        if($("#list_attachment").val()!="5")
        {
            $("#file_type").css('border','1px solid #ff0000');
            error = "2";
        }
        <?php } ?>
        if($("#topic").val().trim()=="")
        {
          $("#topic").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Topic";
          error = "1";
        }
        /*if($("#hcp").val().trim()=="")
        {
          $("#hcp").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Employee Number";
          error = "1";
        }*/
        if($("#product").val().trim()=="")
        {
          $("#product").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Product Name";
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
        if($("#location1").val()=="" && $("#location2").val()=="" && $("#location3").val()=="" && $("#location4").val()=="")          
        {
          $("[id^=location]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Location";
          error = "1";
        }
        if($("#time1").val()=="" && $("#time2").val()=="" && $("#time3").val()=="" && $("#time4").val()=="" && $("#time5").val()=="")          
        {
          $("[id^=time]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Time";
          error = "1";
        }
        /*if($("#plana1").val()=="0" && $("#plana2").val()=="0" && $("#plana3").val()=="0" && $("#plana4").val()=="0")          
        {
          $("[id^=plana]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Plan";
          error = "1";
        }
        if($("#planb1").val()=="0" && $("#planb2").val()=="0" && $("#planb3").val()=="0" && $("#planb4").val()=="0")          
        {
          $("[id^=planb]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Plan (Food & Drink)";
          error = "1";
        }
        if($("#actuala1").val()=="0" && $("#actuala2").val()=="0" && $("#actuala3").val()=="0" && $("#actuala4").val()=="0")          
        {
          $("[id^=actuala]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Actual";
          error = "1";
        }
        if($("#actualb1").val()=="0" && $("#actualb2").val()=="0" && $("#actualb3").val()=="0" && $("#actualb4").val()=="0")          
        {
          $("[id^=actualb]").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Actual (Food & Drink)";
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

	function printPage()
	{
		window.print();
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
        url: "<?php echo base_url(); ?>index.php/ScientificReport/deleteAttachment?id="+id,
          type: "GET",
          dataType: "text",
          success: function(response){
            $.ajax({
              url: "<?php echo base_url(); ?>index.php/ScientificReport/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#attachment').html(response);

					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/ScientificReport/getListAttachment?id="+id_sc,
						type: "GET",
						dataType: "text",
					  success: function(response){
						  $('#list_attachment').val(response);
						  if(response=="5")
						  {	  
							$("#save").attr("style", "visibility:show");
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
//      $("#total1").text(parseInt($("#planb1").val().split('.').join(''),0)+parseInt($("#planb2").val().split('.').join(''),0)+parseInt($("#planb3").val().split('.').join(''),0)+parseInt($("#planb4").val().split('.').join(''),0));
//      $("#total2").text(parseInt($("#actualb1").val().split('.').join(''),0)+parseInt($("#actualb2").val().split('.').join(''),0)+parseInt($("#actualb3").val().split('.').join(''),0)+parseInt($("#actualb4").val().split('.').join(''),0));


      var planb = 0;
      $('input[name^="planb[]"]').each(function() {
        planb = planb + parseInt($(this).val().split('.').join(''),0);
      });
      var actualb = 0;
      $('input[name^="actualb[]"]').each(function() {
        actualb = actualb + parseInt($(this).val().split('.').join(''),0);
      });

      $("#total3").text(parseInt($("#planb1").val().split('.').join(''),0)+parseInt($("#planb2").val().split('.').join(''),0)+parseInt($("#planb3").val().split('.').join(''),0)+parseInt($("#planb4").val().split('.').join(''),0)+parseInt($("#planb5").val().split('.').join(''),0)+parseInt(planb,0));
      $("#total4").text(parseInt($("#actualb1").val().split('.').join(''),0)+parseInt($("#actualb2").val().split('.').join(''),0)+parseInt($("#actualb3").val().split('.').join(''),0)+parseInt($("#actualb4").val().split('.').join(''),0)+parseInt($("#actualb5").val().split('.').join(''),0)+parseInt(actualb,0));

	  $("#total3").text(numeral($("#total3").text()).format('0,0'));
	  $("#total4").text(numeral($("#total4").text()).format('0,0'));

//      $("#total3").text(parseInt(planb,0));
//      $("#total4").text(parseInt(actualb,0));

/*      $("#total5").text(parseInt($("#total1").text(),0)+parseInt($("#total3").text(),0));
      $("#total6").text(parseInt($("#total2").text(),0)+parseInt($("#total4").text(),0));
	  $("#total1").text(numeral($("#total1").text()).format('0,0'));
	  $("#total2").text(numeral($("#total2").text()).format('0,0'));
	  $("#total3").text(numeral($("#total3").text()).format('0,0'));
	  $("#total4").text(numeral($("#total4").text()).format('0,0'));
	  $("#total5").text(numeral($("#total5").text()).format('0,0'));
	  $("#total6").text(numeral($("#total6").text()).format('0,0'));*/
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

      $("[id^=planb]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });      
      $("[id^=actualb]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });      

      $("[id^=plana]").change(function() {
        if($(this).val()=="")
        {
          $(this).val("0");
        }
		var x = numeral($(this).val()).value();
		$(this).val(numeral(x).format('0,0'));
        calculate();
      });      
      $("[id^=actuala]").change(function() {
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

       $("[id^=plana1]").prop("readonly",true);
       $("[id^=plana2]").prop("readonly",true);
       $("[id^=plana3]").prop("readonly",true);
       $("[id^=planb]").prop("readonly",true);
      if($("#id_group").val()<=6 || ($("#id_group").val()>=7 && $("#state").val()>1))
      {
        $("#hcp").prop("readonly",true);
        $("#topic").prop("readonly",true);
        $("#product").prop("readonly",true);
        $("#reason").prop("readonly",true);
        $("[id^=actual]").prop("readonly",true);
        $("[id^=plan]").prop("readonly",true);
        $("[id^=event]").prop("readonly",true);
        $("[id^=time]").prop("readonly",true);
        $("[id^=location]").prop("readonly",true);
        $("[id^=upload]").prop("disabled",true);
        $(".add_button").attr("style", "visibility: hidden");
        $(".remove_button").attr("style", "visibility: hidden");
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
    <?php } } else { ?>
        id_sc = "";
        id_user = <?php echo $this->session->userdata('id_user'); ?>;
        x = 1;
      <?php  } ?>

            $.ajax({
              url: "<?php echo base_url(); ?>index.php/ScientificReport/getListAttachment?id="+id_sc,
                type: "GET",
                dataType: "text",
              success: function(response){
                  $('#list_attachment').val(response);

				  if($("#id_group").val()<=6 || ($("#id_group").val()>=7 && $("#state").val()>1))
				  {
				  }
				  else
				  {	  
						  if(response=="5")
						  {	  
							$("#save").attr("style", "visibility:show");
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

      $.ajax({
        url: "<?php echo base_url(); ?>index.php/ScientificReport/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
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

      var maxField = 10;
      var addButton = $('.add_button');
      var wrapper = $('.field_wrapper');
      var fieldHTML = '<div class="row" style="height:30px"><div class="col-xs-1" style="width:360px;border-left:1px solid black;border-bottom:1px solid black;">';
      var actualb_text = "actualb"+(x+8);
      var planb_text = "planb"+(x+8);
      fieldHTML = fieldHTML + '<input name="type_sponsor[]" id="type_sponsor" class="form-control" type="text" style="width:360px;border-right:1px solid black;border-top:1px solid black;height:30px"/>';
      fieldHTML = fieldHTML + '</div>';
      fieldHTML = fieldHTML + '<div class="col-xs-1" style="width:100px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="planb[]" id="'+planb_text+'" class="form-control" type="text" style="width:100px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';    
      fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:100px;border-left:1px solid black;border-bottom:1px solid black;">';
      fieldHTML = fieldHTML + '<input name="actualb[]" id="'+actualb_text+'" class="form-control" type="text" style="width:100px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';    
      fieldHTML = fieldHTML + '</div>';
      fieldHTML = fieldHTML + '<div class="col-xs-1" style="border-left:1px solid black;width:25px">';    
      fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>'; 


      $('#hcp').keypress(validateNumber);
      $('[id^=plan]').keypress(validateNumber);
      $('[id^=actual]').keypress(validateNumber);
      $('#requested_by1').val('<?php echo $requested_by; ?>');

      //Once add button is clicked

      $(addButton).click(function()
      {
          //Check maximum number of input fields
          var planbArray = new Array();
          $('input[name^="planb[]"]').each(function() {
            planbArray.push($(this).val().split('.').join(''));
          });

          var sponsorArray = new Array();
          $('input[name^="type_sponsor[]"]').each(function() {
            sponsorArray.push($(this).val());
          });

          var actualbArray = new Array();
          $('input[name^="actualb[]"]').each(function() {
            actualbArray.push($(this).val().split('.').join(''));
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
          $(addButton).css('visibility','visible');
          calculate();
      });

      $('#upload').bind('click', function(){
          var data = new FormData;
          data.append('file', document.getElementById('file_name').files[0]);
          data.append('file_type', $('#file_type').val());
          data.append('id_parent', id_sc);


          $.ajax({
              url : "<?php echo base_url(); ?>index.php/ScientificReport/upload",
              type : 'POST',
              data : data,
              contentType: false,
              processData: false,
              success : function(json) {
                $.ajax({
                  url: "<?php echo base_url(); ?>index.php/ScientificReport/getAttachment?id="+id_sc+"&state="+<?php echo $state; ?>,
                    type: "GET",
                    dataType: "text",
                    success: function(response){
                      $('#attachment').html(response);

					$.ajax({
					  url: "<?php echo base_url(); ?>index.php/ScientificReport/getListAttachment?id="+id_sc,
						type: "GET",
						dataType: "text",
					  success: function(response){
						  $('#list_attachment').val(response);
						  if(response=="5")
						  {	  
							$("#save").attr("style", "visibility:show");
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
		  if ( key < 48 || key > 57 ) {
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
