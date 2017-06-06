<?php
function save_cab_package($cab_package_code, $rate, $type, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO cab_packages (id, cab_package_code, rate, type, saved_by)
	VALUES ('', '$cab_package_code', '$rate', '$type', '$user_name')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function update_cab_package($id, $cab_package_code, $rate, $type, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cab_packages SET
	cab_package_code='$cab_package_code',
	rate='$rate',
	type='$type'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}
function list_cab_packages() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
                       <tr>
                           <th>Edit</th>
                           <th>Code</th>
                           <th>Type</th>
                           <th>Rate</th>
			               <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	$i = 1;
	$result = mysqli_query ($conn , "SELECT * FROM cab_packages WHERE cancel_status='0' ORDER BY cab_package_code ASC");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($i % 4 == 0) {
			echo '<tr class="info">';
		} elseif ($i % 3 == 0) {
			echo '<tr class="warning">';
		} elseif ($i % 2 == 0) {
			echo '<tr class="success">';
		} else {
			echo '<tr class="danger">';
		}
		
		echo '<td><a href="cab_package.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-edit fa-2x"></i></a></td>
					
		<td>' . $row [cab_package_code] . '</td>
					
		<td>' . $row [type] . '</td>
					
		<td>' . $row [rate] . '</td>
		
		<td><a href="cab_package.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	
	
}
function get_cab_package_info($cab_package_code) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM cab_packages WHERE cab_package_code='$cab_package_code'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function get_cab_package_info_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn , "SELECT * FROM cab_packages WHERE id='$user_id'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function cancel_cab_package($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cab_packages SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}
function get_cab_booking_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(serial_no) FROM cab" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	
	
}
function get_serial_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(serial_no) FROM cab" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	
	
}
function save_cab($cab_booking_no, $customer, $customer_id, $mobile, $start, $end, $count, $vechicle_type, $app_distance, $days, $start_date, $end_date, $status, $confirm_date, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO cab(id, cab_booking_no, serial_no, name, customer_id, mobile, start, end, count, vechicle_type, app_distance, days, start_date, end_date, status, confirm_date, saved_by, branch, saved)
	VALUES ('', '$cab_booking_no', '$cab_booking_no', '$customer', '$customer_id', '$mobile', '$start', '$end', '$count', '$vechicle_type', '$app_distance', '$days', '$start_date', '$end_date', '$status', '$confirm_date', '$user_name', '$branch', '$time')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function update_cab($cab_booking_no, $customer, $customer_id, $mobile, $start, $end, $count, $vechicle_type, $app_distance, $days, $start_date, $end_date, $status, $confirm_date, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cab SET
	name='$customer',
	customer_id='$customer_id',
	mobile='$mobile',
	start='$start',
	end='$end',
	start_date='$start_date',
	end_date='$end_date',
	count='$count',
	vechicle_type='$vechicle_type',
	app_distance='$app_distance',
	days='$days',
	status='$status',
	confirm_date='$confirm_date',
	saved='$time'
	WHERE cab_booking_no='$cab_booking_no'";
	mysqli_query ($conn, $query );
	
	
}
function update_cab_confirm($cab_booking_no, $vechicle_model, $vechicle_no, $driver, $license, $driver_phone, $pickup_time, $status) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cab SET
	vechicle_model='$vechicle_model',
	vechicle_no='$vechicle_no',
	driver='$driver',
	license='$license',
	driver_phone='$driver_phone',
	status='$status',
	pickup_time='$pickup_time',
	saved='$time'
	WHERE cab_booking_no='$cab_booking_no'";
	mysqli_query ($conn, $query );
	
	
}
function get_cab_info_by_cab_booking_no($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn , "SELECT * FROM cab WHERE cab_booking_no='$cab_booking_no' AND cancel_status='0'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function display_cab_detail($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
                  <tr>
					  <th>From</th>
                      <th>To</th>
					  <th>Start Date</th>
	                  <th>End Date</th>
					  <th>Passengers count</th>
                      <th>Vehicle Type</th>
					  <th>App. Distance</th>
                      <th>Customer</th>
					  <th>Contact</th>
                      <th>Confirm Date</th>
                 </tr>';
	
	$result = mysqli_query (  $conn , "SELECT * FROM cab WHERE cab_booking_no='$cab_booking_no' AND cancel_status='0' ORDER BY id ASC");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$cus_info = get_customer_info ( $row [name] );
		echo '<tr>
			<td>' . $row ['start'] . '</td>
			<td>' . $row ['end'] . '</td>
			<td>' . $row ['start_date'] . '</td>
			<td>' . $row ['end_date'] . '</td>
			<td>' . $row ['count'] . '</td>
			<td>' . $row ['vechicle_type'] . '</td>
			<td>' . $row ['app_distance'] . '</td>
			<td>' . $row ['name'] . '</td>
			<td>' . $cus_info ['mobile'] . '</td>
			<td>' . $row ['confirm_date'] . '</td>
		</tr>';
	}
	echo '
              	</table>
            </div>';
	
	
}
function cab_driver_details($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
                  ';
	
	$result = mysqli_query ( $conn , "SELECT * FROM cab WHERE cab_booking_no='$cab_booking_no' AND cancel_status='0' ORDER BY id ASC");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
				<th colspan="3" class="info">Driver</th>
                <th colspan="2" class="danger" style="">Vechicle</th>
				<th class="success" style="text-align: center;"></th>
             </tr>
			 <tr>
				<th class="info">Name : ' . $row ['driver'] . '</th>
                <th class="info">Mobile : ' . $row ['driver_phone'] . '</th>
				<th class="info">License : ' . $row ['license'] . '</th>
	            <th class="danger">Model : ' . $row ['vechicle_model'] . '</th>
				<th class="danger">Number : ' . $row ['vechicle_no'] . '</th>
				<th class="success">PickUp Time : ' . $row ['pickup_time'] . '</th
             </tr>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>';
	}
	echo '
              	</table>
            </div>';
	

}
function check_repetive_package($cab_booking_no, $package) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ( "SELECT id FROM cab_charges WHERE cab_booking_no='$cab_booking_no' AND package='$package' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}
	
	
}
function add_package_to_cab_charges($cab_booking_no, $package) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_cab_package_info ( $package );
	$rate = $info ['rate'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO cab_charges (id, cab_booking_no, package, rate, saved_by)
	VALUES ('', '$cab_booking_no', '$package', '$rate', '$_SESSION[user_name]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function cab_charges($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
                       <tr>
                           <th>Package</th>
                           <th>Rate</th>
			               <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	$i = 1;
	$total = 0;
	$result = mysqli_query ($conn , "SELECT * FROM cab_charges WHERE cab_booking_no='$cab_booking_no' AND cancel_status='0' ORDER BY rate ASC");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
							
		<td>' . $row [package] . '</td>
			
		<td algin="right">' . $row [rate] . '</td>

		<td><a href="cab.php?job=delete_charge&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>

		</tr>';
		
		$total = $total + $row ['rate'];
		
		$i ++;
	}
	
	echo '<tr>
							
		<td><strong>Total</strong></td>
			
		<td algin="right"><strong>' . number_format ( $total, 2 ) . '</strong></td>

		<td></td>

		</tr></tbody>
          </table>
          </div>';
	
	
}
function cab_charges_view($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
                       <tr>
                           <th>Package</th>
                           <th>Rate</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	$i = 1;
	$total = 0;
	$result = mysqli_query ( $conn, "SELECT * FROM cab_charges WHERE cab_booking_no='$cab_booking_no' AND cancel_status='0' ORDER BY rate ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>
				
		<td>' . $row [package] . '</td>
		
		<td algin="right">' . $row [rate] . '</td>
		
		</tr>';
		
		$total = $total + $row ['rate'];
		
		$i ++;
	}
	
	echo '<tr>
				
		<td><strong>Total</strong></td>
		
		<td algin="right"><strong>' . number_format ( $total, 2 ) . '</strong></td>

		</tr></tbody>
          </table>
          </div>
				
				
				
				<div class="row">
						<div class="col-lg-12" style="text-align: center;">
							<a href="cab.php?job=print&cab_booking_no=' . $cab_booking_no . '" class="btn btn-success" target="blank">Print</a>
						</div>
	                </div>';
	
	
}
function cab_charges_view_print($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
                       <tr>
                           <th>Package</th>
                           <th>Rate</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	$i = 1;
	$total = 0;
	$result = mysqli_query ($conn , "SELECT * FROM cab_charges WHERE cab_booking_no='$cab_booking_no' AND cancel_status='0' ORDER BY rate ASC");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>

		<td>' . $row [package] . '</td>

		<td algin="right">' . $row [rate] . '</td>

		</tr>';
		
		$total = $total + $row ['rate'];
		
		$i ++;
	}
	
	echo '<tr>

		<td><strong>Total</strong></td>

		<td algin="right"><strong>' . number_format ( $total, 2 ) . '</strong></td>

		</tr></tbody>
          </table>
          </div>';
	
	
}
function delete_package_from_cab_charges($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cab_charges SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}
function get_charges_count($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn , "SELECT * FROM cab_charges WHERE cab_booking_no='$cab_booking_no' AND cancel_status='0'");
	$num_rows = mysqli_num_rows ( $result );
	return $num_rows;
	
	
}
function confirm_invoice($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn , "SELECT * FROM invoice WHERE ref_no='$cab_booking_no' AND type='CAB' AND cancel_status='0'");
	$num_rows = mysqli_num_rows ( $result );
	return $num_rows;
	
	
}
function get_cab_total($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT SUM(rate) as total FROM cab_charges WHERE cab_booking_no='$cab_booking_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$total = $row [total];
		return $total;
	}
}
function complete_cab($cab_booking_no, $total) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cab SET
	status='Confirm',
	total='$total',
	branch='$_SESSION[branch]'
	WHERE cab_booking_no='$cab_booking_no'";
	mysqli_query ($conn, $query );
	
	
}
function search_cab_report($cab_booking_no, $name, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($cab_booking_no) {
		$cab_booking_no_check = "AND cab_booking_no LIKE '$cab_booking_no'";
	} else {
		$cab_booking_no_check = "";
	}
	
	if ($name) {
		$name_check = "AND name LIKE '$name'";
	} else {
		$name_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND start_date BETWEEn '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND start_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND start_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
	<tr class="danger" style="font-weight: bold;">

	<td>View</td>
	<td>Booking No</td>
	<td>Serial No</td>
	<td>Name</td>
	<td>Start Date</td>
	<td>End Date</td>
	<td>Type</td>
	<td>Model</td>
	<td>No</td>
	<td>Total</td>
	</tr>';
	
	$total = 0;
	$result = mysqli_query ( $conn , "SELECT * FROM cab WHERE cancel_status='0' $date_check $name_check $cab_booking_no_check ORDER BY id $limit");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<tr>

				<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [cab_booking_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>
			<td>
		' . $row [cab_booking_no] . '
		</td>

		<td>
		 ' . $row [serial_no] . '
		</td>

		<td>
		' . $row [name] . '
		</td>

		<td>
		 ' . $row [start_date] . '
		</td>

		 		<td>
		 ' . $row [end_date] . '
		</td>

		<td>
		' . $row [vechicle_type] . '
		</td>

		<td>
		 ' . $row [vechicle_model] . '
		</td>
		 		
		 <td>
		 ' . $row [vechicle_no] . '
		</td>

		 <td align="right" class="success">
		 ' . $row [total] . '
		</td></tr>
		
		<div class="modal fade" id="' . $row [cab_booking_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [cab_booking_no] . '" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
		<div class="modal-header">Cab
		</div>
		<div class="modal-body">
		<iframe src="Cab.php?job=view&cab_booking_no=' . $row [cab_booking_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
		</div>
		</div>';
		$total = $total + $row ['total'];
	}
	
	$formated_total = number_format ( $total, 2 );
	
	echo '<tr>
			<td colspan="9" align="right"><strong></strong></td>
		
	<td align="right" class="danger">
	<strong>' . $formated_total . '</strong>
	</td>
	</tr></table></div>';
	
	
}
function list_Cab($cab_booking_no, $name, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($cab_booking_no) {
		$cab_booking_no_check = "AND cab_booking_no LIKE '%$cab_booking_no%'";
	} else {
		$cab_booking_no_check = "";
	}
	
	if ($name) {
		$name_check = "AND name LIKE '%$name%'";
	} else {
		$name_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND start_date BETWEEN '$to_date' AND '$from_date'";
	} elseif ($from_date) {
		$date_check = "AND start_date>='$from_date'";
	} elseif ($to_date) {
		$date_check = "AND start_date<='$to_date'";
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
	
	$result = mysqli_query (  $conn , "SELECT * FROM cab WHERE status='Confirm' AND cancel_status='0'  $cab_booking_no_check $name_check $date_check ORDER BY id");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$invoice_amount = get_cab_invoice_amount ( $row [cab_booking_no] );
		$other_income_amount = get_cab_other_income_amount ( $row [cab_booking_no] );
		$receipt_amount = get_cab_receipt_amount ( $row [cab_booking_no] );
		$voucher_amount = get_cab_voucher_amount ( $row [cab_booking_no] );
		$other_expense_amount = get_cab_other_expense_amount ( $row [cab_booking_no] );
		$paybill_amount = get_cab_paybill_amount ( $row [cab_booking_no] );
		$paybill_amount_other = get_cab_paybill_amount_other ( $row [cab_booking_no] );
		
		$job_profit = ($_SESSION ['invoice_total'] + $_SESSION ['other_income_total']) - ($_SESSION ['voucher_total'] + $_SESSION ['other_expense_total']);
		$actual_profit = $_SESSION ['receipt_total'] - ($_SESSION ['paybill_total'] + $_SESSION ['paybill_total_other']);
		
		echo '

				<td>
		' . $row [cab_booking_no] . '
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
function get_cab_invoice_amount($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query (  $conn , "SELECT invoice_no, total, customer FROM invoice WHERE ref_no='$cab_booking_no' AND type='CAB' AND cancel_status='0' ");
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
function get_cab_other_income_amount($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT invoice_no, total FROM invoice WHERE ref_no='$cab_booking_no' AND ref_type='Booking' AND type='CAB' AND cancel_status='0' " );
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
function get_cab_receipt_amount($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query (  $conn , "SELECT receipt_has_invoice.rec_no, receipt_has_invoice.amount, receipt_has_invoice.invoice_no, invoice.invoice_no  FROM receipt_has_invoice, invoice WHERE receipt_has_invoice.invoice_no=invoice.invoice_no AND invoice.ref_no='$cab_booking_no' ");
	$amount = '';
	$_SESSION ['receipt_total'] = 0;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($amount == '') {
			$chq = get_receipt_chq_no_for_cab ( $row ['rec_no'] );
			
			$amount = '<a href="receipt.php?job=view_receipt&rec_no=' . $row [rec_no] . '" target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		} else {
			$chq = get_receipt_chq_no_for_cab ( $row ['rec_no'] );
			$amount = $amount . '<br /><br /><a href="receipt.php?job=view_receipt&rec_no=' . $row [rec_no] . '" target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		}
		
		$_SESSION ['receipt_total'] = $_SESSION ['receipt_total'] + $row [amount];
	}
	
	return $amount;
}
function get_cab_voucher_amount($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT voucher_no, total, travels FROM voucher WHERE booking_no='$cab_booking_no' AND cancel_status='0'" );
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
function get_cab_other_expense_amount($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn , "SELECT other_expenses_no, total FROM other_expenses WHERE ref_no='$cab_booking_no' AND ref_type='Booking' AND type='OTHER-EXPENSES' AND cancel_status='0' ");
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
function get_cab_paybill_amount($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query (  $conn , "SELECT paybill_has_voucher.paybill_no, paybill_has_voucher.amount, voucher.voucher_no, voucher.booking_no, voucher.travels
			FROM paybill_has_voucher, voucher
			WHERE paybill_has_voucher.ref_no=voucher.voucher_no AND paybill_has_voucher.ref_type='VOUCHER' AND voucher.booking_no='$cab_booking_no' ");
	
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
function get_cab_paybill_amount_other($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT paybill_has_voucher.paybill_no, paybill_has_voucher.amount, other_expenses.other_expenses_no, other_expenses.ref_no, other_expenses.customer
			FROM paybill_has_voucher, other_expenses
			WHERE paybill_has_voucher.ref_no=other_expenses.other_expenses_no AND paybill_has_voucher.ref_type='OTHER EXPENSES' AND other_expenses.ref_no='$cab_booking_no' " );
	
	$amount = '';
	$_SESSION ['paybill_total_other'] = 0;
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		
		if ($amount == '') {
			
			$chq = get_paybill_chq_no_for_cab ( $row ['paybill_no'] );
			
			$amount = '
			<a href="paybill.php?job=print_paybill&paybill_no=' . $row [paybill_no] . '" target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		} 

		else {
			
			$chq = get_paybill_chq_no_for_cab ( $row ['paybill_no'] );
			$amount = $amount . '<br /><br /><a href="paybill.php?job=print_paybill&paybill_no=' . $row [paybill_no] . '" target="blank">' . number_format ( $row [amount], 2 ) . '</a>
			<br />[<b> ' . $chq . ' </b>]';
		}
		
		$_SESSION ['paybill_total_other'] = $_SESSION ['paybill_total_other'] + $row [amount];
	}
	
	return $amount;
}
function get_receipt_chq_no_for_cab($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn , "SELECT cheque_no FROM receipt WHERE rec_no='$rec_no' AND cancel_status='0'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['cheque_no'];
	}
}
function get_paybill_chq_no_for_cab($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn , "SELECT cheque_no FROM paybill WHERE paybill_no='$paybill_no' AND cancel_status='0'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['cheque_no'];
	}
}