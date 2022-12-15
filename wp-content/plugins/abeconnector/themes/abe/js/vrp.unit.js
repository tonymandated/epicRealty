/**
 * Unit Availability Check & Pricing Request/Breakdown
 */
var disabledDays, unitDataSource;

jQuery(document).ready(function () {

    /**
     * JavaScript applied to the unit.php VRPConnector theme file
     */
    unitDataSource = jQuery("#unit-data");

    /**
     * Determine if Unit Page Views module is enabled & log the page view if it is.
     */
    var displayPageViews = unitDataSource.data('display-pageviews');
    var unitId = unitDataSource.data('unit-id');

    if (displayPageViews == "true") {
        jQuery.get(url_paths.site_url, {vrpjax: true, act: "saveUnitPageView", par: unitId, cache: Math.random()});
    }

    jQuery("#checkbutton").click(function () {
        if (arrivalDateForm.val() != "" && departureDateForm.val() != "") {
            checkAvailability();
        }
    });

    var arrivalDateForm = jQuery("#check-availability-arrival-date");
    var departureDateForm = jQuery("#check-availability-departure-date");

    if (arrivalDateForm.length
      && arrivalDateForm.val() != ""
      && departureDateForm.length
      && departureDateForm.val() != "") {
        checkAvailability();
    }

    var unitSlug = unitDataSource.data('unit-slug');
    jQuery.get(url_paths.site_url + "/?vrpjax=1&act=getUnitBookedDates&par=" + unitSlug, function (data) {
        disabledDays = jQuery.parseJSON(data);

        var checkAvailArrival, checkAvailDeparture;

        if (jQuery("#check-availability-arrival-date").length > 0)
        {
            checkAvailArrival = jQuery("#check-availability-arrival-date").datepicker({
                minDate: 0,
                onSelect: function () {
                    var minimumDepartureDate = checkAvailArrival.datepicker('getDate');
                    minimumDepartureDate.setDate(minimumDepartureDate.getDate() + getMinLOS(minimumDepartureDate));
                    checkAvailDeparture.datepicker('setDate', minimumDepartureDate);
                    checkAvailDeparture.datepicker('option', 'minDate', minimumDepartureDate);
                },
                beforeShowDay: noCheckinOrBookedDates
            });

            checkAvailDeparture = jQuery("#check-availability-departure-date").datepicker({
                onSelect: function () {
               var arrivalDate=jQuery("#check-availability-arrival-date").datepicker("getDate");
                var departureDate=jQuery("#check-availability-departure-date").datepicker("getDate");
                var oneDay = 1000*60*60*24;
                var difference = Math.ceil((arrivalDate.getTime() - departureDate.getTime()) / oneDay);
                difference=-difference;

                jQuery("#nights").val(difference);
                jQuery("#tn").val(difference);

                if(difference >1) {
                    checkAvailability();
                }
                },
                beforeShowDay: noBookedDates
            })
        }
    });
});

function pad(n)
{
    return n < 10 ? '0' + n : n
}

function noCheckinOrBookedDates(date) {
    var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
    var today = new Date();
    var m2 = today.getMonth(), d2 = today.getDate(), y2 = today.getFullYear();
    var compare1 = y.toString() + pad(m.toString()) + pad(d.toString());
    var compare2 = y2.toString() + pad(m2.toString()) + pad(d2.toString());
    // console.log(compare2, compare1);

    for (var k = 0; k < disabledDays.noCheckin.length; k++) {
        if (jQuery.inArray((m + 1) + '-' + d + '-' + y, disabledDays.noCheckin) != -1 || compare2 > compare1) {
            //console.log('bad:  ' + (m + 1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
            return [false];
        }
    }

    return noBookedDates(date);
}

function noBookedDates(date) {
    var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
    var today = new Date();
    var m2 = today.getMonth(), d2 = today.getDate(), y2 = today.getFullYear();
    var compare1 = y.toString() + pad(m.toString()) + pad(d.toString());
    var compare2 = y2.toString() + pad(m2.toString()) + pad(d2.toString());
    // console.log('Checking (raw): ' + m + '-' + d + '-' + y);
    // console.log(compare2, compare1);

    for (var i = 0; i < disabledDays.bookedDates.length; i++) {
        if (jQuery.inArray((m + 1) + '-' + d + '-' + y, disabledDays.bookedDates) != -1 || compare2 > compare1) {
            // console.log('bad:  ' + (m + 1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
            return [false];
        }
    }

    // Turn days
    if (disabledDays.turnDays.length) {
        var matchedDateRange = false;
        var isTurnDay = false;
        var expression = new RegExp(/-/g);
        var dateFormatted = y.toString() + pad((m + 1).toString()) + pad(d.toString());
        disabledDays.turnDays.forEach(function (turnDay, i) {
            var start = turnDay.start_date.replace(expression, '');
            var end = turnDay.end_date.replace(expression, '');
            if (dateFormatted >= start && dateFormatted < end) {
                matchedDateRange = true;
                if (date.getDay() + disabledDays.turnDaysOffset == turnDay.day) {
                    isTurnDay = true;
                }
            }
        });
        if (matchedDateRange) {
            if (!isTurnDay) {
                return [false];
            }
        }
    }

    //console.log('good:  ' + (m + 1) + '-' + d + '-' + y);
    return [true];
}

