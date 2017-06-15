<?php
function generate_invoice($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_booking_info_by_booking_no ( $booking_no );
	$invoice_date = date ( "Y-m-d" );
	$invoice_no = get_invoice_no ();
	$branch = $info ['branch'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO invoice (id, ref_no, branch, invoice_no, invoice_date, type, customer, customer_id, saved_by, rec_status, total, due)
	VALUES ('', '$booking_no', '$branch', '$invoice_no', '$invoice_date', 'TICKET', '$info[name]', '$info[customer_id]', '$info[completed_by]', '0', '$info[total]', '$info[total]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	$description = 'TICKET';
	
	add_invoice_description ( $invoice_no, $description, $booking_no, $amount );
	add_description_ledger ( $invoice_no, $description, $amount );
	
	add_invoice_ledger ( $invoice_no );
}
function transfer_invoice_to($to_user, $invoice_no, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE invoice SET
	saved_by='$to_user',
	branch='$branch'
	WHERE invoice_no='$invoice_no'";
	mysqli_query ($conn, $query );
	

}
function generate_invoice_cab($cab_booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_cab_info_by_cab_booking_no ( $cab_booking_no );
	$invoice_date = date ( "Y-m-d" );
	$invoice_no = get_invoice_no ();
	$branch = $info ['branch'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO invoice (id, ref_no, branch, invoice_no, invoice_date, type, customer, customer_id, saved_by, rec_status, total, due)
	VALUES ('', '$cab_booking_no', '$branch', '$invoice_no', '$invoice_date', 'CAB', '$info[name]', '$info[customer_id]', '$info[saved_by]', '0', '$info[total]', '$info[total]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	$description = 'CAB';
	
	add_invoice_description ( $invoice_no, $description, $cab_booking_no, $amount );
	add_description_ledger ( $invoice_no, $description, $amount );
	
	add_invoice_ledger ( $invoice_no );
}
function generate_invoice_visa($visa_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_visa_info_by_visa_no ( $visa_no );
	$invoice_date = date ( "Y-m-d" );
	$invoice_no = get_invoice_no ();
	$branch = $info ['branch'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO invoice (id, ref_no, branch, invoice_no, invoice_date, type, customer, customer_id, saved_by, rec_status, total, due)
	VALUES ('', '$visa_no', '$branch', '$invoice_no', '$invoice_date', 'VISA', '$info[name]', '$info[customer_id]', '$info[saved_by]', '0', '$info[total]', '$info[total]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	$description = 'VISA';
	
	add_invoice_description ( $invoice_no, $description, $visa_no, $amount );
	add_description_ledger ( $invoice_no, $description, $amount );
	
	add_invoice_ledger ( $invoice_no );
}
function generate_invoice_itinerary($itinerary_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_itinerary_info_by_itinerary_no ( $itinerary_no );
	$invoice_date = date ( "Y-m-d" );
	$invoice_no = get_invoice_no ();
	$branch = $info ['branch'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO invoice (id, ref_no, branch, invoice_no, invoice_date, type, customer, customer_id, saved_by, rec_status, total, due)
	VALUES ('', '$itinerary_no', '$branch', '$invoice_no', '$invoice_date', 'ITINERARY', '$info[name]', '$info[customer_id]', '$info[saved_by]', '0', '$info[total]', '$info[total]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	$description = 'ITINERARY';
	
	add_invoice_description ( $invoice_no, $description, $itinerary_no, $amount );
	add_description_ledger ( $invoice_no, $description, $amount );
	
	add_invoice_ledger ( $invoice_no );
}
function generate_invoice_insurance($insurance_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_insurance_info_by_insurance_no ( $insurance_no );
	$invoice_date = date ( "Y-m-d" );
	$invoice_no = get_invoice_no ();
	$branch = $info ['branch'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO invoice (id, ref_no, branch, invoice_no, invoice_date, type, customer, customer_id, saved_by, rec_status, total, due)
	VALUES ('', '$insurance_no', '$branch', '$invoice_no', '$invoice_date', 'INSURANCE', '$info[name]', '$info[customer_id]', '$info[saved_by]', '0', '$info[total]', '$info[total]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	$description = 'INSURANCE';
	
	add_invoice_description ( $invoice_no, $description, $insurance_no, $amount );
	add_description_ledger ( $invoice_no, $description, $amount );
	
	add_invoice_ledger ( $invoice_no );
}
function get_invoice_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(invoice_no) FROM invoice WHERE  cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(invoice_no)'] + 1;
	}
}
function get_invoice_no_from_description() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(invoice_no) FROM invoice_has_description WHERE  cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(invoice_no)'] + 1;
	}
}
function get_invoice_info($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM invoice WHERE invoice_no='$invoice_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function get_invoice_info_by_booking_no($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM invoice WHERE ref_no='$booking_no' AND type='TICKET' AND cancel_status='0'" );
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
function delete_invoice_visa($visa_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$type = "VISA";
	$flag = 'INVOICE-VISA';
	$invoice_no = get_invoice_no_by_ref_no ( $visa_no, $type );
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE invoice SET
	cancel_status='1'
	WHERE invoice_no='$invoice_no'";
	mysqli_query ($conn, $query );
	
	delete_invoice_ledger ( $invoice_no, $flag );
	

}
function delete_invoice_insurance($insurance_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$type = "INSURANCE";
	$flag = 'INVOICE-INSURANCE';
	
	$invoice_no = get_invoice_no_by_ref_no ( $insurance_no, $type );
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE invoice SET
	cancel_status='1'
	WHERE invoice_no='$invoice_no'";
	mysqli_query ($conn, $query );
	
	delete_invoice_ledger ( $invoice_no, $flag );
	

}
function get_invoice_no_by_ref_no($ref_no, $type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM invoice WHERE ref_no='$ref_no' AND type='$type'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['invoice_no'];
	}
}
function list_description_by_invoice($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM invoice_has_description WHERE invoice_no='$invoice_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '<div class="col-lg-3"">' . $row [description] . '</div>
			<div class="col-lg-5">' . $row [detail] . '</div>
			<div class="col-lg-2">' . $row [amount] . '</div>
			<div class="col-lg-2"><a href="invoice.php?job=delete_description&id=' . $row [id] . '" ><i class="fa fa-times fa-2x"></i></a></div>';
	}
	

}
function list_description_by_invoice_view($invoice_no) {
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
	$result = mysqli_query ($conn, "SELECT * FROM invoice_has_description WHERE invoice_no='$invoice_no' AND cancel_status='0' ORDER BY id ASC" );
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
function add_invoice_description($invoice_no, $description, $detail, $amount) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "y-m-d H:i:s" );
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO invoice_has_description (invoice_no, description, detail, amount, saved, saved_by)
	VALUES ('$invoice_no', '$description',  '$detail', '$amount', '$time', '$_SESSION[user_name]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function get_invoice_total($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT sum(amount) as total FROM invoice_has_description WHERE invoice_no='$invoice_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$total = $row [total];
	}
	
	return $total;
	

}
function check_invoice_receipt_status($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT rec_status FROM invoice WHERE invoice_no='$invoice_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['rec_status'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	

}
function get_invoice_description_id($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT MAX(id) FROM invoice_has_description WHERE cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(id)'];
	}
}
function last_description_invoice($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT count(id) FROM invoice_has_description WHERE invoice_no='$invoice_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['count(id)'];
	}
}
function delete_invoice($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE invoice SET
	cancel_status='1'
	WHERE invoice_no='$invoice_no'";
	mysqli_query ($conn, $query );
	

}
function delete_description($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE invoice_has_description SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	

}
function delete_invoice_description($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE invoice_has_description SET
	cancel_status='1'
	WHERE invoice_no='$invoice_no'";
	mysqli_query ($conn, $query );
	

}
function update_invoice($invoice_no, $invoice_date, $customer, $remarks, $total, $ref_no, $ref_type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE invoice SET
	invoice_date='$invoice_date',
	customer='$customer',
	remarks='$remarks',
	total='$total',
	due='$total',
	ref_no='$ref_no',
	ref_type='$ref_type',
	branch='$_SESSION[branch]'
	WHERE invoice_no='$invoice_no'";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function add_invoice($invoice_no, $invoice_date, $customer, $customer_id, $remarks, $saved_by, $total, $due, $ref_no, $ref_type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO invoice (invoice_no, invoice_date, type, customer, customer_id, remarks, saved_by, total, due, ref_no, ref_type, branch)
	VALUES ('$invoice_no', '$invoice_date', 'OTHER', '$customer', '$customer_id', '$remarks', '$saved_by', '$total', '$due', '$ref_no', '$ref_type', '$_SESSION[branch]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function search_invoice($invoice_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$today = date ( 'Y-m-d' );
	
	if ($invoice_no) {
		$invoice_no_check = "AND invoice_no = '$invoice_no'";
	} else {
		$invoice_no_check = "";
	}
	
	if ($customer) {
		$customer_check = "AND customer LIKE '%$customer%'";
	} else {
		$customer_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND invoice_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND invoice_date>='$from_date'";
	} elseif ($to_date) {
		$date_check = "AND invoice_date<='$to_date'";
	} else {
		$date_check = "";
	}
	
	if ($invoice_no_check || $customer_check || $date_check) {
		$date_check = "";
	} else {
		$date_check = "AND invoice_date='$today'";
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
	$result = mysqli_query ( $conn, "SELECT * FROM invoice WHERE cancel_status='0' AND type='OTHER' $invoice_no_check $customer_check $date_check ORDER BY id" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '
		<tr>

		<td>
		<a href="invoice.php?job=print&invoice_no=' . $row [invoice_no] . '" target="blank"><i class="fa fa-print fa-lg"></i></a>
		</td>

		<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [invoice_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>

		<td>
		<a href="invoice.php?job=delete_invoice&invoice_no=' . $row [invoice_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a>
		</td>

		<td>
		' . $row [invoice_no] . '
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

		 <td align="right" class="success">
		 ' . $row [total] . '
		</td>

		 <td align="right" class="info">
		 ' . $row [paid] . '
		</td>

		 <td align="right" class="warning">
		 ' . $row [due] . '
		</td>



		</tr>
		<div class="modal fade" id="' . $row [invoice_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [invoice_no] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">Invoice
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
		 		
		 <td align="right" class="danger">
		 <strong>' . $formated_paid . '</strong>
		</td>
		 		
		 <td align="right" class="danger">
		 <strong>' . $formated_due . '</strong>
		</td>

		</tr></table></div>';
	

}