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
            $('input.embassy').typeahead({
                name: 'embassy',
                remote : 'ajax/embassy.php?query=%QUERY'

            });
        })
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.passport_no').typeahead({
                name: 'passport_no',
                remote : 'ajax/passport_no.php?query=%QUERY'

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
					<form role="form" action="itinerary.php?job=search" method="post" name="add_item">
						<div class="form-group">
							<input type="text" name="search" value="{$itinerary_no}" placeholder="Search By Itinerary No" class="form-control"/>
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
					<strong>Itinerary Details</strong>
				</div>
				<div class="panel-body">
					<form role="form" action="itinerary.php?job=next" method="post" name="add_item">
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<input class="form-control embassy" name="country" value="{$country}" placeholder="Embassy">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<select class="form-control" name="type" required>
                                        {if $type}
											<option value="{$type}">{$type}</option>
                                        {else}
											<option value="" disabled selected>Type</option>
                                        {/if}
										<option value="MALE">MALE</option>
										<option value="FEMALE">FEMALE</option>
										<option value="GROUP">GROUP</option>
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<input class="form-control" name="count" value="{$count}" placeholder="Count">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
										<input type="text" name="submit_date" class="form-control" id="datepicker" placeholder="Submitting Date" value="{$submit_date}" required="required" style="width: 100%;" onclick="findTotalInfant(); findTotalChild(); findTotalAdult();">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<div class="form-group">
										<input class="form-control customer" name="customer" value="{$customer}" required placeholder="Name">
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<div class="form-group">
										<input class="form-control" name="mobile" value="{$mobile}" placeholder="Mobile">
									</div>
								</div>
							</div>
						</div>
                        {if $itinerary_no}
							<button type="submit" name="ok" value="Update" class="btn btn-success">Update</button>
                        {else}
							<button type="submit" name="ok" value="Save" class="btn btn-success">Save</button>
                        {/if}
						<button type="reset" class="btn btn-default">Reset</button>

					</form>

                    {if $itinerary_no}
					<div class="row" style="margin-top: 20px;">
						<div class="col-lg-12" style="text-align: center;">
							<strong>Flight Details</strong>
						</div>
					</div>
					<form role="form" action="itinerary.php?job=add_flight" method="post">

						<div class="row" style="margin-top: 20px;">
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
									<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
										<input type="text" name="dep_time" class="form-control" id="datepicker1" value="{$dep_time}" required placeholder="Departure Time" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" id="returnDate" style="visibility:visible;">
									<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
										<input type="text" name="arr_time" class="form-control" id="datepicker2" value="{$arr_time}" readonly placeholder="Arrvial Time" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<input class="form-control" name="flight_no" value="{$flight_no}" required placeholder="Flight No">
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<button type="submit" name="main_ok" class="btn btn-success">Add Flight Detail</button>
								</div>
							</div>
						</div>
					</form>
                    {php}list_itinerary_has_flights($_SESSION['itinerary_no']);{/php}
					<div class="row" style="margin-top: 20px;">
						<div class="col-lg-12" style="text-align: center;">
							<strong>Passenger Details</strong>
						</div>
					</div>
                    {if $passenger_total_updated < $passenger_total}
						<form name="add_product" action="itinerary.php?job=add_passenger" method="post">
							<div class="row" style="margin-top: 20px;">
								<div class="col-lg-2">
									<div class="form-group">
										Passport No :
									</div>
								</div>
								<div class="col-lg-8">
									<div class="form-group">
										<input class="form-control passport_no" type="text" name="passport_no" value="{$passport_no}" required="required" placeholder="Passport No"/>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group">
										<button type="submit" name="ok" value="Save" class="btn btn-success">Add Passenger</button>
									</div>
								</div>
							</div>
						</form>
                    {/if}
                    {php}list_passengers_details($_SESSION['itinerary_no']);{/php}
                    {if $passenger_total_updated==$passenger_total}
						<form name="add_product" action="itinerary.php?job=complete" method="post">
							<div class="row" style="margin-top: 20px;">
								<div class="col-lg-3">
									<div class="form-group">
										<input class="form-control" type="text" name="amount" value="{$amount}" required="required" readonly="readonly" placeholder="Amount"/>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<input class="form-control" type="text" name="off" value="{$off}" required="required" placeholder="Off"/>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<select class="form-control" name="first_time" required>
                                            {if $first_time}
												<option value="{$first_time}">{$first_time}</option>
                                            {else}
												<option value="" disabled selected>First Time To Country</option>
                                            {/if}
											<option value="YES">YES</option>
											<option value="NO">NO</option>
										</select>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<button type="submit" name="ok" value="Save" class="btn btn-primary">Complete Itinerary</button>
									</div>
								</div>
							</div>
						</form>
                    {/if}
				</div>
			</div>
		</div>
	</div>
    {/if}
</section>
{include file="footer.tpl"}
{literal}
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

            $('#datepicker2').datepicker({
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