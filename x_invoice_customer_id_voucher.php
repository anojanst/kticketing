<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	include 'functions/invoice_functions.php';
	include 'functions/booking_functions.php';
	include 'functions/customer_functions.php';

	$result=mysql_query("SELECT * FROM voucher" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
		$customer_info=get_customer_info($row['travels']);
		
		
			mysql_select_db($dbname);
			$query = "UPDATE voucher SET
			customer_id = '$customer_info[customer_id]'
			WHERE voucher_no='$row[voucher_no]'";
			mysql_query($query) or die (mysql_error());
			

			echo $travels.$customer_info[customer_id];
	}