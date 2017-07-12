{include file="header.tpl"}
{include file="navigation.tpl"}

{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.customer').typeahead({
                name: 'customer',
                remote : 'ajax/customer_id_and_name.php?query=%QUERY'

            });
        })
	</script>

{/literal}

{if $error_message}
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="alert alert-danger"><strong>{$error_message}</strong></div>

		</div>
	</div>
{/if}
<section class="content">
	<div class="row" onload="ifReturn()">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="box box-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<form role="form" action="loan.php?job=search" method="post" name="add_item">
						<div class="form-group">
							<input type="text" name="search" value="{$loan_no}" placeholder="Search By loan No" class="form-control"/>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>loan Details</strong>
				</div>
				<div class="panel-body">
					<form role="form" action="loan.php?job=save" method="post" name="add_item">
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<input class="form-control" name="loan_amount" value="{$loan_amount}" placeholder="Loan Amount" required="required">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<input class="form-control" name="interest" value="{$interest}" placeholder="Interest" required="required">
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
										<input type="text" name="interest_date" class="form-control" id="datepicker" placeholder="Interest Date" value="{$interest_date}" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<select class="form-control" name="type" required>
                                        {if $type}
											<option value="{$type}">{$type}</option>
                                        {else}
											<option value="" disabled selected>Type</option>
                                        {/if}
										<option value="MONTHLY">MONTHLY</option>
										<option value="ANNUAL">ANNUAL</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<div class="form-group">
										<input class="form-control customer" name="customer" value="{$customer}" required placeholder="Name">
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<div class="form-group">
										<input class="form-control" name="mobile" value="{$mobile}" placeholder="Mobile">
									</div>
								</div>
							</div>
						</div>
						<button type="submit" name="ok" value="Save" class="btn btn-primary">Save</button>
						<button type="reset" class="btn btn-primary">Reset</button>
					</form>
				</div>
			</div>
		</div>
	</div>
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