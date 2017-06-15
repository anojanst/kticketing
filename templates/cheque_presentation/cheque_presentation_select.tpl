{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
</script>
<script type="text/javascript">
$(document).ready(function() {
$('input.account').typeahead({
  name: 'account',
  remote : 'ajax/bank.php?query=%QUERY'

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
			<div class="box box-primary">
                <div class="panel-heading">
                    Select bank and Presentation date
                </div>
                <div class="panel-body">
					<form name="cheque_presentation_select_form" action="cheque_presentation.php?job=set_date" method="post">
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<input class="account form-control" type="text" name="account" value="{$account}" required="required" placeholder="Bank"/>
								</div>                 
                    		</div>
							<div class="col-lg-3">
								<div class="form-group">
									<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
        								<input type="text" name="presentation_date" class="form-control" id="datepicker" value="{$presentation_date}" required placeholder="Presentation Date" style="width: 100%;">
        								<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
    								</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>                
                    		</div>
							<div class="col-lg-3">
								<div class="form-group">
									<button type="submit" name="ok" class="btn btn-primary">Go</button>
								</div>                 
                    		</div>				
						</div>                 
                   </form>
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
		$("#example1").DataTable();
	});
</script>
{/literal}