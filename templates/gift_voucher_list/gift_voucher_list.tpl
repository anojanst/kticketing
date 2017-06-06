{include file="header.tpl"}
{include file="navigation.tpl"}


	<div class="col-lg-12">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Student List
                </div>
                <div class="panel-body">
                    {php}list_customer_gift_voucher_list();{/php}
                </div>
            </div>   
        </div>


 <div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Customers
                </div>
                <div class="panel-body">
					<form name="add_product" action="customer.php?job=search" method="post">
						<div class="row">
							<div class="col-lg-10">
		                    	<div class="form-group">
									<input class="form-control search" type="text" name="search" value="{$search}" placeholder="Search"/> 
								</div>
		                	</div>
							<div class="col-lg-2">
		                    	<div class="form-group">
									<button type="submit" name="ok" class="btn btn-default">Search</button>
		                   	 	</div>
		                	</div>
	                	</div>
					
					</form>
            		{if $search_mode=='on'}
						{php}list_customer_search($_SESSION[search]);{/php}
					{else}
						{if $access=='yes'}
							{php}list_customer();{/php}
						{/if}
					{/if}
					
				</div>
            </div>
	    </div>
   </div>

{include file="footer.tpl"}	