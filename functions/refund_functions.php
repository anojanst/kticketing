<?php
function check_refund_has_booking_no($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT refund_no FROM refund WHERE ref_no='$booking_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['refund_no'];
	}
	
	
}
function get_refund_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(refund_no) FROM refund WHERE  cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row ['MAX(refund_no)'] + 1;
	}
	
	
}
function add_refund($booking_no, $refund_no, $apply_date, $name, $customer_id, $count, $saved_by, $letter, $note, $type) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO refund (ref_no, refund_no, apply_date, name, customer_id, count, saved_by, letter, branch, note, type)
	VALUES ('$booking_no', '$refund_no', '$apply_date', '$name', '$customer_id', '$count', '$saved_by', '$letter', '$_SESSION[branch]', '$note', '$type')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function check_refund_paybill_status($refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT pay_status FROM other_expenses WHERE ref_type='REFUND' AND ref_no='$refund_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['paybill_status'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
}
function delete_refund($refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE refund SET
	cancel_status='1'
	WHERE refund_no='$refund_no'";
	mysqli_query ($conn, $query );
	
	
}
function list_refund() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$today = date ( 'Y-m-d' );
	
	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                 <thead>   
                    <tr>
                        <td>View</td>
                        <td>Cancel</td>
                        <td>Complete</td>
                        <td>Send</td>
                        <td>Print</td>
                        <td>Refund No</td>
                        <td>customer</td>
                        <td>Booking no</td>
                        <td>Apply Date</td>
                        <td>Fund Release Date</td>
                        <td align="right">Amount</td>
                        <td align="right">Markup</td>
                        <td align="right">Amount to Customer</td>
                    </tr>
                    </thead>
                    <tbody>';
	
	$branch = $_SESSION ['branch'];
	if ($branch == "Head Office") {
		$branch_check = "";
	} else {
		$branch_check = "AND branch LIKE '%$branch%'";
	}
	
	$total = 0;
	$result = mysqli_query ($conn, "SELECT * FROM refund WHERE cancel_status='0' AND apply_date='$today' $branch_check ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '
		<tr>';
		
		if ($row [status] == 1) {
			echo '<td><a href="refund.php?job=view&refund_no=' . $row [refund_no] . '" targrt="_blank"><i class="fa fa-newspaper-o fa-lg"></i></a></td>';
		} else {
			echo '<td></td>';
		}
		
		echo '<td><a href="refund.php?job=delete_refund&refund_no=' . $row [refund_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a></td>';
		
		if ($row [status] != 1) {
			echo '<td><a href="refund.php?job=to_complete&refund_no=' . $row [refund_no] . '"><i class="fa fa-gavel fa-lg"></i></a></td>';
		} 

		else {
			echo '<td></td>';
		}
		
		echo '
				
		<td>
		<a href="refund.php?job=send&refund_no=' . $row [refund_no] . '"><i class="fa fa-share fa-lg"></i></a>
		</td>

		<td>
		<a href="refund.php?job=print&refund_no=' . $row [refund_no] . '" target="blank"><i class="fa fa-print fa-lg"></i></a>
		</td>
				
		<td>' . $row [refund_no] . '</td>

		<td>' . $row [name] . '</td>

		<td>' . $row [ref_no] . '</td>

		<td>' . $row ['apply_date'] . '</td>

		<td>' . $row ['fund_release_date'] . '</td>

		<td align="right" class="info">' . $row [amount] . '</td>
		
		<td align="right" class="warning">' . $row [markup] . '</td>
		
		<td align="right" class="success">' . $row [total] . '</td>

		</tr>';
		$total = $total + $row ['total'];
	}
	
	$formated = number_format ( $total, 2 );
	
	echo '<tr>
		<td colspan="11" align="right"><strong></strong></td>
		<td align="right" class="danger"><strong>Total</strong></td>
		
		 <td align="right" class="danger">
		 <strong>' . $formated . '</strong>
		</td>

		</tr></tbody></table></div>';
}

