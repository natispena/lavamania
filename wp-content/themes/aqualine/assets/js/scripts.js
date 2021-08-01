"use strict";

jQuery( function() {
	
	initSwiperSliders();	
	initFCSwiper();
	initEvents();
	initStyles();
	initMap();
	initCollapseMenu();	
	checkCountUp();	
	initScrollReveal();
});

jQuery(window).on('scroll', function (event) {

	checkNavbar();
	checkGoTop();
	checkScrollAnimation();
}).scroll();

jQuery(window).on('load', function(){

	initMasonry();
	initParallax();

});

jQuery(window).on("resize", function () {

	setResizeStyles();
}).resize();

/* Navbar menu initialization */
function initCollapseMenu() {

	var navbar = jQuery('#navbar'),
		navbar_toggle = jQuery('.navbar-toggle'),
		navbar_wrapper = jQuery("#nav-wrapper");

    navbar_wrapper.on('click', '.navbar-toggle', function (e) {

        navbar_toggle.toggleClass('collapsed');
        navbar.toggleClass('collapse');
        navbar_wrapper.toggleClass('mob-visible');
    });

	// Anchor mobile menu
	navbar.on('click', '.menu-item-type-custom > a', function(e) {

		if ( typeof jQuery(this).attr('href') !== 'undefined' && jQuery(this).attr('href') !== '#' && jQuery(this).attr('href').charAt(0) === '#' )  {

	        navbar_toggle.addClass('collapsed');
	        navbar.addClass('collapse');
	        navbar_wrapper.removeClass('mob-visible');
    	}  	    
    });

    navbar.on('click', '.menu-item-has-children > a', function(e) {

    	var el = jQuery(this);

    	if (!el.closest('#navbar').hasClass('collapse')) {

    		if ((el.attr('href') === undefined || el.attr('href') === '#') || e.target.tagName == 'A') {

		    	el.next().toggleClass('show');
		    	el.parent().toggleClass('show');

		    	return false;
		    }
	    }
    });

    var lastWidth;
    jQuery(window).on("resize", function () {

    	checkNavbar();

    	var winWidth = jQuery(window).width(),
    		winHeight = jQuery(window).height();

       	lastWidth = winWidth;
    });	
}

/* Navbar attributes depends on resolution and scroll status */
function checkNavbar() {

	var navbar = jQuery('#navbar'),
		scroll = jQuery(window).scrollTop(),
    	navBar = jQuery('nav.navbar:not(.no-dark)'),
    	topBar = jQuery('.ltx-topbar-block'),
    	navbar_toggle = jQuery('.navbar-toggle'),
    	navbar_wrapper = jQuery("#nav-wrapper"),
	    slideDiv = jQuery('.slider-full'),
	    winWidth = jQuery(window).width(),
    	winHeight = jQuery(window).height(),
		navbar_mobile_width = navbar.data('mobile-screen-width');

   	if ( winWidth < navbar_mobile_width ) {

		navbar.addClass('navbar-mobile').removeClass('navbar-desktop');
	}
		else {

		navbar.addClass('navbar-desktop').removeClass('navbar-mobile');
	}

	navbar_wrapper.addClass('inited');

	if ( topBar.length ) {

		navBar.data('offset-top', topBar.height());
	}

    if (winWidth > navbar_mobile_width && navbar_toggle.is(':hidden')) {

        navbar.addClass('collapse');
        navbar_toggle.addClass('collapsed');
        navbar_wrapper.removeClass('mob-visible');
    }

    jQuery("#nav-wrapper.navbar-layout-transparent + .page-header, #nav-wrapper.navbar-layout-transparent + .main-wrapper").css('margin-top', '-' + navbar_wrapper.height() + 'px');


    if (scroll > 1) navBar.addClass('dark'); else navBar.removeClass('dark');
}


/* Check GoTop Visibility*/
function checkGoTop() {

	var gotop = jQuery('.ltx-go-top'),
		scrollBottom = jQuery(document).height() - jQuery(window).height() - jQuery(window).scrollTop();

	if ( gotop.length ) {

		if ( jQuery(window).scrollTop() > 400 ) {

			gotop.addClass('show');
		}
			else {

			gotop.removeClass('show');
    	}

    	if ( scrollBottom < 50 ) {

    		gotop.addClass('scroll-bottom');
    	}
    		else {

    		gotop.removeClass('scroll-bottom');
   		}
	}	
}

