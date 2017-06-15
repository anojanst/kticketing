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
		

		</div>
	</div>

</div>

			
            <!-- /.row -->
{include file="footer.tpl"}
