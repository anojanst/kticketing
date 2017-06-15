{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(function() {

            //autocomplete
            $(".auto").autocomplete({
                source: "ajax/query_employees.php",
                minLength: 1
            });

        });
	</script>
{/literal}
<section class="content">
	<div class="content-wrapper">
		<div class="nav-tabs-custom">
			<div class="tab-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-red" style="margin-top: 10px;">
							<div class="panel-heading">
								Users
							</div>
							<div class="panel-body">
                                {php}list_users_full();{/php}
							</div>
							<div class="panel-footer">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
{include file="footer.tpl"}