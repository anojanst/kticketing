<?php
function save_main_receipt_in_cheque_inventory($main_receipt_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_date, $date, $customer) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$status = 'RECEIVED';
	$rec_type = 'MAIN RECEIPT';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO cheque_inventory (rec_ref, rec_date, che_amount, che_no, che_bank, che_branch, che_date, status, rec_type, customer)
	VALUES ('$main_receipt_no', '$date', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$status', '$rec_type', '$customer')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function save_rec_in_cheque_inventory($rec_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $customer) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$status = 'RECEIVED';
	$rec_type = 'RECEIPT';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO cheque_inventory (rec_ref, rec_date, che_amount, che_no, che_bank, che_branch, che_date, status, rec_type, customer)
	VALUES ('$rec_no', '$date', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$status', '$rec_type', '$customer')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function delete_rec_from_cheque_inventory($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM receipt WHERE rec_no='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		mysqli_select_db ($conn, $dbname );
		$query = "UPDATE cheque_inventory SET
	cancel_status='1'
	WHERE rec_ref='$rec_no' AND che_no='$row[cheque_no]' AND rec_type='RECEIPT'";
		mysqli_query ($conn, $query );
	}
	

}
function delete_main_receipt_from_cheque_inventory($main_receipt_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn,"SELECT * FROM main_receipt WHERE main_receipt_no='$main_receipt_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		mysqli_select_db ($conn, $dbname );
		$query = "UPDATE cheque_inventory SET
	cancel_status='1'
	WHERE rec_ref='$main_receipt_no' AND che_no='$row[cheque_no]' AND rec_type='MAIN RECEIPT'";
		mysqli_query ($conn, $query );
	}
	
	
}
function get_cheque_info($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE rec_ref='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		return $row;
	}
	

}
function get_cheque_info_id($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE id='$id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	

}
function get_main_receipt_cheque_info($main_receipt_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM cheque_inventory WHERE rec_ref='$main_receipt_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		return $row;
	}
	

}
function save_main_paybill_in_cheque_inventory($main_paybill_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $payee_to) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$status = 'UNPRESENTED';
	$type = 'MAIN PAYBILL';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO cheque_inventory (rec_ref, rec_date, che_amount, che_no, che_bank, che_branch, che_date, status, rec_type, customer)
	VALUES ('$main_paybill_no', '$date', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$status', '$type', '$payee_to')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function delete_main_paybill_from_cheque_inventory($main_paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM main_paybill WHERE main_paybill_no='$main_paybill_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		mysqli_select_db ($conn, $dbname );
		$query = "UPDATE cheque_inventory SET
	cancel_status='1'
	WHERE rec_ref='$main_paybill_no' AND che_no='$row[cheque_no]' AND rec_type='MAIN PAYBILL'";
		mysqli_query ($conn, $query );
	}
	

}
function save_paybill_in_cheque_inventory($paybill_no, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $date, $customer) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$status = 'UNPRESENTED';
	$type = 'PAYBILL';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO cheque_inventory (rec_ref, rec_date, che_amount, che_no, che_bank, che_branch, che_date, status, rec_type, customer)
	VALUES ('$paybill_no', '$date', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$status', '$type', '$customer')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function delete_paybill_from_cheque_inventory($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM paybill WHERE paybill_no='$paybill_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		mysqli_select_db ($conn, $dbname );
		$query = "UPDATE cheque_inventory SET
	cancel_status='1'
	WHERE rec_ref='$paybill_no' AND che_no='$row[cheque_no]' AND rec_type='PAYBILL'";
		mysqli_query ($conn, $query );
	}
	

}
function list_cheque_not_realised($statement_date, $account) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result2 = mysqli_query ($conn, "SELECT DISTINCT che_date FROM cheque_inventory WHERE status='DEPOSITED' AND dep_date <= '$statement_date' AND dep_account_no='$account' AND cancel_status='0' ORDER BY che_date ASC" );
	while ( $row2 = mysqli_fetch_array ( $result2, MYSQLI_ASSOC ) ) {
		$che_date = $row2 ['che_date'];
		
		echo '<br /><h1>' . $che_date . '</h1><br/>';
		echo '<div class="table-responsive">
              <table class="table">
                  <thead>
	<tr>
	<th>Realise</th>
	<th>Return</th>
	<th>Status</th>
	<th>Cheque No</th>
	<th>Amount</th>
	<th>Receipt No</th>
	<th>Receipt Type</th>
	<th>Bank</th>
	<th>Branch</th>
	<th>Date</th>
	</tr>
	</thead>
	<tbody>
	';
		
		$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE status='DEPOSITED' AND che_date = '$che_date' AND cancel_status='0' ORDER BY che_date ASC" );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			$che_amount = number_format ( $row [che_amount], 2 );
			
			$type = "receipt";
			$type_job = "view_receipt";
			$type_no = "rec_no";
			$type_name = "Receipt";
			
			echo '
			<form name="realise_cheque_' . $row [id] . '" action="cheque.php?job=realise_cheque&id=' . $row [id] . '"	method="post">
			<tr>

			<td>
			<input	type="submit" name="ok" value="REALISE" class="btn btn-danger"/>
			</td>

			<td>
			<input	type="submit" name="ok" value="RETURN" class="btn btn-danger" />
			</td>
		
			<td id="amount_td">
			' . $row [status] . '
			</td>
		
			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '" target="_blank">' . $row [che_no] . '</a>
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
	echo '</tbody>
          </table>';
	

}
function list_realised_cheques() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
	<tr>
	<th>Remove</th>
	<th>Cheque No</th>
	<th>Amount</th>
	<th>Receipt No</th>
	<th>Receipt Type</th>
	<th>Bank</th>
	<th>Branch</th>
	<th>Date</th>
	<th>Deposit Date</th>
	<th>Deposit Bank</th>
	</tr>
	</thead>
	<tbody>
	';
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE status='REALISED' AND cancel_status='0' ORDER BY che_date ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$che_amount = number_format ( $row [che_amount], 2 );
		
		$type = "receipt";
		$type_job = "view_receipt";
		$type_no = "rec_no";
		$type_name = "Receipt";
		echo '
			<form name="return_cheque_' . $row [id] . '" action="cheque.php?job=cancel_realised_cheque&id=' . $row [id] . '"	method="post">
			<tr>

			<td>
			<input	type="submit" name="ok" value="CANCLE" class="btn btn-danger" />
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '" target="_blank">' . $row [che_no] . '</a>
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
		
			<td>
			' . $row [dep_date] . '
			</td>
		
			<td>
			' . $row [dep_account_no] . '
			</td>
			</tr>
			</form>';
	}
	echo '</tbody>
          </table>
          </div>';
	

}
function list_returned_cheques() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
	<tr>
	<th>Remove</th>
	<th>Cheque No</th>
	<th>Amount</th>
	<th>Receipt No</th>
	<th>Receipt Type</th>
	<th>Bank</th>
	<th>Branch</th>
	<th>Date</th>
	<th>Deposit Date</th>
	<th>Deposit Bank</th>
	</tr>
	</thead>
	<tbody>
	';
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE status='RETURN' AND cancel_status='0' ORDER BY che_date ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$che_amount = number_format ( $row [che_amount], 2 );
		
		$type = "receipt";
		$type_job = "view_receipt";
		$type_no = "rec_no";
		$type_name = "Receipt";
		
		echo '
			<form name="return_cheque_' . $row [id] . '" action="cheque.php?job=cancel_return_cheque&id=' . $row [id] . '"	method="post">
			<tr>

			<td>
			<input	type="submit" name="ok" value="CANCLE" class="btn btn-danger"/>
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '" target="_blank">' . $row [che_no] . '</a>
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
		
			<td>
			' . $row [dep_date] . '
			</td>
		
			<td>
			' . $row [dep_account_no] . '
			</td>
			</tr>
			</form>';
	}
	echo '</tbody>
          </table>
          </div>';
	

}
function realise_cheque($id, $statement_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cheque_inventory SET
	status='REALISED',
	real_date='$statement_date'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	add_ledger_cheque_deposit ( $id );
}
function return_cheque($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cheque_inventory SET
	status='RETURN',
	real_date='0'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	return_cheque_ledger ( $id );
	

}
function cancel_realised_cheque($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cheque_inventory SET
	status='DEPOSITED',
	real_date='0'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	

}
function cancel_return_cheque($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cheque_inventory SET
	status='DEPOSITED',
	real_date='0'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	cancel_return_cheque_ledger ( $id );

}
function return_cheque_ledger($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE id='$id' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$date = $row ['dep_date'];
		$flag = 'CHEQUE RETURN';
		$rec_ref = $ref_no = $row ['rec_ref'];
		$customer = addslashes ( $row ['customer'] );
		$che_amount = $row ['che_amount'];
		$che_no = $row ['che_no'];
		$dep_bank = $row ['dep_account_no'];
		$job_no = '';
		
		mysqli_select_db ($conn, $dbname );
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
		VALUES ('$dep_bank', '$date', '$flag', '$ref_no', '$customer', '', '$che_amount', '$che_no')";
		mysqli_query ($conn, $query1 ) or die ( mysqli_connect_error () );
		
		mysqli_select_db ($conn, $dbname );
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
		VALUES ('$customer', '$date', '$flag', '$ref_no', '$dep_bank', '$che_amount', '', '$che_no')";
		mysqli_query ($conn, $query2 ) or die ( mysqli_connect_error () );
	}
}
function list_specify_cheque($statement_date, $che_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
	<tr>
	<th>Deposit</th>
	<th>Cheque No</th>
	<th>Amount</th>
	<th>Status</th>
	<th>Receipt No</th>
	<th>Receipt Type</th>
	<th>Bank</th>
	<th>Branch</th>
	<th>Date</th>
	</tr>
	</thead>
	<tbody>
	';
	
	$result = mysqli_query ($conn, "SELECT * FROM cheque_inventory WHERE status!='RECEIVED' AND che_date = '$che_date' AND cancel_status='0' ORDER BY che_date ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$che_amount = number_format ( $row [che_amount], 2 );
		
		$type = "receipt";
		$type_job = "view_receipt";
		$type_no = "rec_no";
		$type_name = "Receipt";
		
		echo '
			<form name="realise_cheque_' . $row [id] . '" action="cheque.php?job=realise_cheque&id=' . $row [id] . '"	method="post">
			<tr>

			';
		if ($row [status] == "DEPOSITED") {
			echo '<td>
			<input	type="submit" name="ok" value="REALISE" />
			</td>
			<td>
			<input	type="submit" name="ok" value="RETURN" />
			</td>';
		} elseif ($row [status] == "REALISED") {
			echo '<td>
			</td>
			<td>
			<input	type="submit" name="ok" value="RETURN" />
			</td>';
		} elseif ($row [status] == "RETURN") {
			echo '<td>
			<input	type="submit" name="ok" value="REALISE" />
			</td>
			<td>
			</td>';
		}
		
		echo '<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '" target="_blank">' . $row [che_no] . '</a>
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
	
	echo '</tbody>
          </table>
          </div>';
	

}
function cancel_return_cheque_ledger($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM cheque_inventory WHERE id='$id' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$flag = 'CHEQUE RETURN';
		$rec_ref = $ref_no = $row ['rec_ref'];
		$che_no = $row ['che_no'];
	}
	
	mysqli_select_db ( $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='CHEQUE RETURN' AND ref_no ='$ref_no' AND cheque_no='$che_no' AND cancel_status='0'";
	mysqli_query ( $query );
}