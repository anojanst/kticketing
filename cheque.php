<?php
require_once 'conf/smarty-conf.php';
include 'functions/cheque_inventory_functions.php';
include 'functions/bank_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
$module_id = 31;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_id, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "cheque_select_form") {
			unset ( $_SESSION ['statement_date'] );
			
			$smarty->assign ( 'page', 'Cheque Reconciliation' );
			$smarty->display ( 'cheque/cheque_select.tpl' );
		} elseif ($_REQUEST ['job'] == "set_date") {
			$_SESSION ['statement_date'] = $_REQUEST ['statement_date'];
			$_SESSION ['account'] = $_REQUEST ['account'];
			
			$smarty->assign ( 'statement_date', $_SESSION ['statement_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Reconciliation' );
			$smarty->display ( 'cheque/cheque.tpl' );
		} elseif ($_REQUEST ['job'] == "inquiry") {
			$_SESSION ['che_no'] = $_REQUEST ['che_no'];
			
			$smarty->assign ( 'che_no', $_SESSION ['che_no'] );
			$smarty->assign ( 'statement_date', $_SESSION ['statement_date'] );
			list_specify_cheque ( $_SESSION [statement_date], $_SESSION [che_no] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
		} elseif ($_REQUEST ['job'] == "realise_cheque") {
			
			if ($_REQUEST ['ok'] == 'REALISE') {
				realise_cheque ( $_REQUEST ['id'], $_SESSION ['statement_date'] );
				$info = get_cheque_info_id ( $_REQUEST ['id'] );
				update_balance ( $info ['dep_account_no'], $info ['che_amount'] );
			} elseif ($_REQUEST ['ok'] == 'RETURN') {
				return_cheque ( $_REQUEST ['id'], $_SESSION ['statement_date'] );
			}
			$smarty->assign ( 'statement_date', $_SESSION ['statement_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Reconciliation' );
			$smarty->display ( 'cheque/cheque.tpl' );
		} elseif ($_REQUEST ['job'] == "cancel_return_cheque") {
			cancel_return_cheque ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'statement_date', $_SESSION ['statement_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Reconciliation' );
			$smarty->display ( 'cheque/cheque.tpl' );
		} elseif ($_REQUEST ['job'] == "cancel_realised_cheque") {
			cancel_realised_cheque ( $_REQUEST ['id'] );
			$info = get_cheque_info_id ( $_REQUEST ['id'] );
			reupdate_balance_from_reconciliation ( $info ['dep_account_no'], $info ['che_amount'] );
			
			$smarty->assign ( 'statement_date', $_SESSION ['statement_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Reconciliation' );
			$smarty->display ( 'cheque/cheque.tpl' );
		} else {
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Cheque Reconciliation." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}