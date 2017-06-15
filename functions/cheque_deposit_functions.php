<?php
function list_receipt_not_deposit($deposit_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result2 = mysqli_query ( $conn, "SELECT DISTINCT che_date FROM cheque_inventory WHERE status='RECEIVED' AND che_date <= '$deposit_date' AND cancel_status='0' ORDER BY che_date ASC" );
	while ( $row2 = mysqli_fetch_array ( $result2, MYSQLI_ASSOC ) ) {
		$che_date = $row2 ['che_date'];
		
		echo '<h1>' . $che_date . '</h1>';
		echo '<div class="table-responsive">
               <table id="example1" class="table table-bordered table-striped">
                  <thead>
					<tr>
					<th>Deposit</th>
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
		
		$result = mysqli_query ($conn, "SELECT * FROM cheque_inventory WHERE status='RECEIVED' AND che_date = '$che_date' AND cancel_status='0' ORDER BY che_date ASC" );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			$che_amount = number_format ( $row [che_amount], 2 );
			
			$type = "receipt";
			$type_job = "view_receipt";
			$type_no = "rec_no";
			$type_name = "Receipt";
			
			echo '
			<form name="deposit_cheque_' . $row [id] . '" action="cheque_deposit.php?job=deposit_cheque&id=' . $row [id] . '"	method="post">
			<tr>

			<td>
			<input	type="submit" name="ok" value="Deposit" class="btn btn-danger" />
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '" class="btn btn-danger">' . $row [che_no] . '</a>
			</td>

			<td id="amount_td">
			' . $che_amount . '
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '" class="btn btn-danger">' . $row [rec_ref] . '</a>
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
          </table>
          </div>';
	

}
function list_receipt_deposit() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
               <table id="example1" class="table table-bordered table-striped">
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
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE status='DEPOSITED' AND cancel_status='0' ORDER BY che_date ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$che_amount = number_format ( $row [che_amount], 2 );
		
		$type = "receipt";
		$type_job = "view_receipt";
		$type_no = "rec_no";
		$type_name = "Receipt";
		
		echo '
			<form name="remove_receipt_' . $row [id] . '" action="cheque_deposit.php?job=remove_receipt&id=' . $row [id] . '"	method="post">
			<tr>

			<td>
			<input	type="submit" name="ok" value="Remove" class="btn btn-danger" />
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . 'class="btn btn-danger">' . $row [che_no] . '</a>
			</td>

			<td id="amount_td">
			' . $che_amount . '
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . 'class="btn btn-danger">' . $row [rec_ref] . '</a>
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
			' . $row [dep_account_no] . '
			</td>

			<td>
			' . $row [dep_date] . '
			</td>
			</tr>
			</form>';
	}
	echo '</tbody>
          </table>
          </div>';
	

}
function deposit_receipt_cheque($id, $deposit_date, $account) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo "$id";
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cheque_inventory SET
	status='DEPOSITED',
	dep_date='$deposit_date',
	dep_account_no='$account'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	add_ledger_cheque_deposit ( $id );
}
function remove_receipt($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE cheque_inventory SET
	status='RECEIVED',
	dep_date='0',
	dep_account_no='0'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	$result = mysqli_query ($conn, "SELECT * FROM cheque_inventory WHERE id='$id' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$rec_ref = $row [rec_ref];
	}
	
	delete_cheque_deposit_ledger ( $rec_ref );
	

}
function list_specify_cheque($deposit_date, $che_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<br /><h1>' . $che_date . '</h1><br />';
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
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
	
	$result = mysqli_query ( $conn, "SELECT * FROM cheque_inventory WHERE che_no = '$che_no' AND cancel_status='0' ORDER BY che_date ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$che_amount = number_format ( $row [che_amount], 2 );
		
		$type = "receipt";
		$type_job = "view_receipt";
		$type_no = "rec_no";
		$type_name = "Receipt";
		
		echo '
			<form name="deposit_cheque_' . $row [id] . '" action="cheque_deposit.php?job=deposit_cheque&id=' . $row [id] . '"	method="post">
			<tr>';
		
		if ($row [status] == RECEIVED) {
			
			echo '<td>
			<input	type="submit" name="ok" value="Deposit" class="btn btn-danger" />
			</td>';
		} else {
			echo '<td></td>';
		}
		echo ' <td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . '" target="blank">' . $row [che_no] . '</a>
			</td>

			<td id="amount_td">
			' . $che_amount . '
			</td>
			
			<td>
			' . $row [status] . '
			</td>

			<td>
			<a href="' . $type . '.php?job=' . $type_job . '&' . $type_no . '=' . $row [rec_ref] . 'class="btn btn-danger">' . $row [rec_ref] . '</a>
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



