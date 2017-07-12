<?php
function list_customer_gift_voucher(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table id="example1"  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
                          <th>Customer Id</th>
                           <th>Customer Name</th>
							<th>Travel Time</th>
								<th>Total Amount</th>
								<th>Gift Voucher No</th>
							 <th>Gift Voucher Amount</th>
			               <th>Update</th>
                       </tr>
                  </thead>
                  <tbody>';
	
	

	$result=mysqli_query($conn, "SELECT * FROM customer WHERE cancel_status='0'" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		
		$info = get_gift_voucher_info_by_customer_id($row['customer_id']);
		
		if ($travel_time = count_customer_id($row['customer_id']) >  $travel_time = $info ['travel_time'])
		{
			$travel_time = count_customer_id($row['customer_id']);
			$total_amount = count_total($row['customer_id']);
			
			echo '<form role="form" action="gift_voucher.php?job=add&id=' . $row [id] . '&customer_id='.$row[customer_id].'" method="post">
			
				<tr>
			
		<td>'.$row[customer_id].'</td>
			
		<td>'.$row[customer_name].'</td>
			
		<td>'.$travel_time.'</td>
			
		<td>'.$total_amount.'</td>
			
		<td><input class="form-control" name="gift_voucher_no" value="'.$row[gift_voucher_no].'"></td>
			
<td>
				<div class="form-group">
									<select class="form-control" name="gift_voucher_amount" required>
										{if $gift_voucher_amount}
			
											<option value="" disabled selected> gift_voucher_amount</option>
										{/if}
										<option>500</option>
										<option>1000</option>
										<option>2000</option>
									</select>
		                   	 	</div>
</td>
			
		<td><button type="submit" name="ok" value="Add" class="btn btn-primary">Add</button></td>
			
		</tr>
			</form>';
			}
			
			else {
				
			}
			
			$i++;
			
			}
			
			echo '</tbody>
          </table>
          </div>';	


	include 'conf/closedb.php';
}


function get_gift_voucher_info_by_customer_id($customer_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ($conn, "SELECT * FROM gift_voucher WHERE customer_id='$customer_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
}

function list_customer_gift_voucher_list(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
                          <th>Customer Id</th>
                           <th>Customer Name</th>
							<th>Travel Time</th>
								<th>Total Amount</th>
								<th>Gift Voucher No</th>
							 <th>Gift Voucher Amount</th>
								 <th>Date</th>
                       </tr>
                  </thead>
                  <tbody>';



	$i=1;
	$result=mysqli_query($conn, "SELECT * FROM gift_voucher" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		
			echo '<tr>
			<td><div class="col-lg-1" style="color:white;"><a href="customer.php?job=view&customer_id=' . $row ['customer_id'] . '" class="btn btn-xs btn-primary" target="_blank">' . $row ['customer_id'] . '</a></div></td>
					

		<td>'.$row[customer_name].'</td>

		<td>'.$row[travel_time].'</td>

		<td>'.$row[total_amount].'</td>

		<td>'.$row[gift_voucher_no].'</td>

		<td>'.$row[gift_voucher_amount].'</td>
		
			<td>'.$row[date].'</td>
		
		</tr>
			</form>';
		
		$i++;

	}

	echo '</tbody>
          </table>
          </div>';

	include 'conf/closedb.php';
}



function save_gift_voucher($customer_id, $customer_name, $travel_time, $total_amount, $gift_voucher_no, $gift_voucher_amount){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m-d H:i:s" );
	mysqli_select_db($conn, $dbname);
	$query = "INSERT INTO gift_voucher (id, customer_id, customer_name, travel_time, total_amount, gift_voucher_no, gift_voucher_amount, date, saved_by)
	VALUES ('', '$customer_id', '$customer_name', '$travel_time', '$total_amount', '$gift_voucher_no', '$gift_voucher_amount', '$date', '$_SESSION[user_name]')";
	mysqli_query($conn, $query) or die (mysqli_connect_error());


}

function update_gift_voucher_no($id, $gift_voucher_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';


	mysqli_select_db ( $conn, $dbname );
	$query = "UPDATE customer SET
	gift_voucher_no='$gift_voucher_no'
	WHERE id='$id'";

	mysqli_query ($conn, $query );

	include 'conf/closedb.php';
}


function count_customer_id($customer_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ($conn, "SELECT COUNT(customer_id) FROM booking WHERE customer_id='$customer_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$total = $row ['COUNT(customer_id)'];
	}
	return $total;
}


function count_total($customer_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result = mysqli_query ($conn, "SELECT SUM(total) FROM receipt WHERE customer_id='$customer_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$total_amo = $row ['SUM(total)'];
	}

	return $total_amo;
}
