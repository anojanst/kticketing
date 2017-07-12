{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.staff_name').typeahead({
                name: 'staff_name',
                remote : 'ajax/user_name.php?query=%QUERY'

            });
        })
	</script>
{/literal}

<section class="content">
	<div class="row">
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Search TarGet Report</strong>
			</div>
			<div class="panel-body">

				<form role="form" action="staff_target.php?job=search" method="post">
					<div class="col-lg-3">
						<div class="form-group">
							<input class="form-control staff_name" type="text" name="staff_name" value="{$staff_name}" placeholder="Name"/>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="date" class="form-control" id="datepicker" value="{$date}" placeholder="Date" required="required" style="width: 100%;">
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
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>STAFF TARGET REPORT</strong>
				</div>
				<div class="panel-body">
					<div class="col-lg-6">
                        {php} staff_target($_SESSION['staff_name'], $_SESSION['date']);{/php}
					</div>
					<div class="col-lg-6">
                        {php} staff_target_day_by_day($_SESSION['staff_name'], $_SESSION['date']);{/php}
					</div>
				</div
				<div class="panel-footer">
				</div>
			</div>
		</div>
    {/if}
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
	        $("#example1").DataTable();
	    });
	</script>


{/literal}