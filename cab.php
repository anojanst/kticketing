<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/cab_functions.php';
include 'functions/invoice_functions.php';
include 'functions/ledger_functions.php';
include 'functions/customer_functions.php';

$module_no = 18;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'cab_form') {
			unset ( $_SESSION ['cab_booking_no'] );
			$smarty->assign ( 'cab_booking_no', "$_SESSION[cab_booking_no]" );
			$smarty->assign ( 'page', "cab" );
			$smarty->display ( 'cab/cab.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search') {
			
			$cab_info = get_cab_info_by_cab_booking_no ( $_POST ['search'] );
			
			if ($cab_info ['status'] == 0) {
				if ($cab_info) {
					$smarty->assign ( 'search', "On" );
					$_SESSION ['cab_booking_no'] = $_POST ['search'];
					$cab_booking_no = $_SESSION ['cab_booking_no'];
				}
				
				$smarty->assign ( 'customer', "$cab_info[name] | $cab_info[customer_id]" );
				$smarty->assign ( 'mobile', "$cab_info[mobile]" );
				$smarty->assign ( 'start', "$cab_info[start]" );
				$smarty->assign ( 'end', "$cab_info[end]" );
				$smarty->assign ( 'count', "$cab_info[count]" );
				$smarty->assign ( 'vechicle_type', "$cab_info[vechicle_type]" );
				$smarty->assign ( 'app_distance', "$cab_info[app_distance]" );
				$smarty->assign ( 'days', "$cab_info[days]" );
				$smarty->assign ( 'start_date', "$cab_info[start_date]" );
				$smarty->assign ( 'end_date', "$cab_info[end_date]" );
				$smarty->assign ( 'status', "$cab_info[status]" );
				$smarty->assign ( 'confirm_date', "$cab_info[confirm_date]" );
				$smarty->assign ( 'cab_booking_no', "$_SESSION[cab_booking_no]" );
				
				if ($cab_info [status] != "Non Confirm") {
					
					$charges = get_charges_count ( $cab_booking_no );
					$invoiced = confirm_invoice ( $cab_booking_no );
					
					if ($charges >= 1 && $invoiced == 0) {
						$link = "cab.php?job=finish&cab_booking_no=$cab_booking_no";
						$smarty->assign ( 'finish', "on" );
						$smarty->assign ( 'link', "$link" );
					} elseif ($invoiced == 1) {
						$smarty->assign ( 'charge', "off" );
						
						$smarty->assign ( 'finish', "off" );
					}
					
					$smarty->assign ( 'driver', "$cab_info[driver]" );
					
					$smarty->assign ( 'page', "cab" );
					$smarty->display ( 'cab/cab_confirm.tpl' );
				} else {
					$smarty->assign ( 'search', "On" );
					$smarty->assign ( 'page', "cab" );
					$smarty->display ( 'cab/cab.tpl' );
				}
			} else {
				
				$_SESSION ['cab_booking_no'] = $_POST ['search'];
				
				$_SESSION ['id'] = $cab_info ['fare_id'];
				$smarty->assign ( 'page', "cab" );
				$smarty->display ( 'cab/cab_view.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == 'next') {
			$cab_booking_no = $_SESSION ['cab_booking_no'];
			$cab_info = get_cab_info_by_cab_booking_no ( $cab_booking_no );
			
			$smarty->assign ( 'page', "cab" );
			$smarty->display ( 'cab/cab_confirm.tpl' );
		} elseif ($_REQUEST ['job'] == 'save') {
			if ($_REQUEST ['main_ok'] == "Save") {
				$customers = explode ( " | ", $_POST ['customer'] );
				$customer = $customers [0];
				$mobile = $_POST ['mobile'];
				if ($customers [1]) {
					$customer_id = $customers [1];
				} else {
					$customer_id = get_customer_id ();
					save_customer ( $customer, $salute, $customer_id, $first_name, $last_name, $sex, $nationality, $dob, $address, $telephone, $mobile, $email, $passport_no, $passport, $issued_date, $expire_date );
				}
				
				$_SESSION ['cab_booking_no'] = $cab_booking_no = get_cab_booking_no ();
				$_SESSION ['serial_no'] = $serial_no = get_serial_no ();
				
				$start = $_POST ['start'];
				$end = $_POST ['end'];
				$count = $_POST ['count'];
				$vechicle_type = $_POST ['vechicle_type'];
				$app_distance = $_POST ['app_distance'];
				$days = $_POST ['days'];
				$start_date = $_POST ['start_date'];
				$end_date = $_POST ['end_date'];
				$status = $_POST ['status'];
				$confirm_date = $_POST ['confirm_date'];
				$user_name = $_SESSION ['user_name'];
				$branch = $_SESSION ['branch'];
				
				save_cab ( $cab_booking_no, $customer, $customer_id, $mobile, $start, $end, $count, $vechicle_type, $app_distance, $days, $start_date, $end_date, $status, $confirm_date, $user_name, $branch );
				
				$cab_info = get_cab_info_by_cab_booking_no ( $cab_booking_no );
				
				$task_name = "Confirm Cab";
				$description = "Follow Up Cab and confirm booking. Cab Booking No : $cab_booking_no";
				$deadline = $confirm_date;
				$user_name = $_SESSION ['user_name'];
				$ref_no = $cab_booking_no;
				$type = "Cab";
				$saved_by = $_SESSION ['user_name'];
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
				
				$smarty->assign ( 'customer', "$cab_info[name] | $cab_info[customer_id]" );
				$smarty->assign ( 'mobile', "$cab_info[mobile]" );
				$smarty->assign ( 'start', "$cab_info[start]" );
				$smarty->assign ( 'end', "$cab_info[end]" );
				$smarty->assign ( 'count', "$cab_info[count]" );
				$smarty->assign ( 'vechicle_type', "$cab_info[vechicle_type]" );
				$smarty->assign ( 'app_distance', "$cab_info[app_distance]" );
				$smarty->assign ( 'days', "$cab_info[days]" );
				$smarty->assign ( 'start_date', "$cab_info[start_date]" );
				$smarty->assign ( 'end_date', "$cab_info[end_date]" );
				$smarty->assign ( 'status', "$cab_info[status]" );
				$smarty->assign ( 'confirm_date', "$cab_info[confirm_date]" );
				$smarty->assign ( 'cab_booking_no', "$_SESSION[cab_booking_no]" );
				$smarty->assign ( 'search', "On" );
			} else {
				$customer = explode ( " | ", $_POST ['customer'] );
				$customer_id = $customer [1];
				$customer = $customer [0];
				$mobile = $_POST ['mobile'];
				
				$cab_booking_no = $_SESSION ['cab_booking_no'];
				$start = $_POST ['start'];
				$end = $_POST ['end'];
				$count = $_POST ['count'];
				$vechicle_type = $_POST ['vechicle_type'];
				$app_distance = $_POST ['app_distance'];
				$days = $_POST ['days'];
				$start_date = $_POST ['start_date'];
				$end_date = $_POST ['end_date'];
				$status = $_POST ['status'];
				$confirm_date = $_POST ['confirm_date'];
				$user_name = $_SESSION ['user_name'];
				$branch = $_SESSION ['branch'];
				
				update_cab ( $cab_booking_no, $customer, $customer_id, $mobile, $start, $end, $count, $vechicle_type, $app_distance, $days, $start_date, $end_date, $status, $confirm_date, $user_name, $branch );
				
				$cab_booking_no = $_SESSION ['cab_booking_no'];
				$cab_info = get_cab_info_by_cab_booking_no ( $cab_booking_no );
				
				$smarty->assign ( 'customer', "$cab_info[name] | $cab_info[customer_id]" );
				$smarty->assign ( 'mobile', "$cab_info[mobile]" );
				$smarty->assign ( 'start', "$cab_info[start]" );
				$smarty->assign ( 'end', "$cab_info[end]" );
				$smarty->assign ( 'count', "$cab_info[count]" );
				$smarty->assign ( 'vechicle_type', "$cab_info[vechicle_type]" );
				$smarty->assign ( 'app_distance', "$cab_info[app_distance]" );
				$smarty->assign ( 'days', "$cab_info[days]" );
				$smarty->assign ( 'start_date', "$cab_info[start_date]" );
				$smarty->assign ( 'end_date', "$cab_info[end_date]" );
				$smarty->assign ( 'status', "$cab_info[status]" );
				$smarty->assign ( 'confirm_date', "$cab_info[confirm_date]" );
				$smarty->assign ( 'cab_booking_no', "$_SESSION[cab_booking_no]" );
				$smarty->assign ( 'search', "On" );
			}
			$smarty->assign ( 'page', "cab" );
			$smarty->display ( 'cab/cab.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'confirm') {
			
			$cab_booking_no = $_SESSION ['cab_booking_no'];
			
			$vechicle_model = $_POST ['vechicle_model'];
			$vechicle_no = $_POST ['vechicle_no'];
			$driver = $_POST ['driver'];
			$license = $_POST ['license'];
			$driver_phone = $_POST ['driver_phone'];
			$pickup_time = $_POST ['pickup_time'];
			$status = "Confirm";
			
			update_cab_confirm ( $cab_booking_no, $vechicle_model, $vechicle_no, $driver, $license, $driver_phone, $pickup_time, $status );
			
			$cab_info = get_cab_info_by_cab_booking_no ( $cab_booking_no );
			
			$smarty->assign ( 'vechicle_model', "$cab_info[vechicle_model]" );
			$smarty->assign ( 'vechicle_no', "$cab_info[vechicle_no]" );
			$smarty->assign ( 'driver', "$cab_info[driver]" );
			$smarty->assign ( 'license', "$cab_info[license]" );
			$smarty->assign ( 'driver_phone', "$cab_info[driver_phone]" );
			$smarty->assign ( 'pickup_time', "$cab_info[pickup_time]" );
			
			$smarty->assign ( 'page', "cab" );
			$smarty->display ( 'cab/cab_confirm.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add_package') {
			$cab_booking_no = $_SESSION ['cab_booking_no'];
			$package = $_POST ['package'];
			
			add_package_to_cab_charges ( $cab_booking_no, $package );
			
			$cab_info = get_cab_info_by_cab_booking_no ( $cab_booking_no );
			
			$charges = get_charges_count ( $cab_booking_no );
			$invoiced = confirm_invoice ( $cab_booking_no );
			if ($charges >= 1 && $invoiced == 0) {
				$link = "cab.php?job=finish&cab_booking_no=$cab_booking_no";
				$smarty->assign ( 'finish', "on" );
				$smarty->assign ( 'link', "$link" );
			} elseif ($invoiced == 1) {
				$smarty->assign ( 'charge', "off" );
				
				$smarty->assign ( 'finish', "off" );
			}
			
			$smarty->assign ( 'vechicle_model', "$cab_info[vechicle_model]" );
			$smarty->assign ( 'vechicle_no', "$cab_info[vechicle_no]" );
			$smarty->assign ( 'driver', "$cab_info[driver]" );
			$smarty->assign ( 'license', "$cab_info[license]" );
			$smarty->assign ( 'driver_phone', "$cab_info[driver_phone]" );
			$smarty->assign ( 'pickup_time', "$cab_info[pickup_time]" );
			$smarty->assign ( 'page', "cab" );
			$smarty->display ( 'cab/cab_confirm.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete_charge') {
			$id = $_REQUEST ['id'];
			$cab_booking_no = $_SESSION ['cab_booking_no'];
			
			delete_package_from_cab_charges ( $id );
			
			$cab_info = get_cab_info_by_cab_booking_no ( $cab_booking_no );
			
			$charges = get_charges_count ( $cab_booking_no );
			$invoiced = confirm_invoice ( $cab_booking_no );
			
			if ($charges >= 1 && $invoiced == 0) {
				$link = "cab.php?job=finish&cab_booking_no=$cab_booking_no";
				$smarty->assign ( 'finish', "on" );
				$smarty->assign ( 'link', "$link" );
			} elseif ($invoiced == 1) {
				$smarty->assign ( 'charge', "off" );
				
				$smarty->assign ( 'finish', "off" );
			}
			
			$smarty->assign ( 'vechicle_model', "$cab_info[vechicle_model]" );
			$smarty->assign ( 'vechicle_no', "$cab_info[vechicle_no]" );
			$smarty->assign ( 'driver', "$cab_info[driver]" );
			$smarty->assign ( 'license', "$cab_info[license]" );
			$smarty->assign ( 'driver_phone', "$cab_info[driver_phone]" );
			$smarty->assign ( 'pickup_time', "$cab_info[pickup_time]" );
			$smarty->assign ( 'page', "cab" );
			$smarty->display ( 'cab/cab_confirm.tpl' );
		} elseif ($_REQUEST ['job'] == 'print') {
			$cab_booking_no = $_REQUEST ['cab_booking_no'];
			
			$cab_info = get_cab_info_by_cab_booking_no ( $cab_booking_no );
			
			$smarty->assign ( 'cab_booking_no', "$cab_info[cab_booking_no]" );
			$smarty->assign ( 'saved_by', "$cab_info[saved_by]" );
			
			$smarty->assign ( 'page', "cab" );
			$smarty->display ( 'cab/cab_print.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'finish') {
			$cab_booking_no = $_REQUEST ['cab_booking_no'];
			
			$total = get_cab_total ( $cab_booking_no );
			
			complete_cab ( $cab_booking_no, $total );
			generate_invoice_cab ( $cab_booking_no );
			
			$smarty->assign ( 'page', "cab" );
			$smarty->display ( 'cab/cab_view.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "cab" );
			$smarty->display ( 'cab/cab.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Cab." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}