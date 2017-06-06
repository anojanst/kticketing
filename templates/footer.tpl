    </div>
<script src="js/jquery-2.2.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
<script src="js/morris.min.js"></script>
<script src="js/jquery.sparkline.min.js"></script>
<script src="js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="js/jquery-jvectormap-world-mill-en.js"></script>
<script src="js/jquery.knob.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="js/bootstrap3-wysihtml5.all.min.js"></script>
<script src="js/jquery.slimscroll.min.js"></script>
<script src="js/fastclick.js"></script>
<script src="js/app.min.js"></script>
<script src="js/demo.js"></script>
<script src="js/daterangepicker.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.inputmask.js"></script>
<script src="js/jquery.inputmask.date.extensions.js"></script>
<script src="js/jquery.inputmask.extensions.js"></script>
<script src="js/select2.full.min.js"></script>
<script src="js/fileinput.js"></script>
<script src="js/fileinput.min.js"></script>

<script>
	$(function() {
	
		$("#room_cat").change(function() {
		  $("#room_no").load("ajax/room_by_category.php?choice=" + encodeURIComponent($("#room_cat").val()));
					
		});
	});
</script>

<script>
	$(function() {
	
		$("#meal_type").change(function() {
		  $("#meal").load("ajax/meal_by_meal_type.php?choice=" + encodeURIComponent($("#meal_type").val()));					
		});
	});
</script>

<script>
	$(function() {
	
		$("#liquor_type").change(function() {
		  $("#liquor").load("ajax/liquor_by_liquor_type.php?choice=" + encodeURIComponent($("#liquor_type").val()));
		  $("#size").load("ajax/size_by_liquor_type.php?choice=" + encodeURIComponent($("#liquor_type").val()));					
		});
	});
</script>

<script>
	$(function() {
	
		$("#order_type").change(function() {
		  $("#ref_no").load("ajax/ref_no_by_order_type.php?choice=" + encodeURIComponent($("#order_type").val()));					
		});
	});
</script>
<!-- /#wrapper -->

<!-- jQuery -->

{literal}

<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		forceParse: 0,
        showMeridian: 1
    });
	$('.form_date').datetimepicker({
        language:  'fr',
		pickTime: false,
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
    });
</script>
{/literal}
</body>

</html>
