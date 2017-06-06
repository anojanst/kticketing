<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/flight_date_functions.php';


$module_no = 64;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "flight_date") {
			
			$smarty->assign ( 'page', "flight_date" );
			$smarty->display ( 'flight_date/flight_date.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['date'] = $_POST ['date'];
	
			
			$smarty->assign ( 'date', $_SESSION ['date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "flight_date" );
			$smarty->display ( 'flight_date/flight_date.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "flight_date" );
			$smarty->display ( 'flight_date/flight_date.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to customer Flight Date Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}


