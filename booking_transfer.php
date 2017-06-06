<?php
require_once 'conf/smarty-conf.php';
include 'functions/chat_functions.php';
include 'functions/booking_functions.php';
include 'functions/user_functions.php';
include 'functions/invoice_functions.php';
include 'functions/ledger_functions.php';

$module_no = 35;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'transfer') {
			unset ( $_SESSION ['search_booking_no'] );
			unset ( $_SESSION ['search_customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "Transfer Bookings" );
			$smarty->display ( 'booking/transfer.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			$_SESSION ['search_booking_no'] = $_POST ['booking_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "Transfer Bookings" );
			$smarty->display ( 'booking/transfer.tpl' );
		} elseif ($_REQUEST ['job'] == 'transfer_booking') {
			$booking_no = $_REQUEST ['booking_no'];
			$to_user = $_POST ['to_user'];
			
			$user_info = get_user_info ( $to_user );
			$branch = $user_info ['branch'];
			
			$invoice_info = get_invoice_info_by_booking_no ( $booking_no );
			$invoice_no = $invoice_info ['invoice_no'];
			
			transfer_booking_to ( $to_user, $booking_no, $branch );
			transfer_invoice_to ( $to_user, $invoice_no, $branch );
			transfer_ledger_to ( $to_user, $invoice_no, $branch );
			
			unset ( $_SESSION ['search_booking_no'] );
			unset ( $_SESSION ['search_customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "Transfer Bookings" );
			$smarty->display ( 'booking/transfer.tpl' );
		} else {
			$smarty->assign ( 'page', "Transfer Bookings" );
			$smarty->display ( 'booking/transfer.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Transfer Booking." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}