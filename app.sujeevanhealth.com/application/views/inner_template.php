<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo $this->config->item("site_name");?>">
    <meta name="keywords" content="<?php echo $this->config->item("site_name");?>">
    <title><?php echo $this->config->item("site_name");?></title>
    <link rel="shortcut icon" href="<?php echo $this->config->item("jeevanassets");?>logo.png">
    <meta name="author" content="<?php echo $this->config->item("site_name");?>">
    <link href="<?php echo $this->config->item("jeevanassets");?>lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item("jeevanassets");?>lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item("jeevanassets");?>lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item("jeevanassets");?>lib/sweet-alert2/sweetalert2.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item("jeevanassets");?>lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo $this->config->item("jeevanassets");?>lib/summernote/summernote-bs4.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $this->config->item("jeevanassets");?>lib/spinkit/css/spinkit.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $this->config->item("jeevanassets");?>css/bracket.css">
    <link rel="stylesheet" href="<?php echo $this->config->item("jeevanassets");?>css/bracket.simple-white.css">
    <link rel="stylesheet" href="<?php echo $this->config->item("jeevanassets");?>css/jquery.nestable.min.css">
    <link rel="stylesheet" href="<?php echo $this->config->item("jeevanassets");?>bootstrap-tagsinput.css">
    <link rel="stylesheet" href="<?php echo $this->config->item("jeevanassets");?>sujeevan.css">
  </head>
  <body>
    <div class="br-logo"><a href="javascript:void(0)"><img class="img img-responsive" src="<?php echo $this->config->item("jeevanassets");?>logo-name.png"/></a></div>
    <?php $this->load->view("sidebar");?>
    <?php $this->load->view("header");?>
    <?php $this->load->view("right_side");?>
    <div class="br-mainpanel">
        <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
              <a class="breadcrumb-item" href="<?php echo adminurl("Dashboard");?>"><i class="fa fa-home"></i></a>
              <?php echo isset($vtil)?$vtil:"";?>
              <span class="breadcrumb-item active"><?php echo $title;?></span>
          </nav>
        </div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
        <?php $this->load->view($content);?>
     
        <footer class="br-footer">
            <div class="footer-left">
                <div class="mg-b-2">Copyright &copy; <?php echo date("Y");?> <?php echo sitedata("site_name");?>.All Rights Reserved.</div>
            </div>
            <div class="footer-right d-flex align-items-center">
                <div>Developed by <a href="http://advitsoft.com" target="_blank">ADVIT</a>.</div>
            </div>
        </footer>
    </div>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/jquery/jquery.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/jquery-ui/ui/widgets/datepicker.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/moment/min/moment.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/peity/jquery.peity.min.js"></script>
    <?php if($this->uri->segment("2") == "Dashboard") { ?>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/rickshaw/vendor/d3.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/rickshaw/vendor/d3.layout.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/rickshaw/rickshaw.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/jquery.flot/jquery.flot.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/jquery.flot/jquery.flot.resize.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/echarts/echarts.min.js"></script>
<!--    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAq8o5-8Y5pudbJMJtDFzb8aHiWJufa5fg"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/gmaps/gmaps.min.js"></script>-->
    
    <!--<script src="<?php echo $this->config->item("jeevanassets");?>js/map.shiftworker.js"></script>-->
    <script src="<?php echo $this->config->item("jeevanassets");?>js/ResizeSensor.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>js/dashboard.js"></script>
    <?php } ?>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/select2/js/select2.full.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/summernote/summernote-bs4.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>lib/sweet-alert2/sweetalert2.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>js/bracket.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>js/jquery.validate.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>js/jquery.nestable.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo $this->config->item("jeevanassets");?>jeevan.js"></script>
    <script>
        var sv  =   "<?php echo $this->uri->segment("2");?>";
        $(".sp"+sv).css("display","block");
        $("."+sv).addClass("show-sub");
        $("."+sv).addClass("active");
    </script>
  </body>
</html>
