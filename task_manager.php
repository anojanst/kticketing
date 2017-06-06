<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/telephone_functions.php';
include 'functions/booking_functions.php';

$module_no = 43;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "task_manager") {
			unset ( $_SESSION ['task_name'] );
			unset ( $_SESSION ['ref_no'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "task_manager" );
			$smarty->display ( 'task_manager/task_manager.tpl' );
		} elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['task_name'] = $_POST ['task_name'];
			$_SESSION ['search_user_name'] = $_POST ['search_user_name'];
			$_SESSION ['ref_no'] = $_POST ['ref_no'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'task_name', $_SESSION ['task_name'] );
			$smarty->assign ( 'search_user_name', $_SESSION ['search_user_name'] );
			$smarty->assign ( 'ref_no', $_SESSION ['ref_no'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "task_manager" );
			$smarty->assign ( 'search', "on" );
			$smarty->display ( 'task_manager/task_manager.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "change_username") {
			unset ( $_SESSION ['task_name'] );
			unset ( $_SESSION ['ref_no'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			$id = $_REQUEST ['id'];
			$user_name = $_POST ['user_name'];
			get_task_info ( $id );
			
			$task_info = get_task_info ( $id );
			if ($task_info ['user_name'] == $_SESSION ['user_name'] || $task_info ['saved_by'] == $_SESSION ['user_name']) {
				$saved_by = $_SESSION ['user_name'];
				change_username ( $id, $user_name, $saved_by );
			} else {
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you can't edit other person's task" );
			}
			
			$smarty->assign ( 'page', "task_manager" );
			$smarty->display ( 'task_manager/task_manager.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'update') {
			unset ( $_SESSION ['task_name'] );
			unset ( $_SESSION ['ref_no'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			$id = $_REQUEST ['id'];
			$deadline = $_POST ['deadline'];
			get_task_info ( $id );
			
			$task_info = get_task_info ( $id );
			if ($task_info ['user_name'] == $_SESSION ['user_name'] || $task_info ['saved_by'] == $_SESSION ['user_name']) {
				update_deadline ( $id, $deadline );
			} else {
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you can't edit other person's task" );
			}
			
			$smarty->assign ( 'page', "task_manager" );
			$smarty->display ( 'task_manager/task_manager.tpl' );
		} elseif ($_REQUEST ['job'] == 'complete_task') {
			unset ( $_SESSION ['task_name'] );
			unset ( $_SESSION ['ref_no'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			$id = $_REQUEST ['id'];
			$status = 1;
			
			id;
			$task_info = get_task_info ( $id );
			if ($task_info ['user_name'] == $_SESSION ['user_name'] || $task_info ['saved_by'] == $_SESSION ['user_name']) {
				update_status ( $id, $status );
				if ($task_info ['telephone_directory_id'] > 0) {
					$telephone_info = get_telephone_info ( $task_info ['telephone_directory_id'] );
					if ($_REQUEST ['type'] == "Booked") {
						
						$type = "Booked";
					} else {
						
						$type = $telephone_info ['type'];
					}
					
					if ($type == 'Contact') {
						$type = '1stCall';
						update_contact_status ( $task_info ['telephone_directory_id'], $type, $reference, $ref_no );
						$booking_info = get_booking_info_by_booking_no ( $ref_no );
						$fare_id = $booking_info ['fare_id'];
						$dep_air_port = $booking_info ['dep_air_port'];
						$telephone_info = get_telephone_info ( $task_info ['telephone_directory_id'] );
						$telephone_no = $telephone_info ['telephone_no'];
						$customer_name = $telephone_info ['customer_name'];
						$fare_info = get_fare_detail ( $fare_id );
						$_SESSION ['call_id'] = $id;
						
						$task_name = "Convert contact to customer(2nd call)";
						$description = "Customer Name : $customer_name, Booking No: $ref_no, Telephone No : $telephone_no";
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

					elseif ($type == '1stCall') {
						$type = '2ndCall';
						update_contact_status ( $task_info ['telephone_directory_id'], $type, $reference, $ref_no );
						$booking_info = get_booking_info_by_booking_no ( $ref_no );
						$fare_id = $booking_info ['fare_id'];
						$dep_air_port = $booking_info ['dep_air_port'];
						$telephone_info = get_telephone_info ( $task_info ['telephone_directory_id'] );
						$telephone_no = $telephone_info ['telephone_no'];
						$customer_name = $telephone_info ['customer_name'];
						$fare_info = get_fare_detail ( $fare_id );
						$_SESSION ['call_id'] = $id;
						
						$task_name = "Convert contact to customer(SMS)";
						$description = "Customer Name : $customer_name, Booking No: $ref_no, Telephone No : $telephone_no";
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
						$type = 'SMS';
						update_contact_status ( $task_info ['telephone_directory_id'], $type, $reference, $ref_no );
						$booking_info = get_booking_info_by_booking_no ( $ref_no );
						$fare_id = $booking_info ['fare_id'];
						$dep_air_port = $booking_info ['dep_air_port'];
						$telephone_info = get_telephone_info ( $task_info ['telephone_directory_id'] );
						$telephone_no = $telephone_info ['telephone_no'];
						$customer_name = $telephone_info ['customer_name'];
						$fare_info = get_fare_detail ( $fare_id );
						$_SESSION ['call_id'] = $id;
						
						$task_name = "Convert contact to customer(Final Call)";
						$description = "Customer Name : $customer_name, Booking No: $ref_no, Telephone No : $telephone_no";
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
						$type = 'FinalCall';
						update_contact_status ( $id, $type, $reference, $ref_no );
						unset ( $_SESSION ['call_id'] );
					} 

					elseif ($type == 'FinalCall') {
					} 

					elseif ($type == 'Booked') {
						$type = 'Issued';
						update_contact_status ( $task_info ['telephone_directory_id'], $type, $reference, $ref_no );
						$telephone_info = get_telephone_info ( $task_info ['telephone_directory_id'] );
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
						$type = 'Flew';
						update_contact_status ( $task_info ['telephone_directory_id'], $type, $reference, $ref_no );
						$booking_info = get_booking_info_by_booking_no ( $ref_no );
						$fare_id = $booking_info ['fare_id'];
						$dep_air_port = $booking_info ['dep_air_port'];
						$telephone_info = get_telephone_info ( $task_info ['telephone_directory_id'] );
						$telephone_no = $telephone_info ['telephone_no'];
						$customer_name = $telephone_info ['customer_name'];
						$fare_info = get_fare_detail ( $fare_id );
						$_SESSION ['call_id'] = $id;
						
						$task_name = "Remainder to the customer";
						$description = "Customer Name : $customer_name, Booking No: $ref_no, Depature Date :$fare_info[$dep_time], Dep Airport :$dep_air_port";
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

					elseif ($type == 'Flew') {
						$type = 'Arrived';
						update_contact_status ( $id, $type, $reference, $ref_no );
						$booking_info = get_booking_info_by_booking_no ( $ref_no );
						$fare_id = $booking_info ['fare_id'];
						$dep_air_port = $booking_info ['dep_air_port'];
						$telephone_info = get_telephone_info ( $task_info ['telephone_directory_id'] );
						$telephone_no = $telephone_info ['telephone_no'];
						$customer_name = $telephone_info ['customer_name'];
						$fare_info = get_fare_detail ( $fare_id );
						$_SESSION ['call_id'] = $id;
						
						$task_name = "Get a review from customer after Depature";
						$description = "Customer Name : $customer_name, Booking No: $ref_no, Telephone No : $telephone_no";
						$user_name = $_SESSION ['user_name'];
						$type = $reference;
						$saved_by = $_SESSION ['user_name'];
						
						$datetime = new DateTime ( $fare_info ['$arr_time'] );
						$datetime->modify ( '+2 day' );
						$deadline = $datetime->format ( 'Y-m-d H:i:s' );
						
						save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by, $telephone_directory_id );
						unset ( $_SESSION ['call_id'] );
					}
				}
			} 

			else {
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you can't complete other person's task" );
			}
			$smarty->assign ( 'page', "task_manager" );
			$smarty->display ( 'task_manager/task_manager.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'quick_search') {
			unset ( $_SESSION ['task_name'] );
			unset ( $_SESSION ['ref_no'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			$id = $_REQUEST ['id'];
			$task_info = get_task_info ( $id );
			
			$_SESSION ['task_name'] = $task_info ['task_name'];
			if ($task_info ['ref_no'] > 0) {
				$_SESSION ['ref_no'] = $task_info ['ref_no'];
				
				$smarty->assign ( 'ref_no', $_SESSION ['ref_no'] );
			}
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'task_name', $_SESSION ['task_name'] );
			$smarty->assign ( 'page', "task_manager" );
			$smarty->display ( 'task_manager/task_manager.tpl' );
		} 

		else {
			unset ( $_SESSION ['task_name'] );
			unset ( $_SESSION ['ref_no'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "Task Manager" );
			$smarty->display ( 'task_manager/task_manager.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Task Manager" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}