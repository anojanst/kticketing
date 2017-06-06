<?php
require_once 'conf/smarty-conf.php';
include 'functions/ip_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/user_functions.php';
$module_no = 40;

if ($_SESSION ['login'] == 1) {
	
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "ip_form") {
			
			unset ( $_SESSION ['search_user_name'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', 'IP Table' );
			$smarty->display ( 'ip/ip.tpl' );
		} elseif ($_REQUEST ['job'] == "search_form") {
			unset ( $_SESSION ['search_user_name'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', 'IP Table' );
			$smarty->display ( 'ip/ip.tpl' );
		} elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['search_user_name'] = $_POST ['user_name'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'page', 'IP Table' );
			$smarty->display ( 'ip/ip.tpl' );
		} else {
			unset ( $_SESSION ['search_user_name'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', 'IP Table' );
			$smarty->display ( 'ip/ip.tpl' );
		}
	} 

	else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access IP Table." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'page', "Login" );
	$smarty->display ( 'login/login.tpl' );
}