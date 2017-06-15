{include file="header.tpl"}
{include file="navigation.tpl"}
<section class="content">
	<div class="row">
		<div class="box box-primary" style="margin-top: 10px;">
			<div class="panel-heading">
				Quick Link
			</div>
			<div class="panel-body">

				<form role="form" action="quick_links.php?job=add" method="post" enctype="multipart/form-data">
					<div class="col-lg-3">
						<div class="form-group">
							<input class="form-control" name="name" value="{$name}" required placeholder="name">
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<input class="form-control" name="link" value="{$link}" required placeholder="link">
						</div>
					</div>
					<div class="col-lg-3">
						<div class="form-group">
							<input  type="file" name="logo" value="{$logo}" required placeholder="logo">
						</div>
					</div>

					<div class="col-lg-2">
                        {if $edit=='on'}
							<button type="submit" name="ok" value="Update" class="btn btn-primary">Update</button>
                        {else}
							<button type="submit" name="ok" value="Save" class="btn btn-primary">Save</button>
                        {/if}
					</div>
				</form>

			</div>
		</div>
	</div>
	<div class="col-lg-10">
		<div class="panel panel-red" style="margin-top: 10px;">
			<div class="panel-heading">
				Quick Links
			</div>
			<div class="panel-body">
                {php}list_quick_links();{/php}
			</div>
			<div class="panel-footer">
			</div>
		</div>
	</div>
	</div>
</section>
{include file="footer.tpl"}