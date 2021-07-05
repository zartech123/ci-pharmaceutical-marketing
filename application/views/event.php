<head>
    <meta name="viewport" content="width=1024">
    <title>EVENT OTC REQUEST FORM</title>
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
$code = "";
$otc = "";
if (isset($_GET['id'])) {
    $readonly = "readonly";

    $query = $this->db->query("SELECT sum(replace(budget,'.','')) AS amount FROM budget_event where id_parent=" . $_GET['id']);
    foreach ($query->result() as $row2) {
        $amount = $row2->amount;
    }

	$requested_name = "";
    $query = $this->db->query("SELECT name FROM user where id_user=" . $requested_by);
    foreach ($query->result() as $row2) {
        $requested_name = $row2->name;
    }

    $query = $this->db->query("SELECT a.name, email, id_group FROM user a, event_otc b WHERE id_event=" . $_GET['id'] . " and a.active=1 and id_group IN (19) and id_regency=id_product_group");
    foreach ($query->result() as $row2) {
        if ($row2->id_group == 19) {
            $otc = $row2->name;
        }
    }

    $query = $this->db->query("SELECT c.code FROM event_otc a, product_group c WHERE id_group=" . $product . " AND id_event=" . $_GET['id']);
    foreach ($query->result() as $row2) {
        $code = $row2->code;
    }
}

?>
        <form action="<?php echo base_url() . 'index.php/Event/add'; ?>" method="post">
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:900px">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:900px"><img
                        src="<?php echo base_url(); ?>assets/img/logo.png" /></div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="background:#efefef;text-align:center;width:900px">
                    <b>EVENT OTC REQUEST FORM</b>
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
                        <textarea rows="2" class="form-control" id="event_name" name="event_name"
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
                        <textarea rows="2" class="form-control" id="location" name="location"
                            style="height:60px;width:350px;"><?php echo $location; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row" style="height:38px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px"><b>Bundling</b></div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <select class="form-control" id="bundling" name="bundling" style="height:30px">
                            <option value="1">Ya</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" style="height:38px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px"><b>Area</b></div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <select class="form-control" id="area" name="area" style="height:30px">
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" style="height:68px;">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Tempat Ambil Product</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <textarea rows="2" class="form-control" id="outlet" name="outlet"
                            style="height:60px;width:350px;"><?php echo $outlet; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Pengunjung</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="participant_est" name="participant_est" type="text"
                            style="width:70px" maxlength="5" value="<?php echo $participant_est; ?>" />
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
                            value="<?php if ($participant_est == 0) {echo "0";} else {echo number_format(($booth_est + ($spg * 250000) + $transportation_est + $trophy_est + ($gimmick * 10000)) / intval(str_replace('.','',$participant_est)), 0);}?>"
                            readonly />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Biaya Booth/Sewa Tempat</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="booth_est" name="booth_est" type="text" style="width:100px"
                            maxlength="10" value="<?php echo $booth_est; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Nama Pemilik Bank (Panitia)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <textarea rows="2" class="form-control" id="booth_name" name="booth_name"
                            style="height:60px;width:350px;"><?php echo $booth_name; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Nama Bank</b>
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
                    <b>No. Rekening (Panitia)</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <textarea rows="2" class="form-control" id="booth_account" name="booth_account"
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
                        <textarea rows="2" class="form-control" id="booth_phone" name="booth_phone"
                            style="height:60px;width:350px;"><?php echo $booth_phone; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Jumlah Piala</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="trophy" name="trophy" type="text" style="width:70px"
                            maxlength="5" value="<?php echo $trophy; ?>" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1" style="width:20px">&nbsp;<i class="fa fa-square" aria-hidden="true"></i>&nbsp;
                </div>
                <div class="col-xs-1" style="width:180px">
                    <b>Biaya Piala</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;IDR&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="trophy_est" name="trophy_est" type="text" style="width:100px"
                            maxlength="10" value="<?php echo $trophy_est; ?>" />
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
                        <input class="form-control" id="spg" name="spg" type="text" style="width:70px" maxlength="5"
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
                        <input class="form-control" id="spg_est" name="spg_est" type="text" style="width:70px"
                            maxlength="5" value="<?php echo number_format(($spg * 250000), 0); ?>" readonly />
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
                        <input class="form-control" id="transportation_est" name="transportation_est" type="text"
                            style="width:100px" maxlength="10" value="<?php echo $transportation_est; ?>" />
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
                        <input class="form-control" id="gimmick" name="gimmick" type="text" style="width:70px"
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
                        <input class="form-control" id="gimmick_est" name="gimmick_est" type="text" style="width:70px"
                            maxlength="5" value="<?php echo number_format(($gimmick * 10000), 0); ?>" readonly />
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
                <div class="col-xs-1" style="width:180px">
                    <b>Jumlah Sample</b>
                </div>
                <div class="col-xs-1">&nbsp;:&nbsp;</div>
                <div class="col-xs-1">
                    <div class="form-group">
                        <input class="form-control" id="sample_est" name="sample_est" type="text" style="width:70px"
                            maxlength="5" value="<?php echo $sample_est; ?>" />
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
                            maxlength="10" value="<?php echo $sales_est; ?>" / readonly>
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
                            value="<?php if ($sales_est == "0") {echo "0";} else {echo number_format(($booth_est + ($spg * 250000) + $transportation_est + $trophy_est) / $sales_est, 0);}?>"
                            readonly />
                    </div>
                </div>
                <div class="col-xs-1">&nbsp;%&nbsp;</div>
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
                    <b>&nbsp;Amount (IDR)&nbsp;</b>
                </div>
            </div>
            <div class="field_wrapper">
                <?php
