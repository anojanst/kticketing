{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
$(document).ready(function() {
$('input.user').typeahead({
  name: 'user',
  remote : 'ajax/user_name.php?query=%QUERY'

});
})
</script>
{/literal}

<div class="row">
	<div class="panel panel-primary" style="margin-top: 10px;">
		<div class="panel-heading">
                    Search Chat
         </div>
        <div class="panel-body">
            <form role="form" action="chat_history.php?job=search" method="post">
	             <div class="col-lg-4">
	                    <div class="form-group">
	                        <input class="form-control user" name="to_user" value="{$to_user}" required placeholder="To">
	                    </div>
				</div>
	             <div class="col-lg-4">
						<div class="form-group">
	                        <input class="form-control user" name="from_user" value="{$from_user}" required placeholder="From">
	                    </div>
				</div>
				 <div class="col-lg-2">
						<button type="submit" name="ok" value="Search" class="btn btn-primary">Search History</button>
				</div>
	      </form>
			<a href="chat_history.php?job=chat_history_print"  class="btn btn-primary" target="blank">Print</a>
         </div>           
	</div>
</div>
<div class="row">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Users
                </div>
                <div class="panel-body">
                    {php}chat_history_for2days($_SESSION['to_user'],$_SESSION['from_user']);{/php}
                </div>
                <div class="panel-footer">
                </div>
            </div>
   </div>

{include file="footer.tpl"}