{include file="header.tpl"}
{include file="navigation.tpl"}

<div class="content-wrapper">
	<div class="nav-tabs-custom">
  		<div class="tab-content">


	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-info">
                <div class="panel-heading">
                    <strong>Add or Remove Permissions | User Name : </strong>{$full_name}
                </div>
                <div class="panel-body">
            		<div class="col-lg-6">
						<div class="panel panel-success">
			                <div class="panel-heading">
			                    <strong>Permissions User already have</strong>
			                </div>
			                <div class="panel-body">
			            		{php}list_user_module($_SESSION['id']);{/php}					
							</div>
			            </div>
				    </div>
				    <div class="col-lg-6">
						<div class="panel panel-danger">
			                <div class="panel-heading">
			                    <strong>Permissions User Dont have</strong>
			                </div>
			                <div class="panel-body">
			            		{php}list_not_user_module($_SESSION['id']);{/php}			
							</div>
			            </div>
				    </div>
					
				</div>
            </div>
	    </div>
   </div>
   	

		</div>
	</div>
</div>
{include file="footer.tpl"}