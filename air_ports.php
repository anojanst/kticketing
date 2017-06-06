<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/air_ports_functions.php';

$module_no = 7;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "air_port_form") {
			$smarty->assign ( 'page', "Air Ports" );
			$smarty->display ( 'air_ports/air_ports.tpl' );
		} elseif ($_REQUEST ['job'] == "add") {
			if ($_REQUEST ['ok'] == 'Save') {
				
				$air_port = $_POST ['air_port'];
				$air_port_code = $_POST ['air_port_code'];
				$user_name = $_SESSION ['user_name'];
				
				save_air_port ( $air_port, $air_port_code, $user_name );
				
				$smarty->assign ( 'page', "Air Ports" );
				$smarty->display ( 'air_ports/air_ports.tpl' );
			} else {
				$id = $_SESSION ['id'];
				$air_port = $_POST ['air_port'];
				$air_port_code = $_POST ['air_port_code'];
				$user_name = $_SESSION ['user_name'];
				
				update_air_port ( $id, $air_port, $air_port_code, $user_name );
				
				$smarty->assign ( 'page', "Air Ports" );
				$smarty->display ( 'air_ports/air_ports.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_air_port_info_id ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'air_port', $info ['air_port'] );
			$smarty->assign ( 'air_port_code', $info ['air_port_code'] );
			$smarty->assign ( 'off', $info ['off'] );
			
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "Air Ports" );
			$smarty->display ( 'air_ports/air_ports.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Air Ports" );
			$smarty->display ( 'air_ports/air_ports.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_air_port ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "Air Ports" );
			$smarty->display ( 'air_ports/air_ports.tpl' );
		} else {
			$smarty->assign ( 'page', "Air Ports" );
			$smarty->display ( 'air_ports/air_ports.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Air Port Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}