/* All keyboard and mouse events */
function initEvents() {

	jQuery('.swipebox.photo').magnificPopup({type:'image', gallery: { enabled: true }});
	jQuery('.swipebox.image-video').magnificPopup({type:'iframe'});

	if (!/Mobi/.test(navigator.userAgent) && jQuery(window).width() > 768) {

		jQuery('.matchHeight').matchHeight();
		jQuery('.items-matchHeight article').matchHeight();
	}	

	// WooCommerce grid-list toggle
	jQuery('.gridlist-toggle').on('click', 'a', function() {

		jQuery('.matchHeight').matchHeight();
	});

	jQuery('.menu-types').on('click', 'a', function() {

		var el = jQuery(this);

		el.addClass('active').siblings('.active').removeClass('active');
		el.parent().find('.type-value').val(el.data('value'));

		return false;
	});

	/* Scrolling to navbar from "go top" button in footer */
    jQuery('.ltx-go-top').on('click', function() {

	    jQuery('html, body').animate({ scrollTop: 0 }, 1200);

	    return false;
	});


    jQuery('.alert').on('click', '.close', function() {

	    jQuery(this).parent().fadeOut();
	    return false;
	});	

	jQuery(".topbar-icons.mobile, .topbar-icons.icons-hidden")
		.mouseover(function() {

			jQuery('.topbar-icons.icons-hidden').addClass('show');
			jQuery('#navbar').addClass('muted');
		})
		.mouseout(function() {
			jQuery('.topbar-icons.icons-hidden').removeClass('show');
			jQuery('#navbar').removeClass('muted');
	});

	// TopBar Search
    var searchHandler = function(event){

        if (jQuery(event.target).is(".top-search, .top-search *")) return;
        jQuery(document).off("click", searchHandler);
        jQuery('.top-search').removeClass('show-field');
        jQuery('#navbar').removeClass('muted');
    }

    jQuery('.top-search-ico-close').on('click', function (e) {

		jQuery(this).parent().toggleClass('show-field');
		jQuery('#navbar').toggleClass('muted');    	

		return false;
    });

	jQuery('.top-search-ico').on('click', function (e) {

		e.preventDefault();
		jQuery(this).parent().toggleClass('show-field');
		jQuery('#navbar').toggleClass('muted');

        if (jQuery(this).parent().hasClass('show-field')) {

        	jQuery(document).on("click", searchHandler);
        }
        	else {

        	jQuery(document).off("click", searchHandler);
        }
	});

	var search_href = jQuery('.top-search').data('base-href');

	jQuery('#top-search-ico-mobile').on('click', function() {

		window.location = search_href + '?s=' + jQuery(this).next().val();
		return false;
	});	


	jQuery('.top-search input').keypress(function (e) {
		if (e.which == 13) {
			window.location = search_href + '?s=' + jQuery(this).val();
			return false;
		}
	});

	jQuery('.ltx-navbar-search span').on('click', function (e) {
		window.location = search_href + '?s=' + jQuery('.ltx-navbar-search input').val();
	});	

	jQuery('.woocommerce').on('click', 'div.quantity > span', function(e) {

		var f = jQuery(this).siblings('input');
		if (jQuery(this).hasClass('more')) {
			f.val(Math.max(0, parseInt(f.val()))+1);
		} else {
			f.val(Math.max(1, Math.max(0, parseInt(f.val()))-1));
		}
		e.preventDefault();

		jQuery(this).siblings('input').change();

		return false;
	});

	jQuery('.ltx-arrow-down').on('click', function() {

		var offset = jQuery(this).closest('.vc_row').height();
		console.log(offset);
		if ( offset ) {

			jQuery("html, body").animate({ scrollTop: offset }, 500);
		}
	});

	if ( jQuery("#ltx-modal").length && !ltxGetCookie('ltx-modal-cookie') ) {

		jQuery("#ltx-modal").modal("show");
	}

	setTimeout(function() { if ( typeof Pace !== 'undefined' && jQuery('body').hasClass('paceloader-enabled') ) { Pace.stop(); }  }, 3000);	

	jQuery('#ltx-modal').on('click', '.ltx-modal-yes', function() {
	
    	jQuery('body').removeClass('modal-open');
	    jQuery('#ltx-modal').remove();
	    jQuery('.modal-backdrop').remove();
	    ltxSetCookie('ltx-modal-cookie', 1, jQuery(this).data('period'));
	});	

	jQuery('#ltx-modal').on('click', '.ltx-modal-no', function() {

	    window.location.href = jQuery(this).data('no');
	    return false;
	});		

	jQuery('.navbar').on( 'affix.bs.affix', function(){

	    if (!jQuery( window ).scrollTop()) return false;
	});	

	jQuery('.ltx-mouse-move .vc_column-inner')
    .on('mouseover', function(){
   	  if ( typeof jQuery(this).data('bg-size') === 'undefined' ) {
   	  	jQuery(this).data('bg-size', jQuery(this).css('background-size'));
   	  }

      jQuery(this)[0].style.setProperty( 'background-size', parseInt(jQuery(this).data('bg-size')) + 10 + '%', 'important' );
    })
    .on('mouseout', function(){
      jQuery(this)[0].style.setProperty( 'background-size', jQuery(this).data('bg-size'), 'important' );
    })	
	.on('mousesmove', function(e){

		jQuery(this)[0].style.setProperty( 'background-position', ((e.pageX - jQuery(this).offset().left) / jQuery(this).width()) * 100 + '% ' + ((e.pageY - jQuery(this).offset().top) / jQuery(this).height()) * 100 + '%', 'important' );
	});

	jQuery('.ltx-slider-fc .swiper-slide')
	.on('mouseover', function(){

		jQuery(this).prev().prev().addClass('hovered');
	})
	.on('mouseout', function(){

		jQuery(this).prev().prev().removeClass('hovered');
	});

	jQuery('.ltx-tariff-list.ltx-limit').each(function() {

		var limit = parseInt(jQuery(this).data('limit'));

		jQuery(this).find("li:gt(" + ( limit - 1) + ")").hide();
	});

	jQuery(document).on('click', '.ltx-tariff-spoiler', function() {

		jQuery(this).prev().find('li').show();
		jQuery(this).hide();
		jQuery(this).next().show();

		return false;
	});

	jQuery(document).on('click', '.ltx-tariff-spoiler-less', function() {

		var ul = jQuery(this).prev().prev(),
			limit = parseInt(jQuery(ul).data('limit'));

		jQuery(ul).find("li:gt(" + ( limit - 1) + ")").hide();
		jQuery(this).prev().show();
		jQuery(this).hide();

		return false;
	});

}

