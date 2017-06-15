{include file="header.tpl"}
{include file="navigation.tpl"}

{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.name').typeahead({
                name: 'name',
                remote : 'ajax/cab.php?query=%QUERY'

            });
        })
	</script>

	<script type="text/javascript">
        $(document).ready(function() {
            $('input.cab_no').typeahead({
                name: 'cab_no',
                remote : 'ajax/cab_no.php?query=%QUERY'

            });
        })
	</script>
{/literal}

<section class="content">
	<div class="row">
		<div class="box box-primary" style="margin-top: 10px;">
			<div class="panel-heading">
				Search Outstanding Invoice
			</div>
			<div class="panel-body">
				<form role="form" action="log_book.php?job=search" method="post">
					<div class="col-lg-1">
						<div class="form-group">
							<input class="form-control cab_no" type="text" name="cab_booking_no" value="{$cab_booking_no}"/>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<input class="form-control name" type="text" name="name" value="{$name}"/>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="from_date" class="form-control" id="datepicker" value="{$from_date}"  placeholder="From Date" style="width: 100%;">
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
							<input type="hidden" id="dtp_input1" value="" />
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="to_date" value="{$to_date}" class="form-control" id="datepicker1"  placeholder="To Date" style="width: 100%;">
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
    {php}list_Cab($_SESSION['cab_booking_no'],$_SESSION['name'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
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