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

<script type="text/javascript">
$(document).ready(function() {
$('input.user').typeahead({
  name: 'user',
  remote : 'ajax/user_name.php?query=%QUERY'

});
})
</script>

<style>
<!--
.blink{
    animation:blink 1400ms infinite alternate;
}

@keyframes blink {
    from { opacity:1; }
    to { opacity:0; }
};
-->
</style>
{/literal}

<div class="content-wrapper">
<strong> {php}list_new_message();{/php}</strong>


	<div class="nav-tabs-custom">
  		<div class="tab-content">

			<div class="row">

        		<div class="col-lg-2 col-xs-6">
          			<!-- small box -->
          			<div class="small-box bg-yellow">
            			<div class="inner">
              				<h3>Booking</h3>
              				<p> </p>
            			</div>

            			<div class="icon">
              				<i class="ion ion-plane"></i>
            			</div>

            			<a href="booking.php?job=booking_form" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          			</div>
        		</div>

        		<div class="col-lg-2 col-xs-6">
          			<!-- small box -->
          			<div class="small-box bg-green">
            			<div class="inner">
              				<h3>Insurance</h3>
              				<p> </p>
            			</div>

            			<div class="icon">
              				<i class="ion ion-briefcase"></i>
            			</div>

            			<a href="insurance.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          			</div>
        		</div>

        		<div class="col-lg-2 col-xs-6">
          			<!-- small box -->
          			<div class="small-box bg-gray">
            			<div class="inner">
              				<h3>Itinerary</h3>
              				<p> </p>
            			</div>

            			<div class="icon">
              				<i class="ion ion-battery-low"></i>
            			</div>

            			<a href="itinerary.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          			</div>
        		</div>

        		<div class="col-lg-2 col-xs-6">
          			<!-- small box -->
          			<div class="small-box bg-blue">
            			<div class="inner">
              				<h3>Visa</h3>
              				<p> </p>
            			</div>

            			<div class="icon">
              				<i class="ion ion-android-globe"></i>
            			</div>

            			<a href="visa.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          			</div>
        		</div>

        		<div class="col-lg-2 col-xs-6">
          			<!-- small box -->
          			<div class="small-box bg-aqua">
            			<div class="inner">
              				<h3>Cab</h3>
              				<p> </p>
            			</div>

            			<div class="icon">
              				<i class="ion ion-android-car"></i>
            			</div>

            			<a href="cab.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          			</div>
        		</div>

        		<div class="col-lg-2 col-xs-6">
          			<!-- small box -->
          			<div class="small-box bg-lime">
            			<div class="inner">
              				<h3>Receipt</h3>
              				<p> </p>
            			</div>

            			<div class="icon">
              				<i class="ion ion-android-list"></i>
            			</div>

            			<a href="receipt.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          			</div>
        		</div>



			</div>			


		<!--
			<div class="row" style="margin-top: 20px;">
                <div class="col-lg-2">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3" style="margin-left: 10px;">
                                    <i class="fa fa-space-shuttle fa-5x"></i>
                                </div>
							</div>
                        </div>
                        <a href="booking.php?job=booking_form">
                            <div class="panel-footer">
                                <span class="pull-left">Booking</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3" style="margin-left: 20px;">
                                    <i class="fa fa-life-ring fa-5x"></i>
                                </div>
							</div>
                        </div>
                        <a href="insurance.php">
                            <div class="panel-footer">
                                <span class="pull-left">Insurance</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3" style="margin-left: 30px;">
                                    <i class="fa fa-italic fa-5x"></i>
                                </div>
							</div>
                        </div>
                        <a href="itinerary.php?job=itinerary_form">
                            <div class="panel-footer">
                                <span class="pull-left">Itinerary</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3" style="margin-left: 10px;">
                                    <i class="fa fa-cc-visa fa-5x"></i>
                                </div>
							</div>
                        </div>
                        <a href="visa.php">
                            <div class="panel-footer">
                                <span class="pull-left">Visa</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3"  style="margin-left: 15px;">
                                    <i class="fa fa-car fa-5x"></i>
                                </div>
							</div>
                        </div>
                        <a href="cab.php">
                            <div class="panel-footer">
                                <span class="pull-left">Cab</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3" style="margin-left: 20px;">
                                    <i class="fa fa-credit-card fa-5x"></i>
                                </div>
							</div>
                        </div>
                        <a href="receipt.php">
                            <div class="panel-footer">
                                <span class="pull-left">Receipt</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
		-->
 				<div class="row">
					<div class="panel panel-green" style="margin-top: 10px;">
						 <div class="panel-heading">
						</div>
							<div class="panel-body">
 							   {php}list_quick_links_home();{/php}
							</div>
  						</div>
				</div>
		 <div class="row">
                <div class="col-lg-9" style="margin-top: 10px;">
      				<div class="panel panel-default" style="margin-top: 10px;">
                        <div class="panel-heading">
                           Booking Without Visa & Passport
                        </div>
						<div class="panel-body">
							 <div class="col-lg-12"><h5> Visa </h5></div>
	                         <div style="margin-bottom: 20px;">{php}booking_without_visa($_SESSION['user_name']);{/php}</div>
	                         <div class="col-lg-12"><h5> Passport </h5></div>
							 <div>{php}booking_without_passport($_SESSION['user_name']);{/php}</div>
	                    </div>
					</div>
   					<div class="panel panel-info" style="margin-top: 10px;">
                        <div class="panel-heading">
                            Add new task
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
                    							<input type="text" name="deadline" readonly placeholder="Deadline" style="width: 100%;">
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
												<option value="Insurance">Insurance</option>
												<option value="VISA">VISA</option>
												<option value="Cab">Cab</option>
												<option value="Date Change">Date Change</option>
												<option value="Refund">Refund</option>
												<option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" name="status">
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
                                            <input class="form-control" type="hidden" name="from" value="user">
                                        </div>
                                      
                                        <button type="submit" class="btn btn-default">Submit</button>
                                        <button type="reset" class="btn btn-default">Reset</button>
                                    </form>

						</div>
                    </div>
	
                </div>
				<div class="col-lg-3">
      				<div class="panel panel-red" style="margin-top: 10px;">
                        <div class="panel-heading">
                            Next 5 Tasks
                        </div>
                        <div class="panel-body">
                            {php}list_next_five_task($_SESSION['user_name']);{/php}
                        </div>
                        <div class="panel-footer">
                            <a href="view_list.php">View all</a>
                        </div>
                    </div>   
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


		</div>
	</div>

</div>

			
            <!-- /.row -->
{include file="footer.tpl"}
