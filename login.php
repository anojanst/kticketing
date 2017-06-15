<?php
require_once 'conf/smarty-conf.php';
include 'functions/user_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/cash_functions.php';

if ($_REQUEST ['job'] == "login") {

    $login = $_POST ['user_name'];
    $password = $_POST ['password'];

    if (check_login ( $login, $password ) == 1) {

        $_SESSION ['user_name'] = $login;
        $_SESSION ['username'] = $login;
        $user_info = get_user_info ( $login );
        $_SESSION ['login'] = 1;
        $_SESSION ['user_id'] = $user_info ['id'];
        $_SESSION ['branch'] = $user_info ['branch'];

        $target_info = get_day_info ( $login );
        $date = date ( "Y-m-d" );

        if (check_cash_flow_last_entry ( $user_info ['branch'], $date ) == 1) {
            $cash_info = get_cash_info ( $user_info ['branch'] );
            $detail = "OPENING BALANCE ON $date";
            $type = "OPENING BALANCE";
            save_cash_flow ( $user_info ['branch'], $detail, $cash_info ['balance'], $ref_no, $type, $date, $saved_by );
        }

        if ($target_info ['date'] == $date) {
            save_ip ( $_SESSION ['user_name'] );
            $smarty->assign ( 'page', "Home" );
            $smarty->display ( 'user_home/user_home.tpl' );
        } else {
            $smarty->assign ( 'page', "Target" );
            $smarty->display ( 'login/target.tpl' );
        }
    }

    else {
        $smarty->assign ( 'error', "Incorrect Login Details Or Inactivate Account." );
        $smarty->display ( 'login/login.tpl' );
    }
}

elseif ($_REQUEST ['job'] == "target") {

    $_SESSION ['target'] = $target = $_REQUEST ['target'];
    $user_name = $_SESSION ['user_name'];

    save_target ( $target, $user_name );

    $smarty->assign ( 'page', "Cancel Tickets" );
    $smarty->display ( 'login/cancel_ticket.tpl' );
}// cancle start
elseif ($_REQUEST ['job'] == "cancel") {

    save_cancel ( $_SESSION ['user_name'], $_REQUEST ['cancel'] );

    if ($_REQUEST ['cancel'] == "Yes") {
        $smarty->assign ( 'page', "Cancel PNR" );
        $smarty->display ( 'login/cancel_ticket_pnr.tpl' );
    } else {

        save_ip ( $_SESSION ['user_name'] );

        $smarty->assign ( 'page', "Home" );
        $smarty->display ( 'user_home/user_home.tpl' );
    }
}

elseif ($_REQUEST ['job'] == "cancel_pnr") {

    save_cancel_pnr ( $_SESSION ['user_name'], $_POST ['pnr'] );

    $smarty->assign ( 'page', "Cancel PNR" );
    $smarty->display ( 'login/cancel_ticket_pnr.tpl' );
}

elseif ($_REQUEST ['job'] == "done_cancel") {

    save_ip ( $_SESSION ['user_name'] );

    $smarty->assign ( 'page', "Home" );
    $smarty->display ( 'user_home/user_home.tpl' );
}// cancle finish

elseif ($_REQUEST ['job'] == "ok") {

    save_ip ( $_SESSION ['user_name'] );

    if (check_birthday_access () == 0) {
        $today_dm = date ( "m-d" );

        create_dob_task ( $today_dm );
        $count = get_today_birthday_count ( $today_dm );

        save_count_dob ( $count );
    } else {
    }

    $smarty->assign ( 'page', "Home" );
    $smarty->display ( 'user_home/user_home.tpl' );
}

elseif ($_REQUEST ['job'] == "logout") {

    unset ( $_SESSION ['login'] );
    unset ( $_SESSION ['user_name'] );
    unset ( $_SESSION ['user_id'] );
    unset ( $_SESSION ['db'] );
    unset ( $_SESSION ['branch'] );
    header ( 'location: index.php' );
}

else {
    $smarty->display ( 'login/login.tpl' );
}