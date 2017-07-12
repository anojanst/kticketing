<?php
function save_offer($offer_code, $off, $type, $exp_date, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO offers (id, offer_code, off, type, exp_date, saved_by)
	VALUES ('', '$offer_code', '$off', '$type', '$exp_date', '$user_name')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function update_offer($id, $offer_code, $off, $type, $exp_date, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE offers SET
	offer_code='$offer_code',
	off='$off',
	type='$type',
	exp_date='$exp_date'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}
function list_offer() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
                           <th>Edit</th>
                           <th>Offer Code</th>
                           <th>Offer</th>
						   <th>Type</th>
						   <th>EXP Date</th>
			               <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	$i = 1;
	$result = mysqli_query ($conn, "SELECT * FROM offers WHERE cancel_status='0' ORDER BY offer_code ASC" );
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
		
		echo '<td><a href="offer.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-edit fa-2x"></i></a></td>

		<td>' . $row [offer_code] . '</td>
		
		<td>' . $row [off] . '</td>
		
		<td>' . $row [type] . '</td>
				
		<td>' . $row [exp_date] . '</td>
					
		<td><a href="offer.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	
	
}
function get_offer_info($offer_code) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM offers WHERE offer_code='$offer_code'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function get_offer_info_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM offers WHERE id='$user_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function cancel_offer($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE offers SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}