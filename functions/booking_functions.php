<?php
function list_air_lines() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM air_lines WHERE cancel_status='0' ORDER BY air_line ASC" );
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
	
	$result = mysqli_query ( $conn , "SELECT * FROM air_ports WHERE cancel_status='0' ORDER BY air_port ASC");
	$i = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$air_port_names [$i] = $row ['air_port'];
		$i ++;
	}
	return $air_port_names;
	
	
}
function save_booking_item ( $booking_no, $serial_no, $booking_type, $air_line_code, $class, $type, $fare, $tax, $markup, $passenger_type, $total, $dep_time, $arr_time, $rtn_dep_time, $rtn_arr_time, $offer_code, $user_name ) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ( $conn, $dbname );
	$query = "INSERT INTO booking_has_items (id, booking_no, serial_no, booking_type, air_line_code, class, type, fare, tax, markup, passenger_type, total, dep_time, arr_time, rtn_dep_time, rtn_arr_time, offer_code, branch, saved_by)
	VALUES ('', '$booking_no', '$serial_no', '$booking_type', '$air_line_code', '$class', '$type', '$fare', '$tax', '$markup','$passenger_type', '$total', '$dep_time', '$arr_time', '$rtn_dep_time', '$rtn_arr_time', '$offer_code', '$_SESSION[branch]', '$user_name')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function save_date_change_item($date_change_no, $serial_no, $booking_type, $air_line_code, $class, $type, $penalty, $mark_up, $total, $dep_time, $arr_time, $rtn_dep_time, $rtn_arr_time, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO booking_has_items (id, booking_no, serial_no, booking_type, air_line_code, class, type, adult_fare, adult_markup, adult_total, dep_time, arr_time, rtn_dep_time, rtn_arr_time, branch, saved_by)
	VALUES ('', '$date_change_no', '$serial_no', '$booking_type', '$air_line_code', '$class', '$type', '$penalty', '$mark_up', '$total', '$dep_time', '$arr_time', '$rtn_dep_time', '$rtn_arr_time', '$_SESSION[branch]', '$user_name')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function save_booking($booking_no, $booking_type, $name, $customer_id, $mobile, $phone, $email, $way, $dep_air_port, $arr_air_port, $dep_date, $rtn_date, $adult, $child, $infant, $currency, $address, $note, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO booking(id, booking_no, booking_type, name, customer_id, mobile, phone, email, way, dep_air_port, arr_air_port, dep_date, rtn_date, adult, child, infant, currency, address, note, saved_by, branch, saved)
	VALUES ('', '$booking_no', '$booking_type', '$name', '$customer_id', '$mobile', '$phone', '$email', '$way', '$dep_air_port', '$arr_air_port', '$dep_date', '$rtn_date', '$adult', '$child', '$infant', '$currency', '$address', '$note', '$user_name', '$branch', '$time')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function create_date_change($date_change_no, $booking_type, $booking_no, $customer, $customer_id, $mobile, $phone, $email, $way, $dep_air_port, $arr_air_port, $dep_date, $rtn_date, $pax_count, $address, $note, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO booking(id, booking_no, booking_type, ref_no, name, customer_id, mobile, phone, email, way, dep_air_port, arr_air_port, dep_date, rtn_date, adult, address, note, saved_by, branch, saved)
	VALUES ('', '$date_change_no', '$booking_type', '$booking_no', '$customer', '$customer_id', '$mobile', '$phone', '$email', '$way', '$dep_air_port', '$arr_air_port', '$dep_date', '$rtn_date', '$pax_count', '$address', '$note', '$user_name', '$branch', '$time')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function update_booking($booking_no, $name, $customer_id, $mobile, $phone, $email, $way, $dep_air_port, $arr_air_port, $dep_date, $rtn_date, $adult, $child, $infant, $currency, $address, $note, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE booking SET
	name='$name',
	customer_id='$customer_id',
	mobile='$mobile',
	phone='$phone',
	email='$email',
	way='$way',
	dep_air_port='$dep_air_port',
	arr_air_port='$arr_air_port',
	dep_date='$dep_date',
	rtn_date='$rtn_date',
	adult='$adult',
	child='$child',
	infant='$infant',
	currency='$currency',
	address='$address',
	note='$note',
	saved='$time'
	WHERE booking_no='$booking_no'";
	mysqli_query ($conn, $query );
	
	
}
function update_date_change($date_change_no, $booking_no, $customer, $customer_id, $mobile, $phone, $email, $way, $dep_air_port, $arr_air_port, $dep_date, $rtn_date, $pax_count, $address, $note, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE booking SET
	ref_no='$booking_no',
	name='$customer',
	customer_id='$customer_id',
	mobile='$mobile',
	phone='$phone',
	email='$email',
	way='$way',
	dep_air_port='$dep_air_port',
	arr_air_port='$arr_air_port',
	dep_date='$dep_date',
	rtn_date='$rtn_date',
	adult='$pax_count',
	address='$address',
	note='$note'
	WHERE booking_no='$date_change_no'";
	mysqli_query ($conn, $query );
	
	
}
function get_booking_info_by_booking_no($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query (  $conn, "SELECT * FROM booking WHERE booking_no='$booking_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function get_fare_detail($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM booking_has_items WHERE id='$id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function get_booking_type($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn , "SELECT * FROM booking_has_items WHERE booking_no='$booking_no'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}

}
function get_booking_no($type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn , "SELECT MAX(serial_no) FROM booking_has_items WHERE booking_type='$type'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	
	
}
function get_serial_no($type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(serial_no) FROM booking_has_items WHERE booking_type='$type'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	

}
function list_booking_has_items($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 14px;">
                       <tr>
						   <th rowspan="2" class="warning"></th>
                           <th rowspan="2" colspan="3" style="text-align: center;" class="warning">Air Line</th>
						   <th colspan="4" style="text-align: center;" class="success">Flight Time</th>
						   <th rowspan="2" style="text-align: center;" class="danger">Passenger Type</th>
                           <th rowspan="2" style="text-align: center;" class="danger">Fare</th>
                           </tr>
					   <tr>
                           <th class="success">Dep</th>
                           <th class="success">Arr</th>
                           <th class="success">Rtn Dep</th>
						   <th class="success">Rtn Arr</th>
                       </tr>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM booking_has_items WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
				<td><a href="booking.php?job=passenger_detail&id='.$row [id].'&booking_no='.$booking_no.'"  ><i class="fa fa-check-square-o fa-2x"></i></a></td>
				<td>' . $row ['air_line_code'] . '</td>
				<td>' . $row ['class'] . '</td>
				<td>' . $row ['type'] . '</td>
				<td>' . $row ['dep_time'] . '</td>
				<td>' . $row ['arr_time'] . '</td>
				<td>' . $row ['rtn_dep_time'] . '</td>
				<td>' . $row ['rtn_arr_time'] . '</td>
				<td>' . $row ['passenger_type'] . '</td>
				<td style="text-align: right;">' . $row ['fare'] . '<br />' . $row ['tax'] . ' <br />' . $row ['markup'] . '<br/ ><strong><font color="red">' . $row ['total'] . '</font></strong></td>
            </tr>';
	}
	echo '
              	</table>
            </div>';
	

}
function list_date_change_has_items($date_change_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 14px;">
                       <tr>
						   <th rowspan="2" class="warning"></th>
                           <th rowspan="2" colspan="3" style="text-align: center;" class="warning">Air Line</th>
						   <th colspan="4" style="text-align: center;" class="success">Flight Time</th>
                           <th rowspan="2" style="text-align: center;" class="danger">Penalty</th>
                           <th rowspan="2" style="text-align: center;" class="info">Mark Up</th>
                           <th rowspan="2" style="text-align: center;" class="success">Total</th>
                       </tr>
					   <tr>
                           <th class="success">Dep</th>
                           <th class="success">Arr</th>
                           <th class="success">Rtn Dep</th>
						   <th class="success">Rtn Arr</th>
                       </tr>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM booking_has_items WHERE booking_no='$date_change_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
				<td><a href="date_change.php?job=passenger_detail&id=' . $row [id] . '&date_change_no=' . $date_change_no . '"  ><i class="fa fa-check-square-o fa-2x"></i></a></td>
				<td>' . $row ['air_line_code'] . '</td>
				<td>' . $row ['class'] . '</td>
				<td>' . $row ['type'] . '</td>
				<td>' . $row ['dep_time'] . '</td>
				<td>' . $row ['arr_time'] . '</td>
				<td>' . $row ['rtn_dep_time'] . '</td>
				<td>' . $row ['rtn_arr_time'] . '</td>
				<td>' . $row ['adult_fare'] . '</td>
				<td>' . $row ['adult_markup'] . '</td>
				<td>' . $row ['adult_total'] . '</td>
			</tr>';
	}
	echo '
              	</table>
            </div>';
	

}
function display_booking_detail($booking_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM booking WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id ASC" );
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
		
		$result1 = mysqli_query ($conn, "SELECT * FROM booking_has_items WHERE booking_no='$booking_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
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
function display_booking_detail_just_view($booking_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM booking WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="table-responsive">
              <table class="table" style="font-size: 12px;">
                  <tr class="danger">
						   <th>Booking No</th>
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
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM booking_has_items WHERE booking_no='$booking_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			
			echo '<tr>
				<td rowspan="3">' . $booking_no . '</td>
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
function display_booking_cost($booking_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM booking WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id ASC" );
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
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM booking_has_items WHERE booking_no='$booking_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
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
function add_passenger_to_booking($booking_no, $passport_no, $visa_copy) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO booking_has_passengers (id, booking_no, passport_no, visa_copy, saved_by)
	VALUES ('', '$booking_no', '$passport_no', '$visa_copy', '$_SESSION[user_name]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function add_visa($booking_no, $passport_no, $visa_copy) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE booking_has_passengers SET
	visa_copy='$visa_copy'
	WHERE booking_no='$booking_no' AND passport_no='$passport_no'";
	mysqli_query ($conn, $query );
	
	
}
function add_ticket_number($booking_no, $passport_no, $ticket_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE booking_has_passengers SET
	ticket_no='$ticket_no'
	WHERE booking_no='$booking_no' AND passport_no='$passport_no'";
	mysqli_query ($conn, $query );
	

}
function transfer_booking_to($to_user, $booking_no, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE booking SET
	completed_by='$to_user',
	branch='$branch',
	transfered_by='$_SESSION[user_name]'
	WHERE booking_no='$booking_no'";
	mysqli_query ($conn, $query );

}
function list_passengers_details($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
                 
                       <tr>
						   <th>Delete</th>
						   <th>Full Name</th>
                           <th>First Name</th>
						   <th>Last Name</th>
                           <th>Passport No</th>
						   <th>View Visa Copy</th>
                       </tr>
				   ';
	$result = mysqli_query ( $conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td><a href="booking.php?job=delete_passenger&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this user?\')"><i class="fa fa-times fa-2x"></i></a></td>
				<td>' . $row1 ['customer_name'] . '</td>
				<td>' . $row1 ['first_name'] . '</td>
				<td>' . $row1 ['last_name'] . '</td>
				<td>' . $row ['passport_no'] . '</td>
				<td><a href="#" class="btn btn-default" data-toggle="modal" data-target="#' . $row [id] . '">View</a></td>		
			</tr>
						
			<div class="modal fade" id="' . $row [id] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [id] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			      </div>
			      <div class="modal-body">
			        <img src="' . $row [visa_copy] . '" style="width: 100%;"/>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>';
		}
	}
	echo '		
              	</table>
            </div>
			
			';
	
	
}
function list_passengers_details_ticket($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
         
                       <tr>
						   <th>Full Name</th>
                           <th>First Name</th>
						   <th>Last Name</th>
                           <th>Passport No</th>
						   <th>Ticket Number</th>
						   <th>Add</th>
                       </tr>
				   ';
	$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td>' . $row1 ['customer_name'] . '</td>
				<td>' . $row1 ['first_name'] . '</td>
				<td>' . $row1 ['last_name'] . '</td>
				<td>' . $row ['passport_no'] . '</td>
				<td><form name="add_product" action="ticket_number.php?job=add_ticket_no&booking_no=' . $booking_no . '&passport_no=' . $row [passport_no] . '" method="post">
		
				 <div class="form-group">
					<input class="form-control" type="text" name="ticket_no" value="' . $row ['ticket_no'] . '" required="required" placeholder="Ticket No"/>
                 </div>
				 </td>
				 <td>
		         <div class="form-group">
					<button type="submit" name="ok" value="Save" class="btn btn-success">Save</button>
				</div></form></td>
									
			</tr>';
		}
	}
	echo '
              	</table>
            </div>
		
			';
	
	
}
function list_passengers_details_for_date_change($date_change_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
         
                       <tr>
						   <th>Delete</th>
						   <th>Full Name</th>
                           <th>First Name</th>
						   <th>Last Name</th>
                           <th>Passport No</th>
                       </tr>
				   ';
	$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$date_change_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td><a href="date_change.php?job=delete_passenger&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this user?\')"><i class="fa fa-times fa-2x"></i></a></td>
				<td>' . $row1 ['customer_name'] . '</td>
				<td>' . $row1 ['first_name'] . '</td>
				<td>' . $row1 ['last_name'] . '</td>
				<td>' . $row ['passport_no'] . '</td>
			</tr>';
		}
	}
	echo '
              	</table>
            </div>
		
			';
	

}
function list_passengers_details_just_view($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
                 
                       <tr class="info">
						   <th>Full Name</th>
                           <th>First Name</th>
						   <th>Last Name</th>
                           <th>Passport No</th>
						   <th>View Visa Copy</th>
                       </tr>
				  ';
	$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td>' . $row1 ['customer_name'] . '</td>
				<td>' . $row1 ['first_name'] . '</td>
				<td>' . $row1 ['last_name'] . '</td>
				<td>' . $row ['passport_no'] . '</td>';
			if ($row [visa_copy]) {
				echo '<td><a href="#" class="btn btn-danger" data-toggle="modal" data-target="#' . $row [id] . '">View</a></td>';
			} else {
				echo '<td><form name="add_product" action="booking.php?job=add_visa&booking_no=' . $booking_no . '&passport_no=' . $row [passport_no] . '" method="post" enctype="multipart/form-data">
						 <div class="form-group">
							<input class="form-control" type="file" name="visa_copy" id="visa_copy" value="{$visa_copy}" required="required" placeholder="Visa Copy"/>
		                 </div>
						<div class="form-group">
									<button type="submit" name="ok" value="Save" class="btn btn-success">Add</button>
								</div></form></td>';
			}
			echo '
			</tr>

			<div class="modal fade" id="' . $row [id] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [id] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			      </div>
			      <div class="modal-body">
			        <img src="' . $row [visa_copy] . '" style="width: 100%;"/>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>';
		}
	}
	echo '
              	</table>
            </div>
		
			';
	

}
function get_booking_passengers_for_voucher($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
				<tr><th colspan="3" align="center" class="info">Passengers</th></tr>';
	$i = 1;
	$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND cancel_status='0' AND issue_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td><div class="form-group"><input type="checkbox" name="' . $i . '" value="checked"></input><div></td>
				<td>' . $row1 ['salute'] . '</td>
				<td>' . $row1 ['first_name'] . '/' . $row1 ['last_name'] . '</td>
			</tr>';
		}
		$i ++;
	}
	echo '			</tbody>
              	</table>
            </div>

			';
	

}
function get_passenger_id($i, $booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	$x = $i - 1;
	
	$result = mysqli_query ($conn, "SELECT id FROM booking_has_passengers WHERE booking_no='$booking_no' ORDER BY id ASC LIMIT $x,1" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['id'];
	}
	

}
function get_booking_passengers_for_voucher_view($booking_no, $voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
				<tr><th colspan="2" align="center" class="info">Passengers</th></tr>';
	$i = 1;
	$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND voucher_no='$voucher_no' AND cancel_status='0' AND issue_status='1' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td>' . $row1 ['salute'] . '</td>
				<td>' . $row1 ['first_name'] . '/' . $row1 ['last_name'] . '</td>
			</tr>';
		}
		$i ++;
	}
	echo '			</tbody>
              	</table>
            </div>

			';
	

}
function get_booking_details_for_voucher($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM booking WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id ASC" );
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
		
		$result1 = mysqli_query ($conn, "SELECT * FROM booking_has_items WHERE booking_no='$booking_no' AND id='$row[fare_id]' AND cancel_status='0' ORDER BY id ASC" );
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
	$query = "UPDATE booking_has_passengers SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	

}
function update_fare_id($booking_no, $id) {
	$total = get_total ( $booking_no, $id );
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE booking SET
	fare_id='$id',
	total='$total'
	WHERE booking_no='$booking_no'";
	mysqli_query ($conn, $query );
	

}
function update_time_limit($booking_no, $time_limit, $pnr) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE booking SET
	pnr='$pnr',
	issue_date='$time_limit'	
	WHERE booking_no='$booking_no'";
	mysqli_query ($conn, $query );
	

}
function get_total($booking_no, $id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM booking WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$result1 = mysqli_query ($conn, "SELECT * FROM booking_has_items WHERE booking_no='$booking_no' AND id='$id' AND cancel_status='0' ORDER BY id ASC" );
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
	
	$result1 = mysqli_query ($conn, "SELECT * FROM booking_has_items WHERE id='$fare_id' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
		$adult_fare = $adult * $row1 ['adult_fare'];
		$child_fare = $child * $row1 ['child_fare'];
		$infant_fare = $infant * $row1 ['infant_fare'];
		
		$total = $adult_fare + $child_fare + $infant_fare;
		
		return $total;
	}
}
function get_passenger_count($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND cancel_status='0'" );
	$num_rows = mysqli_num_rows ( $result );
	
	return $num_rows;
	

}
function get_passenger_visa_copy_count($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND visa_copy LIKE 'visa_copy%' AND cancel_status='0'" );
	$num_rows = mysqli_num_rows ( $result );
	
	return $num_rows;
	

}
function get_passport_copy_count($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	$i = 0;
	$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND visa_copy LIKE 'visa_copy%' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if (mysqli_num_rows ( mysqli_query ( "SELECT id FROM customer WHERE passport_no='$row[passport_no]' AND passport LIKE 'passports%' AND cancel_status='0'" ) )) {
			$i ++;
		} else {
		}
	}
	
	return $i;
	

}
function complete_booking($booking_no, $pnr, $al_ref, $issue_date, $transits, $flight_no, $rtn_flight_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE booking SET
	status='1',
	pnr='$pnr',
	al_ref='$al_ref',
	issue_date='$issue_date',
	transits='$transits',
	flight_no='$flight_no',
	rtn_flight_no='$rtn_flight_no',
	completed_by='$_SESSION[user_name]',
	branch='$_SESSION[branch]'
	WHERE booking_no='$booking_no'";
	mysqli_query ($conn, $query );
	

}


