<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/salary_functions.php';
include 'functions/other_expenses_functions.php';
include 'functions/customer_functions.php';
include 'functions/ledger_functions.php';

$module_no = 44;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "staff_salary") {
			unset ( $_SESSION ['salary_no'] );
			
			$smarty->assign ( 'page', "staff salary" );
			$smarty->display ( 'staff_salary/staff_salary.tpl' );
		} elseif ($_REQUEST ['job'] == "add_description") {
			
			if (! isset ( $_SESSION ['salary_no'] )) {
				$_SESSION ['salary_no'] = get_salary_no_from_salary_has_descriptions ();
			} else {
			}
			$salary_no = $_SESSION ['salary_no'];
			$description = $_POST ['description'];
			$detail = $_POST ['detail'];
			$amount = $_POST ['amount'];
			
			add_description ( $salary_no, $description, $detail, $amount );
			
			$smarty->assign ( 'total', get_salary_total ( $salary_no ) );
			$smarty->assign ( 'submit', "true" );
			$smarty->assign ( 'salary_no', $_SESSION ['salary_no'] );
			$smarty->assign ( 'saved_by', $_SESSION ['user_name'] );
			$smarty->assign ( 'page', "staff_salary" );
			$smarty->display ( 'staff_salary/staff_salary.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "delete_description") {
			$id = $_REQUEST ['id'];
			$salary_no = $_SESSION ['salary_no'];
			
			delete_salary_description ( $id );
			
			$smarty->assign ( 'total', get_salary_total ( $salary_no ) );
			$smarty->assign ( 'page', "staff_salary" );
			$smarty->display ( 'staff_salary/staff_salary.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "save") {
			
			$salary_no = $_POST ['salary_no'];
			$staff_name = $_POST ['staff_name'];
			$salary_date = $_POST ['salary_date'];
			$saved_by = $_POST ['saved_by'];
			
			add_salary ( $salary_no, $staff_name, $salary_date, $saved_by );
			generate_other_expenses_salary ( $salary_no );
			unset ( $_SESSION ['salary_no'] );
			
			$smarty->assign ( 'notice_s', "Staff $salary_no has been Saved." );
			$smarty->assign ( 'page', "staff_salary" );
			$smarty->display ( 'staff_salary/staff_salary.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "delete") {
			
			$salary_no = $_REQUEST ['salary_no'];
			$other_expenses_no = get_other_expenses_no_by_salary_no_info ( $salary_no );
			
			cancel_salary ( $salary_no );
			cancel_all_salary_description ( $salary_no );
			
			delete_other_expenses_description ( $other_expenses_no );
			delete_all_other_expenses_description_ledger ( $other_expenses_no );
			delete_other_expenses ( $other_expenses_no );
			delete_other_expenses_ledger ( $other_expenses_no );
			
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "Search salary" );
			$smarty->display ( 'search_salary/search_salary.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "view") {
			$salary_no = $_REQUEST ['salary_no'];
			
			$_SESSION ['salary_no_report'] = $salary_no;
			$salary_info = get_salary_info ( $salary_no );
			
			$smarty->assign ( 'staff_name', $salary_info ['staff_name'] );
			$smarty->assign ( 'saved_by', $salary_info [saved_by] );
			$smarty->assign ( 'date', $salary_info [salary_date] );
			$smarty->assign ( 'salary_no', $salary_info [salary_no] );
			
			$smarty->display ( 'salary_slip/salary_slip.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "staff_salary" );
			$smarty->display ( 'staff_salary/staff_salary.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Air Lines Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}