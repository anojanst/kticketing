<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/outstanding_functions.php';

$module_no = 50;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "outstanding_invoice") {
			
			$smarty->assign ( 'page', "cheque_inventory" );
			$smarty->display ( 'outstanding_invoice/outstanding_invoice.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'customer', $_SESSION ['customer'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "outstanding_invoice" );
			$smarty->display ( 'outstanding_invoice/outstanding_invoice.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "outstanding_invoice_print") {
			
			$smarty->assign ( 'customer', $_SESSION ['customer'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "outstanding_invoice" );
			$smarty->display ( 'outstanding_invoice_print/outstanding_invoice_print.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "outstanding_invoice" );
			$smarty->display ( 'outstanding_invoice/outstanding_invoice.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to outstanding invoice Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}


