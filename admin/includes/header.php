<!DOCTYPE html>
<html>
	<head>	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">		
		<script type="text/javascript" src="<?php echo JS_URL?>jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_URL?>theme.js"></script>
		<script type="text/javascript" src="<?php echo JS_URL?>datatables.min.js"></script>	
		<link rel="shortcut icon" type="image/x-icon" href="<?= LOGO_URL?>logo2_4_02_01_21_7052.png " />
		<script type="text/javascript" src="<?php echo JS_URL?>parsley.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_URL?>bootstrap.bundle.min.js"></script>
	  <script type="text/javascript" src="<?php echo JS_URL?>bootstrap-datepicker1.js"></script>
		<script type="text/javascript" src="<?php echo JS_URL?>jquery-confirm.min.js"></script>  
    <!-- blockui-->
    <script type="text/javascript" src="<?php echo JS_URL?>jquery.blockUI.js"></script>
    <script src="<?php echo JS_URL?>jquery.timeago.js"></script>
    <!-- styling css -->
    <link rel="stylesheet" href="<?php echo CSS_URL?>bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="<?php echo CSS_URL?>datatables.min.css" >
    <link rel="stylesheet" href="<?php echo CSS_URL?>parsley.css" >		
    <link rel="stylesheet" href="<?php echo CSS_URL?>jquery-confirm.min.css">
    <link rel="stylesheet" href="<?php echo CSS_URL?>datepicker.css" >
    <link rel="stylesheet" href="<?php echo CSS_URL?>bootstrap_style.css" >
    <link rel="stylesheet" href="<?php echo CSS_URL?>animate.css"> 
    <title><?=$page=='index'?'Dashboard':$page;?></title>
<script type="text/javascript">
var scrollV, scrollH, loc = window.location;
  if ("pushState" in history)
        history.pushState("", document.title, loc.pathname + loc.search);
    else {
        // Prevent scrolling by storing the page's current scroll offset
        scrollV = document.body.scrollTop;
        scrollH = document.body.scrollLeft;
        loc.hash = "";
        // Restore the scroll offset, should be flicker free
        document.body.scrollTop = scrollV;
        document.body.scrollLeft = scrollH;
    }
   $(document).ready(function() {	
	 $(".timeago").timeago();      	
   });
</script>
	</head>