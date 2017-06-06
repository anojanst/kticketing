<?php
require_once 'conf/smarty-conf.php';
include 'functions/offer_functions.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 9;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == "add_new") {
			$smarty->assign ( 'page', "Offer" );
			$smarty->display ( 'offer/offer.tpl' );
		}
		
		if ($_REQUEST ['job'] == 'add') {
			if ($_REQUEST ['ok'] == 'Save') {
				$offer_code = $_POST ['offer_code'];
				$off = $_POST ['off'];
				$type = $_POST ['type'];
				$exp_date = $_POST ['exp_date'];
				$user_name = $_SESSION ['user_name'];
				
				save_offer ( $offer_code, $off, $type, $exp_date, $user_name );
				
				$smarty->assign ( 'page', "Offer" );
				$smarty->display ( 'offer/offer.tpl' );
			} else {
				$id = $_SESSION ['id'];
				$offer_code = $_POST ['offer_code'];
				$off = $_POST ['off'];
				$type = $_POST ['type'];
				$exp_date = $_POST ['exp_date'];
				$user_name = $_SESSION ['user_name'];
				
				update_offer ( $id, $offer_code, $off, $type, $exp_date, $user_name );
				
				$smarty->assign ( 'page', "Offer" );
				$smarty->display ( 'offer/offer.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_offer_info_id ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'offer_code', $info ['offer_code'] );
			$smarty->assign ( 'off', $info ['off'] );
			$smarty->assign ( 'type', $info ['type'] );
			$smarty->assign ( 'exp_date', $info ['exp_date'] );
			
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "Offer" );
			$smarty->display ( 'offer/offer.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Offer" );
			$smarty->display ( 'offer/offer.tpl' );
		} 

		elseif ($_REQUEST ['job'] == 'delete') {
			cancel_offer ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'page', "Offer" );
			$smarty->display ( 'offer/offer.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "Offer" );
			$smarty->display ( 'offer/offer.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Offer Settings" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}