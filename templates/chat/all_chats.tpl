{include file="header.tpl"}
{include file="navigation.tpl"}
	<div class="row">
		<div class="col-lg-10" style="margin-top: 10px;">
			<div class="panel panel-primary">
                <div class="panel-heading">
                    Chats With : {$chat_with}
                </div>
                <div class="panel-body">
            		{if $chat_with}
						{php}chat_with($_SESSION['chat_with']);{/php}
						
					{else}
						<p style="font-size: 30px; text-align: center; font-weight: bold;">Select a User to view Chat History</p>
					{/if}
					
				</div>
            </div>
	    </div>
	    
		<div class="col-lg-2">
			<div class="panel panel-primary" style="margin-top: 10px;">
                <div class="panel-body">

                    {php}list_users_for_chat_full();{/php}
                </div>
            </div>   
        </div>
   </div>
{include file="footer.tpl"}