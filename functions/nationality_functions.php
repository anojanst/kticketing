<?php
function save_nationality($nationality, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO nationality (id, nationality, saved_by)
	VALUES ('', '$nationality', '$user_name')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function update_nationality($id, $nationality) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE nationality SET
	nationality='$nationality'
	WHERE id='$id'";
	
	mysqli_query ( $conn, $query );
	
	
}
function list_nationality() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
                       <tr>
                           <th>Edit</th>
                           <th>Nationality</th>
			               <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	$i = 1;
	$result = mysqli_query ($conn, "SELECT * FROM nationality WHERE cancel_status='0' ORDER BY nationality ASC" );
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
		
		echo '<td><a href="nationality.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-edit fa-2x"></i></a></td>

		<td>' . $row [nationality] . '</td>
					
		<td><a href="nationality.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	
	
}
function get_nationality_info($nationality) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM nationalits WHERE nationality='$nationality'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function get_nationality_info_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM nationality WHERE id='$user_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function cancel_nationality($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE nationality SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}