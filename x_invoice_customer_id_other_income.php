<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	include 'functions/invoice_functions.php';
	include 'functions/booking_functions.php';
	include 'functions/customer_functions.php';

	$result=mysql_query("SELECT * FROM invoice WHERE type='OTHER'" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
		$info=get_invoice_info($row['invoice_no']);
		$customer_info=get_customer_info($info['customer']);
		
		
			mysql_select_db($dbname);
			$query = "UPDATE invoice SET
			customer_id = '$customer_info[customer_id]'
			WHERE invoice_no='$row[invoice_no]'";
			mysql_query($query) or die (mysql_error());
	}