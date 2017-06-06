<?php

function save_bank($bank, $acc_num, $user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "INSERT INTO bank (id, bank, acc_num, saved_by)
	VALUES ('', '$bank', '$acc_num', '$user_name')";
	mysqli_query($conn, $query) or die (mysqli_connect_error());


}

function update_bank($id, $bank, $acc_num, $user_name){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE bank SET
	bank='$bank',
	acc_num='$acc_num'
	WHERE id='$id'";

	mysqli_query($conn, $query);


}

function list_banks(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                       <tr>
                           <th>Edit</th>
                           <th>Bank</th>
                           <th>Account Number</th>
                           <th>Account Balance</th>
			               <th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';
                                        
                                    

    $i=1;
	$result=mysqli_query( $conn, "SELECT * FROM bank WHERE cancel_status='0' ORDER BY bank ASC" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		echo '<td><a href="add_bank.php?job=edit&id='.$row[id].'"  ><i class="fa fa-edit fa-2x"></i></a></td>

		<td>'.$row[bank].'</td>
					
		<td>'.$row[acc_num].'</td>
					
		<td>'.$row[balance].'</td>
					
		<td><a href="add_bank.php?job=delete&id='.$row[id].'" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>
	
		</tr>';

		$i++;

	}
	
	echo '</tbody>
          </table>
          </div>';


}

function get_bank_info($bank) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query( $conn, "SELECT * FROM bank WHERE bank='$bank' AND cancel_status='0'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}

}

function get_bank_info_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM bank WHERE id='$user_id' AND cancel_status='0'" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}

}

function cancel_bank($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE bank SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query($conn, $query);



}

function update_balance($account, $amount){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info=get_bank_info($account);
	$new_balance=$info['balance']+$amount;
	
	mysqli_select_db($conn, $dbname);
	$query = "UPDATE bank SET
	balance='$new_balance'
	WHERE bank='$account'";
	mysqli_query($conn, $query);
		

}

function reupdate_balance($dep_no){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$info=get_deposit_info($dep_no);
	$balance_info=get_bank_info($info['account']);
	$new_balance=$balance_info['balance']-$info['amount'];
	
	mysqli_select_db($conn, $dbname);
	$query = "UPDATE bank SET
	balance='$new_balance'
	WHERE bank='$info[account]'";
	mysqli_query($conn, $query);
		

}

function reupdate_balance_from_reconciliation($account, $amount){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$balance_info=get_bank_info($account);
	$new_balance=$balance_info['balance']-$amount;

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE bank SET
	balance='$new_balance'
	WHERE bank='$account'";
	mysqli_query($conn, $query);


}

function update_balance_withdraw($account, $amount){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$info=get_bank_info($account);
	$new_balance=$info['balance']-$amount;

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE bank SET
	balance='$new_balance'
	WHERE bank='$account'";
	mysqli_query($conn, $query);


}

function reupdate_balance_withdraw($with_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$info=get_withdraw_info($with_no);
	$balance_info=get_bank_info($info['account']);
	$new_balance=$balance_info['balance']+$info['amount'];

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE bank SET
	balance='$new_balance'
	WHERE bank='$info[account]'";
	mysqli_query($conn, $query);


}

function save_deposit($dep_no, $date, $account, $amount, $narration, $saved_by) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "INSERT INTO deposit (id, dep_no, date, account, amount, narration, saved_by, branch)
	VALUES ('', '$dep_no', '$date', '$account', '$amount', '$narration', '$saved_by', '$_SESSION[branch]')";
	mysqli_query($conn, $query) or die (mysqli_connect_error());


}

function get_dep_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query( $conn,"SELECT MAX(dep_no) FROM deposit");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(dep_no)']+1;
	}


}

function list_deposit() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                       <tr>
							<th>Deposit No</th>
							<th>Date</th>
							<th>Account</th>
							<th>Amount</th>
							<th>Narration</th>
							<th>Saved By</th>
							<th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';

	$result=mysqli_query( $conn,"SELECT * FROM deposit WHERE cancel_status = '0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
		<td>
		'.$row[dep_no].'
		</td>

		<td>
		 '.$row[date].'
		</td>
					<td>
		 '.$row[account].'
		</td>
					<td>
		 '.$row[amount].'
		</td>
		<td>
		 '.$row[narration].'
		</td>
					<td>
		 '.$row[saved_by].'
		</td>

		<td>
		<a href="deposit.php?job=delete&dep_no='.$row[dep_no].'" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a>
		</td>

		</tr>
		';
	}

	echo '</tbody>
          </table>
          </div>';


}

