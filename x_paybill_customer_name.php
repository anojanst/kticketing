<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	include 'functions/paybill_functions.php';
	include 'functions/booking_functions.php';
	include 'functions/customer_functions.php';
	include 'functions/voucher_functions.php';
	include 'functions/other_expenses_functions.php';

	$result=mysql_query("SELECT * FROM paybill" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		if ($row['customer_name']){
			$customer_info=get_customer_info($row['customer_name']);
						
			mysql_select_db($dbname);
			$query = "UPDATE paybill SET
			customer_id = '$customer_info[customer_id]'
			WHERE paybill_no='$row[paybill_no]'";
			mysql_query($query) or die (mysql_error());
		}
		else{
			
			$paybill_customer=get_customer_by_paybill_no($row['paybill_no']);
			$customer_info=get_customer_info($paybill_customer);
		
			mysql_select_db($dbname);
			$query = "UPDATE paybill SET
			customer_name = '$customer_info[customer_name]',
			customer_id = '$customer_info[customer_id]'
			WHERE paybill_no='$row[paybill_no]'";
			mysql_query($query) or die (mysql_error());
		}
	}
	
function get_customer_by_paybill_no($paybill_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysql_query("SELECT * FROM paybill_has_voucher WHERE paybill_no='$paybill_no' AND cancel_status='0' ORDER BY id LIMIT 1" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		if($row['ref_type']=="VOUCHER"){
			$info=get_voucher_info($row['ref_no']);
			$customer_name=$info['travels'];
		}
		else{
			$info=get_other_expenses_info($row['ref_no']);
			$customer_name=$info['customer'];
		}
		
		
		return $customer_name;
	}
}