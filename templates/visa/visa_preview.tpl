{include file="header.tpl"}
{include file="navigation.tpl"}

{if $error_message}
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="alert alert-danger"><strong>{$error_message}</strong></div>

		</div>
	</div>
{/if}
<div class="row">
	<div class="col-lg-12" style="margin-top: 10px;">
		<div class="panel panel-yellow" style="margin-top: 10px;">
			<div class="panel-heading">
				<form role="form" action="visa.php?job=search_edit" method="post" name="add_item">
					<div class="form-group">
						<input type="text" name="search" value="{$visa_no}" placeholder="Search By VISA No" class="form-control"/>
					</div>

				</form>
			</div>

		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12" style="margin-top: 10px;">
		<div class="panel panel-red" style="margin-top: 10px;">
			<div class="panel-heading">
				VISA Details
			</div>
			<div class="panel-body">
                {php}display_visa_detail_full($_SESSION['visa_no']);{/php}

                {php}list_passengers_details_view($_SESSION['visa_no']);{/php}

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