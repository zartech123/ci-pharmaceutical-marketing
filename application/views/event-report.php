<head>
    <meta name="viewport" content="width=1024">
    <title>EVENT REPORT OTC REQUEST FORM</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@3.1.0/bootstrap-4.min.css" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <link href="<?php echo base_url(); ?>assets/css/jquery.multiselect.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>assets/js/jquery.multiselect.js"></script>
    <link href="<?php echo base_url(); ?>assets/css/jquery-ui.multidatespicker.css" rel="stylesheet" />
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui.multidatespicker.js"></script>


<body style="font-size:13px">
    <div class="container-fluid"
        style="border:1px solid black;padding-left:22px;padding-right:8px;padding-bottom:8px;padding-top:8px;width:917px">
        <?php
$readonly = "";
$readonly_note1 = "readonly";
if (isset($_GET['access'])) {
    if ($_GET['access'] == 19 && $state == 2) {
        $readonly_note1 = "";
    }
} else {
    $_GET['access'] = $this->session->userdata('id_group');
    if ($this->session->userdata('id_group') == 19 && $state == 2) {
        $readonly_note1 = "";
    }
}
	$amount = 0;

if (isset($_GET['id'])) {
    $readonly = "readonly";

	$query = $this->db->query("SELECT sum(replace(actual,'.','')) AS amount FROM budget_event_report where id_parent=".$_GET['id']);
	foreach ($query->result() as $row2) {
		$amount = $row2->amount;
	}

	$requested_name = "";
    $query = $this->db->query("SELECT name FROM user where id_user=" . $requested_by);
    foreach ($query->result() as $row2) {
        $requested_name = $row2->name;
    }


}

$qty_actual = 0;
$query = $this->db->query("SELECT sum(cust_cost_actual*qty_actual) AS qty_actual FROM event_sku where id_event=" . $_GET['id_event']);
foreach ($query->result() as $row2) {
    $qty_actual = $row2->qty_actual;
}

$qty_actual2 = 0;
$query = $this->db->query("select sum(price*qty_actual) as qty_actual2 from event_sku a, product b where a.id_product=b.id_product and id_event=" . $_GET['id_event']);
foreach ($query->result() as $row2) 
{
    $qty_actual2 = $row2->qty_actual2;
}

$code = "";
$query = $this->db->query("SELECT c.code FROM event_otc a, product_group c WHERE id_group=".$product." AND id_event=" . $_GET['id_event']);
foreach ($query->result() as $row2) 
{
    $code = $row2->code;
}


