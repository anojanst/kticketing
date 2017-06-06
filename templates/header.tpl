<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


<!------------------------------- Admin LTE CSS -->

    <link href="css/kendo.common.min.css" rel="stylesheet">
    <link href="css/kendo.default.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="css/AdminLTE.css">
<link rel="stylesheet" href="css/AdminLTE.min.css">

  <link rel="stylesheet" href="css/_all-skins.min.css">
  <link rel="stylesheet" href="css/blue.css">
  <link rel="stylesheet" href="css/morris.css">
  <link rel="stylesheet" href="css/jquery-jvectormap-1.2.2.css">
  <link rel="stylesheet" href="css/datepicker3.css">
  <link rel="stylesheet" href="css/daterangepicker.css">
  <link rel="stylesheet" href="css/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="css/dataTables.bootstrap.css">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" /> 
  <link rel="stylesheet" href="css/select2.min.css">
   <link rel="stylesheet" href="css/fileinput.css">
  <link rel="stylesheet" href="css/fileinput.min.css">
    <link rel="stylesheet" href="css/daterangepicker.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

<!------------------------------- Finish -->
<style type="text/css">

</style>
    <title>K-Ticketing | {$page} | {$user_name}</title>

    <!-- Bootstrap Core CSS -->
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
    <![endif]-->
    
    <link type="text/css" rel="stylesheet" media="all" href="css/chat.css" />
<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen" />
<link href="css/responsive-calendar.css" rel="stylesheet"/>
<script src="js/jquery.min.js"></script> 

<link type="text/css" rel="stylesheet" href="css/syntaxhighlighter/styles/shCoreDefault.min.css" />
    <link type="text/css" rel="stylesheet" href="css/syntaxhighlighter/styles/shThemejqPlot.min.css" />
    
    
    
    <script class="include" type="text/javascript" src="js/jquery.jqplot.min.js"></script>
    <script type="text/javascript" src="js/syntaxhighlighter/scripts/shCore.min.js"></script>
    <script type="text/javascript" src="js/syntaxhighlighter/scripts/shBrushJScript.min.js"></script>
    <script type="text/javascript" src="js/syntaxhighlighter/scripts/shBrushXml.min.js"></script>
    
    
    <script class="include" language="javascript" type="text/javascript" src="plugins/jqplot.barRenderer.min.js"></script>
    <script class="include" language="javascript" type="text/javascript" src="plugins/jqplot.categoryAxisRenderer.min.js"></script>
    <script class="include" language="javascript" type="text/javascript" src="plugins/jqplot.pointLabels.min.js"></script>



<link class="include" rel="stylesheet" type="text/css" href="css/jquery.jqplot.min.css" />
{literal}
    <script src="js/bootstrap.min.js"></script>
    <script src="js/responsive-calendar.js"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        $(".responsive-calendar").responsiveCalendar({
          events: {
            "2015-04-30": {"number": 5},
            "2015-04-26": {"number": 1}, 
            "2015-05-03":{"number": 1}, 
            "2015-06-12": {}}
        });
      });
    </script>
{/literal}

<!-- Metis Menu Plugin JavaScript -->

<script src="js/metisMenu.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/raphael-min.js"></script>
<script src="js/morris.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="js/sb-admin-2.js"></script>
<script type="text/javascript" src="js/chat.js"></script>
<script type="text/javascript" src="js/typeahead.js"></script> 

<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>

<style>
h1{
font-size: 14px;
color: #111;
}
.content{
	width: 100%;
	margin: 0 auto;
	margin-top: 50px;
}

.tt-hint {
	width: 100%;
 	border: 2px solid #CCCCCC;
    border-radius: 8px 8px 8px 8px;
    font-size: 14px;
    height: 45px;
    line-height: 30px;
    outline: medium none;
    padding: 8px 12px;
	visibility: hidden;
}

.tt-dropdown-menu {
  width: 100%;
  margin-top: 5px;
  padding: 8px 12px;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, 0.2);
  border-radius: 8px 8px 8px 8px;
  font-size: 14px;
  color: #111;
  background-color: #F1F1F1;
}
span.twitter-typeahead {
  width: 100%;
}
.input-group span.twitter-typeahead {
  display: block !important;
}
.input-group span.twitter-typeahead .tt-dropdown-menu {
  top: 32px !important;
}
.input-group.input-group-lg span.twitter-typeahead .tt-dropdown-menu {
  top: 44px !important;
}
.input-group.input-group-sm span.twitter-typeahead .tt-dropdown-menu {
  top: 28px !important;
}
</style>
</head>
<body oncut="return false">
<input type="hidden" name="user_name" value="{$user_name}" id="user_name"/>
<?php
session_start();
$_SESSION['username'] = $_SESSION['user_name'];
?>