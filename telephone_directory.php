<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/telephone_functions.php';
include 'functions/todo_functions.php';

$module_no = 48;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "telephone_directory") {
			
			$smarty->assign ( 'page', "calls" );
			$smarty->display ( 'calls/calls.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "add") {
			
			$customer_name = $_POST ['customer_name'];
			$telephone_no = $_POST ['telephone_no'];
			$details = $_POST ['details'];
			$date = $_POST ['date'];
			$type = "Contact";
			add_telephone ( $customer_name, $telephone_no, $details, $date, $type );
			
			$_SESSION ['call_id'] = get_telephone_max_id ();
			
			$task_name = "Convert contact to customer";
			$description = "Customer Name : $customer_name, Telephone : $telephone_no, Regarding: $details ";
			
			$user_name = $_SESSION ['user_name'];
			$saved_by = $_SESSION ['user_name'];
			
			$date = date ( "Y-m-d H:i:s" );
			$datetime = new DateTime ( $date );
			$datetime->modify ( '+1 day' );
			$deadline = $datetime->format ( 'Y-m-d H:i:s' );
			
			save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
			
			unset ( $_SESSION ['call_id'] );
			
			$smarty->assign ( 'page', "calls" );
			$smarty->display ( 'calls/calls.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "calls" );
			$smarty->display ( 'calls/calls.tpl' );
		}
	} 

	else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to income & profit Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}