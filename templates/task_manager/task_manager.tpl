{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.task').typeahead({
                name: 'task',
                remote : 'ajax/task.php?query=%QUERY'

            });
        })
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.task_no').typeahead({
                name: 'task_no',
                remote : 'ajax/task_no.php?query=%QUERY'

            });
        })
	</script>

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
	<div class="row">
		<div class="box box-primary" style="margin-top: 10px;">
			<div class="panel-heading">
				Task Manager
			</div>
			<div class="panel-body">

				<form role="form" action="task_manager.php?job=search" method="post">
					<div class="col-lg-3">
						<div class="form-group">
							<input class="form-control task" name="task_name" value="{$task_name}"  placeholder="Task">
						</div>
					</div>

					<div class="col-lg-2">
						<div class="form-group">
							<input class="form-control user" name="search_user_name" value="{$search_user_name}"  placeholder="Name">
						</div>
					</div>
					<div class="col-lg-2">
						<div class="form-group">
							<input class="form-control task_no" name="ref_no" value="{$ref_no}"  placeholder="Ref No">
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
					<div class="col-lg-1">
						<button type="submit" name="ok" value="Search" class="btn btn-primary">Search</button>
					</div>
				</form>
			</div>
		</div>
	</div>
    {if $search=="on"}
		<div class="row">
			<div class="box box-primary" style="margin-top: 10px;">
				<div class="panel-heading">
					Users
				</div>
				<div class="row">
					<div class="col-lg-12">
                    	{php}task_history($_SESSION['task_name'],$_SESSION['search_user_name'],$_SESSION['ref_no'],$_SESSION['from_date'],$_SESSION['to_date']);{/php}
					</div>
				</div>

				<div class="panel-footer">
				</div>
			</div>
		</div>
    {/if}
    {if $error_report=="on"}
		<div class="row">
			<div class="col-lg-12" style="margin-top: 10px;">
				<div class="alert alert-danger"><strong>{$error_message}</strong></div>
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