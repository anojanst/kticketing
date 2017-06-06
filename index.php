<?php
require_once 'conf/smarty-conf.php';
include 'functions/chat_functions.php';
include 'functions/loan_functions.php';
include 'functions/other_expenses_functions.php';
include 'functions/ledger_functions.php';

generate_other_expenses_for_interest ();

$smarty->assign ( 'page', "Login" );
$smarty->display ( 'login/login.tpl' );