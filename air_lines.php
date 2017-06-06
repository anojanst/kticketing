<?php
require_once 'conf/smarty-conf.php';
include 'functions/air_lines_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';

$module_no = 6;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "add_new") {
			$smarty->assign ( 'page', "Air Lines" );
			$smarty->display ( 'air_lines/air_lines.tpl' );
		}
		
		if ($_REQUEST ['job'] == 'add') {
			if ($_REQUEST ['ok'] == 'Save') {
				$air_line = $_POST ['air_line'];
				$air_line_code = $_POST ['air_line_code'];
				$off = $_POST ['off'];
				$percent = $_POST ['percent'];
				$user_name = $_SESSION ['user_name'];
				
				save_air_line ( $air_line, $air_line_code, $off, $percent, $user_name );
				
				$smarty->assign ( 'page', "Air Lines" );
				$smarty->display ( 'air_lines/air_lines.tpl' );
			} else {
				$id = $_SESSION ['id'];
				$air_line = $_POST ['air_line'];
				$air_line_code = $_POST ['air_line_code'];
				$off = $_POST ['off'];
				$percent = $_POST ['percent'];
				$user_name = $_SESSION ['user_name'];
				
				update_air_line ( $id, $air_line, $air_line_code, $off, $percent, $user_name );
				
				$smarty->assign ( 'page', "Air Lines" );
				$smarty->display ( 'air_lines/air_lines.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_air_line_info_id ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'air_line', $info ['air_line'] );
			$smarty->assign ( 'air_line_code', $info ['air_line_code'] );
			$smarty->assign ( 'off', $info ['off'] );
			$smarty->assign ( 'percent', $info ['percent'] );
			
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "Air Lines" );
			$smarty->display ( 'air_lines/air_lines.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Air Lines" );
			$smarty->display ( 'air_lines/air_lines.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_air_line ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "Air Lines" );
			$smarty->display ( 'air_lines/air_lines.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "Air Lines" );
			$smarty->display ( 'air_lines/air_lines.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Air Lines Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}