function ltxUrlDecode(str) {

   return decodeURIComponent((str+'').replace(/\+/g, '%20'));
}

/* Parallax initialization */
function initParallax() {

	// Only for desktop
	if (/Mobi/.test(navigator.userAgent)) return false;

	jQuery('.ltx-parallax').parallax("50%", 0.2);	
	jQuery('.ltx-parallax.wpb_column .vc_column-inner').parallax("50%", 0.3);	

	jQuery('.ltx-bg-parallax-enabled:not(.wpb_column)').each(function(i, el) {

		var val = jQuery(el).attr('class').match(/ltx-bg-parallax-value-(\S+)/); 
		if ( val === null ) var val = [0, 0.2];
		jQuery(el).parallax("50%", parseFloat(val[1]));	
	});	

	jQuery('.ltx-bg-parallax-enabled.wpb_column').each(function(i, el) {

		var val = jQuery(el).attr('class').match(/ltx-bg-parallax-value-(\S+)/); 	

		jQuery(el).children('.vc_column-inner').parallax("50%", parseFloat(val[1]));	
	});	

	if ( jQuery('.ltx-parallax-slider').length ) {

		jQuery('.ltx-parallax-slider').each(function(e, el) {

			var scene = jQuery(el).get(0);
			var parallaxInstance = new Parallax(scene, {

				hoverOnly : false,
				limitY: 0,
				selector : '.ltx-layer',
			});
		});
	}

	jQuery(".ltx-scroll-parallax").each(function(i, el) {

		jQuery(el).paroller({ factor: jQuery(el).data('factor'), type: 'foreground', direction: jQuery(el).data('direction') });
	});


	jQuery(".ltx-parallax-slider .layer").each(function(i, el) {

		jQuery(el).paroller({ factor: jQuery(el).data('factor'), type: jQuery(el).data('type'), direction: jQuery(el).data('direction') });
	});	
}

