{include file="header.tpl"}
<div style="width: 200mm; margin-left: 10mm;">
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
			<h1><strong>SALARY SLIP</strong></h1>
		</div>
	</div>

	<div class="row" style="margin-bottom: 10px;">
						<div class="col-xs-2">
                    		<strong>Salary No : </strong>{$salary_no}
						</div>
						<div class="col-xs-3">
                    		<strong> Date : </strong>{$date}
						</div>
						<div class="col-xs-3">
                    		<strong>Staff Name : </strong>{$staff_name}
						</div>	
											
					</div>
					<div class="row">
						{php}list_description_by_salary_view($_SESSION['salary_no_report']);{/php}
					</div>
					<form name="receipt" action="staff_salary.php?job=view" method="post">

					
	<div class="row" style="margin-top: 5px; font-size: 12px; margin-left: 1px; margin-top: 20px;">
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