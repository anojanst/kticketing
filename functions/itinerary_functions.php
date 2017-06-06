<?php
function list_air_lines() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM air_lines WHERE cancel_status='0' ORDER BY air_line ASC" );
	$i = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$air_line_names [$i] = $row ['air_line_code'];
		$i ++;
	}
	return $air_line_names;
	

}
function list_air_ports() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM air_ports WHERE cancel_status='0' ORDER BY air_port ASC" );
	$i = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$air_port_names [$i] = $row ['air_port'];
		$i ++;
	}
	return $air_port_names;
	

}
function save_itinerary($itinerary_no, $serial_no, $country, $type, $customer, $customer_id, $count, $submit_date, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO itinerary(id, itinerary_no, serial_no, country, type, name, customer_id, count, submit_date, saved_by, branch, saved)
	VALUES ('', '$itinerary_no', '$serial_no', '$country', '$type', '$customer', '$customer_id', '$count', '$submit_date', '$user_name', '$branch', '$time')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function update_itinerary($itinerary_no, $serial_no, $country, $type, $customer, $customer_id, $count, $submit_date, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "Y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE itinerary SET
	name='$customer',
	customer_id='$customer_id',
	country='$country',
	type='$type',
	count='$count',
	submit_date='$submit_date',
	saved_by='$user_name',
	branch='$branch',
	saved='$time'
	WHERE itinerary_no='$itinerary_no'";
	mysqli_query ($conn, $query );
	

}
function get_itinerary_info_by_itinerary_no($itinerary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM itinerary WHERE itinerary_no='$itinerary_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function get_itinerary_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(serial_no) FROM itinerary" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	

}
function get_serial_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(serial_no) FROM itinerary" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	

}
function list_itinerary_has_flights($itinerary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 14px; border: 1px white solid;">
	              <tr>
                      <td style="border: none;"><strong>Flight No</strong></td>
                      <td style="border: none;"><strong>Sector</strong></td>
                      <td style="border: none;"><strong>Depature</strong></td>
					  <td style="border: none;"><strong>Arrival</strong></td>
                  </tr>';
	
	$result = mysqli_query ($conn, "SELECT * FROM itinerary_has_flights WHERE itinerary_no='$itinerary_no' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
				<td style="border: none;"><strong>' . $row ['flight_no'] . '</strong></td>
				<td style="border: none;"><strong>' . $row ['dep_air_port'] . '/' . $row ['arr_air_port'] . '</strong></td>
				<td style="border: none;"><strong>' . $row ['dep_time'] . '</strong></td>
				<td style="border: none;"><strong>' . $row ['arr_time'] . '</strong></td>
			</tr>';
	}
	echo '</table>
      </div>';

}
function display_itinerary_detail($itinerary_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn,  "SELECT * FROM itinerary WHERE itinerary_no='$itinerary_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
                       <tr>
						   <th>From</th>
                           <th>To</th>
						   <th>Departure Time</th>
                           <th>Arrival Time</th>';
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
		
		$result1 = mysqli_query ($conn, "SELECT * FROM itinerary_has_items WHERE itinerary_no='$itinerary_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
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
function display_itinerary_detail_just_view($itinerary_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM itinerary WHERE itinerary_no='$itinerary_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="table-responsive">
              <table class="table" style="font-size: 12px;">
                  <tr class="danger">
						   <th>itinerary No</th>
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
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM itinerary_has_flights WHERE itinerary_no='$itinerary_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			
			echo '<tr>
				<td rowspan="3">' . $itinerary_no . '</td>
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
function display_itinerary_cost($itinerary_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM itinerary WHERE itinerary_no='$itinerary_no' AND cancel_status='0' ORDER BY id ASC" );
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
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM itinerary_has_items WHERE itinerary_no='$itinerary_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
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
function add_flight($itinerary_no, $flight_no, $dep_air_port, $arr_air_port, $arr_time, $dep_time) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO itinerary_has_flights (id, itinerary_no, flight_no, dep_air_port, arr_air_port, arr_time, dep_time, saved_by)
	VALUES ('', '$itinerary_no', '$flight_no', '$dep_air_port', '$arr_air_port', '$arr_time', '$dep_time', '$_SESSION[user_name]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function add_passenger_to_itinerary($itinerary_no, $passport_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO itinerary_has_passengers (id, itinerary_no, passport_no, saved_by)
	VALUES ('', '$itinerary_no', '$passport_no', '$_SESSION[user_name]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function add_visa($itinerary_no, $passport_no, $visa_copy) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE itinerary_has_passengers SET
	visa_copy='$visa_copy'
	WHERE itinerary_no='$itinerary_no' AND passport_no='$passport_no'";
	mysqli_query ($conn, $query );
	

}
function list_passengers_details($itinerary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
                 
                       <tr class="danger">
						   <th>Delete</th>
						   <th>Passenger</th>
                           <th>Passport No</th>
                       </tr>
				   ';
	$result = mysqli_query ( $conn, "SELECT * FROM itinerary_has_passengers WHERE itinerary_no='$itinerary_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td><a href="itinerary.php?job=delete_passenger&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this user?\')"><i class="fa fa-times fa-2x"></i></a></td>
				<td>' . $row1 ['first_name'] . '/' . $row1 ['last_name'] . ' ' . $row1 ['salute'] . '</td>
				<td>' . $row ['passport_no'] . '</td>	
			</tr>';
		}
	}
	echo '		
              	</table>
            </div>
			
			';
	

}
function list_passengers_details_just_view($itinerary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">';
	
	$result = mysqli_query ( $conn, "SELECT * FROM itinerary_has_passengers WHERE itinerary_no='$itinerary_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr >
				<td style="text-decoration: underline; border: none;"><strong>' . $row1 ['first_name'] . '/' . $row1 ['last_name'] . ' ' . $row1 ['salute'] . '</stong></td>
				<td style="text-decoration: underline; border: none;"><strong>PPNO: ' . $row ['passport_no'] . '</stong></td>';
		}
	}
	echo '
              	</table>
            </div>
		
			';

}
function get_itinerary_passengers_for_voucher($itinerary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
				<tr><th colspan="2" align="center" class="info">Passengers</th></tr>';
	$result = mysqli_query ($conn, "SELECT * FROM itinerary_has_passengers WHERE itinerary_no='$itinerary_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td>' . $row1 ['salute'] . '</td>
				<td>' . $row1 ['first_name'] . '/' . $row1 ['last_name'] . '</td>
			</tr>';
		}
	}
	echo '			</tbody>
              	</table>
            </div>

			';

}
function get_itinerary_details_for_voucher($itinerary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM itinerary WHERE itinerary_no='$itinerary_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="table-responsive">
              <table class="table" style="font-size: 12px;">
                       <tr class="danger">
						   <th>No of Pax</th>
						   <th>From</th>
                           <th>To</th>
						   <th>Date</th>
						   <th>Flight No</th>
						   <th>Class</th>
					   </tr>';
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM itinerary_has_items WHERE itinerary_no='$itinerary_no' AND id='$row[fare_id]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			$count = $row [adult] + $row [infant] + $row [child];
			echo '<tr >
				<td>' . $count . '</td>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row1 ['dep_time'] . '</td>
				<td>' . $row ['flight_no'] . '</td>
				<td>' . $row1 ['class'] . '</td>
			</tr>';
			if ($row [way] == "Return") {
				echo '<tr><tr>
				<td></td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row1 ['rtn_dep_time'] . '</td>
				<td>' . $row ['rtn_flight_no'] . '</td>
				<td>' . $row1 ['class'] . '</td>
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
	$query = "UPDATE itinerary_has_passengers SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	

}
function update_fare_id($itinerary_no, $id) {
	$total = get_total ( $itinerary_no, $id );
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE itinerary SET
	fare_id='$id',
	total='$total'
	WHERE itinerary_no='$itinerary_no'";
	mysqli_query ($conn, $query );
	

}
function update_time_limit($itinerary_no, $time_limit) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE itinerary SET
	issue_date='$time_limit'
	WHERE itinerary_no='$itinerary_no'";
	mysqli_query ($conn, $query );
	

}
function get_total($itinerary_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM itinerary WHERE itinerary_no='$itinerary_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$result1 = mysqli_query ( $conn, "SELECT * FROM itinerary_has_items WHERE itinerary_no='$itinerary_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
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
	
	$result1 = mysqli_query ( $conn, "SELECT * FROM itinerary_has_items WHERE id='$fare_id' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
		$adult_fare = $adult * $row1 ['adult_fare'];
		$child_fare = $child * $row1 ['child_fare'];
		$infant_fare = $infant * $row1 ['infant_fare'];
		
		$total = $adult_fare + $child_fare + $infant_fare;
		
		return $total;
	}
}
function get_passenger_count($itinerary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM itinerary_has_passengers WHERE itinerary_no='$itinerary_no' AND cancel_status='0'" );
	$num_rows = mysqli_num_rows ( $result );
	
	return $num_rows;
	

}
function complete_itinerary($itinerary_no, $amount, $off, $total, $first_time) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE itinerary SET
	status='1',
	amount='$amount',
	off='$off',
	total='$total',
	first_time='$first_time'
	WHERE itinerary_no='$itinerary_no'";
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
function check_repetive_passport_no($itinerary_no, $passport_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ( "SELECT id FROM itinerary_has_passengers WHERE itinerary_no='$itinerary_no' AND passport_no='$passport_no' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}

}
function check_passengers($itinerary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ( "SELECT id FROM itinerary_has_passengers WHERE itinerary_no='$itinerary_no' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}
	

}
function list_non_confirm($itinerary_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($itinerary_no) {
		$itinerary_no_check = "AND itinerary_no LIKE '%$itinerary_no%'";
	} else {
		$itinerary_no_check = "";
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
						   <th>itinerary No</th>
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
	
	$result = mysqli_query ($conn, "SELECT * FROM itinerary WHERE status='0' AND cancel_status='0' AND itinerary_type='TICKET' $itinerary_no_check $customer_check $date_check ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$time1 = strtotime ( date ( "y-m-d H:i:s" ) );
		$time2 = strtotime ( $row ['saved'] );
		
		$diff = $time1 - $time2;
		if ($diff > "259200") {
			echo '<tr>
				<td><a href="itinerary.php?job=from_non_confim&itinerary_no=' . $row ['itinerary_no'] . '" class="btn btn-danger">' . $row ['itinerary_no'] . '</a></td>
				<td>' . $row ['way'] . '</td>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row ['dep_date'] . '</td>
				<td>' . $row ['rtn_date'] . '</td>
				<td>' . $row ['name'] . '</td>';
			
			$result1 = mysqli_query ($conn,  "SELECT * FROM customer WHERE customer_id='$row[customer_id]' AND cancel_status='0' ORDER BY id ASC" );
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
				<td><a href="itinerary.php?job=from_non_confim&itinerary_no=' . $row ['itinerary_no'] . '" class="btn btn-danger">' . $row ['itinerary_no'] . '</a></td>
				<td>' . $row ['way'] . '</td>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row ['dep_date'] . '</td>
				<td>' . $row ['rtn_date'] . '</td>
				<td>' . $row ['name'] . '</td>';
				
				$result1 = mysqli_query ($conn,  "SELECT * FROM customer WHERE customer_id='$row[customer_id]' AND cancel_status='0' ORDER BY id ASC" );
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