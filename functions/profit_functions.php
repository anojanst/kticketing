<?php
function list_staff_profit($from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$i = 1;
	
	$result = mysqli_query ( $conn, "SELECT * FROM users WHERE cancel_status='0'" );
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
		
		echo '<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    ' . $row [full_name] . '
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
              			<table class="table" style="font-size: 13px;">
						<thead>
                       		<tr class="success">
								<td>Booking No</td>
								<td>Booking Date</td>
                    			<td>Booking Type</td>
								<td align="right">Total</td>
								<td align="right">Profit</td>
                    			<td align="right">Amount Received</td>
								<td align="right">Due</td>
							</tr>
						</thead>
						<tbody>';
		$profit = 0;
		$received = 0;
		$pending = 0;
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM booking WHERE completed_by='$row[user_name]' AND status='1' AND cancel_status='0' $branch_name_check $date_check" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			$invoice_info = get_invoice_info_by_booking_no ( $row1 [booking_no] );
			$fare_info = get_fare_detail ( $row1 [fare_id] );
			$adult_markup = $row1 [adult] * $fare_info [adult_markup];
			$child_markup = $row1 [child] * $fare_info [child_markup];
			$infant_markup = $row1 [infant] * $fare_info [infant_markup];
			$total_markup = $adult_markup + $child_markup + $infant_markup;
			
			echo '<tr>
				<td>' . $row1 [booking_no] . '</td>
				<td>' . $row1 [saved] . '</td>
				<td>' . $row1 [booking_type] . '</td>
 				<td  align="right" class="info">' . $row1 [total] . '</td>
				<td  align="right" class="warning">' . $total_markup . '</td>
 				<td  align="right" class="success">' . $invoice_info [paid] . '</td>
 				<td  align="right" class="danger">' . $invoice_info [due] . '</td>
			</tr>';
			
			$profit = $profit + $total_markup;
			$received = $received + $invoice_info [paid];
			$pending = $pending + $invoice_info [due];
			$i ++;
		}
		echo '
		<tr class="danger">
		
		<td></td>
		
		<td></td>
		<td></td>
		
		 <td></td>
		
		<td align="right">
		' . number_format ( $profit, 2 ) . '
		</td>
		
		<td align="right">
		' . number_format ( $received, 2 ) . '
		</td>
		
		<td align="right">
		' . number_format ( $pending, 2 ) . '
		</td>
		</tr>';
		
		echo '</tbody></table> </div>
            </div> </div>';
	}
}


	