/* Adding custom classes to element */
function initStyles() {

	jQuery('form:not(.checkout, .woocommerce-shipping-calculator) select:not(#rating), aside select, .footer-widget-area select').wrap('<div class="select-wrap"></div>');
	jQuery('.wpcf7-checkbox').parent().addClass('margin-none');

	jQuery('input[type="submit"], button[type="submit"]').not('.btn').addClass('btn btn-xs');
	jQuery('#send_comment').removeClass('btn-xs');
	jQuery('#searchsubmit').removeClass('btn');

	jQuery('.woocommerce .ltx-item-descr .button').append('<span class="ltx-btn-after"></span>').addClass('btn btn-xs').removeClass('button');
	jQuery('.woocommerce .button').addClass('btn btn-main color-hover-black').removeClass('button');
	
	jQuery('.woocommerce .wc-forward:not(.checkout)').removeClass('btn-black').addClass('btn-main');
	jQuery('.woocommerce-message .btn, .woocommerce-info .btn').addClass('btn-xs');
	jQuery('.woocommerce .price_slider_amount .btn').removeClass('btn-black color-hover-white').addClass('btn btn-main btn-xs color-hover-black');
	jQuery('.woocommerce .checkout-button').removeClass('btn-black color-hover-white').addClass('btn btn-main btn-xs color-hover-black');
	jQuery('button.single_add_to_cart_button').removeClass('btn-xs color-hover-white').addClass('color-hover-main');
	jQuery('.woocommerce .coupon .btn').removeClass('color-hover-white').addClass('color-hover-main');

	jQuery('.woocommerce .product .wc-label-new').closest('.product').addClass('ltx-wc-new');


	jQuery('.widget_product_search button').removeClass('btn btn-xs');
	jQuery('.input-group-append .btn').removeClass('btn-xs');

	jQuery('.ltx-hover-logos img').each(function(i, el) { jQuery(el).clone().addClass('ltx-img-hover').insertAfter(el); });
	
	jQuery(".container input[type=\"submit\"], .container input[type=\"button\"], .container .btn").wrap('<span class="ltx-btn-wrap"></span');
	jQuery('.search-form .ltx-btn-wrap').removeClass('ltx-btn-wrap');
	jQuery('.ltx-btn-wrap > .btn-main').parent().addClass('ltx-btn-wrap-main');
	jQuery('.ltx-btn-wrap > .btn-black').parent().addClass('ltx-btn-wrap-black');
	jQuery('.ltx-btn-wrap > .btn-white').parent().addClass('ltx-btn-wrap-white');

	jQuery('.ltx-btn-wrap > .color-hover-main').parent().addClass('ltx-btn-wrap-hover-main');
	jQuery('.ltx-btn-wrap > .color-hover-black').parent().addClass('ltx-btn-wrap-hover-black');
	jQuery('.ltx-btn-wrap > .color-hover-white').parent().addClass('ltx-btn-wrap-hover-white');

	jQuery('.ltx-btn-wrap > *').append('<span class="ltx-btn-overlay ltx-btn-overlay-top"></span><span class="ltx-btn-overlay ltx-btn-overlay-bottom"></span>');

	jQuery('.woocommerce .products .item .ltx-btn-wrap .btn');

	jQuery(".container .wpcf7-submit").removeClass('btn-xs').wrap('<span class="ltx-btn-wrap"></span');

	jQuery('.woocommerce-result-count, .woocommerce-ordering').wrapAll('<div class="ltx-wc-order"></div>');

	jQuery('.blog-post .nav-links > a').wrapInner('<span></span>');
	jQuery('.blog-post .nav-links > a[rel="next"]').wrap('<span class="next"></span>');
	jQuery('.blog-post .nav-links > a[rel="prev"]').wrap('<span class="prev"></span>');

	var overlays = jQuery('*[class*="ltx-bg-overlay-"]')
	.each(function (i, el) {

		var overlay = this.className.match(/ltx-bg-overlay-(\S+)/);
		jQuery(el).prepend('<div class="ltx-overlay-' + overlay[1] + '"></div>');
	});

	var header_icon_class = jQuery('#ltx-header-icon').data('icon');

	var update_width = jQuery('.woocommerce-cart-form__contents .product-subtotal').outerWidth();
	jQuery('button[name="update_cart"]').css('width', update_width);

	jQuery('.wp-searchform .btn').removeClass('btn');

	if ( jQuery('.woocommerce .products').length ) {

		jQuery('.woocommerce .products .product').each(function(i, el) {

			var href = jQuery(el).find('a').attr('href'),
				img = jQuery(el).find('.image img'),
				btn = jQuery(el).find('.ltx-btn-wrap');

			jQuery(img).wrap('<a href="'+ href +'">');
			btn.clone().appendTo(jQuery(el).find('.image'));
		});
	}

	// Settings copyrights overlay for non-default heights
	var copyrights = jQuery('.copyright-block.copyright-layout-copyright-transparent'),
		footer = jQuery('#ltx-widgets-footer + .copyright-block'),
		widgets_footer = jQuery('#ltx-widgets-footer'),
		footerHeight = footer.outerHeight();

	widgets_footer.css('padding-bottom', 0 + footerHeight + 'px');
	footer.css('margin-top', '-' + (footerHeight - 1) + 'px');

	copyrights.css('margin-top', '-' + (copyrights.outerHeight() + 3) + 'px')

	// Cart quanity change
	jQuery('.woocommerce div.quantity,.woocommerce-page div.quantity').append('<span class="more"></span><span class="less"></span>');
	jQuery(document).off('updated_wc_div').on('updated_wc_div', function () {

		jQuery('.woocommerce div.quantity,.woocommerce-page div.quantity').append('<span class="more"></span><span class="less"></span>');
		initStyles();
	});

	var bodyStyles = window.getComputedStyle(document.body);
	var niceScrollConf = {cursorcolor:bodyStyles.getPropertyValue('--white'),cursorborder:"0px",background:"#000",cursorwidth: "8px",cursorborderradius: "0px",autohidemode:false};

	jQuery('.events-sc.ltx-scroll').niceScroll(niceScrollConf);		
}