function check_customer($customer) {
    include 'conf/config.php';
    include 'conf/opendb.php';
    
    if (mysqli_num_rows ( mysqli_query ($conn, "SELECT id FROM customer WHERE customer_name = '$customer' AND cancel_status='0'" ) )) {
        return 1;
    }
    else {
        return 0;
    }
}

function check_repetive_passport_no($booking_no, $passport_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ( "SELECT id FROM booking_has_passengers WHERE booking_no='$booking_no' AND passport_no='$passport_no' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}
	

}
function check_passengers($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ( "SELECT id FROM booking_has_passengers WHERE booking_no='$booking_no' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}
	

}
function list_non_confirm($booking_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($booking_no) {
		$booking_no_check = "AND booking_no LIKE '%$booking_no%'";
	} else {
		$booking_no_check = "";
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
						   <th>Booking No</th>
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
	
	$result = mysqli_query ( $conn, "SELECT * FROM booking WHERE status='0' AND cancel_status='0' AND booking_type='TICKET' $booking_no_check $customer_check $date_check ORDER BY id DESC LIMIT 50" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$time1 = strtotime ( date ( "y-m-d H:i:s" ) );
		$time2 = strtotime ( $row ['saved'] );
		
		$diff = $time1 - $time2;
		if ($diff > "259200") {
			echo '<tr>
				<td><a href="booking.php?job=from_non_confim&booking_no=' . $row ['booking_no'] . '" class="btn btn-danger">' . $row ['booking_no'] . '</a></td>
				<td>' . $row ['way'] . '</td>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row ['dep_date'] . '</td>
				<td>' . $row ['rtn_date'] . '</td>
				<td>' . $row ['name'] . '</td>';
			
			$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE customer_id='$row[customer_id]' AND cancel_status='0' ORDER BY id ASC" );
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
				<td><a href="booking.php?job=from_non_confim&booking_no=' . $row ['booking_no'] . '" class="btn btn-danger">' . $row ['booking_no'] . '</a></td>
				<td>' . $row ['way'] . '</td>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row ['dep_date'] . '</td>
				<td>' . $row ['rtn_date'] . '</td>
				<td>' . $row ['name'] . '</td>';
				
				$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE customer_id='$row[customer_id]' AND cancel_status='0' ORDER BY id ASC" );
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
function list_all_non_confirm($branch, $user, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($branch) {
		$branch_check = "AND branch LIKE '%$branch%'";
	} else {
		$branch_check = "";
	}
	
	if ($user) {
		$user_check = "AND saved_by LIKE '$user'";
	} else {
		$user_check = "";
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
						   <th>Booking No</th>
                           <th>Way</th>
						   <th>From</th>
                           <th>To</th>
						   <th>Dep Date</th>
						   <th>Arr Date</th>
                           <th>Customer</th>
                           <th>Created By</th>
						   <th>Created</th>
                       </tr>
				   </thead>
                <tbody>';
	$result = mysqli_query ( $conn, "SELECT * FROM booking WHERE status='0' AND cancel_status='0' AND booking_type='TICKET' $branch_check $user_check $date_check ORDER BY id DESC LIMIT 50" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
				<td><a href="booking.php?job=from_non_confim&booking_no=' . $row ['booking_no'] . '" class="btn btn-danger">' . $row ['booking_no'] . '</a></td>
				<td>' . $row ['way'] . '</td>
				<td>' . $row ['dep_air_port'] . '</td>
				<td>' . $row ['arr_air_port'] . '</td>
				<td>' . $row ['dep_date'] . '</td>
				<td>' . $row ['rtn_date'] . '</td>
				<td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row ['name'] . '</a></div></td>
				<td>' . $row ['saved_by'] . '</td>
				<td>' . $row ['saved'] . '</td>
			</tr>';
	}
	echo '			</tbody>
              	</table>
            </div>

			';
	

}
function list_your_booking($booking_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($booking_no) {
		$booking_no_check = "AND booking_no LIKE '%$booking_no%'";
	} else {
		$booking_no_check = "";
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
	
	echo '<div class="table-responsive" style="min-height: 400px;">
              <table class="table" style="font-size: 13px;">
                  <thead>
                       <tr class="info">
						   <th>Booking No</th>
                           <th>Way</th>
						   <th>From</th>
                           <th>To</th>
						   <th>Dep Date</th>
						   <th>Arr Date</th>
                           <th>Customer</th>
						   <th>Completed</th>						   
                           <th>Transfer</th>
						   <th></th>
                       </tr>
				   </thead>
                <tbody>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM booking WHERE completed_by='$_SESSION[user_name]' AND status='1' AND cancel_status='0' $booking_no_check $customer_check $date_check ORDER BY id DESC LIMIT 50" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '<tr>
			<td><a href="booking.php?job=view&booking_no=' . $row ['booking_no'] . '" class="btn btn-danger">' . $row ['booking_no'] . '</a></td>
			<td>' . $row ['way'] . '</td>
			<td>' . $row ['dep_air_port'] . '</td>
			<td>' . $row ['arr_air_port'] . '</td>
			<td>' . $row ['dep_date'] . '</td>
			<td>' . $row ['rtn_date'] . '</td>
			<td>' . $row ['name'] . '</td>
			<td>' . $row ['saved'] . '</td>
			<td>
				<form name="add_product" action="booking_transfer.php?job=transfer_booking&booking_no=' . $row [booking_no] . '" method="post">
					<div class="form-group">
						<input class="form-control to_user" type="text" name="to_user" required="required" placeholder="Transfer To"/>
                	</div>
				</td>
				<td>
		         	<div class="form-group">
						<button type="submit" name="ok" value="Save" class="btn btn-success">Transfer</button>
					</div>
				</form>
			</td>
		</tr>';
	}
	echo '			</tbody>
              	</table>
            </div>';
	

}
function list_booking($booking_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($booking_no) {
		$booking_no_check = "AND booking_no LIKE '%$booking_no%'";
	} else {
		$booking_no_check = "";
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
              <table class="table" style="font-size: 12px;">
                  <thead>
                       <tr class="info">
						   <th>B.No</th>
                           <th>Customer</th>
						   <th>Invoice</th>
						   <th>Others</th>
						   <th>Receipt</th>						   
						   <th>Exchange Order</th>
						   <th>Others</th>
						   <th>Paybill</th>
                           <th>B.Profit</th>
						   <th>A.Profit</th>
                           <th>Created By</th>
						   <th>Created</th>
                       </tr>
				   </thead>
                <tbody>';
	
	$ref_type = 'Booking';
	
	$result = mysqli_query ($conn, "SELECT * FROM booking WHERE status>='1' AND cancel_status='0' AND booking_type='TICKET' $booking_no_check $customer_check $date_check ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$invoice_amount = get_booking_invoice_amount ( $row['booking_no'], $ref_type );
		$other_income_amount = get_booking_other_income_amount ($row['booking_no'], $ref_type );
		$receipt_amount = get_booking_receipt_amount ( $row [booking_no] );
		$voucher_amount = get_booking_voucher_amount ( $row [booking_no] );
		$other_expense_amount = get_booking_other_expense_amount ( $row['booking_no'], $ref_type);
		$paybill_amount = get_booking_paybill_amount ( $row [booking_no] );
		$paybill_amount_other = get_booking_paybill_amount_other ( $row [booking_no] );
		
		$job_profit = ($_SESSION ['invoice_total'] + $_SESSION ['other_income_total']) - ($_SESSION ['voucher_total'] + $_SESSION ['other_expense_total']);
		$actual_profit = $_SESSION ['receipt_total'] - ($_SESSION ['paybill_total'] + $_SESSION ['paybill_total_other']);
		
		echo '<tr>
			<td><a href="booking.php?job=view&booking_no=' . $row ['booking_no'] . '" class="btn btn-danger" target="_blank">' . $row ['booking_no'] . '</a></td>
			
		
		<td>
		' . $row [name] . '
		</td>
		
		
		<td id="amount_td" class="light_green">
		' . $invoice_amount . '
		</td>
				
		<td id="amount_td" class="dark_green">
		' . $other_income_amount . '
		</td>

		<td id="amount_td" class="dark_green">
		' . $receipt_amount . '
		</td>
		
		<td id="amount_td" class="light_pink">
		' . $voucher_amount . '
		</td>
				
		<td id="amount_td" class="dark_green">
		' . $other_expense_amount . '
		</td>
		

		
		<td id="amount_td" class="dark_pink">
		' . $paybill_amount . '<br />' . $paybill_amount_other . '
		</td>
		
		<td id="amount_td">
		' . $job_profit . '
		</td>
		
		<td id="amount_td">
		' . $actual_profit . '
		</td>
			<td>' . $row ['completed_by'] . '</td>
			<td>' . $row ['saved'] . '</td>
		</tr>';
	}
	echo '			</tbody>
              	</table>
            </div>
	
			';
	

}


function list_datechange($booking_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	if ($booking_no) {
		$booking_no_check = "AND booking_no LIKE '%$booking_no%'";
	} else {
		$booking_no_check = "";
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
              <table class="table" style="font-size: 12px;">
                  <thead>
                       <tr class="info">
						   <th>B.No</th>
                           <th>Customer</th>
						   <th>Invoice</th>
						   <th>Others</th>
						   <th>Receipt</th>
						   <th>Exchange Order</th>
						   <th>Others</th>
						   <th>Paybill</th>
                           <th>B.Profit</th>
						   <th>A.Profit</th>
                           <th>Created By</th>
						   <th>Created</th>
                       </tr>
				   </thead>
                <tbody>';

	$ref_type = 'BOOKING';
	
	$result = mysqli_query ($conn, "SELECT * FROM booking WHERE status>='1' AND cancel_status='0' AND booking_type='DATE CHANGE' $booking_no_check $customer_check $date_check ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$invoice_amount = get_invoice_amount ($row['booking_no'], $ref_type );
		$other_income_amount = get_booking_other_income_amount ( $row['booking_no'], $ref_type );
		$receipt_amount = get_booking_receipt_amount ( $row [booking_no] );
		$voucher_amount = get_booking_voucher_amount ( $row [booking_no] );
		$other_expense_amount = get_booking_other_expense_amount ( $row['booking_no'], $ref_type );
		$paybill_amount = get_booking_paybill_amount ( $row [booking_no] );
		$paybill_amount_other = get_booking_paybill_amount_other ( $row [booking_no] );

		$job_profit = ($_SESSION ['invoice_total'] + $_SESSION ['other_income_total']) - ($_SESSION ['voucher_total'] + $_SESSION ['other_expense_total']);
		$actual_profit = $_SESSION ['receipt_total'] - ($_SESSION ['paybill_total'] + $_SESSION ['paybill_total_other']);

		echo '<tr>
			<td><a href="booking.php?job=view&booking_no=' . $row ['booking_no'] . '" class="btn btn-danger" target="_blank">' . $row ['booking_no'] . '</a></td>
		

		<td>
		' . $row [name] . '
		</td>


		<td id="amount_td" class="light_green">
		' . $invoice_amount . '
		</td>

		<td id="amount_td" class="dark_green">
		' . $other_income_amount . '
		</td>

		<td id="amount_td" class="dark_green">
		' . $receipt_amount . '
		</td>

		<td id="amount_td" class="light_pink">
		' . $voucher_amount . '
		</td>

		<td id="amount_td" class="dark_green">
		' . $other_expense_amount . '
		</td>



		<td id="amount_td" class="dark_pink">
		' . $paybill_amount . '<br />' . $paybill_amount_other . '
		</td>

		<td id="amount_td">
		' . $job_profit . '
		</td>

		<td id="amount_td">
		' . $actual_profit . '
		</td>
			<td>' . $row ['completed_by'] . '</td>
			<td>' . $row ['saved'] . '</td>
		</tr>';
	}
	echo '			</tbody>
              	</table>
            </div>

			';


}



function get_booking_invoice_amount($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT invoice_no, total, customer FROM invoice WHERE ref_no='$booking_no' AND type='TICKET' AND cancel_status='0' " );
	$invoice_nos = '';
	$_SESSION ['invoice_total'] = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$_SESSION ['invoice_total'] = $row ['SUM(total)'];
		if ($invoice_nos == '') {
			$invoice_nos = '<a href="invoice.php?job=print&invoice_no=' . $row [invoice_no] . '" target="blank">' . number_format ( $row [total], 2 ) . '</a>';
		} else {
			$invoice_nos = $invoice_nos . '<br /><br />' . '<a href="invoice.php?job=print&invoice_no=' . $row [invoice_no] . '" target="blank">' . number_format ( $row [total], 2 ) . '</a>';
		}
		$_SESSION ['invoice_total'] = $_SESSION ['invoice_total'] + $row ['total'];
	}
	
	return $invoice_nos;
}

function get_invoice_amount($ref_no, $ref_type) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	
	$result = mysqli_query ($conn, "SELECT invoice_no, total, customer FROM invoice WHERE ref_no='$ref_no' AND type='$ref_type' AND cancel_status='0' " );
	
	$invoice_nos = '';
	$_SESSION ['invoice_total'] = 0;
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$_SESSION ['invoice_total'] = $row ['SUM(total)'];
		if ($invoice_nos == '') {
			$invoice_nos = '<a href="invoice.php?job=print&invoice_no=' . $row [invoice_no] . '" target="blank">' . number_format ( $row [total], 2 ) . '</a>';
		} else {
			$invoice_nos = $invoice_nos . '<br /><br />' . '<a href="invoice.php?job=print&invoice_no=' . $row [invoice_no] . '" target="blank">' . number_format ( $row [total], 2 ) . '</a>';
		}
		$_SESSION ['invoice_total'] = $_SESSION ['invoice_total'] + $row ['total'];
	}

	return $invoice_nos;
}


function get_booking_other_income_amount($ref_no, $ref_type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT invoice_no, total FROM invoice WHERE ref_no='$ref_no' AND ref_type='$ref_type' AND type='OTHER' AND cancel_status='0' " );
	$other_income_nos = '';
	$_SESSION ['other_income_total'] = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		if ($other_income_nos == '') {
			$other_income_nos = '<a href="invoice.php?job=print&invoice_no=' . $row [invoice_no] . '" target="blank">' . number_format ( $row [total], 2 ) . '</a>';
		} else {
			$other_income_nos = $other_income_nos . '<br /><br />' . '<a href="invoice.php?job=print&invoice_no=' . $row [invoice_no] . '" target="blank">' . number_format ( $row [total], 2 ) . '</a>';
		}
		$_SESSION ['other_income_total'] = $_SESSION ['other_income_total'] + $row ['total'];
	}
	
	return $other_income_nos;
}
function get_booking_receipt_amount($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT receipt_has_invoice.rec_no, receipt_has_invoice.amount, receipt_has_invoice.invoice_no, invoice.invoice_no  FROM receipt_has_invoice, invoice WHERE receipt_has_invoice.invoice_no=invoice.invoice_no AND invoice.ref_no='$booking_no' " );
	$amount = '';
	$_SESSION ['receipt_total'] = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($amount == '') {
			$chq = get_receipt_chq_no ( $row ['rec_no'] );
			
			$amount = '<a href="receipt.php?job=view_receipt&rec_no=' . $row [rec_no] . '" target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		} else {
			$chq = get_receipt_chq_no ( $row ['rec_no'] );
			$amount = $amount . '<br /><br /><a href="receipt.php?job=view_receipt&rec_no=' . $row [rec_no] . '" target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		}
		
		$_SESSION ['receipt_total'] = $_SESSION ['receipt_total'] + $row [amount];
	}
	
	return $amount;
}
function get_receipt_chq_no($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT cheque_no FROM receipt WHERE rec_no='$rec_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['cheque_no'];
	}
}
function get_booking_voucher_amount($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT voucher_no, total, travels FROM voucher WHERE booking_no='$booking_no' AND cancel_status='0'" );
	$voucher_nos = '';
	$_SESSION ['voucher_total'] = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($voucher_nos == '') {
			$voucher_nos = '<a href="voucher.php?job=print&voucher_no=' . $row [voucher_no] . '" target="_blank">' . number_format ( $row [total], 2 ) . '</a>';
		} else {
			$voucher_nos = $voucher_nos . '<br /><br />' . '<a href="voucher.php?job=print&voucher_no=' . $row [voucher_no] . '" target="_blank">' . number_format ( $row [total], 2 ) . '</a>';
		}
		
		$_SESSION ['voucher_total'] = $_SESSION ['voucher_total'] + $row [total];
	}
	
	return $voucher_nos;
}
function get_booking_other_expense_amount($ref_no, $ref_type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT other_expenses_no, total FROM other_expenses WHERE ref_no='$ref_no' AND ref_type='$ref_type' AND cancel_status='0' " );
	$other_expense_nos = '';
	$_SESSION ['other_expense_total'] = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		if ($other_expense_nos == '') {
			$other_expense_nos = '<a href="other_expenses.php?job=print&other_expenses_no=' . $row [other_expenses_no] . '" target="blank">' . number_format ( $row [total], 2 ) . '</a>';
		} else {
			$other_expense_nos = $other_expense_nos . '<br /><br />' . '<a href="other_expenses.php?job=print&other_expenses_no=' . $row [other_expenses_no] . '" target="blank">' . number_format ( $row [total], 2 ) . '</a>';
		}
		$_SESSION ['other_expense_total'] = $_SESSION ['other_expense_total'] + $row ['total'];
	}
	
	return $other_expense_nos;
}
function get_booking_paybill_amount($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT paybill_has_voucher.paybill_no, paybill_has_voucher.amount, voucher.voucher_no, voucher.booking_no, voucher.travels
			FROM paybill_has_voucher, voucher
			WHERE paybill_has_voucher.ref_no=voucher.voucher_no AND paybill_has_voucher.ref_type='VOUCHER' AND voucher.booking_no='$booking_no' " );
	
	$amount = '';
	$_SESSION ['paybill_total'] = 0;
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		
		if ($amount == '') {
			
			$chq = get_paybill_chq_no ( $row ['paybill_no'] );
			
			$amount = '
			<a href="paybill.php?job=print_paybill&paybill_no=' . $row [paybill_no] . '" target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		} 

		else {
			
			$chq = get_paybill_chq_no ( $row ['paybill_no'] );
			$amount = $amount . '<br /><br /><a href="paybill.php?job=print_paybill&paybill_no=' . $row [paybill_no] . '" target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		}
		
		$_SESSION ['paybill_total'] = $_SESSION ['paybill_total'] + $row [amount];
	}
	
	return $amount;
}
function get_booking_paybill_amount_other($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT paybill_has_voucher.paybill_no, paybill_has_voucher.amount, other_expenses.other_expenses_no, other_expenses.ref_no, other_expenses.customer
			FROM paybill_has_voucher, other_expenses
			WHERE paybill_has_voucher.ref_no=other_expenses.other_expenses_no AND paybill_has_voucher.ref_type='OTHER EXPENSES' AND other_expenses.ref_no='$booking_no' " );
	
	$amount = '';
	$_SESSION ['paybill_total_other'] = 0;
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		
		if ($amount == '') {
			
			$chq = get_paybill_chq_no ( $row ['paybill_no'] );
			
			$amount = '
			<a href="paybill.php?job=print_paybill&paybill_no=' . $row [paybill_no] . '" target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		} 

		else {
			
			$chq = get_paybill_chq_no ( $row ['paybill_no'] );
			$amount = $amount . '<br /><br /><a href="paybill.php?job=print_paybill&paybill_no=' . $row [paybill_no] . '"target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		}
		
		$_SESSION ['paybill_total_other'] = $_SESSION ['paybill_total_other'] + $row [amount];
	}
	
	return $amount;
}
function get_paybill_chq_no($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT cheque_no FROM paybill WHERE paybill_no='$paybill_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['cheque_no'];
	}
}