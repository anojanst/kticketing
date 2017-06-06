<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/visa_functions.php';
include 'functions/invoice_functions.php';
include 'functions/ledger_functions.php';
include 'functions/customer_functions.php';

$module_no = 38;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'visa_form') {
			unset ( $_SESSION ['visa_no'] );
			
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa/visa.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search_form') {
			
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa/visa_view.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search') {
			$_SESSION ['search_visa_no'] = $_POST ['visa_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa/visa_view.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search_edit') {
			
			$visa_info = get_visa_info_by_visa_no ( $_POST ['search'] );
			if (! $visa_info ['total']) {
				$_SESSION ['visa_no'] = $_POST ['search'];
				$visa_no = $_SESSION ['visa_no'];
				
				$_SESSION ['passenger_total'] = $visa_info ['count'];
				$passenger_count = get_passenger_counts ( $visa_no );
				
				$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
				$smarty->assign ( 'passenger_total_updated', $passenger_count );
				
				$smarty->assign ( 'search', "On" );
				$smarty->assign ( 'passenger', "on" );
				$smarty->assign ( 'page', "visa" );
				$smarty->display ( 'visa/visa.tpl' );
			} else {
				$smarty->assign ( 'page', "visa" );
				$smarty->display ( 'visa/visa_preview.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == 'save') {
			$customers = explode ( " | ", $_POST ['customer'] );
			$customer = $customers [0];
			$mobile = $_POST ['mobile'];
			if ($customers [1]) {
				$customer_id = $customers [1];
			} else {
				$customer_id = get_customer_id ();
				save_customer ( $customer, $salute, $customer_id, $first_name, $last_name, $sex, $nationality, $dob, $address, $telephone, $mobile, $email, $passport_no, $passport, $issued_date, $expire_date );
			}
			
			$_SESSION ['visa_no'] = $visa_no = get_visa_no ();
			$_SESSION ['serial_no'] = $serial_no = get_serial_number ();
			
			$country = $_POST ['country'];
			$count = $_POST ['count'];
			$visa_type = $_POST ['visa_type'];
			$days = $_POST ['days'];
			$user_name = $_SESSION ['user_name'];
			$branch = $_SESSION ['branch'];
			$visa_no = get_visa_no ();
			$serial_no = get_serial_number ();
			
			save_visa ( $visa_no, $visa_type, $serial_no, $country, $customer, $customer_id, $mobile, $count, $days, $user_name, $branch );
			
			$_SESSION ['passenger_total'] = $count;
			$passenger_count = get_passenger_counts ( $visa_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'passenger', "on" );
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa/visa.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'finish') {
			
			$cost = $_POST ['cost'];
			$markup = $_POST ['markup'];
			$total = $_POST ['total'];
			$visa_no = $_SESSION ['visa_no'];
			
			complete_visa ( $visa_no, $cost, $markup, $total );
			generate_invoice_visa ( $visa_no );
			
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa/visa_preview.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add_passenger') {
			$visa_no = $_SESSION ['visa_no'];
			$passport_no = $_POST ['passport_no'];
			
			if ((check_repetive_passport_number ( $visa_no, $passport_no )) == 1) {
				$smarty->assign ( 'error_message', "Dear $user_name, you cant add repetive passport no." );
			} else {
				if ($passport_no) {
					add_passenger_to_visa ( $visa_no, $passport_no );
				}
			}
			$passenger_count = get_passenger_counts ( $visa_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'passenger', "on" );
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa/visa.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete_passenger') {
			$id = $_REQUEST ['id'];
			
			delete_passengers ( $id );
			
			$passenger_count = get_passenger_counts ( $_SESSION [visa_no] );
			echo $passenger_count;
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'passenger', "on" );
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa/visa.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			$module_no = 104;
			if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
				$visa_no = $_REQUEST ['visa_no'];
				
				delete_visa ( $visa_no );
				delete_invoice_visa ( $visa_no );
				
				$smarty->assign ( 'page', "VISA" );
				$smarty->display ( 'visa/visa_view.tpl' );
			} else {
				$user_name = $_SESSION ['user_name'];
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to Delete Visa." );
				$smarty->assign ( 'page', "Access Error" );
				$smarty->display ( 'user_home/access_error.tpl' );
			}
		} else {
			$smarty->assign ( 'page', "VISA" );
			$smarty->display ( 'visa/visa.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Visa." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}