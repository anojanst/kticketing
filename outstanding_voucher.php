<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/outstanding_functions.php';

$module_no = 52;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "outstanding_voucher") {
			
			$smarty->assign ( 'page', "outstanding_voucher" );
			$smarty->display ( 'outstanding_voucher/outstanding_voucher.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['travels'] = $_POST ['travels'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'travels', $_SESSION ['travels'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "outstanding_voucher" );
			$smarty->display ( 'outstanding_voucher/outstanding_voucher.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "outstanding_voucher_print") {
			
			$smarty->assign ( 'travels', $_SESSION ['travels'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "outstanding_voucher_print" );
			$smarty->display ( 'outstanding_voucher_print/outstanding_voucher_print.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "outstanding_voucher" );
			$smarty->display ( 'outstanding_voucher/outstanding_voucher.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to outstanding voucher Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}


