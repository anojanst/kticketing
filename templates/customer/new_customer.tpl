{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.nationality').typeahead({
                name: 'nationality',
                remote : 'ajax/nationality.php?query=%QUERY'

            });
        })
	</script>

	<script type="text/javascript">
        $(document).ready(function() {
            $('input.search').typeahead({
                name: 'search',
                remote : 'ajax/customer.php?query=%QUERY'

            });
        })
	</script>
{/literal}
{if $error_message}
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="alert alert-danger"><strong>{$error_message}</strong></div>
			<a href="user_home.php" class="btn btn-block btn-social btn-bitbucket"><i class="fa fa-reply"></i> Back To Home Page</a>
		</div>
	</div>
{/if}
<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-green" style="margin-top: 10px;">
				<div class="panel-heading">
					Add New Customer
				</div>
				<div class="panel-body">
					<form name="add_product" action="customer.php?job=add" method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<input class="form-control" type="text" name="customer_name" value="{$customer_name}" placeholder="Customer Name"/>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<input class="form-control" type="text" name="customer_id" value="{$customer_id}" placeholder="Customer ID" readonly="readonly"/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<select class="form-control" name="salute" required>
                                        {if $sex}
											<option value="{$salute}">{$salute}</option>
                                        {else}
											<option value="" disabled selected>Salutation</option>
                                        {/if}
										<option>MR</option>
										<option>MRS</option>
										<option>MASTER</option>
										<option>MS</option>
										<option>DR</option>
										<option>REV</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input class="form-control" type="text" name="first_name" value="{$first_name}" placeholder="First Name"/>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input class="form-control" type="text" name="last_name" value="{$last_name}" placeholder="Last Name"/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-4">
								<div class="form-group">
									<select class="form-control" name="sex" required>
                                        {if $sex}
											<option value="{$sex}">{$sex}</option>
                                        {else}
											<option value="" disabled selected>Gender</option>
                                        {/if}
										<option>Male</option>
										<option>Female</option>
										<option>Transgender</option>
									</select>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group">
									<input class="form-control" id="datepicker" type="text" name="dob" value="{$dob}" placeholder="Date of Birth  (YYYY-MM-DD)">
								</div>
							</div>
							<div class="col-lg-4">
								<div class="form-group" style="width: 100%;">
									<input style="width: 100%;" class="form-control nationality" type="text" name="nationality" value="{$nationality}" placeholder="Nationality"/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<input class="form-control" type="text" name="passport_no" value="{$passport_no}" placeholder="Passport No"/>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<input type="file" name="passport" id="passport" value="{$passport}" placeholder="Passport"/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<input class="form-control" type="text" id="datepicker1" name="issued_date" value="{$issued_date}" placeholder="Issued Date (YYYY-MM-DD)">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
                                <input class="form-control" type="text" id="datepicker2" name="expire_date" value="{$expire_date}" placeholder="Expire Date  (YYYY-MM-DD)">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<input class="form-control" type="text" name="mobile" value="{$mobile}" placeholder="Mobile No"/>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<input class="form-control" type="text" name="telephone" value="{$telephone}" placeholder="Telephone No"/>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<input class="form-control" type="text" name="email" value="{$email}" placeholder="Email"/>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<textarea class="form-control" name="address" placeholder="Address" rows="1">{$address}</textarea>
								</div>
							</div>
						</div>
                        {if $edit=='on'}
							<button type="submit" name="ok" value="Update" class="btn btn-primary">Update</button>
                        {else}
							<button type="submit" name="ok" value="Save" class="btn btn-primary">Save</button>
                        {/if}
						<button type="reset" class="btn btn-primary">Reset</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-red" style="margin-top: 10px;">
				<div class="panel-heading">
					Customers
				</div>
				<div class="panel-body">
					<form name="add_product" action="customer.php?job=search" method="post">
						<div class="row">
							<div class="col-lg-10">
								<div class="form-group">
									<input class="form-control search" type="text" name="search" value="{$search}" placeholder="Search"/>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<button type="submit" name="ok" class="btn btn-primary">Search</button>
								</div>
							</div>
						</div>

					</form>
                    {if $search_mode=='on'}
                        {php}list_customer_search($_SESSION[search]);{/php}
                    {else}
                        {if $access=='yes'}
                            {php}list_customer();{/php}
                        {/if}
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
		$('#datepicker1').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true
		});
	});
</script>
<script>
	$(function () {
		$('#datepicker2').datepicker({
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