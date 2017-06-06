<?php
function customer_paybill_detail($customer_id, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($to_date && $from_date) {
		$date_check = "AND voucher_date BETWEEN '$from_date' AND '$to_date'";
		$date_check2 = "AND other_expenses_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND voucher_date>='$from_date'";
		$date_check2 = "AND other_expenses_date>='$from_date'";
	} elseif ($to_date) {
		$date_check = "AND voucher_date<='$to_date'";
		$date_check2 = "AND other_expenses_date<='$to_date'";
	} else {
		$date_check = "";
		$date_check2 = "";
	}
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
				<tr class="danger" style="font-weight: bold;">
					<td>Ref No</td>
					<td>Date</td>
					<td colspan="2">Type</td>
					<td>Amount</td>
					<td>Paid</td>
   					<th>Add</th>
				</tr>';
	
	$result = mysqli_query ($conn, "SELECT * FROM voucher WHERE customer_id='$customer_id' AND due > 0.00 AND cancel_status='0' $date_check" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '<form name="add_voucher_' . $row [voucher_no] . '" action="paybill.php?job=add_voucher&voucher_no=' . $row [voucher_no] . '&type=VOUCHER" method="post">
		<tr>

		<td><a href="#" class="btn btn-info" data-toggle="modal" data-target="#' . $row [voucher_no] . '">
		' . $row [voucher_no] . '</a>
		</td>
			
		<td>
		 ' . $row [voucher_date] . '
		 </td>
		 		
		 <td>EXCHANGE ORDER</td>
		 <td>TICKET</td>
		 	
		<td class="info">
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
				
			<div class="modal fade" id="' . $row [voucher_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [voucher_no] . '" aria-hidden="true">
				<div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			      </div>
			      <div class="modal-body">
			      	<iframe src="voucher.php?job=view&voucher_no=' . $row [voucher_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
				  </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>	';
	}
	
	$result1 = mysqli_query ($conn, "SELECT * FROM other_expenses WHERE customer_id='$customer_id' AND due > 0.00 AND cancel_status='0' $date_check2" );
	while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
		
		echo '<form name="add_other_expenses_' . $row1 [other_expenses_no] . '" action="paybill.php?job=add_voucher&voucher_no=' . $row1 [other_expenses_no] . '&type=OTHER EXPENSES" method="post">
		<tr>
		
		<td><a href="#" class="btn btn-info" data-toggle="modal" data-target="#other_expenses' . $row1 [other_expenses_no] . '">
		' . $row1 [other_expenses_no] . '</a>
		</td>
		
		<td>
		 ' . $row1 [other_expenses_date] . '
		 </td>
		 
		 <td>OTHER EXPENSES</td>
		
		<td>
		 ' . $row1 [ref_type] . '
		 </td>
		
		<td class="success">
		' . $row1 [due] . '
		</td>
		
		<td>
		<input class="form-control" type="text" name="paid" value="' . $row1 [due] . '" />
		</td>
			<td>
		<input class="btn btn-info" type="submit" name="ok" value="Add" />
		
		</td>
		</tr>
		
		</form>
		
			<div class="modal fade" id="other_expenses' . $row1 [other_expenses_no] . '" tabindex="-1" role="dialog" aria-labelledby="other_expenses' . $row1 [other_expenses_no] . '" aria-hidden="true">
				<div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			      </div>
			      <div class="modal-body">
			      	<iframe src="other_expenses.php?job=view&other_expenses_no=' . $row1 [other_expenses_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
				  </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>	';
	}
	
	echo '</tbody></table>';
}
function update_voucher_due($voucher_no, $paid) {
	$voucher_info = get_voucher_info ( $voucher_no );
	
	$due = $voucher_info ['due'] - $paid;
	$update_paid = $voucher_info ['paid'] + $paid;
	$update_paybill_status = $voucher_info ['pay_status'] + 1;
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE voucher SET
	paid='$update_paid',
	pay_status='$update_paybill_status',
	due='$due'
	WHERE voucher_no='$voucher_no'";
	mysqli_query ($conn, $query );
	
	
}
function update_other_expense_due($voucher_no, $paid) {
	$info = get_other_expenses_info ( $voucher_no );
	
	$due = $info ['due'] - $paid;
	$update_paid = $info ['paid'] + $paid;
	$update_paybill_status = $info ['pay_status'] + 1;
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE other_expenses SET
	paid='$update_paid',
	pay_status='$update_paybill_status',
	due='$due'
	WHERE other_expenses_no='$voucher_no'";
	mysqli_query ($conn, $query );
	
	
}
function save_paybill_voucher_in_temp_table($voucher_no, $type, $random_no, $paid, $user_id) {
	if ($type == "VOUCHER") {
		$info = get_voucher_info ( $voucher_no );
		$date = $info ['voucher_date'];
	} else {
		$info = get_other_expenses_info ( $voucher_no );
		$date = $info ['other_expenses_date'];
	}
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO temp_paybill_has_voucher (amount, ref_no, ref_type, random_no, date, user_id)
	VALUES ('$paid', '$voucher_no', '$type', '$random_no', '$date', '$user_id')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function list_paybill_vouchers($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
				<tr class="danger" style="font-weight: bold;">
					<td>Ref No</td>
					<td>Date</td>
					<td>Type</td>
					<td>Paid</td>
   					<th>Remove</th>
				</tr>';
	
	$result = mysqli_query ($conn, "SELECT * FROM temp_paybill_has_voucher WHERE random_no='$random_no' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '
		<tr>
		<td>' . $row [ref_no] . '</td>		
		<td>' . $row [date] . '</td>
		<td>' . $row [ref_type] . '</td>		
		<td class="success">' . $row [amount] . '</td>
		<td><a href="paybill.php?job=delete_voucher&id=' . $row [id] . '&voucher_no=' . $row [ref_no] . '&type=' . $row [ref_type] . '" ><i class="fa fa-times fa-2x"></i></a></td>
		</tr>';
	}
	
	echo '<tr>
			<td></td>
			<td></td>
			<td class="danger"><strong>Total</strong></td>
			<td class="danger"><span id="total"><strong>' . get_paybill_voucher_total ( $random_no ) . '</strong></span></td>
			<td></td>
			</tr>';
	
	echo '</tbody></table></div>';
	
	
}
function get_paybill_voucher_total($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT SUM(amount) FROM temp_paybill_has_voucher WHERE random_no='$random_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$total = $row ['SUM(amount)'];
	}
	
	return $total;
	
	
}
function delete_paybill_voucher_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "DELETE FROM temp_paybill_has_voucher WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}
function get_paybill_voucher_info_from_temp($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM temp_paybill_has_voucher WHERE id='$id'" );
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) 

	{
		return $row;
	}
	
	
}
function update_voucher_after_delete_temp($voucher_no, $paid, $due, $pay_status, $table) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$no = $table . '_no';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE $table SET
	paid='$paid',
	due='$due',
	pay_status='$pay_status'
	WHERE $no='$voucher_no'";
	mysqli_query ($conn, $query );
	
	
}
function get_paybill_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(paybill_no) FROM paybill " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(paybill_no)'] + 1;
	}
	
	
}
function check_paybill_voucher($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT count(id) FROM temp_paybill_has_voucher WHERE random_no='$random_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['count(id)'] >= 1) {
			return 1;
		} else {
			return 0;
		}
	}
	
	
}
function save_paybill($paybill_no, $customer_name, $customer_id, $date, $remarks, $cheque_amount, $cheque_no, $cheque_bank, $cheque_branch, $cheque_date, $card_amount, $card_bank, $card_no, $exp_date, $bank, $from_bank, $dep_amount, $dep_date, $with_no, $mobile, $ref_no, $ez_amount, $cash_amount, $total, $saved_by) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO paybill (paybill_no, customer_name,  customer_id, date, remarks, cheque_amount, cheque_no, cheque_bank, cheque_branch, cheque_date, card_amount, card_bank, card_no, exp_date, bank, from_bank, dep_amount, dep_date, with_no, mobile, ref_no, ez_amount, cash_amount, total, saved_by, branch)
	VALUES ('$paybill_no', '$customer_name', '$customer_id', '$date', '$remarks', '$cheque_amount', '$cheque_no', '$cheque_bank', '$cheque_branch', '$cheque_date', '$card_amount', '$card_bank', '$card_no', '$exp_date', '$bank', '$from_bank', '$dep_amount', '$dep_date', '$with_no', '$mobile', '$ref_no', '$ez_amount', '$cash_amount', '$total', '$saved_by', '$_SESSION[branch]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function transfer_voucher($random_no, $paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM temp_paybill_has_voucher WHERE random_no='$random_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$ref_no = $row ['ref_no'];
		$amount = $row ['amount'];
		$ref_type = $row ['ref_type'];
		
		mysqli_select_db ($conn, $dbname );
		$query = "INSERT INTO paybill_has_voucher (paybill_no, ref_no, amount, ref_type)
		VALUES ('$paybill_no', '$ref_no', '$amount', '$ref_type')";
		mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	}
	
	
}
function delete_temp_data($random_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "DELETE FROM temp_paybill_has_voucher WHERE random_no='$random_no'";
	
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function get_paybill_has_voucher_info($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM paybill_has_voucher WHERE rec_no='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function list_paybill() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<table id="bl_list" border="1">
	<thead>
	
	<th>paybill</th>
	<th>paybill #</th>
	<th>Transaction</th>
	<th>Job No</th>
	<th>customer</th>
	<th>Cheque Amount (USD)</th>
	<th>Cheque No</th>
	<th>Bank</th>
	<th>Cheque Date</th>
	<th>Cash Amount (USD)</th>
	<th>Date</th>
	<th>Cancel</th>
	</thead>
	<tbody>';
	
	$result = mysqli_query ($conn, "SELECT * FROM paybill WHERE cancel_status=0 ORDER BY id DESC LIMIT 30" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$job_nos = list_ledger_paybill_job_no ( $row [paybill_no] );
		
		echo '
		<tr>
		
		<td>
		<a href="paybill.php?job=view_print_paybill&paybill_no=' . $row [paybill_no] . '" target="blank" ><img src="img/print.png" alt="Print" /></a>
		</td>
		
		

		<td>
		' . $row [paybill_no] . '
		</td>
		<td>
		<a href="paybill.php?job=transaction&paybill_no=' . $row [paybill_no] . '&keepThis=true&TB_iframe=true&height=500&width=800" title="Paybill" class="smoothbox""  >VIEW</a>
		</td>
			<td>
		' . $job_nos . '
		</td>
			<td>
		 ' . $row [customer] . '
		</td>
					<td class="info">
		 ' . $row [cheque_amount] . '
		</td>
					<td>
		 ' . $row [cheque_no] . '
		</td>
					<td>
		 ' . $row [cheque_bank] . '
		</td>
						<td>
		 ' . $row [cheque_date] . '
		</td>
						<td class="info">
		 ' . $row [cash_amount] . '
		</td>
					<td>
		 ' . $row [date] . '
		</td>
				<td>
		<a href="paybill.php?job=delete_paybill&paybill_no=' . $row [paybill_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><img src="img/delete.png" alt="Delete" /></a>
		</td>
	
		</tr>
		';
	}
	
	echo '</tbody></table>';
	
	
}
function cancel_paybill($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE paybill SET
	cancel_status='1'
	WHERE paybill_no='$paybill_no'";
	mysqli_query ($conn, $query );
	
	
}
function cancel_all_paybill_voucher($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE paybill_has_voucher SET
	cancel_status='1'
	WHERE paybill_no='$paybill_no'";
	mysqli_query ( $conn, $query );
	
	
}
function roll_back_paybill_voucher($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM paybill_has_voucher WHERE cancel_status=0 AND paybill_no='$paybill_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		if ($row [ref_type] == "VOUCHER") {
			$info = get_voucher_info ( $row ['ref_no'] );
			$table = "voucher";
			$voucher = "voucher_no";
		} else {
			$info = get_other_expenses_info ( $row ['ref_no'] );
			$table = "other_expenses";
			$voucher = "other_expenses_no";
		}
		$ref_no = $row ['ref_no'];
		
		$paid = $info ['paid'] - $row ['amount'];
		$due = $info ['due'] + $row ['amount'];
		$paybill_status = $info ['pay_status'] - 1;
		
		mysqli_select_db ($conn, $dbname );
		$query = "UPDATE $table SET
		paid='$paid',
		due='$due',
		pay_status='$paybill_status'
		WHERE $voucher='$ref_no'";
		mysqli_query ($conn, $query );
	}
	
	
}
function delete_all_from_temp_for_this_user($user_id) {
	roll_back_paybill_voucher_by_user_id ( $user_id );
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "DELETE FROM temp_paybill_has_voucher WHERE user_id='$user_id'";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function roll_back_paybill_voucher_by_user_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM temp_paybill_has_voucher WHERE user_id='$user_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row [ref_type] == "VOUCHER") {
			$info = get_voucher_info ( $row ['ref_no'] );
			$table = "voucher";
			$voucher = "voucher_no";
		} else {
			$info = get_other_expenses_info ( $row ['ref_no'] );
			$table = "other_expenses";
			$voucher = "other_expenses_no";
		}
		$ref_no = $row ['ref_no'];
		
		$paid = $info ['paid'] - $row ['amount'];
		$due = $info ['due'] + $row ['amount'];
		$paybill_status = $info ['pay_status'] - 1;
		
		mysqli_select_db ( $dbname );
		$query = "UPDATE $table SET
		paid='$paid',
		due='$due',
		pay_status='$paybill_status'
		WHERE $voucher='$ref_no'";
		mysqli_query ( $query );
	}
	
	
}
function get_paybill_info($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM paybill WHERE paybill_no='$paybill_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
	
}
function paybill_get_voucher_no($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT ref_no FROM paybill_has_voucher WHERE paybill_no='$paybill_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['ref_no'];
	}
	
	
}
function list_paybill_voucher_no($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, " SELECT ref_no, ref_type FROM paybill_has_voucher WHERE paybill_no='$paybill_no'AND cancel_status='0'" );
	$i = 1;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($i == 1) {
		} 

		else {
			echo ", ";
		}
		
		if ($row ['ref_type'] == "OTHER EXPENSES") {
			$ref_type = "OE";
		} 

		else {
			$ref_type = "V";
		}
		
		echo "$ref_type-$row[ref_no]";
		$i ++;
	}
	
	
}
function get_paybill_print_count($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT print_count FROM paybill WHERE paybill_no='$paybill_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$print_count = $row ['print_count'];
	}
	
	return $print_count;
	
	
}
function update_paybill_print_count($paybill_no, $print_count) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE paybill SET
	print_count='$print_count'
	WHERE paybill_no='$paybill_no'";
	mysqli_query ($conn, $query );
	
	
}
function list_paybill_vouchers_view($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
  <thead>
    <tr class="success" style="font-weight: bold;">
    <td>Ref No</td>
    <td>Ref Type</td>
    <td>Date</td>
	<td>Customer Name</td>
	<td align="right">Paid</td>
    </tr>
  </thead>
  <tbody>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM paybill_has_voucher WHERE paybill_no='$paybill_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['ref_type'] == "VOUCHER") {
			$info = get_voucher_info ( $row [ref_no] );
			$date = $info ['voucher_date'];
			$customer = $info ['travels'];
		} else {
			$info = get_other_expenses_info ( $row [ref_no] );
			$date = $info ['other_expenses_date'];
			$customer = $info ['customer'];
		}
		
		echo '
		<tr>
		<td>' . $row [ref_no] . '</td>
		<td>' . $row [ref_type] . '</td>
		<td>' . $date . '</td>		
		<td>' . $customer . '</td>
		<td align="right" class="info">' . $row [amount] . '</td>
		
		</tr>
		';
	}
	
	echo '<tr>
	<td><strong>Total</strong></td>
	<td></td>
	<td></td>
	<td></td>
	
	<td align="right"><strong>' . get_paybill_voucher_total_by_paybill_no ( $paybill_no ) . '</strong></td>
	
	
	</tr>';
	
	echo '</tbody></table>';
	
	
}
function get_paybill_voucher_total_by_paybill_no($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT SUM(amount) FROM paybill_has_voucher WHERE paybill_no='$paybill_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$total = $row ['SUM(amount)'];
	}
	
	return $total;
	
	
}
function search_paybill($paybill_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($paybill_no) {
		$paybill_no_check = "AND paybill_no LIKE '%$paybill_no%'";
	} else {
		$paybill_no_check = "";
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
              <table class="table" style="font-size: 13px;">
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
	</tr>';
	
	$today = date ( "Y-m-d" );
	$total = 0;
	$branch = $_SESSION ['branch'];
	
	if ($branch == "Head Office") {
		$branch_check = "";
	} else {
		$branch_check = "AND branch LIKE '%$branch%'";
	}
	
	$result = mysqli_query ( $conn, "SELECT * FROM paybill WHERE cancel_status='0' $paybill_no_check $customer_check $date_check $branch_check ORDER BY id DESC $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '
		<tr>

		<td>
		<a href="paybill.php?job=print_paybill&paybill_no=' . $row [paybill_no] . '" target="blank"><i class="fa fa-print fa-lg"></i></a>
		</td>

		<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [paybill_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>

		<td>
		<a href="paybill.php?job=delete_paybill&paybill_no=' . $row [paybill_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a>
		</td>

		<td>
		' . $row [paybill_no] . '
		</td>

		<td>
		 ' . $row [customer_name] . '
		</td>

		 <td align="right" class="success">
		 ' . $row [cheque_amount] . '
		</td>

		<td align="right" class="warning">
		 ' . $row [dep_amount] . '
		</td>

		 <td align="right" class="info">
		 ' . $row [cash_amount] . '
		</td>
		
		 <td align="right" class="success">
		 ' . $row [card_amount] . '
		</td>
		
		 <td align="right" class="warning">
		 ' . $row [ez_amount] . '
		</td>
		
		 <td align="right" class="info">
		 ' . $row [total] . '
		</td>



		</tr>
		<div class="modal fade" id="' . $row [paybill_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [rec_no] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">Paybill
			      </div>
			      <div class="modal-body">
			        <iframe src="paybill.php?job=transaction&paybill_no=' . $row [paybill_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
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

		</tr></table></div>';
	
	
}


function search_paybill_print($paybill_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	if ($paybill_no) {
		$paybill_no_check = "AND paybill_no LIKE '%$paybill_no%'";
	} else {
		$paybill_no_check = "";
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
              <table class="table" style="font-size: 13px;">
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

	$result = mysqli_query ( $conn, "SELECT * FROM paybill WHERE cancel_status='0' $paybill_no_check $customer_check $date_check $branch_check ORDER BY id DESC $limit" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {

		echo '
		<tr>

		<td>
		' . $row [paybill_no] . '
		</td>

		<td>
		 ' . $row [customer_name] . '
		</td>

		 <td align="right" class="success">
		 ' . $row [cheque_amount] . '
		</td>

		<td align="right" class="warning">
		 ' . $row [dep_amount] . '
		</td>

		 <td align="right" class="info">
		 ' . $row [cash_amount] . '
		</td>

		 <td align="right" class="success">
		 ' . $row [card_amount] . '
		</td>

		 <td align="right" class="warning">
		 ' . $row [ez_amount] . '
		</td>

		 <td align="right" class="info">
		 ' . $row [total] . '
		</td>



		</tr>
		<div class="modal fade" id="' . $row [paybill_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [rec_no] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">Paybill
			      </div>
			      <div class="modal-body">
			        <iframe src="paybill.php?job=transaction&paybill_no=' . $row [paybill_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
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


function roll_back_loan_amount($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM paybill_has_voucher WHERE paybill_no='$paybill_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($type == "VOUCHER") {
		} else {
			$voucher_info = get_other_expenses_info ( $voucher_no );
			$table = "other_expenses";
			$loan_info = get_other_expenses_info ( $voucher_no );
			if ($loan_info ['ref_type'] == "LOAN") {
				$loan_no = $loan_info ['ref_no'];
				reupdate_loan_balance ( $loan_no, $info ['amount'] );
			}
		}
	}
}