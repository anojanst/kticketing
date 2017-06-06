<?php
require_once 'conf/smarty-conf.php';
include 'functions/nationality_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 8;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "add_new") {
			$smarty->assign ( 'page', "Nationality" );
			$smarty->display ( 'nationality/nationality.tpl' );
		}
		
		if ($_REQUEST ['job'] == 'add') {
			if ($_REQUEST ['ok'] == 'Save') {
				$nationality = $_POST ['nationality'];
				
				$user_name = $_SESSION ['user_name'];
				
				save_nationality ( $nationality, $user_name );
				
				$smarty->assign ( 'page', "Nationality" );
				$smarty->display ( 'nationality/nationality.tpl' );
			} else {
				$id = $_SESSION ['id'];
				$nationality = $_POST ['nationality'];
				
				update_nationality ( $id, $nationality );
				
				$smarty->assign ( 'page', "Nationality" );
				$smarty->display ( 'nationality/nationality.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_nationality_info_id ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'nationality', $info ['nationality'] );
			
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "Nationality" );
			$smarty->display ( 'nationality/nationality.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Nationality" );
			$smarty->display ( 'nationality/nationality.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_nationality ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "Nationality" );
			$smarty->display ( 'nationality/nationality.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "Nationality" );
			$smarty->display ( 'nationality/nationality.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Nationality Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}