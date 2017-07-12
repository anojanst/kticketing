<?php
require_once 'conf/smarty-conf.php';
include 'functions/register_functions.php';
include 'functions/company_settings_functions.php';


if ($_REQUEST ['job'] == "company_settings") {

    $info=get_company_details_info();
    $smarty->assign('name',$info['name']);
    $smarty->assign('email',$info['email']);
    $smarty->assign('telephone',$info['tel']);
    $smarty->assign('website',$info['website']);
    $smarty->assign('address',$info['address']);
    $smarty->assign('fax',$info['fax']);
    $smarty->assign('branches',$info['branches']);

    $smarty->assign ( 'page', "Settings" );
	$smarty->display ( 'company_settings/company_settings.tpl' );
}
elseif ($_REQUEST ['job'] == "edit") {

    $name=$_POST['name'];
    $address= $_POST['address'];
    $telephone = $_POST['telephone'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];
    $website=$_POST['website'];
    $branches=$_POST['branches'];
    $filename = stripslashes ($_FILES['logo'] ['name']);
    $logo="fonts/".$filename;
    $copied = copy($_FILES['logo']['tmp_name'],$logo);

    update_company_details( $name,$address, $telephone,$fax,$logo, $email, $website, $branches);

    $info=get_company_details_info();
    $smarty->assign('name',$info['name']);
    $smarty->assign('email',$info['email']);
    $smarty->assign('telephone',$info['tel']);
    $smarty->assign('website',$info['website']);
    $smarty->assign('address',$info['address']);
    $smarty->assign('fax',$info['fax']);
    $smarty->assign('branches',$info['branches']);

    $smarty->assign ( 'page', "Settings" );
    $smarty->display ( 'company_settings/company_settings.tpl' );
}
else {
	$smarty->assign ( 'page', "Home" );
	$smarty->display ( 'user_home/user_home.tpl' );
}


