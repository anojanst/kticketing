<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/report_summary_functions.php';

$module_no = 58;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "report_summary") {
			
			$smarty->assign ( 'page', "report_summary" );
			$smarty->display ( 'report_summary/report_summary.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "report_summary" );
			$smarty->display ( 'report_summary/report_summary.tpl' );
		} 
		
		
		else {
			$smarty->assign ( 'page', "report_summary" );
			$smarty->display ( 'report_summary/report_summary.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Report Summary Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}


