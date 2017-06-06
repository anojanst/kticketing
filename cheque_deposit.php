<?php
require_once 'conf/smarty-conf.php';
include 'functions/cheque_deposit_functions.php';
include 'functions/bank_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
$module_id = 32;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_id, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "cheque_deposit_select_form") {
			unset ( $_SESSION ['deposit_date'] );
			
			$smarty->assign ( 'page', 'Cheque Deposit' );
			$smarty->display ( 'cheque_deposit/cheque_deposit_select.tpl' );
		} elseif ($_REQUEST ['job'] == "set_date") {
			$_SESSION ['deposit_date'] = $_REQUEST ['deposit_date'];
			$_SESSION ['account'] = $_REQUEST ['account'];
			
			$smarty->assign ( 'deposit_date', $_SESSION ['deposit_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Deposit' );
			$smarty->display ( 'cheque_deposit/cheque_deposit.tpl' );
		} elseif ($_REQUEST ['job'] == "inquiry") {
			$_SESSION ['che_no'] = $_REQUEST ['che_no'];
			
			$smarty->assign ( 'che_no', $_SESSION ['che_no'] );
			$smarty->assign ( 'deposit_date', $_SESSION ['deposit_date'] );
			list_specify_cheque ( $_SESSION [deposit_date], $_SESSION [che_no] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
		} elseif ($_REQUEST ['job'] == "deposit_cheque") {
			deposit_receipt_cheque ( $_REQUEST ['id'], $_SESSION ['deposit_date'], $_SESSION ['account'] );
			
			$smarty->assign ( 'deposit_date', $_SESSION ['deposit_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Deposit' );
			$smarty->display ( 'cheque_deposit/cheque_deposit.tpl' );
		} elseif ($_REQUEST ['job'] == "remove_receipt") {
			remove_receipt ( $_REQUEST ['id'] );
			delete_cheque_deposit_ledger ( $id );
			
			$smarty->assign ( 'deposit_date', $_SESSION ['deposit_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Deposit' );
			$smarty->display ( 'cheque_deposit/cheque_deposit.tpl' );
		} else {
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Cheque Deposit." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}
