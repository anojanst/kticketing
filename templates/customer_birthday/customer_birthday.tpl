{include file="header.tpl"}
{include file="navigation.tpl"}


<div class="row">
	<div class="panel panel-primary" style="margin-top: 10px;">
		<div class="panel-heading">
                    Customer Birthday Report
                </div>
                <div class="panel-body">
            
            <form role="form" action="customer_birthday.php?job=search" method="post">
	             
	             <div class="col-lg-3">
							  <div class="form-group" style="visibility:visible;">
    							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        							<input type="text" name="date" value="{$date}"  placeholder="Date" style="width: 100%;">
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
                    Customer Birthday
                </div>
                <div class="panel-body">
					<div class="col-lg-6">
                    	{php} customer_birthday_by_day($_SESSION['date']);{/php}
                	</div>
					<div class="col-lg-6">
                    	{php} customer_birthday($_SESSION['date']);{/php}
                	</div>
					
				</div
               
                <div class="panel-footer">
                </div>
            </div>
   </div>
{/if}

{include file="footer.tpl"}