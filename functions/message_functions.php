<?php

function save_message($message, $start_date, $end_date){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "INSERT INTO message (id, message, start_date, end_date, saved_by)
	VALUES ('', '$message', '$start_date', '$end_date', '$_SESSION[user_name]')";
	mysqli_query($conn, $query) or die (mysqli_connect_error());

	
}


function list_message(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive">
              <table class="table">
                  <thead>
                       <tr>

                           <th>Message</th>
                           <th>Start_Date</th>
                           <th>End Date</th>
							<th>Saved By</th>
						  
                       </tr>
                  </thead>
                  <tbody>';



	$i=1;
	$result=mysqli_query($conn, "SELECT * FROM message WHERE cancel_status='0'" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		echo '

		<td>'.$row[message].'</td>

		<td>'.$row[start_date].'</td>

		<td>'.$row[end_date].'</td>

		<td>'.$row[saved_by].'</td>


		<td><a href="message.php?job=delete&id='.$row[id].'" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-2x"></i></a></td>

		</tr>';

		$i++;

	}

	echo '</tbody>
          </table>
          </div>';

	
}



function cancel_product($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn, $dbname);
	$query = "UPDATE message SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query($conn, $query);


	
}