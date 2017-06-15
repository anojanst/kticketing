{include file="header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-green" style="margin-top: 10px;">
				<div class="panel-heading">
					Add Telephone Directory
				</div>
				<div class="panel-body">
					<form name="add_product" action="telephone_directory.php?job=add" method="post" enctype="multipart/form-data">

						<div class="col-lg-3">
							<div class="form-group" style="width: 100%;">
								<input style="width: 100%;" class="form-control" type="text" name="customer_name" value="{$customer_name}" placeholder=customername"/>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group" style="width: 100%;">
								<input style="width: 100%;" class="form-control" type="text" name="telephone_no" value="{$telephone_no}" placeholder="telephone no"/>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="form-group" style="width: 100%;">
								<input style="width: 100%;" class="form-control" type="text" name="details" value="{$details}" placeholder="details"/>
							</div>
						</div>
						<div class="col-lg-2">
							<button type="submit" name="ok" value="add" class="btn btn-default">add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
{include file="footer.tpl"}