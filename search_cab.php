<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/cab_functions.php';

$module_no = 53;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "search_cab") {
			
			$smarty->assign ( 'page', "search_cab" );
			$smarty->display ( 'search_cab/search_cab.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['cab_booking_no'] = $_POST ['cab_booking_no'];
			$_SESSION ['name'] = $_POST ['name'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'cab_booking_no', $_SESSION ['cab_booking_no'] );
			$smarty->assign ( 'name', $_SESSION ['name'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "search_cab" );
			$smarty->display ( 'search_cab/search_cab.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "search_cab" );
			$smarty->display ( 'search_cab/search_cab.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to search cab Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}



