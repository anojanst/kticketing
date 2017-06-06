<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/outstanding_functions.php';

$module_no = 51;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "outstanding_other_expenses") {
			
			$smarty->assign ( 'page', "outstanding_other_expenses" );
			$smarty->display ( 'outstanding_other_expenses/outstanding_other_expenses.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "search") {
			$_SESSION ['customer'] = $_POST ['customer'];
			$_SESSION ['from_date'] = $_POST ['from_date'];
			$_SESSION ['to_date'] = $_POST ['to_date'];
			
			$smarty->assign ( 'customer', $_SESSION ['customer'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "outstanding_other_expenses" );
			$smarty->display ( 'outstanding_other_expenses/outstanding_other_expenses.tpl' );
		} elseif ($_REQUEST ['job'] == "outstanding_other_expenses_print") {
			
			$smarty->assign ( 'customer', $_SESSION ['customer'] );
			$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
			$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
			$smarty->assign ( 'page', "outstanding_other_expenses" );
			$smarty->display ( 'outstanding_other_expenses_print/outstanding_other_expenses_print.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "outstanding_other_expenses" );
			$smarty->display ( 'outstanding_other_expenses/outstanding_other_expenses.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to outstanding other expenses Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}