?>
        <form action="<?php echo base_url() . 'index.php/EventReport/add'; ?>" method="post">
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:900px">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:900px"><img
                        src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:900px">
                    <b>EVENT REPORT OTC REQUEST FORM</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:right;width:360px">
                    <b>Doc No.&nbsp;&nbsp;</b>
                </div>
                <span
                    style="background:#efefef;"><?php echo substr($created_date, -4); ?>/<?php echo $code; ?>-BTL/<?php echo date("m", strtotime($created_date)); ?>/</span>
                <div class="col-xs-1" style="height:30px;background:#efefef;width:436px">
                    <div class="form-group">
                        <input class="form-control" type="text" id="nodoc2" name="nodoc2" style="width:150px"
                            value="<?php echo $nodoc; ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:900px">
                    <hr />
                </div>
            </div>
            <div class="row" style="height:38px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px"><b>Product</b></div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <select class="form-control" id="product" name="product" style="height:30px">
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px"><b>Event Name</b></div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <textarea readonly rows="2" class="form-control" id="event_name" name="event_name"
                            style="height:60px;width:350px;"><?php echo $event_name; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row" style="height:708px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px"><b>Date</b></div>
                <div class="col-xs-1">
                    &nbsp;:&nbsp;(Month/Date/Year)&nbsp;:&nbsp;<?php echo str_replace('\'', '', $event_date); ?></div>
                <div class="col-xs-1">
                    <div id="event_date"></div>
                </div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Location</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <textarea readonly rows="2" class="form-control" id="location" name="location"
                            style="height:60px;width:350px;"><?php echo $location; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Participant</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="participant_est" name="participant_est" type="text"
                            style="width:70px" maxlength="5" value="<?php echo $participant_est; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Participant (Actual)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="participant_actual" name="participant_actual" type="text"
                            style="width:70px;" maxlength="5" value="<?php echo $participant_actual; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Est. Cost per View</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="view_est" name="view_est" type="text" style="width:70px"
                            maxlength="5"
                            value="<?php if ($participant_est == 0) {echo "0";} else {echo number_format(($booth_est + ($spg * 250000) + $transportation_est + $trophy_est + ($gimmick * 10000)) / $participant_est, 0);}?>"
                            readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Actual Cost per View</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="view_actual" name="view_actual" type="text" style="width:70px"
                            maxlength="5"
                            value="<?php if ($participant_actual==0) {echo "0";} else {echo number_format(($booth_actual + $spg_actual + $transportation_actual + $trophy_actual + ($gimmick_actual * 10000)) / intval(str_replace('.','',$participant_actual)), 0);}?>"
                            readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Biaya Booth</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="booth_est" name="booth_est" type="text" style="width:100px"
                            maxlength="10" value="<?php echo $booth_est; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Biaya Booth (Actual)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="booth_actual" name="booth_actual" type="text" style="width:100px"
                            maxlength="10" value="<?php echo $booth_actual; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Booth (Account Name)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <textarea readonly rows="2" class="form-control" id="booth_name" name="booth_name"
                            style="height:60px;width:350px;"><?php echo $booth_name; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Booth (Bank)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <select class="form-control" id="bank" name="bank" style="height:30px">
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Booth (Account No)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <textarea readonly rows="2" class="form-control" id="booth_account" name="booth_account"
                            style="height:60px;width:350px;"><?php echo $booth_account; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Booth (Phone)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <textarea readonly rows="2" class="form-control" id="booth_phone" name="booth_phone"
                            style="height:60px;width:350px;"><?php echo $booth_phone; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Booth Tgl Transfer</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="booth_date" name="booth_date" type="text" style="width:100px"
                           value="<?php echo $booth_date; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Jumlah Trophy</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="trophy" name="trophy" type="text" style="width:70px"
                            maxlength="5" value="<?php echo $trophy; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Biaya Trophy</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="trophy_est" name="trophy_est" type="text" style="width:100px"
                            maxlength="10" value="<?php echo $trophy_est; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Biaya Trophy (Actual)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="trophy_actual" name="trophy_actual" type="text" style="width:70px"
                            maxlength="10" value="<?php echo $trophy_actual; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Trophy Tgl Transfer</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="trophy_date" name="trophy_date" type="text" style="width:100px"
                           value="<?php echo $trophy_date; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Jumlah SPG</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="spg" name="spg" type="text" style="width:70px" maxlength="5"
                            value="<?php echo $spg; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Biaya SPG</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="spg_est" name="spg_est" type="text" style="width:70px"
                            maxlength="5" value="<?php echo number_format(($spg * 250000), 0); ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Biaya SPG (Actual)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="spg_actual" name="spg_actual" type="text" style="width:70px"
                            maxlength="10" value="<?php echo $spg_actual; ?>"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Biaya Transportation</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="transportation_est" name="transportation_est" type="text"
                            style="width:100px" maxlength="10" value="<?php echo $transportation_est; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Biaya Transportation (Actual)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="transportation_actual" name="transportation_actual" type="text"
                            style="width:100px" maxlength="10" value="<?php echo $transportation_actual; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Transportation Tgl Transfer</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="transportation_date" name="transportation_date" type="text" style="width:100px"
                           value="<?php echo $transportation_date; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Jumlah Gimmick</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="gimmick" name="gimmick" type="text" style="width:70px"
                            maxlength="5" value="<?php echo $gimmick; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Biaya Gimmick</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="gimmick_est" name="gimmick_est" type="text" style="width:70px"
                            maxlength="5" value="<?php echo number_format(($gimmick * 10000), 0); ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Jumlah Gimmick (Actual)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="gimmick_actual" name="gimmick_actual" type="text" style="width:70px"
                            maxlength="5" value="<?php echo $gimmick_actual; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Biaya Gimmick (Actual)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="gimmick_actual2" name="gimmick_actual2" type="text" style="width:70px"
                            maxlength="5" value="<?php echo number_format(($gimmick_actual * 10000), 0); ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Biaya Lain</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="other" name="other" type="text" style="width:70px" maxlength="5"
                            value="<?php echo number_format($amount, 0); ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Total Biaya</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="total_est" name="total_est" type="text" style="width:70px"
                            maxlength="5"
                            value="<?php echo number_format($booth_est + ($spg * 250000) + $transportation_est + $trophy_est + ($gimmick * 10000), 0); ?>"
                            readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Total Biaya (Actual)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="total_actual" name="total_actual" type="text" style="width:70px"
                            maxlength="5"
                            value="<?php echo number_format($booth_actual + $spg_actual + $transportation_actual + $trophy_actual + ($gimmick_actual * 10000), 0); ?>"
                            readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Jumlah Sample</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input readonly class="form-control" id="sample_est" name="sample_est" type="text" style="width:70px"
                            maxlength="5" value="<?php echo $sample_est; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Jumlah Sample (Actual)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="sample_actual" name="sample_actual" type="text" style="width:70px"
                            maxlength="5" value="<?php echo $sample_actual; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Estimasi Penjualan</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="sales_est" name="sales_est" type="text" style="width:100px"
                            maxlength="10" value="<?php echo number_format($sales_est,0); ?>" / readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Cost Ratio</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="cost_ratio" name="cost_ratio" type="text" style="width:50px"
                            maxlength="10"
                            value="<?php if ($sales_est == "0") {echo "0";} else {echo number_format(($booth_est + ($spg * 250000) + $transportation_est + $trophy_est + ($gimmick * 10000)) / $sales_est, 0);}?>"
                            readonly />
                    </div>
                </div>
                <div class="col-xs-1">&nbsp;%&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Actual Harga Jual Konsumen</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="qty_actual" name="qty_actual" type="text" style="width:50px"
                            maxlength="10"
                            value="<?php echo $qty_actual; ?>"
                            readonly />
                    </div>
                </div>
                <div class="col-xs-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>Actual Cost Ratio</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="cost_ratio_actual" name="cost_ratio_actual" type="text" style="width:50px"
                            maxlength="10"
                            value="<?php if ($qty_actual == "0") {echo "0";} else {echo number_format(($booth_actual + $spg_actual + $transportation_actual + $trophy_actual + ($gimmick_actual * 10000)) / $qty_actual, 0);}?>"
                            readonly />
                    </div>
                </div>
                <div class="col-xs-1">&nbsp;%&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px;color:blue">
                    <b>QTY x HNA</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="qty_actual2" name="qty_actual2" type="text" style="width:100px"
                            maxlength="10"
                            value="<?php echo number_format($qty_actual2,0); ?>"
                            readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:150px">
                    <b>Biaya Lainnya:</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;">
                    <b>&nbsp;Description&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;">
                    <b>&nbsp;Estimation (IDR)&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;">
                    <b>&nbsp;Tgl Transfer&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center;border-bottom:1px solid black;">
                    <b>&nbsp;Actual (IDR)&nbsp;</b>
                </div>
            </div>
            <div class="field_wrapper">
                <?php
