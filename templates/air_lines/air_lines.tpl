{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto").autocomplete({
		source: "ajax/query_air_lines.php",
		minLength: 1
	});				

});
</script>



{/literal}

	<div class="row">
		<div class="col-lg-6" style="margin-top: 10px;">
			<div class="panel panel-info">
                <div class="panel-heading">
                    Add new Air Line
                </div>
                <div class="panel-body">
            
					<form role="form" action="air_lines.php?job=add" method="post">
	                    <div class="form-group">
	                        <input class="form-control" name="air_line" value="{$air_line}" required placeholder="Air Line" autofocus="autofocus">
	                    </div>
	
						<div class="form-group">
	                        <input class="form-control" name="air_line_code" value="{$air_line_code}" required placeholder="Air Line Code">
	                    </div>
	                    <div class="form-group">
	                    	<select class="form-control" name="off" required>
								{if $off}
									<option value="{$off}">{$off}</option>
								{else}
									<option value="" disabled selected>Off Or Addition</option>
								{/if}
								<option value="Off">Off</option>
								<option value="Add">Add</option>
							</select>
						</div>
						<div class="form-group">
	                        <input class="form-control"  name="percent" value="{$percent}" required placeholder="Off">
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
                    Air Lines
                </div>
                <div class="panel-body">
                    {php}list_air_lines();{/php}
                </div>
                <div class="panel-footer">
                </div>
            </div>   
        </div>
   </div>
{include file="footer.tpl"}