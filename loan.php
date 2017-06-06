<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/loan_functions.php';
include 'functions/other_expenses_functions.php';
include 'functions/ledger_functions.php';
include 'functions/customer_functions.php';
include 'functions/embassy_functions.php';

$module_no = 34;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'loan_form') {
			unset ( $_SESSION ['loan_no'] );
			
			generate_other_expenses_for_interest ();
			
			$smarty->assign ( 'page', "loan" );
			$smarty->display ( 'loan/loan.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'save') {
			if (! isset ( $_SESSION ['loan_no'] )) {
				$_SESSION ['loan_no'] = $loan_no = get_loan_no ();
				$_SESSION ['serial_no'] = $serial_no = get_serial_no ();
			} else {
			}
			
			$loan_amount = $_POST ['loan_amount'];
			$interest = $_POST ['interest'];
			$interest_date = $_POST ['interest_date'];
			
			$customers = explode ( " | ", $_POST ['customer'] );
			$customer = $customers [0];
			$mobile = $_POST ['mobile'];
			$loan_no = $_SESSION ['loan_no'];
			$serial_no = $_SESSION ['serial_no'];
			$user_name = $_SESSION ['user_name'];
			$branch = $_SESSION ['branch'];
			$type = $_POST ['type'];
			
			if ($customers [1]) {
				$customer_id = $customers [1];
			} else {
				$customer_id = get_customer_id ();
				save_customer ( $customer, $salute, $customer_id, $first_name, $last_name, $sex, $nationality, $dob, $address, $telephone, $mobile, $email, $passport_no, $passport, $issued_date, $expire_date );
			}
			
			save_loan ( $loan_no, $serial_no, $loan_amount, $interest, $type, $customer, $customer_id, $interest_date, $user_name, $branch );
			generate_other_expenses_loan ( $loan_no );
			
			$smarty->assign ( 'page', "loan" );
			$smarty->display ( 'loan/loan.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "loan" );
			$smarty->display ( 'loan/loan.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Loan." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}