/* Styles reloaded then page has been resized */
function setResizeStyles() {

	var videos = jQuery('.blog-post article.format-video iframe'),
		container = jQuery('.blog-post'),
		bodyWidth = jQuery(window).outerWidth(),
		contentWrapper = jQuery('.ltx-content-wrapper.ltx-footer-parallax'),
		footerWrapper = jQuery('.ltx-content-wrapper.ltx-footer-parallax + .ltx-footer-wrapper');

		contentWrapper.css('margin-bottom', footerWrapper.outerHeight() + 'px');

	jQuery.each(videos, function(i, el) {

		var height = jQuery(el).height(),
			width = jQuery(el).width(),
			containerW = jQuery(container).width(),
			ratio = containerW / width;

		jQuery(el).css('width', width * ratio);
		jQuery(el).css('height', height * ratio);
	});

	if ( jQuery('.services-sc.layout-list').length ) {

		var el = jQuery('.services-sc.layout-list');

		if ( !el.hasClass('inited') ) {

			var bodyStyles = window.getComputedStyle(document.body);
			var niceScrollConf = {cursorcolor:bodyStyles.getPropertyValue('--black'),cursorborder:"0px",background:bodyStyles.getPropertyValue('--gray'),cursorwidth: "7px",cursorborderradius: "0px",autohidemode:false};

			el.find('.ltx-list-wrap').niceScroll(niceScrollConf);	
		}
	}

	document.documentElement.style.setProperty( '--fullwidth', bodyWidth + 'px' );
}

/* Starting countUp function */
function checkCountUp() {

	if (jQuery(".countUp").length){

		jQuery('.countUp').counterUp();
	}
}

/* 
	Scroll Reveal Initialization
	Catches the classes: ltx-sr-fade_in ltx-sr-text_el ltx-sr-delay-200 ltx-sr-duration-300 ltx-sr-sequences-100
*/
function initScrollReveal() {

	if (/Mobi/.test(navigator.userAgent) || jQuery(window).width() < 768) return false;

	window.sr = ScrollReveal();

	var srAnimations = {
		zoom_in: {
			
			opacity : 1,
			scale    : 0.01,
		},
		zoom_in_large: {
			
			opacity : 0,
			scale    : 5.01,
		},		
		fade_in: {
			distance: 1,
			opacity : 0,
			scale : 1,
		},
		slide_from_left: {
			distance: '50%',
			origin: 'left',
			scale    : 1,
		},
		slide_from_right: {
			distance: '50%',
			origin: 'right',			
			scale    : 1,
		},
		slide_from_top: {
			distance: '50%',
			origin: 'top',			
			scale    : 1,
		},
		slide_from_bottom: {
			distance: '50%',
			origin: 'bottom',			
			scale    : 1,
		},
		slide_rotate: {
			rotate: { x: 0, y: 0, z: 360 },		
		},		
	};

	var srElCfg = {

		block: [''],
		items: ['article', '.item'],
		text_el: ['.heading', '.btn', '.btn-wrap', 'p', 'ul', 'img'],
		list_el: ['li']
	};


	/*
		Parsing elements class to get variables
	*/
	jQuery('.ltx-sr').each(function() {

		var el = jQuery(this),
			srClass = el.attr('class');

		var srId = srClass.match(/ltx-sr-id-(\S+)/),
			srEffect = srClass.match(/ltx-sr-effect-(\S+)/),
			srEl = srClass.match(/ltx-sr-el-(\S+)/),
			srDelay = srClass.match(/ltx-sr-delay-(\d+)/),
			srDuration = srClass.match(/ltx-sr-duration-(\d+)/),
			srSeq = srClass.match(/ltx-sr-sequences-(\d+)/); 

		var cfg = srAnimations[srEffect[1]];

		var srConfig = {

			delay : parseInt(srDelay[1]),
			duration : parseInt(srDuration[1]),
			easing   : 'ease-in-out',
			afterReveal: function (domEl) { jQuery(domEl).css('transition', 'all .3s ease'); }
		}			

		cfg = jQuery.extend({}, cfg, srConfig);

		var initedEls = [];
		jQuery.each(srElCfg[srEl[1]], function(i, e) {

			initedEls.push('.ltx-sr-id-' + srId[1] + ' ' + e);
		});

		sr.reveal(initedEls.join(','), cfg, parseInt(srSeq[1]));
	});
}

