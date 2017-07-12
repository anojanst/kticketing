{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.customer').typeahead({
                name: 'customer',
                remote : 'ajax/customer.php?query=%QUERY'
            });
        })
	</script>
{/literal}
<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>Search Insurance</strong>
				</div>
				<div class="panel-body">
					<form role="form" action="insurance.php?job=search" method="post" name="add_item">
						<div class="col-lg-5">
							<div class="form-group">
								<input class="form-control" type="text" name="insurance_no" placeholder="insurance No" />
							</div>
						</div>
						<div class="col-lg-5">
							<div class="form-group">
								<input type="text" name="customer" placeholder="Customer" class="form-control customer"/>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group">
								<button type="submit" name="search" value="Search" class="btn btn-primary">Search</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>INSURANCE LIST</strong>
				</div>
				<div class="panel-body">
                    {php}list_insurance($_SESSION['search_insurance_no'], $_SESSION['search_customer']);{/php}
				</div>
			</div>
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
{/literal}