if ($budget == 0) {
    $description_text = "description1";
    $cost_text = "actual1";
    $est_text = "est1";
    $date_text = "actl_date1";
    ?>
                <div class="row" style="height:30px;">
                    <div class="col-xs-1">
                        <div class="form-group">
                            <input id="description5" name="description[]" class="form-control" type="text"
                                value="<?php echo $$description_text; ?>" style="width:200px;height:30px;" />
                        </div>
                    </div>
                    <div class="col-xs-1" style="width:200px">
                        <div class="form-group">
                            <input id="est1" name="est[]" class="form-control" type="text"
                                value="<?php echo $$est_text; ?>" style="width:200px;height:30px;" maxlength="9" readonly/>
                        </div>
                    </div>
                    <div class="col-xs-1" style="width:200px">
                        <div class="form-group">
                            <input id="actl_date1" name="actl_date[]" class="form-control" type="text"
                                value="<?php echo $$date_text; ?>" style="width:200px;height:30px;" maxlength="10" />
                        </div>
                    </div>
                    <div class="col-xs-1" style="width:200px">
                        <div class="form-group">
                            <input id="actual1" name="actual[]" class="form-control" type="text"
                                value="<?php echo $$cost_text; ?>" style="width:200px;height:30px;" maxlength="9" />
                        </div>
                    </div>
                    <div class="col-xs-1" style="width:25px">
                        <a href="javascript:void(0);" class="add_button"><i class="fa fa-plus fa-2x"
                                aria-hidden="true"></i></a>
                    </div>
                </div>
                <?php
}
if ($budget > 0) {
    for ($i = 0; $i < $budget; $i++) {
        $description_text = "description" . ($i + 1);
        $cost_text = "actual" . ($i + 1);
        $est_text = "est" . ($i + 1);
        $date_text = "actl_date" . ($i + 1);
        ?>
                <div class="row" style="height:30px;">
                    <div class="col-xs-1">
                        <div class="form-group">
                            <input id="<?php echo $description_text; ?>" name="description[]" class="form-control"
                                type="text" value="<?php echo $$description_text; ?>"
                                style="width:200px;height:30px;" />
                        </div>
                    </div>
                    <div class="col-xs-1" style="width:200px">
                        <div class="form-group">
                            <input id="<?php echo $est_text; ?>" name="est[]" class="form-control" type="text"
                                value="<?php echo $$est_text; ?>" style="width:200px;height:30px;" maxlength="9" readonly/>
                        </div>
                    </div>
                    <div class="col-xs-1" style="width:200px">
                        <div class="form-group">
                            <input id="<?php echo $date_text; ?>" name="actl_date[]" class="form-control" type="text"
                                value="<?php echo $$date_text; ?>" style="width:200px;height:30px;" maxlength="10" />
                        </div>
                    </div>
                    <div class="col-xs-1" style="width:200px">
                        <div class="form-group">
                            <input id="<?php echo $cost_text; ?>" name="actual[]" class="form-control" type="text"
                                value="<?php echo $$cost_text; ?>" style="width:200px;height:30px;" maxlength="9" />
                        </div>
                    </div>
                    <div class="col-xs-1" style="width:25px">
                        <?php
if ($i == 0) {
            ?>
                        <a href="javascript:void(0);" class="add_button"><i class="fa fa-plus fa-2x"
                                aria-hidden="true"></i></a>
                        <?php } else {?>
                        <a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x"
                                aria-hidden="true"></i></a>
                        <?php }?>
                    </div>
                </div>
                <?php
}
}
?>
            </div>
            <div class="row">
                <div class="col-xs-1"
                    style="border-left:1px solid black;width:200px;border-top:1px solid black;text-align:center;border-bottom:1px solid black;">
                    &nbsp;<b>TOTAL ESTIMATED BUDGET</b>&nbsp;
                </div>
                <div class="col-xs-1" id="total1"
                    style="border-left:1px solid black;width:200px;border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;text-align:center">
                    &nbsp;
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;width:200px;border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;text-align:center">
                    &nbsp;
                </div>
                <div class="col-xs-1" id="total"
                    style="border-left:1px solid black;width:200px;border-right:1px solid black;border-top:1px solid black;border-bottom:1px solid black;text-align:center">
                    &nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1">&nbsp;</div>
            </div>
            <?php if (isset($_GET['id']) == true) {?>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:150px">
                    <b>Attachment :</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:290px">
                    <div class="form-group">
                        <select class="form-control" id="file_type" style="height:30px">
                            <option value="1">Kuitansi Booth / Sewa Tempat</option>
                            <option value="2">Kuitansi Trophy</option>
                            <option value="3">Kuitansi Transportation</option>
                            <option value="5">Kuitansi Biaya Lain</option>
                            <option value="6">Faktur</option>
                            <option value="7">Photo Event (Mandatory)</option>
                            <option value="8">Bukti Transfer Booth / Sewa Tempat</option>
                            <option value="9">Bukti Transfer SPG</option>
                            <option value="10">Bukti Transfer PIC RBW</option>
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
                        <button type="button" id="upload" class="btn btn-primary btn-sm"><i class="fa fa-upload"
                                aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Upload</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:240px;text-align:center;border-bottom:1px solid black;">
                    <b>&nbsp;File Name&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:160px;text-align:center;border-bottom:1px solid black;border-right:1px solid black;">
                    <b>&nbsp;Type&nbsp;</b>
                </div>
            </div>
            <div id="attachment">
            </div>
            <?php }?>
            <div class="row">
                <div class="col-xs-1" style="width:200px">&nbsp;</div>
                <div class="col-xs-1" style="width:200px">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1">
                    <iframe id="framesku" width="900" height="564"
                        src="<?php echo base_url(); ?>index.php/EventSKU/index/id/<?php echo $_GET['id_event']; ?>/state/<?php echo $state; ?>/type/2"></iframe>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1">
                    <iframe id="framepic" width="900" height="564"
                        src="<?php echo base_url(); ?>index.php/EventPIC/index/id/<?php echo $_GET['id_event']; ?>/state/<?php echo $state; ?>/type/2"></iframe>
                </div>
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
            <?php
