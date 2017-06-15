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

	<script type="text/javascript">
        $(document).ready(function() {
            $('input.description').typeahead({
                name: 'description',
                remote : 'ajax/salary_description.php?query=%QUERY'

            });
        })
	</script>
{/literal}
<section class="content">
	<div class="content-wrapper">
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<div class="row">
					<div class="col-lg-9" style="margin-top: 10px;">
						<div class="box box-primary" style="margin-top: 10px;">

							<div class="col-lg-12">
								<h2><strong>Add Description </strong></h2>
							</div>

							<div class="panel-body">

								<div class="row" style="text-align: center;">
									<form action="staff_salary.php?job=add_description" method="post">
										<div class="col-lg-3" style="text-align: left;">
											<div class="form-group">
												<strong>Description</strong>
												<input type="text" name="description" class="form-control description" required="required"/>
											</div>
										</div>
										<div class="col-lg-5" style="text-align: left;">
											<div class="form-group">
												<strong>Detail</strong>
												<input type="text" name="detail" class="form-control"/>
											</div>
										</div>
										<div class="col-lg-2" style="text-align: left;">
											<div class="form-group">
												<strong>Amount</strong>
												<input type="text" name="amount" class="form-control" req/>
											</div>
										</div>
										<div class="col-lg-2" style="text-align: left;">
											<div class="form-group" style="margin-top: 20px;">

												<button type="submit" name="ok" class="btn btn-danger">Add</button>
											</div>
										</div>
									</form>
								</div>
								<div class="row">
									<div class="col-lg-12" style="margin-top: 10px;">
                                        {php}list_salary_details($_SESSION['salary_no']);{/php}
										<div class="col-lg-3 alert-danger"> &nbsp;</div>
										<div class="col-lg-3 alert-danger"> &nbsp;</div>
										<div class="col-lg-2 alert-danger">Total</div>
										<div class="col-lg-2 alert-danger"><strong>{$total}</strong></div>
										<div class="col-lg-2 alert-danger"> &nbsp;</div>
									</div>
								</div>
							</div>
						</div>
					</div>

                    {if $submit=="true"}
					<hr></hr>

					<div class="col-lg-3 ">

						<div class="col-lg-12">
							<div class="box box-primary">

								<form name="salary_form" action="staff_salary.php?job=save" method="post">
									<div class="row">
										<div class="col-lg-12">
											<div class="row">
												<div class="col-lg-12">
													<div class="form-group">
														<input class="form-control" type="text" name="salary_no" value="{$salary_no}" required="required" />
													</div>
												</div>

												<div class="col-lg-12">
													<div class="form-group">
														<input class="form-control staff_name" type="text" name="staff_name" value="{$staff_name}" required="required" />
													</div>
												</div>

												<div class="col-lg-12">
													<div class="form-group">
														<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
															<input type="text" name="salary_date" class="form-control" id="datepicker" value="{$salary_date}" placeholder="salary Date" required="required" style="width: 100%;">
															<span class="add-on"><i class="icon-remove"></i></span>
															<span class="add-on"><i class="icon-th"></i></span>
														</div>
														<input type="hidden" id="dtp_input1" value="" />
													</div>
												</div>
												<div class="col-lg-12">
													<div class="form-group">
														<input class="form-control" type="text" name="saved_by" value="{$saved_by}" readonly="readonly"/>
													</div>
												</div>
												<div class="row" align="center">

													<button type="submit" name="ok" value="Save" class="btn btn-danger">Save</button>

												</div>
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