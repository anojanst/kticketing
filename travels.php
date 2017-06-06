<?php
require_once 'conf/smarty-conf.php';
include 'functions/travels_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 6;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "add_new") {
			$smarty->assign ( 'page', "Travels" );
			$smarty->display ( 'travels/travels.tpl' );
		}
		
		if ($_REQUEST ['job'] == 'add') {
			if ($_REQUEST ['ok'] == 'Save') {
				$travels = $_POST ['travels'];
				$user_name = $_SESSION ['user_name'];
				
				save_travels ( $travels, $travels_code, $off, $percent, $user_name );
				
				$smarty->assign ( 'page', "Travels" );
				$smarty->display ( 'travels/travels.tpl' );
			} else {
				$id = $_SESSION ['id'];
				$travels = $_POST ['travels'];
				$user_name = $_SESSION ['user_name'];
				
				update_travels ( $id, $travels, $travels_code, $off, $percent, $user_name );
				
				$smarty->assign ( 'page', "Travels" );
				$smarty->display ( 'travels/travels.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_travels_info_id ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'travels', $info ['travels'] );
			
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "Travels" );
			$smarty->display ( 'travels/travels.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Travels" );
			$smarty->display ( 'travels/travels.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_travels ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "Travels" );
			$smarty->display ( 'travels/travels.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "Travels" );
			$smarty->display ( 'travels/travels.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Travels Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}