?>

            <div class="row">
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center">
                    <b>&nbsp;Prepared By&nbsp;</b>
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center">
                    <b>&nbsp;Approval&nbsp;</b>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;width:200px;text-align:center">
                    <br />Prepared
                    by<br /><?php if ($approver0 != "") {echo $approver0;} else {echo $requested_name;}?><br />(<?php echo $created_date; ?>)<br /><br /><?php if ($title0 != "") {echo $title0;} else {echo $GLOBALS['agency-grp'];}?><br />&nbsp;
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center">
                    &nbsp;<br />Approved
                    by<br /><span id="otc_name"><?php if ($state > 2) {echo $approver1;} else {echo $GLOBALS['otc'];}?></span><br />(<?php if ($state > 2) {echo $updated_date1;}?>)<br /><br /><?php if ($state > 2) {echo $title1;} else {echo $GLOBALS['otc-grp'];}?><br />&nbsp;
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1"
                    style="width:200px;text-align:center;border-left:1px solid black;border-bottom:1px solid black;height:90px;">
                </div>
                <div class="col-xs-1" style="width:200px">
                    <div class="form-group">
                        <textarea rows="3" class="form-control" id="note1" name="note1" <?php echo $readonly_note1; ?>
                            style="height:90px;width:200px;border:1px solid black;"><?php echo $note1; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:900px;">
                    <?php if ($state == "6") {echo "Document has been fully approved";}?></div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:900px;">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:800px;"><i style='color:red'>* Note is mandatory to be filled if
                        Reviewer / Approver want to Reject / Review this document</i></div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:800px;">
                    <hr />
                </div>
            </div>
            <button type="submit" id="save" class="btn btn-primary btn-sm" style="visibility:hidden"><i
                    class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Save</button>
            <button type="submit" id="request_approval" class="btn btn-success btn-sm" style="visibility:hidden"><i
                    class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Request Approval</button>
            <button type="submit" id="review" class="btn btn-warning btn-sm" style="visibility:hidden"><i
                    class="fa fa-undo" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Review</button>
            <button type="submit" id="approve" class="btn btn-success btn-sm" style="visibility:hidden"><i
                    class="fa fa-check" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Approve</button>
            <button type="submit" id="reject" class="btn btn-danger btn-sm" style="visibility:hidden"><i
                    class="fa fa-ban" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Reject</button>
            <button type="submit" id="freeze" class="btn btn-primary btn-sm" style="visibility:hidden"><i
                    class="fa fa-pause" aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Freeze</button>
            <button type="button" id="print" style="visibility:hidden" class="btn btn-primary btn-sm"
                onclick="printPage();"><i class="fa fa-print"
                    aria-hidden="true"></i>&nbsp;&nbsp;|&nbsp;&nbsp;Print</button>
			<input type="hidden" id="list_attachment" value="">
            <input type="hidden" id="sku" value="">
            <input type="hidden" id="state" value="<?php echo $state; ?>">
			<?php if ($approver0 != "")
			{?>
            <input type="hidden" id="requested_by" name="requested_by"
                value="<?php echo $requested_by; ?>">
			<?} else {?>
            <input type="hidden" id="requested_by" name="requested_by"
                value="<?php echo $this->session->userdata('id_user'); ?>">
			<?}?>
            <input type="hidden" id="event_date2" name="event_date2" value="<?php echo $event_date; ?>">
            <?php if (isset($_GET['access'])) {?>
            <input type="hidden" id="id_group" value="<?php echo $_GET['access']; ?>">
            <?php } else {?>
            <input type="hidden" id="id_group" value="<?php echo $this->session->userdata('id_group'); ?>">
            <?php }?>
            <?php if (isset($_GET['id'])) {?>
            <input type="hidden" id="id_parent" name="id_parent" value="<?php echo $_GET['id']; ?>">
            <?php } ?>
            <?php if (isset($_GET['id_event'])) {?>
            <input type="hidden" id="id_event" name="id_event" value="<?php echo $_GET['id_event']; ?>">
            <?php }
?>
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
var today = new Date();
var y = today.getFullYear();
var global_error = 0;
/*if ($("#state").val() == 1) {
    $('#event_date').multiDatesPicker({
        numberOfMonths: [3, 4],
        minDate: 0,
        <?php
if ($event_date != "") {
    ?>
        addDates: [<?php echo $event_date; ?>],

        <?php
}
?>
        onSelect: function(dateText) {
            var selecteddate = this.value;
            var pieces = selecteddate.split(", ");
            var resultingString = pieces.join("','");
            $("#event_date2").val("'" + resultingString + "'");
        }
    });
}*/

if ($("#state").val() != 6) {
    document.addEventListener('contextmenu', event => {
        event.preventDefault()
    });
    document.body.addEventListener('keydown', event => {
        if (event.ctrlKey && 'p'.indexOf(event.key) !== -1) {
            event.preventDefault()
        }
    });
}
if(($("#id_group").val()==20 || $("#id_group").val()==19))
{
    $("#print").attr("style", "visibility:show");
}

		$.ajax({
			url: "<?php echo base_url(); ?>index.php/Event/getPM?id=" + <?php echo $product; ?>,
			type: "GET",
			dataType: "text",
			success: function(response) {
				$("#otc_name").text(response);
			},
			error: function(response) {},
		});


function printPage() {
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
    ordinal: function(number) {
        return number === 1 ? 'er' : 'ème';
    },
    currency: {
        symbol: '€'
    }
});

$('input[name^="actual[]"]').css("text-align", "right");
$('[id^=actual]').css("text-align", "right");

$('input[name^="est[]"]').css("text-align", "right");
$('[id^=est]').css("text-align", "right");


if ($("#id_group").val() == 20 && $("#state").val() == 1 && $("#id_parent").val() != null) {
	
    <?php
if (isset($_GET['id_event'])) {
    ?>
    var id_sc2 = <?php echo $_GET['id_event']; ?>;
    <?php } else {?>
    id_sc2 = "";
    <?php }

if (isset($_GET['id'])) {
    ?>
    var id_sc = <?php echo $_GET['id']; ?>;
    <?php } else {?>
    id_sc = "";
    <?php }?>

    $.ajax({
        url: "<?php echo base_url(); ?>index.php/EventReport/getSKU?id=" + id_sc2,
        type: "GET",
        dataType: "text",
        success: function(response) {
            $('#sales_actual').val(numeral(response).format('0,0'));
            calculate();
        },
        error: function(response) {},
    });

    var request_approval = document.getElementById('request_approval');
	if($("#requested_by").val()== 119)
	{
		$("#request_approval").attr("style", "visibility:show");
	}	

    request_approval.onclick = function() {
        $("#save").click();
        if (error == 0) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/EventReport/updateState?id_group=" +
                    <?php echo $_GET['access']; ?> + "&id=" + id_sc,
                type: "GET",
                dataType: "text",
                success: function(response) {},
                error: function(response) {},
            });
        }
    }
}

//	alert(<?php echo $this->session->userdata('id_user'); ?>);

$.ajax({
    url: "<?php echo base_url(); ?>index.php/HCO/getBank",
    type: "GET",
    dataType: "text",
    success: function(response) {
        var json = $.parseJSON(response);
        for (var i = 0; i < json.length; ++i) {
            $('#bank').append('<option value="' + json[i].id + '">' + json[i].name + '</option>');
        }
        <?php
if (isset($_GET['id'])) {
    ?>
        $("#bank").val('<?php echo $bank; ?>');
        <?php
}
?>
    },
    error: function(response) {},
});



