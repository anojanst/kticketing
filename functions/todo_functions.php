<?php
function list_next_five_task($user_name) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $date = date ( "Y-m-d H:i:s" );
    $str = strtotime ( $date );

    $result = mysqli_query ($conn,  "SELECT * FROM todo WHERE status='0' AND user_name='$user_name' AND deadline>'$date' ORDER BY deadline ASC LIMIT 5" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        $deadline_str = strtotime ( $row ['deadline'] );
        $due = $deadline_str - $str;
        $due_format = secondsToTime ( $due );

        if ($due <= '46800') {
            echo "<div class='alert alert-danger blink' style='text-decoration: blink; margin-top: 2px;'>";
        } elseif ($due <= '86400') {
            echo "<div class='alert alert-danger' style='margin-top: 2px;'>";
        } elseif ($due <= "259200") {
            echo "<div class='alert alert-warning' style='margin-top: 2px;'>";
        } else {
            echo "<div class='alert alert-success' style='margin-top: 2px;'>";
        }
        echo '
		<p>' . $row [task_name] . '</p>
		<p>Time Remaining :</p><p> ' . $due_format . '</p>
	
				<a href="task_manager.php?job=quick_search&id=' . $row [id] . '" class="btn btn-primary" Style="color:white; width: 100%;">View</a>
				
		</div>';
    }

}
function list_task($user_name) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $date = date ( "Y-m-d H:i:s" );
    $str = strtotime ( $date );
    $result = mysqli_query ( $conn, "SELECT * FROM todo WHERE status='0' AND user_name='$user_name' AND deadline>'$date' ORDER BY saved_time DESC LIMIT 20" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        $deadline_str = strtotime ( $row ['deadline'] );
        $due = $deadline_str - $str;
        $due_format = secondsToTime ( $due );

        if ($due <= '46800') {
            echo "<div class='alert alert-danger blink' style='text-decoration: blink; margin-top: 2px;'>";
        } elseif ($due <= '86400') {
            echo "<div class='alert alert-danger' style='margin-top: 2px;'>";
        } elseif ($due <= "259200") {
            echo "<div class='alert alert-warning' style='margin-top: 2px;'>";
        } else {
            echo "<div class='alert alert-success' style='margin-top: 2px;'>";
        }
        echo "
		<p>$row[task_name]</p>
		<p>Time Remaining :</p><p> $due_format</p>
		</div>";
    }

}
function list_all_task($user_name) {
    include 'conf/config.php';
    include 'conf/opendb.php';
    date_default_timezone_set ( 'Asia/Colombo' );
    $date = date ( "Y-m-d H:i:s" );
    $str = strtotime ( $date );
    $result = mysqli_query ($conn, "SELECT * FROM todo WHERE status='0' AND user_name='$user_name' AND deadline>'$date' ORDER BY deadline ASC" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        $deadline_str = strtotime ( $row ['deadline'] );
        $due = $deadline_str - $str;
        $due_format = secondsToTime ( $due );

        if ($due <= '46800') {
            echo "<div class='alert alert-danger blink' style='text-decoration: blink; margin-top: 2px;'>";
        } elseif ($due <= '86400') {
            echo "<div class='alert alert-danger' style='margin-top: 2px;'>";
        } elseif ($due <= "259200") {
            echo "<div class='alert alert-warning' style='margin-top: 2px;'>";
        } else {
            echo "<div class='alert alert-success' style='margin-top: 2px;'>";
        }
        echo "
		<p><strong>Task : </strong>$row[task_name]</p>
		<p><strong>Ref No : </strong>$row[ref_no]</p>
		<p><strong>Description : </strong>$row[description]</p>
		<p><strong>Time Remaining : </strong> $due_format</p>
		<p><strong>Amount : </strong>$row[amount]</p>
		<p><strong>Received : </strong>$row[received]</p>
		</div>";
    }

}
function secondsToTime($seconds) {
    $dtF = new DateTime ( "@0" );
    $dtT = new DateTime ( "@$seconds" );
    return $dtF->diff ( $dtT )->format ( '%a days, %h hours, %i minutes and %s seconds' );
}
function save_task($task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $call_id = $_SESSION [call_id];
    mysqli_select_db ( $dbname );
    $query = "INSERT INTO todo (id, task_name, description, deadline, amount, received, user_name, status, ref_no, type, saved_by, telephone_directory_id)
	VALUES ('', '$task_name', '$description', '$deadline', '$amount', '$received', '$user_name', '$status', '$ref_no', '$type', '$saved_by', '$call_id')";
    mysqli_query ( $query ) or die ( mysqli_connect_error () );
}
function next_work_javascript($user_name) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $str = strtotime ( date ( "Y-m-d h:i:s" ) );
    $result = mysqli_query ( $conn, "SELECT * FROM todo WHERE status='0' AND user_name='$user_name' ORDER BY deadline DESC LIMIT 1" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        $deadline_str = strtotime ( $row ['deadline'] );
        $due = $deadline_str - $str;

        echo '<form>
			 <input type="hidden" id="time" value="0">
			 <input type="hidden" id="limit" value="20">
			 		<input type="hidden" id="task_name" value="Did you finish ' . $task_name . '?">
			</form>';
    }

}
function calender() {
    include 'conf/config.php';
    include 'conf/opendb.php';

    echo '<script type="text/javascript">
      $(document).ready(function () {
        $(".responsive-calendar").responsiveCalendar({
          
	          events: {';
    $str = date ( "Y-m-d" );

    echo '"2013-04-30": {"number": 5, "url": "http://w3widgets.com/responsive-slider"},
            "2013-04-26": {"number": 1, "url": "http://w3widgets.com"}, 
            "2013-05-03":{"number": 1}, 
            "2013-06-12": {}';

    echo '}});
      });
    </script>';

}
function update_deadline($id, $deadline) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ($conn, $dbname );
    $query = "UPDATE todo SET
	deadline='$deadline'
	WHERE id='$id'";

    mysqli_query ($conn, $query );


}
function change_username($id, $user_name, $saved_by) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ($conn, $dbname );
    $query = "UPDATE todo SET
	user_name='$user_name', saved_by='$saved_by'
	WHERE id='$id'";

    mysqli_query ($conn, $query );


}
function update_status($id, $status) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ($conn, $dbname );
    $query = "UPDATE todo SET
	status='1'
	WHERE id='$id'";

    mysqli_query ($conn, $query );


}
function task_history($task_name, $user_name, $ref_no, $from_date, $to_date) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    if ($task_name) {
        $task_name_check = "AND task_name LIKE '%$task_name%'";
    } else {
        $task_name_check = "";
    }

    if ($user_name) {
        $user_name_check = "AND user_name LIKE '%$user_name%'";
    } else {
        $user_name_check = "";
    }

    if ($ref_no) {
        $ref_no_check = "AND ref_no LIKE '$ref_no%'";
    } else {
        $ref_no_check = "";
    }

    if ($to_date && $from_date) {
        $date_check = "AND deadline BETWEEN '$from_date' AND '$to_date'";
    } elseif ($from_date) {
        $date_check = "AND deadline>='$from_date'";
        $limit = "";
    } elseif ($to_date) {
        $date_check = "AND deadline<='$to_date'";
        $limit = "";
    } else {
        $date_check = "";
        $limit = "LIMIT 50";
    }

    date_default_timezone_set ( 'Asia/Colombo' );
    $date = date ( "Y-m-d H:i:s" );
    $str = strtotime ( $date );

    $result = mysqli_query ( $conn, "SELECT * FROM todo WHERE cancel_status='0' AND status=0 $task_name_check $user_name_check $ref_no_check $date_check ORDER BY id LIMIT 50" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        $deadline_str = strtotime ( $row ['deadline'] );
        $due = $deadline_str - $str;
        $due_format = secondsToTime ( $due );

        if ($due <= '46800') {
            echo "<div class='alert alert-danger blink' style='text-decoration: blink; margin-top: 2px;'>";
        } elseif ($due <= '86400') {
            echo "<div class='alert alert-danger' style='margin-top: 2px;'>";
        } elseif ($due <= "259200") {
            echo "<div class='alert alert-warning' style='margin-top: 2px;'>";
        } else {
            echo "<div class='alert alert-success' style='margin-top: 2px;'>";
        }
        echo '
		<p><strong>Task : </strong>' . $row [task_name] . '</p>
		<p><strong>Ref No : </strong>' . $row [ref_no] . '</p>
		<p><strong>Description : </strong>' . $row [description] . '</p>
		<p><strong>Time Remaining : </strong>' . $due_format . '</p>
		<p><strong>Amount : </strong>' . $row [amount] . '</p>
		<p><strong>Received : </strong>' . $row [received] . '</p>
		<p><strong>Saved By : </strong>' . $row [saved_by] . '</p>
				';

        if ($row [status] == '0') {
            echo '
		<form role="form" action="task_manager.php?job=update&id=' . $row [id] . '" method="post">
				
		 <div class="row">
            <div class="col-lg-2">
                <div class="form-group" style="visibility:visible;">
          
                    <div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
                        <input type="text" name="deadline" placeholder=" Date" style="width: 100%;">
                        <span class="add-on"><i class="icon-remove"></i></span>
                        <span class="add-on"><i class="icon-th"></i></span>
                    </div>
                            <input type="hidden" id="dtp_input1" value="" />
                </div>
            </div>
				
            <div class="col-lg-2">
                <button type="submit"=" name="ok" value="Search" class="btn btn-primary">Update deadline</button>
            </div>
            <div class="col-lg-2">
                <a href="task_manager.php?job=complete_task&id=' . $row [id] . '" class="btn btn-primary" Style="color:white">Complete task</a>
            </div>';

            if ($row [telephone_directory_id] > 0) {
                echo '<div class="col-lg-2">
            			<a href="task_manager.php?job=complete_task&id=' . $row [id] . '&type=Booked" class="btn btn-primary" Style="color:white">Complete as Booked</a>
				</div>';
            }
            echo '</div>
	      </form>';

            echo '
		<form role="form" action="task_manager.php?job=change_username&id=' . $row [id] . '" method="post">
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group" style="visibility:visible;">
                        <div class="form-group">
                            <input class="form-control" name="user_name" placeholder="Name">
                        </div>
                            <input type="hidden" id="dtp_input1" value="" />
                    </div>
                </div>
        
                <div class="col-lg-2">
                    <button type="submit"=" name="ok" value="Search" class="btn btn-primary">Change username</button>
                </div>
            </div>
        </form>';
        }

        echo '</div>';
    }

}
function get_task_info($id) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ( "SELECT * FROM todo WHERE id='$id'", $conn );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        return $row;
    }


}
function create_dob_task($today_dm) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ( $conn, "SELECT * FROM customer WHERE dob LIKE '%$today_dm'" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {

        $task_name = "birthday Remainder";
        $description = "Customer Name : $row[customer_name],Telephone No : $row[mobile]";
        $user_name = "terrancy";
        $type = "birthday";
        $saved_by = $_SESSION ['user_name'];

        $today = date ( 'Y-m-d H:i:s' );
        $datetime = new DateTime ( $today );
        $datetime->modify ( '+6 hours' );
        $deadline = $datetime->format ( 'Y-m-d H:i:s' );

        save_task ( $task_name, $description, $deadline, $amount, $received, $user_name, $status, $ref_no, $type, $saved_by );
    }


}
function get_today_birthday_count($today_dm) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ($conn, "SELECT count(id) FROM customer WHERE dob LIKE '%$today_dm'" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        return $row ['count(id)'];
    }


}
function save_count_dob($count) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $date = date ( "y-m-d" );
    mysqli_select_db ($conn, $dbname );
    $query = "INSERT INTO customer_birthday (id, date, count)
	VALUES ('', '$date', '$count')";
    mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );


}
function check_birthday_access($date) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ($conn, "SELECT count(id) FROM customer_birthday WHERE date='$date'" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        if ($row ['count(id)'] >= 1) {
            return 1;
        } else {
            return 0;
        }
    }

}
