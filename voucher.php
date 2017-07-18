<?php
require_once 'conf/smarty-conf.php';
include 'libs/class.phpmailer.php';
include 'functions/user_functions.php';
include 'functions/ledger_functions.php';
include 'functions/travels_functions.php';
include 'functions/voucher_functions.php';
include 'functions/chat_functions.php';
include 'functions/todo_functions.php';
include 'functions/booking_functions.php';
include 'functions/customer_functions.php';
include 'functions/company_settings_functions.php';

$module_no = 16;
$special_module_no = 106;
if (check_access ( $special_module_no, $_SESSION ['user_id'] ) == 1) {
    $smarty->assign ( 'voucher_without_visa', 1 );
}

if ($_SESSION ['login'] == 1) {
    if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {

        if ($_REQUEST ['job'] == "voucher_form") {

            unset ( $_SESSION ['voucher_edit'] );
            unset ( $_SESSION ['voucher_no'] );
            unset ( $_SESSION ['job_no'] );
            unset ( $_SESSION ['job_type'] );

            $smarty->assign ( 'page', "Voucher" );
            $smarty->display ( 'voucher/voucher.tpl' );
        } elseif ($_REQUEST ['job'] == "search_form") {
            unset ( $_SESSION ['search_voucher_no'] );
            unset ( $_SESSION ['search_travels'] );
            unset ( $_SESSION ['from_date'] );
            unset ( $_SESSION ['to_date'] );

            $smarty->assign ( 'page', "Voucher" );
            $smarty->display ( 'voucher/search_voucher.tpl' );
        }

        elseif ($_REQUEST ['job'] == "search") {
            $_SESSION ['search_voucher_no'] = $_POST ['voucher_no'];
            $_SESSION ['search_travels'] = $_POST ['travels'];
            $_SESSION ['from_date'] = $_POST ['from_date'];
            $_SESSION ['to_date'] = $_POST ['to_date'];

            $smarty->assign ( 'page', "Voucher" );
            $smarty->display ( 'voucher/search_voucher.tpl' );
        }

        elseif ($_REQUEST ['job'] == "booking_no_form") {

            $_SESSION ['booking_no'] = $booking_no = $_POST ['booking_no'];
            $smarty->assign ( 'booking_no', $_SESSION ['booking_no'] );

            $info = get_booking_info_by_booking_no ( $booking_no );
            $_SESSION ['pnr'] = $info ['pnr'];
            $fare_total = get_fare_total ( $info ['fare_id'], $info ['adult'], $info ['infant'], $info ['child'] );

            $smarty->assign ( 'pnr', $info ['pnr'] );
            $smarty->assign ( 'booking_no', "$booking_no" );
            $smarty->assign ( 'time_limit', $info ['issue_date'] );
            $smarty->assign ( 'fare', "$fare_total" );

            if (check_waiting_pax_to_issue ( $booking_no ) == 0) {
                $voucher_no = check_voucher_has_booking_no ( $booking_no );
                $_SESSION ['voucher_no'] = $voucher_no;
                $voucher_info = get_voucher_info ( $voucher_no );

                $smarty->assign ( 'voucher_no', $voucher_no );
                $smarty->assign ( 'booking_no', $voucher_info ['booking_no'] );
                $smarty->assign ( 'voucher_date', $voucher_info ['voucher_date'] );
                $smarty->assign ( 'travels', $voucher_info ['travels'] );
                $smarty->assign ( 'pnr', $voucher_info ['pnr'] );
                $smarty->assign ( 'fare', $voucher_info ['fare'] );
                $smarty->assign ( 'btt_or_less', $voucher_info ['btt_or_less'] );
                $smarty->assign ( 'bol_amount', $voucher_info ['bol_amount'] );
                $smarty->assign ( 'taxes', $voucher_info ['taxes'] );
                $smarty->assign ( 'sub_tot', $voucher_info ['sub_tot'] );
                $smarty->assign ( 'time_limit', $voucher_info ['time_limit'] );
                $smarty->assign ( 'saved_by', $voucher_info ['saved_by'] );
                $smarty->assign ( 'total', $voucher_info ['total'] );

                $smarty->assign ( 'page', "Voucher" );
                $smarty->display ( 'voucher/voucher_send.tpl' );
            } else {
                $count = get_passenger_count ( $booking_no );

                if ($_REQUEST ['skip'] == "YES") {
                    $smarty->assign ( 'submit', "true" );
                    $smarty->assign ( 'page', "Voucher" );
                    $smarty->display ( 'voucher/voucher.tpl' );
                } else {
                    if (get_passport_copy_count ( $booking_no ) == $count && get_passenger_visa_copy_count ( $booking_no ) == $count) {
                        $smarty->assign ( 'submit', "true" );
                        $smarty->assign ( 'page', "Voucher" );
                        $smarty->display ( 'voucher/voucher.tpl' );
                    } else {
                        $smarty->assign ( 'error_message', "Dear $_SESSION[user_name], This Booking Doesn't have Visa copy OR Passport copy" );
                        $smarty->display ( 'voucher/voucher.tpl' );
                    }
                }
            }
        }

        elseif ($_REQUEST ['job'] == "save") {

            $booking_no = $_SESSION ['booking_no'];
            $pnr = $_SESSION ['pnr'];
            $voucher_no = get_voucher_no ();
            $voucher_date = date ( "Y-m-d" );
            $travels = $_POST ['travels'];
            $fare = $_POST ['fare'];
            $taxes = $_POST ['taxes'];
            $saved_by = $_SESSION ['user_name'];
            $btt_or_less = $_POST ['btt_or_less'];
            $total = $_POST ['total'];
            $sub_tot = $_POST ['sub_tot'];
            $time_limit = $_POST ['time_limit'];
            $bol_amount=($fare/100)*$_POST ['bol_amount'];

            if ($_POST ['pnr']) {
                $pnr = $_POST ['pnr'];
            } else {
                $info = get_booking_info_by_booking_no ( $booking_no );
                $pnr = $info ['pnr'];
            }

            $pax_count = get_passenger_count ( $booking_no );
            $i = 1;

            while ( $i <= $pax_count ) {

                if ($_POST [$i] == "checked") {
                    $id = get_passenger_id ( $i, $booking_no );
                    update_issue_status_for_passenger ( $id, $booking_no, $voucher_no );
                }

                $i ++;
            }

            $travels_info = get_customer_info ( $travels );
            $travels_id = $travels_info ['customer_id'];

            add_voucher ( $booking_no, $pnr, $voucher_no, $voucher_date, $travels, $travels_id, $fare, $taxes, $saved_by, $btt_or_less, $bol_amount, $total, $sub_tot, $time_limit );
            add_voucher_ledger ( $voucher_no );
            update_time_limit ( $booking_no, $time_limit, $pnr );

            unset ( $_SESSION ['voucher_no'] );

            remove_user_module ( $_SESSION ['user_id'], $special_module_no );
            $smarty->assign ( 'voucher_without_visa', 0 );
            $smarty->assign ( 'error_message', "Voucher $voucher_no has been Saved." );
            $smarty->assign ( 'page', "Voucher" );
            $smarty->display ( 'voucher/voucher.tpl' );
        } elseif ($_REQUEST ['job'] == "view") {

            $voucher_no = $_REQUEST ['voucher_no'];
            $_SESSION ['voucher_no'] = $voucher_no;
            $voucher_info = get_voucher_info ( $voucher_no );
            $_SESSION ['booking_no'] = $voucher_info ['booking_no'];

            $smarty->assign ( 'voucher_no', $voucher_info ['voucher_no'] );
            $smarty->assign ( 'booking_no', $voucher_info ['booking_no'] );
            $smarty->assign ( 'voucher_date', $voucher_info ['voucher_date'] );
            $smarty->assign ( 'travels', $voucher_info ['travels'] );
            $smarty->assign ( 'pnr', $voucher_info ['pnr'] );
            $smarty->assign ( 'fare', $voucher_info ['fare'] );
            $smarty->assign ( 'btt_or_less', $voucher_info ['btt_or_less'] );
            $smarty->assign ( 'bol_amount', $voucher_info ['bol_amount'] );
            $smarty->assign ( 'taxes', $voucher_info ['taxes'] );
            $smarty->assign ( 'sub_tot', $voucher_info ['sub_tot'] );
            $smarty->assign ( 'time_limit', $voucher_info ['time_limit'] );
            $smarty->assign ( 'saved_by', $voucher_info ['saved_by'] );
            $smarty->assign ( 'total', $voucher_info ['total'] );

            $smarty->assign ( 'page', 'voucher' );
            $smarty->display ( 'voucher/voucher_view.tpl' );
        }

        elseif ($_REQUEST ['job'] == "send") {

            $voucher_no = $_REQUEST ['voucher_no'];
            $_SESSION ['voucher_no'] = $voucher_no;
            $voucher_info = get_voucher_info ( $voucher_no );
            $_SESSION ['booking_no'] = $voucher_info ['booking_no'];

            $smarty->assign ( 'voucher_no', $voucher_info ['voucher_no'] );
            $smarty->assign ( 'booking_no', $voucher_info ['booking_no'] );
            $smarty->assign ( 'voucher_date', $voucher_info ['voucher_date'] );
            $smarty->assign ( 'travels', $voucher_info ['travels'] );
            $smarty->assign ( 'pnr', $voucher_info ['pnr'] );
            $smarty->assign ( 'fare', $voucher_info ['fare'] );
            $smarty->assign ( 'btt_or_less', $voucher_info ['btt_or_less'] );
            $smarty->assign ( 'bol_amount', $voucher_info ['bol_amount'] );
            $smarty->assign ( 'taxes', $voucher_info ['taxes'] );
            $smarty->assign ( 'sub_tot', $voucher_info ['sub_tot'] );
            $smarty->assign ( 'time_limit', $voucher_info ['time_limit'] );
            $smarty->assign ( 'saved_by', $voucher_info ['saved_by'] );
            $smarty->assign ( 'total', $voucher_info ['total'] );

            $smarty->assign ( 'page', 'voucher' );
            $smarty->display ( 'voucher/voucher_send.tpl' );
        }

        elseif ($_REQUEST ['job'] == "send_mail") {

            $voucher_no = $_SESSION ['voucher_no'];
            $voucher_info = get_voucher_info ( $voucher_no );

            $to = $_POST ['to'];
            $subject = $_POST ['subject'];

            $filename = stripslashes ( $_FILES ['file'] ['name'] );
            $extension = getExtension ( $filename );
            $extension = strtolower ( $extension );
            $file_name = $voucher_no . '.' . $extension;
            $newname = "voucher/" . $file_name;
            $copied = copy ( $_FILES ['file'] ['tmp_name'], $newname );
            $attachment = $newname;

            send_mail ( $to, $subject, $attachment, $voucher_no );

            $smarty->assign ( 'page', 'voucher' );
            $smarty->display ( 'voucher/voucher.tpl' );
        }
        elseif ($_REQUEST ['job'] == "delete_voucher") {
            $voucher_no = $_REQUEST ['voucher_no'];
            if (check_voucher_paybill_status ( $voucher_no )) {

                $smarty->assign ( 'notice', 'Notice : Please cancel Paybill to do any amendments' );
            } else {
                $info = get_voucher_info ( $voucher_no );
                reupdate_issue_status_for_passenger ( $info ['booking_no'], $voucher_no );
                delete_voucher ( $voucher_no );
                delete_voucher_ledger ( $voucher_no );
            }
            $smarty->assign ( 'page', 'Voucher' );
            $smarty->display ( 'voucher/voucher.tpl' );
        }

        elseif ($_REQUEST ['job'] == "print") {
            $module_no = 103;
            if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
                $_SESSION ['voucher_no']=$voucher_no = $_REQUEST ['voucher_no'];
                $voucher_info = get_voucher_info ( $voucher_no );
                $_SESSION ['booking_no'] = $voucher_info ['booking_no'];

                $smarty->assign ( 'voucher_no', $voucher_info ['voucher_no'] );
                $smarty->assign ( 'booking_no', $voucher_info ['booking_no'] );
                $smarty->assign ( 'voucher_date', $voucher_info ['voucher_date'] );
                $smarty->assign ( 'travels', $voucher_info ['travels'] );
                $smarty->assign ( 'pnr', $voucher_info ['pnr'] );
                $smarty->assign ( 'fare', $voucher_info ['fare'] );
                $smarty->assign ( 'btt_or_less', $voucher_info ['btt_or_less'] );
                $smarty->assign ( 'bol_amount', $voucher_info ['bol_amount'] );
                $smarty->assign ( 'taxes', $voucher_info ['taxes'] );
                $smarty->assign ( 'sub_tot', $voucher_info ['sub_tot'] );
                $smarty->assign ( 'time_limit', $voucher_info ['time_limit'] );
                $smarty->assign ( 'saved_by', $voucher_info ['saved_by'] );
                $smarty->assign ( 'total', $voucher_info ['total'] );

                $voucher_type = $voucher_info [voucher_type];
                if (check_voucher_paybill_status ( $voucher_no )) {

                    $smarty->assign ( 'error_message', 'Notice : Please cancelPaybill to do any amendments' );
                } else {
                }
                $smarty->display ( 'voucher/voucher_print.tpl' );
            } else {
                $smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Print Voucher" );
                $smarty->display ( 'user_home/access_error.tpl' );
            }
        } else {
        }
    } else {
        $smarty->assign ( 'error_message', "Dear $_SESSION[user_name], you don't have permission to Voucher" );
        $smarty->display ( 'user_home/access_error.tpl' );
    }
} else {

    $smarty->assign ( 'error', "Incorrect Login Details!" );
    $smarty->display ( 'login/login.tpl' );
}
