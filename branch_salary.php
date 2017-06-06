<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/salary_functions.php';

$module_no = 46;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "search_salary") {
			
			$smarty->assign ( 'page', "Branch salary" );
			$smarty->display ( 'branch_salary/branch_salary.tpl' );
		} elseif ($_REQUEST ['job'] == "search") {
			$branch = $_POST ['branch'];
			
			if ($branch == $_SESSION ['branch'] || $_SESSION ['branch'] == 'Head Office') {
				$_SESSION ['from_date'] = $_POST ['from_date'];
				$_SESSION ['to_date'] = $_POST ['to_date'];
				$_SESSION ['branch_name_search'] = $_POST ['branch_name_search'];
				
				$smarty->assign ( 'branch_name_search', $_SESSION ['branch_name_search'] );
				$smarty->assign ( 'from_date', $_SESSION ['from_date'] );
				$smarty->assign ( 'to_date', $_SESSION ['to_date'] );
				
				$smarty->assign ( 'page', "branch salary" );
				$smarty->assign ( 'search', "on" );
				$smarty->display ( 'branch_salary/branch_salary.tpl' );
			} 

			else {
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you can't Search other branch salary details" );
				
				$smarty->assign ( 'page', "Branch salary" );
				$smarty->display ( 'branch_salary/branch_salary.tpl' );
			}
		} 

		else {
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'page', "Branch salary" );
			$smarty->display ( 'branch_salary/branch_salary.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Search  Branch Salary Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}
