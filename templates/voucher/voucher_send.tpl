{include file="header.tpl"}
{include file="navigation.tpl"}
	<div class="row" style="margin-top: 20px; margin-bottom: 30px;">
		<form name="receipt" action="voucher.php?job=send_mail" method="post" enctype="multipart/form-data">
			<div class="col-lg-1">To :</div>
			<div class="col-lg-11">
				<div class="form-group">
					<input class="form-control travels" type="text" name="to" required="required"/>
				</div> 
			</div>
			<div class="col-lg-1">Subject :</div>
			<div class="col-lg-11">
				<div class="form-group">
					<input class="form-control" type="text" name="subject" required="required"/>
				</div> 
			</div>
			<div class="col-lg-1">File :</div>
			<div class="col-lg-11">
		                    	<div class="form-group">
									<input class="form-control" type="file" name="file" id="file" required="required"/>
		                   	 	</div>
		                	</div>
			<div class="col-lg-12" align="center">
				<button type="submit" name="ok" value="Send" class="btn btn-danger">Send</button>
			</div>
		</form>
	</div>
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-4">
			<img src="images/nation_logo.png" alt="Nation Popular Travels & Tours" style="width: 55mm;"/>
		</div>
		<div class="col-xs-8">
			<div style="font-size: 13px; margin-top: -10px;">
				<h1><strong>NATION POPULAR TRAVELS & TOURS</strong></h1>
					16 1/2, E.S. Fernando Mawatha, Colombo 06<br />
					<strong>Hot Line :</strong> +94 11 4651199 <strong>Tel :</strong> +94 11 4375357 <strong>Fax :</strong> +94 11 4505532<br />
					<strong>E-mail :</strong> online@nationtravels.com <br />
					<strong>Web :</strong> nationtravels.com <br />
			</div>
		</div>
	</div>
	
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-12" style="text-align: center; margin-top: -10px;">
			<h1><strong>EXCHANGE ORDER</strong></h1>
		</div>
	</div>
	<div class="col-xs-12">
	<div class="row" style="margin-bottom: 10px;">
						<div class="col-xs-12">
                    		<strong>To : </strong>{$travels}
						</div>
									
	</div>
	<div class="row" style="margin-bottom: 10px;">
						<div class="col-xs-12" style="text-align: center;">
                    		In Exchange for this order please issue the following tickets
						</div>
	</div>


	<div class="row" style="margin-bottom: 10px;">
						<div class="col-xs-2">
                    		<strong>Voucher No : </strong>{$voucher_no}
						</div>
						<div class="col-xs-4">
                    		<strong>Voucher Date : </strong>{$voucher_date}
						</div>
						<div class="col-xs-3">
                    		<strong>Booking No : </strong>{$booking_no}
						</div>
						<div class="col-xs-3">
                    		<strong>Booking Ref : </strong>{$pnr}
						</div>						
					</div>
					<div class="row">
						<div class="col-xs-5">
                    		{php} get_booking_passengers_for_voucher_view($_SESSION['booking_no'], $_SESSION['voucher_no']); {/php}
						</div>
						<div class="col-xs-7">
				    		{php} get_booking_details_for_voucher($_SESSION['booking_no']); {/php}
						</div>
					</div>
					<form name="receipt" action="voucher.php?job=save" method="post">

					<div class="row">
						<div class="table-responsive col-xs-12">
              				<table class="table" style="font-size: 14px;">
									<tr>
										<td>Time Limit </td><td>: {$time_limit}</td>
									</tr>
									<tr>
										<td>Fare </td><td>: {$fare}</td>
									</tr>
									<tr>
										<td>BTT OR Less COM </td><td>: {$btt_or_less} {$bol_amount}</td>
									</tr>
									<tr>
										<td>Total Without Tax </td><td>: {$sub_tot}</td>
									</tr>
									<tr>
										<td>Taxes </td><td>: {$taxes}</td>
									</tr>
									<tr>
										<td>Total </td><td>: {$total}</td>
									</tr>
								</table>
						</div>
					</div>
	<div class="row" style="margin-top: 5px; font-size: 12px; margin-left: 1px;">
		<div class="col-xs-12">
			<div class="table-responsive">
              <table class="table">
				<tr>
					<td width="120">PREPARED BY :</td>
					<td width="150"><strong>{$saved_by}</strong></td>
					<td width="200">AUTHORIZED SIGNATURE :</td>
					<td></td>
				</tr>

			  </table>
			</div>
		</div>
	</div>
	<div class="row" style="margin-bottom: 10px;">
						<div class="col-xs-12" style="text-align: center;">
                    		We do not hold ourselves responsible for any alteration made in this document
						</div>
	</div>
</div>

{include file="footer.tpl"}