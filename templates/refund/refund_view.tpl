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
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Refund Details</strong>
			</div>
			<div class="panel-body">
                {php}refund_detail($_SESSION['refund_no']);{/php}
                {php}list_passengers_for_refund_no_view($_SESSION['refund_no']);{/php}
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
	<script>
        $(function () {
            $("#exampl2").DataTable();
        });
	</script>
{/literal}