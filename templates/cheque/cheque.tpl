{include file="header.tpl"}
{include file="navigation.tpl"}

{literal}
<script type="text/javascript">
$(document).ready(function() {
$('input.account').typeahead({
  name: 'account',
  remote : 'ajax/bank.php?query=%QUERY'

});
})
</script>

{/literal}

{if $error_message}
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="alert alert-danger"><strong>{$error_message}</strong></div>
	    </div>
   </div>
{/if}

	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
						<div class="col-lg-3">
							 Bank : {$account}            
                    	</div>
						<div class="col-lg-3">
							 Statement Date : {$statement_date}            
                    	</div>
						<div class="col-lg-1">
							 <a class="btn btn-default" href="cheque.php?job=print">Print</a></b>            
                    	</div>
						<div class="col-lg-3">
							 <a class="btn btn-default" href="cheque.php?job=cheque_select_form">New Date</a></b>            
                    	</div>
					</div>
                </div>
                <div class="panel-body">
            		<!--<form name="cheque_inquiry_form" action="cheque_deposit.php?job=inquiry" method="post">
						<div class="row">
							<div class="col-lg-9">
								<div class="form-group">
									<input class="form-control" type="text" name="che_no" value="{$che_no}" required="required" placeholder="Cheque No"/>
								</div>                 
                    		</div>
							<div class="col-lg-3">
								<div class="form-group">
									<button type="submit" name="ok" class="btn btn-danger">Inquiry</button>
								</div>                 
                    		</div>				
						</div>                 
                   </form>-->
					<div class="row">
						<div class="col-lg-12">
							<h1><u>Not Realised Cheques</u></h1><br />
							{php}list_cheque_not_realised($_SESSION['statement_date'], $_SESSION['account']);{/php}
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<h1><u>Realised Cheques</u></h1><br />
							{php}list_realised_cheques();{/php}
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<h1><u>Return Cheques</u></h1><br />
							{php}list_returned_cheques();{/php}
						</div>
					</div>


            </div>
	    </div>
	</div>

{include file="footer.tpl"}