function get_deposit_info($dep_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM deposit WHERE dep_no='$dep_no'" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}


}

function delete_deposit($dep_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE deposit SET
	cancel_status='1'
	WHERE dep_no='$dep_no'";
	mysqli_query($conn, $query);

}
function save_withdraw($with_no, $date, $account, $amount, $narration, $saved_by) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "INSERT INTO withdraw (id, with_no, date, account, amount, narration, saved_by, branch)
	VALUES ('', '$with_no', '$date', '$account', '$amount', '$narration', '$saved_by', '$_SESSION[branch]')";
	mysqli_query($conn, $query) or die (mysqli_connect_error());


}

function get_with_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query( $conn, "SELECT MAX(with_no) FROM withdraw");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(with_no)']+1;
	}


}

function list_withdraw() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                       <tr>
							<th>withdraw No</th>
							<th>Date</th>
							<th>Account</th>
							<th>Amount</th>
							<th>Narration</th>
							<th>Saved By</th>
							<th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';

	$result=mysqli_query( $conn, "SELECT * FROM withdraw WHERE cancel_status = '0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
		<td>
		'.$row[with_no].'
		</td>

		<td>
		 '.$row[date].'
		</td>
					<td>
		 '.$row[account].'
		</td>
		<td>
		 '.$row[amount].'
		</td>
		<td>
		 '.$row[narration].'
		</td>
					<td>
		 '.$row[saved_by].'
		</td>

		<td>
		<a href="withdraw.php?job=delete&with_no='.$row[with_no].'" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a>
		</td>

		</tr>
		';
	}

	echo '</tbody>
          </table>
          </div>';


}

function get_withdraw_info($with_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query( $conn, "SELECT * FROM withdraw WHERE with_no='$with_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}


}

function delete_withdraw($with_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE withdraw SET
	cancel_status='1'
	WHERE with_no='$with_no' AND cancel_status='0'";
	mysqli_query($conn, $query);


}

function save_transfer($transfer_no, $dep_no, $with_no, $date, $from_bank, $to_bank, $amount, $narration, $saved_by) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "INSERT INTO transfer (id, transfer_no, dep_no, with_no, date, from_bank, to_bank, amount, narration, saved_by)
	VALUES ('', '$transfer_no', '$dep_no', '$with_no', '$date', '$from_bank', '$to_bank', '$amount', '$narration', '$saved_by')";
	mysqli_query($conn, $query) or die (mysqli_connect_error());


}


function get_transfer_no() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query( $conn, "SELECT MAX(transfer_no) FROM transfer");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row['MAX(transfer_no)']+1;
	}


}

function list_transfer() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                  <thead>
                       <tr>
							<th>Transfer No</th>
							<th>Deposit No</th>
							<th>withdraw No</th>
							<th>Date</th>
							<th>From Bank</th>
							<th>To Bank</th>
							<th>Amount</th>
							<th>Narration</th>
							<th>Saved By</th>
							<th>Delete</th>
                       </tr>
                  </thead>
                  <tbody>';

	$result=mysqli_query( $conn, "SELECT * FROM transfer WHERE cancel_status = '0' ORDER BY id DESC");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		echo '
		<tr>
		<td>
		'.$row[transfer_no].'
		</td>
				
		<td>
		'.$row[dep_no].'
		</td>
				
		<td>
		'.$row[with_no].'
		</td>

		<td>
		 '.$row[date].'
		</td>
					<td>
		 '.$row[from_bank].'
		</td>
					<td>
		 '.$row[to_bank].'
		</td>
					<td>
		 '.$row[amount].'
		</td>
		<td>
		 '.$row[narration].'
		</td>
					<td>
		 '.$row[saved_by].'
		</td>

		<td>
		<a href="transfer.php?job=delete&transfer_no='.$row[transfer_no].'" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a>
		</td>

		</tr>
		';
	}

	echo '</tbody>
          </table>
          </div>';


}

function get_transfer_info($transfer_no){
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query( $conn, "SELECT * FROM transfer WHERE transfer_no='$transfer_no'");
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}

}

function delete_transfer($transfer_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE transfer SET
	cancel_status='1'
	WHERE transfer_no='$transfer_no' AND cancel_status='0'";
	mysqli_query($conn, $query);

}