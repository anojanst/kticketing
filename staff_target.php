<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 56;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "staff_target") {
			
			$smarty->assign ( 'page', "staff_target" );
			$smarty->display ( 'staff_target/staff_target.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['staff_name'] = $_POST ['staff_name'];
			$_SESSION ['date'] = $_POST ['date'];
			
			$smarty->assign ( 'staff_name', $_SESSION ['staff_name'] );
			$smarty->assign ( 'date', $_SESSION ['date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "staff_target" );
			$smarty->display ( 'staff_target/staff_target.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "staff_target" );
			$smarty->display ( 'staff_target/staff_target.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Search  Staff Target Details" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}