/*
	Filter Container
*/
function initFilterContainer() {

	var container = jQuery('.ltx-filter-container');

	jQuery(container).each(function(i, el) {

		var tabs = jQuery(container).find('.ltx-tabs-cats');

		if (tabs.length) {

			tabs.on('click', '.ltx-cat', function() {

				var el = jQuery(this),
					filter = el.data('filter');

				el.parent().parent().find('.active').removeClass('active');
				el.addClass('active');

				jQuery('.ltx-items').fadeOut( "slow", function() {

					container.find('.last').removeClass('last last-2');

					if (filter === 0) {

						container.find('.ltx-filter-item').addClass('show-item').show();
					}
						else
					if (filter !== '') {

						container.find('.ltx-filter-item').removeClass('show-item').hide();
						container.find('.ltx-filter-item.ltx-filter-id-' + filter).addClass('show-item').show();
					}

					container.find('.show-item').last().addClass('last').prevAll('.show-item').first().addClass('last last-2');

					jQuery('.ltx-items').fadeIn( "slow" );

					return false;
				});
			});

			// First Init, Activating first tab
			var firstBtn = tabs.find('.ltx-cat:first');

			firstBtn.addClass('active');

			if ( firstBtn.data('filter') != 0 ) {

				container.find('.ltx-filter-item').hide();
				container.find('.ltx-filter-item.ltx-filter-id-' + firstBtn.data('filter') + '').addClass('show-item').show();

			}

			container.find('.show-item').last().addClass('last').prevAll('.show-item').first().addClass('last last-2');

			jQuery(window).resize();

		}		


	});
}
initFilterContainer();

/*
	Slider filter 
	Filters element in slider and reinits swiper slider after
*/
function initSliderFilter(swiper) {

	var btns = jQuery('.slider-filter'),
		container = jQuery('.slider-filter-container');

	var ww = jQuery(window).width(),
		wh = jQuery(window).height();

	if (btns.length) {

		btns.on('click', 'a.cat, span.cat, span.img', function() {

			var el = jQuery(this),
				filter = el.data('filter'),
				limit = el.data('limit');

			container.find('.filter-item').show();
			el.parent().parent().find('.cat-active').removeClass('cat-active')
			el.parent().parent().find('.cat-li-active').removeClass('cat-li-active')
			el.addClass('cat-active');
			el.parent().addClass('cat-li-active');

			if (filter !== '') {

				container.find('.filter-item').hide();
				container.find('.filter-item.filter-type-' + filter + '').fadeIn(900);
			}

			if (swiper !== 0) {

				swiper.slideTo(0, 0);

				swiper.update();
			}

			return false;
		});

		// First Init, Activating first tab
		var firstBtn = btns.find('.cat:first')

		firstBtn.addClass('cat-active');
		firstBtn.parent().addClass('cat-li-active');
		container.find('.filter-item').hide();
		container.find('.filter-item.filter-type-' + firstBtn.data('filter') + '').show();
	}
}



/*
	Menu filter
*/
function initMenuFilter() {

	var container = jQuery('.ltx-menu-sc'),
		btns = jQuery('.ltx-menu-sc .menu-filter');

	if ( container.length )  {

		var bodyStyles = window.getComputedStyle(document.body);
		var niceScrollConf = {cursorcolor:bodyStyles.getPropertyValue('--main'),cursorborder:"0px",background:"#1E1D1C",cursorwidth: "10px",cursorborderradius: "0px",autohidemode:false};

		if (btns.length) {

			btns.on('click', 'a.cat, span.cat', function() {

				var el = jQuery(this),
					filter = el.data('filter');

				container.find('article').show();
				el.parent().parent().find('.cat-active').removeClass('cat-active')
				el.addClass('cat-active');

				if (filter !== '') {

					container.find('article').hide().removeClass('show');
					container.find('article.filter-type-' + filter + '').fadeIn('slow').addClass('show');
				}

				jQuery('.menu-sc .items').getNiceScroll().resize();

				return false;
			});

			// First Init, Activating first tab
			var firstBtn = btns.find('.cat:first')

			firstBtn.addClass('cat-active');
			container.find('article').hide();
			container.find('article.filter-type-' + firstBtn.data('filter') + '').show().addClass('show');
		}
	}
}

