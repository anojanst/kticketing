<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/customer_functions.php';
include 'functions/gift_voucher_functions.php';


$module_no = 66;
if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "gift_voucher") {
				
			$smarty->assign ( 'page', "gift_voucher" );
			$smarty->display ( 'gift_voucher/gift_voucher.tpl' );
		}

		elseif ($_REQUEST['job'] == 'add') {
			$customer_id = $_REQUEST ['customer_id'];
			$info = get_customer_info_by_customer_id($customer_id);
			
			$travel_time = count_customer_id($customer_id);
			$total_amount = count_total($customer_id);
			$customer_name = $info ['customer_name'];
			$gift_voucher_no= $_POST ['gift_voucher_no'];
			$gift_voucher_amount= $_POST ['gift_voucher_amount'];
			
			save_gift_voucher($customer_id, $customer_name, $travel_time, $total_amount, $gift_voucher_no, $gift_voucher_amount);
		
			
			$smarty->assign ( 'page', "gift_voucher" );
			$smarty->display ( 'gift_voucher/gift_voucher.tpl' );
		}

		else {
			$smarty->assign ( 'page', "gift_voucher" );
			$smarty->display ( 'gift_voucher/gift_voucher.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to customer gift voucher Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
}

else {

	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}


