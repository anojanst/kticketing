<?php
require_once 'conf/smarty-conf.php';
include 'functions/chat_functions.php';
include 'functions/booking_functions.php';
include 'functions/user_functions.php';
include 'functions/cash_functions.php';

$module_no = 41;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'list_all_non_confirm_form') {
			unset ( $_SESSION ['search_branch'] );
			unset ( $_SESSION ['search_user_name'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'branches', branches () );
			$smarty->assign ( 'page', "Non Confirm Bookings" );
			$smarty->display ( 'booking/all_non_confirm.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			$_SESSION ['search_branch'] = $_POST ['branch'];
			$_SESSION ['search_user_name'] = $_POST ['user_name'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'branches', branches () );
			$smarty->assign ( 'page', "Non Confirm Bookings" );
			$smarty->display ( 'booking/all_non_confirm.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "all_non_confirm_print") {
			
			$smarty->assign ( 'branches', branches () );
			$smarty->assign ( 'user_name', $_SESSION ['user_name'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "all_non_confirm" );
			$smarty->display ( 'all_non_confirm_print/all_non_confirm_print.tpl' );
		} 

		else {
			unset ( $_SESSION ['search_branch'] );
			unset ( $_SESSION ['search_user_name'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'branches', branches () );
			$smarty->assign ( 'page', "Non Confirm Bookings" );
			$smarty->display ( 'booking/all_non_confirm.tpl' );
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