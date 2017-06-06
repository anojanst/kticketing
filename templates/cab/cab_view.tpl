{include file="header.tpl"}
{include file="navigation.tpl"}

	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-primary" style="margin-top: 10px;">
                <div class="panel-heading">
                    Booking Details
                </div>
                <div class="panel-body">
            		{php}display_cab_detail($_SESSION['cab_booking_no']);{/php}
				
					{php}cab_driver_details($_SESSION['cab_booking_no']);{/php}
					
					{php}cab_charges_view($_SESSION['cab_booking_no']);{/php}
		                
				</div>
            </div>
	    </div>
   </div>
{include file="footer.tpl"}