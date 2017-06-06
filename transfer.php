<?php
require_once 'conf/smarty-conf.php';
include 'functions/bank_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
$module_no = 28;

if ($_SESSION ['login'] == 1) {
	
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "transfer_form") {
			
			$_SESSION ['transfer_no'] = get_transfer_no ();
			
			$smarty->assign ( 'transfer_no', $_SESSION ['transfer_no'] );
			$smarty->assign ( 'page', 'Cash transfer' );
			$smarty->display ( 'transfer/transfer.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save") {
			$transfer_no = $_SESSION ['transfer_no'];
			$dep_no = get_dep_no ();
			$with_no = get_with_no ();
			
			$date = $_POST ['date'];
			$from_bank = $_POST ['from_bank'];
			$to_bank = $_POST ['to_bank'];
			$amount = $_POST ['amount'];
			$narration = $_POST ['narration'];
			$saved_by = $_SESSION ['user_name'];
			
			save_transfer ( $transfer_no, $dep_no, $with_no, $date, $from_bank, $to_bank, $amount, $narration, $saved_by );
			
			save_deposit ( $dep_no, $date, $to_bank, $amount, $narration, $saved_by );
			update_balance ( $to_bank, $amount );
			add_deposit_ledger ( $dep_no );
			
			save_withdraw ( $with_no, $date, $from_bank, $amount, $narration, $saved_by );
			add_withdraw_ledger ( $with_no );
			update_balance_withdraw ( $from_bank, $amount );
			
			$smarty->assign ( 'error_message', "Transfer $transfer_no has been Saved. DEPOSIT NO : $dep_no, WITHDRAW NO: $with_no" );
			
			$_SESSION ['transfer_no'] = get_transfer_no ();
			
			$smarty->assign ( 'page', 'Cash transfer' );
			$smarty->display ( 'transfer/transfer.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "delete") {
			delete_transfer ( $_REQUEST ['transfer_no'] );
			$info = get_transfer_info ( $_REQUEST ['transfer_no'] );
			
			delete_deposit ( $info ['dep_no'] );
			reupdate_balance ( $info ['dep_no'] );
			delete_deposit_ledger ( $info ['dep_no'] );
			
			delete_withdraw ( $info ['with_no'] );
			delete_withdraw_ledger ( $info ['with_no'] );
			reupdate_balance_withdraw ( $info ['with_no'] );
			
			$_SESSION ['transfer_no'] = get_transfer_no ();
			
			$smarty->assign ( 'page', 'Cash transfer' );
			$smarty->display ( 'transfer/transfer.tpl' );
		} 

		else {
		}
	} 

	else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access transfer." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}