$.ajax({
    url: "<?php echo base_url(); ?>index.php/EventReport/getProduct?id="+<?php echo $product; ?>,
    type: "GET",
    dataType: "text",
    success: function(response) {
        var json = $.parseJSON(response);
        for (var i = 0; i < json.length; ++i) {
            $('[id^=product]').append('<option value="' + json[i].id + '">' + json[i].name + '</option>');
        }

    },
    error: function(response) {},
});


if (($("#id_group").val() == 19 && $("#state").val() == 2)) {
    var review = document.getElementById('review');
    var approve = document.getElementById('approve');
    var reject = document.getElementById('reject');
    $("#note1").css('border', '1px solid #cdcdcd');

    <?php if ($active == 0) {
    ?>
    $("#freeze").text("Activate");
    $("#freeze").attr("style", "visibility:show");
    $("#review").attr("style", "visibility:hidden");
    $("#approve").attr("style", "visibility:hidden");
    $("#reject").attr("style", "visibility:hidden");
    <?php
} else {
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
if (isset($_GET['id_event'])) {
    ?>
    var id_sc2 = <?php echo $_GET['id_event']; ?>;
    <?php } else {?>
    id_sc2 = "";
    <?php }


if (isset($_GET['id'])) {
    ?>
    var id_sc = <?php echo $_GET['id']; ?>;
    <?php } else {?>
    id_sc = "";
    <?php }?>



    review.onclick = function() {
        if (($("#id_group").val() == 19 && $("#note1").val() != "")) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/EventReport/updateState2?id=" + id_sc,
                type: "GET",
                dataType: "text",
                success: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: 'This request has been returned to Requestor',
                        showConfirmButton: true,
                        confirmButtonText: 'Close'
                    });
                },
                error: function(response) {},
            });
        } else {
            if ($("#id_group").val() == 19) {
                $("#note1").css('border', '1px solid #ff0000');
            }
            return false;
        }
    }

    approve.onclick = function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/EventReport/updateState?id_group=" +
                <?php echo $_GET['access']; ?> + "&id=" + id_sc,
            type: "GET",
            dataType: "text",
            success: function(response) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'This Request has been Approved',
                    showConfirmButton: true,
                    confirmButtonText: 'Close'
                });
            },
            error: function(response) {},
        });
    }

    freeze.onclick = function() {
        var active = 1;
        <?php if ($active == 0) {
    ?>
        active = 1;
        <?php
} else {
    ?>
        active = 0;
        <?php
}
?>
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/EventReport/updateState4?active=" + active + "&id=" + id_sc,
            type: "GET",
            dataType: "text",
            success: function(response) {
                if (active == 0) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'info',
                        title: 'This Request has been Locked',
                        showConfirmButton: true,
                        confirmButtonText: 'Close'
                    });
                } else if (active == 1) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'info',
                        title: 'This Request has been UnLocked',
                        showConfirmButton: true,
                        confirmButtonText: 'Close'
                    });
                }
            },
            error: function(response) {},
        });
    }


    reject.onclick = function() {
        if (($("#id_group").val() == 19 && $("#note1").val() != "")) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/EventReport/updateState3?id=" + id_sc,
                type: "GET",
                dataType: "text",
                success: function(response) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'This Request has been Rejected',
                        showConfirmButton: true,
                        confirmButtonText: 'Close'
                    });
                },
                error: function(response) {},
            });
        } else {
            if ($("#id_group").val() == 19) {
                $("#note1").css('border', '1px solid #ff0000');
            }
            return false;
        }
    }

}

if ($("#id_group").val() == 20 && $("#state").val() == 1) {
    var save = document.getElementById('save');
    $("#save").attr("style", "visibility:show");

    save.onclick = function() {
        error = "0";
        error_text = "";
		error2 = "0";
        $("[id=booth_date]").css('border','1px solid #cdcdcd');
        $("[id=trophy_date]").css('border','1px solid #cdcdcd');
        $("[id=transportation_date]").css('border','1px solid #cdcdcd');
        if($("#booth_date").val().trim()=="" && $("#booth_actual").val().trim()!="0")
        {
          $("#booth_date").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Booth Date";
          error = "1";
        }
        if($("#trophy_date").val().trim()=="" && $("#trophy_actual").val().trim()!="0")
        {
          $("#trophy_date").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Trophy Date";
          error = "1";
        }
        if($("#transportation_date").val().trim()=="" && $("#transportation_actual").val().trim()!="0")
        {
          $("#transportation_date").css('border','1px solid #ff0000');
		  error_text = error_text+"<br>Please fill the Transportation Date";
          error = "1";
        }
        <?php
          if(isset($_GET['id']))
          {
        ?>
		if($("#list_attachment").val().indexOf("7")==-1)
		{
            $("#file_type").css('border','1px solid #ff0000');
			error_text = error_text+"<br>Please Submit Photo Event";
            error = "2";
		}
        if($("#list_attachment").val().indexOf("1")==-1 && $("#booth_actual").val().trim()!="0")
        {
            $("#file_type").css('border','1px solid #ff0000');
			error_text = error_text+"<br>Please Submit Kuitansi Booth / Sewa Tempat";
            error = "2";
        }
        if($("#list_attachment").val().indexOf("8")==-1 && $("#booth_actual").val().trim()!="0")
        {
            $("#file_type").css('border','1px solid #ff0000');
			error_text = error_text+"<br>Please Submit Bukti Transfer Booth / Sewa Tempat";
            error = "2";
        }
        if($("#list_attachment").val().indexOf("9")==-1 && $("#spg_actual").val().trim()!="0")
        {
            $("#file_type").css('border','1px solid #ff0000');
			error_text = error_text+"<br>Please Submit Bukti Transfer SPG";
            error = "2";
        }
        if($("#list_attachment").val().indexOf("2")==-1 && $("#trophy_actual").val().trim()!="0")
        {
            $("#file_type").css('border','1px solid #ff0000');
			error_text = error_text+"<br>Please Submit Kuitansi Trophy";
            error = "2";
        }
        if($("#list_attachment").val().indexOf("3")==-1 && $("#transportation_actual").val().trim()!="0")
        {
            $("#file_type").css('border','1px solid #ff0000');
			error_text = error_text+"<br>Please Submit Kuitansi Transportation";
            error = "2";
        }
        $('input[name^="actual[]"]').each(function() 
		{
            if($(this).val()>0 && $("#list_attachment").val().indexOf("5")==-1)
			{
				error2 = "2";
			}			
        });
		if(error2=="2")
		{
			$("#file_type").css('border','1px solid #ff0000');
			error_text = error_text+"<br>Please Submit Kuitansi Biaya Lain";
			error = "2";
		}
        <?php } ?>
        if (error != "0") {
            Swal.fire({
                title: 'Please Check Your Data',
                icon: 'error',
                html: '<span style="font-size:14px">' + error_text,
                showCloseButton: false,
                showCancelButton: false,
                focusConfirm: false,
                confirmButtonText: 'Close'
            })
            return false;
        }
    }

}



