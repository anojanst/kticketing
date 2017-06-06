<?php
require_once 'conf/smarty-conf.php';
include 'functions/inventory_functions.php';
include 'functions/user_functions.php';

$module_no = 2;

if ($_SESSION ['login'] == 1) {
	if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
		
		if ($_REQUEST ['job'] == 'add') {
			if ($_REQUEST ['ok'] == 'Save') {
				
				$product_id = $_POST ['product_id'];
				$product_name = $_POST ['product_name'];
				$count = $_POST ['count'];
				$selling_price = $_POST ['selling_price'];
				$buying_price = $_POST ['buying_price'];
				$discount = $_POST ['discount'];
				$catagory = $_POST ['catagory'];
				$product_description = $_POST ['product_description'];
				$measure_type = $_POST ['measure_type'];
				$purchased_date = $_POST ['purchased_date'];
				$label = $_POST ['label'];
				$supplier = $_POST ['supplier'];
				
				if (check_added_items_inventory ( $product_id ) == 1) {
					$info = get_inventory_info_by_product_id ( $product_id );
					$old_catagory = $info ['catagory'];
					$old_name = $info ['product_name'];
					$old_count = $info ['quantity'];
					$new_count = $old_count + $count;
					if ($old_catagory == $catagory) {
						update_product_by_product_id ( $product_id, $product_name, $new_count, $selling_price, $buying_price, $discount, $catagory, $product_description, $measure_type, $purchased_date, $label, $supplier );
					} else {
						$smarty->assign ( 'error_report', "on" );
						$smarty->assign ( 'error_message', "Catagory differs for this product ID." );
					}
					
					if ($old_name != $product_name) {
						$smarty->assign ( 'warning_report', "on" );
						$smarty->assign ( 'warning_message', "Product Name differs for this product ID. Anyway Product was saved." );
					}
				} else {
					save_product ( $product_id, $product_name, $count, $selling_price, $buying_price, $discount, $catagory, $product_description, $measure_type, $purchased_date, $label, $supplier );
				}
				$smarty->assign ( 'parent_catagorys', list_parent_catagory () );
				$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
				$smarty->assign ( 'page', "Inventory" );
				$smarty->display ( 'inventory/inventory.tpl' );
			} else {
				
				$id = $_SESSION ['id'];
				$product_id = $_POST ['product_id'];
				$product_name = $_POST ['product_name'];
				$count = $_POST ['count'];
				$selling_price = $_POST ['selling_price'];
				$buying_price = $_POST ['buying_price'];
				$discount = $_POST ['discount'];
				$catagory = $_POST ['catagory'];
				$product_description = $_POST ['product_description'];
				$measure_type = $_POST ['measure_type'];
				$purchased_date = $_POST ['purchased_date'];
				$label = $_POST ['label'];
				$supplier = $_POST ['supplier'];
				
				update_product ( $id, $product_id, $product_name, $count, $selling_price, $buying_price, $discount, $catagory, $product_description, $measure_type, $purchased_date, $label, $supplier );
				
				$smarty->assign ( 'edit_mode', "off" );
				$smarty->assign ( 'parent_catagorys', list_parent_catagory () );
				$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
				$smarty->assign ( 'page', "Inventory" );
				$smarty->display ( 'inventory/inventory.tpl' );
			}
		} elseif ($_REQUEST ['job'] == 'search') {
			
			$_SESSION ['search'] = $_POST ['search'];
			
			$smarty->assign ( 'parent_catagorys', list_parent_catagory () );
			$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
			$smarty->assign ( 'search', "$_SESSION[search]" );
			$smarty->assign ( 'search_mode', "on" );
			$smarty->assign ( 'page', "Inventory" );
			$smarty->display ( 'inventory/inventory.tpl' );
		} elseif ($_REQUEST ['job'] == 'edit') {
			$info = get_product_info ( $_REQUEST ['id'] );
			$_SESSION ['id'] = $_REQUEST ['id'];
			
			$smarty->assign ( 'product_id', $info ['product_id'] );
			$smarty->assign ( 'product_name', $info ['product_name'] );
			$smarty->assign ( 'count', $info ['quantity'] );
			$smarty->assign ( 'selling_price', $info ['selling_price'] );
			$smarty->assign ( 'buying_price', $info ['buying_price'] );
			$smarty->assign ( 'discount', $info ['discount'] );
			$smarty->assign ( 'product_description', $info ['product_description'] );
			$smarty->assign ( 'measure_type', $info ['measure_type'] );
			$smarty->assign ( 'catagory', $info ['catagory'] );
			$smarty->assign ( 'purchased_date', $info ['purchased_date'] );
			$smarty->assign ( 'label', $info ['label'] );
			$smarty->assign ( 'supplier', $info ['supplier'] );
			
			$smarty->assign ( 'parent_catagorys', list_parent_catagory () );
			$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
			$smarty->assign ( 'edit', "Product" );
			$smarty->assign ( 'edit_mode', "on" );
			$smarty->assign ( 'page', "Inventory" );
			$smarty->display ( 'inventory/inventory.tpl' );
		} elseif ($_REQUEST ['job'] == 'delete') {
			$module_no = 101;
			if (check_access ( $module_no, $_SESSION ['user_id'] ) == 1) {
				cancel_product ( $_REQUEST ['id'] );
				
				$smarty->assign ( 'parent_catagorys', list_parent_catagory () );
				$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
				$smarty->assign ( 'page', "Inventory" );
				$smarty->display ( 'inventory/inventory.tpl' );
			} else {
				$user_name = $_SESSION ['user_name'];
				$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
				$smarty->assign ( 'error_report', "on" );
				$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to DELETE an item." );
				$smarty->assign ( 'page', "Access Error" );
				$smarty->display ( 'user_home/access_error.tpl' );
			}
		} else {
			$smarty->assign ( 'parent_catagorys', list_parent_catagory () );
			$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
			$smarty->assign ( 'page', "Inventory" );
			$smarty->display ( 'inventory/inventory.tpl' );
		}
	} else {
		$user_name = $_SESSION ['user_name'];
		$smarty->assign ( 'org_name', "$_SESSION[org_name]" );
		$smarty->assign ( 'error_report', "on" );
		$smarty->assign ( 'error_message', "Dear $user_name, you don't have permission to access INVENTORY." );
		$smarty->assign ( 'page', "Access Error" );
		$smarty->display ( 'user_home/access_error.tpl' );
	}
} else {
	$smarty->assign ( 'error', "<p>Incorrect Login Details!</p>" );
	$smarty->display ( 'user_home/login.tpl' );
}