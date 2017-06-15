{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
$(document).ready(function() {
$('input.customer').typeahead({
  name: 'customer',
  remote : 'ajax/customer.php?query=%QUERY'

});
})
</script>
{/literal}
<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-green">
                <div class="panel-heading">
                    Choose Customer
                </div>
                <div class="panel-body">
                    <form role="form" action="paybill.php?job=search" method="post" name="add_item">
						<div class="col-lg-2">
							<div class="form-group">
            					<input class="form-control" type="text" name="paybill_no" placeholder="Paybill No" />
		            		</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
            					<input type="text" name="customer" placeholder="Customer" class="form-control customer"/>
		            		</div>
						</div>
						<div class="col-lg-2">
		                    <div class="form-group" style="visibility:visible;">
    							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        							<input type="text" name="from_date" class="form-control" id="datepicker" readonly placeholder="From Date" style="width: 100%;">
        							<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
    							</div>
								<input type="hidden" id="dtp_input1" value="" />
		                    </div>
		                </div>
						<div class="col-lg-2">
		                    <div class="form-group" id="returnDate" style="visibility:visible;">
    							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        							<input type="text" name="to_date" class="form-control" id="datepicker1" readonly placeholder="To Date" style="width: 100%;">
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
					<a href="paybill.php?job=paybill_print"  class="btn btn-primary" target="blank">Print</a>
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
            		{php}search_paybill($_SESSION['search_paybill_no'], $_SESSION['search_customer'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
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
<script>
	$(function () {
		$('#datepicker1').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true
		});
	});
</script>
<script>
	$(function () {
		$("#example1").DataTable();
	});
</script>
{/literal}