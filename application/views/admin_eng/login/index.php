<!DOCTYPE html>
<html>
  <head>
    <title>Admin Dashboard</title>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <!--<meta content="template language" name="keywords">
    <meta content="Tamerlan Soziev" name="author">
    <meta content="Admin dashboard html template" name="description">-->
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="favicon.png" rel="shortcut icon">
    <link href="apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url().'public/'?>bower_components/select2/dist/css/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url().'public/'?>bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="<?php echo base_url().'public/'?>bower_components/dropzone/dist/dropzone.css" rel="stylesheet">
    <link href="<?php echo base_url().'public/'?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url().'public/'?>bower_components/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet">
    <link href="<?php echo base_url().'public/'?>bower_components/perfect-scrollbar/css/perfect-scrollbar.min.css" rel="stylesheet">
    <link href="<?php echo base_url().'public/'?>bower_components/slick-carousel/slick/slick.css" rel="stylesheet">
    <link href="<?php echo base_url().'public/'?>css/main.css?version=4.2.0" rel="stylesheet">
    <style type="text/css">
      .alert {margin-top: 20px}
      .alert-form {display: none;}
      .middle-alert p{margin-bottom: 5px;}
    </style>
  </head>
  <body class="auth-wrapper">
    <div class="all-wrapper menu-side with-pattern">
      <div class="auth-box-w">
        <div class="logo-w">
          <a href="index.html"><img alt="" src="<?php echo base_url().'public/'?>img/logo-big.png"></a>
        </div>
        <h4 class="auth-header">Login Form</h4>
        <form id="formValidate"  action="<?php echo ADMIN_URL.'/login'; ?>">
          <div class="form-group">
            <label for="">Username</label><input class="form-control" data-error="Please input your User Name" placeholder="Enter your username" required="required"  type="text" id="username" name="username">
            <div class="pre-icon os-icon os-icon-user-male-circle"></div>
          </div>
          <div class="form-group">
            <label for="">Password</label><input class="form-control" data-error="Please input your Password" placeholder="Enter your password" required="required" type="password" id="password" name="password">
            <div class="pre-icon os-icon os-icon-fingerprint"></div>
          </div>
          <div class="buttons-w">
            <button class="btn btn-primary">Log me in</button>
            <div class="form-check-inline">
              <label class="form-check-label"><input class="form-check-input" type="checkbox" id="remember" name="remember">Remember Me</label>
            </div>
          </div>
          <div id="alert-form" class="alert-form clearfix">
            <div id="alert" class="alert alert-success" role="alert">
              <div id="middle-alert" class="middle-alert"></div>
            </div>  
          </div>
        </form>
      </div>
    </div>
    <script src="<?php echo base_url(); ?>public/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/moment/moment.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/chart.js/dist/Chart.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/select2/dist/js/select2.full.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/jquery-bar-rating/dist/jquery.barrating.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap-validator/dist/validator.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/dropzone/dist/dropzone.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/editable-table/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/tether/dist/js/tether.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/slick-carousel/slick/slick.min.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/util.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/alert.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/button.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/carousel.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/collapse.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/dropdown.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/modal.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/tab.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/tooltip.js"></script>
    <script src="<?php echo base_url(); ?>public/bower_components/bootstrap/js/dist/popover.js"></script>
    <script src="<?php echo base_url(); ?>public/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>public/main.js?version=4.2.0"></script>
    <?php echo put_footer_js()?>
    <input type="hidden" id="ajax_url" value="<?php echo ADMIN_URL; ?>">
  </body>
</html>