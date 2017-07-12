<?php
function customer_receipt_detail($customer_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$i = 1;
	

	
	$result = mysqli_query ($conn, "SELECT * FROM invoice WHERE customer_id='$customer_id' AND due > 0 AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($i == 1) {
			echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr class="success">
							<th>Invoice No</th>
							<th>Invoice Date</th>
							<th>Invoice Type</th>
							<th>Amount </th>
							<th>Paid </th>
							<th>Add</th>
							</tr>
							</thead>
							<tbody>';
		} 

		else {
		}
		
		echo '
	<form name="add_invoice_' . $row [invoice_no] . '" action="receipt.php?job=add_invoice&invoice_no=' . $row [invoice_no] . '"	method="post">
		<tr>

		<td><a href="#" class="btn btn-info" data-toggle="modal" data-target="#' . $row [invoice_no] . '">
		' . $row [invoice_no] . '</a>
		</td>
			
		<td>
		 ' . $row [invoice_date] . '
		 </td>
		 		
		 <td>
		 ' . $row [type] . '
		 </td>
		 	
		<td>
		' . $row [due] . '
		</td>
			
		<td>
		<input class="form-control" type="text" name="paid" value="' . $row [due] . '" /> 
		</td>
			<td>
		<input class="btn btn-info" type="submit" name="ok" value="Add" />
		
		</td>	
		</tr>
		
		</form>	
				
			<div class="modal fade" id="' . $row [invoice_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [invoice_no] . '" aria-hidden="true">
				<div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			      </div>
			      <div class="modal-body">
			      	<iframe src="invoice.php?job=view&invoice_no=' . $row [invoice_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
				  </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>';
		
		$i ++;
	}
	
	echo '</tbody></table></div>';
}
function update_invoice_due($invoice_no, $paid) {
	$invoice_info = get_invoice_info ( $invoice_no );
	$due = $invoice_info ['due'] - $paid;
	$update_paid = $invoice_info ['paid'] + $paid;
	$update_rec_status = $invoice_info ['rec_status'] + 1;
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE invoice SET
	paid='$update_paid',
	rec_status='$update_rec_status',
	due='$due'
	WHERE invoice_no='$invoice_no'";
	mysqli_query ($conn, $query );
	
	
}
function save_receipt_invoice_in_temp_table($invoice_no, $random_no, $paid, $user_name) {
	$invoice_info = get_invoice_info ( $invoice_no );
	$job_no = $invoice_info ['job_no'];
	$job_type = $invoice_info ['job_type'];
	$hawb_no = $invoice_info ['hawb_no'];
	$invoice_date = $invoice_info ['invoice_date'];
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO temp_receipt_has_invoice (amount, invoice_no, random_no, invoice_date, user_name)
	VALUES ('$paid', '$invoice_no', '$random_no', '$invoice_date', '$user_name')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function list_receipt_invoices($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table id="example1"  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
						    <th>Invoice No</th>
						    <th>Invoice Date</th>
						    <th>Paid</th>
						    <th>Remove</th>
					    </tr>
					  </thead>
					  <tbody>';
	
	$result = mysqli_query ($conn, "SELECT * FROM temp_receipt_has_invoice WHERE random_no='$random_no' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '
		<tr>
		<td>' . $row [invoice_no] . '</td>
		<td>' . $row [invoice_date] . '</td>
		<td>' . $row [amount] . '</td>
		<td><a href="receipt.php?job=delete_invoice&id='.$row [id].'&invoice_no=' . $row [invoice_no] . '" ><i class="fa fa-times fa-2x"></i></a></td>
		</tr>';
	}
	
	echo '<tr class="danger">
	<td><strong>Total</strong></td>
	<td></td>
	<td><span id="total"><strong>'.get_receipt_invoice_total($random_no).'</strong></span></td>
	<td></td>
	</tr>';
	
	echo '</tbody></table></div>';
	
	
}
function get_receipt_invoice_total($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT SUM(amount) FROM temp_receipt_has_invoice WHERE random_no='$random_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$total = $row ['SUM(amount)'];
	}
	
	return $total;
	
	
}
function delete_receipt_invoice_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "DELETE FROM temp_receipt_has_invoice WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}
function get_receipt_invoice_info_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM temp_receipt_has_invoice WHERE id='$id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
	
}
function update_invoice_after_delete_temp($invoice_no, $paid, $due, $rec_status) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE invoice SET
	paid='$paid',
	due='$due',
	rec_status='$rec_status'
	WHERE invoice_no='$invoice_no'";
	mysqli_query ($conn, $query );
	
	
}
function get_receipt_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(rec_no) FROM receipt " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(rec_no)'] + 1;
	}
	
	
}
function save_receipt($rec_no, $customer_name, $customer_id, $date, $remarks, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $card_amount, $card_bank, $card_no, $exp_date, $card_dep_no, $bank, $dep_amount, $dep_date, $dep_no, $mobile, $ref_no, $ez_amount, $cash_amount, $total, $saved_by) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO receipt (rec_no, customer_name, customer_id, date, remarks, cheque_amount, cheque_no, cheque_bank, cheque_branch, cheque_date, card_amount, card_bank, card_no, exp_date, card_dep_no, bank, dep_amount, dep_date, dep_no, mobile, ref_no, ez_amount, cash_amount, total, saved_by, branch)
	VALUES ('$rec_no', '$customer_name', '$customer_id', '$date', '$remarks', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$card_amount', '$card_bank', '$card_no', '$exp_date', '$card_dep_no', '$bank', '$dep_amount', '$dep_date', '$dep_no', '$mobile', '$ref_no', '$ez_amount', '$cash_amount', '$total', '$saved_by', '$_SESSION[branch]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function transfer_invoice($random_no, $rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM temp_receipt_has_invoice WHERE random_no='$random_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$invoice_no = $row ['invoice_no'];
		$amount = $row ['amount'];
		$invoice_date = $row ['invoice_date'];
		$user_name = $row ['user_name'];
		
		mysqli_select_db ( $dbname );
		$query = "INSERT INTO receipt_has_invoice (rec_no, invoice_no, invoice_date, user_name, amount)
		VALUES ('$rec_no', '$invoice_no', '$invoice_date', '$user_name', '$amount')";
		mysqli_query ( $query ) or die ( mysqli_connect_error () );
	}
	
	
}
function delete_temp_data($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "DELETE FROM temp_receipt_has_invoice WHERE random_no='$random_no'";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function get_receipt_has_invoice_info($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM receipt_has_invoice WHERE rec_no='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function list_receipt() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                <thead>
                    <tr class="danger" style="font-weight: bold;">
                        <td>Print</td>
                        <td>View</td>
                        <td>Cancel</td>
                        <td>No</td>	
                        <td>Customer</td>
                        <td align="right">Cheque</td>
                        <td align="right">Bank</td>
                        <td align="right">Cash</td>
                        <td align="right">Card</td>
                        <td align="right">Ez Cash</td>
                        <td align="right">Total</td>
                    </tr>
                    </thead>
                    <tbody>';
	
	$today = date ( "Y-m-d" );
	$total = 0;
	$branch = $_SESSION ['branch'];
	
	if ($branch == "Head Office") {
		$branch_check = "";
	} else {
		$branch_check = "AND branch LIKE '%$branch%'";
	}
	$result = mysqli_query ($conn, "SELECT * FROM receipt WHERE cancel_status='0' AND date='$today' $branch_check ORDER BY id LIMIT 50" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '
		<tr>
		
		<td>
		<a href="receipt.php?job=view_receipt&rec_no=' . $row [rec_no] . '" target="blank"><i class="fa fa-print fa-lg"></i></a>
		</td>
				
		<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [rec_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>
		
		<td>
		<a href="receipt.php?job=delete_receipt&rec_no=' . $row [rec_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a>
		</td>
				
		<td>
		' . $row [rec_no] . '
		</td>
		
		<td>
		 ' . $row [customer_name] . '
		</td>

		 <td align="right">
		 ' . $row [cheque_amount] . '
		</td>

		<td align="right">
		 ' . $row [dep_amount] . '
		</td>
								
		 <td align="right">
		 ' . $row [cash_amount] . '
		</td>
		 		
		 <td align="right">
		 ' . $row [card_amount] . '
		</td>
		 		
		 <td align="right">
		 ' . $row [ez_amount] . '
		</td>
					
		 <td align="right">
		 ' . $row [total] . '
		</td>
			
		 
	
		</tr>
		<div class="modal fade" id="' . $row [rec_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [rec_no] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">RECEIPT
			      </div>
			      <div class="modal-body">
			        <iframe src="receipt.php?job=transaction&rec_no=' . $row [rec_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>	  
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>';
		$total = $total + $row ['total'];
	}
	
	$formated = number_format ( $total, 2 );
	
	echo '<tr>
		<td colspan="9" align="right"><strong></strong></td>
		<td align="right" class="danger"><strong>Today Total</strong></td>
					
		 <td align="right" class="danger">
		 <strong>' . $formated . '</strong>
		</td>
	
		</tr></tbody></table></div>';
	
	
}
function search_receipt($rec_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($rec_no) {
		$rec_no_check = "AND rec_no LIKE '%$rec_no%'";
	} else {
		$rec_no_check = "";
	}
	
	if ($customer) {
		$customer_check = "AND customer_name LIKE '%$customer%'";
	} else {
		$customer_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}
	
	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                    <thead>
                    <tr>
                        <td>Print</td>
                        <td>View</td>
                        <td>Cancel</td>
                        <td>No</td>
                        <td>Customer</td>
                        <td align="right">Cheque</td>
                        <td align="right">Bank</td>
                        <td align="right">Cash</td>
                        <td align="right">Card</td>
                        <td align="right">Ez Cash</td>
                        <td align="right">Total</td>
                    </tr>
                    </thead>
                    <tbody>';
	
	$today = date ( "Y-m-d" );
	$total = 0;
	$branch = $_SESSION ['branch'];
	
	if ($branch == "Head Office") {
		$branch_check = "";
	} else {
		$branch_check = "AND branch LIKE '%$branch%'";
	}
	
	$result = mysqli_query ($conn, "SELECT * FROM receipt WHERE cancel_status='0' $rec_no_check $customer_check $date_check $branch_check ORDER BY id DESC $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '
		<tr>

		<td>
		<a href="receipt.php?job=view_receipt&rec_no=' . $row [rec_no] . '" target="blank"><i class="fa fa-print fa-lg"></i></a>
		</td>

		<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [rec_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>

		<td>
		<a href="receipt.php?job=delete_receipt&rec_no=' . $row [rec_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a>
		</td>

		<td>
		' . $row [rec_no] . '
		</td>

		<td>
		 ' . $row [customer_name] . '
		</td>

		 <td align="right">
		 ' . $row [cheque_amount] . '
		</td>

		<td align="right">
		 ' . $row [dep_amount] . '
		</td>

		 <td align="right">
		 ' . $row [cash_amount] . '
		</td>
		 
		 <td align="right">
		 ' . $row [card_amount] . '
		</td>
		 
		 <td align="right">
		 ' . $row [ez_amount] . '
		</td>
			
		 <td align="right">
		 ' . $row [total] . '
		</td>
		
		

		</tr>
		<div class="modal fade" id="' . $row [rec_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [rec_no] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">RECEIPT
			      </div>
			      <div class="modal-body">
			        <iframe src="receipt.php?job=transaction&rec_no=' . $row [rec_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>';
		$total = $total + $row ['total'];
	}
	
	$formated = number_format ( $total, 2 );
	
	echo '<tr>
		<td colspan="9" align="right"><strong></strong></td>
		<td align="right" class="danger"><strong>Today Total</strong></td>
			
		 <td align="right" class="danger">
		 <strong>' . $formated . '</strong>
		</td>

		</tr></tbody></table></div>';
}


function search_receipt_print($rec_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	if ($rec_no) {
		$rec_no_check = "AND rec_no LIKE '%$rec_no%'";
	} else {
		$rec_no_check = "";
	}

	if ($customer) {
		$customer_check = "AND customer_name LIKE '%$customer%'";
	} else {
		$customer_check = "";
	}

	if ($to_date && $from_date) {
		$date_check = "AND date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND date>='$from_date'";
		$limit = "";
	} elseif ($to_date) {
		$date_check = "AND date<='$to_date'";
		$limit = "";
	} else {
		$date_check = "";
		$limit = "LIMIT 50";
	}

	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	<tr class="danger" style="font-weight: bold;">

	
	<td>No</td>
	<td>Customer</td>
	<td align="right">Cheque</td>
	<td align="right">Bank</td>
	<td align="right">Cash</td>
	<td align="right">Card</td>
	<td align="right">Ez Cash</td>
	<td align="right">Total</td>
	</tr>';

	$today = date ( "Y-m-d" );
	$total = 0;
	$branch = $_SESSION ['branch'];

	if ($branch == "Head Office") {
		$branch_check = "";
	} else {
		$branch_check = "AND branch LIKE '%$branch%'";
	}

	$result = mysqli_query ($conn, "SELECT * FROM receipt WHERE cancel_status='0' $rec_no_check $customer_check $date_check $branch_check ORDER BY id DESC $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {

		echo '
		<tr>

		<td>
		' . $row [rec_no] . '
		</td>

		<td>
		 ' . $row [customer_name] . '
		</td>

		 <td align="right">
		 ' . $row [cheque_amount] . '
		</td>

		<td align="right">
		 ' . $row [dep_amount] . '
		</td>

		 <td align="right">
		 ' . $row [cash_amount] . '
		</td>
		
		 <td align="right">
		 ' . $row [card_amount] . '
		</td>
		
		 <td align="right">
		 ' . $row [ez_amount] . '
		</td>
		
		 <td align="right">
		 ' . $row [total] . '
		</td>



		</tr>
		<div class="modal fade" id="' . $row [rec_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [rec_no] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">RECEIPT
			      </div>
			      <div class="modal-body">
			        <iframe src="receipt.php?job=transaction&rec_no=' . $row [rec_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>';
		$total = $total + $row ['total'];
	}

	$formated = number_format ( $total, 2 );

	echo '<tr>
		<td colspan="6" align="right"><strong></strong></td>
		<td align="right" class="danger"><strong>Today Total</strong></td>
		
		 <td align="right" class="danger">
		 <strong>' . $formated . '</strong>
		</td>

		</tr></table></div>';

	
}


function cancel_receipt($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ( $dbname );
	$query = "UPDATE receipt SET
	cancel_status='1'
	WHERE rec_no='$rec_no'";
	
	mysqli_query ( $query );
	
	
}
function cancel_all_receipt_invoice($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE receipt_has_invoice SET
	cancel_status='1'
	WHERE rec_no='$rec_no'";
	
	mysqli_query ($conn, $query );
	
	
}
function roll_back_receipt_invoice($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM receipt_has_invoice WHERE cancel_status=0 AND rec_no='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$invoice_info = get_invoice_info ( $row ['invoice_no'] );
		$invoice_no = $row ['invoice_no'];
		
		$paid = $invoice_info ['paid'] - $row ['amount'];
		$due = $invoice_info ['due'] + $row ['amount'];
		$rec_status = $invoice_info ['rec_status'] - 1;
		
		mysqli_select_db ($conn, $dbname );
		$query = "UPDATE invoice SET
		paid='$paid',
		due='$due',
		rec_status='$rec_status'
		WHERE invoice_no='$invoice_no'";
		mysqli_query ($conn, $query );
	}
	
	
}
function delete_all_from_temp_for_this_user($user_name) {
	roll_back_receipt_invoice_by_user_name ( $user_name );
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "DELETE FROM temp_receipt_has_invoice WHERE user_name='$user_name'";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function roll_back_receipt_invoice_by_user_name($user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM temp_receipt_has_invoice WHERE user_name='$user_name'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$invoice_info = get_invoice_info ( $row ['invoice_no'] );
		$invoice_no = $row ['invoice_no'];
		$paid = $invoice_info ['paid'] - $row ['amount'];
		$due = $invoice_info ['due'] + $row ['amount'];
		$rec_status = $invoice_info ['rec_status'] - 1;
		
		mysqli_select_db ($conn, $dbname );
		$query = "UPDATE invoice SET
		paid='$paid',
		due='$due',
		rec_status='$rec_status'
		WHERE invoice_no='$invoice_no'";
		mysqli_query ($conn, $query );
	}
	
	
}
function get_receipt_info($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM receipt WHERE rec_no='$rec_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
	
}
function check_receipt_invoice($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn,  "SELECT count(id) FROM temp_receipt_has_invoice WHERE random_no='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['count(id)'] >= 1) {
			return 1;
		} else {
			return 0;
		}
	}
	
	
}
function receipt_get_invoice_no($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT invoice_no FROM receipt_has_invoice WHERE rec_no='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['invoice_no'];
	}
	
	
}
function list_receipt_invoice_no($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn,  "
	SELECT invoice_no 
	FROM receipt_has_invoice 
	WHERE rec_no='$rec_no'AND cancel_status='0'");
	
	$i = 1;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($i == 1) {
		} else {
			echo ", ";
		}
		echo "$row[invoice_no]";
		$i ++;
	}
	
	
}
function list_receipt_booking_no($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT invoice_no FROM receipt_has_invoice	WHERE rec_no='$rec_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$result1 = mysqli_query ( $conn, "SELECT ref_no FROM invoice WHERE invoice_no='$row[invoice_no]' AND cancel_status='0'" );
		$i = 1;
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			if ($i == 1) {
			} 

			else {
				echo ", ";
			}
			echo "$row1[ref_no]";
			$i ++;
		}
	}
	
	
}
function get_rec_print_count($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(print_count) FROM receipt WHERE rec_no='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(print_count)'] + 1;
	}
	
	
}
function update_rec_print_count($rec_no, $print_count) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ( $dbname );
	$query = "UPDATE receipt SET 
	print_count='$print_count'
	WHERE rec_no='$rec_no'";
	mysqli_query ( $query ) or die ( mysqli_connect_error () );
	
	
}
function list_receipt_invoices_view($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
  <thead>
    <tr class="success" style="font-weight: bold;">
    <td>Invoice No</td>
    <td>Invoice Date</td>
    <td>Ref No</td>
    <td>Ref Type</td>
	<td>Customer Name</td>
	<td align="right">Paid</td>
    </tr>
  </thead>
  <tbody>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM receipt_has_invoice WHERE rec_no='$rec_no' AND cancel_status='0' " );
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		
		$info = get_invoice_info ( $row [invoice_no] );
		$invoice_date = $info ['invoice_date'];
		
		echo '
		<tr>
		<td>' . $row [invoice_no] . '</td>
		<td>' . $invoice_date . '</td>
		<td>' . $info [ref_no] . '</td>
		<td>' . $info [type] . '</td>
		<td>' . $info [customer] . '</td>
		<td align="right">' . number_format ( ($row [amount]), 2 ) . '</td>
		
		</tr>
		';
	}
	
	echo '<tr>
	<td></td>
	<td></td>
	<td class="success" align="right"><strong>Total</strong></td>
	<td class="success" align="right"><strong>' . number_format ( (get_receipt_invoice_total_by_rec_no ( $rec_no )), 2 ) . '</strong></td>
	
	
	</tr>';
	
	echo '</tbody></table></div>';
	
	
}
function get_receipt_invoice_total_by_rec_no($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT SUM(amount) FROM receipt_has_invoice WHERE rec_no='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		$total = $row ['SUM(amount)'];
	}
	
	return $total;
	
	
}
function get_reciept_job_no($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT invoice.job_no FROM invoice, receipt_has_invoice WHERE receipt_has_invoice.rec_no='$rec_no' AND receipt_has_invoice.invoice_no=invoice.invoice_no" );
	
	$job_nos = '';
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		if ($job_nos == '') {
			
			$job_nos = $row [job_no];
		} 

		else {
			
			$job_nos = $job_nos . ', ' . $row [job_no];
		}
	}
	
	return $job_nos;
	
	
}
