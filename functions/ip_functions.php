<?php

function list_ip($user_name, $to_date, $from_date){
	include 'conf/config.php';
	include 'conf/opendb.php';

	if($user_name){
		$user_name_check="user_name LIKE '$user_name'";
	}
	else{
		$user_name_check="";
	}
	
	if($to_date && $from_date){
		$date_check="time BETWEEN '$from_date' AND '$to_date'";
	}
	elseif($from_date){
		$date_check="time>='$from_date'";
		$limit="ORDER BY id DESC";
	}
	elseif($to_date){
		$date_check="time<='$to_date'";
		$limit="ORDER BY id DESC";
	}
	else{
		$date_check="";
		$limit="ORDER BY id DESC LIMIT 50";
	}
	
	if($user_name || $to_date || $from_date){
		$where="WHERE";
	}
	else {
		$where="";
	}
	
	if($date_check && $user_name_check){
		$and="AND";
	}
	else {
		$and="";
	}
	echo '<div class="table-responsive">
               <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>
                           <th>Username</th>
                           <th>IP</th>
                           <th>Time</th>
                       </tr>
                  </thead>
                  <tbody>'; 
                                    
    $i=1;
	$result=mysqli_query($conn, "SELECT * FROM ip_table $where $user_name_check $and $date_check $limit" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		if($i%4==0){
			echo '<tr class="info">';
		}
		elseif($i%3==0){
			echo '<tr class="warning">';
		}
		elseif($i%2==0){
			echo '<tr class="success">';
		}
		else {
			echo '<tr class="danger">';
		}

		echo '<td>'.$row[user_name].'</td>
					
		<td>'.$row[ip].'</td>
		
		<td>'.$row[time].'</td>
	
		</tr>';

		$i++;

	}
	
	echo '</tbody>
          </table>
          </div>';


}