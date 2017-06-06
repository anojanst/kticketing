<?php
function add_description($salary_no, $description, $detail, $amount) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO salary_has_descriptions (id, salary_no, description, detail, amount)
	VALUES ('', '$salary_no', '$description', '$detail', '$amount')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function get_salary_no_from_salary_has_descriptions() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(salary_no) FROM salary_has_descriptions WHERE  cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(salary_no)'] + 1;
	}
}
function list_salary_details($salary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
				<tr style="font-weight: bold;">
					<td>Description</td>
					<td>Detail</td>
					<td align="right">Amount</td>
					<td> Add/Remove</td>
				</tr>';
	
	
	$result = mysqli_query ( $conn, "SELECT * FROM salary_has_descriptions WHERE salary_no='$salary_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '
		
		<td>' . $row [description] . '</td>
		
		<td>' . $row [detail] . '</td>
		<td>' . $row [amount] . '</td>
		
		<td><a href="staff_salary.php?job=delete_description&id=' . $row [id] . '" ><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';		
		
		
	}
	
	echo '</tbody>
          </table>
          </div>';
	
}
function get_salary_total($salary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT sum(amount) as total FROM salary_has_descriptions WHERE salary_no='$salary_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$total = $row [total];
	}
	
	return $total;
	
	
}
function delete_salary_description($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE salary_has_descriptions SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}
function get_salary_info($salary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM salary WHERE salary_no='$salary_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function add_salary($salary_no, $staff_name, $salary_date, $saved_by) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$today = date ( "Y-m-d H:i:s" );
	$total = get_salary_total ( $salary_no );
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO salary (id, salary_no, staff_name, salary_date, saved_by, branch, saved, total, cancel_status)
	VALUES ('', '$salary_no', '$staff_name', '$salary_date', '$saved_by','$_SESSION[branch]', '$today', '$total', '0')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function search_salary_history($staff_name, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($staff_name) {
		$staff_name_check = "AND staff_name LIKE '%$staff_name%'";
	} else {
		$staff_name_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND salary_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND salary_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND salary_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	echo '<div class="table-responsive" >
              <table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr style="font-weight: bold;">
						<td>Print</td>
						<td>View</td>
						<td>Cancel</td>
						<td>Name</td>
						<td>date</td>
						<td align="right">Amount</td>
					</tr>
				</thead>
			
                <tbody valign="top">
				';
	
	$result = mysqli_query ($conn, "SELECT * FROM salary WHERE cancel_status='0' $staff_name_check $date_check ORDER BY id LIMIT 20" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '
		
		<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [salary_no] . '"><i class="fa fa-print fa-lg"></i></a>
		</td>
				
		<td>
		<a href="staff_salary.php?job=view&salary_no=' . $row [salary_no] . '" target="blank"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>

		<td>
		<a href="staff_salary.php?job=delete&salary_no=' . $row [salary_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a>
		</td>
				<td>' . $row [staff_name] . '</td>
			<td>' . $row [salary_date] . '</td>
			<td align="right" class="success">' . $row [total] . '</td>
			</tr>';
		
		$total = $total + $row ['total'];
	}
	$formated_total = number_format ( $total, 2 );
	
	echo '
	
				</tbody>
          </table>
          </div';
	
	
	echo '
		<tr>
		<td colspan="5" align="right"><strong></strong></td>
	
		 <td align="right" class="danger">
		 <strong>' . $formated_total . '</strong>
		</td>	
			
		';
	
}
function search_branch_salary_history($branch, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($branch) {
		$branch_name_check = "AND branch LIKE '$branch'";
	} else {
		$branch_name_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND salary_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND salary_date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND salary_date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
				<tr class="danger" style="font-weight: bold;">
					<td>branch</td>
					<td>date</td>
					<td align="right">Amount</td>
				</tr>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM salary WHERE cancel_status='0' $branch_name_check $date_check ORDER BY id LIMIT 20" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<td>' . $row [branch] . '</td>
			<td>' . $row [salary_date] . '</td>
			<td align="right" class="success">' . $row [total] . '</td>
			</tr>';
		
		$total = $total + $row ['total'];
	}
	
	$formated_total = number_format ( $total, 2 );
	
	echo '<tr>
		<td colspan="2" align="right"><strong></strong></td>
	
		 <td align="right" class="danger">
		 <strong>' . $formated_total . '</strong>
		</td>
	
		</tr></table></div>';
	
	
}
function cancel_salary($salary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE salary SET
	cancel_status='1'
	WHERE salary_no='$salary_no'";
	
	mysqli_query ($conn, $query );
	
	
}
function cancel_all_salary_description($salary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE salary_has_descriptions SET
	cancel_status='1'
	WHERE salary_no='$salary_no'";
	
	mysqli_query ($conn, $query );
	
	
}
function list_description_by_salary_view($salary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
				<tr class="danger" style="font-weight: bold;">
					<td>Description</td>
					<td>Detail</td>
					<td align="right">Amount</td>
				</tr>';
	
	$total = 0;
	$result = mysqli_query ($conn, "SELECT * FROM salary_has_descriptions WHERE salary_no='$salary_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '<td>' . $row [description] . '</td>
			<td>' . $row [detail] . '</td>
			<td align="right" class="success">' . $row [amount] . '</td>
			</tr>';
		
		$total = $total + $row ['amount'];
	}
	
	$formated_total = number_format ( $total, 2 );
	
	echo '<tr>
		<td colspan="2" align="right"><strong></strong></td>

		 <td align="right" class="danger">
		 <strong>' . $formated_total . '</strong>
		</td>

		</tr></table></div>';
	
	
}


