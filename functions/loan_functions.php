<?php
function save_loan($loan_no, $serial_no, $loan_amount, $interest, $type, $customer, $customer_id, $interest_date, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO loan(id, loan_no, serial_no, loan_amount, loan_balance, interest,  type, name, customer_id, interest_date, saved_by, branch, saved)
	VALUES ('', '$loan_no', '$serial_no', '$loan_amount', '$loan_amount', '$interest', '$type', '$customer', '$customer_id', '$interest_date', '$user_name', '$branch', '$time')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function update_loan_balance($loan_no, $amount) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_loan_info_by_loan_no ( $loan_no );
	$balance = $info ['loan_balance'] - $amount;
	
	$query = "UPDATE loan SET
	loan_balance='$balance'
	WHERE loan_no='$loan_no'";
	mysqli_query ($conn, $query );
	

}
function reupdate_loan_balance($loan_no, $amount) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_loan_info_by_loan_no ( $loan_no );
	$balance = $info ['loan_balance'] + $amount;
	
	$query = "UPDATE loan SET
	loan_balance='$balance'
	WHERE loan_no='$loan_no'";
	mysqli_query ($conn, $query );
	

}
function get_loan_info_by_loan_no($loan_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn,  "SELECT * FROM loan WHERE loan_no='$loan_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function get_loan_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn,  "SELECT MAX(serial_no) FROM loan" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	

}
function get_serial_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(serial_no) FROM loan" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	

}
function display_loan_detail($loan_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM loan WHERE loan_no='$loan_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
                       <tr>
						   <th>Loanee</th>
                           <th>Amount</th>
						   <th>Interest</th>
                           <th>Type</th>';
		if ($row ['way'] == "Return") {
			echo '
						   <th>Rtn Dep Time</th>
                           <th>Rtn Arr Time</th>';
		}
		echo '<th>Air Line</th>
                           <th>Class</th>
						   <th>Type</th>
                           <th>Adults</th>
						   <th>Children</th>
                           <th>Infants</th>
                           <th>Currency</th>
                       </tr>';
		
		$result1 = mysqli_query ($conn, "SELECT * FROM loan_has_items WHERE loan_no='$loan_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row1 ['dep_time'] . '</td>
				<td>' . $row1 ['arr_time'] . '</td>';
			if ($row ['way'] == "Return") {
				echo '<td>' . $row1 ['rtn_dep_time'] . '</td>
				<td>' . $row1 ['rtn_arr_time'] . '</td>';
			}
			echo '
				<td>' . $row1 ['air_line_code'] . '</td>
				<td>' . $row1 ['class'] . '</td>
				<td>' . $row1 ['type'] . '</td>
				<td>' . $row ['adult'] . '</td>
				<td>' . $row ['child'] . '</td>
				<td>' . $row ['infant'] . '</td>
				<td>' . $row ['currency'] . '</td>
			</tr>';
		}
	}
	echo '
              	</table>
            </div>';
	

}
function display_loan_detail_just_view($loan_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM loan WHERE loan_no='$loan_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="table-responsive">
              <table class="table" style="font-size: 12px;">
                  <tr class="danger">
						   <th>loan No</th>
						   <th>PNR</th>
						   <th>Airline Ref</th>
						   <th>From</th>
                           <th>To</th>
						   <th>Departure Time</th>
                           <th>Arrival Time</th>
						   <th>Flight No</th>';
		if ($row ['way'] == "Return") {
			echo '
							   <th>Rtn Dep Time</th>
	                           <th>Rtn Arr Time</th>
							   <th>Rtn Flight No</th>';
		}
		echo '<th>Air Line Detail</th>
                           <th>Pax</th>
                           <th>Currency</th>
                       </tr>';
		
		$result1 = mysqli_query ($conn, "SELECT * FROM loan_has_flights WHERE loan_no='$loan_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			
			echo '<tr>
				<td rowspan="3">' . $loan_no . '</td>
				<td rowspan="3">' . $row ['pnr'] . '</td>
				<td rowspan="3">' . $row ['al_ref'] . '</td>
				<td rowspan="3">' . $row ['dep_air_port'] . '</td>
				<td rowspan="3">' . $row ['arr_air_port'] . '</td>
				<td rowspan="3">' . $row1 ['dep_time'] . '</td>
				<td rowspan="3">' . $row1 ['arr_time'] . '</td>
				<td rowspan="3">' . $row ['flight_no'] . '</td>';
			if ($row ['way'] == "Return") {
				echo '<td rowspan="3">' . $row1 ['rtn_dep_time'] . '</td>
				<td rowspan="3">' . $row1 ['rtn_arr_time'] . '</td>
				<td rowspan="3">' . $row ['rtn_flight_no'] . '</td>';
			}
			echo '
				<td rowspan="3">' . $row1 ['air_line_code'] . ' &nbsp;' . $row1 ['class'] . '&nbsp; ' . $row1 ['type'] . '</td>
				<td>Adult : ' . $row ['adult'] . '</td>
				<td rowspan="3">' . $row ['currency'] . '</td>
			</tr>
			<tr>
				<td>Child : ' . $row ['child'] . '</td>
			</tr>
			<tr>
				<td>Infant : ' . $row ['infant'] . '</td>
			</tr>';
		}
	}
	echo '
              	</table>
            </div>';
	

}
function display_loan_cost($loan_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM loan WHERE loan_no='$loan_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
                 <tr class="success">
						   <th rowspan="2">Name</th>
                           <th rowspan="2">Mobile</th>
						   <th rowspan="2">Phone</th>
                           <th rowspan="2">Address</th>
						   <th rowspan="2">Email</th>
                           <th colspan="3" style="text-align: center;" class="success">Amount</th>
                       </tr>
					   <tr>
						   <th class="warning">Type</th>
						   <th class="info">Pax</th>
						   <th class="danger">Total</th>
                       </tr>';
		
		$result1 = mysqli_query ($conn, "SELECT * FROM loan_has_items WHERE loan_no='$loan_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			$adult_total = number_format ( ($row ['adult'] * $row1 ['adult_total']), 2 );
			$child_total = number_format ( ($row ['child'] * $row1 ['child_total']), 2 );
			$infant_total = number_format ( ($row ['infant'] * $row1 ['infant_total']), 2 );
			$total_without_off = number_format ( (($row ['adult'] * $row1 ['adult_total']) + ($row ['child'] * $row1 ['child_total']) + ($row ['infant'] * $row1 ['infant_total'])), 2 );
			
			echo '<tr>
				<td rowspan="4">' . $row ['name'] . '</td>';
			if ($row ['customer_id']) {
				$customer_info = get_customer_info_by_customer_id ( $row ['customer_id'] );
				echo '<td rowspan="4">' . $customer_info ['mobile'] . '</td>
						<td rowspan="4">' . $customer_info ['phone'] . '</td>
						<td rowspan="4">' . $customer_info ['address'] . '</td>
						<td rowspan="4">' . $customer_info ['email'] . '</td>';
			} else {
				echo '<td rowspan="4">' . $row ['mobile'] . '</td>
						<td rowspan="4">' . $row ['phone'] . '</td>
						<td rowspan="4">' . $row ['address'] . '</td>
						<td rowspan="4">' . $row ['email'] . '</td>';
			}
			echo '<td>Adult</td>
				<td>' . $row ['adult'] . ' * ' . $row1 ['adult_total'] . '</td>
				<td align="right">' . $adult_total . '</td>
			</tr>';
			if ($row ['child'] > 0) {
				echo '<tr>
					<td>Child</td>
					<td>' . $row ['child'] . ' * ' . $row1 ['child_total'] . '</td>
					<td align="right">' . $child_total . '</td>
				</tr>';
			}
			if ($row ['infant']) {
				echo '<tr>
					<td>Infant</td>
					<td>' . $row ['infant'] . ' * ' . $row1 ['infant_total'] . '</td>
					<td align="right">' . $infant_total . '</td>
				</tr>';
			}
			echo '<tr class="danger">
				<td colspan="2">Total</td>
				<td align="right">' . $total_without_off . '</td>
			</tr>';
			$offer_info = get_offer_info ( $row1 [offer_code] );
			if ($offer_info ['type'] == "Group") {
				echo '<tr>
					<td colspan="2">Group Offers</td>
					<td align="right">' . $offer_info ['off'] . '</td>
				</tr>
				<tr class="danger">
					<td colspan="2">Final Total</td>
					<td align="right">' . $row ['total'] . '</td>
				</tr>';
			}
		}
	}
	echo '
              	</table>
			</div>';
	

}
function delete_passenger($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE loan_has_passengers SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	

}
function update_fare_id($loan_no, $id) {
	$total = get_total ( $loan_no, $id );
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE loan SET
	fare_id='$id',
	total='$total'
	WHERE loan_no='$loan_no'";
	mysqli_query ($conn, $query );
	

}
function update_time_limit($loan_no, $time_limit) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE loan SET
	issue_date='$time_limit'
	WHERE loan_no='$loan_no'";
	mysqli_query ($conn, $query );
	

}
function get_total($loan_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( "SELECT * FROM loan WHERE loan_no='$loan_no' AND cancel_status='0' ORDER BY id ASC", $conn );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$result1 = mysqli_query ($conn, "SELECT * FROM loan_has_items WHERE loan_no='$loan_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			$adult_total = number_format ( ($row ['adult'] * $row1 ['adult_total']), 2 );
			$child_total = number_format ( ($row ['child'] * $row1 ['child_total']), 2 );
			$infant_total = number_format ( ($row ['infant'] * $row1 ['infant_total']), 2 );
			$total_without_offer = ($row ['adult'] * $row1 ['adult_total']) + ($row ['child'] * $row1 ['child_total']) + ($row ['infant'] * $row1 ['infant_total']);
			
			$offer_info = get_offer_info ( $row1 [offer_code] );
			if ($offer_info ['type'] == "Group") {
				$total = $total_without_offer - $offer_info ['off'];
			} else {
				$total = $total_without_offer;
			}
			return $total;
		}
	}
}
function get_fare_total($fare_id, $adult, $infant, $child) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result1 = mysqli_query ($conn, "SELECT * FROM loan_has_items WHERE id='$fare_id' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
		$adult_fare = $adult * $row1 ['adult_fare'];
		$child_fare = $child * $row1 ['child_fare'];
		$infant_fare = $infant * $row1 ['infant_fare'];
		
		$total = $adult_fare + $child_fare + $infant_fare;
		
		return $total;
	}
}
function get_passenger_count($loan_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM loan_has_passengers WHERE loan_no='$loan_no' AND cancel_status='0'" );
	$num_rows = mysqli_num_rows ( $result );
	
	return $num_rows;
	

}
function complete_loan($loan_no, $amount, $off, $total, $first_time) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE loan SET
	status='1',
	amount='$amount',
	off='$off',
	total='$total',
	first_time='$first_time'
	WHERE loan_no='$loan_no'";
	mysqli_query ($conn, $query );
	

}
function check_customer($customer) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ( "SELECT id FROM customer WHERE customer_name = '$customer' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}
}
function check_repetive_passport_no($loan_no, $passport_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ( "SELECT id FROM loan_has_passengers WHERE loan_no='$loan_no' AND passport_no='$passport_no' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}
	

}
function check_passengers($loan_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ( "SELECT id FROM loan_has_passengers WHERE loan_no='$loan_no' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}

}
function list_non_confirm($loan_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($loan_no) {
		$loan_no_check = "AND loan_no LIKE '%$loan_no%'";
	} else {
		$loan_no_check = "";
	}
	
	if ($customer) {
		$customer_check = "AND name LIKE '%$customer%'";
	} else {
		$customer_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND dep_date BETWEEN '$to_date' AND '$from_date'";
	} elseif ($from_date) {
		$date_check = "AND dep_date>='$from_date'";
	} elseif ($to_date) {
		$date_check = "AND dep_date<='$to_date'";
	} else {
		$date_check = "";
	}
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
                  <thead>
                       <tr class="info">
						   <th>loan No</th>
                           <th>Way</th>
						   <th>From</th>
                           <th>To</th>
						   <th>Dep Date</th>
						   <th>Arr Date</th>
                           <th>Customer</th>
						   <th>Mobile</th>
                           <th>Created By</th>
						   <th>Created</th>
                       </tr>
				   </thead>
                <tbody>';
	
	$result = mysqli_query ($conn, "SELECT * FROM loan WHERE status='0' AND cancel_status='0' AND loan_type='TICKET' $loan_no_check $customer_check $date_check ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$time1 = strtotime ( date ( "y-m-d H:i:s" ) );
		$time2 = strtotime ( $row ['saved'] );
		
		$diff = $time1 - $time2;
		if ($diff > "259200") {
			echo '<tr>
				<td><a href="loan.php?job=from_non_confim&loan_no=' . $row ['loan_no'] . '" class="btn btn-danger">' . $row ['loan_no'] . '</a></td>
				<td>' . $row ['way'] . '</td>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row ['dep_date'] . '</td>
				<td>' . $row ['rtn_date'] . '</td>
				<td>' . $row ['name'] . '</td>';
			
			$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE customer_id='$row[customer_id]' AND cancel_status='0' ORDER BY id ASC" );
			while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
				echo '
					<td>' . $row1 ['mobile'] . '</td>';
			}
			echo '
				<td>' . $row ['saved_by'] . '</td>
				<td>' . $row ['saved'] . '</td>
			</tr>';
		} else {
			if ($row ['saved_by'] == $_SESSION ['user_name']) {
				echo '<tr>
				<td><a href="loan.php?job=from_non_confim&loan_no=' . $row ['loan_no'] . '" class="btn btn-danger">' . $row ['loan_no'] . '</a></td>
				<td>' . $row ['way'] . '</td>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row ['dep_date'] . '</td>
				<td>' . $row ['rtn_date'] . '</td>
				<td>' . $row ['name'] . '</td>';
				
				$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE customer_id='$row[customer_id]' AND cancel_status='0' ORDER BY id ASC" );
				while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
					echo '
				<td>' . $row1 ['mobile'] . '</td>';
				}
				echo '
				<td>' . $row ['saved_by'] . '</td>
				<td>' . $row ['saved'] . '</td>
			</tr>';
			}
		}
	}
	echo '			</tbody>
              	</table>
            </div>
	
			';

}