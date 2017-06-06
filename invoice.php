<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
include 'functions/invoice_functions.php';
include 'functions/chat_functions.php';
include 'functions/customer_functions.php';

$module_no = 23;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "invoice_form") {
			
			unset ( $_SESSION ['invoice_edit'] );
			unset ( $_SESSION ['invoice_no'] );
			
			$smarty->assign ( 'page', "Invoice" );
			$smarty->display ( 'invoice/invoice.tpl' );
		} elseif ($_REQUEST ['job'] == "search_form") {
			unset ( $_SESSION ['invoice_no'] );
			unset ( $_SESSION ['search_invoice_no'] );
			unset ( $_SESSION ['search_customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "Invoice" );
			$smarty->display ( 'invoice/invoice_list.tpl' );
		} elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['search_invoice_no'] = $_POST ['invoice_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "Invoice" );
			$smarty->display ( 'invoice/invoice_list.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "add_invoice_description") {
			if (! isset ( $_SESSION ['invoice_no'] )) {
				$_SESSION ['invoice_no'] = get_invoice_no_from_description ();
			} else {
			}
			$invoice_no = $_SESSION ['invoice_no'];
			$_SESSION ['description'] = $description = $_POST ['description'];
			$_SESSION ['detail'] = $detail = $_POST ['detail'];
			$_SESSION ['amount'] = $amount = $_POST ['amount'];
			
			if ($_SESSION ['invoice_edit'] == 'true') {
				
				$invoice_info = get_invoice_info ( $invoice_no );
				
				$smarty->assign ( 'invoice_date', $invoice_info ['invoice_date'] );
				$smarty->assign ( 'ref_no', $invoice_info ['ref_no'] );
				$smarty->assign ( 'ref_type', $invoice_info ['ref_type'] );
				$smarty->assign ( 'customer', $invoice_info ['customer'] );
				$smarty->assign ( 'remarks', $invoice_info ['remarks'] );
				$smarty->assign ( 'on_behalf_of', $invoice_info ['on_behalf_of'] );
				$smarty->assign ( 'prepared_by', $invoice_info ['prepared_by'] );
				$smarty->assign ( 'total', get_invoice_total ( $invoice_no ) );
				$smarty->assign ( 'edit', 'true' );
			} else {
				$smarty->assign ( 'invoice_no', $invoice_no );
				$smarty->assign ( 'total', get_invoice_total ( $invoice_no ) );
			}
			
			if (check_invoice_receipt_status ( $invoice_no )) {
				
				$smarty->assign ( 'error_message', 'Notice : Please cancel Receipt to do any amendments' );
			} else {
				
				add_invoice_description ( $invoice_no, $description, $detail, $amount );
				add_description_ledger ( $invoice_no, $description, $amount );
			}
			
			$smarty->assign ( 'total', get_invoice_total ( $invoice_no ) );
			
			$smarty->assign ( 'invoice_no', $_SESSION ['invoice_no'] );
			$smarty->assign ( 'submit', 'true' );
			$smarty->assign ( 'page', "Invoice" );
			$smarty->display ( 'invoice/invoice.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save") {
			if ($_REQUEST ['ok'] == 'Update') {
				
				$invoice_no = $_POST ['invoice_no'];
				$info = get_invoice_info ( $invoice_no );
				
				$invoice_date = $_POST ['invoice_date'];
				$customer = explode ( " | ", $_POST ['customer'] );
				$customer_id = $customer [1];
				$customer = $customer [0];
				$remarks = $_POST ['remarks'];
				$ref_no = $_POST ['ref_no'];
				$ref_type = $_POST ['ref_type'];
				$total = get_invoice_total ( $invoice_no );
				$due = $total;
				
				update_invoice ( $invoice_no, $invoice_date, $customer, $remarks, $total, $ref_no, $ref_type );
				update_invoice_ledger ( $info ['invoice_no'] );
				
				unset ( $_SESSION ['invoice_edit'] );
				$smarty->assign ( 'page', "Invoice" );
				$smarty->display ( 'invoice/invoice.tpl' );
			} 

			else {
				$invoice_no = $_SESSION ['invoice_no'];
				$invoice_date = $_POST ['invoice_date'];
				$customer = explode ( " | ", $_POST ['customer'] );
				$customer_id = $customer [1];
				$customer = $customer [0];
				$remarks = $_POST ['remarks'];
				$saved_by = $_SESSION ['user_name'];
				$total = get_invoice_total ( $invoice_no );
				$due = $total;
				$ref_no = $_POST ['ref_no'];
				$ref_type = $_POST ['ref_type'];
				
				add_invoice ( $invoice_no, $invoice_date, $customer, $customer_id, $remarks, $saved_by, $total, $due, $ref_no, $ref_type );
				add_invoice_ledger ( $invoice_no );
				
				unset ( $_SESSION ['invoice_no'] );
				
				$smarty->assign ( 'notice_s', "Invoice $invoice_no has been Saved." );
				$smarty->assign ( 'page', "Invoice" );
				$smarty->display ( 'invoice/invoice.tpl' );
			}
		} elseif ($_REQUEST ['job'] == "edit") {
			
			if (check_invoice_receipt_status ( $_REQUEST ['invoice_no'] )) {
				
				$smarty->assign ( 'notice', 'Notice : Please cancel Receipt to do any amendments' );
				$smarty->assign ( 'page', 'Invoice' );
				$smarty->display ( 'invoice/invoice.tpl' );
			} else {
				
				$invoice_no = $_REQUEST ['invoice_no'];
				$_SESSION ['invoice_no'] = $invoice_no;
				
				$invoice_info = get_invoice_info ( $invoice_no );
				
				$_SESSION ['hawb_no'] = $invoice_info ['hawb_no'];
				$_SESSION ['job_no'] = $invoice_info ['job_no'];
				
				$_SESSION ['invoice_edit'] = 'true';
				
				$smarty->assign ( 'invoice_date', $invoice_info ['invoice_date'] );
				$smarty->assign ( 'ref_no', $invoice_info ['ref_no'] );
				$smarty->assign ( 'ref_type', $invoice_info ['ref_type'] );
				$smarty->assign ( 'customer', $invoice_info ['customer'] );
				$smarty->assign ( 'remarks', $invoice_info ['remarks'] );
				$smarty->assign ( 'on_behalf_of', $invoice_info ['on_behalf_of'] );
				$smarty->assign ( 'prepared_by', $invoice_info ['prepared_by'] );
				$smarty->assign ( 'total', get_invoice_total ( $invoice_no ) );
				$smarty->assign ( 'edit', 'true' );
				$smarty->assign ( 'submit', 'true' );
				$smarty->assign ( 'page', 'Invoice' );
				$smarty->display ( 'invoice/invoice.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == "delete_description") {
			
			$invoice_no = $_SESSION ['invoice_no'];
			if (check_invoice_receipt_status ( $invoice_no )) {
				
				$smarty->assign ( 'notice', 'Notice : Please cancel Receipt to do any amendments' );
			} 

			else {
				
				if (last_description_invoice ( $invoice_no ) == 1) {
					delete_invoice ( $invoice_no );
					delete_invoice_ledger ( $invoice_no );
				} else {
					$smarty->assign ( 'submit', 'true' );
					$smarty->assign ( 'submit_des', 'true' );
				}
				
				delete_description ( $_REQUEST ['id'] );
				delete_description_ledger ( $_REQUEST ['id'] );
			}
			
			if ($_SESSION ['invoice_edit'] == 'true') {
				
				$invoice_info = get_invoice_info ( $invoice_no );
				
				$smarty->assign ( 'invoice_no', $invoice_no );
				$smarty->assign ( 'invoice_date', $invoice_info ['invoice_date'] );
				$smarty->assign ( 'customer', $invoice_info ['customer'] );
				$smarty->assign ( 'remarks', $invoice_info ['remarks'] );
				$smarty->assign ( 'on_behalf_of', $invoice_info ['on_behalf_of'] );
				$smarty->assign ( 'prepared_by', $invoice_info ['prepared_by'] );
				$smarty->assign ( 'total', get_invoice_total ( $invoice_no ) );
				$smarty->assign ( 'edit', 'true' );
			} 

			else {
				$smarty->assign ( 'invoice_no', $invoice_no );
				$smarty->assign ( 'total', get_invoice_total ( $invoice_no ) );
			}
			
			$smarty->assign ( 'page', 'Invoice' );
			$smarty->display ( 'invoice/invoice.tpl' );
		} elseif ($_REQUEST ['job'] == "view") {
			$invoice_no = $_REQUEST ['invoice_no'];
			
			$_SESSION ['invoice_no_report'] = $invoice_no;
			$invoice_info = get_invoice_info ( $invoice_no );
			$customer_info = get_customer_info_by_customer_id ( $invoice_info ['customer_id'] );
			
			$smarty->assign ( 'customer', $invoice_info [customer] );
			$smarty->assign ( 'ref_no', $invoice_info [ref_no] );
			$smarty->assign ( 'customer_address', $customer_info [address] );
			$smarty->assign ( 'saved_by', $invoice_info [saved_by] );
			$smarty->assign ( 'invoice_date', $invoice_info [invoice_date] );
			$smarty->assign ( 'invoice_no', $invoice_info [invoice_no] );
			$smarty->assign ( 'total', number_format ( get_invoice_total ( $invoice_no ), 2 ) );
			$smarty->assign ( 'total_in_word', strtoupper ( num_to_rupee ( get_invoice_total ( $invoice_no ) ) ) );
			
			$smarty->display ( 'invoice/invoice_report.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "delete_invoice") {
			
			$invoice_no = $_REQUEST ['invoice_no'];
			
			$invoice_info = get_invoice_info ( $invoice_no );
			
			if (check_invoice_receipt_status ( $invoice_no )) {
				$smarty->assign ( 'error_message', 'Notice : Please cancel Receipt to do any amendments' );
			} else {
				$flag = 'INVOICE-OTHER';
				delete_invoice ( $invoice_no );
				delete_invoice_description ( $_REQUEST ['invoice_no'] );
				delete_invoice_ledger ( $_REQUEST ['invoice_no'], $flag );
				delete_all_description_ledger ( $_REQUEST ['invoice_no'] );
			}
			
			$smarty->assign ( 'page', 'Invoice' );
			$smarty->display ( 'invoice/invoice_list.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "print") {
			$invoice_no = $_REQUEST ['invoice_no'];
			
			$_SESSION ['invoice_no_report'] = $invoice_no;
			$invoice_info = get_invoice_info ( $invoice_no );
			$customer_info = get_customer_info_by_customer_id ( $invoice_info ['customer_id'] );
			
			$smarty->assign ( 'customer', $invoice_info [customer] );
			$smarty->assign ( 'customer_address', $customer_info [address] );
			$smarty->assign ( 'saved_by', $invoice_info [saved_by] );
			$smarty->assign ( 'invoice_date', $invoice_info [invoice_date] );
			$smarty->assign ( 'invoice_no', $invoice_info [invoice_no] );
			$smarty->assign ( 'total', number_format ( get_invoice_total ( $invoice_no ), 2 ) );
			$smarty->assign ( 'total_in_word', strtoupper ( num_to_rupee ( get_invoice_total ( $invoice_no ) ) ) );
			
			$smarty->display ( 'invoice/invoice_print.tpl' );
		} else {
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Other Incomes." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}