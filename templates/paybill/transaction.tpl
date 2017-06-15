{include file="header.tpl"}


<br />
<br />
<br />


{php} list_paybill_vouchers_view($_SESSION['paybill_no']); {/php}


<br />
<br />
{include file="footer.tpl"}

{literal}
    <script>
        $(function () {
            $("#example1").DataTable();
        });
    </script>
{/literal}