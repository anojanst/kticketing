<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/telephone_functions.php';
include 'functions/todo_functions.php';
include 'functions/booking_functions.php';

$module_no = 48;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "view_telephone_no") {
			
			$smarty->assign ( 'page', "view_telephone_no" );
			$smarty->display ( 'view_telephone_no/view_telephone_no.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['customer_name'] = $_POST ['customer_name'];
			$_SESSION ['telephone_no'] = $_POST ['telephone_no'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', "view_telephone_no" );
			$smarty->display ( 'view_telephone_no/view_telephone_no.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'update') {
			
			$id = $_REQUEST ['id'];
			$type = $_POST ['type'];
			$reference = $_POST ['reference'];
			$ref_no = $_POST ['ref_no'];
			
			update_contact_status ( $id, $type, $reference, $ref_no );
			
			if ($type == 'Booked') {
				$telephone_info = get_telephone_info ( $id );
				$customer_name = $telephone_info ['customer_name'];
				$telephone_no = $telephone_info ['telephone_no'];
				$_SESSION ['call_id'] = $id;
				
				$task_name = "Collect money from customer";
				$description = "Customer Name : $customer_name, Telephone : $telephone_no";
				$user_name = $_SESSION ['user_name'];
				$type = $reference;
				$saved_by = $_SESSION ['user_name'];
				
				$date = date ( "Y-m-d H:i:s" );
				$datetime = new DateTime ( $date );
				$datetime->modify ( '+1 day' );
				$deadline = $datetime->format ( 'Y-m-d H:i:s' );
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by, $telephone_directory_id );
				unset ( $_SESSION ['call_id'] );
				
				if ($reference == 'Booking') {
					$booking_info = get_booking_info_by_booking_no ( $ref_no );
					$booking_no = $booking_info ['booking_no'];
					$way = $booking_info ['way'];
					$dep_date = $booking_info ['dep_date'];
					$dep_air_port = $booking_info ['dep_air_port'];
					$issue_date = $booking_info ['issue_date'];
					$_SESSION ['call_id'] = $id;
					
					$task_name = "Issue Ticket before $issue_date";
					$description = "Booking No: $booking_no, Way : $way, Dep Date :$dep_date, Dep Airport :$dep_air_port";
					$user_name = $_SESSION ['user_name'];
					$type = $reference;
					$saved_by = $_SESSION ['user_name'];
					
					$deadline = $issue_date;
					
					save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by, $telephone_directory_id );
					unset ( $_SESSION ['call_id'] );
				}
			} 

			elseif ($type == 'Issued') {
				$booking_info = get_booking_info_by_booking_no ( $ref_no );
				$booking_no = $booking_info ['booking_no'];
				$fare_id = $booking_info ['fare_id'];
				$dep_air_port = $booking_info ['dep_air_port'];
				$telephone_info = get_telephone_info ( $id );
				$telephone_no = $telephone_info ['telephone_no'];
				$customer_name = $telephone_info ['customer_name'];
				$fare_info = get_fare_detail ( $fare_id );
				$_SESSION ['call_id'] = $id;
				
				$task_name = "Remainder to the customer";
				$description = "Customer Name : $customer_name, Booking No: $booking_no, Depature Date :$fare_info[$dep_time], Dep Airport :$dep_air_port";
				$user_name = $_SESSION ['user_name'];
				$type = $reference;
				$saved_by = $_SESSION ['user_name'];
				
				$datetime = new DateTime ( $fare_info ['$dep_time'] );
				$datetime->modify ( '-1 day' );
				$deadline = $datetime->format ( 'Y-m-d H:i:s' );
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by, $telephone_directory_id );
				
				$task_name = "Verify customer about flight";
				
				$datetime = new DateTime ( $fare_info ['$dep_time'] );
				$datetime->modify ( '+1 day' );
				$deadline = $datetime->format ( 'Y-m-d H:i:s' );
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by, $telephone_directory_id );
				unset ( $_SESSION ['call_id'] );
			} 

			elseif ($type == '1stCall') {
				$booking_info = get_booking_info_by_booking_no ( $ref_no );
				$booking_no = $booking_info ['booking_no'];
				$fare_id = $booking_info ['fare_id'];
				$dep_air_port = $booking_info ['dep_air_port'];
				$telephone_info = get_telephone_info ( $id );
				$telephone_no = $telephone_info ['telephone_no'];
				$customer_name = $telephone_info ['customer_name'];
				$fare_info = get_fare_detail ( $fare_id );
				$_SESSION ['call_id'] = $id;
				
				$task_name = "Convert contact to customer(2nd call)";
				$description = "Customer Name : $customer_name, Booking No: $booking_no, Telephone No : $telephone_no";
				$user_name = $_SESSION ['user_name'];
				$type = $reference;
				$saved_by = $_SESSION ['user_name'];
				
				$date = date ( "Y-m-d H:i:s" );
				$datetime = new DateTime ( $date );
				$datetime->modify ( '+1 day' );
				$deadline = $datetime->format ( 'Y-m-d H:i:s' );
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by, $telephone_directory_id );
				unset ( $_SESSION ['call_id'] );
			} 

			elseif ($type == '2ndCall') {
				$booking_info = get_booking_info_by_booking_no ( $ref_no );
				$booking_no = $booking_info ['booking_no'];
				$fare_id = $booking_info ['fare_id'];
				$dep_air_port = $booking_info ['dep_air_port'];
				$telephone_info = get_telephone_info ( $id );
				$telephone_no = $telephone_info ['telephone_no'];
				$customer_name = $telephone_info ['customer_name'];
				$fare_info = get_fare_detail ( $fare_id );
				$_SESSION ['call_id'] = $id;
				
				$task_name = "Convert contact to customer(send SMS)";
				$description = "Customer Name : $customer_name, Booking No: $booking_no, Telephone No : $telephone_no";
				$user_name = $_SESSION ['user_name'];
				$type = $reference;
				$saved_by = $_SESSION ['user_name'];
				
				$date = date ( "Y-m-d H:i:s" );
				$datetime = new DateTime ( $date );
				$datetime->modify ( '+1 day' );
				$deadline = $datetime->format ( 'Y-m-d H:i:s' );
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by, $telephone_directory_id );
				unset ( $_SESSION ['call_id'] );
			} 

			elseif ($type == 'SMS') {
				$booking_info = get_booking_info_by_booking_no ( $ref_no );
				$booking_no = $booking_info ['booking_no'];
				$fare_id = $booking_info ['fare_id'];
				$dep_air_port = $booking_info ['dep_air_port'];
				$telephone_info = get_telephone_info ( $id );
				$telephone_no = $telephone_info ['telephone_no'];
				$customer_name = $telephone_info ['customer_name'];
				$fare_info = get_fare_detail ( $fare_id );
				$_SESSION ['call_id'] = $id;
				
				$task_name = "Convert contact to customer(Final Call)";
				$description = "Customer Name : $customer_name, Booking No: $booking_no, Telephone No : $telephone_no";
				$user_name = $_SESSION ['user_name'];
				$type = $reference;
				$saved_by = $_SESSION ['user_name'];
				
				$date = date ( "Y-m-d H:i:s" );
				$datetime = new DateTime ( $date );
				$datetime->modify ( '+1 day' );
				$deadline = $datetime->format ( 'Y-m-d H:i:s' );
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by, $telephone_directory_id );
				unset ( $_SESSION ['call_id'] );
			} 

			elseif ($type == 'Flew') {
				$booking_info = get_booking_info_by_booking_no ( $ref_no );
				$booking_no = $booking_info ['booking_no'];
				$fare_id = $booking_info ['fare_id'];
				$dep_air_port = $booking_info ['dep_air_port'];
				$telephone_info = get_telephone_info ( $id );
				$telephone_no = $telephone_info ['telephone_no'];
				$customer_name = $telephone_info ['customer_name'];
				$fare_info = get_fare_detail ( $fare_id );
				$_SESSION ['call_id'] = $id;
				
				$task_name = "Get a review from customer after Depature";
				$description = "Customer Name : $customer_name, Booking No: $booking_no, Telephone No : $telephone_no";
				$user_name = $_SESSION ['user_name'];
				$type = $reference;
				$saved_by = $_SESSION ['user_name'];
				
				$datetime = new DateTime ( $fare_info ['$arr_time'] );
				$datetime->modify ( '+2 day' );
				$deadline = $datetime->format ( 'Y-m-d H:i:s' );
				
				save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by, $telephone_directory_id );
				unset ( $_SESSION ['call_id'] );
			}
			
			$smarty->assign ( 'page', "view_telephone_no" );
			$smarty->display ( 'view_telephone_no/view_telephone_no.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'list') {
			
			$smarty->assign ( 'page', "view_telephone_no" );
			$smarty->display ( 'view_telephone_no/view_telephone_no.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_telephone_no ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "view_telephone_no" );
			$smarty->display ( 'view_telephone_no/view_telephone_no.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "view_telephone_no" );
			$smarty->display ( 'view_telephone_no/view_telephone_no.tpl' );
		}
	} 

	else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to telephone Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}