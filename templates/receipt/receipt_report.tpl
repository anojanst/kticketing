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
		<div class="col-xs-12" style="text-align: center; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin-top: -20px; padding-top: 5px;">
			<h1 style="margin-top: -1px;"><strong>Branches</strong></h1>
		</div>
	</div>
	<div class="row" style="border: 1px solid black; margin-left: 1px;">
		<div class="col-xs-4">
			<div style="font-size: 11px;  margin-top: -10px;">
				<h1><strong>Jaffna</strong></h1>
				128, Brown Road, Jaffna<br />
				<strong>Hot Line :</strong> +94 21 4920920 <br />
				<strong>Tel :</strong> +94 21 4920505 <br />
				<strong>Fax :</strong> +94 21 7538325<br />
				<strong>E-Mail :</strong> jaffna@nationtravels.com <br />
			</div>
		</div>
		<div class="col-xs-4" style="text-align: center; margin-top: -10px;">
			<div style="font-size: 11px;">
				<h1><strong>Vavuniya</strong></h1>
				179A, Railway Station Road, Vairavapuliyankulam<br />
				<strong>Hot Line :</strong> +94 24 4930830 <br />
				<strong>Fax :</strong> +94 24 4930831<br />
				<strong>E-Mail :</strong> va@nationtravels.com <br />
			</div>
		</div>
		<div class="col-xs-4" style="text-align: right;">
			<div style="font-size: 11px;  margin-top: -10px;">
				<h1><strong>Modera</strong></h1>
				27, Lower St.Andrews Place, <br />Colombo-15<br />
				<strong>Hot Line :</strong> +94 11 4375357 <br />
				<strong>E-Mail :</strong> de@nationtravels.com <br />
			</div>
		</div>
	</div>
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-12" style="text-align: center; margin-top: -10px;">
			<h1><strong>OFFICIAL RECEIPT</strong></h1>
		</div>
	</div>
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-12" style="margin-top: -10px;">
			<h1><strong>Refference</strong></h1>
		</div>
	</div>
	<div class="row" style="font-size: 13px; border: 1px solid black; margin-left: 1px;">
		<div class="col-xs-3">
			<strong>Receipt No :</strong> {$rec_no}
		</div>
		<div class="col-xs-3">
			<strong>Date :</strong> {$date}
		</div>
		<div class="col-xs-3">
			<strong>Invoice No :</strong> {php}list_receipt_invoice_no($_SESSION['rec_no']);{/php}
		</div>
		<div class="col-xs-3">
			<strong>Booking No :</strong> {php}list_receipt_booking_no($_SESSION['rec_no']);{/php}
		</div>
	</div>
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-12" style="margin-top: -10px;">
			<h1><strong>Customer Information</strong></h1>
		</div>
	</div>
	<div class="row" style="font-size: 13px; border: 1px solid black; margin-left: 1px;">
		<div class="col-xs-6">
			<strong>Customer Name :</strong> {$customer_name}
		</div>
		<div class="col-xs-6">
			<strong>Address :</strong> {$address|wordwrap:40}
		</div>
	</div>
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-12">
			<h1><strong>Payment Details</strong></h1>
		</div>
	</div>
	<div class="row" style="margin-top: 5px; font-size: 13px; margin-left: 1px;">
		<div class="col-xs-12">
			<div class="table-responsive">
              <table class="table" style="font-size: 13px;">
				<tr>	
					<td style="width: 160mm;">Total Fee</td>
					<td align="right">{$total}.00</td>
				</tr>
				<tr>	
					<td>Total Service Charge</td>
					<td align="right">0.00</td>
				</tr>
				<tr>	
					<td> <strong>Total</strong></td>
					<td align="right" style="border-bottom: double silver;"><strong>{$total}.00</strong></td>
				</tr>
				<tr>	
					<td><strong>Total In Words :</strong> {$total_word}</td>
				</tr>
			  </table>
			</div>
		</div>
	</div>
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-12" style="margin-top: -20px;">
			<h1><strong>Payment Methods</strong></h1>
		</div>
	</div>
	<div class="row" style="margin-top: 5px; font-size: 13px; margin-left: 1px;">
		<div class="col-xs-12">
			<div class="table-responsive">
              <table  class="table">
				<tr>
					<td>CASH</td>
					<td align="right"><strong>{$cash_amount}</strong></td>
					<td></td>
					<td></td>
					
				</tr>
				{if $card_no}
				<tr>
					<td>CARD</td>
					<td align="right"><strong>{$card_amount}</strong></td>
					<td>CARD DETAILS</td>
					<td><strong>{$card_no} {$card_bank}</strong></td>
					
				</tr>
				{/if}
				{if $bank}
				<tr>
					<td>DEPOSIT</td>
					<td align="right"><strong>{$dep_amount}</strong></td>
					<td>BANK DETAILS</td>
					<td><strong>{$bank} {$dep_date}</strong></td>
					
				</tr>
				{/if}
				{if $cheque_no}
				<tr>
					<td>CHEQUE</td>
					<td align="right"><strong>{$cheque_amount}</strong></td>
					<td>CHEQUE DETAILS</td>
					<td><strong>{$cheque_no} {$cheque_bank} {$cheque_date}</strong></td>
				</tr>
				{/if}
				
				
				{if $ref_no}
				<tr>
					<td>EZ CASH</td>
					<td align="right"><strong>{$ez_amount}</strong></td>
					<td>EZ DETAILS</td>
					<td><strong>{$ref_no} {$mobile}</strong></td>
					
				</tr>
				{/if}
				
				
				
			  </table>
			</div>
		</div>
	</div>
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-12">
			<h1><strong>Authorization Details</strong></h1>
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
				<tr>
					<td>REMARKS :</td>
					<td colspan="3"><strong>{$remarks}</strong></td>
				</tr>
				<tr>
					<td>Printed On : </td>
					<td  colspan="3">{$smarty.now|date_format:'%Y-%m-%d at %H:%M'}</td>
					
				</tr>

			  </table>
			</div>
		</div>
	</div>
	<div class="row" style="margin-left: 1px;">
		<div class="col-xs-12" style="text-align: center;">
			<strong>We are the wings for your flight <br /> www.nationtravels.com</strong>
		</div>
	</div>
</div>

{include file="footer.tpl"}