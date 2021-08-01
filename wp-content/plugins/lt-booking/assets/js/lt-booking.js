"use strict";

jQuery(document).on('ready', function() { 

	setTimeout(function() {

		if ( jQuery('.ltb-cars').length ) {

			var carsSwiper = document.querySelector('.ltb-cars').swiper;

			carsSwiper.on('slideChange', function() {

				ltbTariffsRefresh(carsSwiper.realIndex);
				ltbServicesRefresh(carsSwiper.realIndex);
				ltbRecountTotal();
			});

			ltbTariffsRefresh(0);
			ltbServicesRefresh(0);
			ltbRecountTotal();

			ltbEvents();
			ltbCalendar();
			ltbCalendarInit();
			ltbStripe();
		}
	}, 500);
});

jQuery(window).on("resize", function () {

	if ( jQuery('.ltb-cars').length ) {

		ltbCalendar();
	}
});

function ltbCalendar() {

	var ww = jQuery(window).width(),
		wh = jQuery(window).height(),
		pp = 3,
		max = jQuery('.ltb-calendar').data('days-limit');

	if ( !jQuery('.ltb-calendar').data('offset' ) ) {

		jQuery('.ltb-calendar').data('offset', 0);
	}

	var offset = jQuery('.ltb-calendar').data('offset');

	jQuery('.ltb-calendar').data('pp', pp);

	if ( max > 7 && ww >= 992 ) {

		pp = 7;

		jQuery('.ltb-calendar-nav').addClass('visible');
		jQuery('.ltb-calendar').data('pp', pp);
		ltbCalendarNav( pp, offset, max );
	}	
		else
	if ( ww < 992 ) {

		pp = 3;
		jQuery('.ltb-calendar-nav').addClass('visible');
		ltbCalendarNav( pp, offset, max );
	}
		else {

		jQuery('.ltb-calendar-nav').removeClass('visible');

		jQuery('.ltb-calendar tbody td, .ltb-calendar thead th').show();
	}

}

function ltbCalendarNav( pp, offset, max ) {

	if ( offset == 0 ) jQuery('.ltb-calendar-left').addClass('disabled'); else jQuery('.ltb-calendar-left').removeClass('disabled');
	if ( offset == max - pp ) jQuery('.ltb-calendar-right').addClass('disabled'); else jQuery('.ltb-calendar-right').removeClass('disabled');

	jQuery('.ltb-calendar tbody td').each(function(i, el) {

		if ( i < offset || i >= offset + pp ) {

			jQuery(el).removeClass('visible').hide();	
		}
			else {

			jQuery(el).addClass('visible').show();
		}
	});

	jQuery('.ltb-calendar thead th').each(function(i, el) {

		if ( i < offset || i >= offset + pp ) {

			jQuery(el).removeClass('visible').hide();	
		}
			else {

			jQuery(el).addClass('visible').show();
		}
	});			

	var first_current = jQuery('.ltb-calendar thead .visible').first().data('current'),
		last_current = jQuery('.ltb-calendar thead .visible').last().data('current'),
		current = first_current;

	if ( current != last_current ) {

		current += ' / ' + last_current;
	}

	jQuery('.ltb-calendar-nav .ltb-current-month').html(current);
}

function ltbCalendarInit() {

	jQuery('.ltb-slots-left').each(function(i, e) {

		var total = jQuery(e).data('total'),
			booked = jQuery(e).data('booked'),
			out = '';

			out += '<span class="ltb-free">';
			for ( var x = 1; x <= total; x++ ) {

				if ( x > (total - booked) ) {

					out += '<span class="disabled"></span>';
				} 
					else {

					out += '<span></span>';
				}
			}
			out += '</span>';

			jQuery(e).html(out);
	})

	jQuery('.ltb-calendar-nav').on('click', 'a', function() {

		var offset = jQuery('.ltb-calendar').data('offset'),
			max = jQuery('.ltb-calendar').data('days-limit'),
			pp = jQuery('.ltb-calendar').data('pp');

		if ( jQuery(this).hasClass('ltb-calendar-left') ) {

			jQuery('.ltb-calendar').data('offset', offset - 1);
		}

		if ( jQuery(this).hasClass('ltb-calendar-right') ) {

			jQuery('.ltb-calendar').data('offset', offset + 1);
		}

		if ( jQuery('.ltb-calendar').data('offset') < 0 ) jQuery('.ltb-calendar').data('offset', 0);
		if ( jQuery('.ltb-calendar').data('offset') > (max - pp) ) jQuery('.ltb-calendar').data('offset', max - pp);

		ltbCalendar();
		
		return false;
		
	});	
}

