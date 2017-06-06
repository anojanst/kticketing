<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/itinerary_functions.php';
include 'functions/invoice_functions.php';
include 'functions/ledger_functions.php';
include 'functions/customer_functions.php';
include 'functions/embassy_functions.php';

$module_no = 22;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'itinerary_form') {
			unset ( $_SESSION ['itinerary_no'] );
			$smarty->assign ( 'itinerary_no', "$_SESSION[itinerary_no]" );
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "itinerary" );
			$smarty->display ( 'itinerary/itinerary.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'next') {
			if (! isset ( $_SESSION ['itinerary_no'] )) {
				$_SESSION ['itinerary_no'] = $itinerary_no = get_itinerary_no ();
				$_SESSION ['serial_no'] = $serial_no = get_serial_no ();
			} else {
			}
			
			$country = $_POST ['country'];
			$type = $_POST ['type'];
			$submit_date = $_POST ['submit_date'];
			$count = $_POST ['count'];
			
			$customers = explode ( " | ", $_POST ['customer'] );
			$customer = $customers [0];
			$mobile = $_POST ['mobile'];
			$itinerary_no = $_SESSION ['itinerary_no'];
			$serial_no = $_SESSION ['serial_no'];
			$user_name = $_SESSION ['user_name'];
			$branch = $_SESSION ['branch'];
			
			if ($customers [1]) {
				$customer_id = $customers [1];
			} else {
				$customer_id = get_customer_id ();
				save_customer ( $customer, $salute, $customer_id, $first_name, $last_name, $sex, $nationality, $dob, $address, $telephone, $mobile, $email, $passport_no, $passport, $issued_date, $expire_date );
			}
			
			if ($_REQUEST ['ok'] == "Save") {
				save_itinerary ( $itinerary_no, $serial_no, $country, $type, $customer, $customer_id, $count, $submit_date, $user_name, $branch );
			} else {
				update_itinerary ( $itinerary_no, $serial_no, $country, $type, $customer, $customer_id, $count, $submit_date, $user_name, $branch );
			}
			
			$itinerary_info = get_itinerary_info_by_itinerary_no ( $itinerary_no );
			
			$_SESSION ['passenger_total'] = $itinerary_info ['count'];
			$passenger_count = get_passenger_count ( $itinerary_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			
			$smarty->assign ( 'customer', "$itinerary_info[name] | $itinerary_info[customer_id]" );
			$smarty->assign ( 'count', "$itinerary_info[count]" );
			$smarty->assign ( 'submit_date', "$itinerary_info[submit_date]" );
			$smarty->assign ( 'type', "$itinerary_info[type]" );
			$smarty->assign ( 'itinerary_no', "$_SESSION[itinerary_no]" );
			$smarty->assign ( 'country', "$itinerary_info[country]" );
			
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "itinerary" );
			$smarty->display ( 'itinerary/itinerary.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add_flight') {
			$itinerary_no = $_SESSION ['itinerary_no'];
			$flight_no = $_POST ['flight_no'];
			$dep_air_port = $_POST ['dep_air_port'];
			$arr_air_port = $_POST ['arr_air_port'];
			$arr_time = $_POST ['arr_time'];
			$dep_time = $_POST ['dep_time'];
			
			add_flight ( $itinerary_no, $flight_no, $dep_air_port, $arr_air_port, $arr_time, $dep_time );
			
			$itinerary_info = get_itinerary_info_by_itinerary_no ( $itinerary_no );
			
			$smarty->assign ( 'customer', "$itinerary_info[name] | $itinerary_info[customer_id]" );
			$smarty->assign ( 'count', "$itinerary_info[count]" );
			$smarty->assign ( 'submit_date', "$itinerary_info[submit_date]" );
			$smarty->assign ( 'type', "$itinerary_info[type]" );
			$smarty->assign ( 'itinerary_no', "$_SESSION[itinerary_no]" );
			$smarty->assign ( 'country', "$itinerary_info[country]" );
			
			$_SESSION ['passenger_total'] = $itinerary_info ['count'];
			$passenger_count = get_passenger_count ( $itinerary_no );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "itinerary" );
			$smarty->display ( 'itinerary/itinerary.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'search') {
			$_SESSION ['itinerary_no'] = $itinerary_no = $_POST ['search'];
			$itinerary_info = get_itinerary_info_by_itinerary_no ( $_POST ['search'] );
			
			if ($itinerary_info ['status'] == 0) {
				$amount = 1500 * $itinerary_info [count];
				
				$smarty->assign ( 'customer', "$itinerary_info[name] | $itinerary_info[customer_id]" );
				$smarty->assign ( 'count', "$itinerary_info[count]" );
				$smarty->assign ( 'submit_date', "$itinerary_info[submit_date]" );
				$smarty->assign ( 'type', "$itinerary_info[type]" );
				$smarty->assign ( 'itinerary_no', "$_SESSION[itinerary_no]" );
				$smarty->assign ( 'country', "$itinerary_info[country]" );
				$smarty->assign ( 'amount', "$amount" );
				
				$smarty->assign ( 'air_port_names', list_air_ports () );
				
				$_SESSION ['passenger_total'] = $itinerary_info ['count'];
				$passenger_count = get_passenger_count ( $itinerary_no );
				
				$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
				$smarty->assign ( 'passenger_total_updated', $passenger_count );
				
				$smarty->assign ( 'page', "itinerary" );
				$smarty->display ( 'itinerary/itinerary.tpl' );
			} else {
				$_SESSION ['itinerary_no'] = $_POST ['search'];
				$itinerary_info = get_itinerary_info_by_itinerary_no ( $_POST ['search'] );
				$address_info = get_embassy_info ( $itinerary_info ['country'] );
				
				if ($itinerary_info [type] == "MALE") {
					$type = "his";
					$passengers = "passenger";
					$tense = "has";
					$tense2 = "this";
				} elseif ($itinerary_info [type] == "FEMALE") {
					$type = "her";
					$passengers = "passenger";
					$tense = "has";
					$tense2 = "this";
				} else {
					$type = "their";
					$passengers = "passengers";
					$tense = "have";
					$tense2 = "these";
				}
				$link = "itinerary.php?job=print&itinerary_no=$itinerary_no";
				
				$smarty->assign ( 'customer', "$itinerary_info[name] | $itinerary_info[customer_id]" );
				$smarty->assign ( 'count', "$itinerary_info[count]" );
				$smarty->assign ( 'submit_date', "$itinerary_info[submit_date]" );
				$smarty->assign ( 'link', "$link" );
				$smarty->assign ( 'type', "$type" );
				$smarty->assign ( 'tense', "$tense" );
				$smarty->assign ( 'tense2', "$tense2" );
				$smarty->assign ( 'passengers', "$passengers" );
				$smarty->assign ( 'itinerary_no', "$_SESSION[itinerary_no]" );
				$smarty->assign ( 'country', "$address_info[country]" );
				$smarty->assign ( 'amount', "$amount" );
				$smarty->assign ( 'address', "$address_info[address]" );
				
				$smarty->assign ( 'page', "itinerary" );
				$smarty->display ( 'itinerary/itinerary_view.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == 'add_passenger') {
			$itinerary_no = $_SESSION ['itinerary_no'];
			$passport_no = $_POST ['passport_no'];
			
			if ((check_repetive_passport_no ( $itinerary_no, $passport_no )) == 1) {
				$smarty->assign ( 'error_message', "Dear $user_name, you cant add repetive passport no." );
			} else {
				if ($passport_no) {
					add_passenger_to_itinerary ( $itinerary_no, $passport_no );
				}
			}
			$passenger_count = get_passenger_count ( $itinerary_no );
			
			$itinerary_info = get_itinerary_info_by_itinerary_no ( $itinerary_no );
			$amount = 1500 * $itinerary_info [count];
			
			$smarty->assign ( 'customer', "$itinerary_info[name] | $itinerary_info[customer_id]" );
			$smarty->assign ( 'count', "$itinerary_info[count]" );
			$smarty->assign ( 'submit_date', "$itinerary_info[submit_date]" );
			$smarty->assign ( 'type', "$itinerary_info[type]" );
			$smarty->assign ( 'itinerary_no', "$_SESSION[itinerary_no]" );
			$smarty->assign ( 'country', "$itinerary_info[country]" );
			$smarty->assign ( 'amount', "$amount" );
			
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'air_port_names', list_air_ports () );
			$smarty->assign ( 'page', "itinerary" );
			$smarty->display ( 'itinerary/itinerary.tpl' );
		} elseif ($_REQUEST ['job'] == 'delete_passenger') {
			$id = $_REQUEST ['id'];
			
			delete_passenger ( $id );
			
			$passenger_count = get_passenger_count ( $itinerary_no );
			$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
			$smarty->assign ( 'passenger_total_updated', $passenger_count );
			$smarty->assign ( 'page', "itinerary" );
			$smarty->display ( 'itinerary/itinerary.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'complete') {
			$itinerary_no = $_SESSION ['itinerary_no'];
			$amount = $_POST ['amount'];
			$off = $_POST ['off'];
			$first_time = $_POST ['first_time'];
			$total = $amount - $off;
			
			$passenger_count = get_passenger_count ( $itinerary_no );
			$passenger_total = $_SESSION ['passenger_total'];
			
			if ($passenger_count == $passenger_total) {
				complete_itinerary ( $itinerary_no, $amount, $off, $total, $first_time );
				generate_invoice_itinerary ( $itinerary_no );
				
				$itinerary_info = get_itinerary_info_by_itinerary_no ( $itinerary_no );
				$task_name = "Convert Itinerary to Ticket";
				$description = "Follow Up Ticket Time Limit for $itinerary_no";
				$amount = $date_change_info ['total'];
				$user_name = $_SESSION ['user_name'];
				$ref_no = $itinerary_no;
				$type = "Itinerary";
				$saved_by = $_SESSION ['user_name'];
				
				if ($itinerary_info ['country'] == "India") {
					$datetime = new DateTime ( $itinerary_info [submit_date] );
					$datetime->modify ( '+3 day' );
					$deadline = $datetime->format ( 'Y-m-d H:i:s' );
					
					save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
				} else {
					if ($first_time == "YES") {
						$datetime = new DateTime ( $itinerary_info [submit_date] );
						$datetime->modify ( '+14 day' );
						$deadline = $datetime->format ( 'Y-m-d H:i:s' );
						
						save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
						
						$datetime2 = new DateTime ( $itinerary_info [submit_date] );
						$datetime2->modify ( '+21 day' );
						$deadline2 = $datetime2->format ( 'Y-m-d H:i:s' );
						
						save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
					} else {
						$datetime = new DateTime ( $itinerary_info [submit_date] );
						$datetime->modify ( '+3 day' );
						$deadline = $datetime->format ( 'Y-m-d H:i:s' );
						save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
					}
				}
				
				$address_info = get_embassy_info ( $itinerary_info ['country'] );
				
				if ($itinerary_info [type] == "MALE") {
					$type = "his";
					$passengers = "passenger";
					$tense = "has";
					$tense2 = "this";
				} elseif ($itinerary_info [type] == "FEMALE") {
					$type = "her";
					$passengers = "passenger";
					$tense = "has";
					$tense2 = "this";
				} else {
					$type = "their";
					$passengers = "passengers";
					$tense = "have";
					$tense2 = "these";
				}
				$link = "itinerary.php?job=print&itinerary_no=$itinerary_no";
				
				$smarty->assign ( 'customer', "$itinerary_info[name] | $itinerary_info[customer_id]" );
				$smarty->assign ( 'count', "$itinerary_info[count]" );
				$smarty->assign ( 'submit_date', "$itinerary_info[submit_date]" );
				$smarty->assign ( 'link', "$link" );
				$smarty->assign ( 'type', "$type" );
				$smarty->assign ( 'tense', "$tense" );
				$smarty->assign ( 'tense2', "$tense2" );
				$smarty->assign ( 'passengers', "$passengers" );
				$smarty->assign ( 'itinerary_no', "$_SESSION[itinerary_no]" );
				$smarty->assign ( 'country', "$address_info[country]" );
				$smarty->assign ( 'amount', "$amount" );
				$smarty->assign ( 'address', "$address_info[address]" );
				
				$smarty->assign ( 'page', "itinerary" );
				$smarty->display ( 'itinerary/itinerary_view.tpl' );
			} else {
				$user_name = $_SESSION ['user_name'];
				$smarty->assign ( 'passenger_total', $_SESSION ['passenger_total'] );
				$smarty->assign ( 'passenger_total_updated', $passenger_count );
				$smarty->assign ( 'error_message', "Dear $user_name, Please add all passengers details to confirm Itinerary." );
				$smarty->assign ( 'page', "itinerary" );
				$smarty->display ( 'itinerary/itinerary.tpl' );
			}
		} elseif ($_REQUEST ['job'] == "print") {
			$_SESSION ['itinerary_no'] = $_REQUEST ['itinerary_no'];
			
			$itinerary_info = get_itinerary_info_by_itinerary_no ( $_REQUEST ['itinerary_no'] );
			$address_info = get_embassy_info ( $itinerary_info ['country'] );
			
			if ($itinerary_info [type] == "MALE") {
				$type = "his";
				$passengers = "passenger";
				$tense = "has";
				$tense2 = "this";
			} elseif ($itinerary_info [type] == "FEMALE") {
				$type = "her";
				$passengers = "passenger";
				$tense = "has";
				$tense2 = "this";
			} else {
				$type = "their";
				$passengers = "passengers";
				$tense = "have";
				$tense2 = "these";
			}
			$link = "itinerary.php?job=print&itinerary_no=$itinerary_no";
			
			$smarty->assign ( 'customer', "$itinerary_info[name] | $itinerary_info[customer_id]" );
			$smarty->assign ( 'count', "$itinerary_info[count]" );
			$smarty->assign ( 'submit_date', "$itinerary_info[submit_date]" );
			$smarty->assign ( 'link', "$link" );
			$smarty->assign ( 'type', "$type" );
			$smarty->assign ( 'tense', "$tense" );
			$smarty->assign ( 'tense2', "$tense2" );
			$smarty->assign ( 'passengers', "$passengers" );
			$smarty->assign ( 'itinerary_no', "$_SESSION[itinerary_no]" );
			$smarty->assign ( 'country', "$address_info[country]" );
			$smarty->assign ( 'amount', "$amount" );
			$smarty->assign ( 'address', "$address_info[address]" );
			
			$smarty->assign ( 'page', "itinerary" );
			$smarty->display ( 'itinerary/itinerary_print.tpl' );
		} else {
			$smarty->assign ( 'page', "itinerary" );
			$smarty->display ( 'itinerary/itinerary.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Iitinerary." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}