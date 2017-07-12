{include file="header.tpl"}
{include file="navigation.tpl"}

{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.customer').typeahead({
                name: 'customer',
                remote : 'ajax/customer_id_and_name.php?query=%QUERY'

            });
        })
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.customer_id').typeahead({
                name: 'customer_id',
                remote : 'ajax/customer_id.php?query=%QUERY'

            });
        })
	</script>

	<script type="text/javascript">
        function findTotal(){
            var	y = document.getElementById("penalty").value,
                z = document.getElementById("mark_up").value;

            var total = +y + +z;
            document.getElementById("total").value=total;
        }
	</script>

	<script type="text/javascript">

        function ifReturn() {
            if (document.getElementById('way').value=="Return") {
                document.getElementById('returnDate').style.visibility = 'visible';
                document.getElementById('returnArrivalTime').style.visibility = 'visible';
                document.getElementById('returnDepartureTime').style.visibility = 'visible';
            } else {
                document.getElementById('returnDate').style.visibility = 'hidden';
                document.getElementById('returnArrivalTime').style.visibility = 'hidden';
                document.getElementById('returnDepartureTime').style.visibility = 'hidden';
            }
        }
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.offer_code').typeahead({
                name: 'offer_code',
                remote : 'ajax/offer.php?query=%QUERY'

            });
        })
	</script>
{/literal}

{if $error_message}
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="alert alert-danger"><strong>{$error_message}</strong></div>

		</div>
	</div>
{/if}

