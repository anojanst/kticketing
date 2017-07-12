{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.country').typeahead({
                name: 'country',
                remote : 'ajax/country.php?query=%QUERY'

            });
        })
	</script>

	<script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script> <script type="text/javascript">
    //<![CDATA[
    bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
    //]]>
</script>

{/literal}
<section class="content">
	<div class="row">
		<div class="col-lg-6" style="margin-top: 10px;">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Add new country</strong>
				</div>
				<div class="panel-body">

					<form role="form" action="embassy.php?job=add" method="post">
						<div class="form-group">
							<input class="form-control" name="embassy" value="{$embassy}" required placeholder="Embassy" autofocus="autofocus">
						</div>
						<div class="form-group">
							<input class="form-control country" name="country" value="{$country}" required placeholder="Country" autofocus="autofocus">
						</div>
						<div class="form-group">
							<strong>Address</strong>
						</div>
						<div class="form-group">
							<textarea class="form-control" name="address" rows="5">{$address}</textarea>
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

		<div class="col-lg-6">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>Embassies</strong>
				</div>
				<div class="panel-body">
                    {php}list_embassy();{/php}
				</div>
				<div class="panel-footer">
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