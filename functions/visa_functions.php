<?php
function delete_visa($visa_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE visa SET
	cancel_status='1'
	WHERE visa_no='$visa_no'";
	mysqli_query ($conn, $query );
}
function get_visa_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(serial_no) FROM visa" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	
	
}
function get_serial_number() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(serial_no) FROM visa" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	
	
}
function save_visa($visa_no, $visa_type, $serial_no, $country, $customer, $customer_id, $mobile, $count, $days, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO visa(id, visa_no, visa_type, serial_no, country, name, customer_id, mobile, count, days, saved_by, branch, saved)
	VALUES ('', '$visa_no', '$visa_type', '$serial_no', '$country', '$customer', '$customer_id', '$mobile', '$count', '$days', '$user_name', '$branch', '$time')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function get_visa_info_by_visa_no($visa_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM visa WHERE visa_no='$visa_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function list_visa($visa_no, $customer) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($visa_no) {
		$visa_no_check = "AND visa_no LIKE '%$visa_no%'";
	} else {
		$visa_no_check = "";
	}
	
	if ($customer) {
		$customer_check = "AND name LIKE '%$customer%'";
	} else {
		$customer_check = "";
	}
	
	$branch = $_SESSION ['branch'];
	
	if ($branch == "Head Office") {
		$branch_check = "";
	} else {
		$branch_check = "AND branch LIKE '%$branch%'";
	}
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr class="danger">
						   <th>Delete</th>
						   <th>Visa No</th>
                           <th>Country</th>
						   <th>Type</th>
						   <th>Staying Days</th>
                           <th>Customer</th>
						   <th>Mobile</th>
						   <th style="text-align: right;">Cost</th>
                           <th style="text-align: right;">Markup</th>
						   <th style="text-align: right;">Total</th>
                       </tr>
				   </thead>
                <tbody>';
	
	$result = mysqli_query ($conn, "SELECT * FROM visa WHERE cancel_status='0' $visa_no_check $customer_check $branch_check ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$cus_info = get_customer_info ( $row [name] );
		echo '<tr>
			<td><a href="visa.php?job=delete&visa_no=' . $row [visa_no] . '"  ><i class="fa fa-close fa-2x"></i></a></td>
			<td>' . $row ['visa_no'] . '</td>
			<td>' . $row ['country'] . '</td>
			<td>' . $row ['visa_type'] . '</td>
			<td>' . $row ['days'] . '</td>
			<td>' . $row ['name'] . '</td>
			<td>' . $cus_info ['mobile'] . '</td>
			<td align="right" class="info">' . $row ['cost'] . '</td>
			<td align="right" class="warning">' . $row ['markup'] . '</td>
			<td align="right"  class="success">' . $row ['total'] . '</td>
		</tr>';
	}
	echo '
              	</table>
            </div>';
	
	
}
function display_visa_detail($visa_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  ';
	
	$result = mysqli_query ($conn, "SELECT * FROM visa WHERE visa_no='$visa_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$cus_info = get_customer_info ( $row [name] );
		echo '<tr>
				<th colspan="5" class="info">Visa Detail</th>
                <th colspan="2" class="danger" style="">Passenger Detail</th>
             </tr>
			 <tr>
				<th class="info">Visa No : ' . $row ['visa_no'] . '</th>
                <th class="info">Country : ' . $row ['country'] . '</th>
                <th class="info">Type : ' . $row ['visa_type'] . '</th>
				<th class="info">Staying Days : ' . $row ['days'] . '</th>
				<th class="info">Pax Count : ' . $row ['count'] . '</th>
	            <th class="danger">Name : ' . $row ['name'] . '</th>
				<th class="danger">Mobile : ' . $cus_info ['mobile'] . '</th>
             </tr>
			<tr>
		</tr>
		<input type="hidden" id="count" value="' . $row [count] . '">';
	}
	echo '
              	</table>
            </div>';
	
	
}
function display_visa_detail_full($visa_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  ';
	
	$result = mysqli_query ($conn, "SELECT * FROM visa WHERE visa_no='$visa_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$cus_info = get_customer_info ( $row [name] );
		echo '<tr>
				<th colspan="5" class="info">Visa Detail</th>
                <th colspan="2" class="danger">Passenger Detail</th>
                <th colspan="3" class="success">Payment Detail</th>
             </tr>
			 <tr>
				<th class="info">No : ' . $row ['visa_no'] . '</th>
                <th class="info">To : ' . $row ['country'] . '</th>
                <th class="info">Type : ' . $row ['visa_type'] . '</th>
				<th class="info">Days : ' . $row ['days'] . '</th>
				<th class="info">Pax Count : ' . $row ['count'] . '</th>
	            <th class="danger">Name : ' . $row ['name'] . '</th>
				<th class="danger">Mobile : ' . $cus_info ['mobile'] . '</th>
				<th class="success">Cost : ' . $row ['cost'] * $row ['count'] . '</th>
                <th class="success">markup : ' . $row ['markup'] * $row ['count'] . '</th>
                <th class="success">total : ' . $row ['total'] . '</th>
             </tr>
			<tr>
		</tr>
		<input type="hidden" id="count" value="' . $row [count] . '">';
	}
	echo '
              	</table>
            </div>';
	
	
}
function get_passenger_counts($visa_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM visa_has_passengers WHERE visa_no='$visa_no' AND cancel_status='0'" );
	$num_rows = mysql_num_rows ( $result );
	
	return $num_rows;
	
	
}
function check_repetive_passport_number($visa_no, $passport_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysql_num_rows ( mysqli_query ( "SELECT id FROM visa_has_passengers WHERE visa_no='$visa_no' AND passport_no='$passport_no' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}
	
	
}
function add_passenger_to_visa($visa_no, $passport_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO visa_has_passengers (id, visa_no, passport_no, saved_by)
	VALUES ('', '$visa_no', '$passport_no', '$_SESSION[user_name]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function delete_passengers($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE visa_has_passengers SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}
function list_passengers_detail($visa_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
         
                       <tr>
						   <th>Delete</th>
						   <th>Full Name</th>
                           <th>First Name</th>
						   <th>Last Name</th>
                           <th>Passport No</th>
                       </tr>
				   ';
	$result = mysqli_query ($conn, "SELECT * FROM visa_has_passengers WHERE visa_no='$visa_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td><a href="visa.php?job=delete_passenger&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this user?\')"><i class="fa fa-times fa-2x"></i></a></td>
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
function list_passengers_details_view($visa_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
         
                       <tr>
						   <th>Full Name</th>
                           <th>First Name</th>
						   <th>Last Name</th>
                           <th>Passport No</th>
                       </tr>
				   ';
	$result = mysqli_query ($conn, "SELECT * FROM visa_has_passengers WHERE visa_no='$visa_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
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
function complete_visa($visa_no, $cost, $markup, $total) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE visa SET
	cost='$cost',
	markup='$markup',
	total='$total',
	branch='$_SESSION[branch]'
	WHERE visa_no='$visa_no'";
	mysqli_query ($conn, $query );
	
	
}



function list_visa_logbook($visa_no, $customer) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	if ($visa_no) {
		$visa_no_check = "AND visa_no LIKE '%$visa_no%'";
	} else {
		$visa_no_check = "";
	}
	
	if ($customer) {
		$customer_check = "AND name LIKE '%$customer%'";
	} else {
		$customer_check = "";
	}


	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr class="info">
						   <th>V.No</th>
                           <th>Customer</th>
						   <th>Invoice</th>
						   <th>Others</th>
						   <th>Receipt</th>
						   <th>Others</th>
						   <th>Paybill</th>
                           <th>B.Profit</th>
						   <th>A.Profit</th>
                           <th>Created By</th>
						   <th>Created</th>
                       </tr>
				   </thead>
                <tbody>';
	$ref_type = 'Refund';
	
	$result = mysqli_query ( $conn, "SELECT * FROM visa WHERE cancel_status='0' $visa_no_check $customer_check  ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$invoice_amount = get_invoice_amount ( $row['visa_no'], $ref_type);
		$other_income_amount = get_booking_other_income_amount ( $row['visa_no'], $ref_type );
		$receipt_amount = get_booking_receipt_amount ( $row [visa_no] );
		$voucher_amount = get_booking_voucher_amount ( $row [visa_no] );
		$other_expense_amount = get_booking_other_expense_amount ( $row['visa_no'], $ref_type );
		$paybill_amount = get_booking_paybill_amount ( $row [visa_no] );
		$paybill_amount_other = get_booking_paybill_amount_other ( $row [visa_no] );

		$job_profit = ($_SESSION ['invoice_total'] + $_SESSION ['other_income_total']) - ($_SESSION ['voucher_total'] + $_SESSION ['other_expense_total']);
		$actual_profit = $_SESSION ['receipt_total'] - ($_SESSION ['paybill_total'] + $_SESSION ['paybill_total_other']);

		echo '<tr>
		<td>
		' . $row [visa_no] . '
		</td>

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
			<td>' . $row ['saved_by'] . '</td>
			<td>' . $row ['saved'] . '</td>
		</tr>';
	}
	echo '			</tbody>
              	</table>
            </div>

			';

	
}
