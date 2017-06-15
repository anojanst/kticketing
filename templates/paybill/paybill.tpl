{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        $('input.customer_name').typeahead({
            name: 'customer_name',
            remote : 'ajax/customer_id_and_name.php?query=%QUERY'

        });
    })
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('input.bank').typeahead({
            name: 'bank',
            remote : 'ajax/bank.php?query=%QUERY'

        });
    })
</script>

<script type="text/javascript">
    function checkTotal(){
        var x = document.getElementById("total").innerHTML,
            a = document.getElementById("cheAmount").value,
            b = document.getElementById("cardAmount").value,
            c = document.getElementById("depAmount").value,
            d = document.getElementById("ezAmount").value,
            e = document.getElementById("cashAmount").value;

        var total = +a + +b + +c + +d + +e;
        if (total!=x){
            alert(total);
            alert(x);
            alert("Please enter the correct Amonuts in relevent field");
            return false;
        }
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
					<form name="paybill_customer_form" action="paybill.php?job=customer_form" method="post" onsubmit="return checkTotal();">
						<div class="row">
							<div class="col-lg-5">
								<div class="form-group">
									<input class="customer_name form-control" type="text" name="customer" value="{$customer}" required placeholder="Customer" autofocus="autofocus"/>
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" style="visibility:visible;">
									<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
										<input type="text" name="vsp_from_date" class="form-control" id="datepicker" value="{$vsp_from_date}" readonly placeholder="From" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-2">
								<div class="form-group" style="visibility:visible;">
									<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
										<input type="text" name="vsp_to_date" class="form-control" id="datepicker1" value="{$vsp_to_date}" readonly placeholder="To" style="width: 100%;">
										<span class="add-on"><i class="icon-remove"></i></span>
										<span class="add-on"><i class="icon-th"></i></span>
									</div>
									<input type="hidden" id="dtp_input1" value="" />
								</div>
							</div>
							<div class="col-lg-3">
								<div class="form-group">
									<button type="submit" name="ok" class="btn btn-primary">List Pending Vouchers</button>
								</div>
							</div>
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
						Vouchers
					</div>
					<div class="panel-body">
                        {php}list_paybill_vouchers($_SESSION['random_no']); {/php}

						<p><strong>Pending vouchers</strong></p>
                        {php}customer_paybill_detail($_SESSION['customer_id'], $_SESSION['vsp_from_date'], $_SESSION['vsp_to_date']);{/php}
						<hr>

						<ul class="nav nav-pills">
							<li class="active"><a href="#cash" data-toggle="tab">Cash Payment</a></li>
							<li><a href="#cheque" data-toggle="tab">Cheque Payment</a></li>
							<li><a href="#bank" data-toggle="tab">Bank Tranfer</a></li>
							<!--<li><a href="#credit_card" data-toggle="tab">Credit Card Payment</a></li>-->
							<li><a href="#ez_cash" data-toggle="tab">EZ Cash</a></li>
						</ul>
						<form name="paybill" action="paybill.php?job=save_paybill" method="post">
							<div class="tab-content">
								<div class="tab-pane fade in" id="cheque">
									<div class="row" style="margin-top: 20px;">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" id="cheAmount" name="cheque_amount" value="{$cheque_amount}" placeholder="Cheque Amount"/>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="cheque_no" value="{$cheque_no}" placeholder="Cheque No"/>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group" style="visibility:visible;">
												<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
													<input type="text" name="cheque_date" class="form-control" id="datepicker2" value="{$cheque_date}" readonly placeholder="Cheque Date" style="width: 100%;">
													<span class="add-on"><i class="icon-remove"></i></span>
													<span class="add-on"><i class="icon-th"></i></span>
												</div>
												<input type="hidden" id="dtp_input1" value="" />
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<input class="form-control bank" type="text" name="cheque_bank" value="{$cheque_bank}" placeholder="Cheque Bank"/>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<input class="form-control" type="text" name="cheque_branch" value="{$cheque_branch}" placeholder="Cheque Branch"/>
											</div>
										</div>
									</div>
								</div>
								<!-- <div class="tab-pane fade in" id="credit_card">
					<div class="row" style="margin-top: 20px;">
						<div class="col-lg-3">
							<div class="form-group">
								<input class="form-control" type="text" id="cardAmount" name="card_amount" value="{$card_amount}" placeholder="Amount"/>
							</div>                 
                    	</div>
						<div class="col-lg-3">
							<div class="form-group">
								<input class="form-control" type="text" name="card_no" value="{$card_no}" placeholder="Card No"/>
							</div>                 
                    	</div>
						<div class="col-lg-2">
		                    <div class="form-group" style="visibility:visible;">
    							<input type="text" name="exp_date" value="{$exp_date}" readonly placeholder="Expire Date XX/XX" style="width: 100%;">
        						
		                    </div>
		                </div>
						<div class="col-lg-2">
							<div class="form-group">
								<select class="form-control" name="card_bank" placeholder="Card Bank" >
									{if $way}
										<option value="{$card_bank}">{$card_bank}</option>
									{else}
										<option value="" disabled selected>Card Bank</option>
									{/if}
										<option value="Bank of Ceylon">Bank of Ceylon</option>
 										<option value="Peoples Bank">Peoples Bank</option>
 										<option value="National Savings Bank">National Savings Bank</option>
 										<option value="NDB">NDB</option>
 										<option value="Commercial Bank">Commercial Bank</option>
 										<option value="Hatton National Bank">Hatton National Bank</option>
 										<option value="Seylan Bank">Seylan Bank</option>
 										<option value="HSBC">HSBC</option>
 										<option value="DFCC Vardhana Bank">DFCC Vardhana Bank</option>
 										<option value="Sampath Bank">Sampath Bank</option>
 										<option value="Union Commercial Bank">Union Commercial Bank</option>
 										<option value="Nations Trust Bank">Nations Trust Bank</option>
 										<option value="Pan Asia Bank">Pan Asia Bank </option>
  										<option value="Standard chartered Bank">Standard chartered Bank</option>
  										<option value="City Bank">City Bank</option>
  										<option value="Deutsche Bank">Deutsche Bank</option>
  										<option value="Amana Bank">Amana Bank</option>
  										<option value="State Bank of India">State Bank of India</option>
  										<option value="Indian Bank">Indian Bank</option>
  										<option value="ICICI Bank">ICICI Bank</option>
  										<option value="Axis Bank">Axis Bank</option>
								</select>
							</div>                 
                    	</div>
					</div>
					</div> -->
								<div class="tab-pane fade in" id="bank">
									<div class="row" style="margin-top: 20px;">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" id="depAmount" name="dep_amount" value="{$dep_amount}" placeholder="Deposited Amount"/>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="bank" value="{$bank}" placeholder="Bank"/>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group" style="visibility:visible;">
												<div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
													<input type="text" name="dep_date" value="{$dep_date}" class="form-control" id="datepicker3" readonly placeholder="Deposited Date" style="width: 100%;">
													<span class="add-on"><i class="icon-remove"></i></span>
													<span class="add-on"><i class="icon-th"></i></span>
												</div>
												<input type="hidden" id="dtp_input1" value="" />
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<input class="bank form-control" type="text" name="from_bank" value="{$from_bank}" placeholder="From Bank"/>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade in" id="ez_cash">
									<div class="row" style="margin-top: 20px;">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" id="ezAmount" name="ez_amount" value="{$ez_amount}" placeholder="Amount"/>
											</div>
										</div>
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" name="ref_no" value="{$ref_no}" placeholder="Ref No"/>
											</div>
										</div>
										<div class="col-lg-2">
											<div class="form-group">
												<input class="form-control" type="text" name="mobile" value="{$mobile}" placeholder="Mobile"/>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade in active" id="cash">
									<div class="row" style="margin-top: 20px;">
										<div class="col-lg-3">
											<div class="form-group">
												<input class="form-control" type="text" id="cashAmount" name="cash_amount" value="{$cash_amount}" required placeholder="Amount"/>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="panel panel-yellow">
										<div class="panel-heading">
											paybill Detail
										</div>
										<div class="panel-body">
											<div class="col-lg-2">
												<div class="form-group" style="visibility:visible;">
													<div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
														<input type="text" name="date" value="{$date}" class="form-control" id="datpicker4" required placeholder="Date" style="width: 100%;">
														<span class="add-on"><i class="icon-remove"></i></span>
														<span class="add-on"><i class="icon-th"></i></span>
													</div>
													<input type="hidden" id="dtp_input1" value="" />
												</div>
											</div>
											<div class="col-lg-6">
												<div class="form-group">
													<input class="form-control" type="text" name="remarks" value="{$remarks}" placeholder="Remarks"/>
												</div>
											</div>
											<div class="col-lg-2">
												<div class="form-group">
													<input class="form-control" type="text" name="saved_by" value="{$saved_by}" readonly="readonly"/>
												</div>
											</div>
											<div class="col-lg-2">
												<div class="form-group">
													<input class="btn btn-primary" type="submit" name="ok" value="Save paybill" />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
		</div>
    {/if}
</section>
{include file="footer.tpl"}
{literal}
<script>
	$(function () {
		$('#datepicker').datepicker({
		 	format: 'yyyy-mm-dd',
		  	autoclose: true
		});
	});
</script>
<script>
	$(function () {
		$('#datepicker1').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true
		});
	});
</script>

<script>
    $(function () {

        $('#datepicker2').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>

<script>
    $(function () {

        $('#datepicker3').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>

<script>
    $(function () {

        $('#datepicker4').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });
</script>

{/literal}