{include file="header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="row">
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Search Outstanding Invoice</strong>
			</div>
			<div class="panel-body">
				<form role="form" action="report_summary.php?job=search" method="post">
					<div class="col-lg-3">
						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="from_date" class="form-control" id="datepicker1" value="{$from_date}"  placeholder="From Date" style="width: 100%;">
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
							<input type="hidden" id="dtp_input1" value="" />
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="to_date" class="form-control" id="datepicker" value="{$to_date}"  placeholder="To Date" style="width: 100%;">
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
							<input type="hidden" id="dtp_input1" value="" />
						</div>
					</div>
					<div class="col-lg-2">
						<button type="submit" name="ok" value="Search" class="btn btn-primary">Search</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
{if $search=="on"}


	<div class="row">
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Outstanding Invoice</strong>
			</div>
			<div class="panel-body">
                {php}final_outstanding_invoice_report($_SESSION['customer'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
			</div>
			<div class="panel-footer">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Outstanding Other Expenses</strong>
			</div>
			<div class="panel-body">
                {php}final_outstanding_other_expenses_report($_SESSION['customer'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
			</div>
			<div class="panel-footer">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Outstanding Voucher</strong>
			</div>
			<div class="panel-body">
                {php}final_outstanding_voucher_report($_SESSION['travels'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
			</div>
			<div class="panel-footer">
			</div>
		</div>
	</div>
{/if}
{include file="footer.tpl"}
{literal}
	<script>
        $(function () {

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
	</script>
	<script>
        $(function () {

            $('#datepicker1').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
	</script>
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

{/literal}