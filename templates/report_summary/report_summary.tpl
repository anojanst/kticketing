{include file="header.tpl"}
{include file="navigation.tpl"}

<div class="row">
	<div class="panel panel-primary" style="margin-top: 10px;">
		<div class="panel-heading">
                    Search Outstanding Invoice
                </div>
                <div class="panel-body">
            
            <form role="form" action="report_summary.php?job=search" method="post">
	             
										
	             <div class="col-lg-3">
	        		   <div class="form-group" style="visibility:visible;">
    							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        							<input type="text" name="from_date" value="{$from_date}"  placeholder="From Date" style="width: 100%;">
        							<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
    							</div>
								<input type="hidden" id="dtp_input1" value="" />
		                    </div>
				 </div>
				  <div class="col-lg-3">
	           			 <div class="form-group" style="visibility:visible;">
    							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        							<input type="text" name="to_date" value="{$to_date}"  placeholder="To Date" style="width: 100%;">
        							<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
    							</div>
								<input type="hidden" id="dtp_input1" value="" />
		                    </div>
				 </div>
				 <div class="col-lg-2">
					<button type="submit" name="ok" value="Search" class="btn btn-primary">Search</button>
				</div>
	      </form>
			
         </div>           
	</div>
</div>

{if $search=="on"}


	<div class="row">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Outstanding Invoice
                </div>
                <div class="panel-body">
                    {php}final_outstanding_invoice_report($_SESSION['customer'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
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
					 {php}final_outstanding_other_expenses_report($_SESSION['customer'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
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
                    {php}final_outstanding_voucher_report($_SESSION['travels'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
                </div>
                <div class="panel-footer">
                </div>
            </div>
   </div>

{/if}

{include file="footer.tpl"}