function getMinLOS(arrival)
{
    for (i in disabledDays.minNights) {
        var minNight = disabledDays.minNights[i];
        var start = new Date(minNight.start);
        var end = new Date(minNight.end);

        if (arrival >= start && arrival <= end) {
            return minNight.minLOS;
        }
    }

    return disabledDays.minLOS;
}

function checkAvailability() {
    jQuery("#errormsg").hide();
    jQuery("#booklink").hide();
    jQuery("#ratebreakdown").hide();
    jQuery("#loadingicons").show();

    jQuery("#loadingicons").addClass('active');
    jQuery("#ratebreakdown").empty();
    jQuery.get(url_paths.site_url + "/?vrpjax=1&act=checkavailability&par=1", jQuery("#bookingform").serialize(), function (data) {
        var obj = jQuery.parseJSON(data);

        if (!obj.Error) {
            jQuery(".ratebreakdown").css("display", "block");
            jQuery("#loadingicons").hide();
            jQuery("#abe-quote-activator").show();
            jQuery("#loadingicons").removeClass('active');
            jQuery("#thetotal,#booklink").fadeIn();
            ratebreakdown(obj);
            jQuery("#checkbutton").fadeTo(500, 0.5);
            jQuery(".unitsearch").change(function () {
                //jQuery("#booklink").hide();
                jQuery("#errormsg").html('').hide();
                jQuery("#checkbutton").fadeTo(500, 1);
            });
            jQuery("#ratebreakdown").show();
        } else {
            jQuery("#abe-quote-activator").hide();
            jQuery("#errormsg").html('')
            jQuery("#loadingicons").hide();
            var theerror = '<div class="alert alert-error">' + obj.Error + '</div>';
            jQuery("#errormsg").html(theerror).show();

        }
    });
}

function ratebreakdown(obj) {
jQuery("#ratebreakdown").empty();
    var tbl = jQuery("#ratebreakdown");

    for (var i in obj.Charges) {
        if(obj.Charges[i].Amount > 0 && obj.Charges[i].Description == 'Rent') {
            var row = "<tr><td >" + obj.Charges[i].Description + "</td><td class='rate-breakdown-value'>$" + parseFloat(obj.Charges[i].Amount).toFixed(2) + "</td></tr>";
            tbl.append(row);
        }
    }

    if (obj.BookDetails) {
        for (i in obj.BookDetails.charges) {
            var row = "<tr><td >" + obj.BookDetails.charges[i].Description + "</td><td class='rate-breakdown-value'>$" + parseFloat(obj.BookDetails.charges[i].Amount).toFixed(2) + "</td></tr>";
            tbl.append(row);
        }
    }

    if(obj.TotalTax>0) {
        var tax = "<tr><td>Tax:</td><td class='rate-breakdown-value'>$" + parseFloat(obj.TotalTax).toFixed(2) + "</td></tr>";
        tbl.append(tax);
    }

    var total = '<tr class="double"><td><b>Total Cost :</b></td><td  class="rate-breakdown-value"><b>$' + (parseFloat(obj.TotalCost)).toFixed(2) + '</b></td></tr>';
    tbl.append(total);
    var totaldue = "<tr class='success'><td><b>Total Due Now:</b></td><td class='rate-breakdown-value'><b>$" + (parseFloat(obj.DueToday)).toFixed(2) + "</b></td></tr>";
    if(obj.DueToday !== obj.TotalCost) {
        // No sense in displaying something that says 'Due Now' if it isn't less than the total cost.

        tbl.append(totaldue);
    }

    if(obj.PromoCodeDiscount) {
        var promoCodeDiscount = "<tr><td colspan='2'>" + obj.PromoCodeDiscount.text + "</td></tr>" +
            "<tr><td>Total Savings:</td><td class='rate-breakdown-value'>$" + obj.PromoCodeDiscount.value + "</td></tr>";
        tbl.append(promoCodeDiscount);
    }

    if (obj.Arrival) {
        var day = getDayFromDate(obj.Arrival);
    } else {
        var day = getDayFromDate(obj.arrival);
    }

    if (jQuery('.abe-quote-info').length > 0) {
        if (obj.Arrival) {
            var day = getDayFromDate(obj.Arrival);
        } else {
            var day = getDayFromDate(obj.arrival);
        }
       
        var quoteText = `${day} ${obj.Arrival ? obj.Arrival : obj.arrival } <br> <span>$${addCommas(parseFloat(obj.TheRentalRate).toFixed(2))}</span> + <sup>tax/fees</sup>`;
        jQuery('.abe-quote-info').html(quoteText)
    }
    
    var quoteText = `${day} ${obj.Arrival ? obj.Arrival : obj.arrival } <br> <span>$${addCommas(parseFloat(obj.TheRentalRate).toFixed(2))}</span> + <sup>tax/fees</sup>`;
    jQuery('.ratebreakdown-quote').html(quoteText);
}

