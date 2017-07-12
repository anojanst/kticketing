<?php
require_once 'conf/smarty-conf.php';
include 'functions/paybill_functions.php';
include 'functions/user_functions.php';
include 'functions/voucher_functions.php';
include 'functions/other_expenses_functions.php';
include 'functions/ledger_functions.php';
include 'functions/cheque_inventory_functions.php';
include 'functions/chat_functions.php';
include 'functions/customer_functions.php';
include 'functions/bank_functions.php';
include 'functions/loan_functions.php';
include 'functions/cash_functions.php';
include 'functions/company_settings_functions.php';

$module_no = 25;

if ($_SESSION ['login'] == 1) {
	
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "paybill_form") {
			unset ( $_SESSION ['random_no'] );
			unset ( $_SESSION ['customer_name'] );
			unset ( $_SESSION ['customer_id'] );
			
			$smarty->assign ( 'page', "paybill" );
			$smarty->display ( 'paybill/paybill.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search_form") {
			unset ( $_SESSION ['search_paybill_no'] );
			unset ( $_SESSION ['search_customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "Paybill" );
			$smarty->display ( 'paybill/search_paybill.tpl' );
		} 
		
		elseif ($_REQUEST ['job'] == "paybill_print") {
				
			$_SESSION ['search_paybill_no'] = $_POST ['paybill_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			$smarty->assign ( 'page', "paybill" );
			$smarty->display ( 'paybill_print/paybill_print.tpl' );
		}

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['search_paybill_no'] = $_POST ['paybill_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "Paybill" );
			$smarty->display ( 'paybill/search_paybill.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "customer_form") {
			unset ( $_SESSION ['random_no'] );
			
			$_SESSION ['customer'] = $customer = $_POST ['customer'];
			
			$customers = explode ( " | ", $_POST ['customer'] );
			$_SESSION ['customer_name'] = $customer_name = $customers [0];
			$_SESSION ['customer_id'] = $customer_id = $customers [1];
			
			$_SESSION ['customer_id'] = $customer_id;
			$_SESSION ['vsp_from_date'] = $vsp_from_date = $_POST ['vsp_from_date'];
			$_SESSION ['vsp_to_date'] = $vsp_to_date = $_POST ['vsp_to_date'];
			
			delete_all_from_temp_for_this_user ( $_SESSION ['user_id'] );
			
			$smarty->assign ( 'customer', $_SESSION ['customer'] );
			$smarty->assign ( 'vsp_from_date', $_SESSION ['vsp_from_date'] );
			$smarty->assign ( 'vsp_to_date', $_SESSION ['vsp_to_date'] );
			$smarty->assign ( 'saved_by', $_SESSION ['saved_by'] );
			$smarty->assign ( 'submit', 'true' );
			$smarty->assign ( 'page', "paybill" );
			$smarty->display ( 'paybill/paybill.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "add_voucher") {
			$voucher_no = $_REQUEST ['voucher_no'];
			$type = $_REQUEST ['type'];
			$paid = $_POST ['paid'];
			
			if (! isset ( $_SESSION ['random_no'] )) {
				$_SESSION ['random_no'] = $random_no = rand ( 1, 1000 );
			} else {
			}
			$random_no = $_SESSION ['random_no'];
			$user_id = $_SESSION ['user_id'];
			
			if ($type == "VOUCHER") {
				update_voucher_due ( $voucher_no, $paid );
			} else {
				update_other_expense_due ( $voucher_no, $paid );
				$info = get_other_expenses_info ( $voucher_no );
				if ($info ['ref_type'] == "LOAN") {
					$loan_no = $info ['ref_no'];
					update_loan_balance ( $loan_no, $paid );
				}
			}
			save_paybill_voucher_in_temp_table ( $voucher_no, $type, $random_no, $paid, $user_id );
			
			$smarty->assign ( 'saved_by', $_SESSION [user_name] );
			$smarty->assign ( 'customer', $_SESSION ['customer'] );
			$smarty->assign ( 'name_in_che', $_SESSION ['customer_name'] );
			$smarty->assign ( 'submit', 'true' );
			$smarty->assign ( 'page', 'Paybill' );
			$smarty->display ( 'paybill/paybill.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save_paybill") {
			
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
			$from_bank = $_POST ['from_bank'];
			$dep_date = $_POST ['dep_date'];
			$ez_amount = $_POST ['ez_amount'];
			$mobile = $_POST ['mobile'];
			$ref_no = $_POST ['ref_no'];
			$cash_amount = $_POST ['cash_amount'];
			$total = $cheque_amount + $cash_amount + $card_amount + $dep_amount + $ez_amount;
			
			$saved_by = $_SESSION ['user_name'];
			$paybill_no = get_paybill_no ();
			$random_no = $_SESSION ['random_no'];
			
			if (check_paybill_voucher ( $random_no ) == 1) {
				
				if ($cash_amount > '0') {
					$detail = "PAYBILL";
					$cash_ref_no = $paybill_no;
					$type = "OUT";
					$branch = $_SESSION ['branch'];
					$time = date ( 'Y-m-d H:i:s' );
					save_cash_flow ( $branch, $detail, $cash_amount, $cash_ref_no, $type, $date, $saved_by );
				} else {
				}
				
				if ($bank) {
					$with_no = get_with_no ();
					$narration = "PAYBILL-" . $paybill_no;
					save_withdraw ( $with_no, $dep_date, $from_bank, $dep_amount, $narration, $saved_by );
					add_withdraw_ledger ( $with_no );
					update_balance_withdraw ( $from_bank, $dep_amount );
				} else {
				}
				
				save_paybill ( $paybill_no, $customer_name, $_SESSION ['customer_id'], $date, $remarks, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $card_amount, $card_bank, $card_no, $exp_date, $bank, $from_bank, $dep_amount, $dep_date, $with_no, $mobile, $ref_no, $ez_amount, $cash_amount, $total, $saved_by );
				transfer_voucher ( $random_no, $paybill_no );
				delete_temp_data ( $random_no );
				add_paybill_ledger ( $paybill_no );
				
				if ($cheque_no) {
					save_paybill_in_cheque_inventory ( $paybill_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $customer_name );
				} else {
				}
			} else {
				$smarty->assign ( 'error_message', "Add Voucher to paybill." );
				$smarty->assign ( 'submit', 'true' );
			}
			
			unset ( $_SESSION ['random_no'] );
			unset ( $_SESSION ['paybill_no'] );
			unset ( $_SESSION ['customer_name'] );
			
			$smarty->assign ( 'error_message', "Paybill $paybill_no has been Saved." );
			$smarty->assign ( 'submit', 'false' );
			$smarty->assign ( 'page', 'Paybill' );
			$smarty->display ( 'paybill/paybill.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "delete_voucher") {
			$id = $_REQUEST ['id'];
			$voucher_no = $_REQUEST ['voucher_no'];
			$type = $_REQUEST ['type'];
			
			$info = get_paybill_voucher_info_from_temp ( $id );
			
			if ($type == "VOUCHER") {
				$voucher_info = get_voucher_info ( $voucher_no );
				$table = "voucher";
			} else {
				$voucher_info = get_other_expenses_info ( $voucher_no );
				$table = "other_expenses";
				$loan_info = get_other_expenses_info ( $voucher_no );
				if ($loan_info ['ref_type'] == "LOAN") {
					$loan_no = $loan_info ['ref_no'];
					reupdate_loan_balance ( $loan_no, $info ['amount'] );
				}
			}
			
			$paid = $voucher_info ['paid'] - $info ['amount'];
			$due = $voucher_info ['due'] + $info ['amount'];
			$pay_status = $voucher_info ['pay_status'] - 1;
			
			update_voucher_after_delete_temp ( $voucher_no, $paid, $due, $pay_status, $table );
			delete_paybill_voucher_from_temp ( $id );
			
			$smarty->assign ( 'submit', 'true' );
			$smarty->display ( 'paybill/paybill.tpl' );
		} elseif ($_REQUEST ['job'] == "delete_paybill") {
			$module_no = 107;
			if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
				$paybill_no = $_REQUEST ['paybill_no'];
				
				$info = get_paybill_info ( $paybill_no );
				if ($info ['cash_amount'] > 0) {
					$cash_amount = $info ['cash_amount'];
					
					$detail = "PAYBILL";
					$ref_no = $paybill_no;
					$type = "IN";
					$branch = $info ['branch'];
					$time = date ( 'Y-m-d H:i:s' );
					
					delete_cash_flow ( $branch, $detail, $ref_no );
				} else {
				}
				
				if ($info ['from_bank']) {
					delete_withdraw ( $info ['with_no'] );
					delete_withdraw_ledger ( $info ['with_no'] );
					reupdate_balance_withdraw ( $info ['with_no'] );
				} else {
				}
				
				roll_back_paybill_voucher ( $paybill_no );
				cancel_paybill ( $paybill_no );
				roll_back_loan_amount ( $paybill_no );
				cancel_all_paybill_voucher ( $paybill_no );
				delete_paybill_ledger ( $paybill_no );
				delete_paybill_from_cheque_inventory ( $paybill_no );
				
				$smarty->display ( 'paybill/paybill.tpl' );
			} 

			else {
				$smarty->assign ( 'error_message', "You dont have permission to delete paybill" );
				$smarty->display ( 'user_home/access_error.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == "print_paybill") {
			
			$module_no = 108;
			if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
				$paybill_no = $_REQUEST ['paybill_no'];
				
				$print_count = get_paybill_print_count ( $paybill_no );
				
				$paybill_no = $_REQUEST ['paybill_no'];
				$print_count = get_paybill_print_count ( $paybill_no );
				
				update_paybill_print_count ( $paybill_no, $print_count );
				$paybill_no = $_REQUEST ['paybill_no'];
				
				$paybill_info = get_paybill_info ( $_REQUEST ['paybill_no'] );
				$voucher_no = paybill_get_voucher_no ( $paybill_info ['paybill_no'] );
				$voucher_info = get_voucher_info ( $voucher_no );
				$_SESSION ['paybill_no'] = $_REQUEST ['paybill_no'];
				
				$smarty->assign ( 'print_count', $print_count );
				$smarty->assign ( 'paybill_no', $paybill_info ['paybill_no'] );
				$smarty->assign ( 'date', $paybill_info ['date'] );
				$smarty->assign ( 'customer_name', $paybill_info ['customer_name'] );
				$smarty->assign ( 'total', number_format ( ($paybill_info ['cheque_amount'] + $paybill_info ['cash_amount'] + $paybill_info ['card_amount'] + $paybill_info ['dep_amount'] + $paybill_info ['ez_amount']) ), 2 );
				$smarty->assign ( 'total_word', strtoupper ( num_to_rupee ( $paybill_info ['cheque_amount'] + $paybill_info ['cash_amount'] + $paybill_info ['card_amount'] + $paybill_info ['dep_amount'] + $paybill_info ['ez_amount'] ) ) );
				$smarty->assign ( 'cheque_amount', $paybill_info ['cheque_amount'] );
				$smarty->assign ( 'cheque_no', $paybill_info ['cheque_no'] );
				$smarty->assign ( 'cheque_bank', $paybill_info ['cheque_bank'] );
				$smarty->assign ( 'cheque_branch', $paybill_info ['cheque_branch'] );
				$smarty->assign ( 'cheque_date', $paybill_info ['cheque_date'] );
				$smarty->assign ( 'card_amount', $paybill_info ['card_amount'] );
				$smarty->assign ( 'card_no', $paybill_info ['card_no'] );
				$smarty->assign ( 'card_bank', $paybill_info ['card_bank'] );
				$smarty->assign ( 'dep_amount', $paybill_info ['dep_amount'] );
				$smarty->assign ( 'dep_date', $paybill_info ['dep_date'] );
				$smarty->assign ( 'bank', $paybill_info ['bank'] );
				$smarty->assign ( 'ez_amount', $paybill_info ['ez_amount'] );
				$smarty->assign ( 'ref_no', $paybill_info ['ref_no'] );
				$smarty->assign ( 'mobile', $paybill_info ['mobile'] );
				$smarty->assign ( 'cash_amount', $paybill_info ['cash_amount'] );
				$smarty->assign ( 'saved_by', $paybill_info ['saved_by'] );
				$smarty->assign ( 'remarks', $paybill_info ['remarks'] );
				
				$smarty->display ( 'paybill/paybill_report.tpl' );
			} else {
				$smarty->display ( 'user_home/access_error.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == "transaction") {
			
			require_once 'functions/paybill_functions.php';
			require_once 'functions/voucher_functions.php';
			
			$_SESSION ['paybill_no'] = $_REQUEST ['paybill_no'];
			
			$smarty->display ( 'paybill/transaction.tpl' );
		} else {
			$smarty->assign ( 'page', "Paybill" );
			$smarty->display ( 'paybill/paybill.tpl' );
		}
	} 

	else {
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}