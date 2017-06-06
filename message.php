<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/message_functions.php';

$module_no = 60;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "message") {
			$smarty->assign ( 'page', "message" );
			$smarty->display ( 'message/message.tpl' );
		} 
		
		elseif ($_REQUEST['job'] == 'add') {
				
			$message = $_POST ['message'];
			$start_date = $_POST ['start_date'];
			$end_date= $_POST ['end_date'];
			
			$user_name = $_SESSION ['saved_by'];
			
			save_message($message, $start_date, $end_date);
		
			$smarty->assign ( 'page', "message" );
			$smarty->display ( 'message/message.tpl' );
				
		}	
		

		elseif ($_REQUEST['job'] == 'delete') {
			cancel_product($_REQUEST['id']);
		
			$smarty->assign ( 'page', "message" );
			$smarty->display ( 'message/message.tpl' );
		}
		
		else {
			$smarty->assign ( 'page', "message" );
			$smarty->display ( 'message/message.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Message" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}