function ltbTariffsRefresh(index) {

	var tariffsContainer = jQuery('.ltb-step-02'),
		tariffs = jQuery('.ltb-cars .swiper-wrapper').data('tariffs');

	tariffsContainer.find('.ltb-tariff-wrapper').hide();

	if ( tariffs[index].length ) {

		jQuery.each(tariffs[index], function(i, el) {

			tariffsContainer.find('.ltb-tariff-id-' + el).show();
		});
	}
}

function ltbServicesRefresh(index) {

	var servicesContainer = jQuery('.ltb-step-03'),
		services = jQuery('.ltb-cars .swiper-wrapper').data('services');

	servicesContainer.find('.ltb-service-wrapper').show();

	if ( services[index] ) {

		servicesContainer.find('.ltb-service-wrapper').hide();
		jQuery.each(services[index], function(i, el) {

			servicesContainer.find('.ltb-service-id-' + el).show();
		});
	}
		else {

		servicesContainer.find('.ltb-service-wrapper').show();
	}
}

function ltbEvents() {

	var tariffsContainer = jQuery('.ltb-step-02'),
		servicesContainer = jQuery('.ltb-step-03'),
		datesContainer = jQuery('.ltb-step-04'),
		step = jQuery('.ltb-calendar').data('step-minutes');


	jQuery(".service-count").wrap('<span class="ltb-service-count-wrap"></span>');

	tariffsContainer.on('click', '.btn', function() {

		var sel = jQuery(this).data('selected'),
			unsel = jQuery(this).data('unselected');

		tariffsContainer.find('.btn').removeClass('tariff-active').find('.ltx-btn-inner > .ltx-txt').html(unsel);

		jQuery(this).addClass('tariff-active').find('.ltx-btn-inner > .ltx-txt').html(sel);
		jQuery('.ltb-time.active').removeClass('active');

		ltbRecountTotal();

		return false;
	});

	jQuery(document).on('input', '.service-count', function(event) {

		var count = jQuery(event.target).val();

		if ( count > 1 ) {

			jQuery(event.target).closest('.ltb-service').addClass('active');
		}
			else {

			jQuery(event.target).closest('.ltb-service').removeClass('active');
			jQuery(event.target).val(1)
		}

		ltbRecountTotal();
	});
	
	servicesContainer.on('click', '.ltb-service', function(event) {

		if ( jQuery(event.target).prop("tagName") == 'INPUT' ) return true;

		jQuery(this).toggleClass('active');

		if ( jQuery(this).hasClass('btn') && jQuery(this).hasClass('active') ) {

			jQuery(this).find('.ltx-txt').html(jQuery(this).data('selected'));
		}
			else
		if ( jQuery(this).hasClass('btn') ) {

			jQuery(this).find('.ltx-txt').html(jQuery(this).data('unselected'));
		}

		jQuery('.ltb-time.active').removeClass('active');

		ltbRecountTotal();

		return false;
	});

	datesContainer.on('click', '.ltb-time:not(.disabled)', function() {

		var duration = parseInt(jQuery('#ltb-duration').val()),
			curTime = parseInt(jQuery(this).data('stamp')),
			nextTime = curTime + (duration * 60),

			freeTime = 1;

		// Checking a duration to the next free period
		jQuery.each(jQuery(this).nextAll(), function(i, el) {

			if ( parseInt(jQuery(el).data('stamp')) >= nextTime ) {

				return false;
			}

			if ( jQuery(el).hasClass('disabled')) {

				alert(jQuery('.ltb-calendar').data('exceed'));
				freeTime = 0;
				return false;
			}
		});

		if ( freeTime == 1 ) {

			datesContainer.find('.active').removeClass('active');
			jQuery(this).addClass('active');


			ltbRecountTotal();
		}

		return false;
	});	

	jQuery('#ltb-booking-form').on('submit', ltbFormSubmit);
	jQuery('#ltb-form-submit').on('click', ltbFormValidate);
}

