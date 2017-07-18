{include file="header.tpl"}
{include file="navigation.tpl"}

<section class="content">
	<div class="panel panel-info" style="margin-top: 10px;">
		<div class="panel-body">
			<div class="row" style="margin-top: 20px; margin-bottom: 30px;">
				<form name="receipt" action="refund.php?job=send_mail" method="post" enctype="multipart/form-data">
					<div class="col-lg-1">To :</div>
					<div class="col-lg-11">
						<div class="form-group">
							<input class="form-control travels" type="text" name="to" required="required"/>
						</div>
					</div>
					<div class="col-lg-1">Subject :</div>
					<div class="col-lg-11">
						<div class="form-group">
							<input class="form-control" type="text" name="subject" required="required"/>
						</div>
					</div>
					<div class="col-lg-1">File :</div>
					<div class="col-lg-11">
						<div class="form-group">
							<input type="file" name="file" id="file" required="required"/>
						</div>
					</div>
					<div class="col-lg-12">
						<button type="submit" name="ok" value="Send" class="btn btn-danger">Send</button>
					</div>
				</form>
			</div>
			<div class="row" style="margin-left: 1px;">
                {include file="print_company_detail.tpl"}
			</div>

			<div class="row" style="margin-left: 1px;">
				<div class="col-xs-12" style="text-align: center; margin-top: -10px;">
					<h1><strong>REFUND REQUEST</strong></h1>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="row" style="margin-bottom: 10px;">
					<div class="col-xs-12">
						<strong>To : </strong>{$travels}
					</div>
				</div>
				<div class="row" style="margin-bottom: 10px;">
					<div class="col-xs-12" style="text-align: center;">
						Please proceed the refund process for the following Passengers in this ticket.
					</div>
				</div>


				<div class="row" style="margin-bottom: 10px;">
					<div class="col-xs-3">
						<strong>Booking No : </strong>{$booking_no}
					</div>
					<div class="col-xs-3">
						<strong>Booking Ref : </strong>{$pnr}
					</div>
					<div class="col-xs-6">
						<strong>Refund Application for : </strong>{$type}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						<h4><strong>Ticket Details</strong></h4>
                        {php} get_booking_details_for_voucher($_SESSION['booking_no']); {/php}
					</div>
					<div class="col-xs-12">
						<h4><strong>Refund Appling Passengers Details</strong></h4>
                        {php} list_passengers_for_refund_no_view($_SESSION['refund_no']); {/php}
					</div>
				</div>

				<div class="row" style="margin-top: 5px; font-size: 12px; margin-left: 1px;">
					<div class="col-xs-12">
						<div class="table-responsive">
							<table class="table">
								<tr>
									<td width="120">PREPARED BY :</td>
									<td width="150"><strong>{$saved_by}</strong></td>
									<td width="200">AUTHORIZED SIGNATURE :</td>
									<td></td>
								</tr>

							</table>
						</div>
					</div>
				</div>
				<div class="row" style="margin-bottom: 10px;">
					<div class="col-xs-12" style="text-align: center;">
						We do not hold ourselves responsible for any alteration made in this document
					</div>
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
	<script>
        $(function () {
            $("#example2").DataTable();
        });
	</script>
{/literal}