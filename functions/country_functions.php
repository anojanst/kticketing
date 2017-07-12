<?php
function save_country($country, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO country (id, country, saved_by)
	VALUES ('', '$country', '$user_name')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function update_country($id, $country) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE country SET
	country='$country'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	

}
function list_country() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
                           <th>Edit</th>
                           <th>country</th>
			               <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	$i = 1;
	$result = mysqli_query ( $conn, "SELECT * FROM country WHERE cancel_status='0' ORDER BY country ASC" );
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
		
		echo '<td><a href="country.php?job=edit&id=' . $row [id] . '"  ><i class="fa fa-edit fa-2x"></i></a></td>

		<td>' . $row [country] . '</td>
					
		<td><a href="country.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';
		
		$i ++;
	}
	
	echo '</tbody>
          </table>
          </div>';
	

}
function get_country_info($country) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn,  "SELECT * FROM nationalits WHERE country='$country'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function get_country_info_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM country WHERE id='$user_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}

}
function cancel_country($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE country SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );

}