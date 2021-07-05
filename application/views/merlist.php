<head>
    <meta name="viewport" content="width=1024">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
<body>
    <div class="container-fluid">
        <div class="row">
          <div class="col-xs-1" style="height:7px">&nbsp;</div>
        </div>
        <div id="list">
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:100%">
    		<iframe id="iframe1" src="" style="height:400px;width:100%;border:none;overflow:hidden;"></iframe>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:100%"><hr></div>
        </div>
        <div class="row">
          <div class="col-xs-1" style="width:100%">Copyright @ 2019</div>
        </div>
        <div class="row">
          <div class="col-xs-1">&nbsp;</div>
        </div>
    </div>
  </body>
  <style type="text/css">
    .form-control {
      border-radius: 0.5rem;
      padding: 0px;
    }
    .btn-group-xs > .btn, .btn-xs {
    padding: .25rem .4rem;
    font-size: 1rem;
    line-height: 1.25;
    border-radius: .2rem;
    }
  </style>
  <script type="text/javascript">
  function setEditFrame(id,type)
  {
    $("#iframe1").attr('src','<?php echo base_url(); ?>index.php/MER?type='+type+'&id='+id);      
  }
  function setAddFrame(type)
  {
    $("#iframe1").attr('src','<?php echo base_url(); ?>index.php/MER?type='+type);      
  }
  $(function () {
        $.ajax({
            url : "<?php echo base_url(); ?>index.php/MERList/getList?type="+<?php echo $_GET['type']; ?>,
            type: "GET",
            dataType: "text",
            success : function(response) {
                $('#list').html(response);
            }
        });
  });

  </script>
</head>
