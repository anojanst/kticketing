<?php

function save_branch_target($branch, $amount, $date){
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db($conn,$dbname);
	$query = "INSERT branch_target (id, branch, amount, date, saved_by)
	VALUES ('', '$branch', '$amount', '$date', '$_SESSION[user_name]')";
	mysqli_query($conn,$query) or die (mysqli_connect_error());

	
}


function list_branch_target(){
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="box-body">
              <table id="example1" style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
                  <thead>
                       <tr>

                           <th>Branch</th>
                           <th>Amount</th>
                           <th>Date</th>
							<th>Saved By</th>
						  
                       </tr>
                  </thead>
                  <tbody>';

	$result=mysqli_query($conn, "SELECT * FROM branch_target WHERE cancel_status='0'" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

		echo '
		<tr>
		<td>'.$row[branch].'</td>

		<td>'.$row[amount].'</td>

		<td>'.$row[date].'</td>

		<td>'.$row[saved_by].'</td>

		</tr>';

	}

	echo '</tbody>
          </table>
          </div>';

	
}

function branch_target_month($branch, $date) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date ( "Y-m", strtotime ( $date ) );

	$result = mysqli_query ($conn, "SELECT SUM(amount) FROM branch_target WHERE date LIKE '$date%' AND branch='$branch' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$tar = $row ['SUM(amount)'];
	}

	$result = mysqli_query ( $conn, "SELECT SUM(total) FROM receipt WHERE date LIKE '$date%' AND branch='$branch' AND cancel_status=0 " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$tot = $row ['SUM(total)'];
	}
	if ($tar > 0) {
		$percentage = round ( (($tot / $tar) * 100), 1 );

		echo '<p>
		<strong><font color="#8e44ad">' . $tot . '</font><font color="#7f8c8d">/</font><font color="#c0392b">' . $tar . '</font></strong>
		<span class="pull-right text-muted"><font color="#7f8c8d">' . $percentage . '%</font></span>
		</p>';

		if ($percentage == 0) {
			$percentage = 0.1;
			echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
	                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
	                </div>
	            </div>';
		} elseif (0 < $percentage and $percentage < 30) {
			echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
	                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
	                </div>
	            </div>';
		}

		elseif (30 < $percentage and $percentage < 60) {
			echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
	               <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
	               </div>
	            </div>';
		}

		elseif (60 < $percentage and $percentage < 90) {
			echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
	               <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
	               </div>
	            </div>';
		}

		elseif (90 < $percentage) {
			echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
	                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
	                </div>
	            </div>';
		}
	} else {
		echo "No Results Found";
	}

	
}
function branch_target_day_by_day($branch, $date) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$from = date ( "Y-m-01", strtotime ( $date ) );
	$to = date ( "Y-m-t", strtotime ( $date ) );

	$days = round ( (strtotime ( $to ) - strtotime ( $from )) / 86400 );

	$i = 0;
	while ( $i < $days ) {
		$datetime = new DateTime ( $from );
		$datetime->modify ( '+' . $i . ' day' );
		$date = $datetime->format ( 'Y-m-d' );

		$result = mysqli_query ($conn, "SELECT amount FROM branch_target WHERE date='$date' AND branch='$branch' " );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			$tar = $row ['amount'];
		}

		$result = mysqli_query ( $conn, "SELECT SUM(total) FROM receipt WHERE date='$date' AND branch='$branch' AND cancel_status=0" );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			$tot = $row ['SUM(total)'];
		}
		if ($tar > 0) {
			$percentage = round ( (($tot / $tar) * 100), 1 );
				
			if ($tot > 0) {
				$tot = $tot;
			} else {
				$tot = "0.00";
			}
			echo $date;
			echo '<p>
			<strong><font color="#8e44ad">' . $tot . '</font><font color="#7f8c8d">/</font><font color="#c0392b">' . $tar . '</font></strong>
			<span class="pull-right text-muted"><font color="#7f8c8d">' . $percentage . '%</font></span>
			</p>';
				
			if ($percentage == 0) {
				$percentage = 0.1;
				echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
		                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
		                </div>
		            </div>';
			} elseif (0 < $percentage and $percentage < 30) {
				echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
		                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
		                </div>
		            </div>';
			}

			elseif (30 < $percentage and $percentage < 60) {
				echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
		               <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
		               </div>
		            </div>';
			}

			elseif (60 < $percentage and $percentage < 90) {
				echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
		               <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
		               </div>
		            </div>';
			}

			elseif (90 < $percentage) {
				echo '<div class="progress progress-striped active" style="height: 20px; margin-top:15px;">
		                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 20px;">
		                </div>
		            </div>';
			}
		}
		$i ++;
	}

	
}
