{include file="header.tpl"}
{include file="navigation.tpl"}

{literal}
<script type="text/javascript">
$(document).ready(function() {
$('input.pnr').typeahead({
  name: 'pnr',
  remote : 'ajax/pnr.php?query=%QUERY'

});
})
</script>

{/literal}

<div class="row">
	<div class="panel panel-primary" style="margin-top: 10px;">
		<div class="panel-heading">
                   PNR
                </div>
        <div class="panel-body">
            <form role="form" action="pnr.php?job=search" method="post">
					<div class="col-lg-3">
						<div class="form-group">
								<input class="form-control pnr" type="text" name="pnr" value="{$pnr}"/>
						</div> 
					</div>
				<div class="col-lg-2">
					<button type="submit" name="ok" value="Search" class="btn btn-primary">Search</button>
				</div>
	      </form>
 		<a href="pnr.php?job=pnr_print"  class="btn btn-primary" target="blank">Print</a>
      </div>           
	</div>
</div>

{if $search=="on"}
<div class="row">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
              PNR
                </div>
                <div class="panel-body">
                    {php}search_pnr_report($_SESSION['pnr']);{/php}
               </div>
                <div class="panel-footer">
                </div>
            </div>
   </div>
{/if}


{include file="footer.tpl"}