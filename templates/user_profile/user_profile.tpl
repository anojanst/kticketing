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

	<div class="row">
		<div class="col-lg-9" style="margin-top: 10px;">
			<div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    Add new user
                </div>
                <div class="panel-body">
            
					<form role="form" action="user_profile.php?job=add" method="post"  enctype="multipart/form-data">
	                    <div class="form-group">
	                        <input class="form-control" name="name" value="{$name}" required placeholder="Name">
	                    </div>
	
						<div class="form-group">
	                        <input class="form-control" name="full_name" value="{$full_name}" required placeholder="Full Name">
	                    </div>
	                    
	                    <div class="form-group">
	                        <input class="form-control"  name="department" value="{$department}" required placeholder="Department">
	                    </div>
	                    
	                    <div class="form-group">
	                        <input class="form-control" name="email" value="{$email}" required placeholder="E-mail">
	                    </div>
	                    
	                    <div class="form-group">
	                        <input class="form-control" name="mobile" value="{$mobile}" required placeholder="Mobile">
	                    </div>
	                    
	                    <div class="form-group">
	                        <textarea class="form-control" rows="3" name="address" placeholder="Address">{$address}</textarea>
	                    </div>
		                <div class="form-group">
									Profile Pictures
		                 </div>
		                  <div class="form-group">
									<input class="form-control" type="file" name="profile_pictures" id="profile_pictures" value="{$profile_pictures}" placeholder="Profile Pictures"/>
		                   </div>
	                    
	                    <div class="form-group">
	                    	<label>Add username and password if this employee will use the system.</label>
	                        <input class="form-control" name="user_name" value="{$user_name}" placeholder="User Name">
	                    </div>
	                    
	                    <div class="form-group">
	                        <input type="password" class="form-control" name="new_password" placeholder="New Password">
	                    </div>
					
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
	    
		
   </div>
{include file="footer.tpl"}