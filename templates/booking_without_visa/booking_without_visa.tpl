{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
    <script type="text/javascript">
        $(document).ready(function() {
            $('input.staff_name').typeahead({
                name: 'staff_name',
                remote : 'ajax/user_name.php?query=%QUERY'

            });
        })
    </script>
{/literal}

<section class="content">
    <div class="row">
        <div class="box box-primary" style="margin-top: 10px;">
            <div class="panel-heading">
                Booking Without Visa & Passport
            </div>
            <div class="panel-body">
                <form role="form" action="booking_without_visa.php?job=search" method="post">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <input class="form-control staff_name" type="text" name="staff_name" value="{$staff_name}" placeholder="Name"/>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <button type="submit" name="ok" value="Search" class="btn btn-primary">Search</button>
                    </div>
                </form>
                <div class="col-lg-2">
                    <a href="booking_without_visa.php?job=booking_without_visa_print"  class="btn btn-primary" target="blank">Print</a>
                </div>
            </div>
        </div>
    </div>

    {if $search=="on"}
        <div class="row">
            <div class="panel panel-default" style="margin-top: 10px;">
                <div class="panel-heading">
                    Booking Without Visa
                </div>
                <div class="panel-body">
                    {php}booking_without_visa($_SESSION['staff_name']);{/php}
                </div>

                <div class="panel-footer">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="panel panel-default" style="margin-top: 10px;">
                <div class="panel-heading">
                    Booking Without Passport
                </div>
                <div class="panel-body">
                    {php}booking_without_passport($_SESSION['staff_name']);{/php}
                </div>

                <div class="panel-footer">
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