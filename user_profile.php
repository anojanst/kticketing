<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

$module_no = 63;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		if ($_REQUEST ['job'] == 'add') {
			$id = $_SESSION ['id'];
			$name = $_POST ['name'];
			$full_name = $_POST ['full_name'];
			$department = $_POST ['department'];
			$email = $_POST ['email'];
			$mobile = $_POST ['mobile'];
			$address = addslashes ( $_POST ['address'] );
			$user = $_POST ['user'];
			$user_name = $_POST ['user_name'];
			$password = $_POST ['new_password'];
			$branch = $_POST ['branch'];
			
			$filename = stripslashes ( $_FILES ['profile_pictures'] ['name'] );
			if ($filename) {
				$extension = getExtension ( $filename );
				$extension = strtolower ( $extension );
				$file_name = $user_name . '.' . $extension;
				$newname = "images/" . $file_name;
				$copied = copy ( $_FILES ['profile_pictures'] ['tmp_name'], $newname );
			} else {
			}
			
			update_user ( $id, $name, $full_name, $department, $email, $mobile, $address, $user, $user_name, $password, $branch );
			
			$smarty->assign ( 'page', "user_profile" );
			$smarty->display ( 'user_profile/user_profile.tpl' );
		} elseif ($_REQUEST ['job'] == "edit") {
			
			$info = get_user_info ( $_SESSION ['user_name'] );
			$_SESSION ['id'] = $info ['id'];
			
			$smarty->assign ( 'name', $info ['name'] );
			$smarty->assign ( 'full_name', $info ['full_name'] );
			$smarty->assign ( 'department', $info ['department'] );
			$smarty->assign ( 'email', $info ['email'] );
			$smarty->assign ( 'mobile', $info ['mobile'] );
			$smarty->assign ( 'address', $info ['address'] );
			$smarty->assign ( 'user', $info ['user'] );
			$smarty->assign ( 'user_name', $info ['user_name'] );
			$smarty->assign ( 'branch', $info ['branch'] );
			
			$smarty->assign ( 'edit', "on" );
			$smarty->assign ( 'page', "user_profile" );
			$smarty->display ( 'user_profile/user_profile.tpl' );
		} 

		else {
			$smarty->assign ( 'page', "user_profile" );
			$smarty->display ( 'user_profile/user_profile.tpl' );
		}
	} else {
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to User Profile" );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}


