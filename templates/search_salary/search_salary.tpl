{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.user').typeahead({
                name: 'user',
                remote : 'ajax/user_name.php?query=%QUERY'

            });
        })
	</script>
{/literal}
<section class="content">
	<div class="content-wrapper">
		<div class="panel panel-info" style="margin-top: 10px;">
			<div class="panel-heading">
				<strong>Search salary</strong>
			</div>

			<div class="row" style="margin-top: 10px;">
				<div class="col-lg-12">
					<form role="form" action="search_salary.php?job=search" method="post">
						<div class="col-lg-4">
							<div class="form-group">
								<input class="form-control user" name="staff_name_search" value="{$staff_name_search}" required placeholder="Name">
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
									<input type="text" name="to_date" value="{$to_date}" class="form-control" id="datepicker1"  placeholder="To Date" style="width: 100%;">
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
					<div class="col-lg-12">
						<div class="panel panel-red" style="margin-top: 10px;">
							<div class="panel-heading">
								Users
							</div>
							<div class="panel-body">
                                {php}search_salary_history($_SESSION['staff_name_search'],$_SESSION['from_date'],$_SESSION['to_date']);{/php}
							</div>
							<div class="panel-footer">
							</div>
						</div>
					</div>
				</div>
            {/if}
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
