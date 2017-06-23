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
            <div class="box box-primary" style="margin-top: 10px;">
                <div class="panel-heading">Search By Booking No
                </div>
                <div class="panel-body">
                    <form role="form" action="ticket_number.php?job=list_passenger" method="post">
                        <div class="col-lg-10">
                            <div class="form-group">
                                <input class="booking_no form-control" type="text" name="booking_no" value="{$booking_no}" required placeholder="Booking No" autofocus="autofocus"/>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="form-group">
                                <button type="submit" name="ok" class="btn btn-success">List Passengers</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {if $booking_no}
        <div class="row">
            <div class="col-lg-12" style="margin-top: 10px;">
                <div class="panel panel-red" style="margin-top: 10px;">
                    <div class="panel-heading">
                        Passengers | <strong>Booking No : {$booking_no}</strong>
                    </div>
                    <div class="panel-body">

                        {php}list_passengers_details_ticket($_SESSION['booking_no']);{/php}
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
            $("#example1").DataTable();
        });
    </script>
{/literal}