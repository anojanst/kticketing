{include file="header.tpl"}

<div style="width: 200mm; margin-left: 10mm;">

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

	<div class="row">
		<div class="col-xs-5">
             <strong>To User : </strong>{$to_user}
		</div>
		<div class="col-xs-3">
              <strong>From User : </strong>{$from_user}
		</div>
						
	</div>
	<div class="row">
			{php}chat_history_for2days($_SESSION['to_user'],$_SESSION['from_user']);{/php}
	</div>
</div>

{include file="footer.tpl"}