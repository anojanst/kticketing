{include file="header.tpl"}
{include file="navigation.tpl"}

<section class="content">
    {if $error_message}
		<div class="row">
			<div class="col-lg-12" style="margin-top: 10px;">
				<div class="alert alert-danger"><strong>{$error_message}</strong></div>
			</div>
		</div>
    {/if}

	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Search By Transfer No</strong>
				</div>
				<div class="panel-body">
					<form name="transfer_form" action="cash_transfer.php?job=save" method="post">
						<div class="row">
							<div class="col-lg-3">
								<div class="form-group">
									<select class="form-control" name="branch" required>
                                        {if $branch}
											<option value="{$branch}">{$branch}</option>
                                        {else}
											<option value="" disabled selected>Select A Branch</option>
                                        {/if}
                                        {section name=branch loop=$branches}
											<option value="{$branches[branch]}">{$branches[branch]}</option>
                                        {/section}
									</select>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
										<input type="text" name="date" id="datepicker" class="form-control" value="{$date}"  placeholder="Date" style="width: 100%;"/>
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<input class="form-control" type="text" name="amount" value="{$amount}" required="required" placeholder="Amount"/>
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<button type="submit" name="ok" class="btn btn-danger">Transfer</button>
								</div>
							</div>
						</div>
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