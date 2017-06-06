<?php
require_once 'conf/smarty-conf.php';
include 'functions/embassy_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 20;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "add_new") {
			$smarty->assign ( 'page', "Embassy Settings" );
			$smarty->display ( 'embassy/embassy.tpl' );
		}
		
		if ($_REQUEST ['job'] == 'add') {
			if ($_REQUEST ['ok'] == 'Save') {
				$embassy = $_POST ['embassy'];
				$country = $_POST ['country'];
				$address = addslashes ( $_POST ['address'] );
				$user_name = $_SESSION ['user_name'];
				
				save_embassy ( $embassy, $country, $address, $user_name );
				
				$smarty->assign ( 'page', "Embassy Settings" );
				$smarty->display ( 'embassy/embassy.tpl' );
			} else {
				$id = $_SESSION ['id'];
				$embassy = $_POST ['embassy'];
				$country = $_POST ['country'];
				$address = addslashes ( $_POST ['address'] );
				
				update_embassy ( $id, $embassy, $country, $address );
				
				$smarty->assign ( 'page', "Embassy Settings" );
				$smarty->display ( 'embassy/embassy.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_embassy_info_id ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'embassy', $info ['embassy'] );
			$smarty->assign ( 'country', $info ['country'] );
			$smarty->assign ( 'address', $info ['address'] );
			
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "Embassy Settings" );
			$smarty->display ( 'embassy/embassy.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Embassy Settings" );
			$smarty->display ( 'embassy/embassy.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_embassy ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "Embassy Settings" );
			$smarty->display ( 'embassy/embassy.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "Embassy Settings" );
			$smarty->display ( 'embassy/embassy.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Embassy Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}