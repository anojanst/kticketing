{include file="header.tpl"}
{include file="navigation.tpl"}


<div class="col-lg-12">
    <div class="panel panel-red" style="margin-top: 10px;">
        <div class="panel-heading">
            Customer List
        </div>
        <div class="panel-body">
            {php}list_customer_gift_voucher();{/php}
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