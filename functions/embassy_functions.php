<?php
function save_embassy($embassy, $country, $address, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO embassy (id, embassy, country, address, saved_by)
	VALUES ('', '$embassy', '$country', '$address', '$user_name')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function update_embassy($id, $embassy, $country, $address) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE embassy SET
	embassy='$embassy',
	country='$country',
	address='$address'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	

}
function list_embassy() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
                       <tr>
                           <th>Edit</th>
                           <th>Embassy</th>
                           <th>Country</th>
                           <th>Address</th>
			               <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	$i = 1;
	$result = mysqli_query ($conn, "SELECT * FROM embassy WHERE cancel_status='0' ORDER BY embassy ASC" );
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
		
		echo '<td><a href="embassy.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-edit fa-2x"></i></a></td>

		<td>' . $row [embassy] . '</td>
		
		<td>' . $row [country] . '</td>
				
		<td>' . $row [address] . '</td>
					
		<td><a href="embassy.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	

}
function get_embassy_info($embassy) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM embassy WHERE embassy='$embassy'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}

}
function get_embassy_info_id($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM embassy WHERE id='$id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}

}
function cancel_embassy($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE embassy SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	

}