{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(function() {

            //autocomplete
            $(".auto").autocomplete({
                source: "ajax/query_air_ports.php",
                minLength: 1
            });

        });
	</script>
{/literal}
<section class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="box box-primary" style="margin-top: 10px;">
				<div class="panel-heading">
					Add new Air Line
				</div>
				<div class="panel-body">
					<form role="form" action="air_ports.php?job=add" method="post">
						<div class="form-group">
							<input class="form-control" name="air_port" value="{$air_port}" required placeholder="Air Port Name With Code" autofocus="autofocus">
						</div>

						<div class="form-group">
							<input class="form-control" name="air_port_code" value="{$air_port_code}" required placeholder="Air Port Code">
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
			<div class="panel panel-red" style="margin-top: 10px;">
				<div class="panel-heading">
					Air Lines
				</div>
				<div class="panel-body">
                    {php}list_air_ports();{/php}
				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</section>
{include file="footer.tpl"}