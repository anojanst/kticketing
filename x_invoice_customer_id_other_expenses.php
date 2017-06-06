<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	include 'functions/invoice_functions.php';
	include 'functions/booking_functions.php';
	include 'functions/customer_functions.php';

	$result=mysql_query("SELECT * FROM other_expenses WHERE type='OTHER-EXPENSES'" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
		$customer_info=get_customer_info($row['customer']);
		
		
			mysql_select_db($dbname);
			$query = "UPDATE other_expenses SET
			customer_id = '$customer_info[customer_id]'
			WHERE other_expenses_no='$row[other_expenses_no]'";
			mysql_query($query) or die (mysql_error());
	}