<?php
require_once 'conf/smarty-conf.php';
include 'functions/receipt_functions.php';
include 'functions/user_functions.php';
include 'functions/invoice_functions.php';
include 'functions/ledger_functions.php';
include 'functions/cheque_inventory_functions.php';
include 'functions/chat_functions.php';
include 'functions/customer_functions.php';
include 'functions/bank_functions.php';
include 'functions/cash_functions.php';

$module_no = 11;

if ($_SESSION ['login'] == 1) {
	
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "receipt_form") {
			unset ( $_SESSION ['customer_name'] );
			unset ( $_SESSION ['customer_id'] );
			unset ( $_SESSION ['random_no'] );
			
			$smarty->assign ( 'page', "Receipt" );
			$smarty->display ( 'receipt/receipt.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search_form") {
			unset ( $_SESSION ['search_rec_no'] );
			unset ( $_SESSION ['search_customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "Receipt" );
			$smarty->display ( 'receipt/search_receipt.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['search_rec_no'] = $_POST ['rec_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "Receipt" );
			$smarty->display ( 'receipt/search_receipt.tpl' );
		} 
		
		elseif ($_REQUEST ['job'] == "receipt_print") {
		
			$_SESSION ['search_rec_no'] = $_POST ['rec_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "receipt" );
			$smarty->display ( 'receipt_print/receipt_print.tpl' );
		}

		elseif ($_REQUEST ['job'] == "customer_form") {
			unset ( $_SESSION ['random_no'] );
			$_SESSION ['customer'] = $customer = $_POST ['customer'];
			
			$customers = explode ( " | ", $_POST ['customer'] );
			$_SESSION ['customer_name'] = $customer_name = $customers [0];
			$_SESSION ['customer_id'] = $customer_id = $customers [1];
			
			$_SESSION ['customer_id'] = $customer_id;
			
			delete_all_from_temp_for_this_user ( $_SESSION ['user_name'] );
			
			$smarty->assign ( 'customer', $_SESSION ['customer'] );
			$smarty->assign ( 'saved_by', $_SESSION [user_name] );
			$smarty->assign ( 'submit', 'true' );
			$smarty->assign ( 'page', "Receipt" );
			$smarty->display ( 'receipt/receipt.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "add_invoice") {
			$invoice_no = $_REQUEST ['invoice_no'];
			$paid = $_POST ['paid'];
			
			if (! isset ( $_SESSION ['random_no'] )) {
				$_SESSION ['random_no'] = $random_no = rand ( 1, 1000 );
				;
			} else {
			}
			$random_no = $_SESSION ['random_no'];
			$user_name = $_SESSION ['user_name'];
			
			update_invoice_due ( $invoice_no, $paid );
			save_receipt_invoice_in_temp_table ( $invoice_no, $random_no, $paid, $user_name );
			
			$smarty->assign ( 'saved_by', $_SESSION [user_name] );
			$smarty->assign ( 'customer', $_SESSION ['customer'] );
			$smarty->assign ( 'submit', 'true' );
			$smarty->assign ( 'page', 'Reciept' );
			$smarty->display ( 'receipt/receipt.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save_receipt") {
			$customer_name = $_SESSION ['customer_name'];
			$date = $_POST ['date'];
			$remarks = $_POST ['remarks'];
			
			$cheque_amount = $_POST ['cheque_amount'];
			$cheque_no = $_POST ['cheque_no'];
			$cheque_bank = $_POST ['cheque_bank'];
			$cheque_branch = $_POST ['cheque_branch'];
			$cheque_date = $_POST ['cheque_date'];
			$card_amount = $_POST ['card_amount'];
			$card_no = $_POST ['card_no'];
			$exp_date = $_POST ['exp_date'];
			$card_bank = $_POST ['card_bank'];
			$dep_amount = $_POST ['dep_amount'];
			$bank = $_POST ['bank'];
			$dep_date = $_POST ['dep_date'];
			$ez_amount = $_POST ['ez_amount'];
			$mobile = $_POST ['mobile'];
			$ref_no = $_POST ['ref_no'];
			$cash_amount = $_POST ['cash_amount'];
			$total = $cheque_amount + $cash_amount + $card_amount + $dep_amount + $ez_amount;
			
			$saved_by = $_SESSION ['user_name'];
			$rec_no = get_receipt_no ();
			$random_no = $_SESSION ['random_no'];
			if (check_receipt_invoice ( $random_no ) == 1) {
				if ($cash_amount > '0') {
					$detail = "RECEIPT";
					$cash_ref_no = $rec_no;
					$type = "IN";
					$branch = $_SESSION ['branch'];
					$time = date ( 'Y-m-d H:i:s' );
					save_cash_flow ( $branch, $detail, $cash_amount, $cash_ref_no, $type, $date, $saved_by );
				} else {
				}
				
				if ($bank) {
					$dep_no = get_dep_no ();
					$narration = "RECEIPT-" . $rec_no;
					save_deposit ( $dep_no, $dep_date, $bank, $dep_amount, $narration, $saved_by );
					update_balance ( $bank, $dep_amount );
					add_deposit_ledger ( $dep_no );
				} else {
				}
				
				if ($card_bank) {
					$card_dep_no = get_dep_no ();
					$narration = "CARD-RECEIPT-" . $rec_no;
					if ($card_bank == "NDB") {
						$account = "Indian Bank Current";
					} else {
						$account = "HNB Jaffna";
					}
					save_deposit ( $card_dep_no, $date, $account, $card_amount, $narration, $saved_by );
					update_balance ( $account, $card_amount );
					add_deposit_ledger ( $card_dep_no );
				} else {
				}
				
				save_receipt ( $rec_no, $customer_name, $_SESSION ['customer_id'], $date, $remarks, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $card_amount, $card_bank, $card_no, $exp_date, $card_dep_no, $bank, $dep_amount, $dep_date, $dep_no, $mobile, $ref_no, $ez_amount, $cash_amount, $total, $saved_by );
				transfer_invoice ( $random_no, $rec_no );
				delete_temp_data ( $random_no );
				add_receipt_ledger ( $rec_no );
				
				if ($cheque_no) {
					save_rec_in_cheque_inventory ( $rec_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $customer_name );
				} else {
				}
			} else {
				$smarty->assign ( 'error_message', "Add Invoice to receipt." );
				$smarty->assign ( 'submit', 'true' );
			}
			
			$smarty->assign ( 'error_message', "Receipt $rec_no has been Saved." );
			$smarty->assign ( 'page', 'Reciept' );
			$smarty->display ( 'receipt/receipt.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "delete_invoice") {
			
			$id = $_REQUEST ['id'];
			$invoice_no = $_REQUEST ['invoice_no'];
			
			$info = get_receipt_invoice_info_from_temp ( $id );
			$invoice_info = get_invoice_info ( $invoice_no );
			
			$paid = $invoice_info ['paid'] - $info ['amount'];
			$due = $invoice_info ['due'] + $info ['amount'];
			$rec_status = $invoice_info ['rec_status'] - 1;
			
			update_invoice_after_delete_temp ( $invoice_no, $paid, $due, $rec_status );
			
			delete_receipt_invoice_from_temp ( $id );
			
			$smarty->assign ( 'saved_by', $_SESSION [user_name] );
			$smarty->assign ( 'customer', $_SESSION ['customer'] );
			$smarty->assign ( 'submit', 'true' );
			$smarty->assign ( 'page', 'Reciept' );
			$smarty->display ( 'receipt/receipt.tpl' );
		} elseif ($_REQUEST ['job'] == "delete_receipt") {
			
			$module_no = 102;
			if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
				
				$rec_no = $_REQUEST ['rec_no'];
				$info = get_receipt_info ( $rec_no );
				
				if ($info ['bank']) {
					delete_deposit ( $info ['dep_no'] );
					reupdate_balance ( $info ['dep_no'] );
					delete_deposit_ledger ( $info ['dep_no'] );
				} else {
				}
				
				if ($info ['card_bank']) {
					delete_deposit ( $info ['card_dep_no'] );
					reupdate_balance ( $info ['card_dep_no'] );
					delete_deposit_ledger ( $info ['card_dep_no'] );
				} else {
				}
				
				if ($info ['cash_amount'] > 0) {
					$cash_amount = $info ['cash_amount'];
					
					$detail = "RECEIPT";
					$ref_no = $rec_no;
					$type = "OUT";
					$branch = $info ['branch'];
					$time = date ( 'Y-m-d H:i:s' );
					
					delete_cash_flow ( $branch, $detail, $ref_no );
				} else {
				}
				
				roll_back_receipt_invoice ( $rec_no );
				cancel_receipt ( $rec_no );
				cancel_all_receipt_invoice ( $rec_no );
				delete_receipt_ledger ( $rec_no );
				delete_rec_from_cheque_inventory ( $rec_no );
				
				$smarty->assign ( 'page', 'Reciept' );
				$smarty->display ( 'receipt/receipt.tpl' );
			} 

			else {
				$user_name = $_SESSION ['user_name'];
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to Delete Receipt." );
				$smarty->assign ( 'page', "Access Error" );
				$smarty->display ( 'user_home/access_error.tpl' );
			}
		} elseif ($_REQUEST ['job'] == "view_receipt") {
			$module_no = 101;
			if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
				$rec_no = $_REQUEST ['rec_no'];
				
				$receipt_info = get_receipt_info ( $_REQUEST ['rec_no'] );
				$invoice_no = receipt_get_invoice_no ( $receipt_info ['rec_no'] );
				$invoice_info = get_invoice_info ( $invoice_no );
				$customer_info = get_customer_info ( addslashes ( $receipt_info ['customer_id'] ) );
				$_SESSION ['rec_no'] = $_REQUEST ['rec_no'];
				
				$smarty->assign ( 'rec_no', $receipt_info ['rec_no'] );
				$smarty->assign ( 'date', $receipt_info ['date'] );
				$smarty->assign ( 'customer_name', $receipt_info ['customer_name'] );
				$smarty->assign ( 'address', $customer_info ['address'] );
				$smarty->assign ( 'total', number_format ( ($receipt_info ['cheque_amount'] + $receipt_info ['cash_amount'] + $receipt_info ['card_amount'] + $receipt_info ['dep_amount'] + $receipt_info ['ez_amount']) ), 2 );
				$smarty->assign ( 'total_word', strtoupper ( num_to_rupee ( $receipt_info ['cheque_amount'] + $receipt_info ['cash_amount'] + $receipt_info ['card_amount'] + $receipt_info ['dep_amount'] + $receipt_info ['ez_amount'] ) ) );
				$smarty->assign ( 'cheque_amount', $receipt_info ['cheque_amount'] );
				$smarty->assign ( 'cheque_no', $receipt_info ['cheque_no'] );
				$smarty->assign ( 'cheque_bank', $receipt_info ['cheque_bank'] );
				$smarty->assign ( 'cheque_branch', $receipt_info ['cheque_branch'] );
				$smarty->assign ( 'cheque_date', $receipt_info ['cheque_date'] );
				$smarty->assign ( 'card_amount', $receipt_info ['card_amount'] );
				$smarty->assign ( 'card_no', $receipt_info ['card_no'] );
				$smarty->assign ( 'card_bank', $receipt_info ['card_bank'] );
				$smarty->assign ( 'dep_amount', $receipt_info ['dep_amount'] );
				$smarty->assign ( 'dep_date', $receipt_info ['dep_date'] );
				$smarty->assign ( 'bank', $receipt_info ['bank'] );
				$smarty->assign ( 'ez_amount', $receipt_info ['ez_amount'] );
				$smarty->assign ( 'ref_no', $receipt_info ['ref_no'] );
				$smarty->assign ( 'mobile', $receipt_info ['mobile'] );
				$smarty->assign ( 'cash_amount', $receipt_info ['cash_amount'] );
				$smarty->assign ( 'saved_by', $receipt_info ['saved_by'] );
				$smarty->assign ( 'remarks', $receipt_info ['remarks'] );
				
				$smarty->display ( 'receipt/receipt_report.tpl' );
			} else {
				$user_name = $_SESSION ['user_name'];
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to Print Receipt." );
				$smarty->assign ( 'page', "Access Error" );
				$smarty->display ( 'user_home/access_error.tpl' );
			}
		} elseif ($_REQUEST ['job'] == "print_receipt") {
			
			$module_no = 101;
			if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
				$rec_no = $_REQUEST ['rec_no'];
				$print_count = get_rec_print_count ( $rec_no );
				
				update_rec_print_count ( $rec_no, $print_count );
				$rec_no = $_REQUEST ['rec_no'];
				
				$receipt_info = get_receipt_info ( $_REQUEST ['rec_no'] );
				$invoice_no = receipt_get_invoice_no ( $receipt_info ['rec_no'] );
				$invoice_info = get_invoice_info ( $invoice_no );
				$customer_info = get_customer_name_info ( addslashes ( $receipt_info ['customer_name'] ) );
				$job_info = get_job_info ( $invoice_info ['job_no'] );
				$_SESSION ['rec_no'] = $_REQUEST ['rec_no'];
				
				$smarty->assign ( 'job_type', $job_info ['job_type'] );
				$smarty->assign ( 'print_count', $print_count );
				$smarty->assign ( 'rec_no', $receipt_info ['rec_no'] );
				$smarty->assign ( 'date', $receipt_info ['date'] );
				$smarty->assign ( 'job_no', $invoice_info ['job_no'] );
				
				$smarty->assign ( 'ex_rate', $invoice_info ['ex_rate'] );
				
				$smarty->assign ( 'customer_name', $receipt_info ['customer_name'] );
				$smarty->assign ( 'address', $customer_info ['address'] );
				$smarty->assign ( 'total', strtoupper ( num_to_rupee ( $receipt_info ['cheque_amount'] + $receipt_info ['cash_amount'] ) ) );
				
				$smarty->assign ( 'cheque_amount', $receipt_info ['cheque_amount'] );
				$smarty->assign ( 'cheque_no', $receipt_info ['cheque_no'] );
				$smarty->assign ( 'cheque_bank', $receipt_info ['cheque_bank'] );
				$smarty->assign ( 'cheque_branch', $receipt_info ['cheque_branch'] );
				$smarty->assign ( 'cheque_date', $receipt_info ['cheque_date'] );
				$smarty->assign ( 'cash_amount', $receipt_info ['cash_amount'] );
				$smarty->assign ( 'prepared_by', $receipt_info ['prepared_by'] );
				$smarty->assign ( 'remarks', $receipt_info ['remarks'] );
				$smarty->display ( 'receipt/receipt_print.tpl' );
			} 

			else {
				$user_name = $_SESSION ['user_name'];
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to Print Receipt." );
				$smarty->assign ( 'page', "Access Error" );
				$smarty->display ( 'user_home/access_error.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == "transaction") {
			
			require_once 'functions/receipt_functions.php';
			require_once 'functions/invoice_functions.php';
			
			$_SESSION ['rec_no'] = $_REQUEST ['rec_no'];
			
			$smarty->display ( 'receipt/transaction.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "Receipt" );
			$smarty->display ( 'receipt/receipt.tpl' );
		}
	} 

	else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Receipt." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}