<?php
require_once 'conf/smarty-conf.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 4;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "add_new") {
			$smarty->assign ( 'page', "Add New" );
			$smarty->display ( 'todo/add_new.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save") {
			
			$from = $_POST ['from'];
			$task_name = $_POST ['task_name'];
			$description = $_POST ['description'];
			$deadline = $_POST ['deadline'];
			$amount = $_POST ['amount'];
			$received = $_POST ['received'];
			$type = $_POST ['type'];
			if ($_POST ['to_user']) {
				$user_name = $_POST ['to_user'];
				$saved_by = $_SESSION ['user_name'];
			} else {
				$user_name = $_SESSION ['user_name'];
				$saved_by = $_SESSION ['user_name'];
			}
			
			if ($_POST ['status'] == "Done") {
				$status = 1;
			} else {
				$status = 0;
			}
			$ref_no = $_POST ['ref_no'];
			
			save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
			
			if ($from == 'user') {
				$smarty->assign ( 'page', "Home" );
				$smarty->display ( 'user_home/user_home.tpl' );
			} else {
				$smarty->assign ( 'page', "Add New" );
				$smarty->display ( 'todo/add_new.tpl' );
			}
		} 

		else {
			$smarty->assign ( 'page', "Add New" );
			$smarty->display ( 'todo/add_new.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Access To Do" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}