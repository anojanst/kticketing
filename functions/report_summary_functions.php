<?php
function final_cheque_inventory_report($status, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($status) {
		$status_check = "AND status LIKE '$status'";
	} else {
		$status_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND che_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND che_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND che_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
				<tr style="font-weight: bold;">
	<td colspan="5" class="danger">Cheque Detail</td>
	<td colspan="3" class="success">Referrence Detail</td>
	<td class="info">Status</td>
	<td class="warning">Presented</td>
	<td colspan="3" class="info">Deposited</td>
	<td class="success">Realised</td>
	<td class="danger">Returned</td>

	</tr>

	<tr style="font-weight: bold;">
	<td class="danger" >No</td>
	<td class="danger" >Amount</td>
	<td class="danger" >Date</td>
	<td class="danger" >Bank</td>
	<td class="danger" >Branch</td>
	<td class="success">No</td>
	<td class="success">Type</td>
	<td class="success">Date</td>
	<td class="info">Status</td>
	<td class="warning">Date</td>
	<td class="info">Ref</td>
	<td class="info">Date</td>
	<td class="info">Account</td>
	<td class="success">Date</td>
	<td class="danger">Date</td>

	</tr>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE cancel_status='0' $status_check $date_check ORDER BY id $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
	}
	
	echo '</tr></table></div>';
	
	
}
function final_income_expence_report($branch, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">

	<thead><th>Date</th>
	<th>Ref No</th>
	<th>Type</th>
	<th>Cusromer</th>
	<th class="success">Income</th>
	<th class="danger">Expense</th>
	</thead>
	<tbody>';
	
	$from = strtotime ( $from_date );
	$to = strtotime ( $to_date );
	
	$days = round ( ($to - $from) / 86400 );
	
	$i = 0;
	while ( $i < $days ) {
		$datetime = new DateTime ( $from_date );
		$datetime->modify ( '+' . $i . ' day' );
		$date = $datetime->format ( 'Y-m-d' );
		$date_display = '0';
		
		$result = mysqli_query ( $conn, "SELECT invoice_no,	type, customer,invoice_date,paid FROM invoice WHERE cancel_status='0' AND branch='$branch' AND invoice_date = '$date' AND paid>'0'" );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			
			$rec_total = $rec_total + $row [paid];
		}
		
		$result1 = mysqli_query ( $conn, "SELECT booking.branch, voucher.voucher_no, voucher.travels, voucher.paid, voucher.voucher_date FROM booking, voucher
				WHERE booking.booking_no=voucher.booking_no AND booking.branch='$branch' AND voucher_date = '$date' AND voucher.paid>'0' AND voucher.cancel_status='0'" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			
			if ($date_display == '0') {
				
				$date_display = 1;
			} 

			else {
			}
			
			$pay_total = $pay_total + $row1 [paid];
		}
		
		$result = mysqli_query ($conn, "SELECT other_expenses_no,customer,	type, other_expenses_date,paid FROM other_expenses WHERE cancel_status='0' AND branch='$branch' AND other_expenses_date = '$date' AND paid>'0'" );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			
			if ($date_display == '0') {
				
				$date_display = 1;
			} else {
			}
			
			$oth_total = $oth_total + $row [paid];
		}
		
		$i ++;
	}
	
	$net = number_format ( ($rec_total - ($pay_total + $oth_total)), 2 );
	
	
}
function final_list_staff_profit($from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$i = 1;
	
	$result = mysqli_query ($conn, "SELECT * FROM users WHERE cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($to_date && $from_date) {
			$date_check = "AND saved BETWEEN '$from_date' AND '$to_date'";
		} elseif ($from_date) {
			$date_check = "AND saved>='$from_date'";
			$limit = "";
		} elseif ($to_date) {
			$date_check = "AND saved<='$to_date'";
			$limit = "";
		} else {
			$date_check = "";
			$limit = "LIMIT 50";
		}
		$branch = $_SESSION ['branch'];
		if ($branch == "Head Office") {
			$branch_name_check = "";
		} else {
			$branch_name_check = "AND branch LIKE '$branch'";
		}
		
		$profit = 0;
		$received = 0;
		$pending = 0;
		
		$result1 = mysqli_query ($conn, "SELECT * FROM booking WHERE completed_by='$row[user_name]' AND status='1' AND cancel_status='0' $branch_name_check $date_check" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			$invoice_info = get_invoice_info_by_booking_no ( $row1 [booking_no] );
			$fare_info = get_fare_detail ( $row1 [fare_id] );
			$adult_markup = $row1 [adult] * $fare_info [adult_markup];
			$child_markup = $row1 [child] * $fare_info [child_markup];
			$infant_markup = $row1 [infant] * $fare_info [infant_markup];
			$total_markup = $adult_markup + $child_markup + $infant_markup;
			
			$profit = $profit + $total_markup;
			$received = $received + $invoice_info [paid];
			$pending = $pending + $invoice_info [due];
			$i ++;
		}
	}
}
function final_outstanding_invoice_report($customer, $from_date, $to_date) {
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
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                <thead>
                    <tr class="danger" style="font-weight: bold;">
                        <td>View</td>
                        <td>No</td>
                        <td>Customer</td>
                        <td>Ref No</td>
                        <td>Type</td>
                        <td align="right">Total</td>
                        <td align="right">Paid</td>
                        <td align="right">Due</td>
                    </tr>
                    </thead>
                    <tbody>';
	
	$due = 0;
	$result = mysqli_query ( $conn, "SELECT * FROM invoice WHERE cancel_status='0' AND due > 0 $date_check $customer_name_check ORDER BY id $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$due = $due + $row ['due'];
	}
	
	$formated_due = number_format ( $due, 2 );
	
	echo '<tr>
			<td colspan="7" align="right"><strong></strong></td>
		
	<td align="right" class="danger">
	<strong>' . $formated_due . '</strong>
	</td>
	</tr></tbody></table></div>';
	
	
}
function final_outstanding_other_expenses_report($customer, $from_date, $to_date) {
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
              <table id="example2" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                <thead>
                    <tr class="danger" style="font-weight: bold;">
                        <td>View</td>
                        <td>No</td>
                        <td>Customer</td>
                        <td>Ref No</td>
                        <td>Ref Type</td>
                        <td align="right">Total</td>
                        <td align="right">Paid</td>
                        <td align="right">Due</td>
                    </tr>
                    </thead>
                    <tbody>';
	
	$due = 0;
	$result = mysqli_query ($conn, "SELECT * FROM other_expenses WHERE cancel_status='0' AND due > 0 $date_check $customer_name_check ORDER BY id $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$due = $due + $row ['due'];
	}
	
	$formated_due = number_format ( $due, 2 );
	
	echo '<tr>
			<td colspan="7" align="right"><strong></strong></td>
		
	<td align="right" class="danger">
	<strong>' . $formated_due . '</strong>
	</td>
	</tr></tbody></table></div>';
	
	
}
function final_outstanding_voucher_report($travels, $from_date, $to_date) {
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
              <table id="example3" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	            <thead>
                <tr class="danger" style="font-weight: bold;">
                <td>View</td>
                <td>No</td>
                <td>Travels</td>
                <td>Booking No</td>
                <td>Pnr</td>
                <td align="right">Total</td>
                <td align="right">Paid</td>
                <td align="right">Due</td>
                </tr>
                </thead>
                <tbody>';

	$due = 0;
	$result = mysqli_query ($conn, "SELECT * FROM voucher WHERE cancel_status='0' AND due > 0 $date_check $travels_name_check ORDER BY id $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$due = $due + $row ['due'];
	}
	
	$formated_due = number_format ( $due, 2 );
	
	echo '<tr>
			<td colspan="7" align="right"><strong></strong></td>
		
	<td align="right" class="danger">
	<strong>' . $formated_due . '</strong>
	</td>
	</tr></tbody></table></div>';
	
	
}
function final_customer_invoice_due($from_date, $to_date) {
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
	
	$result = mysqli_query ($conn, "SELECT DISTINCT customer_id FROM invoice WHERE due>0 AND cancel_status='0' $date_check" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		
		
		$due = 0;
		$result1 = mysqli_query ( $conn, "SELECT * FROM invoice WHERE cancel_status='0' AND due > 0 AND customer_id='$row[customer_id]' $date_check ORDER BY id $limit" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			$due = $due + $row ['due'];
		}
		
		$formated_due = number_format ( $due, 2 );
	}
	
}
function final_customer_other_expenses_due($from_date, $to_date) {
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
	
	$result = mysqli_query ($conn,  "SELECT DISTINCT customer_id FROM other_expenses WHERE due>0 AND cancel_status='0' $date_check" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		
		$due = 0;
		$result1 = mysqli_query ($conn, "SELECT * FROM other_expenses WHERE cancel_status='0' AND due > 0 AND customer_id='$row[customer_id]'$date_check  ORDER BY id $limit" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			$due = $due + $row ['due'];
		}
		
		$formated_due = number_format ( $due, 2 );
	}
	
}
function final_customer_voucher_due($from_date, $to_date) {
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
	
	$result = mysqli_query ( $conn, "SELECT DISTINCT travels FROM voucher WHERE due>0 AND cancel_status='0' $date_check" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$due = 0;
		$result1 = mysqli_query ( $conn, "SELECT * FROM voucher WHERE cancel_status='0' AND due >0  AND travels='$row[travels]' $date_check ORDER BY id $limit" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			$due = $due + $row ['due'];
		}
		
		$formated_due = number_format ( $due, 2 );
	}
	
}