function ltbRecountTotal() {

	var carsSwiper = document.querySelector('.ltb-cars').swiper,
		carsInfo = jQuery('.ltb-cars .swiper-wrapper').data('cars'),
		carActive = carsInfo[carsSwiper.realIndex],
		tariffActive = jQuery('.ltb-step-02 .tariff-active'),
		timeActive = jQuery('.ltb-step-04 .ltb-time.active'),
		tariffTime = tariffActive.data('time'),
		tariffPrice = tariffActive.data('price'),
		serviceActive = jQuery('.ltb-step-03 .ltb-service.active'),
		ltbGrid = jQuery('.ltb-grid'),
		servicesList = '',
		servicesArray = [],
		servicesArrayCount = [],
		servCount = 1,
		totalTime = 0,
		totalPrice = 0,
		totalTimeVal = 0,
		totalPriceVal = 0,
		active = true,
		thd_sep = jQuery('.ltb-grid').data('thd-sep');

	if ( serviceActive.length ) {

		serviceActive.each(function(i, el) {

			var servCount = jQuery(el).find('.service-count').val();
			if ( servCount === undefined ) servCount = 1;

			totalTime += parseInt(jQuery(el).data('time'));
			var servPrice = parseFloat(jQuery(el).data('price'));
			totalPrice +=  ( servPrice * servCount ) ;
			servicesList += '<li>' + jQuery(el).data('title') + '</li>';
			servicesArray.push(jQuery(el).data('id'));

			servicesArrayCount.push(servCount);
		});
	}

	if ( !isNaN(tariffTime) ) {
		
		totalTime += parseInt(tariffTime);
		totalPrice += parseFloat(tariffPrice);
	}

	jQuery('.ltb-booking-type .ltb-value').html(carActive.header);

	if ( jQuery('.ltb-section.ltb-step-02').length || jQuery('.ltb-section.ltb-step-03').length ) {

		if ( tariffActive.length || serviceActive.length ) {

			jQuery('.ltb-booking-plan .ltb-value').html(tariffActive.data('title')).closest('.ltb-grid-item').removeClass('ltb-placeholder');
		}
			else {

			jQuery('.ltb-booking-plan .ltb-value').html(ltbGrid.data('plan-placeholder')).closest('.ltb-grid-item').addClass('ltb-placeholder');
			active = false;
		}
	}

	if ( servicesList.length ) {

		jQuery('.ltb-booking-plan .ltb-additional').show();
		jQuery('.ltb-booking-plan .ltb-list').html(servicesList);
	}
		else {

		jQuery('.ltb-booking-plan .ltb-additional').hide();
	}

	jQuery('.ltb-booking-date .ltb-value').html(timeActive.data('date'));
	jQuery('.ltb-booking-time .ltb-value').html(timeActive.data('time'));


	if ( jQuery('.ltb-section.ltb-step-04').length ) {

		if ( timeActive.length ) {

			jQuery('.ltb-booking-time .ltb-value').closest('.ltb-grid-item').removeClass('ltb-placeholder');
			jQuery('.ltb-booking-date .ltb-value').closest('.ltb-grid-item').removeClass('ltb-placeholder');
		}
			else {

			jQuery('.ltb-booking-time .ltb-value').html(ltbGrid.data('time-placeholder')).closest('.ltb-grid-item').addClass('ltb-placeholder');
			jQuery('.ltb-booking-date .ltb-value').html(ltbGrid.data('time-placeholder')).closest('.ltb-grid-item').addClass('ltb-placeholder');
			active = false;
		}
	}

	if ( isNaN(totalTime) ) {

		totalTime = '-';
		totalTimeVal = 0;
	}
		else {

		totalTimeVal = totalTime;

		if ( ltbGrid.data('hours-mode') == 1 ) {

			totalTime = convertMinsToHrsMins(totalTime);
		}
			else {

			totalTime +=  ' ' + ltbGrid.data('minutes');
		}
	}

	if ( isNaN(totalPrice) ) {

		totalPrice = '-';
		totalPriceVal = 0;
	}
		else {

		totalPrice = Math.round(totalPrice*100) / 100;
		totalPriceVal = totalPrice;

		jQuery('#ltb-amount').val(totalPrice);

		if ( ltbGrid.data('currency-pos') == 'before' ) {

			totalPrice = ltbGrid.data('currency') + '<span class="ltb-price-val">' + totalPrice + '</span>';
		}
			else {

			totalPrice = '<span class="ltb-price-val">' + totalPrice + '</span>' + ' ' + ltbGrid.data('currency');
		}
	}

	var thd_sep = jQuery('.ltb-grid').data('thd-sep');

	
	jQuery('.ltb-total-time .ltb-value').html(totalTime);
	jQuery('.ltb-total-price .ltb-value').html(totalPrice); 

	jQuery('#ltb-car-type').val(carActive.id);
	jQuery('#ltb-plan').val(tariffActive.data('id'));
	jQuery('#ltb-services').val(servicesArray);
	jQuery('#ltb-services-count').val(servicesArrayCount);
	jQuery('#ltb-booking-date').val(timeActive.data('stamp'));

	jQuery('#ltb-duration').val(totalTimeVal);
	jQuery('#ltb-price').val(totalPriceVal);

	if ( thd_sep != '' ) {

		jQuery('.ltb-price-val').each(function(i,  el) {

			jQuery(el).html(numberWithCommas(jQuery(el).html(), thd_sep));
		});
	}

	if ( !active ) {

		jQuery('#ltb-form-submit').addClass('disabled');
	}
		else {

		jQuery('#ltb-form-submit').removeClass('disabled');
	}
}

