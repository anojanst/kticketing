<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/customer_functions.php';
include 'functions/gift_voucher_functions.php';


$module_no = 65;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "gift_voucher") {
				
			$smarty->assign ( 'page', "gift_voucher_list" );
			$smarty->display ( 'gift_voucher_list/gift_voucher_list.tpl' );
		}


		else {
			$smarty->assign ( 'page', "gift_voucher_list" );
			$smarty->display ( 'gift_voucher_list/gift_voucher_list.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to customer gift voucher List Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
}

else {

	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}



