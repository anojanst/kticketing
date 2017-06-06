<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	include 'functions/receipt_functions.php';
	include 'functions/booking_functions.php';
	include 'functions/customer_functions.php';
	include 'functions/invoice_functions.php';
	
	$result=mysql_query("SELECT * FROM receipt" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		if ($row['customer_name']){
			$customer_info=get_customer_info($row['customer_name']);
						
			mysql_select_db($dbname);
			$query = "UPDATE receipt SET
			customer_id = '$customer_info[customer_id]'
			WHERE rec_no='$row[rec_no]'";
			mysql_query($query) or die (mysql_error());
		}
		else{
			
			$receipt_customer=get_customer_by_rec_no($row['rec_no']);
			$customer_info=get_customer_info($receipt_customer);
		
			mysql_select_db($dbname);
			$query = "UPDATE receipt SET
			customer_name = '$customer_info[customer_name]',
			customer_id = '$customer_info[customer_id]'
			WHERE rec_no='$row[rec_no]'";
			mysql_query($query) or die (mysql_error());
		}
	}
	
function get_customer_by_rec_no($rec_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysql_query("SELECT * FROM receipt_has_invoice WHERE rec_no='$rec_no' AND cancel_status='0' ORDER BY id LIMIT 1" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
			$info=get_invoice_info($row['invoice_no']);
			$customer_name=$info['customer'];
				
		
		return $customer_name;
	}
}