<?php
function list_users_for_chat() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$user_name = $_SESSION ['user_name'];
	
	echo '<li><div><p><strong><a href="view_all_messages.php">View All Messages</a></strong></p></div></li><li class="divider"></li>';
	
	$result = mysqli_query ($conn, "SELECT * FROM users WHERE user_name!='$user_name' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '<li>
			<div>
			<p>
			<img src="images/' . $row [user_name] . '.jpg" width="24" height="24" style="margin-left: 5px;"/>
			<strong><a href="javascript:void(0)" onclick="javascript:chatWith(' . "'$row[user_name]'" . ')">' . $row [user_name] . '</a></strong>
			
			</p>
			
			</div>
		</li>
	<li class="divider"></li>';
	}
	

}
function list_users_for_chat_full() {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$user_name = $_SESSION ['user_name'];
	
	$result = mysqli_query ($conn, "SELECT * FROM users WHERE user_name!='$user_name' AND cancel_status='0'" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		echo '
			<div>
			<p>
			<img src="images/' . $row [user_name] . '.jpg" width="32" height="32" style="margin-left: 5px;"/>
			<strong><a href="view_all_messages.php?job=view&chat_with=' . $row [user_name] . '">' . $row [user_name] . '</a></strong></p>
		
			<p><strong><a href="javascript:void(0)" onclick="javascript:chatWith(' . "'$row[user_name]'" . ')" class="btn btn-default">New Message</a></strong>
			
			</p>
			</div>
	';
	}
	

}
function chat_with($chat_with) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$user_name = $_SESSION ['user_name'];
	
	$today = date ( 'Y-m-d H:i:s' );
	$tostr = strtotime ( $today );
	$minus = $tostr - 604800;
	$till = date ( 'Y-m-d H:i:s', $minus );
	
	$result = mysqli_query ( $conn, "SELECT * FROM chat WHERE `from` IN ('$user_name','$chat_with') AND `to` IN ('$user_name','$chat_with') AND sent>'$till' ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		if ($row ['from'] == $user_name) {
			echo '<div class="row">
					<div style="text-align=left; padding: 2px;" class="alert alert-success col-lg-8">
					<p><img src="images/' . $row ['from'] . '.jpg" width="36" height="36" style="margin-left: 5px; margin-right: 10px; float: left;"/>
						<strong> ' . $row [message] . '</strong><br />' . $row [sent] . '</p>
					</div>
				</div>';
		} else {
			echo '<div class="row"><div class="col-lg-4"></div><div class="alert alert-danger col-lg-8" style="text-align=center; padding: 2px;"><p style="text-align: right; margin-right: 10px; float: right;">
					<strong style="text-align: right; margin-right: 40px; float: right;"> ' . $row [message] . '</strong><br />' . $row [sent] . '
					<img src="images/' . $row ['from'] . '.jpg" width="36" height="36" style="margin-left: 5px; margin-top: -15px; float: right;"/></p>
				 </div>
				</div>';
		}
	}
	

}
function chat_history_for2days($to_user, $from_user) {
	include 'conf/config.php';
	include 'conf/opendb.php';
	
	$today = date ( 'Y-m-d H:i:s' );
	$tostr = strtotime ( $today );
	$minus = $tostr - 172800;
	$till = date ( 'Y-m-d H:i:s', $minus );
	
	$result = mysqli_query ($conn, "SELECT * FROM chat WHERE `from` IN ('$to_user','$from_user') AND `to` IN ('$to_user','$from_user') AND sent>'$till' ORDER BY id DESC" );
	while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
		
		if ($row ['from'] == $from_user) {
			echo '<div class="row">
					<div style="padding: 2px;" class="alert alert-success col-lg-8">
					<p><img src="images/' . $row ['from'] . '.jpg" width="36" height="36" style="margin-left: 5px; margin-right: 10px; float: left;"/>
						<strong> ' . $row [message] . '</strong><br />' . $row [sent] . '</p>
					</div>
				</div>';
		} else {
			echo '<div class="row"><div class="col-lg-4"></div><div class="alert alert-info col-lg-8" style="padding: 2px;"><p style="text-align: right; margin-right: 10px; float: right;">
					<strong style="text-align: right; margin-right: 40px; float: right;"> ' . $row [message] . '</strong><br />' . $row [sent] . '
					<img src="images/' . $row ['from'] . '.jpg" width="36" height="36" style="margin-left: 5px; margin-top: -15px; float: right;"/></p>
				 </div>
				</div>';
		}
	}
	

}