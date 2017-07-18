{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
$(document).ready(function() {
$('input.package').typeahead({
  name: 'package',
  remote : 'ajax/cab_package.php?query=%QUERY'

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
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    <strong>Booking Details</strong>
                </div>
                <div class="panel-body">
            		{php}display_cab_detail($_SESSION['cab_booking_no']);{/php}
				</div>
            </div>
	    </div>
   </div>
	
   <div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    <strong>Vechicle and Driver Details</strong>
                </div>
                <div class="panel-body">
					{if $driver} 
					{php}cab_driver_details($_SESSION['cab_booking_no']);{/php}
					{else}
            		<form name="add_product" action="cab.php?job=confirm" method="post">
						<div class="row">
							<div class="col-lg-2">
		                    	<div class="form-group">
									<input class="form-control" type="text" name="vechicle_model" value="{$vechicle_model}" required="required" placeholder="Vechicle Model"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<input class="form-control" type="text" name="vechicle_no" value="{$vechicle_no}" required="required" placeholder="Vechicle No"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<input class="form-control" type="text" name="driver" value="{$driver}" required="required" placeholder="Driver"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<input class="form-control" type="text" name="license" value="{$license}" required="required" placeholder="License"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<input class="form-control" type="text" name="driver_phone" value="{$driver_phone}" required="required" placeholder="Phone"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
    								<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
        								<input type="text" name="pickup_time" class="form-control" id="timepicker1" value="{$pickup_time}" placeholder="Pickup Time" style="width: 100%;">
        								<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
    								</div>
									<input type="hidden" id="dtp_input1" value="" />
		                    	</div>
		                	</div>
							</div>
									<button type="submit" name="ok" value="Save" class="btn btn-success">Confirm</button>
		                	</form>
	                	</div>
					
					{/if}
					
				</div>
            </div>
	
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    <strong>Add Charges</strong>
                </div>
				<div class="panel-footer">
            		{if $finish=="off"}
					<div class="row">
						<div class="col-lg-12">
							{php}cab_charges_view($_SESSION['cab_booking_no']);{/php}
		                </div>
	                </div>
					{else}
					<form name="add_product" action="cab.php?job=add_package" method="post">
						<div class="row">
							<div class="col-lg-10">
		                    	<div class="form-group">
									<input class="form-control package" type="text" name="package" value="{$package}" required placeholder="Select Package"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<button type="submit" name="ok" value="Add" class="btn btn-danger">Add Pakage</button>
		                   	 	</div>
		                	</div>
	                	</div>
					</form>
					
					<div class="row">
						<div class="col-lg-12">
							{php}cab_charges($_SESSION['cab_booking_no']);{/php}
		                </div>
	                </div>
					{/if}
					{if $finish=="on"}
					<div class="row">
						<div class="col-lg-12" style="text-align: center;">
							<a href="{$link}" class="btn btn-success">Finish Cab</a>
						</div>
	                </div>
					{/if}
				</div>
            </div>
	    </div>
   </div>
{include file="footer.tpl"}

{literal}
<script>
    $(function () {
        $("#example1").DataTable();
    });
</script>
<script>
    $(function () {
        $("#example2").DataTable();
    });
</script>
<script>
    $(function () {
        $("#example3").DataTable();
    });
</script>
<script>
  $(function () {

    $('#timepicker1').timepicker({
    });
 });
</script>
{/literal}