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
	<div class="row">
		<div class="col-lg-5" style="margin-top: 10px;">
			<div class="panel panel-info">
				<div class="panel-heading">
					<strong>Add new user</strong>
				</div>
				<div class="panel-body">

					<form role="form" action="users.php?job=add" method="post" enctype="multipart/form-data">
						<div class="form-group">
							<input class="form-control" name="name" value="{$name}" required placeholder="Name">
						</div>

						<div class="form-group">
							<input class="form-control" name="full_name" value="{$full_name}" required placeholder="Full Name">
						</div>
						<!--
	                    <div class="form-group">
	                        <input class="form-control"  name="department" value="{$department}" required placeholder="Department">
	                    </div>
	                  -->
						<div class="form-group">
							<input class="form-control" name="email" value="{$email}" required placeholder="E-mail">
						</div>

						<div class="form-group">
							<input class="form-control" name="mobile" value="{$mobile}" required placeholder="Mobile">
						</div>

						<div class="form-group">
							<textarea class="form-control" rows="3" name="address" placeholder="Address">{$address}</textarea>
						</div>

						<!--
						 <div class="form-group">
									Profile Pictures
		                 </div>
		                  <div class="form-group">
									<input class="form-control" type="file" name="profile_pictures" id="profile_pictures" value="{$profile_pictures}" placeholder="Profile Pictures"/>
		                   </div>
	                 -->

						<div class="form-group">
							<label>Add username and password if this employee will use the system.</label>
							<input class="form-control" name="user_name" value="{$user_name}" placeholder="User Name">
						</div>

						<div class="form-group">
							<input type="password" class="form-control" name="password" value="{$password}" placeholder="Password">
						</div>


						<!--
						<div class="form-group">
		                    	<select class="form-control" name="branch" required>
		                    		{if $branch}
										<option value="{$branch}">{$branch}</option>
									{else}
										<option value="" disabled selected>Branch</option>
									{/if}
										<option value="Head Office">Head Office</option>
									<option value="Jaffna">Jaffna</option>
										<option value="Vavuniya">Vavuniya</option>
										<option value="Colombo 15">Colombo 15</option>
								</select>
		                    </div>
					-->

                        {if $edit=='on'}
							<button type="submit" name="ok" value="Update" class="btn btn-default">Update</button>
                        {else}
							<button type="submit" name="ok" value="Save" class="btn btn-default">Save</button>
                        {/if}
						<button type="reset" class="btn btn-default">Reset</button>

					</form>
				</div>
			</div>
		</div>

		<div class="col-lg-7">
			<div class="panel panel-info" style="margin-top: 10px;">
				<div class="panel-heading">
					<strong>Users</strong>
				</div>
				<div class="panel-body">
					<!--
                    {php}list_users();{/php}
					-->
                    {php}list_users_full_for_user_add();{/php}
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