function deleteAttachment(id) {

    <?php
if (isset($_GET['id'])) {
    ?>
    var id_sc = <?php echo $_GET['id']; ?>;
    <?php } else {?>
    id_sc = "";
    <?php }?>

    $.ajax({
        url: "<?php echo base_url(); ?>index.php/EventReport/deleteAttachment?id=" + id,
        type: "GET",
        dataType: "text",
        success: function(response) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/EventReport/getAttachment?id=" + id_sc +
                    "&state=" + <?php echo $state; ?>,
                type: "GET",
                dataType: "text",
                success: function(response) {
                    $('#attachment').html(response);
                },
                error: function(response) {},
            });
        },
        error: function(response) {},
    });
}


function calculate() {

    var i = 0;
    var total = 0;
    var total1 = 0;
    for (i = 1; i <= 11; i++) {
        if ($("#actual" + i).val() != null) {
            if ($("#actual" + i).val() != "0") {
                total = total + parseInt($("#actual" + i).val().split('.').join(''), 0);
                total1 = total1 + parseInt($("#est" + i).val().split('.').join(''), 0);
            }
        }
    }

    //	  $("#total").text(total);
    $("#total").text(numeral(total).format('0,0'));
    $("#total1").text(numeral(total1).format('0,0'));
    var y = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_est").val().split('.').join(''),
            0) + ($("#spg").val() * 250000) + parseInt($("#transportation_est").val().split('.').join(''), 0) +
        parseInt($(
            "#trophy_est").val().split('.').join(''), 0) + ($("#gimmick").val() * 10000);
    var y_actual = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_actual").val().split('.').join(''),
            0) + parseInt($("#spg_actual").val().split('.').join(''), 0) + parseInt($("#transportation_actual").val().split('.').join(''), 0) +
        parseInt($(
            "#trophy_actual").val().split('.').join(''), 0) + ($("#gimmick_actual").val() * 10000);
    $("#total_est").val(numeral(y).format('0,0'));
    $("#total_actual").val(numeral(y_actual).format('0,0'));
    $("#view_est").val(numeral(y / parseInt($("#participant_est").val().split('.').join(''), 0)).format('0,0'));
    $("#view_actual").val(numeral(y_actual / parseInt($("#participant_actual").val().split('.').join(''), 0)).format('0,0'));
	if(parseInt($("#sales_est").val().split('.').join(''), 0)==0)
	{
		$("#cost_ratio").val(0);
	}
	else
	{
		$("#cost_ratio").val(numeral(y * 100 / parseInt($("#sales_est").val().split('.').join(''), 0)).format('0,0'));
	}	
	if(parseInt($("#qty_actual").val().split('.').join(''), 0)==0)
	{
		$("#cost_ratio_actual").val(0);
	}
	else
	{
		$("#cost_ratio_actual").val(numeral(y_actual * 100 / parseInt($("#qty_actual").val().split('.').join(''), 0)).format('0,0'));
	}	
    $("#other").val(numeral(parseInt($("#total").text().split('.').join(''), 0)).format('0,0'));

}

function format(sel) {
    if (sel.value == "") {
        sel.value = "0";
    }
    var x = numeral(sel.value).value();
    sel.value = numeral(x).format('0,0');
    calculate();
}


