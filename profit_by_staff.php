<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/booking_functions.php';
include 'functions/receipt_functions.php';
include 'functions/voucher_functions.php';
include 'functions/invoice_functions.php';
include 'functions/profit_functions.php';

$module_no = 19;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "search") {
			
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "Proft By Staff" );
			$smarty->display ( 'profit_by_staff/profit_by_staff.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "profit_by_staff_print") {
			
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "profit_by_staff" );
			$smarty->display ( 'profit_by_staff_print/profit_by_staff_print.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "Proft By Staff" );
			$smarty->display ( 'profit_by_staff/profit_by_staff.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Proft Report" );
		$smarty->assign ( 'page', "Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}