if ($budget == 0) {
    $description_text = "description1";
    $cost_text = "budget1";
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
                            <input id="budget1" name="budget[]" class="form-control" type="text"
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
        $cost_text = "budget" . ($i + 1);
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
                            <input id="<?php echo $cost_text; ?>" name="budget[]" class="form-control" type="text"
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
                            <option value="1">Others (Optional)</option>
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
					<?php if(isset($_GET['id'])) { ?>
                    <iframe id="framesku" width="900" height="564"
                        src="<?php echo base_url(); ?>index.php/EventSKU/index/id/<?php echo $_GET['id']; ?>/state/<?php echo $state; ?>/type/1"></iframe>
					<?php } else { ?>
                    <iframe id="framesku" width="900" height="564"
                        src=""></iframe>
					<?php } ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1">&nbsp;</div>
            </div>
            <div class="row">
                <div class="col-xs-1">
					<?php if(isset($_GET['id'])) { ?>
                    <iframe id="framepic" width="900" height="564"
                        src="<?php echo base_url(); ?>index.php/EventPIC/index/id/<?php echo $_GET['id']; ?>/state/<?php echo $state; ?>/type/1"></iframe>
					<?php } else { ?>
                    <iframe id="framepic" width="900" height="564"
                        src=""></iframe>
					<?php } ?>
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
                    by<br /><?php if ($approver0 != "") {echo $approver0;} else {echo $requested_name;}?><br />(<?php echo $created_date; ?>)<br /><br /><?php if ($title0 != "") {echo $title0;} else {if ($this->session->userdata('id_group') == 10) {echo $GLOBALS['rsm-grp'];} else {echo $GLOBALS['kae-grp'];}}?><br />&nbsp;
                </div>
                <div class="col-xs-1"
                    style="border-left:1px solid black;border-top:1px solid black;border-right:1px solid black;width:200px;text-align:center">
                    &nbsp;<br />Approved
                    by<br /><span
                        id="otc_name"><?php if ($state > 2) {echo $approver1;} else {echo $otc;}?></span><br />(<?php if ($state > 2) {echo $updated_date1;}?>)<br /><br /><?php if ($state > 2) {echo $title1;} else {echo $GLOBALS['otc-grp'];}?><br />&nbsp;
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

<?php
if (isset($_GET['id'])) {
    ?>
$("#bundling").val('<?php echo $bundling; ?>');
<?php
}
?>
if ($("#state").val() == 1) {

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

}

$("[id=product]").change(function() {
    $.ajax({
        url: "<?php echo base_url(); ?>index.php/Event/getPM?id=" + $(this).val(),
        type: "GET",
        dataType: "text",
        success: function(response) {
            $("#otc_name").text(response);
        },
        error: function(response) {},
    });
});

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
if ($("#state").val() == 6 && ($("#id_group").val() == 10 || $("#id_group").val() == 15 || $("#id_group").val() ==
        19)) {
    $("#print").attr("style", "visibility:show");
}

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

$('input[name^="budget[]"]').css("text-align", "right");
$('[id^=budget]').css("text-align", "right");

if (($("#id_group").val() == 15 || $("#id_group").val() == 10) && $("#state").val() == 1 && $("#id_parent").val() !=
    null) {
    <?php
if (isset($_GET['id'])) {
    ?>
    var id_sc = <?php echo $_GET['id']; ?>;
    <?php } else {?>
    id_sc = "";
    <?php }?>

    $.ajax({
        url: "<?php echo base_url(); ?>index.php/Event/getSKU?id=" + id_sc,
        type: "GET",
        dataType: "text",
        success: function(response) {
            $('#sales_est').val(numeral(response).format('0,0'));
            calculate();
        },
        error: function(response) {},
    });

    var request_approval = document.getElementById('request_approval');
    $("#request_approval").attr("style", "visibility:show");

    request_approval.onclick = function() {
        $("#save").click();
        if (error == 0) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Event/updateState?id_group=" +
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
    url: "<?php echo base_url(); ?>index.php/Event/getProduct",
    type: "GET",
    dataType: "text",
    success: function(response) {
        var json = $.parseJSON(response);
        for (var i = 0; i < json.length; ++i) {
            $('[id^=product]').append('<option value="' + json[i].id + '">' + json[i].name + '</option>');
        }
        <?php
if (isset($_GET['id'])) {
    ?>
        $("#product").val('<?php echo $product; ?>');
        <?php
}
?>

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Event/getPM?id=" + $('[id^=product]').val(),
            type: "GET",
            dataType: "text",
            success: function(response) {
                $("#otc_name").text(response);
            },
            error: function(response) {},
        });

    },
    error: function(response) {},
});


