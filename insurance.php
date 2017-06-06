<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/insurance_functions.php';
include 'functions/invoice_functions.php';
include 'functions/ledger_functions.php';
include 'functions/customer_functions.php';

$module_no = 21;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'insurance_form') {
			unset ( $_SESSION ['insurance_no'] );
			
			$smarty->assign ( 'page', "insurance" );
			$smarty->display ( 'insurance/insurance.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search_form') {
			
			$smarty->assign ( 'page', "insurance" );
			$smarty->display ( 'insurance/insurance_view.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search') {
			$_SESSION ['search_insurance_no'] = $_POST ['insurance_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			
			$smarty->assign ( 'page', "insurance" );
			$smarty->display ( 'insurance/insurance_view.tpl' );
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
			
			$_SESSION ['insurance_no'] = $insurance_no = get_insurance_no ();
			$_SESSION ['serial_no'] = $serial_no = get_serial_no ();
			$count = $_POST ['count'];
			$country = $_POST ['country'];
			$policy_no = $_POST ['policy_no'];
			$insurance_type = $_POST ['insurance_type'];
			$days = $_POST ['days'];
			$start_date = $_POST ['start_date'];
			$exp_date = $_POST ['exp_date'];
			$cost = $_POST ['cost'];
			$markup = $_POST ['markup'];
			$total = $_POST ['total'];
			$user_name = $_SESSION ['user_name'];
			$branch = $_SESSION ['branch'];
			$insurance_no = get_insurance_no ();
			$serial_no = get_serial_no ();
			
			save_insurance ( $insurance_no, $insurance_type, $serial_no, $country, $policy_no, $customer, $customer_id, $mobile, $count, $days, $start_date, $exp_date, $cost, $markup, $total, $user_name, $branch );
			generate_invoice_insurance ( $insurance_no );
			
			$smarty->assign ( 'page', "insurance" );
			$smarty->display ( 'insurance/insurance_view.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			$module_no = 105;
			if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
				$insurance_no = $_REQUEST ['insurance_no'];
				
				delete_insurance ( $insurance_no );
				delete_invoice_insurance ( $insurance_no );
				
				$smarty->assign ( 'page', "insurance" );
				$smarty->display ( 'insurance/insurance_view.tpl' );
			} else {
				$user_name = $_SESSION ['user_name'];
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to Delete insurance." );
				$smarty->assign ( 'page', "Access Error" );
				$smarty->display ( 'user_home/access_error.tpl' );
			}
		} else {
			$smarty->assign ( 'page', "insurance" );
			$smarty->display ( 'insurance/insurance.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access insurance." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}