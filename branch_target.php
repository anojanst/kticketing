<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/target_functions.php';

$module_no = 61;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "branch_target") {
			$smarty->assign ( 'page', "branch_target" );
			$smarty->display ( 'branch_target/branch_target.tpl' );
		} 
		
		elseif ($_REQUEST['job'] == 'add') {
				
			$branch = $_POST ['branch'];
			$amount = $_POST ['amount'];
			$date= $_POST ['date'];
			$user_name = $_SESSION ['saved_by'];
			
			save_branch_target($branch, $amount, $date);
		
			$smarty->assign ( 'page', "branch_target" );
			$smarty->display ( 'branch_target/branch_target.tpl' );
				
		}	
		

		else {
			$smarty->assign ( 'page', "branch_target" );
			$smarty->display ( 'branch_target/branch_target.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to branch target" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}



