<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
include 'functions/travels_functions.php';
include 'functions/refund_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/booking_functions.php';
include 'functions/other_expenses_functions.php';
include 'functions/voucher_functions.php';
include 'libs/class.phpmailer.php';

$module_no = 27;

if ($_SESSION ['login'] == 1) {
	
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "refund_form") {
			
			unset ( $_SESSION ['refund_edit'] );
			unset ( $_SESSION ['refund_no'] );
			
			$smarty->assign ( 'page', "refund_logbook" );
			$smarty->display ( 'refund_logbook/refund_logbook.tpl' );
		} elseif ($_REQUEST ['job'] == "search_form") {
			unset ( $_SESSION ['search_refund_no'] );
			unset ( $_SESSION ['search_customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "refund_logbook" );
			$smarty->display ( 'refund_logbook/refund_logbook.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['search_refund_no'] = $_POST ['refund_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "refund_logbook" );
			$smarty->display ( 'refund_logbook/refund_logbook.tpl' );
		} 


		elseif ($_REQUEST ['job'] == "view") {
			
			$refund_no = $_REQUEST ['refund_no'];
			$_SESSION ['refund_no'] = $refund_no;
			$refund_info = get_refund_info ( $refund_no );
			$_SESSION ['booking_no'] = $refund_info ['booking_no'];
			
			$smarty->assign ( 'page', 'refund_logbook' );
			$smarty->display ( 'refund_logbook/refund_logbook.tpl' );
		} 
		elseif ($_REQUEST ['job'] == "refund_logbook_print") {
		
			$smarty->assign ( 'customer', $_SESSION ['search_customer'] );
		
			$smarty->assign ( 'page', "refund_logbook_print" );
			$smarty->display ( 'refund_logbook_print/refund_logbook_print.tpl' );
		}
	
	
 else {
			$smarty->assign ( 'page', 'refund_logbook' );
			$smarty->display ( 'refund_logbook/refund_logbook.tpl' );
		}
	} else {
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to refund logbook" );
		$smarty->display ( 'user_home/access_error.tpl' );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}

