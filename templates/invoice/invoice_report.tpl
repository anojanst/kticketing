{include file="header.tpl"}
<div style="max-width: 210mm;">
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-4">
			<img src="images/nation_logo.png" alt="Nation Popular Travels & Tours" style="width: 55mm;"/>
		</div>
		<div class="col-xs-7">
			<div style="font-size: 12px; margin-top: -10px;">
				<h3><strong>NATION POPULAR TRAVELS & TOURS</strong></h3>
					16 1/2, E.S. Fernando Mawatha, Colombo 06<br />
					<strong>Hot Line :</strong> +94 11 4651199 <strong>Tel :</strong> +94 11 4375357 <strong>Fax :</strong> +94 11 4505532<br />
					<strong>E-mail :</strong> online@nationtravels.com <br />
					<strong>Web :</strong> nationtravels.com <br />
			</div>
		</div>
	</div>
	
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-12" style="text-align: center; margin-top: -10px;">
			<h1><strong>Other Incomes</strong></h1>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
						<div class="col-xs-3">
                    		<strong>Invoice No : </strong>{$invoice_no}
						</div>
						<div class="col-xs-3">
                    		<strong>Invoice Date : </strong>{$invoice_date}
						</div>
						<div class="col-xs-3">
                    		<strong>Ref No : </strong>{$ref_no}
						</div>
						<div class="col-xs-3">
                    		<strong>Customer : </strong>{$customer}
						</div>						
					</div>
					<div class="row">
						{php}list_description_by_invoice_view($_SESSION['invoice_no_report']);{/php}
					</div>
					<form name="receipt" action="voucher.php?job=save" method="post">

					
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
	
</div>

{include file="footer.tpl"}