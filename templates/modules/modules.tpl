{include file="header.tpl"}
{include file="navigation.tpl"}

<div class="row">
	<div class="col-lg-6" style="margin-top: 10px;">
		<div class="panel panel-info">
			<div class="panel-heading">
				<strong>Add New Modules</strong>
			</div>
			<div class="panel-body">
				<form role="form" action="modules.php?job=save" method="post">
					<div class="form-group">
						<input class="form-control" name="module_name" value="{$module_name}" required placeholder="Module Name">
					</div>

					<div class="form-group">
						<input class="form-control" name="module_no" value="{$module_no}" required placeholder="Module No">
					</div>

                    {if $edit=='on'}
						<button type="submit" name="ok" value="Update" class="btn btn-default">Update</button>
                    {else}
						<button type="submit" name="ok" value="Save" class="btn btn-default">Save</button>
                    {/if}
					<button type="reset" class="btn btn-default">Reset</button>

				</form>

			</div>
		</div>
	</div>
	<div class="col-lg-6" style="margin-top: 10px;">
		<div class="panel panel-success">
			<div class="panel-heading">
				<strong>Modules</strong>
			</div>
			<div class="panel-body">
                {php} list_modules(); {/php}

			</div>
		</div>
	</div>
</div>

{include file="footer.tpl"}

{literal}
	<script>
        $(function () {
            $("#example1").DataTable();
        });
	</script>
{/literal}