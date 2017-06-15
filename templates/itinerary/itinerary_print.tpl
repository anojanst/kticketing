{include file="print.tpl"}
<div style="width: 210mm;">

	<div class="row" style="margin-top: 50mm; font-size: 14px;">
		<div class="col-xs-9"><strong>{$address}</strong></div>
		<div class="col-xs-2" style="text-align: right;"><strong>{$submit_date}</strong></div>
	</div>
	<div class="row" style="margin-top: 20px; font-size: 14px;">
		<div class="col-xs-12">Dear Sir/Madam,</div>
	</div>
	<div class="row" style="margin-top: 20px; font-size: 14px;">
		<div class="col-xs-12">
            {php}list_passengers_details_just_view($_SESSION['itinerary_no']);{/php}
		</div>
	</div>
	<div class="row" style="margin-top: 15px; font-size: 14px;">
		<div class="col-xs-12">This is to confirm that the above mentioned {$passengers} {$tense} made reserversion with us for {$type} travel on the following itinerary:</div>
	</div>
	<div class="row" style="margin-top: 20px;">
		<div class="col-xs-12">{php}list_itinerary_has_flights($_SESSION['itinerary_no']);{/php}</div>
	</div>

	<div class="row" style="margin-top: 15px; font-size: 14px;">
		<div class="col-xs-12">
			We will be in position to proceed with ticketing of {$tense2} {$passengers} upon receipt of this entry visa to <strong>{$country}</strong>
			<br />
			<br />
			Please note this letter is being issued at the request of {$tense2} {$passengers}
			<br />
			<br />
			Thanking you.
			<br />
			<br />
			Yours faithfully,
			<br />
			<br />
			<strong>. . . . . . . . . . . . . . . . . .</strong>
			<br />
			<strong>Travels Executive,</strong>
			<br />
			<strong>Nation Popular Travels & Tours</strong>
		</div>
	</div>

{include file="footer.tpl"}

{literal}
<script>
    $(function () {
        $("#example1").DataTable();
    });
</script>
{/literal}