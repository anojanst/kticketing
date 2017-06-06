<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/booking_functions.php';
include 'functions/invoice_functions.php';
include 'functions/ledger_functions.php';
include 'functions/customer_functions.php';
include 'functions/offer_functions.php';

$module_no = 36;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'ticket') {
			unset ( $_SESSION ['booking_no'] );
			
			$smarty->assign ( 'page', "Ticket Number" );
			$smarty->display ( 'booking/ticket_number.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'list_passenger') {
			
			$_SESSION ['booking_no'] = $booking_no = $_REQUEST ['booking_no'];
			
			$booking_info = get_booking_info_by_booking_no ( $booking_no );
			
			if ($booking_info ['status'] == 1) {
				$smarty->assign ( 'booking_no', "$booking_no" );
			}
			
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/ticket_number.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add_ticket_no') {
			$_SESSION ['booking_no'] = $booking_no = $_REQUEST ['booking_no'];
			$ticket_no = $_POST ['ticket_no'];
			$passport_no = $_REQUEST ['passport_no'];
			
			add_ticket_number ( $booking_no, $passport_no, $ticket_no );
			
			$smarty->assign ( 'booking_no', "$booking_no" );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/ticket_number.tpl' );
		} 

		else {
			unset ( $_SESSION ['booking_no'] );
			
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/ticket_number.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Ticket numbers." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}