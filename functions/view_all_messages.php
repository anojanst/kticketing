<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';

if ($_SESSION ['login'] == 1) {
	if ($_REQUEST ['job'] == "view") {
		$_SESSION ['chat_with'] = $chat_with = $_REQUEST ['chat_with'];
		
		$smarty->assign ( 'chat_with', $chat_with );
		$smarty->assign ( 'page', "Chat" );
		$smarty->display ( 'chat/all_chats.tpl' );
	} 

	else {
		$smarty->assign ( 'page', "Chat" );
		$smarty->display ( 'chat/all_chats.tpl' );
	}
} 

else {
	
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}