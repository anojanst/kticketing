<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/quick_links_functions.php';

$module_no = 57;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "quick_links") {
			
			$smarty->assign ( 'page', "quick_links" );
			$smarty->display ( 'quick_links/quick_links.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "add") {
			if ($_REQUEST ['ok'] == 'Save') {
				$name = $_POST ['name'];
				$link = $_POST ['link'];
				
				$filename = stripslashes ( $_FILES ['logo'] ['name'] );
				if ($filename) {
					$newname = "images/" . $filename;
					$copied = copy ( $_FILES ['logo'] ['tmp_name'], $newname );
					$logo = $newname;
				} else {
					$logo = "";
				}
				
				save_quick_links ( $name, $link, $logo );
				$smarty->assign ( 'page', "quick_links" );
				$smarty->display ( 'quick_links/quick_links.tpl' );
			} else {
				$id = $_SESSION ['id'];
				$name = $_POST ['name'];
				$link = $_POST ['link'];
				$info = get_quick_link_info_id ( $id );
				$filename = stripslashes ( $_FILES ['logo'] ['name'] );
				if ($filename) {
					$newname = "images/" . $filename;
					$copied = copy ( $_FILES ['logo'] ['tmp_name'], $newname );
					$logo = $newname;
				} else {
					$logo = $info ['logo'];
				}
				
				update_air_line ( $id, $name, $link, $logo );
				$smarty->assign ( 'page', "quick_links" );
				$smarty->display ( 'quick_links/quick_links.tpl' );
			}
		} 

		elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_quick_link_info_id ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'name', $info ['name'] );
			$smarty->assign ( 'link', $info ['link'] );
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "quick_links" );
			$smarty->display ( 'quick_links/quick_links.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_quick_links ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "quick_links" );
			$smarty->display ( 'quick_links/quick_links.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "quick_links" );
			$smarty->display ( 'quick_links/quick_links.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Quick Links Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}

