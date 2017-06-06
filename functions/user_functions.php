<?php
function save_user($name, $full_name, $department, $email, $mobile, $address, $user, $user_name, $password, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($password) {
		$passwordmd5 = md5 ( $password );
		$user = 1;
	}
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO users (id, name, full_name, department, email, mobile, address, user, user_name, password, code, branch)
	VALUES ('', '$name', '$full_name', '$department', '$email', '$mobile', '$address', '$user', '$user_name', '$passwordmd5', '$password', '$branch')";
	mysqli_query ( $conn,$query ) or die ( mysqli_connect_error () );
	
	
}
function update_user($id, $name, $full_name, $department, $email, $mobile, $address, $user, $user_name, $password, $branch) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if ($password) {
		$passwordmd5 = md5 ( $password );
		$user = 1;
	}
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE users SET
	name='$name',
	full_name='$full_name',
	department='$department',
	email='$email',
	mobile='$mobile',
	address='$address',
	user='$user',
	user_name='$user_name',
	password='$passwordmd5',
	code='$password',
	branch='$branch'
	WHERE id='$id'";
	
	mysqli_query ($conn, $query );
	
	
}
function list_users() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM users WHERE cancel_status='0' ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['user'] == 1) {
			echo "<div class='alert alert-success' style='margin-top: 2px;'>";
		} else {
			echo "<div class='alert alert-info' style='margin-top: 2px;'>";
		}
		echo '
		<p>' . $row [full_name] . '</p>
		<a href="users.php?job=edit&id=' . $row [id] . '"  ><p>View Details<p></p></a>
		</div>';
	}
	
	
}

function list_users_full() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo '<div class="table-responsive">
              <table  style="width: 100%;" class="table-responsive table-bordered table-striped dt-responsive">
				<tr>
					<td>Name</td>
					<td>Full Name</td>
					<td>Department</td>
					<td>Mobile</td>
					<td>E-mail</td>
					<td>Address</td>
					<td>Edit</td>
					<td>Access</td>
					<td>Delete</td>
					</tr>';
	
	$result = mysqli_query ( $conn, "SELECT * FROM users WHERE cancel_status='0' ORDER BY department DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['user'] == 1) {
			echo "<tr class='info'>";
		} else {
			echo "<tr>";
		}
		echo '
		<td>' . $row [name] . '</td>
		<td>' . $row [full_name] . '</td>
		<td>' . $row [department] . '</td>
		<td>' . $row [mobile] . '</td>
		<td>' . $row [email] . '</td>
		<td>' . $row [address] . '</td>
		<td><a href="users.php?job=edit&id=' . $row [id] . '"><i class="fa fa-pencil-square-o fa-lg"></i></a></td>
		<td><a href="users.php?job=access&id=' . $row [id] . '"><i class="fa fa-key fa-lg"></i></a></td>
		<td><a href="users.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a></td>
		</tr>';
	}
	echo '    	</table>
            </div>';
	
}

function list_users_full_for_user_add() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	echo '<div class="table-responsive" >
              <table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<td>Full Name</td>
					
						<td>Mobile</td>
						<td>E-mail</td>
					
						<td>Edit</td>
						<td>Access</td>
						<td>Delete</td>
					</tr>
				</thead>
			
			<tbody valign="top">';

	$result = mysqli_query ( $conn, "SELECT * FROM users WHERE cancel_status='0' ORDER BY department DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['user'] == 1) {
			echo "<tr class='info'>";
		} else {
			echo "<tr class='danger'>";
		}
		echo '
		
		<td>' . $row [full_name] . '</td>
		
		<td>' . $row [mobile] . '</td>
		<td>' . $row [email] . '</td>
		
		<td><a href="users.php?job=edit&id=' . $row [id] . '"><i class="fa fa-pencil-square-o fa-lg"></i></a></td>
		<td><a href="users.php?job=access&id=' . $row [id] . '"><i class="fa fa-key fa-lg"></i></a></td>
		<td><a href="users.php?job=delete&id=' . $row [id] . '" onclick="javascript:return confirm(\'Are you sure you want to delete this entry?\')"><i class="fa fa-times fa-lg"></i></a></td>
		</tr>';
	}
	echo '</tbody>
          </table>
          </div>';
}


