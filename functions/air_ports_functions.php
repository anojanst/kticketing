<?php
function save_air_port($air_port, $air_port_code, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO air_ports (id, air_port, air_port_code, saved_by)
	VALUES ('', '$air_port', '$air_port_code', '$user_name')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function update_air_port($id, $air_port, $air_port_code, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE air_ports SET
	air_port='$air_port',
	air_port_code='$air_port_code'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );

}
function list_air_ports() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
                           <th>Edit</th>
                           <th>Air Port</th>
                           <th>Code</th>
			               <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	$i = 1;
	$result = mysqli_query ($conn , "SELECT * FROM air_ports WHERE cancel_status='0' ORDER BY air_port ASC");
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
		
		echo '<td><a href="air_ports.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-edit fa-2x"></i></a></td>

		<td>' . $row [air_port] . '</td>
					
		<td>' . $row [air_port_code] . '</td>
		
		<td><a href="air_ports.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	

}
function get_air_port_info($air_port) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn , "SELECT * FROM air_ports WHERE air_port='$air_port'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}

}
function get_air_port_info_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn ,"SELECT * FROM air_ports WHERE id='$user_id'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}

}
function cancel_air_port($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE air_ports SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	

}