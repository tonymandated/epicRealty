(function($, global, undefined){
    /* Handles */
    $(function(){

        $('.vrpshowing').change(function() {

            var that = $(this);

            if(that.val() == '') {
                return;
            }

            location.search = VRP.queryString.formatQueryString(that.val());

        });

        $('.vrpsorter').change(function() {

            var that = $(this);

            if(that.val() == '') {
                return;
            }

            location.search = VRP.queryString.formatQueryString(that.val());
        });


        $('.vrpsorter').change(function() {

            var that = $(this);

            if(that.val() == '') {
                return;
            }

            location.search = VRP.queryString.formatQueryString(that.val());
        });

        $('.vrp-cd-pagination a').click(function(e){

            e.preventDefault();

            var that = $(this),
                parameters = that.attr('href');

            if(that.hasClass('current') || that.hasClass('disabled')) {
                return;
            }

            location.search = VRP.queryString.formatQueryString(parameters);

        });

        $('.vrp-thumbnail').hover(function(e){

            var that = $(this).parent(),
                index = $('.vrp-item').index(that);

            VRP.ui.overlay(that, index, e);

        }, function(e) {

            var that = $(this).parent(),
                index = $('.vrp-item').index(that);

            VRP.ui.overlay(that, index, e);

        });

        $('#vrp-list').click(function(e) {
            e.preventDefault();
            $('.list-grid-layout').attr('class', 'col-xs-12 list-grid-layout vpr-list-style');
        });

        $('#vrp-grid').click(function(e){
            e.preventDefault();
            $('.list-grid-layout').attr('class', 'col-md-4 col-xs-6 col-sm-12 vpr-list-grid-layout vpr-grid-style');
        });

    });
}(jQuery, window));
 var fav_count='';
