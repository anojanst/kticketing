<?php
require_once 'conf/smarty-conf.php';
include 'functions/customer_functions.php';
include 'functions/chat_functions.php';
include 'functions/user_functions.php';
include 'functions/booking_functions.php';
include 'functions/gift_voucher_functions.php';

$module_no = 13;

if ($_SESSION ['login'] == 1) {
	
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == "customer_form") {
			
			$smarty->assign ( 'page', "Customer" );
			$smarty->display ( 'customer/new_customer.tpl' );
		} 

		elseif ($_REQUEST ['job'] == "add") {
			if ($_REQUEST ['ok'] == 'Update') {
				$id = $_SESSION ['id'];
				$info = get_customer_info_by_id ( $id );
				
				$customer_name = $_POST ['customer_name'];
				$salute = $_POST ['salute'];
				$customer_id = $_POST ['customer_id'];
				$first_name = $_POST ['first_name'];
				$last_name = $_POST ['last_name'];
				$sex = $_POST ['sex'];
				$nationality = $_POST ['nationality'];
				$dob = $_POST ['dob'];
				$address = addslashes ( $_POST ['address'] );
				$telephone = $_POST ['telephone'];
				$mobile = $_POST ['mobile'];
				$email = $_POST ['email'];
				$passport_no = $_POST ['passport_no'];
				$issued_date = $_POST ['issued_date'];
				$expire_date = $_POST ['expire_date'];
				
				if ($info ['passport_no'] != $passport_no) {
					$old_passport = $info ['passport_no'];
					update_passport_no_in_booking ( $passport_no, $old_passport );
				}
				
				$filename = stripslashes ( $_FILES ['passport'] ['name'] );
				if ($filename) {
					$extension = getExtension ( $filename );
					$extension = strtolower ( $extension );
					$file_name = $passport_no . '.' . $extension;
					$newname = "passports/" . $file_name;
					$copied = copy ( $_FILES ['passport'] ['tmp_name'], $newname );
					$passport = $newname;
				} else {
					$passport = $info ['passport'];
				}
				update_customer ( $id, $customer_name, $salute, $customer_id, $first_name, $last_name, $sex, $nationality, $dob, $address, $telephone, $mobile, $email, $passport_no, $passport, $issued_date, $expire_date );
			} else {
				$customer_name = $_POST ['customer_name'];
				$salute = $_POST ['salute'];
				$customer_id = $_POST ['customer_id'];
				$first_name = $_POST ['first_name'];
				$last_name = $_POST ['last_name'];
				$sex = $_POST ['sex'];
				$nationality = $_POST ['nationality'];
				$dob = $_POST ['dob'];
				$address = addslashes ( $_POST ['address'] );
				$telephone = $_POST ['telephone'];
				$mobile = $_POST ['mobile'];
				$email = $_POST ['email'];
				$passport_no = $_POST ['passport_no'];
				$issued_date = $_POST ['issued_date'];
				$expire_date = $_POST ['expire_date'];
				$customer_id = get_customer_id ();
				$filename = stripslashes ( $_FILES ['passport'] ['name'] );
				if ($filename) {
					$extension = getExtension ( $filename );
					$extension = strtolower ( $extension );
					$file_name = $passport_no . '.' . $extension;
					$newname = "passports/" . $file_name;
					$copied = copy ( $_FILES ['passport'] ['tmp_name'], $newname );
					$passport = $newname;
				}
				save_customer ( $customer_name, $salute, $customer_id, $first_name, $last_name, $sex, $nationality, $dob, $address, $telephone, $mobile, $email, $passport_no, $passport, $issued_date, $expire_date );
			}
			
			$smarty->assign ( 'error_message', "Customer Created. Customer ID : $customer_id" );
			$smarty->assign ( 'page', "Customer" );
			$smarty->display ( 'customer/new_customer.tpl' );
		} elseif ($_REQUEST ['job'] == "edit") {
			$_SESSION ['id'] = $id = $_REQUEST ['id'];
			$info = get_customer_info_by_id ( $id );
			
			if ($info ['dob'] == "0000-00-00") {
				$info ['dob'] = "";
			}
			if ($info ['issued_date'] == "0000-00-00") {
				$info ['issued_date'] = "";
			}
			if ($info ['expire_date'] == "0000-00-00") {
				$info ['expire_date'] = "";
			}
			$smarty->assign ( 'customer_name', $info ['customer_name'] );
			$smarty->assign ( 'salute', $info ['salute'] );
			$smarty->assign ( 'customer_id', $info ['customer_id'] );
			$smarty->assign ( 'first_name', $info ['first_name'] );
			$smarty->assign ( 'last_name', $info ['last_name'] );
			$smarty->assign ( 'sex', $info ['sex'] );
			$smarty->assign ( 'nationality', $info ['nationality'] );
			$smarty->assign ( 'dob', $info ['dob'] );
			$smarty->assign ( 'address', $info ['address'] );
			$smarty->assign ( 'telephone', $info ['telephone'] );
			$smarty->assign ( 'mobile', $info ['mobile'] );
			$smarty->assign ( 'email', $info ['email'] );
			$smarty->assign ( 'passport_no', $info ['passport_no'] );
			$smarty->assign ( 'issued_date', $info ['issued_date'] );
			$smarty->assign ( 'expire_date', $info ['expire_date'] );
			
			$smarty->assign ( 'edit', 'on' );
			$smarty->assign ( 'page', "Customer" );
			$smarty->display ( 'customer/new_customer.tpl' );
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Customer" );
			$smarty->display ( 'customer/new_customer.tpl' );
		} elseif ($_REQUEST ['job'] == "delete") {
			cancel_customer ( $_REQUEST ['id'] );
			
			$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
			$smarty->assign ( 'page', "Customer" );
			$smarty->display ( 'customer/new_customer.tpl' );
		}elseif ($_REQUEST ['job'] == "view") {
			$_SESSION ['customer_id'] = $_REQUEST ['customer_id'];
				
			$info = get_customer_info_by_customer_id ( $_SESSION ['customer_id'] );
				
			$_SESSION ['search'] = $info ['customer_name'];
				
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Customer" );
			$smarty->display ( 'customer/new_customer.tpl' );
			
			
		}

		 else {
			$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
			$smarty->assign ( 'page', "Customer" );
			$smarty->display ( 'customer/new_customer.tpl' );
		}
	} 

	else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access Receipt." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}