<?php
require_once 'conf/smarty-conf.php';
include 'functions/bank_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
include 'functions/cash_functions.php';

$module_id = 29;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_id, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "withdraw_form") {
			
			$_SESSION ['with_no'] = get_with_no ();
			$smarty->assign ( 'with_no', $_SESSION ['with_no'] );
			$smarty->assign ( 'page', 'Withdrawal' );
			$smarty->display ( 'withdraw/withdraw.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save") {
			
			$with_no = $_SESSION ['with_no'];
			$date = $_POST ['date'];
			$account = $_POST ['account'];
			$amount = $_POST ['amount'];
			$narration = $_POST ['narration'];
			$saved_by = $_SESSION ['user_name'];
			
			save_withdraw ( $with_no, $date, $account, $amount, $narration, $saved_by );
			add_withdraw_ledger ( $with_no );
			update_balance_withdraw ( $account, $amount );
			
			$detail = "WITHDRAWED FROM BANK";
			$ref_no = $with_no;
			$type = "IN";
			$branch = $_SESSION ['branch'];
			$time = date ( 'Y-m-d H:i:s' );
			save_cash_flow ( $branch, $detail, $amount, $ref_no, $type, $date, $saved_by );
			
			$smarty->assign ( 'error_message', "Withdrawal $with_no has been Saved." );
			$smarty->assign ( 'page', 'Withdrawal' );
			$smarty->display ( 'withdraw/withdraw.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "delete") {
			$with_info = get_withdraw_info ( $_REQUEST ['with_no'] );
			$amount = $with_info ['amount'];
			
			$detail = "WITHDRAWED FROM BANK";
			$ref_no = $_REQUEST ['with_no'];
			$type = "OUT";
			$branch = $_SESSION ['branch'];
			$time = date ( 'Y-m-d H:i:s' );
			
			delete_cash_flow ( $branch, $detail, $ref_no );
			
			delete_withdraw ( $_REQUEST ['with_no'] );
			delete_withdraw_ledger ( $_REQUEST ['with_no'] );
			reupdate_balance_withdraw ( $_REQUEST ['with_no'] );
			
			$smarty->assign ( 'page', 'Withdrawal' );
			$smarty->display ( 'withdraw/withdraw.tpl' );
		} else {
		}
	} 

	else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Withdraw." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}