$.ajax({
    url: "<?php echo base_url(); ?>index.php/Event/getArea",
    type: "GET",
    dataType: "text",
    success: function(response) {
        var json = $.parseJSON(response);
        for (var i = 0; i < json.length; ++i) {
            $('[id^=area]').append('<option value="' + json[i].id + '">' + json[i].name + '</option>');
        }
        <?php
if (isset($_GET['id'])) {
    ?>
        $("#area").val('<?php echo $id_area; ?>');
        <?php
}
?>
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
if (isset($_GET['id'])) {
    ?>
    var id_sc = <?php echo $_GET['id']; ?>;
    <?php } else {?>
    id_sc = "";
    <?php }?>



    review.onclick = function() {
        if (($("#id_group").val() == 19 && $("#note1").val() != "")) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Event/updateState2?id=" + id_sc,
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
            url: "<?php echo base_url(); ?>index.php/Event/updateState?id_group=" +
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
            url: "<?php echo base_url(); ?>index.php/Event/updateState4?active=" + active + "&id=" + id_sc,
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
                url: "<?php echo base_url(); ?>index.php/Event/updateState3?id=" + id_sc,
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

if (($("#id_group").val() == 15 || $("#id_group").val() == 10) && $("#state").val() == 1) {
    var save = document.getElementById('save');
    $("#save").attr("style", "visibility:show");

    save.onclick = function() {
        error = "0";
        error_text = "";
        $("#location").css('border', '1px solid #cdcdcd');
        $("#event_name").css('border', '1px solid #cdcdcd');
        $("#sample_est").css('border', '1px solid #cdcdcd');
        $("#participant_est").css('border', '1px solid #cdcdcd');
        if ($("#participant_est").val().trim() == "" || $("#participant_est").val().trim() == "0") {
            $("#participant_est").css('border', '1px solid #ff0000');
            error_text = error_text + "<br>Please fill the Participant";
            error = "1";
        }
        /*if ($("#sample_est").val().trim() == "0") {
            $("#sample_est").css('border', '1px solid #ff0000');
            error_text = error_text + "<br>Please fill the Jumlah Sample";
            error = "1";
        }*/
        if ($("#event_name").val().trim() == "") {
            $("#event_name").css('border', '1px solid #ff0000');
            error_text = error_text + "<br>Please fill the Event Name";
            error = "1";
        }
        if ($("#event_date2").val().trim() == "" || $("#event_date2").val().trim() == "''") {
            error_text = error_text + "<br>Please fill the Event Date";
            error = "1";
        }
        if ($("#location").val().trim() == "") {
            $("#location").css('border', '1px solid #ff0000');
            error_text = error_text + "<br>Please fill the Location";
            error = "1";
        }
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
        url: "<?php echo base_url(); ?>index.php/Event/deleteAttachment?id=" + id,
        type: "GET",
        dataType: "text",
        success: function(response) {
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Event/getAttachment?id=" + id_sc +
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
    for (i = 1; i <= 11; i++) {
        if ($("#budget" + i).val() != null) {
            if ($("#budget" + i).val() != "0") {
                total = total + parseInt($("#budget" + i).val().split('.').join(''), 0);
            }
        }
    }

    //	  $("#total").text(total);
    $("#total").text(numeral(total).format('0,0'));
    var y = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_est").val().split('.').join(''),
            0) + ($("#spg").val() * 250000) + parseInt($("#transportation_est").val().split('.').join(''), 0) +
        parseInt($(
            "#trophy_est").val().split('.').join(''), 0) + ($("#gimmick").val() * 10000);
    var y1 = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_est").val().split('.').join(''),
            0) + ($("#spg").val() * 250000) + parseInt($("#transportation_est").val().split('.').join(''), 0) +
        parseInt($(
            "#trophy_est").val().split('.').join(''), 0);
    $("#total_est").val(numeral(y).format('0,0'));
    $("#view_est").val(numeral(y / parseInt($("#participant_est").val().split('.').join(''), 0)).format('0,0'));
    if($("#sales_est").val()!=0)
	{
		$("#cost_ratio").val(numeral(y1 * 100 / parseInt($("#sales_est").val().split('.').join(''), 0)).format('0,0'));
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

    $("[id^=budget]").change(function() {
        if ($(this).val() == "") {
            $(this).val("0");
        }
        var x = numeral($(this).val()).value();
        $(this).val(numeral(x).format('0,0'));
        calculate();
    });

    $("#spg").change(function() {
        if ($(this).val() == "") {
            $(this).val("0");
        }
        var x = numeral($(this).val()).value() * 250000;
        $("#spg_est").val(numeral(x).format('0,0'));
        var y = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_est").val()
            .split('.').join(''), 0) + ($("#spg").val() * 250000) + parseInt($(
            "#transportation_est").val().split('.').join(''), 0) + parseInt($("#trophy_est").val()
            .split('.').join(''), 0) + ($("#gimmick").val() * 10000);
        var y1 = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_est").val()
                .split('.').join(''),
                0) + ($("#spg").val() * 250000) + parseInt($("#transportation_est").val().split('.')
                .join(''), 0) +
            parseInt($(
                "#trophy_est").val().split('.').join(''), 0);
        $("#total_est").val(numeral(y).format('0,0'));
        $("#view_est").val(numeral(y / parseInt($("#participant_est").val().split('.').join(''), 0))
            .format('0,0'));
		if(parseInt($("#sales_est").val().split('.').join(''), 0)!=0)
		{
			$("#cost_ratio").val(numeral(y1 * 100 / parseInt($("#sales_est").val().split('.').join(''), 0))
				.format('0,0'));
		}		
    });

    $("#gimmick").change(function() {
        if ($(this).val() == "") {
            $(this).val("0");
        }
        var x = numeral($(this).val()).value() * 10000;
        $("#gimmick_est").val(numeral(x).format('0,0'));
        var y = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_est").val()
            .split('.').join(''), 0) + ($("#spg").val() * 250000) + parseInt($(
            "#transportation_est").val().split('.').join(''), 0) + parseInt($("#trophy_est").val()
            .split('.').join(''), 0) + ($("#gimmick").val() * 10000);
        $("#total_est").val(numeral(y).format('0,0'));
        $("#view_est").val(numeral(y / parseInt($("#participant_est").val().split('.').join(''), 0))
            .format('0,0'));
    });

    $("[id$=est]").change(function() {
        if ($(this).val() == "") {
            $(this).val("0");
        }
        var x = numeral($(this).val()).value();
        $(this).val(numeral(x).format('0,0'));
        var y = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_est").val()
            .split('.').join(''), 0) + ($("#spg").val() * 250000) + parseInt($(
            "#transportation_est").val().split('.').join(''), 0) + parseInt($("#trophy_est").val()
            .split('.').join(''), 0) + ($("#gimmick").val() * 10000);
        var y1 = parseInt($("#total").text().split('.').join(''), 0) + parseInt($("#booth_est").val()
                .split('.').join(''),
                0) + ($("#spg").val() * 250000) + parseInt($("#transportation_est").val().split('.')
                .join(''), 0) +
            parseInt($(
                "#trophy_est").val().split('.').join(''), 0);
        $("#total_est").val(numeral(y).format('0,0'));
        $("#view_est").val(numeral(y / parseInt($("#participant_est").val().split('.').join(''), 0))
            .format('0,0'));
		if(parseInt($("#sales_est").val().split('.').join(''), 0)!=0)
		{
			$("#cost_ratio").val(numeral(y1 * 100 / parseInt($("#sales_est").val().split('.').join(''), 0))
				.format('0,0'));
		}		
    });

    if (($("#id_group").val() != 15 && $("#id_group").val() != 10) || (($("#id_group").val() == 15 || $(
            "#id_group").val() == 10) && $("#state").val() > 1)) {
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
        $("[id^=budget]").prop("readonly", true);
        $("[id^=description]").prop("readonly", true);
        $("[id^=location]").prop("readonly", true);
        $("[id^=event]").prop("readonly", true);
        $("[id$=est]").prop("readonly", true);
        $("[id^=booth]").prop("readonly", true);
        $("[id^=spg]").prop("readonly", true);
        $("[id^=trophy]").prop("readonly", true);
        $("[id^=gimmick]").prop("readonly", true);
        $("[id^=upload]").prop("disabled", true);
        $(".add_button").attr("style", "visibility: hidden");
        $(".remove_button").attr("style", "visibility: hidden");
    } else {}

    if ($("#id_group").val() != 15 && $("#id_group").val() != 10) {
        $("[id^=upload]").prop("disabled", true);
    }

    $("#framesku").load(function() {

        $("#framesku").contents().on("click", ".btn.btn-danger.btn-xs.delete-confirmation-button",
            function() {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Event/getSKUPIC?id=" + id_sc,
                    type: "GET",
                    dataType: "text",
                    success: function(response) {
                        $('#sku').val(response);
                        if (($("#id_group").val() != 15 && $("#id_group").val() !=
                                10) || (($("#id_group").val() == 15 || $("#id_group")
                                    .val() == 10) &&
                                $("#state").val() > 1)) {} else {
                            if (response != "2") {
                                //$("#save").attr("style", "visibility:hidden");
                                $("#request_approval").attr("style",
                                    "visibility:hidden");
                            } else {
                                $("#save").attr("style", "visibility:show");
                                $("#request_approval").attr("style", "visibility:show");
                            }
                        }
                    },
                    error: function(response) {},
                });
            });
    });

    $("#framesku").on("load", function() {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Event/getSKUPIC?id=" + id_sc,
            type: "GET",
            dataType: "text",
            success: function(response) {
                $('#sku').val(response);
                if (($("#id_group").val() != 15 && $("#id_group").val() != 10) || (($(
                            "#id_group").val() == 15 || $("#id_group").val() == 10) &&
                        $("#state").val() > 1)) {} else {
                    if (response != "2") {
                        //$("#save").attr("style", "visibility:hidden");
                        $("#request_approval").attr("style", "visibility:hidden");
                    } else {
                        $("#save").attr("style", "visibility:show");
                        $("#request_approval").attr("style", "visibility:show");
                    }
                }
            },
            error: function(response) {},
        });

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Event/getSKU?id=" + id_sc,
            type: "GET",
            dataType: "text",
            success: function(response) {
                $('#sales_est').val(numeral(response).format('0,0'));
                calculate();
            },
            error: function(response) {},
        });

    });

    $("#framepic").load(function() {
        $("#framepic").contents().on("click", ".btn.btn-danger.btn-xs.delete-confirmation-button",
            function() {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Event/getSKUPIC?id=" + id_sc,
                    type: "GET",
                    dataType: "text",
                    success: function(response) {
                        $('#sku').val(response);
                        if (($("#id_group").val() != 15 && $("#id_group").val() !=
                                10) || (($("#id_group").val() == 15 || $("#id_group")
                                    .val() == 10) &&
                                $("#state").val() > 1)) {} else {
                            if (response != "2") {
                                //$("#save").attr("style", "visibility:hidden");
                                $("#request_approval").attr("style",
                                    "visibility:hidden");
                            } else {
                                $("#save").attr("style", "visibility:show");
                                $("#request_approval").attr("style", "visibility:show");
                            }
                        }
                    },
                    error: function(response) {},
                });
            });
    });

    $("#framepic").on("load", function() {

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Event/getSKUPIC?id=" + id_sc,
            type: "GET",
            dataType: "text",
            success: function(response) {
                $('#sku').val(response);
                if (($("#id_group").val() != 15 && $("#id_group").val() != 10) || (($(
                            "#id_group").val() == 15 || $("#id_group").val() == 10) &&
                        $("#state").val() > 1)) {} else {
                    if (response != "2") {
                        //$("#save").attr("style", "visibility:hidden");
                        $("#request_approval").attr("style", "visibility:hidden");
                    } else {
                        $("#save").attr("style", "visibility:show");
                        $("#request_approval").attr("style", "visibility:show");
                    }
                }
            },
            error: function(response) {},
        });

    });

    var x = 1;
    <?php
