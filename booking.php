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

$module_no = 5;
unset ( $_SESSION ['serial_no'] );
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'booking_form') {
			unset ( $_SESSION ['booking_no'] );
			unset ( $_SESSION ['fare_id'] );
			
			$smarty->assign ( 'air_line_names', list_air_lines () );
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/booking.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add_item') {
			$booking_type = "TICKET";
			if (! isset ( $_SESSION ['booking_no'] )) {
				
				$_SESSION ['booking_no'] = $booking_no = get_booking_no ( $booking_type );
				$serial_no = get_serial_no ( $booking_type );
			} else {
			}
			
			$air_line_code = $_POST ['air_line_code'];
			$class = $_POST ['class'];
			$type = $_POST ['type'];
			$fare = $_POST ['fare'];
            $markup = $_POST ['markup'];
            $tax = $_POST ['tax'];
			$total = $_POST ['total'];
			$passenger_type=$_POST['passenger_type'];
			$dep_time = $_POST ['dep_time'];
			$arr_time = $_POST ['arr_time'];
			$rtn_dep_time = $_POST ['rtn_dep_time'];
			$rtn_arr_time = $_POST ['rtn_arr_time'];
			$user_name = $_SESSION ['user_name'];
			$offer_code = $_POST ['offer_code'];
			
			$booking_no = $_SESSION ['booking_no'];
			$booking_info = get_booking_info_by_booking_no ( $booking_no );
			
			save_booking_item ( $booking_no, $serial_no, $booking_type, $air_line_code, $class, $type, $fare, $tax, $markup, $passenger_type, $total, $dep_time, $arr_time, $rtn_dep_time, $rtn_arr_time, $offer_code, $user_name );
			
			if ($booking_info) {
				$smarty->assign ( 'customer', "$booking_info[name] | $booking_info[customer_id]" );
			}
			$smarty->assign ( 'mobile', "$booking_info[mobile]" );
			$smarty->assign ( 'phone', "$booking_info[phone]" );
			$smarty->assign ( 'email', "$booking_info[email]" );
			$smarty->assign ( 'booking_no', "$_SESSION[booking_no]" );
			$smarty->assign ( 'way', "$booking_info[way]" );
			$smarty->assign ( 'dep_air_port', "$booking_info[dep_air_port]" );
			$smarty->assign ( 'arr_air_port', "$booking_info[arr_air_port]" );
			$smarty->assign ( 'dep_date', "$booking_info[dep_date]" );
			$smarty->assign ( 'rtn_date', "$booking_info[rtn_date]" );
			$smarty->assign ( 'adult', "$booking_info[adult]" );
			$smarty->assign ( 'child', "$booking_info[child]" );
			$smarty->assign ( 'infant', "$booking_info[infant]" );
			$smarty->assign ( 'currency', "$booking_info[currency]" );
			$smarty->assign ( 'address', "$booking_info[address]" );
			$smarty->assign ( 'note', "$booking_info[note]" );
			
			$smarty->assign ( 'air_line_names', list_air_lines () );
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/booking.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search') {
			
			$booking_info = get_booking_info_by_booking_no ( $_POST ['search'] );
			$booking_no=$_POST['search'];

			if ($booking_info ['status'] == 0) {
				if ($booking_info) {
					$smarty->assign ( 'search', "On" );
					$_SESSION ['booking_no'] = $_POST ['search'];
					$booking_no = $_SESSION ['booking_no'];
				}
				
				$smarty->assign ( 'customer', "$booking_info[name] | $booking_info[customer_id]" );
				$smarty->assign ( 'mobile', "$booking_info[mobile]" );
				$smarty->assign ( 'phone', "$booking_info[phone]" );
				$smarty->assign ( 'email', "$booking_info[email]" );
				$smarty->assign ( 'booking_no', "$_SESSION[booking_no]" );
				$smarty->assign ( 'way', "$booking_info[way]" );
				$smarty->assign ( 'dep_air_port', "$booking_info[dep_air_port]" );
				$smarty->assign ( 'arr_air_port', "$booking_info[arr_air_port]" );
				$smarty->assign ( 'dep_date', "$booking_info[dep_date]" );
				$smarty->assign ( 'rtn_date', "$booking_info[rtn_date]" );
				$smarty->assign ( 'adult', "$booking_info[adult]" );
				$smarty->assign ( 'child', "$booking_info[child]" );
				$smarty->assign ( 'infant', "$booking_info[infant]" );
				$smarty->assign ( 'currency', "$booking_info[currency]" );
				$smarty->assign ( 'address', "$booking_info[address]" );
				$smarty->assign ( 'note', "$booking_info[note]" );
				
				$smarty->assign ( 'air_line_names', list_air_lines () );
				$smarty->assign ( 'air_port_names', list_air_ports () );
				
				if ((check_passengers ( $booking_no )) == 1) {
					$_SESSION ['passenger_total'] = $booking_info ['adult'] + $booking_info ['child'] + $booking_info ['infant'];
					$passenger_count = get_passenger_count ( $booking_no );
					$_SESSION ['id'] = $booking_info ['fare_id'];
					
					$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
					$smarty->assign ( 'passenger_total_updated', $passenger_count );
					$smarty->assign ( 'page', "Booking" );
					$smarty->display ( 'booking/passenger_detail.tpl' );
				} else {
					$smarty->assign ( 'page', "Booking" );
					$smarty->display ( 'booking/booking.tpl' );
				}
			} else {
				$_SESSION ['booking_no'] = $_POST ['search'];
				
				$_SESSION ['id'] = $booking_info ['fare_id'];
				$smarty->assign ( 'page', "Booking" );
				$smarty->display ( 'booking/booking_view.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == 'from_non_confim') {
			$_SESSION ['booking_no'] = $_REQUEST ['booking_no'];
			$booking_no = $_SESSION ['booking_no'];
			$booking_info = get_booking_info_by_booking_no ( $booking_no );
			
			$smarty->assign ( 'customer', "$booking_info[name] | $booking_info[customer_id]" );
			$smarty->assign ( 'mobile', "$booking_info[mobile]" );
			$smarty->assign ( 'phone', "$booking_info[phone]" );
			$smarty->assign ( 'email', "$booking_info[email]" );
			$smarty->assign ( 'booking_no', "$_SESSION[booking_no]" );
			$smarty->assign ( 'way', "$booking_info[way]" );
			$smarty->assign ( 'dep_air_port', "$booking_info[dep_air_port]" );
			$smarty->assign ( 'arr_air_port', "$booking_info[arr_air_port]" );
			$smarty->assign ( 'dep_date', "$booking_info[dep_date]" );
			$smarty->assign ( 'rtn_date', "$booking_info[rtn_date]" );
			$smarty->assign ( 'adult', "$booking_info[adult]" );
			$smarty->assign ( 'child', "$booking_info[child]" );
			$smarty->assign ( 'infant', "$booking_info[infant]" );
			$smarty->assign ( 'currency', "$booking_info[currency]" );
			$smarty->assign ( 'address', "$booking_info[address]" );
			$smarty->assign ( 'note', "$booking_info[note]" );
			
			$smarty->assign ( 'air_line_names', list_air_lines () );
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'search', "On" );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/booking.tpl' );
		} elseif ($_REQUEST ['job'] == 'save') {
			if ($_REQUEST ['main_ok'] == "Save") {
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
				
				$way = $_POST ['way'];
				$dep_air_port = $_POST ['dep_air_port'];
				$arr_air_port = $_POST ['arr_air_port'];
				$dep_date = $_POST ['dep_date'];
				$rtn_date = $_POST ['rtn_date'];
				$adult = $_POST ['adult'];
				$child = $_POST ['child'];
				$infant = $_POST ['infant'];
				$currency = $_POST ['currency'];
				$note = $_POST ['note'];
				$booking_no = $_SESSION ['booking_no'];
				$user_name = $_SESSION ['user_name'];
				$branch = $_SESSION ['branch'];
				
				$info = get_booking_type ( $booking_no );
				$booking_type = $info ['booking_type'];
				save_booking ( $booking_no, $booking_type, $customer, $customer_id, $mobile, $phone, $email, $way, $dep_air_port, $arr_air_port, $dep_date, $rtn_date, $adult, $child, $infant, $currency, $address, $note, $user_name, $branch );
				
				$booking_info = get_booking_info_by_booking_no ( $booking_no );
				
				$smarty->assign ( 'customer', "$booking_info[name] | $booking_info[customer_id]" );
				$smarty->assign ( 'mobile', "$booking_info[mobile]" );
				$smarty->assign ( 'phone', "$booking_info[phone]" );
				$smarty->assign ( 'email', "$booking_info[email]" );
				$smarty->assign ( 'booking_no', "$_SESSION[booking_no]" );
				$smarty->assign ( 'way', "$booking_info[way]" );
				$smarty->assign ( 'dep_air_port', "$booking_info[dep_air_port]" );
				$smarty->assign ( 'arr_air_port', "$booking_info[arr_air_port]" );
				$smarty->assign ( 'dep_date', "$booking_info[dep_date]" );
				$smarty->assign ( 'rtn_date', "$booking_info[rtn_date]" );
				$smarty->assign ( 'adult', "$booking_info[adult]" );
				$smarty->assign ( 'child', "$booking_info[child]" );
				$smarty->assign ( 'infant', "$booking_info[infant]" );
				$smarty->assign ( 'currency', "$booking_info[currency]" );
				$smarty->assign ( 'address', "$booking_info[address]" );
				$smarty->assign ( 'note', "$booking_info[note]" );
				$smarty->assign ( 'search', "On" );
			} else {
				$customer = explode ( " | ", $_POST ['customer'] );
				$customer_id = $customer [1];
				$customer = $customer [0];
				$mobile = $_POST ['mobile'];
				$phone = $_POST ['phone'];
				$email = $_POST ['email'];
				$address = $_POST ['address'];
				
				$booking_no = $_SESSION ['booking_no'];
				$way = $_POST ['way'];
				$dep_air_port = $_POST ['dep_air_port'];
				$arr_air_port = $_POST ['arr_air_port'];
				$dep_date = $_POST ['dep_date'];
				$rtn_date = $_POST ['rtn_date'];
				$adult = $_POST ['adult'];
				$child = $_POST ['child'];
				$infant = $_POST ['infant'];
				$currency = $_POST ['currency'];
				$note = $_POST ['note'];
				$user_name = $_SESSION ['user_name'];
				
				update_booking ( $booking_no, $customer, $customer_id, $mobile, $phone, $email, $way, $dep_air_port, $arr_air_port, $dep_date, $rtn_date, $adult, $child, $infant, $currency, $address, $note, $user_name, $branch );
				
				$booking_no = $_SESSION ['booking_no'];
				$booking_info = get_booking_info_by_booking_no ( $booking_no );
				
				$smarty->assign ( 'customer', "$booking_info[name] | $booking_info[customer_id]" );
				$smarty->assign ( 'mobile', "$booking_info[mobile]" );
				$smarty->assign ( 'phone', "$booking_info[phone]" );
				$smarty->assign ( 'email', "$booking_info[email]" );
				$smarty->assign ( 'booking_no', "$_SESSION[booking_no]" );
				$smarty->assign ( 'way', "$booking_info[way]" );
				$smarty->assign ( 'dep_air_port', "$booking_info[dep_air_port]" );
				$smarty->assign ( 'arr_air_port', "$booking_info[arr_air_port]" );
				$smarty->assign ( 'dep_date', "$booking_info[dep_date]" );
				$smarty->assign ( 'rtn_date', "$booking_info[rtn_date]" );
				$smarty->assign ( 'adult', "$booking_info[adult]" );
				$smarty->assign ( 'child', "$booking_info[child]" );
				$smarty->assign ( 'infant', "$booking_info[infant]" );
				$smarty->assign ( 'currency', "$booking_info[currency]" );
				$smarty->assign ( 'address', "$booking_info[address]" );
				$smarty->assign ( 'note', "$booking_info[note]" );
				$smarty->assign ( 'search', "On" );
			}
			$smarty->assign ( 'air_line_names', list_air_lines () );
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/booking.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'passenger_detail') {
			
			$booking_no = $_SESSION ['booking_no'] =  $_REQUEST ['booking_no'];
			$id = $_SESSION ['id'] = $_REQUEST ['id'];
			$booking_info = get_booking_info_by_booking_no ( $booking_no );
			$fare_info = get_fare_detail ( $id );
			
			if (check_customer( $booking_info ['name'] ) == 1) {
				
				$_SESSION ['passenger_total'] = $booking_info ['adult'] + $booking_info ['child'] + $booking_info ['infant'];
				$passenger_count = get_passenger_count ( $booking_no );
				
				update_fare_id ( $booking_no, $id );
				
				$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
				$smarty->assign ( 'passenger_total_updated', $passenger_count );
				$smarty->assign ( 'page', "Booking" );
				$smarty->display ( 'booking/passenger_detail.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == 'add_passenger') {
			$booking_no = $_SESSION ['booking_no'];
			$passport_no = $_POST ['passport_no'];
			
			if ((check_repetive_passport_no ( $booking_no, $passport_no )) == 1) {
				$smarty->assign ( 'error_message', "Dear $user_name, you cant add repetive passport no." );
			} else {
				$filename = stripslashes ( $_FILES ['visa_copy'] ['name'] );
				if ($filename) {
					$extension = getExtension ( $filename );
					$extension = strtolower ( $extension );
					$file_name = $booking_no . '-' . $passport_no . '.' . $extension;
					$newname = "visa_copy/" . $file_name;
					$copied = copy ( $_FILES ['visa_copy'] ['tmp_name'], $newname );
					$visa_copy = $newname;
				} else {
					$visa_copy = "";
				}
				if ($passport_no) {
					add_passenger_to_booking ( $booking_no, $passport_no, $visa_copy );
				}
			}
			$passenger_count = get_passenger_count ( $booking_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/passenger_detail.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add_visa') {
			$booking_no = $_REQUEST ['booking_no'];
			$passport_no = $_REQUEST ['passport_no'];
			
			$filename = stripslashes ( $_FILES ['visa_copy'] ['name'] );
			$extension = getExtension ( $filename );
			$extension = strtolower ( $extension );
			$file_name = $booking_no . '-' . $passport_no . '.' . $extension;
			$newname = "visa_copy/" . $file_name;
			$copied = copy ( $_FILES ['visa_copy'] ['tmp_name'], $newname );
			$visa_copy = $newname;
			
			add_visa ( $booking_no, $passport_no, $visa_copy );
			
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/booking_view.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete_passenger') {
			$id = $_REQUEST ['id'];
			
			delete_passenger ( $id );
			
			$passenger_count = get_passenger_count ( $booking_no );
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/passenger_detail.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'booking_complete') {
			$booking_no = $_SESSION ['booking_no'];
			$pnr = $_POST ['pnr'];
			$al_ref = $_POST ['al_ref'];
			$issue_date = $_POST ['issue_date'];
			$transits = $_POST ['transits'];
			$flight_no = $_POST ['flight_no'];
			$rtn_flight_no = $_POST ['rtn_flight_no'];
			$passenger_count = get_passenger_count ( $booking_no );
			$passenger_total = $_SESSION ['passenger_total'];
			
			if ($passenger_count == $passenger_total) {
				complete_booking ( $booking_no, $pnr, $al_ref, $issue_date, $transits, $flight_no, $rtn_flight_no );
				generate_invoice ( $booking_no );
				
				$booking_info = get_booking_info_by_booking_no ( $booking_no );
				$task_name = "Ticket Time Limit";
				$description = "Follow Up Ticket Time Limit for $booking_no";
				$deadline = $issue_date;
				$amount = $date_change_info ['total'];
				$user_name = $_SESSION ['user_name'];
				$ref_no = $booking_no;
				$type = "Booking";
				$saved_by = $_SESSION ['user_name'];
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
				
				$smarty->assign ( 'page', "Booking" );
				$smarty->display ( 'booking/booking_view.tpl' );
			} else {
				$user_name = $_SESSION ['user_name'];
				$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
				$smarty->assign ( 'passenger_total_updated', $passenger_count );
				$smarty->assign ( 'error_message', "Dear $user_name, Please add all passengers details to confirm booking." );
				$smarty->assign ( 'page', "Booking" );
				$smarty->display ( 'booking/passenger_detail.tpl' );
			}
		} elseif ($_REQUEST ['job'] == "view") {
			$_SESSION ['booking_no'] = $_REQUEST ['booking_no'];
			
			$booking_info = get_booking_info_by_booking_no ( $_SESSION ['booking_no'] );
			
			$_SESSION ['id'] = $booking_info ['fare_id'];
			
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/booking_view.tpl' );
		} 

		else {
			unset ( $_SESSION ['booking_no'] );
			unset ( $_SESSION ['fare_id'] );
			
			$smarty->assign ( 'page', "Booking" );
			$smarty->display ( 'booking/passenger_detail.tpl' );
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
