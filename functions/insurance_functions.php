<?php
function delete_insurance($insurance_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE insurance SET
	cancel_status='1'
	WHERE insurance_no='$insurance_no'";
	mysqli_query ($conn, $query );
}
function get_insurance_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn,  "SELECT MAX(serial_no) FROM insurance" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}
	
	
}
function get_serial_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(serial_no) FROM insurance" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(serial_no)'] + 1;
	}

}
function save_insurance($insurance_no, $insurance_type, $serial_no, $country, $policy_no, $customer, $customer_id, $mobile, $count, $days, $start_date, $exp_date, $cost, $markup, $total, $user_name, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO insurance(id, insurance_no, insurance_type, serial_no, country, policy_no, name, customer_id, mobile, count, days, start_date, exp_date, cost, markup, total, saved_by, branch, saved)
	VALUES ('', '$insurance_no', '$insurance_type', '$serial_no', '$country', '$policy_no', '$customer', '$customer_id', '$mobile', '$count', '$days', '$start_date', '$exp_date', '$cost', '$markup', '$total', '$user_name', '$branch', '$time')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function get_insurance_info_by_insurance_no($insurance_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM insurance WHERE insurance_no='$insurance_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}

}
function list_insurance($insurance_no, $customer) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($insurance_no) {
		$insurance_no_check = "AND insurance_no LIKE '%$insurance_no%'";
	} else {
		$insurance_no_check = "";
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
	
	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr class="danger">
						   <th>Delete</th>
						   <th>Insurance No</th>
						   <th>Policy No</th>
                           <th>Country</th>
						   <th>Type</th>
						   <th>Policy Period</th>
						   <th>Policy Start</th>
						   <th>Policy Expire</th>
                           <th>Customer</th>
						   <th>Mobile</th>
						   <th style="text-align: right;">Cost</th>
                           <th style="text-align: right;">Markup</th>
						   <th style="text-align: right;">Total</th>
                       </tr>
				   </thead>
                <tbody>';
	
	$result = mysqli_query ($conn, "SELECT * FROM insurance WHERE cancel_status='0' $insurance_no_check $customer_check $branch_check ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$cus_info = get_customer_info ( $row [name] );
		echo '<tr>
			<td><a href="insurance.php?job=delete&insurance_no=' . $row [insurance_no] . '"  ><i class="fa fa-close fa-2x"></i></a></td>
			<td>' . $row ['insurance_no'] . '</td>
			<td>' . $row ['country'] . '</td>
			<td>' . $row ['policy_no'] . '</td>
			<td>' . $row ['insurance_type'] . '</td>
			<td>' . $row ['days'] . '</td>
			<td>' . $row ['start_date'] . '</td>
			<td>' . $row ['exp_date'] . '</td>
			<td>' . $row ['name'] . '</td>
			<td>' . $cus_info ['mobile'] . '</td>
			<td align="right">' . $row ['cost'] . '</td>
			<td align="right" class="success">' . $row ['markup'] . '</td>
			<td align="right" class="info">' . $row ['total'] . '</td>
		</tr>';
	}
	echo '
              	</table>
            </div>';
	

}
