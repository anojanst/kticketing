<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	include 'functions/invoice_functions.php';
	include 'functions/booking_functions.php';
	include 'functions/customer_functions.php';

	$result=mysql_query("SELECT * FROM invoice WHERE type='TICKET'" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
		$info=get_invoice_info($row['invoice_no']);
		$booking_info=get_booking_info_by_booking_no($info['ref_no']);
		echo $booking_info[customer_id];
		echo "UPDATE invoice SET
			customer_id = '$booking_info[customer_id]'
			WHERE invoice_no='$row[invoice_no]'";
		
			mysql_select_db($dbname);
			$query = "UPDATE invoice SET
			customer_id = '$booking_info[customer_id]'
			WHERE invoice_no='$row[invoice_no]'";
			mysql_query($query) or die (mysql_error());
			
			
	}