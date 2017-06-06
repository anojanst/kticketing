<?php
require_once 'conf/smarty-conf.php';
include 'functions/chat_functions.php';
include 'functions/booking_functions.php';
include 'functions/user_functions.php';

$module_no = 14;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'list_non_confirm_form') {
			$smarty->assign ( 'page', "Non Confirm Bookings" );
			$smarty->display ( 'booking/non_confirm.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			$_SESSION ['search_booking_no'] = $_POST ['booking_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "Non Confirm Bookings" );
			$smarty->display ( 'booking/non_confirm.tpl' );
		} else {
			$smarty->assign ( 'page', "Non Confirm Bookings" );
			$smarty->display ( 'booking/non_confirm.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Non Confirm Booking." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}