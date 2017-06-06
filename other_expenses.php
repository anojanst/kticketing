<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
include 'functions/other_expenses_functions.php';
include 'functions/chat_functions.php';
include 'functions/customer_functions.php';

$module_no = 24;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "other_expenses_form") {
			
			unset ( $_SESSION ['other_expenses_edit'] );
			unset ( $_SESSION ['other_expenses_no'] );
			
			$smarty->assign ( 'page', "other_expenses" );
			$smarty->display ( 'other_expenses/other_expenses.tpl' );
		}
		if ($_REQUEST ['job'] == "search_form") {
			unset ( $_SESSION ['other_expenses_no'] );
			unset ( $_SESSION ['search_other_expenses_no'] );
			unset ( $_SESSION ['search_customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "other_expenses" );
			$smarty->display ( 'other_expenses/other_expenses_list.tpl' );
		}
		if ($_REQUEST ['job'] == "search") {
			$_SESSION ['search_other_expenses_no'] = $_POST ['other_expenses_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "other_expenses" );
			$smarty->display ( 'other_expenses/other_expenses_list.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "add_other_expenses_description") {
			if (! isset ( $_SESSION ['other_expenses_no'] )) {
				$_SESSION ['other_expenses_no'] = get_other_expenses_no_from_description ();
			} else {
			}
			$other_expenses_no = $_SESSION ['other_expenses_no'];
			$_SESSION ['description'] = $description = $_POST ['description'];
			$_SESSION ['detail'] = $detail = $_POST ['detail'];
			$_SESSION ['amount'] = $amount = $_POST ['amount'];
			
			if ($_SESSION ['other_expenses_edit'] == 'true') {
				
				$other_expenses_info = get_other_expenses_info ( $other_expenses_no );
				
				$smarty->assign ( 'other_expenses_date', $other_expenses_info ['other_expenses_date'] );
				$smarty->assign ( 'customer', $other_expenses_info ['customer'] );
				$smarty->assign ( 'remarks', $other_expenses_info ['remarks'] );
				$smarty->assign ( 'on_behalf_of', $other_expenses_info ['on_behalf_of'] );
				$smarty->assign ( 'prepared_by', $other_expenses_info ['prepared_by'] );
				$smarty->assign ( 'total', get_other_expenses_total ( $other_expenses_no ) );
				$smarty->assign ( 'edit', 'true' );
			} else {
				$smarty->assign ( 'other_expenses_no', $other_expenses_no );
				$smarty->assign ( 'total', get_other_expenses_total ( $other_expenses_no ) );
			}
			
			if (check_other_expenses_paybill_status ( $other_expenses_no )) {
				
				$smarty->assign ( 'error_message', 'Notice : Please cancel Receipt to do any amendments' );
			} else {
				
				add_other_expenses_description ( $other_expenses_no, $description, $detail, $amount );
				add_description_ledger_other_expenses ( $other_expenses_no, $description, $amount );
			}
			
			$smarty->assign ( 'total', get_other_expenses_total ( $other_expenses_no ) );
			
			$smarty->assign ( 'other_expenses_no', $_SESSION ['other_expenses_no'] );
			$smarty->assign ( 'submit', 'true' );
			$smarty->assign ( 'page', "other_expenses" );
			$smarty->display ( 'other_expenses/other_expenses.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save") {
			if ($_REQUEST ['ok'] == 'Update') {
				
				$other_expenses_no = $_POST ['other_expenses_no'];
				$info = get_other_expenses_info ( $other_expenses_no );
				
				$other_expenses_date = $_POST ['other_expenses_date'];
				$customer = explode ( " | ", $_POST ['customer'] );
				$customer_id = $customer [1];
				$customer = $customer [0];
				$remarks = $_POST ['remarks'];
				$total = get_other_expenses_total ( $other_expenses_no );
				$due = $total;
				$ref_no = $_POST ['ref_no'];
				$ref_type = $_POST ['ref_type'];
				
				update_other_expenses ( $other_expenses_no, $other_expenses_date, $customer, $customer_id, $remarks, $total, $ref_no, $ref_type );
				update_other_expenses_ledger ( $info ['other_expenses_no'] );
				
				unset ( $_SESSION ['other_expenses_edit'] );
				$smarty->assign ( 'page', "other_expenses" );
				$smarty->display ( 'other_expenses/other_expenses.tpl' );
			} 

			else {
				$other_expenses_no = $_SESSION ['other_expenses_no'];
				$other_expenses_date = $_POST ['other_expenses_date'];
				$customer = explode ( " | ", $_POST ['customer'] );
				$customer_id = $customer [1];
				$customer = $customer [0];
				$remarks = $_POST ['remarks'];
				$saved_by = $_SESSION ['user_name'];
				$total = get_other_expenses_total ( $other_expenses_no );
				$due = $total;
				$ref_no = $_POST ['ref_no'];
				$ref_type = $_POST ['ref_type'];
				
				add_other_expenses ( $other_expenses_no, $other_expenses_date, $customer, $customer_id, $remarks, $saved_by, $total, $due, $ref_no, $ref_type );
				add_other_expenses_ledger ( $other_expenses_no );
				
				unset ( $_SESSION ['other_expenses_no'] );
				
				$smarty->assign ( 'notice_s', "other_expenses $other_expenses_no has been Saved." );
				$smarty->assign ( 'page', "other_expenses" );
				$smarty->display ( 'other_expenses/other_expenses.tpl' );
			}
		} elseif ($_REQUEST ['job'] == "edit") {
			
			if (check_other_expenses_receipt_status ( $_REQUEST ['other_expenses_no'] )) {
				
				$smarty->assign ( 'notice', 'Notice : Please cancel Receipt to do any amendments' );
				$smarty->assign ( 'page', 'other_expenses' );
				$smarty->display ( 'other_expenses/other_expenses.tpl' );
			} else {
				
				$other_expenses_no = $_REQUEST ['other_expenses_no'];
				$_SESSION ['other_expenses_no'] = $other_expenses_no;
				
				$other_expenses_info = get_other_expenses_info ( $other_expenses_no );
				
				$_SESSION ['hawb_no'] = $other_expenses_info ['hawb_no'];
				$_SESSION ['job_no'] = $other_expenses_info ['job_no'];
				
				$_SESSION ['other_expenses_edit'] = 'true';
				
				$smarty->assign ( 'other_expenses_no', $other_expenses_info ['other_expenses_no'] );
				$smarty->assign ( 'job_no', $other_expenses_info ['job_no'] );
				$smarty->assign ( 'other_expenses_date', $other_expenses_info ['other_expenses_date'] );
				$smarty->assign ( 'job_type', $other_expenses_info ['job_type'] );
				$smarty->assign ( 'hawb_no', $other_expenses_info ['hawb_no'] );
				$smarty->assign ( 'customer', $other_expenses_info ['customer'] );
				$smarty->assign ( 'remarks', $other_expenses_info ['remarks'] );
				$smarty->assign ( 'on_behalf_of', $other_expenses_info ['on_behalf_of'] );
				$smarty->assign ( 'prepared_by', $other_expenses_info ['prepared_by'] );
				$smarty->assign ( 'total', get_other_expenses_total ( $other_expenses_no ) );
				
				$smarty->assign ( 'edit', 'true' );
				
				$smarty->assign ( 'submit', 'true' );
				$smarty->assign ( 'submit_des', 'true' );
				$smarty->assign ( 'page', 'other_expenses' );
				$smarty->display ( 'other_expenses/other_expenses.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == "delete_description") {
			
			$other_expenses_no = $_SESSION ['other_expenses_no'];
			if (check_other_expenses_paybill_status ( $other_expenses_no )) {
				
				$smarty->assign ( 'notice', 'Notice : Please cancel Receipt to do any amendments' );
			} 

			else {
				
				if (last_description_other_expenses ( $other_expenses_no ) == 1) {
					delete_other_expenses ( $other_expenses_no );
					delete_other_expenses_ledger ( $other_expenses_no );
				} else {
					$smarty->assign ( 'submit', 'true' );
					$smarty->assign ( 'submit_des', 'true' );
				}
				
				delete_description ( $_REQUEST ['id'] );
				delete_other_expenses_description_ledger ( $_REQUEST ['id'] );
			}
			
			if ($_SESSION ['other_expenses_edit'] == 'true') {
				
				$other_expenses_info = get_other_expenses_info ( $other_expenses_no );
				
				$smarty->assign ( 'other_expenses_no', $other_expenses_no );
				$smarty->assign ( 'other_expenses_date', $other_expenses_info ['other_expenses_date'] );
				$smarty->assign ( 'customer', $other_expenses_info ['customer'] );
				$smarty->assign ( 'remarks', $other_expenses_info ['remarks'] );
				$smarty->assign ( 'on_behalf_of', $other_expenses_info ['on_behalf_of'] );
				$smarty->assign ( 'prepared_by', $other_expenses_info ['prepared_by'] );
				$smarty->assign ( 'total', get_other_expenses_total ( $other_expenses_no ) );
				$smarty->assign ( 'edit', 'true' );
			} 

			else {
				$smarty->assign ( 'other_expenses_no', $other_expenses_no );
				$smarty->assign ( 'total', get_other_expenses_total ( $other_expenses_no ) );
			}
			
			$smarty->assign ( 'page', 'other_expenses' );
			$smarty->display ( 'other_expenses/other_expenses.tpl' );
		} elseif ($_REQUEST ['job'] == "view") {
			$other_expenses_no = $_REQUEST ['other_expenses_no'];
			
			$_SESSION ['other_expenses_no_report'] = $other_expenses_no;
			$other_expenses_info = get_other_expenses_info ( $other_expenses_no );
			$customer_info = get_customer_info ( addslashes ( $other_expenses_info [customer] ) );
			
			$smarty->assign ( 'customer', $other_expenses_info [customer] );
			$smarty->assign ( 'customer_address', $customer_info [address] );
			$smarty->assign ( 'saved_by', $other_expenses_info [saved_by] );
			$smarty->assign ( 'other_expenses_date', $other_expenses_info [other_expenses_date] );
			$smarty->assign ( 'other_expenses_no', $other_expenses_info [other_expenses_no] );
			$smarty->assign ( 'total', number_format ( get_other_expenses_total ( $other_expenses_no ), 2 ) );
			$smarty->assign ( 'total_in_word', strtoupper ( num_to_rupee ( get_other_expenses_total ( $other_expenses_no ) ) ) );
			
			$smarty->display ( 'other_expenses/other_expenses_report.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "delete_other_expenses") {
			
			$other_expenses_no = $_REQUEST ['other_expenses_no'];
			
			$other_expenses_info = get_other_expenses_info ( $other_expenses_no );
			
			if (check_other_expenses_paybill_status ( $other_expenses_no )) {
				$smarty->assign ( 'error_message', 'Notice : Please cancel Receipt to do any amendments' );
			} else {
				delete_other_expenses ( $other_expenses_no );
				delete_other_expenses_description ( $_REQUEST ['other_expenses_no'] );
				delete_other_expenses_ledger ( $_REQUEST ['other_expenses_no'] );
				delete_all_other_expenses_description_ledger ( $_REQUEST ['other_expenses_no'] );
			}
			
			$smarty->assign ( 'page', 'other_expenses' );
			$smarty->display ( 'other_expenses/other_expenses_list.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "print") {
			$other_expenses_no = $_REQUEST ['other_expenses_no'];
			
			$_SESSION ['other_expenses_no_report'] = $other_expenses_no;
			$other_expenses_info = get_other_expenses_info ( $other_expenses_no );
			$customer_info = get_customer_info ( addslashes ( $other_expenses_info [customer] ) );
			
			$smarty->assign ( 'customer', $other_expenses_info [customer] );
			$smarty->assign ( 'customer_address', $customer_info [address] );
			$smarty->assign ( 'saved_by', $other_expenses_info [saved_by] );
			$smarty->assign ( 'other_expenses_date', $other_expenses_info [other_expenses_date] );
			$smarty->assign ( 'other_expenses_no', $other_expenses_info [other_expenses_no] );
			$smarty->assign ( 'total', number_format ( get_other_expenses_total ( $other_expenses_no ), 2 ) );
			$smarty->assign ( 'total_in_word', strtoupper ( num_to_rupee ( get_other_expenses_total ( $other_expenses_no ) ) ) );
			
			$smarty->display ( 'other_expenses/other_expenses_print.tpl' );
		} else {
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Other Expenses." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}