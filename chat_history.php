<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';

$module_no = 42;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "chat_history") {
			unset ( $_SESSION ['to_user'] );
			unset ( $_SESSION ['from_user'] );
			
			$smarty->assign ( 'page', "Chat History" );
			$smarty->display ( 'chat_history/chat_history.tpl' );
		} elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['to_user'] = $_POST ['to_user'];
			$_SESSION ['from_user'] = $_POST ['from_user'];
			
			$smarty->assign ( 'to_user', $_SESSION ['to_user'] );
			$smarty->assign ( 'from_user', $_SESSION ['from_user'] );
			$smarty->assign ( 'page', "Chat History" );
			$smarty->display ( 'chat_history/chat_history.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "chat_history_print") {
			
			$smarty->assign ( 'to_user', $_SESSION ['to_user'] );
			$smarty->assign ( 'from_user', $_SESSION ['from_user'] );
			$smarty->assign ( 'page', "chat_history" );
			$smarty->display ( 'chat_history_print/chat_history_print.tpl' );
		} 

		else {
			unset ( $_SESSION ['to_user'] );
			unset ( $_SESSION ['from_user'] );
			
			$smarty->assign ( 'page', "Chat History" );
			$smarty->display ( 'chat_history/chat_history.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Chat history Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}