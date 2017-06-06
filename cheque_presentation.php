<?php
require_once 'conf/smarty-conf.php';
include 'functions/cheque_presentation_functions.php';
include 'functions/cheque_inventory_functions.php';
include 'functions/bank_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';

$module_id = 33;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_id, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "cheque_presentation_select_form") {
			unset ( $_SESSION ['presentation_date'] );
			
			$smarty->assign ( 'page', 'Cheque Presentation' );
			$smarty->display ( 'cheque_presentation/cheque_presentation_select.tpl' );
		} elseif ($_REQUEST ['job'] == "set_date") {
			$_SESSION ['presentation_date'] = $_REQUEST ['presentation_date'];
			$_SESSION ['account'] = $_REQUEST ['account'];
			
			$smarty->assign ( 'presentation_date', $_SESSION ['presentation_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Presentation' );
			$smarty->display ( 'cheque_presentation/cheque_presentation.tpl' );
		} elseif ($_REQUEST ['job'] == "inquiry") {
			$_SESSION ['che_no'] = $_REQUEST ['che_no'];
			
			$smarty->assign ( 'che_no', $_SESSION ['che_no'] );
			$smarty->assign ( 'presentation_date', $_SESSION ['presentation_date'] );
			list_specify_paybill_cheque ( $_SESSION [presentation_date], $_SESSION [che_no] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
		} elseif ($_REQUEST ['job'] == "present_cheque") {
			present_paybill_cheque ( $_REQUEST ['id'], $_SESSION ['presentation_date'], $_SESSION ['account'] );
			$info = get_cheque_info_id ( $_REQUEST ['id'] );
			reupdate_balance_from_reconciliation ( $info ['dep_account_no'], $info ['che_amount'] );
			
			$smarty->assign ( 'presentation_date', $_SESSION ['presentation_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Presentation' );
			$smarty->display ( 'cheque_presentation/cheque_presentation.tpl' );
		} elseif ($_REQUEST ['job'] == "unpresented_cheque") {
			$info = get_cheque_info_id ( $_REQUEST ['id'] );
			update_balance ( $info ['dep_account_no'], $info ['che_amount'] );
			unpresented_paybill_cheque ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'presentation_date', $_SESSION ['presentation_date'] );
			$smarty->assign ( 'account', $_SESSION ['account'] );
			$smarty->assign ( 'page', 'Cheque Presentation' );
			$smarty->display ( 'cheque_presentation/cheque_presentation.tpl' );
		} else {
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Cheque Presentation." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}