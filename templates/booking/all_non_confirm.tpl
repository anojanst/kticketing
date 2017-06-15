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
<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-green" style="margin-top: 10px;">
				<div class="panel-heading">
					Search All Non Confirm Bookings
				</div>
				<div class="panel-body">
					<form role="form" action="all_non_confirm_booking.php?job=search" method="post" name="add_item">
						<div class="col-lg-2">
							<div class="form-group">
								<select class="form-control" name="branch">
                                    {if $branch}
										<option value="{$branch}">{$branch}</option>
                                    {else}
										<option value="" disabled selected>Select A Branch</option>
                                    {/if}
                                    {section name=branch loop=$branches}
										<option value="{$branches[branch]}">{$branches[branch]}</option>
                                    {/section}
								</select>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<input type="text" name="user_name" placeholder="Users" class="form-control user_name"/>
							</div>
						</div>
						<div class="col-lg-3">
							<div class="form-group" style="visibility:visible;">
								<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
									<input type="text" name="from_date" class="form-control" id="datepicker" readonly placeholder="From Date" style="width: 100%;">
									<span class="add-on"><i class="icon-remove"></i></span>
									<span class="add-on"><i class="icon-th"></i></span>
								</div>
								<input type="hidden" id="dtp_input1" value="" />
							</div>
						</div>
						<div class="col-lg-3">
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
								<button type="submit" name="search" value="Search" class="btn btn-primary">Search</button>
							</div>
						</div>
					</form>
					<a href="all_non_confirm_booking.php?job=all_non_confirm_print"  class="btn btn-primary" target="blank">Print</a>

				</div>
			</div>
		</div>
	</div>
    {php}list_all_non_confirm($_SESSION['search_branch'], $_SESSION['search_user_name'], $_SESSION['from_date'], $_SESSION['to_date']);{/php}
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


{/literal}