{include file="header.tpl"}
{include file="navigation.tpl"}

<div id="contents">
    {if $error_report=='on'}
        <div class="error_report">
            <strong>{$error_message}</strong>
        </div>
    {/if}
    {if $warning_report=='on'}
        <div class="warning_report" style="margin-bottom: 50px;">
            <strong>{$warning_message}</strong>
        </div>
    {/if}
    <section class="content">
        <div class="nav-tabs-custom">
            <div class="tab-content">
                <div class="row">
                    <div class="col-lg-12" align="center">
                        <h2><strong>Company Details </strong></h2>
                    </div>

                    <form role="form" action="company_settings.php?job=edit" method="post" class="product" enctype="multipart/form-data">
                        <div class="row" style="margin-bottom: 10px; margin-left: 20px;">
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-lg-3">Name: </div>

                                <div class="col-lg-6">
                                    <input class="form-control" name="name"  value="{$name}" placeholder="Name">
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-lg-3">Address : </div>

                                <div class="col-lg-6">
                                    <textarea class="form-control" name="address" value=""  placeholder="address"> {$address}</textarea>
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-lg-3">Telephone : </div>

                                <div class="col-lg-6">
                                    <input class="form-control" name="telephone" value="{$telephone}"  placeholder="Telephone">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-lg-3">Fax : </div>

                                <div class="col-lg-6">
                                    <input class="form-control" name="fax" value="{$fax}"  placeholder="Fax">
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-lg-3">Email : </div>

                                <div class="col-lg-6">
                                    <input class="form-control" name="email" value="{$email}"  placeholder="Email">
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-lg-3">Website : </div>

                                <div class="col-lg-6">
                                    <input class="form-control" name="website" value="{$website}"  placeholder="Website">
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-lg-3">Branches : </div>

                                <div class="col-lg-6">
                                    <input class="form-control" name="branches" value="{$branches}"  placeholder="Branches">
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 10px;">
                                <div class="col-lg-3">Logo : </div>

                                <div class="col-lg-6">
                                    <input type="file" name="logo" id="logo" placeholder="Cover" required/>
                                </div>
                            </div>

                            <div class="row" style="margin-left: 20px;">
                                <div class="col-lg-2">
                                    <button type="submit" value="Update" class="btn btn-block btn-success btn-lg">Update</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

{include file="footer.tpl"}
{literal}
    <script>
        $(document).on('ready', function() {
            $("#gallery").fileinput({
                showUpload: false,
                maxFileCount: 10,
                mainClass: "input-group-lg"
            });
        });
    </script>

    <script>
        $(document).on('ready', function() {
            $("#input-1").fileinput({
                showUpload: false,
                maxFileCount: 1,
                mainClass: "input-group-lg"
            });
        });
    </script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2();

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
{/literal}