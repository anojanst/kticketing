{include file="header.tpl"}

<section class="content">
	<div class="nav-tabs-custom">
		<div class="tab-content">


    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading" style="text-align: center;">
						<h3 style="margin-top: 10px; margin-bottom: 10px;">What is your target today?</h3>
                    </div>
                    <div class="panel-body">
                        <form action="login.php?job=target" method="post">
                            <fieldset>
                                <input type="submit" class="btn btn-lg btn-success btn-block" name="target" value="100000"/>
                                <input type="submit" class="btn btn-lg btn-success btn-block" name="target" value="200000"/>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" name="target" value="500000"/>
                                
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

		</div>
	</div>
</section>
 

{include file="footer.tpl"}