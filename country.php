<?php
require_once 'conf/smarty-conf.php';
include 'functions/country_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 20;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "add_new") {
			$smarty->assign ( 'page', "Country" );
			$smarty->display ( 'country/country.tpl' );
		}
		
		if ($_REQUEST ['job'] == 'add') {
			if ($_REQUEST ['ok'] == 'Save') {
				$country = $_POST ['country'];
				
				$user_name = $_SESSION ['user_name'];
				
				save_country ( $country, $user_name );
				
				$smarty->assign ( 'page', "Country" );
				$smarty->display ( 'country/country.tpl' );
			} else {
				$id = $_SESSION ['id'];
				$country = $_POST ['country'];
				
				update_country ( $id, $country );
				
				$smarty->assign ( 'page', "Country" );
				$smarty->display ( 'country/country.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_country_info_id ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'country', $info ['country'] );
			
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "Country" );
			$smarty->display ( 'country/country.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Country" );
			$smarty->display ( 'country/country.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_country ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "Country" );
			$smarty->display ( 'country/country.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "Country" );
			$smarty->display ( 'country/country.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Country Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}