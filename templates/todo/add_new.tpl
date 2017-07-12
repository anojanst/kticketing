{include file="header.tpl"}
{include file="navigation.tpl"}

<section class="content">
    <div class="row">
        <div class="col-lg-9" style="margin-top: 10px;">
            <div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    <strong>Add new task</strong>
                </div>
                <div class="panel-body">

                    <form role="form" action="add_new_todo.php?job=save" method="post">
                        <div class="form-group">
                            <input class="form-control" name="task_name" placeholder="Task Name">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" name="description" placeholder="Description"></textarea>
                        </div>
                        <div class="control-group">
                            <label class="control-label">DateTime Picking</label>
                            <div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
                                <input type="text" name="deadline" class="form-control" id="datepicker" readonly placeholder="Deadline" style="width: 100%;">
                                <span class="add-on"><i class="icon-remove"></i></span>
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                            <input type="hidden" id="dtp_input1" value="" /><br/>
                        </div>
                        <div class="form-group">
                            <input class="form-control user" name="to_user" placeholder="Assign This Task To">
                        </div>
                        <div class="form-group">
                            <input class="form-control" name="ref_no" placeholder="Ref No">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="type">
                                <option value="">Task Type</option>
                                <option value="Booking">Booking</option>
                                <option value="Itinerary">Itinerary</option>
                                <option value="VISA">VISA</option>
                                <option value="Cab">Cab</option>
                                <option value="Date Change">Date Change</option>
                                <option value="Refund">Refund</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control"  name="status">
                                <option>Task Status</option>
                                <option>Done</option>
                                <option>Pending</option>
                            </select>
                        </div>
                        <div class="form-group input-group">
                            <input class="form-control" name="amount" placeholder="Task Amount">
                            <span class="input-group-addon">.00</span>
                        </div>
                        <div class="form-group input-group">
                            <input class="form-control" name="received" placeholder="Received Amount">
                            <span class="input-group-addon">.00</span>
                        </div>
                        <div class="form-group input-group">
                            <input class="form-control" type="hidden" name="from" value="add">
                        </div>

                        <button type="submit" class="btn btn-default">Submit Button</button>
                        <button type="reset" class="btn btn-default">Reset Button</button>
                    </form>

                </div>
            </div>

        </div>
        <div class="col-lg-3" style="margin-top: 10px;">
            <div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    <strong>Saved Tasks</strong>
                </div>
                <div class="panel-body">
                    {php}list_task($_SESSION['user_name']);{/php}
                </div>
                <div class="panel-footer">
                    <a href="view_list.php">View all</a>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    {php}next_work_javascript($_SESSION['user_name']);{/php}
</section>

{include file="footer.tpl"}
{literal}
    <script>
        $(function () {
            $("#example1").DataTable();
        });
    </script>
{/literal}