$(function() {

    numeral.locale('id');
    calculate();

    $("[id^=actual]").change(function() {
        if ($(this).val() == "") {
            $(this).val("0");
        }
        var x = numeral($(this).val()).value();
        $(this).val(numeral(x).format('0,0'));
        calculate();
    });

    $("#spg_actual").change(function() {
        if ($(this).val() == "") {
            $(this).val("0");
        }
//        var x = numeral($(this).val()).value();
//        $("#spg_actual").val(numeral(x).format('0,0'));
		var y_actual = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_actual").val().split('.').join(''),
				0) + parseInt($("#spg_actual").val().split('.').join(''), 0) + parseInt($("#transportation_actual").val().split('.').join(''), 0) +
			parseInt($(
				"#trophy_actual").val().split('.').join(''), 0) + ($("#gimmick_actual").val() * 10000);
		$("#total_actual").val(numeral(y_actual).format('0,0'));
		if($("#participant_actual").val()==0)
		{
			$("#view_actual").val(0);
		}
		else
		{
			$("#view_actual").val(numeral(y_actual / parseInt($("#participant_actual").val().split('.').join(''), 0)).format('0,0'));
		}	
		if(parseInt($("#sales_est").val().split('.').join(''), 0)==0)
		{
			$("#cost_ratio").val(0);
		}
		else
		{
			$("#cost_ratio").val(numeral(y * 100 / parseInt($("#sales_est").val().split('.').join(''), 0)).format('0,0'));
		}	
		if(parseInt($("#qty_actual").val().split('.').join(''), 0)==0)
		{
			$("#cost_ratio_actual").val(0);
		}
		else
		{
			$("#cost_ratio_actual").val(numeral(y_actual * 100 / parseInt($("#qty_actual").val().split('.').join(''), 0)).format('0,0'));
		}	
    });

    $("#gimmick_actual").change(function() {
        if ($(this).val() == "") {
            $(this).val("0");
        }
//        var x = numeral($(this).val()).value() * 10000;
//        $("#gimmick_actual").val(numeral(x).format('0,0'));
		var z = $("#gimmick_actual").val() * 10000;
        $("#gimmick_actual2").val(numeral(z).format('0,0'));
		var y_actual = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_actual").val().split('.').join(''),
				0) + parseInt($("#spg_actual").val().split('.').join(''), 0) + parseInt($("#transportation_actual").val().split('.').join(''), 0) +
			parseInt($(
				"#trophy_actual").val().split('.').join(''), 0) + ($("#gimmick_actual").val() * 10000);
		$("#total_actual").val(numeral(y_actual).format('0,0'));
		if($("#participant_actual").val()==0)
		{
			$("#view_actual").val(0);
		}
		else
		{
			$("#view_actual").val(numeral(y_actual / parseInt($("#participant_actual").val().split('.').join(''), 0)).format('0,0'));
		}	
		if(parseInt($("#sales_est").val().split('.').join(''), 0)==0)
		{
			$("#cost_ratio").val(0);
		}
		else
		{
			$("#cost_ratio").val(numeral(y * 100 / parseInt($("#sales_est").val().split('.').join(''), 0)).format('0,0'));
		}	
		if(parseInt($("#qty_actual").val().split('.').join(''), 0)==0)
		{
			$("#cost_ratio_actual").val(0);
		}
		else
		{
			$("#cost_ratio_actual").val(numeral(y_actual * 100 / parseInt($("#qty_actual").val().split('.').join(''), 0)).format('0,0'));
		}	
    });

    $("[id$=actual]").change(function() {
        if ($(this).val() == "") {
            $(this).val("0");
        }
        var x = numeral($(this).val()).value();
        $(this).val(numeral(x).format('0,0'));
		var y_actual = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_actual").val().split('.').join(''),
				0) + parseInt($("#spg_actual").val().split('.').join(''), 0) + parseInt($("#transportation_actual").val().split('.').join(''), 0) +
			parseInt($(
				"#trophy_actual").val().split('.').join(''), 0) + ($("#gimmick_actual").val() * 10000);
		$("#total_actual").val(numeral(y_actual).format('0,0'));
		if($("#participant_actual").val()==0)
		{
			$("#view_actual").val(0);
		}
		else
		{
			$("#view_actual").val(numeral(y_actual / parseInt($("#participant_actual").val().split('.').join(''), 0)).format('0,0'));
		}	
		if(parseInt($("#sales_est").val().split('.').join(''), 0)==0)
		{
			$("#cost_ratio").val(0);
		}
		else
		{
			$("#cost_ratio").val(numeral(y * 100 / parseInt($("#sales_est").val().split('.').join(''), 0)).format('0,0'));
		}	
		if(parseInt($("#qty_actual").val().split('.').join(''), 0)==0)
		{
			$("#cost_ratio_actual").val(0);
		}
		else
		{
			$("#cost_ratio_actual").val(numeral(y_actual * 100 / parseInt($("#qty_actual").val().split('.').join(''), 0)).format('0,0'));
		}	
    });

	
        $('#event_date').multiDatesPicker({
            disabled: true,
            numberOfMonths: [3, 4],
            <?php
if ($event_date != "") {
    ?>
            addDates: [<?php echo $event_date; ?>],

            <?php
}
?>
        });

    if ($("#id_group").val() != 20 || ($("#id_group").val() == 20 && $("#state").val() > 1)) {
        $("[id$=_date]").prop("readonly", true);
        $("[id$=_actual]").prop("readonly", true);
        $("[id^=description]").prop("readonly", true);
        $("[id^=location]").prop("readonly", true);
        $("[id^=event]").prop("readonly", true);
        $("[id$=est]").prop("readonly", true);
        $("[id=booth_name]").prop("readonly", true);
        $("[id=booth_phone]").prop("readonly", true);
        $("[id=booth_account]").prop("readonly", true);
        $("[id=booth_phone]").prop("readonly", true);
        $("[id=spg]").prop("readonly", true);
        $("[id=trophy]").prop("readonly", true);
        $("[id=gimmick]").prop("readonly", true);
        $("[id^=upload]").prop("disabled", true);
        $(".add_button").attr("style", "visibility: hidden");
        $(".remove_button").attr("style", "visibility: hidden");
    } else {}

    if ($("#id_group").val() != 20) {
        $("[id^=upload]").prop("disabled", true);
    }

    $("#framesku").on("load", function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/EventReport/getSKU?id=" + id_sc2,
            type: "GET",
            dataType: "text",
            success: function(response) {
                $('#sales_actual').val(numeral(response).format('0,0'));
                calculate();
            },
            error: function(response) {},
        });

    });

    var x = 1;
    <?php
if (isset($_GET['id_event'])) {
    ?>
    var id_sc2 = <?php echo $_GET['id_event']; ?>;
    <?php } else {?>
    id_sc2 = "";
    <?php }

