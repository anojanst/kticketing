<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/report_functions.php';

$module_no = 49;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "cheque_inventory") {
			
			$smarty->assign ( 'page', "cheque_inventory" );
			$smarty->display ( 'cheque_inventory/cheque_inventory.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'list') {
			$_SESSION ['status'] = $_POST ['status'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'status', $_SESSION ['status'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "cheque_inventory" );
			$smarty->display ( 'cheque_inventory/cheque_inventory.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "cheque_inventory_print") {
			
			$smarty->assign ( 'status', $_SESSION ['status'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "cheque_inventory" );
			$smarty->display ( 'cheque_inventory_print/cheque_inventory_print.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "cheque_inventory" );
			$smarty->display ( 'cheque_inventory/cheque_inventory.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to cheque inventory Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}

