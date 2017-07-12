<?php
function customer_dep_date($date) {
	include 'conf/config.php';
	include 'conf/opendb.php';


	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
				<thead>
				<tr class="danger" style="font-weight: bold;">

				<td>Booking No</td>
				<td>Name</td>
				<td>Mobile</td>
				<td>Dep Date</td>
				<td>Dep Air Port</td>
				</tr>
				</thead>
				<tbody>';

	$result1 = mysqli_query ( $conn, "SELECT * FROM booking WHERE cancel_status='0' AND dep_date = '$date'" );
	while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
		echo '<tr>

		<td>
		<a href="booking.php?job=view&booking_no=' . $row1['booking_no'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row1['booking_no'] . '</a></td>
	
        <td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row1 ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row1 ['name'] . '</a></div></td>
		
		<td>
		' . $row1 [mobile] . '
		</td>
		<td>
		' . $row1 [dep_date] . '
		</td>

		<td>
		 ' . $row1 [dep_air_port] . '
		</td>
				
        </tr>';

	}
	echo '</tbody></table></div>';


}


function customer_arr_date($date) {
	include 'conf/config.php';
	include 'conf/opendb.php';


	echo '<div class="box-body">
              <table id="example2" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
				<thead>
				<tr class="success" style="font-weight: bold;">

				<td>Booking No</td>
				<td>Name</td>
				<td>Mobile</td>
				<td>Rtn Date</td>
				<td>Arr Air Port</td>
				</tr>
				</thead>
				<tbody>';

	$result1 = mysqli_query ($conn, "SELECT * FROM booking WHERE cancel_status='0' AND rtn_date = '$date'" );
	while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
		echo '<tr>

		<td>
		<a href="booking.php?job=view&booking_no=' . $row1['booking_no'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row1['booking_no'] . '</a></td>
	

								<td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row1 ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row1 ['name'] . '</a></div></td>
				

		<td>
		' . $row1 [mobile] . '
		</td>
		<td>
		' . $row1 [rtn_date] . '
		</td>

		<td>
		 ' . $row1 [arr_air_port] . '
		</td>
				
				</tr>';

	}
	echo '</tbody></table></div>';


}