if (isset($_GET['id'])) {
    ?>
    var id_sc = <?php echo $_GET['id']; ?>;
    <?php if ($budget == 0) {?>
    x = 1;
    <?php } else {?>
    x = <?php echo ($budget - 0); ?>; //Initial field counter is 1
    <?php }} else {?>
    id_sc = "0";
    x = 1;
    <?php }
	if (isset($_GET['id'])) 
	{
	?>

    $.ajax({
        url: "<?php echo base_url(); ?>index.php/EventReport/getListAttachment?id=" + id_sc,
        type: "GET",
        dataType: "text",
        success: function(response) {
					  $('#list_attachment').val(response);
						  if(response.indexOf("7")!=-1 && ((response.indexOf("9")!=-1 && $("#spg_actual").val().trim()!="0") || (response.indexOf("8")!=-1 && $("#booth_actual").val().trim()!="0") || (response.indexOf("1")!=-1 && $("#booth_actual").val().trim()!="0") || (response.indexOf("3")!=-1 && $("#transportation_actual").val().trim()!="0") || (response.indexOf("2")!=-1 && $("#trophy_actual").val().trim()!="0") || ($("#transportation_actual").val().trim()=="0" && $("#booth_actual").val().trim()=="0" && $("#trophy_actual").val().trim()=="0")))
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
							if($("#requested_by").val()==119)
							{
								$("#request_approval").attr("style", "visibility:show");
							}	
						  }
						  else
						  {
							//$("#save").attr("style", "visibility:hidden");
							$("#request_approval").attr("style", "visibility:hidden");
							global_error=1;
						  }   					  
		}
		,
        error: function(response) {},
    });


    <?php } ?>
	

    $.ajax({
        url: "<?php echo base_url(); ?>index.php/EventReport/getSKUPIC?id=" + id_sc2,
        type: "GET",
        dataType: "text",
        success: function(response) {
            $('#sku').val(response);
            if ($("#id_group").val() != 20 || ($("#id_group").val() == 20 && $("#state").val() >
                    1)) {} else {
                if (response!="2") {
                    //$("#save").attr("style", "visibility:hidden");
                    $("#request_approval").attr("style", "visibility:hidden");
					global_error=1;
                } else {
                    $("#save").attr("style", "visibility:show");
					<?php if (isset($_GET['id'])) { ?> $("#request_approval").attr("style", "visibility:show"); <?php } ?>
                }
            }
        },
        error: function(response) {},
    });



    $.ajax({
        url: "<?php echo base_url(); ?>index.php/EventReport/getAttachment?id=" + id_sc + "&state=" +
            <?php echo $state; ?>,
        type: "GET",
        dataType: "text",
        success: function(response) {
            $('#attachment').html(response);
        },
        error: function(response) {},
    });

    //** 1

    //**

    var maxField = 10;
    var addButton = $('.add_button');
    var wrapper = $('.field_wrapper');
    var fieldHTML = '<div class="row" style="height:30px">';
    var description_text = "description" + (x);
    var cost_text = "actual" + (x);
    var est_text = "est" + (x);
    var date_text = "actl_date" + (x);
                        fieldHTML = '<div class="row" style="height:30px">';
                        fieldHTML = fieldHTML +
                            '<div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="description[]" id="' +
                            description_text +
                            '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px">';
                        fieldHTML = fieldHTML +
                            '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="est[]" id="' + est_text +
                            '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0" readonly>';
                        fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="actl_date[]" id="' + date_text +
                            '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" maxlength="10" value="0">';
                        fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="actual[]" id="' + cost_text +
                            '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';
						fieldHTML = fieldHTML + '</div>';
						fieldHTML = fieldHTML +
                            '<div class="col-xs-1" style="border-left:1px solid black;width:25px">';
                        fieldHTML = fieldHTML +
                            '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>';

    $('[id^=actual]').keypress(validateNumber);
    $('[id^=est]').keypress(validateNumber);


    //Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        var costArray = new Array();
        $('input[name^="actual[]"]').each(function() {
            costArray.push($(this).val().split('.').join(''));
        });

        var estArray = new Array();
        $('input[name^="est[]"]').each(function() {
            estArray.push($(this).val().split('.').join(''));
        });

        var descArray = new Array();
        $('input[name^="description[]"]').each(function() {
            descArray.push($(this).val());
        });

        var dateArray = new Array();
        $('input[name^="actl_date[]"]').each(function() {
            dateArray.push($(this).val());
        });

        //Check maximum number of input fields
        $('input[name^="description"]').each(function() {
            if (x < maxField) {
                if ($(this).val().trim() != "") {
                    if (dateArray[x - 1] != "" && costArray[x - 1] > 0) {
                        x++; //Increment field counter
                        cost_text = "actual" + (x);
                        date_text = "actl_date" + (x);
						est_text = "est" + (x);
                        description_text = "description" + (x);
                        fieldHTML = '<div class="row" style="height:30px">';
                        fieldHTML = fieldHTML +
                            '<div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="description[]" id="' +
                            description_text +
                            '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px">';
                        fieldHTML = fieldHTML +
                            '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="est[]" id="' + est_text +
                            '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0" readonly>';
                        fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="actl_date[]" id="' + date_text +
                            '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" maxlength="10" value="0">';
                        fieldHTML = fieldHTML + '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="actual[]" id="' + cost_text +
                            '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';
						fieldHTML = fieldHTML + '</div>';
						fieldHTML = fieldHTML +
                            '<div class="col-xs-1" style="border-left:1px solid black;width:25px">';
                        fieldHTML = fieldHTML +
                            '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>';
                        $(wrapper).append(fieldHTML); //Add field html
                    }
                }
            }
        });
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent('div').parent('div').remove(); //Remove field html
        x--; //Decrement field counter
        $(addButton).css('visibility', 'visible');
        calculate();
    });

	<?php 
	if (isset($_GET['id'])) {
    ?>
    var id_sc = <?php echo $_GET['id']; ?>;
    <?php } else {?>
    id_sc = "0";
    <?php }?>



    $('#upload').bind('click', function() {
        var data = new FormData;
        data.append('file', document.getElementById('file_name').files[0]);
        data.append('file_type', $('#file_type').val());
        data.append('id_parent', id_sc);
    


        $.ajax({
            url: "<?php echo base_url(); ?>index.php/EventReport/upload",
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(json) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/EventReport/getAttachment?id=" +
                        id_sc + "&state=" + <?php echo $state; ?>,
                    type: "GET",
                    dataType: "text",
                    success: function(response) {
                        $('#attachment').html(response);
                    },
                    error: function(response) {},
                });

            }
        });

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/EventReport/getListAttachment?id=" + id_sc,
            type: "GET",
            dataType: "text",
            success: function(response) {
                $('#list_attachment').val(response);
						  if(response.indexOf("7")!=-1 && ((response.indexOf("9")!=-1 && $("#spg_actual").val().trim()!="0") || (response.indexOf("8")!=-1 && $("#booth_actual").val().trim()!="0") || (response.indexOf("1")!=-1 && $("#booth_actual").val().trim()!="0") || (response.indexOf("3")!=-1 && $("#transportation_actual").val().trim()!="0") || (response.indexOf("2")!=-1 && $("#trophy_actual").val().trim()!="0") || ($("#transportation_actual").val().trim()=="0" && $("#booth_actual").val().trim()=="0" && $("#trophy_actual").val().trim()=="0")))
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
							if($("#requested_by").val()==119)
							{
								$("#request_approval").attr("style", "visibility:show");
							}	
						  }
						  else
						  {
							//$("#save").attr("style", "visibility:hidden");
							$("#request_approval").attr("style", "visibility:hidden");
							global_error=1;
						  }   					  
            },
            error: function(response) {},
        });

    });

    function validateNumber(event) {
        var key = window.event ? event.keyCode : event.which;
        if (key < 48 || key > 57) {
            return false;
        } else {
            return true;
        }
    };
	
      $('input[name^="actl_date[]"]').datepicker({dateFormat: 'dd/mm/yy'});
      $("#booth_date").datepicker({dateFormat: 'dd/mm/yy'});
      $("#trophy_date").datepicker({dateFormat: 'dd/mm/yy'});
      $("#transportation_date").datepicker({dateFormat: 'dd/mm/yy'});

});



</script>
</head>