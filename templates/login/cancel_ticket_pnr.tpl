{include file="header.tpl"}
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading" style="text-align: center;"><h3 style="margin-top: 10px; margin-bottom: 10px;">Cancel Ticket PNR</h3>
                </div>
                <div class="panel-body">
                    <form action="login.php?job=cancel_pnr" method="post">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="PNR" name="pnr" type="text" autofocus>
                            </div>
                        </fieldset>
                    </form>
                    {php}list_canceled_pnr();{/php}

                    <form action="login.php?job=done_cancel" method="post">
                        <fieldset>
                            <input type="submit" class="btn btn-lg btn-success btn-block" Value="Done"/>
                        </fieldset>
                    </form>
                </div>
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