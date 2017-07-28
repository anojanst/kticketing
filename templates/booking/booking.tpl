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
    <script>
        function calculateDiscountAdult()
        {
            var xmlhttp;
            var pass = document.getElementById("fare").value;
            if (pass=="")
            {
                document.getElementById("afterDiscountAdult").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {
                xmlhttp=new XMLHttpRequest();
            }
            else
            {
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    var outPut = xmlhttp.responseText;
                    document.getElementById("afterDiscountAdult").innerHTML=xmlhttp.responseText;

                }
            }
            var air_line_code = document.getElementById("air_line_code").value;
            xmlhttp.open("GET","ajax/check_cut_off.php?fare="+pass+"&air_line_code="+air_line_code,true);
            xmlhttp.send();

        }
    </script>

    <script type="text/javascript">
        function findTotalAdult(){
            var x = document.getElementById("afterDiscountAdult").innerHTML;
                console.log(x);
                y = document.getElementById("tax").value;
                z = document.getElementById("markup").value;

            var total = +x + +y + +z;
            document.getElementById("total").value=total;
        }
    </script>

    <script>
        function calculateDiscountChild()
        {
            var xmlhttp;
            var pass = document.getElementById("child_fare").value;
            if (pass=="")
            {
                document.getElementById("afterDiscountChild").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {
                xmlhttp=new XMLHttpRequest();
            }
            else
            {
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    var outPut = xmlhttp.responseText;
                    document.getElementById("afterDiscountChild").innerHTML=xmlhttp.responseText;
                }
            }
            var air_line_code = document.getElementById("air_line_code").value;
            var offer = document.getElementById("offer").value;
            var offer_code = document.getElementById("offer_code").value;
            xmlhttp.open("GET","ajax/check_cut_off.php?fare="+pass+"&air_line_code="+air_line_code+"&offer="+offer+"&offer_code="+offer_code,true);
            xmlhttp.send();

        }
    </script>

    <script type="text/javascript">
        function findTotalChild(){
            var s = document.getElementById("afterDiscountChild").innerHTML,
                t = document.getElementById("child_tax").value,
                u = document.getElementById("child_markup").value;

            var total = +s + +t + +u;
            document.getElementById("totalChild").value=total;
        }
    </script>

    <script>
        function calculateDiscountInfant()
        {
            var xmlhttp;
            var pass = document.getElementById("infant_fare").value;
            if (pass=="")
            {
                document.getElementById("afterDiscountInfant").innerHTML="";
                return;
            }
            if (window.XMLHttpRequest)
            {
                xmlhttp=new XMLHttpRequest();
            }
            else
            {
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    var outPut = xmlhttp.responseText;
                    document.getElementById("afterDiscountInfant").innerHTML=xmlhttp.responseText;
                }
            }
            var air_line_code = document.getElementById("air_line_code").value;
            var offer = document.getElementById("offer").value;
            var offer_code = document.getElementById("offer_code").value;
            xmlhttp.open("GET","ajax/check_cut_off.php?fare="+pass+"&air_line_code="+air_line_code+"&offer="+offer+"&offer_code="+offer_code,true);
            xmlhttp.send();

        }
    </script>

    <script type="text/javascript">
        function findTotalInfant(){
            var x = document.getElementById("afterDiscountInfant").innerHTML,
                y = document.getElementById("infant_tax").value,
                z = document.getElementById("infant_markup").value;

            var total = +x + +y + +z;
            document.getElementById("totalInfant").value=total;
        }
    </script>

    <script type="text/javascript">

        function ifReturn() {
            if (document.getElementById('way').value=="Return") {
                document.getElementById('returnDate').style.visibility = 'visible';
                document.getElementById('returnArrivalTime').style.visibility = 'visible';
                document.getElementById('returnDepartureTime').style.visibility = 'visible';
            } else {
                document.getElementById('returnDate').style.visibility = 'hidden';
                document.getElementById('returnArrivalTime').style.visibility = 'hidden';
                document.getElementById('returnDepartureTime').style.visibility = 'hidden';
            }
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('input.offer_code').typeahead({
                name: 'offer_code',
                remote : 'ajax/offer.php?query=%QUERY'

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
    <div class="row" onload="ifReturn()">
        <div class="col-lg-12" style="margin-top: 10px;">
            <div class="box box-primary" style="margin-top: 10px;">
                <div class="panel-heading">
                    <form role="form" action="booking.php?job=search" method="post" name="add_item">
                        <div class="form-group">
                            <input type="text" name="search" value="{$booking_no}" placeholder="Search By Booking No" class="form-control"/>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    <strong>Fare Details</strong>
                </div>
                <div class="panel-body">
                    <form role="form" action="booking.php?job=add_item" method="post" name="add_item">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <select class="form-control" id="air_line_code" name="air_line_code" onchange="calculateDiscountAdult(); calculateDiscountInfant(); calculateDiscountChild();" required placeholder="Air Line" >
                                        {if $air_line}
                                            <option value="{$air_line_code}">{$air_line_code}</option>
                                        {else}
                                            <option value="" disabled selected>Air Lines</option>
                                        {/if}
                                        {section name=air_line_code loop=$air_line_names}
                                            <option value="{$air_line_names[air_line_code]}">{$air_line_names[air_line_code]}</option>
                                        {/section}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <select class="form-control" name="class" required placeholder="class" >
                                        {if $class}
                                            <option value="{$class}">{$class}</option>
                                        {else}
                                            <option value="" disabled selected>Class</option>
                                        {/if}
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                        <option value="F">F</option>
                                        <option value="G">G</option>
                                        <option value="H">H</option>
                                        <option value="I">I</option>
                                        <option value="J">J</option>
                                        <option value="K">K</option>
                                        <option value="L">L</option>
                                        <option value="M">M</option>
                                        <option value="N">N</option>
                                        <option value="O">O</option>
                                        <option value="P">P</option>
                                        <option value="Q">Q</option>
                                        <option value="R">R</option>
                                        <option value="S">S</option>
                                        <option value="T">T</option>
                                        <option value="U">U</option>
                                        <option value="V">V</option>
                                        <option value="W">W</option>
                                        <option value="X">X</option>
                                        <option value="Y">Y</option>
                                        <option value="Z">Z</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <select class="form-control" name="type" required placeholder="Type" >
                                        {if $type}
                                            <option value="{$type}">{$type}</option>
                                        {else}
                                            <option value="" disabled selected>Type</option>
                                        {/if}
                                        <option value="First Class">First Class</option>
                                        <option value="Business">Business</option>
                                        <option value="Economy">Economy</option>
                                        <option value="High Economy">High Economy</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="fare" value="{$fare}" id="fare" onkeyup="calculateDiscountAdult();" required placeholder="Fare">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <span id="afterDiscountAdult" class="alert-info col-lg-12"   style="height: 30px; text-align: right; padding: 5px;"></span>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="tax" value="{$tax}" id="tax" onkeyup="findTotalAdult()" required placeholder="Tax">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="markup" onkeyup="findTotalAdult()" id="markup" value="{$markup}" required placeholder="Markup">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <select class="form-control" name="passenger_type" required placeholder="Passsenger" >
                                    {if $passenger_type}
                                        <option value="{$passenger_type}">{$passenger_type}</option>
                                    {else}
                                        <option value="" disabled selected>Passenger_type</option>
                                    {/if}
                                    <option value="ADULT">Adult</option>
                                    <option value="CHILD">Child</option>
                                    <option value="INFANT">Infant</option>
                                    <option value="NO_OF_TICKETS">No of Tickets</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="total" value="{$total}" id="total" required placeholder="Total" readonly>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
                                        <input type="text" name="dep_time" class="form-control" id="datetimepicker1" placeholder="Departure time" required="required" style="width: 100%;" onclick="findTotalInfant(); findTotalChild(); findTotalAdult();">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
                                        <input type="text" name="arr_time" class="form-control" id="datetimepicker2" placeholder="Arrival time" required="required" style="width: 100%;">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id="returnDepartureTime" style="visibility:visible;">
                                    <div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
                                        <input type="text" name="rtn_dep_time" class="form-control" id="datetimepicker3"  placeholder="Return departure time" style="width: 100%;">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group" id="returnArrivalTime" style="visibility:visible;">
                                    <div class="controls input-append date form_datetime" data-date-format="yyyy-mm-dd h:i:s" data-link-field="dtp_input1">
                                        <input type="text" name="rtn_arr_time" class="form-control" id="datetimepicker4"  placeholder="Return arrival time" style="width: 100%;">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="ok" value="Add Fare" class="btn btn-primary">Add Fare</button>
                        <button type="reset" class="btn btn-primary">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {if $booking_no}
    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    <strong>General Information | <strong>Booking No : {$booking_no}</strong></strong>
                </div>
                <div class="panel-body">
                    <form role="form" action="booking.php?job=save" method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Flight Details</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <select class="form-control" id="way" onchange="ifReturn()" name="way" required placeholder="One way or Return" >
                                        {if $way}
                                            <option value="{$way}">{$way}</option>
                                        {else}
                                            <option value="" disabled selected>One way or Return</option>
                                        {/if}
                                        <option value="One Way">One Way</option>
                                        <option value="Return">Return</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <select class="form-control" name="dep_air_port" required placeholder="Departure Airport" >
                                        {if $arr_air_port}
                                            <option value="{$dep_air_port}">{$dep_air_port}</option>
                                        {else}
                                            <option value="" disabled selected>Departure Airport</option>
                                        {/if}
                                        {section name=dep_air_port loop=$air_port_names}
                                            <option value="{$air_port_names[dep_air_port]}">{$air_port_names[dep_air_port]}</option>
                                        {/section}
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <select class="form-control" name="arr_air_port" required placeholder="Arrival Airport" >
                                        {if $arr_air_port}
                                            <option value="{$arr_air_port}">{$arr_air_port}</option>
                                        {else}
                                            <option value="" disabled selected>Arrival Airport</option>
                                        {/if}
                                        {section name=arr_air_port loop=$air_port_names}
                                            <option value="{$air_port_names[arr_air_port]}">{$air_port_names[arr_air_port]}</option>
                                        {/section}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                                        <input type="text" name="dep_date" class="form-control" id="datepicker" value="{$dep_date}" required placeholder="Departure Date" style="width: 100%;">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group" id="returnDate" style="visibility:visible;">
                                    <div class="controls input-append date form_date" data-date-format="yyyy-mm-dd" data-link-field="dtp_input1">
                                        <input type="text" name="rtn_date" class="form-control" id="datepicker1" value="{$rtn_date}" readonly placeholder="Return Date" style="width: 100%;">
                                        <span class="add-on"><i class="icon-remove"></i></span>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" value="" />
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="adult" value="{$adult}" required placeholder="Adults">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="child" value="{$child}" placeholder="Child">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="infant" value="{$infant}" placeholder="Infant">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <select class="form-control" name="currency" required placeholder="Currency" >
                                        {if $currency}
                                            <option value="{$currency}">{$currency}</option>
                                        {else}
                                            <option value="" disabled selected>Currency</option>
                                        {/if}
                                        <option value="LKR">LKR</option>
                                        <option value="USD">USD</option>
                                        <option value="INR">INR</option>
                                        <option value="CHF">CHF</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label>Contact Details</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input class="form-control customer" name="customer" value="{$customer}" required placeholder="Name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <div class="form-group">
                                        <input class="form-control" name="mobile" value="{$mobile}" placeholder="Mobile">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="phone" value="{$phone}" placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input class="form-control" name="email" value="{$email}" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <textarea class="form-control" name="address" placeholder="Address" rows="2">{$address}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <textarea class="form-control" name="note" placeholder="Note" rows="2">{$note}</textarea>
                                </div>
                            </div>
                        </div>
                        {if $search=='On'}
                            <button type="submit" name="main_ok" value="Update" class="btn btn-primary">Update</button>
                        {else}
                            <button type="submit" name="main_ok" value="Save" class="btn btn-primary">Create Non Confirm</button>
                        {/if}
                        <button type="reset" class="btn btn-primary">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" style="margin-top: 10px;">
            <div class="panel panel-info" style="margin-top: 10px;">
                <div class="panel-heading">
                    <strong>Fare Details</strong>
                </div>
                <div class="panel-body">
                    {php}list_booking_has_items($_SESSION['booking_no']);{/php}
                </div>
            </div>
        </div>
    </div>
</section>
{/if}
{include file="footer.tpl"}
{literal}
    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker();
        });
    </script>
    <script>
        $(function () {
            $('#datetimepicker2').datetimepicker();
        });
    </script>
    <script>
        $(function () {
            $('#datetimepicker3').datetimepicker();
        });
    </script>
    <script>
        $(function () {
            $('#datetimepicker4').datetimepicker();
        });
    </script>
    <script>
        $(function () {
            $("#example1").DataTable();
        });
    </script>

{/literal}