<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/customer_functions.php';


$module_no = 59;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "customer_birthday") {
			
			$smarty->assign ( 'page', "cusromer_birthday" );
			$smarty->display ( 'customer_birthday/customer_birthday.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['date'] = $_POST ['date'];
	
			
			$smarty->assign ( 'date', $_SESSION ['date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "cusromer_birthday" );
			$smarty->display ( 'customer_birthday/customer_birthday.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "customer_birthday" );
			$smarty->display ( 'customer_birthday/customer_birthday.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to customer birthday Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}