function check_login($login, $password) {
	$password = md5 ( $password );
	
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	if (mysqli_num_rows ( mysqli_query ($conn, "SELECT id FROM users WHERE user_name = '$login' AND password= '$password'" ) )) {
		return 1;
	} else {
		return 0;
	}
	
	
}
function get_user_info($user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM users WHERE user_name='$user_name'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC) ) {
		return $row;
	}
	
}
function get_user_info_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM users WHERE id='$user_id'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function check_access($module_no, $user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT count(id) FROM user_has_module WHERE user_id='$user_id' AND module_no='$module_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		if ($row ['count(id)'] >= 1) {
			return 1;
		} else {
			return 0;
		}
	}
	
}
function save_target($target, $user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m-d" );
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO day_registry (`id`, `user_name`, `target`, `date`)
	VALUES ('', '$user_name', '$target', '$date')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function save_ip($user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$time = date ( "Y-m-d H:i:s" );
	$ip = $_SERVER ['REMOTE_ADDR'];
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO ip_table (`id`, `user_name`, `ip`, `time`)
	VALUES ('', '$user_name', '$ip', '$time')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function get_day_info($user_name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM day_registry WHERE user_name='$user_name' ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
}
function save_cancel($user_name, $cancel) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m-d" );
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE day_registry SET
	cancel='$cancel'
	WHERE user_name='$user_name' AND date='$date'";
	
	mysqli_query ($conn, $query );
	
	
}
function save_date_change($user_name, $change) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m-d" );
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE day_registry SET
	date_change='$change'
	WHERE user_name='$user_name' AND date='$date'";
	
	mysqli_query ($conn, $query );
	
	
}
function list_canceled_pnr() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m-d" );
	
	$result = mysqli_query ($conn, "SELECT * FROM cancel_pnr WHERE date='$date'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo "<div class='alert alert-success' style='margin-top: 2px;'>
				<p>$row[pnr]</p>
             </div>";
	}
	
}
function save_cancel_pnr($user_name, $pnr) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m-d" );
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO cancel_pnr (`id`, `user_name`, `pnr`, `date`)
	VALUES ('', '$user_name', '$pnr', '$date')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function save_date_change_pnr($user_name, $pnr) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m-d" );
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO date_change_pnr (`id`, `user_name`, `pnr`, `date`)
	VALUES ('', '$user_name', '$pnr', '$date')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function list_changed_pnr() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m-d" );
	
	$result = mysqli_query ( $conn, "SELECT * FROM date_change_pnr WHERE date='$date'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo "<div class='alert alert-success' style='margin-top: 2px;'>
		<p>$row[pnr]</p>
		</div>";
	}
	
}
function cancel_user($id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "UPDATE users SET
	cancel_status='1'
	WHERE id='$id'";
	mysqli_query ($conn, $query );
	
	
}
function list_not_user_module($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn , "SELECT * FROM modules WHERE modules.cancel_status='0' AND modules.module_no NOT IN (SELECT user_has_module.module_no FROM user_has_module WHERE user_has_module.user_id='$user_id' )");
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="col-lg-9">' . $row [module_name] . '</div>
			  <div class="col-lg-3"><a href="users.php?job=add_access&module_no=' . $row [module_no] . '"> <i class="fa fa-check fa-2x"></i></a></div>';
	}
	
	
}
function list_user_module($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ( $conn, "SELECT * FROM user_has_module WHERE user_id='$user_id'" );
	
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$module_info = get_module_info ( $row ['module_no'] );
		$module_name = $module_info ['module_name'];
		
		echo '<div class="col-lg-9">' . $module_name . '</div>
			  <div class="col-lg-3"><a href="users.php?job=remove_access&module_no=' . $row [module_no] . '"> <i class="fa fa-times fa-2x"></i></a></div>';
	}
	
	
}
function get_module_info($module_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM modules WHERE module_no='$module_no'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		return $row;
	}
	
	
}
function add_user_module($user_id, $module_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO user_has_module (user_id, module_no)
	VALUES ('$user_id', '$module_no')";
	mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );
	
	
}
function remove_user_module($user_id, $module_no) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	echo $user_id;
	mysqli_select_db ($conn, $dbname );
	$query = "DELETE FROM user_has_module WHERE user_id='$user_id' AND module_no='$module_no'";
	mysqli_query ($conn, $query );
	
	
}
function getExtension($str) {
	$i = strrpos ( $str, "." );
	if (! $i) {
		return "";
	}
	$l = strlen ( $str ) - $i;
	$ext = substr ( $str, $i + 1, $l );
	return $ext;
}
function today_target_and_receipt_total() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM users WHERE user_name='$user_name'");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC) ) {
		return $row;
	}
	
	$date = date ( "Y-m-d" );
	$user_name = $_SESSION ['user_name'];
	
	$result = mysqli_query ($conn, "SELECT target FROM day_registry WHERE date='$date' AND user_name='$user_name' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$today_tar = $row [target];
	}
	
	$result = mysqli_query ($conn, "SELECT SUM(total) FROM receipt WHERE date='$date' AND saved_by='$user_name' ");
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$tot = $row ['SUM(total)'];
	}
	
	$percentage = round ( (($tot / $today_tar) * 100), 1 );
	
	echo '<p style="margin-bottom:15px;">
	<strong>Staff Today Target</strong>
	</p>
	<p style="margin-bottom:-35px;">
	<strong><font color="#8e44ad">' . $tot . '</font><font color="#7f8c8d">/</font><font color="#c0392b">' . $today_tar . '</font></strong>
	<span class="pull-right text-muted"><font color="#7f8c8d">' . $percentage . '%</font></span>
	</p>';
	if ($percentage == 0) {
		$percentage = 0.1;
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} elseif (0 < $percentage and $percentage < 30) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} 

	elseif (30 < $percentage and $percentage < 60) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} 

	elseif (60 < $percentage and $percentage < 90) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} 

	elseif (90 < $percentage) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}
	
}


