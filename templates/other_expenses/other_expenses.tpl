{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.booking_no').typeahead({
                name: 'booking_no',
                remote : 'ajax/booking_no_confirm.php?query=%QUERY'

            });
        })
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.customer').typeahead({
                name: 'customer',
                remote : 'ajax/customer_id_and_name.php?query=%QUERY'

            });
        })
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.description').typeahead({
                name: 'description',
                remote : 'ajax/description_other_expenses.php?query=%QUERY'

            });
        })
	</script>
	<script type="text/javascript">
        function findTotal(){
            var s = document.getElementById("fare").value,
                t = document.getElementById("bol_amount").value,
                u = document.getElementById("taxes").value,
                radio1 = document.getElementById("btt");
            if (radio1.checked) {
                var sub_total = +s + +t;
            }
            else{
                var sub_total = +s - +t;
            }
            var total = +sub_total + +u;
            document.getElementById("sub_tot").value=sub_total;
            document.getElementById("total").value=total;
        }
	</script>
{/literal}
<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Choose Customer</strong>
				</div>
				<div class="panel-body">

					<div class="row" style="text-align: center;">
						<div class="col-lg-3" style="margin-top: 10px;">
							<div class="form-group">
								<strong>Description</strong>
							</div>
						</div>
						<div class="col-lg-5" style="margin-top: 10px;">
							<div class="form-group">
								<strong>Detail</strong>
							</div>
						</div>
						<div class="col-lg-2" style="margin-top: 10px;">
							<div class="form-group">
								<strong>Amount</strong>
							</div>
						</div>
						<div class="col-lg-2" style="margin-top: 10px;">
							<div class="form-group">
								<strong>Add/Remove</strong>
							</div>
						</div>
					</div>
					<div class="row" style="text-align: center;">
						<form action="other_expenses.php?job=add_other_expenses_description" method="post">
							<div class="col-lg-3" style="text-align: left;">
								<div class="form-group">
									<input type="text" name="description" class="form-control description" required="required"/>
								</div>
							</div>
							<div class="col-lg-5">
								<div class="form-group">
									<input type="text" name="detail" class="form-control"/>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<input type="text" name="amount" class="form-control" req/>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<button type="submit" name="ok" class="btn btn-primary">Add</button>
								</div>
							</div>
						</form>
					</div>
					<div class="row">
						<div class="col-lg-12" style="margin-top: 10px;">
                            {php}list_description_by_other_expenses($_SESSION['other_expenses_no']);{/php}
							<div class="col-lg-3 alert-danger"> &nbsp;</div>
							<div class="col-lg-3 alert-danger"> &nbsp;</div>
							<div class="col-lg-2 alert-danger">Total</div>
							<div class="col-lg-2 alert-danger"><strong>{$total}</strong></div>
							<div class="col-lg-2 alert-danger"> &nbsp;</div>
						</div>
					</div>
                    {if $submit=='true'}
					<hr></hr>
					<div class="row" style="margin-top: 20px;">
						<div class="col-lg-12">
							<form name="other_expenses_form" action="other_expenses.php?job=save" method="post">
								<div class="row">
									<div class="col-lg-12">
										<div class="row">
											<div class="col-lg-3">
												<div class="form-group">
													<input class="form-control" type="text" name="other_expenses_no" value="{$other_expenses_no}" required="required" readonly="readonly"/>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<input class="form-control" type="text" name="ref_no" value="{$ref_no}" required="required" placeholder="Ref No"/>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<select class="form-control" name="ref_type" required>
                                                        {if $ref_type}
															<option value="{$ref_type}">{$ref_type}</option>
                                                        {else}
															<option value="" disabled selected>Type</option>
                                                        {/if}
														<option value="Booking">Booking</option>
														<option value="Itinerary">Itinerary</option>
														<option value="Insurance">Insurance</option>
														<option value="VISA">VISA</option>
														<option value="Cab">Cab</option>
														<option value="Cargo">Cargo</option>
														<option value="Office Expenses">Office Expenses</option>
														<option value="Salary">Salary</option>
													</select>
												</div>
											</div>
											<div class="col-lg-3">
												<div class="form-group">
													<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
														<input type="text" name="other_expenses_date" class="form-control" id="datepicker" value="{$other_expenses_date}" placeholder="other_expenses Date" required="required" style="width: 100%;">
														<span class="add-on"><i class="icon-remove"></i></span>
														<span class="add-on"><i class="icon-th"></i></span>
													</div>
													<input type="hidden" id="dtp_input1" value="" />
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<input class="form-control customer" type="text" name="customer" value="{$customer}" required="required" placeholder="customer"/>
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<input class="form-control" type="text" name="remarks" value="{$remarks}" placeholder="Remarks"/>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6">
												{if $edit=='true'}
													<button type="submit" name="ok" value="Update" class="btn btn-primary">Update</button>
												{else}
													<button type="submit" name="ok" value="Save" class="btn btn-primary">Save</button>
												{/if}
											</div>
										</div>
									</div>
							</form>
						</div>
                        {/if}
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