{include file="header.tpl"}
{include file="navigation.tpl"} 

{literal}

</script>
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

<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="box box-primary">
                <div class="panel-heading">
                    Search By Transfer No
                </div>
                <div class="panel-body">
            		<form name="transfer_form" action="transfer.php?job=save" method="post">
						<div class="row">
							<div class="col-lg-2">
								<div class="form-group">
									<input class="form-control" type="text" name="transfer_no" value="{$transfer_no}" readonly />
								</div>                 
                    		</div>
							<div class="col-lg-2">
								<div class="form-group">
									<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        								<input type="text" name="date" value="{$date}" class="form-control" id="datepicker" readonly placeholder="Date" style="width: 100%;">
        								<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
    								</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>                
                    		</div>
							<div class="col-lg-3">
								<div class="form-group">
									<input class="account form-control" type="text" name="from_bank" required="required" placeholder="From Bank"/>
								</div>                 
                    		</div>
							<div class="col-lg-3">
								<div class="form-group">
									<input class="account form-control" type="text" name="to_bank" required="required" placeholder="To Bank"/>
								</div>                 
                    		</div>
							<div class="col-lg-2">
								<div class="form-group">
									<input class="form-control" type="text" name="amount" value="{$amount}" required="required" placeholder="Amount"/>
								</div>                 
                    		</div>
							<div class="col-lg-12">
								<div class="form-group">
									<input class="form-control" type="text" name="narration" value="{$narration}" required="required" placeholder="Note"/>
								</div>                 
                    		</div>
							<div class="col-lg-3">
								<div class="form-group">
									<button type="submit" name="ok" class="btn btn-primary">Save</button>
								</div>                 
                    		</div>				
						</div>                 
                   </form>
				</div>
            </div>
	    </div>
	</div>

	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-red">
                <div class="panel-heading">
                   Latest Transfers
                </div>
                <div class="panel-body">
            		{php}list_transfer();{/php}
				</div>
            </div>
	    </div>
	</div>
</section>
{include file="footer.tpl"}
{literal}
<script>
  $(function () {

    $('#datepicker').datepicker({
     format: 'yyyy-mm-dd',
      autoclose: true
    });
 });
</script>
{/literal}