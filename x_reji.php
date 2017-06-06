<?php
	include 'conf/config.php';
	include 'conf/opendb.php';
	include 'functions/invoice_functions.php';
	include 'functions/ledger_functions.php';

	$result=mysql_query("SELECT * FROM invoice WHERE type='TICKET' AND cancel_status='0'" , $conn);
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		
		$info=get_invoice_info($row['invoice_no']);
		
		if($info['total']==$info['due']){
			mysql_select_db($dbname);
			$query = "UPDATE invoice SET
			cancel_status = '1'
			WHERE invoice_no='$row[invoice_no]'";
			mysql_query($query) or die (mysql_error());
			
			mysql_select_db($dbname);
			$query2 = "UPDATE `ledger` SET `cancel_status`='1' WHERE `flag` LIKE 'INVOICE%' AND `ref_no`='$row[invoice_no]'";
			mysql_query($query2) or die (mysql_error());
		}			
	}