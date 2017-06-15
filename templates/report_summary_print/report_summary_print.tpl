{include file="header.tpl"}

<div style="width: 200mm; margin-left: 10mm;">

    <div class="row" style="margin-left: 1px;">
        <div class="col-xs-4">
            <img src="images/nation_logo.png" alt="Nation Popular Travels & Tours" style="width: 55mm;"/>
        </div>
        <div class="col-xs-8">
            <div style="font-size: 13px; margin-top: -10px;">
                <h1><strong>NATION POPULAR TRAVELS & TOURS</strong></h1>
                16 1/2, E.S. Fernando Mawatha, Colombo 06<br />
                <strong>Hot Line :</strong> +94 11 4651199 <strong>Tel :</strong> +94 11 4375357 <strong>Fax :</strong> +94 11 4505532<br />
                <strong>E-mail :</strong> online@nationtravels.com <br />
                <strong>Web :</strong> nationtravels.com <br />
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3">
            <strong>From Date : </strong>{$from_date}
        </div>
        <div class="col-xs-4">
            <strong>To Date : </strong>{$to_date}
        </div>
    </div>

    <div class="row">
        <div  style="margin-top: 10px;">
        </div>
    </div>

    <div class="row">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                Cheque Inventory
            </div>
            <div class="panel-body">
                {php}cheque_inventory_report($_SESSION['status'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                INCOME EXPENSE REPORT
            </div>
            <div class="panel-body">
                {php}income_expence_report($_SESSION['search_branch'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                Staff Profit
            </div>
            <div class="panel-body">
                {php}list_staff_profit($_SESSION['from_date'], $_SESSION['to_date']);{/php}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                Outstanding Invoice
            </div>
            <div class="panel-body">
                {php}outstanding_invoice_report($_SESSION['customer'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                Outstanding Other Expenses
            </div>
            <div class="panel-body">
                {php}outstanding_other_expenses_report($_SESSION['customer'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                Outstanding Voucher
            </div>
            <div class="panel-body">
                {php}outstanding_voucher_report($_SESSION['travels'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                Customer Other Expenses Due
            </div>
            <div class="panel-body">
                {php}customer_other_expenses_due($_SESSION['from_date'], $_SESSION['to_date']);{/php}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                Customer Invoice Due
            </div>
            <div class="panel-body">
                {php}customer_invoice_due($_SESSION['from_date'], $_SESSION['to_date']);{/php}
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                Customer Voucher Due
            </div>
            <div class="panel-body">
                {php}customer_voucher_due($_SESSION['from_date'], $_SESSION['to_date']);{/php}
            </div>
            <div class="panel-footer">
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