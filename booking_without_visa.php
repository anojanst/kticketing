<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/outstanding_functions.php';

$module_no = 58;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "booking_without_visa") {
			
			$smarty->assign ( 'page', "booking_without_visa" );
			$smarty->display ( 'booking_without_visa/booking_without_visa.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['staff_name'] = $_POST ['staff_name'];

				
			$smarty->assign ( 'staff_name', $_SESSION ['staff_name'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "booking_without_visa" );
			$smarty->display ( 'booking_without_visa/booking_without_visa.tpl' );
		}
		
		elseif ($_REQUEST ['job'] == "booking_without_visa_print") {
				
			$smarty->assign ( 'staff_name', $_SESSION ['staff_name'] );
		
			$smarty->assign ( 'page', "booking_without_visa_print" );
			$smarty->display ( 'booking_without_visa_print/booking_without_visa_print.tpl' );
		}

		

		else {
			$smarty->assign ( 'page', "booking_without_visa" );
			$smarty->display ( 'booking_without_visa/booking_without_visa.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Booking Without Visa Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}



