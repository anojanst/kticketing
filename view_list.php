<?php
require_once 'conf/smarty-conf.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 4;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "view_list") {
			$smarty->assign ( 'page', "View All" );
			$smarty->display ( 'todo/view_all.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "View All" );
			$smarty->display ( 'todo/view_all.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Access To Do." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}