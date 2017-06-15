{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.booking_no').typeahead({
                name: 'booking_no',
                remote : 'ajax/booking_no_confirm.php?query=%QUERY'

            });
        })
	</script>
	<script type="text/javascript">
        $(document).ready(function() {
            $('input.travels').typeahead({
                name: 'travels',
                remote : 'ajax/travels.php?query=%QUERY'

            });
        })
	</script>
	<script type="text/javascript">
        function findTotal(){
            var s = document.getElementById("fare").value,
                t = document.getElementById("bol_amount").value,
                u = document.getElementById("taxes").value,
                radio1 = document.getElementById("btt");
            var p=(s/100)*t;
            if (radio1.checked) {
                var sub_total = +s + +p;
            }
            else{
                var sub_total = +s - +p;
            }
            var total = +sub_total + +u;
            document.getElementById("sub_tot").value=sub_total;
            document.getElementById("total").value=total;
        }
	</script>
{/literal}
{if $error_message}
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="alert alert-danger"><strong>{$error_message}</strong></div>

		</div>
	</div>
{/if}
<section class="content">
	<div class="row">
		<div class="col-lg-12" style="margin-top: 10px;">
			<div class="panel panel-green">
				<div class="panel-heading">
					Choose Customer
				</div>
				<div class="panel-body">
					<form name="booking_no_form" action="voucher.php?job=booking_no_form" method="post">
						<div class="row">
							<div class="col-lg-7">
								<div class="form-group">
									<input class="booking_no form-control" type="text" name="booking_no" value="{$booking_no}" required placeholder="Booking No" autofocus="autofocus"/>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group">
									<button type="submit" name="ok" class="btn btn-success">Generate Voucher</button>
								</div>
							</div>
                            {if $voucher_without_visa==1}
								<div class="col-lg-3">
									<div class="form-group">
										<button type="submit" name="skip" value="YES" class="btn btn-danger">Skip Visa & Generate Voucher</button>
									</div>
								</div>
                            {/if}
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
    {if $submit=='true'}
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-red" style="margin-top: 10px;">
					<div class="panel-heading">
						Create Voucher
					</div>
					<div class="panel-body">
						<div class="row" style="margin-bottom: 10px;">
							<div class="col-lg-9">
								<strong>Booking No : </strong>{$booking_no}
							</div>
							<div class="col-lg-3">
								<strong>Booking Ref : </strong>{$pnr}
							</div>
						</div>
						<form name="receipt" action="voucher.php?job=save" method="post">
							<div class="row">
								<div class="col-lg-5">
                                    {php} get_booking_passengers_for_voucher($_SESSION['booking_no']); {/php}
								</div>
								<div class="col-lg-7">
                                    {php} get_booking_details_for_voucher($_SESSION['booking_no']); {/php}
								</div>
							</div>


							<div class="row">
								<div class="col-lg-4">
								</div>
								<div class="col-lg-4">
									<div class="row">
										<div class="col-lg-6">Travels :</div>
										<div class="col-lg-6">
											<div class="form-group">
												<input class="form-control travels" type="text" name="travels" value="{$travels}" required="required"/>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">Time Limit :</div>
										<div class="col-lg-6">
											<div class="form-group">
												<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
													<input type="text" name="time_limit" value="{$time_limit}" required="required" style="width: 100%;">
													<span class="add-on"><i class="icon-remove"></i></span>
													<span class="add-on"><i class="icon-th"></i></span>
												</div>
												<input type="hidden" id="dtp_input1" value="" />
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">Fare :</div>
										<div class="col-lg-6">
											<div class="form-group">
												<input class="form-control" type="text" name="fare" value="{$fare}" id="fare" required="required" onload="findTotal()"/>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">BTT OR Less COM :</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label class="radio-inline">
													<input type="radio" checked="{$checked}" value="BTT" name="btt_or_less" id="btt" onclick="findTotal()"></input>
													BTT
												</label>
												<label class="radio-inline">
													<input type="radio" checked="{$checked}" value="Less" name="btt_or_less" id="less" onclick="findTotal()"></input>
													Less
												</label>
												<input class="form-control" type="text" name="bol_amount" value="{$bol_amount}" id="bol_amount" onkeyup="findTotal()" required="required"/>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">Total Without Tax:</div>
										<div class="col-lg-6">
											<div class="form-group">
												<input class="form-control" type="text" name="sub_tot" id="sub_tot" value="{$sub_tot}" required="required" readonly="readonly"/>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">Taxes :</div>
										<div class="col-lg-6">
											<div class="form-group">
												<input class="form-control" type="text" name="taxes" value="{$taxes}" id="taxes" onkeyup="findTotal()" required="required"/>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">Total :</div>
										<div class="col-lg-6">
											<div class="form-group">
												<input class="form-control" type="text" name="total" value="{$total}" id="total" required="required" readonly="readonly"/>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-6">New PNR :</div>
										<div class="col-lg-6">
											<div class="form-group">
												<input class="form-control" type="text" name="pnr" id="total"/>
											</div>
										</div>
									</div>
									<div class="row" align="center">
										<button type="submit" name="ok" value="Save" class="btn btn-danger">Save</button>
									</div>
								</div>
						</form>
					</div>

				</div>
			</div>
		</div>
		</div>

    {else}
		<div class="row">
			<div class="col-lg-12" style="margin-top: 10px;">
				<div class="panel panel-red">
					<div class="panel-heading">
						Latest Vouchers
					</div>
					<div class="panel-body">
                        {php}list_voucher();{/php}
					</div>
				</div>
			</div>
		</div>
    {/if}
</section>
{include file="footer.tpl"}