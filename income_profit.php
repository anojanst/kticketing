<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/report_functions.php';
include 'functions/invoice_functions.php';

$module_no = 47;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "income_profit") {
			
			$smarty->assign ( 'page', "income_profit" );
			$smarty->display ( 'income_profit/income_profit.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'list') {
			
			$branch = $_POST ['branch'];
			
			if ($branch == $_SESSION ['branch'] || $_SESSION ['branch'] == 'Head Office') {
				$_SESSION ['search_branch'] = $_POST ['branch'];
				$_SESSION ['from_date'] = $_POST ['from_date'];
				$_SESSION ['to_date'] = $_POST ['to_date'];
				
				$smarty->assign ( 'branch', $_SESSION ['search_branch'] );
				$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
				$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
				$smarty->assign ( 'search', "on" );
				$smarty->assign ( 'page', "income_profit" );
				$smarty->display ( 'income_profit/income_profit.tpl' );
			} 

			else {
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you can't Search other branch income profit" );
				
				$smarty->assign ( 'page', "income_profit" );
				$smarty->display ( 'income_profit/income_profit.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == "income_profit_print") {
			
			$smarty->assign ( 'branch', $_SESSION ['search_branch'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "income_profit" );
			$smarty->display ( 'income_profit_print/income_profit_print.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "income_profit" );
			$smarty->display ( 'income_profit/income_profit.tpl' );
		}
	} else {
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
