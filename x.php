<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result=mysql_query("SELECT DISTINCT(mobile) FROM customer_temp WHERE mobile BETWEEN '0700000000' AND '0790000000'" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
	
		$mobile=$row['mobile'];
		mysql_select_db($dbname);
		$query = "INSERT INTO customer_contact (mobile)
		VALUES ('$mobile')";
		mysql_query($query) or die (mysql_error());
			
	}
	
	include 'conf/closedb.php';