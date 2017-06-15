{include file="print.tpl"}
<div style="width: 210mm;">
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
			<h1><strong>Cab Invoice</strong></h1>
		</div>
	</div>
	<div class="col-xs-12">

		<div class="row" style="margin-bottom: 10px;">
			<div class="col-xs-2">
				<strong>Ref No : </strong>{$cab_booking_no}
			</div>
		</div>
		<div class="row">
            {php}display_cab_detail($_SESSION['cab_booking_no']);{/php}

            {php}cab_driver_details($_SESSION['cab_booking_no']);{/php}

            {php}cab_charges_view_print($_SESSION['cab_booking_no']);{/php}

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

{literal}
<script>
    $(function () {
        $("#example1").DataTable();
    });
</script>
{/literal}