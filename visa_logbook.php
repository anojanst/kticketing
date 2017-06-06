<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/visa_functions.php';
include 'functions/invoice_functions.php';
include 'functions/ledger_functions.php';
include 'functions/customer_functions.php';
include 'functions/booking_functions.php';

$module_no = 38;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'visa_form') {
			unset ( $_SESSION ['visa_no'] );
			
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa_logbook/visa_logbook.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search_form') {
			
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa_logbook/visa_logbook.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search') {
			$_SESSION ['search_visa_no'] = $_POST ['visa_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa_logbook/visa_logbook.tpl' );
		}
		
		elseif ($_REQUEST ['job'] == "visa_logbook_print") {
		
			$smarty->assign ( 'customer', $_SESSION ['search_customer'] );
		
			$smarty->assign ( 'page', "visa_logbook_print" );
			$smarty->display ( 'visa_logbook_print/visa_logbook_print.tpl' );
		}


		 else {
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa_logbook/visa_logbook.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Visa Log book." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}
