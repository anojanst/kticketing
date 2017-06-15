<?php
function income_expence_report($branch, $from_date, $to_date) {
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
		
		$result = mysqli_query ($conn, "SELECT invoice_no,	type, customer,invoice_date,paid FROM invoice WHERE cancel_status='0' AND branch='$branch' AND invoice_date = '$date' AND paid>'0'" );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			echo '
			<tr>';
			if ($date_display == '0') {
				echo '<td>' . $date . '</td>';
				$date_display = 1;
			} else {
				echo '<td></td>';
			}
			
			echo '<td>
			<a href="invoice.php?job=view_receipt&invoice_no=' . $row [invoice_no] . '"target="blank">' . $row [invoice_no] . '
			</td>
			<td>
			 ' . $row [type] . '
			</td>
					
			
				<td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row ['customer'] . '</a></div></td>
			 					
			
			<td align="right" class="success">
			 ' . $row [paid] . '
			</td>
			
			<td class="danger"></td>
			</tr>';
			
			$rec_total = $rec_total + $row [paid];
		}
		
		$result1 = mysqli_query ( $conn, "SELECT booking.branch, voucher.voucher_no, voucher.travels, voucher.paid, voucher.voucher_date FROM booking, voucher
		WHERE booking.booking_no=voucher.booking_no AND booking.branch='$branch' AND voucher_date = '$date' AND voucher.paid>'0' AND voucher.cancel_status='0'" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '
			<tr>';
			if ($date_display == '0') {
				echo '<td>' . $date . '</td>';
				$date_display = 1;
			} 

			else {
				echo '<td></td>';
			}
			
			echo '
			<td>
			<a href="voucher.php?job=print_paybill&voucher_no=' . $row1 [voucher_no] . '" target="blank">' . $row1 [voucher_no] . '</a>
			</td>
			<td>
			 voucher
			</td>
			<td>
			 ' . $row1 [customer_id] . '
			</td>
			<td class="success"></td>
			<td align="right" class="danger">
			 ' . $row1 [paid] . '
			</td>
			
			</tr>';
			
			$pay_total = $pay_total + $row1 [paid];
		}
		
		$result = mysqli_query ($conn, "SELECT other_expenses_no,customer,	type, other_expenses_date,paid FROM other_expenses WHERE cancel_status='0' AND branch='$branch' AND other_expenses_date = '$date' AND paid>'0'" );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			echo '
			<tr>';
			if ($date_display == '0') {
				echo '<td>' . $date . '</td>';
				$date_display = 1;
			} else {
				echo '<td></td>';
			}
			
			echo '<td>
			<a href="other_expenses.php?job=view_receipt&other_expenses_no=' . $row [other_expenses_no] . '"target="blank">' . $row [other_expenses_no] . '
			</td>
		<td>
			 ' . $row [type] . '
			</td>
							<td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row ['customer'] . '</a></div></td>
			 		
			<td class="success"></td>
			<td align="right" class="danger">
			 ' . $row [paid] . '
			</td>
		
			
			</tr>';
			
			$oth_total = $oth_total + $row [paid];
		}
		
		$i ++;
	}
	
	$net = number_format ( ($rec_total - ($pay_total + $oth_total)), 2 );
	
	echo '<tr>
			<td colspan="4" align="right" class="success"><strong>Total</strong></td>
			
			<td align="right" class="success">
			 ' . number_format ( $rec_total, 2 ) . '
			</td>
			<td align="right" class="danger">
			 ' . number_format ( ($pay_total + $oth_total), 2 ) . '
			</td>
			</tr>
			 		
			<tr>
			<td colspan="4" align="right" class="warning"><strong>Net</strong></td>
			
			<td colspan="3" align="right" class="warning">
			 ' . $net . '
			</td>
			
			</tr>
			 		
			</tbody></table></div>';
	
	
}
function cheque_inventory_report($status, $from_date, $to_date) {
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
		echo '<tr><td class="danger">' . $row [che_no] . '</td>
			<td class="danger">' . $row [che_amount] . '</td>
			<td class="danger">' . $row [che_date] . '</td>
			<td class="danger">' . $row [che_bank] . '</td>
			<td class="danger">' . $row [che_branch] . '</td>
			<td class="success">' . $row [rec_ref] . '</td>
			<td class="success">' . $row [rec_type] . '</td>
			<td class="success">' . $row [rec_date] . '</td>
			<td class="info">' . $row [status] . '</td>
			<td class="warning">' . $row [presented_date] . '</td>
			<td class="info">' . $row [dep_ref] . '</td>
			<td class="info">' . $row [dep_date] . '</td>
			<td class="info">' . $row [dep_account_no] . '</td>
			<td class="success">' . $row [real_date] . '</td>
			<td class="danger">' . $row [ret_date] . '</td>
			';
	}
	
	echo '</tr></table></div>';
	
	
}
function search_pnr_report($pnr) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo "<h1><B>Booking Details By PNR</B></h1>";
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	<tr class="danger" style="font-weight: bold;">

	<td>ID</td>
	<td>Booking No</td>
	<td>Air Line Code</td>
	<td>Dep Time</td>
	<td>Saved By</td>
	
	</tr>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM booking b, booking_has_items i WHERE i.cancel_status='0' AND i.id=b.fare_id AND b.pnr LIKE '%$pnr%' ORDER BY i.id $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>

		<td>
		' . $row [id] . '
		</td>
		<td>
			<div class="col-lg-1" style="color:white;"><a href="booking.php?job=view&booking_no=' . $row ['booking_no'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row ['booking_no'] . '</a></div>		</td>
		<td>
		' . $row [air_line_code] . '
		</td>

		<td>
		 ' . $row [dep_time] . '
		</td>

		<td>
		' . $row [saved_by] . '
		</td>

	</tr>';
	}
	
	echo '</tr></table></div>';
	
	echo "<h1><B>PNR Details Updates</B></h1>";
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	<tr class="danger" style="font-weight: bold;">
		
	<td>ID</td>
	<td>Name</td>
	<td>Date</td>
		
	</tr>';
	
	$result = mysqli_query ($conn, "SELECT * FROM cancel_pnr WHERE pnr LIKE '%$pnr%' ORDER BY id $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
		
		<td>
		' . $row [id] . '
		</td>
			<td>
		' . $row [user_name] . '
		</td>
		
		<td>
		 ' . $row [date] . '
		</td>
		
	</tr>';
	}
	echo '</tr></table></div>';
	
}