{include file="header.tpl"}
{include file="print_company_detail.tpl"}


<div class="row">
	<div class="col-xs-3">
		<strong>From Date : </strong>{$from_date}
	</div>
	<div class="col-xs-4">
		<strong>To Date : </strong>{$to_date}
	</div>
</div>
<div class="row">
    {php}search_receipt_print($_SESSION['search_rec_no'], $_SESSION['search_customer'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
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