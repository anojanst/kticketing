<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/report_functions.php';

$module_no = 55;
if ($_SESSION ['login'] == 1) {
    if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
        if ($_REQUEST ['job'] == "pnr") {

            $smarty->assign ( 'page', "pnr" );
            $smarty->display ( 'pnr/pnr.tpl' );
        }

        elseif ($_REQUEST ['job'] == "search") {
            $_SESSION ['pnr'] = $_POST ['pnr'];

            $smarty->assign ( 'pnr', $_SESSION ['pnr'] );
            $smarty->assign ( 'search', "on" );
            $smarty->assign ( 'page', "pnr" );
            $smarty->display ( 'pnr/pnr.tpl' );
        } elseif ($_REQUEST ['job'] == "pnr_print") {

            $smarty->assign ( 'page', "pnr_print" );
            $smarty->display ( 'pnr_print/pnr_print.tpl' );
        }

        else {
            $smarty->assign ( 'page', "search_cab" );
            $smarty->display ( 'search_cab/search_cab.tpl' );
        }
    } else {
        $smarty->assign ( 'error_report', "on" );
        $smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to PNR Settings" );
        $smarty->assign ( 'page', "Access Error" );
        $smarty->display ( 'user_home/access_error.tpl' );
    }
}

else {

    $smarty->assign ( 'error', "Incorrect Login Details!" );
    $smarty->display ( 'login/login.tpl' );
}


