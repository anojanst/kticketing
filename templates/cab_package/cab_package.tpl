{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(function() {

            //autocomplete
            $(".auto").autocomplete({
                source: "ajax/query_cab_package.php",
                minLength: 1
            });

        });
	</script>
{/literal}
<section class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>Add new Cab Package</strong>
				</div>
				<div class="panel-body">
					<form role="form" action="cab_package.php?job=add" method="post">
						<div class="form-group">
							<input class="form-control" name="cab_package_code" value="{$cab_package_code}" required placeholder="Cab Package Code" autofocus="autofocus">
						</div>
						<div class="form-group">
							<input class="form-control" name="rate" value="{$rate}" required placeholder="Rate">
						</div>
						<div class="form-group">
							<select class="form-control" name="type" required placeholder="Type" >
                                {if $type}
									<option value="{$type}">{$type}</option>
                                {else}
									<option value="" disabled selected>Type</option>
                                {/if}
								<option value="Distance">Distance</option>
								<option value="Place">Place</option>
								<option value="Day">Day</option>
								<option value="Additional (KM)">Additional (KM)</option>
								<option value="Additional (Day)">Additional (Day)</option>
								<option value="Waiting Charge (hour)">Waiting Charge (hour)</option>
								<option value="Waiting Charge (night)">Waiting Charge (night)</option>
								<option value="Parking">Parking</option>
								<option value="Highway">Highway</option>
							</select>
						</div>

                        {if $edit=='on'}
							<button type="submit" name="ok" value="Update" class="btn btn-primary">Update</button>
                        {else}
							<button type="submit" name="ok" value="Save" class="btn btn-primary">Save</button>
                        {/if}
						<button type="reset" class="btn btn-primary">Reset</button>

					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>Air Lines</strong>
				</div>
				<div class="panel-body">
                    {php}list_cab_packages();{/php}
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</section>
{include file="footer.tpl"}

{literal}
	<script>
        $(function () {
            $("#example1").DataTable();
        });
	</script>
{/literal}