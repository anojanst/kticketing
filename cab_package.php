<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/cab_functions.php';

$module_no = 7;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if($_REQUEST['job']=="cab_package_form"){
			$smarty->assign ( 'page', "Cab Package" );
			$smarty->display ( 'cab_package/cab_package.tpl' );
		}
		elseif($_REQUEST['job']=="add"){
			if ($_REQUEST['ok'] == 'Save') {
				
				$cab_package_code = $_POST ['cab_package_code'];
				$rate = $_POST ['rate'];
				$type = $_POST ['type'];
				$user_name = $_SESSION ['user_name'];
					
				save_cab_package ($cab_package_code, $rate, $type, $user_name);
					
				$smarty->assign ( 'page', "Cab Package" );
				$smarty->display ( 'cab_package/cab_package.tpl' );
			}
			else{
				$id=$_SESSION['id'];
				$cab_package_code = $_POST ['cab_package_code'];
				$rate = $_POST ['rate'];
				$type = $_POST ['type'];
				$user_name = $_SESSION ['user_name'];
					
				update_cab_package ($id, $cab_package_code, $rate, $type, $user_name);
					
				$smarty->assign ( 'page', "Cab Package" );
				$smarty->display ( 'cab_package/cab_package.tpl' );
			}
			
		}
		elseif ($_REQUEST['job'] == 'edit') {
			$info = get_cab_package_info_id($_REQUEST['id']);
			$_SESSION['id'] = $_REQUEST['id'];
				
			$smarty->assign('cab_package_code', $info['cab_package_code']);
			$smarty->assign('rate', $info['rate']);
			$smarty->assign('type', $info['type']);
			$smarty->assign('off', $info['off']);
		
			$smarty->assign('edit', "on");
			$smarty->assign ( 'page', "Cab Package" );
			$smarty->display ( 'cab_package/cab_package.tpl' );
		}
		elseif ($_REQUEST['job'] == 'search') {
		
			$_SESSION['search'] = $_POST['search'];
		
			$smarty->assign('search', "$_SESSION[search]");
			$smarty->assign('search_mode', "on");
			$smarty->assign ( 'page', "Cab Package" );
			$smarty->display ( 'cab_package/cab_package.tpl' );
		}
		
		elseif ($_REQUEST['job'] == 'delete') {
			cancel_cab_package($_REQUEST['id']);
		
			$smarty->assign ( 'page', "Cab Package" );
			$smarty->display ( 'cab_package/cab_package.tpl' );
		}
		else{
			$smarty->assign ( 'page', "Cab Package" );
			$smarty->display ( 'cab_package/cab_package.tpl' );
		}
	}
	else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Cab Packages Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
}

else {

	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}