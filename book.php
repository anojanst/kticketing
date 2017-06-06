<?php
require_once 'conf/smarty-conf.php';
include 'functions/chat_functions.php';
include 'functions/booking_functions.php';
include 'functions/user_functions.php';

$module_no = 26;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'list') {
			unset ( $_SESSION ['search_booking_no'] );
			unset ( $_SESSION ['customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "Ticket Log Book" );
			$smarty->display ( 'booking/book.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			$_SESSION ['search_booking_no'] = $_POST ['booking_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "Ticket Log Book" );
			$smarty->display ( 'booking/book.tpl' );
		} else {
			$smarty->assign ( 'page', "Ticket Log Book" );
			$smarty->display ( 'booking/book.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Non Confirm Booking." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}