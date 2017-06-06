{include file="header.tpl"}
	<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading" style="text-align: center;">
                        <h3 style="margin-top: 10px; margin-bottom: 10px;">Is there any cancel tickets today?</h3>
                    </div>
                    <div class="panel-body">
                        <form action="login.php?job=cancel" method="post">
                            <fieldset>
                                <input type="submit" class="btn btn-lg btn-success btn-block" name="cancel" value="Yes"/>
                                <input type="submit" class="btn btn-lg btn-success btn-block" name="cancel" value="No"/>
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

{include file="footer.tpl"}