/* Swiper slider initialization */
function initSwiperSliders() {

	var ltxSliders = jQuery('.ltx-swiper-slider:not(".inited")');

	jQuery(ltxSliders).each(function(i, el) {

		var container = jQuery(el),
			id = jQuery(el).attr('id'),
			autoplay = false,
			autoplay_interact = false,
			navigation = false,
			pagination = false,
			slidesPerView = false,
			centeredSlides = false,
			simulateTouch = true,
			allowTouchMove	= true,
			spg = 1,
			slidesPerGroup = 1,
			spaceBetween = container.data('space-between'),
			loop = container.data('loop'),
			effect = container.data('effect'),
			speed = container.data('speed'),
			breakpoints_per = container.data('breakpoints').split(';'),
			breakpoints_viewports = [4000, 1599, 1199, 991, 768, 480],
			breakpoints = {};

		if ( container.data('autoplay') && container.data('autoplay') > 0 ) {

			if ( container.data('autoplay-interaction') === 1 ) {

				autoplay_interact = true;		
			}
				else {

				autoplay_interact = false;
			}

			autoplay = {

				delay: container.data('autoplay'),
				disableOnInteraction: autoplay_interact,
			}
		}

		if ( container.data('center-slide') ) {

			centeredSlides = true;
		}

		if ( container.data('arrows') ) {

			var arrows_html = '<div class="'+ id + '-arrows ltx-arrows ltx-arrows-' + container.data('arrows') + '"><a href="#" class="ltx-arrow-left"></a><a href="#" class="ltx-arrow-right"></a></div>';

			if ( container.data('arrows') == 'sides-outside' || container.data('arrows') == 'sides-small' ) {

				jQuery(container).after(arrows_html);
			}
				else
			if ( container.data('arrows') != 'custom' ) {

				jQuery(container).append(arrows_html);
			}

			navigation = {
				nextEl: '.' + id + '-arrows .ltx-arrow-right',
				prevEl: '.' + id + '-arrows .ltx-arrow-left',
			}
		}

		if ( !loop ) loop = false;

		jQuery(breakpoints_per).each(function(i, el) {

			if ( !slidesPerView && el ) {

				slidesPerView = el;
				if ( container.data('slides-per-group') ) slidesPerGroup = el;
				slidesPerGroup = 1;
			}

			if ( i == 0 ) return;

			if ( el ) {

				if ( container.data('slides-per-group') ) spg = el; else spg = 1;
				spg = 1;
				breakpoints[breakpoints_viewports[i]] = { slidesPerView : el, slidesPerGroup : spg };

				if ( spg == 1 ) delete breakpoints[breakpoints_viewports[i]]['slidesPerGroup']; 
			}
		});

		if ( container.data('pagination') && container.data('pagination') == 'fraction' ) {

			pagination = {

				el: '.swiper-pagination',
				type: 'fraction',			
			};
		}
			else
		if ( container.data('pagination') && container.data('pagination') == 'custom' ) {

			pagination = {
				el: '.swiper-pagination-custom',
				clickable: true,
				renderBullet: function (index, className) {

					var pages = JSON.parse(decodeURIComponent(this.$wrapperEl.data('pagination')));

					return '<span class="' + className + '"><span class="ltx-img"><img src="' + pages[index]['image'] + '" alt="' + pages[index]['header'] + '"></span><span class="ltx-title">' + pages[index]['header'] + '</span></span>';
				},
			};
		}

		if ( container.data('simulate-touch') ) {

			simulateTouch = false;
			allowTouchMove = false;
		}

		if ( !slidesPerView ) slidesPerView = 1;

		var conf = {
	    	initialSlide	: 0,
			spaceBetween	: spaceBetween,
			centeredSlides	: centeredSlides,

			slidesPerView	: slidesPerView,
			slidesPerGroup	: slidesPerGroup,	
			breakpoints		: breakpoints,

			loop		: loop,
			speed		: speed,
			navigation	: navigation,	
			autoplay	: autoplay,	

			pagination : pagination,

			simulateTouch : simulateTouch,
			allowTouchMove : allowTouchMove,

	    };

	    if ( slidesPerGroup == 1) delete conf['slidesPerGroup']; 

	    if ( effect == 'fade') {

	    	conf["effect"] = 'fade';
	    	conf["fadeEffect"] = { crossFade: false };
	    }
	    	else
	    if ( effect == 'coverflow') {

			var ww = jQuery(window).width();		    

	    	conf['centeredSlides'] = true;
	    	conf["effect"] = 'coverflow';
	    	conf["coverflowEffect"] = { slideShadows: false, rotate: 32, stretch: 1, depth: 150, modifier: 1, };
	    }
	    	else
	    if ( effect == 'flip') {

	    	conf["effect"] = 'flip';
	    	conf["flipEffect"] = { slideShadows: false };
	    }
	    	else
	    if ( effect == 'cube') {

	    	conf["effect"] = 'cube';
	    	conf["cubeEffect"] = { slideShadows: false };
	    }

	    var swiper = new Swiper(container, conf);
		if ( container.data('autoplay') > 0 && container.data('autoplay-interaction') === 1 ) {

			swiper.el.addEventListener("mouseenter", function( event ) { swiper.autoplay.stop(); }, false);
			swiper.el.addEventListener("mouseout", function( event ) { swiper.autoplay.start(); }, false);
		}

	    swiper.update();	
	
		jQuery(document).on('vc-full-width-row', function() {

			swiper.update();
		});
	});
}

