<?php
function add_invoice_ledger($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM invoice WHERE invoice_no = '$invoice_no' AND cancel_status='0' ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$date = $row ['invoice_date'];
		$flag = 'INVOICE-' . $row [type];
		$invoice_no = $ref_no = $row ['invoice_no'];
		$narration = addslashes ( $row ['customer'] );
		$total = $row ['total'];
		$account = $row ['type'];
		$branch = $row ['branch'];
		
		mysqli_select_db ($conn, $dbname ) or die ( mysqli_connect_error () );
		
		mysqli_select_db ($conn, $dbname );
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, branch, customer_id)
		VALUES ('$account', '$date', '$flag', '$ref_no', '$narration', '', '$total', '$branch', '$row[customer_id]')";
		mysqli_query ($conn, $query1 ) or die ( mysqli_connect_error () );
		
		mysqli_select_db ($conn, $dbname );
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, branch, customer_id)
		VALUES ('$narration', '$date', '$flag', '$ref_no', '$account', '$total', '', '$branch', '$row[customer_id]')";
		mysqli_query ($conn, $query2 ) or die ( mysqli_connect_error () );
	}
	

}
function transfer_ledger_to($to_user, $invoice_no, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$query = "UPDATE ledger SET
	updated_by='$to_user',
	branch='$branch'
	WHERE ref_no='$invoice_no' AND flag LIKE 'INVOICE-%'";
	mysqli_query ($conn, $query );
	

}
function add_other_expenses_ledger($other_expenses_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM other_expenses WHERE other_expenses_no = '$other_expenses_no' AND cancel_status='0' ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$date = $row ['other_expenses_date'];
		$flag = 'OTHER-EXPENSES';
		$other_expenses_no = $ref_no = $row ['other_expenses_no'];
		$narration = addslashes ( $row ['customer'] );
		$total = $row ['total'];
		$account = $row ['ref_type'];
		$branch = $row ['branch'];
		
		mysqli_select_db ($conn, $dbname ) or die ( mysqli_connect_error () );
		
		mysqli_select_db ($conn, $dbname );
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, branch, customer_id)
		VALUES ('$account', '$date', '$flag', '$ref_no', '$narration', '', '$total', '$branch', '$row[customer_id]')";
		mysqli_query ($conn, $query1 ) or die ( mysqli_connect_error () );
		
		mysqli_select_db ($conn, $dbname );
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, branch, customer_id)
		VALUES ('$narration', '$date', '$flag', '$ref_no', '$account', '$total', '', '$branch', '$row[customer_id]')";
		mysqli_query ($conn, $query2 ) or die ( mysqli_connect_error () );
	}
	

}
function update_invoice_ledger($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$invoice_info = get_invoice_info ( $invoice_no );
	$account = 'OTHER INCOMES';
	$date = $invoice_info ['invoice_date'];
	$flag = 'INVOICE';
	$total = $invoice_info ['total'];
	$narration = addslashes ( $invoice_info ['customer'] );
	
	mysqli_select_db ($conn, $dbname );
	$query1 = "UPDATE ledger SET
	account='$account',
	date='$date',
	flag='$flag',
	narration='$narration',
	credit='$total',
	remarks='$remarks'
	WHERE ref_no='$invoice_no' AND flag='INVOICE' AND debit='0' AND cancel_status='0'";
	mysqli_query ($conn, $query1 );
	
	mysqli_select_db ($conn, $dbname );
	$query2 = "UPDATE ledger SET
	account='$narration',
	date='$date',
	flag='$flag',
	narration='$account',
	debit='$total',
	remarks='$remarks'
	WHERE flag='INVOICE' AND ref_no ='$invoice_no' AND credit='0' AND cancel_status='0'";
	mysqli_query ($conn, $query2 );
	

}
function add_description_ledger($invoice_no, $description, $amount) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$id = get_invoice_description_id ( $invoice_no );
	$date = date ( "Y-m-d" );
	$flag = 'INV_DES';
	$account = addslashes ( $description );
	$narration = 'OTHER INCOMES';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, remarks)
	VALUES ('$account', '$date', '$flag', '$id', '$narration', '', '$amount', '$invoice_no')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function add_description_ledger_other_expenses($other_expenses_no, $description, $amount) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$id = get_other_expenses_description_id ( $other_expenses_no );
	$date = date ( "Y-m-d" );
	$flag = 'OTHER_EXPENSES_DES';
	$account = addslashes ( $description );
	$narration = 'OTHER EXPENSES';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, remarks)
	VALUES ('$account', '$date', '$flag', '$id', '$narration', '$amount', '', '$other_expenses')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	

}
function delete_invoice_ledger($invoice_no, $flag) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='$flag' AND ref_no ='$invoice_no'";
	mysqli_query ($conn, $query );
}
function delete_other_expenses_ledger($other_expenses) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='OTHER-EXPENSES' AND ref_no ='$other_expenses'";
	mysqli_query ($conn, $query );
}
function delete_description_ledger($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='INV_DES' AND ref_no ='$id'";
	mysqli_query ($conn, $query );
	

}
function delete_all_description_ledger($invoice_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='INV_DES' AND remarks='$invoice_no'";
	mysqli_query ($conn, $query );
	

}
function delete_other_expenses_description_ledger($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='OTHER_EXPENSES_DES' AND ref_no ='$id'";
	mysqli_query ($conn, $query );
	

}
function delete_all_other_expenses_description_ledger($other_expenses) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='OTHER_EXPENSES_DES' AND ref_no='$other_expenses'";
	mysqli_query ($conn, $query );
	

}
function add_receipt_ledger($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM receipt WHERE rec_no='$rec_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$date = $row ['date'];
		$flag = 'RECEIPT';
		$rec_no = $ref_no = $row ['rec_no'];
		$customer = addslashes ( $row ['customer_name'] );
		$cheque_amount = $row ['cheque_amount'];
		$cheque_no = $row ['cheque_no'];
		$cheque_bank = $row ['cheque_bank'];
		$cash_amount = $row ['cash_amount'];
		$card_amount = $row ['card_amount'];
		$card_no = $row ['card_no'];
		$dep_amount = $row ['dep_amount'];
		$bank = $row ['bank'];
		$ez_amount = $row ['ez_amount'];
		$ez_ref = $row ['ref_no'];
		$cash_amount = $row ['cash_amount'];
		$branch = $row ['brance'];
		
		if ($cheque_amount > 0) {
			
			mysqli_select_db ($conn, $dbname );
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, cheque_bank, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '', '$cheque_amount', '$cheque_no', '$cheque_bank', '$branch')";
			mysqli_query ($conn, $query1 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ($conn, $dbname );
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, cheque_bank, branch)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$customer', '$cheque_amount', '', '$cheque_no', '$cheque_bank', '$branch')";
			mysqli_query ($conn, $query2 ) or die ( mysqli_connect_error () );
		}
		
		if ($cash_amount > 0) {
			
			mysqli_select_db ($conn, $dbname );
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'CASH', '', '$cash_amount', '$branch')";
			mysqli_query ($conn, $query3 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ($conn, $dbname );
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, branch)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$customer', '$cash_amount', '', '$branch')";
			mysqli_query ($conn, $query4 ) or die ( mysqli_connect_error () );
		}
		
		if ($dep_amount > 0) {
			
			mysqli_select_db ($conn, $dbname );
			$query5 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, acc_no, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'BANK', '', '$dep_amount', '$bank', '$branch')";
			mysqli_query ($conn, $query5 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ($conn, $dbname );
			$query6 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, acc_no, branch)
			VALUES ('BANK', '$date', '$flag', '$ref_no', '$customer', '$dep_amount', '', '$bank', '$branch')";
			mysqli_query ($conn, $query6 ) or die ( mysqli_connect_error () );
		}
		
		if ($card_amount > 0) {
			
			mysqli_select_db ($conn, $dbname );
			$query7 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, card_no, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'BANK BY CARD', '', '$card_amount', '$card_no', '$branch')";
			mysqli_query ($conn, $query7 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ($conn, $dbname );
			$query8 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, card_no, branch)
			VALUES ('BANK BY CARD', '$date', '$flag', '$ref_no', '$customer', '$card_amount', '', '$card_no', '$branch')";
			mysqli_query ($conn, $query8 ) or die ( mysqli_connect_error () );
		}
		
		if ($ez_amount > 0) {
			
			mysqli_select_db ($conn, $dbname );
			$query9 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, ez_ref, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'EZ CASH', '', '$ez_amount', '$ez_ref', '$branch')";
			mysqli_query ($conn, $query9 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ($conn, $dbname );
			$query10 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, ez_ref, branch)
			VALUES ('EZ CASH', '$date', '$flag', '$ref_no', '$customer', '$ez_amount', '', '$ez_ref', '$branch')";
			mysqli_query ($conn, $query10 ) or die ( mysqli_connect_error () );
		}
	}
	

}
function delete_receipt_ledger($rec_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='RECEIPT' AND ref_no ='$rec_no'  AND cancel_status='0'";
	mysqli_query ($conn, $query );
	

}
function add_voucher_ledger($voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM voucher WHERE voucher_no = '$voucher_no' AND cancel_status='0' ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$date = $row ['voucher_date'];
		$flag = 'VOUCHER';
		$voucher_no = $ref_no = $row ['voucher_no'];
		$narration = addslashes ( $row ['travels'] );
		
		$account = 'Ticket';
		
		mysqli_select_db ($conn, $dbname ) or die ( mysqli_connect_error () );
		mysqli_select_db ($conn, $dbname );
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, customer_id)
		VALUES ('$account', '$date', '$flag', '$ref_no', '$narration', '$total', '', '$row[customer_id]')";
		mysqli_query ($conn, $query1 ) or die ( mysqli_connect_error () );
		
		mysqli_select_db ($conn, $dbname );
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, customer_id)
		VALUES ('$narration', '$date', '$flag', '$ref_no', '$account', '', '$total', '$row[customer_id]')";
		mysqli_query ($conn, $query2 ) or die ( mysqli_connect_error () );
	}
	

}
function delete_voucher_ledger($voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='VOUCHER' AND ref_no ='$voucher_no'  AND cancel_status='0'";
	mysqli_query ($conn, $query );
	

}
function add_paybill_ledger($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM paybill WHERE paybill_no='$paybill_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$date = $row ['date'];
		$flag = 'PAYBILL';
		$paybill_no = $paybill_no = $row ['paybill_no'];
		$customer = addslashes ( $row ['customer_name'] );
		$cheque_amount = $row ['cheque_amount'];
		$cheque_no = $row ['cheque_no'];
		$cheque_bank = $row ['cheque_bank'];
		$cash_amount = $row ['cash_amount'];
		$card_amount = $row ['card_amount'];
		$card_no = $row ['card_no'];
		$dep_amount = $row ['dep_amount'];
		$bank = $row ['bank'];
		$ez_amount = $row ['ez_amount'];
		$ez_ref = $row ['ref_no'];
		$cash_amount = $row ['cash_amount'];
		$branch = $row ['brance'];
		
		if ($cheque_amount > 0) {
			
			mysqli_select_db ( $dbname );
			$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, cheque_bank, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'CHEQUES IN HAND', '$cheque_amount', '', '$cheque_no', '$cheque_bank', '$branch')";
			mysqli_query ( $query1 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ( $dbname );
			$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no, cheque_bank, branch)
			VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', '$customer', '', '$cheque_amount', '$cheque_no', '$cheque_bank', '$branch')";
			mysqli_query ( $query2 ) or die ( mysqli_connect_error () );
		}
		
		if ($cash_amount > 0) {
			
			mysqli_select_db ( $dbname );
			$query3 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'CASH', '$cash_amount', '', '$branch')";
			mysqli_query ( $query3 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ( $dbname );
			$query4 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, branch)
			VALUES ('CASH', '$date', '$flag', '$ref_no', '$customer', '', '$cash_amount', '$branch')";
			mysqli_query ( $query4 ) or die ( mysqli_connect_error () );
		}
		
		if ($dep_amount > 0) {
			
			mysqli_select_db ( $dbname );
			$query5 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, acc_no, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'BANK', '$dep_amount', '', '$bank', '$branch')";
			mysqli_query ( $query5 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ( $dbname );
			$query6 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, acc_no, branch)
			VALUES ('BANK', '$date', '$flag', '$ref_no', '$customer', '', '$dep_amount', '$bank', '$branch')";
			mysqli_query ( $query6 ) or die ( mysqli_connect_error () );
		}
		
		if ($card_amount > 0) {
			
			mysqli_select_db ( $dbname );
			$query7 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, card_no, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'BANK BY CARD', '$card_amount', '', '$card_no', '$branch')";
			mysqli_query ( $query7 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ( $dbname );
			$query8 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, card_no, branch)
			VALUES ('BANK BY CARD', '$date', '$flag', '$ref_no', '$customer', '', '$card_amount', '$card_no', '$branch')";
			mysqli_query ( $query8 ) or die ( mysqli_connect_error () );
		}
		
		if ($ez_amount > 0) {
			
			mysqli_select_db ( $dbname );
			$query9 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, ez_ref, branch)
			VALUES ('$customer', '$date', '$flag', '$ref_no', 'EZ CASH', '$ez_amount', '', '$ez_ref', '$branch')";
			mysqli_query ( $query9 ) or die ( mysqli_connect_error () );
			
			mysqli_select_db ( $dbname );
			$query10 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, ez_ref, branch)
			VALUES ('EZ CASH', '$date', '$flag', '$ref_no', '$customer', '', '$ez_amount', '$ez_ref', '$branch')";
			mysqli_query ( $query10 ) or die ( mysqli_connect_error () );
		}
	}
	

}
function delete_paybill_ledger($paybill_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='PAYBILL' AND ref_no ='$paybill_no'  AND cancel_status='0'";
	mysqli_query ($conn, $query );
	

}
function add_deposit_ledger($dep_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM deposit WHERE dep_no=$dep_no " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$date = $row ['date'];
		$flag = 'DEPOSIT';
		$ref_no = $dep_no;
		$account = $row ['account'];
		$narration = $row ['narration'];
		$amount = $row ['amount'];
		
		mysqli_select_db ($conn, $dbname );
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit)
		VALUES ('cash', '$date', '$flag', '$ref_no', '$narration', '', '$amount')";
		mysqli_query ($conn, $query1 ) or die ( mysqli_connect_error () );
		
		mysqli_select_db ($conn, $dbname );
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit)
		VALUES ('$account', '$date', '$flag', '$ref_no', '$narration', '$amount', '')";
		mysqli_query ($conn, $query2 ) or die ( mysqli_connect_error () );
	}
	

}
function delete_deposit_ledger($dep_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='DEPOSIT' AND ref_no ='$dep_no'";
	mysqli_query ($conn, $query );
}
function add_withdraw_ledger($with_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM withdraw WHERE with_no=$with_no " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$date = $row ['date'];
		$flag = 'WITHDRAW';
		$ref_no = $with_no;
		$account = $row ['account'];
		$narration = $row ['narration'];
		$amount = $row ['amount'];
		
		mysqli_select_db ($conn, $dbname );
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit)
		VALUES ('cash', '$date', '$flag', '$ref_no', '$narration', '$amount', '')";
		mysqli_query ($conn, $query1 ) or die ( mysqli_connect_error () );
		
		mysqli_select_db ($conn, $dbname );
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit)
		VALUES ('$account', '$date', '$flag', '$ref_no', '$narration', '', '$amount')";
		mysqli_query ($conn, $query2 ) or die ( mysqli_connect_error () );
	}
	

}
function delete_withdraw_ledger($with_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='WITHDRAW' AND ref_no ='$with_no' AND cancel_status='0'";
	mysqli_query ($conn, $query );
}
function add_ledger_cheque_deposit($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM cheque_inventory WHERE id='$id' ORDER BY id ASC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$date = $row ['dep_date'];
		$flag = 'CHEQUE DEPOSIT';
		$rec_ref = $ref_no = $row ['rec_ref'];
		$customer = addslashes ( $row ['customer'] );
		$che_amount = $row ['che_amount'];
		$che_no = $row ['che_no'];
		$dep_bank = $row ['dep_account_no'];
		$job_no = '';
		
		mysqli_select_db ($conn, $dbname );
		$query1 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
		VALUES ('CHEQUES IN HAND', '$date', '$flag', '$ref_no', 'DEPOSITED', '', '$che_amount', '$che_no')";
		mysqli_query ($conn, $query1 ) or die ( mysqli_connect_error () );
		
		mysqli_select_db ($conn, $dbname );
		$query2 = "INSERT INTO ledger (account, date, flag, ref_no, narration, debit, credit, cheque_no)
		VALUES ('$dep_bank', '$date', '$flag', '$ref_no', '$customer', '$che_amount', '', '$che_no')";
		mysqli_query ($conn, $query2 ) or die ( mysqli_connect_error () );
	}
	

}
function delete_cheque_deposit_ledger($rec_ref) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE ledger SET
	cancel_status='1'
	WHERE flag='CHEQUE DEPOSIT' AND ref_no ='$rec_ref'";
	mysqli_query ($conn, $query );
}