<section class="content">
	<div class="row" onload="ifReturn()">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="box box-primary" style="margin-top: 10px;">
				<div class="panel-heading">
					<form role="form" action="date_change.php?job=search" method="post" name="add_item">
						<div class="form-group">
							<input type="text" name="search" value="{$date_change_no}" placeholder="Search By Date Change No" class="form-control"/>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>Fare Details</strong>
				</div>
				<div class="panel-body">
					<form role="form" action="date_change.php?job=add_item" method="post" name="add_item">
						<div class="row">

							<div class="col-lg-2">
								<div class="form-group">
									<select class="form-control" id="air_line_code" name="air_line_code" required placeholder="Air Line" >
                                        {if $air_line}
											<option value="{$air_line_code}">{$air_line_code}</option>
                                        {else}
											<option value="" disabled selected>Air Lines</option>
                                        {/if}
                                        {section name=air_line_code loop=$air_line_names}
											<option value="{$air_line_names[air_line_code]}">{$air_line_names[air_line_code]}</option>
                                        {/section}
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<select class="form-control" name="class" required placeholder="class" >
                                        {if $class}
											<option value="{$class}">{$class}</option>
                                        {else}
											<option value="" disabled selected>Class</option>
                                        {/if}
										<option value="A">A</option>
										<option value="B">B</option>
										<option value="C">C</option>
										<option value="D">D</option>
										<option value="E">E</option>
										<option value="F">F</option>
										<option value="G">G</option>
										<option value="H">H</option>
										<option value="I">I</option>
										<option value="J">J</option>
										<option value="K">K</option>
										<option value="L">L</option>
										<option value="M">M</option>
										<option value="N">N</option>
										<option value="O">O</option>
										<option value="P">P</option>
										<option value="Q">Q</option>
										<option value="R">R</option>
										<option value="S">S</option>
										<option value="T">T</option>
										<option value="U">U</option>
										<option value="V">V</option>
										<option value="W">W</option>
										<option value="X">X</option>
										<option value="Y">Y</option>
										<option value="Z">Z</option>
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<select class="form-control" name="type" required placeholder="Type" >
                                        {if $type}
											<option value="{$type}">{$type}</option>
                                        {else}
											<option value="" disabled selected>Type</option>
                                        {/if}
										<option value="First Class">First Class</option>
										<option value="Business">Business</option>
										<option value="Economy">Economy</option>
										<option value="High Economy">High Economy</option>
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<input class="form-control" name="penalty" value="{$penalty}" id="penalty" onkeyup="findTotal()" required placeholder="Penalty">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<input class="form-control" name="mark_up" value="{$mark_up}" id="mark_up" onkeyup="findTotal()" required placeholder="Mark UP">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<input class="form-control" name="total" value="{$total}" id="total" required placeholder="Total" readonly>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
										<input type="text" name="dep_time" class="form-control" id="timepicker" placeholder="Departure time" required="required" style="width: 100%;" onclick="findTotal()">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
										<input type="text" name="arr_time" class="form-control" id="timepicker1" placeholder="Arrival time" required="required" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" id="returnDepartureTime" style="visibility:visible;">
									<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
										<input type="text" name="rtn_dep_time" class="form-control" id="timepicker2" readonly placeholder="Return departure time" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group" id="returnArrivalTime" style="visibility:visible;">
									<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
										<input type="text" name="rtn_arr_time" class="form-control" id="timepicker3" readonly placeholder="Return arrival time" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
						</div>

                        {if $edit=='on'}
							<button type="submit" name="ok" value="Update" class="btn btn-primary">Update</button>
                        {else}
							<button type="submit" name="ok" value="Save" class="btn btn-primary">Save</button>
                        {/if}
						<button type="reset" class="btn btn-primary">Reset</button>

					</form>
				</div>
			</div>
		</div>
	</div>
    {if $date_change_no}
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>General Information | <strong>Date Change No : {$date_change_no}</strong></strong>
				</div>
				<div class="panel-body">
					<form role="form" action="date_change.php?job=save" method="post">

						<div class="row">
							<div class="col-lg-12">
								<label>Flight Details</label>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-2">
								<div class="form-group">
									<select class="form-control" id="way" onchange="ifReturn()" name="way" required placeholder="One way or Return" >
                                        {if $way}
											<option value="{$way}">{$way}</option>
                                        {else}
											<option value="" disabled selected>One way or Return</option>
                                        {/if}
										<option value="One Way">One Way</option>
										<option value="Return">Return</option>
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<select class="form-control" name="dep_air_port" required placeholder="Departure Airport" >
                                        {if $arr_air_port}
											<option value="{$dep_air_port}">{$dep_air_port}</option>
                                        {else}
											<option value="" disabled selected>Departure Airport</option>
                                        {/if}
                                        {section name=dep_air_port loop=$air_port_names}
											<option value="{$air_port_names[dep_air_port]}">{$air_port_names[dep_air_port]}</option>
                                        {/section}
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<select class="form-control" name="arr_air_port" required placeholder="Arrival Airport" >
                                        {if $arr_air_port}
											<option value="{$arr_air_port}">{$arr_air_port}</option>
                                        {else}
											<option value="" disabled selected>Arrival Airport</option>
                                        {/if}
                                        {section name=arr_air_port loop=$air_port_names}
											<option value="{$air_port_names[arr_air_port]}">{$air_port_names[arr_air_port]}</option>
                                        {/section}
									</select>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<input class="form-control" name="pax_count" value="{$pax_count}" required placeholder="PAX">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
										<input type="text" name="dep_date" class="form-control" id="datepicker" value="{$dep_date}" readonly required placeholder="Departure Date" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="returnDate" style="visibility:visible;">
									<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
										<input type="text" name="rtn_date" class="form-control" id="datepicker1" value="{$rtn_date}" readonly placeholder="Return Date" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
						</div>

						<ul class="nav nav-pills">
							<li class="active"><a href="#own" data-toggle="tab">NATION TRAVELS BOOKING</a></li>
							<li><a href="#out" data-toggle="tab">New Booking</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade in" id="out">
								<div class="row" style="margin-top: 20px;">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group">
													<input class="form-control customer" name="customer" value="{$customer}" placeholder="Name">
												</div>
											</div>
											<div class="col-lg-2">
												<div class="form-group">
													<input class="form-control" name="mobile" value="{$mobile}" placeholder="Mobile">
												</div>
											</div>
											<div class="col-lg-2">
												<div class="form-group">
													<input class="form-control" name="phone" value="{$phone}" placeholder="Phone">
												</div>
											</div>
											<div class="col-lg-2">
												<div class="form-group">
													<input class="form-control" name="email" value="{$email}" placeholder="Email">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												<div class="form-group">
													<textarea class="form-control" name="address" placeholder="Address" rows="2">{$address}</textarea>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<textarea class="form-control" name="note" placeholder="Note" rows="2">{$note}</textarea>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade in active" id="own">
								<div class="row" style="margin-top: 20px;">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control booking_no" type="text" name="booking_no" value="{$booking_no}" placeholder="Booking No"/>
										</div>
									</div>
								</div>
							</div>
						</div>

                        {if $search=='On'}
							<button type="submit" name="main_ok" value="Update" class="btn btn-primary">Update</button>
                        {else}
							<button type="submit" name="main_ok" value="Save" class="btn btn-primary">Save</button>
                        {/if}
						<button type="reset" class="btn btn-primary">Reset</button>
				</div>
				</form>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-red" style="margin-top: 10px;">
				<div class="panel-heading">
					Fare Details
				</div>
				<div class="panel-body">
                    {php}list_date_change_has_items($_SESSION['date_change_no']);{/php}
				</div>
			</div>
		</div>
	</div>
</section>
{/if}
{include file="footer.tpl"}
{literal}
	<script>
        $(function () {

            $('#timepicker').timepicker({
            });
        });
	</script>

	<script>
        $(function () {

            $('#timepicker1').timepicker({
            });
        });
	</script>

	<script>
        $(function () {

            $('#timepicker2').timepicker({
            });
        });
	</script>

	<script>
        $(function () {

            $('#timepicker3').timepicker({
            });
        });
	</script>
	<script>
        $(function () {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
	</script>

	<script>
        $(function () {
            $('#datepicker1').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
	</script>
	<script>
		$(function () {
			$("#example1").DataTable();
		});
	</script>

{/literal}