function getDayFromDate(date)
{
    var d = new Date(date);

    var weekday = new Array(7);
    weekday[0] = "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";
    return weekday[d.getDay()];
}

function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function getDayFromDate(date)
{
    var d = new Date(date);

    var weekday = new Array(7);
    weekday[0] = "Sunday";
    weekday[1] = "Monday";
    weekday[2] = "Tuesday";
    weekday[3] = "Wednesday";
    weekday[4] = "Thursday";
    weekday[5] = "Friday";
    weekday[6] = "Saturday";
    addCommas
    return weekday[d.getDay()];
}

/**
 * Google Map
 */

function initializeGoogleMap() {
    var geocoder = new google.maps.Geocoder();
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: 13,
        scrollwheel: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var unitLatitude = unitDataSource.data("unit-latitude");
    var unitLongitude = unitDataSource.data("unit-longitude");

    if (unitLatitude && unitLongitude) {
        console.log('lat long');
        /**
         * Latitude & Longitude are present - Use this data for mapping *
         */
        var unitMapPinLocation = new google.maps.LatLng(unitLatitude, unitLongitude);
        map.setCenter(unitMapPinLocation);

        new google.maps.Marker({
            map: map,
            position: unitMapPinLocation
        });
    } else {
        console.log('address');
        /**
         * No lat/long present - Use address for mapping
         */
        var fullUnitAddress = unitDataSource.data("unit-address1")
//                + " " + unitDataSource.data("unit-address2")
            + " " + unitDataSource.data("unit-city")
            + " " + unitDataSource.data("unit-state")
            + " " + unitDataSource.data("unit-zip");
        console.log(fullUnitAddress);

        geocoder.geocode({'address': fullUnitAddress}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            }
        });
    }
}

jQuery(document).ready(function () {
    // Unit Page Tabs
    unitTabs = jQuery("#vrp-tabs").tabs();

    //Unit Photo Gallery



        // jQuery('#vrp-slider').lightSlider({
        //     gallery:true,
        //     item:1,
        //     thumbItem:9,
        //     slideMargin: 0,
        //     speed:300,
        //     loop:true,
        //     pager:true,
        //     thumbItem: 9,
        //     pause: 5000,

        // });




    jQuery("#vrpinquire").submit(function () {
        jQuery("#iqbtn").attr("disabled", "disabled");
        jQuery.post(url_paths.site_url + "/?vrpjax=1&act=custompost&par=addinquiry", jQuery(this).serialize(), function (data) {
            var obj = jQuery.parseJSON(data);
            if (obj.success) {
                jQuery("#vrpinquire").replaceWith("Thank you for your inquiry!");
            } else {
                var item;
                var thetotal = obj.err.length - 1;
                for (i = 0; i <= thetotal; i++) {
                    item = obj.err[i];
                    /// alert(item.name);
                    jQuery("#i" + item.name).append("<span class='errormsg'>" + item.msg + "</span>");
                }
                jQuery("#iqbtn").removeAttr("disabled");
            }
        });
        return false;
    });

    jQuery("#gmaplink").on('click', function () {
        initializeGoogleMap();
    });

    jQuery("#icheckinput").datepicker();


    jQuery( window ).resize(function() {

            jQuery("#vrp").width() < 950 ? jQuery("#vrp").addClass('vrp-small') : jQuery("#vrp").removeClass('vrp-small');


        });
    jQuery("#vrp").width() < 950 ? jQuery("#vrp").addClass('vrp-small') : jQuery("#vrp").removeClass('vrp-small');
});
