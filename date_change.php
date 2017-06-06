<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/booking_functions.php';
include 'functions/invoice_functions.php';
include 'functions/ledger_functions.php';
include 'functions/customer_functions.php';
include 'functions/offer_functions.php';

$module_no = 17;

unset ( $_SESSION ['serial_no'] );
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'date_change_form') {
			unset ( $_SESSION ['date_change_no'] );
			$smarty->assign ( 'date_change_no', "$_SESSION[date_change_no]" );
			$smarty->assign ( 'air_line_names', list_air_lines () );
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'date_change/date_change.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add_item') {
			$booking_type = "DATE CHANGE";
			if (! isset ( $_SESSION ['date_change_no'] )) {
				
				$_SESSION ['date_change_no'] = $date_change_no = get_booking_no ( $booking_type );
				$serial_no = get_serial_no ( $booking_type );
			} else {
			}
			
			$air_line_code = $_POST ['air_line_code'];
			$class = $_POST ['class'];
			$type = $_POST ['type'];
			$penalty = $_POST ['penalty'];
			$mark_up = $_POST ['mark_up'];
			$total = $_POST ['total'];
			$dep_time = $_POST ['dep_time'];
			$arr_time = $_POST ['arr_time'];
			$rtn_dep_time = $_POST ['rtn_dep_time'];
			$rtn_arr_time = $_POST ['rtn_arr_time'];
			$user_name = $_SESSION ['user_name'];
			
			$date_change_no = $_SESSION ['date_change_no'];
			$date_change_info = get_booking_info_by_booking_no ( $date_change_no );
			
			save_date_change_item ( $date_change_no, $serial_no, $booking_type, $air_line_code, $class, $type, $penalty, $mark_up, $total, $dep_time, $arr_time, $rtn_dep_time, $rtn_arr_time, $user_name );
			
			if ($date_change_info) {
				$smarty->assign ( 'customer', "$date_change_info[name] | $date_change_info[customer_id]" );
			}
			$smarty->assign ( 'mobile', "$date_change_info[mobile]" );
			$smarty->assign ( 'phone', "$date_change_info[phone]" );
			$smarty->assign ( 'email', "$date_change_info[email]" );
			$smarty->assign ( 'date_change_no', "$_SESSION[date_change_no]" );
			$smarty->assign ( 'way', "$date_change_info[way]" );
			$smarty->assign ( 'dep_air_port', "$date_change_info[dep_air_port]" );
			$smarty->assign ( 'arr_air_port', "$date_change_info[arr_air_port]" );
			$smarty->assign ( 'dep_date', "$date_change_info[dep_date]" );
			$smarty->assign ( 'rtn_date', "$date_change_info[rtn_date]" );
			$smarty->assign ( 'adult', "$date_change_info[adult]" );
			$smarty->assign ( 'child', "$date_change_info[child]" );
			$smarty->assign ( 'infant', "$date_change_info[infant]" );
			$smarty->assign ( 'currency', "$date_change_info[currency]" );
			$smarty->assign ( 'address', "$date_change_info[address]" );
			$smarty->assign ( 'note', "$date_change_info[note]" );
			
			$smarty->assign ( 'air_line_names', list_air_lines () );
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'date_change/date_change.tpl' );
		} 
		elseif ($_REQUEST ['job'] == 'list') {
			unset ( $_SESSION ['search_booking_no'] );
			unset ( $_SESSION ['customer'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
				
			$smarty->assign ( 'page', "Ticket Log Book" );
			$smarty->display ( 'booking/date_change_logbook.tpl' );
		}

		elseif ($_REQUEST ['job'] == 'search') {
			$date_change_info = get_booking_info_by_booking_no ( $_POST ['search'] );
			$_SESSION ['date_change_no'] = $_POST ['search'];
			if ($date_change_info ['status'] == 0) {
				if ($date_change_info) {
					$smarty->assign ( 'search', "On" );
				}
				
				$smarty->assign ( 'customer', "$date_change_info[name] | $date_change_info[customer_id]" );
				$smarty->assign ( 'mobile', "$date_change_info[mobile]" );
				$smarty->assign ( 'phone', "$date_change_info[phone]" );
				$smarty->assign ( 'email', "$date_change_info[email]" );
				
				$smarty->assign ( 'way', "$date_change_info[way]" );
				$smarty->assign ( 'dep_air_port', "$date_change_info[dep_air_port]" );
				$smarty->assign ( 'arr_air_port', "$date_change_info[arr_air_port]" );
				$smarty->assign ( 'dep_date', "$date_change_info[dep_date]" );
				$smarty->assign ( 'rtn_date', "$date_change_info[rtn_date]" );
				$smarty->assign ( 'pax_count', "$date_change_info[adult]" );
				
				$smarty->assign ( 'booking_no', "$date_change_info[ref_no]" );
				$smarty->assign ( 'address', "$date_change_info[address]" );
				$smarty->assign ( 'note', "$date_change_info[note]" );
				
				$smarty->assign ( 'date_change_no', "$_SESSION[date_change_no]" );
				$smarty->assign ( 'air_line_names', list_air_lines () );
				$smarty->assign ( 'air_port_names', list_air_ports () );
				
				if ((check_passengers ( $_SESSION ['date_change_no'] )) == 1) {
					$_SESSION ['passenger_total'] = $date_change_info ['adult'] + $date_change_info ['child'] + $date_change_info ['infant'];
					$passenger_count = get_passenger_count ( $date_change_no );
					$_SESSION ['id'] = $date_change_info ['fare_id'];
					
					$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
					$smarty->assign ( 'passenger_total_updated', $passenger_count );
					$smarty->assign ( 'page', "Booking" );
					$smarty->display ( 'date_change/passenger_detail.tpl' );
				} else {
					$smarty->assign ( 'page', "Booking" );
					$smarty->display ( 'date_change/date_change.tpl' );
				}
			} else {
				$_SESSION ['date_change_no'] = $_POST ['search'];
				
				$_SESSION ['id'] = $date_change_info ['fare_id'];
				$smarty->assign ( 'page', "Booking" );
				$smarty->display ( 'date_change/date_change_view.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'save') {
			if ($_REQUEST ['main_ok'] == "Save") {
				$booking_no = $_POST ['booking_no'];
				$date_change_no = $_SESSION ['date_change_no'];
				$user_name = $_SESSION ['user_name'];
				$branch = $_SESSION ['branch'];
				
				if ($booking_no) {
					$booking_info = get_booking_info_by_booking_no ( $booking_no );
					$customer = $booking_info ['name'];
					$customer_id = $booking_info ['customer_id'];
					$mobile = $booking_info ['mobile'];
					$phone = $booking_info ['phone'];
					$email = $booking_info ['email'];
					$address = $booking_info ['address'];
				} else {
					$customers = explode ( " | ", $_POST ['customer'] );
					$customer = $customers [0];
					$mobile = $_POST ['mobile'];
					$phone = $_POST ['phone'];
					$email = $_POST ['email'];
					$address = $_POST ['address'];
					if ($customers [1]) {
						$customer_id = $customers [1];
					} else {
						$customer_id = get_customer_id ();
						save_customer ( $customer, $salute, $customer_id, $first_name, $last_name, $sex, $nationality, $dob, $address, $telephone, $mobile, $email, $passport_no, $passport, $issued_date, $expire_date );
					}
				}
				
				$way = $_POST ['way'];
				$dep_air_port = $_POST ['dep_air_port'];
				$arr_air_port = $_POST ['arr_air_port'];
				$dep_date = $_POST ['dep_date'];
				$rtn_date = $_POST ['rtn_date'];
				$pax_count = $_POST ['pax_count'];
				$note = $_POST ['note'];
				
				$info = get_booking_type ( $date_change_no );
				$booking_type = $info ['booking_type'];
				create_date_change ( $date_change_no, $booking_type, $booking_no, $customer, $customer_id, $mobile, $phone, $email, $way, $dep_air_port, $arr_air_port, $dep_date, $rtn_date, $pax_count, $address, $note, $user_name, $branch );
				
				$date_change_info = get_booking_info_by_booking_no ( $date_change_no );
				
				$smarty->assign ( 'customer', "$date_change_info[name] | $date_change_info[customer_id]" );
				$smarty->assign ( 'mobile', "$date_change_info[mobile]" );
				$smarty->assign ( 'phone', "$date_change_info[phone]" );
				$smarty->assign ( 'email', "$date_change_info[email]" );
				$smarty->assign ( 'date_change_no', "$_SESSION[date_change_no]" );
				$smarty->assign ( 'booking_no', "$date_change_info[ref_no]" );
				$smarty->assign ( 'way', "$date_change_info[way]" );
				$smarty->assign ( 'dep_air_port', "$date_change_info[dep_air_port]" );
				$smarty->assign ( 'arr_air_port', "$date_change_info[arr_air_port]" );
				$smarty->assign ( 'dep_date', "$date_change_info[dep_date]" );
				$smarty->assign ( 'rtn_date', "$date_change_info[rtn_date]" );
				$smarty->assign ( 'pax_count', "$date_change_info[adult]" );
				$smarty->assign ( 'address', "$date_change_info[address]" );
				$smarty->assign ( 'note', "$date_change_info[note]" );
				$smarty->assign ( 'search', "On" );
			} else {
				$booking_no = $_POST ['booking_no'];
				$booking_info = get_booking_info_by_booking_no ( $booking_no );
				if ($booking_no) {
					$customer = $booking_info ['name'];
					$customer_id = $booking_info ['customer_id'];
					$mobile = $booking_info ['mobile'];
					$phone = $booking_info ['phone'];
					$email = $booking_info ['email'];
					$address = $booking_info ['address'];
				} else {
					$customers = explode ( " | ", $_POST ['customer'] );
					$customer = $customers [0];
					$mobile = $_POST ['mobile'];
					$phone = $_POST ['phone'];
					$email = $_POST ['email'];
					$address = $_POST ['address'];
					$customer_id = $customers [1];
				}
				
				$date_change_no = $_SESSION ['date_change_no'];
				$way = $_POST ['way'];
				$dep_air_port = $_POST ['dep_air_port'];
				$arr_air_port = $_POST ['arr_air_port'];
				$dep_date = $_POST ['dep_date'];
				$rtn_date = $_POST ['rtn_date'];
				$pax_count = $_POST ['pax_count'];
				$booking_no = $_POST ['booking_no'];
				$note = $_POST ['note'];
				$user_name = $_SESSION ['user_name'];
				
				update_date_change ( $date_change_no, $booking_no, $customer, $customer_id, $mobile, $phone, $email, $way, $dep_air_port, $arr_air_port, $dep_date, $rtn_date, $pax_count, $address, $note, $user_name, $branch );
				
				$date_change_no = $_SESSION ['date_change_no'];
				$date_change_info = get_booking_info_by_booking_no ( $date_change_no );
				echo $date_change_info [name];
				$smarty->assign ( 'customer', "$date_change_info[name] | $date_change_info[customer_id]" );
				$smarty->assign ( 'mobile', "$date_change_info[mobile]" );
				$smarty->assign ( 'phone', "$date_change_info[phone]" );
				$smarty->assign ( 'email', "$date_change_info[email]" );
				$smarty->assign ( 'date_change_no', "$_SESSION[date_change_no]" );
				$smarty->assign ( 'way', "$date_change_info[way]" );
				$smarty->assign ( 'dep_air_port', "$date_change_info[dep_air_port]" );
				$smarty->assign ( 'arr_air_port', "$date_change_info[arr_air_port]" );
				$smarty->assign ( 'dep_date', "$date_change_info[dep_date]" );
				$smarty->assign ( 'rtn_date', "$date_change_info[rtn_date]" );
				$smarty->assign ( 'pax_count', "$date_change_info[adult]" );
				$smarty->assign ( 'booking_no', "$date_change_info[ref_no]" );
				$smarty->assign ( 'address', "$date_change_info[address]" );
				$smarty->assign ( 'note', "$date_change_info[note]" );
				$smarty->assign ( 'search', "On" );
			}
			$smarty->assign ( 'air_line_names', list_air_lines () );
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'date_change/date_change.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'passenger_detail') {
			$date_change_no = $_SESSION ['date_change_no'];
			$id = $_SESSION ['id'] = $_REQUEST ['id'];
			$date_change_info = get_booking_info_by_booking_no ( $date_change_no );
			$fare_info = get_fare_detail ( $id );
			
			$_SESSION ['passenger_total'] = $date_change_info ['adult'] + $date_change_info ['child'] + $date_change_info ['infant'];
			$passenger_count = get_passenger_count ( $date_change_no );
			
			update_fare_id ( $date_change_no, $id );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'date_change/passenger_detail.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add_passenger') {
			$date_change_no = $_SESSION ['date_change_no'];
			$passport_no = $_POST ['passport_no'];
			
			if ((check_repetive_passport_no ( $date_change_no, $passport_no )) == 1) {
				$smarty->assign ( 'error_message', "Dear $user_name, you cant add repetive passport no." );
			} else {
				
				add_passenger_to_booking ( $date_change_no, $passport_no, $visa_copy );
			}
			$passenger_count = get_passenger_count ( $date_change_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'date_change/passenger_detail.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete_passenger') {
			$id = $_REQUEST ['id'];
			
			delete_passenger ( $id );
			
			$passenger_count = get_passenger_count ( $date_change_no );
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'date_change/passenger_detail.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'booking_complete') {
			$date_change_no = $_SESSION ['date_change_no'];
			$pnr = $_POST ['pnr'];
			$al_ref = $_POST ['al_ref'];
			$issue_date = $_POST ['issue_date'];
			$flight_no = $_POST ['flight_no'];
			$rtn_flight_no = $_POST ['rtn_flight_no'];
			$passenger_count = get_passenger_count ( $date_change_no );
			$passenger_total = $_SESSION ['passenger_total'];
			
			if ($passenger_count == $passenger_total) {
				complete_booking ( $date_change_no, $pnr, $al_ref, $issue_date, $transits, $flight_no, $rtn_flight_no );
				generate_invoice ( $date_change_no );
				
				$date_change_info = get_booking_info_by_booking_no ( $date_change_no );
				$task_name = "Date Change Time Limit";
				$description = "Follow Up Date Change Time Limit for $date_change_no";
				$amount = $date_change_info ['total'];
				$user_name = $_SESSION ['user_name'];
				$ref_no = $date_change_no;
				$deadline = $issue_date;
				$type = "Date Change";
				$saved_by = $_SESSION ['user_name'];
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
				
				$smarty->assign ( 'page', "Booking" );
				$smarty->display ( 'date_change/date_change_view.tpl' );
			} else {
				$user_name = $_SESSION ['user_name'];
				$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
				$smarty->assign ( 'passenger_total_updated', $passenger_count );
				$smarty->assign ( 'error_message', "Dear $user_name, Please add all passengers details to confirm booking." );
				$smarty->assign ( 'page', "Booking" );
				$smarty->display ( 'date_change/passenger_detail.tpl' );
			}
		} 

		else {
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'date_change/passenger_detail.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Booking." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}