jQuery(document).ready(function(){

    // VrpUnitLinks
    if (jQuery('.abe-unit-links').length > 0) {
        if (jQuery('.abe-unit-links').length) {
            jQuery('.abe-unit-links').select2();

            jQuery('.abe-unit-links').change(function(){
                window.location.href = jQuery(this).val();
            });
        }
    }

    // Price Range event trigger
    if (jQuery('#abeFromRange').length > 0) {
        jQuery('#abeFromRange').on('change', function(e){
            jQuery('#abe-results-search').submit();
        });

        jQuery('#abeToRange').on('change', function(e){
            jQuery('#abe-results-search').submit();
        });
    }

if(jQuery( 'input[name="search[arrival]"]' ).length>0) {
    var dates = jQuery('input[name="search[arrival]"]' ).datepicker({
        beforeShow: customRange,
        minDate: 2,
        onSelect: function (selectedDate) {

            var option = this.id == "arrival" ? "minDate" : "30",
                instance = jQuery(this).data("datepicker"),
                date = jQuery.datepicker.parseDate(
                    instance.settings.dateFormat ||
                    jQuery.datepicker._defaults.dateFormat,
                    selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        },
        onClose: function () {
            var departField = jQuery('input[name="search[departure]"]');
            var nextDayDate = jQuery('input[name="search[arrival]"]').datepicker('getDate');
            if (nextDayDate !== null) {
                nextDayDate.setDate(nextDayDate.getDate() + 7);
                departField.datepicker('setDate', nextDayDate);
                setTimeout(function () {
                    departField.datepicker("show");
                }, 10);
            }
        }


    });


    jQuery('input[name="search[departure]"]').datepicker({
         beforeShow: customRange,
        onSelect: function () {
            var arrivalDate=jQuery('input[name="search[arrival]"]').datepicker("getDate");
            var departureDate=jQuery('input[name="search[departure]"]').datepicker("getDate");
            var oneDay = 1000*60*60*24;
            var difference = Math.ceil((arrivalDate.getTime() - departureDate.getTime()) / oneDay);
            difference=-difference;

            jQuery("#nights").val(difference);
            jQuery("#tn").val(difference);
        }
    });
}
    function customRange(a) {
        var b = new Date();
        var c = new Date(b.getFullYear(), b.getMonth(), b.getDate());
        if (a.id == 'depart') {
            if (jQuery('input[name="search[arrival]"]').datepicker('getDate') != null) {
                c = jQuery('input[name="search[arrival]"]').datepicker('getDate');
            }
        }
        return {
            minDate: c
        }
    }

    jQuery('.hasDatepicker').attr("autocomplete", "off").attr("readonly", "readonly");

    jQuery("#bookmsg").hide();

    if (jQuery("#unitsincomplex").length > 0){
        if (jQuery("#hassession").length > 0){
            jQuery.get(url_paths.site_url + "/?vrpjax=1&act=searchjax",jQuery("#jaxform").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).fadeIn();
            });
        }else{
            jQuery.get(url_paths.site_url + "/?vrpjax=1&act=searchjax",jQuery("#jaxform2").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).fadeIn();
            });
        }
        jQuery("#jaxform").submit(function(){
            jQuery.get(url_paths.site_url + "/?vrpjax=1&act=searchjax",jQuery("#jaxform").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).slideDown(1000);
            });
            return false;
        });

        jQuery("#showallofthem").click(function(){
            jQuery.get(url_paths.site_url + "/?vrpjax=1&act=searchjax",jQuery("#jaxform2").serialize(),function(data){
                jQuery("#unitsincomplex").hide().html(data).slideDown(1000);
            });
            return false;
        });
    }


    /** Step3.php **/
    jQuery("#country").on('change', function(){

        var country =jQuery(this).find(":selected").val();
        console.log(country);

        if (country == 'CA' || country == 'US' || country == 'other'){
            if (country == 'CA'){
                jQuery("#abe-state-wrapper select").val('');
                jQuery("#abe-province-wrapper").show();
                jQuery("#abe-othercountry-wrapper,#abe-region-wrapper,#abe-state-wrapper").hide();
                jQuery("#abe-province-wrapper").effect("highlight", {}, 2000);
            }

            if (country == 'US'){
                jQuery("#abe-province-wrapper select,#abe-region-wrapper select").val('');
                jQuery("#abe-state-wrapper").show();
                jQuery("#abe-othercountry-wrapper,#abe-region-wrapper,#abe-province-wrapper").hide();
                jQuery("#abe-state-wrapper").effect("highlight", {}, 2000);
            }

            if (country == 'other'){
                jQuery("#abe-province-wrapper select,#abe-state-wrapper select").val('');
                jQuery("#abe-province-wrapper,#abe-state-wrapper").hide();
                jQuery("#abe-othercountry-wrapper,#abe-region-wrapper").show();
                jQuery("#abe-othercountry-wrapper,#abe-region-wrapper").effect("highlight", {}, 2000);
            }
        }else{
            jQuery("#abe-province-wrapper select,#abe-state-wrapper select, #abe-othercountry-wrapper select").val('');
            jQuery("#abe-province-wrapper,#abe-state-wrapper,#abe-othercountry-wrapper").hide();
            jQuery("#abe-region-wrapper").show();
            jQuery("#abe-region-wrapper").effect("highlight", {}, 2000);
        }

    });

    jQuery("#vrpbookform").submit(function(){

        var bookform = jQuery(this);
        grecaptcha.ready(function() {
            grecaptcha.execute(url_paths.recaptcha_site_key, {action: 'booking'}).then(function(token) {
                bookform.find( ".g-recaptcha-response" ).val( token );

                jQuery("#bookingbuttonvrp").hide();
                jQuery("#vrploadinggif").show();
                jQuery("span.vrpmsg").remove();
                jQuery(".badfields").removeClass("badfields");
                jQuery("#comments").val(jQuery("#comments").val());
                jQuery.post(url_paths.site_url + "/?vrpjax=1&act=processbooking", bookform.serialize(), function(data){

                    console.log(data);

                    var obj=jQuery.parseJSON(data);
                    if (typeof(obj.Error) !== 'undefined' && obj.Error.length != 0) {
                        jQuery("#bookingbuttonvrp").show();
                        jQuery("#vrploadinggif").hide();
                        alert(obj.Error);
                    } else if (obj.Bad.length != 0){
                        jQuery("#bookingbuttonvrp").show();
                        jQuery("#vrploadinggif").hide();
                        jQuery.each(obj.Bad,function(k,v){
                            jQuery("#" + k + "tr td:last").append('<span class="vrpmsg alert alert-error">' + v + '</span>');
                            var oldcolor=jQuery("#" + k + "tr").css("color");
                            jQuery("#" + k + "tr").addClass("badfields");
                            jQuery("#" + k).change(function(){
                                jQuery("#" + k + "tr").removeClass("badfields");
                                jQuery("#" + k + "tr td span.vrpmsg").remove();
                            });
                        });
                        jQuery("html, body").animate({
                            scrollTop: 0
                        }, "slow",function(){});
                        alert("Please correct the errors with your reservation and try again.");

                    } else {
                        window.location=jQuery("#vrpbookform").attr("action");
                    }

                });
            });
        });
        return false;
    });

    jQuery("#showContract").on('click', function(event) {
        event.preventDefault();
        jQuery('#theContract').show();
    });

    jQuery('#closeContract').on('click', function(event) {
        event.preventDefault();
        jQuery('#theContract').hide();
    });


    /** OTHER **/
    jQuery(".dpinquiry").datepicker();

    jQuery(".vrp-pagination li a,.dobutton").button();
});

const checkOffset = jQuery.datepicker._checkOffset;
jQuery.extend(jQuery.datepicker, {
    _checkOffset: function (inst, offset, isFixed) {
        if (!isFixed) {
            return checkOffset.apply(this, arguments);
        }        let isRTL = this._get(inst, "isRTL");
        let obj = inst.input[0];        // copied from Datepicker._findPos (node_modules/jquery-ui/datepicker.js)
        while (obj && (obj.type === "hidden" || obj.nodeType !== 1 || jQuery.expr.filters.hidden(obj))) {
            obj = obj[isRTL ? "previousSibling" : "nextSibling"];
        }        let rect = obj.getBoundingClientRect();        // copied from Datepicker._checkOffset
        var viewHeight = document.documentElement.clientHeight + (isFixed ? 0 : jQuery(document).scrollTop()),
            dpHeight = inst.dpDiv.outerHeight();        return {
            // added validation for when the date picker is displayed at the bottom
            top: viewHeight < rect.top + rect.height + dpHeight ? rect.top - dpHeight : rect.top + rect.height,
            left: rect.left
        };
    }
});

