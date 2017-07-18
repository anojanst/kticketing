<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
include 'functions/travels_functions.php';
include 'functions/refund_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/booking_functions.php';
include 'functions/other_expenses_functions.php';
include 'functions/voucher_functions.php';
include 'functions/company_settings_functions.php';
include 'libs/class.phpmailer.php';

$module_no = 27;

if ($_SESSION ['login'] == 1) {
	
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "refund_form") {
			
			unset ( $_SESSION ['refund_edit'] );
			unset ( $_SESSION ['refund_no'] );
			
			$smarty->assign ( 'page', "refund" );
			$smarty->display ( 'refund/refund.tpl' );

		} elseif ($_REQUEST ['job'] == "search_form") {
			unset ( $_SESSION ['search_refund_no'] );
			unset ( $_SESSION ['search_customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "refund" );
			$smarty->display ( 'refund/search_refund.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['search_refund_no'] = $_POST ['refund_no'];
			$_SESSION ['search_customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "refund" );
			$smarty->display ( 'refund/search_refund.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "booking_no_form") {
			
			$_SESSION ['booking_no'] = $booking_no = $_POST ['booking_no'];
			$smarty->assign ( 'booking_no', $_SESSION ['booking_no'] );
			
			$info = get_booking_info_by_booking_no ( $booking_no );
			
			$smarty->assign ( 'booking_no', "$booking_no" );
			
			$refund_no = check_refund_has_booking_no ( $booking_no );
			
			if ($refund_no) {
				$_SESSION ['refund_no'] = $refund_no;
				$refund_info = get_refund_info ( $refund_no );
				
				if ($refund_info ['status'] == 0) {
					$_SESSION ['booking_no'] = $refund_info ['ref_no'];
					
					$smarty->assign ( 'booking_no', $refund_info ['ref_no'] );
					$smarty->assign ( 'page', "refund" );
					$smarty->display ( 'refund/refund_passengers.tpl' );
				} else {
					$_SESSION ['booking_no'] = $refund_info ['ref_no'];
					
					$smarty->assign ( 'booking_no', $refund_info ['ref_no'] );
					$smarty->assign ( 'page', "refund" );
					$smarty->display ( 'refund/refund_view.tpl' );
				}
			} else {
				$smarty->assign ( 'submit', "true" );
				$smarty->assign ( 'page', "refund" );
				$smarty->display ( 'refund/refund.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == "to_complete") {
			
			$_SESSION ['refund_no'] = $refund_no = $_REQUEST ['refund_no'];
			
			$refund_info = get_refund_info ( $refund_no );
			$_SESSION ['booking_no'] = $refund_info ['ref_no'];
			
			$_SESSION ['passenger_total'] = $refund_info ['count'];
			$passenger_count = get_passenger_count_refund ( $refund_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'booking_no', $refund_info ['ref_no'] );
			$smarty->assign ( 'page', "refund" );
			$smarty->display ( 'refund/refund_passengers.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save") {
			
			$booking_no = $_SESSION ['booking_no'];
			$refund_no = get_refund_no ();
			$apply_date = $_POST ['apply_date'];
			$customer = explode ( " | ", $_POST ['customer'] );
			$customer_id = $customer [1];
			$name = $customer [0];
			$count = $_POST ['count'];
			$note = $_POST ['note'];
			$type = $_POST ['type'];
			
			$filename = stripslashes ( $_FILES ['letter'] ['name'] );
			$extension = getExtension ( $filename );
			$extension = strtolower ( $extension );
			$file_name = 'Refund-' . $refund_no . '.' . $extension;
			$newname = "letter/" . $file_name;
			$copied = copy ( $_FILES ['letter'] ['tmp_name'], $newname );
			$letter = $newname;
			
			add_refund ( $booking_no, $refund_no, $apply_date, $name, $customer_id, $count, $_SESSION ['user_name'], $letter, $note, $type );
			
			$_SESSION ['refund_no'] = $refund_no;
			
			$_SESSION ['passenger_total'] = $count;
			$passenger_count = get_passenger_count_refund ( $refund_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			
			$smarty->assign ( 'page', "refund" );
			$smarty->display ( 'refund/refund_passengers.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "complete") {
			$refund_no = $_SESSION ['refund_no'];
			$amount = $_POST ['amount'];
			$markup = $_POST ['markup'];
			$total = $_POST ['total'];
			
			complete_refund ( $refund_no, $amount, $markup, $total );
			generate_other_expenses ( $refund_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'booking_no', $refund_info ['ref_no'] );
			$smarty->assign ( 'page', "refund" );
			$smarty->display ( 'refund/refund_view.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add_passenger') {
			$refund_no = $_SESSION ['refund_no'];
			$passport_no = $_REQUEST ['passport_no'];
			$ticket_no = $_REQUEST ['ticket_no'];
			$visa_copy = $_REQUEST ['visa_copy'];
			$info = get_refund_info ( $refund_no );
			if ((check_repetive_passport_no_refund ( $refund_no, $passport_no )) == 1) {
				$smarty->assign ( 'error_message', "Dear $user_name, you cant add repetive passport no." );
			} else {
				if ($passport_no) {
					add_passenger_to_refund ( $refund_no, $passport_no, $ticket_no, $visa_copy );
					update_booking_has_passenger ( $passport_no, $info ['ref_no'] );
				}
			}
			$passenger_count = get_passenger_count_refund ( $refund_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'page', "refund" );
			$smarty->display ( 'refund/refund_passengers.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete_passenger') {
			$id = $_REQUEST ['id'];
			$refund_no = $_SESSION ['refund_no'];
			
			$info = get_refund_info ( $refund_no );
			$passport_info = get_refund_has_passenger_info ( $id );
			
			$passport_no = $passport_info ['passport_no'];
			
			update_back_booking_has_passenger ( $passport_no, $info ['ref_no'] );
			delete_passenger_refund ( $id );
			
			$passenger_count = get_passenger_count_refund ( $refund_no );
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'page', "refund" );
			$smarty->display ( 'refund/refund_passengers.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "view") {
			
			$refund_no = $_REQUEST ['refund_no'];
			$_SESSION ['refund_no'] = $refund_no;
			$refund_info = get_refund_info ( $refund_no );
			$_SESSION ['booking_no'] = $refund_info ['booking_no'];
			
			$smarty->assign ( 'page', 'refund' );
			$smarty->display ( 'refund/refund_view.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "send") {

            $_SESSION ['refund_no'] =$refund_no = $_REQUEST ['refund_no'];
			$refund_info = get_refund_info ( $refund_no );
			$_SESSION ['booking_no'] = $refund_info ['ref_no'];
			$booking_info = get_booking_info_by_booking_no ( $refund_info ['ref_no'] );
			$voucher_no = check_voucher_has_booking_no ( $refund_info ['ref_no'] );
			$voucher_info = get_voucher_info ( $voucher_no );
			
			$smarty->assign ( 'refund_no', $refund_info ['refund_no'] );
			$smarty->assign ( 'booking_no', $refund_info ['ref_no'] );
			$smarty->assign ( 'refund_date', $refund_info ['refund_date'] );
			$smarty->assign ( 'type', $refund_info ['type'] );
			$smarty->assign ( 'travels', $voucher_info ['travels'] );
			$smarty->assign ( 'pnr', $booking_info ['pnr'] );
			$smarty->assign ( 'saved_by', $refund_info ['saved_by'] );
			
			$smarty->assign ( 'page', 'refund' );
			$smarty->display ( 'refund/refund_send.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "print") {
			
			$refund_no = $_REQUEST ['refund_no'];
			$_SESSION ['refund_no'] = $refund_no;
			$refund_info = get_refund_info ( $refund_no );
			$_SESSION ['booking_no'] = $refund_info ['ref_no'];
			$booking_info = get_booking_info_by_booking_no ( $refund_info ['ref_no'] );
			$voucher_no = check_voucher_has_booking_no ( $refund_info ['ref_no'] );
			$voucher_info = get_voucher_info ( $voucher_no );
			
			$smarty->assign ( 'refund_no', $refund_info ['refund_no'] );
			$smarty->assign ( 'booking_no', $refund_info ['ref_no'] );
			$smarty->assign ( 'refund_date', $refund_info ['refund_date'] );
			$smarty->assign ( 'type', $refund_info ['type'] );
			$smarty->assign ( 'travels', $voucher_info ['travels'] );
			$smarty->assign ( 'pnr', $booking_info ['pnr'] );
			$smarty->assign ( 'saved_by', $refund_info ['saved_by'] );
			
			$smarty->assign ( 'page', 'refund' );
			$smarty->display ( 'refund/refund_print.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "send_mail") {
			
			$refund_no = $_SESSION ['refund_no'];
			$refund_info = get_refund_info ( $refund_no );
			
			$to = $_POST ['to'];
			$subject = $_POST ['subject'];
			
			$filename = stripslashes ( $_FILES ['file'] ['name'] );
			$extension = getExtension ( $filename );
			$extension = strtolower ( $extension );
			$file_name = $refund_no . '.' . $extension;
			$newname = "refund/" . $file_name;
			$copied = copy ( $_FILES ['file'] ['tmp_name'], $newname );
			$attachment = $newname;
			
			send_mail_refund ( $to, $subject, $attachment, $refund_no );
			
			$smarty->assign ( 'page', 'refund' );
			$smarty->display ( 'refund/refund.tpl' );
		} elseif ($_REQUEST ['job'] == "delete_refund") {
			$refund_no = $_REQUEST ['refund_no'];
			if (check_refund_paybill_status ( $refund_no )) {
				
				$smarty->assign ( 'notice', 'Notice : Please cancel Paybill to do any amendments' );
			} else {
				delete_refund ( $refund_no );
				$info = get_other_expenses_details ( $refund );
				delete_other_expenses ( $info ['other_expenses_no'] );
				delete_other_expenses_ledger ( $info ['other_expenses_no'] );
			}
			
			$smarty->assign ( 'page', 'refund' );
			$smarty->display ( 'refund/refund.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "print") {
			$module_no = 103;
			if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
				$refund_no = $_REQUEST ['refund_no'];
				$_SESSION ['refund_no'] = $refund_no;
				$refund_info = get_refund_info ( $refund_no );
				$_SESSION ['booking_no'] = $refund_info ['booking_no'];
				
				$smarty->assign ( 'refund_no', $refund_info ['refund_no'] );
				$smarty->assign ( 'booking_no', $refund_info ['booking_no'] );
				$smarty->assign ( 'refund_date', $refund_info ['refund_date'] );
				$smarty->assign ( 'travels', $refund_info ['travels'] );
				$smarty->assign ( 'pnr', $refund_info ['pnr'] );
				$smarty->assign ( 'fare', $refund_info ['fare'] );
				$smarty->assign ( 'btt_or_less', $refund_info ['btt_or_less'] );
				$smarty->assign ( 'bol_amount', $refund_info ['bol_amount'] );
				$smarty->assign ( 'taxes', $refund_info ['taxes'] );
				$smarty->assign ( 'sub_tot', $refund_info ['sub_tot'] );
				$smarty->assign ( 'time_limit', $refund_info ['time_limit'] );
				$smarty->assign ( 'saved_by', $refund_info ['saved_by'] );
				$smarty->assign ( 'total', $refund_info ['total'] );
				
				$refund_type = $refund_info [refund_type];
				if (check_refund_paybill_status ( $refund_no )) {
					
					$smarty->assign ( 'error_message', 'Notice : Please cancelPaybill to do any amendments' );
				} else {
				}
				$smarty->display ( 'refund/refund_print.tpl' );
			} else {
				$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Print refund" );
				$smarty->display ( 'user_home/access_error.tpl' );
			}
		} else {
			$smarty->assign ( 'page', 'refund' );
			$smarty->display ( 'refund/refund.tpl' );
		}
	} else {
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to refund" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}
