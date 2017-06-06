{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
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
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-primary" style="margin-top: 10px;">
                <div class="panel-heading">
                    Booking Details
                </div>
                <div class="panel-body">
            		{php}display_booking_detail($_SESSION['date_change_no'], $_SESSION['id']);{/php}
				</div>
            </div>
	    </div>
   </div>
	
   <div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-green" style="margin-top: 10px;">
                <div class="panel-heading">
                    Enter Passenger Detail
                </div>
                <div class="panel-body">
					{if $passenger_total_updated < $passenger_total} 
            		<form name="add_product" action="date_change.php?job=add_passenger" method="post">
						<div class="row">
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
					{php}list_passengers_details_for_date_change($_SESSION['date_change_no']);{/php}
				</div>
            </div>
	    </div>
   </div>
	
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Other Details
                </div>
                <div class="panel-body">
            		{php}display_booking_cost($_SESSION['date_change_no'], $_SESSION['id']);{/php}
				</div>
				<div class="panel-footer">
            		<form name="add_product" action="date_change.php?job=booking_complete" method="post">
						<div class="row">
							<div class="col-lg-4">
		                    	<div class="form-group">
									<strong>Add PNR & Complete Date Change</strong>
		                   	 	</div>
		                	</div>
						</div>
						<div class="row">
							<div class="col-lg-2">
		                    	<div class="form-group">
    							<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
        							<input type="text" name="issue_date" readonly placeholder="Issuing Date" style="width: 100%;">
        							<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
    							</div>
								<input type="hidden" id="dtp_input1" value="" />
		                    </div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<input class="form-control" type="text" name="pnr" value="{$pnr}" required placeholder="PNR"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<input class="form-control" type="text" name="al_ref" value="{$al_ref}" placeholder="Air Lines Refference"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<input class="form-control" type="text" name="flight_no" value="{$flight_no}" placeholder="Flight No"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<input class="form-control" type="text" name="rtn_flight_no" value="{$rtn_flight_no}" placeholder="Rtn Flight No"/>
		                   	 	</div>
		                	</div>
							<div class="col-lg-3">
		                    	<div class="form-group">
									<button type="submit" name="ok" value="Save" class="btn btn-danger">Save & Complete Booking</button>
								</div>
		                	</div>
	                	</div>
					</form>
				</div>
            </div>
	    </div>
   </div>
{include file="footer.tpl"}