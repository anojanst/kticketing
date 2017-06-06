{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
$(document).ready(function() {
$('input.customer_name').typeahead({
  name: 'customer_name',
  remote : 'ajax/customer.php?query=%QUERY'

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
			<div class="panel panel-green">
                <div class="panel-heading">
                    Choose Customer
                </div>
                <div class="panel-body">
            		<form name="search_form" action="other_expenses.php?job=search" method="post"  >
						<div class="col-lg-2">
							<div class="form-group">
            					<input class="form-control" type="text" name="other_expenses_no" placeholder="Ref No" />
		            		</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
            					<input type="text" name="customer" placeholder="Customer Name" class="form-control travels"/>
		            		</div>
						</div>
						<div class="col-lg-3">
		                    <div class="form-group" style="visibility:visible;">
    							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        							<input type="text" name="from_date" readonly placeholder="From Date" style="width: 100%;">
        							<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
    							</div>
								<input type="hidden" id="dtp_input1" value="" />
		                    </div>
		                </div>
						<div class="col-lg-3">
		                    <div class="form-group" id="returnDate" style="visibility:visible;">
    							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        							<input type="text" name="to_date" readonly placeholder="To Date" style="width: 100%;">
        							<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
    							</div>
								<input type="hidden" id="dtp_input1" value="" />
		                    </div>
		                </div>
						<div class="col-lg-1">
							<div class="form-group">
								<button type="submit" name="search" value="Search" class="btn btn-danger">Search</button>
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
                   Search Result
                </div>
                <div class="panel-body">
            		{php}search_other_expenses($_SESSION['search_other_expenses_no'], $_SESSION['search_customer'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
				</div>
            </div>
	    </div>
	</div>
{include file="footer.tpl"}