function search_refund($refund_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$today = date ( 'Y-m-d' );
	
	if ($refund_no) {
		$refund_no_check = "AND refund_no = '$refund_no'";
	} else {
		$refund_no_check = "";
	}
	
	if ($customer) {
		$customer_check = "AND customer LIKE '%$customer%'";
	} else {
		$customer_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND apply_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND apply_date>='$from_date'";
	} elseif ($to_date) {
		$date_check = "AND apply_date<='$to_date'";
	} else {
		$date_check = "";
	}
	
	echo '<div class="box-body">
              <table id="example1"  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                <thead>   
                    <tr class="danger" style="font-weight: bold;">
                        <td>View</td>
                        <td>Cancel</td>
                        <td>Complete</td>
                        <td>Send</td>
                        <td>Print</td>
                        <td>Refund No</td>
                        <td>customer</td>
                        <td>Booking no</td>
                        <td>Apply Date</td>
                        <td>Fund Release Date</td>
                        <td align="right">Amount</td>
                        <td align="right">Markup</td>
                        <td align="right">Amount to Customer</td>
                    </tr>
                    </thead>
                    <tbody>';
	
	$branch = $_SESSION ['branch'];
	if ($branch == "Head Office") {
		$branch_check = "";
	} else {
		$branch_check = "AND branch LIKE '%$branch%'";
	}
	
	$total = 0;
	$result = mysqli_query ( $conn, "SELECT * FROM refund WHERE cancel_status='0' $branch_check $refund_no_check $customer_check $date_check ORDER BY id" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		echo '
		<tr>';
		
		if ($row [status] == 1) {
			echo '<td><a href="refund.php?job=view&refund_no=' . $row [refund_no] . '" targrt="_blank"><i class="fa fa-newspaper-o fa-lg"></i></a></td>';
		} else {
			echo '<td></td>';
		}
		
		echo '<td><a href="refund.php?job=delete_refund&refund_no=' . $row [refund_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a></td>';
		
		if ($row [status] != 1) {
			echo '<td><a href="refund.php?job=to_complete&refund_no=' . $row [refund_no] . '"><i class="fa fa-gavel fa-lg"></i></a></td>';
		} 

		else {
			echo '<td></td>';
		}
		
		echo '
				
		<td>
		<a href="refund.php?job=send&refund_no=' . $row [refund_no] . '"><i class="fa fa-share fa-lg"></i></a>
		</td>

		<td>
		<a href="refund.php?job=print&refund_no=' . $row [refund_no] . '" target="blank"><i class="fa fa-print fa-lg"></i></a>
		</td>
				
		<td>' . $row [refund_no] . '</td>

		<td>' . $row [name] . '</td>

		<td>' . $row [ref_no] . '</td>

		<td>' . $row ['apply_date'] . '</td>

		<td>' . $row ['fund_release_date'] . '</td>

		
		<td align="right" class="info">' . $row [amount] . '</td>
		
		<td align="right" class="warning">' . $row [markup] . '</td>
		
		<td align="right" class="success">' . $row [total] . '</td>

		</tr>';
		$total = $total + $row ['total'];
	}
	
	$formated = number_format ( $total, 2 );
	
	echo '<tr>
		<td colspan="11" align="right"><strong></strong></td>
		<td align="right" class="danger"><strong>Total</strong></td>
		
		 <td align="right" class="danger">
		 <strong>' . $formated . '</strong>
		</td>

		</tr></tbody></table></div>';
	
	
}
function get_refund_info($refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM refund WHERE refund_no='$refund_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function get_refund_has_passenger_info($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM refund_has_passengers WHERE id='$id' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function get_other_expenses_details($refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM other_expenses WHERE ref_no='$refund_no' AND ref_type='REFUND' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}
function refund_detail($refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM refund WHERE refund_no='$refund_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                   <thead>
                       <tr>
                           <th>Refund No</th>
                           <th>Type</th>
						   <th>Customer</th>
                           <th>Customer ID</th>
						   <th>Mobile</th>
                           <th>Ref No</th>
                           <th>Count</th>
						   <th>Apply Date</th>
                           <th>Note</th>
                           <th>Amount</th>
                           <th>Markup</th>
                           <th>Amount to Customer</th>
						   <th>Letter</th>
                       </tr>
                       </thead>
                       <tbody>';
		
		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE customer_id='$row[customer_id]' AND cancel_status='0'" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td>' . $row ['refund_no'] . '</td>
				<td>' . $row ['type'] . '</td>
				<td>' . $row ['name'] . '</td>
				<td>' . $row ['customer_id'] . '</td>
				<td>' . $row1 ['mobile'] . '</td>
				<td>' . $row ['ref_no'] . '</td>
				<td>' . $row ['count'] . '</td>
				<td>' . $row ['apply_date'] . '</td>
				<td>' . $row ['note'] . '</td>
				<td>' . $row ['amount'] . '</td>
				<td>' . $row ['markup'] . '</td>
				<td>' . $row ['total'] . '</td>
				<td><a href="#" class="btn btn-default" data-toggle="modal" data-target="#' . $row [id] . '">View</a></td>
			</tr>
						
			<div class="modal fade" id="' . $row [id] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [id] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">
			      </div>
			      <div class="modal-body">
			        <img src="' . $row [letter] . '" style="width: 100%;"/>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>';
		}
	}
	echo '</tbody>
        </table>
        </div>';
	
	
}
function list_passengers_for_refund_no($refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
         		 <thead>
         		 <tr class="info">
                    <th>Remove</th>
					<th>Full Name</th>
                    <th>First Name</th>
					<th>Last Name</th>
                    <th>Passport No</th>
					<th>Ticket No</th>
                 </tr>
                 </thead>
                 <tbody>';
	$result = mysqli_query ($conn, "SELECT * FROM refund_has_passengers WHERE refund_no='$refund_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td><a href="refund.php?job=delete_passenger&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this Passenger?\')"><i class="fa fa-times fa-2x"></i></a></td>
				<td>' . $row1 ['customer_name'] . '</td>
				<td>' . $row1 ['first_name'] . '</td>
				<td>' . $row1 ['last_name'] . '</td>
				<td>' . $row ['passport_no'] . '</td>
				<td>' . $row ['ticket_no'] . '</td>';
		}
	}
	echo '        </tbody>
              	</table>
            </div>

			';
	
	
}
function list_passengers_for_refund_no_view($refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
              <table id="example2" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>  
                     <tr class="info">
                        <th>Full Name</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Passport No</th>
                        <th>Ticket No</th>
                     </tr>
                     </thead>
                     <tbody>';
	$result = mysqli_query ( $conn, "SELECT * FROM refund_has_passengers WHERE refund_no='$refund_no' AND cancel_status='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr><td>' . $row1 ['customer_name'] . '</td>
				<td>' . $row1 ['first_name'] . '</td>
				<td>' . $row1 ['last_name'] . '</td>
				<td>' . $row ['passport_no'] . '</td>
				<td>' . $row ['ticket_no'] . '</td>';
		}
	}
	echo '        </tbody>
              	</table>
            </div>';
	
	
}
function list_passengers_booking_no($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="box-body">
              <table id="example2" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                    <thead>
                       <tr class="info">
						   <th>Full Name</th>
                           <th>First Name</th>
						   <th>Last Name</th>
                           <th>Passport No</th>
						   <th>Ticket No</th>
						   <th>Add</th>
                       </tr>
                   </thead>
                   <tbody>';
	$result = mysqli_query ( $conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND cancel_status='0' AND refund='0' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$result1 = mysqli_query ( $conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0' ORDER BY id ASC" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			echo '<tr>
				<td>' . $row1 ['customer_name'] . '</td>
				<td>' . $row1 ['first_name'] . '</td>
				<td>' . $row1 ['last_name'] . '</td>
				<td>' . $row ['passport_no'] . '</td>
				<td>' . $row ['ticket_no'] . '</td>
				<td><form name="add_product" action="refund.php?job=add_passenger&passport_no=' . $row [passport_no] . '&ticket_no=' . $row [ticket_no] . '&visa_copy=' . $row [visa_copy] . '" method="post">
					<div class="form-group">
						<button type="submit" name="ok" value="Save" class="btn btn-success">Add</button>
					</div>
				</form>
				</td>
				</tr>';
		}
	}
	echo '    </tbody>
            </table>
          </div>';
	
	
}
function get_passenger_count_refund($refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM refund_has_passengers WHERE refund_no='$refund_no' AND cancel_status='0'" );
	$num_rows = mysqli_num_rows ( $result );
	return $num_rows;
	
	
}
function check_repetive_passport_no_refund($refund_no, $passport_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ($conn, "SELECT id FROM refund_has_passengers WHERE refund_no='$refund_no' AND passport_no='$passport_no' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}
	
	
}
function add_passenger_to_refund($refund_no, $passport_no, $ticket_no, $visa_copy) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO refund_has_passengers (id, refund_no, passport_no, ticket_no, visa_copy, saved_by)
	VALUES ('', '$refund_no', '$passport_no', '$ticket_no', '$visa_copy', '$_SESSION[user_name]')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function delete_passenger_refund($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE refund_has_passengers SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}
function update_booking_has_passenger($passport_no, $booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE booking_has_passengers SET
	refund='1'
	WHERE booking_no='$booking_no' AND passport_no='$passport_no'";
	mysqli_query ($conn, $query );
	
	
}
function update_back_booking_has_passenger($passport_no, $booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE booking_has_passengers SET
	refund='0'
	WHERE booking_no='$booking_no' AND passport_no='$passport_no'";
	mysqli_query ($conn, $query );
	
	
}
function complete_refund($refund_no, $amount, $markup, $total) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$today = date ( "Y-m-d" );
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE refund SET
	status='1',
	amount='$amount',
	markup='$markup',
	fund_release_date='$today',
	total='$total',
	completed_by='$_SESSION[user_name]'
	WHERE refund_no='$refund_no'";
	mysqli_query ($conn, $query );
	
	
}
function send_mail_refund($to, $subject, $attachment, $refund_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_refund_info ( $refund_no );
	$booking_no = $info ['ref_no'];
	$voucher_no = check_voucher_has_booking_no ( $refund_info ['ref_no'] );
	$voucher_info = get_voucher_info ( $voucher_no );
	$travels = $voucher_info ['travels'];
	
	$mail = new PHPMailer ();
	
	$mail->IsSMTP (); // set mailer to use SMTP
	$mail->Host = "mail.flyjaffna.com"; // specify main and backup server
	$mail->SMTPAuth = true; // turn on SMTP authentication
	$mail->Username = "nationvoucher+flyjaffna.com"; // SMTP username
	$mail->Password = "Voucher_123"; // SMTP password
	
	$mail->From = "nationvoucher@flyjaffna.com";
	$mail->FromName = "NATION TRAVELS AND TOURS";
	$mail->AddAddress ( "$to", "$travels" );
	// $mail->AddAddress("ellen@example.com"); // name is optional
	$mail->AddReplyTo ( "nationvoucher@flyjaffna.com", "Nation" );
	
	$mail->WordWrap = 50; // set word wrap to 50 characters
	$mail->AddAttachment ( "$attachment" ); // add attachments
	
	echo "SELECT * FROM refund_has_passengers WHERE refund_no='$refund_no' AND cancel_status='0'";
	$result = mysqli_query ( $conn, "SELECT * FROM refund_has_passengers WHERE refund_no='$refund_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$mail->AddAttachment ( "$row[visa_copy]" );
		
		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0'" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			$mail->AddAttachment ( "$row1[passport]" );
		}
	}
	
	// $mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // optional name
	$mail->IsHTML ( true ); // set email format to HTML
	
	$mail->Subject = "$subject";
	$mail->Body = 'Please Check the Attached File <br />Thank You.
						<br /><h1><strong>NATION POPULAR TRAVELS & TOURS</strong></h1>
					16 1/2, E.S. Fernando Mawatha, Colombo 06<br />
					<strong>Hot Line :</strong> +94 11 4651199 <strong>Tel :</strong> +94 11 4375357 <strong>Fax :</strong> +94 11 4505532<br />
					<strong>E-mail :</strong> online@nationtravels.com <br />
					<strong>Web :</strong> nationtravels.com <br />';
	
	$mail->AltBody = "Please Check the Attached File
						Thank You.
						NATION POPULAR TRAVELS & TOURS
					16 1/2, E.S. Fernando Mawatha, Colombo 06
					Hot Line : +94 11 4651199 Tel : +94 11 4375357 Fax : +94 11 4505532
					E-mail : online@nationtravels.com
					Web : nationtravels.com ";
	if (! $mail->Send ()) {
		exit ();
	}
}


