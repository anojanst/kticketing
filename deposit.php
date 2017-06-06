<?php
require_once 'conf/smarty-conf.php';
include 'functions/bank_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
include 'functions/cash_functions.php';
$module_no = 28;

if ($_SESSION ['login'] == 1) {
	
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "deposit_form") {
			
			$_SESSION ['dep_no'] = get_dep_no ();
			
			$smarty->assign ( 'dep_no', $_SESSION ['dep_no'] );
			$smarty->assign ( 'page', 'Cash Deposit' );
			$smarty->display ( 'deposit/deposit.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save") {
			$dep_no = $_SESSION ['dep_no'];
			$date = $_POST ['date'];
			$account = $_POST ['account'];
			$amount = $_POST ['amount'];
			$narration = $_POST ['narration'];
			$saved_by = $_SESSION ['user_name'];
			
			save_deposit ( $dep_no, $date, $account, $amount, $narration, $saved_by );
			update_balance ( $account, $amount );
			add_deposit_ledger ( $dep_no );
			
			$detail = "DEPOSITED TO BANK";
			$ref_no = $dep_no;
			$type = "OUT";
			$branch = $_SESSION ['branch'];
			$time = date ( 'Y-m-d H:i:s' );
			save_cash_flow ( $branch, $detail, $amount, $ref_no, $type, $date, $saved_by );
			
			$smarty->assign ( 'error_message', "Cash deposit $dep_no has been Saved." );
			
			$_SESSION ['dep_no'] = get_dep_no ();
			
			$smarty->assign ( 'page', 'Cash Deposit' );
			$smarty->display ( 'deposit/deposit.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "delete") {
			$dep_info = get_deposit_info ( $_REQUEST ['dep_no'] );
			$amount = $dep_info ['amount'];
			
			$detail = "DEPOSITED TO BANK";
			$ref_no = $_REQUEST ['dep_no'];
			$type = "IN";
			$branch = $_SESSION ['branch'];
			$time = date ( 'Y-m-d H:i:s' );
			
			delete_cash_flow ( $branch, $detail, $ref_no );
			
			delete_deposit ( $_REQUEST ['dep_no'] );
			reupdate_balance ( $_REQUEST ['dep_no'] );
			delete_deposit_ledger ( $_REQUEST ['dep_no'] );
			
			$_SESSION ['dep_no'] = get_dep_no ();
			
			$smarty->assign ( 'page', 'Cash Deposit' );
			$smarty->display ( 'deposit/deposit.tpl' );
		} 

		else {
		}
	} 

	else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Deposit." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}