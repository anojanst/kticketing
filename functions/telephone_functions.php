<?php
function add_telephone($customer_name, $telephone_no, $details, $date, $type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO calls (id, customer_id, customer_name, telephone_no, details, date, saved_by, type, reference, ref_no)
	VALUES ('','$customer_id', '$customer_name', '$telephone_no', '$details', '$date', '$_SESSION[user_name]', '$type', '$reference', '$ref_no')";
	mysql_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function search_telephone_no($customer_name, $telephone_no, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($customer_name) {
		$customer_name_check = "AND customer_name LIKE '%$customer_name%'";
	} else {
		$customer_name_check = "";
	}
	
	if ($telephone_no) {
		$telephone_no_check = "AND telephone_no LIKE '%$telephone_no%'";
	} else {
		$telephone_no_check = "";
	}
	if ($to_date && $from_date) {
		$date_check = "AND date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
				<tr class="danger" style="font-weight: bold;">
					<td>customer name</td>
					<td>telephone no</td>
					<td>details</td>
					<td>date</td>
					<td>type</td>
					<td>reference</td>
				<td>ref no</td>
				<td>Update</td>
					<td>Suspend</td>
				
				</tr>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM calls WHERE type NOT LIKE 'Flew' AND cancel_status='0' $customer_name_check $telephone_no_check $date_check ORDER BY id DESC $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '
				<form role="form" action="view_telephone_no.php?job=update&id=' . $row [id] . '" method="post">
	<tr>
		<td>' . $row [customer_name] . '</td>
		<td>' . $row [telephone_no] . '</td>
		<td>' . $row [details] . '</td>
		<td>' . $row [date] . '</td>
				<td><select class="form-control" name="type" required placeholder="Customer" >';
		if ($row [type]) {
			echo '<option value="' . $row [type] . '">' . $row [type] . '</option>';
		} else {
			echo '<option value="" disabled selected> Select Type</option>';
		}
		echo '<option value="Contact">Contact</option>
											<option value="1stCall">1stCall</option>
											<option value="2ndCall">2ndCall</option>
											<option value="SMS">SMS</option>
											<option value="FinalCall">FinalCall</option>
											<option value="Booked">Booked</option>
											<option value="Paid">Paid</option>
											<option value="Issued">Issued</option>
											<option value="Flew">Flew</option>
		                        			<option value="Flew">Arrived</option>
                        		
									
								</select></td>
				
				<td><select class="form-control" name="reference"  placeholder="Reference" >';
		if ($row [reference]) {
			echo '<option value="' . $row [reference] . '">' . $row [reference] . '</option>';
		} else {
			echo '<option value="" disabled selected> Select Type</option>';
		}
		echo '	
									<option value="Booking">Booking</option>
									<option value="VISA">VISA</option>
                        			<option value="Cab">Cab</option>
                        			<option value="Itinerary">Itinerary</option>
									<option value="Insurance">Insurance</option>
									</select></td>';
		
		if ($row [ref_no] > 0) {
			echo '<td><input class="form-control" name="ref_no" value=' . $row [ref_no] . '></td>';
		} else {
			echo '<td><input class="form-control" name="ref_no">';
		}
		
		echo '<td><button type="submit" name="ok" value="update" class="btn btn-primary">Update</button></td>
			
	
		</form>
				<td><a href="view_telephone_no.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-minus-circle"></i></a></td>
		</tr>';
	}
	echo '    	</table>
            </div>';
	
}
function cancel_telephone_no($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE calls SET
	cancel_status='1'
	WHERE id='$id'";
	mysql_query ($conn, $query );
	
	
}
function update_contact_status($id, $type, $reference, $ref_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE calls SET
	type='$type', reference='$reference', ref_no='$ref_no'
	WHERE id='$id'";
	
	mysql_query ($conn, $query );
	
	
}
function get_telephone_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysql_query ( $conn, "SELECT * FROM calls WHERE id='$id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
	
}
function get_telephone_max_id() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysql_query ($conn, "SELECT MAX(id) FROM calls WHERE cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(id)'];
	}
}


	