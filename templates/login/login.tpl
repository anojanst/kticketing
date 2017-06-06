{include file="header.tpl"}


		<div class="row">
			<div class="col-lg-12">
            	 <img src="images/flyjaffna2.png" style="width: 100%" />
	    	</div>
		</div>
        <div class="row">
			<div class="col-lg-8" style="text-align: center;" >
            	<h1 style="font-size:30pt; margin-top:100px;">We Are Coming With a New Look.</h1>
	    	</div>
            <div class="col-lg-3">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading" style="text-align: center;">
                        <img src="images/logo.png" width="60" height="60" /><h2 class="panel-title">Please Sign In</h2>
                    </div>
                    <div class="panel-body">
                        <form action="login.php?job=login" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="User Name" name="user_name" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" class="btn btn-lg btn-success btn-block" Value="Login"/>
                                
                                {if $error}
                                <div class="alert alert-danger" style="margin-top: 10px;">
                                	{$error}
                            	</div>
                            	{/if}
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

{include file="footer.tpl"}