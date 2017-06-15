<?php
function list_paybill_not_presentation($presentation_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result2 = mysqli_query ( $conn, "SELECT DISTINCT che_date FROM cheque_inventory WHERE status='UNPRESENTED' AND che_date <= '$presentation_date' AND cancel_status='0' ORDER BY che_date ASC" );
	while ( $row2 = mysqli_fetch_array ( $result2, MYSQLI_ASSOC ) ) {
		$che_date = $row2 ['che_date'];
		
		echo '<h1>' . $che_date . '</h1>';
		echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
	<tr>
	<th>Present</th>
	<th>Cheque No</th>
	<th>Amount</th>
	<th>Paybill No</th>
	<th>Paybill Type</th>
	<th>Bank</th>
	<th>Branch</th>
	<th>Date</th>
	</tr>
	</thead>
	<tbody>
	';
		
		$result = mysqli_query ($conn, "SELECT * FROM cheque_inventory WHERE status='UNPRESENTED' AND che_date = '$che_date' AND cancel_status='0' ORDER BY che_date ASC" );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			$che_amount = number_format ( $row [che_amount], 2 );
			
			if ($row [rec_type] == "PAYBILL") {
				$type = "paybill";
				$type_job = "print_paybill";
				$type_no = "paybill_no";
				$type_name = "Paybill";
			} else {
				$type = "main_paybill";
				$type_job = "view_print_main_receipt";
				$type_no = "main_receipt_no";
				$type_name = "Main Receipt";
			}
			echo '
			<form name="deposit_cheque_' . $row [id] . '" action="cheque_presentation.php?job=present_cheque&id=' . $row [id] . '" method="post">
			<tr>

			<td>
			<input	type="submit" name="ok" value="Present" class="btn btn-danger"/>
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '"  target="_blank">' . $row [che_no] . '</a>
			</td>

			<td id="amount_td">
			' . $che_amount . '
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '" target="_blank">' . $row [rec_ref] . '</a>
			</td>

			<td>
			' . $row [rec_type] . '
			</td>
			
			<td>
			' . $row [che_bank] . '
			</td>

			<td>
			' . $row [che_branch] . '
			</td>

			<td>
			' . $row [che_date] . '
			</td>
			</tr>
			</form>';
		}
	}
	echo '</tbody></table></div>';
	

}
function list_paybill_presented() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
	<tr>
	<th>Unpresent</th>
	<th>Cheque No</th>
	<th>Amount</th>
	<th>Paybill No</th>
	<th>Paybill Type</th>
	<th>Bank</th>
	<th>Branch</th>
	<th>Date</th>
	<th>Presented Date</th>
	</tr>
	</thead>
	<tbody>
	';
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE status='PRESENTED' AND cancel_status='0' ORDER BY che_date ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$che_amount = number_format ( $row [che_amount], 2 );
		
		$type = "paybill";
		$type_job = "print_paybill";
		$type_no = "paybill_no";
		$type_name = "Paybill";
		
		echo '
			<form name="unpresented_cheque_' . $row [id] . '" action="cheque_presentation.php?job=unpresented_cheque&id=' . $row [id] . '" method="post">
			<tr>

			<td>
			<input	type="submit" name="ok" value="Unpresent" class="btn btn-danger"/>
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '"  target="_blank" >' . $row [che_no] . '</a>
			</td>

			<td id="amount_td">
			' . $che_amount . '
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '"  target="_blank">' . $row [rec_ref] . '</a>
			</td>

			<td>
			' . $row [rec_type] . '
			</td>
			
			<td>
			' . $row [che_bank] . '
			</td>
			
			<td>
			' . $row [che_branch] . '
			</td>
			
			<td>
			' . $row [che_date] . '
			</td>

			<td>
			' . $row [presented_date] . '
			</td>
			</tr>
			</form>';
	}
	echo '</tbody></table></div>';
	

}
function present_paybill_cheque($id, $presentation_date, $account) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cheque_inventory SET
	status='PRESENTED',
	presented_date='$presentation_date',
	dep_account_no='$account'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
}
function unpresented_paybill_cheque($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cheque_inventory SET
	status='UNPRESENTED',
	presented_date='0',
	dep_account_no='0'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE id='$id' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$rec_ref = $row [rec_ref];
	}
	

}
function list_specify_paybill_cheque($presentation_date, $che_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<h1>' . $che_date . '</h1>';
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
	<tr>
	<th>Present</th>
	<th>Cheque No</th>
	<th>Amount</th>
	<th>Status</th>
	<th>Paybill No</th>
	<th>Paybill Type</th>
	<th>Bank</th>
	<th>Branch</th>
	<th>Date</th>
	</tr>
	</thead>
	<tbody>
	';
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE che_no = '$che_no' AND cancel_status='0' AND (rec_type='PAYBILL' or rec_type='MAIN PAYBILL') ORDER BY che_date ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$che_amount = number_format ( $row [che_amount], 2 );
		
		$type = "paybill";
		$type_job = "print_paybill";
		$type_no = "paybill_no";
		$type_name = "Paybill";
		
		echo '
			<form name="present_cheque_' . $row [id] . '" action="cheque_presentation.php?job=present_cheque&id=' . $row [id] . '" method="post">
			<tr>';
		
		if ($row [status] == UNPRESENTED) {
			
			echo '<td>
			<input	type="submit" name="ok" value="Present" class="btn btn-danger"/>
			</td>';
		} else {
			echo '<td></td>';
		}
		echo ' <td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '" target="_blank">' . $row [che_no] . '</a>
			</td>

			<td id="amount_td">
			' . $che_amount . '
			</td>
			
			<td>
			' . $row [status] . '
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '"  target="_blank">' . $row [rec_ref] . '</a>
			</td>

			<td>
			' . $row [rec_type] . '
			</td>
			
			<td>
			' . $row [che_bank] . '
			</td>

			<td>
			' . $row [che_branch] . '
			</td>

			<td>
			' . $row [che_date] . '
			</td>
			</tr>
			</form>';
	}
	
	echo '</tbody></table>';
	

}

