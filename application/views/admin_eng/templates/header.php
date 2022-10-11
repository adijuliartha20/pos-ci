<?php //$this->load->helper('url'); ?>
<html>
    <head>
    	<!--<meta content="width=device-width, initial-scale=1" name="viewport">-->
        <title><?php echo $title;?> - Loco Admin</title>
        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500" rel="stylesheet" type="text/css">
        <?php echo put_headers(); ?>
    </head>
    <body class="<?php echo (isset($_SESSION['access'])?  $_SESSION['access'].'-area' : '' ); ?>">
    	<div class="all-wrapper menu-side">
      		<div class="layout-w">