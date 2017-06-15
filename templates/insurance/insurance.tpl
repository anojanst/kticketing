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
            $('input.country').typeahead({
                name: 'country',
                remote : 'ajax/country.php?query=%QUERY'

            });
        })
    </script>

    <script type="text/javascript">
        function findTotal(){
            var x = document.getElementById("count").value,
                y = document.getElementById("cost").value,
                z = document.getElementById("markup").value;

            var total =(+y + +z) * +x;
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
            <div class="panel panel-yellow" style="margin-top: 10px;">
                <div class="panel-heading">
                    <form role="form" action="insurance.php?job=search" method="post" name="add_item">
                        <div class="form-group">
                            <input type="text" name="search" value="{$insurance_no}" placeholder="Search By insurance No" class="form-control"/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <div class="panel panel-red" style="margin-top: 10px;">
                <div class="panel-heading">
                    Save Insurance
                </div>
                <div class="panel-body">
                    <form role="form" action="insurance.php?job=save" method="post" name="add_item">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input class="form-control country" name="country" value="{$country}" required placeholder="Country">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <select class="form-control" name="insurance_type" required placeholder="Type" >
                                        {if $insurance_type}
                                            <option value="{$insurance_type}">{$insurance_type}</option>
                                        {else}
                                            <option value="" disabled selected>Type</option>
                                        {/if}
                                        <option value="Individual">Individual</option>
                                        <option value="Famliy">Family</option>
                                        <option value="Group">Group</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input class="form-control" name="policy_no" value="{$policy_no}" required placeholder="Policy No">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input class="form-control" name="count" id="count" onkeyup="findTotal();" value="{$count}" required placeholder="Passenger Count">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input class="form-control customer" name="customer" value="{$customer}" required="required" placeholder="Customer">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input class="form-control" name="mobile" value="{$mobile}" placeholder="Moblie">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input class="form-control" name="days" value="{$days}" required placeholder="Policy Period">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                                        <input type="text" name="start_date" class="form-control" id="datepicker" value="{$start_date}" required placeholder="Start Date" style="width: 100%;">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                                        <input type="text" name="exp_date" class="form-control" id="datepicker1" value="{$exp_date}" required placeholder="Exp. Date" style="width: 100%;">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input class="form-control" id="cost" name="cost" value="{$cost}" onkeyup="findTotal();" required="required" placeholder="Cost Per Person">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input class="form-control" id="markup" name="markup" value="{$markup}" onkeyup="findTotal();" required="required" placeholder="Mark up Per Person">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <input class="form-control" id="total" name="total" value="{$total}" required="required" placeholder="Total" readonly="readonly">
                                </div>
                            </div>

                        </div>

                        {if $search=='On'}
                            <button type="submit" name="main_ok" value="Update" class="btn btn-primary">Update</button>
                        {else}
                            <button type="submit" name="main_ok" value="Save" class="btn btn-primary">Save</button>
                        {/if}
                        <button type="reset" class="btn btn-primary">Reset</button>
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
            $("#example1").DataTable();
        });
    </script>
{/literal}