function list_refund_logbook($refund_no, $customer, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';

$today = date ( 'Y-m-d' );
	
	if ($refund_no) {
		$refund_no_check = "AND refund_no = '$refund_no'";
	} else {
		$refund_no_check = "";
	}
	
	if ($customer) {
		$customer_check = "AND customer LIKE '%$customer%'";
	} else {
		$customer_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND apply_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND apply_date>='$from_date'";
	} elseif ($to_date) {
		$date_check = "AND apply_date<='$to_date'";
	} else {
		$date_check = "";
	}

	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr class="info">
						   <th>R.No</th>
                           <th>Customer</th>
						   <th>Others</th>
						   <th>Receipt</th>
						   <th>Others</th>
						   <th>Paybill</th>
                           <th>B.Profit</th>
						   <th>A.Profit</th>
                           <th>Created By</th>
						   <th>Created</th>
                       </tr>
				   </thead>
                <tbody>';
	$ref_type = 'VISA';
	$result = mysqli_query ( $conn, "SELECT * FROM refund WHERE cancel_status='0' $branch_check $refund_no_check $customer_check $date_check ORDER BY id" );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		$other_income_amount = get_booking_other_income_amount ( $row['refund_no'], $ref_type );
		$receipt_amount = get_booking_receipt_amount ( $row [refund_no] );
		$other_expense_amount = get_booking_other_expense_amount ($row['refund_no'], $ref_type);
		$paybill_amount = get_booking_paybill_amount ( $row [refund_no] );
		$paybill_amount_other = get_booking_paybill_amount_other ( $row [refund_no] );

		$job_profit = ($_SESSION ['invoice_total'] + $_SESSION ['other_income_total']) - ($_SESSION ['voucher_total'] + $_SESSION ['other_expense_total']);
		$actual_profit = $_SESSION ['receipt_total'] - ($_SESSION ['paybill_total'] + $_SESSION ['paybill_total_other']);

		echo '<tr>
		
			<td><a href="refund.php?job=view&refund_no=' . $row [refund_no] . '"  class="btn btn-primary" target="_blank">' . $row ['refund_no'] . '</a></td>
				
					
		<td>
		' . $row [name] . '
		</td>


		<td id="amount_td" class="dark_green">
		' . $other_income_amount . '
		</td>

		<td id="amount_td" class="dark_green">
		' . $receipt_amount . '
		</td>


		<td id="amount_td" class="dark_green">
		' . $other_expense_amount . '
		</td>

		<td id="amount_td" class="dark_pink">
		' . $paybill_amount . '<br />' . $paybill_amount_other . '
		</td>

		<td id="amount_td">
		' . $job_profit . '
		</td>

		<td id="amount_td">
		' . $actual_profit . '
		</td>
			<td>' . $row ['completed_by'] . '</td>
			<td>' . $row ['saved'] . '</td>
		</tr>';
	}
	echo '			</tbody>
              	</table>
            </div>

			';

	
}
