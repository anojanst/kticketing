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
            $('input.customer').typeahead({
                name: 'customer',
                remote : 'ajax/customer_id_and_name.php?query=%QUERY'

            });
        })
    </script>

    <script type="text/javascript">
        function findTotal(){
            var s = document.getElementById("amount").value,
                t = document.getElementById("markup").value,

            var total = +s - +t;

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
                    Choose Booking No
                </div>
                <div class="panel-body">
                    <form name="booking_no_form" action="refund.php?job=booking_no_form" method="post">
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="form-group">
                                    <input class="booking_no form-control" type="text" name="booking_no" value="{$booking_no}" required placeholder="Booking No" autofocus="autofocus"/>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <button type="submit" name="ok" class="btn btn-primary">Display Booking Details</button>
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
                        Create refund
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <form name="receipt" action="refund.php?job=save" method="post" enctype="multipart/form-data">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input class="form-control customer" type="text" name="customer" value="{$customer}" required="required" placeholder="Customer"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                                                <input type="text" name="apply_date" class="form-control" id="datepicker" value="{$apply_date}" required="required" style="width: 100%;" placeholder="Apply Date">
                                                <span class="add-on"><i class="icon-remove"></i></span>
                                                <span class="add-on"><i class="icon-th"></i></span>
                                            </div>
                                            <input type="hidden" id="dtp_input1" value="" />
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="count" value="{$count}" required="required" placeholder="Refund Count"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <select class="form-control" name="type" required>
                                                {if $type}
                                                    <option value="{$air_line_code}">{$air_line_code}</option>
                                                {else}
                                                    <option value=""  disabled selected">Type</option>
                                                {/if}
                                                <option value="BOTH WAY">BOTH WAY</option>
                                                <option value="DEPARTURE ONLY">DEPARTURE ONLY</option>
                                                <option value="RETURN ONLY">RETURN ONLY</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input  type="file" name="letter" id="letter" value="{$letter}" required="required" placeholder="Refund Request Letter"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="note" value="{$note}" required="required" placeholder="Note"/>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group" style="text-align: center;">
                                            <button type="submit" name="ok" value="Save & Select Passenger form Booking" class="btn btn-primary">Save & Select Passenger form Booking</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                        Latest refunds
                    </div>
                    <div class="panel-body">
                        {php}list_refund();{/php}
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

{/literal}