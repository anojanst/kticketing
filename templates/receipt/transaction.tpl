{include file="header.tpl"}
	<div class="row">    
		<div class="col-lg-12">
			<div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Receipt
                </div>
                <div class="panel-body">
                    {php} list_receipt_invoices_view($_SESSION['rec_no']); {/php}

                </div>
                <div class="panel-footer">
                </div>
            </div>   
        </div>
   </div>
{include file="footer.tpl"}