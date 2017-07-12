<?php
function list_customer($customer_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM customer WHERE cancel_status='0' ORDER BY id DESC LIMIT 10" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($i % 2 == 1) {
			echo "<div class='alert alert-info' style='margin-top: 2px;'>";
		} else {
			echo "<div class='alert alert-danger' style='margin-top: 2px;'>";
		}
		echo '<div class="row">
				<div class="col-lg-4">
					<img src="' . $row [passport] . '" width="270"/>
					<a href="customer.php?job=edit&id=' . $row [id] . '" class="btn"><i class="fa fa-pencil-square-o"></i> edit </a>
					<a href="customer.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this user?\')"><i class="fa fa-times"></i></i> Delete </a>
				</div>
				<div class="col-lg-8">
					<div class="table-responsive">
              			<table class="table" style="font-size: 12px;">
                  			<tr>
                           		<th>Customer ID</th>
                           		<td>' . $row [customer_no] . '</td>
                           		<th>Customer Name</th>
                           		<td>' . $row [customer_name] . '</td>
			               	</tr>
                           	<tr>
                           		<th>First Name</th>
                           		<td>' . $row [first_name] . '</td>
                           		<th>Last Name</th>
                           		<td>' . $row [last_name] . '</td>
			               	</tr>
                           	<tr>
                           		<th>Sex</th>
                           		<td>' . $row [sex] . '</td>
                           		<th>Nationality</th>
                           		<td>' . $row [nationality] . '</td>
			               	</tr>
                           	<tr>
                           		<th>Date Of Birth</th>
                           		<td>' . $row [dob] . '</td>
                           		<th>Passport No</th>
                           		<td>' . $row [passport_no] . '</td>
			               	</tr>
                           <tr>
                           		<th>Issued Date</th>
                           		<td>' . $row [issued_date] . '</td>
                           		<th>Expire Date</th>
                           		<td>' . $row [expire_date] . '</td>
			               	</tr>
                           	<tr>
                           		<th>Mobile</th>
                           		<td>' . $row [mobile] . '</td>
                           		<th>Telephone</th>
                           		<td>' . $row [telephone] . '</td>
			               	</tr>
                           	<tr>
                           		<th>Email</th>
                           		<td>' . $row [email] . '</td>
                           		<th>Address</th>
                           		<td>' . $row [address] . '</td>
			               	</tr>
                        </table>
                    </div>
					
				</div>
			</div>				
		</div>';
	}
	echo '</tbody></table>';
	

}
function list_customer_search($search) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM customer WHERE customer_name LIKE '$search' AND cancel_status='0' ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($i % 2 == 1) {
			echo "<div class='alert alert-info' style='margin-top: 2px;'>";
		} else {
			echo "<div class='alert alert-danger' style='margin-top: 2px;'>";
		}
		echo '<div class="row">
				<div class="col-lg-4">
					<img src="' . $row [passport] . '" width="270"/>
					<a href="customer.php?job=edit&id=' . $row [id] . '" class="btn"><i class="fa fa-pencil-square-o"></i> edit </a>
					<a href="customer.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this user?\')"><i class="fa fa-times"></i></i> Delete </a>
				</div>
				<div class="col-lg-8">
					<div class="table-responsive">
              			<table class="table" style="font-size: 12px;">
                  			<tr>
                           		<th>Customer ID</th>
                           		<td>' . $row [customer_id] . '</td>
                           		<th>Customer Name</th>
                           		<td>' . $row [customer_name] . '</td>
			               	</tr>
                           	<tr>
                           		<th>First Name</th>
                           		<td>' . $row [first_name] . '</td>
                           		<th>Last Name</th>
                           		<td>' . $row [last_name] . '</td>
			               	</tr>
                           	<tr>
                           		<th>Sex</th>
                           		<td>' . $row [sex] . '</td>
                           		<th>Nationality</th>
                           		<td>' . $row [nationality] . '</td>
			               	</tr>
                           	<tr>
                           		<th>Date Of Birth</th>
                           		<td>' . $row [dob] . '</td>
                           		<th>Passport No</th>
                           		<td>' . $row [passport_no] . '</td>
			               	</tr>
                           <tr>
                           		<th>Issued Date</th>
                           		<td>' . $row [issued_date] . '</td>
                           		<th>Expire Date</th>
                           		<td>' . $row [expire_date] . '</td>
			               	</tr>
                           	<tr>
                           		<th>Mobile</th>
                           		<td>' . $row [mobile] . '</td>
                           		<th>Telephone</th>
                           		<td>' . $row [telephone] . '</td>
			               	</tr>
                           	<tr>
                           		<th>Email</th>
                           		<td>' . $row [email] . '</td>
                           		<th>Address</th>
                           		<td>' . $row [address] . '</td>
			               	</tr>
                        </table>
                    </div>
					
				</div>
			</div>				
		</div>';
	}
	echo '</tbody></table>';
	

}
function get_customer_id() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(id) FROM customer" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$max_id = $row ['MAX(id)'] + 1;
		$customer_id = 'NATIONCUS-' . $max_id;
		return $customer_id;
	}
	

}
function save_customer($customer_name, $salute, $customer_id, $first_name, $last_name, $sex, $nationality, $dob, $address, $telephone, $mobile, $email, $passport_no, $passport, $issued_date, $expire_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO customer (id, customer_name, salute, customer_id, first_name, last_name, sex, nationality, dob, address, telephone, mobile, email, passport_no, passport, issued_date, expire_date, saved_by)
	VALUES ('','$customer_name', '$salute', '$customer_id', '$first_name', '$last_name', '$sex', '$nationality', '$dob', '$address', '$telephone', '$mobile', '$email', '$passport_no', '$passport', '$issued_date', '$expire_date', '$_SESSION[user_name]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function update_customer($id, $customer_name, $salute, $customer_id, $first_name, $last_name, $sex, $nationality, $dob, $address, $telephone, $mobile, $email, $passport_no, $passport, $issued_date, $expire_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE customer SET
	customer_name='$customer_name',
	salute='$salute',
	customer_id='$customer_id',
	first_name='$first_name',
	last_name='$last_name',
	sex='$sex',
	nationality='$nationality',
	dob='$dob',
	address='$address',
	telephone='$telephone',
	mobile='$mobile',
	email='$email',
	passport='$passport',
	passport_no='$passport_no',
	issued_date='$issued_date',
	expire_date='$expire_date'
	WHERE id='$id'";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function update_passport_no_in_booking($passport_no, $old_passport) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE booking_has_passengers SET
	passport_no='$passport_no',
	passport_no_on_booking_complete='$old_passport'
	WHERE passport_no='$old_passport'";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function get_customer_info_by_id($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM customer WHERE id='$id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	

}
function get_customer_info($customer_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM customer WHERE customer_name='$customer_name'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function get_customer_info_by_customer_id($customer_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM customer WHERE customer_id='$customer_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function cancel_customer($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE customer SET
	cancel_status='1',
	canceled_by='$_SESSION[user_name]'
	WHERE id='$id'";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}



function customer_birthday($date) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date ( "m", strtotime ( $date ) );
	
		echo '<div class="box-body">
              <table id="example2" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                <thead>
                <tr>
                    <td>Customer Name</td>
                    <td>DOB</td>
                    <td>Mobile</td>
				</tr>
				</thead>
				<tbody>';

		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE dob LIKE '%-$date-%' ORDER BY day(dob)" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>

		
		<td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row1 ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row1 ['customer_name'] . '</a></div></td>
				
		<td>' . $row1 [dob] . '</td>

		<td>' . $row1 [mobile] . '</td>
		</tr>';
		
	}
	echo '</tbody></table></div>';
	

}

function customer_birthday_by_day($date) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date ( "m-d", strtotime ( $date ) );

	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
				<thead>
				<tr >

				<td>Customer Name</td>
				<td>DOB</td>
				<td>Mobile</td>
				</tr>
				<thead>
				<tbody>';

	$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE dob LIKE '%-$date'" );
	while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
		echo '<tr>

        <td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row1 ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row1 ['customer_name'] . '</a></div></td>				
		<td>' . $row1 [dob] . '</td>
		<td>' . $row1 [mobile] . '</td>
		</tr>';

	}
	echo '</tbody></table></div>';


}