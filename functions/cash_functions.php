<?php
function branches() {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ( $conn,"SELECT * FROM cash" );
    $i = 0;
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        $branches [$i] = $row ['branch'];
        $i ++;
    }
    return $branches;
}
function list_latest_activities($branch, $from_date, $to_date) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    if ($to_date && $from_date) {
        $date_check = "AND date BETWEEN '$from_date' AND '$to_date'";
        $limit = "";
    } elseif ($from_date) {
        $date_check = "AND date>='$from_date'";
        $limit = "";
    } elseif ($to_date) {
        $date_check = "AND date<='$to_date'";
        $limit = "";
    } else {
        $date_check = "";
        $limit = "LIMIT 100";
    }

    echo '<div class="box-body">
              <table id="example2" width="100%" class="table-responsive table-bordered table-striped dt-responsive">
                   <thead>
                       <tr>
						   <th colspan="4" class="success">Cash Flow IN</th>
                           <th colspan="4" class="danger">Cash Flow OUT</th>
                       </tr>
					   <tr>
                           <th class="success">Date</th>
                           <th class="success">Ref No</th>
						   <th class="success">Detail</th>
                           <th class="success">Amount</th>
						   <th class="danger">Detail</th>
                           <th class="danger">Ref No</th>
                           <th class="danger">Date</th>
                           <th class="danger">Amount</th>
                       </tr>
                   </thead>
                   <tbody>';
    $in_total = 0;
    $in_total = 0;
    $result = mysqli_query ( $conn, "SELECT * FROM cash_flow WHERE branch='$branch' AND cancel_status='0' $date_check ORDER BY id DESC $limit" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        if ($row ['type'] == "IN") {
            echo '<tr>
				<td>' . $row [date] . '</td>
				<td>' . $row [ref_no] . '</td>
				<td>' . $row [detail] . ' By : ' . $row [user] . '</td>
				<td align="right">' . $row [amount] . '</td>
				<td colspan="4"></td>
			</tr>';
            $in_total = $in_total + $row ['amount'];
        } elseif ($row ['type'] == "OUT") {
            echo '<tr>				
				<td colspan="4"></td>
				<td>' . $row [date] . '</td>
				<td>' . $row [ref_no] . '</td>
				<td>' . $row [detail] . ' By : ' . $row [user] . '</td>
				<td align="right">' . $row [amount] . '</td>
			</tr>';
            $out_total = $out_total + $row ['amount'];
        } else {
            if ($row ['amount'] >= 0) {
                echo '<tr>
				<td>' . $row [date] . '</td>
				<td>' . $row [ref_no] . '</td>
				<td>' . $row [detail] . '</td>
				<td align="right">' . $row [amount] . '</td>
				<td colspan="4"></td>
			</tr>';
                $in_total = $in_total + $row ['amount'];
            } else {
                echo '<tr>
				<td colspan="4"></td>
				<td>' . $row [date] . '</td>
				<td>' . $row [ref_no] . '</td>
				<td>' . $row [detail] . '</td>
				<td align="right" class="success">' . $row [amount] . '</td>
			</tr>';
                $out_total = $out_total + $row ['amount'];
            }
        }
    }

    $total = $in_total - $out_total;
    echo '<tr>
			<td colspan="3" class="success" align="right"><strong>Total In</strong></th>
			<td class="success" align="right"><strong>' . number_format ( $in_total, 2 ) . '</strong></td>
            <td colspan="3" class="danger" align="right"><strong>Total OUT</strong></th>
			<td class="danger" align="right"><strong>' . number_format ( $out_total, 2 ) . '</strong></td>
          </tr>
		  <tr>
			<td colspan="7" class="info"><strong>Balance Within the Period</strong></td>
			<td class="info" align="right"><strong>' . number_format ( $total, 2 ) . '</strong></td>
          </tr>
          </tbody>
       </table>
    </div>';


}
function save_cash_flow($branch, $detail, $cash_amount, $ref_no, $type, $date, $saved_by) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ($conn, $dbname );
    $query = "INSERT INTO cash_flow (id, `branch`, detail, amount, ref_no, `type`, date, user)
	VALUES ('', '$branch', '$detail', '$cash_amount', '$ref_no', '$type', '$date', '$saved_by')";
    mysqli_query ($conn, $query ) or die ( mysqli_connect_error () );


}
function get_cash_info($branch) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    $result = mysqli_query ( $conn, "SELECT * FROM cash WHERE branch='$branch'" );
    while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
        return $row;
    }
}
function delete_cash_flow($branch, $detail, $ref_no) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    mysqli_select_db ($conn, $dbname );
    $query = "UPDATE cash_flow SET
	cancel_status='1'
	WHERE branch='$branch' AND detail='$detail' AND ref_no='$ref_no'";
    mysqli_query ($conn, $query );


}
function check_cash_flow_last_entry($branch, $date) {
    include 'conf/config.php';
    include 'conf/opendb.php';

    if (mysqli_num_rows ( mysqli_query ($conn, "SELECT id FROM cash_flow WHERE branch='$branch' AND date='$date'" ) )) {
        return 0;
    } else {
        return 1;
    }


}

?>