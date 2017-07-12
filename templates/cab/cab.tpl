{include file="header.tpl"}
{include file="navigation.tpl"}

{literal}
    <script type="text/javascript">
        $(document).ready(function() {
            $('input.customer').typeahead({
                name: 'customer',
                remote : 'ajax/customer_id_and_name.php?query=%QUERY'

            });
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('input.customer_id').typeahead({
                name: 'customer_id',
                remote : 'ajax/customer_id.php?query=%QUERY'

            });
        })
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('input.offer_code').typeahead({
                name: 'offer_code',
                remote : 'ajax/offer.php?query=%QUERY'

            });
        })
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
    <div class="row" onload="ifReturn()">
        <div class="col-lg-12" style="margin-top: 10px;">
            <div class="panel panel-yellow" style="margin-top: 10px;">
                <div class="panel-heading">
                    <form role="form" action="cab.php?job=search" method="post" name="add_item">
                        <div class="form-group">
                            <input type="text" name="search" value="{$cab_booking_no}" placeholder="Search By Cab Booking No" class="form-control"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    <strong>Save Cab Booking</strong>
                </div>
                <div class="panel-body">
                    <form role="form" action="cab.php?job=save" method="post" name="add_item">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="start" value="{$start}" required placeholder="From">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="end" value="{$end}" required placeholder="To">
                                </div>
                            </div>

                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="count" value="{$count}" required placeholder="Passenger Count">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <select class="form-control" name="vechicle_type" required placeholder="Vechicle Type" >
                                        {if $vechicle_type}
                                            <option value="{$vechicle_type}">{$vechicle_type}</option>
                                        {else}
                                            <option value="" disabled selected>Vechicle Type</option>
                                        {/if}
                                        <option value="Car">Car</option>
                                        <option value="SUV">SUV</option>
                                        <option value="Van">Van</option>
                                        <option value="Bus">Bus</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="app_distance" value="{$app_distance}" placeholder="Approximate Distance">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="days" value="{$days}" placeholder="Days">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                                        <input type="text" name="start_date" class="form-control" id="datepicker" value="{$start_date}" placeholder="Start Date" required="required" style="width: 100%;" onclick="findTotalInfant(); findTotalChild(); findTotalAdult();">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                                        <input type="text" name="end_date" class="form-control" id="datepicker1" value="{$end_date}" placeholder="End date" style="width: 100%;">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control customer" name="customer" value="{$customer}" placeholder="Customer">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="mobile" value="{$mobile}" placeholder="Moblie">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <select class="form-control" name="status" required placeholder="Status" >
                                        {if $status}
                                            <option value="{$status}">{$status}</option>
                                        {else}
                                            <option value="" disabled selected>Status</option>
                                        {/if}
                                        <option value="Non Confirm">Non Confirm</option>
                                        <option value="Confirm">Confirm</option>
                                        <option value="Finished">Finished</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
                                        <input type="text" name="confirm_date" class="form-control" id="datepicker2" value="{$confirm_date}" placeholder="Confirmation date" style="width: 100%;">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                        </div>

                        {if $search=='On'}
                            <button type="submit" name="main_ok" value="Update" class="btn btn-primary">Update</button>
                            <a class="btn btn-primary" href="cab.php?job=next" style="color: white;">Next</a>
                        {else}
                            <button type="submit" name="main_ok" value="Save" class="btn btn-primary">Save</button>
                        {/if}
                        <button type="reset" class="btn btn-default">Reset</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
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
        $("#example1").DataTable();
    });
</script>

{/literal}