function today_branch_target_and_receipt_total() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date ( "Y-m-d" );
	$branch = $_SESSION ['branch'];

	if($amount > 1)
	{
	
	
	$result = mysqli_query ( $conn, "SELECT amount FROM branch_target WHERE date='$date' AND branch='$branch' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$today_tar = $row [amount];
	}

	$result1 = mysqli_query ($conn, "SELECT SUM(total) FROM receipt WHERE date='$date' AND branch='$branch' " );
	while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
		$tot = $row1 ['SUM(total)'];
	}

	$percentage = round ( (($tot / $today_tar) * 100), 1 );

	echo '<p style="margin-bottom:15px;">
	<strong>Branch Today Target</strong>
	</p>
	<p style="margin-bottom:-35px;">
	<strong><font color="#8e44ad">' . $tot . '</font><font color="#7f8c8d">/</font><font color="#c0392b">' . $today_tar . '</font></strong>
	<span class="pull-right text-muted"><font color="#7f8c8d">' . $percentage . '%</font></span>
	</p>';
	if ($percentage == 0) {
		$percentage = 0.1;
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} elseif (0 < $percentage and $percentage < 30) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}

	elseif (30 < $percentage and $percentage < 60) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}

	elseif (60 < $percentage and $percentage < 90) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}

	elseif (90 < $percentage) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}
	}
	else {
		
	}
	
}



