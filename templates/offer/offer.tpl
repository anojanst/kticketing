{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto").autocomplete({
		source: "ajax/query_offer.php",
		minLength: 1
	});				

});
</script>
{/literal}

	<div class="row">
		<div class="col-lg-6" style="margin-top: 10px;">
			<div class="panel panel-info">
                <div class="panel-heading">
                    Add new Offer
                </div>
                <div class="panel-body">
            
					<form role="form" action="offer.php?job=add" method="post">
	
						<div class="form-group">
	                        <input class="form-control" name="offer_code" value="{$offer_code}" required placeholder="Offer Code">
	                    </div>
						<div class="form-group">
	                        <input class="form-control"  name="off" value="{$off}" required placeholder="Off">
	                    </div>
	                    <div class="form-group">
	                    	<select class="form-control" name="type" required>
								{if $off}
									<option value="{$type}">{$type}</option>
								{else}
									<option value="" disabled selected>Type</option>
								{/if}
								<option value="Single">Single</option>
								<option value="Group">Group</option>
							</select>
						</div>
						
						<div class="form-group" style="visibility:visible;">
    							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        							<input type="text" name="exp_date" value="{$exp_date}" readonly placeholder="Expire Date" style="width: 100%;">
        							<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
    							</div>
								<input type="hidden" id="dtp_input1" value="" />
		                    </div>
						{if $edit=='on'}
							<button type="submit" name="ok" value="Update" class="btn btn-default">Update</button>
						{else}
							<button type="submit" name="ok" value="Save" class="btn btn-default">Save</button>
						{/if}
	                    	<button type="reset" class="btn btn-default">Reset</button>                  
                  
                   </form>
				</div>
            </div>
	    </div>
	    
		<div class="col-lg-6">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Offers
                </div>
                <div class="panel-body">
                    {php}list_offer();{/php}
                </div>
                <div class="panel-footer">
                </div>
            </div>   
        </div>
   </div>
{include file="footer.tpl"}