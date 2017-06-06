<?php
require_once 'conf/smarty-conf.php';
include 'functions/bank_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 10;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "add_new") {
			$smarty->assign ( 'page', "Bank" );
			$smarty->display ( 'bank/add_bank.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'add') {
			if ($_REQUEST ['ok'] == 'Save') {
				$bank = $_POST ['bank'];
				$acc_num = $_POST ['acc_num'];
				$user_name = $_SESSION ['user_name'];
				
				save_bank ( $bank, $acc_num, $user_name );
				
				$smarty->assign ( 'page', "Bank" );
				$smarty->display ( 'bank/add_bank.tpl' );
			} else {
				$id = $_SESSION ['id'];
				$bank = $_POST ['bank'];
				$acc_num = $_POST ['acc_num'];
				$user_name = $_SESSION ['user_name'];
				
				update_bank ( $id, $bank, $acc_num, $user_name );
				
				$smarty->assign ( 'page', "Bank" );
				$smarty->display ( 'bank/add_bank.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_bank_info_id ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'bank', $info ['bank'] );
			$smarty->assign ( 'acc_num', $info ['acc_num'] );
			
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "Bank" );
			$smarty->display ( 'bank/add_bank.tpl' );
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