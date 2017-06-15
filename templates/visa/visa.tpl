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
            $('input.passport_no').typeahead({
                name: 'passport_no',
                remote : 'ajax/passport_no.php?query=%QUERY'

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
        $(document).ready(function() {
            $('input.country').typeahead({
                name: 'country',
                remote : 'ajax/country.php?query=%QUERY'

            });
        })
	</script>

	<script type="text/javascript">
        function findTotal(){
            var x = document.getElementById("count").value,
                y = document.getElementById("cost").value,
                z = document.getElementById("markup").value;

            var total =(+y + +z) * +x;
            document.getElementById("total").value=total;
        }
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
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-yellow" style="margin-top: 10px;">
				<div class="panel-heading">
					<form role="form" action="visa.php?job=search_edit" method="post" name="add_item">
						<div class="form-group">
							<input type="text" name="search" value="{$visa_no}" placeholder="Search By VISA No" class="form-control"/>
						</div>

					</form>
				</div>

			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-red" style="margin-top: 10px;">
				<div class="panel-heading">
					VISA Details
				</div>
				<div class="panel-body">
                    {if $passenger=="on"}
                        {php}display_visa_detail($_SESSION['visa_no']);{/php}
                    {else}
						<form role="form" action="visa.php?job=save" method="post" name="add_item">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<input class="form-control country" name="country" value="{$country}" required placeholder="To">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<select class="form-control" name="visa_type" required placeholder="Type" >
                                            {if $visa_type}
												<option value="{$visa_type}">{$visa_type}</option>
                                            {else}
												<option value="" disabled selected>Type</option>
                                            {/if}
											<option value="Tourist">Tourist</option>
											<option value="Medical">Medical</option>
											<option value="Student">Student</option>
											<option value="Business">Business</option>
										</select>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<input class="form-control" name="days" value="{$days}" required placeholder="Staying Days">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<input class="form-control" name="count" id="count" onkeyup="findTotal();" value="{$count}" required placeholder="Passenger Count">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<input class="form-control customer" name="customer" value="{$customer}" required="required" placeholder="Customer">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<input class="form-control" name="mobile" value="{$mobile}" placeholder="Moblie">
									</div>
								</div>
							</div>


                            {if $search=='On'}
								<button type="submit" name="main_ok" value="Update" class="btn btn-primary">Update</button>
                            {else}
								<button type="submit" name="main_ok" value="Save" class="btn btn-primary">Save</button>
                            {/if}
							<button type="reset" class="btn btn-default">Reset</button>

						</form>
                    {/if}

                    {if $passenger=='on'}
						<div class="row">
                            {if $passenger_total_updated < $passenger_total}
								<form name="add_product" action="visa.php?job=add_passenger" method="post">
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
								</form>
                            {/if}
							<div class="col-lg-12">
                                {php}list_passengers_detail($_SESSION['visa_no']);{/php}
							</div>
						</div>
                        {if $passenger_total_updated == $passenger_total}
							<div class="row">
								<form name="add_product" action="visa.php?job=finish" method="post">
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" id="cost" name="cost" value="{$cost}" onkeyup="findTotal();" required="required" placeholder="Cost Per Person">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" id="markup" name="markup" value="{$markup}" onkeyup="findTotal();" required="required" placeholder="Mark up Per Person">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<input class="form-control" id="total" name="total" value="{$total}" required="required" placeholder="Total" readonly="readonly">
										</div>
									</div>
									<div class="col-lg-3">
										<div class="form-group">
											<button type="submit" name="ok" value="Save" class="btn btn-success">Finish</button>
										</div>
									</div>
								</form>
							</div>
                        {/if}
                    {/if}
				</div>
			</div>
		</div>
	</div>
</section>
{include file="footer.tpl"}