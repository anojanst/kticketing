{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
$(document).ready(function() {
$('input.branch').typeahead({
  name: 'branch',
  remote : 'ajax/branch_name.php?query=%QUERY'

});
})
</script>
{/literal}


<div class="content-wrapper">
	<div class="nav-tabs-custom">
  		<div class="tab-content">

<div class="row">
<div class="col-lg-12">
	

				<div class="col-lg-12">
                	<h2><strong>Search branch salary</strong></h2>
               	</div>

                <div class="panel-body">
            
            <form role="form" action="branch_salary.php?job=search" method="post">
	             <div class="col-lg-4">
	                    <div class="form-group">
	                        <input class="form-control branch" name="branch_name_search" value="{$branch_name_search}" required placeholder="branch">
	                    </div>
				</div>
	              <div class="col-lg-2">
	            		<div class="form-group" style="visibility:visible;">
    							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        							<input type="text" name="from_date" value="{$from_date}"  placeholder="From Date" style="width: 100%;">
        							<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
    							</div>
								<input type="hidden" id="dtp_input1" value="" />
		                    </div>
				 </div>
				 <div class="col-lg-2">
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
					<button type="submit" name="ok" value="Search" class="btn btn-primary">Search History</button>
				</div>
	      </form>
         </div>           
	
</div>
{if $search=="on"}
<div class="row">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Users
                </div>
                <div class="panel-body">
                    {php}search_branch_salary_history($_SESSION['branch_name_search'],$_SESSION['from_date'],$_SESSION['to_date']);{/php}
                </div>
                <div class="panel-footer">
                </div>
            </div>
   </div>
{/if}

{if $error_report=="on"}
<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="alert alert-danger"><strong>{$error_message}</strong></div>
	    </div>
   </div>
{/if}

</div>

		</div>
	</div>
</div>

{include file="footer.tpl"}