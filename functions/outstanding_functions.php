<?php
function outstanding_invoice_report($customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($customer) {
		$customer_name_check = "AND customer LIKE '$customer'";
	} else {
		$customer_name_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND invoice_date BETWEEn '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND invoice_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND invoice_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	<tr class="danger" style="font-weight: bold;">

	<td>View</td>
	<td>No</td>
	<td>Customer</td>
	<td>Ref No</td>
	<td>Type</td>
	<td align="right">Total</td>
	<td align="right">Paid</td>
	<td align="right">Due</td>
	</tr>';
	
	$due = 0;
	$result = mysqli_query ( $conn, "SELECT * FROM invoice WHERE cancel_status='0' AND due > 0 $date_check $customer_name_check ORDER BY id $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
				
				<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [invoice_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>
			<td>
		' . $row [invoice_no] . '
		</td>

									<td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row ['customer'] . '</a></div></td>
				

		<td>
		' . $row [ref_no] . '
		</td>

		<td>
		 ' . $row [type] . '
		</td>

		 <td align="right" class="info">
		 ' . $row [total] . '
		</td>

		 <td align="right" class="warning">
		 ' . $row [paid] . '
		</td>

		 <td align="right" class="success">
		 ' . $row [due] . '
		</td></tr>
			
		<div class="modal fade" id="' . $row [invoice_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [invoice_no] . '" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">Invoice
		</div>
		<div class="modal-body">
		<iframe src="invoice.php?job=view&invoice_no=' . $row [invoice_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		</div>
		</div>';
		$due = $due + $row ['due'];
	}
	
	$formated_due = number_format ( $due, 2 );
	
	echo '<tr>
			<td colspan="7" align="right"><strong></strong></td>
			
	<td align="right" class="danger">
	<strong>' . $formated_due . '</strong>
	</td>
	</tr></table></div>';
	
	
}
function outstanding_other_expenses_report($customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($customer) {
		$customer_name_check = "AND customer LIKE '$customer'";
	} else {
		$customer_name_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND other_expenses_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND other_expenses_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND other_expenses_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	<tr class="danger" style="font-weight: bold;">

	<td>View</td>
	<td>No</td>
	<td>Customer</td>
	<td>Ref No</td>
	<td>Ref Type</td>
	<td align="right">Total</td>
	<td align="right">Paid</td>
	<td align="right">Due</td>
	</tr>';
	
	$due = 0;
	$result = mysqli_query ( $conn, "SELECT * FROM other_expenses WHERE cancel_status='0' AND due > 0 $date_check $customer_name_check ORDER BY id $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
		<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [other_expenses_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>
			<td>
		' . $row [other_expenses_no] . '
		</td>

									<td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row ['customer'] . '</a></div></td>

		<td>
		' . $row [ref_no] . '
		</td>

		<td>
		 ' . $row [ref_type] . '
		</td>

		  <td align="right" class="info">
		 ' . $row [total] . '
		</td>

		 <td align="right" class="warning">
		 ' . $row [paid] . '
		</td>

		 <td align="right" class="success">
		 ' . $row [due] . '
		</td></tr>
			
		<div class="modal fade" id="' . $row [other_expenses_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [other_expenses_no] . '" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">Invoice
		</div>
		<div class="modal-body">
		<iframe src="other_expenses.php?job=view&other_expenses_no=' . $row [other_expenses_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		</div>
		</div>';
		$due = $due + $row ['due'];
	}
	
	$formated_due = number_format ( $due, 2 );
	
	echo '<tr>
			<td colspan="7" align="right"><strong></strong></td>
			
	<td align="right" class="danger">
	<strong>' . $formated_due . '</strong>
	</td>
	</tr></table></div>';
	
	
}
function outstanding_voucher_report($travels, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($travels) {
		$travels_name_check = "AND travels LIKE '$travels'";
	} else {
		$travels_name_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND voucher_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND voucher_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND voucher_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	<tr class="danger" style="font-weight: bold;">

	<td>View</td>
	<td>No</td>
	<td>Travels</td>
	<td>Booking No</td>
	<td>Pnr</td>
	<td align="right">Total</td>
	<td align="right">Paid</td>
	<td align="right">Due</td>
	</tr>';
	
	$due = 0;
	$result = mysqli_query ( $conn, "SELECT * FROM voucher WHERE cancel_status='0' AND due > 0 $date_check $travels_name_check ORDER BY id $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>

			<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [voucher_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>
			<td>
		' . $row [voucher_no] . '
		</td>

		<td>
		 ' . $row [travels] . '
		</td>

		<td>
		' . $row [booking_no] . '
		</td>

		<td>
		 ' . $row [pnr] . '
		</td>
 		<td align="right" class="info">
		 ' . $row [total] . '
		</td>

		 <td align="right" class="warning">
		 ' . $row [paid] . '
		</td>

		 <td align="right" class="success">
		 ' . $row [due] . '
		</td></tr>
			
		
		<div class="modal fade" id="' . $row [voucher_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [voucher_no] . '" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">Invoice
		</div>
		<div class="modal-body">
		<iframe src="voucher.php?job=view&voucher_no=' . $row [voucher_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		</div>
		</div>';
		$due = $due + $row ['due'];
	}
	
	$formated_due = number_format ( $due, 2 );
	
	echo '<tr>
			<td colspan="7" align="right"><strong></strong></td>
			
	<td align="right" class="danger">
	<strong>' . $formated_due . '</strong>
	</td>
	</tr></table></div>';
	
	
}
function customer_due_report() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM customer WHERE customer_id='$customer_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		return $row;
	}
	
	
}
function customer_invoice_due($from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($to_date && $from_date) {
		$date_check = "AND invoice_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND invoice_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND invoice_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	$result = mysqli_query ( $conn, "SELECT DISTINCT customer_id FROM invoice WHERE due>0 AND cancel_status='0' $date_check" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$customer_info = get_customer_info_by_customer_id ( $row [customer_id] );
		echo "<h1>$customer_info[customer_name]</h1>";
		
		echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
				<tr class="danger" style="font-weight: bold;">
				
				<td>View</td>
				<td>No</td>
				<td>Invoice Date</td>
				<td>Ref No</td>
				<td>Type</td>
				<td align="right">Total</td>
				<td align="right">Paid</td>
				<td align="right">Due</td>
				</tr>';
		
		$due = 0;
		$result1 = mysqli_query ($conn, "SELECT * FROM invoice WHERE cancel_status='0' AND due > 0 AND customer_id='$row[customer_id]' $date_check ORDER BY id $limit" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
	
						
				<td>
		<a href="#" data-toggle="modal" data-target="#' . $row1 [invoice_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>
			<td>
		' . $row1 [invoice_no] . '
		</td>
	
		<td>
		 ' . $row1 [invoice_date] . '
		</td>
	
		<td>
		' . $row1 [ref_no] . '
		</td>
	
		<td>
		 ' . $row1 [type] . '
		</td>
	
		 <td align="right" class="info">
		 ' . $row1 [total] . '
		</td>
	
		 <td align="right" class="warning">
		 ' . $row1 [paid] . '
		</td>
	
		 <td align="right" class="success">
		 ' . $row1 [due] . '
		</td></tr>
			
		 			
		<div class="modal fade" id="' . $row1 [invoice_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row1 [invoice_no] . '" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">Invoice
		</div>
		<div class="modal-body">
		<iframe src="invoice.php?job=view&invoice_no=' . $row1 [invoice_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		</div>
		</div>';
			$due = $due + $row1 ['due'];
		}
		
		$formated_due = number_format ( $due, 2 );
		
		echo '<tr>
			<td colspan="7" align="right"><strong></strong></td>
		
	<td align="right" class="danger">
	<strong>' . $formated_due . '</strong>
	</td>
	</tr></table></div>';
	}
	
}
function customer_other_expenses_due($from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($to_date && $from_date) {
		$date_check = "AND other_expenses_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND other_expenses_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND other_expenses_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	$result = mysqli_query ($conn, "SELECT DISTINCT customer_id FROM other_expenses WHERE due>0 AND cancel_status='0' $date_check" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$customer_info = get_customer_info_by_customer_id ( $row [customer_id] );
		echo "<h1>$customer_info[customer_name]</h1>";
		
		echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	<tr class="danger" style="font-weight: bold;">

	<td>View</td>
	<td>No</td>
	<td>Other Expenses Date</td>
	<td>Ref No</td>
	<td>Ref Type</td>
	<td align="right">Total</td>
	<td align="right">Paid</td>
	<td align="right">Due</td>
	</tr>';
		
		$due = 0;
		$result1 = mysqli_query ($conn, "SELECT * FROM other_expenses WHERE cancel_status='0' AND due > 0 AND customer_id='$row[customer_id]'$date_check  ORDER BY id $limit" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>

				<td>
		<a href="#" data-toggle="modal" data-target="#' . $row1 [other_expenses_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>
			<td>
		' . $row1 [other_expenses_no] . '
		</td>

		<td>
		 ' . $row1 [other_expenses_date] . '
		</td>

		<td>
		' . $row1 [ref_no] . '
		</td>

		<td>
		 ' . $row1 [ref_type] . '
		</td>

		  <td align="right" class="info">
		 ' . $row1 [total] . '
		</td>

		 <td align="right" class="warning">
		 ' . $row1 [paid] . '
		</td>

		 <td align="right" class="success">
		 ' . $row1 [due] . '
		</td></tr>
			
		 		<div class="modal fade" id="' . $row1 [other_expenses_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row1 [other_expenses_no] . '" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">Invoice
		</div>
		<div class="modal-body">
		<iframe src="other_expenses.php?job=view&other_expenses_no=' . $row1 [other_expenses_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		</div>
		</div>';
			
			$due = $due + $row1 ['due'];
		}
		
		$formated_due = number_format ( $due, 2 );
		
		echo '<tr>
			<td colspan="7" align="right"><strong></strong></td>
			
	<td align="right" class="danger">
	<strong>' . $formated_due . '</strong>
	</td>
	</tr></table></div>';
	}
	
}
function customer_voucher_due($from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($to_date && $from_date) {
		$date_check = "AND voucher_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND voucher_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND voucher_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	$result = mysqli_query ($conn, "SELECT DISTINCT travels FROM voucher WHERE due>0 AND cancel_status='0' $date_check" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo "<h1>$row[travels]</h1>";
		
		echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	<tr class="danger" style="font-weight: bold;">

	<td>View</td>
	<td>No</td>
	<td>Travels</td>
	<td>Booking No</td>
	<td>Pnr</td>
	<td align="right">Total</td>
	<td align="right">Paid</td>
	<td align="right">Due</td>
	</tr>';
		
		$due = 0;
		$result1 = mysqli_query ($conn, "SELECT * FROM voucher WHERE cancel_status='0' AND due >0  AND travels='$row[travels]' $date_check ORDER BY id $limit" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>

				<td>
		<a href="#" data-toggle="modal" data-target="#' . $row1 [voucher_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>
			<td>
		' . $row1 [voucher_no] . '
		</td>

		<td>
		 ' . $row1 [travels] . '
		</td>

		<td>
		' . $row1 [booking_no] . '
		</td>

		<td>
		 ' . $row1 [pnr] . '
		</td>
 <td align="right" class="info">
		 ' . $row1 [total] . '
		</td>

		 <td align="right" class="warning">
		 ' . $row1 [paid] . '
		</td>

		 <td align="right" class="success">
		 ' . $row1 [due] . '
		</td></tr>
			<div class="modal fade" id="' . $row1 [voucher_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row1 [voucher_no] . '" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">Invoice
		</div>
		<div class="modal-body">
		<iframe src="voucher.php?job=view&voucher_no=' . $row1 [voucher_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		</div>
		</div>';
			
			$due = $due + $row1 ['due'];
		}
		
		$formated_due = number_format ( $due, 2 );
		
		echo '<tr>
			<td colspan="7" align="right"><strong></strong></td>
		
	<td align="right" class="danger">
	<strong>' . $formated_due . '</strong>
	</td>
	</tr></table></div>';
	}
	
}