function numberWithCommas(x, c) {

	if ( parseInt(x) > 1000 ) {

	    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, c);
	}
		else {

	    return x;
	}
}

function convertMinsToHrsMins(minutes) {

	var ltbGrid = jQuery('.ltb-grid'),
		h = Math.floor(minutes / 60),
		m = minutes % 60;

		if ( minutes > 60 ) {

			return h + ' ' + ltbGrid.data('hours') + ' ' + m + ' ' + ltbGrid.data('minutes');
		}
			else {

			return m + ' ' + ltbGrid.data('minutes');
		}
}

function ltbFormSubmit(event) {

    var bookingInfo = jQuery('#ltb-booking-form').serialize();

    if ( jQuery('#ltb-form-submit').hasClass('disabled') ) {

    	return false;
    }

    jQuery('.ltb-div-submit').addClass('loading');

    jQuery.ajax({

		type:    "POST",
		url:     ltbAjax.ajaxurl,
		data:    {
			action: 'make_booking',
			bookingInfo: bookingInfo
		},
		success: function(data) {

			jQuery(".ltb-form").addClass('done').html(data);
			jQuery('.ltb-div-submit').removeClass('loading');

			if ( jQuery('.ltb-payment-btn-wrapper').length ) {

				jQuery('.ltb-payment-btn-wrapper').show().appendTo(".ltb-form");
				jQuery('html,body').animate({scrollTop: jQuery('.ltb-form').offset().top});
			}
		},
		error: function(data) {

			jQuery('.ltb-div-submit').removeClass('loading');
		}		
    });

    return false;
}

function ltbFormValidate(event) {

	var validate = false;

	jQuery('#ltb-booking-form input[type="text"], #ltb-booking-form textarea').each(function(i, el) {

		if ( jQuery(el).prop('required') && jQuery(el).val() == '' ){

			jQuery(el).addClass('validate');
			validate = true;
		}
			else {

			jQuery(el).removeClass('validate');
		}
	});

	if ( !validate ) {

	    return true;
	}
		else {

	    return false;
	}
}

function ltbStripe() {

	if ( jQuery('#ltb-payment-submit').length ) {

		var createCheckoutSession = function () {

			return fetch(jQuery('#ltb-payment-submit').data('domain') + '/ltb-create-checkout-session', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify({
					quantity: 1,
					point: jQuery('#ltb-booking-done').data('point'),
					id: jQuery('#ltb-booking-done').data('booking'),
				}),
			}).then(function (result) {
				return result.json();
			});
		};

		var stripe = Stripe(ltb_stripe.pk);

		document.querySelector('#ltb-payment-submit').addEventListener('click', function (evt) {

			jQuery('.ltb-payment-btn-wrapper').addClass('loading');

			createCheckoutSession().then(function (data) {
				stripe
				.redirectToCheckout({
					sessionId: data.sessionId,
				})
				.then(handleResult);
			});
		});
	}
}