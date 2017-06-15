{include file="header.tpl"}
{include file="navigation.tpl"}

<section class="content">
	<div class="row">
		<div class="col-lg-4" style="margin-top: 10px;">
			<div class="box box-primary">
				<div class="panel-heading">
					Add new Message
				</div>
				<div class="panel-body">
					<form role="form" action="message.php?job=add" method="post">
						<div class="form-group">
							<textarea class="form-control" rows="3" name="message" placeholder="Message">{$message}</textarea>
						</div>

						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="start_date" class="form-control" id="datepicker" value="{$start_date}"  placeholder="Start Date" style="width: 100%;">
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
							<input type="hidden" id="dtp_input1" value="" />
						</div>

						<div class="form-group" style="visibility:visible;">
							<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
								<input type="text" name="end_date" class="form-control" id="datepicker1" value="{$end_date}"  placeholder="End Date" style="width: 100%;">
								<span class="add-on"><i class="icon-remove"></i></span>
								<span class="add-on"><i class="icon-th"></i></span>
							</div>
							<input type="hidden" id="dtp_input1" value="" />
						</div>
						<button type="submit" name="ok" value="Save" class="btn btn-default">Save</button>
					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<div class="panel panel-red" style="margin-top: 10px;">
				<div class="panel-heading">
					Message
				</div>
				<div class="panel-body">
                    {php}list_message();{/php}
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