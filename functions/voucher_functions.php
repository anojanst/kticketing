<?php
function check_voucher_has_booking_no($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT voucher_no FROM voucher WHERE booking_no='$booking_no' AND cancel_status='0' ORDER BY id DESC LIMIT 1" );
	while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
		return $row ['voucher_no'];
	}
	
	
}
function check_booking_has_visa_and_passport($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysql_num_rows ( mysqli_query ( "SELECT id FROM booking_has_passengers WHERE booking_no='$booking_no' AND visa_copy LIKE 'visa_copy%' AND cancel_status='0'" ) )) {
		
		$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND visa_copy LIKE 'visa_copy%' AND cancel_status='0'" );
		while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
			if (mysql_num_rows ( mysqli_query ( "SELECT id FROM customer WHERE passport_no='$row[passport_no]' AND passport LIKE 'passports%' AND cancel_status='0'" ) )) {
				return 1;
			} else {
				return 0;
			}
		}
	} else {
		return 0;
	}
	
	
}
function get_voucher_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT MAX(voucher_no) FROM voucher WHERE  cancel_status='0' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
		return $row ['MAX(voucher_no)'] + 1;
	}
	
	
}
function add_voucher($booking_no, $pnr, $voucher_no, $voucher_date, $travels, $travels_id, $fare, $taxes, $saved_by, $btt_or_less, $bol_amount, $total, $sub_tot, $time_limit) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO voucher (booking_no, pnr, voucher_no,  voucher_date, travels, customer_id, fare, taxes, saved_by, btt_or_less, bol_amount, total, sub_tot, due, time_limit)
	VALUES ('$booking_no', '$pnr', '$voucher_no',  '$voucher_date', '$travels', '$travels_id', '$fare', '$taxes', '$saved_by', '$btt_or_less', '$bol_amount', '$total', '$sub_tot', '$total', '$time_limit')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function check_voucher_paybill_status($voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT pay_status FROM voucher WHERE voucher_no='$voucher_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
		if ($row ['paybill_status'] > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	
}
function delete_voucher($voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE voucher SET
	cancel_status='1'
	WHERE voucher_no='$voucher_no'";
	mysqli_query ($conn, $query );
	
	
}
function update_issue_status_for_passenger($id, $booking_no, $voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE booking_has_passengers SET
	issue_status='1',
	voucher_no='$voucher_no'
	WHERE booking_no='$booking_no' AND id='$id'";
	mysqli_query ($conn, $query );
	
	
}
function reupdate_issue_status_for_passenger($booking_no, $voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE booking_has_passengers SET
	issue_status='0',
	voucher_no=''
	WHERE booking_no='$booking_no' AND voucher_no='$voucher_no'";	
	mysqli_query ($conn, $query );
	
	
}
function check_waiting_pax_to_issue($booking_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysql_num_rows ( mysqli_query ( "SELECT id FROM booking_has_passengers WHERE booking_no = '$booking_no' AND issue_status='0' AND cancel_status='0'" ) )) {
		return 1;
	} else {
		return 0;
	}
}
function list_voucher() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
	<tr class="danger" style="font-weight: bold;">

	<td>Print</td>
	<td>View</td>
	<td>Send</td>
	<td>Cancel</td>
	<td>No</td>
	<td>Travels</td>
	<td>Booking</td>
	<td>PNR</td>
	<td align="right">Fare</td>
	<td align="right">BTT/LessCOM</td>
	<td align="right">Taxes</td>
	<td align="right">Total</td>
	</tr>';
	
	$today = date ( "Y-m-d" );
	$total = 0;
	$result = mysqli_query ($conn, "SELECT * FROM voucher WHERE cancel_status='0' AND voucher_date='$today' ORDER BY id" );
	while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
		
		echo '
		<tr>

		<td>
		<a href="voucher.php?job=print&voucher_no=' . $row [voucher_no] . '" target="blank"><i class="fa fa-print fa-lg"></i></a>
		</td>

		<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [voucher_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>
				
		<td>
		<a href="voucher.php?job=send&voucher_no=' . $row [voucher_no] . '"><i class="fa fa-share fa-lg"></i></a>
		</td>

		<td>
		<a href="voucher.php?job=delete_voucher&voucher_no=' . $row [voucher_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a>
		</td>

		<td>
		' . $row [voucher_no] . '
		</td>

		<td>
		 ' . $row [travels] . '
		</td>

		 <td>
		 ' . $row [booking_no] . '
		</td>

		<td>
		 ' . $row [pnr] . '
		</td>

		 <td align="right">
		 ' . $row [fare] . '
		</td>
		 
		 <td align="right">
		 ' . $row [btt_or_less] . ' ' . $row [bol_amount] . '
		</td>
		 
		 <td align="right">
		 ' . $row [taxes] . '
		</td>
			
		 <td align="right" class="success">
		 ' . $row [total] . '
		</td>
		
		

		</tr>
		<div class="modal fade" id="' . $row [voucher_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [voucher_no] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">voucher
			      </div>
			      <div class="modal-body">
			        <iframe src="voucher.php?job=view&voucher_no=' . $row [voucher_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
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
		<td colspan="10" align="right"><strong></strong></td>
		<td align="right" class="danger"><strong>Today Total</strong></td>
			
		 <td align="right" class="danger">
		 <strong>' . $formated . '</strong>
		</td>

		</tr></table></div>';
	
	
}
function search_voucher($voucher_no, $travels, $from_date, $to_date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$today = date ( 'Y-m-d' );
	
	if ($voucher_no) {
		$voucher_no_check = "AND voucher_no = '$voucher_no'";
	} else {
		$voucher_no_check = "";
	}
	
	if ($travels) {
		$travels_check = "AND travels LIKE '%$travels%'";
	} else {
		$travels_check = "";
	}
	
	if ($to_date && $from_date) {
		$date_check = "AND voucher_date BETWEEN '$from_date' AND '$to_date'";
	} elseif ($from_date) {
		$date_check = "AND voucher_date>='$from_date'";
	} elseif ($to_date) {
		$date_check = "AND voucher_date<='$to_date'";
	} else {
		$date_check = "";
	}
	
	if ($voucher_no_check || $travels_check || $date_check) {
	} else {
		$date_check = "AND voucher_date='$today'";
	}
	echo '<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
	<tr class="danger" style="font-weight: bold;">

	<td>Print</td>
	<td>View</td>
	<td>Send</td>
	<td>Cancel</td>
	<td>No</td>
	<td>Travels</td>
	<td>Booking</td>
	<td>PNR</td>
	<td align="right">Fare</td>
	<td align="right">BTT/LessCOM</td>
	<td align="right">Taxes</td>
	<td align="right">Total</td>
	</tr>';
	
	$total = 0;
	$result = mysqli_query ($conn, "SELECT * FROM voucher WHERE cancel_status='0' $voucher_no_check $travels_check $date_check ORDER BY id" );
	while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
		
		echo '
		<tr>

		<td>
		<a href="voucher.php?job=print&voucher_no=' . $row [voucher_no] . '" target="blank"><i class="fa fa-print fa-lg"></i></a>
		</td>

		<td>
		<a href="#" data-toggle="modal" data-target="#' . $row [voucher_no] . '"><i class="fa fa-newspaper-o fa-lg"></i></a>
		</td>

		<td>
		<a href="voucher.php?job=send&voucher_no=' . $row [voucher_no] . '"><i class="fa fa-share fa-lg"></i></a>
		</td>

		<td>
		<a href="voucher.php?job=delete_voucher&voucher_no=' . $row [voucher_no] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a>
		</td>

		<td>
		' . $row [voucher_no] . '
		</td>

		<td>
		 ' . $row [travels] . '
		</td>

		 <td>
		 ' . $row [booking_no] . '
		</td>

		<td>
		 ' . $row [pnr] . '
		</td>

		 <td align="right">
		 ' . $row [fare] . '
		</td>
		
		 <td align="right">
		 ' . $row [btt_or_less] . ' ' . $row [bol_amount] . '
		</td>
		
		 <td align="right">
		 ' . $row [taxes] . '
		</td>
		
		 <td align="right" class="success">
		 ' . $row [total] . '
		</td>



		</tr>
		<div class="modal fade" id="' . $row [voucher_no] . '" tabindex="-1" role="dialog" aria-labelledby="' . $row [voucher_no] . '" aria-hidden="true">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <div class="modal-header">voucher
			      </div>
			      <div class="modal-body">
			        <iframe src="voucher.php?job=view&voucher_no=' . $row [voucher_no] . '" style="zoom:0.60" frameborder="0" height="500" width="99.6%"></iframe>
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
		<td colspan="10" align="right"><strong></strong></td>
		<td align="right" class="danger"><strong>Total</strong></td>
		
		 <td align="right" class="danger">
		 <strong>' . $formated . '</strong>
		</td>

		</tr></table></div>';
	
	
}
function get_voucher_info($voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM voucher WHERE voucher_no='$voucher_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
		return $row;
	}
}
function send_mail($to, $subject, $attachment, $voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info = get_voucher_info ( $voucher_no );
	$booking_no = $info ['booking_no'];
	
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
	
	$result = mysqli_query ($conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$booking_no' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQL_ASSOC ) ) {
		$mail->AddAttachment ( "$row[visa_copy]" );
		
		$result1 = mysqli_query ($conn, "SELECT * FROM customer WHERE passport_no='$row[passport_no]' AND cancel_status='0'" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQL_ASSOC ) ) {
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
