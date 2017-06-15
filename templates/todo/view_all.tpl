{include file="header.tpl"}
{include file="navigation.tpl"}
{literal}
    <script type="text/javascript">
        function blink(selector){
            $(selector).fadeOut('slow', function(){
                $(this).fadeIn('slow', function(){
                    blink(this);
                });
            });
        }

        blink('.blink');
    </script>
    <style>
        <!--
        .blink{
            animation:blink 2100ms infinite alternate;
        }

        @keyframes blink {
            from { opacity:1; }
            to { opacity:0; }
        };
        -->
    </style>
{/literal}
<div class="row">
    <div class="col-lg-12" style="margin-top: 10px;">
        <div class="panel panel-red" style="margin-top: 10px;">
            <div class="panel-heading">
                Saved Tasks
            </div>
            <div class="panel-body">
                {php}list_all_task($_SESSION['user_name']);{/php}
            </div>
        </div>

    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
{php}next_work_javascript($_SESSION['user_name']);{/php}

{include file="footer.tpl"}
{literal}
    <script>
        $(function () {
            $("#example1").DataTable();
        });
    </script>
{/literal}