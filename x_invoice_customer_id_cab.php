<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	include 'functions/invoice_functions.php';
	include 'functions/cab_functions.php';
	include 'functions/customer_functions.php';

	$result=mysql_query("SELECT * FROM invoice WHERE type='CAB'" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
		$info=get_invoice_info($row['invoice_no']);
		$cab_info=get_cab_info_by_cab_booking_no($info['ref_no']);
		
		
			mysql_select_db($dbname);
			$query = "UPDATE invoice SET
			customer_id = '$cab_info[customer_id]'
			WHERE invoice_no='$row[invoice_no]'";
			mysql_query($query) or die (mysql_error());
	}