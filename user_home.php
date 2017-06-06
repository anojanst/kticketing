<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/loan_functions.php';
include 'functions/other_expenses_functions.php';

if ($_SESSION ['login'] == 1) {
	generate_other_expenses_for_interest ();
	$smarty->assign ( 'page', "User Home" );
	$smarty->display ( 'user_home/user_home.tpl' );
} else {
	$smarty->assign ( 'error', "Incorrect Login Details!" );
	$smarty->display ( 'login/login.tpl' );
}