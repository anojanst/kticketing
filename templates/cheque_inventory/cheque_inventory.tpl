{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.status').typeahead({
                name: 'status',
                remote : 'ajax/status.php?query=%QUERY'

            });
        })
	</script>
{/literal}
<section class="content">
	<div class="row">
		<div class="box box-primary" style="margin-top: 10px;">
			<div class="panel-heading">
				Search Cheque Inventory
			</div>
			<div class="panel-body">
				<form role="form" action="cheque_inventory.php?job=list" method="post">
					<div class="col-lg-3">
						<div class="form-group">
							<input class="form-control status" name="status" value="{$status}" placeholder="status">
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="from_date" class="form-control" id="datepicker" value="{$from_date}"  placeholder="From Date" style="width: 100%;">
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
							<input type="hidden" id="dtp_input1" value="" />
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="to_date" class="form-control" id="datepicker1" value="{$to_date}"  placeholder="To Date" style="width: 100%;">
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
				<div class="col-lg-2">
					<a href="cheque_inventory.php?job=cheque_inventory_print"  class="btn btn-primary" target="blank">Print</a>
				</div>
			</div>
		</div>
	</div>

    {if $search=="on"}
		<div class="row">
			<div class="panel panel-red" style="margin-top: 10px;">
				<div class="panel-heading">
					Cheque Inventory
				</div>
				<div class="panel-body">
                    {php}cheque_inventory_report($_SESSION['status'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
				</div>

				<div class="panel-footer">
				</div>
			</div>
		</div>
    {/if}
</section>
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

{/literal}