if (isset($_GET['id'])) {
    ?>
    var id_sc = <?php echo $_GET['id']; ?>;
    <?php if ($budget == 0) {?>
    x = 1;
    <?php } else {?>
    x = <?php echo ($budget - 0); ?>; //Initial field counter is 1
    <?php }} else {?>
    id_sc = "";
    x = 1;
    <?php }?>
    $.ajax({
        url: "<?php echo base_url(); ?>index.php/Event/getListAttachment?id=" + id_sc,
        type: "GET",
        dataType: "text",
        success: function(response) {
            $('#list_attachment').val(response);
        },
        error: function(response) {},
    });


    $.ajax({
        url: "<?php echo base_url(); ?>index.php/Event/getSKUPIC?id=" + id_sc,
        type: "GET",
        dataType: "text",
        success: function(response) {
            $('#sku').val(response);
            if (($("#id_group").val() != 15 && $("#id_group").val() != 10) || (($("#id_group")
                        .val() == 15 || $("#id_group").val() == 10) &&
                    $("#state").val() > 1)) {} else {
                if (response != "2") {
                    //$("#save").attr("style", "visibility:hidden");
                    $("#request_approval").attr("style", "visibility:hidden");
                } else {
                    $("#save").attr("style", "visibility:show");
                    $("#request_approval").attr("style", "visibility:show");
                }
            }
        },
        error: function(response) {},
    });

    $.ajax({
        url: "<?php echo base_url(); ?>index.php/Event/getAttachment?id=" + id_sc + "&state=" +
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
    var cost_text = "budget" + (x);
    fieldHTML = fieldHTML +
        '<div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
    fieldHTML = fieldHTML + '<input name="description[]" id="' + description_text +
        '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px">';
    fieldHTML = fieldHTML +
        '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
    fieldHTML = fieldHTML + '<input name="budget[]" id="' + cost_text +
        '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px;text-align:right" onchange="format(this);" maxlength="10" value="0">';
    fieldHTML = fieldHTML + '</div>';
    fieldHTML = fieldHTML + '<div class="col-xs-1" style="border-left:1px solid black;width:25px">';
    fieldHTML = fieldHTML +
        '<a href="javascript:void(0);" class="remove_button"><i class="fa fa-times fa-2x" aria-hidden="true"></i></a></div></div>';

    $('[id^=budget]').keypress(validateNumber);


    //Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        var costArray = new Array();
        $('input[name^="budget[]"]').each(function() {
            costArray.push($(this).val().split('.').join(''));
        });

        var descArray = new Array();
        $('input[name^="description[]"]').each(function() {
            descArray.push($(this).val());
        });

        //Check maximum number of input fields
        $('input[name^="description"]').each(function() {
            if (x < maxField) {
                if ($(this).val().trim() != "") {
                    if (descArray[x - 1] != "" && costArray[x - 1] > 0) {
                        x++; //Increment field counter
                        cost_text = "budget" + (x);
                        description_text = "description" + (x);
                        fieldHTML = '<div class="row" style="height:30px">';
                        fieldHTML = fieldHTML +
                            '<div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="description[]" id="' +
                            description_text +
                            '" class="form-control" type="text" style="width:200px;border-right:1px solid black;border-top:1px solid black;height:30px">';
                        fieldHTML = fieldHTML +
                            '</div><div class="col-xs-1" style="width:200px;border-left:1px solid black;border-bottom:1px solid black;">';
                        fieldHTML = fieldHTML + '<input name="budget[]" id="' + cost_text +
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

    $('#upload').bind('click', function() {
        var data = new FormData;
        data.append('file', document.getElementById('file_name').files[0]);
        data.append('file_type', $('#file_type').val());
        data.append('id_parent', id_sc);

        $.ajax({
            url: "<?php echo base_url(); ?>index.php/Event/upload",
            type: 'POST',
            data: data,
            contentType: false,
            processData: false,
            success: function(json) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/Event/getAttachment?id=" +
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
            url: "<?php echo base_url(); ?>index.php/Event/getListAttachment?id=" + id_sc,
            type: "GET",
            dataType: "text",
            success: function(response) {
                $('#list_attachment').val(response);
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

});
</script>
</head>