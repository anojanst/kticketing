<?php
require_once 'conf/smarty-conf.php';
include 'functions/cash_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';
$module_no = 39;

if ($_SESSION ['login'] == 1) {
	
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "transfer_form") {
			
			$smarty->assign ( 'branches', branches () );
			$smarty->assign ( 'page', 'Cash transfer' );
			$smarty->display ( 'cash_transfer/cash_transfer.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save") {
			$date = $_POST ['date'];
			$amount = $_POST ['amount'];
			$saved_by = $_SESSION ['user_name'];
			
			$type = "IN";
			$detail = "TRANSFERED FROM $_SESSION[branch]";
			save_cash_flow ( $_POST ['branch'], $detail, $amount, $ref_no, $type, $date, $saved_by );
			
			$type = "OUT";
			$detail = "TRANSFERED TO $_POST[branch]";
			save_cash_flow ( $_SESSION ['branch'], $detail, $amount, $ref_no, $type, $date, $saved_by );
			
			$smarty->assign ( 'branches', branches () );
			$smarty->assign ( 'page', 'Cash transfer' );
			$smarty->display ( 'cash_transfer/cash_transfer.tpl' );
		} 

		else {
		}
	} 

	else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access cash transfer." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}