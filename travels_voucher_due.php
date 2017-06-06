<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/outstanding_functions.php';
include 'functions/customer_functions.php';

$module_no = 50;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "travels_voucher_due") {
			
			$smarty->assign ( 'page', "travels_voucher_due" );
			$smarty->display ( 'travels_voucher_due/travels_voucher_due.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "travels_voucher_due" );
			$smarty->display ( 'travels_voucher_due/travels_voucher_due.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "travels_voucher_due_print") {
			
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "travels_voucher_due_print" );
			$smarty->display ( 'travels_voucher_due_print/travels_voucher_due_print.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "travels_voucher_due" );
			$smarty->display ( 'travels_voucher_due/travels_voucher_due.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to travels voucher due Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}

