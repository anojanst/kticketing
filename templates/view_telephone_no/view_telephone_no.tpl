{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.cusromer').typeahead({
                name: 'cusromer',
                remote : 'ajax/customer_telephone.php?query=%QUERY'

            });
        })
	</script>

	<script type="text/javascript">
        $(document).ready(function() {
            $('input.telephone').typeahead({
                name: 'telephone',
                remote : 'ajax/telephone_no.php?query=%QUERY'

            });
        })
	</script>
{/literal}
<section class="content">
	<div class="row">
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Search salary</strong>
			</div>
			<div class="panel-body">

				<form role="form" action="view_telephone_no.php?job=search" method="post">
					<div class="col-lg-3">
						<div class="form-group">
							<input class="form-control cusromer" name="customer_name" value="{$customer_name}" placeholder="Name">
						</div>
					</div>

					<div class="col-lg-3">
						<div class="form-group">
							<input class="form-control telephone" name="telephone_no" value="{$telephone_no}" placeholder="TelephoneNo">
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="from_date" class="form-control" id="datepicker" value="{$from_date}"  placeholder="From Date" style="width: 100%;">
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
							<input type="hidden" id="dtp_input1" value="" />
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="to_date" class="form-control" id="datepicker1" value="{$to_date}"  placeholder="To Date" style="width: 100%;">
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
							<input type="hidden" id="dtp_input1" value="" />
						</div>
					</div>
					<div class="col-lg-2">
						<button type="submit" name="ok" value="Search" class="btn btn-primary">Search </button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>Users</strong>
				</div>
				<div class="panel-body">
                    {php}search_telephone_no($_SESSION['customer_name'], $_SESSION['telephone_no'], $_SESSION['from_date'],$_SESSION['to_date']);{/php}

				</div>
				<div class="panel-footer">
				</div>
			</div>
		</div>
	</div>
</section>
{include file="footer.tpl"}
{literal}
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

            $('#datepicker').datepicker({
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