function initFCSwiper() {

	var slidersLtx = jQuery('.ltx-slider-fc');

	if (slidersLtx.length) {

		if ( slidersLtx.data('autoplay') === 0 ) {

			var autoplay = false;
		}
			else {

			var autoplay = {
				delay: slidersLtx.data('autoplay'),
				disableOnInteraction: false,
			}
		}

	    var slidersSwiper = new Swiper(slidersLtx, {

			speed		: 1000,

			effect : 'fade',
			fadeEffect: { crossFade: true },

			autoplay: autoplay,	

			navigation: {
				nextEl: '.arrow-right',
				prevEl: '.arrow-left',
			},			
			mousewheel : true,
			pagination : {

				el: '.swiper-pages',
				clickable: true,				
			},

	    });

		var active = jQuery('body').find('.swiper-slide-active section');

		jQuery('body').removeClass('ltx-body-black ltx-body-white');
		if ( active.hasClass('bg-color-black') ) {

	  		jQuery('body').addClass('ltx-body-black');
		}		  
			else {

	  		jQuery('body').addClass('ltx-body-white');
		}	    

		slidersSwiper.on('slideChangeTransitionStart', function (el) {

			jQuery('body').addClass('ltx-slider-start');
		});

		slidersSwiper.on('transitionStart', function (el) {

			var rev = jQuery(this.el).find('.swiper-slide-active .revslider-initialised ');

			if ( rev.length ) {

				console.log('!');

				rev.revnext();	
			}			
		});

		slidersSwiper.on('slideChange transitionStart transitionEnd click init resize', function (el) {

			var active = jQuery(this.el).find('.swiper-slide-active section'),
				rev = jQuery(this.el).find('.swiper-slide-active .revslider-initialised ');

			if ( rev.length ) {

//				console.log('!');

//				rev.revnext();	
/*				jQuery('body').resize();*/
				/*
				revid = jQuery('rev').attr('id').split('_');
				console.log(rev);
				
				*/
			}

			jQuery('body').removeClass('ltx-body-black ltx-body-white');
			if ( active.hasClass('bg-color-black') ) {

		  		jQuery('body').addClass('ltx-body-black');
			}		  
				else {

		  		jQuery('body').addClass('ltx-body-white');
			}
		});

	    slidersSwiper.update();   


	    jQuery(window).on('resize', function(){

			var ww = jQuery(window).width(),
				wh = jQuery(window).height();

			if ( slidersLtx.length ) {

				if (ww > 1200) {

					slidersSwiper.mousewheel.enable();
				}
					else {

					slidersSwiper.mousewheel.disable();
				}			
			}
		}).resize();
	}
}


/* Masonry initialization */
function initMasonry() {

	jQuery('.masonry').masonry({
	  itemSelector: '.item',
	  columnWidth:  '.item'
	});		

	jQuery('.gallery-inner').masonry({
	  itemSelector: '.mdiv',
	  columnWidth:  '.mdiv'
	});			
}

/* Google maps init */
function initMap() {

	jQuery('.ltx-google-maps').each(function(i, mapEl) {

		mapEl = jQuery(mapEl);
		if (mapEl.length) {

			var uluru = {lat: mapEl.data('lat'), lng: mapEl.data('lng')};
			var map = new google.maps.Map(document.getElementById(mapEl.attr('id')), {
			  zoom: mapEl.data('zoom'),
			  center: uluru,
			  scrollwheel: false,
			  styles: mapStyles
			});

			var marker = new google.maps.Marker({
			  position: uluru,
			  icon: mapEl.data('marker'),
			  map: map
			});
		}
	});
}

function ltxGetCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') c = c.substring(1, c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
	}
	return null;
}


/* Scroll animation used for homepages */
function checkScrollAnimation() {

	var scrollBlock = jQuery('.ltx-check-scroll');
    if (scrollBlock.length) {

	    var scrollTop = scrollBlock.offset().top - window.innerHeight;

	    if (!scrollBlock.hasClass('done') && jQuery(window).scrollTop() > scrollTop) {

	    	scrollBlock.addClass('done');
	    }  
	}
}

