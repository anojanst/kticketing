<?php
require_once 'conf/smarty-conf.php';
include 'functions/register_functions.php';
include 'libs/class.phpmailer.php';

if ($_REQUEST ['job'] == "settings") {
	
	$smarty->assign ( 'page', "Settings" );
	$smarty->display ( 'settings/settings.tpl' );
} 

else {
	$smarty->assign ( 'page', "Home" );
	$smarty->display ( 'user_home/user_home.tpl' );
}


