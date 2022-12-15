let shippingInfoTracked = false, paymentInfoTracked = false;
let analytics = {
	arrival: false,
	departure: false,
	range: false,
	nights: false,
	value: false,
	units: []
};
(function($, global, undefined) {
    $(function () {
    	// Get details about their search/selection
    	var arrival = $('#arrival').val();
    	var departure = $('#depart').val();
    	if (typeof arrival == 'string' && arrival.length) {
    		analytics.arrival = arrival;
	    	if (departure.length) {
	    		analytics.departure = departure;
	    		var arrivalDate = new Date(arrival);
	    		var departureDate = new Date(departure);
	    		var range = arrivalDate.toISOString().split('T')[0] + ':' + departureDate.toISOString().split('T')[0];
                analytics.range = range;
                var oneDay = 1000 * 60 * 60 * 24;
                var nights = Math.abs(Math.ceil((arrivalDate.getTime() - departureDate.getTime()) / oneDay));
                analytics.nights = nights;
	    	}
		} else {
			// unit scope
	    	var arrival = $('#check-availability-arrival-date').val();
	    	var departure = $('#check-availability-departure-date').val();
	    	if (typeof arrival == 'string' && arrival.length) {
	    		analytics.arrival = arrival;
		    	if (departure.length) {
		    		analytics.departure = departure;
		    		var arrivalDate = new Date(arrival);
		    		var departureDate = new Date(departure);
		    		var range = arrivalDate.toISOString().split('T')[0] + ':' + departureDate.toISOString().split('T')[0];
	                analytics.range = range;
	                var oneDay = 1000 * 60 * 60 * 24;
	                var nights = Math.abs(Math.ceil((arrivalDate.getTime() - departureDate.getTime()) / oneDay));
	                analytics.nights = nights;
		    	}
		    } else {
				// booking scope
		    	var arrival = $('input[name="booking[arrival]"]').val();
		    	var departure = $('input[name="booking[depart]"]').val();
		    	if (typeof arrival == 'string' && arrival.length) {
		    		analytics.arrival = arrival;
			    	if (departure.length) {
			    		analytics.departure = departure;
			    		var arrivalDate = new Date(arrival);
			    		var departureDate = new Date(departure);
			    		var range = arrivalDate.toISOString().split('T')[0] + ':' + departureDate.toISOString().split('T')[0];
		                analytics.range = range;
		                var oneDay = 1000 * 60 * 60 * 24;
		                var nights = Math.abs(Math.ceil((arrivalDate.getTime() - departureDate.getTime()) / oneDay));
		                analytics.nights = nights;
			    	}
			    }
		    }
		}

		if ($('.abe-results .abe-item').length > 0) {
			// view_item_list
			analytics.units = [];
			$('.abe-results .abe-item').each(function (i, item) {
				var unit = $(item);
				analytics.units.push({
					item_id: unit.data('vrp-property-code'),
					item_name: unit.data('vrp-name'),
					affiliation: 'Reservations',
					index: unit.data('vrp-index'),
					item_brand: unit.data('vrp-type'),
					item_category: unit.data('vrp-beds') + ' Bedrooms',
					item_category2: unit.data('vrp-baths') + ' Bathrooms',
					item_category3: 'Sleeps ' + unit.data('vrp-sleeps'),
					item_category4: analytics.range,
					item_category5: analytics.nights ? (analytics.nights + ' Nights') : false
				});
			});
			updateDataLayer('view_item_list');

			$('.abe-results .abe-item a').click(function (e) {
				//select_item
				var unit = $(this).closest('.abe-item');
				analytics.units = [];
				analytics.units.push({
					item_id: unit.data('vrp-property-code'),
					item_name: unit.data('vrp-name'),
					affiliation: 'Reservations',
					index: unit.data('vrp-index'),
					item_brand: unit.data('vrp-type'),
					item_category: unit.data('vrp-beds') + ' Bedrooms',
					item_category2: unit.data('vrp-baths') + ' Bathrooms',
					item_category3: 'Sleeps ' + unit.data('vrp-sleeps'),
					item_category4: analytics.range,
					item_category5: analytics.nights ? (analytics.nights + ' Nights') : false
				});
				updateDataLayer('select_item');
			});
		}

		if ($('.abe.abe-unit').length > 0) {
			var unit = $('.abe.abe-unit .abe-unit-info');
			analytics.units = [];
			analytics.units.push({
				item_id: unit.data('unit-property-code'),
				item_name: unit.data('unit-name'),
				affiliation: 'Reservations',
				index: unit.data('unit-index'),
				item_brand: unit.data('unit-type'),
				item_category: unit.data('unit-beds') + ' Bedrooms',
				item_category2: unit.data('unit-baths') + ' Bathrooms',
				item_category3: 'Sleeps ' + unit.data('unit-sleeps'),
				item_category4: analytics.range,
				item_category5: analytics.nights ? (analytics.nights + ' Nights') : false
			});
			updateDataLayer('view_item');

			$('*#booklink').click(function (e) {
				var price = parseFloat($('#ratebreakdown .double .rate-breakdown-value').html().replace(new RegExp(/[^0-9.]/g), '')) / analytics.nights;
				analytics.units[0].currency = 'USD';
				analytics.units[0].price = Math.round((price + Number.EPSILON) * 100) / 100;
				analytics.units[0].quantity = analytics.nights;
				updateDataLayer('add_to_cart');
			});
		}

		$('.abe-favorite:not(.active').click(function () {
			// double check .active
			if (!$(this).hasClass('active')) {
				// todo
			}
		});

		if ($('#vrpbookform').length > 0) {
			analytics.units = [];
			var unit = $('#vrpbookform');
			var price = parseFloat($('input[name="booking[TotalCost]"]').val()) / analytics.nights;
			analytics.units.push({
				item_id: unit.data('unit-property-code'),
				item_name: unit.data('unit-name'),
				affiliation: 'Reservations',
				item_brand: unit.data('unit-type'),
				item_category: unit.data('unit-beds') + ' Bedrooms',
				item_category2: unit.data('unit-baths') + ' Bathrooms',
				item_category3: 'Sleeps ' + unit.data('unit-sleeps'),
				item_category4: analytics.range,
				item_category5: analytics.nights ? (analytics.nights + ' Nights') : false,
				currency: 'USD',
				price: Math.round((price + Number.EPSILON) * 100) / 100,
				quantity: analytics.nights
			});
			updateDataLayer('begin_checkout');

			// shipping info (personal information)
			$('#vrpbookform input, #vrpbookform select').change(function () {
				var requiredFields = {
					'fname': 'input',
					'lname': 'input',
					'address': 'input',
					'city': 'input',
					'state': 'select',
					'zip': 'input',
					'country': 'select',
					'phone': 'input',
					'email': 'input'
				};
				var valid = 0;
				for (name in requiredFields) {
					var field = $(requiredFields[name] + '[name="booking[' + name + ']"]');
					if (field.val().replace(new RegExp(/[\s\r\t\n]+/g)).length > 0) valid++;
				}
				if (Object.keys(requiredFields).length == valid && !shippingInfoTracked) {
					shippingInfoTracked = true;
					analytics.value = parseFloat($('input[name="booking[TotalCost]"]').val());
					updateDataLayer('add_shipping_info');
				}

				if (shippingInfoTracked) {
					var requiredFields = {
						'ccNumber': 'input',
						'cvv': 'input',
						'expMonth': 'select',
						'expYear': 'select'
					};
					var valid = 0;
					for (name in requiredFields) {
						var field = $(requiredFields[name] + '[name="booking[' + name + ']"]');
						if (field.val().replace(new RegExp(/[\s\r\t\n]+/g)).length > 0) valid++;
					}
					if (Object.keys(requiredFields).length == valid && !paymentInfoTracked) {
						paymentInfoTracked = true;
						updateDataLayer('add_payment_info');
					}
				}
			});
		}

		function updateDataLayer(event)
		{
			dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
			switch (event) {
				case 'view_item_list':
					dataLayer.push({
						event: event,
    					ecommerce: {
    						items: analytics.units
    					}
					});
					break;

				case 'select_item':
					dataLayer.push({
						event: event,
    					ecommerce: {
    						items: analytics.units
    					}
					});
					break;

				case 'view_item':
					delete analytics.units[0].index;
					dataLayer.push({
						event: event,
    					ecommerce: {
    						items: analytics.units
    					}
					});
					break;

				case 'add_to_cart':
					delete analytics.units[0].index;
					dataLayer.push({
						event: event,
    					ecommerce: {
    						items: analytics.units
    					}
					});
					break;

				case 'begin_checkout':
					delete analytics.units[0].index;
					dataLayer.push({
						event: event,
    					ecommerce: {
    						items: analytics.units
    					}
					});
					break;

				case 'add_shipping_info':
					delete analytics.units[0].index;
					dataLayer.push({
						event: event,
    					ecommerce: {
    						// currency: 'USD',
    						// value: analytics.value,
    						items: analytics.units
    					}
					});
					break;

				case 'add_payment_info':
					delete analytics.units[0].index;
					dataLayer.push({
						event: event,
    					ecommerce: {
    						// currency: 'USD',
    						// value: analytics.value,
    						items: analytics.units
    					}
					});
					break;
			}

		}
	});
}(jQuery, window));