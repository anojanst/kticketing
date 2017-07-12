{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.user_name').typeahead({
                name: 'user_name',
                remote : 'ajax/user_name.php?query=%QUERY'

            });
        })
	</script>
{/literal}
{if $error_message}
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="alert alert-danger"><strong>{$error_message}</strong></div>

		</div>
	</div>
{/if}
<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Choose Customer</strong>
				</div>
				<div class="panel-body">
					<form name="search_form" action="ip.php?job=search" method="post"  >
						<div class="col-lg-3">
							<div class="form-group">
								<input type="text" name="user_name" placeholder="User Name" class="form-control user_name"/>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group" style="visibility:visible;">
								<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
									<input type="text" name="from_date" id="datepicker" class="form-control" readonly placeholder="From Date" style="width: 100%;">
									<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
								</div>
								<input type="hidden" id="dtp_input1" value="" />
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group" id="returnDate" style="visibility:visible;">
								<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
									<input type="text" name="to_date" id="datepicker1" class="form-control" readonly placeholder="To Date" style="width: 100%;">
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
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Search Result</strong>
				</div>
				<div class="panel-body">
                    {php}list_ip($_SESSION['search_user_name'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
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