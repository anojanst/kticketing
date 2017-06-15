{include file="header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-green" style="margin-top: 10px;">
				<div class="panel-heading">
					Add Telephone Directory
				</div>
				<div class="panel-body">
					<form name="add_product" action="telephone_directory.php?job=add" method="post" enctype="multipart/form-data">
						<div class="col-lg-2">
							<div class="form-group" style="width: 100%;">
								<input style="width: 100%;" class="form-control" type="text" name="customer_name" value="{$customer_name}" placeholder="Customer Name"/>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group" style="width: 100%;">
								<input style="width: 100%;" class="form-control" type="text" name="telephone_no" value="{$telephone_no}" placeholder="Telephone no"/>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group" style="width: 100%;">
								<input style="width: 100%;" class="form-control" type="text" name="details" value="{$details}" placeholder="Details"/>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group" id="returnDate" style="visibility:visible;">
								<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
									<input type="text" name="date" class="form-control" id="datepicker" readonly placeholder="date" style="width: 100%;">
									<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
								</div>
								<input type="hidden" id="dtp_input1" value="" />
							</div>
						</div>
						<div class="col-lg-2">
							<button type="submit" name="ok" value="add" class="btn btn-primary">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

    {if $view=="on"}
		<div class="row">
			<div class="panel panel-red" style="margin-top: 10px;">
				<div class="panel-heading">
					Users
				</div>
				<div class="panel-body">
                    {php}list_telephone_no($_SESSION['cusromer_no'],$_SESSION['customer_name'],$_SESSION['telephone_no'],$_SESSION['details']),$_SESSION['date']);{/php}
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
		$("#example1").DataTable();
	});
</script>

{/literal}