<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/target_functions.php';

$module_no = 62;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "branch_target_report") {
			
			$smarty->assign ( 'page', "branch_target_report" );
			$smarty->display ( 'branch_target_report/branch_target_report.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['branch'] = $_POST ['branch'];
			$_SESSION ['date'] = $_POST ['date'];
			
			$smarty->assign ( 'branch', $_SESSION ['branch'] );
			$smarty->assign ( 'date', $_SESSION ['date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "branch_target_report" );
			$smarty->display ( 'branch_target_report/branch_target_report.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "branch_target_report" );
			$smarty->display ( 'branch_target_report/branch_target_report.tpl' );
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