function month_target_and_receipt_total() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m" );
	$user_name = $_SESSION ['user_name'];
	
	$result = mysqli_query ( $conn, "SELECT SUM(target) FROM day_registry WHERE date LIKE '$date%' AND user_name='$user_name' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$tar = $row ['SUM(target)'];
	}
	
	$result = mysqli_query ( $conn, "SELECT SUM(total) FROM receipt WHERE date LIKE '$date%' AND saved_by='$user_name' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$tot = $row ['SUM(total)'];
	}
	$percentage = round ( (($tot / $tar) * 100), 1 );
	
	echo '<p style="margin-bottom:15px;">
	<strong>Staff Month Target</strong>
	</p>
			<p style="margin-bottom:-35px;">
	<strong><font color="#8e44ad">' . $tot . '</font><font color="#7f8c8d">/</font><font color="#c0392b">' . $tar . '</font></strong>
	<span class="pull-right text-muted"><font color="#7f8c8d">' . $percentage . '%</font></span>
	</p>';
	
	if ($percentage == 0) {
		$percentage = 0.1;
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} elseif (0 < $percentage and $percentage < 30) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} 

	elseif (30 < $percentage and $percentage < 60) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} 

	elseif (60 < $percentage and $percentage < 90) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} 

	elseif (90 < $percentage) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}
	
}


function month_branch_target_and_receipt_total() {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$date = date ( "Y-m" );
	$branch = $_SESSION ['branch'];
	
	if($amount > 1)
	{
		
	$result = mysqli_query ( $conn, "SELECT SUM(amount) FROM branch_target WHERE date LIKE '$date%' AND branch='$branch' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$tar = $row ['SUM(amount)'];
	}

	$result = mysqli_query ( $conn, "SELECT SUM(total) FROM receipt WHERE date LIKE '$date%' AND branch='$branch' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$tot = $row ['SUM(total)'];
	}
	$percentage = round ( (($tot / $tar) * 100), 1 );

	echo '<p style="margin-bottom:15px;">
	<strong>Branch Month Target</strong>
	</p>
	<p style="margin-bottom:-35px;">
	<strong><font color="#8e44ad">' . $tot . '</font><font color="#7f8c8d">/</font><font color="#c0392b">' . $tar . '</font></strong>
	<span class="pull-right text-muted"><font color="#7f8c8d">' . $percentage . '%</font></span>
	</p>';

	
	if ($percentage == 0) {
		$percentage = 0.1;
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	} elseif (0 < $percentage and $percentage < 30) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}

	elseif (30 < $percentage and $percentage < 60) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}

	elseif (60 < $percentage and $percentage < 90) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}

	elseif (90 < $percentage) {
		echo '<div class="progress progress-striped active" style="height: 8px; margin-top:-15px;">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: ' . $percentage . '%; height: 10px;">
                </div>
            </div>';
	}
	}
	else {
		
	}
	
}


function staff_target($staff_name, $date) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$date = date ( "Y-m", strtotime ( $date ) );
	
	$result = mysqli_query ( $conn, "SELECT SUM(target) FROM day_registry WHERE date LIKE '$date%' AND user_name='$staff_name' " );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		$tar = $row ['SUM(target)'];
	}
	
	$result = mysqli_query ( $conn, "SELECT SUM(total) FROM receipt WHERE date LIKE '$date%' AND saved_by='$staff_name' AND cancel_status=0 " );
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
function staff_target_day_by_day($staff_name, $date) {
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
		
		$result = mysqli_query ($conn, "SELECT target FROM day_registry WHERE date='$date' AND user_name='$staff_name' " );
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			$tar = $row ['target'];
		}
		
		$result = mysqli_query ( $conn, "SELECT SUM(total) FROM receipt WHERE date='$date' AND saved_by='$staff_name' AND cancel_status=0" );
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
function list_quick_links_home() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$result = mysqli_query ($conn, "SELECT * FROM quick_links WHERE cancel_status='0' ORDER BY id" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<div class="col-lg-1">
						 <a href="' . $row [link] . '" target="blank">
                          <img src="' . $row [logo] . '" width="32" height="32" style="margin-left: 5px;"/>
                         </a>
     			     </div>';
	}
	
	
}


