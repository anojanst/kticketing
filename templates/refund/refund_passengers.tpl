{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
	function findTotal(){
		var s = document.getElementById("amount").value,
			t = document.getElementById("markup").value;
		var tot = +s - +t;
		document.getElementById("total").value=tot;
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
<div class="row">
	<div class="col-lg-12" style="margin-top: 10px;">
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Refund Details</strong>
			</div>
			<div class="panel-body">
                {php}refund_detail($_SESSION['refund_no']);{/php}
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12" style="margin-top: 10px;">
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Passenger for Refund</strong>
			</div>
			<div class="panel-body">
				<h1><strong>Selected Passengers</strong></h1>
                {php}list_passengers_for_refund_no($_SESSION['refund_no']);{/php}
                {if $passenger_total_updated < $passenger_total}
					<h1><strong>All Passengers</strong></h1>
                    {php}list_passengers_booking_no($_SESSION['booking_no']);{/php}
                {/if}
			</div>
		</div>
	</div>
</div>


{if $passenger_total_updated==$passenger_total}
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>Other Details</strong>
				</div>
				<div class="panel-body">
					<form name="add_product" action="refund.php?job=complete" method="post">
						<div class="row" style="margin-top: 20px;">
							<div class="col-lg-3">
								<div class="form-group">
									<input class="form-control" type="text" id="amount" name="amount" value="{$amount}" required="required" onkeyup="findTotal();" placeholder="Amount"/>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<input class="form-control" type="text" id="markup" name="markup" value="{$markup}" required="required" onkeyup="findTotal();" placeholder="Markup"/>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<input class="form-control" type="text" id="total" name="total" value="{$total}" required="required" placeholder="Total" readonly="readonly"/>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<button type="submit" name="ok" value="Save" class="btn btn-danger">Complete Refund</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
{/if}

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
{/literal}