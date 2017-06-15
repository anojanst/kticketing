<?php
function generate_other_expenses($refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_refund_info ( $refund_no );
	$other_expenses_date = date ( "Y-m-d" );
	$other_expenses_no = get_other_expenses_no_from_description ();
	$branch = $info ['branch'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO other_expenses (id, ref_no, branch, other_expenses_no, other_expenses_date, type, customer, saved_by, total, due, ref_type)
	VALUES ('', '$refund_no', '$branch', '$other_expenses_no', '$other_expenses_date', 'OTHER-EXPENSES', '$info[name]', '$info[completed_by]', '$info[total]', '$info[total]', 'REFUND')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	$description = "Refund";
	
	add_other_expenses_description ( $other_expenses_no, $description, $refund_no, $info ['total'] );
	add_description_ledger_other_expenses ( $other_expenses_no, $description, $info ['total'] );
	add_other_expenses_ledger ( $other_expenses_no );
}
function generate_other_expenses_loan($loan_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_loan_info_by_loan_no ( $loan_no );
	$other_expenses_date = date ( "Y-m-d" );
	$other_expenses_no = get_other_expenses_no_from_description ();
	$branch = $info ['branch'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO other_expenses (id, ref_no, branch, other_expenses_no, other_expenses_date, type, customer, customer_id, saved_by, total, due, ref_type)
	VALUES ('', '$loan_no', '$branch', '$other_expenses_no', '$other_expenses_date', 'OTHER-EXPENSES', '$info[name]', '$info[customer_id]', '$info[saved_by]', '$info[loan_amount]', '$info[loan_amount]', 'LOAN')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	$description = "Loan";
	
	add_other_expenses_description ( $other_expenses_no, $description, $loan_no, $info ['loan_amount'] );
	add_description_ledger_other_expenses ( $other_expenses_no, $description, $info ['loan_amount'] );
	add_other_expenses_ledger ( $other_expenses_no );
}
function generate_other_expenses_salary($salary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_salary_info ( $salary_no );
	$customer_info = get_customer_info ( $info [staff_name] );
	$other_expenses_date = date ( "Y-m-d" );
	$other_expenses_no = get_other_expenses_no_from_description ();
	$branch = $info ['branch'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO other_expenses (id, ref_no, branch, other_expenses_no, other_expenses_date, type, customer, customer_id, saved_by, total, due, ref_type)
	VALUES ('', '$salary_no', '$branch', '$other_expenses_no', '$other_expenses_date', 'OTHER-EXPENSES', '$info[staff_name]', '$customer_info[customer_id]', '$info[saved_by]', '$info[total]', '$info[total]', 'SALARY')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	$description = "salary";
	
	add_other_expenses_description ( $other_expenses_no, $description, $loan_no, $info ['total'] );
	add_description_ledger_other_expenses ( $other_expenses_no, $description, $info ['total'] );
	add_other_expenses_ledger ( $other_expenses_no );
}
function get_other_expenses_no_by_salary_no_info($salary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn,  "SELECT * FROM other_expenses WHERE ref_no='$salary_no' AND ref_type='SALARY' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['other_expenses_no'];
	}
}
function generate_other_expenses_for_interest() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m-d" );
	
	$result = mysqli_query ( $conn, "SELECT * FROM loan WHERE interest_date='$date' AND interest>'0' AND loan_balance>'0' AND cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$other_expenses_date = $date;
		$other_expenses_no = get_other_expenses_no_from_description ();
		$branch = $info ['branch'];
		
		if ($row ['type'] == "MONTHLY") {
			$total = ($row ['loan_balance'] / 100) * $row ['interest'];
		} else {
			$total = (($row ['loan_balance'] / 100) * $row ['interest']) / 12;
		}
		
		mysqli_select_db ( $dbname );
		$query1 = "INSERT INTO other_expenses (id, ref_no, branch, other_expenses_no, other_expenses_date, type, customer, saved_by, total, due, ref_type)
		VALUES ('', '$row[loan_no]', '$branch', '$other_expenses_no', '$other_expenses_date', 'OTHER-EXPENSES', '$row[name]', '$row[saved_by]', '$total', '$total', 'INTEREST')";
		mysqli_query ( $query1 ) or die ( mysqli_connect_error () );
		
		$new_date = date ( 'Y-m-d', strtotime ( '+30 days' ) );
		
		mysqli_select_db ( $dbname );
		$query2 = "UPDATE loan SET
		interest_date='$new_date'
		WHERE loan_no='$row[loan_no]'";
		mysqli_query ( $query2 );
		
		$description = "Interest";
		
		add_other_expenses_description ( $other_expenses_no, $description, $row ['loan_no'], $total );
		add_description_ledger_other_expenses ( $other_expenses_no, $description, $total );
		add_other_expenses_ledger ( $other_expenses_no );
	}
}
function get_other_expenses_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(other_expenses_no) FROM other_expenses WHERE  cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(other_expenses_no)'] + 1;
	}
}
function get_other_expenses_no_from_description() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(other_expenses_no) FROM other_expenses_has_description WHERE  cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(other_expenses_no)'] + 1;
	}
}
function get_other_expenses_info($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM other_expenses WHERE other_expenses_no='$other_expenses_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function get_other_expenses_info_by_booking_no($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn,"SELECT * FROM other_expenses WHERE ref_no='$booking_no' AND type='TICKET'  AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function num_to_rupee($number) {
	$real_name = Rupee;
	$decimal_digit = 2;
	$decimal_name = Cent;
	
	$res = '';
	$real = 0;
	$decimal = 0;
	
	if ($number == 0)
		return 'Zero' . (($real_name == '') ? '' : ' ' . $real_name);
	if ($number >= 0) {
		$real = floor ( $number );
		
		$decimal = number_format ( $number - $real, 2 );
	} else {
		$real = ceil ( $number ) * (- 1);
		$number = abs ( $number );
		$decimal = $number - $real;
	}
	$decimal = ( int ) str_replace ( '.', '', $decimal );
	
	$unit_name [1] = 'thousand';
	$unit_name [2] = 'million';
	$unit_name [3] = 'billion';
	$unit_name [4] = 'trillion';
	
	$packet = array ();
	
	$number = strrev ( $real );
	$packet = str_split ( $number, 3 );
	
	for($i = 0; $i < count ( $packet ); $i ++) {
		$tmp = strrev ( $packet [$i] );
		$unit = $unit_name [$i];
		if (( int ) $tmp == 0)
			continue;
		$tmp_res = '';
		if (strlen ( $tmp ) >= 2) {
			$tmp_proc = substr ( $tmp, - 2 );
			switch ($tmp_proc) {
				case '10' :
					$tmp_res = 'ten';
					break;
				case '11' :
					$tmp_res = 'eleven';
					break;
				case '12' :
					$tmp_res = 'twelve';
					break;
				case '13' :
					$tmp_res = 'thirteen';
					break;
				case '15' :
					$tmp_res = 'fifteen';
					break;
				case '20' :
					$tmp_res = 'twenty';
					break;
				case '30' :
					$tmp_res = 'thirty';
					break;
				case '40' :
					$tmp_res = 'forty';
					break;
				case '50' :
					$tmp_res = 'fifty';
					break;
				case '70' :
					$tmp_res = 'seventy';
					break;
				case '80' :
					$tmp_res = 'eighty';
					break;
				default :
					$tmp_begin = substr ( $tmp_proc, 0, 1 );
					$tmp_end = substr ( $tmp_proc, 1, 1 );
					
					if ($tmp_begin == '1')
						$tmp_res = get_num_name ( $tmp_end ) . 'teen';
					elseif ($tmp_begin == '0')
						$tmp_res = get_num_name ( $tmp_end );
					elseif ($tmp_end == '0')
						$tmp_res = get_num_name ( $tmp_begin ) . 'ty';
					else {
						if ($tmp_begin == '2')
							$tmp_res = 'twenty';
						elseif ($tmp_begin == '3')
							$tmp_res = 'thirty';
						elseif ($tmp_begin == '4')
							$tmp_res = 'forty';
						elseif ($tmp_begin == '5')
							$tmp_res = 'fifty';
						elseif ($tmp_begin == '6')
							$tmp_res = 'sixty';
						elseif ($tmp_begin == '7')
							$tmp_res = 'seventy';
						elseif ($tmp_begin == '8')
							$tmp_res = 'eighty';
						elseif ($tmp_begin == '9')
							$tmp_res = 'ninety';
						
						$tmp_res = $tmp_res . ' ' . get_num_name ( $tmp_end );
					}
					break;
			}
			
			if (strlen ( $tmp ) == 3) {
				$tmp_begin = substr ( $tmp, 0, 1 );
				
				$space = '';
				if (substr ( $tmp_res, 0, 1 ) != ' ' && $tmp_res != '')
					$space = ' ';
				
				if ($tmp_begin != 0) {
					if ($tmp_begin != '0') {
						if ($tmp_res != '')
							$tmp_res = 'and' . $space . $tmp_res;
					}
					$tmp_res = get_num_name ( $tmp_begin ) . ' hundred' . $space . $tmp_res;
				}
			}
		} else
			$tmp_res = get_num_name ( $tmp );
		$space = '';
		if (substr ( $res, 0, 1 ) != ' ' && $res != '')
			$space = ' ';
		$res = $tmp_res . ' ' . $unit . $space . $res;
	}
	
	$space = '';
	if (substr ( $res, - 1 ) != ' ' && $res != '')
		$space = ' ';
	
	$res .= $space . $real_name . (($real > 1 && $real_name != '') ? 's' : '');
	
	if ($decimal > 0)
		$res .= ' ' . num_to_words ( $decimal, '', 0, '' ) . ' ' . $decimal_name . (($decimal > 1 && $decimal_name != '') ? 's' : '');
	return ucfirst ( $res );
}
function get_num_name($num) {
	switch ($num) {
		case 1 :
			return 'one';
		case 2 :
			return 'two';
		case 3 :
			return 'three';
		case 4 :
			return 'four';
		case 5 :
			return 'five';
		case 6 :
			return 'six';
		case 7 :
			return 'seven';
		case 8 :
			return 'eight';
		case 9 :
			return 'nine';
	}
}
function num_to_words($number, $real_name, $decimal_digit, $decimal_name) {
	if ($number == 0)
		return 'Zero' . (($real_name == '') ? '' : ' ' . $real_name);
	if ($number >= 0) {
		$real = floor ( $number );
		$decimal = round ( $number - $real, $decimal_digit );
	} else {
		$real = ceil ( $number ) * (- 1);
		$number = abs ( $number );
		$decimal = $number - $real;
	}
	$decimal = ( int ) str_replace ( '.', '', $decimal );
	
	$unit_name [1] = 'thousand';
	$unit_name [2] = 'million';
	$unit_name [3] = 'billion';
	$unit_name [4] = 'trillion';
	
	$packet = array ();
	
	$number = strrev ( $real );
	$packet = str_split ( $number, 3 );
	
	for($i = 0; $i < count ( $packet ); $i ++) {
		$tmp = strrev ( $packet [$i] );
		$unit = $unit_name [$i];
		if (( int ) $tmp == 0)
			continue;
		$tmp_res = '';
		if (strlen ( $tmp ) >= 2) {
			$tmp_proc = substr ( $tmp, - 2 );
			switch ($tmp_proc) {
				case '10' :
					$tmp_res = 'ten';
					break;
				case '11' :
					$tmp_res = 'eleven';
					break;
				case '12' :
					$tmp_res = 'twelve';
					break;
				case '13' :
					$tmp_res = 'thirteen';
					break;
				case '15' :
					$tmp_res = 'fifteen';
					break;
				case '20' :
					$tmp_res = 'twenty';
					break;
				case '30' :
					$tmp_res = 'thirty';
					break;
				case '40' :
					$tmp_res = 'forty';
					break;
				case '50' :
					$tmp_res = 'fifty';
					break;
				case '70' :
					$tmp_res = 'seventy';
					break;
				case '80' :
					$tmp_res = 'eighty';
					break;
				default :
					$tmp_begin = substr ( $tmp_proc, 0, 1 );
					$tmp_end = substr ( $tmp_proc, 1, 1 );
					
					if ($tmp_begin == '1')
						$tmp_res = get_num_name ( $tmp_end ) . 'teen';
					elseif ($tmp_begin == '0')
						$tmp_res = get_num_name ( $tmp_end );
					elseif ($tmp_end == '0')
						$tmp_res = get_num_name ( $tmp_begin ) . 'ty';
					else {
						if ($tmp_begin == '2')
							$tmp_res = 'twenty';
						elseif ($tmp_begin == '3')
							$tmp_res = 'thirty';
						elseif ($tmp_begin == '4')
							$tmp_res = 'forty';
						elseif ($tmp_begin == '5')
							$tmp_res = 'fifty';
						elseif ($tmp_begin == '6')
							$tmp_res = 'sixty';
						elseif ($tmp_begin == '7')
							$tmp_res = 'seventy';
						elseif ($tmp_begin == '8')
							$tmp_res = 'eighty';
						elseif ($tmp_begin == '9')
							$tmp_res = 'ninety';
						
						$tmp_res = $tmp_res . ' ' . get_num_name ( $tmp_end );
					}
					break;
			}
			
			if (strlen ( $tmp ) == 3) {
				$tmp_begin = substr ( $tmp, 0, 1 );
				
				$space = '';
				if (substr ( $tmp_res, 0, 1 ) != ' ' && $tmp_res != '')
					$space = ' ';
				
				if ($tmp_begin != 0) {
					if ($tmp_begin != '0') {
						if ($tmp_res != '')
							$tmp_res = 'and' . $space . $tmp_res;
					}
					$tmp_res = get_num_name ( $tmp_begin ) . ' hundred' . $space . $tmp_res;
				}
			}
		} else
			$tmp_res = get_num_name ( $tmp );
		$space = '';
		if (substr ( $res, 0, 1 ) != ' ' && $res != '')
			$space = ' ';
		$res = $tmp_res . ' ' . $unit . $space . $res;
	}
	
	$space = '';
	if (substr ( $res, - 1 ) != ' ' && $res != '')
		$space = ' ';
	
	$res .= $space . $real_name . (($real > 1 && $real_name != '') ? 's' : '');
	
	if ($decimal > 0)
		$res .= ' ' . num_to_words ( $decimal, '', 0, '' ) . ' ' . $decimal_name . (($decimal > 1 && $decimal_name != '') ? 's' : '');
	return ucfirst ( $res );
}
function get_other_expenses_no_by_ref_no($ref_no, $type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( "SELECT * FROM other_expenses WHERE ref_no='$ref_no' AND type='$type'  AND cancel_status='0'", $conn );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['other_expenses_no'];
	}
}
function list_description_by_other_expenses($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM other_expenses_has_description WHERE other_expenses_no='$other_expenses_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '<div class="col-lg-3"">' . $row [description] . '</div>
			<div class="col-lg-5">' . $row [detail] . '</div>
			<div class="col-lg-2">' . $row [amount] . '</div>
			<div class="col-lg-2"><a href="other_expenses.php?job=delete_description&id=' . $row [id] . '" ><i class="fa fa-times fa-2x"></i></a></div>';
	}
	
	
}
function list_description_by_other_expenses_view($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
				<tr class="danger" style="font-weight: bold;">
					<td>Description</td>
					<td>Detail</td>
					<td align="right">Amount</td>
				</tr>';
	
	$total = 0;
	$result = mysqli_query ( $conn, "SELECT * FROM other_expenses_has_description WHERE other_expenses_no='$other_expenses_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '<td>' . $row [description] . '</td>
			<td>' . $row [detail] . '</td>
			<td align="right">' . $row [amount] . '</td>
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
function add_other_expenses_description($other_expenses_no, $description, $detail, $amount) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO other_expenses_has_description (other_expenses_no, description, detail, amount, saved, saved_by)
	VALUES ('$other_expenses_no', '$description',  '$detail', '$amount', '$time', '$_SESSION[user_name]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function get_other_expenses_total($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT sum(amount) as total FROM other_expenses_has_description WHERE other_expenses_no='$other_expenses_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$total = $row [total];
	}
	
	return $total;
	
	
}
function check_other_expenses_paybill_status($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT pay_status FROM other_expenses WHERE other_expenses_no='$other_expenses_no'  AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['pay_status'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
}
function get_other_expenses_description_id($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(id) FROM other_expenses_has_description WHERE cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(id)'];
	}
}
function last_description_other_expenses($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT count(id) FROM other_expenses_has_description WHERE other_expenses_no='$other_expenses_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['count(id)'];
	}
}
function delete_other_expenses($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE other_expenses SET
	cancel_status='1'
	WHERE other_expenses_no='$other_expenses_no'";
	mysqli_query ($conn, $query );
	
	
}
function delete_description($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE other_expenses_has_description SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}
function delete_other_expenses_description($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE other_expenses_has_description SET
	cancel_status='1'
	WHERE other_expenses_no='$other_expenses_no'";
	mysqli_query ($conn, $query );
	
	
}
function update_other_expenses($other_expenses_no, $other_expenses_date, $customer, $customer_id, $remarks, $total, $ref_no, $ref_type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE other_expenses SET
	other_expenses_date='$other_expenses_date',
	customer='$customer',
	customer_id='$customer_id',
	remarks='$remarks',
	total='$total',
	due='$total',
	ref_no='$ref_no',
	ref_type='$ref_type',
	branch='$_SESSION[branch]'
	WHERE other_expenses_no='$other_expenses_no'";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function add_other_expenses($other_expenses_no, $other_expenses_date, $customer, $customer_id, $remarks, $saved_by, $total, $due, $ref_no, $ref_type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO other_expenses (other_expenses_no, other_expenses_date, type, customer, customer_id, remarks, saved_by, total, due, ref_no, ref_type, branch)
	VALUES ('$other_expenses_no', '$other_expenses_date', 'OTHER-EXPENSES', '$customer', '$customer_id', '$remarks', '$saved_by', '$total', '$due', '$ref_no', '$ref_type', '$_SESSION[branch]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function search_other_expenses($other_expenses_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$today = date ( 'Y-m-d' );
	
	if ($other_expenses_no) {
		$other_expenses_no_check = "AND other_expenses_no = '$other_expenses_no'";
	} else {
		$other_expenses_no_check = "";
	}
	
	if ($customer) {
		$customer_check = "AND customer LIKE '%$customer%'";
	} else {
		$customer_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND other_expenses_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND other_expenses_date>='$from_date'";
	} elseif ($to_date) {
		$date_check = "AND other_expenses_date<='$to_date'";
	} else {
		$date_check = "";
	}
	
	if ($other_expenses_no_check || $customer_check || $date_check) {
		$date_checking = $date_check;
	} else {
		$date_checking = "AND other_expenses_date='$today'";
	}
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
	<tr class="danger" style="font-weight: bold;">

	<td>Print</td>
	<td>View</td>
	<td>Cancel</td>
	<td>No</td>
	<td>Customer</td>
	<td>Ref No</td>
	<td>Ref Type</td>
	<td align="right">Total</td>
	<td align="right">Paid</td>
	<td align="right">Due</td>
	</tr>';
	
	$due = 0;
	$paid = 0;
	$total = 0;
	$result = mysqli_query ( $conn, "SELECT * FROM other_expenses WHERE cancel_status='0' AND type='OTHER-EXPENSES' $other_expenses_no_check $customer_check $date_checking ORDER BY id" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '
		<tr>

		<td>
		<a href="other_expenses.php?job=print&other_expenses_no=' . $row [other_expenses_no] . '" target="blank"><i class="fa fa-print fa-lg"></i></a>
		</td>

		<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [other_expenses_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>

		<td>
		<a href="other_expenses.php?job=delete_other_expenses&other_expenses_no=' . $row [other_expenses_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a>
		</td>

		<td>
		' . $row [other_expenses_no] . '
		</td>

		<td>
		 ' . $row [customer] . '
		</td>

		<td>
		' . $row [ref_no] . '
		</td>

		<td>
		 ' . $row [ref_type] . '
		</td>

		 <td align="right">
		 ' . $row [total] . '
		</td>

		 <td align="right">
		 ' . $row [paid] . '
		</td>

		 <td align="right">
		 ' . $row [due] . '
		</td>



		</tr>
		<div class="modal fade" id="' . $row [other_expenses_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [other_expenses_no] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">other_expenses
			      </div>
			      <div class="modal-body">
			        <iframe src="other_expenses.php?job=view&other_expenses_no=' . $row [other_expenses_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>';
		$total = $total + $row ['total'];
		$due = $due + $row ['due'];
		$paid = $paid + $row ['paid'];
	}
	
	$formated_total = number_format ( $total, 2 );
	$formated_due = number_format ( $due, 2 );
	$formated_paid = number_format ( $paid, 2 );
	
	echo '<tr>
		<td colspan="7" align="right"><strong></strong></td>

		 <td align="right" class="danger">
		 <strong>' . $formated_total . '</strong>
		</td>
		 		
		 <strong>' . $formated_paid . '</strong>
		</td>
		 		
		 <td align="right" class="danger">
		 <strong>' . $formated_due . '</strong>
		</td>

		</tr></table></div>';
	
	
}