function booking_without_passport($name) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	
	
	

		
		$result = mysqli_query ($conn, "SELECT * FROM booking WHERE saved_by='$name' AND cancel_status='0' AND status='1'") ;
		while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			
			
		$result1 = mysqli_query ( $conn, "SELECT * FROM booking_has_passengers WHERE booking_no='$row[booking_no]'" );
		while ( $row1 = mysqli_fetch_array ( $result1, MYSQLI_ASSOC ) ) {
			if (mysqli_num_rows ( mysqli_query ($conn, "SELECT id FROM customer WHERE passport_no='$row1[passport_no]' AND passport NOT LIKE 'passports%' AND cancel_status='0'" ) )) {
			
				if($row[booking_no]==0){
						
				}

				elseif($row[booking_no]<99999) {
					echo '<div class="col-lg-1" style="color:white;"><a href="booking.php?job=view&booking_no=' . $row ['booking_no'] . '" class="btn btn-xs btn-danger" target="_blank">' . $row ['booking_no'] . '</a></div>';
				}
				else{
					echo '<div class="col-lg-1" style="color:white;"><a href="#" class="btn btn-xs btn-primary">' . $row ['booking_no'] . '</a></div>';
				}
			}
		}
		}
	
}





function booking_without_visa($name) {
	include 'conf/config.php';
	include 'conf/opendb.php';


	
	$result = mysqli_query ($conn, "SELECT * FROM booking WHERE saved_by='$name' AND cancel_status='0' AND status='1'") ;
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
			
		if (mysqli_num_rows ( mysqli_query ($conn, "SELECT id FROM booking_has_passengers WHERE booking_no='$row[booking_no]' AND visa_copy NOT LIKE 'visa_copy%' AND cancel_status='0'" ) )) {
				
					if($row[booking_no]==0){
							
					}

					elseif($row[booking_no]<99999) {
						echo '<div class="col-lg-1" style="color:white;"><a href="booking.php?job=view&booking_no=' . $row ['booking_no'] . '" class="btn btn-xs btn-danger" target="_blank">' . $row ['booking_no'] . '</a></div>';
					}
					else{
						echo '<div class="col-lg-1" style="color:white;"><a href="#" class="btn btn-xs btn-primary">' . $row ['booking_no'] . '</a></div>';
					}
				
			}
		}
	
	
}



function list_new_message(){
	include 'conf/config.php';
	include 'conf/opendb.php';


	$today = date ( 'Y-m-d' );
	$result=mysqli_query($conn, "SELECT * FROM message WHERE cancel_status='0' AND start_date='$today' LIMIT 1" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{

	echo'<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
		<div class="alert alert-danger"><div class="row"><div class="col-lg-2" style="background-color: yellow; color: red; padding:5px; font-weight: bolder; margin-left: 10px; text-align: center;">Important News</div><div class="col-lg-9"><strong> '.$row[message].'</strong></div></div></div>
		</div>
		</div>';
	}

	
}

function get_userdetails_info_id($user_id) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	$result=mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' AND cancel_status='0'" );
	while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{
		return $row;
	}
	
}



function update_userdetails($id, $name, $full_name, $department, $email, $mobile, $address, $user, $user_name, $password, $branch){
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	

	mysqli_select_db($conn,$dbname);
	$query = "UPDATE users SET
	name='$name',
	full_name='$full_name',
	department='$department',
	email='$email',
	mobile='$mobile',
	address='$address',
	user='$user',
	user_name='$user_name',
	password='$password',
	branch='$branch'
	WHERE id='$id'";

	mysqli_query($conn,$query);

	
}


function add_profile_pictures($user_name, $profile_pictures) {
	include 'conf/config.php';
	include 'conf/opendb.php';

	mysqli_select_db ($conn, $dbname );
	$query = "INSERT INTO users (id, user_name, profile_pictures, saved_by)
	VALUES ('','$user_name', '$profile_pictures', '$_SESSION[user_name]')";
	mysqli_query ( $conn, $query ) or die ( mysqli_connect_error () );

	
}
