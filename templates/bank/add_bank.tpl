{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
$(function() {
	
	//autocomplete
	$(".auto").autocomplete({
		source: "ajax/bank.php",
		minLength: 1
	});				

});
</script>
{/literal}

<section class="content">
	<div class="row">
		<div class="col-lg-6" style="margin-top: 10px;">
			<div class="box box-primary">
                <div class="panel-heading">
                    Add new Bank
                </div>
                <div class="panel-body">
            
					<form role="form" action="add_bank.php?job=add" method="post">
	                    <div class="form-group">
	                        <input class="form-control" name="bank" value="{$bank}" required placeholder="Bank" autofocus="autofocus">
	                    </div>
	
						<div class="form-group">
	                        <input class="form-control" name="acc_num" value="{$acc_num}" required placeholder="Account Number">
	                    </div>

						{if $edit=='on'}
							<button type="submit" name="ok" value="Update" class="btn btn-primary">Update</button>
						{else}
							<button type="submit" name="ok" value="Save" class="btn btn-primary">Save</button>
						{/if}
	                    	<button type="reset" class="btn btn-primary">Reset</button>
                  
                   </form>
				</div>
            </div>
	    </div>
	    
		<div class="col-lg-6">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Banks
                </div>
                <div class="panel-body">
                    {php}list_banks();{/php}
                </div>
            </div>   
        </div>
   </div>
</section>
{include file="footer.tpl"}

{literal}
	<script>
        $(function () {
            $("#example1").DataTable();
        });
	</script>
{/literal}