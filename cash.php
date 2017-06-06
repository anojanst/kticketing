<?php
require_once 'conf/smarty-conf.php';
include 'functions/cash_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 37;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "view_form") {
			unset ( $_SESSION ['search_branch'] );
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'branches', branches () );
			$smarty->assign ( 'page', "Cash" );
			$smarty->display ( 'cash/cash.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'list') {
			$_SESSION ['search_branch'] = $branch = $_POST ['branch'];
			unset ( $_SESSION ['from_date'] );
			unset ( $_SESSION ['to_date'] );
			
			$smarty->assign ( 'branches', branches () );
			$smarty->assign ( 'branch', $branch );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "Cash" );
			$smarty->display ( 'cash/cash.tpl' );
		} elseif ($_REQUEST ['job'] == 'list_full') {
			$branch = $_SESSION ['search_branch'];
			$_SESSION ['from_date'] = $from_date = $_POST ['from_date'];
			$_SESSION ['to_date'] = $to_date = $_POST ['to_date'];
			
			$smarty->assign ( 'branches', branches () );
			$smarty->assign ( 'branch', $branch );
			$smarty->assign ( 'from_date', $from_date );
			$smarty->assign ( 'to_date', $to_date );
			$smarty->assign ( 'search', "on" );
			$smarty->assign ( 'page', "Cash" );
			$smarty->display ( 'cash/cash.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Bank" );
			$smarty->display ( 'bank/add_bank.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_bank ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "Bank" );
			$smarty->display ( 'bank/add_bank.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "Bank" );
			$smarty->display ( 'bank/add_bank.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Bank" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}