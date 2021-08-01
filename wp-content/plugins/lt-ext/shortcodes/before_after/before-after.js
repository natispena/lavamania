"use strict";

jQuery( function() {
	
	initBeforeAfter();


});

function initBeforeAfter() {

	if ( jQuery('.ltx-before-after').length ) {

		var mySwiper = document.querySelector('.ltx-before-after .swiper-container').swiper;

		mySwiper.on('resize', function() {

			jQuery('.ltx-before-after .ltx-wrap').removeClass('init');

			jQuery('.ltx-before-after .ltx-wrap').each(function() {

				var wrap = jQuery(this);

				if ( !jQuery(wrap).hasClass('init') ) {

					initBeforeAfterEl(wrap);
					jQuery(wrap).addClass('init');
				}
			});			
		});

		jQuery('.ltx-before-after .ltx-wrap').each(function() {

			var wrap = jQuery(this);

			if ( !jQuery(wrap).hasClass('init') ) {

				initBeforeAfterEl(wrap);
				jQuery(wrap).addClass('init');
			}
		});
/*
		jQuery('.ltx-before-after .ltx-wrap .handle').on('mouseover', function () {

			var wrap = jQuery(this).closest('.ltx-wrap');

			if ( !jQuery(wrap).hasClass('init') ) {

				initBeforeAfterEl(wrap);
				jQuery(wrap).addClass('init');
			}
		});
*/		
	}
}

function initBeforeAfterEl(el) {

	var supportsTouch = 'ontouchstart' in window || navigator.msMaxTouchPoints;

	var $container = jQuery(el),
	$before = $container.find('.before'),
	$after = $container.find('.after'),
	$handle = $container.find('.handle'),
	$before_header = $container.parent().find('.ltx-before-header'),
	$after_header = $container.parent().find('.ltx-after-header');

	var maxX = $container.outerWidth(),
	offsetX = $container.offset().left,
	startX = 0;

	var touchstart, touchmove, touchend;
	var mousemove = function(e) {
		e.preventDefault();
		var curX = e.clientX - offsetX,
		diff = startX - curX,
		curPos = (curX / maxX) * 100;
		if ( curPos > 100 ) {
			curPos = 100;
		}
		if ( curPos < 0 ) {
			curPos = 0;
		}
		$before.css({right: (100 - curPos) + "%"});
		$handle.css({left: curPos+"%"});

		$before_header.css({ opacity: 1 - (100 - curPos) / 100 });
		$after_header.css({ opacity: (100 - curPos) / 100 });
	};
	var mouseup = function(e) {
		e.preventDefault();
		if ( supportsTouch ) {
			jQuery(document).off('touchmove', touchmove);
			jQuery(document).off('touchend', touchend);
		} else {
			jQuery(document).off('mousemove', mousemove);
			jQuery(document).off('mouseup', mouseup);
		}
	};
	var mousedown = function(e) {
		e.preventDefault();
		startX = e.clientX - offsetX;
		if ( supportsTouch ) {
			jQuery(document).on('touchmove', touchmove);
			jQuery(document).on('touchend', touchend);
		} else {
			jQuery(document).on('mousemove', mousemove);
			jQuery(document).on('mouseup', mouseup);
		}
	};

	touchstart = function(e) {
		mousedown({preventDefault: e.preventDefault, clientX: e.originalEvent.changedTouches[0].pageX});
	};
	touchmove = function(e) {
		mousemove({preventDefault: e.preventDefault, clientX: e.originalEvent.changedTouches[0].pageX});
	};
	touchend = function(e) {
		mouseup({preventDefault: e.preventDefault, clientX: e.originalEvent.changedTouches[0].pageX});
	};
	if ( supportsTouch ) {
		$handle.on('touchstart', touchstart);
	} else {
		$handle.on('mousedown', mousedown);
	}
}
