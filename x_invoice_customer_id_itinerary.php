<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	include 'functions/invoice_functions.php';
	include 'functions/itinerary_functions.php';
	include 'functions/customer_functions.php';

	$result=mysql_query("SELECT * FROM invoice WHERE type='ITINERARY'" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
		$info=get_invoice_info($row['invoice_no']);
		$itinerary_info=get_itinerary_info_by_itinerary_no($info['ref_no']);
		
		
			mysql_select_db($dbname);
			$query = "UPDATE invoice SET
			customer_id = '$itinerary_info[customer_id]'
			WHERE invoice_no='$row[invoice_no]'";
			mysql_query($query) or die (mysql_error());
	}